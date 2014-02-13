<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu, Amol Shintre and Naomi Chopra
# Admin Stock Management Page to add new stock
# Sneds POST request to stock_details.php 
#

include("../users/accesslist.php");
/*if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) 
     && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	 && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) ) {
		header( 'Location: home.php' );
}*/

include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
LangUtil::setPageId("stocks");
$script_elems->enableTableSorter();
$script_elems->enableDatePicker();
$lid = $_SESSION['lab_config_id'];
$r_id = $_REQUEST['id'];
$view_use = 1;
putUILog('edit_stock', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?> 
<script type='text/javascript'>
$(document).ready(function(){
	
	$('#reagent').keydown(function() {
		prefetch_pname();
	});
        
        $('#reagent_error').hide();
        $('#reagent_u_error').hide();
	
});
function add_specimenbox(){	
	
	var url_string = "inventory/add_reagent.php";
	$.ajax({ 
		url: url_string
            });
}

function validateForm() {
var gcheck = 1;
var name = $('#reagent').attr("value");
var oname = $('#o_reagent').attr("value");
        name = name.replace(" ", "%20");
         oname = oname.replace(" ", "%20");
        var url_string = "inventory/check_reagent.php?name="+name+"&lid="+"<?php echo $_SESSION['lab_config_id']; ?>";
	$.ajax({ 
		url: url_string, 
                async : false,
		success: function(check){
                     if(check == '1' && name != oname)
                        {
                                $('#reagent_u_error').show();
                                gcheck = 0;
                        }
                        else
                        {
                                $('#reagent_u_error').hide();
                        }
               }
	});
        if($('#reagent').attr("value") == "")
	{
		$('#reagent_error').show();
		return;
	}
	else
	{
		$('#reagent_error').hide();
	}
        if(gcheck == 1)
	$('#new_test_form').submit();
}

function prefetch_pname()
{
	var name = $('#reagent').attr("value");
	name = name.replace(" ", "%20");
	if(name == "" || name.length < 1)
	{
		$('#patient_prompt_div').html("");
		return;
	}
	//var url_string = "inventory/reagent_prompt_match.php?q="+name;
	//$('#patient_prompt_div').load(url_string);
}
</script>
<a href='view_stock.php'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>&nbsp;|&nbsp;<b><?php echo "Edit Item"; ?></b>
<br><br>

<?php
$tips_string = " Edit item details by completing this form. If you wish to edit lot details for the selected item then click on 'Edit' link next to the specific lot.";
$page_elems->getSideTip("Tips", $tips_string);
$reag = Inventory::getReagentById($lid, $r_id);
?>

<form name='new_test_form' id='new_test_form' action='inventory/update_reagent.php'  method='post'>
    <div class="pretty_box" style="width:450px;">
			<table>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Reagent']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
						<input type="text" name="reagent" id="reagent" class='uniform_width' value="<?php echo $reag['name']; ?>"/>
                                                <input type="hidden" name="r_id" id="r_id" value="<?php echo $r_id; ?>"/>
                                                <input type="hidden" name="lid" id="lid" value="<?php echo $lid; ?>"/>
                                                <input type="hidden" name="o_reagent" id="o_reagent" value="<?php echo $reag['name']; ?>"/>
                                                <label class="error" for="reagent" id="reagent_u_error"><small><font color="red"><?php echo "Item already exists"; ?></font></small></label>
                                                <label class="error" for="reagent" id="reagent_error"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
					</td>
                                        
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo "Unit"; ?> 
					</td>
					<td></td>
					<td>
						<input type="text" name="unit" id="unit" class='uniform_width' value="<?php echo $reag['unit']; ?>"/>
					</td>
                                     
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo "Remarks"; ?> 
						
					</td>
					<td></td>
					<td>
                                              <textarea name="remarks" id="remarks" rows="3" cols="22" ><?php echo $reag['remarks']; ?></textarea>
					</td>
				</tr>
				
			</table>
		</div>
	</div>
		&nbsp;&nbsp;&nbsp;&nbsp;
	<br>
	<br>
		<input name='stock_manage' id='stock_manage' type='button' onclick='javascript:validateForm();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' />
			&nbsp;&nbsp;&nbsp;&nbsp;
		<a href='view_stock.php'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
</form>
<br><br>

<table class='tablesorter' id='current_inventory'  style='width:700px'>
	<thead>
		<tr align='center'>
			<th> <?php echo LangUtil::$pageTerms['Lot_Number']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Quantity']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th><?php echo "Unit"."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th> <?php echo LangUtil::$pageTerms['Expiry_Date']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Manufacturer']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Supplier']."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th> <?php echo "Date of Reception"."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                        <th> <?php echo LangUtil::$pageTerms['Remarks']."&nbsp;&nbsp;&nbsp;&nbsp;" ?></th>
                        <th><?php echo "Edit"."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></th>
                       
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
                            echo "<a href='edit_lot.php?id=".$reag['id']."&lot=".$stock['lot']."'> Edit</a>";
                           
                            ?></td>
                        <?php } ?>
                        
		</tr>
<?php 
	} 
?>
	</tbody>
</table>


<div id='patient_prompt_div2'>
	
	</div>
<?php include("includes/footer.php"); ?>
