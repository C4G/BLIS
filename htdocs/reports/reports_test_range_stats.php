<?php
#
# Shows tests performed report for a site/location and date interval
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
//include("/includes/db_lib.php");
LangUtil::setPageId("reports");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();

?>
</script>

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

<b><?php echo "Test Range"; ?></b> 
 | <a href='reports.php?show_tsr'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>
<?php
session_start();

$user = get_user_by_name($_SESSION['username']);
$lab_config_id = $user->labConfigId;

$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$uiinfo = "from=".$date_from."&to=".$date_to;
putUILog('reports_test_range_stats', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
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

?>

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
<br/>
<?php
$test_id = $_REQUEST['test_type_id_1'];
$result = StatsLib::getUpplerLowerRange($lab_config,$test_id);

foreach($result as $record) 
{
	$lower_range= str_replace(array('<','>'),'',$record['LOWER_RANGE']);
	$upper_range= str_replace(array('<','>'),'',$record['UPPER_RANGE']);
	$sex =$record['SEX'];

	echo "Lower Range: ".$lower_range." Upper Range: ".$upper_range." SEX: ".$sex; ?>
	<br><br>
	<?php 
		$test_range_count = StatsLib::gettestRangeStats($lab_config, $date_from, $date_to,$test_id,$lower_range,$upper_range, $sex) ;
		/* $below_range=$test_range_count['BELOW_LOWER_RANGE'];
		$in_range = $test_range_count['IN_RANGE'];
		$above_high_range=$test_range_count['ABOVE_HIGH_RANGE'];*/ ?>
<br><br>
	<div id='stat_table'>
		<?php $page_elems->gettestRangeStatsTable($test_range_count); ?>
	</div>
	<br><br>
<?Php } ?>

<?php include("includes/footer.php"); ?>