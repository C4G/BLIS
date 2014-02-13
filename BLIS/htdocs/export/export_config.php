<?php
#
# Exports lab configuration parameters
#

include("../includes/db_lib.php");
require_once("../includes/perms_check.php");
include("../includes/page_elems.php");
include("../includes/script_elems.php");

putUILog('export_config', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$page_elems = new PageElems();
$script_elems = new ScriptElems();
$script_elems->enableJQuery();

$saved_session = SessionUtil::save();
$lab_config_id = $_REQUEST['id'];
$lab_config = LabConfig::getById($lab_config_id);
if($lab_config == null)
{
	echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['MSG_NOTFOUND'];
	return;
}
?>
<script type='text/javascript'>
function export_as_word(div_id)
{
	var content = $('#'+div_id).html();
	$('#word_data').attr("value", content);
	$('#word_format_form').submit();
}

function print_content(div_id)
{
	var DocumentContainer = document.getElementById(div_id);
	var WindowObject = window.open("", "PrintWindow", "toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
	//javascript:window.print();
}

</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
</form>
<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:export_as_word('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
<hr>

<div id='export_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<?php 
# Site name and location
echo "<b>";
echo LangUtil::$generalTerms['FACILITY'].": ".$lab_config->getSiteName();
echo "<br>";
echo LangUtil::$generalTerms['G_DATE'].": ".DateLib::mysqlToString(date("Y-m-d"));
echo "</b>";
echo "<br><br>";
echo "<hr>";


# Summary
echo "<b>".$LANG_ARRAY['lab_config_home']['MENU_CUSTOM']."</b>";
echo "<br><br>";
$page_elems->getLabConfigInfo($lab_config->id);
echo "<hr>";
echo "<br><br>";

/*
# Specimen types
echo "<b>".LangUtil::$generalTerms['SPECIMEN_TYPES']."</b>";
echo "<br><br>";
$specimen_id_list = get_lab_config_specimen_types($lab_config->id);
var_dump($specimen_id_list);
foreach($specimen_id_list as $specimen_id)
{
	$specimen = Specimen::getById($specimen_id);
	//echo $specimen->getName();
	echo "<br>";
}
echo "<hr>";
echo "<br>";

# Test types
echo "<b>".LangUtil::$generalTerms['TEST_TYPES']."</b>";
echo "<br><br>";
$specimen_id_list = get_lab_config_specimen_types($lab_config->id);
var_dump($specimen_id_list);
foreach($specimen_id_list as $specimen_id)
{
	$specimen = Specimen::getById($specimen_id);
	//echo $specimen->getName();
	echo "<br>";
}
echo "<hr>";
echo "<br>";
*/

# Fields used
echo "<b>".$LANG_ARRAY['lab_config_home']['MENU_CUSTOM']."</b>";
echo "<br><br>";
$page_elems->getRegistrationFieldsSummary($lab_config);
echo "<br><br>";
echo "<b>".$LANG_ARRAY['lab_config_home']['CUSTOMFIELDS']." - ".LangUtil::$generalTerms['PATIENTS']."</b>";
echo "<br><br>";
$custom_field_list = $lab_config->getPatientCustomFields();
foreach($custom_field_list as $custom_field)
{
	$field_name = $custom_field->fieldName;				
	echo $field_name;
	echo "<br>";
}
echo "<br><br>";
echo "<b>".$LANG_ARRAY['lab_config_home']['CUSTOMFIELDS']." - ".LangUtil::$generalTerms['SPECIMENS']."</b>";
echo "<br><br>";
$custom_field_list = $lab_config->getSpecimenCustomFields();
foreach($custom_field_list as $custom_field)
{
	$field_name = $custom_field->fieldName;				
	echo $field_name;
	echo "<br>";
}
echo "<hr>";
echo "<br><br>";


# Infection report settings
echo "<b>".$LANG_ARRAY['lab_config_home']['MENU_INFECTION']."</b>";
echo "<br><br>";
LangUtil::setPageId("lab_config_home");
$page_elems->getAggregateReportSummary($lab_config);
echo "<hr>";
echo "<br><br>";

# User accounts
echo "<b>".$LANG_ARRAY['lab_config_home']['MENU_USERS']."</b>";
echo "<br><br>";
$user_list = $lab_config->getUsers();
$page_elems->getLabUsersTable($user_list, $lab_config_id, true);
echo "<hr>";
echo "<br><br>";

# TATs values
echo "<b>".$LANG_ARRAY['lab_config_home']['MENU_TAT']."</b>";
echo "<br><br>";
$page_elems->getGetGoalTatTable($lab_config->id);
echo "<br><br>";
echo "<hr>";
?>
</div>
<?php
SessionUtil::restore($saved_session);
?>