<?php
#
# Changes password for the user
# Called from edit_profile.php
#
include("redirect.php");
session_start(); 
include("includes/db_lib.php");
$username = $_SESSION['username'];
$old_password = $_REQUEST['old_password'];
$new_password = $_REQUEST['new_password'];
# Check if old password matches
$correct_password = check_user_password($username, $old_password);
$url_append = "";
if($correct_password === false)
{
	$url_append = "pmatcherr";
}
else
{
	# Update new password in DB
	$password_changed = change_user_password($username, $new_password);
	if($password_changed === false)
	{
		$url_append = "pupdateerr";
	}
	else
	{	
		$url_append = "pupdate";
	}
}
db_close();
header("location:edit_profile.php?".$url_append);
?>