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
$lot = $_REQUEST['lot'];
putUILog('edit_lot', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?> 
<script type='text/javascript'>
$(document).ready(function(){
	
	$('#reagent').keydown(function() {
		prefetch_pname();
	});
        
        $('#n_lot_error').hide();
        $('#lot_u_error').hide();
	
});
function add_specimenbox(){	
	
	var url_string = "inventory/add_reagent.php";
	$.ajax({ 
		url: url_string
            });
}

function validateForm() {
        var gcheck = 1;
        var name = $('#n_lot').attr("value");
        var oname = $('#lot').attr("value");
        name = name.replace(" ", "%20");
        oname = oname.replace(" ", "%20");
        vall = $('select').val();
		//disable duplicate lot check
       /* var url_string = "inventory/check_lot.php?lot="+name+"&lid="+"<?php echo $_SESSION['lab_config_id']; ?>"+"&id="+"<?php echo $r_id; ?>";
	$.ajax({ 
		url: url_string, 
                async : false,
		success: function(check){
                     if(check == '1' && name != oname)
                        {
                                $('#lot_u_error').show();
                                gcheck = 0;
                        }
                        else
                        {
                                $('#lot_u_error').hide();
                        }
               }
	});*/
        
        if($('#n_lot').attr("value") == "")
	{
		$('#n_lot_error').show();
		return;
	}
	else
	{
		$('#n_lot_error').hide();
	} 
        if(gcheck == 1)
	$('#new_test_form').submit();
}

function validateForm2() {

             
	$('#new_test_form2').submit();
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
	var url_string = "inventory/reagent_prompt_match.php?q="+name;
	$('#patient_prompt_div').load(url_string);
}
</script>
<a href='edit_stock.php?id=<?php echo $r_id; ?>'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>&nbsp;|&nbsp;<b><?php echo "Edit Lot"; ?></b>
<br><br>

<?php
$tips_string = "Edit stock (lot) details by completeting this form.";
$page_elems->getSideTip("Tips", $tips_string);
$reag = Inventory::getReagentById($lid, $r_id);
$lott = Inventory::getLot($lid, $r_id, $lot);

?>

<form name='new_test_form' id='new_test_form' action='inventory/update_stock.php'  method='post'>
    <div class="pretty_box" style="width:500px;">
			<table>
                                               
                                        
				<tr>
					<td>
                                             
						&nbsp;<?php echo LangUtil::$pageTerms['Reagent']; ?> 
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
                                            <?php
                                            
                                            echo $reag['name'];
                                            ?>
					</td>
				</tr>
                                <tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Units']; ?> 
					</td>
					<td></td>
					<td>
						<?php echo $reag['unit']; ?>
					</td>
				</tr>
				<tr>
					<td>
                                            <input type="hidden" name="r_id" id="r_id" value="<?php echo $r_id; ?>"/>
                                            <input type="hidden" name="lid" id="lid" value="<?php echo $lid; ?>"/>
                                            <input type="hidden" name="lot" id="lot" value="<?php echo $lot; ?>"/>

						&nbsp;<?php echo LangUtil::$pageTerms['Lot_Number']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td></td>
					<td>
						<input type="text" name="n_lot" id="n_lot" class='uniform_width' value="<?php echo $lott['lot']; ?>"/>
                                                <label class="error" for="n_lot" id="n_lot_error"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
                                                <label class="error" for="n_lot" id="lot_u_error"><small><font color="red"><?php echo "Lot number exists"; ?></font></small></label>
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
                                                $value_list1 = explode('-', $lott['expiry_date']);
                                                echo $page_elems->getDatePicker($name_list1, $id_list1, $value_list1); ?>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Manufacturer']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="manu" id="txtRow14" class='uniform_width' value="<?php echo $lott['manufacturer']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Supplier']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="sup" id="txtRow15" class='uniform_width' value="<?php echo $lott['supplier']; ?>" />
					</td>
				</tr>
				
				
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Cost_per_Unit']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="cost" id="txtRow18" class='uniform_width' value="<?php echo $lott['cost_per_unit']; ?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label for='<?php echo $curr_form_id; ?>_date_1'>
							&nbsp;<?php echo LangUtil::$pageTerms['Date_received']; ?>
						</label>
					</td>
					<td></td>
					<td>
							<?php
                                                         $name_list2 = array("yyyy_r", "mm_r", "dd_r");
                                                         $id_list2 = $name_list2;
                                                         $value_list2 = explode('-', $lott['date_of_reception']);
                                                        echo $page_elems->getDatePicker($name_list2, $id_list2, $value_list2); ?>
					</td>
				</tr>
                                <tr>
					<td>
						&nbsp;<?php echo "Remarks"; ?> 
						
					</td>
					<td></td>
					<td>
                                              <textarea name="remarks" id="remarks" rows="3" cols="22"><?php echo $lott['remarks']; ?></textarea>
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
		<a href='edit_stock.php?id=<?php echo $r_id; ?>'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
</form>

<div id='patient_prompt_div2'>
	
	</div>
<?php include("includes/footer.php"); ?>
