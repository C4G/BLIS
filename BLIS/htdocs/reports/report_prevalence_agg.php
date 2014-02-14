<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
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
<script type="text/javascript" src="js/highcharts.js"></script>
<script type='text/javascript'>
$(window).load(function(){
	//$('#stat_graph').hide();
	//$('#stat_graph_bar').hide();
	viewTrends();
	$('#trendsDiv').hide();
});

function toggle_stat_table()
{ 
	if( $('#showtablelink').text() == <?php echo '"'.LangUtil::$pageTerms['MSG_HIDEGRAPH'].'"'; ?> ) {
		$('#showtablelink').text(<?php echo '"'.LangUtil::$pageTerms['MSG_SHOWGRAPH'].'"'; ?>);
		$('#trendsDiv').hide();
	}
	else {
		$('#showtablelink').text(<?php echo '"'.LangUtil::$pageTerms['MSG_HIDEGRAPH'].'"'; ?>);
		$('#trendsDiv').show();
	}
}

/*
function toggle_stat_graph()
{ 
	var linktext = $('#showgraphlink').text();
	if(linktext.indexOf("Show Graph") != -1) {
		$('#showgraphlink').text("Hide Graph");
		$('#trendsDiv').hide();
		$('#stat_graph_bar').show();
	}
	else {

		$('#showgraphlink').text("Show Graph");
		$('#stat_graph_bar').hide();
		}
}
*/

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
function view_prevalance_bar()
{

	$('#stat_graph_bar').toggle();
	var linktext = $('#showbarGraph').text();
	if(linktext.indexOf("Show Graph") != -1)
		{
		$('#showbarGraph').text("Hide Graph");
				
			}
	else
		{
		$('#showbarGraph').text("Show Graph");
		}
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
	/*
	$('#prevalance_graph').load(url_string, function() {
		$('#prevalance_graph').show();
		$('#progress_spinner').hide();
	});
	*/
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
<?php

$lab_config_id = $_REQUEST['locationAgg'];
if( count($lab_config_id) == 1 && $lab_config_id[0] == 0 )
	$lab_config_id = 0;
$summary_type = $_REQUEST['summary_type'];
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
//$test_type_id = 0;
$test_type_id = $_REQUEST['testTypeCountry'];

?>
<b><?php echo LangUtil::$pageTerms['MENU_INFECTIONSUMMARY']; ?></b>
<?php /* |<a href="javascript:toggle_stat_graph();" id='showgraphlink'>Show Graph</a> */ ?>
 | <a href="javascript:toggle_stat_table();" id='showtablelink'><?php echo LangUtil::$pageTerms['MSG_SHOWGRAPH']; ?></a>
 | <a href='reports.php?show_p_agg'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>

<div id='prevalance_graph' >
</div>

<?php


if( $lab_config_id != 0 ) {
	$lab_config = get_lab_config_by_id($lab_config_id[0]);
	if($lab_config == null)
	{
		?>
		<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['MSG_NOTFOUND'] ?>
		</div>
		<?php
		return;
	}
	DbUtil::switchToLabConfig($lab_config_id);
}


# Cumulative summary
$stat_list = array();
$stat_list = StatsLib::getDiscreteInfectionStatsAggregate($lab_config_id, $date_from, $date_to, $test_type_id);
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
function processWeeklyTrends( $lab_config_id, $test_type_id, $date_from, $date_to, $test_name = null) {
	global $namesArray;
	global $stat_list;
	
	# All Tests & All Labs */
	if( $test_type_id == 0 && $lab_config_id == 0 ) { 
		$site_list = get_site_list($_SESSION['user_id']);
		
		$userId = $_SESSION['user_id'];
		$saved_db = DbUtil::switchToGlobal();
		$query = "SELECT * FROM test_mapping WHERE user_id = $userId";
		$resultset = query_associative_all($query, $row_count);
		foreach($resultset as $record) {
				$labIdTestIds = explode(';',$record['lab_id_test_id']);
				foreach($labIdTestIds as $labIdTestId) {
					$labIdTestId = explode(':',$labIdTestId);
					$labId = $labIdTestId[0];
					$testId= $labIdTestId[1];
					$test_type_list_all[$labId][] = $testId;
					$test_type_names[$labId][] = $record['test_name'];
				}
		}
		DbUtil::switchRestore($saved_db);
			
		foreach( $site_list as $key => $value) {
				
			$lab_config = LabConfig::getById($key);
			$test_type_list = array();
			$test_type_list = $test_type_list_all[$key];
			$testNames = $test_type_names[$key];
			$saved_db = DbUtil::switchToLabConfig($lab_config->id);
			$testCount = -1;
			
			foreach($test_type_list as $test_type_id) {
				$query_string = 
						"SELECT COUNT(*) AS count_val FROM test t, specimen s ".
						"WHERE t.test_type_id=$test_type_id ".
						"AND t.specimen_id=s.specimen_id ".
						"AND result!=''".
						"AND ( s.date_collected BETWEEN '$date_from' AND '$date_to' )";
				$record = query_associative_one($query_string);
				$count_all = intval($record['count_val']);
				$testCount++;
				if($count_all == 0)
						continue;
				
				$namesArray[] = $lab_config->name." - ".$testNames[$testCount];
				getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);
			}
		}
	}
	# All Tests for a Single Lab
	else if ( $test_type_id == 0 && count($lab_config_id) == 1 ) {
		$lab_config = LabConfig::getById($lab_config_id[0]);
		$test_type_list = get_discrete_value_test_types($lab_config);
		foreach($test_type_list as $test_type_id) {
			$namesArray[] = get_test_name_by_id($test_type_id, $lab_config_id[0]);
			getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);
		}
	}
	# All Tests for more than one lab
	else if ( $test_type_id == 0 && count($lab_config_id) > 1 ) {
		$userId = $_SESSION['user_id'];
		$saved_db = DbUtil::switchToGlobal();
		$query = "SELECT * FROM test_mapping WHERE user_id = $userId";
		$resultset = query_associative_all($query, $row_count);
		foreach($resultset as $record) {
				$labIdTestIds = explode(';',$record['lab_id_test_id']);
				foreach($labIdTestIds as $labIdTestId) {
					$labIdTestId = explode(':',$labIdTestId);
					$labId = $labIdTestId[0];
					$testId= $labIdTestId[1];
					$test_type_list_all[$labId][] = $testId;
					$test_type_names[$labId][] = $record['test_name'];
				}
		}
		DbUtil::switchRestore($saved_db);
			
		foreach( $lab_config_id as $key) {
			$lab_config = LabConfig::getById($key);
			$test_type_list = array();
			$test_type_list = $test_type_list_all[$key];
			$testNames = $test_type_names[$key];
			$saved_db = DbUtil::switchToLabConfig($lab_config->id);
			$testCount = -1;
			
			foreach($test_type_list as $test_type_id) {
				$query_string = 
						"SELECT COUNT(*) AS count_val FROM test t, specimen s ".
						"WHERE t.test_type_id=$test_type_id ".
						"AND t.specimen_id=s.specimen_id ".
						"AND result!=''".
						"AND ( s.date_collected BETWEEN '$date_from' AND '$date_to' )";
				$record = query_associative_one($query_string);
				$count_all = intval($record['count_val']);
				$testCount++;
				if($count_all == 0)
						continue;
				
				$namesArray[] = $lab_config->name." - ".$testNames[$testCount];
				getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);
			}
		}
	}
	else {
		/* Build Array Map with Lab Id as Key and Test Id as corresponding Value */
		$labIdTestIds = explode(";",$test_type_id);
		$testIds = array();
		foreach( $labIdTestIds as $labIdTestId) {
				$labIdTestIdsSeparated = explode(":",$labIdTestId);
				$labId = $labIdTestIdsSeparated[0];
				$testId = $labIdTestIdsSeparated[1];
				$testIds[$labId] = $testId;
		}
		# Particular Test & All Labs
		if ( $test_type_id != 0 && $lab_config_id == 0 ) {
			$site_list = get_site_list($_SESSION['user_id']);
		
			foreach( $site_list as $key => $value) {
				$lab_config = LabConfig::getById($key);
				$test_type_id = $testIds[$lab_config->id];
				$namesArray[] = $lab_config->name;
				getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);
			}
		}
		# Particular Test for Single Lab
		else if ( $test_type_id != 0 && count($lab_config_id) == 1 ) {
			$lab_config = LabConfig::getById($lab_config_id[0]);
			$test_type_id = $testIds[$lab_config->id];
			$namesArray[] = $lab_config->name;
			getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);	
		}
		# Particular Test & Multiple Labs	
		else if ( $lab_config_id != 0 && $test_type_id != 0 ) {
				foreach( $lab_config_id as $key) {
					$lab_config = LabConfig::getById($key);
					$test_type_id = $testIds[$lab_config->id];
					$namesArray[] = $lab_config->name;
					getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);
				}
		}
	}
	/*
	$lab_config = LabConfig::getById($lab_config_id[0]);
	if($lab_config) {
		//$test_type_list = get_discrete_value_test_types($lab_config);
			
		foreach($test_type_list as $test_type_id) {
			$namesArray[] = get_test_name_by_id($test_type_id, $lab_config_id[0]);
			getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);
		}
	}
	*/
}

