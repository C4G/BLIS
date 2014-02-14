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
	//echo "comment_field"."-".$comment_field_value."<br/>";
	$measure_list = $test_type->getMeasures();
	$result_value_valid = true;
	$result_csv = "";
	$comment_csv = "";
        $submeasure_list = array();
                $comb_measure_list = array();
               // print_r($measure_list);
                
                foreach($measure_list as $measure)
                {
                    
                    $submeasure_list = $measure->getSubmeasuresAsObj();
                    //echo "<br>".count($submeasure_list);
                    //print_r($submeasure_list);
                    $submeasure_count = count($submeasure_list);
                    
                    if($measure->checkIfSubmeasure() == 1)
                    {
                        continue;
                    }
                        
                    if($submeasure_count == 0)
                    {
                        array_push($comb_measure_list, $measure);
                    }
                    else
                    {
                        array_push($comb_measure_list, $measure);
                        foreach($submeasure_list as $submeasure)
                           array_push($comb_measure_list, $submeasure); 
                    }
                }
                $measure_list = $comb_measure_list;
                $comment_value = "";
                //$test = 1;
	foreach($measure_list as $measure)
	{
		$result_field_name = 'result_'.$test_type->testTypeId."_".$measure->measureId;
		$comment_field_name = 'comments_'.$test_type->testTypeId."_".$measure->measureId;
		
		echo $result_field_name.'='.$_REQUEST[$result_field_name];
		//$test++;
		$result_value = $_REQUEST[$result_field_name];
		$comment_value = $_REQUEST[$comment_field_name];
		if( trim($result_value) == "" ) 
		{
			# Result value not provided / is empty:
			# Do not update result value
			//echo " : Not Savable Field "."<br/>";
			$result_value_valid = false;
			$result_csv .=",";
		}
		else { 
			/*if ( strstr($result_value, ",") ) 
				$result_csv .= str_replace(",","_",$result_value);
			else
				$result_csv .= $result_value."_";
                         */
			$result_value_valid = true;
			//echo " : Savable Field "."<br/>";
			        $range_typee = $measure->getRangeType();
                    if($range_typee == Measure::$RANGE_FREETEXT)
                    {
                        $result_csv = $result_csv."[$]".$result_value."[/$]_";
                    }
                   // else if($range_typee == Measure::$RANGE_AUTOCOMPLETE)
                   // {
                  //      $result_csv = $result_csv.$result_value;
                    //}
                    else
                    {
						if ( strstr($result_value, ",") ) 
							$result_csv .= str_replace(",","_",$result_value);
						else
							$result_csv .= $result_value."_";					
                        //$result_csv = $result_csv.$result_value."_";
                    }
                         
		}	
		# replace last underscore with "," to separate multiple measures results
		
		$result_csv = substr($result_csv, 0, strlen($result_csv) - 1);
		$result_csv .= ",";
		//echo "<br/> === ".$result_csv. " ===>".$result_value_valid."<br/>";
		if ( $comment_value != "None" &&  $comment_value != "") {
                    if($measure->checkIfSubmeasure() == 1)
                                    {
                                        $decName = $measure->truncateSubmeasureTag();
                                       
                                    }
                                    else
                                    {
					$decName = $measure->getName();
                                    }
			$comment_csv .= $decName.":".$comment_value.", ";
		}
	}
	// if at least one element present that can be saved
	$result_csv_elements_present = explode(",",$result_csv);
	if(count($result_csv_elements_present)>0){
		$result_value_valid = true;
	}
	if($result_value_valid === true)
	{
		$result_csv .= ",";
		$comment_csv = substr($comment_csv,0,strlen($comment_csv)-2); //Remove the extra comma and space at the end
		$comment_csv = preg_replace("/[^a-zA-z0-9,+.;:_\s]/", "", $comment_csv);
		# Update verified results to DB
                //NC3065
		//$result_csv = preg_replace("/[^a-zA-Z0-9,+.;:_\s]/", "", $result_csv);
                //-NC3065
				
		//echo $comment_csv; exit;
		
		//echo "<br/>Result CSV ".$result_csv;exit;
		if($test_entry->result == "")
		{
			# Test result not yet entered
			# Add these results to DB
			$test_entry->result = $result_csv;
			$test_entry->comments = $comment_csv;
			$test_entry->userId = $_SESSION['user_id'];
			$test_entry->addResult($patient->getHashValue());
			echo "TEST";
		}
		else
		{
			# Existing results to be verified
			$test_entry->result = $result_csv;
			$test_entry->comments = $comment_csv;
			$test_entry->verifiedBy = $_SESSION['user_id'];
			$test_entry->dateVerified = date("Y-m-d H:i:s");
			$test_entry->verifyAndUpdate($patient->getHashValue());
			echo "TEST";
		}
	} else {
		echo "TEST";
	}
}
header("Location: specimen_info.php?sid=$specimen_id&re=1");
?>