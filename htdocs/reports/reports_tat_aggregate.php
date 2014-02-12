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

$site_list = get_site_list($_SESSION['user_id']);
$lab_config_id = $_REQUEST['locationAgg'];
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$include_pending = $_REQUEST['pending'];
$tat_type = $_REQUEST['tattype'];
$ttype = $_REQUEST['ttype'];
if($_REQUEST['pending'] == 'Y') {
	$include_pending = true;
}
?>
<script type='text/javascript'>
$(document).ready(function(){

	<?php 
	if($include_pending == 'Y') { ?>
		$('#pending_chk').attr('checked', true);
	<?php } ?>
		$('#ttype').val(<?php echo json_encode($ttype);?>);
	
	view_tat(<?php echo json_encode($tat_type); ?>);
});

function toggle_stat_table()
{
	$('#stat_table').toggle();
	var linktext = $('#showtablelink').text();
	if(linktext.indexOf("<?php echo LangUtil::$pageTerms['MSG_SHOWTABLE']; ?>") != -1)
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_HIDETABLE']; ?>");
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
	});
}

function view_testwise_weekly()
{
	var date_from = $('#yf').attr("value")+"-"+$('#mf').attr("value")+"-"+$('#df').attr("value");
	var date_to = $('#yt').attr("value")+"-"+$('#mt').attr("value")+"-"+$('#dt').attr("value");
	var include_pending = 0;
	
	/* Get Selected Lab Values */
	var myTR=document.getElementById('locationAggregation');
	var inputArray=myTR.getElementsByTagName('input');
	var locationAgg = new Array();
	var count = 0;
	for(var i=0;i<inputArray.length;i++){
		if(inputArray[i].type=='checkbox' && inputArray[i].checked==true){
			locationAgg[count++] = inputArray[i].value;
		}
    }
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
	if(locationAgg.length != 0)
		var url_string = "ajax/tat_ttype_weekly.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l="+locationAgg+"&p="+include_pending;
	else
		var url_string = "ajax/tat_ttype_weekly.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&l=<?php echo $lab_config_id; ?>&p="+include_pending;
	//alert(url_string);
	$('#stats_testwise_div').load(url_string, function() {
		$('#stats_testwise_div').show();
		$('#stats_cumul_div').hide();
		$('#progress_spinner').hide();
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
	});
}

function view_tat(tat_type) {

	if( typeof(tat_type) == 'undefined' )
		var tat_type = $('#tattype').attr("value");
	if(tat_type == 'm')
		view_testwise_monthly();
	else if(tat_type == 'w')
		view_testwise_weekly();
	else if(tat_type == 'd')
		view_testwise_daily();		
}

function changeAvailableLocations(dropdown) {
	var index  = dropdown.selectedIndex;
    var selectValue = dropdown.options[index].value;
	var url_string = 'ajax/locations_bytests.php?l='+selectValue+'&checkBoxName=locationAgg[]';
	$('#locationAggregation').load(url_string);
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
<b><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></b><br>
<?php 
/*
$lab_config = get_lab_config_by_id($lab_config_id); ?><br>
<a href='reports.php?show_t'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>
<?php 
	if($lab_config == null) { ?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?> <a href='javascript:history.go(-1);'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
	</div>
	<?php return; } 
*/ 
?>
<a href='reports.php?show_t_agg'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<table>
<tbody>
<tr>
<td>
<?php echo LangUtil::$generalTerms['FROM_DATE']; ?> 
<td>
<?php 
$name_list = array("yf", "mf", "df");
$id_list = $name_list;
$df_parts = explode("-", $date_from);
$page_elems->getDatePicker($name_list, $id_list, $df_parts, false);
?>
</td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<tr>
<td><?php echo LangUtil::$generalTerms['TO_DATE']; ?></td>
<td><?php 
$name_list = array("yt", "mt", "dt");
$id_list = $name_list;
$dt_parts = explode("-", $date_to);
$page_elems->getDatePicker($name_list, $id_list, $dt_parts, false);
?>
</td>
</tr>
<tr id='testType'>
	<td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
	<td>
		<select name='ttype' id='ttype' class='uniform_width' onchange='changeAvailableLocations(this)'>
			<option value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></option>
			<?php
				$page_elems->getTestTypesCountrySelect();
			?>
		</select>
	</td>
</tr>
<tr class="location_row_aggregate" id="location_row_aggregate">
	<td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;</td>
	<td id='locationAggregation'>
		<input type='checkbox' name='locationAgg' id='locationAgg' value='0'><?php echo LangUtil::$generalTerms['ALL']; ?></input>
		<?php
			$page_elems->getSiteOptionsCheckBoxes("locationAgg[]");
		?>
	</td>
</tr>
<tr valign='top'>
	<td><?php echo LangUtil::$pageTerms['MSG_INCLUDEPENDING']; ?> </td>
	<td>
		<input type='radio' value='Y' name='pending'><?php echo LangUtil::$generalTerms['YES']; ?></input>
		<input type='radio' value='N' name='pending' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
	</td>
</tr>
<tr valign='top'>
<td><?php echo "Time Division"; ?></td>
<td>
<select name='tattype' id='tattype' style='font-family:Tahoma;'>
	<option value='m'><?php echo LangUtil::$pageTerms['PROGRESSION_M']; ?></option>
	<option value='w' selected><?php echo LangUtil::$pageTerms['PROGRESSION_W']; ?></option>
	<option value='d'><?php echo LangUtil::$pageTerms['PROGRESSION_D']; ?></option>
</select>
</td>
</tr>
<tr>
<td></td>
<td>
<input type='button' onclick='javascript:view_tat();' value='<?php echo LangUtil::$generalTerms['CMD_VIEW']; ?>'></input>
<span id='progress_spinner' style='display:none'><?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?></span>
</td>
</tr>
</tbody>
</table>
<br><br>
<?php

/*$stat_list = StatsLib::getTatStats($lab_config, $date_from, $date_to);

if(count($stat_list) == 0)
{
	?>
	<br>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$pageTerms['TIPS_NOTATTESTS']; ?>
	</div>
	<?php
}
*/
?>
<div id='stats_testwise_div'></div>
<div id='stats_cumul_div'>

</div>
<?php include("includes/footer.php"); ?>