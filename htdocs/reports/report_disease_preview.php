<?php
#
# Main page for showing disease (infection) report preview
# Called from lab_config_home.php
# Copied code from report_disease.php
# DiseaseReport ($site_settings) object is set based on POST data
#

include("redirect.php");
include("includes/db_lib.php");
include("includes/stats_lib.php");
include("includes/script_elems.php");
LangUtil::setPageId("reports");

$script_elems = new ScriptElems();
$script_elems->enableJQuery();
?>
<script type='text/javascript'>
function export_as_word()
{
	var html_data = $('#report_content').html();
	$('#word_data').attr("value", html_data);
	$('#export_word_form').submit();
}
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPREVIEW']; ?>'></input>
</form>
<hr>
<form name='export_word_form' id='export_word_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' value='' id='word_data' name='data'></input>
</form>
<div id='report_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<b><?php echo LangUtil::$pageTerms['MENU_INFECTIONREPORT']; ?></b>
<br><br>
<?php
# Assoc list for temprarily storing site settings
$disease_report_list = array();
$lab_config_id = $_REQUEST['lab_config_id'];
$disease_report = new DiseaseReport();
$disease_report->labConfigId = $_REQUEST['lab_config_id'];
if($_REQUEST['rage'] == 'y')
{
	# Group by age slots enabled
	$disease_report->groupByAge = 1;
	$age_lower_list = $_REQUEST['age_l'];
	$age_upper_list = $_REQUEST['age_u'];
	$age_slot_string = "";
	for($i = 0; $i < count($age_lower_list); $i++)
	{
		if
		(
			trim($age_lower_list[$i]) === "" || 
			trim($age_upper_list[$i]) === "" || 
			is_nan($age_lower_list[$i]) ||
			(trim($age_upper_list[$i]) != "+" && is_nan($age_upper_list[$i]))
		)
		{
			# Invalid/empty age slot: Ignore
			continue;
		}
		$age_slot_string .= $age_lower_list[$i].":".$age_upper_list[$i];
		if($i < count($age_lower_list) - 1)
		{
			$age_slot_string .= ",";
		}
	}
	$disease_report->ageGroups = $age_slot_string;
}
else 
{
	# Group by age slots not selected
	$disease_report->groupByAge = 0;
	$disease_report->ageGroups = null;
}

if($_REQUEST['rgender'] == 'y')
{
	# Group by gender enabled
	$disease_report->groupByGender = 1;
}
else
{
	# Group by gender not selected
	$disease_report->groupByGender = 0;
}

# Insert dummy record with (lab_config_id, 0, 0) for site-wide settings of all test types.
# Can be removed later if group_by_gender and group_by_age settings need to be test-specific.
$disease_report->testTypeId = 0;
$disease_report->measureId = 0;
$disease_report->measureGroups = "";

# Copy to assoc list instead of updating in DB
//$disease_report->addToDb();
$disease_report_list[0] = array();
$disease_report_list[0][0] = $disease_report;
$disease_report = clone $disease_report_list[0][0];

