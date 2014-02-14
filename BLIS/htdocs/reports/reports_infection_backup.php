<?php
#
# Shows infection summary report for a site/location
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
LangUtil::setPageId("reports");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
?>
<script type='text/javascript'>
$(window).load(function(){
	$('#stat_graph').hide();
	
});
function toggle_stat_table()
{
	$('#prevalance').toggle();
	//$('#stat_graph').toggle();
	var linktext = $('#showtablelink').text();
	if(linktext.indexOf("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>") != -1)
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_HIDEGRAPH']; ?>");
	else
		{$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>");
		$('#prevalance_graph').hide();
		}
}

function view_prevalance()
{

	var tat_type = $('#tattype').attr("value");
	
	
	if(tat_type == 'm')
	view_testwise_monthly();
	
else if(tat_type == 'w')
	view_testwise_weekly();

	else if(tat_type == 'd')
		view_testwise_daily();	
	

}
function view_testwise_monthly()
{//
	var date_from = $('#yf').attr("value")+"-"+$('#mf').attr("value")+"-"+$('#df').attr("value");
	var date_to = $('#yt').attr("value")+"-"+$('#mt').attr("value")+"-"+$('#dt').attr("value");
	if(checkDate($('#yf').attr("value"), $('#mf').attr("value"), $('#df').attr("value")) == false)
	{
	
		alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
		return;
	}
	if(checkDate($('#yt').attr("value"), $('#mt').attr("value"), $('#dt').attr("value")) == false)
	{
		alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
		return;
	}
	
	$('#progress_spinner').show();
	
	var ttype = $('#ttype').attr("value");
	var age_s=$('#age_s').attr("value");
	var age_e=$('#age_e').attr("value");
	var age=$("input[name='age']:checked").attr("value");
	var gender=$("input[name='gender']:checked").attr("value");
	//var gender=$("input[name='gender']:checked").attr("value");
	var url_string = "ajax/monthly_prevalance.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&age_s="+age_s+"&age_e="+age_e+"&gender="+gender+"&l=<?php echo $lab_config_id; ?>";
	//var url_string = "ajax/monthly_prevalance.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>";
	$('#prevalance_graph').load(url_string, function() {
		$('#prevalance_graph').show();
		
		$('#progress_spinner').hide();
	});
}
function view_testwise_weekly()
{
	var date_from = $('#yf').attr("value")+"-"+$('#mf').attr("value")+"-"+$('#df').attr("value");
	
	var date_to = $('#yt').attr("value")+"-"+$('#mt').attr("value")+"-"+$('#dt').attr("value");
	
	if(checkDate($('#yf').attr("value"), $('#mf').attr("value"), $('#df').attr("value")) == false)
	{
	
		alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
		return;
	}
	if(checkDate($('#yt').attr("value"), $('#mt').attr("value"), $('#dt').attr("value")) == false)
	{
		alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
		return;
	}
	
	$('#progress_spinner').show();
	
	var ttype = $('#ttype').attr("value");
	var ttype = $('#ttype').attr("value");
	var age_s=$('#age_s').attr("value");
	var age_e=$('#age_e').attr("value");
	var gender=$("input[name='gender']:checked").attr("value");
	var url_string = "ajax/weekly_prevalance.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&age_s="+age_s+"&age_e="+age_e+"&gender="+gender+"&l=<?php echo $lab_config_id; ?>";
	//var url_string = "ajax/weekly_prevalance.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>";
	$('#prevalance_graph').load(url_string, function() {
		$('#prevalance_graph').show();
		
		$('#progress_spinner').hide();
	});
}
function view_testwise_daily()
{
	var date_from = $('#yf').attr("value")+"-"+$('#mf').attr("value")+"-"+$('#df').attr("value");
	
	var date_to = $('#yt').attr("value")+"-"+$('#mt').attr("value")+"-"+$('#dt').attr("value");
	
	if(checkDate($('#yf').attr("value"), $('#mf').attr("value"), $('#df').attr("value")) == false)
	{
	
		alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
		return;
	}
	if(checkDate($('#yt').attr("value"), $('#mt').attr("value"), $('#dt').attr("value")) == false)
	{
		alert("<?php echo LangUtil::$generalTerms['TIPS_DATEINVALID']; ?>");
		return;
	}
	
	$('#progress_spinner').show();
	
	var ttype = $('#ttype').attr("value");
	var ttype = $('#ttype').attr("value");
	var age_s=$('#age_s').attr("value");
	var age_e=$('#age_e').attr("value");
	var gender=$("input[name='gender']:checked").attr("value");
	var url_string = "ajax/daily_prevalance.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&age_s="+age_s+"&age_e="+age_e+"&gender="+gender+"&l=<?php echo $lab_config_id; ?>";
	$('#prevalance_graph').load(url_string, function() {
		$('#prevalance_graph').show();
		
		$('#progress_spinner').hide();
	});
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
<b><?php echo LangUtil::$pageTerms['MENU_INFECTIONSUMMARY']; ?></b>
 | <a href="javascript:toggle_stat_table();" id='showtablelink'><?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?></a>
 | <a href='reports.php'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>
<?php
$lab_config_id = $_REQUEST['location'];
$summary_type = $_REQUEST['summary_type'];
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$lab_config = get_lab_config_by_id($lab_config_id);
if($lab_config == null)
{
	?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$generalTerms['MSG_NOTFOUND'] ?>
	</div>
	<?php
	return;
}
?>
<?php echo LangUtil::$generalTerms['FACILITY'] ?>: <?php echo $lab_config->getSiteName(); ?> | 
<?php
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
<?php
DbUtil::switchToLabConfig($lab_config_id);
# Cumulative summary
$stat_list = StatsLib::getDiscreteInfectionStats($lab_config, $date_from, $date_to);
if(count($stat_list) == 0)
{
	?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$pageTerms['TIPS_NODISCRETE']; ?>
	</div>
	<?php
	include("includes/footer.php"); 
	return;
}
/*
?>
<div id='stat_graph' style='display:none;'>
<?php
# To avoid cluttered graph, divide stat_list into chunks
$chunk_size = 999;
$stat_chunks = array_chunk($stat_list, $chunk_size, true);
$i = 1;
foreach($stat_chunks as $stat_chunk)
{
	$div_id = "placeholder_".$i;
	$legend_id = "legend_".$i;
	$ylabel_id = "ylabel_".$i;
	$width_px = count($stat_chunk)*150;
	//$width_px=880;
	?>
	<table>
	<tbody>
	<tr valign='top'>
	<td>
		<span id="<?php echo $ylabel_id; ?>" class='flipv_up' style="width:30px;height:30px;"><?php echo LangUtil::$generalTerms['PREVALENCE_RATE']; ?> (%)</span>
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
	<?php
	<script id="source" language="javascript" type="text/javascript"> 
	$(function () {
		<?php
		$x_val = 0;
		$count = 1;
		foreach($stat_chunk as $key=>$value)
		{
			$test_type_id = $key;
			$count_all = $value[0];
			$count_negative = $value[1];
			$infection_rate = 0;
			if($count_all != 0)
				$infection_rate = round((($count_all-$count_negative)/$count_all)*100, 2);
			echo "var d$count = [];";
			echo "d$count.push([$x_val, $infection_rate]);";
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
					bars: { show: true, barWidth: 1 }//,
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
		], { xaxis: {ticks: <?php echo $tick_array; ?>}, legend: {container: "#<?php echo $legend_id; ?>"}  }
		);
		$('#<?php echo $ylabel_id; ?>').flipv_up();
	});
	</script>
	<?php
	# End of loop
	$i++;
}
?>
</div>
<?php
*/
?>
<div id='prevalance'style='display:none'>
<table> 
	<tr> 
		<td width="1%">
			<?php echo LangUtil::$generalTerms['FROM_DATE']; ?> 
		</td>
		<td>
			<?php 
			$name_list = array("yf","mf","df");
			$id_list = $name_list;
			$df_parts = explode("-", $date_from);
			$page_elems->getDatePicker($name_list, $id_list, $df_parts, false);
			?>
		</td>
		<td align="right">
			<?php echo LangUtil::$generalTerms['TO_DATE']; ?>
		</td>
		<td>
			<span>
			<?php 
			$name_list = array("yt", "mt", "dt");
			$id_list = $name_list;
			$dt_parts = explode("-", $date_to);
			$page_elems->getDatePicker($name_list, $id_list, $dt_parts, false);
			?>
			</span>
		</td>
	</tr>
	<tr>
		<td><?php echo LangUtil::$generalTerms['TYPE']; ?></td>
		<td >
			<select name='tattype' id='tattype' class=uniform_width>
				<option value='m'><?php echo LangUtil::$pageTerms['PROGRESSION_M']; ?></option>
				<option value='w'><?php echo LangUtil::$pageTerms['PROGRESSION_W']; ?></option>
				<option value='d'><?php echo LangUtil::$pageTerms['PROGRESSION_D']; ?></option>
			</select>
		</td>
		<td align="right"><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
		<td>
			<select name='ttype' id='ttype' class=uniform_width>
				<?php $page_elems->getDiscreteTestTypesSelect($lab_config->id); ?>
			</select>
		</td>
	</tr>
	<tr valign='top'>
		<!--<td><?php echo LangUtil::$generalTerms['GENDER']; ?></td>-->
		<td align="right">
		<!--<input type='radio' name='gender' id='gender' value='A' checked><?php echo LangUtil::$generalTerms['ALL']; ?></input>
			<input type='radio' name='gender' id='gender' value='M'> <?php echo LangUtil::$generalTerms['MALE']; ?></input>
			<input type='radio' name='gender' id='gender' value='F'> <?php echo LangUtil::$generalTerms['FEMALE']; ?></input>
		-->
		<input type="checkbox" name="gender" value='M'> </td><td>Seperate by gender<br>
		</td><td align="right"><input type="checkbox" name="age" value='A'></td><td> Seperate by age<br>
		</td>
		<td>
		</td>
		<td align='left'>
			<input type='button' onclick='javascript:view_prevalance();' value='<?php echo LangUtil::$generalTerms['CMD_VIEW']; ?>'></input>
			&nbsp;&nbsp;<span id='progress_spinner' style='display:none'><?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?></span>
		</td>
	</tr>
</table>

<div id='prevalance_graph' >
</div>
</div>
<div id='stat_table'>
	<?php $page_elems->getInfectionStatsTable($stat_list); ?>
</div>

<?php include("includes/footer.php"); ?>