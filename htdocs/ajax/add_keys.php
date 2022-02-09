<?php

include("../includes/db_lib.php");
include("../includes/SessionCheck.php");
$userId = $_SESSION['user_id'];
$lab=$_REQUEST['lab_name'];
//$key=$_REQUEST['pub_key'];
$target_loc="../key.blis";

	if ( move_uploaded_file($_FILES["keys"]["tmp_name"], $target_loc) ) {
$key=file_get_contents($target_loc);
$keyMgmt=new KeyMgmt();
$keyMgmt->LabName=$lab;
$keyMgmt->PubKey=$key;
$keyMgmt->AddedBy=$userId;
$ret=KeyMgmt::add_key_mgmt($keyMgmt);
echo $ret;
}
else
{
echo "FAIL";
return;
}

?>