<?php
#
# Updates Lab data (Similar to revert)
# Called via POST from lab_config_home.php
# Redirects back after update is complete
#
include("../includes/db_constants.php");
include("../export/backup_lib.php");
include("../includes/user_lib.php");
$saved_session = SessionUtil::save();

function page_redirect($is_done, $lid)
{
	if( $lid != 0 )
		$url_string = "lab_config_home.php?updateChange&id=".$_REQUEST['lid'];
	else 
		$url_string = "lab_configs.php?id=0";
	if($is_done === true)
		$url_string .= "&revert=1";
	else
		$url_string .= "&revert=0";
	//header("Location:".$url_string);
	echo $url_string;
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

$returnStatus = true;
$lab_config_id = $_REQUEST['lid'];
$backup_folder = $_REQUEST['backup_path'];

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

if($lid == 0 ) {
	$backupFolderList = getBackupFolders($_SESSION['user_id']);
	foreach( $backupFolderList as $key=>$value ) {
		$returnStatus = performUpdate($key, $value);
		if ( $returnStatus == false )
			break;
	}
}
else {
	$returnStatus = performUpdate($lab_config_id, $backup_folder);
}

function performUpdate($lab_config_id, $backup_folder) {
	global $DB_HOST, $DB_USER, $DB_PASS;

	$currentDir = getcwd();
	$mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
	$blisLabBackupFilePath = "\"".$mainBlisDir.$backup_folder."\blis_".$lab_config_id."\blis_".$lab_config_id."_backup.sql\"";
	$mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
	$dbname = "blis_".$lab_config_id;
	$command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname < $blisLabBackupFilePath";
	$command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
	system($command, $return_var);
	if( $return_var == 0 )
		return true;
	else
		return false;
}

# All done
SessionUtil::restore($saved_session);
page_redirect($returnStatus, $_REQUEST['lid']);
?>