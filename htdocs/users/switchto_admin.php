<?php
#
# Main page for switching back from tech role to admin/director role
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/user_lib.php");

# Restore required session variables
$_SESSION['lab_config_id'] = $_SESSION['lab_config_id_backup'];
$_SESSION['user_level'] = $_SESSION['user_level_backup'];
$_SESSION['db_name'] = $_SESSION['db_name_backup'];
# Reset flag
if(isset($_SESSION['admin_as_tech']))
	$_SESSION['admin_as_tech'] = false;
if(isset($_SESSION['dir_as_tech']))
{
	$_SESSION['langdata_path'] = $LOCAL_PATH."langdata_revamp/";
	$_SESSION['dir_as_tech'] = false;	
}
header("location: home.php");
?>