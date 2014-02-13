<?php
#
# Deletes all data (test/specimen types) in catalog
#

include("../includes/db_lib.php");
require_once("../includes/perms_check.php");

# Enable to delete by entry
$CLEAN_DELETE = false;

# Check if superadmin or country director
$user = get_user_by_id($_SESSION['user_id']);
if(!(is_super_admin($user) || is_country_dir($user)))
{
	# Abort
	return;
}

if($SERVER == $ON_DEV)
{
	# On dev server: Abort
	return;
}

if($CLEAN_DELETE === false)
{
	# Perform bulk deletion of catalog data
	$saved_db = DbUtil::switchToGlobal();
	$table_list = array (
		"lab_config_test_type",
		"lab_config_specimen_type",
		"specimen_test",
		"test_type_measure",
		"measure", 
		"test_type",
		"specimen_type"
	);
	foreach($table_list as $table_name)
	{
		query_empty_table($table_name);
	}
	DbUtil::switchRestore($saved_db);
	return;
}

# Perform clean deletion (by entry)
$saved_db = DbUtil::switchToGlobal();

$query_string = "SELECT * FROM test_type";
$resultset = query_associative_all($query_string, $row_count);
$test_list = array();
foreach($resultset as $record)
{
	$test_list[] = TestType::getObject($record);
}

# For each test type:
foreach($test_list as $test)
{
	$test_type_id = $test->testTypeId;
	# Remove entries from lab_config_test_type
	$query_string = "DELETE FROM lab_config_test_type WHERE test_type_id=$test_type_id";
	query_delete($query_string);
	# Remove entries from test_type_measure
	$query_string = "DELETE FROM test_type_measure WHERE test_type_id=$test_type_id";
	query_delete($query_string);
	# Remove entries from specimen_test
	$query_string = "DELETE FROM specimen_test WHERE test_type_id=$test_type_id";
	query_delete($query_string);
	# Remove entry from test_type
	$query_string = "DELETE FROM test_type WHERE test_type_id=$test_type_id";
	query_delete($query_string);
}

$query_string = "SELECT * FROM measure";
$resultset = query_associative_all($query_string, $row_count);
$measure_list = array();
foreach($resultset as $record)
{
	$measure_list[] = Measure::getObject($record);
}

# For each measure:
foreach($measure_list as $measure)
{
	$measure_id = $measure->measureId;
	# Remove entries from test_type_measure
	$query_string = "DELETE FROM test_type_measure WHERE measure_id=$measure_id";
	query_delete($query_string);
	# Remove entry from measure
	$query_string = "DELETE FROM measure WHERE measure_id=$measure_id";
	query_delete($query_string);
}

$query_string = "SELECT * FROM specimen_type";
$resultset = query_associative_all($query_string, $row_count);
$specimen_list = array();
foreach($resultset as $record)
{
	$specimen_list[] = TestType::getObject($record);
}

# For each specimen type:
foreach($specimen_list as $specimen)
{
	$specimen_type_id = $specimen->specimenTypeId;
	# Remove entries from lab_config_specimen_type
	$query_string = "DELETE FROM lab_config_specimen_type WHERE specimen_type_id=$specimen_type_id";
	query_delete($query_string);
	# Remove entries from specimen_test
	$query_string = "DELETE FROM specimen_test WHERE specimen_type_id=$specimen_type_id";
	query_delete($query_string);
	# Remove entry from specimen_type
	$query_string = "DELETE FROM specimen_type WHERE specimen_type_id=$specimen_type_id";
	query_delete($query_string);
}

DbUtil::switchRestore($saved_db);
?>