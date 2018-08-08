<?php
/**
 * Created by PhpStorm.
 * User: SaiTeja
 * Date: 9/15/2016
 * Time: 12:01 PM
 */

include("../includes/db_lib.php");
include("../includes/page_elems.php");

LangUtil::setPageId("lab_config_home");
$page_elems = new PageElems();

$lab_config_id = $_REQUEST["id"];
$test_id = $_REQUEST["ttype"];

$test_type = TestType::getById($test_id);
?>
<b><?php echo $test_type->name." Test Aggregate Report Configuration"; ?></b>
| <a href='javascript:cancel_test_agg_report_conf();'
     id='test_agg_report_edit_link'>
    <?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>
</a>
<br><br>
<div id='test_agg_report_msg' class='clean-orange' style='display:none;width:350px;'>
</div>
<br>

<form id='test_agg_report_form' name='test_agg_report_form'
      action='ajax/test_agg_report_config_update.php' method='post'>
    <?php
    $page_elems->getTestAggregateReportConfigureForm($lab_config_id, $test_type);
    ?>
</form>


