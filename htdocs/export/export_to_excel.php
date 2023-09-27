<?php

# TAKE NOTE!
# For this to work properly, you need to make sure that _all_ of these
# required files are not outputting anything to the browser.
# https://github.com/PHPOffice/PHPExcel/blob/1.8/Documentation/markdown/Overview/08-Recipes.md#http-headers
# Ensure that these files are _not_ encoded as "UTF-8 with BOM" (Byte Order Mark)
# since that also counts. They should be "UTF-8".
require_once("../includes/composer.php");
require_once("../includes/db_lib.php");
require_once("../includes/user_lib.php");

$current_user_id = $_SESSION['user_id'];

$current_user = get_user_by_id($current_user_id);
if (!is_super_admin($current_user) && !is_country_dir($current_user)) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    echo "You do not have permission to view this page.";
    exit;
}

// Send the spreadsheet directly to the browser
// Do not echo() or output anything else below this line!

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="report.xlsx"');
header('Cache-Control: max-age=0');

$labs = get_lab_configs($current_user_id);

// The headers for the spreadsheet must match the columns in the query below
$headers = array("Patient Name", "Sex", "Date of Birth", "Specimen Type", "Date Collected", "Test Result");
$query = <<<'EOQ'
    SELECT
        p.name AS patient_name, p.sex, p.dob as patient_dob,
        st.name AS specimen_type, s.date_collected AS specimen_collected,
        t.result AS test_result
    FROM specimen AS s
    INNER JOIN specimen_type AS st ON s.specimen_type_id = st.specimen_type_id
    INNER JOIN test AS t ON s.specimen_id = t.specimen_id
    INNER JOIN patient AS p ON s.patient_id = p.patient_id;
EOQ;

# TODO - make this dynamic
db_change("blis_127");

$results = query_associative_all($query);

$objPHPExcel = new PHPExcel();

$sheet = $objPHPExcel->getSheet(0);
$sheet->setTitle("Patient Test Results");

foreach($headers as $index => $header) {
    $sheet->setCellValueByColumnAndRow($index, 1, $header);
}

foreach($results as $row_index => $row) {
    $col = 0;
    foreach($row as $col_name => $value) {
        $sheet->setCellValueByColumnAndRow($col, $row_index + 2, $value);
        $col = $col + 1;
    }
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("php://output");
