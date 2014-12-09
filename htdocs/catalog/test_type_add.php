<?php
#
# Adds a new test type to catalog in DB
#
include("redirect.php");
include("includes/db_lib.php");
include("lang/lang_xml2php.php");


putUILog('test_type_add', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


$test_name = $_REQUEST['test_name'];
$cat_code = $_REQUEST['cat_code'];
$hide_patient_name = $_REQUEST['hidePatientName'];
$prevalenceThreshold=$_REQUEST['prevalenceThreshold'];
$targetTat=$_REQUEST['targetTat'];

if (is_billing_enabled($_SESSION['lab_config_id'])) {
    $cost_cents_initial = $_REQUEST['cost_to_patient_cents'];
    $cost_cents = $cost_cents_initial / pow(10, strlen($cost_cents_initial));

    $newCostToPatient = $_REQUEST['cost_to_patient_dollars'] + $cost_cents;
}
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

$added_submeasures_list = array();
$sub_reference_ranges_list = array();

$us = '_';
$is_panel = false;
$r = 0;
$scc = 0;
$ccc = 0;
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

        $submeasure_names = $_REQUEST['submeasure'];
	$submeasure_types = $_REQUEST['smtype'];
        $subunits = $_REQUEST['sunit'];
	
        $do_once = 1;
        $measures_count = count($measure_names);
        $i = 0;
        //for($i = 0; $i < count($measure_names); $i++)
	while ($i < $measures_count)
        {
                    if($measure_names[$i] == "")
                    {
                        $i++;
                        continue;
                    }
                    $ranges_lower = $_REQUEST['range_l_'.($i+1)];
                    $ranges_upper = $_REQUEST['range_u_'.($i+1)];
                    $reference_ranges_list[$ccc] = array();
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
                            $reference_ranges_list[$ccc][]= array($lower, $upper , $lower_age , $upper_age, $gender_option);
                            }
                            $index++;


                                    //$reference_ranges_list[$i][] = array($lower_range, $upper_range, $lower_age, $upper_age, $gender_option);
                            }
                            //	$range_string = trim($ranges_lower[$i]).":".trim($ranges_upper[$i]);
							
							//print_r($reference_ranges_list);exit;
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
                    else if($measure_types[$i] == Measure::$RANGE_FREETEXT)
                    {
                            # Free text measure type
                            $range_string = "\$freetext\$\$";
                    }
                    $unit = $units[$i];
                    //# Add measure to DB and track the ID (key)

                    $added_measures_list[$ccc] = add_measure($measure_name, $range_string, $unit);
                    $ccc++;
            
                $submeasure_tag = "\$sub*".$added_measures_list[$i]."/$";
                $submeasures_count = count($submeasure_names[$i+1]);
                $k = 0;
                while($k < $submeasures_count)
                {
                                            $sam = 91;

                    if($submeasure_names[$i+1][$k] == "")
                    {
                        $k++;
                        continue;
                    }
                    $sam = 99;
                    $ranges_lower = $_REQUEST['range_l_'.($i+1).$us.($k+1)];
                    $ranges_upper = $_REQUEST['range_u_'.($i+1).$us.($k+1)];
                    $sub_reference_ranges_list[$scc] = array();
                    $measure_name = $submeasure_tag.$submeasure_names[$i+1][$k];
                    $range_string = "";
                    if($submeasure_types[$i+1][$k] == Measure::$RANGE_NUMERIC)
                    {
                    $index=0;
                    $age_upper = $_REQUEST['agerange_u_'.($i+1).$us.($k+1)];
                    $age_lower = $_REQUEST['agerange_l_'.($i+1).$us.($k+1)];
                    $gender = $_REQUEST['gender_'.($i+1).$us.($k+1)];
                            foreach($ranges_lower as $lower)

                            {
                            $upper=$ranges_upper[$index];
                            if($upper!=$lower)
                            {
                            $lower_age = $age_lower[$index];
                            $upper_age = $age_upper[$index];
                            $gender_option=$gender[$index];
                            $sub_reference_ranges_list[$scc][] = array($lower, $upper , $lower_age , $upper_age, $gender_option);
                            }
                            $index++;


                                    //$reference_ranges_list[$i][] = array($lower_range, $upper_range, $lower_age, $upper_age, $gender_option);
                            }
                            //	$range_string = trim($ranges_lower[$i]).":".trim($ranges_upper[$i]);
                            $range_string = ":";
                    }
                    else if($submeasure_types[$i+1][$k] == Measure::$RANGE_OPTIONS)
                    {
                            # Alphanumeric values
                            $option_values = $_REQUEST['alpharange_'.($i+1).$us.($k+1)];
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
                    else if($submeasure_types[$i+1][$k] == Measure::$RANGE_AUTOCOMPLETE)
                    {
                            # Autocomplete field
                            $option_values = $_REQUEST['autocomplete_'.($i+1).$us.($k+1)];
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
                    else if($submeasure_types[$i+1][$k] == Measure::$RANGE_FREETEXT)
                    {
                            # Free text measure type
                            $range_string = "\$freetext\$\$";
                    }
                    $unit = $subunits[$i+1][$k];
                    //# Add measure to DB and track the ID (key)

                    $added_submeasures_list[$scc] = add_measure($measure_name, $range_string, $unit);
                    $scc++;
                    $k++;
                }
                $i++;
            }   
                
	
        
        # Store Submeasures
        
}

