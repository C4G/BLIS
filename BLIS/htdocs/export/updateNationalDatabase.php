<?php
#
# Updates Lab data (Similar to revert)
# Called via POST from lab_config_home.php
# Redirects back after update is complete
#
include("../includes/header.php");
include("../includes/db_constants.php");
//include("../export/backup_lib.php");
//include("../includes/user_lib.php");
$saved_session = SessionUtil::save();
//$labConfigId = 129;
$labConfigId = $_REQUEST['labConfigId'];
//$base = $labConfigId."00000000000";
$dateFrom = $_REQUEST['yearFrom'].$_REQUEST['monthFrom'].$_REQUEST['dayFrom'];
$dateTo = $_REQUEST['yearTo'].$_REQUEST['monthTo'].$_REQUEST['dayTo'];

function page_redirect($is_done, $lid) {
	if( $lid != 0 )
		$url_string = "lab_config_home.php?id=".$_REQUEST['lid'];
	else 
		$url_string = "lab_configs.php?id=0";
	if($is_done === true)
		$url_string .= "&revert=1";
	else
		$url_string .= "&revert=0";
	header("Location:".$url_string);
}

function dir_copy($src,$dst) { 
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

function updateDatabase() {
	global $labConfigId, $DB_HOST, $DB_USER, $DB_PASS;
	
	$country = strtolower(LabConfig::getUserCountry($labConfigId));
	$saved_db = DbUtil::switchToCountry($country);
	
	
	$currentDir = getcwd();
	$mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
	//$blisLabBackupFilePath = "\"".$mainBlisDir.$backup_folder."\blis_".$lab_config_id."\blis_".$lab_config_id."_backup.sql\"";
	$sqlFilePath = "\"".$mainBlisDir."htdocs\\export\\temp.sql\"";
	$mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
	$dbname = "blis_".$country;
	$command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname < $sqlFilePath";
	$command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
	echo $command;
	system($command, $return_var);
	if( $return_var == 0 )
		echo "true";
	else
		echo "false";
	DbUtil::switchRestore($saved_db);
	
}

function parseFile() {
	global $base, $dateFrom, $dateTo;

	$fileName = $_REQUEST["sqlFile"];
	$tempDumpFile = "temp.sql";
	$fileWriteHandle = null;
	$fileHandle = null;
	$currentTime = time();
	$fileWriteHandle = fopen($tempDumpFile, "w");
	
	if(file_exists($fileName)) {
		$fileHandle = fopen($fileName, "r");
		while(!feof($fileHandle)) {
			$line = fgets($fileHandle);
			$tsQuery = explode("\t",$line);
			$ts = date("Ymd",strtotime($tsQuery[0]));
			
			if( $dateFrom <= $ts && $ts <= $dateTo ) {
				$query = $tsQuery[1];
				$posP = stripos($query, "`patient`");
				$posS = stripos($query, "`specimen`");
				$posT = stripos($query, "`test`");
				if( $posP !== false || $posS !== false || $posT !== false ) {
					$insertOrNot = stripos($query, "INSERT");
					if( $insertOrNot !== false ) {
						$lineLength = strlen($query);
						if( $posP !== false ) {
							$position = stripos($query, "VALUES");
							if(	$position !== false ) {
								
								/*
								$startSplit = substr($query, 0, $position + 8);
								$endSplitInitial = substr($query, $position + 8, $lineLength);
								$endSplitPosition = stripos($endSplitInitial, ",");
								$localId = substr($endSplitInitial, 0, $endSplitPosition);
								$replacement = bcadd($base, $localId);
								$endSplit = substr($endSplitInitial, $endSplitPosition, strlen($endSplitInitial));
								$newQuery = $startSplit.$replacement.$endSplit.";";
								fwrite($fileWriteHandle, $newQuery);
								*/
							}
						}
						else {
							fwrite($fileWriteHandle, $newQuery);
							/*
							$position = stripos($query, "VALUES");
							if( $position !== false ) {
								$startSplit = substr($query, 0, $position + 8);
								$endSplitInitial = substr($query, $position + 8, $lineLength);
								$endSplitPosition = stripos($endSplitInitial, ",");
								$localId = substr($endSplitInitial, 0, $endSplitPosition);
								$localId = intval($localId);
								$replacement1 = bcadd($base, $localId);
								$endSplitInitial = substr($endSplitInitial, $endSplitPosition + 1, $lineLength);
								$endSplitPosition = stripos($endSplitInitial, ",");
								$localId = substr($endSplitInitial, 0, $endSplitPosition);
								$localId = intval($localId);
								$replacement2 = bcadd($base, $localId);
								$endSplit = substr($endSplitInitial, $endSplitPosition + 1, strlen($endSplitInitial));
								$newQuery = $startSplit.$replacement1.", ".$replacement2.", ".$endSplit.";";
								fwrite($fileWriteHandle, $newQuery);
							}
							*/
						}
					}
					else {
							$updateOrNot = stripos($query, "UPDATE");
							if($updateOrNot !== false ) {
								/*
								$lineLength = strlen($query);
								$position = strrpos($query, "=");
								$startSplit = substr($query, 0, $position+1);
								$localId = substr($query, $position+1, strlen($query));
								$localId = intval($localId);
								$replacement = bcadd($base, $localId);
								$newQuery = $startSplit.$replacement.";\n";
								*/
								fwrite($fileWriteHandle, $query);
							}
					}
				}
				else
					continue;
			}
		}
	}
	fclose($fileHandle);
	fclose($fileWriteHandle);
}

parseFile();
//updateDatabase();
/*
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
	performUpdate($lab_config_id, $backup_folder);
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
page_redirect($returnStatus);
*/
include("../includes/footer.php");
?>