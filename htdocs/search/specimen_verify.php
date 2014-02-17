<?php
#
# Main page for verifying/cirrecting result values for an individual specimen
#
include("redirect.php");
include("includes/header.php");
include("includes/ajax_lib.php");
LangUtil::setPageId("specimen_info");

$script_elems->enableTokenInput();
?>
<script type='text/javascript'>
function checkandsubmit()
{
	$('#specimen_verify_progress').show();
	// TODO: Add validation
	$('#specimen_verify_form').submit();
}

function update_remarks(test_type_id, measure_id)
{
	/*
	var values_csv = "";
	var remarks_input_id = "comments_"+test_type_id;
	var results_field_list = $(".results_entry");
	for(var i = 0; i < results_field_list.length; i++)
	{
		var elem = results_field_list[i];
		var val = elem.value;
		values_csv += val+"_";
	}
	var url_string = "ajax/fetch_remarks.php";
	var data_string = "lid=<?php echo $_SESSION['lab_config_id']; ?>&ttype="+test_type_id+"&values_csv="+values_csv;
	$.ajax({
		type: "POST",
		url: url_string,
		data: data_string,
		success: function(msg) {
			$("#"+remarks_input_id).attr("value", msg)
		}
	});
	*/
	var result_field_name = 'result_'+test_type_id+"_"+measure_id;
	var result_field_value = $("#"+result_field_name).val();
	var comments_field_name = 'comments_'+test_type_id+"_"+measure_id;
	//alert(result_field_value);
	$("#"+comments_field_name).val(result_field_value);
}

</script>
<br>
<?php
$tips_string = LangUtil::$pageTerms['TIPS_VERIFY'];
$page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
$specimen_id = $_REQUEST['sid'];
$specimen = Specimen::getById($_REQUEST['sid']);
?>
<b><?php echo LangUtil::$pageTerms['TITLE_VERIFY']; ?></b>
 | <a href='javascript:history.go(-1);'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<?php
