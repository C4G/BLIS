<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Updates goal TAT values for tests in a lab configuration
# Called via Ajax from lab_config_home.php
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) ) {
	displayForbiddenMessage();
}

$lab_config_id = $_REQUEST['lid'];
$lab_config = get_lab_config_by_id($lab_config_id);
$test_type_list = $_REQUEST['ttype'];
$tat_value_list = $_REQUEST['tat'];
$tat_unit_list = $_REQUEST['unit'];

$count = 0;
foreach($test_type_list as $test_type_id)
{
	$curr_tat_value = $tat_value_list[$count];
	$curr_tat_value = preg_replace("/[^0-9]/" ,"", $curr_tat_value);
	if(trim($curr_tat_value) == "")
	{
		# Empty TAT entry
		$count++;
		continue;
	}
	if($tat_unit_list[$count] == 2)
	{
		# Multiply by 24 to store in hours
		$curr_tat_value *= 24;
	}
	$lab_config->updateGoalTatValue($test_type_id, $curr_tat_value);
	$count++;
}
?>