function getWeeklyStats( $lab_config, $test_type_id, $date_from, $date_to, $test_name = null ) {
			global $xAxisGraph;
			global $progressTrendsData;
			
			$stats = StatsLib::getDiscreteInfectionStatsWeekly($lab_config, $test_type_id, $date_from, $date_to);
			foreach($stats as $key => $value) {
				$formattedDate = bcmul($key,1000);
				if( $value[0] != 0) {
					$progressData[] = array($formattedDate,100-round(($value[1]/$value[0])*100,2));
				}	
				else {
					$progressData[] = array($formattedDate,0);
				}
			}
			$progressTrendsData[] = $progressData;
}

?>
	<div id="trendsDiv" style="width: 800px; height: 400px; margin: 0 auto" ></div>


<div id='stat_table'>
<?php
	$multipleIndividualLabs = false;
	$viewTrendsEnabled = false;
	$page_elems->getInfectionStatsTableAggregate($stat_list, $date_from, $date_to, $test_type_id, $lab_config_id, $multipleIndividualLabs, $viewTrendsEnabled);
	processWeeklyTrends($lab_config_id, $test_type_id, $date_from, $date_to);
?>
</div>
<div id='trendsDiv_progress_spinner' style="display:none;">
		<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
</div>
<?php
	//if( !($lab_config_id == 0 && $test_type_id == 0) && !($test_type_id == 0 && count($lab_config_id)>1) )
		createTrends();
