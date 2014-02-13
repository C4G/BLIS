<?php
#
# Returns HTML for adding an extra table row in batch results entry
# Called via Ajax from results_entry.php
#

include("../includes/db_lib.php");

$test_type_id = $_REQUEST['t_type'];
# Fetch all measures for this test type
$test_type = TestType::getById($test_type_id);
$measure_list = $test_type->getMeasures();
#<tr valign='top'>
	#<td>--</td>
?>
	<td><input type='text' name='specimen_id[]'></input></td>
	<?php
	$measure_count = 1;
	foreach($measure_list as $measure)
	{
		if(strpos($measure->range, ":") != false)
			# Continuous value range
			echo "<td><input type='text' name='measure_".$measure_count."[]' style='width:35px;'></input></td>";
		else if(strpos($measure->range, "/") == false && strpos($measure->range, "_") == false)
		{	
			# Discrete value range
			$range_options = explode("/", $measure->range);
			?>
			<td>
			<select name='measure_<?php echo $measure_count; ?>[]'>
			<?php
			foreach($range_options as $option)
			{
			?>
				<option value='<?php echo $option; ?>'><?php echo $option; ?></option>
			<?php
			}
			?>
			</select>
			</td>
			<?php
		}
		$measure_count++;
	}
?>
<td><input name='comments[]' type='text'></input></td>
</tr>