<?php
#
# Sends matching test types for jquery.token-input plugin
#

include ("../includes/ajax_lib.php");
include ("../includes/db_lib.php");

$q = $_REQUEST['q'];
$test_list = search_test_types_catalog($q);
$json_params = array('id', 'name');
echo list_to_json($test_list, $json_params);
?>