<?php
include("../includes/db_lib.php");

$q = $_REQUEST['q'];
$a = $_REQUEST['a'];
$c = $_REQUEST['c'];
$lab_section = $_REQUEST['labsection'];
$count = 0;
if($a == 0)
    $count = search_patients_by_id_count($q, $labsection);
else if($a == 1)
    $count = search_patients_by_name_count($q, $labsection,$c);
else if($a == 2)
    $count = search_patients_by_addlid_count($q, $labsection);
else if($a == 3)
    $count = search_patients_by_dailynum_count("-".$q, $labsection);
else if($a == 9)
    $count = search_patients_by_db_id_count($q, $labsection);

echo $count;
?>
