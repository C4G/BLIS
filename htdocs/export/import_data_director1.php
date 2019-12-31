<?php

include("redirect.php");
include("../includes/db_lib.php");
$file_name = $_FILES['sqlFile']['name'];
$file_name_and_extension = explode('.', $file_name);
$fileName = $_FILES['sqlFile']['tmp_name'];
if($file_name_and_extension[1]=="zip")
{
$name=getcwd()."/uploads/".$file_name;
move_uploaded_file($fileName,$name);
$is_encrypted=false;
if(endsWith($file_name,"_enc.zip"))
$is_encrypted=true;

$extractPath=getcwd().'/uploads/'.$file_name_and_extension[0];
$zip = new ZipArchive;
if ($zip->open($name) === TRUE) {
    $zip->extractTo($extractPath);
    $zip->close();
$sqlFile="";
$langFile="";
$sqlFolder="";
$keyFile="";
foreach (new DirectoryIterator($extractPath) as $fileInfo) {
    if($fileInfo->isDot()||$fileInfo->isFile()) continue;
$fname=$fileInfo->getFilename();
if($fname==="blis_revamp")
continue;
else
{
if(startsWith($fname,"blis_"))
{
$sqlFile=$fname."/".$fname."_backup.sql";
$sqlFolder=$fname;
if($is_encrypted)
$keyFile=$fname."/".$fname.".sql.key";
}
else if(startsWith($fname,"langdata"))
$langFile=$fname;
else
continue;
} 
}
//~~
$file_name_parts = explode("_",$sqlFolder );
$lid = $file_name_parts[1];

    $currentDir = getcwd();
    $mainBlisDir = substr($currentDir,0,strpos($currentDir,"htdocs"));

    $mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";

$fileName=$extractPath."/".$sqlFile;

    $command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS  < ".$fileName;

    $command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
$pvt="../ajax/LAB_dir.blis";
if($is_encrypted)
{
if(file_exists($pvt))
{
decryptFile($fileName,$pvt);
    $command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS  < ".$fileName.".dec";
    $command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
}
else
{
//error handling if key not downloaded, pending.
}
}


    system($command, $return);
if($is_encrypted)
unlink($fileName.".dec");
$result = $return;
if($result == 0)
{
    insert_import_entry(intval($lid));
}
sleep(2);
#the following code copies folder containing langdata_<labid> files from back up to the local folder 

$src_langdata_path = $extractPath."/".$langFile;
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

}
else
$result=1;
}
else
$result=1;

function startsWith ($string, $startString) 
{
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
} 

function endsWith($haystack, $needle) {
    return substr($haystack,-strlen($needle))===$needle;
}
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

?>
<script language="javascript" type="text/javascript">

   window.top.window.stopUpload(<?php echo $result; ?>);
</script> 
