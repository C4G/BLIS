<?php
include("redirect.php");
include("includes/header.php");
include("lang/lang_xml2php.php");
include("includes/stats_lib.php");
LangUtil::setPageId("stocks");
$script_elems->enableTableSorter();


$entry_id_value=$_REQUEST['entry_id'];
$retval=array();
$retval=get_stock_details($entry_id_value);

?>
<script type='text/javascript'>
function stock_edit()
{
	$('#stock_edit_details').submit();
}
</script>

<form name='stock_edit_details' id='stock_edit_details' action='stock_edit.php' method='get'>
	<h3> Edit Stock Details </h3>

	<div class='pretty_box' style="width:400px;">
		<table>
			<tr>
				<td>
					&nbsp;<?php echo LangUtil::$pageTerms['Reagent']; ?><?php $page_elems->getAsterisk(); ?> 
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<input class='uniform_width' type="text" name="txtRow11" id="txtRow11"  value=<?php echo $retval[0];?>></input>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;<?php echo LangUtil::$pageTerms['Lot_Number']; ?><?php $page_elems->getAsterisk(); ?> 
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<input class='uniform_width' type="text" name="txtRow12" id="txtRow12"  value=<?php echo $retval[1];?>></input>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;<?php echo LangUtil::$pageTerms['Manufacturer']; ?>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<input class='uniform_width' type="text" name="txtRow13" id="txtRow13"  value=<?php echo $retval[2];?>></input>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;<?php echo LangUtil::$pageTerms['Quantity']; ?>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<input class='uniform_width' type="text" name="txtRow14" id="txtRow14" value=<?php echo $retval[3];?>></input>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;<?php echo LangUtil::$pageTerms['Expiry_Date']; ?>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					
					<input class='uniform_width' type="text" name="txtRow15" id="txtRow15" value=<?php echo $retval[4];?>></input>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;<?php echo LangUtil::$pageTerms['Supplier']; ?>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<input class='uniform_width' type="text" name="txtRow16" id="txtRow16"   value=<?php echo $retval[5];?>></input>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;<?php echo LangUtil::$pageTerms['Units']; ?><?php $page_elems->getAsterisk(); ?> 
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<input class='uniform_width' type="text" name="txtRow17" id="txtRow17"  value=<?php echo $retval[6];?>></input>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;<?php echo LangUtil::$pageTerms['Cost_per_Unit']; ?><?php $page_elems->getAsterisk(); ?> 
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<input class='uniform_width' type="text" name="txtRow18" id="txtRow18"  value=<?php echo $retval[7];?>></input>
				</td>
			</tr>
		</table>
	</div>
	<input type='hidden' name='file' value='2' id='file' />
	<input type='hidden' name='entry_id' value=<?php echo $entry_id_value;?> id= 'entry_id'/>
	<br><br>
	<input name='stock_manage' id='stock_manage' type='button' onclick='javascript:stock_edit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' />
		&nbsp;&nbsp;&nbsp;&nbsp;
	<a href='stock_edit.php'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>		
</form>

<?php
include("includes/footer.php");
?>