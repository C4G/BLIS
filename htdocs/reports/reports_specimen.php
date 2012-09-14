<?php
#
# Creates printable report for all test results on a single specimen
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");
include("includes/page_elems.php");
LangUtil::setPageId("reports");

# Helper function to fetch test record
function get_test_record($specimen_id, $test_type_id)
{
	$query_string = 
		"SELECT * FROM test ".
		"WHERE specimen_id=$specimen_id AND test_type_id=$test_type_id ";
	$record = query_associative_one($query_string);
	$test_entry = Test::getObject($record);
	return $test_entry;
}

function list_results($test_entry, $not_bold_measure_name)
{
	$measure_list = get_test_type_measure($test_entry->testTypeId);
	if($test_entry->isPending())
	{
		echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['PENDING_RESULTS']."<br>";
		return;
	}
	$result_list = explode(",", $test_entry->result);
	$print_range_label = false;
	for($i = 0; $i < count($measure_list); $i++)
	{
		$curr_measure = $measure_list[$i];
		$range = $curr_measure->range;
		if(strpos($range, ":"))
		{
			# Numeric range exists: Show range label ("Golabl Normal Ranges")
			$print_range_label = true;
			break;
		}
	}
	?>
	<table cellspacing='6px' style='text-align:left;'>
		<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>
			<?php 
			if($print_range_label)
				echo LangUtil::$pageTerms['RANGE_NORMAL'];
			?>		
			</td>
			<td>
				<?php echo LangUtil::$generalTerms['RESULT_COMMENTS']; ?>
			</td>
		</tr>
		<?php
		for($i = 0; $i < count($measure_list); $i++)
		{
			# Pretty print
			$curr_measure = $measure_list[$i];
			echo "<tr>";
			echo "<td>";
				if($not_bold_measure_name)
				{
					echo $curr_measure->getName();
				}
				else
				{
					echo "<b>".$curr_measure->getName()."<b>";
				}
				echo "</td>";
				echo "<td>$result_list[$i]</td>";
				echo "<td>";
				if(trim($curr_measure->unit) != "")
					echo "[$curr_measure->unit]";
				echo "</td>";
				echo "<td>";
				if($print_range_label)
				{
					$range = $curr_measure->range;
					if(strpos($range, ":"))
					{
						$range_bounds = explode(":", $range);
						echo "($range_bounds[0] - $range_bounds[1])";
					}
					else
					{
						//Do nothing
					}
				}
				echo "</td>";
				echo "<td>";
				if(trim($test_entry->comments) == "")
					echo "-";
				else
					echo $test_entry->comments;
				echo "</td>";
			echo "</tr>";
		}
		?>
		</tbody>
	</table>
	<?php
}

$page_elems = new PageElems();
$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableLatencyRecord();

$lab_config_id = $_REQUEST['location'];
DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
$specimen_id = $_REQUEST['specimen_id'];
$specimen = get_specimen_by_id($specimen_id);

$report_id = $REPORT_ID_ARRAY['reports_specimen.php'];
$report_config = $lab_config->getReportConfig($report_id);

