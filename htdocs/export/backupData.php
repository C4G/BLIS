<?php
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
if ($lab_config_id != $request_lab_config_id) {
    echo "You do not have permission to back up lab #$request_lab_config_id!";
    return;
}

$encryption_enabled = (KeyMgmt::read_enc_setting() == 1);

$keyContents = "";
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
    }
}

function mySqlDump($databaseName, $backupFilename) {
    global $log, $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS;

    $mysqldumpPath = PlatformLib::mySqlDumpPath();
    $command = $mysqldumpPath." -B -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $databaseName -r ".escapeshellarg($backupFilename);
    $output = system($command, $result);

    if ($result == 0) {
        return $backupFilename;
    } else {
        $log->error("Could not dump MySQL database; command: $command, err code $result, output:\n $output");
        return false;
    }
}

function encryptFile($filename, $publicKey, $outputFilename, $decryptionKeyFilename)
{
    global $log;

    $data = file_get_contents($filename);
    $res = openssl_seal($data, $sealed, $ekeys, array($publicKey));
    if (!$res) {
        $log->error("Failed to encrypt data: " . openssl_error_string());
        return false;
    }
    $env_key = $ekeys[0];
    file_put_contents($decryptionKeyFilename, base64_encode($env_key));
    file_put_contents($outputFilename, $sealed);
}

$file_list1 = array();
$file_list2 = array();
$file_list3 = array();

$lab_db = "blis_$lab_config_id";

// Create backup directory structure
$backup_dir = "../../files/backups/blis_backup_".date("Ymd-His");
mkdir($backup_dir, 0700, true);
mkdir("$backup_dir/$lab_db/", 0700, false);
mkdir("$backup_dir/blis_revamp/", 0700, false);
mkdir("$backup_dir/langdata_$lab_config_id/", 0700, false);

$plaintext_backup = "$backup_dir/$lab_db/$lab_db"."_backup.sql";

// Dump the database
mySqlDump($lab_db, $plaintext_backup);

$backupType = $_POST['backupTypeSelect'];

// If backup type is anonymous, then re-import the database and hash the patient names
if ($backupType == "anonymized") {
    // Create the database we will reimport to
    $anonymized_db = $lab_db."_anonymized";
    $query = "CREATE DATABASE $anonymized_db";
    query_blind($query, $con);

    // Copy the plaintext database backup and replace the old database name with the anonymized one.
    $fileHandle = fopen($plaintext_backup, "r");
    $backupLabDbTempFileName = "$backup_dir/$lab_db/blis_".$lab_config_id."_reimport.sql";
    $fileWriteHandle = fopen($backupLabDbTempFileName, "w");
    while (!feof($fileHandle)) {
        $line = fgets($fileHandle);
        if (strstr($line, "CREATE DATABASE ") || strstr($line, "USE ")) {
            $line = str_replace($lab_db, $anonymized_db, $line);
        }
        fwrite($fileWriteHandle, $line);
    }
    fclose($fileWriteHandle);
    fclose($fileHandle);

    // Delete the original database dump
    unlink($plaintext_backup);

    // Reimport the new database data
    $mysqlExePath = PlatformLib::mySqlClientPath();
    $command = "$mysqlExePath -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $anonymized_db < \"$backupLabDbTempFileName\"";
    $last_line = system($command, $result);
    if ($result != 0) {
        $log->error("Could not import MySQL database to anonymize data; command: $command, last line: $last_line");
        return;
    }

    // Delete the temporary dump used to import data
    unlink($backupLabDbTempFileName);

    // Replace each patient name with a SHA-256 hash of the name
    $saved_db= db_get_current();
    db_change($anonymized_db);
    $queryUpdate = "UPDATE patient SET name = SHA2(name, 256);";
    query_blind($queryUpdate);
    DbUtil::switchRestore($saved_db);

    // Re-dump the anonymized database to a temp file
    mySqlDump($anonymized_db, $backupLabDbTempFileName);

    // Drop anonymized database
    query_blind("DROP DATABASE $anonymized_db;");

    // Replace instances of the anonymized db name with the real db name
    $fileHandle = fopen($backupLabDbTempFileName, "r");
    $fileWriteHandle = fopen($plaintext_backup, "w");
    while (!feof($fileHandle)) {
        $line = fgets($fileHandle);
        if (strstr($line, "CREATE DATABASE ") || strstr($line, "USE ")) {
            $line = str_replace($anonymized_db, $lab_db, $line);
        }
        fwrite($fileWriteHandle, $line);
    }
    fclose($fileWriteHandle);
    fclose($fileHandle);

    unlink($backupLabDbTempFileName);

    // Now the file located at $plaintext_backup is anonymized!
}

$server_public_key = false;

if ($encryption_enabled) {
    $server_public_key = openssl_pkey_get_public($keyContents);
    if (!$server_public_key) {
        $log->error(openssl_error_string());
        return;
    }

    $encrypted_backup = "$backup_dir/$lab_db/$lab_db"."_backup.sql.enc";
    $encrypted_backup_key = "$backup_dir/$lab_db/$lab_db"."_backup.key";
    encryptFile($plaintext_backup, $server_public_key, $encrypted_backup, $encrypted_backup_key);

    // Delete plaintext backup
    unlink($plaintext_backup);
}


