<?php
#
# Main page for updating aggregate (disease) report settings
# Called via Ajax from lab_config_home.php
#

include("../includes/db_lib.php");

$disease_report = new DiseaseReport();
$disease_report->labConfigId = $_REQUEST['lab_config_id'];
if($_REQUEST['rage'] == 'y')
{
	# Group by age slots enabled
	$disease_report->groupByAge = 1;
	$age_lower_list = $_REQUEST['age_l'];
	$age_upper_list = $_REQUEST['age_u'];
	$age_slot_string = "";
	for($i = 0; $i < count($age_lower_list); $i++)
	{
		if
		(
			trim($age_lower_list[$i]) === "" || 
			trim($age_upper_list[$i]) === "" || 
			is_nan($age_lower_list[$i]) ||
			(trim($age_upper_list[$i]) != "+" && is_nan($age_upper_list[$i]))
		)
		{
			# Invalid/empty age slot: Ignore
			continue;
		}
		$age_slot_string .= $age_lower_list[$i].":".$age_upper_list[$i];
		if($i < count($age_lower_list) - 1)
		{
			$age_slot_string .= ",";
		}
	}
	$disease_report->ageGroups = $age_slot_string;
}
else 
{
	# Group by age slots not selected
	$disease_report->groupByAge = 0;
	$disease_report->ageGroups = null;
}

if($_REQUEST['rgender'] == 'y')
{
	# Group by gender enabled
	$disease_report->groupByGender = 1;
}
else
{
	# Group by gender not selected
	$disease_report->groupByGender = 0;
}

# Insert dummy record with (lab_config_id, 0, 0) for site-wide settings of all test types.
# Can be removed later if group_by_gender and group_by_age settings need to be test-specific.
$disease_report->testTypeId = 0;
$disease_report->measureId = 0;
$disease_report->measureGroups = "";
$disease_report->addToDb();

# For each test type
## Fetch range slots for each measure and update in DB
$test_list = $_REQUEST['ttypes'];
foreach($test_list as $test_type_id)
{
	$disease_report->testTypeId = $test_type_id;
	$test_type = TestType::getById($test_type_id);
	$measure_list = $test_type->getMeasureIds();
	foreach($measure_list as $measure_id)
	{
		$slot_string = "";
		# Fetch measure slot values
		$disease_report->measureId = $measure_id;
		$lower_field_name = "slotl_".$test_type_id."_".$measure_id;
		$upper_field_name = "slotu_".$test_type_id."_".$measure_id;
		if(!isset($_REQUEST[$lower_field_name]))
			continue;
		$slot_lower_list = $_REQUEST[$lower_field_name];
		$slot_upper_list = $_REQUEST[$upper_field_name];
		for($i = 0; $i < count($slot_lower_list); $i++)
		{
			$slot_string .= $slot_lower_list[$i].":".$slot_upper_list[$i].",";
		}
		$disease_report->measureGroups = $slot_string;
		$disease_report->addToDb();
	}
}
?>