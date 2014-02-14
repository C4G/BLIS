<?php
#
# Creates printable worksheet of pending tests for a particular test type
#

# Redirect to worksheet_custom.php if custom worksheet selected
$worksheet_id = $_REQUEST['w_type'];
if(trim($worksheet_id) != "")
{
	$url_redirect = "worksheet_custom.php?id=$worksheet_id";
	if($_REQUEST['is_blank'] == "Y")
	{
		$num_rows = 10;
		if(is_nan($_REQUEST['num_rows']))
			$num_rows = 10;
		else
			$num_rows = intval($_REQUEST['num_rows']);
		$url_redirect .= "&ib=1&bn=".$num_rows;
	}
	header("location:".$url_redirect);
}

include("redirect.php");
include("includes/db_lib.php");
LangUtil::setPageId("results_entry");

include("includes/script_elems.php");
include("includes/page_elems.php");

$page_elems = new PageElems();
$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableTableSorter();
$script_elems->enableDragTable();

$cat_code = $_REQUEST['cat_code'];
$test_type_id = $_REQUEST['t_type'];
$is_blank = false;
if($_REQUEST['is_blank'] == "Y")
	$is_blank = true;
$num_rows = 10;
if(is_nan($_REQUEST['num_rows']))
	$num_rows = 10;
else
	$num_rows = intval($_REQUEST['num_rows']);

//$test_name = get_test_name_by_id($test_type_id);
//$test_type = TestType::getById($test_type_id);
//$measure_list = $test_type->getMeasures();
$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
$report_id = $REPORT_ID_ARRAY['worksheet.php'];
if($test_type_id != 0)
	$report_config = $lab_config->getWorkSheetConfig($test_type_id);
else
	$report_config = $lab_config->getReportConfig(5);
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
	var html_code = DocumentContainer.innerHTML;
	if($('#do_landscape').is(":checked"))
		html_code += "<style type='text/css'> #report_config_content {-moz-transform: rotate(-90deg) translate(-300px); } </style>";
	WindowObject.document.writeln(html_code);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
	//javascript:window.print();
}

$(document).ready(function(){
	$('.report_content_table').tablesorter();
});
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
</form>
<input type='checkbox' id='do_landscape' <?php
if($report_config->landscape == true) echo " checked ";
?>><?php echo LangUtil::$generalTerms['LANDSCAPE']; ?></input>&nbsp;&nbsp;

