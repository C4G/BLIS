<?php

include("redirect.php");
include("../includes/db_lib.php");
putUILog('backup_data', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

if($SERVER == $ON_ARC)
{
	# System on arc2 server: Do not allow backup option
	echo "Sorry, data backup option is not available in online version.";
}

$lab_config_id = $_REQUEST['labConfigId'];
$backupType = $_REQUEST['backupTypeSelect'];
$keyLocation = "../tmpPublicKey.pem";

if($_REQUEST['keyType'] == "uploaded") {
	if ( move_uploaded_file($_FILES["publicKey"]["tmp_name"], $keyLocation) ) {
		echo "succeeded!";
	}
	//$ret = move_uploaded_file("/public.pem", $keyLocation);
	else
		echo "fail";
	$publicKey = file_get_contents($keyLocation);
}
else
	$publicKey = file_get_contents("public.pem");

$file_list1 = array();
$file_list2 = array();
$file_list3 = array();
$file_list4 = array();

$currentDir = getcwd();
$mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
$mysqldumpPath = "\"".$mainBlisDir."server\mysql\bin\mysqldump.exe\"";
$dbname = "blis_".$lab_config_id;
$backupLabDbFileName= "blis_".$lab_config_id."_backup.sql";
$count=0;
$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname > $backupLabDbFileName";
system($command);
if( $backupType == "encrypted" ) {
/* Encrypt the sql with the public key */
	$fileHandle = fopen($backupLabDbFileName, "r");
	$backupLabDbFileNameEnc = $backupLabDbFileName.".enc";
	$fileWriteHandle = fopen($backupLabDbFileNameEnc, "w");

	while(!feof($fileHandle)) {
		$line = fgets($fileHandle);
		$return = openssl_public_encrypt($line, $encLine, $publicKey);
		fwrite($fileWriteHandle, $encLine);
	}
	fclose($fileWriteHandle);
	fclose($fileHandle);
	unlink($backupLabDbFileName);
}
else if( $backupType == "anonymized" ) {
	$query = "CREATE DATABASE ".$dbname."_temp";
	mysql_query($query, $con);
	$fileHandle = fopen($backupLabDbFileName, "r");
	$backupLabDbTempFileName = "blis_".$lab_config_id."_temp_backup.sql";
	$fileWriteHandle = fopen($backupLabDbTempFileName, "w");

	while(!feof($fileHandle)) {
		$line = fgets($fileHandle);
		if( strstr($line, "CREATE DATABASE ") ) {
			$line = str_replace( $dbname, $dbname."_temp", $line );
		}
		else if ( strstr($line, "USE ") ) {
			$line = str_replace( $dbname, $dbname."_temp", $line );
		}
		fwrite($fileWriteHandle, $line);
	}
	fclose($fileWriteHandle);
	fclose($fileHandle);
	
	$blisLabBackupTempFilePath = "\"".$mainBlisDir."\htdocs\export\blis_".$lab_config_id."_temp_backup.sql\"";
	$mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
	$dbTempName = "blis_".$lab_config_id."_temp";
	$command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbTempName < $blisLabBackupTempFilePath";
	$command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
	system($command, $return);
	
	unlink($backupLabDbTempFileName);
	$saved_db= db_get_current();
	$switchDatabaseName = "blis_".$lab_config_id."_temp";
	db_change($switchDatabaseName);
	$queryUpdate = "UPDATE patient ".
				   "SET name = hash_value";
	query_blind($queryUpdate);
	$backupLabDbTempFileName= "blis_".$lab_config_id."_temp_backup.sql";
	$count=0;
	$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbTempName > $backupLabDbTempFileName";
	system($command);
	DbUtil::switchRestore($saved_db);
	$query = "DROP DATABASE ".$dbname."_temp";
	mysql_query($query, $con);
	$fileHandle = fopen($backupLabDbTempFileName, "r");
	$backupLabDbFileName= "blis_".$lab_config_id."_backup.sql";
	unlink($backupLabDbFileName);
	$fileWriteHandle = fopen($backupLabDbFileName, "w");

	while(!feof($fileHandle)) {
		$line = fgets($fileHandle);
		if( strstr($line, "CREATE DATABASE ") ) {
			$line = str_replace( $dbname."_temp", $dbname, $line );
		}
		else if ( strstr($line, "USE ") ) {
			$line = str_replace( $dbname."_temp", $dbname, $line );
		}
		fwrite($fileWriteHandle, $line);
	}
	fclose($fileWriteHandle);
	fclose($fileHandle);
	$backupLabDbFileNameEnc = $backupLabDbFileName;

}	
else {
	$backupLabDbFileNameEnc = $backupLabDbFileName;
}
$file_list1[] = $backupLabDbFileNameEnc;

$dbname = "blis_revamp";
$backupDbFileName = "blis_revamp_backup.sql";
$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname > $backupDbFileName";
system($command);
if($backupType == "encrypted") { 
	$fileHandle = fopen($backupDbFileName, "r");
	$backupDbFileNameEnc = $backupDbFileName.".enc";
	$fileWriteHandle = fopen($backupDbFileNameEnc, "w");

	while(!feof($fileHandle)) {
		$line = fgets($fileHandle);
		$return = openssl_public_encrypt($line, $encLine, $publicKey);
		fwrite($fileWriteHandle, $encLine);
	}
	fclose($fileWriteHandle);
	fclose($fileHandle);
	unlink($backupDbFileName);
}
else {
	$backupDbFileNameEnc = $backupDbFileName;
}
$file_list2[] = $backupDbFileNameEnc;

$dir_name3 = "../../local/langdata_".$lab_config_id;
if ($handle = opendir($dir_name3))
{
	while (false !== ($file = readdir($handle))) 
	{
		if($file === "." || $file == "..")
			continue;
		$file_list3[] = $dir_name3."/$file";
	}
}

$lab_config = LabConfig::getById($lab_config_id);
$site_name = str_replace(" ", "-", $lab_config->getSiteName());
$destination = "../../blis_backup_".$site_name."_".date("Ymd-Hi")."/";
$toScreenDestination = "blis_backup_".$site_name."_".date("Ymd-Hi");
@mkdir($destination);
@mkdir($destination."blis_revamp/");
@mkdir($destination."blis_".$lab_config_id."/");
@mkdir($destination."langdata_".$lab_config_id."/");
chmod($destination, 777);

foreach($file_list1 as $file)
{
	$file_name_parts = explode("/", $file);
	echo $file_parts[count($file_name_parts)-1];
	$target_file_name = $destination."blis_".$lab_config_id."/".$file_name_parts[count($file_name_parts)-1];
	$ourFileHandle = fopen($target_file_name, 'w') or die("can't open file");
	fclose($ourFileHandle);
	if(!copy($file, $target_file_name))
	{
		echo "Error: $file -> $destination.$file <br>";
	};
}
unlink($backupLabDbFileNameEnc);

foreach($file_list2 as $file)
{
	$file_name_parts = explode("/", $file);
	if(!copy($file, $destination."blis_revamp/".$file_name_parts[count($file_name_parts)-1]))
	{
		echo "Error: $file -> $destination.$file <br>";
	};
}
unlink($backupDbFileNameEnc);

foreach($file_list3 as $file)
{
	$file_name_parts = explode("/", $file);
	if(!copy($file, $destination."langdata_".$lab_config_id."/".$file_name_parts[count($file_name_parts)-1]))
	{
		echo "Error: $file -> $destination.$file <br>";
	};
}

# Backup log file if exists

$log_file1 = "../../local/log_".$lab_config_id.".txt";
$log_file2 = "../../local/log_".$lab_config_id."_updates.sql";
$log_file3 = "../../local/log_".$lab_config_id."_revamp_updates.sql";

if( file_exists($log_file1) ) {
	$copyDestination = $destination."log_".$lab_config_id.".txt";
	if($backupType == "encrypted") { 
		$fileHandle = fopen($log_file1, "r");
		$logFile = $log_file1.".enc";
		$fileWriteHandle = fopen($logFile, "w");

		while(!feof($fileHandle)) {
			$line = fgets($fileHandle);
			$return = openssl_public_encrypt($line, $encLine, $publicKey);
			fwrite($fileWriteHandle, $encLine);
		}
		fclose($fileWriteHandle);
		fclose($fileHandle);
		$copyDestination = $copyDestination.".enc";
	}
	else 
		$logFile = $log_file1;
	copy($logFile, $copyDestination);
	//unlink($logFile);
}

if( file_exists($log_file2) ) {
	$copyDestination = $destination."log_".$lab_config_id."_updates.sql";
	if($backupType == "encrypted") { 
		$fileHandle = fopen($log_file2, "r");
		$logFile = $log_file1.".enc";
		$fileWriteHandle = fopen($logFile, "w");

		while(!feof($fileHandle)) {
			$line = fgets($fileHandle);
			$return = openssl_public_encrypt($line, $encLine, $publicKey);
			fwrite($fileWriteHandle, $encLine);
		}
		fclose($fileWriteHandle);
		fclose($fileHandle);
		$copyDestination = $copyDestination.".enc";
	}
	else 
		$logFile = $log_file2;
	copy($logFile, $copyDestination);
	//unlink($logFile);
}
if( file_exists($log_file3) ) {
	$copyDestination = $destination."log_".$lab_config_id."_revamp_updates.sql";
	if($backupType == "encrypted") { 
		$fileHandle = fopen($log_file3, "r");
		$logFile = $log_file1.".enc";
		$fileWriteHandle = fopen($logFile, "w");

		while(!feof($fileHandle)) {
			$line = fgets($fileHandle);
			$return = openssl_public_encrypt($line, $encLine, $publicKey);
			fwrite($fileWriteHandle, $encLine);
		}
		fclose($fileWriteHandle);
		fclose($fileHandle);
		$copyDestination = $copyDestination.".enc";
	}
	else 
		$logFile = $log_file3;
	copy($logFile, $copyDestination);
	//unlink($logFile);

}


$versions = array();
$vstr = "2-2,2-3";
$versions = explode(',', $vstr);
$uilog_files = array();

foreach($versions as $vr)
{
    $uilog_files[] = "../../local/UILog_".$vr.".csv";
}

$i = 0;

foreach($uilog_files as $log_file3)
{
if( file_exists($log_file3) ) {
        $vers = $versions[$i];
	$copyDestination = $destination."UILog_".$vers.".csv";
	if($backupType == "encrypted") { 
		$fileHandle = fopen($log_file3, "r");
		$logFile = $log_file1.".enc";
		$fileWriteHandle = fopen($logFile, "w");

		while(!feof($fileHandle)) {
			$line = fgets($fileHandle);
			$return = openssl_public_encrypt($line, $encLine, $publicKey);
			fwrite($fileWriteHandle, $encLine);
		}
		fclose($fileWriteHandle);
		fclose($fileHandle);
		$copyDestination = $copyDestination.".enc";
	}
	else 
		$logFile = $log_file3;
	copy($logFile, $copyDestination);
	//unlink($logFile);
}
$i++;
}
# All okay
$str = "Backup folder created as ".$toScreenDestination." under main BLIS directory.<br>Please copy this folder to your disk as backup";
echo $str;
?>