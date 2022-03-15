<?php
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
$user = get_user_by_name($_SESSION['username']);
$lab_config_id = $user->labConfigId;
//$lab_config_id = $_REQUEST['labConfigId'];
$backupType = $_REQUEST['backupTypeSelect'];
$keyLocation = "../tmpPublicKey.pem";
$LabName=$_POST['target'];
$ploc="../ajax/LAB_".$_SESSION['lab_config_id']."_pubkey.blis";
if (KeyMgmt::read_enc_setting()==1) {
    if ($LabName==="Current Lab") {
        if (!file_exists($ploc)) {
            echo "Please go to Lab Configuration -> Manage Backup Keys and click the download public key button to be able to use the encryption functionality.";
            return;
        }
        $pubKey=file_get_contents($ploc);
    }
}

if ($LabName!=="Current Lab") {
    if (count($_FILES)==1) {
        $keyMgmt=KeyMgmt::getByLabName($LabName);
        $pubKey=$keyMgmt->PubKey;
    } else {
        $target_loc= __DIR__."/../key.blis";
        if (move_uploaded_file($_FILES["pkey"]["tmp_name"], $target_loc)) {
            $pubKey = file_get_contents($target_loc);
            $keyMgmt=new KeyMgmt();
            $keyMgmt->LabName=$LabName;
            $keyMgmt->PubKey=$pubKey;
            $keyMgmt->AddedBy=$_SESSION['user_id'];
            KeyMgmt::add_key_mgmt($keyMgmt);
        }
    }
}

if ($_REQUEST['keyType'] == "uploaded") {
    if (move_uploaded_file($_FILES["publicKey"]["tmp_name"], $keyLocation)) {
        echo "succeeded!";
    }
    //$ret = move_uploaded_file("/public.pem", $keyLocation);
    else {
        echo "fail";
    }
    $publicKey = file_get_contents($keyLocation);
} else {
    $publicKey = file_get_contents("public.pem");
}

$file_list1 = array();
$file_list2 = array();
$file_list3 = array();
$file_list4 = array();

$mysqldumpPath = '"'.PlatformLib::mySqlDumpPath().'"';
$dbname = "blis_".$lab_config_id;
$backupLabDbFileName= "blis_".$lab_config_id."_backup.sql";
$count=0;
$command = $mysqldumpPath." -B -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $dbname -r $backupLabDbFileName";
system($command);
if ($backupType == "encrypted") {
    /* Encrypt the sql with the public key */
    $fileHandle = fopen($backupLabDbFileName, "r");
    $backupLabDbFileNameEnc = $backupLabDbFileName.".enc";
    $fileWriteHandle = fopen($backupLabDbFileNameEnc, "w");

    while (!feof($fileHandle)) {
        $line = fgets($fileHandle);
        $return = openssl_public_encrypt($line, $encLine, $publicKey);
        fwrite($fileWriteHandle, $encLine);
    }
    fclose($fileWriteHandle);
    fclose($fileHandle);
    unlink($backupLabDbFileName);
} elseif ($backupType == "anonymized") {
    $query = "CREATE DATABASE ".$dbname."_temp";
    mysql_query($query, $con);
    $fileHandle = fopen($backupLabDbFileName, "r");
    $backupLabDbTempFileName = "blis_".$lab_config_id."_temp_backup.sql";
    $fileWriteHandle = fopen($backupLabDbTempFileName, "w");

    while (!feof($fileHandle)) {
        $line = fgets($fileHandle);
        if (strstr($line, "CREATE DATABASE ")) {
            $line = str_replace($dbname, $dbname."_temp", $line);
        } elseif (strstr($line, "USE ")) {
            $line = str_replace($dbname, $dbname."_temp", $line);
        }
        fwrite($fileWriteHandle, $line);
    }
    fclose($fileWriteHandle);
    fclose($fileHandle);
    
    $blisLabBackupTempFilePath = "\"".$mainBlisDir."\htdocs\export\blis_".$lab_config_id."_temp_backup.sql\"";
    $mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
    $dbTempName = "blis_".$lab_config_id."_temp";
    $command = $mysqlExePath." -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $dbTempName < $blisLabBackupTempFilePath";
    $command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
    system($command, $return);
    
    unlink($backupLabDbTempFileName);
    $saved_db= db_get_current();
    $switchDatabaseName = "blis_".$lab_config_id."_temp";
    db_change($switchDatabaseName);
    $queryUpdate = "UPDATE patient ".
                   "SET name = hash_value";
    query_blind($queryUpdate);
    $backupLabDbTempFileName= "blis_".$lab_config_id."_temp_backup";
    $count=0;
    $command = $mysqldumpPath." -B -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $dbTempName -r $backupLabDbTempFileName";
    system($command);
    DbUtil::switchRestore($saved_db);
    $query = "DROP DATABASE ".$dbname."_temp";
    mysql_query($query, $con);
    $fileHandle = fopen($backupLabDbTempFileName, "r");
    $backupLabDbFileName= "blis_".$lab_config_id."_backup.sql";
    unlink($backupLabDbFileName);
    $fileWriteHandle = fopen($backupLabDbFileName, "w");

    while (!feof($fileHandle)) {
        $line = fgets($fileHandle);
        if (strstr($line, "CREATE DATABASE ")) {
            $line = str_replace($dbname."_temp", $dbname, $line);
        } elseif (strstr($line, "USE ")) {
            $line = str_replace($dbname."_temp", $dbname, $line);
        }
        fwrite($fileWriteHandle, $line);
    }
    fclose($fileWriteHandle);
    fclose($fileHandle);
    $backupLabDbFileNameEnc = $backupLabDbFileName;
} else {
    $backupLabDbFileNameEnc = $backupLabDbFileName;
}
$file_list1[] = $backupLabDbFileNameEnc;

