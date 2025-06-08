<?php

include("../includes/db_lib.php");
include("../includes/SessionCheck.php");
$patientId =  $_REQUEST['p_id'];
$userId =  $_REQUEST['user_id'];
$logType =  $_REQUEST['log_type'];

$saved_db = DbUtil::switchToGlobal();
$queryString = "INSERT INTO user_log(patient_id, log_type, creation_date, created_by) VALUES (".$patientId.",'".$logType."','".date('Y-m-d H:i:s')."',".$userId.")";
global $con;
query_insert_one($queryString) or die(mysqli_error($con));
DbUtil::switchRestore($saved_db);

echo "true";
?>
