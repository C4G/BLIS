<?php
#
# Main page for updating a lab user account
# Called via Ajax from lab_user_edit.php
#
include("../includes/SessionCheck.php");
include("../includes/db_lib.php");

$saved_session = SessionUtil::save();

$type=$_REQUEST['lab_user_type'];

$defaultoption=$_REQUEST['showpname'];

$rwoption=$_REQUEST['rw'];
$usertype = new UserType();
$usertype->level = $type;
$usertype->defaultdisplay = $defaultoption;


update_lab_user_type($usertype,$rwoption );

echo $usertype->defaultdisplay;

SessionUtil::restore($saved_session);
?>