<?php
#
# Main page for marking specimen results as reported
# Called via Ajax from results_entry.php
#

include("../includes/db_lib.php");

$sid_list = $_REQUEST['sid'];
foreach($sid_list as $sid)
{
	$marker_key = 'mark_'.$sid;
	if(isset($_REQUEST[$marker_key]))
	{
		# Mark specimen as reported
		$ts = date("Y-m-d H:i:s");
		Specimen::markAsReported($sid, $ts);
	}
}
?>