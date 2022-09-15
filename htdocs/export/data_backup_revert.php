<?php
#
# Reverts to a previous backup of data
# Called via POST from lab_config_home.php
# Redirects back after revert complete
#
require_once("../export/backup_lib.php");
require_once("../includes/db_constants.php");
require_once("../includes/platform_lib.php");

function page_redirect($is_done)
{
    $url_string = "lab_config_home.php?id=".$_REQUEST['lid'];
    if ($is_done === true) {
        $url_string .= "&revert=1";
    } else {
        $url_string .= "&revert=0";
    }
    header("Location:".$url_string);
}

function decryptFile($fname, $pvt)
{
    global $log;

    $log->info("Attempting to decrypt $fname with $pvt");

    if (!file_exists($fname.".key") || !file_exists($pvt)) {
        error_log("Both of these files must exist but at least one does not: $fname.key, $pvt");
        return false;
    }

    $private_key_id = openssl_get_privatekey(file_get_contents($pvt));
    $env_key=file_get_contents($fname.".key");
    $env_key=base64_decode($env_key);

    $sealed=file_get_contents($fname);
    $open = '';
    $res = openssl_open($sealed, $open, $env_key, $private_key_id);
    openssl_free_key($private_key_id);

    if (!$res) {
        $log->error("Could not decrypt $fname with $fname.key: " . openssl_error_string());
        return false;
    }

    file_put_contents($fname.".dec", $open);

    // Return the filename of the decrypted file
    return $fname.".dec";
}

/**
 * Imports data from a .sql file into the given database.
 */
function restoreFile($fname, $dbname) {
    global $log, $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS;

    $mysqlExePath = PlatformLib::mySqlClientPath();
    $command = $mysqlExePath." -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $dbname < ".escapeshellarg($fname);
    if (PlatformLib::runningOnWindows()) {
        // the C: is an apparently useless command to prevent the original command from failing because of having more than 2 double quotes
        $command = "C: &".$command;
    }

    $output = system($command, $return);

    if ($return != 0) {
        $log->error("Could not restore MySQL database; command: $command, err code: $return, output:\n $output");
    }

    return $return;
}

function endsWith($haystack, $needle)
{
    return substr($haystack, -strlen($needle)) === $needle;
}

$saved_session = SessionUtil::save();

$is_done = false;
$lab_config_id = $_REQUEST['lid'];
$backup_folder = $_REQUEST['backup_path'];
# Include langdata folder in backup revert?
$do_langdata = false;
if ($_REQUEST['do_lang'] == 'Y') {
    $do_langdata = true;
}

# Perform backup of current version before reverting?
$do_currbackup = false;
if ($_REQUEST['do_currbackup'] == 'Y') {
    $do_currbackup = true;
}

if ($do_currbackup === true) {
    // The Current Lab key is used since we are backing up this lab
    $labKeyFile = KeyMgmt::pathToKey("LAB_$lab_config_id"."_pubkey.blis");
    if (!file_exists($labKeyFile)) {
        // generate key
        KeyMgmt::generateKeyPair(
            dirname(__FILE__) . "/../../files/LAB_".$lab_config_id.".blis",
            $labKeyFile
        );
        $log->info("Keypair generated successfully.");
    }
    $keyContents = file_get_contents($labKeyFile);
    if (!BackupLib::performBackup($lab_config_id, true, $keyContents)) {
        # Backup of current version failed.
        $log->error("Backup failed!");
        page_redirect(false);
    }
}

$restored_from_zip = false;
if (endsWith($backup_folder, ".zip")) {
    // A BLIS 3.8+ backup zip file was specified, so we have to unzip it.
    $zip_path = __DIR__ . "/../../files/backups/$backup_folder";
    $pathinfo = pathinfo($zip_path);
    $unzip_path = dirname($zip_path) . "/" . $pathinfo['filename'];
    mkdir($unzip_path);
    $log->info("Unzipping $zip_path to $unzip_path");
    
    $zip = new ZipArchive;
    $res = $zip->open($zip_path);
    if ($res === TRUE) {
        $zip->extractTo($unzip_path);
        $zip->close();
        $log->info("$zip_path unzipped successfully!");
        // Now that the zip file is unzipped, we can set $backup_folder to the unzipped files and proceed.
        $backup_folder = $unzip_path;
        // Set this flag to indicate this backup came from a zip file (and thus can be deleted later)
        $restored_from_zip = true;
    } else {
        $log->error("Could not open $zip_path!");
        // We have to return here since we can't complete successfully.
        page_redirect(false);
    }
} else {
    // If backup_folder is an old-style folder backup, prepend it with the path to the main BLIS folder.
    $mainBlisDir = __DIR__ . "/../../";
    $backup_folder = $mainBlisDir . $backup_folder;
}

$pvt=KeyMgmt::pathToKey("LAB_$lab_config_id.blis");

$blisLabBackupFilePath = $backup_folder."/blis_".$lab_config_id."/blis_".$lab_config_id."_backup.sql";

// Attempt to decrypt file
$decrypted_file = decryptFile($blisLabBackupFilePath, $pvt);
if (!!$decrypted_file) {
    $blisLabBackupFilePath = $decrypted_file;
}

$return = restoreFile($blisLabBackupFilePath, "blis_$lab_config_id");

if (!!$decrypted_file) {
    unlink($decrypted_file);
}

echo $return;

$blisBackUpFilePath = $backup_folder."/blis_revamp/blis_revamp_backup.sql";
$decrypted_file = decryptFile($blisBackUpFilePath, $pvt);
if (!!$decrypted_file) {
    $blisBackUpFilePath = $decrypted_file;
}
$return = restoreFile($blisBackUpFilePath, "blis_revamp");

if (!!$decrypted_file) {
    unlink($decrypted_file);
}

echo $return;

$langdata_dir = $backup_folder."/langdata_".$lab_config_id;

if ($do_langdata === true) {
    $log->info("Copying $langdata_dir to local/langdata_$lab_config_id");
    PlatformLib::copyDirectory($langdata_dir, __DIR__."/../../local/");
}

if ($restored_from_zip) {
    PlatformLib::removeDirectory($backup_folder);
}

# All done
SessionUtil::restore($saved_session);
page_redirect(true);