$server_public_key = openssl_pkey_get_public($pubKey);
if (!$server_public_key) {
    echo "Unable to open " . $ploc;
    return;
}

encryptFile($backupLabDbFileName, $server_public_key);
$backupDbFileName = "blis_revamp_backup.sql";

$dbname = "blis_revamp";
$command = $mysqldumpPath." -B -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $dbname -r $backupDbFileName";
system($command);
if ($backupType == "encrypted") {
    $fileHandle = fopen($backupDbFileName, "r");
    $backupDbFileNameEnc = $backupDbFileName.".enc";
    $fileWriteHandle = fopen($backupDbFileNameEnc, "w");

    while (!feof($fileHandle)) {
        $line = fgets($fileHandle);
        $return = openssl_public_encrypt($line, $encLine, $publicKey);
        fwrite($fileWriteHandle, $encLine);
    }
    fclose($fileWriteHandle);
    fclose($fileHandle);
    unlink($backupDbFileName);
} else {
    $backupDbFileNameEnc = $backupDbFileName;
}
encryptFile($backupDbFileNameEnc, $server_public_key);
$file_list2[] = $backupDbFileNameEnc;

$dir_name3 = "../../local/langdata_".$lab_config_id;
if ($handle = opendir($dir_name3)) {
    while (false !== ($file = readdir($handle))) {
        if ($file === "." || $file == "..") {
            continue;
        }
        $file_list3[] = $dir_name3."/$file";
    }
}

$lab_config = LabConfig::getById($lab_config_id);
$site_name = str_replace(" ", "-", $lab_config->getSiteName());
if ($LabName!=="Current Lab") {
    $site_name=$LabName;
}
$destination = "../../blis_backup_".$site_name."_".date("Ymd-Hi")."/";
$toScreenDestination = "blis_backup_".$site_name."_".date("Ymd-Hi");
mkdir($destination, 0755);
mkdir($destination."blis_revamp/", 0755);
mkdir($destination."blis_".$lab_config_id."/", 0755);
mkdir($destination."langdata_".$lab_config_id."/", 0755);

foreach ($file_list1 as $file) {
    $file_name_parts = explode("/", $file);
    $target_file_name = $destination."blis_".$lab_config_id."/".$file_name_parts[count($file_name_parts)-1];
    $ourFileHandle = fopen($target_file_name, 'w') or die("can't open file");
    fclose($ourFileHandle);
    if (!copy($file, $target_file_name)) {
        echo "Error: $file -> $destination.$file <br>";
    };
    if (KeyMgmt::read_enc_setting()==1) {
        if (!copy($file.".key", $target_file_name.".key")) {
            echo "Error: $file -> $destination.$file <br>";
        };
    }
}
unlink($backupLabDbFileNameEnc);

