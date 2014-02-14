<?php
#
# Checks if the given patient ID already exists
# Called for form validation via Ajax from new_patient.php
#

include("../includes/db_lib.php");

$test_name = $_REQUEST['test_name'];
$test_name_exists = check_testType_byname($test_name);
if($test_name_exists === false)
	echo "0";
else
	echo "1";
db_close();
?>