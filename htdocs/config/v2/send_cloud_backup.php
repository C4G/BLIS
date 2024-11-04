<?php

require_once(__DIR__."/../../includes/composer.php");
require_once(__DIR__."/../../includes/keymgmt.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/lib/backup.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$lab_config_id = $_REQUEST['lab_config_id'];
$lab_config_query = "SELECT lab_config_id, blis_cloud_hostname, blis_cloud_connection_key, blis_cloud_server_pubkey_id FROM lab_config WHERE lab_config_id = '$lab_config_id';";
db_change("blis_revamp");
$lab = query_associative_one($lab_config_query);

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    // If the user is not a super admin or country director, they should only
    // be able to access data for their own lab, and only if they are an admin.
    if ($lab_config_id == $current_user->labConfigId && is_admin($current_user)) {
        $unauthorized = false;
    }
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header("Location: /home.php");
    exit;
}

$connect_url = $lab["blis_cloud_hostname"];
$connect_code = $lab["blis_cloud_connection_key"];
$server_key_id = $lab["blis_cloud_server_pubkey_id"];

$log->warn(json_encode($lab));

$server_pubkey = KeyMgmt::getById($server_key_id);
$server_pubkey_text = $server_pubkey->PubKey;
$server_pubkey_text = str_replace(" ", "\n", $server_pubkey_text);
$log->warn($server_pubkey_text);
$ossl_pubkey = openssl_get_publickey($server_pubkey_text);
if ($ossl_pubkey == false) {
    $log->error("Could not get server pubkey: " . openssl_error_string());
    $_SESSION["FLASH"] = "Error sending backup.";
    header("Location: /lab_config_home.php?id=$lab_config_id");
    exit();
}

$lab_backups = Backup::for_lab_config_id($lab_config_id);
$latest_backup = $lab_backups[0];

$backup_blob = file_get_contents($latest_backup->full_path);

$ossl_result = openssl_seal($backup_blob, $sealed_data, $ekeys, array($ossl_pubkey), "AES256", $iv);
if ($ossl_result == false) {
    $log->error("Could not encrypt backup: " . openssl_error_string());
    $_SESSION["FLASH"] = "Error sending backup.";
    header("Location: /lab_config_home.php?id=$lab_config_id");
    exit();
}

$tmpfil = tmpfile();
$tmpmeta = stream_get_meta_data($tmpfil);
$tmppath = $tmpmeta['uri'];
fwrite($tmpfil, $sealed_data);
fseek($tmpfil, 0);

if (function_exists('curl_file_create')) {
    // For PHP 5.5+, which is what we use in the BLIS docker image
    $curlfile = curl_file_create($tmppath, 'application/octet-stream');
} else {
    // For old-school PHP, which is in-use by the Desktop BLIS
    $curlfile = '@' . realpath($tmppath);
    $log->info("Resolved path to: $curlfile");
}

$post = array('action'=>'backup', 'connection_code'=>$connect_code,'backup_file'=>$curlfile,'envelope_key'=>$iv);

$log->info("Sending backup to BLIS cloud with URL: ".$connect_url);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $connect_url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($curl);
curl_close($curl);

fclose($tmpfil);

$_SESSION['FLASH'] = "Backup sent successfully.";
header("Location: /lab_config_home.php");
