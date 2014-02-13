<?php

include("redirect.php");
include("../includes/header.php");
include("../includes/db_constants.php");
$lab_config_id=$_REQUEST['id'];
$user = get_user_by_id($_SESSION['user_id']);
$country = $user->country;

global $DB_HOST,$DB_USER,$DB_PASS;
		
$currentDir = getcwd();		
$mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
$mysqldumpPath = "\"".$mainBlisDir."server\mysql\bin\mysqldump.exe\"";
$dbname = "blis_".$lab_config_id;
$backupLabDbFileName= "blis_".$lab_config_id."_configuration.sql";
$count=0;
$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname > $backupLabDbFileName";
system($command,$return);
$file_list1[] = $backupLabDbFileName;
		
$dbname = "blis_revamp";
$backupDbFileName = "blis_revamp_configuration.sql";
$command = $mysqldumpPath." -B -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname > $backupDbFileName";
system($command,$return);
$file_list2[] = $backupDbFileName;

$lab_config = LabConfig::getById($lab_config_id);
$site_name = str_replace(" ", "-", $lab_config->getSiteName());
$destination = "../../blis_configuration_".$site_name."_".$country."/";
$toScreenDestination = "blis_configuration_".$site_name."_".$country;
@mkdir($destination);
@mkdir($destination."blis_revamp/");
@mkdir($destination."blis_".$lab_config_id."/");
chmod($destination, 777);

foreach($file_list1 as $file) {
	$file_name_parts = explode("/", $file);
	$target_file_name = $destination."blis_".$lab_config_id."/".$file_name_parts[count($file_name_parts)-1];
	$ourFileHandle = fopen($target_file_name, 'w') or die("can't open file");
	fclose($ourFileHandle);
	if(!copy($file, $target_file_name)) {
		//echo "Error: $file $destination.$file <br>";
		return false;
	};
}
unlink($backupLabDbFileName);
		
foreach($file_list2 as $file) {
	$file_name_parts = explode("/", $file);
	if(!copy($file, $destination."blis_revamp/".$file_name_parts[count($file_name_parts)-1])) {	
		//echo "Error: $file $destination.$file <br>";
		return false;
	};
}
unlink($backupDbFileName);
?>

<br><br>Lab Configuration created successfully at <?php echo $toScreenDestination; ?> under BLIS Directory. The lab id is <?php echo $lab_config_id; ?>.
<br><br>Please follow the steps below to create a complete copy of BLIS at the new lab.
<br><br>1. Create a copy of the main BLIS folder onto a USB Drive or CD.
<br>2. Carry over this USB Drive or CD to the new lab and copy the folder to the lab computer.
<br>3. From the lab computer, run the file named installBLIS.bat and when prompted enter the Lab Id, location and country.
<br><br> Once you get the installed successfully message, double click BLIS.exe to launch the system. You can then login with the administrator 
username and password you created and begin configuring the system for use.

<?php
include("../includes/footer.php");
?>