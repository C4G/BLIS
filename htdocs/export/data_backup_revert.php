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
$blisLabBackupFilePath = "\"".$mainBlisDir.$backup_folder."\blis_".$lab_config_id."\blis_".$lab_config_id."_backup.sql\"";
$mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
$dbname = "blis_".$lab_config_id;
$command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname < $blisLabBackupFilePath";
$command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
system($command, $return);
echo $return;

$dbName = "blis_revamp";
$blisBackUpFilePath = "\"".$mainBlisDir.$backup_folder."\blis_revamp\blis_revamp_backup.sql\"";
$command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname < $blisBackUpFilePath";
$command = "C: &".$command;
system($command,$return);
echo $return;

$langdata_dir = "../../".$backup_folder."/langdata_".$lab_config_id;
chmod("../../dbdir/", 777);

if($do_langdata === true)
	dir_copy($langdata_dir, "../../local/langdata_".$lab_config_id);

# All done
SessionUtil::restore($saved_session);
page_redirect(true);
?>