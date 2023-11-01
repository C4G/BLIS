<?php

# TAKE NOTE!
# For this to work properly, you need to make sure that _all_ of these
# required files are not outputting anything to the browser.
# https://github.com/PHPOffice/PHPExcel/blob/1.8/Documentation/markdown/Overview/08-Recipes.md#http-headers
# Ensure that these files are _not_ encoded as "UTF-8 with BOM" (Byte Order Mark)
# since that also counts. They should be "UTF-8".
require_once("../includes/composer.php");
require_once("../includes/db_lib.php");
require_once("../includes/db_util.php");
require_once("../includes/user_lib.php");

// Get all of the lab IDs being requested together
$lab_ids = array();
foreach($_REQUEST['locationAgg'] as $idx => $location) {
    $split = explode(":", $location);
    $lab_ids[] = intval($split[0]);
}

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    // If the user is not a super admin or country director, they should only
    // be able to access data for their own lab, and only if they are an admin.
    if (count($lab_ids) == 1 && $lab_ids[0] == $current_user->labConfigId && is_admin($current_user)) {
        $unauthorized = false;
    }
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    echo "You do not have permission to view this page.";
    exit;
}

// Send the spreadsheet directly to the browser
// Do not echo() or output anything else below this line!

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="report.xlsx"');
header('Cache-Control: max-age=0');

DbUtil::switchToGlobal();

$lab_id_list = implode(", ", $lab_ids);
$lab_db_name_query = <<<EOQ
    SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id IN ( $lab_id_list );
EOQ;
$labs_with_db_names = query_associative_all($lab_db_name_query);

$labs = array();
foreach($labs_with_db_names as $idx => $row) {
    $lid = $row['lab_config_id'];
    $dbn = $row['db_name'];
    $nm = $row['name'];
    $labs[$lid] = array();
    $labs[$lid] = $row;
}

$start_date = intval($_REQUEST['yyyy_from'])."-".intval($_REQUEST['mm_from'])."-".intval($_REQUEST['dd_from']);
$end_date = intval($_REQUEST['yyyy_to'])."-".intval($_REQUEST['mm_to'])."-".intval($_REQUEST['dd_to']);

$test_type_ids = $_REQUEST['test_types'];

$include_name = ($_REQUEST["include_patient_name"] == "true");
$include_sex = ($_REQUEST["include_patient_sex"] == "true");
$include_dob = ($_REQUEST["include_patient_birthday"] == "true");

// Okay... let's build the SQL query

// The headers for the spreadsheet must match the order of the columns/fields
$headers = array();
$fields = array();

if ($include_name) {
    $headers[] = "Patient Name";
    $fields[] = "p.name AS patient_name";
}

if ($include_sex) {
    $headers[] = "Sex";
    $fields[] = "p.sex";
}

if ($include_dob) {
    $headers[] = "Date of Birth";
    $fields[] = "p.dob AS patient_dob";
}

array_push($headers, "Specimen Type", "Date Collected");
array_push($fields, "st.name AS specimen_type", "s.date_collected AS specimen_collected");

// Push additional field for test result - the headers for this will be generated separately
// Must be the last field! There is logic in the loop below that depends on it.
array_push($fields, "t.result AS test_result");

$fields_sql = implode(", ", $fields);

$objPHPExcel = new PHPExcel();

foreach($labs as $lab_id => $lab) {
    foreach($test_type_ids as $tt_idx => $test_type_id) {
        
        // Ignore the weird indentation... that is because this is a multiline string
        // It will break if not indented this way I think...
        $query = <<<EOQ
            SELECT $fields_sql
            FROM specimen AS s
            INNER JOIN specimen_type AS st ON s.specimen_type_id = st.specimen_type_id
            INNER JOIN test AS t ON s.specimen_id = t.specimen_id
            INNER JOIN patient AS p ON s.patient_id = p.patient_id
            WHERE s.date_collected BETWEEN '$start_date' AND '$end_date'
            AND t.test_type_id = '$test_type_id';
EOQ;

        
        $sheet = $objPHPExcel->createSheet();

        db_change($lab['db_name']);

        // Grab all the measures for this test type from the database.
        $test_type = TestType::getById($test_type_id, $lab['lab_config_id']);
        
        $sheet_name = $test_type->name;
        // Replace invalid characters with a space
        // https://github.com/PHPOffice/PHPExcel/blob/39534e3dd376041d0d50a4714e73375bf45b692b/Classes/PHPExcel/Worksheet.php#L45C41-L45C83
        $sheet_name = str_replace(array('*', ':', '/', '\\', '?', '[', ']'), ' ', $sheet_name);
        // Sheet names can only be 31 characters max
        $sheet_name = substr($sheet_name, 0, 31);
        $sheet->setTitle($sheet_name);

        $measure_list = array();
        $measure_headers = array();

        $db_measure_list = $test_type->getMeasures($lab['lab_config_id']);
        foreach($db_measure_list as $measure) {
            if($measure->checkIfSubmeasure() == 1) {
                continue;
            }

            $measure_list[] = $measure;

            $submeasure_list = $measure->getSubmeasuresAsObj($lab['lab_config_id']);
            if(count($submeasure_list) > 0) {
                foreach($submeasure_list as $submeasure) {
                    $measure_list[] = $submeasure;
                }
            }
        }
        foreach($measure_list as $measure) {
            $hname = $measure->name;
            if (strlen($measure->unit) > 0) {
                $hname = $hname . "(" . $measure->unit . ")";
            }
            $measure_headers[] = $hname;
        }

        $results = query_associative_all($query);

        foreach($headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow($index, 1, $header);
        }

        foreach($measure_headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow(count($headers) + $index, 1, $header);
        }

        $total_columns = count($headers) + count($measure_headers);

        foreach($results as $row_index => $row) {
            $col = 0;
            $test_result = "";
            foreach($row as $col_name => $value) {
                if ($col_name == "test_result") {
                    $test_result = $value;
                    break;
                }

                $sheet->setCellValueByColumnAndRow($col, $row_index + 2, $value);
                $col = $col + 1;
            }
            $test_result_split = explode(",", $test_result);
            foreach($test_result_split as $result) {
                $sheet->setCellValueByColumnAndRow($col, $row_index + 2, $result);
                $col = $col + 1;
                if ($col >= $total_columns) break;
            }
        }
    }
}

$objPHPExcel->removeSheetByIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("php://output");
