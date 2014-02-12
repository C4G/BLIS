<?php
#
# Returns a list of matched specimens for generating reports
# Called via Ajax from report.php
#

include("../includes/db_lib.php");
LangUtil::setPageId("reports");

$lab_config_id = $_REQUEST['location'];
$q = $_REQUEST['session_num'];
$a = $_REQUEST['specimen_attrib'];
$specimen_list = array();
$saved_db = DbUtil::switchToLabConfig($lab_config_id);
# Fetch list from DB
if($a == 1)
{
	# Fetch by specimen ID
	$specimen_list = search_specimens_by_id($q);
}
else if($a == 2)
{
	# Fetch by Session No.
	$specimen_list = search_specimens_by_session($q);
}
else if($a == 3)
{
	# Fetch by Patient ID
	$specimen_list = search_specimens_by_patient_id($q);
}
else if($a == 4)
{
	# Fetch by Patient Name
	$specimen_list = search_specimens_by_patient_name($q);
}
if(count($specimen_list) == 0 || $specimen_list[0] == null)
{
	?>
	<br>
	<div class='sidetip_nopos'>No match found for
	<?php
	if($a == 1)
		echo " ".LangUtil::$generalTerms['SPECIMEN_ID']." ";
	else if($a == 2)
		echo " ".LangUtil::$generalTerms['ACCESSION_NUM']." ";
	else if($a == 2)
		echo " ".LangUtil::$generalTerms['PATIENT_ID']." ";
	else if($a == 2)
		echo " ".LangUtil::$generalTerms['PATIENT_NAME']." ";
	?>
	<b><?php echo " - ".$q." - ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?></b>
	</div>
	<?php
	return;
}
# Build HTML table
?>
<table class='hor-minimalist-b' style='width:720px;'>
	<thead>
		<tr valign='top'>
			<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
			<th><?php echo LangUtil::$generalTerms['ACCESSION_NUM']; ?></th>
			<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
			<th><?php echo LangUtil::$generalTerms['R_DATE']; ?></th>
			<th><?php echo LangUtil::$generalTerms['PATIENT']; ?></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php
foreach($specimen_list as $specimen)
{
	$patient = get_patient_by_id($specimen->patientId);
?>
	<tr valign='top'>
	<td>
	<?php echo $specimen->specimenId; ?>
	</td>
	<td>
	<?php echo $specimen->getSessionNum(); ?>
	</td>
	<td>
	<?php echo $specimen->getTypeName(); ?>
	</td>
	<td>
	<?php echo DateLib::mysqlToString($specimen->dateRecvd); ?>
	</td>
	<td>
	<?php 
	//echo $specimen->patientId; 
	//echo " ";
	echo $patient->getName();
	?>
	</td>
	<td>
		<a href='reports_specimen.php?location=<?php echo $lab_config_id; ?>&specimen_id=<?php echo $specimen->specimenId; ?>' title='Click to Generate Specimen Report' target='_blank'>
			<?php echo LangUtil::$generalTerms['CMD_GETREPORT']; ?>
		</a>
	</td>
	<td>
		<a href='reports_specimenlog.php?location=<?php echo $lab_config_id; ?>&specimen_id=<?php echo $specimen->specimenId; ?>' title='Click to Track Specimen Actions' target='_blank'>
			<?php echo LangUtil::$generalTerms['CMD_TRACK']; ?>
		</a>
	</td>
	</tr>
<?php
}
DbUtil::switchRestore($saved_db);
?>
</tbody>
</table>
<?php
if($a == 2)
{
	# Show link for Session Report
	?>
	<br>
	<a href='reports_session.php?location=<?php echo $lab_config_id; ?>&session_num=<?php echo $q; ?>' target='_blank'><?php echo LangUtil::$pageTerms['TIPS_GETACCESSIONREPORT']; ?> &raquo;</a>
	<?php
}