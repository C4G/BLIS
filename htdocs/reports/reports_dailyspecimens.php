<?php
#
# Main page for printing daily specimen records
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");
include("includes/page_elems.php");
LangUtil::setPageId("reports");

# Utility function
function get_records_to_print($lab_config, $test_type_id, $date_from, $date_to)
{
	$saved_db = DbUtil::switchToLabConfig($lab_config->id);
	$retval = array();
	
	if(isset($_REQUEST['p']) && $_REQUEST['p'] ==1)
		{
	
		$query_string =
		"SELECT * FROM test WHERE test_type_id=$test_type_id ".
		"AND result LIKE '' ".
		"AND specimen_id IN ( ".
			"SELECT specimen_id FROM specimen ".
			"WHERE (date_collected BETWEEN '$date_from' AND '$date_to') ".
		")";
		}
	 
		else
		if(isset($_REQUEST['ip']) && $_REQUEST['ip'] == 0)
	{
	$query_string =
		"SELECT * FROM test WHERE test_type_id=$test_type_id ".
		"AND result <> '' ".
		"AND specimen_id IN ( ".
			"SELECT specimen_id FROM specimen ".
			"WHERE (date_collected BETWEEN '$date_from' AND '$date_to') ".
		")";
		}
		else
		{
		
		$query_string =
		"SELECT * FROM test WHERE test_type_id=$test_type_id ".
		//"AND result <> '' ".
		"AND specimen_id IN ( ".
			"SELECT specimen_id FROM specimen ".
			"WHERE (date_collected BETWEEN '$date_from' AND '$date_to') ".
		")";
		}
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

$page_elems = new PageElems();
$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableTableSorter();
$script_elems->enableDragTable();

$date_from = $_REQUEST['yf']."-".$_REQUEST['mf']."-".$_REQUEST['df'];
$date_to = $_REQUEST['yt']."-".$_REQUEST['mt']."-".$_REQUEST['dt'];
$lab_config_id = $_REQUEST['l'];
$cat_code = $_REQUEST['c'];
$ttype = $_REQUEST['t'];

$uiinfo = "from=".$date_from."&to=".$date_to."&ct=".$cat_code."&tt=".$ttype;
putUILog('daily_log_specimens', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$lab_config = get_lab_config_by_id($lab_config_id);
$test_types = get_lab_config_test_types($lab_config_id);

$report_id = $REPORT_ID_ARRAY['reports_dailyspecimens.php'];
$report_config = $lab_config->getReportConfig($report_id);

$margin_list = $report_config->margins;
for($i = 0; $i < count($margin_list); $i++)
{
	$margin_list[$i] = ($SCREEN_WIDTH * $margin_list[$i] / 100);
}

if($ttype != 0)
{
	# Single test type selected
	$test_types = array();
	$test_types[] = $ttype;
}
else if($cat_code != 0)
{
	# Fetch all tests belonging to this category (aka lab section)
	$cat_test_types = TestType::getByCategory($cat_code);
	$cat_test_ids = array();
	foreach($cat_test_types as $test_type)
		$cat_test_ids[] = $test_type->testTypeId;
	$matched_test_ids = array_intersect($cat_test_ids, $test_types);
	$test_types = array_values($matched_test_ids);
}
?>
<script type='text/javascript'>
function export_as_word(div_id)
{
	var content = $('#'+div_id).html();
	$('#word_data').attr("value", content);
	$('#word_format_form').submit();
}

function report_fetch()
{ 	var yt= <?php echo $_REQUEST['yt'];?>;
	var yf=<?php echo $_REQUEST['yf'];?>;
	var mt=<?php echo $_REQUEST['mt'];?>;
	var mf=<?php echo $_REQUEST['mf'];?>;
	var dt=<?php echo $_REQUEST['dt'];?>;
	var df=<?php echo $_REQUEST['df'];?>;
	var l=<?php echo $_REQUEST['l'];?>;
	var cat_code=<?php echo $_REQUEST['c'];?>;
	var ttype=<?php echo $_REQUEST['t'];?>;
	var ip = 0;
	var p=0;
	if($('#ip').is(":checked"))
		ip = 1;
	if($('#p').is(":checked"))
		p = 1;
	var url = "reports_dailyspecimens.php?yt="+yt+"&mt="+mt+"&dt="+dt+"&yf="+yf+"&mf="+mf+"&df="+df+"&l="+l+"&c="+cat_code+"&t="+ttype+"&ip="+ip+"&p="+p;
	window.open(url);
	}

function print_content(div_id)
{
	var DocumentContainer = document.getElementById(div_id);
	var WindowObject = window.open("", "PrintWindow", "toolbars=no,scrollbars=yes,status=no,resizable=yes");
	var html_code = DocumentContainer.innerHTML;
	var do_landscape = $("input[name='do_landscape']:checked").attr("value");
	if(do_landscape == "Y")
		html_code += "<style type='text/css'> #report_config_content {-moz-transform: rotate(-90deg) translate(-300px); } </style>";WindowObject.document.writeln(html_code);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
	//javascript:window.print();
}

$(document).ready(function(){
	$('#report_content_table4').tablesorter();
});
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
</form>
		<input type='radio' name='do_landscape' value='N'<?php
		if($report_config->landscape == false) echo " checked ";
		?>>Portrait</input>
		&nbsp;&nbsp;
		<input type='radio' name='do_landscape' value='Y' <?php
		if($report_config->landscape == true) echo " checked ";
		?>>Landscape</input>&nbsp;&nbsp;
<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:export_as_word('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($_REQUEST['ip']==1){?><input type='checkbox' name='ip' id='ip' checked ></input> <?php echo "All Tests"; ?>
<?php } else{?><input type='checkbox' name='ip' id='ip'></input> <?php echo "All Tests"; }?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($_REQUEST['p']==1){?><input type='checkbox' name='p' id='p' checked ></input> <?php echo "Only Pending"; ?>
<?php } else{?><input type='checkbox' name='p' id='p'></input> <?php echo "Only Pending"; }?>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:report_fetch();" value='<?php echo LangUtil::$generalTerms['CMD_VIEW']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php $page_elems->getTableSortTip(); ?>
<hr>

<div id='export_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<style type='text/css'>
	<?php $page_elems->getReportConfigCss($margin_list, false); ?>
</style>
<div id='report_config_content'>
<h3><?php echo $report_config->headerText; ?></h3>
<h3><?php echo $report_config->titleText; ?></h3>
<?php
 if($date_from == $date_to)
 {
	echo LangUtil::$generalTerms['DATE'].": ".DateLib::mysqlToString($date_from);
 }
 else
 {
	echo LangUtil::$generalTerms['FROM_DATE'].": ".DateLib::mysqlToString($date_from);
	echo " | ";
	echo LangUtil::$generalTerms['TO_DATE'].": ".DateLib::mysqlToString($date_to);
 }
$record_list = array();
foreach($test_types as $test_type_id)
{
	$record_list[] = get_records_to_print($lab_config, $test_type_id, $date_from, $date_to);
}
$total_tests = 0;
foreach($record_list as $record)
{
	$total_tests += count($record);
}
?>	
<br>
 <?php if($cat_code != 0){ echo LangUtil::$generalTerms['LAB_SECTION']; ?>: <?php }
	if($cat_code == 0)
	{
		//echo LangUtil::$generalTerms['ALL'];
	}
	else
	{
		$cat_name = get_test_category_name_by_id($cat_code);
		echo $cat_name;
	}
	 if($ttype != 0 && $cat_code != 0)
	 {
 ?>
 |<?php  
 }
 if($ttype != 0) { echo LangUtil::$generalTerms['TEST_TYPE']; ?>: <?php }
	if($ttype == 0)
	{
		//echo LangUtil::$generalTerms['ALL'];
	}
	else
	{
		$test_name = get_test_name_by_id($ttype);
		echo $test_name;
	
	}



if(count($test_types) == 0)
{
	?>
	<br><br>
	<b><?php echo $cat_name; ?></b> <?php echo LangUtil::$pageTerms['TIPS_RECNOTFOUND']; ?>
	<?php # Line for Signature ?>
	<br><br>
	.............................
	<h4><?php echo $report_config->footerText; ?></h4>
	<?php
	return;
}
$record_list = array();
foreach($test_types as $test_type_id)
{
	$record_list[] = get_records_to_print($lab_config, $test_type_id, $date_from, $date_to);
}
$total_tests = 0;
foreach($record_list as $record)
{
	$total_tests += count($record);
}
?>

<?php
$no_match = true;
foreach($record_list as $record)
{
	if($record == null)
		continue;
	if(count($record) == 0)
		continue;
	if(count($record[0]) != 0)
	{
		$no_match = false;
		break;
	}
}
if($no_match === true)
{
	?>
	<?php echo LangUtil::$pageTerms['TIPS_RECNOTFOUND']; ?>
	<?php # Line for Signature ?>
	<br><br>
	.............................
	<h4><?php echo $report_config->footerText; ?></h4>
	<?php
	return;
}
?>
<table class='print_entry_border draggable' id='report_content_table4'>
<thead>
		<tr valign='top'>
			<?php
			if($report_config->useDailyNum == 1)
			{
				echo "<th>".LangUtil::$generalTerms['PATIENT_DAILYNUM']."</th>";
			}
			if($report_config->useSpecimenAddlId != 0)
			{
				echo "<th>".LangUtil::$generalTerms['SPECIMEN_ID']."</th>";
			}
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
				echo "<th>".LangUtil::$generalTerms['TEST']."</th>";
			}
			if($report_config->useComments == 1)
			{
				echo "<th>".LangUtil::$generalTerms['COMMENTS']."</th>";
			}
			if($report_config->useReferredTo == 1)
			{
				echo "<th>".LangUtil::$generalTerms['REF_TO']."</th>";
			}
			if($report_config->useReferredToHospital == 1)
			{
				echo "<th>"."Referred From"."</th>";
			}
			if($report_config->useDoctor == 1)
			{
				echo "<th>".LangUtil::$generalTerms['DOCTOR']."</th>";
			}
			if($report_config->useResults == 1)
			{
				echo "<th>".LangUtil::$generalTerms['RESULTS']."</th>";
			}
			if($report_config->useRange == 1)
			{
				echo "<th style='width:120px;'>".LangUtil::$generalTerms['RANGE']."</th>";
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
	//ho "rl".count($record_list);
	foreach($record_list as $record_set_array)
	{ //ho "eeel".count($record_set_array);
		foreach($record_set_array as $record_set)
		{
		if(count($record_set) == 0)
			continue;
		$value = $record_set;
		$test = $value[0];
		$specimen = $value[1];
		$patient = $value[2];
		?>
		<tr valign='top'>
			<?php
			if($report_config->useDailyNum == 1)
			{
				echo "<td>".$specimen->getDailyNum()."</td>";
			}
			if($report_config->useSpecimenAddlId == 1)
			{
				echo "<td>";
				$specimen->getAuxId();
				echo "</td>";
			}
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
			if($report_config->useReferredToHospital == 1)
			{
				echo "<td>".$specimen->getReferredFromName()."</td>";
			}
			if($report_config->useDoctor == 1)
			{
				echo "<td>".$specimen->getDoctor()."</td>";
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
			if($report_config->useRange == 1)
			{
				echo "<td>";
				$test_type = TestType::getById($test->testTypeId);
				$measure_list = $test_type->getMeasures();
				foreach($measure_list as $measure)
						{
						$type=$measure->getRangeType();
						if($type==Measure::$RANGE_NUMERIC)
						{
						$range_list_array=$measure->getRangeString($patient);
					$lower=$range_list_array[0];
					$upper=$range_list_array[1];
						?>(
		<?php
			$unit=$measure->unit;
			if(stripos($unit,",")!=false)
		{	
			$units=explode(",",$unit);
			$lower_parts=explode(".",$lower);
			$upper_parts=explode(".",$upper);
			if($lower_parts[0]!=0)
			{
			echo $lower_parts[0];
			echo $units[0];
			}
			if($lower_parts[1]!=0)
			{
			echo $lower_parts[1];
			echo $units[1];
			}
			echo " - ";
			if($upper_parts[0]!=0)
			{
			echo $upper_parts[0];
			echo $units[0];
			}
			if($upper_parts[1]!=0)
			{
			echo $upper_parts[1];
			echo $units[1];
			}

		}
		else if(stripos($unit,":")!=false)
		{
		$units=explode(":",$unit);
			
		echo $lower;
		?><sup><?php echo $units[0]; ?></sup> - 
		<?php echo $upper;?> <sup> <?php echo $units[0]; ?> </sup>
		<?php
		echo " ".$units[1];
		}
		
		else
		{			
			echo $lower; ?>-<?php echo $upper; 
			echo " ".$measure->unit;
		}
		?>)&nbsp;&nbsp;	
			
			<?php
		//echo " ".$measure->unit;
	//	echo "<br>";
		
		
		
							
						}
						//echo $measure->getRangeString($patient);
						else
							echo "&nbsp;&nbsp;&nbsp;".$measure->unit;
							echo "<br>";
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
	}
	?>
	</tbody>
	</table>
		<?php echo LangUtil::$pageTerms['TOTAL_TESTS']; ?>: <?php echo $total_tests; ?> 


	<br>
	<?php

?>

<?php # Line for Signature ?>
.............................
<h4><?php echo $report_config->footerText; ?></h4>
</div>
</div>