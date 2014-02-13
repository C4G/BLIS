<?php
#
# Shows summary/confirmation for report configuration
# Called via Ajax lab_config_home.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");

LangUtil::setPageId("lab_config_home");
$page_elems = new PageElems();

$lab_config_id = $_REQUEST['l'];
$report_type = $_REQUEST['rt'];

$lab_config = LabConfig::getById($lab_config_id);
if($lab_config == null)
{
	?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['MSG_NOTFOUND'] ?>
	</div>
	<?php
	return;
}

$report_config = $lab_config->getReportConfig($report_type);
?>
<div class='pretty_box'>
	<?php $page_elems->getReportConfigSummary($report_config); ?>
</div>