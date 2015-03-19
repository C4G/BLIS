<?php
#
# Deletes the configuration details of a specified device
# Called via Ajax from lab_config_home.php
#

	include("../includes/db_lib.php");

	$instrument_id = $_POST['id'];

	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

	$query = sprintf("DELETE FROM test_machines WHERE id = %s", mysql_real_escape_string($instrument_id));
	query_delete($query);

	DbUtil::switchRestore($saved_db);

?>

