<?php
#
# Main page for lab configuration added confirmation
#
include("redirect.php");
include("includes/header.php");
?>
<script type='text/javascript'>
function export(labConfigId) {
	alert("wololo!");
	return;
	$('#currentExporting').show();
	$.ajax({
		type : 'POST',
		url : 'export/exportLabConfiguration.php?id='+labConfigId,
		success : function(data) {
			$('#successfulExport').show();
		}
	});
} 
</script>

<br>
<b><?php echo LangUtil::$generalTerms['LAB_CONFIG_ADDED']; ?></b>
 | <a href='lab_configs.php'>&laquo; Back to Configurations</a>
 | <a href='exportLabConfiguration.php?id=<?php echo $_REQUEST["id"]; ?>'> Export Lab Configuration &raquo; </a></b>
<br><br>

<div id='successfulExport' style='display:none;'>
	<?php echo LangUtil::$generalTerms['SUCCESS_EXPORT']; ?>
</div>

<div id='currentExporting' style='display:none;'>
	<?php echo LangUtil::$generalTerms['PENDING_EXPORT']; ?>
</div>

<?php
$page_elems->getLabConfigInfo($_REQUEST['id']);
include("includes/footer.php");

?>