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
		$test_type = get_test_type_by_id($test->testTypeId);
		$measure_list = $test_type->getMeasures();
		$result_list = explode(",", $test->result);
		$comments_field_name = 'comments_'.$test_type->testTypeId;
		?>
		<tr valign='top'>
			<td><?php echo $test_type->getName(); ?></td>
			<td>
			<?php
			$i = 0;
			foreach($measure_list as $measure)
			{
				$field_name = 'result_'.$test_type->testTypeId."_".$measure->measureId;
				$field_id = $field_name;
				$field_value = $result_list[$i];
				$range = $measure->range;
				$range_type = $measure->getRangeType();
	
				echo "<span style='float:right'>";
				echo "<label for='$field_name'>";
				if(count($measure_list) != 1)
					echo $measure->getName();
				echo "&nbsp;".$measure->unit;
				if($range_type == Measure::$RANGE_AUTOCOMPLETE) {
					echo " : ".$field_value;
				}
				echo "</label>";
				
				$range_values = $measure->getRangeValues();
				if($range_type == Measure::$RANGE_OPTIONS)
				{	
					# Discrete value range
					?>
					<select name='<?php echo $field_name; ?>' id='<?php echo $field_id; ?>' class='uniform_width'>
					<?php
					foreach($range_values as $option)
					{
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
					?>
					<span>
					&nbsp;( <?php echo LangUtil::$generalTerms['RANGE']; ?> <?php echo $range_values[0]; ?>-<?php echo $range_values[1]; ?> )&nbsp;&nbsp;
					</span>
					<input class='uniform_width' type='text' name='<?php echo $field_name; ?>' id='<?php echo $field_id; ?>' value='<?php echo $field_value; ?>'>
					</input>
					<?php
				}
				else if($range_type == Measure::$RANGE_AUTOCOMPLETE)
				{
					# Autocomplete values
					$url_string = "ajax/measure_autocomplete.php?id=".$measure->measureId;
					$hint_text = "Type to enter results";
					/*
					$json_params = array("id", "name");
					$result_values = explode(",", $field_value);
					$value_map = array();
					foreach($result_values as $value)
					{
						if(trim($value) == "")
							continue;
						$value_map[$value] = $value;
					}					
					$json_string = list_to_json($value_map, $json_params);
					$page_elems->getTokenList(-1, $field_id, $field_name, $url_string, $hint_text, $json_string);
					*/
					$page_elems->getTokenList(-1, $field_id,"result_".$test_type->testTypeId."_".$measure->measureId, $url_string, $hint_text,"");
				}
				echo "</span>";
				echo "<br>";
				$i++;
			}
			?>
			</td>
			<td>
				<input name='<?php echo $comments_field_name; ?>' value='<?php echo $test->comments; ?>'></input>
			</td>
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