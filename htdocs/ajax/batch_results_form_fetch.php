<?php
#
# Returns batch results entry form for a given test type
# Called via ajax from results_entry.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
LangUtil::setPageId("results_entry");

$page_elems = new PageElems();

$test_type_id = $_REQUEST['t_type'];
$date_to=$_REQUEST['date_to'];
$date_from=$_REQUEST['date_from'];
$date_from_array=explode("-",$date_from);
$date_to_array=explode("-",$date_to);

$test_type = TestType::getById($test_type_id);
$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
$worksheet_config = $lab_config->getWorkSheetConfig($test_type_id);

# Fetch all measures for this test type
$measure_list = $test_type->getMeasures();
# Create a table with specimen ID field and these measures
# Fetch currently pending tests for this test type
$pending_tests = get_pending_tests_by_type_date($test_type_id , $date_from , $date_to);
if(count($pending_tests) == 0 || $pending_tests == null)
{
	?>
	<div class='sidetip_nopos'>
		<?php echo get_test_name_by_id($test_type_id)." ".LangUtil::$pageTerms['MSG_PENDINGNOTFOUND']; ?>.
	</div>
	<?php
	return;
}
?>
<small><?php echo count($pending_tests)." ".LangUtil::$generalTerms['SPECIMENS']; ?></small><br>
<form id='batch_form' name='batch_form' action='results_batch_add.php' method='post'>
<?php # Hidden field for tracking test type ?>
<input type='hidden' name='t_type' value='<?php echo $test_type_id; ?>'></input>
<input type='hidden' name='num_measures' value='<?php echo count($measure_list); ?>'></input>
<?php # Table of result fields ?>

<table class='tablesorter' id='batch_result_table'>
<thead>
	<tr valign='top'>
		<?php
		if($worksheet_config->usePatientId != 0)
		{
			?>
			<th><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
			<?php
		}
		if($worksheet_config->useDailyNum != 0)
		{
			?>
			<th><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></th>
			<?php
		}
		if($worksheet_config->useSpecimenAddlId != 0)
		{
			?>
			<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
			<?php
		}
		if($worksheet_config->usePatientName != 0)
		{
			?>
			<th><?php echo LangUtil::$generalTerms['PATIENT']; ?></th>
			<?php
		}
		if($worksheet_config->useAge == 1)
		{
			?>
				<th><?php echo LangUtil::$generalTerms['AGE']; ?></th>
			<?php
		}
		if($worksheet_config->useGender == 1)
		{
			?>			
				<th><?php echo LangUtil::$generalTerms['GENDER']; ?></th>
			<?php
		}
		if($worksheet_config->useDob == 1)
		{
			?>
				<th><?php echo LangUtil::$generalTerms['DOB']; ?></th>
			<?php 
		}
		?>
						
		<?php 
		# Patient Custom fields here
		$custom_field_list = $lab_config->getPatientCustomFields();
		if(count($custom_field_list) > 0 ) {
			foreach($custom_field_list as $custom_field)
			{
				if($worksheet_config) {
					if(in_array($custom_field->id, $worksheet_config->patientCustomFields))
					{	
						$field_name = $custom_field->fieldName;				
						echo "<th>";
						echo $field_name;
						echo "</th>";
					}
				}
			}
		}
		if($worksheet_config->useDateRecvd == 1)
		{
			echo "<th>".LangUtil::$generalTerms['R_DATE']."</th>";
		}
		# Specimen Custom fields headers here
		$custom_field_list = $lab_config->getSpecimenCustomFields();
		foreach($custom_field_list as $custom_field)
		{
			$field_name = $custom_field->fieldName;
			$field_id = $custom_field->id;
			if(in_array($field_id, $worksheet_config->specimenCustomFields))
			{
				echo "<th>".$field_name."</th>";
			}
		}
		if($worksheet_config->useComments == 1)
		{
			echo "<th>".LangUtil::$generalTerms['COMMENTS']."</th>";
		}
		if($worksheet_config->useReferredTo == 1)
		{
			echo "<th>".LangUtil::$generalTerms['REF_TO']."</th>";
		}
		if($worksheet_config->useDoctor == 1)
		{
			echo "<th>".LangUtil::$generalTerms['DOCTOR']."</th>";
		}
		foreach($measure_list as $measure)
		{
			echo "<th>".$measure->getName()."<br><small>";
			if(strpos($measure->range, ":") != false)
			{
				$range_bounds = explode(":", $measure->range);
				echo " (".LangUtil::$generalTerms['RANGE']." $range_bounds[0] - $range_bounds[1])";
			}
			if($measure->unit != "")
				echo "($measure->unit)";
			echo "</small></th>";
		}
		?>
		<th><?php echo LangUtil::$generalTerms['RESULT_COMMENTS']." (".LangUtil::$generalTerms['OPTIONAL'].")"; ?></th>
		<th><?php echo LangUtil::$generalTerms['CMD_SKIP']; ?>?</th>
		<th><!-- Related Tests Column --></th>
	</tr>
