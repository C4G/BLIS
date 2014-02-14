<?php
#
# Creates data backup
#

include("redirect.php");
include("includes/db_lib.php");

if($SERVER == $ON_ARC)
{
	# System on arc2 server: Do not allow backup option
	echo "Sorry, data backup option is not available in online version.";
	return;
}

/* creates a compressed zip file */
function create_zip($files1 = array(), $files2 = array(), $files3 = array(), $destination = '',$overwrite = false, $lab_config_id) 
{
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files1 = array();
	$valid_files2 = array();
	//if files were passed in...
	if(is_array($files1)) 
	{
		//cycle through each file
		foreach($files1 as $file) 
		{
			//make sure the file exists
			if(file_exists($file)) 
			{
				$valid_files1[] = $file;
			}
		}
	}
	if(is_array($files2)) 
	{
		//cycle through each file
		foreach($files2 as $file) 
		{
			//make sure the file exists
			if(file_exists($file)) 
			{
				$valid_files2[] = $file;
			}
		}
	}
	if(is_array($files3)) 
	{
		//cycle through each file
		foreach($files3 as $file) 
		{
			//make sure the file exists
			if(file_exists($file)) 
			{
				$valid_files3[] = $file;
			}
		}
	}
	//create the archive
	$zip = new ZipArchive();
	//if($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) 
	if($zip->open($destination, ZIPARCHIVE::OVERWRITE) !== true) 
	{
		return false;
	}
	//if we have good files...
	if(count($valid_files1)) 
	{
		//add the files
		foreach($valid_files1 as $file) 
		{
			$file_parts = explode("/", $file);
			$zip->addFile($file, "blis_".$lab_config_id."/".$file_parts[4]);
		}
	}
	if(count($valid_files2)) 
	{
		//add the files
		foreach($valid_files2 as $file) 
		{
			$file_parts = explode("/", $file);
			$zip->addFile($file, "blis_revamp/".$file_parts[4]);
		}
	}
	if(count($valid_files3)) 
	{
		//add the files
		foreach($valid_files3 as $file) 
		{
			$file_parts = explode("/", $file);
			$zip->addFile($file, "langdata/".$file_parts[2]);
		}	
	}
	$timestamp = date("Y-m-d H:i");
	$lab_config = LabConfig::getById($lab_config_id);
	$site_name = $lab_config->getSiteName();
	$readme_content = "";
	if($_SESSION['locale'] != "fr")
	{
	$readme_content = <<<EOF
BLIS Data Backup
================
Facility: $site_name .
Backup date and time: $timestamp .
To restore data, copy and overwrite folders named "blis_revamp" and "blis_$lab_config_id" in "dbdir" directory.
To restore language translation values, copy and overwrite folder named "langdata" in "htdocs" directory.
-
EOF;
	}
	else
	{
	$readme_content = <<<EOF
BLIS Data Backup
================
Facilité: $site_name .
Date de sauvegarde et de temps: $timestamp .
Pour restaurer les données, de copier et écraser les dossiers nommés "blis_revamp" et "blis_$lab_config_id" dans "dbdir" dossier".
Pour restaurer les valeurs de la traduction, copier le répertoire et remplacer le nom "langdata" dans "htdocs" dossier.
-
EOF;
	}
	$zip->addFromString('readme.txt', $readme_content);
	//debug
	echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->getStatusString();
	//close the zip -- done!
	$zip->close();
	//check to make sure the file exists
	return file_exists($destination);
}

function create_backup($lab_config_id)
{
	$lab_config = LabConfig::getById($lab_config_id);
	$site_name = $lab_config->name;
	$site_name = str_replace(" ", "-", $site_name);
	$timestamp = date("Ymd-hi");
	$file_list1 = array(); # dbdir/blis_xxx
	$file_list2 = array(); # dbdir/blis_revamp
	$file_list3 = array(); # htdocs/langdata
	$dir_name = "../../dbdir/blis_".$lab_config_id;
	$count=0;
	if ($handle = opendir($dir_name))
	{
		while (false !== ($file = readdir($handle))) 
		{
			if($file === "." || $file == "..")
				continue;
			$file_list1[] = $dir_name."/$file";
			$count++;
			print $dir_name."/$file";
		}
		print "\n number of files";
		print $count;
		$dir_name = "../../dbdir/blis_revamp";
		if ($handle = opendir($dir_name))
		{
			while (false !== ($file = readdir($handle))) 
			{
				if($file === "." || $file == "..")
					continue;
				$file_list2[] = $dir_name."/$file";
			}
			$dir_name = "../../locale/langdata";
			if ($handle = opendir($dir_name))
			{
				while (false !== ($file = readdir($handle))) 
				{
					if($file === "." || $file == "..")
						continue;
					$file_list3[] = $dir_name."/$file";
				}
				$zip_file_name = $site_name."_".$timestamp.".zip";
				$result = create_zip($file_list1, $file_list2, $file_list3, $zip_file_name, true, $lab_config_id);
			}
		}
	}
	
	# Send file stream to user for download
	$file = $zip_file_name;
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
	unlink($file);
}


#
# Execution begins here
#

$lab_config_id = $_REQUEST['id'];
create_backup($lab_config_id);
echo "hiral";
?>