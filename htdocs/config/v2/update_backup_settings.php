<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Download a lab backup, with access control.
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/lib/backup.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$lab_config_id = $_REQUEST['id'];
$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
db_change($lab['db_name']);

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    // If the user is not a super admin or country director, they should only
    // be able to access data for their own lab, and only if they are an admin.
    if ($lab_config_id == $current_user->labConfigId && is_admin($current_user)) {
        $unauthorized = false;
    }
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header("Location: /home.php");
    exit;
}

require_once(__DIR__."/../../includes/keymgmt.php");

if ($_POST["settings_encryption_enabled"] == "on") {
    KeyMgmt::write_enc_setting(1);
} else {
    KeyMgmt::write_enc_setting(0);
}

$_SESSION['FLASH'] = "Settings updated successfully.";

header("Location: lab_config_backup_settings.php?id=$lab_config_id");
