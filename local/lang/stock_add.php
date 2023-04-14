<?php
#
# Adds a new test type to catalog in DB
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
include("lang/lang_xml2php.php");
LangUtil::setPageId("stocks");
$script_elems->enableTableSorter();
$script_elems->enableDatePicker();

$file=$_REQUEST['file'];

//echo "Only administrator can change stock details";
//return;
?>
<script type='text/javascript'>
function update_stock()
{
	$('#file').attr("value",'2');
	var num=document.getElementById('new_quantity').value;
	$('#new_test_form2').submit();
}
function view_table()
{
	if(document.getElementById('edit_table').style.display =='none')
		$('#edit_table').show();
	else
		$('#edit_table').hide();
}

function hide_table()
{
	$('#edit_table').hide();
	$('#view_div').show();
}

function div_load()
{
	if(document.getElementById('current_inventory').style.display =='none')
		$('#current_inventory').show();
	else
		$('#current_inventory').hide();

}

</script>
<?php
	$name=$_REQUEST['reagent_name'];
	$lot_number=$_REQUEST['lot_number'];
	$receiver=$_REQUEST['receiver'];
	$new_quantity=$_REQUEST['new_quantity'];
	$remarks=$_REQUEST['remarks'];
	$dd_to=$_REQUEST['dd_to'];
	$mm_to=$_REQUEST['mm_to'];
	$yyy_to=$_REQUEST['yyyy_to'];
	$ts = mktime(0,0,0,$mm_to,$dd_to,$yyyy_to);
	$retur=update_stocks($name,$lot_number,$new_quantity,$receiver,$remarks, $ts);
	$retval=array();
	$retval=get_stock_count();
?>
	<h3><?php echo LangUtil::$pageTerms['Inventory'];?></h3>
	<a href='javascript:div_load();'><?php echo LangUtil::$pageTerms['Current_Inventory']; ?></a>
	
<?php
	$tips_string = LangUtil::$pageTerms['TIPS_UPDATE'];//"Enter the quantity of the stock being checked out. The table below gives account of the current inventory. ";
	$page_elems->getSideTip("Tips", $tips_string);
?>
	<div id='current_inventory' style='display:none;' name='current_inventory' >
		<table class='tablesorter'  style='width:300px'>
			<thead>
				<tr>
					<th> <?php echo LangUtil::$pageTerms['Reagent']; ?></th>
					<th> <?php echo LangUtil::$pageTerms['Quantity_In_Stock']; ?></th>
				</tr>
			</thead>
			<?php
				foreach($retval as $value)
			{ ?>
			<tbody>
				<tr>
					<td><?php echo $value[0];?></td>
					<td><?php echo $value[1]."  ".$value[2] ;?></td>
				</tr>
			<?php 
			} ?>
			</tbody>
		</table>
	</div>
	<div name='view_div' id='view_div'>
		<br>
		<a href="javascript:view_table();">Update Stock </a>
	</div>
	
	<br>
	
	<div  id="edit_table" name="edit_table" style="display:none;width:400px;" class='pretty_box' >
		<form name='new_test_form2' id='new_test_form2' action='stock_add.php' method='post'>

			<table>
				<tr align="top">
					<td width="50%"> <?php echo LangUtil::$pageTerms['Reagent']; ?></td>
					<td>
						<input type=text name=reagent_name id=reagent_name class='uniform_width'/>
					</td>
				</tr>
				<tr align="top">
					<td width="50%"> <?php echo LangUtil::$pageTerms['Lot_Number']; ?> </td>
					<td>
						<input type=text name=lot_number id=lot_number class='uniform_width'/>
					</td>
				</tr>
				<tr align="top" >
					<td width="50%"> <?php echo LangUtil::$pageTerms['Quantity_Signed_Out']; ?></td>
					<td>
						<input type=text name=new_quantity id=new_quantity class='uniform_width'/>
					</td>
				</tr>
				<tr align="top">
					<td width="50%"> <?php echo LangUtil::$pageTerms['Receiver']; ?></td>
					<td>
						<input type=text name=receiver id=receiver class='uniform_width'/>
					</td>
				</tr>
				<tr align="top">
					<td width="50%"> <?php echo LangUtil::$pageTerms['Remarks']; ?></td>
					<td>
						<input type=text name=remarks id=remarks class='uniform_width'/>
					</td>
				</tr>
				<tr>
					<td>
						<label for='<?php echo $curr_form_id; ?>_date_1'>
							Date of Entry
						</label>
					</td>
					<td>
						<span id='<?php echo $curr_form_id; ?>_date_l'>
						<?php $name_list = array("yyyy_to", "mm_to", "dd_to");
							$id_list = $name_list;
							 $today = date("Y-m-d");
							$today_array = explode("-", $today);
							$value_list = $today_array;
							$page_elems->getDatePicker($name_list, $id_list, $value_list); ?>
						</span>
					</td>
				</tr>
			</table>
			<br><br>
			<input type='button' name='stock_update' id='stock_update' onclick='javascript:update_stock();' value='Submit' />
		</form>
	</div>
	
	
<br><br><br><br>


<?php
include("includes/footer.php");
?>