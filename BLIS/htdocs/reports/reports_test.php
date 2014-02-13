<?php
#
# Creates printable report for single test results on a specimen
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");

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

function list_results($test_entry)
{
	$measure_list = get_test_type_measure($test_entry->testTypeId);
	if($test_entry->isPending())
	{
		echo "ERROR: Test results pending<br>";
		return;
	}
	$result_list = explode(",", $test_entry->result);
	?>
	<table cellspacing='6px'>
		<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Global Normal Ranges</td>
		</tr>
		<?php
		for($i = 0; $i < count($measure_list); $i++)
		{
			# Pretty print
			$curr_measure = $measure_list[$i];
			echo "<tr>";
				echo "<td>".$curr_measure->getName()."</td>";
				echo "<td>$result_list[$i]</td>";
				echo "<td>[$curr_measure->unit]</td>";
				$range = $curr_measure->range;
				if(strpos($range, ":"))
				{
					$range_bounds = explode(":", $range);
					echo "<td>($range_bounds[0] - $range_bounds[1])</td>";
				}
				else
				{
					echo "<td>---</td>";
				}
			echo "</tr>";
		}
		?>
		</tbody>
	</table>
	<?php
}

$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableLatencyRecord();

$lab_config_id = $_REQUEST['location'];
$specimen_id = $_REQUEST['specimen_id'];
$test_type_id = $_REQUEST['t_type'];
$test_name = get_test_name_by_id($test_type_id);
DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
$specimen = get_specimen_by_id($specimen_id);
?>
<script type='text/javascript'>
function export_as_word(div_id)
{
	var content = $('#'+div_id).html();
	$('#word_data').attr("value", content);
	$('#word_format_form').submit();
}
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
	<input type='button' onclick="javascript:window.print();" value='Print'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:export_as_word('export_content');" value='Export as Word Document'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:window.close();" value='Close This Page'></input>
</form>
<hr>
<div id='export_content'>
<h2><?php echo $lab_config->getSiteName(); ?></h2>
<h3><?php echo $test_name; ?> Report</h3>
<?php
if($specimen == null)
{
	echo "ERROR: Sample ID $specimen_id not found </div>";
	return;
}
$patient = get_patient_by_id($specimen->patientId);
$test_entry = get_test_record($specimen_id, $test_type_id);
?>
Sample ID: <?php echo $specimen_id; ?>
&nbsp;&nbsp;&nbsp;
Type: <?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?>
<br>
Patient ID: <?php echo $patient->getSurrogateId(); ?>
&nbsp;&nbsp;&nbsp;
Name: <?php echo $patient->name; ?>
<br>
Age: <?php echo $patient->getAge(); ?>
&nbsp;&nbsp;&nbsp;
Date of Birth: <?php echo $patient->getDob(); ?>
&nbsp;&nbsp;&nbsp;
Sex: <?php echo $patient->sex; ?>
<br>
Dr:
<br>
Report Date: <?php echo date('Y-m-d H:i'); ?>
<br><br>
<?php 
if($test_entry == null)
{
	echo "ERROR: Test type $test_name was not registered for Sample ID $specimen_id";
}
else
{
	list_results($test_entry);
}
?>
<br><br>
Signature: ...................................
</div>