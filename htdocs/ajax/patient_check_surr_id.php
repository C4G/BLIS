<?php
#
# Checks if the given patient ID already exists
# Called for form validation via Ajax from new_patient.php
#

include("../includes/db_lib.php");

$pid = $_REQUEST['sur_id'];
$pid_exists = check_patient_surr_id($pid);
if($pid_exists === false)
	echo "0";
else
	echo "1";
db_close();
?>