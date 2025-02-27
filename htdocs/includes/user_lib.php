<?php
//
// (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
// Contains functions for managing user roles, privileges and logging
//

require_once(__DIR__."/../lang/lang_util.php");

//list of access rights
$access_rights=array(
"addUserLog.php"=>"~CD~SA~A~R~RP~",
"add_country_level_measures.php"=>"~CD~SA~",
"add_country_level_specimens.php"=>"~CD~SA~",
"add_country_level_tests.php"=>"~CD~SA~",
"add_country_level_test_categories.php"=>"~CD~SA~",
"add_currency_rate.php"=>"~CD~SA~",
"add_stock.php"=>"~CD~SA~A~",
"batch_results_form_fetch.php"=>"~R~CD~SA~A~",
"batch_results_form_row.php"=>"~R~CD~SA~A~",
"billing_update.php"=>"~SA~CD~",
"catalog_deletedata.php"=>"~A~CD~SA~",
"cfield_add.php"=>"~CD~SA~A~",
"cfield_update.php"=>"~CD~SA~A~",
"check_user_exists.php"=>"~CD~SA~",
"createconfigfile.php"=>"~CD~SA~",
"daily_num_update.php"=>"~RG~CD~SA~A~",
"daily_prevalance.php"=>"~CD~SA~A~RP~",
"deleteDHIMS2Config.php"=>"~CD~SA~",
"delete_currency_rate.php"=>"~CD~SA~",
"delete_patient.php"=>"~RG~CD~SA~A~",
"delete_specimen.php"=>"~CD~SA~RG~",
"delete_test.php"=>"~CD~SA~RG~",
"DHIMS2conf_add.php"=>"~CD~SA~",
"doctor_ofield_update.php"=>"~CD~SA~",
"equip_interface_update.php"=>"~SA~CD~",
"fetchUserLog.php"=>"~R~CD~SA~A~RP~",
"fetch_remarks.php"=>"~S~R~CD~SA~A~RG~",
"gender_prevalance.php"=>"~CD~SA~A~",
"general_prevalance.php"=>"~CD~SA~A~",
"getDHIMS2Config.php"=>"~CD~SA~",
"getEquipmentDetails.php"=>"~CD~SA~",
"getTestReferenceRange.php"=>"~CD~SA~",
"getEquipmentProps.php"=>"~CD~A~SA~",
"getSpecimenBarcode.php"=>"~CD~SA~A~S~",
"get_result_count.php"=>"~S~A~SA~CD~RP~",
"get_user_type_options.php"=>"~CD~SA~A~",
"grouped_count_reports_update.php"=>"~CD~SA~",
"import_patient.php"=>"~S~R~RG~SA~A~CD~RP~",
"infection_report_settings_update.php"=>"~A~SA~CD~RP~",
"lab_admin_add.php"=>"~CD~SA~",
"lab_admin_change.php"=>"~CD~SA~",
"lab_admin_delete.php"=>"~CD~SA~",
"lab_admin_update.php"=>"~CD~SA~",
"lab_config_addCurrency.php"=>"~CD~SA~",
"lab_config_delete.php"=>"~CD~SA~",
"lab_config_miscupdate.php"=>"~CD~SA~",
"lab_config_search.php"=>"~A~CD~SA~",
"lab_config_tat_update.php"=>"~CD~A~SA~",
"lab_user_add.php"=>"~CD~SA~A~",
"lab_user_delete.php"=>"~CD~SA~",
"lab_user_type_add.php"=>"~CD~SA~A~",
"lab_user_type_delete.php"=>"~CD~SA~",
"lab_user_type_update.php"=>"~CD~SA~A~",
"lab_user_update.php"=>"~CD~SA~A~",
"locations_bytests.php"=>"~CD~SA~A~RP~",
"measure_autocomplete.php"=>"~R~S~CD~SA~A~",
"monthly_prevalance.php"=>"~CD~SA~A~RP~",
"ofield_update.php"=>"~CD~SA~",
"patient_add.php"=>"~RG~SA~A~CD~",
"patient_add_custom.php"=>"~RG~SA~A~CD~",
"patient_check_id.php"=>"~RG~SA~A~CD~",
"patient_check_name.php"=>"~RG~SA~A~CD~",
"patient_check_surr_id.php"=>"~RG~SA~A~CD~",
"patient_data_dynamic_expansion.php"=>"~RG~SA~A~CD~",
"patient_data_page.php"=>"~RG~SA~A~CD~S~",
"patient_info.php"=>"~RG~SA~A~CD~",
"patient_prompt_match.php"=>"~RG~SA~A~CD~",
"patient_update.php"=>"~S~SA~A~CD~",
"preport_checkboxes.php"=>"~CD~SA~A~RP~",
"print_unverified_update.php"=>"~CD~SA~",
"process-field-ordering.php"=>"~CD~SA~A~",
"remarks_form_fetch.php"=>"~CD~SA~A~",
"reports_specimen_entries.php"=>"~CD~SA~A~RP~",
"report_agg_update.php"=>"~CD~SA~A~RP~",
"report_config_fetch.php"=>"~CD~SA~A~RP~",
"report_config_summary.php"=>"~CD~SA~A~RP~",
"report_config_update.php"=>"~CD~SA~A~RP~",
"report_fields_order.php"=>"~CD~SA~A~RP~",
"results_getunreported.php"=>"~CD~SA~A~R~",
"results_markasreported.php"=>"~CD~SA~A~R~",
"results_verify_do.php"=>"~CD~SA~A~R~",
"result_add.php"=>"~CD~SA~A~S~R~",
"result_data_count.php"=>"~CD~SA~A~R~",
"result_data_count_labsection.php"=>"~CD~SA~A~R~",
"result_data_count_new.php"=>"~CD~SA~A~R~",
"result_data_page.php"=>"~CD~SA~A~R~",
"result_data_page_labsection.php"=>"~CD~SA~A~R~",
"result_data_page_new.php"=>"~CD~SA~A~R~",
"result_entry_patient_dyn.php"=>"~CD~SA~A~R~",
"result_entry_patient_lab_section.php"=>"~CD~SA~A~R~",
"retrieve_deleted.php"=>"~CD~SA~A~",
"search_config_update.php"=>"~CD~SA~",
"search_p.php"=>"~CD~SA~A~RG~S~RP~",
"search_p_dyn.php"=>"~CD~SA~A~S~RP~",
"search_s.php"=>"~CD~SA~A~S~",
"session_num_update.php"=>"~CD~SA~A~RG~",
"site_config_add.php"=>"~CD~SA~",
"site_config_update.php"=>"~CD~SA~",
"specimenbox_add.php"=>"~CD~SA~A~RG~",
"specimentopatient.php"=>"~CD~SA~A~R~",
"specimen_add.php"=>"~CD~SA~A~RG~",
"specimen_aggregate_reports_update.php"=>"~CD~A~SA~RP~",
"specimen_check_id.php"=>"~CD~SA~A~RG~",
"specimen_form_fetch.php"=>"~CD~SA~A~R~S~",
"specimen_name_check.php"=>"~A~CD~SA~",
"specimen_type_update.php"=>"~CD~SA~A~",
"st_types_update.php"=>"~CD~SA~",
"tat_table.php"=>"~CD~A~SA~RP~",
"tat_ttype_daily.php"=>"~CD~A~SA~RP~",
"tat_ttype_monthly.php"=>"~CD~A~SA~RP~",
"tat_ttype_weekly.php"=>"~CD~A~SA~RP~",
"tests_select.php"=>"~CD~A~SA~RP~",
"tests_selectbycat.php"=>"~CD~A~SA~R~RP~",
"test_agg_report_config_update.php"=>"~CD~SA~",
"test_list_by_site.php"=>"~CD~SA~",
"test_report_config_fetch.php"=>"~CD~SA~",
"test_report_config_summary.php"=>"~CD~SA~",
"test_type_name_check.php"=>"~A~CD~SA~",
"test_type_options.php"=>"~CD~SA~A~RG~",
"test_type_update.php"=>"~CD~SA~A~",
"toggle_test_reports.php"=>"~CD~SA~",
"UpdateDoctorNames.php"=>"~CD~SA~A~",
"update_barcode_settings.php"=>"~CD~SA~",
"update_country_level_section.php"=>"~CD~SA~",
"update_country_level_test.php"=>"~CD~SA~",
"userlog_fetch.php"=>"~CD~A~SA~RP~",
"users_select.php"=>"~CD~A~SA~RP~",
"weekly_prevalance.php"=>"~CD~A~SA~RP~",
"worksheet_config_fetch.php"=>"~CD~SA~",
"worksheet_config_summary.php"=>"~CD~SA~",
"worksheet_custom_fetchsection.php"=>"~CD~SA~",
"catalog.php"=>"~A~CD~SA~",
"country_catalog.php"=>"~CD~SA~",
"cfield_edit.php"=>"~CD~A~SA~",
"cfield_new.php"=>"~CD~A~SA~",
"lab_configs.php"=>"~CD~A~SA~",
"lab_config_home.php"=>"~CD~SA~",
"lab_config_new.php"=>"~CD~SA~",
"lab_config_status.php"=>"~CD~SA~",
"update_database.php"=>"~CD~SA~",
"remarks_edit.php"=>"~CD~A~SA~",
"stock_edit.php"=>"~CD~A~SA~",
"stock_management.php"=>"~CD~A~SA~",
"reports.php"=>"~CD~A~SA~RP~",
"reports_userlog.php"=>"~CD~A~SA~RP~",
"update.php"=>"~CD~A~SA~",
"lab_admins.php"=>"~CD~SA~",
"lab_admin_edit.php"=>"~CD~SA~",
"lab_admin_new.php"=>"~CD~SA~",
"lab_user_edit.php"=>"~CD~A~SA~",
"lab_user_new.php"=>"~CD~A~SA~",
"lab_user_type_edit.php"=>"~CD~A~SA~",
"lab_user_type_new.php"=>"~CD~A~SA~",
"switchto_tech.php"=>"~CD~SA~");

