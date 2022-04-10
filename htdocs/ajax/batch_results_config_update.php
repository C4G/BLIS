
<?php
#
# Updates report configuration in DB
# Called via Ajax from lab_config_home.php
#
include("../includes/SessionCheck.php");
include("../includes/db_lib.php");
$lab_config_id = $_REQUEST['location'];
$report_config = new ReportConfig();
$report_config->labConfigId = $lab_config_id;

echo "debugging -> ", $pfield_csv;

# Patient main fields
$patient_main_field_count = 13;
$patient_main_field_map = array();
for($i = 0; $i < $patient_main_field_count; $i++)
{
	//echo $_REQUEST['p_field_12'];
	if(isset($_REQUEST['p_field_'.$i])){
		$patient_main_field_map[$i] = 1;
	}else
		$patient_main_field_map[$i] = 0;
}

$pfield_csv = implode(",", $patient_main_field_map);
echo "debugging -> ", $pfield_csv;

# Update DB with this entry
ReportConfig::updatePfieldsToDb(
	$report_config, 
	$patient_main_field_map
);
echo "true";
?>