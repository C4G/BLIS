<?php
#
# Returns specimen result entry form
# Called via ajax from results_entry.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
include("../includes/ajax_lib.php");
include("../includes/user_lib.php");
LangUtil::setPageId("results_entry");
$page_elems = new PageElems();

function get_result_form($test_type, $test_id, $num_tests, $patient)
{
	# Returns HTML form elements for given test type results
	
	global $form_id_list, $specimen_id, $page_elems;
	
	$curr_form_id = 'test_'.$test_type->testTypeId;
	$form_id_list[] = $curr_form_id;
	?>
	<script type='text/javascript'>
	$(document).ready(function() {
		$(".enable_check").each(function() {
			toggle_form('<?php echo $curr_form_id; ?>', this);
		});
		
	});
	function update_remarks1()
	{
		var result_elems = $("input[name='result[]']").attr("value");
				if(isNaN(result_elems))
		{	
			alert("Value expected for result is numeric.");
			return;
		}
		update_remarks(<?php echo $test_type->testTypeId; ?>, <?php echo count($measure_list); ?>, <?php echo $patient->getAgeNumber(); ?>, '<?php echo $patient->sex;?>');
	}
	</script>
	<form name='<?php echo $curr_form_id; ?>' id='<?php echo $curr_form_id; ?>' action='' method=''>
	<input type='hidden' name='test_id' value='<?php echo $test_id; ?>'></input>
	<input type='hidden' name='specimen_id' value='<?php echo $specimen_id; ?>'></input>
	<?php
	# Fetch all measures for this test
	$measure_list = $test_type->getMeasures();
        
        $submeasure_list = array();
                $comb_measure_list = array();
               // print_r($measure_list);
                
                foreach($measure_list as $measure)
                {
                    
                    $submeasure_list = $measure->getSubmeasuresAsObj();
                    //echo "<br>".count($submeasure_list);
                    //print_r($submeasure_list);
                    $submeasure_count = count($submeasure_list);
                    
                    if($measure->checkIfSubmeasure() == 1)
                    {
                        continue;
                    }
                        
                    if($submeasure_count == 0)
                    {
                        array_push($comb_measure_list, $measure);
                    }
                    else
                    {
                        array_push($comb_measure_list, $measure);
                        foreach($submeasure_list as $submeasure)
                           array_push($comb_measure_list, $submeasure); 
                    }
                }
                $measure_list = $comb_measure_list;
	# Create form element for each measure
	$count = 0;
	foreach($measure_list as $measure)
	{
		$input_id = 'measure_'.$test_type->testTypeId."_".$count;
                $decName = "";
                if($measure->checkIfSubmeasure() == 1)
                                    {
                                        $decName = $measure->truncateSubmeasureTag();
                                        $decName.":";
                                    }
                                    else
                                    {
					$decName = $measure->getName().":";
                                    }
		?>
        
		<label for='<?php echo $input_id; ?>'><?php echo $decName; echo "\n"; ?></label>
		<?php
		$range = $measure->range;
		$range_type = $measure->getRangeType();
		$range_values = $measure->getRangeValues($patient);
		if($range_type == Measure::$RANGE_OPTIONS)
		{
		?>
			<select name='result[]' id='<?php echo $input_id; ?>' class='uniform_width' onchange="javascript:update_remarks(<?php echo $test_type->testTypeId; ?>, <?php echo count($measure_list); ?> ,<?php echo $patient->getAgeNumber(); ?>, '<?php echo $patient->sex;?>');">
			<option></option>
			<?php
			foreach($range_values as $option)
			{
				$option= str_replace('#', '/', $option);
				?>
				<option value='<?php echo $option; ?>'><?php echo str_replace('#', '/', $option); ?></option>
				<?php
			}
			?>
			</select>
		<?php
		}
		else if($range_type == Measure::$RANGE_NUMERIC)
		{
			# Continuous value range
			$age=$patient->getAgeNumber();
			?>
			<input class='uniform_width' type='text' name='result[]' id='<?php echo $input_id; ?>' onchange="javascript:update_remarks1();"></input>
			<span id='<?php echo $input_id; ?>_range'>
			&nbsp;(<?php 
			$unit=$measure->unit;
			if(stripos($unit,",")!=false)
		{	
			$units=explode(",",$unit);
			$lower_parts=explode(".",$range_values[0]);
			$upper_parts=explode(".",$range_values[1]);
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
			?>-<?php
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
?>)<?php
		}else
		{	if(stripos($unit,":")!=false)
				{		
			$units=explode(":",$unit);
			echo $range_values[0]; ?><sup><?php echo $units[0] ?></sup>-<?php echo $range_values[1];?><sup><?php echo $units[0] ?></sup>)
		<?php 
	}
		else
		{
		echo $range_values[0]; ?>-<?php echo $range_values[1];?>)<?php } ?>
		</span>
			<?php
			}
		}
		else if($range_type == Measure::$RANGE_AUTOCOMPLETE)
		{
			# Autocomplete values
			# Use jquery.token-input plugin
			$url_string = "ajax/measure_autocomplete.php?id=".$measure->measureId;
			$hint_text = "Type to enter results";
			echo "<div>";
			$page_elems->getTokenList($count, $input_id, "result[]", $url_string, $hint_text,"");
			echo "</div>";
			
		}
                else if($range_type == Measure::$RANGE_FREETEXT)
		{
                        # Text box
                    echo "<div>";
                        echo "<textarea name='result[]' id='$input_id' class='uniform_width results_entry'></textarea>";
                    echo "</div>";
                                	
		}
		if(stripos($measure->unit,":")!=false)
		{
		$units=explode(":",$measure->unit);
		echo $units[1];
		}else
		if(stripos($measure->unit,",")===false)
		echo $measure->unit;
		
		if($num_tests > 0 && $count == 0)
		{
			# Checkbox to skip results for this test type
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<small>
			<input type='checkbox' id='<?php echo $curr_form_id; ?>_skip' class="enable_check" title='Tick this box if results are available and ready to enter' onclick="javascript:toggle_form('<?php echo $curr_form_id; ?>', this);">
			<?php //echo LangUtil::$generalTerms['CMD_SKIP']; 
			      echo "Enable Result Entry"; ?>
			</input>
			</small>
			<?php
		}
		echo "<br>";
		$count++;
	}
	?>
	<table><tr><td>
	<label for='<?php echo $curr_form_id; ?>_comments'>
		Result Interpretation
	</label></td><td>
	<span id='<?php echo $curr_form_id; ?>_comments_span'>
		<textarea name='comments' id='<?php echo $curr_form_id; ?>_comments'  class='uniform_width'  onfocus="javascript:update_remarks(<?php echo $test_type->testTypeId; ?>, <?php echo count($measure_list); ?>, <?php echo $patient->getAgeNumber(); ?>, '<?php echo $patient->sex;?>');" ></textarea>
	</span></td><tr><td>
	<label for='<?php echo $curr_form_id; ?>_comments_1'>
		<?php echo LangUtil::$generalTerms['RESULT_COMMENTS']; ?> (<?php echo LangUtil::$generalTerms['OPTIONAL']; ?>)
	</label></td><td>
	<span id='<?php echo $curr_form_id; ?>_comments_span'>
		<textarea name='comments_1' id='<?php echo $curr_form_id; ?>_comments_1'  class='uniform_width'></textarea>
	</span>
	</td></tr>
	<tr><td>
	<label for='<?php echo $curr_form_id; ?>_date_1'>
		Date of Entry
	</label></td><td>
	<span id='<?php echo $curr_form_id; ?>_date_l'>
	<?php $name_list = array("yyyy_to", "mm_to", "dd_to");
		 $id_list = $name_list;
		 $today = date("Y-m-d");
		$today_array = explode("-", $today);
		$value_list = $today_array;
		$page_elems->getDatePicker($name_list, $id_list, $value_list); ?>
		</span>
	</td></tr>
	</table>
	</form>
	<?php
}

