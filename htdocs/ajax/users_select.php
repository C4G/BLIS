<?php
# Returns a JSON list of usernames for a site location via Ajax
# Called from reports.php
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

$user_list = get_users_by_site_map($_REQUEST['site']);
$json_params = array('optionValue', 'optionDisplay');
echo list_to_json($user_list, $json_params);
?>