foreach ($file_list2 as $file) {
    $file_name_parts = explode("/", $file);
    if (!copy($file, $destination."blis_revamp/".$file_name_parts[count($file_name_parts)-1])) {
        echo "Error: $file -> $destination.$file <br>";
    };
    if (KeyMgmt::read_enc_setting()==1) {
        if (!copy($file.".key", $destination."blis_revamp/".$file_name_parts[count($file_name_parts)-1].".key")) {
            echo "Error: $file -> $destination.$file <br>";
        };
    }
}
unlink($backupDbFileNameEnc);

foreach ($file_list3 as $file) {
    $file_name_parts = explode("/", $file);
    if (!copy($file, $destination."langdata_".$lab_config_id."/".$file_name_parts[count($file_name_parts)-1])) {
        echo "Error: $file -> $destination.$file <br>";
    };
}

# Backup log file if exists

$log_file1 = "../../local/log_".$lab_config_id.".txt";
$log_file2 = "../../local/log_".$lab_config_id."_updates.sql";
$log_file3 = "../../local/log_".$lab_config_id."_revamp_updates.sql";

if (file_exists($log_file1)) {
    encryptFile($log_file1, $server_public_key);
    $copyDestination = $destination."log_".$lab_config_id.".txt";
    if ($backupType == "encrypted") {
        $fileHandle = fopen($log_file1, "r");
        $logFile = $log_file1.".enc";
        $fileWriteHandle = fopen($logFile, "w");

        while (!feof($fileHandle)) {
            $line = fgets($fileHandle);
            $return = openssl_public_encrypt($line, $encLine, $publicKey);
            fwrite($fileWriteHandle, $encLine);
        }
        fclose($fileWriteHandle);
        fclose($fileHandle);
        $copyDestination = $copyDestination.".enc";
    } else {
        $logFile = $log_file1;
    }
    copy($logFile, $copyDestination);
    //unlink($logFile);
}

if (file_exists($log_file2)) {
    encryptFile($log_file2, $server_public_key);
    $copyDestination = $destination."log_".$lab_config_id."_updates.sql";
    if ($backupType == "encrypted") {
        $fileHandle = fopen($log_file2, "r");
        $logFile = $log_file1.".enc";
        $fileWriteHandle = fopen($logFile, "w");

        while (!feof($fileHandle)) {
            $line = fgets($fileHandle);
            $return = openssl_public_encrypt($line, $encLine, $publicKey);
            fwrite($fileWriteHandle, $encLine);
        }
        fclose($fileWriteHandle);
        fclose($fileHandle);
        $copyDestination = $copyDestination.".enc";
    } else {
        $logFile = $log_file2;
    }
    copy($logFile, $copyDestination);
    //unlink($logFile);
}
if (file_exists($log_file3)) {
    encryptFile($log_file3, $server_public_key);
    $copyDestination = $destination."log_".$lab_config_id."_revamp_updates.sql";
    if ($backupType == "encrypted") {
        $fileHandle = fopen($log_file3, "r");
        $logFile = $log_file1.".enc";
        $fileWriteHandle = fopen($logFile, "w");

        while (!feof($fileHandle)) {
            $line = fgets($fileHandle);
            $return = openssl_public_encrypt($line, $encLine, $publicKey);
            fwrite($fileWriteHandle, $encLine);
        }
        fclose($fileWriteHandle);
        fclose($fileHandle);
        $copyDestination = $copyDestination.".enc";
    } else {
        $logFile = $log_file3;
    }
    copy($logFile, $copyDestination);
    //unlink($logFile);
}


$versions = array();
$vstr = "2-2,2-3";
$versions = explode(',', $vstr);
$uilog_files = array();

foreach ($versions as $vr) {
    $uilog_files[] = "../../local/UILog_".$vr.".csv";
}

$i = 0;

