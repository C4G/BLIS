<?php

require_once("redirect.php");
require_once("../includes/db_lib.php");
require_once("../includes/platform_lib.php");
require_once("../includes/composer.php");

$file_name = $_FILES['sqlFile']['name'];
$log->info("Uploaded $file_name");
$file_name_and_extension = explode('.', $file_name);
$fileName = $_FILES['sqlFile']['tmp_name'];
if ($file_name_and_extension[1]=="zip") {
    $name=getcwd()."/uploads/".$file_name;
    move_uploaded_file($fileName, $name);
    $is_encrypted=false;
    if (endsWith($file_name, "_enc.zip")) {
        $is_encrypted=true;
    }

    $extractPath=dirname(__FILE__).'/uploads/'.$file_name_and_extension[0];
    $zip = new ZipArchive;
    if ($zip->open($name) === true) {
        $zip->extractTo($extractPath);
        $zip->close();
        $sqlFile="";
        $langFile="";
        $sqlFolder="";
        $keyFile="";
        foreach (new DirectoryIterator($extractPath) as $fileInfo) {
            if ($fileInfo->isDot()||$fileInfo->isFile()) {
                continue;
            }
            $fname=$fileInfo->getFilename();
            if ($fname==="blis_revamp") {
                continue;
            } else {
                if (startsWith($fname, "blis_")) {
                    $sqlFile=$fname."/".$fname."_backup.sql";
                    $sqlFolder=$fname;
                    if ($is_encrypted) {
                        $keyFile=$fname."/".$fname.".sql.key";
                    }
                } elseif (startsWith($fname, "langdata")) {
                    $langFile=$fname;
                } else {
                    continue;
                }
            }
        }

        //~~
        $file_name_parts = explode("_", $sqlFolder);
        $lid = $file_name_parts[1];
        $fileName=$extractPath."/".$sqlFile;

        $mysqlExePath = "\"".PlatformLib::mySqlClientPath()."\"";
        $command = $mysqlExePath." -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS  < ";
        if(PlatformLib::runningOnWindows()) {
            // the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
            $command = "C: &".$command;
        }

        $pvt=dirname(__FILE__)."/../ajax/LAB_dir.blis";
        if ($is_encrypted) {
            if (file_exists($pvt)) {
                $decryptedFile = decryptFile($fileName, $pvt);
                $command = $command . $decryptedFile;
            } else {
                error_log("File $fileName is encrypted, but the server does not have a private key file generated yet.");
                // error handling if key not downloaded, pending.
            }
        } else {
            $command = $command . $fileName;
        }

        system($command, $return);
        $result = $return;

        if ($is_encrypted) {
           unlink($fileName.".dec");
        }

        if ($result == 0) {
            insert_import_entry(intval($lid));
        }

        sleep(2);

        #the following code copies folder containing langdata_<labid> files from back up to the local folder

        $src_langdata_path = trim($extractPath."/".$langFile);
        $dest_path = dirname(__FILE__)."/../../local/langdata_".$lid;
        $res = PlatformLib::copyDirectory($src_langdata_path, $dest_path);
        if (!$res) {
           error_log("There was a problem copying the langdata folder.");
        }

        // the following code adds lab admin to user and user_config tables
        // in blis_revamp when developers are importing a backup into the app on their machine
        $dev = 1;
        $adminName = 'admin_'.$lid;
        $lab_admin_id = checkAndAddAdmin($adminName, $lid, $dev);

        checkAndAddUserConfig($lab_admin_id);

        // the following code adds lab config to lab_config table in blis_revamp when developers
        // are importing a backup into the app on their machine
        $lab_config = new LabConfig();
        $lab_config->adminUserId = $lab_admin_id;
        $lab_config->id = $lid;
        add_lab_config($lab_config, $dev);

        #the following code adds user id of the admin for imported lab and the lab id are added to lab_access_config table of the revamp db
        add_lab_config_access($lab_admin_id, $lid);
    } else {
        $result=1;
    }
} else {
    $result=1;
}

function startsWith($string, $startString)
{
    $len = strlen($startString);
    return substr($string, 0, $len) === $startString;
}

function endsWith($haystack, $needle)
{
    return substr($haystack, -strlen($needle)) === $needle;
}
function decryptFile($fname, $pvt)
{
    if (!file_exists($fname.".key") || !file_exists($pvt)) {
        error_log("Both of these files must exist but at least one does not: $fname.key, $pvt");
        return;
    }

    $private_key_id = openssl_get_privatekey(file_get_contents($pvt));
    $env_key=file_get_contents($fname.".key");
    $env_key=base64_decode($env_key);

    $sealed=file_get_contents($fname);
    $open = '';
    $res = openssl_open($sealed, $open, $env_key, $private_key_id);
    openssl_free_key($private_key_id);

    if (!$res) {
        return "";
    }

    file_put_contents($fname.".dec", $open);

    // Return the filename of the decrypted file
    return $fname.".dec";
}

?>

<script language="javascript" type="text/javascript">
   window.top.window.stopUpload(<?php echo $result; ?>);
</script>
