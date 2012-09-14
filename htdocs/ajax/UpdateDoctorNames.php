<?php

include("../includes/db_mysql_lib.php");

$id = $_REQUEST['id'];
$orgNameId = "originalDoctorName".$id;
$originalDoctorName = $_REQUEST[$orgNameId];
$newNameId = "newDoctorNameInput".$id;
$newDoctorName = $_REQUEST[$newNameId];

$query = "UPDATE specimen SET doctor = '$newDoctorName' ".
		 "WHERE doctor like '$originalDoctorName' ";
query_update($query);

header("Location: ../");

?>
