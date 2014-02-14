<?php
#
# Sends matching test measure names for jquery.token-input plugin
#

include ("../includes/ajax_lib.php");
include ("../includes/db_lib.php");

$q = $_REQUEST['q'];
$measure_list = search_measures_catalog($q);
$json_params = array('id', 'name');
echo list_to_json($measure_list, $json_params);
?>