if($specimen == null)
{
	?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['ERROR'].": ".$_REQUEST['sid']." - ".LangUtil::$generalTerms['SPECIMEN_ID']." ".LangUtil::$generalTerms['MSG_NOTFOUND'] ?>.
	</div>
	<?php
	include("includes/footer.php");
	return;
}
$page_elems->getSpecimenInfo($specimen->specimenId);
$test_list = get_tests_by_specimen_id($specimen->specimenId);
?>
<form name='specimen_verify_form' id='specimen_verify_form' action='specimen_verify_do.php' method='get'>
<input type='hidden' name='sid' value='<?php echo $specimen->specimenId; ?>'></input>
<table class='hor-minimalist-c'>
	<thead>
		<tr valign='top'>
			<th><b><?php echo LangUtil::$generalTerms['TEST']; ?></b></th>
			<th><b><?php echo LangUtil::$generalTerms['RESULTS']; ?></b></th>
			<th><b><?php echo LangUtil::$generalTerms['RESULT_COMMENTS']." (".LangUtil::$generalTerms['OPTIONAL'].")"; ?></b></th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($test_list as $test)
	{
		// CSF eg.
		$test_type = get_test_type_by_id($test->testTypeId);

		// 59,60,61...,
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
		$result_list = explode(",", $test->result);
		?>
		<tr valign='top'>
			<td><?php echo $test_type->getName(); ?></td>
			<?php
			$i = 0;
			foreach($measure_list as $measure)
			{
				if ($i > 0)
					echo "<td></td>";
				echo "<td>";
				$field_name = 'result_'.$test_type->testTypeId."_".$measure->measureId;
				$comments_field_name = 'comments_'.$test_type->testTypeId."_".$measure->measureId;
				$field_id = $field_name;
				$field_value = $result_list[$i];
				$range_type = $measure->getRangeType();
				$range = $measure->range;
				echo "<span style='float:right'>";
				echo "<label for='$field_name'>";
				if(count($measure_list) != 1)
                                {
                                    if($measure->checkIfSubmeasure() == 1)
                                    {
                                        $decName = $measure->truncateSubmeasureTag();
                                        echo $decName.":";
                                    }
                                    else
                                    {
					echo $measure->getName().":";
                                    }
                                }
				echo "&nbsp;".$measure->unit; //.' '.$field_value;
				echo "</label>";
				if($range_type == Measure::$RANGE_OPTIONS)
				{
					# Discrete value range
					$range_options = $measure->getRangeValues();
					?>
					<select name='<?php echo $field_name; ?>' id='<?php echo $field_id; ?>' class='uniform_width results_entry' onchange="javascript:update_remarks(<?php echo $test_type->testTypeId; ?>, <?php echo $measure->measureId; ?> );">
					<?php
					foreach($range_options as $option)
					{  $option=str_replace("#" , "/" , $option);
						?>
						<option value='<?php echo $option; ?>' <?php
						if($option === $field_value)
							echo " selected ";
						?>><?php echo $option; ?></option>
						<?php
					}
					?>
					</select>
				<?php
				}
				else if($range_type == Measure::$RANGE_NUMERIC)
				{
					# Continuous value range
					$patient_list=get_patient_by_sp_id($specimen_id);
					foreach($patient_list as $patient)
					{
					$range_bounds = $measure->getRangeValues($patient);
					}
					
					?>
					<span>
					&nbsp; <?php echo LangUtil::$generalTerms['RANGE']; ?> (<?php 
					$unit=$measure->unit;
					if(stripos($unit,",")!=false) {	
						$units=explode(",",$unit);
						$lower_parts=explode(".",$range_bounds[0]);
						$upper_parts=explode(".",$range_bounds[1]);
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
					}
					else
					{	
						if(stripos($unit,":")!=false) {		
							$units=explode(":",$unit);
							echo $range_bounds[0]; ?><sup><?php echo $units[0] ?></sup>-<?php echo $range_bounds[1];?><sup><?php echo $units[0] ?></sup>)
						<?php 
						}
						else {
							echo $range_bounds[0]; ?>-<?php echo $range_bounds[1];?>)<?php echo "&nbsp;".$measure->unit;} ?>
							</span>
							<input class='uniform_width results_entry' type='text' name='<?php echo $field_name; ?>' id='<?php echo $field_id; ?>' value='<?php echo $field_value; ?>' onchange="javascript:update_remarks(<?php echo $test_type->testTypeId; ?>);">
							</input>
						<?php
					}	
				}
				else if($range_type == Measure::$RANGE_AUTOCOMPLETE)
				{
					# Autocomplete values
					# Use jquery.token-input plugin
					$json_params = array('id', 'name');
					$value_map = explode("_",trim($field_value));
					$values_f = array();
					for($js=0; $js<count($value_map); $js++)
						$values_f[$value_map[$js]]= $value_map[$js];						
					$json_values = list_to_json($values_f, $json_params);					
					
					$url_string = "ajax/measure_autocomplete.php?id=".$measure->measureId;
					$hint_text = "Type to enter results";
					echo "<div>";
					$page_elems->getTokenList(-1, $field_id,"result_".$test_type->testTypeId."_".$measure->measureId, $url_string, $hint_text,$json_values);
					echo "</div>";
				}
                                else if($range_type == Measure::$RANGE_FREETEXT)
                                {
                                    # Text box
									$field_value = preg_replace("/[^a-zA-Z0-9,+.;:_\s]/", "", $field_value);									
                                    echo "<textarea name='$field_name' id='$field_id' class='uniform_width results_entry'>$field_value</textarea>";
                                }
				echo "</span>"; 
				echo "</td>";
				echo "<td>";
				$remark_value="";
				$strpart = strstr( $test->comments,$measure->getName());
				if( $strpart != "")
				{					
					$remark_arr = explode(":",$strpart,3);					
					if( strstr($remark_arr[1], ","))
					{
						$remark_arr[1] = explode(",",$remark_arr[1]);
						$remark_value = $remark_arr[1][0];						
					}
					else
					{
						$remark_value = $remark_arr[1];
					}					
				}
				echo "<input class='uniform_width' name=$comments_field_name id=$comments_field_name value='$remark_value'></input>";
				echo "</td>";
				echo "</tr>";
				$i++;
			}
			?>
		</tr>
		<?php
	}
	?>
	<tr>
		<td></td>
		<td>
			<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:checkandsubmit();'></input>
			&nbsp;&nbsp;&nbsp;
			<a href='javascript:history.go(-1);'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
			&nbsp;&nbsp;&nbsp;
			<span id='specimen_verify_progress' style='display:none'>
				<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
			</span>
	</tbody>
</table>
</form>
<br>
<?php include("includes/footer.php"); ?>