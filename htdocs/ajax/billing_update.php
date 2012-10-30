<?php

include("../includes/db_lib.php");

$lab_config_id = $_REQUEST['lid'];
$lab_config = LabConfig::getById($lab_config_id);

if($lab_config == null)
	return;

if ($_REQUEST['enable_billing']) {
    enable_billing();
} else {
    disable_billing();
}

update_currency_name_in_lab_config_settings($_REQUEST['currency_name']);
update_currency_delimiter_in_lab_config_settings($_REQUEST['currency_delimiter']);
?>
