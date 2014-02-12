<?php
#
# Page for creating new custom fields
#

include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("lab_config_home");

$lab_config_id = $_REQUEST['id'];
$lab_config = LabConfig::getById($lab_config_id);
?>
<br>
<b><?php echo LangUtil::$pageTerms['NEW_CUSTOMWORKSHEET']; ?></b> | 
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
$(document).ready(function(){
	$('#cat_code').change( function() {
		get_test_boxes();
	});
	get_test_boxes();
});

$(document).ready(function() {
	$('.test_type_checkbox').change( function() {
		toggle_mlist(this);
	});
});
		
function toggle_mlist(elem)
{
	var target_div = elem.name+"_mlist";
	if(elem.checked == true)
	{
		$('#'+target_div).show();
	}
	else
	{
		$('#'+target_div).hide();
	}
}

function submit_worksheet_form()
{
	$('#worksheet_submit_progress').show();
	$('#custom_worksheet_form').submit();
}

function get_test_boxes()
{
	var cat_code = $('#cat_code').attr("value");
	var url_string = 'ajax/worksheet_custom_fetchsection.php?lid=<?php echo $lab_config->id; ?>&cat='+cat_code;
	$('#test_boxes_progress').show();
	$('#test_boxes').load( url_string, function() {
		$('#test_boxes_progress').hide();
		$('.test_type_checkbox').change( function() {
			toggle_mlist(this);
		});
	});
}

function add_another_uf()
{
	var html_code = "<input type='text' name='uf_name[]' class='uniform_width'></input> <input type='text' name='uf_width[]' size='2' value='<?php echo CustomWorksheet::$DEFAULT_WIDTH; ?>'></input><br>";
	$('#uf_list_box').append(html_code);
}

</script>
<form id='custom_worksheet_form' name='worksheet_custom_form' action='worksheet_custom_add.php' method='post'>
	<?php $page_elems->getNewCustomWorksheetForm($lab_config); ?>
</form>
<?php include("includes/footer.php"); ?>