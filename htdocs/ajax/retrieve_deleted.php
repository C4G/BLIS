<?php
#
# Deletes a patient profile from DB
# Called via Ajax from lab_user_new.php
#
include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
include("../includes/user_lib.php");
$item_id=$_REQUEST['item_id'];

if(isset($_REQUEST['ret_cat'])){
	$category = $_REQUEST['ret_cat'];
}else{ 
	$category = "test";
}
//$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

$lab_config=$_SESSION['lab_config_id'];

$isSuccess = 0 ;

//echo "Params ".$test_id." Test ".$test->testId; 
if(retrieve_deleted_items($lab_config, $item_id, $category)){
	 $isSuccess = 1;
} 
echo $isSuccess;
?>