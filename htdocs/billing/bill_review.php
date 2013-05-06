<?php
#
# Main page for reviewing a generated bill, and recieving payment/printing
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("bill_review");

$lab_config_id = $_SESSION['lab_config_id'];

$pid = $_REQUEST['pid'];
$billId = $_REQUEST['bill_id'];

$script_elems->enableTableSorter();

?>
<html>
	<head>
		<script type='text/javascript'>
			function apply_discount(id)
			{
				var selected = $("#selector_for_discount_of_association_" + id).val();
				var amount = $("#discount_amount_for_association_" + id).val();
				$.post('update_discount_for_association.php', {sel : selected, amt : amount, id : id}, function (response) {
					var decoded_resp = JSON.parse(response);
					$("#calculated_cost_for_test_" + id).hide();
					$("#calculated_cost_for_test_" + id).text(decoded_resp["a"]);
					$("#calculated_cost_for_test_" + id).fadeIn('fast');
					$("#bill_total").hide().html(decoded_resp["b"]).fadeIn('fast');
				});
			}
			function print_bill(id, lab_id)
			{
				var url = "reports_billing_specific.php?bill_id=" + id + "&lab_config_id=" + lab_id;
				window.open(url, '_blank');
				window.focus();
			}
		</script>
		<?php include("../includes/styles.php"); ?>
	</head>
	
	<body>
		<?php
			$bill = Bill::loadFromId($billId, $lab_config_id);
			$patient = Patient::getById($bill->getPatientId());
			$associations = $bill->getAllAssociationsForBill($lab_config_id);
		?>
		<div class='patient_bill_title'>
			Bill <?php echo $bill->getId(); ?> for <?php echo $patient->getName(); ?>
		</div>
		<form id='payments_form' name='payments_form' action=''>
			<table class='tablesorter' id='bill_table' style="border-collapse: separate;">
				<tr valign='top'>
					<th style="width: 75px;">Test Date</th>
					<th>Test Name</th>
					<th>Specimen Type</th>
					<th style="width: 80px;">Test Cost</th>
					<th>Discount Type</th>
					<th>Discount Amount</th>
					<th style="width: 80px;"></th>
				</tr>
				<?php
					foreach ($associations as $assoc)
					{ 
						$test = Test::getById($assoc->getTestId());
						$testType = TestType::getById($test->testTypeId);
						$specimen = Specimen::getById($test->specimenId);
						?>
				<tr>
					<td><?php echo date("Y-m-d", strtotime($test->timestamp)); ?></td>
					<td><?php echo $testType->name; ?></td>
					<td><?php echo $specimen->getTypeName(); ?></td>
					<td id="calculated_cost_for_test_<?php echo $assoc->getId(); ?>"><?php echo format_number_to_money($assoc->getDiscountedTotal()); ?></td>
					<td>
						<select class="discount_type_selector" id="selector_for_discount_of_association_<?php echo $assoc->getId(); ?>">
							<option value="<?php echo BillsTestsAssociationObject::NONE; ?>" <?php echo (($assoc->isDiscountDisabled()) ? "selected" : ""); ?>>None</option>
							<option value="<?php echo BillsTestsAssociationObject::PERCENT; ?>" <?php echo (($assoc->isPercentDiscount()) ? "selected" : ""); ?>>Percent</option>
							<option value="<?php echo BillsTestsAssociationObject::FLAT;  ?>" <?php echo (($assoc->isFlatDiscount()) ? "selected" : ""); ?>>Flat</option>
						</select>
					</td>
					<td>
						<input type='text'  id="discount_amount_for_association_<?php echo $assoc->getId(); ?>" value="<?php echo $assoc->getDiscountAmount(); ?>"/>
					</td>
					<td><div style="color:blue; cursor:hand; cursor:pointer;" onclick="javascript:apply_discount(<?php echo $assoc->getId(); ?>)">Update Cost</div></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan='6'></td>
					<td>Bill Total: <div id="bill_total" ><?php echo format_number_to_money($bill->getBillTotal($lab_config_id)); ?></div></td>
				</tr>
			</table>
			<input type='button' value='Print Bill' onclick="javascript:print_bill(<?php echo $bill->getId() . ", " . $lab_config_id; ?>)"\>
		</form>
	</body>
</html>

<?php include("includes/footer.php"); ?>