<?php
# Returns a JSON list of test types for a site location via Ajax
# Called from pages where site/location drop down box is used
include("../includes/db_lib.php");

function list_to_json($value_list, $json_params)
{
	$count = 0;
	$return_string = "";
	$return_string .= "[";
	foreach($value_list as $key => $value)
	{
		$return_string .= "{".$json_params[0].": ".$key.", ".$json_params[1].": '".$value."'}";
		$count += 1;
		if($count != count($value_list))
			$return_string .= ", ";
	}
	$return_string .= "]";
	return $return_string;
}

$test_list = get_test_types_by_site_map($_REQUEST['site']);
$json_params = array('optionValue', 'optionDisplay');
echo list_to_json($test_list, $json_params);
?>
