<?php
#
# Changes lab manager assigned to a lab configuration
#

include("../includes/db_lib.php");

$lab_config_id = $_REQUEST['lid'];
$admin_user_id = $_REQUEST['uid'];

$lab_config = LabConfig::getById($lab_config_id);
if($lab_config != null)
	$lab_config->changeAdmin($admin_user_id);

?>
