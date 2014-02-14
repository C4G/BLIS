<?php
#
# updates the field ordering for patient registration
# Called via Ajax from lab_config_home.php
#
include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
include("../includes/user_lib.php");
include_once("../includes/field_order_update.php");

print_r($_GET);
//echo "Total parameter count = ".count($_GET);

$field_ordering = new FieldOrdering();


$field_order = "";
$formId = 0;
foreach($_GET as $key => $value){
	if($key == "formId"){
		$formId = $value;
		continue;
	} else {
		if($field_order == "")
			$field_order = str_replace("_"," ",$key);
		else	
			$field_order = $field_order.",".str_replace("_"," ",$key);
	}
}

$field_ordering->form_field_inOrder =$field_order;
$field_ordering->id = $_SESSION['lab_config_id'];
$field_ordering->form_id = $formId;


/* foreach($_GET as $key => $value){
	if($value == "1")
		$field_ordering->field1 = str_replace("_"," ",$key);
		//$field_ordering->field1 = field_order_update::getShortName($key);
	if($value == "2")
		$field_ordering->field2 = str_replace("_"," ",$key);
	if($value == "3")
		$field_ordering->field3 = str_replace("_"," ",$key);
	if($value == "4")
		$field_ordering->field4 = str_replace("_"," ",$key);
	if($value == "5")
		$field_ordering->field5 = str_replace("_"," ",$key);
	if($value == "6")
		$field_ordering->field6 = str_replace("_"," ",$key);
	if($value == "7")
		$field_ordering->field7 = str_replace("_"," ",$key);
	if($value == "8")
		$field_ordering->field8 = str_replace("_"," ",$key);
	if($value == "9")
		$field_ordering->field9 = str_replace("_"," ",$key);
	if($value == "10")
		$field_ordering->field10 = str_replace("_"," ",$key);
	if($value == "11")
		$field_ordering->field11 = str_replace("_"," ",$key);
	if($value == "12")
		$field_ordering->field12 = str_replace("_"," ",$key);
	if($value == "13")
		$field_ordering->field13 = str_replace("_"," ",$key);
	if($value == "14")
		$field_ordering->field14 = str_replace("_"," ",$key);
	if($value == "15")
		$field_ordering->field15 = str_replace("_"," ",$key);
	if($value == "16")
		$field_ordering->field16 = str_replace("_"," ",$key);
}
 */
FieldOrdering::deleteFieldOrderEntry($field_ordering->id, $field_ordering->form_id);
FieldOrdering::add_fieldOrdering($field_ordering);
?>
