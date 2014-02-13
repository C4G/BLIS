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

	//$('#stat_graph').hide();
	
});
function toggle_stat_table()
{
	$('#prevalance').toggle();
	//$('#stat_graph_bar').toggle();
	var linktext = $('#showtablelink').text();
	if(linktext.indexOf("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>") != -1)
		{
		$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_HIDEGRAPH']; ?>");
						view_prevalance();
				$('#prevalance_graph').show();


		}
	else
		{$('#showtablelink').text("<?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?>");
		$('#prevalance_graph').hide();
		//$('#tattype').attr("value")='w';
		}
}

function view_prevalance1()
{

	var tat_type = $('#tattype').attr("value");
	
	
	if(tat_type == 'm')
	view_testwise_monthly();
	
else if(tat_type == 'w')
	view_testwise_weekly();

	else if(tat_type == 'd')
		view_testwise_daily();	
	

}

function view_prevalance()
{

var tat_type = $('#tattype').attr("value");
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
	
	var type=$("input[name='gender']:checked").attr("value");
	
		
	 if(type=="S")
	{
	
	var url_string ="ajax/gender_prevalance.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&type="+tat_type+"&l=<?php echo $lab_config_id; ?>";
	
	}
	else if(type=="A")
	{
     
	var url_string = "ajax/age_prevalance.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&type="+tat_type+"&l=<?php echo $lab_config_id; ?>";
	
	}
	else if(type=="G")
	{
	
	var url_string="ajax/general_prevalance.php?tt="+ttype+"&df="+date_from+"&dt="+date_to+"&type="+tat_type+"&l=<?php echo $lab_config_id; ?>";
	
	}
	$('#prevalance_graph').load(url_string, function() {
		$('#prevalance_graph').show();
		$('#progress_spinner').hide();
	});


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
 | <a href='reports.php'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>
<?php
$lab_config_id ="129";// $_REQUEST['location'];
$summary_type = $_REQUEST['summary_type'];
$date_from = '2010-01-01';//$_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to ='2011-01-01';// $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
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
 $site_list = get_site_list($_SESSION['user_id']);
			if(count($site_list) != 1)
			{ echo LangUtil::$generalTerms['FACILITY'] ?>: <?php echo $lab_config->getSiteName(); 
}

?>

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
?>
<div id='prevalance'>
<table> 
	<tr> <td width="1%"><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
		<td>
			<?php 
			$name_list = array("yf","mf","df");
			$id_list = $name_list;
			$df_parts = explode("-", $date_from);
			$page_elems->getDatePicker($name_list, $id_list, $df_parts, false);
			?>
		</td>
		<td align="right"><?php echo LangUtil::$generalTerms['TYPE']; ?></td>
		<td>
			<select name='tattype' id='tattype' class=uniform_width>
				<option value='w'><?php echo LangUtil::$pageTerms['PROGRESSION_W']; ?></option>
				<option value='d'><?php echo LangUtil::$pageTerms['PROGRESSION_D']; ?></option>
				<option value='m'><?php echo LangUtil::$pageTerms['PROGRESSION_M']; ?></option>
			</select>
		</td>
		<td align="right"><?php echo LangUtil::$generalTerms['ALL']; ?></td>
		<td align="left"><input type='radio' name='gender' id='gender' value='G' checked></input></td>
		<td></td>
		</tr>
		<tr>
		<td align="right"><?php echo LangUtil::$generalTerms['TO_DATE']; ?></td>
		<td><span>
			<?php 
			$name_list = array("yt", "mt", "dt");
			$id_list = $name_list;
			$dt_parts = explode("-", $date_to);
			$page_elems->getDatePicker($name_list, $id_list, $dt_parts, false);
			?>
			</span>
		</td>
		<td align="right"><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
		<td><select name='ttype' id='ttype' class=uniform_width><?php $page_elems->getDiscreteTestTypesSelect($lab_config->id); ?></select></td>
		<td align='right'> Separate by <?php echo LangUtil::$generalTerms['GENDER']; ?></td>
		<td align='left'><input type='radio' name='gender' id='gender' value='S'> </input></td>
		<td align='left'><input type='button' onclick='javascript:view_prevalance();' value='<?php echo LangUtil::$generalTerms['CMD_VIEW']; ?>'></input>
			</td></tr>
			<tr><td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><span id='progress_spinner' style='display:none'><?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?></span>
		</td>
	</tr>
</table>

<div id='prevalance_graph' >
</div>
</div>
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
<?php include("includes/footer.php"); ?>