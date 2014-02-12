<?php

include("redirect.php");
include("../includes/db_lib.php");
//include("../includes/db_constants.php");

global $DB_HOST,$DB_USER,$DB_PASS;

$user = get_user_by_id($_SESSION['user_id']);
$country = strtolower($user->country);
	
$currentDir = getcwd();		
$mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
$mysqldumpPath = "\"".$mainBlisDir."server\mysql\bin\mysqldump.exe\"";
$dbName = "blis_".$country;
$backupDbFileName= "blis_".$country."_backup.sql";
$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbName > $backupDbFileName";
system($command,$return);
$file_list1[] = $backupDbFileName;

$destination = "../../blis_backup_".$country."_".date("Ymd-Hi")."/";
$toScreenDestination = "blis_backup_".$country."_".date("Ymd-Hi");
@mkdir($destination);
chmod($destination, 777);

foreach($file_list1 as $file) {
	$file_name_parts = explode("/", $file);
	$target_file_name = $destination."/".$file_name_parts[count($file_name_parts)-1];
	$ourFileHandle = fopen($target_file_name, 'w') or die("can't open file");
	fclose($ourFileHandle);
	if(!copy($file, $target_file_name)) {
		//echo "Error: $file $destination.$file <br>";
		return false;
	};
}
unlink($backupDbFileName);

echo "Database exported successfully to folder $toScreenDestination under BLIS Directory";
?>