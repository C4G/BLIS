<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

require_once(__DIR__."/../../users/accesslist.php");
require_once(__DIR__."/../../includes/migrations.php");
require_once(__DIR__."/../../includes/user_lib.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);
$lab_config_id = $_REQUEST['id'];

DbUtil::switchToGlobal();

$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);
db_change($lab['db_name']);

$lab_config_name = $lab["name"];

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

$migrator = new LabDatabaseMigrator($lab['db_name']);
$migrations_successful = $migrator->apply_migrations();

if ($migrations_successful) {
    $_SESSION["FLASH"] = "Migrations applied successfully.";
} else {
    $_SESSION["FLASH"] = "There were errors while applying migrations.";
}

header("Location: lab_config_backups.php?id=$lab_config_id");
exit;
