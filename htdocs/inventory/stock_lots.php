<?php
#
# Adds a new test type to catalog in DB
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
include("lang/lang_xml2php.php");
include("barcode/barcode_lib.php");
LangUtil::setPageId("stocks");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
 $r_id = $_REQUEST['id'];
    $lid = $_SESSION['$lab_config_id'];
    $reag = Inventory::getReagentById($lid, $r_id);
    $view_use = 1;
    putUILog('stock_lots', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
$barcode_seperator = '$';

$code_type = "code39";
$bar_width = 2;
$bar_height = 40;
$font_size = 11;

    ?>

<script type='text/javascript'>
	$(document).ready(function(){
			$('#current_inventory').tablesorter();
	});

 
 function getBarcode(code)
{
    
    if(code == '')
        {
             alert('cannot be empty');
                return;
        }
    var count = parseInt($('#count').html()); 
    count = count + 1;
    $('#count').html(count);  
    var div = "bar"+count;
    generateBarcode(div, code);
}

function generateBarcode(div, code)
{
    var content = "<br><br><div id='"+div+"'></div>";
    $('#barcodeList').html(content);
        $("#"+div).barcode(code, '<?php echo $code_type; ?>',{barWidth:<?php echo $bar_width; ?>, barHeight:<?php echo $bar_height; ?>, fontSize:<?php echo $font_size; ?>, output:'css'});

}




    function PrintElem(elem, code)
    {
        
        Popup($(elem).html(), code);
    }

    function Popup(data, code) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Barcodes</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();
        //mywindow.document.show
        return true;
    }

function get_barcode(code)
{
     if(code == '')
        {
             alert('cannot be empty');
                return;
        }
    var count = parseInt($('#count').html()); 
    count = count + 1;
    $('#count').html(count);  
    var div = "bar"+count;
    var content = "<br><br><div id='"+div+"'></div>";
    $('#barcodeList').html(content);
        $("#"+div).barcode(code, '<?php echo $code_type; ?>',{barWidth:<?php echo $bar_width; ?>, barHeight:<?php echo $bar_height; ?>, fontSize:<?php echo $font_size; ?>, output:'css'});
    var data = $('#barcodeList').html();
    var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Barcodes</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();    
}

</script>
<div id="count" style='display:none;'>0</div>
<p style="text-align: right;"><a rel='facebox' href='#view_stocks_help'>Page Help</a></p>

<a href='view_stock.php'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a> &nbsp;|&nbsp;<b> <?php echo LangUtil::$pageTerms['Current_Inventory']; ?></b>

<?php echo "<br><br>Item Name: <b>".$reag['name']."</b>";?>
 
<table class='tablesorter' id='current_inventory'  style='width:700px'>
	<thead>
		<tr>
			<th> <?php echo LangUtil::$pageTerms['Lot_Number']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Quantity']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th><?php echo "Unit"."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th> <?php echo LangUtil::$pageTerms['Expiry_Date']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Manufacturer']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Supplier']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th> <?php echo "Date of Reception"."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th> <?php echo LangUtil::$pageTerms['Remarks']."&nbsp;&nbsp;&nbsp;&nbsp;" ?></th>
                        <th><?php echo "Update"."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th><?php echo "Action"."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                       
		</tr>
	</thead>
<?php
    
   
    $stocks_list = Inventory::getStocksList($lid, $r_id);
    foreach($stocks_list as $stock) {
?>  <tbody>
		<tr align='center'>
			<td><?php echo $stock['lot']; ?></td>
			<td><?php echo Inventory::getLotQuantity($lid, $r_id, $stock['lot']); ?></td>
			<td><?php 
                        $uni = $reag['unit'];
                            if($uni == '')
                                echo "units";
                            else 
                                echo $uni;
                            ?>
                        </td>
                        <td><?php $dp = explode("-", $stock['expiry_date']);
                            $e_date = $dp[2]."/".$dp[1]."/".$dp[0];
                            echo $e_date;
                        ?></td>
                        <td><?php echo $stock['manufacturer']; ?></td>
                        <td><?php echo $stock['supplier']; ?></td>
                        <td><?php $dp = explode("-", $stock['date_of_reception']);
                            $e_date = $dp[2]."/".$dp[1]."/".$dp[0];
                            echo $e_date; ?></td>
                        <td><?php echo $stock['remarks']; ?></td>
                        <?php if($view_use == 1){ ?>
                        <td><?php 
                            echo "<a href='use_stock.php?id=".$reag['id']."&lot=".$stock['lot']."'> Update Stock</a>";
                           
                            ?></td>
                        <?php } ?>
                        <td><?php 
                            $gencode = $reag['id'].$barcode_seperator.$reag['name'].$barcode_seperator.$stock['lot'];
                            ?>
                            <a href='#' onclick="get_barcode('<?php echo $gencode; ?>')"> Print Barcode</a>
                                <?php
                            //echo "<a target='_blank' href='print_barcode.php?gencode=".$gencode."'> Print Barcode</a>";
                            ?></td>
                        
		</tr>
<?php 
	} 
?>
	</tbody>
</table>
<div id='view_stocks_help' class='right_pane' style='display:none;margin-left:10px;'>
<ul>	
        <?php

                
             echo "Stock lots for the selected Reagent are displayed. Click on 'Update Stock' to log stock usage for the specific lot.";



        ?>
</ul>
</div>

<div id ="barcodeList" style="display:none;">
    </div>

<?php
include("includes/footer.php");
?>
