<?php
#
# Show confirmation page for addition of new cusotm worksheet
#

include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("lab_config_home");

$lab_config_id = $_REQUEST['lid'];
$worksheet_id = $_REQUEST['wid'];

$lab_config = LabConfig::getById($lab_config_id);
if($lab_config == null)
{
	echo LangUtil::$generalTerms['MSG_NOTFOUND']; 
}
$worksheet = CustomWorksheet::getById($worksheet_id, $lab_config);
if($worksheet == null)
{
	echo LangUtil::$generalTerms['MSG_NOTFOUND']; 
}
else
{
?>
<br>
<b><?php echo LangUtil::$pageTerms['ADDED_CUSTOMWORKSHEET']; ?></b> |
 <a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>'>&laquo; <?php echo LangUtil::$pageTerms['BACK_TOCONFIG']; ?></a>
<br><br>
<?php
$page_elems->getCustomWorksheetSummary($worksheet);
}
?>
<?php include("includes/footer.php"); ?>
