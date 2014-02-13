<?php
#
# Main page for adding custom data values for patients
# Called via Ajax from find_patient.php
#

include("../includes/db_lib.php");

$saved_session = SessionUtil::save();

# Helper function 
function get_custom_value($custom_field)
{
	# Fetched custom field value from $_REQUEST
	# (Replicated from specimen_add.php)
	$name_prefix = "custom_".$custom_field->id;
	if
	(
		$custom_field->fieldTypeId == CustomField::$FIELD_FREETEXT ||
		$custom_field->fieldTypeId == CustomField::$FIELD_OPTIONS || 
		$custom_field->fieldTypeId == CustomField::$FIELD_NUMERIC
	)
	{
		return $_REQUEST[$name_prefix];
	}
	else if($custom_field->fieldTypeId == CustomField::$FIELD_MULTISELECT)
	{
		$retval = "";
		$value_list = $_REQUEST[$name_prefix];
		$count = 0;
		foreach($value_list as $value)
		{
			$retval .= $value;
			$count++;
			if($count < count($value_list))
			{
				$retval .= ", ";
			}
		}
		return $retval;
	}
	else if($custom_field->fieldTypeId == CustomField::$FIELD_DATE)
	{
		$value_yyyy = $name_prefix."_yyyy";
		$value_mm = $name_prefix."_mm";
		$value_dd = $name_prefix."_dd";
		$date_value = $_REQUEST[$value_yyyy]."-".$_REQUEST[$value_mm]."-".$_REQUEST[$value_dd];
		return $date_value;
	}
}

$patient_id = $_REQUEST['pid2'];
$custom_field_list = get_custom_fields_patient();
foreach($custom_field_list as $custom_field)
{
	$custom_value = get_custom_value($custom_field);
	$custom_data = new PatientCustomData();
	$custom_data->fieldId = $custom_field->id;
	$custom_data->fieldValue = $custom_value;
	$custom_data->patientId = $patient_id;
	add_custom_data_patient($custom_data);
}
SessionUtil::restore($saved_session);
?>