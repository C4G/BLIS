<?php
#
# Contains commonly used functions for performing backup or reverting to a backup
#
include("../includes/db_lib.php");

class BackupLib
{
	public static function performBackup($lab_config_id, $currentDir, $include_langdata=true)
	{
		# Performs backup of current data for a lab
		global $SERVER, $ON_ARC;
		if($SERVER == $ON_ARC)
		{
			# System on arc2 server: Do not allow backup option
			return false;
		}
	
		$file_list1 = array();
		$file_list2 = array();
		$file_list3 = array();
		
		$DB_HOST = localhost;
		$DB_USER = root;
		$DB_PASS = blis123;
		
		$mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
		$mysqldumpPath = "\"".$mainBlisDir."server\mysql\bin\mysqldump.exe\"";
		$dbname = "blis_".$lab_config_id;
		$backupLabDbFileName= "blis_".$lab_config_id."_backup.sql";
		$count=0;
		$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname > $backupLabDbFileName";
		system($command,$return);
		$file_list1[] = $backupLabDbFileName;
		
		$dbname = "blis_revamp";
		$backupDbFileName = "blis_revamp_backup.sql";
		$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname > $backupDbFileName";
		system($command,$return);
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
		db_close();
		$site_name = str_replace(" ", "-", $lab_config->getSiteName());
		$destination = "../../blis_backup_".$site_name."_".date("Ymd-Hi")."/";
		@mkdir($destination);
		@mkdir($destination."blis_revamp/");
		@mkdir($destination."blis_".$lab_config_id."/");
		@mkdir($destination."langdata_".$lab_config_id."/");
		chmod($destination, 777);
		
		foreach($file_list1 as $file) {
			$file_name_parts = explode("/", $file);
			$target_file_name = $destination."blis_".$lab_config_id."/".$file_name_parts[count($file_name_parts)-1];
			$ourFileHandle = fopen($target_file_name, 'w') or die("can't open file");
			fclose($ourFileHandle);
			if(!copy($file, $target_file_name))
			{
				//echo "Error: $file $destination.$file <br>";
				return false;
			};
		}
		
		foreach($file_list2 as $file) {
			$file_name_parts = explode("/", $file);
			if(!copy($file, $destination."blis_revamp/".$file_name_parts[count($file_name_parts)-1]))
			{	
				//echo "Error: $file $destination.$file <br>";
				return false;
			};
		}
		
		foreach($file_list3 as $file)
		{
			$file_name_parts = explode("/", $file);
			if(!copy($file, $destination."langdata_".$lab_config_id."/".$file_name_parts[count($file_name_parts)-1]))
			{
				//echo "Error: $file $destination.$file <br>";
				return false;
			};
		}
		
		# All okay
		return true;
	}
}