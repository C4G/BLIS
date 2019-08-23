<?php
#
# Updates custom field information
# Called via Ajax from cfield_edit.php
#

include("../includes/db_lib.php");
include("../includes/SessionCheck.php");
$field_id = $_REQUEST['id'];
$lab_config_id = $_REQUEST['lid'];
$type = $_REQUEST['t'];
$field_name = $_REQUEST['fname'];
$field_type = $_REQUEST['ftype'];
$options_csv = "";
$enable=$_REQUEST['Enable'];
$flag=$_REQUEST['flag'];
$del=$_REQUEST['Delete'];
$offset=0;
if($flag!=0 && $enable!="enable")
{
$offset=$flag;
}
else if($enable!="enable"&& $flag==0)
{
$offset=$field_id;
}
else if($enable=="enable"&&$flag==0)
$offset=-1;
else if($enable=="enable"&&$flag!=0)
{
$offset=-3;
}

if($enable!="enable")
{
	$field_name=$field_name."^^".$offset;
	if($flag!=0)
	$offset=-2;
}
if($field_type == CustomField::$FIELD_OPTIONS || $field_type == CustomField::$FIELD_MULTISELECT)
{
	# Option-type field
	$options_list = $_REQUEST['option'];
	$count = 0;
	foreach($options_list as $option)
	{
		if($option == "")
		{
			$count++;
			continue;
		}
		$options_csv .= trim($option);
		$count++;
		if($count != count($options_list))
			$options_csv .= "/";
	}
}
else if($field_type == CustomField::$FIELD_NUMERIC)
{
	$range_lower = trim($_REQUEST['range_lower']);
	$range_upper = trim($_REQUEST['range_upper']);
	$unit = trim($_REQUEST['unit']);
	$options_csv = $range_lower.":".$range_upper.":".$unit;
}

$updated_entry = new CustomField();
$updated_entry->id = $field_id;
$updated_entry->fieldTypeId = $field_type;
$updated_entry->fieldName = $field_name;
$updated_entry->fieldOptions = $options_csv;
if($del=="Delete"){
CustomField::deleteById($updated_entry, $lab_config_id, $type);
FieldOrdering::deleteFieldOrderEntry($lab_config_id, 1);
}
else
CustomField::updateById($updated_entry, $lab_config_id, $type, $offset);
?>