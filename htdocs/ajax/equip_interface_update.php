<?php

include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
include("../includes/user_lib.php");

$equipment_id=$_REQUEST['equipment_id'];
$equipment_name=$_REQUEST['equipment_name'];
$equipment_version = $_REQUEST['equipment_version'];
$lab_department = $_REQUEST['lab_department'];
$comm_type = $_REQUEST['comm_type'];
$feed_source = $_REQUEST['feed_source'];
$config_file = $_REQUEST['config_file'];
$prop_ids = $_REQUEST['prop_ids'];
$propidarr = explode(",", $prop_ids);
$prop_values = $_REQUEST['prop_values'];
$propvaluesarr =  explode(",", $prop_values);

$saved_db = DbUtil::switchToGlobal();
$query_string = 
	"update interfaced_equipment
	set equipment_name = '$equipment_name',
		equipment_version = '$equipment_version',
		lab_department = '$lab_department',
		comm_type = '$comm_type',
		feed_source = '$feed_source',
		config_file = '$config_file'
		where id = $equipment_id";
query_insert_one($query_string);

for ($i = 0; $i < count($propidarr); $i++){
	$query_string = 
	"update equip_config
	set prop_value = '$propvaluesarr[$i]'
	where equip_id = $equipment_id
		and prop_id = $propidarr[$i]";
	query_insert_one($query_string);
}

DbUtil::switchRestore($saved_db);

?>