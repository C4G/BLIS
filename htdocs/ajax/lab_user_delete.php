<?php
#
# Main page for deleting a lab user account
# Called via Ajax from lab_config_home.php
#

include("../includes/db_lib.php");

$saved_session = SessionUtil::save();

$user_id = $_REQUEST['uid'];
delete_user_by_id($user_id);

SessionUtil::restore($saved_session);
?>