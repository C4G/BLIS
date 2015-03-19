<?php
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# This page should check the user permissions. If the user is not logged in, the we should forward the user to the login page.
# If the user is logged in, we should check the permissions in the database, and display the appropriate options to the user.

require_once("user_lib.php");

if(session_id() == '')
	session_start();

if(isset($TRACK_LOADTIME) && $TRACK_LOADTIME)
{
	# TEMP
	# Initialize session for testing load times with hard-coded values
	$_SESSION['username'] = "testlab1_tech1";
	$user = get_user_by_name($_SESSION['username']);
	$_SESSION['user_id'] = 56;
	$_SESSION['user_actualname'] = "Technician 1";
	$_SESSION['user_level'] = $LIS_TECH_RW;
	$_SESSION['locale'] = $DEFAULT_LANG;
	//if($user->isAdmin())
	if(is_admin($user))
	{
		$_SESSION['lab_config_id'] = -1;
		$_SESSION['db_name'] = "";
	}
	else
	{
		$_SESSION['lab_config_id'] = $user->labConfigId;
		$lab_config = get_lab_config_by_id($user->labConfigId);
		$_SESSION['db_name'] = $lab_config->dbName;
	}

	# Set session variables for recording latency/user props
	$_SESSION['PROPS_RECORDED'] = false;
	$_SESSION['DELAY_RECORDED'] = false;
	#TODO: Add other session variables here
	$_SESSION['user_role'] = "garbage";
}

$page_access_map = array();

if
(
	!isset($_SESSION['username']) 
	&& strpos($_SERVER['PHP_SELF'], 'login.php') === false 
	&& strpos($_SERVER['PHP_SELF'], 'password_reset.php') === false 
	&& strpos($_SERVER['PHP_SELF'], 'password_reset_confirm.php') === false 
)
{
	#User not logged in
	header("Location:login.php?prompt");
}
else if
(
	strpos($_SERVER['PHP_SELF'], 'login.php') === false 
	&& strpos($_SERVER['PHP_SELF'], 'password_reset.php') === false 
	&& strpos($_SERVER['PHP_SELF'], 'password_reset_confirm.php') === false 
)
{
	# TODO:
	# This code is executed if the user is logged in
	# Check if user has access to $_SERVER['PHP_SELF']
	if(isset($_SESSION['user_level']))
	{
		
	}
	# ...
	# Fetch appropriate top menu options in an array
	if(isset($_SESSION['user_level']))
	{	
		$user = get_user_by_name($_SESSION['username']);

		$top_menu_options = get_top_menu_options($_SESSION['user_level'], $user->rwoptions );
	}
}
?>