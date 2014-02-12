<?php
#
# Main page for switching from admin/director role to technician role
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/user_lib.php");

# Backup required session variables
$_SESSION['lab_config_id_backup'] = $_SESSION['lab_config_id'];
$_SESSION['user_level_backup'] = $_SESSION['user_level'];
$_SESSION['db_name_backup'] = $_SESSION['db_name'];
# Overwrite new values
$_SESSION['lab_config_id'] = $_REQUEST['id'];
# Change to technician mode with patient name access
$_SESSION['user_level'] = $LIS_TECH_SHOWPNAME;
$lab_config = get_lab_config_by_id($_REQUEST['id']);
$_SESSION['db_name'] = $lab_config->dbName;
# Config values for registration fields
$_SESSION['p_addl'] = $lab_config->patientAddl;
$_SESSION['s_addl'] = $lab_config->specimenAddl;
$_SESSION['dnum'] = $lab_config->dailyNum;
$_SESSION['sid'] = $lab_config->sid;
$_SESSION['pid'] = $lab_config->pid;
$_SESSION['comm'] = $lab_config->comm;
$_SESSION['age'] = $lab_config->age;
$_SESSION['dob'] = $lab_config->dob;
$_SESSION['rdate'] = $lab_config->rdate;
$_SESSION['refout'] = $lab_config->refout;
$_SESSION['pname'] = $lab_config->pname;
$_SESSION['sex'] = $lab_config->sex;
$_SESSION['dformat'] = $lab_config->dateFormat;	
$_SESSION['dnum_reset'] = $lab_config->dailyNumReset;
$_SESSION['doctor'] = $lab_config->doctor;
$_SESSION['pnamehide'] = $lab_config->hidePatientName;
if($SERVER == $ON_PORTABLE)
	$_SESSION['langdata_path'] = $LOCAL_PATH."langdata_".$lab_config->id."/";
else
	$_SESSION['langdata_path'] = $LOCAL_PATH."langdata_revamp/";
# Set flag
if($_SESSION['user_level_backup'] == $LIS_SUPERADMIN || $_SESSION['user_level_backup'] == $LIS_COUNTRYDIR)
	$_SESSION['dir_as_tech'] = true;
else if($_SESSION['user_level_backup'] == $LIS_ADMIN)
	$_SESSION['admin_as_tech'] = true;
header("location: home.php");
?>