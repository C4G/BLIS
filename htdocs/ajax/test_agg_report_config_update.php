<?php
/**
 * Created by PhpStorm.
 * User: SaiTeja
 * Date: 9/16/2016
 * Time: 12:51 AM
 */
include("../includes/db_lib.php");

$lab_config_id = $_REQUEST['lab_config_id'];
$test_type_id = $_REQUEST['test_type_id'];

$test_type = TestType::getById($test_type_id);
$test_report_config_count = new TestAggReportConfig();

$test_report_config_count->title = $test_type->name;
$test_report_config_count->test_type_id = $test_type_id;
$test_report_config_count->group_by_age = $_REQUEST['groupby_age_toggle_count'];
$test_report_config_count->age_unit = $_REQUEST['age_unit_choice_count'];

$age_lower_limits = $_REQUEST['age_limit_lower_count'];
$age_upper_limits = $_REQUEST['age_limit_upper_count'];
$age_groups = "";

for ($i = 0; $i < count($age_lower_limits); $i++)
{
    if (
        trim($age_lower_limits[$i]) == "" ||
        trim($age_upper_limits[$i]) == "" ||
        is_nan($age_lower_limits[$i]) ||
        (trim($age_upper_limits[$i]) != '+' && is_nan($age_upper_limits[$i]))
    )
        continue;

    $age_groups .= $age_lower_limits[$i]."-".$age_upper_limits[$i];
    if ($i < count($age_lower_limits) - 1)
        $age_groups .= ',';
}
$test_report_config_count->age_groups = $age_groups;
$test_report_config_count->report_type = 1;

# Site test aggregate report
$test_report_config_site = new TestAggReportConfig();

$test_report_config_site->title = $test_type->name;
$test_report_config_site->test_type_id = $test_type_id;
$test_report_config_site->group_by_age = $_REQUEST['groupby_age_toggle_site'];
$test_report_config_site->age_unit = $_REQUEST['age_unit_choice_site'];

$age_lower_limits = $_REQUEST['age_limit_lower_site'];
$age_upper_limits = $_REQUEST['age_limit_upper_site'];
$age_groups = "";

for ($i = 0; $i < count($age_lower_limits); $i++)
{
    if (
        trim($age_lower_limits[$i]) == "" ||
        trim($age_upper_limits[$i]) == "" ||
        is_nan($age_lower_limits[$i]) ||
        (trim($age_upper_limits[$i]) != '+' && is_nan($age_upper_limits[$i]))
    )
        continue;

    $age_groups .= $age_lower_limits[$i]."-".$age_upper_limits[$i];
    if ($i < count($age_lower_limits) - 1)
        $age_groups .= ',';
}
$test_report_config_site->age_groups = $age_groups;
$test_report_config_site->report_type = 2;

TestAggReportConfig::updateRecord($lab_config_id, $test_report_config_count);
TestAggReportConfig::updateRecord($lab_config_id, $test_report_config_site);
?>

