<?php
#
# Reverts to a previous backup of data
# Called via POST from lab_config_home.php
# Redirects back after revert complete
#
include("../includes/db_constants.php");
include("../export/backup_lib.php");
$saved_session = SessionUtil::save();
function page_redirect($is_done)
{
	$url_string = "lab_config_home.php?id=".$_REQUEST['lid'];
	if($is_done === true)
		$url_string .= "&revert=1";
	else
		$url_string .= "&revert=0";
	header("Location:".$url_string);
}

function dir_copy($src,$dst) 
{ 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) 
	{ 
        if (( $file != '.' ) && ( $file != '..' )) 
		{ 
            if ( is_dir($src . '/' . $file) ) 
			{ 
                dir_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else 
			{ 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
	} 
    closedir($dir); 
} 

$is_done = false;
$lab_config_id = $_REQUEST['lid'];
$backup_folder = $_REQUEST['backup_path'];
# Include langdata folder in backup revert?
$do_langdata = false;
if($_REQUEST['do_lang'] == 'Y')
	$do_langdata = true;
# Perform backup of current version before reverting?
$do_currbackup = false;
if($_REQUEST['do_currbackup'] == 'Y')
	$do_currbackup = true;
if($do_currbackup === true)
{
	if(!BackupLib::performBackup($lab_config_id, getcwd() ) === true)
	{
		# Backup of current version failed.
		page_redirect(false);
	}
}

$currentDir = getcwd();
$mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
$blisLabBackupFilePath = $mainBlisDir.$backup_folder."\blis_".$lab_config_id."\blis_".$lab_config_id."_backup.sql";
$pvt=file_get_contents("../ajax/LAB_".$lab_config_id.".blis");
decryptFile($blisLabBackupFilePath,$pvt);
$temp=$blisLabBackupFilePath.".dec";
if(file_exists($blisLabBackupFilePath.".key"))
$blisLabBackupFilePath = "\"".$mainBlisDir.$backup_folder."\blis_".$lab_config_id."\blis_".$lab_config_id."_backup.sql.dec\"";
else
$blisLabBackupFilePath = "\"".$mainBlisDir.$backup_folder."\blis_".$lab_config_id."\blis_".$lab_config_id."_backup.sql\"";
$mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
$dbname = "blis_".$lab_config_id;
$command = $mysqlExePath." -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $dbname < $blisLabBackupFilePath";
$command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes

system($command, $return);
unlink($temp);
echo $return;

$dbName = "blis_revamp";
$blisBackUpFilePath = $mainBlisDir.$backup_folder."\blis_revamp\blis_revamp_backup.sql";
decryptFile($blisBackUpFilePath,$pvt);
$temp=$blisBackUpFilePath.".dec";
if(file_exists($blisLabBackupFilePath.".key"))
$blisBackUpFilePath = "\"".$mainBlisDir.$backup_folder."\blis_revamp\blis_revamp_backup.sql.dec\"";
else
$blisBackUpFilePath = "\"".$mainBlisDir.$backup_folder."\blis_revamp\blis_revamp_backup.sql\"";
$command = $mysqlExePath." -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $dbName < $blisBackUpFilePath";
$command = "C: &".$command;

system($command,$return);
echo $return;
unlink($temp);

$langdata_dir = "../../".$backup_folder."/langdata_".$lab_config_id;
chmod("../../dbdir/", 0755);

if($do_langdata === true)
	dir_copy($langdata_dir, "../../local/langdata_".$lab_config_id);

# All done
SessionUtil::restore($saved_session);
page_redirect(true);
function decryptFile($fname,$pvt)
{
if(!file_exists($fname.".key"))
return;
$env_key=base64_decode(file_get_contents($fname.".key"));
$sealed=file_get_contents($fname);
$open = '';
openssl_open($sealed, $open, $env_key, $pvt);
file_put_contents($fname.".dec",$open);
}
function decryptFile1($fname,$pvtKey)
{
ini_set('auto_detect_line_endings',true);
	$fileHandle = fopen($fname,"r");
	$fnameDec = $fname.".dec";
	$fileWriteHandle = fopen($fnameDec, "w");
while(!feof($fileHandle)) {
		$line = rtrim(fgets($fileHandle),"\r\n");
$line=base64_decode($line);
		$return = openssl_private_decrypt($line, $decLine,$pvtKey,OPENSSL_PKCS1_PADDING);
if($return)
		fwrite($fileWriteHandle, $decLine);
}
	fclose($fileWriteHandle);
	fclose($fileHandle);
}
?>