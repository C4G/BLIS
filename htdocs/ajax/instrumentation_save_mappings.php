<?php

	include("../includes/db_lib.php");

	$driverID = $_REQUEST['machine_driver_id'];
	$testTypes = $_REQUEST['test_type'];
	$measures = $_REQUEST['measure'];
	$resultKeys = $_REQUEST['result_key'];

	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

	$queryString = "INSERT INTO test_type_instruments (test_type_id, measure_id, machine_driver_id, result_key)".
					" VALUES ('%s', '%s', '%s', '%s')";

	for($i=0; $i < count($testTypes); $i++) {

		if (intval($testTypes[$i]) > 0) {
			$execString = sprintf($queryString,
						mysql_real_escape_string($testTypes[$i]),
						mysql_real_escape_string($measures[$i]),
						mysql_real_escape_string($driverID),
						mysql_real_escape_string($resultKeys[$i]));

			query_insert_one($execString);
		}
	}

	DbUtil::switchRestore($saved_db);

?>