<?php
/**
 * C4G BLIS Spring 22
 * Date: 3/06/2022
 */
include("../includes/SessionCheck.php");
include('../includes/db_lib.php');

$lab_config_id = $_REQUEST['lab_config_id'];
$server_ip = $_REQUEST['server_ip'];
// $saved_db = DbUtil::switchToGlobal();

$queryString = "UPDATE lab_config SET server_ip = '$server_ip' WHERE lab_config_id = $lab_config_id";
query_update($queryString) or die(mysql_error());

// DbUtil::switchRestore($saved_db);
echo "true"; 

?>