<?php

include("../includes/db_lib.php");
include("globals.php");

$option = $_REQUEST['op'];

if($option == 0)
{
    apc_clear_cache('user');
    echo "Cache Cleared";
}
else
{
apc_clear_cache('user');

$uiLog = new UILog();
$csvdat = $uiLog->readUILog('2.2');
apc_add('csvdata', $csvdat);

$ids = array();

foreach($csvdat as $csv)
{
    array_push($ids, $csv[1]);
}     
$counts = array_count_values($ids);

$u_ids = array_unique($ids);
apc_add('idlist', $u_ids);

$classes = array(
    /*"reports",
    "registration",
    "results",
    "search",
    "inventory",
    "catalog",
    "config",
    "export",
    "misc"*/
);

$classes["reports"] = array("reports","reports_onetesthistory","reports_test_count_grouped","reports_testhistory","reports_user_stats_all","reports_user_stats_individual",);
$classes["registration"] = array("new_patient","new_specimen","patient_add","patient_profile");
$classes["results"] = array("specimen_add","specimen_info");
$classes["search"] = array("search","find_patient","search_p","doctor_register");
$classes["inventory"] = array("add_new_stock","edit_lot","edit_stock","inv_new_reagent","inv_new_stock","stock_lots","stock_use","use_stock","view_stock","view_stocks");
$classes["catalog"] = array("catalog","test_type_add","test_type_edit","test_type_new","test_type_update");
$classes["config"] = array("lab_config_add","lab_config_home","lab_config_new");
$classes["export"] = array("export_excel","export_word");
$classes["misc"] = array("");

apc_add('classes', $classes);

echo "Log file Loaded!";
}
?>
