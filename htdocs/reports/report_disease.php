<?php
#
# Main page for showing disease report and options to export
# Called via POST from reports.php
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
	//$('#export_word_form').submit();
	$('#word_format_form').submit();
}

function print_content(div_id)
{
	var DocumentContainer = document.getElementById(div_id);
	var WindowObject = window.open("", "PrintWindow", "toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
	//javascript:window.print();
}
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
	<input type='hidden' name='lab_id' value='<?php echo $lab_config_id; ?>' id='lab_id'>
	<input type='button' onclick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:export_as_word();" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
</form>
<hr>
<?php /*
<form name='export_word_form' id='export_word_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' value='' id='word_data' name='data'></input>
</form>
*/
?>
<div id='report_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<b><?php echo LangUtil::$pageTerms['MENU_INFECTIONREPORT']; ?></b>
<br><br>
<?php
$lab_config_id = $_REQUEST['location'];
$lab_config = LabConfig::getById($lab_config_id);
if($lab_config == null)
{
	echo LangUtil::$generalTerms['MSG_NOTFOUND'];
	return;
}
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$cat_code = $_REQUEST['cat_code'];
$uiinfo = "from=".$date_from."&to=".$date_to."&ct=".$cat_code;
putUILog('reports_disease', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
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
if($site_settings == null)
{
	echo $lab_config->getSiteName()." - ".LangUtil::$pageTerms['TIPS_CONFIGINFECTION'];
	return;
}
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
			<td>
			<?php
			if($date_from == $date_to)
			{
				echo DateLib::mysqlToString($date_from);
			}
			else
			{	
				echo DateLib::mysqlToString($date_from)." to ".DateLib::mysqlToString($date_to);
			}
			?>
			</td>
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
<table style='border-collapse: collapse;'>
	<thead>
		<tr>
			<th><?php echo LangUtil::$generalTerms['TEST']; ?></th>
			<th ><?php echo LangUtil::$generalTerms['RESULTS']; ?></th>
			<?php
			if($site_settings->groupByGender == 1)
			{
				echo "<th >".LangUtil::$generalTerms['GENDER']."</th>";
			}
			if($site_settings->groupByAge == 1)
			{
				echo "<th >".LangUtil::$pageTerms['RANGE_AGE']."</th>";
				for($i = 1; $i < count($age_group_list); $i++)
				{
					echo "<th >".LangUtil::$pageTerms['RANGE_AGE']."</th>";
				}
			}
			if($site_settings->groupByGender == 1)
			{
				echo "<th ></th>";
			}
			?>
			<th ><?php echo LangUtil::$pageTerms['TOTAL']; ?></th>
			<th ><?php echo LangUtil::$pageTerms['TOTAL_TESTS']; ?></th>
		</tr>
		<tr>
			<th ></th>
			<th ></th>
			<?php
			if($site_settings->groupByGender == 1)
			{
				echo "<th ></th>";
			}
			
			if($site_settings->groupByAge == 1)
			{
				foreach($age_group_list as $age_slot)
				{
					echo "<th>$age_slot[0]";
					if(trim($age_slot[1]) == "+")
						echo "+";
					else
						echo " - $age_slot[1]";
					echo "</th>";
				}
			}
			if($site_settings->groupByGender == 1)
			{
				echo "<th >".LangUtil::$pageTerms['TOTAL_MF']."</th>";
			}
			echo "<th ></th>";
			echo "<th ></th>";
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
			?>
			<tr valign='top' id='<?php echo $row_id; ?>'>
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
					$grand_total = array_sum($male_total) + array_sum($female_total);
				}
				else
				{
					echo array_sum($cross_gender_total);
					$grand_total = array_sum($cross_gender_total);
				}
				echo "</td>";
				?>
			</tr>
			<?php
			if($grand_total == 0)
			{
				# Hide current table row
				?>
				<script type='text/javascript'>
				$(document).ready(function(){
					$('#<?php echo $row_id; ?>').remove();
				});
				</script>
				<?php
			}
		}
	}
	?>
	</tbody>
</table>
<br><br><br>
............................................
</div>