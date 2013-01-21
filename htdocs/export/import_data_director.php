<?php
include("redirect.php");
include("../includes/db_lib.php");

    //$fileName = $_REQUEST["sqlFile"];
    $fileName = $_FILES['sqlFile']['tmp_name'];
    //move_uploaded_file($_FILES["file"]["tmp_name"],$name);
   // echo $fileName.'<br><pre>';
    //print_r($_FILES);
    //echo "++".$_FILES['SQLimportForm']['name'];
    //echo '</pre><br>';
    $currentDir = getcwd();
    $mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
    $blisLabBackupFilePath = "\"".$mainBlisDir."\htdocs\export\blis_129_temp_backup.sql\"";
    $mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
    //$backupLabDbFileName = "\"".$mainBlisDir."backups\\"."testsql.sql\"";
    $command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS  < $fileName";
    $command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
    echo $command;
    system($command, $return);
    //echo "R=".$return."*";
$result = $return;
sleep(2);
?>

<script language="javascript" type="text/javascript">
   window.top.window.stopUpload(<?php echo $result; ?>);
</script> 
