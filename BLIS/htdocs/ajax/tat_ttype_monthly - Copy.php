<?php
#
# Main page for creating monthly TAT progression charts
# Called via Ajax from reports_tat.php
#

include("../includes/db_lib.php");
include("../includes/stats_lib.php");
include("../includes/page_elems.php");
LangUtil::setPageId("reports");

$page_elems = new PageElems();

$test_type_id = $_REQUEST['tt'];
$date_from = $_REQUEST['df'];
$date_to = $_REQUEST['dt'];
$lab_config_id = $_REQUEST['l'];
$date_from_js = str_replace("-", "/", $date_from);
$date_to_js = str_replace("-", "/", $date_to);
$lab_config = get_lab_config_by_id($lab_config_id);
$include_pending = false;
if($_REQUEST['p'] == 1)
	$include_pending = true;

# Obtain stats as date_collected(millisec ts) => tat value
$stat_list = StatsLib::getTatMonthlyProgressionStats($lab_config, $test_type_id, $date_from, $date_to, $include_pending);
ksort($stat_list);
# Build chart with time series
$div_id = "tplaceholder_".$test_type_id;
$ylabel_id = "tylabel_".$test_type_id;
$legend_id = "tlegend_".$test_type_id;
?>
<table>
	<tbody>
	<tr valign='top'>
		<td>
			<span id="<?php echo $ylabel_id; ?>" class='flipv_up' style="width:30px;height:30px;"><?php echo LangUtil::$generalTerms['TAT']; ?> (<?php echo LangUtil::$generalTerms['DAYS']; ?>)</span>
		</td>
		<td>
			<div id="<?php echo $div_id; ?>" style="width:800px;height:300px;"></div>
		</td>	
		<td>
			<div id="<?php echo $legend_id; ?>" style="width:200px;height:300px;"></div>
		</td>
	</tr>
	</tbody>