foreach ($uilog_files as $log_file3) {
    if (file_exists($log_file3)) {
        encryptFile($log_file3, $server_public_key);
        $vers = $versions[$i];
        $copyDestination = $destination."UILog_".$vers.".csv";
        if ($backupType == "encrypted") {
            $fileHandle = fopen($log_file3, "r");
            $logFile = $log_file1.".enc";
            $fileWriteHandle = fopen($logFile, "w");

            while (!feof($fileHandle)) {
                $line = fgets($fileHandle);
                $return = openssl_public_encrypt($line, $encLine, $publicKey);
                fwrite($fileWriteHandle, $encLine);
            }
            fclose($fileWriteHandle);
            fclose($fileHandle);
            $copyDestination = $copyDestination.".enc";
        } else {
            $logFile = $log_file3;
        }
        copy($logFile, $copyDestination);
        //unlink($logFile);
    }
    $i++;
}
//$rootPath=getcwd()+'/../../'.$toScreenDestination;
$zipFile=$toScreenDestination.".zip";
if (KeyMgmt::read_enc_setting()==1) {
    $zipFile=$toScreenDestination."_enc.zip";
}
$zipFileLoc=realpath("../../")."/".$zipFile;

//echo $zipFileLoc;
createZipFile($zipFile, realpath($destination));
copy($zipFile, $zipFileLoc);
//removeDirectory(realpath($destination));


$button_clicked = $_REQUEST['local_or_server'];
$local_text = LangUtil::$generalTerms['BACKUP_LOCAL'];
if ($button_clicked == $local_text) {
    // handle local download here
    echo "Download the below zip of the backup and save it to your disk. <br/><a href='/export/".$zipFile."'/>Download Zip</a>";
} else {
    // handle server backup here  
    $query = "select server_ip from lab_config where lab_config_id = ".$lab_config_id;
    $result = query_associative_one($query);
    $server_ip = reset($result); 
    echo $server_ip;
    $response = send_backup_to_server($zipFileLoc, $server_ip);
    echo $response;
}

function hasFile()
{
    echo count($_FILES);
    foreach ($_FILES['pkey']['tmp_name'] as $tmp_name) {
        if (is_uploaded_file($tmp_name)) {
            return 1;
        } else {
            return 0;
        }
    }
}
function encryptFile($fname, $pub)
{
    if (KeyMgmt::read_enc_setting()==0) {
        return;
    }
    $data=file_get_contents($fname);
    $sealed = '';
    openssl_seal($data, $sealed, $ekeys, array($pub));
    $env_key = $ekeys[0];
    file_put_contents($fname.".key", base64_encode($env_key));
    $f=fopen($fname, "w");
    fwrite($f, $sealed);
    fclose($f);
    //file_put_contents($fname,base64_encode($sealed));
}
function encryptFile1($fname, $pubKey)
{
    $fileHandle = fopen($fname, "r");
    $fnameEnc = $fname.".enc";
    $fileWriteHandle = fopen($fnameEnc, "w");
    ini_set('auto_detect_line_endings', true);
    while (!feof($fileHandle)) {
        $line = fgets($fileHandle);
        $return = openssl_public_encrypt($line, $encLine, $pubKey, OPENSSL_PKCS1_PADDING);
        if ($return) {
            fwrite($fileWriteHandle, base64_encode($encLine)."\r\n");
        } else {
            fwrite($fileWriteHandle, "~".$line."\r\n");
        }
    }
    fclose($fileWriteHandle);
    fclose($fileHandle);
    $temp=file_get_contents($fnameEnc);
    file_put_contents($fname, $temp);
    unlink($fnameEnc);
}
function createZipFile($zipFile, $rootPath)
{
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


function send_backup_to_server($zipped, $server_ip)
{
    $endpoint = 'http://'.$server_ip.'/export/import_data_director.php';
    $curlfile = curl_file_create( $zipped, 'application/zip');

    $curl = curl_init();
    curl_setopt( $curl, CURLOPT_URL, $endpoint );
    curl_setopt( $curl, CURLOPT_POST, true );
    curl_setopt( $curl, CURLOPT_POSTFIELDS,  $curlfile);
    // if this doesn't work, try array with curlfile
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    $response = curl_exec( $curl );
    curl_close( $curl );
    return $response;
}