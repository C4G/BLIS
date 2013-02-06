<?php
#
# Allows user to create a custom bill for a patient, and accept payments
#

include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");

$script_elems = new ScriptElems();
$page_elems = new PageElems();

$script_elems->enableJQuery();
$script_elems->enableJQueryForm();
?>
<html>
	<head>
		<title>
		</title>
		<script type='text/javascript'>
			$("#generate_bill_button").click(function() {
				var url = "bill_review.php";
				$('#submit_progress').show();
				$("#bill_generator_form").ajaxSubmit({
					success: function(data)
					{
						$('#submit_progress').hide();
						window.location = url + "?bill_id=" + data;
					}
				});
			});
		</script>
		<?php include("../includes/styles.php"); ?>
	</head>
	<body>
		<form name='bill_generator_form' id='bill_generator_form' action='create_new_bill.php'>
		<input type='hidden' name='patient_id' value='<?php echo $_SESSION['pid']; ?>'><?php
		$tests = get_all_tests_for_patient_and_date_range($_SESSION['pid'], "January 1, 1969", "today");
		if (!empty($tests))
		{
		?><table class='tablesorter' id='billing_popup_table' style="border-collapse: separate; width: 700px;">
			<thead>
				<tr valign='top'>
					<th id='billing_popup_date' style='width: 75px;'>Test Date</th>
					<th id='billing_popup_name'>Test Name</th>
					<th id='billing_popup_specimen_type'>Specimen Type</th>
					<th id='billing_popup_cost'>Test Cost</th>
					<th id='billing_popup_select' style='width: 110px;'>Select for Billing</th>
				</tr>
			</thead><?php
			foreach ($tests as $test)
			{
			$test = Test::getById($test['test_id']); // We only loaded an id and timestamp, and we want more information.

			$specimen = Specimen::getById($test->specimenId);

			$testHasBeenBilled = Bill::hasTestBeenBilled($test->testId, $_SESSION['lab_config_id']);
			
			if ($testHasBeenBilled)
			{
				$style_string = "style='background-color:grey; color:white;'";
			} else
			{
				$style_string = "";
			}
			$cost = get_cost_of_test($test);
			?><tr>
				<td <?php echo $style_string ?>><?php echo date("Y-m-d", strtotime($test->timestamp)); ?></td>
				<td <?php echo $style_string ?>><?php echo get_test_name_by_id($test->testTypeId); ?></td>
				<td <?php echo $style_string ?>><?php echo $specimen->getTypeName(); ?></td>
				<td <?php echo $style_string ?>><?php echo $cost["amount"]; ?></td>
				<?php if ($testHasBeenBilled)
				{ 
					$assoc = BillsTestsAssociationObject::loadByTestId($test->testId, $_SESSION['lab_config_id']);
					?>
					<td> <a href="bill_review.php?bill_id=<?php echo $assoc->getBillId() ?>">View Associated Bill</a> </td>
				<?php } else
				{ ?>
					<td <?php echo $style_string ?>><input name='test_checkboxes[]' type='checkbox' value='<?php echo $test->testId ?>'></input></td>
				<?php } ?>
			</tr><?php
			}
		?><tr>
			<td colspan='4'></td>
			<td align='center'><input id='generate_bill_button' name='generate_bill_button' type='button' value='Generate Bill'/></td>
		</tr></table>
		<span id='submit_progress' style='display:none;'>
			<?php echo $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
		</span>
		<?php
		} else
		{
			echo "There are no specimens registered for this patient.";
		}?>
	</body>
</html>