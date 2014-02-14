<?php
#
# Main page for printing session details.
# Lists patient profile along with all specimens registered in the session.
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");
include("includes/page_elems.php");
LangUtil::setPageId("regn");

$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$page_elems = new PageElems();

$session_num = $_REQUEST['snum'];
$specimen_list = get_specimens_by_session($session_num);
$lab_config = get_lab_config_by_id($_SESSION['lab_config_id']);
?>
<html>
<body>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
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
	<input type='hidden' name='data' value='' id='word_data'></input>
	<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
</form>
<hr>
<div id='export_content'>
<h4><?php echo LangUtil::$generalTerms['DETAILS']; ?></h4>
<?php echo LangUtil::$generalTerms['FACILITY']; ?>: <?php echo $lab_config->getSiteName(); ?> 
 | <?php echo LangUtil::$generalTerms['ACCESSION_NUM']; ?> <?php echo $session_num; ?>
 | <?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?> <?php $parts = explode("-", $session_num); echo $parts[1]; ?>
<br><br>
<?php
if(count($specimen_list) == 0 || $specimen_list == null)
{
	echo LangUtil::$generalTerms['MSG_NOTFOUND'];
	return;
}
$patient_id = $specimen_list[0]->patientId;
echo LangUtil::$generalTerms['PATIENT']."<br>";
$page_elems->getPatientInfo($patient_id);
?>
<br>
<?php echo LangUtil::$generalTerms['SPECIMENS']; ?><br>
<?php
$count = 0;
foreach($specimen_list as $specimen)
{
	$count++;
	$page_elems->getSpecimenInfo($specimen->specimenId);
	echo "<br>";
}
?>
</div>
</body>
</html>