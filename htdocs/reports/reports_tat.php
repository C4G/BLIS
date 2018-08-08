<?php
#
# Shows turnaround time report for a site/location and date interval
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
LangUtil::setPageId("reports");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
$script_elems->enableDatePicker();

$lab_config_id = $_REQUEST['location'];
$lab_config = get_lab_config_by_id($lab_config_id);
$site_list = get_site_list($_SESSION['user_id']);
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$include_pending = false;
$uiinfo = "from=".$date_from."&to=".$date_to."&ip=".$_REQUEST['pending'];
putUILog('reports_tat', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
if($_REQUEST['pending'] == 'Y')
{
	$include_pending = true;
}
?>
<script type='text/javascript'>
$(document).ready(function(){
	<?php
	if($include_pending === true)
	{
		?>
		$('#pending_chk').attr('checked', true);
		<?php
	}
	?>
	view_testwise_weekly();
});

function toggle_stat_table()
{
	$('#stats_testwise_div').toggle();
	$('#stat_table').toggle();
	var linktext = $('#showtablelink').text();
	if(linktext.indexOf("<?php echo LangUtil::$pageTerms['MSG_SHOWTABLE']; ?>") != -1)
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>");
	else
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_SHOWTABLE']; ?>");
}

function view_cumul()
{
	$('#progress_spinner').show();
	$('#stats_testwise_div').hide();
	$('#stats_cumul_div').show();
	$('#progress_spinner').hide();
}

function view_testwise_monthly()
{
	var date_from = $('#yf').attr("value")+"-"+$('#mf').attr("value")+"-"+$('#df').attr("value");
	var date_to = $('#yt').attr("value")+"-"+$('#mt').attr("value")+"-"+$('#dt').attr("value");
	var include_pending = 0;
	if($('#pending_chk').is(':checked'))
	{
		include_pending = 1;
	}
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
	var url_string = "ajax/tat_ttype_monthly.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>&p="+include_pending;
	$('#stats_testwise_div').load(url_string, function() {
		$('#stats_testwise_div').show();
		$('#stats_cumul_div').hide();
		$('#progress_spinner').hide();
		var url_string = "ajax/tat_table.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>&p="+include_pending;
		$('#stat_table').load(url_string);
	});
}

function view_testwise_weekly()
{
	var date_from = $('#yf').attr("value")+"-"+$('#mf').attr("value")+"-"+$('#df').attr("value");
	var date_to = $('#yt').attr("value")+"-"+$('#mt').attr("value")+"-"+$('#dt').attr("value");
	var include_pending = 0;
	if($('#pending_chk').is(':checked'))
	{
		include_pending = 1;
	}
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
	var url_string = "ajax/tat_ttype_weekly.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>&p="+include_pending;
	$('#stats_testwise_div').load(url_string, function() {
		$('#stats_testwise_div').show();
		$('#stats_cumul_div').hide();
		$('#progress_spinner').hide();
		var url_string = "ajax/tat_table.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>&p="+include_pending;
		$('#stat_table').load(url_string);
	});
}

function view_testwise_daily()
{
	var date_from = $('#yf').attr("value")+"-"+$('#mf').attr("value")+"-"+$('#df').attr("value");
	var date_to = $('#yt').attr("value")+"-"+$('#mt').attr("value")+"-"+$('#dt').attr("value");
	var include_pending = 0;
	if($('#pending_chk').is(':checked'))
	{
		include_pending = 1;
	}
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
	var url_string = "ajax/tat_ttype_daily.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>&p="+include_pending;
	$('#stats_testwise_div').load(url_string, function() {
		$('#stats_testwise_div').show();
		$('#stats_cumul_div').hide();
		$('#progress_spinner').hide();
		var url_string = "ajax/tat_table.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>&p="+include_pending;
		$('#stat_table').load(url_string);
	});
}

function view_tat()
{
	$('#stat_table').hide();
	$('#stat_table').empty();
	$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_SHOWTABLE']; ?>");
	var tat_type = $('#tattype').attr("value");
	if(tat_type == 'm')
		view_testwise_monthly();
	else if(tat_type == 'w')
		view_testwise_weekly();
	else if(tat_type == 'd')
		view_testwise_daily();	
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
<b><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></b>
<?php
if($lab_config != null && count($site_list) != 1)
{
	?>
	| <?php echo LangUtil::$generalTerms['FACILITY'] ?>: <?php echo $lab_config->getSiteName(); ?>
	<?php
}
?>
 | <a href="javascript:toggle_stat_table();" id='showtablelink'><?php echo LangUtil::$pageTerms['MSG_SHOWTABLE']; ?></a>
 | <a href='reports.php?show_t'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>
<?php
if($lab_config == null)
{
	?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?> <a href='javascript:history.go(-1);'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
	</div>
	<?php
	return;
}

DbUtil::switchToLabConfig($lab_config_id);
?>
<?php echo LangUtil::$generalTerms['FROM_DATE']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
$name_list = array("yf", "mf", "df");
$id_list = $name_list;
$df_parts = explode("-", $date_from);
$page_elems->getDatePicker($name_list, $id_list, $df_parts, false);
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo LangUtil::$generalTerms['TO_DATE']; ?>
<span>
<?php 
$name_list = array("yt", "mt", "dt");
$id_list = $name_list;
$dt_parts = explode("-", $date_to);
$page_elems->getDatePicker($name_list, $id_list, $dt_parts, false);
?>
</span>
<br><br>
<?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>
&nbsp;
<select name='ttype' id='ttype' style='font-family:Tahoma;'>
	<option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
	<?php $page_elems->getTestTypesSelect($lab_config->id); ?>
</select>
&nbsp;&nbsp;&nbsp;
<input type='checkbox' id='pending_chk' name='pending'><?php echo LangUtil::$pageTerms['MSG_INCLUDEPENDING']; ?></input>
<small>
&nbsp;&nbsp;&nbsp;
<select name='tattype' id='tattype' style='font-family:Tahoma;'>
	<option value='m'><?php echo LangUtil::$pageTerms['PROGRESSION_M']; ?></option>
	<option value='w' selected><?php echo LangUtil::$pageTerms['PROGRESSION_W']; ?></option>
	<option value='d'><?php echo LangUtil::$pageTerms['PROGRESSION_D']; ?></option>
</select>
&nbsp;&nbsp;&nbsp;
<input type='button' onclick='javascript:view_tat();' value='<?php echo LangUtil::$generalTerms['CMD_VIEW']; ?>'></input>
<?php
# Replaced by single select box above
/*
<br>
<a href='javascript:view_testwise_monthly();' id='monthly_link' title='Select a test type and click to view monthly progression chart'><?php echo LangUtil::$pageTerms['PROGRESSION_M']; ?></a>
&nbsp;&nbsp;&nbsp;
<a href='javascript:view_testwise_weekly();' id='weekly_link' title='Select a test type and click to view weekly progression chart'><?php echo LangUtil::$pageTerms['PROGRESSION_W']; ?></a>
&nbsp;&nbsp;&nbsp;
<a href='javascript:view_testwise_daily();' id='daily_link' title='Select a test type and click to view daily progression chart'><?php echo LangUtil::$pageTerms['PROGRESSION_D']; ?></a>
</small>
*/
?>
&nbsp;&nbsp;&nbsp;
<span id='progress_spinner' style='display:none'><?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?></span>
<br><br>
<?php
$stat_list = StatsLib::getTatStats($lab_config, $date_from, $date_to);

if(count($stat_list) == 0)
{
	?>
	<br>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$pageTerms['TIPS_NOTATTESTS']; ?>
	</div>
	<?php
}
?>
<div id='stats_testwise_div'></div>
<div id='stats_cumul_div'></div>

<div id='stat_table' style='display:none'></div>
<?php include("includes/footer.php"); ?>