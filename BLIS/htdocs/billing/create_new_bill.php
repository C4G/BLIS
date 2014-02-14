<?php
#
# Generates a bill for a set of tests and adds it to the DB.
#

include("../includes/db_lib.php");

$lab_config_id = $_SESSION['lab_config_id'];

$patientId = $_REQUEST['patient_id'];
$tests = $_REQUEST['test_checkboxes'];

if (empty($tests))
{
	// There weren't any tests selected.  Really this should have been handled in the js on the page, but somehow it got missed...
} else
{
	$test_objs = Test::convertArrayOfIdsToObjects($tests);
	
	$bill = Bill::createBillForTests($test_objs, $lab_config_id);

	// This sends the bill id back to the js handler, so we can post the correct bill_id to the next page.
	echo $bill->getId();
}

?>