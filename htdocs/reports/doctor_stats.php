<?php
#
# Shows tests performed report for a site/location and date interval
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
LangUtil::setPageId("reports");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();

$uiinfo = "from=".$date_from."%to=".$date_to;
?>
<script type='text/javascript'>
$(window).load(function(){
	$('#stat_graph').hide();
});
function toggle_stat_table()
{
	$('#stat_graph').toggle();
	var linktext = $('#showtablelink').text();
	if(linktext.indexOf("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>") != -1)
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_HIDEGRAPH']; ?>");
	else
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>");
}

function showEditBox(id) {
	$('#newDoctorName'+id).toggle();
}

function updateDoctorName(id) {
	var newDoctorName = $('#newDoctorNameInput'+id).val();
	var oldDoctorName = $('#originalDoctorName'+id).text();
	if(oldDoctorName == "Not Known") {
		alert("This is not editable!");
		return;
	}
	if(newDoctorName == '') {
		alert("Please enter a name!");
		return;
	}
	else{
		$('#updateDoctorNameForm'+id).submit();
		/*
		$('#'+formName).ajaxSubmit({
			success: function(param) {
				if(param == "true") {
					window.refresh();
				}
				else {
					$('#updateFailedDiv').show();
				}
			}
		});
		*/
	}
}
</script>
<style type='text/css'>
.flipv_up {
	font-size: 12px;
	font-family: Tahoma;
}
.flipv {
	font-size: 12px;
	font-family: Tahoma;
}
</style>
<br>
<b> Doctor Statistics</b>
<?php /*| <a href="javascript:toggle_stat_table();" id='showtablelink'> # echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; </a> */ ?>
 | <a href='reports.php'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>
<?php
$lab_config_id = $_REQUEST['location'];
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$uiinfo = "from=".$date_from."&to=".$date_to;
putUILog('doctor_stats', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
if($lab_config == null)
{
	?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?> <a href='javascript:history.go(-1);'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
	</div>
	<?php
	return;
}
 $site_list = get_site_list($_SESSION['user_id']);
			if(count($site_list) != 1)
			{ echo LangUtil::$generalTerms['FACILITY'] ?>: <?php echo $lab_config->getSiteName(); ?> | 
<?php
}

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
?>
<br><br>

<?php $stat_list = StatsLib::getDoctorStats($lab_config, $date_from, $date_to); ?>
<?php
/*
<div id='stat_graph'>
<?php
# To avoid clutter on the graph, divide stat_list to chunks
$chunk_size = 999;
$stat_chunks = array_chunk($stat_list, $chunk_size, true);
$i = 1;
foreach($stat_chunks as $stat_chunk)
{
	$div_id = "placeholder_".$i;
	$ylabel_id = "ylabel_".$i;
	$legend_id = "legend_".$i;
	$width_px = count($stat_chunk)*150;
	?>
	<table>
	<tbody>
	<tr valign='top'>
	<td>
		<span id="<?php echo $ylabel_id; ?>" class='flipv_up' style="width:30px;height:30px;"><?php echo LangUtil::$pageTerms['COUNT_TEST']; ?></span>
	</td>
	<td>
		<div style='width:900px;height:340px;overflow:auto'>
			<div id="<?php echo $div_id; ?>" style="width:<?php echo $width_px; ?>px;height:300px;"></div>
		</div>
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
		$x_val = 0;
		$count = 1;
		foreach($stat_chunk as $key=>$value)
		{
			$test_type_id = $key;
			$tests_done_count = $value;
			echo "var d$count = [];";
			echo "d$count.push([$x_val, $tests_done_count]);";
			$count++;
			$x_val += 2;
		}
		?>
		$.plot($("#<?php echo $div_id; ?>"), [
			<?php
			$count = 1;
			$index_count = 0;
			$tick_array = "[";
			foreach($stat_chunk as $key=>$value)
			{
				$test_name = get_test_name_by_id($key);
				$tick_array .= "[$index_count+0.4, '$test_name']";
				?>
				{
					data: d<?php echo $count; ?>,
					bars: { show: true }//,
					//label: "<?php #echo get_test_name_by_id($key); ?>"
				}
				<?php
				$count++;
				$index_count += 2;
				if($count < count($stat_chunk) + 1)
				{
					echo ",";
					$tick_array .= ",";
				}
			}
			$tick_array .= "]";
			?>
		], { xaxis: {ticks: <?php echo $tick_array; ?>}, legend: {container: "#<?php echo $legend_id; ?>"}  });
		$('#<?php echo $ylabel_id; ?>').flipv_up();
	});
	</script>	
	<?php
	# End of loop
	$i++;
}
?>
</div>
*/
?>
<div id='updateFailedDiv' style='display:none; color:Red' >
	Could not update. Please try again..
</div>
<div id='stat_table'>
	<?php $page_elems->getDoctorStatsTable($stat_list, $date_from, $date_to, $lab_config_id); ?>
</div>
<?php include("includes/footer.php"); ?>