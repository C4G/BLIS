<?php
#
# Marks submitted results as verified, with corrections if any
# Called via ajax from verify_results.php
#

include("../includes/db_lib.php");

# Helper function
# TODO: Move this to Test::verifyAndUpdate()
function verify_and_update($test_type_id, $verified_entry, $hash_value)
{
	$specimen_id = $verified_entry->specimenId;
	$query_string =
		"SELECT * FROM test ".
		"WHERE specimen_id=$specimen_id ".
		"AND test_type_id=$test_type_id LIMIT 1";
	$record = query_associative_one($query_string);
	$existing_entry = Test::getObject($record);
	$test_id = $existing_entry->testId;
	$verified_result_value = $verified_entry->result.$hash_value;
	$query_verify = "";
	if	(
			$existing_entry->result == $verified_result_value && 
			$existing_entry->comments == $verified_entry->comments
		)
	{
		# No changes or corrections after verification
		$query_verify = 
			"UPDATE test ".
			"SET verified_by=$verified_entry->verifiedBy, ".
			"date_verified='$verified_entry->dateVerified' ".
			"WHERE test_id=$test_id";
	}
	else
	{
		# Update with corrections and mark as verified
		$query_verify =
			"UPDATE test ".
			"SET result='$verified_result_value', ".
			"comments='$verified_entry->comments', ".
			"verified_by=$verified_entry->verifiedBy, ".
			"date_verified='$verified_entry->dateVerified' ".
			"WHERE test_id=$test_id";
	}
	query_blind($query_verify);
}

# Execution begins here
$test_type_id = $_REQUEST['t_type'];
$num_measures = $_REQUEST['num_measures'];
$specimen_id_list = $_REQUEST['specimen_id'];
$comments_list = $_REQUEST['comments'];
$measure_list = array();
for($i = 1; $i <= $num_measures; $i++)
{
	$field_name = "measure_$i";
	$measure_list[] = $_REQUEST[$field_name];
}
for($i = 0; $i < count($specimen_id_list); $i++)
{
	if(isset($_REQUEST['verify_flag_'.($i+1)]) === false)
	{
		# Verify flag is unset. Skip.
		continue;
	}
	$test_entry = new Test();
	$test_entry->specimenId = $specimen_id_list[$i];
	$specimen = Specimen::getById($specimen_id_list[$i]);
	$patient = Patient::getById($specimen->patientId);
	$result_values = array();
	for($j = 0; $j < $num_measures; $j++)
	{
		$result_values[] = $measure_list[$j][$i];
	}
	$test_entry->result = implode(",", $result_values).",";
	$test_entry->comments = $comments_list[$i];
	$test_entry->verifiedBy = $_SESSION['user_id'];
	$test_entry->dateVerified = date("Y-m-d H:i:s");
	# TODO: Add checking of valid ranges before committing verification
	verify_and_update($test_type_id, $test_entry, $patient->getHashValue());
}
?>
<div class='sidetip_nopos'>
Results marked a verified
</div>