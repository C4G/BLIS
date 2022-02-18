<?php
include("redirect.php");
include("../includes/db_lib.php");

    //$fileName = $_REQUEST["sqlFile"];
$file_name = $_FILES['sqlFile']['name'];
$file_name_and_extension = explode('.', $file_name);
$file_name_parts = explode("_", $file_name_and_extension['0']);
$lid = $file_name_parts[1];
    $fileName = $_FILES['sqlFile']['tmp_name'];
    //move_uploaded_file($_FILES["file"]["tmp_name"],$name);
   // echo $fileName.'<br><pre>';
    print_r($_FILES);
    //echo "++".$_FILES['SQLimportForm']['name'];
    //echo '</pre><br>';
    $currentDir = getcwd();
    $mainBlisDir = substr($currentDir,0,strpos($currentDir,"htdocs"));
    $blisLabBackupFilePath = "\"".$mainBlisDir."\htdocs\export\blis_129_temp_backup.sql\"";
    $mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
    //$backupLabDbFileName = "\"".$mainBlisDir."backups\\"."testsql.sql\"";
    $command = $mysqlExePath." -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS  < $fileName";
    $command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
    echo $command;
    system($command, $return);
    //echo "R=".$return."*";
$result = $return;
if($result == 0)
{
    insert_import_entry(intval($lid));
}
sleep(2);

#the following code copies folder containing langdata_<labid> files from back up to the local folder 

$src_langdata_path = $_REQUEST['lang_data_folder_path'];
$dest_path = "\"".$currentDir."\..\..\local\langdata_".$lid."\"";
$lang_data_command = "echo d | xcopy /s /Y "."\"".trim($src_langdata_path)."\" ". $dest_path;
$lang_data_command = "C: &".$lang_data_command;
system($lang_data_command, $return);

#the following code adds lab admin to user and user_cofig tables in revamp when developers are importing a backup into the app on their machine
$dev = 1;
$adminName = 'admin_'.$lid;
$lab_admin_id = checkAndAddAdmin($adminName, $lid, $dev);

checkAndAddUserConfig($lab_admin_id);

#the following code adds lab config to lab_config table in revamp when developers are importing a backup into the app on their machine
$lab_config = new LabConfig();
$lab_config->adminUserId = $lab_admin_id;
$lab_config->id = $lid;
add_lab_config($lab_config, $dev);

#the following code adds user id of the admin for imported lab and the lab id are added to lab_access_config table of the revamp db
add_lab_config_access($lab_admin_id, $lid);

?>

<script language="javascript" type="text/javascript">
    console.log('<?php echo $fileName; ?>');
   window.top.window.stopUpload(<?php echo $result; ?>);
</script> 
