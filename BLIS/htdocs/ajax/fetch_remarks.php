<?php
#
# Returns remarks (results interpretation) for supplied test type and measure values
# Called via Ajax from results_entry.php
#

include("../includes/db_lib.php");

$lab_config_id = $_REQUEST['lid'];
$lab_config = LabConfig::getById($lab_config_id);
$result_csv = $_REQUEST['values_csv'];
$result_list = explode("_", $result_csv);
$patient_age=$_REQUEST['patient_age'];
$patient_sex=$_REQUEST['patient_sex'];
if($lab_config == null)
{
	# Lab configuration not found
	echo "-";
	return;
}


$test_type_id = $_REQUEST['ttype'];
$test_type = TestType::getById($test_type_id);

if($test_type == null)
{
	# Test type entry not found
	echo "-";
	return;
}

$measure_list = $test_type->getMeasures();
$count = 0;
$retval = "";
foreach($measure_list as $measure)
{ 
	$range_values = $measure->getRangeValues();
	if(trim($result_list[$count]) == "")
	{
		$count++;
		continue;
	}
	$remarks_value = "";
	$range_type = $measure->getRangeType();
	
	if($range_type == Measure::$RANGE_NUMERIC)
	{
		$interpretation=$measure->getNumericInterpretation();
		if(0)//$interpretation==NULL)
		{
			$interpretation=$measure->getInterpretation();
			foreach($interpretation as $inter)
			{
			if($inter=="")
			$remarks_value = "-";
			else
				{
				$split=explode("**",$inter);
				$range_l=$split[0];
				$range_u=$split[1];
				if(($result_list[$count]>=$range_l) &&($result_list[$count]<=$range_u))
					{
					$remarks_value=$split[2];
					break;
					}
				if($i == count($interpretation))
				$remarks_value = "-";
	
				}
				}
		}else{
			foreach($interpretation as $inter)
			{
				if($inter[4]=="B")
				{
					if(($result_list[$count]>=$inter[0]) &&($result_list[$count]<=$inter[1]) && ($patient_age>=$inter[2]) &&($patient_age<=$inter[3]))
					{
					$remarks_value=$inter[5];
					break;
					}
				}else{
						if($inter[4]==$patient_sex)
						{
							if(($result_list[$count]>=$inter[0]) &&($result_list[$count]<=$inter[1]) && ($patient_age>=$inter[2]) &&($patient_age<=$inter[3]))
						{
						$remarks_value=$inter[5];
						break;
						}						
	
						}
					}
			}
	
	}
	$retval .= $remarks_value;
	}
	// {
		// if($remarks_map == null)
			// continue;
		// foreach($remarks_map as $range=>$interpretation)
		// {
			// $range_bounds = explode(":", $range);
			// if($range_bounds[0] == "-" && $result_list[$count] <= $range_bounds[1])
			// {
				// $remarks_value = $interpretation;
				// break;
			// }
			// else if($range_bounds[1] == "+" && $result_list[$count] >= $range_bounds[0])
			// {
				// $remarks_value = $interpretation;
				// break;
			// }
			// else if($result_list[$count] >= $range_bounds[0] == "+" && $result_list[$count] <= $range_bounds[1])
			// {
				// $remarks_value = $interpretation;
				// break;
			// }
		// }
		// $retval .= $remarks_value;
	// }
	else 
	if($range_type == Measure::$RANGE_OPTIONS)
	{
		$range_values = $measure->getRangeValues();
		$interpretation=$measure->getInterpretation();
		for($i = 0;$i < count($range_values); $i++)
			if($range_values[$i]==$result_list[$count])
			{
				$remarks_value=$interpretation[$i];
				break;
			}
		if($i == count($range_values))
			$remarks_value = "-";
		$retval .= $remarks_value;
	}
	else if($range_type == Measure::$RANGE_AUTOCOMPLETE)
	 {
		$range_values = $measure->getRangeValues();
		$interpretation=$measure->getInterpretation();
		$values=explode(",",$result_list[$count]);
		foreach($values as $value)
		{
		for($i = 0;$i < count($range_values); $i++)
			 if($range_values[$i]==$value)
			 {
				 $remarks_value=$interpretation[$i];
				 break;
			 }
		 if($i == count($range_values))
			 $remarks_value = $remarks_values[$i];
	// if(count($values)==2)
	// $retval .= $remarks_value;
	// else 
	$retval .= $remarks_value .", ";
	}
	if(count($measure_list)==1 )//|| $==count($values)-1)
	$retval=substr($retval , 0,-4);
	 else
	$retval=substr($retval , 0,-2);
	}
	if(count($measure_list) != 1 && $count < count($measure_list)-1 && trim($remarks_value) != "")
	$retval .= ", ";
	$count++;
}
echo $retval;
?>
