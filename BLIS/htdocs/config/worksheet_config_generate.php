<?php
include("../includes/db_lib.php");

function generate_worksheet_config($lab_config_id)
{
	$lab_config = LabConfig::getById($lab_config_id);
	
	$test_ids = $lab_config->getTestTypeIds();
	
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	foreach($test_ids as $test_id)
	{
		$test_entry = TestType::getById($test_id);
		$query_string = 
			"SELECT * FROM report_config WHERE test_type_id=$test_id LIMIT 1";
		$record = query_associative_one($query_string);
		if($record == null)
		{	
			# Add new entry
			$query_string_add = 
				"INSERT INTO report_config (".
					"test_type_id, header, footer, margins, ".
					"p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields ".
				") VALUES (".
					"'$test_id', 'Worksheet - ".$test_entry->name."', '', '5,0,5,0', ".
					"'0,1,0,1,1,0,0', '0,0,1,1,0,0', '1,0,1,0,0,0,0,1', '', '' ".
				")";
			query_insert_one($query_string_add);
		}
	}
	DbUtil::switchRestore($saved_db);
}

generate_worksheet_config(129);
?>