$form_id_list = array();
$specimen_id = $_REQUEST['sid'];

$test_id = -1 ;
if(isset($_REQUEST['test_id'])) {
	$test_id = $_REQUEST['test_id'];
}



if($specimen_id == "")
{
	echo "<span class='error_string'>".LangUtil::$generalTerms['SPECIMEN_ID']."  ".$specimen_id." ".LangUtil::$generalTerms['MSG_NOTFOUND'].".</span>";
	return;
}
?>
<?php
$specimen = get_specimen_by_id($specimen_id);
$patient = Patient::getById($specimen->patientId);
if($specimen == null)
{
	echo "<span class='error_string'>".LangUtil::$generalTerms['SPECIMEN_ID']."  ".$specimen_id." ".LangUtil::$generalTerms['MSG_NOTFOUND'].".</span>";
	return;
}
if($specimen->statusCodeId == Specimen::$STATUS_DONE)
{
	?>
	<div class='sidetip_nopos' style='width:350px;'>
	<?php 
	echo LangUtil::$pageTerms['MSG_ALREADYENTERED']."- ";
	if($_SESSION['sid'] != 0)
	{
		echo "<br>";
		echo LangUtil::$generalTerms['SPECIMEN_ID'].": ";
		echo $specimen->getAuxId();
	}
	echo "<br>";
	echo LangUtil::$generalTerms['SPECIMEN_TYPE'].": ".get_specimen_name_by_id($specimen->specimenTypeId);
	echo "<br>";
	//if($_SESSION['pnamehide'] == 0)
	if($_SESSION['user_level'] == $LIS_TECH_SHOWPNAME)
	{
		echo LangUtil::$generalTerms['PATIENT'].": $patient->name ($patient->sex ".$patient->getAgeNumber().") <br>";
	}
	else
	{
		echo LangUtil::$generalTerms['GENDER']."/".LangUtil::$generalTerms['AGE'].": $patient->sex /".$patient->getAgeNumber()."<br>";
	}
	?>
	<br><a href='specimen_info.php?sid=<?php echo $specimen->specimenId; ?>'> <?php echo LangUtil::$generalTerms['DETAILS']; ?> &raquo;</a>
	</div>
	<?php
	return;
}
# Print HTML results form
$test_list = get_tests_by_specimen_id($specimen->specimenId);
$patient = get_patient_by_id($specimen->patientId);
?>
<div class='pretty_box'>

