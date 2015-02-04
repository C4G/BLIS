<?php

include("../includes/db_lib.php");

$userId = $_SESSION['user_id'];
$driverID = $_REQUEST['driver'];
$deviceName = $_REQUEST['name'];
$deviceDescription = $_REQUEST['description'];
$hostIPAddress = $_REQUEST['ip_address'];
$hostname = $_REQUEST['host_name'];

$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

$queryString = "INSERT INTO test_machines (name, description, ip_address, host_name, machine_driver_id)".
				" VALUES ('%s', '%s', '%s', '%s', '%s')";
$queryString = sprintf($queryString,
				mysql_real_escape_string(),
				mysql_real_escape_string(),
				mysql_real_escape_string(),
				mysql_real_escape_string(),
				mysql_real_escape_string());

query_insert_one($queryString) or die(mysql_error());
DbUtil::switchRestore($saved_db);

?>