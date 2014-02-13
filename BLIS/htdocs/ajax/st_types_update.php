
<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Updates specimen and tests added to a lab configuration
# Called via Ajax from lab_config_home.php
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList))
    && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList))
    && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) ) {
	displayForbiddenMessage();
}

$lab_config_id = $_REQUEST['lid'];
$specimen_type_list = get_specimen_types_catalog($lab_config_id);
$test_type_list = get_test_types_catalog($lab_config_id);
$updated_specimen_list = array();
$updated_test_list = array();
$lab_config = LabConfig::getById($lab_config_id);
if($lab_config == null)
	return;
foreach($specimen_type_list as $key=>$value)
{
	$field_tocheck = "s_type_".$key;
	if(isset($_REQUEST[$field_tocheck]))
	{
		$updated_specimen_list[]  = $key;
	}
}
foreach($test_type_list as $key=>$value)
{
	$field_tocheck = "t_type_".$key;
	if(isset($_REQUEST[$field_tocheck]))
	{
		$updated_test_list[]  = $key;
	}
}
update_lab_config($lab_config, $updated_specimen_list, $updated_test_list);
# Generate initial worksheet configs if missing
$lab_config->worksheetConfigGenerate();

# Check if disease report has already been configured.
## If not, add new entries
$site_settings = new DiseaseReport();
$site_settings->labConfigId = $lab_config_id;
$site_settings->testTypeId = 0;
$site_settings->measureId = 0;
$site_settings->groupByGender = 1;
$site_settings->groupByAge = 0;
$site_settings->ageGroups = "";
$site_settings->measureGroups = "";
$existing_settings = DiseaseReport::getByKeys($site_settings->labConfigId, $site_settings->testTypeId, $site_settings->measureId);
if($existing_settings == null)
{
	$site_settings->addToDb();
}	
$selected_test_list = $lab_config->getTestTypes();
foreach($selected_test_list as $test_type)
{
	$site_settings->testTypeId = $test_type->testTypeId;
	$measure_list = $test_type->getMeasures();
	foreach($measure_list as $measure)
	{
		$site_settings->measureId = $measure->measureId;
		$site_settings->measureGroups = $measure->range;
		if(strpos($site_settings->measureGroups, "/") === true)
		{
			# Alphanumeric options: Do not add new entry
			continue;
		}
		$existing_settings = DiseaseReport::getByKeys($site_settings->labConfigId, $site_settings->testTypeId, $site_settings->measureId);
		if($existing_settings == null)
			$site_settings->addToDb();
	}
}

?>