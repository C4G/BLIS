<?php
#
# Updates patient profile
# Called via Ajax from patient_profile.php
#

include("../includes/db_lib.php");

# Helper function 
function get_custom_value($custom_field)
{
	# Fetched custom field value from $_REQUEST
	# (Replicated from specimen_add.php)
	$name_prefix = "custom_".$custom_field->id;
	if
	(
		$custom_field->fieldTypeId == CustomField::$FIELD_FREETEXT ||
		$custom_field->fieldTypeId == CustomField::$FIELD_OPTIONS
	)
	{
		return $_REQUEST[$name_prefix];
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

# Execution begins here
$saved_session = SessionUtil::save();

$patient_id = $_REQUEST['patient_id'];
$addl_id = $_REQUEST['addl_id'];
$name = $_REQUEST['name'];
$sex = $_REQUEST['sex'];
$age = $_REQUEST['age'];
$age_param = $_REQUEST['age_param'];
$dob = "";
$partial_dob = "";
$surr_id = $_REQUEST['surr_id'];

if($age_param == 2)
{
	# Age specified in months
	$age *= -1;
}

if(trim($_REQUEST['yyyy']) == "" && trim($_REQUEST['mm'])== "" && trim($_REQUEST['dd']) == "")
{
	$dob = "";
	$partial_dob = "";
}
else if($_REQUEST['pd_ym'] == 1)
{
	# Partial DOB with year-month only
	$dob = "";
	$partial_dob = trim($_REQUEST['yyyy'])."-".trim($_REQUEST['mm']);
}
else if($_REQUEST['pd_y'] == 1)
{
	# Partial DOB with year only
	$dob = "";
	$partial_dob = trim($_REQUEST['yyyy']);
}
else
{
	# Full DOB or age
	$dob = trim($_REQUEST['yyyy'])."-".trim($_REQUEST['mm'])."-".trim($_REQUEST['dd']);
	$partial_dob = "";
}
if(is_nan(intval($age)))
	$age="";
$updated_profile = new Patient();
$updated_profile->patientId = $patient_id;
$updated_profile->addlId = $addl_id;
$updated_profile->name = $name;
$updated_profile->age = $age;
$updated_profile->dob = $dob;
$updated_profile->partialDob = $partial_dob;
$updated_profile->sex = $sex;
$updated_profile->surrogateId = $surr_id;

$flag = update_patient($updated_profile);
# Handle custom fields
$custom_field_list = get_custom_fields_patient();
foreach($custom_field_list as $custom_field)
{
	$custom_value = get_custom_value($custom_field);
	$custom_data = new PatientCustomData();
	$custom_data->fieldId = $custom_field->id;
	$custom_data->fieldValue = $custom_value;
	$custom_data->patientId = $patient_id;
	update_custom_data_patient($custom_data);
}

SessionUtil::restore($saved_session);
echo "1";
?>