</thead>
<tbody>
	<?php
	for($i = 1; $i <= count($pending_tests); $i++)
	{
	?>
	<tr valign='top'>
		<?php
		$specimen = Specimen::getById($pending_tests[$i-1]->specimenId);
		$patient = Patient::getById($specimen->patientId);
		if($worksheet_config->usePatientId != 0)
		{
			?>
			<td><?php echo $patient->getSurrogateId(); ?></td>
			<?php
		}
		if($worksheet_config->useDailyNum != 0)
		{
			?>
			<td><?php echo $specimen->getDailyNumFull(); ?></td>
			<?php
		}
		if($worksheet_config->useSpecimenAddlId != 0)
		{
			echo "<td>";
			$specimen->getAuxId(); 
			echo "</td>";
		}
		if($worksheet_config->usePatientName != 0)
		{
			echo "<td>";
			echo $patient->name;
			echo "</td>";
		}
		if($worksheet_config->useAge == 1)
		{
			echo "<td>";
			echo $patient->getAgeNumber();
			echo "</td>";
		}
		if($worksheet_config->useGender == 1)
		{
			echo "<td>";
			echo $patient->sex;
			echo "</td>";
		}
		if($worksheet_config->useDob == 1)
		{
			echo "<td>";
			echo $patient->getDob();
			echo "</td>";
		}
		# Patient Custom fields here
		$custom_field_list = $lab_config->getPatientCustomFields();
		if( count($custom_field_list) > 0 ) {
			foreach($custom_field_list as $custom_field)
			{
				if($worksheet_config) {
					if(in_array($custom_field->id, $worksheet_config->patientCustomFields))
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
			}
		}
		if($worksheet_config->useDateRecvd == 1)
		{
			echo "<td>".DateLib::mysqlToString($specimen->dateRecvd)."</td>";
		}
		# Specimen Custom fields headers here
		$custom_field_list = $lab_config->getSpecimenCustomFields();
		if( count($custom_field_list) > 0 ) {
			foreach($custom_field_list as $custom_field)
			{
				if(in_array($custom_field->id, $worksheet_config->specimenCustomFields))
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
		}
		if($worksheet_config->useComments == 1)
		{
			echo "<td>";
			echo $specimen->getComments();
			echo "</td>";
		}
		if($worksheet_config->useReferredTo == 1)
		{
			echo "<td>".$specimen->getReferredToName()."</td>";
		}
		if($worksheet_config->useDoctor == 1)
		{
			echo "<td>".$specimen->getDoctor()."</td>";
		}
		?>
		<input type='hidden' name='specimen_id[]' value='<?php echo $pending_tests[$i-1]->specimenId; ?>'></input>
		<?php
		$measure_count = 1;
		foreach($measure_list as $measure)
		{
			if((strpos($measure->range, "/") != false) && (strpos($measure->range, "_") == false))
			{	
				# Discrete value range
				$range_options = explode("/", $measure->range);
				?>
				<td>
				<select name='measure_<?php echo $specimen->specimenId."_".$measure_count; ?>[]' multiple="multiple" size="4">
				<?php
				foreach($range_options as $option1)
				{
				$option=str_replace("#","/",$option1)
				?>
					<option value='<?php echo $option; ?>'><?php echo $option; ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<?php
			}
			else if(strpos($measure->range, "_") != false)
			{	
				# Discrete value range
				$range_options = explode("_", $measure->range);
				?>
				<td>
				<select name='measure_<?php echo $specimen->specimenId."_".$measure_count; ?>[]' multiple="multiple" size="4">
				<?php
				foreach($range_options as $option1)
				{
					$option=str_replace("@","_",$option1)
				?>
				
					<option value='<?php echo $option; ?>'><?php echo $option; ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<?php
			}
			else 
				# Continuous value range
				echo "<td><input type='text' name='measure_".$specimen->specimenId."_".$measure_count."[]' style='width:35px;'></input></td>";
			$measure_count++;
		}
		?>
		<td><input name='comments[]' type='text'></input></td>
		<td>
			<center>
			<input type='checkbox' name='skip_<?php echo $i; ?>' title='Tick the box to Skip entering results for this Specimen'></input>
			</center>
		</td>
		<td><a href="javascript:fetch_specimen3(<?php echo $specimen->specimenId;?>,<?php echo $test_type_id; ?>)">Related Tests for this specimen</a></td>
	</tr>
	<!-- <tr valign="top" class="related_tests_tr_<?php echo $specimen->specimenId; ?>" >
		<td colspan="100%"><div class='result_form_pane_batch' id='result_form_pane_batch_<?php echo $specimen->specimenId; ?>'>
		 </div></td>
	</tr>  -->
	<script type="text/javascript">
	
	</script>
	<?php
	}
	?>
	
</tbody>
</table>
<script type='text/javascript'>
$(document).ready(function(){
	var rows = $('table.tablesorter tr');
	alert("Test");
	rows.filter('.related_tests_tr_'+specimen_id).hide();
}
</script>
<!--
<small>
<a href='javascript:add_one_batch_row();'>Add another row &raquo;</a>
 | <a href='javascript:add_five_batch_rows();'>Add 5 more rows &raquo;</a>
</small>
<br>
-->
<br>
<input type='button' id='batch_submit_button' onclick='javascript:submit_batch_form();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href='javascript:clear_batch_table();' id='batch_cancel_button'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<span id='batch_submit_progress' style='display:none'>
<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
</span>
</form>