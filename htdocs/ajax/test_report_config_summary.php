<?php
/**
 * Created by PhpStorm.
 * User: SaiTeja
 * Date: 9/15/2016
 * Time: 7:01 PM
 */

include("../includes/db_lib.php");
include("../includes/page_elems.php");

LangUtil::setPageId("lab_config_home");
$page_elems = new PageElems();

$lab_config_id = $_REQUEST['id'];
$test_type = TestType::getById($_REQUEST['ttype']);

?>
<b><?php echo $test_type->getName()." Test Aggregate Report Summary"; ?></b>
| <a href='javascript:edit_test_agg_report_conf();'
     id='test_agg_report_edit_link'>
    <?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>
</a>
<br><br>
<div id='test_agg_report_msg' class='clean-orange' style='display:none;width:350px;'>
</div>
<br>
<?php echo $page_elems->getTestAggregateReportSummary($lab_config_id, $test_type); ?>
