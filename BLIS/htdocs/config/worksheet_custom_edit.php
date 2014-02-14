<?php
#
# Page for editting an existing custom worksheet
# Called from lab_config_home.php
#

include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("lab_config_home");

$lab_config_id = $_REQUEST['lid'];
$lab_config = LabConfig::getById($lab_config_id);
$worksheet_id = $_REQUEST['wid'];
?>
<br>
<b><?php echo LangUtil::$pageTerms['EDIT_CUSTOMWORKSHEET']; ?></b> | 
	<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<?php
if($lab_config == null)
{
	echo "<div class='sidetip_nopos'>";
	echo LangUtil::$generalTerms['MSG_NOTFOUND'];
	echo "</div>";
	include("includes/footer.php");
	return;
}
?>
<script type='text/javascript'>
function submit_worksheet_form()
{
	$('#worksheet_submit_progress').show();
	$('#custom_worksheet_form').submit();
}

function add_another_uf()
{
	var html_code = "<input type='text' name='uf_name[]' class='uniform_width'></input> <input type='text' name='uf_width[]' size='2' value='<?php echo CustomWorksheet::$DEFAULT_WIDTH; ?>'></input><br>";
	$('#uf_list_box').append(html_code);
}
</script>
<form id='custom_worksheet_form' name='worksheet_custom_form' action='worksheet_custom_update.php' method='post'>
	<?php $page_elems->getEditCustomWorksheetForm($worksheet_id, $lab_config); ?>
</form>
<?php include("includes/footer.php"); ?>