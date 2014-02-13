<?php
#
# Checks if the given patient ID already exists
# Called for form validation via Ajax from new_patient.php
#

include("../includes/db_lib.php");

$specimen_name = $_REQUEST['specimen_name'];
$specimen_name_exists = check_spacemen_byname($specimen_name);
if($specimen_name_exists === false)
	echo "0";
else
	echo "1";
db_close();
?>