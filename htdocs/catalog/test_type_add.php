<?php
#
# Adds a new test type to catalog in DB
#
include("redirect.php");
include("includes/db_lib.php");
include("lang/lang_xml2php.php");


$test_name = $_REQUEST['test_name'];
$cat_code = $_REQUEST['cat_code'];
$hide_patient_name = $_REQUEST['hidePatientName'];
$prevalenceThreshold=$_REQUEST['prevalenceThreshold'];
$targetTat=$_REQUEST['targetTat'];
if($cat_code == -1)
{
	# Add new test category to catalog
	$new_cat_name = $_REQUEST['new_category'];
	$new_cat_id = add_test_category($new_cat_name);
	$cat_code = $new_cat_id;
}
$test_descr = $_REQUEST['test_descr'];
$test_clinical_data=$_REQUEST['clinical_data'];

# Check test type (panel or normal)
$reference_ranges_list = array();
$added_measures_list = array();
$is_panel = false;
if(isset($_REQUEST['ispanel']))
{
	# Panel test. Collect all selected measures
	$is_panel = true;
	$measure_list = get_measures_catalog();
	foreach($measure_list as $measure_id=>$measure_name)
	{
		if(isset($_REQUEST['m_'.$measure_id]))
		{
			# Track the measure ID (key)
			$added_measures_list[] = $measure_id;
		}
	}
}
else
{
	# Non-panel test. Collect all newly entered measures
	$measure_names = $_REQUEST['measure'];
	$measure_types = $_REQUEST['mtype'];
	$units = $_REQUEST['unit'];
	for($i = 0; $i < count($measure_names); $i++)
	{
		if($measure_names[$i] == "")
			continue;
		$ranges_lower = $_REQUEST['range_l_'.($i+1)];
		$ranges_upper = $_REQUEST['range_u_'.($i+1)];
		$reference_ranges_list[$i] = array();
		$measure_name = $measure_names[$i];
		$range_string = "";
		if($measure_types[$i] == Measure::$RANGE_NUMERIC)
		{
		$index=0;
		$age_upper = $_REQUEST['agerange_u_'.($i+1)];
		$age_lower = $_REQUEST['agerange_l_'.($i+1)];
		$gender = $_REQUEST['gender_'.($i+1)];
			foreach($ranges_lower as $lower)
			
			{
			$upper=$ranges_upper[$index];
			if($upper!=$lower)
			{
			$lower_age = $age_lower[$index];
			$upper_age = $age_upper[$index];
			$gender_option=$gender[$index];
			$reference_ranges_list[$i][] = array($lower, $upper , $lower_age , $upper_age, $gender_option);
			}
			$index++;
			
			
				//$reference_ranges_list[$i][] = array($lower_range, $upper_range, $lower_age, $upper_age, $gender_option);
			}
			//	$range_string = trim($ranges_lower[$i]).":".trim($ranges_upper[$i]);
			$range_string = ":";
		}
		else if($measure_types[$i] == Measure::$RANGE_OPTIONS)
		{
			# Alphanumeric values
			$option_values = $_REQUEST['alpharange_'.($i+1)];
			# Check if options entered properly
			$options_entered = false;
			foreach($option_values as $option_value)
			{
				if(trim($option_value) != "")
				{
					$options_entered = true;
					$range_string .= trim($option_value);
					$range_string .= "/";
				}
			}
			if($options_entered === false)
			{
				# Error: Option values not entered properly.
				# TODO:
			}
			# Truncate trailing "/"
			$range_string = substr($range_string, 0, -1);
		}
		else if($measure_types[$i] == Measure::$RANGE_AUTOCOMPLETE)
		{
			# Autocomplete field
			$option_values = $_REQUEST['autocomplete_'.($i+1)];
			$options_entered = false;
			foreach($option_values as $option_value)
			{
				if(trim($option_value) != "")
				{
					$options_entered = true;
					$range_string .= trim($option_value);
					$range_string .= "_";
				}
			}
			if($options_entered === false)
			{
				# Error: Autocomplete values not entered properly.
				# TODO:
			}
			# Truncate trailing "_"
			$range_string = substr($range_string, 0, -1);
		}
		$unit = $units[$i];
		//# Add measure to DB and track the ID (key)
		
		$added_measures_list[] = add_measure($measure_name, $range_string, $unit);
	}
}

# Fetch compatible specimen types
$specimen_list = array();
$catalog_specimen_list = get_specimen_types_catalog($lab_config_id);
foreach($catalog_specimen_list as $specimen_typeid=>$specimen_name)
{
	if(isset($_REQUEST['s_type_'.$specimen_typeid]))
	{
		$specimen_list[] = $specimen_typeid;
	}
}

# Add test type record
$test_type_id = "";
if(count($specimen_list) != 0)
{
	# Add entries to 'specimen_test' map table
	$test_type_id = add_test_type($test_name, $test_descr,$test_clinical_data, $cat_code, $is_panel, $specimen_list , $lab_config_id, $hide_patient_name, $prevalenceThreshold, $targetTat);
}
else
{
	# No specimens selected. Add test anyway
	$test_type_id = add_test_type($test_name, $test_descr,$test_clinical_data, $is_panel, $cat_code ,$lab_config_id, $hide_patient_name, $prevalenceThreshold, $targetTat);
}

# Add entries for newly listed/measures to 'test_type_measure' map table
for($i = 0; $i < count($added_measures_list); $i += 1)
{
	$measure_id = $added_measures_list[$i];
	add_test_type_measure($test_type_id, $measure_id);
}
# Add age/genderwise reference ranges for numeric measures
$measure_count = 0;
foreach($reference_ranges_list as $range_list)
{
	$measure_id = $added_measures_list[$measure_count];
	if(count($range_list) == 0)
	{
		# Not a numeric field
		continue;
	}
	foreach($range_list as $range_entry)
	{
		$range_lower = $range_entry[0];
		$range_upper = $range_entry[1];
		$age_min = $range_entry[2];
		$age_max = $range_entry[3];
		$gender_option = $range_entry[4];
		$ref_range = new ReferenceRange();
		$ref_range->measureId = $measure_id;
		$ref_range->ageMin = $age_min;
		$ref_range->ageMax = $age_max;
		$ref_range->sex = $gender_option;
		$ref_range->rangeLower = $range_lower;
		$ref_range->rangeUpper = $range_upper;
		$ref_range->addToDb($_SESSION['lab_config_id']);
	}
	$measure_count++;
}

# Update locale XML and generate PHP list again.
if($CATALOG_TRANSLATION === true)
	update_testtype_xml($test_type_id, $test_name);

header("location: test_type_added.php?tn=$test_name");
?>