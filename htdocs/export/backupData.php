<?php
require_once("./backup_lib.php");
require_once("../encryption/keys.php");
require_once("../includes/composer.php");
require_once("../includes/db_lib.php");
require_once("../includes/features.php");
require_once("../includes/lab_config.php");
require_once("../includes/platform_lib.php");
require_once("../includes/user_lib.php");
require_once("redirect.php");

putUILog('backup_data', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
session_start();
if ($SERVER == $ON_ARC) {
    # System on arc2 server: Do not allow backup option
    echo "Sorry, data backup option is not available in online version.";
}
//AS changed lab config fix.

$user = get_user_by_id($_SESSION['user_id']);
$user_lab_config_id = $user->labConfigId;
$lab_config_id = $_REQUEST['labConfigId'];

if ($user_lab_config_id != $lab_config_id && !is_super_admin($user) && !is_country_dir($user)) {
    echo "You do not have permission to back up lab #$lab_config_id!";
    return;
}

$lab_config = LabConfig::getById($lab_config_id);
db_change($lab_config->dbName);

$encryption_enabled = $lab_config->backup_encryption_enabled;

$keyContents = false;
if ($encryption_enabled) {
    $key_id = $_REQUEST["keySelectDropdown"];

    $key = Key::find($key_id);
    if (!$key) {
        $log->error("Could not find public key ID $key_id");
    } else {
        if($key->type != Key::$PUBLIC) {
            $log->error("Attempting to backup data with a keypair instead of a public key. Key ID: $key_id");
        }
        $keyContents = $key->data;
    }
}

$backup_path = BackupLib::performBackup($lab_config_id, true, $keyContents);

if (Features::lab_config_v2_enabled()) {

    require_once(__DIR__."/../config/v2/lib/backup.php");
    $lab_config_backups_path = "/config/v2/lab_config_backups.php?id=$lab_config_id";

    $base = basename($backup_path);
    $oldpath = realpath(__DIR__."/../../files/backups/$base");
    $relpath = "storage/$base";
    $newpath = __DIR__."/../../files/$relpath";

    if (!rename($oldpath, $newpath)) {
        $_SESSION["FLASH"] = "Could not move $oldpath to $newpath.";
        header("Location: $lab_config_backups_path");
        exit;
    }

    try {
        db_change("blis_$lab_config_id");
        Backup::insert($lab_config_id, $base, $relpath);

        $_SESSION["FLASH"] = "Lab backup completed successfully.";
    } catch (Exception $e) {
        $_SESSION["FLASH"] = "Lab backup was unsuccessful: " . $e->getMessage();
    }

    header("Location: $lab_config_backups_path");
    exit;
} else {
    echo "Download the below zip of the backup and save it to your disk. <br/><a href='/export/backups/".basename($backup_path)."'/>Download Zip</a>";
}
