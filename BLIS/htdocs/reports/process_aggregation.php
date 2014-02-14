<?php

include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
LangUtil::setPageId("reports");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
?>

<script type="text/javascript">
	$(window).load(function(){
		$('#stat_graph').hide();
		$('#stat_graph_bar').hide();
	});
		
	function showGraph() {
		$('#stat_graph').show();
		$('#stat_graph_bar').show();
		$('#viewGraphSpan').hide();
		$('#hideGraphSpan').show();
		$('#hideTrendSpan').hide();
		$('#viewTrendSpan').show();
	}
	
	function hideGraph() {
		$('#stat_graph').hide();
		$('#stat_graph_bar').hide();
		$('#viewGraphSpan').show();
		$('#hideGraphSpan').hide();
		$('#viewTrendSpan').show();
		$('#hideTrendSpan').hide();
	}
	
	function hideTrends() {
		$('#stat_graph').hide();
		$('#stat_graph_bar').hide();
		$('#viewGraphSpan').show();
		$('#hideGraphSpan').hide();
		$('#viewTrendSpan').show();
		$('#hideTrendSpan').hide();
		$('#trendsDiv').hide();
	}
</script>

<script type="text/javascript" src="js/highcharts.js"></script>
<br>
<div id = 'links'>
	<a href='reports.php?show_agg'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a> | 
	<span id='viewGraphSpan'><a href='javascript:showGraph();'>View Graph</a></span>
	<span id='hideGraphSpan' style='display:none;'><a href='javascript:hideGraph();'>Hide Graph</a></span> 
	|
	<span id='viewTrendSpan'><a href='javascript:viewTrends();'>View Trends</a></span>
	<span id='hideTrendSpan' style='display:none;'><a href='javascript:hideTrends();'>Hide Trends</a></span>
 </div>
<br>
<b>
<?php echo LangUtil::$pageTerms['MENU_INFECTIONSUMMARY']; ?></b>
<?php
	$lab_config_id_array = $_REQUEST['locationAgg'];
?>
</script>
<?php
$test_type_id = $_REQUEST['testTypeCountry'];
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$reportType = $_REQUEST['reportTypeSelect'];
$lab_config_id = 0;
$labNamesArray = array();
$xAxisGraph = array();
$progressGraphData = array();

function publishDates( $date_from, $date_to ) {
	echo "<br><br>";
	if($date_from == $date_to)
			echo LangUtil::$generalTerms['DATE'].": ".DateLib::mysqlToString($date_from)."<br>";
	else {
			echo LangUtil::$generalTerms['FROM_DATE'].": ".DateLib::mysqlToString($date_from);
			echo " | ";
			echo LangUtil::$generalTerms['TO_DATE'].": ".DateLib::mysqlToString($date_to)."<br>";
	}
	echo "<br>";
}

function getWeeklyStats( $lab_config, $test_type_id, $date_from, $date_to, $test_name = null ) {
			global $xAxisGraph;
			global $progressGraphData;
			
			if ( $test_name != null) {
				
			}
			$stats = StatsLib::getDiscreteInfectionStatsWeekly($lab_config, $test_type_id, $date_from, $date_to);
			foreach($stats as $key => $value) {
				$xAxisGraph[] = date('Y,  n,  j',$key);
				if( $value[0] != 0) {
					$progressData[] = round(($value[1]/$value[0])*100,2);
				}	
				else {
					$progressData[] = 0;
				}
			}
			$progressGraphData[] = $progressData;
}

if( count($lab_config_id_array) == 1 ) {
	if ( $test_type_id == 0 )
		$lab_config_id = $lab_config_id_array;
	$multipleIndividualLabs = false;
}	
else {
	$multipleIndividualLabs = true;
}

