<?php

include("../includes/db_lib.php");
include("../includes/stats_lib.php");


$lab_config_id = $_REQUEST['l'];
$date_from = $_REQUEST['df'];
$date_to = $_REQUEST['dt'];
$test_type = $_REQUEST['tt'];
$lab_config = get_lab_config_by_id($lab_config_id);
$include_pending = $_REQUEST['p'];

$test_type_set = true;
// When all tests are selected, $test_type will be 0
if(!$test_type) $test_type_set = false;
?>
<script type='text/javascript'>
$(document).ready(function(){
	$('#tat_table').tablesorter();
});
</script>
<table class='tablesorter' id='tat_table'>
<thead>
	<tr>
		<th>Test Type</th>
		<th>Specimens Handled</th>
		<th>Average Turnaround Time</th>
	</tr>
</thead>
<tbody>
<?php
// $stat_list = StatsLib::getTatDailyProgressionStats($lab_config, $test_type, $date_from, $date_to, $include_pending);
$stat_list = StatsLib::getTatStats($lab_config, $date_from, $date_to);
foreach($stat_list as $key=>$value)
{
	$test_type_id = $test_type;
	if(!$test_type_set) {
		$test_type_id = $key;
	}
	if($test_type_id != $key) {
		continue;
	}
	$test_type_id = $key;
	$tat_value = $value[0];
	$num_specimens = $value[1];
	?>
	<tr>
		<td><?php echo get_test_name_by_id($test_type_id); ?></td>
		<td><?php echo $num_specimens; ?></td>
		<td>
			<?php
			$days = floor($tat_value);
			$hours = floor(($tat_value - $days)*24);
			$mins = floor(((($tat_value - $days)*24) - $hours)*60);
			$avg_tat = "";
			if($days > 0) {
				$avg_tat = $avg_tat.$days." days ";
			}
			if($hours > 0) {
				$avg_tat = $avg_tat.$hours." hours ";
			}
			if($mins > 0) {
				$avg_tat = $avg_tat.$mins." mins";
			}
			echo $avg_tat;
			?>
		</td>
	</tr>
	<?php
}
?>
</tbody>
</table>