// List of known user roles (These could be fetched from DB and populated)
$LIS_TECH_RW = 0;
$LIS_TECH_RO = 1;
$LIS_ADMIN = 2;
$LIS_SUPERADMIN = 3;
$LIS_COUNTRYDIR = 4;
$LIS_CLERK = 5;
$LIS_TECH_SHOWPNAME = 13;
// New user levels for technicians
// Regn, Results, Reports
$LIS_001 = 6;
$LIS_010 = 7;
$LIS_011 = 8;
$LIS_100 = 9;
$LIS_101 = 10;
$LIS_110 = 11;
$LIS_111 = 12;

$LIS_VERIFIER = 15;
$READONLYMODE = 16;
$LIS_PHYSICIAN = 17;
function is_allowed($fname,$rwopts)
{
global $access_rights;
$access_right_label=$access_rights[$fname];
	$rw_option = array ();
	$rw_option =explode ( ',', $rwopts );
$opt_index="";
if($fname=="find_patient.php" || strpos($access_right_label,"RG~")!==false)
$opt_index=$opt_index."2,";
if($fname=="reports.php"|| strpos($access_right_label,"RP~")!==false)
$opt_index=$opt_index."5,";
if($fname=="results_entry.php"  || strpos($access_right_label,"R~")!==false)
$opt_index=$opt_index."3,";
if($fname=="search.php" || strpos($access_right_label,"S~")!==false)
$opt_index=$opt_index."4,";
if($fname=="view_stock.php")
$opt_index=$opt_index."6,";
if($fname=="backupDataUI.php")
$opt_index=$opt_index."7,";
if($opt_index==""&&(strpos($access_right_label,"CD~")!==false||strpos($access_right_label,"SA~")!==false||strpos($access_right_label,"~A~")!==false))
$opt_index=-1; //admin page
if($opt_index=="")
$opt_index="0";
if($opt_index!="0")
{
		if (checkAccess($opt_index, $rw_option ))
{
return true;
}
else
{
return false;
}
}
return true;
}
function checkAccess($opt_index,$rw_option)
{
$opt_index=explode(',',$opt_index);
foreach($opt_index as $o)
{
if($opt_index!="")
{
if(in_array ( $o, $rw_option ))
{
return true;
}
}
}
return false;
}
function get_top_menu_options($user_role, $user_rwoption = "") {
//echo $user_role;
	// Returns list links to php pages accessible by $user_role
	// Called from perms_check.php
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_VERIFIER, $LIS_COUNTRYDIR, $LIS_CLERK, $READONLYMODE, $LIS_PHYSICIAN;
	global $LIS_001, $LIS_010, $LIS_011, $LIS_100, $LIS_101, $LIS_110, $LIS_111, $LIS_TECH_SHOWPNAME;
    global $LIS_SATELLITE_LAB_USER;
	// Global variables from includes/db_constants.php
	global $SERVER, $ON_ARC;
	$page_list = array ();
	$rw_option = array ();
	$page_list [LangUtil::getPageTitle ( "home" )] = "home.php";

	$rw_option = explode ( ',', $user_rwoption );

	if($user_role == $LIS_PHYSICIAN) {
		if (in_array ( "2", $rw_option ))
			$page_list [LangUtil::getPageTitle ( "regn" )] = "doctor_register.php";
		if (in_array ( "3", $rw_option ))
			$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
		if (in_array ( "4", $rw_option ))
			$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
		if (in_array ( "5", $rw_option ))
			$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
		if (in_array ( "6", $rw_option ))
			$page_list ["Inventory"] = "view_stock.php";
		if (in_array ( "7", $rw_option ))
			$page_list [LangUtil::$pageTerms ['MENU_BACKUP']] = "backupDataUI.php?id=" . $id;
	}
    else if ($user_role == $LIS_SATELLITE_LAB_USER) {
        $page_list ["Search"] = "search.php";
    }
	else if ($user_role == $READONLYMODE) {
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
	}
	else if ($user_role == $LIS_CLERK) {
		$page_list [LangUtil::getPageTitle ( "regn" )] = "find_patient.php";
		$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
	}
	else if ($user_role == $LIS_ADMIN) {
		$page_list [LangUtil::getPageTitle ( "lab_config_home" )] = "lab_configs.php";
		$page_list [LangUtil::getPageTitle ( "catalog" )] = "catalog.php";
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
		if ($SERVER != $ON_ARC) {
			if (User::onlyOneLabConfig ( $_SESSION ['user_id'], $_SESSION ['user_level'] )) {
				// Back up data option
				$lab_config_list = get_lab_configs ( $_SESSION ['user_id'] );
				$page_list [LangUtil::$pageTerms ['MENU_BACKUP']] = "backupDataUI.php?id=" . $lab_config_list [0]->id;
			}
		}
	} else if ($user_role == $LIS_SUPERADMIN || $user_role == $LIS_COUNTRYDIR) {
		$page_list [LangUtil::getPageTitle ( "lab_configs" )] = "lab_configs.php";
		$page_list [LangUtil::getPageTitle ( "lab_admins" )] = "lab_admins.php";
		$page_list [LangUtil::getPageTitle ( "catalog" )] = "country_catalog.php";
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
	} else if ($user_role == $LIS_VERIFIER) {
		$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
	}
	else
	{
		if (in_array ( "2", $rw_option ))
			$page_list [LangUtil::getPageTitle ( "regn" )] = "find_patient.php";
		if (in_array ( "3", $rw_option ))
			$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
		if (in_array ( "4", $rw_option ))
			$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
		if (in_array ( "5", $rw_option ))
			$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
		if (in_array ( "6", $rw_option ))
			$page_list ["Inventory"] = "view_stock.php";
		if (in_array ( "7", $rw_option ))
			$page_list [LangUtil::$pageTerms ['MENU_BACKUP']] = "backupDataUI.php?id=" . $id;
	}

	return $page_list;
}
function rand_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
	// Random string generator used by get_random_password()

	// Length of character list
	$chars_length = (strlen ( $chars ) - 1);
	// Start our string
	$string = $chars {rand ( 0, $chars_length )};
	// Generate random string
	for($i = 1; $i < $length; $i = strlen ( $string )) {
		// Grab a random character from our list
		$r = $chars {rand ( 0, $chars_length )};
		// Make sure the same two characters don't appear next to each other
		if ($r != $string {$i - 1})
			$string .= $r;
	}
	// Return the string
	return $string;
}
function get_random_password() {
	// Generates a random string as new user password
	$string = rand_str ( 7 );
	return $string;
}
function is_admin($user) {
	// Returns true for admin and superadmin level users
	global $LIS_VERIFIER, $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_CLERK, $LIS_TECH_SHOWPNAME, $LIS_COUNTRYDIR, $LIS_PHYSICIAN;
/*	if ($user->level == $LIS_TECH_RO || $user->level == $LIS_TECH_RW || $user->level == $LIS_CLERK || $user->level == $LIS_TECH_SHOWPNAME || $user->level == $LIS_VERIFIER || $user->level == $LIS_PHYSICIAN)
		return false;
	return true;*/
if($user->level==$LIS_ADMIN||$user->level==$LIS_SUPERADMIN||$user->level==$LIS_COUNTRYDIR)
return true;
return false;
}
function is_super_admin($user) {
	// Returns true for superadmin level users only
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN;
	if ($user->level == $LIS_SUPERADMIN)
		return true;
	return false;
}
function is_country_dir($user) {
	// Returns true for superadmin level users only
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_COUNTRYDIR;
	if ($user->level == $LIS_COUNTRYDIR)
		return true;
	return false;
}

