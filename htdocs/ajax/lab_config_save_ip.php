<?php
/**
 * C4G BLIS Spring 22
 * Date: 3/06/2022
 */
require_once('../includes/lab_config.php');

$lab_config_id = $_REQUEST['lab_config_id'];
$lab_config = LabConfig::getById($lab_config_id);

$server_ip = $_REQUEST['server_ip'];

$lab_config->updateBlisCloudHostname($server_ip);

echo "true"; 

?>