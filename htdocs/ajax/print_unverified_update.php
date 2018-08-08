<?php

include("../includes/db_lib.php");

$lab_config = $_REQUEST['lab_config_id'];
$print_unverified = $_REQUEST['pv'];

LabConfig::setPrintUnverified($lab_config, $print_unverified);

?>