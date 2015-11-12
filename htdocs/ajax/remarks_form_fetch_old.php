<?php
#
# Generates form for editing result interpretations
# Called via Ajax from remarks_edit.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
$page_elems = new PageElems();

$lab_config_id = $_REQUEST['lid'];
$test_type_id = $_REQUEST['ttype'];

include($LOCAL_PATH."langdata_".$lab_config_id."/remarks.php");

$saved_id = $_SESSION['lab_config_id'];

$lab_config = LabConfig::getById($lab_config_id);
$test_type = TestType::getById($test_type_id);

# Fetch all measures for this test
$measure_list = $test_type->getMeasures();
# For each measure, fetch existing remarks data from remarks.XML
$measure_remarks = array();
foreach($measure_list as $measure)
{
	$measure_remarks[$measure->measureId] = LangUtil::getMeasureRemarks($lab_config->id, $measure->measureId);
}
# Generate form
?>
<div class='pretty_box' style='width:auto;'>
<form name='remarks_form' id='remarks_form' action='remarks_update.php' method='post'>
<input type='hidden' name='lid' value='<?php echo $lab_config_id; ?>'></input>
<input type='hidden' name='ttype' value='<?php echo $test_type_id; ?>'></input>
<?php 
foreach($measure_list as $measure)
{
	$range_type = $measure->getRangeType();
	$remarks_list = $measure_remarks[$measure->measureId];
	echo $measure->name;
	if($range_type == Measure::$RANGE_NUMERIC)
	{
		echo "&nbsp;&nbsp;&nbsp;";
		echo $measure->getRangeString();
		echo "<br>";
	}
	?>
	<table id='remarks_table_<?php echo $measure->measureId; ?>' class='hor-minimalist-c'>
		<thead>
			<tr>
				<th><?php echo LangUtil::$generalTerms['RANGE']; ?></th>
				<th>Interpretation</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if($range_type == Measure::$RANGE_NUMERIC)
		{	if(isset($remarks_list))
				foreach($remarks_list as $key=>$value)
				{
					$bounds = explode(":", $key);
					echo "<tr>";
					echo "<td>";
					echo "<input type='text' name='range_l_".$measure->measureId."[]' value='".$bounds[0]."' class='uniform_width_less numeric_range'></input> - ";
					echo "<input type='text' name='range_u_".$measure->measureId."[]' value='".$bounds[1]."' class='uniform_width_less numeric_range'></input>";
					echo "</td>";
					echo "<td>";
					echo "<input type='text' name='remarks_".$measure->measureId."[]' value='".$value."' class='uniform_width'></input>";
					echo "</td>";
					echo "</tr>";
			}
			else
			{$bounds[0]=0;// get the value from the table.
			$bounds[1]=100;//get the value from the table
			echo("empty");
			echo "<tr>";
					echo "<td>";
					echo "<input type='text' name='range_l_".$measure->measureId."[]' value='".$bounds[0]."' class='uniform_width_less numeric_range'></input> - ";
					echo "<input type='text' name='range_u_".$measure->measureId."[]' value='".$bounds[1]."' class='uniform_width_less numeric_range'></input>";
					echo "</td>";
					echo "<td>";
					echo "<input type='text' name='remarks_".$measure->measureId."[]' value='".$value."' class='uniform_width'></input>";
					echo "</td>";
					echo "</tr>";
			}
		}
		else if($range_type == Measure::$RANGE_OPTIONS)
		{
			foreach($remarks_list as $key=>$value)
			{
				echo "<tr>";
				echo "<td>";
				echo $key;
				echo "</td>";
				echo "<td>";
				echo "<input type='text' value='$value' name='remarks_".$measure->measureId."[]' class='uniform_width'></input>";
				echo "</td>";
				echo "</tr>";
			}
		}
		?>
		</tbody>
	</table>
	<?php
	if($range_type == Measure::$RANGE_NUMERIC)
	{
		?>
		<br>
		<small><a href="javascript:add_remarks_row(<?php echo $measure->measureId; ?>, <?php echo $range_type; ?>);"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?>&raquo;</a></small>
		<?php
	}
}
?>
<br><br>
<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:submit_remarks_form();'></input>
&nbsp;&nbsp;
<a href='javascript:hide_remarks_form();'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
&nbsp;&nbsp;
<span id='remarks_submit_progress' style='display:none;'>
	<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
</span>
</form>
</div>
<?php
# Return
$_SESSION['lab_config_id'] = $saved_id;
?>