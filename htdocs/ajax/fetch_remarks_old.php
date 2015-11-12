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

if($lab_config == null)
{
	# Lab configuration not found
	echo "-";
	return;
}

$remarks_file = $LOCAL_PATH."langdata_".$lab_config_id."/remarks.php";
include($remarks_file);
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
	if(trim($result_list[$count]) == "")
	{
		$count++;
		continue;
	}
	$remarks_value = "";
	$range_type = $measure->getRangeType();
	$remarks_map = $REMARKS_ARRAY[$measure->measureId];
	if($range_type == Measure::$RANGE_NUMERIC)
	{
		if($remarks_map == null)
			continue;
		foreach($remarks_map as $range=>$interpretation)
		{
			$range_bounds = explode(":", $range);
			if($range_bounds[0] == "-" && $result_list[$count] <= $range_bounds[1])
			{
				$remarks_value = $interpretation;
				break;
			}
			else if($range_bounds[1] == "+" && $result_list[$count] >= $range_bounds[0])
			{
				$remarks_value = $interpretation;
				break;
			}
			else if($result_list[$count] >= $range_bounds[0] == "+" && $result_list[$count] <= $range_bounds[1])
			{
				$remarks_value = $interpretation;
				break;
			}
		}
		$retval .= $remarks_value;
	}
	else if($range_type == Measure::$RANGE_OPTIONS)
	{
		if(isset($remarks_map[$result_list[$count]]))
			$remarks_value = $remarks_map[$result_list[$count]];
		else
			$remarks_value = "-";
		$retval .= $remarks_value;
	}
	if(count($measure_list) != 1 && $count < count($measure_list)-1 && trim($remarks_value) != "")
		$retval .= ", ";
	$count++;
}
echo $retval;
?>
