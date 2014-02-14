<?php
#
# Lists test records in simple table for printing purposes
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/stats_lib.php");
include("includes/page_elems.php");
LangUtil::setPageId("reports");

# Utility function
function get_records_to_print($lab_config, $test_type_id, $date_from, $date_to)
{
	$saved_db = DbUtil::switchToLabConfig($lab_config->id);
	$retval = array();
	$query_string =
		"SELECT * FROM test WHERE test_type_id=$test_type_id ".
		//"AND result <> '' ".
		"AND specimen_id IN ( ".
			"SELECT specimen_id FROM specimen ".
			"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
		")";
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$test = Test::getObject($record);
		$specimen = Specimen::getById($test->specimenId);
		$patient = Patient::getById($specimen->patientId);
		$retval[] = array($test, $specimen, $patient);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_cumul_stats($lab_config_id, $test_type_id, $date_from, $date_to)
{
	$lab_config = LabConfig::getById($lab_config_id);
	$test_type = TestType::getById($test_type_id);
	$measure_list = $test_type->getMeasures();
	$site_settings = DiseaseReport::getByKeys($lab_config->id, 0, 0);
	$age_group_list = $site_settings->getAgeGroupAsList();
	?>
	<table class='pretty_print' style='border-collapse: collapse;'>
	<thead>
		<tr valign='top'>
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
	StatsLib::setDiseaseSetList($lab_config, $test_type, $date_from, $date_to);
	$measures = $test_type->getMeasures();
	foreach($measures as $measure)
	{
		$male_total = array();
		$female_total = array();
		$cross_gender_total = array();
		$curr_male_total = 0;
		$curr_female_total = 0;
		$curr_cross_gender_total = 0;
		$disease_report = DiseaseReport::getByKeys($lab_config->id, $test_type->testTypeId, $measure->measureId);
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
	?>
	</tbody>
	</table>
	<?php	
}

include("includes/script_elems.php");
$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableTableSorter();
$script_elems->enableDragTable();
$page_elems = new PageElems();
//$page_elems->getExportTxtScript();
?>
<script type='text/javascript'>
function export_as_word(div_id)
{
	var content = $('#'+div_id).html();
	$('#word_data').attr("value", content);
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

$(document).ready(function(){
	$('#report_content_table3').tablesorter();
});
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
</form>
<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:export_as_word('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php $page_elems->getTableSortTip(); ?>
<hr>
<?php
$lab_config_id = $_REQUEST['location'];
$test_type_id = $_REQUEST['t_type'];
DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
$test_type = get_test_type_by_id($test_type_id);

$report_id = $REPORT_ID_ARRAY['reports_print.php'];
$report_config = $lab_config->getReportConfig($report_id);

$margin_list = $report_config->margins;
for($i = 0; $i < count($margin_list); $i++)
{
	$margin_list[$i] = ($SCREEN_WIDTH * $margin_list[$i] / 100);
}

$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
if($lab_config == null)
{
	?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>
	<?php
	return;
}
?>
<div id='export_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<style type='text/css'>
	<?php $page_elems->getReportConfigCss($margin_list, false); ?>
</style>
<div id='report_config_content'>
<h3>
	<?php echo $report_config->headerText; ?> |
	<?php echo LangUtil::$generalTerms['G_DATE']; ?>: <?php echo date($_SESSION['dformat']); ?>
</h3>
<h3><?php echo $report_config->titleText; ?></h3>
<?php echo LangUtil::$generalTerms['FACILITY']; ?>: <?php echo $lab_config->getSiteName(); ?> |
<?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>: <?php echo $test_type->getName(); ?> |
<?php echo LangUtil::$generalTerms['FROM_DATE']; ?>: <?php echo DateLib::mysqlToString($date_from); ?> |
<?php echo LangUtil::$generalTerms['TO_DATE']; ?>: <?php echo DateLib::mysqlToString($date_to); ?>
<br><br>
<?php
$record_list = get_records_to_print($lab_config, $test_type_id, $date_from, $date_to);
if(count($record_list) == 0)
{
	echo LangUtil::$pageTerms['TIPS_RECNOTFOUND'];
	return;
}
?>
<table class='print_entry_border draggable' id='report_content_table3'>
	<thead>
		<tr valign='top'>
		<?php
		if($report_config->usePatientId == 1)
		{
		?>
			<th><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
		<?php
		}
		if($report_config->usePatientAddlId == 1)
		{
		?>
			<th><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></th>
		<?php
		}
		if($report_config->usePatientName == 1)
		{
		?>
			<th><?php echo LangUtil::$generalTerms['NAME']; ?></th>
		<?php
		}
		if($report_config->useAge == 1)
		{
		?>
			<th><?php echo LangUtil::$generalTerms['AGE']; ?></th>
		<?php
		}
		if($report_config->useGender == 1)
		{
		?>			
			<th><?php echo LangUtil::$generalTerms['GENDER']; ?></th>
		<?php
		}
		if($report_config->useDob == 1)
		{
		?>
			<th><?php echo LangUtil::$generalTerms['DOB']; ?></th>
		<?php 
		}
		# Patient Custom fields here
		$custom_field_list = $lab_config->getPatientCustomFields();
		foreach($custom_field_list as $custom_field)
		{
			if(in_array($custom_field->id, $report_config->patientCustomFields))
			{	
				$field_name = $custom_field->fieldName;				
				echo "<th>";
				echo $field_name;
				echo "</th>";
			}
		}
		if($report_config->useSpecimenAddlId != 0)
		{
			echo "<th>".LangUtil::$generalTerms['SPECIMEN_ID']."</th>";
		}
		if($report_config->useDailyNum == 1)
		{
			echo "<th>".LangUtil::$generalTerms['PATIENT_DAILYNUM']."</th>";
		}
		if($report_config->useSpecimenName == 1)
		{
			echo "<th>".LangUtil::$generalTerms['TYPE']."</th>";
		}
		if($report_config->useDateRecvd == 1)
		{
			echo "<th>".LangUtil::$generalTerms['R_DATE']."</th>";
		}
		# Specimen Custom fields headers here
		$custom_field_list = $lab_config->getSpecimenCustomFields();
		foreach($custom_field_list as $custom_field)
		{
			$field_name = $custom_field->fieldName;
			$field_id = $custom_field->id;
			if(in_array($field_id, $report_config->specimenCustomFields))
			{
				echo "<th>".$field_name."</th>";
			}
		}
		if($report_config->useTestName == 1)
		{
			echo "<th>".LangUtil::$generalTerms['TEST'];
			if($report_config->useRange)
			{
				echo " ";
			}
			echo "</th>";
		}
		if($report_config->useComments == 1)
		{
			echo "<th>".LangUtil::$generalTerms['COMMENTS']."</th>";
		}
		if($report_config->useReferredTo == 1)
		{
			echo "<th>".LangUtil::$generalTerms['REF_TO']."</th>";
		}
		if($report_config->useResults == 1)
		{
			echo "<th>".LangUtil::$generalTerms['RESULTS']."</th>";
		}
		if($report_config->useEntryDate == 1)
		{
			echo "<th>".LangUtil::$generalTerms['E_DATE']."</th>";
		}
		if($report_config->useRemarks == 1)
		{
			echo "<th>".LangUtil::$generalTerms['RESULT_COMMENTS']."</th>";
		}
		if($report_config->useEnteredBy == 1)
		{
			echo "<th>".LangUtil::$generalTerms['ENTERED_BY']."</th>";
		}
		if($report_config->useVerifiedBy == 1)
		{
			echo "<th>".LangUtil::$generalTerms['VERIFIED_BY']."</th>";
		}
		if($report_config->useStatus == 1)
		{
			echo "<th>".LangUtil::$generalTerms['SP_STATUS']."</th>";
		}
		?>
		</tr>
	</thead>
<tbody>
<?php
$count = 1;
# Loop here
foreach($record_list as $record_set)
{
	$value = $record_set;
	$test = $value[0];
	$specimen = $value[1];
	$patient = $value[2];
	?>
	<tr valign='top'>
		<?php
		if($report_config->usePatientId == 1)
		{
		?>
			<td><?php echo $patient->getSurrogateId(); ?></td>
		<?php
		}
		if($report_config->usePatientAddlId == 1)
		{
		?>
			<td><?php echo $patient->getAddlId(); ?></td>
		<?php
		}
		if($report_config->usePatientName == 1)
		{
		?>
			<td><?php echo $patient->name; ?></td>
		<?php
		}
		if($report_config->useAge == 1)
		{
		?>
			<td><?php echo $patient->getAge(); ?></td>
		<?php
		}
		if($report_config->useGender == 1)
		{
		?>			
			<td><?php echo $patient->sex; ?></td>
		<?php
		}
		if($report_config->useDob == 1)
		{
		?>
			<td><?php echo $patient->getDob(); ?></td>
		<?php 
		}
		# Patient Custom fields here
		$custom_field_list = $lab_config->getPatientCustomFields();
		foreach($custom_field_list as $custom_field)
		{
			if(in_array($custom_field->id, $report_config->patientCustomFields))
			{	
				$field_name = $custom_field->fieldName;				
				$custom_data = get_custom_data_patient_bytype($patient->patientId, $custom_field->id);
				echo "<td>";
				if($custom_data == null)
				{
					echo "-";
				}
				else
				{
					$field_value = $custom_data->getFieldValueString($lab_config->id, 2);
					if(trim($field_value) == "")
						$field_value = "-";
					echo $field_value;
				}
				echo "</td>";					
			}
		}
		if($report_config->useSpecimenAddlId == 1)
		{
			echo "<td>";
			$specimen->getAuxId();
			echo "</td>";
		}
		if($report_config->useDailyNum == 1)
		{
			echo "<td>".$specimen->dailyNum."</td>";
		}
		if($report_config->useSpecimenName == 1)
		{
			echo "<td>".get_specimen_name_by_id($specimen->specimenTypeId)."</td>";
		}
		if($report_config->useDateRecvd == 1)
		{
			echo "<td>".DateLib::mysqlToString($specimen->dateRecvd)."</td>";
		}
		# Specimen Custom fields here
		$custom_field_list = $lab_config->getSpecimenCustomFields();
		foreach($custom_field_list as $custom_field)
		{
			if(in_array($custom_field->id, $report_config->specimenCustomFields))
			{
				echo "<td>";
				$custom_data = get_custom_data_specimen_bytype($specimen->specimenId, $custom_field->id);
				if($custom_data == null)
				{
					echo "-";
				}
				else
				{
					$field_value = $custom_data->getFieldValueString($lab_config->id, 1);
					if($field_value == "" or $field_value == null) 
						$field_value = "-";
					echo $field_value; 
				}
				echo "</td>";
			}
		}
		if($report_config->useTestName == 1)
		{
			echo "<td>".get_test_name_by_id($test->testTypeId)."</td>";
		}
		if($report_config->useComments == 1)
		{
			echo "<td>";
			echo $specimen->getComments();
			echo "</td>";
		}
		if($report_config->useReferredTo == 1)
		{
			echo "<td>".$specimen->getReferredToName()."</td>";
		}
		if($report_config->useResults == 1)
		{
			echo "<td>";
			if(trim($test->result) == "")
			{
				echo LangUtil::$generalTerms['PENDING_RESULTS'];
			}
			else
			{
				echo $test->decodeResult();
			}
			echo "</td>";
		}
		if($report_config->useEntryDate == 1)
		{
			echo "<td>";
			if(trim($test->result) == "")
				echo "-";
			else
			{
				$ts_parts = explode(" ", $test->timestamp);
				echo DateLib::mysqlToString($ts_parts[0]);
			}
			echo "</td>";
		}
		if($report_config->useRemarks == 1)
		{
			echo "<td>".$test->getComments()."</td>";
		}
		if($report_config->useEnteredBy == 1)
		{
			echo "<td>".$test->getEnteredBy()."</td>";
		}
		if($report_config->useVerifiedBy == 1)
		{
			echo "<td>".$test->getVerifiedBy()."</td>";
		}
		if($report_config->useStatus == 1)
		{
			echo "<td>".$test->getStatus()."</td>";
		}
		?>
	</tr>
	<?php
	$count++;
}
?>
</tbody>
</table>
<br><br>
<?php
# Print cumulative stats
echo "<b>".LangUtil::$generalTerms['CUMULATIVE']."</b><br>";
get_cumul_stats($lab_config_id, $test_type_id, $date_from, $date_to);
?>
<br>
<?php # Line for Signature ?>
.............................
<h4><?php echo $report_config->footerText; ?></h4>
</div>
</div>