function is_satellite_lab_user($user) {
	global $LIS_SATELLITE_LAB_USER;
	if ($user->level == $LIS_SATELLITE_LAB_USER)
		return true;
	return false;
}

function get_level_name($level_code) {
	// Returns string containing user-level
	global $LIS_PHYSICIAN, $READONLYMODE, $LIS_001, $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_VERIFIER, $LIS_COUNTRYDIR, $LIS_CLERK, $LIS_TECH_SHOWPNAME;
	// echo "Level Code = ".$level_code."-".$LIS_VERIFIER;
	switch ($level_code) {
		case $LIS_TECH_RW :
			return LangUtil::$generalTerms ['LAB_TECH'];
			break;
		case $LIS_TECH_SHOWPNAME :
			return LangUtil::$generalTerms ['LAB_TECH'];
			break;
		case $LIS_TECH_RO :
			return LangUtil::$generalTerms ['LAB_TECH'];
			break;
		case $LIS_ADMIN :
			return LangUtil::$generalTerms ['LAB_MGR'];
			break;
		case $LIS_SUPERADMIN :
			return "BLIS Super-admin";
			break;
		case $LIS_COUNTRYDIR :
			return LangUtil::$generalTerms ['LAB_DIR'];
			break;
		case $LIS_CLERK :
			return LangUtil::$generalTerms ['LAB_RECEPTIONIST'];
			break;
		case $LIS_VERIFIER :
			{
				$verifier = "Verifier";
				return $verifier;
				break;
			}
		case $READONLYMODE :
			{
				$readOnly = "Read Only";
				return $readOnly;
				break;
			}
		case $LIS_001 :
			{
				$receptionist = "Lab Receptionist";
				return $receptionist;
				break;
			}
		case $LIS_PHYSICIAN :
			{
				return "Doctor";
			}
		case 7:{
			return "LIS_010";
		}
		case 8:{
			return "LIS_011";
		}
		case 9:{
			return "LIS_100";
		}
		case 10:{
			return "LIS_101";
		}
		case 11:{
			return "LIS_110";
		}
		case 12:{
			return "LIS_111";
		}
		case 14:{
			return "LIS_TECH_RW";
		}
	}
}
?>
