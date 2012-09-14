<?php

include("../includes/db_lib.php");
if($SERVER == $ON_ARC)
{
	# System on arc2 server: Do not allow backup option
	echo "Sorry, data backup option is not available in online version.";
	return;
}

$lab_config_id = $_REQUEST['id'];
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
$file_list1[] = $backupLabDbFileName;

$dbname = "blis_revamp";
$backupDbFileName = "blis_revamp_backup.sql";
$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname > $backupDbFileName";
system($command);
$file_list2[] = $backupDbFileName;

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
unlink($backupLabDbFileName);

foreach($file_list2 as $file)
{
	$file_name_parts = explode("/", $file);
	if(!copy($file, $destination."blis_revamp/".$file_name_parts[count($file_name_parts)-1]))
	{
		echo "Error: $file -> $destination.$file <br>";
	};
}
unlink($backupDbFileName);

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
	copy($log_file1, $destination."log_".$lab_config_id.".txt");
	unlink($log_file1);
}
if( file_exists($log_file2) ) {
	copy($log_file2, $destination."log_".$lab_config_id."_updates.sql");
	unlink($log_file2);
}
if( file_exists($log_file3) ) {
	copy($log_file3, $destination."log_".$lab_config_id."_revamp_updates.sql");
	unlink($log_file3);
}



# All okay
?>

Backup folder created: <b><?php echo $destination; ?></b> under "blis_portable" directory.
<br><br>
Please copy this folder to your disk as backup.
<br>
--