<?php
/**
 * C4G BLIS Spring 22
 * Date: 3/11/2022
 */
include("../includes/SessionCheck.php");
include('../includes/db_lib.php');

$lab_config_id = $_REQUEST['lab_config_id'];
$server_ip = $_REQUEST['server_ip'];
// $saved_db = DbUtil::switchToGlobal();

// TODO call backup code, send to server

echo "true"; 

?>