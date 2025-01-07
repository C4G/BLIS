<?php

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/user_lib.php");

db_change("blis_revamp");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$lab_config_id = $_REQUEST['lab_config_id'];

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    // If the user is not a super admin or country director, they should only
    // be able to update their own lab, and only if they are an admin.
    if ($lab_config_id == $current_user->labConfigId && is_admin($current_user)) {
        $unauthorized = false;
    }
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header("Location: /home.php");
    exit;
}

$lc_id = db_escape($lab_config_id);
$query = "UPDATE lab_config SET blis_cloud_hostname = NULL, blis_cloud_connection_key = NULL, blis_cloud_server_pubkey_id = NULL WHERE lab_config_id = $lc_id";
query_update($query);

$_SESSION['FLASH'] = "Successfully disconnected from cloud.";

header("Location: /lab_config_home.php?id=$lab_config_id");
