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
$sel_id = $_REQUEST['id'];
putUILog('inv_new_stock', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?> 
<script type='text/javascript'>
$(document).ready(function() {
            $('#lot_error').hide();
            $('#lot_u_error').hide();
            $('#quant_error').hide();

//$("#changeText").click(function() {
    var url_string = "../inventory/get_reagent_unit.php?lid="+"<?php echo $lid; ?>"+"&id="+"<?php echo $sel_id; ?>";
	$.ajax({ 
		url: url_string, 
		success: function(result){
			//$('#specimenboxes').append(msg);
                            $("#unit_div").html(result);

		}
	});
//});
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

        var gcheck = 1;
        var name = $('#lot').attr("value");
        name = name.replace(" ", "%20");
        vall = $('select').val();
        var url_string = "inventory/check_lot.php?lot="+name+"&lid="+"<?php echo $_SESSION['lab_config_id']; ?>"+"&id="+vall;
	$.ajax({ 
		url: url_string, 
                async : false,
		success: function(check){
                     if(check == '1')
                        {
                                //$('#lot_u_error').show();
                                //gcheck = 0;
                        }
                        else
                        {
                                $('#lot_u_error').hide();
                        }
               }
	});
	if($('#lot').attr("value") == "")
	{
		$('#lot_error').show();
		return;
	}
	else
	{
		$('#lot_error').hide();
	}   
        if($('#quant').attr("value") == "")
	{
		$('#quant_error').show();
		return;
	}
	else
	{
		$('#quant_error').hide();
	}   
        if(gcheck == 1)
	$('#new_test_form').submit();
}

function display_unit()
{
    val = $('select').val();
    var url_string = "../inventory/get_reagent_unit.php?lid="+"<?php echo $lid?>"+"&id="+val;
	$.ajax({ 
		url: url_string, 
		success: function(result){
                            $("#unit_div").html(result);

		}
	});
}
</script>
<a href='view_stock.php'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>&nbsp;|&nbsp;<b><?php echo LangUtil::$pageTerms['Add_Stock']; ?></b>
<br><br>

<?php
$tips_string = "Add new stocks (lots) for existing items by completing this form. Lot number, Expiry Date, Quantity and Date of Reception are compulsory fields.";
$page_elems->getSideTip("Tips", $tips_string);
?>

<form name='new_test_form' id='new_test_form' action='inventory/add_new_stock.php' method='post'>
		
		<input type='hidden' name='count' value='1' id='count' />
		<div class="pretty_box" style="width:500px;">
			<table>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Reagent']; ?>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
                                            <?php
                                            $reagents_list = Inventory::getAllReagents($lid);
                                            //echo "<pre>";
                                            //print_r($reagents_list);
                                            //echo "</pre>";
                                            $unittt = "hi";
                                            echo "<select id='reagent' name='reagent'  style='width: 205px' onchange='javascript:display_unit()'>";
                                            foreach($reagents_list as $reagent)
                                            {
                                                $r_id = $reagent['id'];
                                                $r_name = $reagent['name'];
                                                if($r_id != $sel_id)
                                                    echo "<option value='$r_id'>$r_name</option>";
                                                else
                                                     echo "<option value='$r_id' selected='selected'>$r_name</option>";
                                            }
                                            echo "</select>";
                                            ?>
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
						&nbsp;<?php echo LangUtil::$pageTerms['Lot_Number']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td></td>
					<td>
						<input type="text" name="lot" id="lot" class='uniform_width'/>
                                                <label class="error" for="lot" id="lot_error"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
                                                <label class="error" for="lot" id="lot_u_error"><small><font color="red"><?php echo "Lot number exists"; ?></font></small></label>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Expiry_Date']; ?><?php $page_elems->getAsterisk(); ?> 
						
					</td>
					<td></td>
					<td>
						<!--<input type="date" name="txtRow13" id="txtRow13" class='uniform_width'/>-->
						<?php
                                                $name_list1 = array("yyyy_e", "mm_e", "dd_e");
                                                $id_list1 = $name_list1;
                                                echo $page_elems->getDatePicker($name_list1, $id_list1, $value_list1); ?>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Manufacturer']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="manu" id="txtRow14" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Supplier']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="sup" id="txtRow15" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Quantity_Supplied']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td></td>
					<td>
						<input type="text" name="quant" id="quant" class='uniform_width'/>
                                                <label class="error" for="quant" id="quant_error"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
					</td>
				</tr>
				
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Cost_per_Unit']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="cost" id="txtRow18" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						<label for='<?php echo $curr_form_id; ?>_date_1'>
							&nbsp;<?php echo LangUtil::$pageTerms['Date_received']; ?><?php $page_elems->getAsterisk(); ?> 
						</label>
					</td>
					<td></td>
					<td>
							<?php
                                                         $name_list2 = array("yyyy_r", "mm_r", "dd_r");
                                                         $id_list2 = $name_list2;
                                                        echo $page_elems->getDatePicker($name_list2, $id_list2, $value_list2); ?>
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
		<a href='view_stock.php'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
		<input type='hidden' name='file' value='1' id='file' />
</form>




<?php include("includes/footer.php"); ?>