<?php
#
# Adds a new specimen type to catalog in DB
#
include("redirect.php");
include("includes/db_lib.php");
include("lang/lang_xml2php.php");

$specimen_name = $_REQUEST['specimen_name'];
$specimen_descr = $_REQUEST['specimen_descr'];
$reff = 1;
$test_type_list = get_test_types_catalog($lab_conifg_id, $reff);
$added_test_list = array();
foreach($test_type_list as $key=>$value)
{
	$field_tocheck = "t_type_".$key;
	if(isset($_REQUEST[$field_tocheck]))
	{
		$added_test_list[]  = $key;
	}
}
$specimen_type_id="";
if(count($added_test_list) == 0)
{
	# No tests selected
	$specimen_type_id = add_specimen_type($specimen_name, $specimen_descr);
}
else
{
	# Compatible tests selected
	$specimen_type_id = add_specimen_type($specimen_name, $specimen_descr, $added_test_list);
}

# Update locale XML and generate PHP list again.
if($CATALOG_TRANSLATION === true)
	update_specimentype_xml($specimen_type_id, $specimen_name);

header("Location: specimen_type_added.php?sn=$specimen_name");
?>