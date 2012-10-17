<?php
include("../includes/db_lib.php");

$q = $_REQUEST['q'];
$a = $_REQUEST['a'];
$count = 0;
if($a == 1)
    $count = search_patients_by_name_count($q);

echo $count;
?>
