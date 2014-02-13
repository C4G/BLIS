<?php
#
# Shows infection summary report for a site/location
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
LangUtil::setPageId("stocks");
$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
?>
<script type='text/javascript'>
function view_graph()
{
$('#view_div').hide();
$('#ylabel').show();
$('#legend').show();
$('#placeholder').show();
$('#plotted').show();
}

function hide_graph()
{
$('#view_div').show();
$('#ylabel').hide();
$('#legend').hide();
$('#placeholder').hide();
$('#plotted').hide();
}
</script>
<br>
<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_i'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>|
<b>Stock Details </b>
<br><br>
<br><br>
<?php
$retval=get_stock_out_details();
ksort($retval);
$div_id = "placeholder";
$ylabel_id = "ylabel";
$legend_id = "legend";
$count=0;
?>
<div id='stat_table'>
	<?php $page_elems->getStockOutDetails($retval); ?>
</div>
<div id="view_div" name="view_div" >
<a href="javascript:view_graph" style="display:none">Show Graph </a>
</div>
<div id="plotted" name="plotted" style="display:none">
<a href="javascript:hide_graph();">Hide Graph</a>
</div>
<table>
	<tbody>
	<tr valign='top'>
		<td>
			<span id="<?php echo $ylabel_id; ?>" class='flipv_up' style="width:30px;height:30px;display:none"></span>
		</td>
		<td></td>
		<td>
			<div id="<?php echo $div_id; ?>" style="width:800px;height:300px; display:none"></div>
		</td>	
		<td>
			<div id="<?php echo $legend_id; ?>" style="width:200px;height:300px;display:none"></div>
		</td>
	</tr>
	</tbody>
</table>
<script id="source" language="javascript" type="text/javascript"> 
		 $(function (){
	 <?php
		echo "var d = [];";
		$retval1=array();
		foreach($retval as $value)
		{
		$date_parts=explode("-",$value[2]);
		$ts= mktime(0,0,0,$date_parts[1],$date_parts[2],$date_parts[0]);
			$x_val = $ts;
			$quant = $value[1];
			$retval1[$x_val]+=$value[1];
			$count++;
		}
		foreach($retval1 as $key=>$value)
			echo "d.push([$key*1000, $value]);";
	?>
	$.plot($("#<?php echo $div_id; ?>"),[
		{
			data: d,
			hoverable:true,
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
			bars: {
			show: true,
      lineWidth: "20",
      fill: true
     		},
			<?php
			}
			?>
			label: "Stock Level"
		},
		
		],
		{ 
			xaxis: {
				autoscaleMargin:.02,
				ticks:10,
				 mode: "time",
				timeformat: "%y/%m/%d"
				 },
			legend: {
				container: "#<?php echo $legend_id;?>"
			}
		} 
	);
});
</script>
