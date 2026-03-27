<?php

include("../includes/db_lib.php");
include("../includes/SessionCheck.php");
$lab_config_id = $_REQUEST['lid'];
$lab_config = LabConfig::getById($lab_config_id);

if($lab_config == null)
	return;

if ($_REQUEST['enable_billing']) {
    enable_billing();
} else {
    disable_billing();
}

$logos_dir = $STORAGE_DIR . "/logos";
if (!is_dir($logos_dir)) {
    mkdir($logos_dir, 0755, true);
}
$name = $logos_dir . "/logo_billing_" . $lab_config_id . ".jpg";
$success = move_uploaded_file($_FILES["billingLogo"]["tmp_name"], $name);
$a = update_currency_name_in_lab_config_settings($_REQUEST['default_currency']);
$b = update_currency_delimiter_in_lab_config_settings($_REQUEST['currency_delimiter']);
echo $a+$b;
?>