</table>
<script id="source" language="javascript" type="text/javascript"> 
$(function () {
	<?php
	$count = 1;
	echo "var d$test_type_id = [];";
	echo "var d".$test_type_id."_ile = [];";
	if($test_type_id != 0)
		echo "var d".$test_type_id."_goal = [];";
	foreach($stat_list as $key=>$value)
	{
		$x_val = $key;
		$tat_value = $value[0];
		$ile_tat_value = $value[1];
		$goal_tat_value = $value[2];
		# JavaScript timestamp in millisec 1000
		echo "d$test_type_id.push([$x_val*1000, $tat_value]);";
		// Hiding 90th percentile plot
		//echo "d".$test_type_id."_ile.push([$x_val*1000, $ile_tat_value]);";
		if($test_type_id != 0)
			echo "d".$test_type_id."_goal.push([$x_val*1000, $goal_tat_value]);";
		$count++;
	}
	?>
	$.plot($("#<?php echo $div_id; ?>"), [
		{
			data: d<?php echo $test_type_id; ?>,
			lines: { show: true },
			label: "<?php echo LangUtil::$generalTerms['TAT_AVG']; ?>"
		}
		<?php
		// Hiding 90th percentile plot
		/*, 
		{
			data: d<?php echo $test_type_id; ?>_ile,
			lines: { show: true },
			label: "<?php echo LangUtil::$generalTerms['TAT_ILE']; ?>"
		}
		*/
		?>
		<?php
		if($test_type_id != 0)
		{
		?>
		, 
		{
			data: d<?php echo $test_type_id; ?>_goal,
			lines: { show: true },
			label: "<?php echo LangUtil::$generalTerms['TAT_TARGET']; ?>"
		}
		<?php
		}
		?>
		],
		{ 
			xaxis: {
				mode: "time",
				minTickSize: [1, "month"],
				timeformat: "%b-%y"//,
				//min: (new Date("<?php echo $date_from_js; ?>")).getTime()//,
                //max: (new Date("<?php echo $date_to_js; ?>")).getTime()
            },
			legend: {
				container: "#<?php echo $legend_id; ?>"
			}
		} 
	);
	$('#<?php echo $ylabel_id; ?>').flipv_up();
});
</script>
<br>
<?php
if($test_type_id != 0)
{
# Show table of tat-exceeded specimens
$is_exceeded = false;
foreach($stat_list as $key=>$value)
{
	if(count($value[3]) != 0)
	{
		$is_exceeded = true;
		break;
	}
}
if($is_exceeded === false)
{
	?>
	<center>
	<div class='sidetip_nopos' style='width:300px;'>
	<?php echo LangUtil::$pageTerms['TIPS_TATEXCEED']; ?>
	</div>
	</center>
	<?php
}
else
{
	$saved_db = DbUtil::switchToLabConfig($lab_config->id);
	$table_id = 'exceededtable_'.$test_type_id;
	?>
	<center>
	<div class='sidetip_nopos' style='width:300px;'>
	<?php
	$total_exceeded = 0;
	foreach($stat_list as $key=>$value)
	{
		$total_exceeded += count($value[3]);
	}
	echo $total_exceeded." ".LangUtil::$pageTerms['TIPS_TATEXCEEDNUM'];
	?>	
	<a href="javascript:toggle('<?php echo $table_id; ?>');">&nbsp;&nbsp;<?php echo LangUtil::$generalTerms['CMD_VIEW'] ?> &raquo;</a>
	</div>
	</center>
	<table class='tablesorter' id='<?php echo $table_id; ?>' style='display:none;'>
		<thead>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td style='text-align:right;'>
					<a href="javascript:toggle('<?php echo $table_id; ?>');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>
				</td>
			</tr>
			<tr>
				<th>#</th>
				<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TESTS']; ?></th>
				<th><?php echo LangUtil::$generalTerms['C_DATE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['REGD_BY']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$count = 1;
		foreach($stat_list as $key=>$value)
		{
			if(count($value[3]) == 0)
				continue;
			foreach($value[3] as $specimen_id)
			{
				$specimen = get_specimen_by_id($specimen_id);
				$page_elems->getSpecimenExceededInfoRow($specimen, $count);
				$count++;
			}
		}
		?>
		</tbody>
	</table>
	<script type='text/javascript'>
	$(function () {
		$('#<?php echo $table_id; ?>').tablesorter();
	});
	</script>
	<br>
	<?php
	DbUtil::switchRestore($saved_db);
}
if($include_pending === false)
	return;

# Show table of tat-pending specimens
$is_pending = false;
foreach($stat_list as $key=>$value)
{
	if(count($value[4]) != 0)
	{
		$is_pending = true;
		break;
	}
}
if($is_pending === false)
{
	?>
	<center>
	<div class='sidetip_nopos' style='width:300px;'>
	<?php echo LangUtil::$pageTerms['TIPS_TATNOPENDING']; ?>
	</div>
	</center>
	<?php
}
else
{
	$saved_db = DbUtil::switchToLabConfig($lab_config->id);
	$table_id = 'pendingtable_'.$test_type_id;
	?>
	<center>
	<div class='sidetip_nopos' style='width:300px;'>
	<?php
	$total_pending = 0;
	foreach($stat_list as $key=>$value)
	{
		$total_pending += count($value[4]);
	}
	echo $total_pending." ".LangUtil::$pageTerms['TIPS_TATPENDING'];
	?>	
	<a href="javascript:toggle('<?php echo $table_id; ?>');">&nbsp;&nbsp;<?php echo LangUtil::$generalTerms['CMD_VIEW'] ?> &raquo;</a>
	</div>
	</center>
	<table class='tablesorter' id='<?php echo $table_id; ?>' style='display:none;'>
		<thead>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td style='text-align:right;'>
					<a href="javascript:toggle('<?php echo $table_id; ?>');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>
				</td>
			</tr>
			<tr>
				<th>#</th>
				<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TESTS']; ?></th>
				<th><?php echo LangUtil::$generalTerms['C_DATE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['REGD_BY']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$count = 1;
		foreach($stat_list as $key=>$value)
		{
			if(count($value[4]) == 0)
				continue;
			foreach($value[4] as $specimen_id)
			{
				$specimen = get_specimen_by_id($specimen_id);
				$page_elems->getSpecimenExceededInfoRow($specimen, $count);
				$count++;
			}
		}
		?>
		</tbody>
	</table>
	<?php
	DbUtil::switchRestore($saved_db);
}
}
?>