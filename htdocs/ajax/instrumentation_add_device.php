<?php

include("../includes/db_lib.php");

$driverID = $_REQUEST['driver'];
$deviceName = $_REQUEST['name'];
$deviceDescription = $_REQUEST['description'];
$hostIPAddress = $_REQUEST['ip_address'];
$hostname = $_REQUEST['host_name'];

$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

$queryString = "INSERT INTO test_machines (name, description, ip_address, hostname, machine_driver_id)".
				" VALUES ('%s', '%s', '%s', '%s', '%s')";
$queryString = sprintf($queryString,
				mysql_real_escape_string($deviceName),
				mysql_real_escape_string($deviceDescription),
				mysql_real_escape_string($hostIPAddress),
				mysql_real_escape_string($hostname),
				mysql_real_escape_string($driverID));

query_insert_one($queryString);
DbUtil::switchRestore($saved_db);

?>