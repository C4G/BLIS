
<?php
#
# Updates report configuration in DB
# Called via Ajax from lab_config_home.php
#

include("../includes/db_lib.php");
$lab_config_id = $_REQUEST['location'];
$report_id = $_REQUEST['report_id'];
$report_config = new ReportConfig();
$report_config->labConfigId = $lab_config_id;
$report_config->reportId = $report_id;
$report_config->testTypeId = $_REQUEST['t_type'];


$report_config->rowItems = $_REQUEST['row_items'];
if($_REQUEST['show_border']=='Y')
	$report_config->showBorder = true;
else
	$report_config->showBorder = false;
	
if($_REQUEST['show_rborder']=='Y')
	$report_config->showResultBorder = true;
else
	$report_config->showResultBorder = false;
	
if($_REQUEST['result_box_hori']=='Y')
	$report_config->resultborderHorizontal = true;
else
	$report_config->resultborderHorizontal = false;
	
if($_REQUEST['result_box_vert']=='Y')
	$report_config->resultborderVertical = true;
else
	$report_config->resultborderVertical = false;
	

if($_REQUEST['do_landscape'] == 'Y')
	$report_config->landscape = true;
else
	$report_config->landscape = false;

if($_REQUEST['Clinical_Data'] == 'Y')
	$ClinicalData = 1;
else
	$ClinicalData = 0;
$name="../../logo_".$lab_config_id.".jpg";
# Header text
$align_header=array();
$align_header[0]=db_escape($_REQUEST['header']);
$align_header[1]=$_REQUEST['align'];

$report_config->headerText = db_escape(implode("??",$align_header));
$testType = TestType::getById($_REQUEST['t_type']);
$testName = $testType->name;
$title_text = "";
$count = 0;
foreach($_REQUEST['title'] as $title_line)
{
	$count++;
	$title_text .= $title_line;
	if($count < count($_REQUEST['title']))
		$title_text .= "<br>";
}
move_uploaded_file($_FILES["file"]["tmp_name"],$name);
$report_config->titleText = db_escape($title_text);
# Footer text

$report_config->footerText = db_escape($_REQUEST['footer']);
$report_config->designation=db_escape($_REQUEST['designation']);
# Margins
$margin_top = 0;
$margin_bottom = 0;
$margin_left = 0;
$margin_right = 0;
if
(
	trim($_REQUEST['margin_top']) != "" &&
	! is_nan($_REQUEST['margin_top'])
)
$margin_top = trim($_REQUEST['margin_top']);
if
(
	trim($_REQUEST['margin_bottom']) != "" &&
	! is_nan($_REQUEST['margin_bottom'])
)
$margin_bottom = trim($_REQUEST['margin_bottom']);
if
(
	trim($_REQUEST['margin_left']) != "" &&
	! is_nan($_REQUEST['margin_left'])
)
$margin_left = trim($_REQUEST['margin_left']);
if
(
	trim($_REQUEST['margin_right']) != "" &&
	! is_nan($_REQUEST['margin_right'])
)
$margin_right = trim($_REQUEST['margin_right']);
$margin_csv = $margin_top.",".$margin_bottom.",".$margin_left.",".$margin_right;

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

# Specimen main fields
$specimen_main_field_count = 7;
$specimen_main_field_map = array();
for($i = 0; $i < $specimen_main_field_count; $i++)
{
	if(isset($_REQUEST['s_field_'.$i]))
		$specimen_main_field_map[$i] = 1;
	else
		$specimen_main_field_map[$i] = 0;
}

# Test main fields
$test_main_field_count = 9;
$test_main_field_map = array();
for($i = 0; $i < $test_main_field_count; $i++)
{
	if(isset($_REQUEST['t_field_'.$i]))
		$test_main_field_map[$i] = 1;
	else
		$test_main_field_map[$i] = 0;
}
$test_main_field_map[9]=$ClinicalData;
# Custom fields (patients and specimens)
$patient_custom_field_map = array();
$specimen_custom_field_map = array();
foreach($_REQUEST as $key=>$value)
{
	if(strpos($key, "p_custom_") !== false)
	{
		$key_parts = explode("_", $key);
		$patient_custom_field_map[] = $key_parts[2];
	}
	else if(strpos($key, "s_custom_") !== false)
	{
		$key_parts = explode("_", $key);
		$specimen_custom_field_map[] = $key_parts[2];
	}
}

if($report_config->reportId == 1){
	# Test main fields
	if(isset($_REQUEST['f_field_0']))
		$report_config->useRequesterName = 1;
	else
		$report_config->useRequesterName = 0;
	
	if(isset($_REQUEST['f_field_1']))
		$report_config->useReferredTo = 1;
	else
		$report_config->useReferredTo = 0;
	
	
	
}
# Update DB with this entry
ReportConfig::updateToDb(
	$report_config, 
	$margin_csv, 
	$patient_main_field_map, 
	$specimen_main_field_map, 
	$test_main_field_map, 
	$patient_custom_field_map, 
	$specimen_custom_field_map
);
echo "true";
?>