# Fetch compatible specimen types
$specimen_list = array();
$reff = 1;
$catalog_specimen_list = get_specimen_types_catalog($lab_config_id, $reff);
foreach($catalog_specimen_list as $specimen_typeid=>$specimen_name)
{
	if(isset($_REQUEST['s_type_'.$specimen_typeid]))
	{
		$specimen_list[] = $specimen_typeid;
	}
}

# Add test type record
//function add_test_type($test_name, $test_descr, $clinical_data, $cat_code, $is_panel, $specimen_list=array(), $lab_config_id, $hide_patient_name)
$test_type_id = "";
if(count($specimen_list) != 0)
{
	# Add entries to 'specimen_test' map table
	  $test_type_id = add_test_type($test_name, $test_descr, $test_clinical_data, $cat_code, $is_panel, $lab_config_id, $hide_patient_name, $prevalenceThreshold, $targetTat, $specimen_list);
}
else
{
	# No specimens selected. Add test anyway
	  $test_type_id = add_test_type($test_name, $test_descr, $test_clinical_data, $cat_code, $is_panel, $lab_config_id, $hide_patient_name, $prevalenceThreshold, $targetTat);
}

if($newCostToPatient > 0 && is_billing_enabled($_SESSION['lab_config_id'])) { // If the cost is greater than 0, we go ahead and add the cost.  If not, there's no reason to make another sql call here.  It'll be done elsewhere.
    instantiate_new_cost_of_test_type($newCostToPatient, $test_type_id);
}

enable_new_test($_SESSION['lab_config_id'], $test_type_id);
# Merge added_measure_list and added_submeasures_list
$add_measr = $added_measures_list;
$merged_list = array_merge($added_measures_list, $added_submeasures_list);

sort($merged_list);


/*
echo "<br>";
print_r($added_measures_list);
echo "<br>";
print_r($added_submeasures_list);
echo "<br>";
print_r($merged_list);
echo "<br>";
*/

# Add entries for newly listed/measures to 'test_type_measure' map table
for($i = 0; $i < count($merged_list); $i += 1)
{
	$measure_id = $merged_list[$i];
	add_test_type_measure($test_type_id, $measure_id);
}
/*for($i = 0; $i < count($added_submeasures_list); $i += 1)
{
	$measure_id = $added_submeasures_list[$i];
	add_test_type_measure($test_type_id, $measure_id);
}*/
# Add age/genderwise reference ranges for numeric measures
$measure_count = 0;
foreach($reference_ranges_list as $range_list)
{
	$measure_id = $add_measr[$measure_count];
	if(count($range_list) == 0)
	{
            $measure_count++;
		# Not a numeric field
		continue;
	}
	foreach($range_list as $range_entry)
	{
            echo "<br>--".$measure_id;
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

$measure_count = 0;
foreach($sub_reference_ranges_list as $range_list)
{
	$measure_id = $added_submeasures_list[$measure_count];
	if(count($range_list) == 0)
	{
            $measure_count++;
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
/*
echo "<br>Hi".$sam;
echo "<br>";
print_r($submeasure_names);
*/

header("location: test_type_added.php?tn=$test_name");
?>