$dbname = "blis_revamp";
$backupDbFileName = "$backup_dir/$dbname/$dbname"."_backup.sql";
mySqlDump($dbname, $backupDbFileName);

if ($encryption_enabled) {
    $encrypted_backup = "$backup_dir/$dbname/$dbname"."_backup.sql.enc";
    $encrypted_backup_key = "$backup_dir/$dbname/$dbname"."_backup.sql.key";
    encryptFile($backupDbFileName, $server_public_key, $encrypted_backup, $encrypted_backup_key);

    unlink($backupDbFileName);
}

// Add language data files to backup folder
$lab_langdata = "../../local/langdata_$lab_config_id";
if ($handle = opendir($lab_langdata)) {
    while (false !== ($file = readdir($handle))) {
        if ($file === "." || $file == "..") {
            continue;
        }
        copy("$lab_langdata/$file", "$backup_dir/langdata_$lab_config_id/$file");
    }
}

# Backup log files if they exist
function dump_log($logfile, $dest_base) {
    global $encryption_enabled, $server_public_key;
    if (file_exists($logfile)) {
        if ($encryption_enabled) {
            $dest = "$dest_base.enc";
            $key_dest = "$dest_base.key";
            encryptFile($logfile, $server_public_key, $dest, $key_dest);
        } else {
            copy($logfile, $dest_base);
        }
    }
}

dump_log("../../local/log_$lab_config_id.txt", "$backup_dir/log_$lab_config_id.txt");
dump_log("../../local/log_$lab_config_id"."_updates.txt", "$backup_dir/log_$lab_config_id"."_updates.txt");
dump_log("../../local/log_$lab_config_id"."_revamp_updates.txt", "$backup_dir/log_$lab_config_id"."_revamp_updates.txt");
dump_log("../../local/UILog_2-2.csv", "$backup_dir/UILog_2-2.csv");
dump_log("../../local/UILog_2-3.csv", "$backup_dir/UILog_2-3.csv");
dump_log("../../log/application.log", "$backup_dir/application.log");
dump_log("../../log/apache2_error.log", "$backup_dir/apache2_error.log");
dump_log("../../log/php_error.log", "$backup_dir/apache2_error.log");

$zipFile=$backup_dir;
if ($encryption_enabled) {
    $zipFile=$zipFile."_enc.zip";
} else {
    $zipFile = $zipFile.".zip";
}

createZipFile($zipFile, realpath($backup_dir));

$new_path = dirname(__FILE__)."/backups/".basename($zipFile);
rename($zipFile, $new_path);

// Removes the backup directory in files/
// Comment this out if you want to figure out what went wrong somewhere!
removeDirectory($backup_dir);

echo "Download the below zip of the backup and save it to your disk. <br/><a href='/export/backups/".basename($new_path)."'/>Download Zip</a>";

send_file_to_server($new_path);

// } else {
//     // handle server backup here
//     $query = "select server_ip from lab_config where lab_config_id = ".$lab_config_id;
//     $server_ip = query_associative_one($query)['server_ip'];
//     $response = send_backup_to_server($zipFile, $server_ip);
//     echo $response;
// }


function createZipFile($zipFile, $rootPath)
{
    global $log;
    $log->info("Creating zip file: $zipFile from path $rootPath");

    $zip = new ZipArchive();
    $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    // Create recursive directory iterator
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        // Skip directories (they would be added automatically)
        if (!$file->isDir()) {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            //echo $zipFile + "\n" + $filePath;
            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Zip archive will be created only after closing object
    $zip->close();
}
function removeDirectory($dir)
{
    $it = new RecursiveDirectoryIterator($dir);//, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator(
        $it,
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($dir);
}


function send_file_to_server($file_path) {
    // TODO
    $server_ip = "http://188.166.124.131";

    send_file($file_path, $server_ip);
}

function send_file($file_path, $server_host)
{
    global $log;

    $endpoint = $server_host.'/export/import_data_director.php';
    $log->info("Attempting to upload $file_path to $endpoint...");

    if (function_exists('curl_file_create')) {
        // For PHP 5.5+, which is what we use in the BLIS docker image
        $curlfile = curl_file_create($file_path, 'application/zip');
    } else {
        // For old-school PHP, which is in-use by the Desktop BLIS
        $curlfile = '@' . realpath($file_path);
        $log->info("Resolved path to: $curlfile");
    }

    // The sqlFile name is the form name for the file
    // This should match the name used in import_data_director.php
    $post = array('sqlFile'=> $curlfile);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $endpoint);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS,  $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec( $curl );
    curl_close( $curl );

    // See https://www.php.net/manual/en/function.curl-exec.php
    // for why to use the === here
    if ($response === false) {
        $log->error("Failed to upload file.");
    } else {
        $log->info("File uploaded successfully!");
        echo("<p>Backup was transferred to server $server_host</p>");
    }

    return $response;
}
