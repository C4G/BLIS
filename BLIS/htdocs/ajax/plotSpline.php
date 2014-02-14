<?php

include("../includes/db_mysql_lib.php");
include("../includes/db_lib.php");
include("../includes/user_lib.php");
include("../includes/stats_lib.php");

$testName = $_REQUEST['testName'];
$labConfigIds = $_REQUEST['labConfigIds'];
$date_from = $_REQUEST['date_from'];
$date_to = $_REQUEST['date_to'];

$saved_db = DbUtil::switchToGlobal();
$query = "SELECT lab_id_test_id FROM test_mapping WHERE test_name like '$testName' LIMIT 1";
$resultset = query_associative_all($query, $row_count);
foreach($resultset as $record) {
	$labIdTestIds = explode(';',$record['lab_id_test_id']);
	foreach($labIdTestIds as $labIdTestId) {
		$labIdTestId = explode(':',$labIdTestId);
		$labId = $labIdTestId[0];
		$testId= $labIdTestId[1];
		$test_type_list[$labId] = $testId;
	}
}
DbUtil::switchRestore($saved_db);
?>

<script type="text/javascript" src="../js/highcharts.js"></script>

<?php
	
function getWeeklyStats( $lab_config, $test_type_id, $date_from, $date_to ) {
	global $xAxisGraph;
	global $progressTrendsData;

	$stats = StatsLib::getDiscreteInfectionStatsWeekly($lab_config, $test_type_id, $date_from, $date_to);
	foreach($stats as $key => $value) {
		$formattedDate = bcmul($key,1000);
		if( $value[0] != 0)
			$progressData[] = array($formattedDate,100-round(($value[1]/$value[0])*100,2));
		else
			$progressData[] = array($formattedDate,0);
	}
	$progressTrendsData[] = $progressData;
}

if( $labConfigIds == 0 ) {
	$site_list = get_site_list($_SESSION['user_id']);
}
else {
	$labIds = explode(",",$labConfigIds);
	foreach($labIds as $labId) 
		$site_list[$labId] = $labId;
}
		
foreach($site_list as $key=>$value) {
	$lab_config = LabConfig::getById($key);
	$namesArray[] = $lab_config->name;
	$test_type_id = $test_type_list[$key];
	getWeeklyStats($lab_config, $test_type_id, $date_from, $date_to);
}

createTrends();
?>

<?php
function createTrends() { 
	global $namesArray;
	global $progressTrendsData;
	
?>

	<script type="text/javascript">
		viewTrends();
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
	   
			for(var i=0;i<namesArray.length;i++) {
				options.series.push({
					name: namesArray[i],
					data: progressData[i]
				});
			}
		   chart = new Highcharts.Chart(options);
		}
		
	</script>
<?php } ?>