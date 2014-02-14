<?php
#
# Main page for updating a lab user account
# Called via Ajax from lab_user_edit.php
#

include("../includes/db_lib.php");
include("../includes/user_lib.php");

$saved_session = SessionUtil::save();

$user_id = $_REQUEST['id'];
$username = $_REQUEST['un'];
$fullname = $_REQUEST['fn'];
$email = $_REQUEST['em'];
$phone = $_REQUEST['ph'];
$new_pwd = $_REQUEST['p'];
$level = $_REQUEST['lev'];
$lang_id = $_REQUEST['lang'];
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
$user->email = $email;
$user->phone = $phone;
$user->password = $new_pwd;
$user->level = $level;
$user->langId = $lang_id;

update_lab_user($user);

SessionUtil::restore($saved_session);
?>