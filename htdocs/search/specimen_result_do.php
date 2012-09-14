<?php
#
# Adds test results for a single specimen
# Called via POST from specimen_result.php
#
include("redirect.php");
include("includes/db_lib.php");

$specimen_id = $_REQUEST['sid'];
$specimen = Specimen::getById($_REQUEST['sid']);

if($specimen == null)
{
	# Specimen ID invalid or specimen not found
	header("Location: specimen_info.php?sid=$specimen_id");
}
$patient = Patient::getById($specimen->patientId);
$test_list = get_tests_by_specimen_id($specimen->specimenId);

foreach($test_list as $test_entry)
{
	$test_type = get_test_type_by_id($test_entry->testTypeId);
	$comment_field_value = $_REQUEST[$comment_field_name];
	$measure_list = $test_type->getMeasures();
	$result_value_valid = true;
	$result_csv = "";
	$comments_csv = "";
	foreach($measure_list as $measure)
	{
		$result_field_name = 'result_'.$test_type->testTypeId."_".$measure->measureId;
		$comment_field_name = 'comments_'.$test_type->testTypeId."_".$measure->measureId;
		$result_value = $_REQUEST[$result_field_name];
		$comment_value = $_REQUEST[$comment_field_name];
		if( trim($result_value) == "" ) 
		{
			# Result value not provided / is empty:
			# Do not update result value
			$result_value_valid = false;
		}
		else { 
			if ( strstr($result_value, ",") ) 
				$result_csv .= str_replace(",","_",$result_value);
			else
				$result_csv .= $result_value."_";
		}	
		# replace last underscore with "," to separate multiple measures results
		$result_csv = substr($result_csv, 0, strlen($result_csv) - 1);
		$result_csv .= ",";
		
		if ( !($comment_value == "None") ) {
			$comment_csv .= $measure->name.":".$comment_value.", ";
		}
	}
	if($result_value_valid === true)
	{
		$result_csv .= ",";
		$comment_csv = substr($comment_csv,0,strlen($comment_csv)-2); //Remove the extra comma and space at the end
		$comment_csv = preg_replace("/[^a-zA-z0-9,+.;:_\s]/", "", $comment_csv);
		# Update verified results to DB
		$result_csv = preg_replace("/[^a-zA-Z0-9,+.;:_\s]/", "", $result_csv);
		if($test_entry->result == "")
		{
			# Test result not yet entered
			# Add these results to DB
			$test_entry->result = $result_csv;
			$test_entry->comments = $comment_csv;
			$test_entry->userId = $_SESSION['user_id'];
			$test_entry->addResult($patient->getHashValue());
		}
		else
		{
			# Existing results to be verified
			$test_entry->result = $result_csv;
			$test_entry->comments = $comment_csv;
			$test_entry->verifiedBy = $_SESSION['user_id'];
			$test_entry->dateVerified = date("Y-m-d H:i:s");
			$test_entry->verifyAndUpdate($patient->getHashValue());
		}
	}
}
header("Location: specimen_info.php?sid=$specimen_id&re=1");
?>