<?php

include("../includes/db_lib.php");

$lab_config_id = $_REQUEST['lid'];
$lab_config = LabConfig::getById($lab_config_id);

if($lab_config == null)
	return;

if ($_REQUEST['enable_billing']) {
    enable_billing($lab_config_id);
} else {
    disable_billing($lab_config_id);
}
?>
