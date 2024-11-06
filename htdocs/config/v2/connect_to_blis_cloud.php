<?php

require_once(__DIR__."/../../includes/composer.php");
require_once(__DIR__."/../../includes/keymgmt.php");
require_once(__DIR__."/../../includes/user_lib.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$lab_config_id = $_REQUEST['lab_config_id'];
$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
//db_change($lab['db_name']);
$lab_config_name = $lab['name'];

db_change("blis_revamp");

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

$connect_url = $_REQUEST['blis-cloud-url'];
$connect_code = $_REQUEST['blis-cloud-code'];

$p_url = parse_url($connect_url);
if ($p_url["scheme"] != "https" && $p_url["host"] != "localhost") {
    $_SESSION["FLASH"] = "You must specify a secure URL (starting with https://) for BLIS Cloud.";
    header('HTTP/1.1 400 Bad Request', true, 400);
    header("Location: /lab_config_home.php");
    exit;
}

$post = array('action'=> 'connect', 'public_key'=> '', 'lab_name'=>$lab_config_name, 'connection_code'=> $connect_code);

$log->info("Connecting to BLIS cloud with URL: ".$connect_url);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $connect_url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode != 200) {
    $_SESSION['FLASH'] = "There was an error establishing the connection. Check the logs for details.";
    $log->error("Error connecting to server. URL: $connect_url, response status: $httpCode, response: $response");
} else {
    $r_json = json_decode($response, true);

    $new_conncode = $r_json["connection_code"];
    $server_pubkey = $r_json["public_key"];

    $key_lab_name = "BLIS Cloud Connection for $lab_config_name";
    $key = KeyMgmt::create($key_lab_name, $server_pubkey, $current_user_id);
    KeyMgmt::add_key_mgmt($key);
    $key = KeyMgmt::getByLabName($key_lab_name);
    $key_id = $key->ID;

    $lc_update_query = "UPDATE lab_config SET blis_cloud_hostname = '" . db_escape($connect_url) . "',"
                     . "blis_cloud_connection_key = '" . db_escape($new_conncode) . "',"
                     . "blis_cloud_server_pubkey_id = $key_id WHERE lab_config.lab_config_id = $lab_config_id";

    query_update($lc_update_query);

    $_SESSION['FLASH'] = "Connection established successfully.";
}

header("Location: /lab_config_home.php?id=$lab_config_id");
