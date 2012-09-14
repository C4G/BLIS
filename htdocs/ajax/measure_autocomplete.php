<?php
#
# Returns token input values for "autocomplete" type measure
# Called via Ajax from results_entry.php
#

include ("../includes/ajax_lib.php");
include ("../includes/db_lib.php");

function find_matched($list, $search_string)
{
	$retval = array();
	foreach($list as $value)
	{
		if(strcasecmp(substr($value, 0, strlen($search_string)),$search_string) == 0)
		{
			$retval[] = $value;
		}
	}
	return $retval;
}

$measure_id =$_REQUEST['id'];
$q = $_REQUEST['q'];

$measure = Measure::getById($measure_id);
$value_map = array();
$range_values = $measure->getRangeValues();
$matched_range_values = find_matched($range_values, $q);
foreach($matched_range_values as $range_value)
{
	$value_map[$range_value] = $range_value;
}
$json_params = array('id', 'name');
echo list_to_json($value_map, $json_params);
?>