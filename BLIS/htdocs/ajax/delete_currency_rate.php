<?php
include("../includes/db_lib.php");

$lab_config_id = $_REQUEST['lid'];
$lab_config = LabConfig::getById($lab_config_id);
$currencyFrom = $_REQUEST['defaultCurrency'];
$currencyTo = $_REQUEST['secondaryCurrency'];

if($lab_config == null)
	return;

delete_currency_rate_lab_config($lab_config_id, $currencyFrom, $currencyTo);
?>
