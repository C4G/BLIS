<?php
#
# Adds a new custom field entry
# Called via Ajax from cfield_add.php
#

include("../includes/db_lib.php");

$lab_config_id = $_REQUEST['lid'];
$tabletype = $_REQUEST['tabletype'];
$field_name = $_REQUEST['fname'];
$field_type = $_REQUEST['ftype'];
$options_csv = "";
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

$new_entry = new CustomField();
$new_entry->fieldName = $field_name;
$new_entry->fieldTypeId = $field_type;
$new_entry->fieldOptions = $options_csv;

CustomField::addNew($new_entry, $lab_config_id, $tabletype);
FieldOrdering::deleteFieldOrderEntry($lab_config_id, 1);
FieldOrdering::deleteFieldOrderEntry($lab_config_id, 2);
?>