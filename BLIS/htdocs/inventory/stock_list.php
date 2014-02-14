<?php
#
# Adds a new test type to catalog in DB
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
include("lang/lang_xml2php.php");
LangUtil::setPageId("stocks");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
putUILog('stock_list', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?>

<script type='text/javascript'>
	$(document).ready(function(){
			$('#current_inventory').tablesorter();
	});

</script>

<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a> &nbsp;|&nbsp;<b> <?php echo LangUtil::$pageTerms['Current_Inventory']; ?></b>

<?php echo Inventory::getReagentName($r_id);?>

<table class='tablesorter' id='current_inventory'  style='width:500px'>
	<thead>
		<tr>
			<th> <?php echo LangUtil::$pageTerms['Lot Number']; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Quantity']; ?></th>
                        <th><?php echo "Unit"; ?></th>
                        <th> <?php echo LangUtil::$pageTerms['Expiry_Date']." (mm/dd/yyyy)"; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Manufacturer']; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Supplier']; ?></th>
                        <th> <?php echo LangUtil::$pageTerms['Date Received']; ?></th>
                        <th> <?php echo LangUtil::$pageTerms['Remarks']; ?></th>
                        <th><?php echo "Update"; ?></th>
                       
		</tr>
	</thead>
<?php
    
    $r_id = $_REQUEST['id'];
    $lid = $_SESSION['$lab_config_id'];
    $stocks_list = Inventory::getStocksList($lid, $r_id);
    foreach($stocks_list as $stock) {
?>  <tbody>
		<tr>
			<td><?php echo $stock['lot'];?></td>
			<td><?php 
                        
                        ?></td>
			<td><?php 
                        $uni = $reagent['unit'];
                            if($uni == '')
                                echo "units";
                            else 
                                echo $uni;
                            ?></td>
                        <?php if($view_use == 1){ ?>
                        <td><?php 
                            echo "<a href='use_stock.php?id=".$reagent['id']."'> Update Stock</a>";
                           
                            ?></td>
                        <?php } ?>
                        
		</tr>
<?php 
	} 
?>
	</tbody>
</table>


<?php
include("includes/footer.php");
?>
