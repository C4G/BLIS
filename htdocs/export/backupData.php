<?php
require_once("./backup_lib.php");
require_once("../includes/composer.php");
require_once("../includes/db_lib.php");
require_once("../includes/platform_lib.php");
require_once("redirect.php");

putUILog('backup_data', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
session_start();
if ($SERVER == $ON_ARC) {
    # System on arc2 server: Do not allow backup option
    echo "Sorry, data backup option is not available in online version.";
}
//AS changed lab config fix.

$user = get_user_by_id($_SESSION['user_id']);
$lab_config_id = $user->labConfigId;
$request_lab_config_id = $_REQUEST['labConfigId'];
$log->debug("[Lab config vars] $_SESSION, $_REQUEST");
if ($lab_config_id != $request_lab_config_id) {
    echo "You do not have permission to back up lab #$request_lab_config_id!";
    return;
}

$encryption_enabled = (KeyMgmt::read_enc_setting() == 1);

$keyContents = false;
if ($encryption_enabled) {
    $keySelection=$_POST['target'];
    if ($keySelection == "-1") {
        // A new key is uploaded
        $pkey_alias = $_POST['pkey_alias'];
        $pkey_contents = file_get_contents($_FILES['pkey']['tmp_name']);
        $res = KeyMgmt::add_key_mgmt(KeyMgmt::create($pkey_alias, $pkey_contents, $user->userId));
        $log->info("Uploading $pkey_alias: $res");
        $keyContents = $pkey_contents;
    } else if ($keySelection == "0") {
        // The Current Lab key is used
        $labKeyFile = dirname(__FILE__) . "/../../files/LAB_".$lab_config_id."_pubkey.blis";
        if (!file_exists($labKeyFile)) {
            // generate key
            KeyMgmt::generateKeyPair(
                dirname(__FILE__) . "/../../files/LAB_".$lab_config_id.".blis",
                $labKeyFile);
            $log->info("Keypair generated successfully.");
        }
        $keyContents = file_get_contents($labKeyFile);
    } else {
        // a specific key in the database was requested
        $key = KeyMgmt::getByID($keySelection);
        $keyContents = $key->PubKey;
        $log->debug("Public key contents before trim: $keyContents");
        $keyContents = substr($keyContents, ($pos = strpos($keyContents, '-')) !== false ? $pos : 0);
        $log->debug("Position of - : $pos, Public key contents trimmed: $keyContents");
    }
}

$backup_path = BackupLib::performBackup($lab_config_id, true, $keyContents);
echo "Download the below zip of the backup and save it to your disk. <br/><a href='/export/backups/".basename($backup_path)."'/>Download Zip</a>";
