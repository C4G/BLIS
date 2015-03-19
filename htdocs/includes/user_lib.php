<?php
//
// (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
// Contains functions for managing user roles, privileges and logging
//

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
function get_top_menu_options($user_role, $user_rwoption = "") {
	// Returns list links to php pages accessible by $user_role
	// Called from perms_check.php
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_VERIFIER, $LIS_COUNTRYDIR, $LIS_CLERK, $READONLYMODE, $LIS_PHYSICIAN;
	global $LIS_001, $LIS_010, $LIS_011, $LIS_100, $LIS_101, $LIS_110, $LIS_111, $LIS_TECH_SHOWPNAME;
	// Global variables from includes/db_constants.php
	global $SERVER, $ON_ARC;
	$page_list = array ();
	$rw_option = array ();
	$page_list [LangUtil::getPageTitle ( "home" )] = "home.php";
	
	$rw_option = explode ( ',', $user_rwoption );
	
	// Write Mode starts
	if ($user_role == $LIS_TECH_RW || $user_role == $LIS_001 || $user_role == $LIS_VERIFIER) {
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
	} else if ($user_role == $READONLYMODE) {
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
	} 	
	
	else if($user_role == $LIS_PHYSICIAN) {
		$page_list [LangUtil::getPageTitle ( "regn" )] = "doctor_register.php";
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
	}
	// return $page_list;
	
	else if ($user_role == $LIS_CLERK) {
		$page_list [LangUtil::getPageTitle ( "regn" )] = "find_patient.php";
		$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
	} else if ($user_role == $LIS_TECH_RW || $user_role == $LIS_TECH_SHOWPNAME) {
		$page_list [LangUtil::getPageTitle ( "regn" )] = "find_patient.php";
		$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
		$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
		$page_list ["Inventory"] = "view_stock.php";
		$id = get_lab_config_id ( $_SESSION ['user_id'] );
		if ($id == 0) {
			$lab_config_list = get_lab_configs ( $_SESSION ['user_id'] );
			$id = $lab_config_list [0]->id;
		}
		// $page_list[LangUtil::$pageTerms['MENU_BACKUP']] = "data_backup?id=".$id;
		$page_list [LangUtil::$pageTerms ['MENU_BACKUP']] = "backupDataUI.php?id=" . $id;
	} else if ($user_role == $LIS_TECH_RO || $user_role == $LIS_TECH_SHOWPNAME) {
		$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
	} else if ($user_role == $LIS_ADMIN) {
		// ...
		$page_list [LangUtil::getPageTitle ( "lab_config_home" )] = "lab_configs.php";
		$page_list [LangUtil::getPageTitle ( "catalog" )] = "catalog.php";
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
		if ($SERVER != $ON_ARC) {
			if (User::onlyOneLabConfig ( $_SESSION ['user_id'], $_SESSION ['user_level'] )) {
				// Back up data option
				$lab_config_list = get_lab_configs ( $_SESSION ['user_id'] );
				// $page_list[LangUtil::$pageTerms['MENU_BACKUP']] = "data_backup?id=".$lab_config_list[0]->id;
				$page_list [LangUtil::$pageTerms ['MENU_BACKUP']] = "backupDataUI.php?id=" . $lab_config_list [0]->id;
			}
		}
		// $page_list["Inventory"]="stock_add.php";
		// ...
	} else if ($user_role == $LIS_SUPERADMIN || $user_role == $LIS_COUNTRYDIR) {
		$page_list [LangUtil::getPageTitle ( "lab_configs" )] = "lab_configs.php";
		$page_list [LangUtil::getPageTitle ( "lab_admins" )] = "lab_admins.php";
		$page_list [LangUtil::getPageTitle ( "catalog" )] = "country_catalog.php";
		$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
	} else if ($user_role == $LIS_VERIFIER) {
		$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
	} else if (false) {
		switch ($user_role) {
			case $LIS_001 :
				// Reports only
				$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
				$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
				break;
			case $LIS_010 :
				// Results only
				$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
				$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
				break;
			case $LIS_011 :
				// Results and reports
				$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
				$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
				$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
				break;
			case $LIS_100 :
				// Regn only
				$page_list [LangUtil::getPageTitle ( "regn" )] = "find_patient.php";
				$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
				break;
			case $LIS_101 :
				// Regn and Reports
				$page_list [LangUtil::getPageTitle ( "regn" )] = "find_patient.php";
				$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
				$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
				break;
			case $LIS_110 :
				// Regn and Results
				$page_list [LangUtil::getPageTitle ( "regn" )] = "find_patient.php";
				$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
				$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
				break;
			case $LIS_111 :
				// All three
				$page_list [LangUtil::getPageTitle ( "regn" )] = "find_patient.php";
				$page_list [LangUtil::getPageTitle ( "results_entry" )] = "results_entry.php";
				$page_list [LangUtil::getPageTitle ( "search" )] = "search.php";
				$page_list [LangUtil::getPageTitle ( "reports" )] = "reports.php";
				break;
		}
	}
	// Currently Disabled. Uncomment if required
	// $page_list[LangUtil::getPageTitle("help")] = "help.php";
	
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
	if ($user->level == $LIS_TECH_RO || $user->level == $LIS_TECH_RW || $user->level == $LIS_CLERK || $user->level == $LIS_TECH_SHOWPNAME || $user->level == $LIS_VERIFIER || $user->level == $LIS_PHYSICIAN)
		return false;
	return true;
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
	}
}
?>