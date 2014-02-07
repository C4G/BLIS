<?php
#
# Deletes a patient profile from DB
# Called via Ajax from lab_user_new.php
#
include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
include("../includes/user_lib.php");
$specimen_id=$_REQUEST['specimen_id'];

//$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

$lab_config=$_SESSION['lab_config_id'];

$isSuccess = 0 ;
$specimen = get_specimen_by_id_api($specimen_id,$lab_config);
//$specimen = get_specimen_by_id_api($specimen_id,$lab_config);
$specimen_list = array();
$specimen_list[] = $specimen; 

$specTest = $specimen_list[0];
//echo "Specimen ID to be deleted Arr ".$specTest->specimenId. " | lab id : ".$lab_config."<br/>";  
if(delete_specimen_by_specimen_id_api($specimen_list, $lab_config)){
	 $isSuccess = 1;
} 
echo $isSuccess;
?>