$margin_list = $report_config->margins;
for($i = 0; $i < count($margin_list); $i++)
{
	$margin_list[$i] = ($SCREEN_WIDTH * $margin_list[$i] / 100);
}

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
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
</form>
<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:export_as_word('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
<hr>
<div id='export_content'>
<style type='text/css'>
	#export_content { margin-left: 30px; }
	<?php $page_elems->getReportConfigCss($margin_list); ?>
</style>
<div id='report_config_content'>
<h3><?php echo $report_config->headerText; ?></h3>
<?php
if($specimen == null)
{
	echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['SPECIMEN_ID']." $specimen_id - ".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
	return;
}
$patient = get_patient_by_id($specimen->patientId);
?>
<table>
	<tbody>
	<?php
	if($report_config->usePatientId == 1)
	{
	?>
	<tr valign='top'>
		<td><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?>:</td>
		<td><?php echo $patient->getSurrogateId(); ?></td>
	</tr>
	<?php
	}
	if($report_config->usePatientAddlId == 1)
	{
	?>
	<tr valign='top'>
		<td><?php echo LangUtil::$generalTerms['ADDL_ID']; ?>:</td>
		<td><?php echo $patient->getAddlId(); ?></td>
	</tr>
	<?php
	}
	if($report_config->usePatientName == 1)
	{
	?>
	<tr valign='top'>
		<td><?php echo LangUtil::$generalTerms['NAME']; ?>:</td>
		<td><?php echo $patient->name; ?></td>
	</tr>
	<?php
	}
	if($report_config->useAge == 1)
	{
	?>
	<tr valign='top'>
		<td><?php echo LangUtil::$generalTerms['AGE']; ?>:</td>
		<td><?php echo $patient->getAge(); ?></td>
	</tr>
	<?php
	}
	if($report_config->useGender == 1)
	{
	?>			
	<tr valign='top'>	
		<td><?php echo LangUtil::$generalTerms['GENDER']; ?>:</td>
		<td><?php echo $patient->sex; ?></td>
	</tr>
	<?php
	}
	if($report_config->useDob == 1)
	{
	?>
	<tr valign='top'>
		<td><?php echo LangUtil::$generalTerms['DOB']; ?>:</td>
		<td><?php echo $patient->getDob(); ?></td>
	</tr>
	<?php 
	}
	# Patient Custom fields here
	$custom_field_list = $lab_config->getPatientCustomFields();
	foreach($custom_field_list as $custom_field)
	{
		if(in_array($custom_field->id, $report_config->patientCustomFields))
		{	
			$field_name = $custom_field->fieldName;				
			?>
			<tr valign='top'>
			<?php
			echo "<td>";
				echo $field_name;
			echo ":</td>";
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
			?>
			</tr>
			<?php
		}
	}
?>
</tbody>
</table>
<table>
	<tbody>
	<?php
			if($report_config->useSpecimenAddlId != 0)
			{
				echo "<tr valign='top'>";
				echo "<td>".LangUtil::$generalTerms['SPECIMEN_ID'].":</td>";
				echo "<td>";
				$specimen->getAuxId();
				echo "</td>";
				echo "</tr>";
			}
			if($report_config->useDailyNum == 1)
			{
				echo "<tr valign='top'>";
				echo "<td>".LangUtil::$generalTerms['PATIENT_DAILYNUM'].":</td>";
				echo "<td>".$specimen->dailyNum."</td>";
				echo "</tr>";
			}
			if($report_config->useSpecimenName == 1)
			{
				echo "<tr valign='top'>";
				echo "<td>".LangUtil::$generalTerms['SPECIMEN_TYPE'].":</td>";
				echo "<td>".get_specimen_name_by_id($specimen->specimenTypeId)."</td>";
				echo "</tr>";
			}
			if($report_config->useDateRecvd == 1)
			{
				echo "<tr valign='top'>";
				echo "<td>".LangUtil::$generalTerms['R_DATE'].":</td>";
				echo "<td>".DateLib::mysqlToString($specimen->dateRecvd)."</td>";
				echo "</tr>";
			}
			if($report_config->useComments == 1)
			{
				echo "<tr valign='top'>";
				echo "<td>".LangUtil::$generalTerms['COMMENTS'].":</td>";
				echo "<td>";
				$specimen->getComments();
				echo "</td>";
				echo "</tr>";
			}
			# Specimen Custom fields headers here
			$custom_field_list = $lab_config->getSpecimenCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				$field_name = $custom_field->fieldName;
				$field_id = $custom_field->id;
				if(in_array($field_id, $report_config->specimenCustomFields))
				{
					echo "<tr valign='top'>";
					echo "<td>".$field_name.":</td>";
					$custom_data = get_custom_data_specimen_bytype($specimen->specimenId, $custom_field->id);
					echo "<td>";
					if($custom_data == null)
					{
						echo "-";
					}
					else
					{
						$field_value = $custom_data->getFieldValueString($lab_config->id, 1);
						if(trim($field_value) == "")
							$field_value = "-";
						echo $field_value;
					}
					echo "</td>";					
					echo "</tr>";
				}
			}
		?>
	</tbody>
</table>
<br><br>
<?php
$test_list = get_tests_by_specimen_id($specimen_id);
foreach($test_list as $test_entry)
{
	$test_name = get_test_name_by_id($test_entry->testTypeId);
	$measure_list = get_test_type_measure($test_entry->testTypeId);
	$print_test_name = true;
	if(count($measure_list) == 1)
	{
		# Do nothing
		$print_test_name = false;
	}
	else
	{
		echo "<b>$test_name</b>";
		echo "<br>";
	}		
	if($test_entry == null)
	{
		echo "ERROR: Test type $test_name was not registered for Sample ID $specimen_id<br>";
	}
	else
	{
		list_results($test_entry, $print_test_name);
	}
}
?>
<br><br>
....................................
<h4><?php echo $report_config->footerText; ?></h4>
</div>
</div>