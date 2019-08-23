<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Updates goal TAT values for tests in a lab configuration
# Called via Ajax from lab_config_home.php
#
include("../includes/SessionCheck.php");
include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) ) {
	displayForbiddenMessage();
}

$lab_config_id = $_REQUEST['lid'];
$lab_config = get_lab_config_by_id($lab_config_id);
$test_type_list = $_REQUEST['ttype'];
$tat_value_days_list = $_REQUEST['tat_days'];
$tat_value_hours_list = $_REQUEST['tat_hours'];
$tat_value_mins_list = $_REQUEST['tat_mins'];

$count = 0;
foreach($test_type_list as $test_type_id)
{
	$curr_tat_day_value = $tat_value_days_list[$count];
	$curr_tat_hours_value = $tat_value_hours_list[$count];
	$curr_tat_mins_value = $tat_value_mins_list[$count];

	$curr_tat_day_value = preg_replace("/[^0-9]/" ,"", $curr_tat_day_value);
	$curr_tat_hours_value = preg_replace("/[^0-9]/" ,"", $curr_tat_hours_value);
	$curr_tat_mins_value = preg_replace("/[^0-9]/" ,"", $curr_tat_mins_value);

	$curr_tat_value = 0;

	if(trim($curr_tat_hours_value) != "" ) {
		$curr_tat_value = $curr_tat_hours_value;
	}
	if(trim($curr_tat_day_value) != "" ) {
		$curr_tat_value += $curr_tat_day_value*24;
	}
	if(trim($curr_tat_mins_value) != "" ) {
		$curr_tat_value +=  $curr_tat_mins_value/60;
	}
	if(trim($curr_tat_value) == "")
	{
		# Empty TAT entry
		$count++;
		continue;
	}
	$lab_config->updateGoalTatValue($test_type_id, $curr_tat_value);
	$count++;
}
?>