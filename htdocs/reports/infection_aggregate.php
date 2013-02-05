<?php
#
# Main page for showing disease report and options to export
# Called via POST from reports.php
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/stats_lib.php");
include("includes/script_elems.php");
include("includes/user_lib.php");

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
	<input type='button' onclick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:export_as_word();" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
</form>
<hr>

<div id='report_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<b><?php echo LangUtil::$pageTerms['MENU_INFECTIONREPORT']; ?></b>
<br><br>
<?php

function publishValues( $test, $measure, $age_total, $age_total1, $age_total2, $male_total, $female_total, $cross_gender_total, $grand_total) {
	global $site_settings;
	
	$disease_report = GlobalInfectionReport::getByKeys($_SESSION['user_id'], $test->testId, $measure->measureId);
	
	$is_range_options = true;
	if(strpos($measure->range, "/") === false)
			$is_range_options = false;

	$range_values = array();
	if($is_range_options) {
		# Alphanumeric options
		$range_values1 = explode("/", $measure->range);
		$range_values=str_replace("#","/",$range_values1);	
	}
	else {
		# Numeric ranges: Fetch ranges configured for this test-type/measure from DB
		$range_values = $disease_report->getMeasureGroupAsList();
	}
				
	$row_id = "row_".$test->testId."_".$measure->measureId;
	echo "<tr valign='top' id='$row_id'>";
	echo "<td>".$measure->name."</td>";
	echo "<td>";

	foreach($range_values as $range_value) {
		if($is_range_options)
			echo "$range_value<br>";
		else
			echo "$range_value[0]-$range_value[1]<br>";
		
		if($site_settings->groupByGender == 1)
			echo "<br>";
	}
	echo "</td>";
					
	if($site_settings->groupByGender == 1) {
		# Group by gender set to true
		echo "<td>";
		for($i = 1; $i <= count($range_values); $i++)
				echo "M<br>F<br>";
		echo "</td>";
	}
				
	if($site_settings->groupByAge == 1) {
		# Group by age set to true: Fetch age slots from DB
		$age_slot_list = $site_settings->getAgeGroupAsList();
		$j = 0;
		foreach($age_slot_list as $age_slot) {
			echo "<td>";
			$k=0;
			foreach($range_values as $range_value) {
				$range_type = DiseaseSetFilter::$CONTINUOUS;
				
				if($is_range_options == true)
					$range_type = DiseaseSetFilter::$DISCRETE;
				
				if($site_settings->groupByGender == 0)
					echo $age_total[$j][$k]."<br>";
				else {
					echo $age_total1[$j][$k]."<br>".$age_total2[$j][$k]."<br>";
				}
				$k++;
			}
			$j++;
			echo "</td>";
		}
	}
	else {
		# Age slots not configured: Show cumulative count for all age values
		$range_value_count = 0;
		foreach($range_values as $range_value) {
			$range_type = DiseaseSetFilter::$CONTINUOUS;

			if($is_range_options == true)
				$range_type = DiseaseSetFilter::$DISCRETE;

			if($site_settings->groupByGender == 1) {
				echo "<td>";
				for($i = 1; $i <= count($range_values); $i++) {
					$this_male_total = $male_total[$i];
					$this_female_total = $female_total[$i];
					echo "$this_male_total<br>$this_female_total<br>";
					$this_cross_gender_total = $this_male_total + $this_female_total;
				}
				echo "</td>";
			}
		}
	}
	echo "<td>";
	for($i = 1; $i <= count($range_values); $i++) {
		if($site_settings->groupByGender == 1) {
				echo $male_total[$i];
				echo "<br>";
				echo $female_total[$i];
				echo "<br>";
		}
		else {
				echo $cross_gender_total[$i];
				echo "<br>";
		}
	}
	echo "</td>";
	echo "<td>";
	for($i = 1; $i <= count($cross_gender_total); $i++)
		echo "$cross_gender_total[$i]<br><br>";
	echo "</td>";
}

$lab_config_ids = $_REQUEST['locationAgg'];
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$cat_code = $_REQUEST['cat_code'];
$labNames = "";

