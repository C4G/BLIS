<?php

include("../includes/db_lib.php");

$userId = $_SESSION['user_id'];
$specimenName = $_REQUEST['specimenName'];
$labIdSpecimenId = $_REQUEST['labIdSpecimenId'];

$saved_db = DbUtil::switchToGlobal();
$queryString = "SELECT MAX(specimen_id) AS specimen_id FROM specimen_mapping ".
			   "WHERE user_id=$userId";
$record = query_associative_one($queryString);
$specimenId = intval($record['specimen_id']) + 1;
$queryString = "INSERT INTO specimen_mapping (user_id, specimen_name, lab_id_specimen_id, specimen_id) ".
			   "VALUES (".$userId.",'".$specimenName."','".$labIdSpecimenId."',".$specimenId.")";
query_insert_one($queryString) or die(mysql_error());
DbUtil::switchRestore($saved_db);

echo "true";
?>