if ( !$multipleIndividualLabs ) {

	if ( $lab_config_id == 0 && $test_type_id != 0 ) {
		$labArray = explode(":",$test_type_id);
		$lab_config_id = $labArray[0];
		$testArray = explode(";",$labArray[1]);
		$test_type_id = $testArray[0];
	}

	switch ($reportType) {
		case 'Prevalence':
			$stat_list = array();
			$stat_list = StatsLib::getDiscreteInfectionStatsAggregate($lab_config_id, $date_from, $date_to, $test_type_id);
			if(count($stat_list) == 0) {
				?>
				<div class='sidetip_nopos'>
				<?php echo LangUtil::$pageTerms['TIPS_NODISCRETE']; ?>
				</div>
				<?php
				include("includes/footer.php"); 
				return;
			}
			publishDates( $date_from, $date_to);
			?>
			<div id='stat_table'>
				<?php 
					if( $lab_config_id != 0 ) {
						$lab_config = LabConfig::getById($lab_config_id);
						$labName = $lab_config->name;
						echo $labName."<br>";
						$page_elems->getInfectionStatsTable($stat_list, $lab_config_id);
					}
					else
						$page_elems->getInfectionStatsTableAggregate($stat_list); 
				?>
			</div>
			<?php
			break;
		case 'turnaroundTime':
			view_testwise_weekly();
			break;
		case 'infectionReport': 
			break;
	}
}
else {
	if ( $reportType == "Prevalence" ) {
	
		publishDates( $date_from, $date_to );
		$stat_list = array();
		$retval = array();
		$existing_stat_list = array();
		$testName = null;
		
		for($i=0; $i < count($lab_config_id_array); $i++) {
		
			$labIdTestTypeIdSeparated = explode(":",$lab_config_id_array[$i]);
			$lab_config_id = $labIdTestTypeIdSeparated[0];
			$test_type_id = $labIdTestTypeIdSeparated[1];
			
			$retval = StatsLib::getDiscreteInfectionStatsAggregate($lab_config_id, $date_from, $date_to, $test_type_id);
			$existing_stat_list = $stat_list;
			$stat_list = array_merge($existing_stat_list, $retval);
			
			$lab_config = LabConfig::getById($lab_config_id);
			$labName = $lab_config->name;
			$labNamesArray[] = $labName;
			
			getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);
			
			if ( !$testName ) {
				$saved_db = DbUtil::switchToLabConfig($lab_config_id);
				$testName = get_test_name_by_id($test_type_id);
				DbUtil::switchRestore($saved_db);		
			}
			
			if(count($stat_list) == 0) {
				?>
				<div class='sidetip_nopos'>
				<?php echo LangUtil::$pageTerms['TIPS_NODISCRETE']; ?>
				</div>
				<?php
				include("includes/footer.php"); 
				return;
			}
		}
		echo LangUtil::$generalTerms['TEST_TYPE'].": ".$testName."<br>";
		echo "<div id='stat_table'>";
		$page_elems->getInfectionStatsTableAggregate($stat_list, $lab_config_id , $multipleIndividualLabs);
		echo "</div>";
		
		createGraph();
		createTrends();
	}
}

function createGraph() {

				global $stat_list;
				echo "<div id='stat_graph_bar'>";
				# To avoid cluttered graph, divide stat_list into chunks
				$chunk_size = 999;
				$stat_chunks = array_chunk($stat_list, $chunk_size, true);
				$i = 1;
				foreach($stat_chunks as $stat_chunk)
				{
					$div_id = "placeholder_".$i;
					$legend_id = "legend_".$i;
					$ylabel_id = "ylabel_".$i;
					$width_px = count($stat_chunk)*95;
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
								$labName = $labNamesArray[$count-1];
								$tick_array .= "[$index_count+0.4, '$labName']";
								?>
								{
									data: d<?php echo $count; ?>,
									bars: { show: true, barWidth: 1 }//,
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
			echo "</div>";
}

function createTrends() { 
	global $labNamesArray;
	global $xAxisGraph;
	global $progressGraphData;
?>
	<div id="trendsDiv" style="width: 800px; height: 400px; margin: 0 auto"></div>
	<script type="text/javascript">
		function viewTrends() {
			var x = <?php echo json_encode($labNamesArray); ?>;
			var y = <?php echo json_encode($xAxisGraph); ?>;
			var z = <?php echo json_encode($progressGraphData); ?>;
			$('#stat_graph').hide();
			$('#stat_graph_bar').hide();
			$('#viewGraphSpan').show();
			$('#hideGraphSpan').hide();
			$('#viewTrendSpan').hide();
			$('#hideTrendSpan').show();
			createChart(x, y, z);
		}
	
		function createChart(labNamesArray, xAxisGraph, progressGraphData) {

			var chart;
			var options = {
			chart: {
				 renderTo: 'trendsDiv',
				 type: 'spline'
			  },
			  title: {
				 text: 'Prevalence Rate'
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
	   
			for(var i=0;i<labNamesArray.length;i++) {
				options.series.push({
					name: labNamesArray[i],
					data: progressGraphData[i]
				});
			}
		   chart = new Highcharts.Chart(options);
		}
		
	</script>
<?php } ?>