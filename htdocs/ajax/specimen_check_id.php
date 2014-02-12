<?php
include("../includes/db_lib.php");
$sid = $_REQUEST['sid'];
$sid_exists = check_specimen_id($sid);
if($sid_exists === false)
	echo "";
else
	echo "<span class='error_string'>ID $sid already exists";
?>