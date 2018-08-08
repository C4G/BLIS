<?php
/**
 * Created by PhpStorm.
 * User: SaiTeja
 * Date: 9/16/2016
 * Time: 11:37 AM
 */

include('redirect.php');
include('../includes/db_lib.php');
include('../includes/stats_lib.php');
include('../includes/script_elems.php');
include('../includes/page_elems.php');
include('../users/accesslist.php');

LangUtil::setPageId('reports');

if(!(isLoggedIn(get_user_by_id($_SESSION['user_id']))))
    header('Location: home.php');

$script_elems = new ScriptElems();
$script_elems->enableJQuery();

$page_elems = new PageElems();

$db_details = explode('_', db_get_current());
$lab_config_id = $db_details[1];
$lab_config = LabConfig::getById($lab_config_id);

$test_id = $_REQUEST['select_test_for_report'];
$test = TestType::getById($test_id);

$site = $_REQUEST['select_site_for_report'];
$report_type = "";

if ($site == LangUtil::$pageTerms['ALL_SITES'])
{
    $report_type = LangUtil::$pageTerms['COUNT_REPORT'];
    $report_type_code = 1;
    $test_report_config = TestAggReportConfig::getByTestTypeId($lab_config_id,
        $test_id, $report_type_code);
} else {
    $report_type = LangUtil::$pageTerms['SITE_REPORT'];
    $report_type_code = 2;
    $test_report_config = TestAggReportConfig::getByTestTypeId($lab_config_id,
        $test_id, $report_type_code);
}
?>


<script type="text/javascript">
    function export_as_word() {
        var html_data = $('#report_content').html();
        $('#word_data').attr('value', html_data);
        $('#word_format_form').submit();
    }

    function print_content(div_id) {
        var document_container = document.getElementById(div_id);
        var window_object = window.open('', 'PrintWindow', 'toolbars=no,scrollbars=yes,status=no,resizable=yes');
        window_object.document.write(document_container.innerHTML);
        window_object.document.close();
        window_object.focus();
        window_object.print();
        window_object.close();
    }
</script>

<form name="word_format_form" id="word_format_form"
      action="../export/export_word_aggregate.php" method="post"
      target="_blank">
    <input type="hidden" name="data" value="" id="word_data">;
    <input type="hidden" name="report_type" value="test_aggregate_report"
           id="report_type">
    <input type="button" onclick="print_content('report_content');"
           value="<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>">
    <input type="button" onclick="export_as_word();"
           value="<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>">
    <input type="button" onclick="window.close();"
           value="<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>">
</form>
<br>

<div id="report_content">
    <link rel="stylesheet" type="text/css" href="../css/table_print.css">
    <b><font size="5"><?php echo $test->name. " ". $report_type; ?></font> </b>

<br><br>
<font size="3.5">
    <?php
    $date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
    $date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
    $ui_info = "from=".$date_from."&to=".$date_to;
    putUILog('test_agg_report', $ui_info, basename($_SERVER['REQUEST_URI'], '.php'), 'X', 'X', 'X');
    echo LangUtil::$pageTerms['REPORT_PERIOD'].": ";

    if($date_from == $date_to)
        echo DateLib::mysqlToString($date_from);
    else
        echo DateLib::mysqlToString($date_from)." to ".DateLib::mysqlToString($date_to);

    echo "<br>";
    echo "Laboratory: ".$lab_config->name;
    echo "<br>";

    if ($report_type_code == 1)
        $page_elems->showAggregateCountReport($lab_config, $test, $test_report_config);
    elseif ($report_type_code == 2)
        $page_elems->showAggregateSiteReport($site, $test, $test_report_config);
    ?>
    <br>

</font>
</div>
