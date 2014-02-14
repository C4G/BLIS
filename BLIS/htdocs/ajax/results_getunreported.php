<?php
#
# Fetches form containing unreportes specimens
# Called via Ajax from results_entry.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
LangUtil::setPageId("results_entry");

$page_elems = new PageElems();
?>
<?php 
$form_name = 'report_results_form';
$form_id = $form_name;
$specimen_list = Specimen::getUnreported();
if($specimen_list == null || count($specimen_list) == 0)
{
	?>
	<div class='sidetip_nopos'>
	<?php echo $pageTerms['TIPS_NOUNREPORTEDFOUND']; ?>
	</div>
	<?php
}
else
{
	?>
	<div id='report_results_form_div'>
	<form name='<?php echo $form_name; ?>' id='<?php echo $form_id; ?>' 
		action='ajax/results_markasreported.php' method='post'>
	<?php $page_elems->getReportResultsForm($form_name, $form_id); ?>
	<input type='button' value='<?php echo LangUtil::$pageTerms['CMD_MARKASREPORTED']; ?>' onclick='javascript:mark_reported();'></input>
	&nbsp;&nbsp;&nbsp;
	<span id='report_results_progress_div' style='display:none;'>
		<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
	</span>
	</form>
	</div>
	<div id='report_results_confirm' class='sidetip' style='display:none;'>
		<?php echo LangUtil::$pageTerms['TIPS_MARKEDREPORTED']; ?>
	</div>
<?php
}
?>