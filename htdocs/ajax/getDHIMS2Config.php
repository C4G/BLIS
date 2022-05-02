<?php
include("../includes/SessionCheck.php");
include("../includes/db_lib.php");
include("../includes/SessionCheck.php");

$dhims2 = new DHIMS2();
$lab_config_id = $_REQUEST['l'];
echo json_encode($dhims2->getConfigs($lab_config_id));
?>