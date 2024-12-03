<?php

require_once(__DIR__."/../../includes/composer.php");
require_once(__DIR__."/../../includes/keymgmt.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/lib/backup.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$lab_config_id = $_REQUEST['lab_config_id'];
$lab_config_query = "SELECT db_name, lab_config_id, blis_cloud_hostname, blis_cloud_connection_key, blis_cloud_server_pubkey_id FROM lab_config WHERE lab_config_id = '$lab_config_id';";
db_change("blis_revamp");
$lab = query_associative_one($lab_config_query);
$lab_db_name = $lab['db_name'];

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

$server_pubkey = KeyMgmt::getById($server_key_id);
$server_pubkey_text = $server_pubkey->PubKey;
$ossl_pubkey = openssl_get_publickey($server_pubkey_text);

if ($ossl_pubkey === false) {
    $log->error("Could not get server pubkey: " . openssl_error_string());
    $_SESSION["FLASH"] = "Error sending backup.";
    header("Location: /lab_config_home.php?id=$lab_config_id");
    exit();
}

db_change($lab_db_name);
$lab_backups = Backup::for_lab_config_id($lab_config_id);
if (count($lab_backups) < 1) {
    $log->error("No backups have been made of lab $lab_config_id");
    $_SESSION["FLASH"] = "Error sending backup.";
    header("Location: /lab_config_home.php?id=$lab_config_id");
    exit();
}

$latest_backup = $lab_backups[0];
db_change("blis_revamp");

$backup_blob = file_get_contents($latest_backup->full_path);

$log->info("Sending backup: " . $latest_backup->full_path . " to " . $connect_url);

// WARNING! RC4 is a very outdated and insecure encryption algorithm.
// This will prevent only the most simple attempts to decrypt the file.
// Unfortunately, the old version of PHP we use on Windows prevents anything newer (for now...)
$ossl_result = openssl_seal($backup_blob, $sealed_data, $ekeys, array($ossl_pubkey), "RC4");
if ($ossl_result === false) {
    $log->error("Could not encrypt backup: " . openssl_error_string());
    $_SESSION["FLASH"] = "Error sending backup.";
    header("Location: /lab_config_home.php?id=$lab_config_id");
    exit();
}

$log->info("Backup " . $latest_backup->full_path . " encrypted successfully.");

$tmpfil = tmpfile();
$tmpmeta = stream_get_meta_data($tmpfil);
$tmppath = $tmpmeta['uri'];
fwrite($tmpfil, $sealed_data);
fseek($tmpfil, 0);

$ekey = base64_encode($ekeys[0]);

$curl = curl_init();

if (function_exists('curl_file_create')) {
    // For PHP 5.5+, which is what we use in the BLIS docker image
    $curlfile = curl_file_create($tmppath, 'application/octet-stream');
} else {
    // For old-school PHP, which is in-use by the Desktop BLIS
    $curlfile = '@' . realpath($tmppath);
    curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
    $log->info("curl_file_create not available; using @-syntax. Resolved path to: $curlfile");
}

$post = array(
    'action'=>'backup',
    'connection_code'=>$connect_code,
    'backup_file'=>$curlfile,
    'backup_date'=>$latest_backup->timestamp,
    'envelope_key'=>$ekey
);

$log->info("Sending backup to BLIS cloud with URL: ".$connect_url);

curl_setopt($curl, CURLOPT_URL, $connect_url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($curl);

$failure = false;

if (curl_errno($curl)) {
    $log->warn("Curl error: " . curl_error($curl));
    $failure = true;
}

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ($httpCode != 200) {
    $log->warn("Request failed with status: $httpCode");
    $failure = true;
} else {
    $resp = json_decode($response, true);
    $new_connection_code = $resp["connection_code"];
    $lc_update_query = "UPDATE lab_config SET blis_cloud_connection_key = '" . db_escape($new_connection_code)
        . "' WHERE lab_config.lab_config_id = $lab_config_id";
    query_update($lc_update_query);
}

curl_close($curl);
fclose($tmpfil);

if (!$failure) {
    $_SESSION['FLASH'] = "Backup sent successfully.";
} else {
    $_SESSION['FLASH'] = "There was an error sending the backup. Check the logs for details.";
}

header("Location: /lab_config_home.php?id=$lab_config_id");
