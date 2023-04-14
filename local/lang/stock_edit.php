<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Admin stock Edit Page
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) 
     && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	 && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) ) {
		header( 'Location: home.php' );
}

include("redirect.php");
include("includes/header.php");
include("lang/lang_xml2php.php");
include("includes/stats_lib.php");
LangUtil::setPageId("stocks");

$script_elems->enableTableSorter();
$entry_ids=get_entry_ids();

if($_REQUEST['file']==2) {

	$name=$_REQUEST['txtRow11'];
	$lot_number=$_REQUEST['txtRow12'];
	$manu=$_REQUEST['txtRow13'];
	$quant=$_REQUEST['txtRow14'];
	$expiry_date=$_REQUEST['txtRow15'];
	$supplier=$_REQUEST['txtRow16'];
	$unit=$_REQUEST['txtRow17'];
	$cost=$_REQUEST['txtRow18'];
	$entry_id=$_REQUEST['entry_id'];
	update_stocks_details($name,$lot_number,$expiry_date,$manu,$quant,$supplier,$entry_id, $cost);
}
$retval=array();
$retval=get_stocks();
?>

<script type='text/javascript'>
function stock_edit(entry_id_number)
{
//var entry_id_number=document.getElementById('entry_id').value;
$('#entry_id').attr("value",entry_id_number);
$('#new_test_form2').submit();
}
</script>

<form name='new_test_form2' id='new_test_form2' action='stock_edit_details.php' method='get'>
	<input type='hidden' name='entry_id' value='' id='entry_id' />
	<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_i'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>&nbsp;| &nbsp;
	<b><?php echo LangUtil::$pageTerms['Edit_Stock']; ?> </b>
	<br><br>
</form>

<table class='tablesorter' >
	<thead>
		<tr align='center'>
			<th><?php echo LangUtil::$pageTerms['Reagent']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Lot_Number']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Expiry_Date']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Quantity']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Manufacturer']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Supplier']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Units']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Cost_per_Unit']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Edit']; ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($retval as $record_set){ 
?>
		<tr align='center'>
		<?php $value = $record_set;?>
			<td><?php echo $value[0]; ?></td>
			<td><?php echo $value[1]; ?></td>
			<td><?php echo $value[4]; ?></td>
			<td><?php echo $value[3]; ?></td>
			<td><?php echo $value[2]; ?></td>
			<td><?php echo $value[5]; ?></td>
			<td><?php echo $value[6]; ?></td>
			<td><?php echo $value[8]; ?></td>
			<td><a href="javascript:void(0)" onclick="stock_edit(<?php echo $value[7]; ?>)"><?php echo LangUtil::$pageTerms['Edit']; ?></a></td>
		</tr>
<?php
	} 
?>
	</tbody>
</table>
<?php
include("includes/footer.php");
?>