# For each test type
## Fetch range slots for each measure and update in DB
$test_list = $_REQUEST['ttypes'];
foreach($test_list as $test_type_id)
{
	$disease_report_list[$test_type_id] = array();
	$disease_report->testTypeId = $test_type_id;
	$test_type = TestType::getById($test_type_id);
	$measure_list = $test_type->getMeasureIds();
	foreach($measure_list as $measure_id)
	{
		$slot_string = "";
		# Fetch measure slot values
		$disease_report->measureId = $measure_id;
		$lower_field_name = "slotl_".$test_type_id."_".$measure_id;
		$upper_field_name = "slotu_".$test_type_id."_".$measure_id;
		if(!isset($_REQUEST[$lower_field_name]))
			continue;
		$slot_lower_list = $_REQUEST[$lower_field_name];
		$slot_upper_list = $_REQUEST[$upper_field_name];
		for($i = 0; $i < count($slot_lower_list); $i++)
		{
			if(trim($slot_lower_list[$i]) === "" || trim($slot_upper_list[$i]) === "")
				continue;
			$slot_string .= $slot_lower_list[$i].":".$slot_upper_list[$i].",";
		}
		$disease_report->measureGroups = $slot_string;
		# Copy to assoc list instead of updating in DB
		//$disease_report->addToDb();
		$disease_report_list[$test_type_id][$measure_id] = $disease_report;
		$disease_report = clone $disease_report_list[$test_type_id][$measure_id];
	}
}
$lab_config = LabConfig::getById($lab_config_id);
$date_from = date("Y-m-d");
$date_to = date("Y-m-d");
$cat_code = 0;
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
?>
<table>
	<tbody>
		<tr>
			<td><?php echo LangUtil::$generalTerms['FACILITY']; ?>:</td>
			<td><?php echo $lab_config->getSiteName(); ?></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$pageTerms['REPORT_PERIOD']; ?>:</td>
			<td><?php echo DateLib::mysqlToString($date_from); ?> to <?php echo DateLib::mysqlToString($date_to); ?></td>
		</tr>
		<?php
		if($cat_code != 0)
		{
		# Specific tets category selected: Show category name in report
		?>
		<tr>
			<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?>:</td>
			<td><?php echo get_test_category_name_by_id($cat_code) ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php
if(count($selected_test_types) == 0)
{
	echo LangUtil::$pageTerms['TIPS_NOTATTESTS'];
	return;
}
$table_css = "style='padding: .3em; border: 1px black solid; font-size:14px;'";
?>
<br>
<table class='pretty_print' style='border-collapse: collapse;'>
	<thead>
		<tr>
			<td><?php echo LangUtil::$generalTerms['TEST']; ?></td>
			<td ><?php echo LangUtil::$generalTerms['RESULTS']; ?></td>
			<?php
			if($site_settings->groupByGender == 1)
			{
				echo "<td >".LangUtil::$generalTerms['GENDER']."</td>";
			}
			if($site_settings->groupByAge == 1)
			{
				echo "<td >".LangUtil::$pageTerms['RANGE_AGE']."</td>";
				for($i = 1; $i < count($age_group_list); $i++)
				{
					echo "<td >".LangUtil::$pageTerms['RANGE_AGE']."</td>";
				}
			}
			if($site_settings->groupByGender == 1)
			{
				echo "<td ></td>";
			}
			?>
			<td ><?php echo LangUtil::$pageTerms['TOTAL']; ?></td>
			<td ><?php echo LangUtil::$pageTerms['TOTAL_TESTS']; ?></td>
		</tr>
		<tr>
			<td ></td>
			<td ></td>
			<?php
			if($site_settings->groupByGender == 1)
			{
				echo "<td ></td>";
			}
			
			if($site_settings->groupByAge == 1)
			{
				foreach($age_group_list as $age_slot)
				{
					echo "<td>$age_slot[0]";
					if(trim($age_slot[1]) == "+")
						echo "+";
					else
						echo " - $age_slot[1]";
					echo "</td>";
				}
			}
			if($site_settings->groupByGender == 1)
			{
				echo "<td >".LangUtil::$pageTerms['TOTAL_MF']."</td>";
			}
			echo "<td ></td>";
			echo "<td ></td>";
			?>
		<tr>
	</thead>
	<tbody>
	<?php
	foreach($selected_test_types as $test)
	{
		StatsLib::setDiseaseSetList($lab_config, $test, $date_from, $date_to);
		$measures = $test->getMeasures();
		foreach($measures as $measure)
		{
			$male_total = array();
			$female_total = array();
			$cross_gender_total = array();
			$curr_male_total = 0;
			$curr_female_total = 0;
			$curr_cross_gender_total = 0;
			//$disease_report = DiseaseReport::getByKeys($lab_config->id, $test->testTypeId, $measure->measureId);
			if($disease_report == null)
			{
				# TODO: Check for error control
				# Alphanumeric values. Hence entry not found.
				//continue;
			}
			$is_range_options = true;
			if(strpos($measure->range, "/") === false)
			{
				$is_range_options = false;
				$disease_report = $disease_report_list[$test->testTypeId][$measure->measureId];
			}
			else
			{
				$disease_report = $disease_report_list[0][0];
			}
			$range_values = array();
			if($is_range_options)
			{
				# Alphanumeric options
				$range_values = explode("/", $measure->range);
			}
			else
			{
				# Numeric ranges: Fetch ranges configured for this test-type/measure from DB
				$range_values = $disease_report->getMeasureGroupAsList();
			}
			?>
			<tr valign='top'>
				<td><?php echo $measure->getName(); ?></td>
				<td>
				<?php 
				foreach($range_values as $range_value)
				{
					if($is_range_options)
						echo "$range_value<br>";
					else
						echo "$range_value[0]-$range_value[1]<br>";
					if($site_settings->groupByGender == 1)
					{
						echo "<br>";
					}
				}
				?>
				</td>
				<?php
				if($site_settings->groupByGender == 1)
				{
					# Group by gender set to true
					echo "<td>";
					for($i = 1; $i <= count($range_values); $i++)
					{
						echo "M<br>F<br>";
					}
				}
				if($site_settings->groupByAge == 1)
				{
					# Group by age set to true: Fetch age slots from DB
					$age_slot_list = $site_settings->getAgeGroupAsList();
					foreach($age_slot_list as $age_slot)
					{
						echo "<td>";
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
								$disease_filter->patientAgeRange = $age_slot;
								$disease_filter->patientGender = null;
								$disease_filter->measureId = $measure->measureId;
								$disease_filter->rangeType = $range_type;
								$disease_filter->rangeValues = $range_value;
								$curr_total = StatsLib::getDiseaseFilterCount($disease_filter);
								$curr_cross_gender_total += $curr_total;
								echo "$curr_total<br>";
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
								echo "$curr_total1<br>$curr_total2<br>";
							}
							# Build assoc list to track genderwise totals
							$male_total[$range_value_count] += $curr_male_total;
							$female_total[$range_value_count] += $curr_female_total;
							$cross_gender_total[$range_value_count] += $curr_cross_gender_total;
						}
						echo "</td>";
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
				
				if($site_settings->groupByGender == 1)
				{
					echo "<td>";
					for($i = 1; $i <= count($range_values); $i++)
					{
						$this_male_total = $male_total[$i];
						$this_female_total = $female_total[$i];
						echo "$this_male_total<br>$this_female_total<br>";
						$this_cross_gender_total = $this_male_total + $this_female_total;
					}
					echo "</td>";
				}
				
				echo "<td>";
				for($i = 1; $i <= count($range_values); $i++)
				{
					if($site_settings->groupByGender == 1)
					{
						echo $male_total[$i] + $female_total[$i];
						echo "<br><br>";
					}
					else
					{
						echo $cross_gender_total[$i];
						echo "<br>";
					}				
				}
				echo "</td>";
				# Grand total:
				# TODO: Check the following function for off-by-one error
				//$disease_total = StatsLib::getDiseaseTotal($lab_config, $test, $date_from, $date_to);
				//echo "<td >$disease_total</td>";
				echo "<td>";
				if($site_settings->groupByGender == 1)
				{
					echo array_sum($male_total) + array_sum($female_total);
				}
				else
				{
					echo array_sum($cross_gender_total);
				}
				echo "</td>";
				?>
			</tr>
			<?php
		}
	}
	?>
	</tbody>
</table>
<br>
<br>
</div>