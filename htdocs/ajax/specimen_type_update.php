<?php
#
# Main page for updating specimen type info
# Called via Ajax from specimen_type_edit.php
#

include("../includes/db_lib.php");
include("../lang/lang_xml2php.php");

$updated_entry = new SpecimenType();
$updated_entry->specimenTypeId = $_REQUEST['sid'];
$updated_entry->name = $_REQUEST['name'];
$updated_entry->description = $_REQUEST['description'];
$reff = 1;
$test_type_list = get_test_types_catalog($lab_config_id, $reff);
$updated_test_list = array();
foreach($test_type_list as $key=>$value)
{
	$field_tocheck = "t_type_".$key;
	if(isset($_REQUEST[$field_tocheck]))
	{
		$updated_test_list[]  = $key;
	}
}
update_specimen_type($updated_entry, $updated_test_list);
# Update locale XML and generate PHP list again.
if($CATALOG_TRANSLATION === true)
	update_specimentype_xml($updated_entry->specimenTypeId, $updated_entry->name);
?>