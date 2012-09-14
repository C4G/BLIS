<?php
#
# Main page for updating a lab admin account
# Called via Ajax from lab_admin_edit.php
#

include("../includes/db_lib.php");

$saved_session = SessionUtil::save();

$user_id = $_REQUEST['id'];
$username = $_REQUEST['un'];
$fullname = $_REQUEST['fn'];
$email = $_REQUEST['em'];
$phone = $_REQUEST['ph'];
$new_pwd = $_REQUEST['p'];
$lang_id = $_REQUEST['lang'];

$user = new User();
$user->userId = $user_id;
$user->username = $username;
$user->actualName = $fullname;
$user->email = $email;
$user->phone = $phone;
$user->password = $new_pwd;
$user->langId = $lang_id;

update_admin_user($user);

SessionUtil::restore($saved_session);
?>