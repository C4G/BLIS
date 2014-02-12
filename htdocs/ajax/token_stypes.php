<?php
#
# Sends matching specimen types for jquery.token-input plugin
#

include ("../includes/ajax_lib.php");
include ("../includes/db_lib.php");

$q = $_REQUEST['q'];
$specimen_list = search_specimen_types_catalog($q);
$json_params = array('id', 'name');
echo list_to_json($specimen_list, $json_params);
?>