<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu, Amol Shintre and Naomi Chopra
# Admin Stock Management Page to add new stock
# Sends POST request to stock_details.php 
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
$selected_id = $_REQUEST['id'];
$selected_lot = $_REQUEST['lot'];
putUILog('use_stock', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?> 
<script type='text/javascript'>
$(document).ready(function() {
//$("#changeText").click(function() {
    $('#quant_u_error').hide();
    $('#quant_e_error').hide();
val = $('select').val();
    var url_string = "../inventory/get_reagent_unit.php?lid="+"<?php echo $lid?>"+"&id="+"<?php echo $selected_id; ?>";
	$.ajax({ 
		url: url_string, 
		success: function(result){
                            $("#unit_div").html(result);

		}
	});
//});
     var url_string = "../inventory/get_reagent_quantity.php?lid="+"<?php echo $lid; ?>"+"&id="+"<?php echo $selected_id; ?>"+"&lot="+"<?php echo $_REQUEST['lot']; ?>";
	$.ajax({ 
		url: url_string, 
		success: function(result){
			//$('#specimenboxes').append(msg);
                            $("#quant_div").html(result);

		}
	});

});
function add_specimenbox(){
	var num= parseInt(document.getElementById('count').value);
	
	var new_num=num+1;
	$('#count').attr("value",new_num);
	
	var url_string = "inventory/add_new_stock.php?num="+new_num;
	$.ajax({ 
		url: url_string, 
		success: function(msg){
			$('#specimenboxes').append(msg);
			
		}
	});
}

function validateRow() {

	if($('#quant_u').attr("value") == "")
	{
		$('#quant_u_error').show();
                $('#quant_e_error').hide();
		return;
	}
	else
	{
		$('#quant_u_error').hide();
                $('#quant_e_error').hide();
	}   
        var ent = $('#quant_u').attr("value");
        var qua = $('#quant_div').html();
        if(parseFloat(ent) > parseFloat(qua) || parseFloat(ent) == 0)
	{
		$('#quant_e_error').show();
		return;
	}
	else
	{
		$('#quant_e_error').hide();
	}   
	$('#new_test_form').submit();
}

function display_unit()
{
    var url_string = "../inventory/get_reagent_unit.php?lid="+"<?php echo $lid;?>"+"&id="+"<?php echo $selected_id; ?>";
	$.ajax({ 
		url: url_string, 
		success: function(result){
			//$('#specimenboxes').append(msg);
                            $("#unit_div").html(result);

		}
	});
        
        
}
</script>
<a href='stock_lots.php?id=<?php echo $_REQUEST['id']; ?>'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>&nbsp;|&nbsp;<b><?php echo "Log Stock Usage"; ?></b>
<br><br>

<?php
$tips_string = "Log stock usage (quantity signed out) by completing this form. Available qunatity for the selected lot is displayed. Quantity signed out should be less than or equal to the available quantity.";
$page_elems->getSideTip("Tips", $tips_string);

?>

<form name='new_test_form' id='new_test_form' action='inventory/stock_use.php' method='post'>
		
		<input type='hidden' name='count' value='1' id='count' />
		<div class="pretty_box" style="width:550px;">
			<table>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Reagent']; ?> 
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
                                            <?php
                                            /*$reagents_list = Inventory::getAllReagents($lid);
                                            echo "<select id='reagent' name='reagent'  style='width: 205px' onchange='javascript:display_unit()'>";
                                            foreach($reagents_list as $reagent)
                                            {
                                                $r_id = $reagent['id'];
                                                $r_name = $reagent['name'];
                                                if($r_id != $selected_id)
                                                    echo "<option value='$r_id'>$r_name</option>";
                                                else
                                                     echo "<option value='$r_id' selected='selected'>$r_name</option>";
                                            }
                                            echo "</select>";*/
                                            $reag = Inventory::getReagentById($lid, $selected_id);
                                            echo $reag['name'];
                                            ?>
                                            <input type="hidden" name="reagent" id="reagent" value="<?php echo $selected_id; ?>"/>
					</td>
				</tr>
                                <tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Units']; ?>
					</td>
					<td></td>
					<td>
						<div id="unit_div"></div>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Lot_Number']; ?>
					</td>
					<td></td>
					<td>
                                            <div id="lot_div"><?php echo $lot ?></div>
						<input type="hidden" name="lot" id="lot" value="<?php echo $selected_lot; ?>"/>
					</td>
				</tr>
                                <tr>
					<td>
						&nbsp;<?php echo "Available Quantity"; ?>
					</td>
					<td></td>
					<td>
						<div id="quant_div"></div>
					</td>
				</tr>
                                <tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Quantity_Signed_Out']; ?><?php $page_elems->getAsterisk(); ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="quant_u" id="quant_u" class='uniform_width'/>
                                                <label class="error" for="quant_u" id="quant_u_error"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
                                                <label class="error" for="quant_u" id="quant_e_error"><small><font color="red"><?php echo "Exceeds available quantity"; ?></font></small></label>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo "Date of Usage"; ?><?php $page_elems->getAsterisk(); ?> 
						
					</td>
					<td></td>
					<td>
						<!--<input type="date" name="txtRow13" id="txtRow13" class='uniform_width'/>-->
						<?php
                                                $name_list1 = array("yyyy_u", "mm_u", "dd_u");
                                                $id_list1 = $name_list1;
                                                echo $page_elems->getDatePicker($name_list1, $id_list1, $value_list1); ?>
					</td>
				</tr>
				
				
                                <tr>
					<td>
						&nbsp;<?php echo "Remarks"; ?> 
						
					</td>
					<td></td>
					<td>
                                              <textarea name="remarks" id="remarks" rows="3" cols="22"></textarea>
					</td>
				</tr>
			</table>
		</div>
	<br>
		&nbsp;&nbsp;&nbsp;&nbsp;
	<br>
	<br>
		<input name='stock_manage' id='stock_manage' type='button' onclick='javascript:validateRow();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' />
			&nbsp;&nbsp;&nbsp;&nbsp;
		<a href='stock_lots.php?id=<?php echo $_REQUEST['id']; ?>'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
		<input type='hidden' name='file' value='1' id='file' />
</form>

<?php include("includes/footer.php"); ?>