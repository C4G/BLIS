<?php

require_once(__DIR__."/../users/accesslist.php");
require_once(__DIR__."/../includes/user_lib.php");
require_once(__DIR__."/../encryption/keys.php");

global $log;

$current_user_id = $_SESSION["user_id"];
$current_user = get_user_by_id($current_user_id);
$lab_config_id = $_REQUEST["lab_config_id"];
$key_id = $_REQUEST["key_id"];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
db_change($lab["db_name"]);

$super_admin_or_country_dir = is_super_admin($current_user) || is_country_dir($current_user);

$unauthorized = true;

if ($super_admin_or_country_dir) {
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
    header(LangUtil::$generalTerms['401_UNAUTHORIZE'], true, 401);
    header("Location: /home.php");
    exit;
}

$key = Key::find($key_id);

if (!$key) {
    header("Not Found", true, 404);
    exit;
}

$pubkey_contents = "";
if ($key->type != Key::$PUBLIC) {
    $keypair = base64_decode($key->data);
    $pubkey = sodium_crypto_box_publickey($keypair);
    $pubkey_contents = base64_encode($pubkey);
    sodium_memzero($keypair);
} else {
    $pubkey_contents = $key->data;
}
sodium_memzero($key->data);

$key_filename = $key->name;
if (substr(strtolower($key_filename), strlen($key_filename) - 5, 5) != ".blis") {
    $key_filename = $key_filename . ".blis";
}

ob_start('ob_gzhandler');

header('Content-Type: text/plain');
header("Content-Disposition: attachment; filename=\"$key_filename\";");
header('Content-Length: ' . strlen($pubkey_contents));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

echo($pubkey_contents);

ob_end_flush();
