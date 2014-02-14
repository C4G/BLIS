<?php

// Get test result data for visualization

include("../includes/db_lib.php");
include("../includes/stats_lib.php");

$loc = $_REQUEST['location'];
$lab_config = get_lab_config_by_id($loc);

// From configuration
//$date_from = '2011-8-1';
//$date_to = '2012-5-1';
$patient_id = $_REQUEST['patient_id'];

$test_result_list = array();

$patient = get_patient_by_id($patient_id);

if($patient == null)
{
	// can't find patient infomation
	echo LangUtil::$generalTerms['PATIENT_ID']." $patient_id ".LangUtil::$generalTerms['MSG_NOTFOUND'];
}
else
{
	$record_list = get_records_to_print($lab_config, $patient_id);
	
	foreach($record_list as $value) {
		$test = $value[0];
		$specimen = $value[1];
		
		// get columns required for visualization
		$id=$test->testTypeId;
		$patient_name = $patient->name;
		$test_name = get_test_name_by_id($test->testTypeId);
		$test_date = get_test_date_by_id($test->testTypeId);
		
		$result = "";
		
		if(trim($test->result) == "")
			$result = "";
		else if($report_config->useMeasures == 1)
			$result = $test->decodeResultWithoutMeasures();
		else
			$result = $test->decodeResult();
		
		// cleaning up results
		$result = str_replace("&nbsp;", " ", $result);
		$result = str_replace("<br><br>", ", ", $result);
		$result = str_replace("<br>", ", ", $result);
		$result = str_replace("<b>", "", $result);
		$result = str_replace("</b>", "", $result);
		$result = str_replace(" ,", ",", $result);
		
		// if $result starts with ", ", remove it
		if(substr($result, 0, 2) === ", "){
			$result = substr($result, 2);
		}
		
		// if $result ends with ", ", remove it
		if(substr($result, -2) === ", "){
			$result = substr($result, 0, -2);
		}
		
		// range
		$test_type = TestType::getById($test->testTypeId);
		$measure_list = $test_type->getMeasures();
		
		$range_output = '';
		
		$loop_count = 0;
		foreach($measure_list as $measure) {
			
			$type=$measure->getRangeType();
			if($type==Measure::$RANGE_NUMERIC) {
				$range_list_array=$measure->getRangeString($patient);
				$lower=$range_list_array[0];
				$upper=$range_list_array[1];
				$unit=$measure->unit;
				if(stripos($unit,",")!=false) {
					$units=explode(",",$unit);
					$lower_parts=explode(".",$lower);
					$upper_parts=explode(".",$upper);

					if($lower_parts[0]!=0) {
						$range_output .= $lower_parts[0];
						$range_output .= $units[0];
					}
					
					if($lower_parts[1]!=0) {
						$range_output .= $lower_parts[1];
						$range_output .= $units[1];
					}
					$range_output .= "-";

					if($upper_parts[0]!=0) {
						$range_output .= $upper_parts[0];
						$range_output .= $units[0];
					}
					
					if($upper_parts[1]!=0) {
						$range_output .= $upper_parts[1];
						$range_output .= $units[1];
					}
				} else if(stripos($unit,":")!=false) {
					$units=explode(":",$unit);
					$range_output .= $lower;
					$range_output .= $units[0] . "-";
					$range_output .= $upper;
					$range_output .= $units[0];
					$range_output .= " ".$units[1];
				} else {		
					$range_output .= $lower."-". $upper; 
					$range_output .= " ".$measure->unit;
				}
			} else {
				if($measure->unit=="")
					$range_output .= "";
			}
			if($loop_count < count($measure_list)-1){
				$range_output .= ", ";
			}
			
			$loop_count++;
		}
		
		// comments
		$comment = $test->getComments();
		
		// clean up comments
		$comment = str_replace("&nbsp;", " ", $comment);
		$comment = str_replace("<br><br>", ", ", $comment);
		$comment = str_replace("<br>", ", ", $comment);
		$comment = str_replace("\n", ", ", $comment);
		$comment = str_replace("<b>", "", $comment);
		$comment = str_replace("</b>", "", $comment);
		$comment = str_replace(" ,", ",", $comment);
		
		// if $comment starts with ", ", remove it
		if(substr($comment, 0, 2) === ", "){
			$comment = substr($comment, 2);
		}
		
		// if $comment ends with ", ", remove it
		if(substr($comment, -2) === ", "){
			$comment = substr($comment, 0, -2);
		}
		
		// if result and range have one to one mapping, create multiple entries
		if(preg_match("/\d+-\d+.?\d+ .*, /",$range_output) && preg_match("/.* \d+.?\d+, /",$result)){
			//echo "found: ".$range_output;
			$split_result = explode(", ", $result);
			$num_of_results = count($split_result);
			
			$split_range = explode(", ", $range_output);
			$num_of_ranges = count($split_range);
			
			// if there's one to one mapping
			if($num_of_results == $num_of_ranges){
			//print_r($split_result);
				for($j=0; $j<$num_of_results; $j++){
				
					// handle results
					$trimmedResult = trim($split_result[$j]);
					$result_value_pair = explode(" ", $trimmedResult);
					$count_of_parts = count($result_value_pair);
					$subtest_name = "";
					
					// aggregate all parts before value for subtest name
					for($k=0; $k<$count_of_parts-1; $k++){
						$subtest_name .= $result_value_pair[$k];
					}
					$subtest_result = $result_value_pair[$count_of_parts-1];
					
					// handle ranges
					$subtest_range = $split_range[$j];
					
					$test_result_list[] = array('patient_id'=>$patient_id, 'test_id'=>$id, 'test_name'=>$test_name." - ".$subtest_name, 'test_date'=>$test_date, 'result'=>$subtest_result, 'range'=>$subtest_range, 'comment'=>$comment);
					
				}
			}else{
				$test_result_list[] = array('patient_id'=>$patient_id, 'test_id'=>$id, 'test_name'=>$test_name, 'test_date'=>$test_date, 'result'=>$result, 'range'=>$range_output, 'comment'=>$comment);
			}
		}else{
			$test_result_list[] = array('patient_id'=>$patient_id, 'test_id'=>$id, 'test_name'=>$test_name, 'test_date'=>$test_date, 'result'=>$result, 'range'=>$range_output, 'comment'=>$comment);
		}
	}
}


