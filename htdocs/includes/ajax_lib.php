<?php
#
# Library functions for Ajax calls and JSON data
#

function list_to_json($value_list, $json_params)
{
	# Utility function that converts an associative list to JSON string
	$count = 0;
	$return_string = "";
	$return_string .= "[";
	foreach($value_list as $key => $value)
	{
		$return_string .= "{\"".$json_params[0]."\": \"".$key."\", \"".$json_params[1]."\": \"".$value."\"}";
		$count += 1;
		if($count != count($value_list))
			$return_string .= ", ";
	}
	$return_string .= "]";
	return $return_string;
}
