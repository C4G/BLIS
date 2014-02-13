<?php
#
# Main page for creating weekly TAT progression charts
# Called via Ajax from reports_tat.php
#

include("../includes/user_lib.php");
include("../includes/db_lib.php");
include("../includes/stats_lib.php");
include("../includes/page_elems.php");

LangUtil::setPageId("reports");

$page_elems = new PageElems();

$date_from = $_REQUEST['df'];
$date_to = $_REQUEST['dt'];
$date_from_js = date("Y, n, j",strtotime($date_from));
$date_to_js = date("Y, n, j",strtotime($date_to));
//$date_to_js = str_replace("-", "/", $date_to);
$include_pending = false;
$labNamesArray = array();

if($_REQUEST['p'] == 1)
	$include_pending = true;

$test_type_id = $_REQUEST['tt'];
$testTypeId = $test_type_id;
$lab_config_id = $_REQUEST['l'];

if( strstr($lab_config_id,",") )
	$lab_config_ids = explode(",",$lab_config_id);
else if ( $lab_config_id != 0 )
	$lab_config_ids[] = $lab_config_id;

$stat_list = array();
	
/* All Tests & All Labs */ 
if ( $test_type_id == 0 && $lab_config_id == 0 ) { 
	$site_list = get_site_list($_SESSION['user_id']);

	foreach( $site_list as $key => $value) {
		$lab_config = get_lab_config_by_id($key);
		$labName = $lab_config->name;
		$namesArray[] = $labName;
		$stat_list = StatsLib::getTatDailyProgressionStats($lab_config, $test_type_id, $date_from, $date_to, $include_pending);
		ksort($stat_list);
		$stat_lists[] = $stat_list;
		unset($stat_list);
	}
}
/* All Tests for Single Lab */
else if ( $test_type_id == 0 && count($lab_config_ids) == 1 ) {
	$lab_config = get_lab_config_by_id($lab_config_id);
	$labName = $lab_config->name;
	$namesArray[] = $labName;
	$stat_list = StatsLib::getTatDailyProgressionStats($lab_config, $test_type_id, $date_from, $date_to, $include_pending);
	ksort($stat_list);
	$stat_lists[] = $stat_list;
}
/* All Tests for Multiple Labs */
else if ( $test_type_id == 0 && count($lab_config_ids) > 1 ) {
	foreach( $lab_config_ids as $key) {
		$lab_config = LabConfig::getById($key);
		$namesArray[] = $lab_config->name;
		$stat_list = StatsLib::getTatDailyProgressionStats($lab_config, $test_type_id, $date_from, $date_to, $include_pending);
		ksort($stat_list); 
		$stat_lists[] = $stat_list;
		unset($stat_list);
	}
}	
else {
	/* Build Array Map with Lab Id as Key and Test Id as corresponding Value, if using aggregation */
	$testIds = array();
	if( strstr($test_type_id,";") ) {
		$labIdTestIds = explode(";",$test_type_id);
		foreach( $labIdTestIds as $labIdTestId) {
				$labIdTestIdsSeparated = explode(":",$labIdTestId);
				$labId = $labIdTestIdsSeparated[0];
				$testId = $labIdTestIdsSeparated[1];
				$testIds[$labId] = $testId;
		}	
	}
	else {
			$testIds[$lab_config_id] = $test_type_id;
	}
	
	/* Single Test for All Labs */
	if ( $test_type_id != 0 && $lab_config_id == 0 ) {
		$site_list = get_site_list($_SESSION['user_id']);

		foreach( $site_list as $key => $value) {
			$lab_config = LabConfig::getById($key);
			$test_type_id = $testIds[$lab_config->id];
			$namesArray[] = $lab_config->name;
			$stat_list = StatsLib::getTatDailyProgressionStats($lab_config, $test_type_id, $date_from, $date_to, $include_pending);
			ksort($stat_list); 
			$stat_lists[] = $stat_list;
			unset($stat_list);
		}
	}
	/* Single Test for Single Lab */
	else if ( $test_type_id != 0 && count($lab_config_ids) == 1 ) {
		$lab_config = get_lab_config_by_id($lab_config_id);
		$test_type_id = $testIds[$lab_config->id];
		$labName = $lab_config->name;
		$namesArray[] = $labName;
		$stat_list = StatsLib::getTatDailyProgressionStats($lab_config, $test_type_id, $date_from, $date_to, $include_pending);
		ksort($stat_list);
		$stat_lists[] = $stat_list;
	}
	/* Single Test for Multiple Labs */
	else if ( $test_type_id != 0 && count($lab_config_ids) > 1 ) {
		
		foreach( $lab_config_ids as $key) {
				$lab_config = LabConfig::getById($key);
				$test_type_id = $testIds[$lab_config->id];
				$namesArray[] = $lab_config->name;
				$stat_list = StatsLib::getTatDailyProgressionStats($lab_config, $test_type_id, $date_from, $date_to, $include_pending);
				ksort($stat_list); 
				$stat_lists[] = $stat_list;
				unset($stat_list);
		}
	}
}

