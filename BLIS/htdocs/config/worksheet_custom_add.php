<?php
#
# Adds a new custom worksheet to DB
# Called via POST from worksheet_custom_new.php
#

include("redirect.php");
include("includes/db_lib.php");

$saved_session = SessionUtil::save();

$lab_config_id = $_REQUEST['location'];
$lab_config = LabConfig::getById($lab_config_id);

$DEFAULT_COLUMN_WIDTH = 5; # (in %)

$worksheet = new CustomWorksheet();
$worksheet->name = db_escape($_REQUEST['wname']);
$worksheet->headerText = db_escape($_REQUEST['header']);
$worksheet->titleText = db_escape($_REQUEST['title']);
$worksheet->footerText = db_escape($_REQUEST['footer']);

$worksheet->margins = array();
$worksheet->margins[ReportConfig::$TOP] = $_REQUEST['margin_top'];
$worksheet->margins[ReportConfig::$BOTTOM] = $_REQUEST['margin_bottom'];
$worksheet->margins[ReportConfig::$LEFT] = $_REQUEST['margin_left'];
$worksheet->margins[ReportConfig::$RIGHT] = $_REQUEST['margin_right'];

$worksheet->testTypes = array();
$worksheet->columnWidths = array();

$worksheet->idFields = array();
$worksheet->idFields[CustomWorksheet::$OFFSET_PID] = 0;
$worksheet->idFields[CustomWorksheet::$OFFSET_DNUM] = 0;
$worksheet->idFields[CustomWorksheet::$OFFSET_ADDLID] = 0;
if($_REQUEST['is_pid'] == 'Y')
{
	$worksheet->idFields[CustomWorksheet::$OFFSET_PID] = 1;
}
if($_REQUEST['is_dnum'] == 'Y')
{
	$worksheet->idFields[CustomWorksheet::$OFFSET_DNUM] = 1;
}
if($_REQUEST['is_addlid'] == 'Y')
{
	$worksheet->idFields[CustomWorksheet::$OFFSET_ADDLID] = 1;
}

foreach($_REQUEST as $key=>$value)
{
	if(strpos($key, "ttype_") !== false)
	{
		$param_parts = explode("_", $key);
		$test_type_id = $param_parts[1];
		if(in_array($test_type_id, $worksheet->testTypes) === false)
		{
			$worksheet->testTypes[] = $test_type_id;
		}
		if(array_key_exists($test_type_id, $worksheet->columnWidths) === false)
		{
			$worksheet->columnWidths[$test_type_id] = array();
		}
		$test_type = TestType::getById($test_type_id);
		$measure_list = $test_type->getMeasures();
		foreach($measure_list as $measure)
		{
			$measure_id = $measure->measureId;
			$width_param = $_REQUEST["width_".$test_type_id."_".$measure_id];
			$width_val = $DEFAULT_COLUMN_WIDTH;
			if(is_nan($width_param))
			{
				$width_val = $DEFAULT_COLUMN_WIDTH;
			}
			else
			{
				$width_val = intval($width_param);
			}
			$worksheet->columnWidths[$test_type_id][$measure_id] = $width_val;
		}
	}
}

$worksheet->userFields = array();
$count = 0;
$width_list = $_REQUEST['uf_width'];
foreach($_REQUEST['uf_name'] as $field_name)
{
	if(trim($field_name) == "")
	{
		$count++;
		continue;
	}
	$field_width = $width_list[$count];
	if(trim($field_width) == "" || is_nan($field_width))
	{
		$field_width = CustomWorksheet::$DEFAULT_WIDTH;
	}
	$field_entry = array(0, $field_name, $field_width);
	$worksheet->userFields[] = $field_entry;
	$count++;
}

$worksheet_id = CustomWorksheet::addToDb($worksheet, $lab_config);

SessionUtil::restore($saved_session);

header("location:worksheet_custom_added.php?wid=$worksheet_id&lid=$lab_config->id");
?>