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
putUILog('inv_new_reagent', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

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
        name = name.replace(" ", "%20");
        var url_string = "inventory/check_reagent.php?name="+name+"&lid="+"<?php echo $_SESSION['lab_config_id']; ?>";
	$.ajax({ 
		url: url_string,
                async : false,
		success: function(check){
                     if(check == '1')
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
	var url_string = "inventory/reagent_prompt_match.php?q="+name;
	$('#patient_prompt_div').load(url_string);
}
</script>
<a href='view_stock.php'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>&nbsp;|&nbsp;<b><?php echo "Add New Item"; ?></b>
<br><br>

<?php
$tips_string = "Add new Item by completeing this form. Stocks can then be added for these items. Item name is required. Entering units for the item is optional. As you type letters in item name field, item with similar names are dispayed below.";
$page_elems->getSideTip("Tips", $tips_string);
?>

<form name='new_test_form' id='new_test_form' action='inventory/add_reagent.php'  method='post'>
    <div class="pretty_box" style="width:450px;">
			<table>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Reagent']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
						<input type="text" name="reagent" id="reagent" class='uniform_width'/>
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
						<input type="text" name="unit" id="unit" class='uniform_width'/>

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
	</div>
		&nbsp;&nbsp;&nbsp;&nbsp;
	<br>
	<br>
		<input name='stock_manage' id='stock_manage' type='button' onclick='javascript:validateForm();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' />
			&nbsp;&nbsp;&nbsp;&nbsp;
		<a href='view_stock.php'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
</form>
<div id='patient_prompt_div'>
	
	</div>
<?php include("includes/footer.php"); ?>