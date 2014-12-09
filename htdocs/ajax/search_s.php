<?php
#
# Returns list of matched specimens
# Called via Ajax from /search.php
#

include("../includes/db_lib.php");
LangUtil::setPageId("search");

$q = $_REQUEST['q'];
$a = $_REQUEST['a'];
$uiinfo = "op=".$a."&qr=".$q;
putUILog('search_s', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
$specimen_list = array();
# Fetch list from DB
if($a == 0)
{
	# Fetch by specimen ID
	$specimen_list = search_specimens_by_id($q);
}
else if($a == 1)
{
	# Fetch by additional ID
	$specimen_list = search_specimens_by_addlid($q);
}
else if($a == 2)
{
	# Fetch by Session No.
	$specimen_list = search_specimens_by_session($q);
}
if(count($specimen_list) == 0 || $specimen_list[0] == null)
{
	?>
	<br>
	<div class='sidetip_nopos'>
	<?php
	if($a == 0)
		echo " ".LangUtil::$generalTerms['SPECIMEN_ID']." ";
	else if($a == 1)
		echo " ".LangUtil::$generalTerms['ADDL_ID_S']." ";
	else if($a == 2)
		echo " ".LangUtil::$generalTerms['ACCESSION_NUM']." ";
	?>
	<b><?php echo $q; ?></b>
	<?php echo " - ". LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>
	<?php
	return;
}
# Build HTML table
?>
<table class='hor-minimalist-b' style='width:600px'>
<thead>
<tr>
<?php
if($_SESSION['s_addl'] != 0)
{
?>
	<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']?></th>
<?php
}
?>
<th><?php echo LangUtil::$generalTerms['ACCESSION_NUM']; ?></th>
<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
<th></th>
<th></th>
</tr>
</thead>
<tbody>
<?php
foreach($specimen_list as $specimen)
{
?>
	<tr>
	<?php
	if($_SESSION['s_addl'] != 0)
	{
	?>
		<td>
		<?php $specimen->getAuxId(); ?>
		</td>
	<?php
	}
	?>
	<td>
	<?php echo $specimen->sessionNum; ?>
	</td>
	<td>
	<?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?>
	</td>
	<td>
	<a href='specimen_info.php?sid=<?php echo $specimen->specimenId; ?>' title='Click to View Specimen Info'><?php echo LangUtil::$generalTerms['DETAILS']; ?></a>
	</td>
	<td>
	<?php
	$date_parts = explode("-", $specimen->dateCollected);
	$report_url = "reports_testhistory.php?location=".$_SESSION['lab_config_id']."&patient_id=".$specimen->patientId."&yf=$date_parts[0]&mf=$date_parts[1]&df=$date_parts[2]&yt=$date_parts[0]&mt=$date_parts[1]&dt=$date_parts[2]&ip=1";
	//$report_url = "reports_specimen.php?location=".$_SESSION['lab_config_id']."&specimen_id=".$specimen->specimenId;
	?>
	<a href='<?php echo $report_url; ?>' target='_blank' title='Click to Generate Report for this Specimen'><?php echo LangUtil::$generalTerms['CMD_GETREPORT']; ?></a>
	</td>
	</tr>
<?php
}
?>
</tbody>
</table>