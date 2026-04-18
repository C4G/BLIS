<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/user_lib.php");
require_once(__DIR__."/../../encryption/keys.php");

global $log;

$current_user_id = $_SESSION["user_id"];
$current_user = get_user_by_id($current_user_id);
$lab_config_id = $_REQUEST["id"];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
db_change($lab["db_name"]);

$lab_config_name = $lab["name"];

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

$keypair_name = trim($_POST['keypair_name']);
if ($keypair_name == NULL || $keypair_name == "") {
    $_SESSION['FLASH'] = "Must specify a name for the keypair.";
    header("Bad Request", true, 400);
    header("Location: lab_config_backup_settings.php?id=$lab_config_id");
    exit;
}

$log->info("Generating new keypair for $lab_config_name ($lab_config_id)");

$key = sodium_crypto_box_keypair();
$key_b64 = base64_encode($key);
sodium_memzero($key);

try {
    db_change($lab["db_name"]);
    $db_key_id = Key::insert($keypair_name, Key::$KEYPAIR, $key_b64);
    sodium_memzero($key_b64);
} catch (Exception $e) {
    $_SESSION['FLASH'] = "An error occurred generating the keypair: " . $e->getMessage();
    header("Internal Server Error", true, 500);
    header("Location: lab_config_backup_settings.php?id=$lab_config_id");
    exit;
}

$_SESSION['FLASH'] = "Keypair generated successfully.";
header("Location: lab_config_backup_settings.php?id=$lab_config_id");
