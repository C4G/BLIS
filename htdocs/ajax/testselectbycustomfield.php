<?php
#
# Returns <option> tags for list of test types by category (section) and site
# Called via Ajax from reports.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
LangUtil::setPageId("general");

$page_elems = new PageElems();
$selvalue = $_REQUEST['selvalue'];

if(strstr($selvalue,'p_') != FALSE)
	$custom_field_obj = get_custom_fields_patient_by_id(substr($selvalue,2));
else
	$custom_field_obj = get_custom_fields_specimen_by_id(substr($selvalue,2));
$page_elems->getCustomFormField($custom_field_obj);
?>