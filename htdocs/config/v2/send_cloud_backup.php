<?php

require_once(__DIR__."/../../includes/composer.php");
require_once(__DIR__."/../../includes/keymgmt.php");
require_once(__DIR__."/../../includes/platform_lib.php");
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
    header(LangUtil::$generalTerms['404_BAD_REQUEST'], true, 401);
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

// AES256 is probably not the best choice of encryption algorithm.
// This should be dynamic, or more centrally managed somewhere.
$cipher_algo = "aes-256-cbc";
$iv_required = openssl_cipher_iv_length($cipher_algo) != false;
$iv = null;
$iv_b64 = '';

$ossl_result = openssl_seal($backup_blob, $sealed_data, $ekeys, array($ossl_pubkey), "aes-256-cbc", $iv);
if ($ossl_result === false) {
    $log->error("Could not encrypt backup: " . openssl_error_string());
    $_SESSION["FLASH"] = "Error sending backup.";
    header("Location: /lab_config_home.php?id=$lab_config_id");
    exit();
}

$encpath = $latest_backup->full_path . ".cloud_encrypted";
file_put_contents($encpath, $sealed_data);

$log->info("Backup " . $latest_backup->full_path . " encrypted successfully.");

$ekey = base64_encode($ekeys[0]);
if ($iv_required) {
    $iv_b64 = base64_encode($iv);
}

$curlfile = curl_file_create(realpath($encpath));

$post = array(
    'action'=>'backup',
    'connection_code'=>$connect_code,
    'backup_file'=>$curlfile,
    'backup_date'=>$latest_backup->timestamp,
    'envelope_key'=>$ekey,
    'iv'=>$iv_b64,
);

$log->info("Sending backup to BLIS cloud with URL: ".$connect_url);

$ch = curl_init($connect_url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

$NUM_RETRIES = 5;

for ($x = 0; $x < $NUM_RETRIES; $x = $x + 1) {
    $log->info("Attempt #" . ($x + 1));

    $result = curl_exec($ch);

    if ($result === false) {
        $log->warning("Request failed. Curl error: " . curl_error($ch));
        $failure = true;
        continue;
    }

    $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    if ($code !== 200) {
        $log->warning("Received a non-200 status code: $code" . $result);
        $failure = true;
        continue;
    }

    $resp = json_decode($result, true);
    $new_connection_code = $resp["connection_code"];
    $lc_update_query = "UPDATE lab_config SET blis_cloud_connection_key = '" . db_escape($new_connection_code)
        . "' WHERE lab_config.lab_config_id = $lab_config_id";
    query_update($lc_update_query);
    $log->info("Backup sent and connection code refreshed!");
    unlink($encpath);
    $failure = false;
    break;
}

if (!$failure) {
    $_SESSION['FLASH'] = "Backup sent successfully.";
} else {
    $_SESSION['FLASH'] = "There was an error sending the backup. Check the logs for details.";
}

header("Location: /lab_config_home.php?id=$lab_config_id");