if( count($lab_config_ids) == 1 && $lab_config_ids[0] == 0 ) {
	//$sites_list = get_site_list($_SESSION['user_id']);
        $config_list = get_lab_configs_imported();
	foreach($config_list as $lab_config) {
	//foreach($sites_list as $key => $value)
		//$site_list[] = $key;
            $site_list[] = $lab_config->id;
        }
}
else if ( count($lab_config_ids) == 1 )
	$site_list = $lab_config_ids;
else 
	$site_list = $lab_config_ids;

foreach($site_list as $labConfigId) 
	$labNames .= LabConfig::getById($labConfigId)->name.", ";

$labNames = substr($labNames, 0, strlen($labNames)-2);
//print_r($labNames);
//$selected_test_ids = $lab_config->getTestTypeIds();

if($cat_code != 0) {
	# Fetch all tests belonging to this category (aka lab section)
	$cat_test_types = TestTypeMapping::getByCategory($cat_code);
        print_r($cat_test_types);
	$selected_test_ids = array();
	foreach( $cat_test_types as $test_type )
		$selected_test_ids[] = $test_type->testId;
	//$matched_test_ids = array_intersect($cat_test_ids, $selected_test_ids);
	//$selected_test_ids = array_values($matched_test_ids);
}
else {
	$userId = $_SESSION['user_id'];
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"SELECT test_category_id from test_category_mapping ".
		"WHERE user_id=$userId";
	$resultset = query_associative_all($query_string, $row_count);
	$selected_test_ids = array();
	foreach($resultset as $record) {
		$cat_code = $record['test_category_id'];
		$cat_test_types = TestTypeMapping::getByCategory($cat_code);
		foreach( $cat_test_types as $test_type )
			$selected_test_ids[] = $test_type->testId;
	}
	DbUtil::switchRestore($saved_db);
}

# Fetch TestType objects using selected test_type_ids.
$selected_test_types = array();
foreach($selected_test_ids as $test_type_id) {
	$test = TestTypeMapping::getById($test_type_id);
	$selected_test_types[] = $test;
}

