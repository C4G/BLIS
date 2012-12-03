<?php
include("../includes/db_lib.php");

$q = $_REQUEST['q'];
$a = $_REQUEST['a'];
$count = 0;
if($a == 0)
    $count = search_patients_by_id_count($q);
else if($a == 1)
    $count = search_patients_by_name_count($q);
else if($a == 2)
    $count = search_patients_by_addlid_count($q);
else if($a == 3)
    $count = search_patients_by_dailynum_count("-".$q);
else if($a == 9)
    $count = search_patients_by_db_id_count($q);

echo $count;
?>