// return json data
$json_data = json_encode($test_result_list);
echo $json_data;

# Helper function to fetch test history records, from reports_testhistory.php
function get_records_to_print($lab_config, $patient_id) {
	global $date_from, $date_to;
	$retval = array();
	//if(isset($_REQUEST['ip']) && $_REQUEST['ip'] == 0) {
        if(isset($_REQUEST['inc_p']) && $_REQUEST['inc_p'] == 0) {
		# Do not include pending tests
            //echo "hi";
		$query_string =
			"SELECT t.* FROM test t, specimen sp ".
			"WHERE t.result <> '' ".
			"AND t.specimen_id=sp.specimen_id ".
			"AND sp.patient_id=$patient_id ";
		if(isset($_REQUEST['yf']))
			$query_string .= "AND (sp.date_collected BETWEEN '$date_from' AND '$date_to') ";
		$query_string .= "ORDER BY sp.date_collected DESC";
	
	}
	else {
            //echo "yo";
		# Include pending tests
		$query_string =
			"SELECT t.* FROM test t, specimen sp ".
			"WHERE t.specimen_id=sp.specimen_id ".
			"AND sp.patient_id=$patient_id ";
		if(isset($_REQUEST['yf']))
			$query_string .= "AND (sp.date_collected BETWEEN '$date_from' AND '$date_to') ";
		$query_string .= "ORDER BY sp.date_collected DESC";		
	
	}
	
	$resultset = query_associative_all($query_string, $row_count);
	
	if(count($resultset) == 0 || $resultset == null)
		return $retval;
	
	foreach($resultset as $record) {
		$test = Test::getObject($record);
		$hide_patient_name = TestType::toHidePatientName($test->testTypeId);
		
		if( $hide_patient_name == 1 )
					$hidePatientName = 1;
		
		$specimen = get_specimen_by_id($test->specimenId);
		$retval[] = array($test, $specimen, $hide_patient_name);		
	}
	
	return $retval;
}

?>