$progressData = array();
foreach($stat_lists as $stat_list) {
	foreach($stat_list as $key => $value) {
		$formattedValue = round($value[0],2);
		$formattedDate = bcmul($key,1000);
		$progressData[] = array($formattedDate,$formattedValue);
	}
	$progressTrendsData[] = $progressData;
	unset($progressData);
}
# Obtain stats as date_collected(millisec ts) => tat value

# Build chart with time series
$div_id = "tplaceholder_".$testTypeId;
$ylabel_id = "tylabel_".$testTypeId;
$legend_id = "tlegend_".$testTypeId;

?>
<div id="trendsDiv" style="width: 800px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript" src="js/highcharts.js"></script>
<script type='text/javascript'>
			var progressTrendsData = new Array();
			var namesArray = <?php echo json_encode($namesArray); ?>;
			var progressTrendsDataTemp = <?php echo json_encode($progressTrendsData); ?>;
			var dateStart = Date.UTC(<?php echo $date_from_js; ?>); 

			var values, value1, value2;
			/* Convert the string timestamps to floatvalue timestamps */
			for(var j=0;j<progressTrendsDataTemp.length;j++) {
				var i = 0;
				if( progressTrendsDataTemp[j][i]) {
					progressTrendsData[j] = new Array();
					while ( progressTrendsDataTemp[j][i] ) {
						values = progressTrendsDataTemp[j][i];
						value1 = parseFloat(values[0]);
						value2 = values[1];
						progressTrendsData[j][i] = [value1, value2];
						i++;
					}
				}
			}
			
			var chart;
			var options = {
			chart: {
				 renderTo: 'trendsDiv',
				 type: 'spline'
			  },
			  title: {
				 text: <?php echo "'".LangUtil::$pageTerms['MENU_TAT']."'"; ?>//'TurnAroundTime Rate'
			  },
			  xAxis: {
				 type: 'datetime',
				 dateTimeLabelFormats: { 
					month: '%e. %b',
					year: '%b'
				 },
			  },
			  yAxis: {
				 title: {
					text: 'TurnAround Time (Days)'
				 },
			  },
			  tooltip: {
				 formatter: function() {
						   return '<b>'+ this.series.name +'</b><br/>' + Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' Days';
				 }
			  },
			  series: [{
				name: ' ',
				data: []
			  }]
		   };
	   
			
			for(var i=0;i<namesArray.length;i++) {

				options.series.push({
					name: namesArray[i],
					data: progressTrendsData[i]
					/*
					data: (function(progressTrendsDataTemp) {
						var data = [];
					
						for(var i=0;i<progressTrendsDataTemp[i].length;i++) {
							var values = new String(progressTrendsDataTemp[0][i]);
							var value = values.split(",");
							data.push({
								x: value[0],
								y: value[1]
							});
						}
						return data;
					})()
					*/
				});
			}
			
		   chart = new Highcharts.Chart(options);

</script>
<?php

if($testTypeId != 0) {
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
		$table_id = 'exceededtable_'.$testTypeId;
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
		</script><br>
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
	if($is_pending === false) {
		?>
		<center>
		<div class='sidetip_nopos' style='width:300px;'>
		<?php echo LangUtil::$pageTerms['TIPS_TATNOPENDING']; ?>
		</div>
		</center>
		<?php
	}
	else {
		$saved_db = DbUtil::switchToLabConfig($lab_config->id);
		$table_id = 'pendingtable_'.$testTypeId;
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