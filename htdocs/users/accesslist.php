<?php

include_once("../includes/db_lib.php");

# List of known user roles (These could be fetched from DB and populated)
$LIS_TECH_RW = 0;
$LIS_TECH_RO = 1;
$LIS_ADMIN = 2;
$LIS_SUPERADMIN = 3;
$LIS_COUNTRYDIR = 4;
$LIS_CLERK = 5;

function isSuperAdmin($user) {
	# Returns true for superadmin level users only
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN;
	if($user->level == $LIS_SUPERADMIN)
		return true;
	return false;
}

function isCountryDir($user) {
	# Returns true for country director level users only
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_COUNTRYDIR;
	if($user->level == $LIS_COUNTRYDIR)
		return true;
	return false;
}

function isAdmin($user) {
	# Returns true for admin level 
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_COUNTRYDIR;
	if($user->level == $LIS_ADMIN)
		return true;
	return false;
}


function isLoggedIn($user){
    if($user->level != "")
		return true;
	return false;
}

function displayForbiddenMessage() {
	echo "<b><font size='6px'>Forbidden</b></font><br><br>";
	echo "You don't have permission to access ".basename($_SERVER['PHP_SELF'])." on this server";
	die();
}

$countryDirPageList = array();
array_push($countryDirPageList, 'lab_configs.php', 'lab_config_new.php', 'update_database.php', 'update.php', 'lab_config_status.php','st_types_update.php', 'remarks_edit.php', 'lab_config_home.php',
'switchto_tech.php', 'lab_admins.php', 'lab_admin_edit.php', 'lab_admin_new.php', 'country_catalog.php', 'reports.php', 'stock_management.php', 'stock_edit.php','lab_config_tat_update.php', 
'lab_user_new.php', 'lab_user_type_new.php', 'reports_userlog.php', 'lab_user_edit.php','lab_user_type_edit.php', 'ofield_update.php', 'doctor_ofield_update.php', 'search_config_update.php', 'cfield_new.php', 'cfield_edit.php','worksheet_custom_fetchsection.php','worksheet_config_summary.php','worksheet_config_fetch.php','weekly_prevalance.php','users_select.php','userlog_fetch.php','update_barcode_settings.php','toggle_test_reports.php','tests_selectbycat.php','tests_select.php','test_report_config_summary.php','test_report_config_fetch.php','test_list_by_site.php','test_agg_report_config_update.php','tat_ttype_weekly.php','tat_ttype_monthly.php','tat_ttype_daily.php','tat_table.php','st_types_update.php','specimen_aggregate_reports_update.php');

$adminPageList = array();
array_push($adminPageList, 'lab_configs.php', 'catalog.php', 'reports.php', 'update.php', 'st_types_update.php', 'remarks_edit.php', 'lab_config_tat_update.php',
'stock_management.php', 'stock_edit.php', 'lab_user_new.php', 'lab_user_type_new.php', 'reports_userlog.php', 'lab_user_edit.php', 'lab_user_type_edit.php', 'ofield_update.php', 'doctor_ofield_update.php','search_config_update.php', 'cfield_new.php', 'cfield_edit.php','worksheet_custom_fetchsection.php','worksheet_config_summary.php','worksheet_config_fetch.php','weekly_prevalance.php','users_select.php','userlog_fetch.php','update_barcode_settings.php','toggle_test_reports.php','tests_selectbycat.php','tests_select.php','test_type_name_check.php','test_report_config_summary.php','test_report_config_fetch.php','test_list_by_site.php','test_agg_report_config_update.php','tat_ttype_weekly.php','tat_ttype_monthly.php','tat_ttype_daily.php','tat_table.php','st_types_update.php','specimen_name_check.php','specimen_aggregate_reports_update.php');

$superAdminPageList = array();
array_push($superAdminPageList, 'lab_configs.php', 'lab_config_new.php', 'update_database.php', 'update.php', 'lab_config_status.php','st_types_update.php', 'lab_config_home.php',
'switchto_tech.php', 'lab_admins.php', 'lab_admin_edit.php', 'lab_admin_new.php', 'country_catalog.php', 'reports.php', 'stock_management.php', 'stock_edit.php', 
'lab_user_new.php', 'lab_user_type_new.php', 'reports_userlog.php', 'lab_user_edit.php','lab_user_type_edit.php', 'ofield_update.php','doctor_ofield_update.php', 'search_config_update.php', 'cfield_new.php', 'cfield_edit.php','worksheet_custom_fetchsection.php','worksheet_config_summary.php','worksheet_config_fetch.php','weekly_prevalance.php','users_select.php','userlog_fetch.php','update_barcode_settings.php','toggle_test_reports.php','tests_selectbycat.php','tests_select.php','test_report_config_summary.php','test_report_config_fetch.php','test_list_by_site.php','test_agg_report_config_update.php','tat_ttype_weekly.php','tat_ttype_monthly.php','tat_ttype_daily.php','tat_table.php','st_types_update.php','specimen_aggregate_reports_update.php');

?>