# Fetch site-wide settings
$site_settings = GlobalInfectionReport::getByKeys($_SESSION['user_id'], 0, 0);
if($site_settings == null)
{
	echo LangUtil::$pageTerms['TIPS_CONFIGINFECTION'];
	return;
}
$age_group_list = $site_settings->getAgeGroupAsList();
?>
<table>
	<tbody>
		<tr>
			<td><?php echo LangUtil::$generalTerms['FACILITY']; ?>:</td>
			<td><?php echo $labNames; ?></td>
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
		if($cat_code != 0) {
			# Specific tets category selected: Show category name in report
			?>
			<tr>
				<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?>:</td>
				<td><?php echo getTestCategoryAggNameById($cat_code) ?></td>
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
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($selected_test_types as $globalTestType) {
			$testIds = array();
			$labIdTestIds = explode(";",$globalTestType->labIdTestId);
			foreach( $labIdTestIds as $labIdTestId ) {
					$labIdTestIdsSeparated = explode(":",$labIdTestId);
					$labId = $labIdTestIdsSeparated[0];
					$testId = $labIdTestIdsSeparated[1];
					$testIds[$labId] = $testId;
			}
			$measures = $globalTestType->getMeasures();
			foreach($measures as $measure) {			
				$disease_report = GlobalInfectionReport::getByKeys($_SESSION['user_id'], $globalTestType->testId, $measure->measureId);
				$male_total = array();
				$female_total = array();
				$cross_gender_total = array();
				$age_total = array();
				$age_total1 = array();
				$age_total2 = array();
				$curr_male_total = 0;
				$curr_female_total = 0;
				$curr_cross_gender_total = 0;
				$age_total;
				$age_total1;
				$age_total2;
				foreach($site_list as $labConfigId) {
					$lab_config = get_lab_config_by_id($labConfigId);
					$testTypeId = $testIds[$labConfigId];
					$saved_db = DbUtil::switchToLabConfig($labConfigId);
					$testType = TestType::getById($testTypeId);
					StatsLib::setDiseaseSetList($lab_config, $testType, $date_from, $date_to);
					DbUtil::switchRestore($saved_db);
					$is_range_options = true;
					
					if(strpos($measure->range, "/") === false)
						$is_range_options = false;
						
					$range_values = array();
					
					if($is_range_options) {
						# Alphanumeric options
						$range_values1 = explode("/", $measure->range);
						$range_values=str_replace("#","/",$range_values1);
						
					}
					else {
						# Numeric ranges: Fetch ranges configured for this test-type/measure from DB
						$range_values = $disease_report->getMeasureGroupAsList();
					}
					
					$grand_total = 0;
					
					if($site_settings->groupByAge == 1) {
						# Group by age set to true: Fetch age slots from DB
						$age_slot_list = $site_settings->getAgeGroupAsList();
						$x=0;
						foreach($age_slot_list as $age_slot) {
							$range_value_count = 0;
							$y = 0;
							foreach($range_values as $range_value) {
								$range_value_count++;
								if(!isset($male_total[$range_value_count])) {
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
								if($site_settings->groupByGender == 0) {
									# No genderwise count required.
									# Create filter
									$disease_filter = new DiseaseSetFilter();
									$disease_filter->patientAgeRange = $age_slot;
									$disease_filter->patientGender = null;
									$disease_filter->measureId = getLabMeasureIdFromGlobalName($measure->name, $labConfigId);//$measure->measureId;
									$disease_filter->rangeType = $range_type;
									$disease_filter->rangeValues = $range_value;
									$curr_total = StatsLib::getDiseaseFilterCount($disease_filter);
									$age_total[$x][$y] = $age_total[$x][$y] + $curr_total;
									$curr_cross_gender_total += $curr_total;
								}
								else
								{
									# Genderwise count required.
									# Create filter
									$disease_filter = new DiseaseSetFilter();
									$disease_filter->patientAgeRange = $age_slot;
									$disease_filter->measureId = getLabMeasureIdFromGlobalName($measure->name, $labConfigId);
									$disease_filter->rangeType = $range_type;
									$disease_filter->rangeValues = $range_value;
									## Count for males.
									$disease_filter->patientGender = 'M';
									$curr_total1 = StatsLib::getDiseaseFilterCount($disease_filter);
									$age_total1[$x][$y] = $age_total1[$x][$y] + $curr_total1;
									$curr_male_total += $curr_total1;
									## Count for females.
									$disease_filter->patientGender = 'F';
									$curr_total2 = StatsLib::getDiseaseFilterCount($disease_filter);
									$age_total2[$x][$y] = $age_total2[$x][$y] + $curr_total2;
									$curr_female_total += $curr_total2;
								}
								# Build assoc list to track genderwise totals
								$male_total[$range_value_count] += $curr_male_total;
								$female_total[$range_value_count] += $curr_female_total;
								$cross_gender_total[$range_value_count] += $curr_male_total + $curr_female_total;
								$y++;
							}
							$x++;
						}
					}
					else {
						# Age slots not configured: Show cumulative count for all age values
						$range_value_count = 0;
							foreach($range_values as $range_value) {
								$range_value_count++;
								
								if(!isset($male_total[$range_value_count])) {
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
									$disease_filter->measureId = getLabMeasureIdFromGlobalName($measure->name, $labConfigId);
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
									$disease_filter->measureId = getLabMeasureIdFromGlobalName($measure->name, $labConfigId);
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
								$cross_gender_total[$range_value_count] += $curr_male_total + $curr_female_total;
							}
					}
					
					if($site_settings->groupByGender == 1) {
						for($i = 1; $i <= count($range_values); $i++) {
							$this_male_total = $male_total[$i];
							$this_female_total = $female_total[$i];
							$this_cross_gender_total = $this_male_total + $this_female_total;
						}
					}
						
					if($site_settings->groupByGender == 1)
						$grand_total = array_sum($male_total) + array_sum($female_total);
					else
						$grand_total = array_sum($cross_gender_total);
				}
				publishValues($test, $measure, $age_total, $age_total1, $age_total2, $male_total, $female_total, $cross_gender_total, $grand_total);
			}
			# Grand total:
			echo "<td>";
			if($site_settings->groupByGender == 1) {
				echo array_sum($male_total) + array_sum($female_total);
				$grand_total = array_sum($male_total) + array_sum($female_total);
			}
			else {
				echo array_sum($cross_gender_total);
				$grand_total = array_sum($cross_gender_total);
			}
			echo "</td>";
			?>
			</tr>
			<?php
				if($grand_total == 0) {
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
	?>
	</tbody>
</table>
<br><br><br>
............................................
</div>