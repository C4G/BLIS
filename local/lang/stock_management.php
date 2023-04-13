<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Admin Stock Management Page to add new stock
# Sneds POST request to stock_details.php 
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) 
     && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	 && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) ) {
		header( 'Location: home.php' );
}

include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
LangUtil::setPageId("stocks");
$script_elems->enableTableSorter();
$script_elems->enableDatePicker();
?> 
<script type='text/javascript'>
function add_specimenbox(){
	var num= parseInt(document.getElementById('count').value);
	
	var new_num=num+1;
	$('#count').attr("value",new_num);
	
	var url_string = "ajax/add_stock.php?num="+new_num;
	$.ajax({ 
		url: url_string, 
		success: function(msg){
			$('#specimenboxes').append(msg);
			
		}
	});
}

function validateRow() {

	var i;
	$('#new_test_form').submit();
}

</script>
<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_i'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>&nbsp;|&nbsp;<b><?php echo LangUtil::$pageTerms['Add_Stock']; ?></b>
<br><br>

<?php
$tips_string =LangUtil::$pageTerms['TIPS_ADD'];// "Add the details of the stock in the given form. To add more that one stock items you can select Add Another.";
$page_elems->getSideTip("Tips", $tips_string);
?>

<form name='new_test_form' id='new_test_form' action='stock_details.php' method='post'>
	<div id='specimenboxes' >
		<?php
			$name_list = array("yyyy_to1", "mm_to1", "dd_to1");
			$name_list1 = array("yyyy_ex1", "mm_ex1", "dd_ex1");
			$id_list = $name_list;
			$id_list1 = $name_list1;
			$today = date("Y-m-d");
			$today_array = explode("-", $today);
			$value_list = $today_array;
			$value_list1 = $today_array;
		?>
		<input type='hidden' name='count' value='1' id='count' />
		<div class="pretty_box" style="width:400px;">
			<table>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Reagent']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
						<input type="text" name="txtRow11" id="txtRow11" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Lot_Number']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td></td>
					<td>
						<input type="text" name="txtRow12" id="txtRow12" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Expiry_Date']; ?><?php $page_elems->getAsterisk(); ?> 
						
					</td>
					<td></td>
					<td>
						<!--<input type="date" name="txtRow13" id="txtRow13" class='uniform_width'/>-->
						<?php echo $page_elems->getDatePicker($name_list1, $id_list1, $value_list1); ?>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Manufacturer']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="txtRow14" id="txtRow14" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Supplier']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="txtRow15" id="txtRow15" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Quantity_Supplied']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td></td>
					<td>
						<input type="text" name="txtRow16" id="txtRow16" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Units']; ?><?php $page_elems->getAsterisk(); ?> 
					</td>
					<td></td>
					<td>
						<input type="text" name="txtRow17" id="txtRow17" class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<?php echo LangUtil::$pageTerms['Cost_per_Unit']; ?>
					</td>
					<td></td>
					<td>
						<input type="text" name="txtRow18" id="txtRow18" class='uniform_width'/>
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
						<span id='<?php echo $curr_form_id; ?>_date_l'>
							<?php echo $page_elems->getDatePicker($name_list, $id_list, $value_list); ?>
						</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<br>
	<!--<a href='javascript:add_specimenbox();'>Add Another</a> -->
		&nbsp;&nbsp;&nbsp;&nbsp;
	<br>
	<br>
		<input name='stock_manage' id='stock_manage' type='button' onclick='javascript:validateRow();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' />
			&nbsp;&nbsp;&nbsp;&nbsp;
		<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
		<input type='hidden' name='file' value='1' id='file' />
</form>

<?php include("includes/footer.php"); ?>