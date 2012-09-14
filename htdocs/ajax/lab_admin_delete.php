<?php
#
# Main page for deleting a lab admin account
# Called via Ajax from lab_configs.php
#

include("../includes/db_lib.php");

$saved_session = SessionUtil::save();

$user_id = $_REQUEST['user_id'];
delete_user_by_id($user_id);

SessionUtil::restore($saved_session);
?>