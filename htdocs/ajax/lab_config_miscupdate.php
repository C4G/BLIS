<?php
#
# Updates general settings (misc) for a lab configuration
# Also, generates/clears existing random data
# Called via Ajax from lab_config_home.php
#
require_once(__DIR__."/../includes/SessionCheck.php");
require_once(__DIR__."/../includes/composer.php");
require_once(__DIR__."/../includes/db_lib.php");
require_once(__DIR__."/../includes/random.php");
require_once(__DIR__."/../users/accesslist.php");

global $log;

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

if (!isCountryDir($current_user) && !isSuperAdmin($current_user)) {
	$_SESSION['FLASH'] = "You do not have permission to update this lab's metadata.";
    header("Location: /home.php");
    return;
}

$saved_session = SessionUtil::save();
$saved_id = $_SESSION['lab_config_id'];

$lab_config_id = $_REQUEST['lid'];
$name = $_REQUEST['name'];
$location = $_REQUEST['loc'];
$lab_config = LabConfig::getById($lab_config_id);

if(trim($name) !== "") {
	$log->info("Updating lab name to '$name'");
	$lab_config->changeName($name);
}

if(trim($location) != "") {
	$log->info("Updating lab location to '$location'");
	$lab_config->changeLocation($location);
}

$saved_db = DbUtil::switchToLabConfig($lab_config->id);

# Random data management: ONLY for test/evaluation phase
# 1: Generate Random Data
# 2: Clear Random Data
# 3: Do nothing
$dboption = $_REQUEST['dboption'];
if($dboption != 0)
{
	global $MAX_NUM_PATIENTS, $MAX_NUM_SPECIMENS;
	$num_patients = $_REQUEST['num_p'];
	$num_specimens = $_REQUEST['num_s'];
	if($num_patients > $MAX_NUM_PATIENTS || is_nan($num_patients))
	{
		$num_patients = $MAX_NUM_PATIENTS;
	}
	if($num_specimens > $MAX_NUM_SPECIMENS || is_nan($num_specimens))
	{
		$num_specimens = $MAX_NUM_SPECMENS;
	}
	$_SESSION['lab_config_id'] = $lab_config_id;
	//clear_random_data($lab_config);
	empty_test_table();
	empty_specimen_table();
	//empty_patient_table();
	if($dboption == 1)
	{
		# Generate random data again
		add_patients_random($num_patients);
		//echo "Patients added successfully!";
		## Random specimen entries
		$user_list = $lab_config->getUsers();
		add_specimens_random($num_specimens, $user_list);
		echo "Specimens added successfully!";
		## Random test result entries
		add_results_sequential($user_list);
		echo "Results added successfully!";
	}
	else if($dboption == 2)
	{
		# Cleared all random data records
		# Do nothing as data already cleared above this if-else block.
	}
}

DbUtil::switchRestore($saved_db);
$_SESSION['lab_config_id'] = $saved_id;
SessionUtil::restore($saved_session);

// Contrary to what this filename implies, this page is _not_ called by AJAX anywhere, so we need to make sure to redirect
// back to the lab config page.
$_SESSION['FLASH'] = "Lab config was updated successfully.";
header("Location: /lab_config_home.php?id=$lab_config_id");

?>
