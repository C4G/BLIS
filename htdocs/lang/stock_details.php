<?php
#
# Adds a new test type to catalog in DB
#
include("redirect.php");
include("includes/header.php");
include("includes/stats_lib.php");
include("lang/lang_xml2php.php");
LangUtil::setPageId("stocks");

$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
echo $_REQUEST['file'];
$file=$_REQUEST['file'];
?>

<script type='text/javascript'>
	$(document).ready(function(){
			$('#current_inventory').tablesorter();
	});

</script>
<style type='text/css'>
.flipv_up {
	font-size: 12px;
	font-family: Tahoma;
}
.flipv {
	font-size: 12px;
	font-family: Tahoma;
}
</style>
<?php
	$length=$_REQUEST['count'];

	$name= array();
	$lot_number=array();
	$expiry_date=array();
	$manufacture= array();
	$quantity= array();
	$supplier=array();
	$unit=array();
	$cost_per_unit=array();
	$ts=array();

	for($i=1; $i<=$length; $i++) {
		$name_request="txtRow".$i."1";
		$lot_number_request="txtRow".$i."2";
		$dd_ex_request="dd_ex".$i;
		$mm_ex_request="mm_ex".$i;
		$yyyy_ex_request="yyyy_ex".$i;
		$manufacture_request="txtRow".$i."4";
		$supplier_request="txtRow".$i."5";
		$quantity_supplied_request="txtRow".$i."6";
		$unit_request="txtRow".$i."7";
		$cost_request="txtRow".$i."8";
		$dd_to_request="dd_to".$i;
		$mm_to_request="mm_to".$i;
		$yyyy_to_request="yyyy_to".$i;
		
		$name[$i-1]=$_REQUEST[$name_request];
		$lot_number[$i-1]=$_REQUEST[$lot_number_request];
		$expiry_date[$i-1]=$_REQUEST[$mm_ex_request]."/".$_REQUEST[$dd_ex_request]."/".$_REQUEST[$yyyy_ex_request];
		$manufacture[$i-1]=$_REQUEST[$manufacture_request];
		$quantity_supplied[$i-1]=$_REQUEST[$quantity_supplied_request];
		$supplier[$i-1]=$_REQUEST[$supplier_request];
		$unit[$i-1]=$_REQUEST[$unit_request];
		$cost_per_unit[$i-1]=$_REQUEST[$cost_request];
		$dd_to=$_REQUEST[$dd_to_request];
		$mm_to=$_REQUEST[$mm_to_request];
		$yyyy_to=$_REQUEST[$yyyy_to_request];
		$ts[$i-1]= mktime(0,0,0,$mm_to,$dd_to,$yyyy_to);
	}
	if($name[0]!="" && $file=='1')
		add_new_stock($name,$lot_number,$expiry_date,$manufacture,$supplier,$quantity_supplied,$unit,$cost_per_unit,$ts);
	
        $_REQUEST['file'] = '0';
        echo $_REQUEST['file'];
	$retval=array();
	$retval=get_stocks();
?>
<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a> &nbsp;|&nbsp;<b> <?php echo LangUtil::$pageTerms['Current_Inventory']; ?></b>
<table class='tablesorter' id='current_inventory'  style='width:600px'>
	<thead>
		<tr>
			<th> <?php echo LangUtil::$pageTerms['Reagent']; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Lot_Number']; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Expiry_Date']." (mm/dd/yyyy)"; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Manufacturer']; ?></th>
			<th> <?php echo LangUtil::$pageTerms['Supplier']; ?></th>
			<th><?php echo LangUtil::$pageTerms['Total_Quantity']; ?></th>
                        <th><?php echo "Unit"; ?></th>
			<th><?php echo LangUtil::$pageTerms['Cost_per_Unit']; ?></th>
		</tr>
	</thead>
<?php
	foreach($retval as $record_set) {
?>  <tbody>
		<tr>
		<?php $value = $record_set;?>
			<td><?php echo $value[0];?></td>
			<td><?php echo $value[1];?></td>
			<td><?php echo $value[4];?></td>
			<td><?php echo $value[2];?></td>
			<td><?php echo $value[5];?></td>
			<td><?php echo $value[3]; ?></td>
                        <td><?php echo $value[6]; ?></td>
			<td><?php echo $value[8];?></td>
		</tr>
<?php 
	} 
?>
	</tbody>
</table>


<?php
include("includes/footer.php");
?>