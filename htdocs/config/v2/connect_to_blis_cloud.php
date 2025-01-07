<?php

require_once(__DIR__."/../../includes/composer.php");
require_once(__DIR__."/../../includes/keymgmt.php");
require_once(__DIR__."/../../includes/platform_lib.php");
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
$is_localhost = $p_url["host"] == "localhost";
$is_localnetwork = substr($p_url["host"], 0, 8) == "192.168.";
if ($p_url["scheme"] != "https" && !$is_localhost && !$is_localnetwork) {
    $_SESSION["FLASH"] = "You must specify a secure URL (starting with https://) for BLIS Cloud.";
    header('HTTP/1.1 400 Bad Request', true, 400);
    header("Location: /lab_config_home.php?id=$lab_config_id");
    exit;
}

$post = array('action'=> 'connect', 'public_key'=> '', 'lab_name'=>$lab_config_name, 'connection_code'=> $connect_code);

$log->info("Connecting to BLIS cloud with URL: ".$connect_url);

$curl_cmd = PlatformLib::curlPath();
$curl_cmd = $curl_cmd . " -i --show-error -X POST ";
if (PlatformLib::runningOnWindows()) {
    // The Windows version of cURL is newer than the one we might have on Linux
    // (especially Ubuntu 20.04) so we can add this new option.
    $curl_cmd = $curl_cmd . "--fail-with-body ";
} else {
    $curl_cmd = $curl_cmd . "--fail ";
}
foreach($post as $key=>$value) {
    $curl_cmd = $curl_cmd . " -F \"$key=$value\"";
}
$curl_cmd = $curl_cmd . " $connect_url";

$NUM_RETRIES = 5;

for ($x = 0; $x < $NUM_RETRIES; $x = $x + 1) {
    $log->info("Attempt #" . ($x + 1));

    ob_start();
    system($curl_cmd, $return_code);
    $output = ob_get_contents();
    ob_end_clean();

    if ($return_code == 0 && strlen($output) > 0) {
        // HACK HACK HACKITY HACK
        // If there is ever a space in the output we're in trouble!
        // Really we're in trouble for a lot of reasons with this code.
        $resp_beginning = strpos($output, "{\"");
        $parseable_output = substr($output, $resp_beginning);

        $r_json = json_decode($parseable_output, true);

        $new_conncode = $r_json["connection_code"];
        $server_pubkey = base64_decode($r_json["public_key"]);

        $key_lab_name = "BLIS Cloud Connection for $lab_config_name";
        $key = KeyMgmt::create($key_lab_name, $server_pubkey, $current_user_id);
        KeyMgmt::add_key_mgmt($key);
        $key = KeyMgmt::getByLabName($key_lab_name);
        $key_id = $key->ID;

        $lc_update_query = "UPDATE lab_config SET blis_cloud_hostname = '" . db_escape($connect_url) . "',"
                         . "blis_cloud_connection_key = '" . db_escape($new_conncode) . "',"
                         . "blis_cloud_server_pubkey_id = $key_id WHERE lab_config.lab_config_id = $lab_config_id";

        query_update($lc_update_query);

        $failure = false;
        break;
    } else {
        if (strlen($output) == 0) {
            $outstr = "Output is empty!";
        } else {
            $outstr = "Output: $output";
        }
        $log->warn("Request failed. Curl exit code: $return_code. $outstr");
        $failure = true;
    }
}

if ($failure) {
    $_SESSION['FLASH'] = "There was an error establishing the connection. Check the logs for details.";
} else {
    $_SESSION['FLASH'] = "Connection established successfully.";
}

header("Location: /lab_config_home.php?id=$lab_config_id");
