<?php
#
# Deletes a patient profile from DB
# Called via Ajax from lab_user_new.php
#
include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
include("../includes/user_lib.php");
$test_id=$_REQUEST['test_id'];

//$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

$lab_config=$_SESSION['lab_config_id'];

$isSuccess = 0 ;

$test = get_test_by_test_id_api($test_id,$lab_config);
$test_list = array();
$test_list[] = $test; 
//echo "Params ".$test_id." Test ".$test->testId; 
if(delete_test_by_test_id_api($test_list, $lab_config)){
	 $isSuccess = 1;
} 
echo $isSuccess;
?>