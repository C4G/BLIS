<?php
#
# Deletes a driver file
# Called via Ajax from lab_config_home.php
#

	include("../includes/db_lib.php");

	$driver_id = $_POST['id'];
	$plugin_dir = $_SERVER['DOCUMENT_ROOT']."classes/plugins/";
	$driver_file = ".php";

	# Delete DB tables entries corresponding to this driver
	$saved_db = DbUtil::switchToGlobal();
	$query = sprintf("SELECT driver_name FROM machine_drivers WHERE id = %s", mysql_real_escape_string($driver_id));
	$record = query_associative_one($query);

	if($record != null){

		$driver_file =  $plugin_dir.$record['driver_name'].$driver_file;
	}

	$query = sprintf("DELETE FROM machine_drivers WHERE id = %s", mysql_real_escape_string($driver_id));
	query_delete($query);

	DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

	$query = sprintf("DELETE FROM test_machines WHERE machine_driver_id = %s", mysql_real_escape_string($driver_id));
	query_delete($query);

	$query = sprintf("DELETE FROM test_type_instruments WHERE machine_driver_id = %s", mysql_real_escape_string($driver_id));
	query_delete($query);

	DbUtil::switchRestore($saved_db);

	# Delete corresponding driver file

	unlink(realpath($driver_file));

?>

