<?php

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList))
    && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList))
    && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) ) {
	#displayForbiddenMessage();
}

$lab_config_id = $_REQUEST['lid'];
$lab_config = LabConfig::getById($lab_config_id);

if($lab_config == null)
	return;

if ($_REQUEST['enable_billing']) {
    $billing_enabled = 1;
} else {
    $billing_enabled = 0;
}

update_billing_config($billing_enabled, $lab_config_id);
?>
