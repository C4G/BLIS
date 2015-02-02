<?php
#

# Called via Ajax from reports_infection.php
#

include("../includes/db_lib.php");
include("../includes/stats_lib.php");
include("../includes/page_elems.php");
LangUtil::setPageId("reports");

$page_elems = new PageElems();
$test_type_id = $_REQUEST['tt'];
$date_from = $_REQUEST['df'];
$date_to = $_REQUEST['dt'];
$lab_config_id = $_REQUEST['l'];
$date_from_js = str_replace("-", "/", $date_from);
$date_to_js = str_replace("-", "/", $date_to);
$lab_config = get_lab_config_by_id($lab_config_id);
$gender=$_REQUEST['gender'];
$age_s=$_REQUEST['age_s'];
$age_e=$_REQUEST['age_e'];

$stat_list = StatsLib::getDiscreteInfectionStatsWeekly($lab_config,$test_type_id, $date_from, $date_to, $gender);
ksort($stat_list);

# Build chart with time series
$div_id = "placeholder_".$test_type_id;
$ylabel_id = "ylabel_".$test_type_id;
$legend_id = "legend_".$test_type_id;
?>


<script id="source" language="javascript" type="text/javascript"> 
$(function () {
<?php
		
		$count = 0;
		echo "var d = [];";
		foreach($stat_list as $key=>$value)
		{
			$x_val = $key;//check if the test id is returnr as  value or else x_value  key but shld be date
			$count_all = $value[0];
			$count_negative = $value[1];
			$infection_rate = 0;
			if($count_all != 0)
				$infection_rate = round((($count_all-$count_negative)/$count_all)*100, 2);
			
			echo "d.push([$x_val*1000, $infection_rate]);";
			$count++;
			//$x_val += 2;
		}
	
	?>
	});
 </script>
		<?php
		if($count!=0)
		{ ?>
	<center>
<?php
	echo get_test_name_by_id($test_type_id); 
?> - <?php echo LangUtil::$pageTerms['PROGRESSION_W']; ?>
</center>
<table>
	<tbody>
	<tr valign='top'>
		<td>
			<span id="<?php echo $ylabel_id; ?>" class='flipv_up' style="width:30px;height:30px;"><?php echo LangUtil::$generalTerms['MENU_INFECTIONSUMMARY']; ?> </span>
		</td>
		<td>
			<div id="<?php echo $div_id; ?>" style="width:800px;height:300px;"></div>
		</td>	
		<td>
			<div id="<?php echo $legend_id; ?>" style="width:200px;height:300px;"></div>
		</td>
	</tr>
	</tbody>
</table>
	<script id="source" language="javascript" type="text/javascript"> 
	
	 $(function (){
	 <?php
		echo "var d = [];";
		foreach($stat_list as $key=>$value)
		{
			$x_val = $key;//check if the test id is returnr as  value or else x_value  key but shld be date
			$count_all = $value[0];
			$count_negative = $value[1];
			$infection_rate = 0;
			if($count_all != 0)
				$infection_rate = round((($count_all-$count_negative)/$count_all)*100, 2);
			
			echo "d.push([$x_val*1000, $infection_rate]);";
			//$x_val += 2;
		}
	?>
		
$.plot($("#<?php echo $div_id; ?>"), [
		{
			data: d,
			<?php 
			if($count==1) 
			{
			?>
				points: { show: true, radius:5 }, 
			<?php
			}
			else
			{
			?>
			lines: { show: true },
			<?php
			}
			?>
			label: "<?php echo LangUtil::$pageTerms['MENU_INFECTIONSUMMARY']; ?>"
		}
		],
		{ 
			xaxis: {
				mode: "time",
				minTickSize: [7, "day"],
				timeformat: "%m-%y"//,
				//min: (new Date("<?php echo $date_from_js; ?>")).getTime()//,
                //max: (new Date("<?php echo $date_to_js; ?>")).getTime()
            },
			legend: {
				container: "#<?php echo $legend_id; ?>"
			}
		} 
	);
	$('#<?php echo $ylabel_id; ?>').flipv_up();
		
});
<?php
	}
	
	?>
</script>
