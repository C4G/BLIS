<?php

include "../includes/db_lib.php";
include "../includes/stats_lib.php";
include "../includes/user_lib.php";

//DbUtil::switchToLabConfig($lab_config_id);
// returns total , nrgative and prev threshold
//$test_type_id = $_REQUEST['test_type_id'];
//echo "<pre>";
//$token = $_REQUEST['tok'];
if(!isset($_REQUEST['yf']) || !isset($_REQUEST['mf']) || !isset($_REQUEST['df']) || !isset($_REQUEST['yt']) || !isset($_REQUEST['dt']) || !isset($_REQUEST['mt']) || !isset($_REQUEST['category_code']))
{
    echo -2;
    return;
}
$date_from = $_REQUEST['yf']."-".$_REQUEST['mf']."-".$_REQUEST['df'];
$date_to = $_REQUEST['yt']."-".$_REQUEST['mt']."-".$_REQUEST['dt'];
$cat_code = $_REQUEST['category_code'];

//$result = API::get_prev_rates($test_type_id, $date_from, $date_to);
if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }

            if($lab_config_id == null)
            {
                $lab_config_id = get_lab_config_id_admin($_SESSION['user_id']);
            }

$lab_config = LabConfig::getById($lab_config_id);

$selected_test_ids = $lab_config->getTestTypeIds();
if($cat_code != 0)
{
	# Fetch all tests belonging to this category (aka lab section)
	$cat_test_types = TestType::getByCategory($cat_code);
	$cat_test_ids = array();
	foreach($cat_test_types as $test_type)
	$cat_test_ids[] = $test_type->testTypeId;
	$matched_test_ids = array_intersect($cat_test_ids, $selected_test_ids);
	$selected_test_ids = array_values($matched_test_ids);
}

# Fetch TestType objects using selected test_type_ids.
$selected_test_types = array();
foreach($selected_test_ids as $test_type_id)
{
	$test = TestType::getById($test_type_id);
	$selected_test_types[] = $test;
}

# Fetch site-wide settings
$site_settings = DiseaseReport::getByKeys($lab_config->id, 0, 0);

$age_group_list = $site_settings->getAgeGroupAsList();

