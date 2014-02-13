<?php
#
# Updates report configuration in DB
# Called via Ajax from lab_config_home.php
#
include("../includes/db_lib.php");
$p_fields=$_REQUEST['p_fields_left'];
$o_fields=$_REQUEST['o_fields_left'];


$p_fields=rtrim(ltrim($p_fields,','),',');
$o_fields=rtrim(ltrim($o_fields,','),',');

Patient::updateReportOrder($p_fields,$o_fields);

?>