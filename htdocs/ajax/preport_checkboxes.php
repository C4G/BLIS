<?php
#
# Returns matched sampled in reverse chronological order
# Called via Ajax from reports.php
# Used for '[MENU_PATIENT]' report
#

include("../includes/db_lib.php");
LangUtil::setPageId("reports");

$lab_config_id = $_REQUEST['l'];
$query = $_REQUEST['q'];
$attrib_type = $_REQUEST['a'];
$lab_config = LabConfig::getById($lab_config_id);

$saved_db = DbUtil::switchToLabConfig($lab_config_id);
$specimen_list = array();
if($attrib_type == 0)
{
	# Fetch by patient ID
	$specimen_list = search_specimens_by_patient_id($query);
}
else if($attrib_type == 1)
{
	# Fetch by patient name
	$specimen_list = search_specimens_by_patient_name($query);
}
else if($attrib_type == 2)
{
	# Fetch by patient daily number
	$specimen_list = search_specimens_by_dailynum("-".$query);
}

if(count($specimen_list) == 0)
{
	# No match found
	?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$pageTerms['TIPS_NOMATCHSPECIMENS']; ?>
	</div>
	<?php
	return;
}
# Table fields - checkbox, patient_name, specimen_id, type, collection_date, tests, status
?>
<form id='preport_selected_form' action='reports_patient.php' method='post' target='_blank'>
<input type='hidden' name='l' id='location151' value=''></input>
<table class='tablesorter' id='preport_table' style='width:720px;'>
	<thead>
		<tr valign='top'>
			<th <?php
			if(count($specimen_list) == 1)
				echo " style='display:none;' ";
			?>></th>
			
			<th><?php echo LangUtil::$generalTerms['PATIENT']; ?></th>
			<?php
			if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
			{
			?>
				<th><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></th>
			<?php
			}
			?>
			<!--<th><?php # echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>-->
			<th><?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?></th>
			<th><?php echo LangUtil::$generalTerms['R_DATE']; ?></th>
			<th><?php echo LangUtil::$generalTerms['TESTS']; ?></th>
			<th><?php echo LangUtil::$generalTerms['SP_STATUS']; ?></th>
		</tr>
	</thead>
	<tbody>
<?php
foreach($specimen_list as $specimen)
{
	$patient = get_patient_by_id($specimen->patientId);
	?>
	<tr valign='top'>
	<td <?php
		if(count($specimen_list) == 1)
			echo " style='display:none;' ";
		?>>
		<input type='checkbox' class='sp_checkbox' name='sp_<?php echo $specimen->specimenId; ?>' value='<?php echo $specimen->specimenId; ?>' <?php
			if(count($specimen_list) == 1)
				echo " checked ";
			?>></input>
	</td>
	<td>
		<?php echo $patient->getName(); ?>
	</td>
	<?php
			if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
			{
			?>
				<td><?php echo $specimen->getDailyNumFull(); ?></td>
			<?php
			}
			?>	
	<!--
	<td>
		<?php # echo $specimen->specimenId; ?>
	</td>
	-->
	<td>
		<?php echo $specimen->getTypeName(); ?>
	</td>
	<td>
		<?php echo DateLib::mysqlToString($specimen->dateRecvd); ?>
	</td>
	<td>
		<?php echo $specimen->getTestNames(); ?>
	</td>
	<td>
		<?php echo $specimen->getStatus(); ?>
	</td>
	</tr>
<?php
}
?>
</tbody>
</table>
<br>
<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_GETREPORT']; ?>' onclick='javascript:submit_preport();'></input>

</form>
<?php
DbUtil::switchRestore($saved_db);
?>