if(count($selected_test_types) == 0)
{
	//$rts = 0;
}
$rts = array();
foreach($selected_test_types as $test)
	{
		StatsLib::setDiseaseSetList($lab_config, $test, $date_from, $date_to);
		$measures = $test->getMeasures();
                //print_r($measures);
                
                //echo "<br>";
		foreach($measures as $measure)
		{
			$male_total = array();
			$female_total = array();
			$cross_gender_total = array();
			$curr_male_total = 0;
			$curr_female_total = 0;
			$curr_cross_gender_total = 0;
			$disease_report = DiseaseReport::getByKeys($lab_config->id, $test->testTypeId, $measure->measureId);
			
			if($disease_report == null)
			{
				# TODO: Check for error control
				# Alphanumeric values. Hence entry not found.
				//continue;
				break;
			}
			$is_range_options = true;
			if(strpos($measure->range, "/") === false)
			{
				$is_range_options = false;
			}
			$range_values = array();
			if($is_range_options)
			{
				# Alphanumeric options
				$range_values1 = explode("/", $measure->range);
				$range_values=str_replace("#","/",$range_values1);
				
			}
			else
			{
				# Numeric ranges: Fetch ranges configured for this test-type/measure from DB
				
				$range_values = $disease_report->getMeasureGroupAsList();
			}
			$row_id = "row_".$test->testTypeId."_".$measure->measureId;
			$grand_total = 0;
                        //print_r($range_values);
			?>
			<?php //$rts[$measure->getName()]//echo $measure->getName(); ?>
				
				<?php 
				/*foreach($range_values as $range_value)
				{
					if($is_range_options)
						echo "$range_value<br>";
					else
						echo "$range_value[0]-$range_value[1]<br>";
					if($site_settings->groupByGender == 1)
					{
						echo "<br>";
					}
				}*/
				?>
				<?php
                                /*
				if($site_settings->groupByGender == 1)
				{
					# Group by gender set to true
					echo "<td>";
					for($i = 1; $i <= count($range_values); $i++)
					{
						echo "M<br>F<br>";
					}
				}*/
				if(0)//($site_settings->groupByAge == 1)
				{
					# Group by age set to true: Fetch age slots from DB
					$age_slot_list = $site_settings->getAgeGroupAsList();
					foreach($age_slot_list as $age_slot)
					{
						//echo "<td>";
						$range_value_count = 0;
						foreach($range_values as $range_value)
						{
							$range_value_count++;
							if(!isset($male_total[$range_value_count]))
							{
								$male_total[$range_value_count] = 0;
								$female_total[$range_value_count] = 0;
								$cross_gender_total[$range_value_count] = 0;
							}
							$curr_male_total = 0;
							$curr_female_total = 0;
							$curr_cross_gender_total = 0;
							$range_type = DiseaseSetFilter::$CONTINUOUS;
							if($is_range_options == true)
								$range_type = DiseaseSetFilter::$DISCRETE;
							if(0)//($site_settings->groupByGender == 0)
							{
								# No genderwise count required.
								# Create filter
								$disease_filter = new DiseaseSetFilter();
								$disease_filter->patientAgeRange = $age_slot;
								$disease_filter->patientGender = null;
								$disease_filter->measureId = $measure->measureId;
								$disease_filter->rangeType = $range_type;
								$disease_filter->rangeValues = $range_value;
								$curr_total = StatsLib::getDiseaseFilterCount($disease_filter);
								$curr_cross_gender_total += $curr_total;
								//echo "$curr_total<br>";
							}
							else
							{
								# Genderwise count required.
								# Create filter
								$disease_filter = new DiseaseSetFilter();
								$disease_filter->patientAgeRange = $age_slot;
								$disease_filter->measureId = $measure->measureId;
								$disease_filter->rangeType = $range_type;
								$disease_filter->rangeValues = $range_value;
								## Count for males.
								$disease_filter->patientGender = 'M';
								$curr_total1 = StatsLib::getDiseaseFilterCount($disease_filter);
								$curr_male_total += $curr_total1;
								## Count for females.
								$disease_filter->patientGender = 'F';
								$curr_total2 = StatsLib::getDiseaseFilterCount($disease_filter);
								$curr_female_total += $curr_total2;
								//echo "$curr_total1<br>$curr_total2<br>";
							}
							# Build assoc list to track genderwise totals
							$male_total[$range_value_count] += $curr_male_total;
							$female_total[$range_value_count] += $curr_female_total;
							$cross_gender_total[$range_value_count] += $curr_cross_gender_total;
                                                       
                                                        
                                                        
						}
						//echo "</td>";
					}
				}
				else
				{
					# Age slots not configured: Show cumulative count for all age values
					$range_value_count = 0;
						foreach($range_values as $range_value)
						{
							$range_value_count++;
							if(!isset($male_total[$range_value_count]))
							{
								$male_total[$range_value_count] = 0;
								$female_total[$range_value_count] = 0;
								$cross_gender_total[$range_value_count] = 0;
							}
							$curr_male_total = 0;
							$curr_female_total = 0;
							$curr_cross_gender_total = 0;
							$range_type = DiseaseSetFilter::$CONTINUOUS;
							if($is_range_options == true)
								$range_type = DiseaseSetFilter::$DISCRETE;
							if($site_settings->groupByGender == 0)
							{
								# No genderwise count required.
								# Create filter
								$disease_filter = new DiseaseSetFilter();
								$disease_filter->patientAgeRange = array(0, 200);
								$disease_filter->patientGender = null;
								$disease_filter->measureId = $measure->measureId;
								$disease_filter->rangeType = $range_type;
								$disease_filter->rangeValues = $range_value;
								$curr_total = StatsLib::getDiseaseFilterCount($disease_filter);
								$curr_cross_gender_total += $curr_total;
							}
							else
							{
								# Genderwise count required.
								# Create filter
								$disease_filter = new DiseaseSetFilter();
								$disease_filter->patientAgeRange = array(0, 200);
								$disease_filter->measureId = $measure->measureId;
								$disease_filter->rangeType = $range_type;
								$disease_filter->rangeValues = $range_value;
								## Count for males.
								$disease_filter->patientGender = 'M';
								$curr_total1 = StatsLib::getDiseaseFilterCount($disease_filter);
								$curr_male_total += $curr_total1;
								## Count for females.
								$disease_filter->patientGender = 'F';
								$curr_total2 = StatsLib::getDiseaseFilterCount($disease_filter);
								$curr_female_total += $curr_total2;
							}
							# Build assoc list to track genderwise totals
							$male_total[$range_value_count] += $curr_male_total;
							$female_total[$range_value_count] += $curr_female_total;
							$cross_gender_total[$range_value_count] += $curr_cross_gender_total;
						}
				}
				
				
				if(1)
				{
					//echo "<td>";
                                    //print_r($male_total);
					for($i = 1; $i <= count($range_values); $i++)
					{
                                            
						$this_male_total = $male_total[$i];
						$this_female_total = $female_total[$i];
						//echo "$this_male_total<br>$this_female_total<br>";
						$this_cross_gender_total = $this_male_total + $this_female_total;
                                                if(is_array($range_values[$i-1]))
                                                {
                                                   // foreach($range_values[$i-1] as $rr)
                                                        
                                                }
                                                else
                                                {
                                                 $rts[$measure->getName()][$range_values[$i-1]]['Male'] = $this_male_total;
                                                  $rts[$measure->getName()][$range_values[$i-1]]['Female'] = $this_female_total;
                                                }
					}
					//echo "</td>";
				}
				
                               
				
			
			
			
		}
	}


            
            
if($rts < 1)
    echo $rts;
else
    echo json_encode ($rts);

//print_r($rts);
//echo "</pre>"
?>
