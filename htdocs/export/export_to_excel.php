<?php

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

$labs = get_lab_configs($current_user_id);

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

# TODO
db_change("blis_127");

$results = query_associative_all($query);

$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getSheet(0);
$sheet->setCellValue("A1", "Mitchell Rysavy");

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save("05featuredemo.xlsx");

$log->error(count($results));