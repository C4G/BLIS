<?php

include("../includes/db_lib.php");

$userId = $_SESSION['user_id'];
$measureName = $_REQUEST['measureName'];
$labIdMeasureId = $_REQUEST['labIdMeasureId'];

$saved_db = DbUtil::switchToGlobal();
$queryString = "SELECT MAX(measure_id) AS measure_id FROM measure_mapping ".
			   "WHERE user_id=$userId";
$record = query_associative_one($queryString);
$measureId = intval($record['measure_id']) + 1;

$queryString = "INSERT INTO measure_mapping (user_id, measure_name, lab_id_measure_id, measure_id) VALUES (".$userId.",'".$measureName."','".$labIdMeasureId."',".$measureId.")";
query_insert_one($queryString) or die(mysql_error());
DbUtil::switchRestore($saved_db);

echo "true";
?>