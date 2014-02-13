<?php
#
# Main page for generating reports of selected samples for a patient
# Gathers selected specimen IDs and redirects to reports_session.php

$lab_config_id = $_REQUEST['l'];
# Gather selected specimen IDs
$specimen_id_list = array();
foreach($_REQUEST as $key => $value)
{
	if(strpos($key, "sp") === 0)
		$specimen_id_list[] = $value;
}
$specimen_csv = implode(",", $specimen_id_list);
# Redirect to reports_session.php with extra flag and list of selected specimens
$url_string = "reports_session.php?fp=1&slist=".$specimen_csv."&location=".$lab_config_id;
header("Location: ".$url_string);
?>
