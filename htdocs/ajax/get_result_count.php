<?php
include("../includes/SessionCheck.php");
include("../includes/db_lib.php");

$q = $_REQUEST['q'];
$a = $_REQUEST['a'];
$c = $_REQUEST['c'];
$lab_section = $_REQUEST['labsection'];
$satellite_lab_id = get_satellite_lab_user_id($_SESSION['user_id']);

$count = 0;
if($a == 0) {
    $count = search_patients_by_id_count($q, $labsection, $satellite_lab_id);
}
else if($a == 1){ 
    $count = search_patients_by_name_count($q, $labsection,$c, $satellite_lab_id);
}
else if($a == 2)
    $count = search_patients_by_addlid_count($q, $labsection, $satellite_lab_id);
else if($a == 3)
    $count = search_patients_by_dailynum_count("-".$q, $labsection, $satellite_lab_id);
else if($a == 9)
    $count = search_patients_by_db_id_count($q, $labsection);
echo $count;
?>
