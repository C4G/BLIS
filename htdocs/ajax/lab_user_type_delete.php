<?php
#
# Main page for deleting a lab user account
# Called via Ajax from lab_config_home.php
#
include("../includes/SessionCheck.php");
include("../includes/db_lib.php");

$saved_session = SessionUtil::save();

$user_type = $_REQUEST['type'];

delete_user_type($user_type);

SessionUtil::restore($saved_session);
?>