<?php
if(0)
{
if($_SESSION['sid'] != 0)
{
	echo LangUtil::$generalTerms['SPECIMEN_ID'].": ";
	$specimen->getAuxId();
	echo "<br>";
}
if($_SESSION['pid'] != 0)
{
	echo LangUtil::$generalTerms['PATIENT_ID'].": ".$patient->surrogateId."<br>";
}
if($_SESSION['dnum'] != 0)
{
	echo LangUtil::$generalTerms['PATIENT_DAILYNUM'].": ".$specimen->getDailyNum()."<br>";
}
//if($_SESSION['pnamehide'] == 0)
if($_SESSION['user_level'] == $LIS_TECH_SHOWPNAME)
{
	echo LangUtil::$generalTerms['PATIENT_NAME']; ?>: <?php echo $patient->name; 
}
else
{
	echo LangUtil::$generalTerms['GENDER']."/".LangUtil::$generalTerms['AGE'].": $patient->sex /".$patient->getAgeNumber()."<br>";
}
}
?>

<br>
<table class='hor-minimalist-c'>
<tbody>
<?php
$related_test_count = 0;
foreach($test_list as $test)
{
	//echo "TEST ID is : ".$test_id."<br/>";
	//echo "TEST TYPE ID is : ".$test->testTypeId."<br/>";
	if($test_id != -1){
		if( $test->testTypeId != $test_id){
	?>
	<tr valign='top'>
		<td>
			<?php 
			$test_type = get_test_type_by_id($test->testTypeId);
			echo $test_type->getName(); 
			?>
		</td>
		<td>
			<?php
			if($test->isPending() === false)
			{
				echo "(".LangUtil::$pageTerms['MSG_ALREADYENTERED'].") ";
				echo $test->decodeResult();
			}
			else
			{
				get_result_form($test_type, $test->testId, count($test_list), $patient);
			}
			?>
		</td>
	</tr>
	<?php 
		$related_test_count++;
	}
	}
	else {
	?>
	<tr valign='top'>
		<td>
			<?php 
			$test_type = get_test_type_by_id($test->testTypeId);
			echo $test_type->getName(); 
			?>
		</td>
		<td>
			<?php
			if($test->isPending() === false)
			{
				echo "(".LangUtil::$pageTerms['MSG_ALREADYENTERED'].") ";
				echo $test->decodeResult();
			}
			else
			{
				get_result_form($test_type, $test->testId, count($test_list), $patient);
			}
			?>
		</td>
	</tr>
	
	<?php }
	?>
	<?php
}

if($test_id != -1 && $related_test_count==0){
	echo "<span class='error_string'>".LangUtil::$generalTerms['SPECIMEN_ID']."  ".$specimen_id." ".LangUtil::$generalTerms['RELATED_TESTS_NOTFOUND'].".</span>";
	return;
}
?>
</tbody>
</table>
<br>
<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:submit_forms(<?php echo $specimen->specimenId; ?>);'></input>
&nbsp;&nbsp;
<?php if($test_id == -1){?>
<a href='javascript:hide_result_form(<?php echo $specimen->specimenId; ?>);' class='result_cancel_link'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
&nbsp;&nbsp;
<?php }?>
<span class='result_progress_spinner' style='display:none;'>
<?php echo $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
</span>
<input type='hidden' id='form_id_list' value='<?php echo implode(",", $form_id_list); ?>'></input>
</div>
<hr>
