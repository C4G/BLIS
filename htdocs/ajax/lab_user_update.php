<?php
#
# Main page for updating a lab user account
# Called via Ajax from lab_user_edit.php
#

include_once("../includes/SessionCheck.php");
include_once("../includes/db_lib.php");

$saved_session = SessionUtil::save();

$user_id = $_REQUEST['id'];
$username = $_REQUEST['un'];
$fullname = $_REQUEST['fn'];
$satellite_lab_name = $_REQUEST['sln'];
$email = $_REQUEST['em'];
$phone = $_REQUEST['ph'];
$new_pwd = $_REQUEST['p'];
$level = $_REQUEST['lev'];
$lang_id = $_REQUEST['lang'];
$rwoptions = $_REQUEST['opt'];

if($level == $LIS_TECH_RW)
{
	if($_REQUEST['showpname'] == 1)
	{
		$level = $LIS_TECH_SHOWPNAME;
	}
}

$user = new User();
$user->userId = $user_id;
$user->username = $username;
$user->actualName = $fullname;
$user->satelliteLabName = $satellite_lab_name;
$user->email = $email;
$user->phone = $phone;
$user->password = $new_pwd;
$user->level = $level;
$user->langId = $lang_id;
$user->rwoption = $rwoptions;

update_lab_user($user);
ECHO "RESET";
SessionUtil::restore($saved_session);
?>