<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:export_as_word('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
LangUtil::setPageId("reports");
$page_elems->getTableSortTip();
LangUtil::setPageId("results_entry"); 
?>
<hr>
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
<br>
<?php echo LangUtil::$generalTerms['TECHNICIAN']; ?>: <?php echo get_username_by_id($_SESSION['user_id']); ?>
<?php 
if($cat_code != 0)
{
	echo " | ".LangUtil::$generalTerms['LAB_SECTION'].": ".get_test_category_name_by_id($cat_code); 
}
?>
<br><br>
<?php
# Build list of test types to handle
$test_type_list = array();
if($test_type_id != 0)
{
	# Only one test type selected
	$test_type_list[] = TestType::getById($test_type_id);
}
else
{
	# Fetch all test types belonging to this lab section
	$test_type_list = get_test_types_by_site_category($_SESSION['lab_config_id'], $cat_code);
}
if(count($test_type_list) == 0 && $is_blank === false)
{
	# No tests exist in this lab onfiguration for the chosen lab section
	echo LangUtil::$pageTerms['MSG_PENDINGNOTFOUND'];
	return;
}
foreach($test_type_list as $test_type)
{
###########
$report_config = $lab_config->getWorkSheetConfig($test_type_id);
$test_name = $test_type->getName();
echo LangUtil::$generalTerms['TEST_TYPE']; ?>: <?php echo $test_name;
$measure_list = $test_type->getMeasures();
$test_list = get_pending_tests_by_type($test_type->testTypeId);
if(count($test_list) == 0 && $is_blank === false)
{
	echo "<br><br>".LangUtil::$pageTerms['TIPS_NOSPECIMENSTOTEST'];
	return;
}
?>
<br><br>
<table id='worksheet_<?php echo $test_type_id; ?>' class='print_border report_content_table draggable' style='width:900px'>
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
			if($report_config->useSpecimenAddlId == 1)
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
			if($report_config->useComments == 1)
			{
				echo "<th>".LangUtil::$generalTerms['COMMENTS']."</th>";
			}
			if($report_config->useReferredTo == 1)
			{
				echo "<th>".LangUtil::$generalTerms['REF_TO']."</th>";
			}
			if($report_config->useDoctor == 1)
			{
				echo "<th>".LangUtil::$generalTerms['DOCTOR']."</th>";
			}
			if($report_config->useTestName == 1 || $report_config->useResults == 1)
			{
				//echo "<th>".$test_name."</th>";
				$test_entry = TestType::getById($test_type_id);
				$measure_list = $test_entry->getMeasures();
				foreach($measure_list as $measure)
				{
					$count = 0;
					$range = $measure->range;
					if(strpos($range, ":") !== false)
					{
						echo "<th>";
						echo $measure->name;
						echo "</th>";
					}
					else if(strpos($range, "/") !== false)
					{
						$range_parts = explode("/", $range);
						echo "<th>";
						echo $measure->name;
						echo "</th>";
						/*
						foreach($range_parts as $option_value)
						{
							
							if($count == 0)
							{
								echo $measure->name;
								$count++;
							}
							echo "</th>";
						}*/						
					}
					$count++;					
				}
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
		<?php
		if($report_config->useTestName == 1 || $report_config->useResults == 1)
		{
			# Row for showing ranges/measure options 
		?>
		<tr valign='top'>
			<?php
			if($report_config->usePatientId == 1)
			{
			?>
				<th></th>
			<?php
			}
			if($report_config->usePatientAddlId == 1)
			{
			?>
				<th></th>
			<?php
			}
			if($report_config->useSpecimenAddlId == 1)
			{
				echo "<th></th>";
			}
			if($report_config->useDailyNum == 1)
			{
				echo "<th></th>";
			}
			if($report_config->useSpecimenName == 1)
			{
				echo "<th></th>";
			}
			if($report_config->usePatientName == 1)
			{
			?>
				<th></th>
			<?php
			}
			if($report_config->useAge == 1)
			{
			?>
				<th></th>
			<?php
			}
			if($report_config->useGender == 1)
			{
			?>			
				<th></th>
			<?php
			}
			if($report_config->useDob == 1)
			{
			?>
				<th></th>
			<?php 
			}
			# Patient Custom fields here
			$custom_field_list = $lab_config->getPatientCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				if(in_array($custom_field->id, $report_config->patientCustomFields))
				{	
					echo "<th>";
					echo "</th>";
				}
			}
			if($report_config->useDateRecvd == 1)
			{
				echo "<th>";
				echo "</th>";
			}
			# Specimen Custom fields headers here
			$custom_field_list = $lab_config->getSpecimenCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				$field_name = $custom_field->fieldName;
				$field_id = $custom_field->id;
				if(in_array($field_id, $report_config->specimenCustomFields))
				{
					echo "<th>";
					echo "</th>";
				}
			}
			if($report_config->useComments == 1)
			{
				echo "<th>";
				echo "</th>";
			}
			if($report_config->useReferredTo == 1)
			{
				echo "<th>";
				echo "</th>";
			}
			if($report_config->useDoctor == 1)
			{
				echo "<th></th>";
			}
			if($report_config->useTestName == 1 || $report_config->useResults == 1)
			{
				//echo "<th>".$test_name."</th>";
				$test_entry = TestType::getById($test_type_id);
				$measure_list = $test_entry->getMeasures();
				foreach($measure_list as $measure)
				{
					# Show range/options here
					echo "<th>";
					if($report_config->useRange == 1)
						echo $measure->getRangeString();
					echo "</th>";
				}
			}
			if($report_config->useEntryDate == 1)
			{
				echo "<th></th>";
			}
			if($report_config->useRemarks == 1)
			{
				echo "<th></th>";
			}
			if($report_config->useEnteredBy == 1)
			{
				echo "<th></th>";
			}
			if($report_config->useVerifiedBy == 1)
			{
				echo "<th></th>";
			}
			if($report_config->useStatus == 1)
			{
				echo "<th></th>";
			}
			?>
		</tr>
		<?php
		}
		?>
	</thead>
	<tbody>
	<?php
	if($is_blank)
	{
		for($i = 1; $i <= $num_rows; $i++)
		{
		?>
		<tr valign='top'>
			<?php
			if($report_config->usePatientId == 1)
			{
			?>
				<td><br><br></td>
			<?php
			}
			if($report_config->usePatientAddlId == 1)
			{
			?>
				<td><br><br></td>
			<?php
			}
			if($report_config->useSpecimenAddlId == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useDailyNum == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useSpecimenName == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->usePatientName == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useAge == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useGender == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useDob == 1)
			{
				echo "<td><br><br></td>";
			}
			# Patient Custom fields here
			$custom_field_list = $lab_config->getPatientCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				if(in_array($custom_field->id, $report_config->patientCustomFields))
				{	
					$field_name = $custom_field->fieldName;				
					$custom_data = get_custom_data_patient_bytype($patient->patientId, $custom_field->id);
					echo "<td><br><br></td>";
				}
			}
			if($report_config->useDateRecvd == 1)
			{
				echo "<td><br><br></td>";
			}
			# Specimen Custom fields here
			$custom_field_list = $lab_config->getSpecimenCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				if(in_array($custom_field->id, $report_config->specimenCustomFields))
				{
					echo "<td><br><br></td>";
				}
			}
			if($report_config->useComments == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useReferredTo == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useDoctor == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useTestName == 1 || $report_config->useResults == 1)
			{
				$test_entry = TestType::getById($test_type_id);
				$measure_list = $test_entry->getMeasures();
				foreach($measure_list as $measure)
				{
					# Show range/options here
					$range = $measure->range;
					if(strpos($range, ":") !== false)
					{
						echo "<td>";
						echo "</td>";
					}
					else if(strpos($range, "/") !== false)
					{
						echo "<td>";
						echo "</td>";
						/*
						$range_parts = explode("/", $range);
						foreach($range_parts as $option_value)
						{
							echo "<td>";	
							echo "</td>";
						}*/						
					}
				}
			}
			if($report_config->useEntryDate == 1)
			{
				echo "<td><br><br>";
				echo "</td>";
			}
			if($report_config->useRemarks == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useEnteredBy == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useVerifiedBy == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useStatus == 1)
			{
				echo "<td><br><br></td>";
			}
			?>
		</tr>
		<?php
		}
		
	}
	else
	{
	foreach($test_list as $test_entry)
	{
		$specimen_id = $test_entry->specimenId;
		$specimen = get_specimen_by_id($specimen_id);
		$patient = Patient::getById($specimen->patientId);
		$test = $test_entry;
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
			if($report_config->useSpecimenAddlId == 1)
			{
				echo "<td>";
				$specimen->getAuxId();
				echo "</td>";
			}
			if($report_config->useDailyNum == 1)
			{
				?>
				<td><?php echo $specimen->getDailyNumFull(); ?></td>
				<?php
			}
			if($report_config->useSpecimenName == 1)
			{
				echo "<td>".get_specimen_name_by_id($specimen->specimenTypeId)."</td>";
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
				<td><?php echo $patient->getAgeNumber(); ?></td>
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
			if($report_config->useDoctor == 1)
			{
				echo "<td>".$specimen->getDoctor()."</td>";
			}
			if($report_config->useTestName == 1 || $report_config->useResults == 1)
			{
				$test_entry = TestType::getById($test_type_id);
				$measure_list = $test_entry->getMeasures();
				foreach($measure_list as $measure)
				{
					# Show range/options here
					$range = $measure->range;
					if(strpos($range, ":") !== false)
					{
						echo "<td>";
						echo "</td>";
					}
					else if(strpos($range, "/") !== false)
					{
						$range_parts = explode("/", $range);
						echo "<td>";	
						echo "</td>";
						/*
						foreach($range_parts as $option_value)
						{
							echo "<td>";	
							echo "</td>";
						}
						*/						
					}
				}
			}
			if($report_config->useEntryDate == 1)
			{
				echo "<td><br><br>";
				echo "</td>";
			}
			if($report_config->useRemarks == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useEnteredBy == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useVerifiedBy == 1)
			{
				echo "<td><br><br></td>";
			}
			if($report_config->useStatus == 1)
			{
				echo "<td><br><br></td>";
			}
			?>
		</tr>
		<?php
	}
	}
	?>
	</tbody>
</table>
<br>
<?php
#########
}
?>
<br><br>
.....................................
<h4><?php echo $report_config->footerText; ?></h4>
</div>
</div>