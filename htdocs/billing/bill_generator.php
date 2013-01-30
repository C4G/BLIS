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
		</script>
		<?php include("../includes/styles.php"); ?>
	</head>
	<body>
		<form name='bill_generator_form' action=''>
		<input type='hidden' value='<?php echo $_SESSION['pid']; ?>'><?php
		$specimens = search_specimens_by_patient_id($_SESSION['pid']);
		if (!empty($specimens))
		{
		?><table class='tablesorter' id='billing_popup_table' style="border-collapse: separate;">
			<thead>
				<tr valign='top'>
					<th class='billing_popup_header'>Specimen Date</th>
					<th class='billing_popup_header'>Specimen Name</th>
					<th class='billing_popup_header'>Specimen Cost</th>
					<th class='billing_popup_header'>Select for Billing</th>
				</tr>
			</thead><?php
			foreach ($specimens as $specimen)
			{
			$style_string = "style='background-color:grey; color:white;'";
			?><tr>
				<td <?php echo $style_string ?>><?php echo $specimen->getDateReported()?></td>
				<td <?php echo $style_string ?>><?php echo $specimen->getTypeName()?></td>
				<td <?php echo $style_string ?>><?php echo $specimen->getCost()?></td>
				<td <?php echo $style_string ?>><input type='checkbox' <?php echo "checked" ?>></input></td>
			</tr><?php
			}
		?></table>
		<input type='submit' value='Generate Bill' />
		&nbsp
		<input type='submit' value='Enter Payment' /><?php
		} else
		{
			echo "There are no specimens registered for this patient.";
		}?>
	</body>
</html>