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

<br>
<b>Inventory Report</b> 
| <a href='reports.php'>&laquo; Back To Reports</a>
<br><br>

<?php
	$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
	$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
	$name=$_REQUEST['reagent_name'];
	$date_from_js =str_replace("-", "/", $date_from);
	$date_to_js =str_replace("-", "/", $date_to);
	$all='ALL';
	if($name!=$all)
		$retval=get_current_inventory_byName($date_to,$date_from, $name);
	else
		$retval=get_current_inventory($date_to,$date_from);
	ksort($retval);
	$div_id = "placeholder";
	$ylabel_id = "ylabel";
	$legend_id = "legend";
	$count=0;
?>
<div id='stat_table'>
	<?php $page_elems->getInventory($retval); ?>
</div>
