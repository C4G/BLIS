<?php
#
# Adds a new test type to catalog in DB
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/user_lib.php");
include("includes/page_elems.php");
include("includes/script_elems.php");
include("includes/stats_lib.php");
include("lang/lang_xml2php.php");
include("users/accesslist.php");

LangUtil::setPageId("stocks");
$script_elems = new ScriptElems();
$page_elems = new PageElems();

$view_update = 1;
$view_add = 1;
$view_edit = 0;
putUILog('view_stocks', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

if(is_admin(get_user_by_id($_SESSION['user_id']))) {
            $view_edit = 1;
            //header( 'Location: home.php' );
}

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
   
    $lid = $_SESSION['$lab_config_id'];
?>

<script type='text/javascript'>
	$(document).ready(function(){
			$('#current_inventory').tablesorter();
	});

</script>
<!--<p style="text-align: right;"><a rel='facebox' href='#view_stocks_help'>Page Help</a></p>-->
<a href='inv_new_reagent.php'> <?php echo "Add Item" ; ?></a> &nbsp;|&nbsp;<b> <?php echo LangUtil::$pageTerms['Current_Inventory']; ?></b>
<table class='tablesorter' id='current_inventory'  style='width:600px'>
	<thead>
		<tr align='center'>
			<th> <?php echo LangUtil::$pageTerms['Reagent']; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Quantity']; ?></th>
                        <th><?php echo "Unit"; ?></th>
                        <?php if($view_update == 1){ ?>
                        <th><?php 
                            echo "Update";
                            ?></th>
                        <?php } ?>
                        <?php if($view_add == 1){ ?>
                        <th><?php 
                            echo "Add";
                            ?></th>
                        <?php } ?>
                        <?php if($view_edit == 1){ ?>
                        <th><?php 
                            echo "Edit";
                            ?></th>
                        <?php } ?>
                       
		</tr>
	</thead>
<?php
    $reagents_list = array();
    $reagents_list = Inventory::getAllReagents($lid);
    foreach($reagents_list as $reagent) {
?>  <tbody>
		<tr align='center'>
			<td><?php echo $reagent['name'];?></td>
			<td><?php 
                        
                            $quant = Inventory::getQuantity($lid, $reagent['id']);
                            if($quant == '')
                                echo "0";
                            else 
                                echo $quant;
                        ?></td>
			<td><?php 
                        $uni = $reagent['unit'];
                            if($uni == '')
                                echo "units";
                            else 
                                echo $uni;
                            ?></td>
                        <?php if($view_update == 1){ ?>
                        <td><?php 
                            echo "<a href='stock_lots.php?id=".$reagent['id']."'> Log Stock Usage</a>";
                            ?></td>
                        <?php } ?>
                        <?php if($view_add == 1){ ?>
                        <td><?php 
                            echo "<a href='inv_new_stock.php?id=".$reagent['id']."'> Add Stock</a>";
                            ?></td>
                        <?php } ?>
                        <?php if($view_edit == 1){ ?>
                        <td><?php 
                            echo "<a href='edit_stock.php?id=".$reagent['id']."'> Edit Details</a>";
                            ?></td>
                        <?php } ?>
                        
		</tr>
<?php 
	} 
?>
	</tbody>
</table>
