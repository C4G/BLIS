<?php
#
# Library functions for Ajax calls and JSON data
#

# Require LangUtil class here so AJAX pages have access to it
if(!class_exists('LangUtil')) {
    # Hack to prevent legacy language files from double-including this file
    require_once("../lang/lang_util.php");
}


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
