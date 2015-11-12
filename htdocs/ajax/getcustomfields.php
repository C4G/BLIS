<?php
#
# Returns <option> tags for list of test types by category (section) and site
# Called via Ajax from reports.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
LangUtil::setPageId("general");

$page_elems = new PageElems();
$selvalue = $_REQUEST['type'];?>
<option value='0'><?php echo LangUtil::$generalTerms['ALL'];//  ?></option>
                           <?php
						   $lab_config = LabConfig::getById($_SESSION['lab_config_id']);
						   if($selvalue == "p")
						   {						
						  	$custom_field_list = $lab_config->getPatientCustomFields();
							foreach($custom_field_list as $custom_field)
							{
								echo "<option value='p_".$custom_field->id."'>".$custom_field->fieldName."</option>"; 
							}
						   }
						   elseif($selvalue == "s")
						   {
							
							$custom_field_list = $lab_config->getSpecimenCustomFields();
							foreach($custom_field_list as $custom_field)
							{
								echo "<option value='s_".$custom_field->id."'>".$custom_field->fieldName."</option>"; 
							}
						   }
?>