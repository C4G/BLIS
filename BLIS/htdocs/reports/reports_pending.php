<?php
#
# Shows pending tests report for a site/location and date interval
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("reports");

$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
?>
<br>
<b><?php echo LangUtil::$pageTerms['MENU_PENDINGTESTS']; ?></b>
| <a href='reports.php'>&laquo; <?php echo LangUtil::$pageTerms['MSG_BACKTOREPORTS']; ?></a>
<br><br>
<?php
$lab_config_id = $_REQUEST['location'];
$lab_config = get_lab_config_by_id($lab_config_id);
DbUtil::switchToLabConfig($lab_config_id);
$test_type_id = $_REQUEST['test_type'];
if($test_type_id == "0")
{
	# Show graph for all test types in the lab configuration
}
else
{
	# Show pending tests for this type in a table
	$test = get_test_type_by_id($test_type_id);
	?>
	<table class="hor-minimalist-b">
		<tr>
			<td><?php echo LangUtil::$generalTerms['FACILITY']; ?></td>
			<td> <?php echo $lab_config->getSiteName(); ?></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
			<td><?php echo get_test_name_by_id($test_type_id); ?></td>
		</tr>
		<?php $pending_tests = get_pending_tests_by_type($test_type_id);?>
		<tr>
			<td><?php echo LangUtil::$generalTerms['PENDING_RESULTS']; ?></td>
			<td><?php echo count($pending_tests); ?></td>
		</tr>
	</table>
	<br>
	<?php
	if(count($pending_tests) != 0)
	{
	?>
	<script type='text/javascript'>
	$(document).ready(function(){
		$('#pending_list').tablesorter({sortList: [[4,0]]});	
	});
	</script>
	
	<table id='pending_list' class='tablesorter'><?php #class="hor-minimalist-c" style='width:600px;' ?> 
		<thead>
			<tr>
				<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
				<th><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></th>
				<th><?php echo LangUtil::$generalTerms['C_DATE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['REGD_BY']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($pending_tests as $test)
		{
			$specimen_id = $test->specimenId;
			$specimen = get_specimen_by_id($specimen_id);
			?>
			<tr valign='top'>
				<td>
					<?php $specimen->getAuxId(); ?>
				</td>
				<td><?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?></td>
				<td>
				<?php 
					echo $specimen->patientId; 
					$patient = get_patient_by_id($specimen->patientId);
					if($patient != null && trim($patient->addlId) != "")
					{
						//echo " (Addl ID: $patient->addlId )";
					}
				?>
				</td>
				<td>
					<?php
					$patient = get_patient_by_id($specimen->patientId);
					echo $patient->getName();
					?>
				</td>
				<td><?php echo DateLib::mysqlToString($specimen->dateCollected); ?></td>
				<td><?php echo get_username_by_id($specimen->userId); ?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php
	}
	# TODO: Add paging to the above table
}
?>
<?php include("includes/footer.php"); ?>