?>

<?php /*
<div id='stat_table'>
	<?php $page_elems->getInfectionStatsTable($stat_list); ?>
</div>
*/ ?>

<div id='stat_graph_bar' >
<?php /*
# To avoid cluttered graph, divide stat_list into chunks
$chunk_size = 999;
$stat_chunks = array_chunk($stat_list, $chunk_size, true);
$i = 1;
foreach($stat_chunks as $stat_chunk)
{
	$div_id = "placeholder_".$i;
	$legend_id = "legend_".$i;
	$ylabel_id = "ylabel_".$i;
	$width_px = count($stat_chunk)*65;
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
} */
?> 
</div>

<?php
function createTrends() { 
	global $namesArray;
	global $progressTrendsData;
?>

	<script type="text/javascript">
		function viewTrends() {
			var progressData = new Array();
			var namesArray = <?php echo json_encode($namesArray); ?>;
			var progressTrendsDataTemp = <?php echo json_encode($progressTrendsData); ?>;
			
			var values, value1, value2;
			/* Convert the string timestamps to floatvalue timestamps */
			for(var j=0;j<progressTrendsDataTemp.length;j++) {
				var i = 0;
				if( progressTrendsDataTemp[j][i]) {
					progressData[j] = new Array();
					while ( progressTrendsDataTemp[j][i] ) {
						values = progressTrendsDataTemp[j][i];
						value1 = parseFloat(values[0]);
						value2 = values[1];
						progressData[j][i] = [value1, value2];
						i++;
					}
				}
			}
			
			//$('#stat_graph').hide();
			//$('#stat_graph_bar').hide();
			//$('#viewGraphSpan').show();
			//$('#hideGraphSpan').hide();
			//$('#viewTrendSpan').hide();
			//$('#hideTrendSpan').show();
			createChart(namesArray, progressData);
		}
	
		function createChart(namesArray, progressData) {
			var chart;
			var options = {
			chart: {
				 renderTo: 'trendsDiv',
				 type: 'spline'
			  },
			  title: {
				 text: <?php echo "'".LangUtil::$pageTerms['MENU_INFECTIONSUMMARY']."'"; ?>//'Prevalence Rate'
			  },
			  xAxis: {
				 type: 'datetime',
				 dateTimeLabelFormats: { // don't display the dummy year
					month: '%e. %b',
					year: '%b'
				 }
			  },
			  yAxis: {
				 title: {
					text: 'Percentage (%)'
				 },
				 min: 0
			  },
			  tooltip: {
				 formatter: function() {
						   return '<b>'+ this.series.name +'</b><br/>'+
					   Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' %';
				 }
			  },
			  series: [{
				name : ' ', 
				tickInterval: 7 * 24 * 3600 * 1000, // one week
				pointStart: Date.UTC(2011, 0, 1),
				data: [ ]
			  }]
		   };
	   
			for(var i=0;i<namesArray.length;i++) {
				options.series.push({
					name: namesArray[i],
					data: progressData[i]
				});
			}
		   chart = new Highcharts.Chart(options);
		}
		
	</script>
<?php
}
?>
<div id='prevalance' style='display:none;'>
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
</div>


<?php include("includes/footer.php"); ?>