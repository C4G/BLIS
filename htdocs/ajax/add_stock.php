<?php
#
# Sends a new specimen registration form
# Called via Ajax from new_specimen.php
#

include("../includes/page_elems.php");
include("../includes/script_elems.php");
LangUtil::setPageId("stocks");
$script_elems= new ScriptElems();
$script_elems->enableDatePicker();

$count = $_REQUEST['num'];

$page_elems = new PageElems();

$name_request="txtRow".$count."1";
$lot_number_request="txtRow".$count."2";
$expiry_date_request="txtRow".$count."3";
$manufacture_request="txtRow".$count."4";
$quantity_supplied_request="txtRow".$count."6";
$supplier_request="txtRow".$count."5";
$unit_request="txtRow".$count."7";
$cost_request="txtRow".$count."8";
$name_list = array("yyyy_to".$count, "mm_to".$count, "dd_to".$count);
$name_list1 = array("yyyy_ex".$count, "mm_ex".$count, "dd_ex".$count);
$id_list = $name_list;
$id_list1 = $name_list1;
$today = date("Y-m-d");
$today_array = explode("-", $today);
$value_list = $today_array;
$value_list1 = $today_array;
?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="pretty_box" style="width:400px">
	<table>
		<tr>
			<td>
				&nbsp;<?php echo LangUtil::$pageTerms['Reagent']; ?><?php $page_elems->getAsterisk(); ?> 
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
				<input type="text" name='<?php echo $name_request; ?>' id='<?php echo $name_request; ?>' class='uniform_width'/>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<?php echo LangUtil::$pageTerms['Lot_Number']; ?><?php $page_elems->getAsterisk(); ?> 
			</td>
			<td></td>
			<td>
				<input type="text" name='<?php echo $lot_number_request; ?>' id='<?php echo $lot_number_request; ?>' class='uniform_width'/>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<?php echo LangUtil::$pageTerms['Expiry_Date']; ?><?php $page_elems->getAsterisk(); ?> 
			</td>
			<td></td>
			<td>
				<?php // <input type="text" name='<php echo $expiry_date_request; >' id='<php echo $expiry_date_request; >' class='uniform_width'/> ?>
				<?php echo $page_elems->getDatePicker($name_list1, $id_list1, $value_list1); ?>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<?php echo LangUtil::$pageTerms['Manufacturer']; ?>
			</td>
			<td></td>
			<td>
				<input type="text" name='<?php echo $manufacture_request; ?>' id='<?php echo $manufacture_request; ?>' class='uniform_width'/>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<?php echo LangUtil::$pageTerms['Supplier']; ?>
			</td>
			<td></td>
			<td>
				<input type="text" name='<?php echo $supplier_request; ?>' id='<?php echo $supplier_request; ?>' class='uniform_width'/>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<?php echo LangUtil::$pageTerms['Quantity_Supplied']; ?><?php $page_elems->getAsterisk(); ?> 
			</td>
			<td></td>
			<td>
				<input type="text" name='<?php echo $quantity_supplied_request; ?>' id='<?php echo $quantity_supplied_request; ?>' class='uniform_width'/>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<?php echo LangUtil::$pageTerms['Units']; ?><?php $page_elems->getAsterisk(); ?> 
			</td>
			<td></td>
			<td>
				<input type="text" name='<?php echo $unit_request; ?>' id='<?php echo $unit_request; ?>' class='uniform_width'/>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<?php echo LangUtil::$pageTerms['Cost_per_Unit']; ?>
			</td>
			<td></td>
			<td>
				<input type="text" name='<?php echo $cost_request; ?>' id='<?php echo $cost_request; ?>' class='uniform_width'/>
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
<?php
?>