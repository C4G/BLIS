<?php
#
# Main page for updating test type info
# Called via Ajax from test_type_edit.php
#

include("../includes/db_lib.php");
include("../lang/lang_xml2php.php");

//print_r($_REQUEST);

$test_type_id = $_REQUEST['tid'];
$cat_code = $_REQUEST['cat_code'];
$measures_to_delete = array();
$reference_ranges_list = array();
$measures_to_retain = array();

if($_REQUEST['cat_code'] == -1)
{
	# Add new test category to catalog
	$new_cat_name = $_REQUEST['new_category'];
	$new_cat_id = add_test_category($new_cat_name);
	$cat_code = $new_cat_id;
}
$updated_entry = new TestType();
$updated_entry->testTypeId = $_REQUEST['tid'];
$updated_entry->name = $_REQUEST['name'];
$updated_entry->description = $_REQUEST['description'];
$updated_entry->testCategoryId = $cat_code;
# Update tests measures and ranges
$is_panel = false;
$added_measures_list = array();
if($_REQUEST['ispanel'] == 1)
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
	# Non-panel test. Collect all modified measures
	$measure_ids = $_REQUEST['m_id'];
	$measure_names = $_REQUEST['measure'];
	$measure_types = $_REQUEST['mtype'];
	$units = $_REQUEST['unit'];
	for($i = 0; $i < count($measure_names);$i++)
	{
		if($measure_names[$i] == "")
		{
			# Mark for deletion
			$measures_to_delete[] = $measure_ids[$i];
			continue;
		}
		$measure_name = $measure_names[$i];
		$range_string = "";
		$measure_id = $measure_ids[$i];
		$reference_ranges_list[$i] = array();
		if($measure_types[$i] == Measure::$RANGE_NUMERIC)
		{
			# Numeric range
			# Clear existing ref ranges			
			ReferenceRange::deleteByMeasureId($measure_id, $_SESSION['lab_config_id']);
			# Check if new reference values and age ranges have been entered properly
			$ranges_lower = $_REQUEST['range_l_'.($i+1)];
			$ranges_upper = $_REQUEST['range_u_'.($i+1)];
			for($j = 0; $j < count($ranges_lower); $j++)
			{
				$lower_range = $ranges_lower[$j];
				$upper_range = $ranges_upper[$j];
				$lower_age = 0;
				$upper_age = 0;
				if(isset($_REQUEST["agerange_l_".($i+1)."_".$j]))
				{
					# Age range specified for this reference range
					$lower_age = $_REQUEST["agerange_l_".($i+1)."_".$j];
					$upper_age = $_REQUEST["agerange_u_".($i+1)."_".$j];
					if($lower_age > $upper_age)
					{
						# Swap
						list($lower_age, $upper_age) = array($upper_age, $lower_age);
					}
				}
				$gender_option = $_REQUEST["bygender_".($i+1)."_".$j];
				$reference_ranges_list[$i][] = array($lower_range, $upper_range, $lower_age, $upper_age, $gender_option);
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
			# Autocomplete values
			$option_values = $_REQUEST['autocomplete_'.($i+1)];
			# Check if options entered properly
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
		# Existing measure
		# Update measure to DB
		$measure = Measure::getById($measure_ids[$i]);
		$measure->name = $measure_name;
		$measure->range = $range_string;
		$measure->unit = $unit;
		# Update measure entry DB
		$measure->updateToDb();
		$measures_to_retain[] = $measure_ids[$i];
	}
	
	# Non-panel test. Collect all newly added measures
	$count_ref = count($reference_ranges_list);
	$new_measures_list = array();
	$measure_names = $_REQUEST['new_measure'];
	$measure_types = $_REQUEST['new_mtype'];
	$ranges_lower = $_REQUEST['new_range_l'];
	$ranges_upper = $_REQUEST['new_range_u'];
	$units = $_REQUEST['new_unit'];
	for($i = 0; $i < count($measure_names);$i++)
	{
		if(trim($measure_names[$i]) == "")
			continue;
		$reference_ranges_list[$count_ref] = array();
		$measure_name = $measure_names[$i];
		$range_string = "";
		if($measure_types[$i] == Measure::$RANGE_NUMERIC)
		{
			# Numeric range
			# Check is range values entered properly
			for($j = 0; $j < count($ranges_lower); $j++)
			{
				$lower_range = $ranges_lower[$j];
				$upper_range = $ranges_upper[$j];
				$lower_age = 0;
				$upper_age = 0;
				if(isset($_REQUEST["new_agerange_l_".($i+1)."_".$j]))
				{
					# Age range specified for this reference range
					$lower_age = $_REQUEST["new_agerange_l_".($i+1)."_".$j];
					$upper_age = $_REQUEST["new_agerange_u_".($i+1)."_".$j];
					if($lower_age > $upper_age)
					{
						# Swap
						list($lower_age, $upper_age) = array($upper_age, $lower_age);
					}
				}
				$gender_option = $_REQUEST["new_bygender_".($i+1)."_".$j];
				$reference_ranges_list[$count_ref][] = array($lower_range, $upper_range, $lower_age, $upper_age, $gender_option);
			}
			$range_string = ":";
		}
		else if($measure_types[$i] == Measure::$RANGE_OPTIONS)
		{
			# Alphanumeric values
			$option_values = $_REQUEST['new_alpharange_'.($i+1)];
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
			# Autocomplete values
			$option_values = $_REQUEST['new_autocomplete_'.($i+1)];
			# Check if options entered properly
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
		# Add measure to DB
		$new_measure_id = add_measure($measure_name, $range_string, $unit);
		$new_measures_list[] = $new_measure_id;
		$measures_to_retain[]  = $new_measure_id;
		$count_ref++;
	}
	# Add entries for newly listed/measures to 'test_type_measure' map table
	for($i = 0; $i < count($new_measures_list); $i += 1)
	{
		$measure_id = $new_measures_list[$i];
		add_test_type_measure($test_type_id, $measure_id);
	}	
}

# Fetch compatible specimen types
$specimen_list = array();
$catalog_specimen_list = get_specimen_types_catalog();
foreach($catalog_specimen_list as $specimen_typeid=>$specimen_name)
{
	if(isset($_REQUEST['s_type_'.$specimen_typeid]))
	{
		$specimen_list[] = $specimen_typeid;
	}
}
update_test_type($updated_entry, $specimen_list);

# Add entries for newly listed/measures to 'test_type_measure' map table
if($_REQUEST['ispanel'] == 1)
{
	for($i = 0; $i < count($added_measures_list); $i += 1)
	{
		$measure_id = $added_measures_list[$i];
		add_test_type_measure($test_type_id, $measure_id);
	}
}

//print_r($measures_to_retain);
//print_r($reference_ranges_list);
# Add ref ranges for retained and new measures
$measure_count = 0;
foreach($reference_ranges_list as $range_list)
{
	$measure_id = $measures_to_retain[$measure_count];
	if($measure_id == "")
		continue;
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

# Remove measure entries marked for deletion
foreach($measures_to_delete as $measure_id)
{
	# Disabled for version 0.8.4.
	# TODO: Check existing result values before deleting a measure
	//delete_test_type_measure($test_type_id, $measure_id);
}
# Update locale XML and generate PHP list again.
if($CATALOG_TRANSLATION === true)
	update_testtype_xml($updated_entry->testTypeId, $updated_entry->name);
?>