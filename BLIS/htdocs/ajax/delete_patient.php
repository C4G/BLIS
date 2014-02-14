<?php
#
# Deletes a patient profile from DB
# Called via Ajax from lab_user_new.php
#
include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
include("../includes/user_lib.php");
$patient_id=$_REQUEST['patient_id'];

//$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

$lab_config=$_REQUEST['lab_config_id'];

$isSuccess = 1 ;
if(delete_patient($patient_id, $lab_config) == 0){
	 $isSuccess = 0;
} 
echo $isSuccess;
?>