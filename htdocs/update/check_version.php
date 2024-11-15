<?php

include_once("redirect.php");
include_once("../includes/db_lib.php");
include_once("../includes/migrations.php");
include_once("../includes/user_lib.php");
include_once("../lang/lang_util.php");

LangUtil::setPageId("update");
global $VERSION;

$check_revamp_versions_result = checkVersionDataEntryExists($VERSION);

$check_lab_migrations_complete = true;
if (isset($_SESSION['lab_config_id'])) {
    $lab_config_id = $_SESSION['lab_config_id'];
    $lab_db_name_query = "SELECT db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
    $result = query_associative_one($lab_db_name_query);
    $lab_db = $result['db_name'];
    $migrator = new LabDatabaseMigrator($lab_db);
    $check_lab_migrations_complete = !($migrator->has_pending_migrations());
}

$check_revamp_migrations_complete = true;
$migrator = new LabDatabaseMigrator("blis_revamp", "revamp");
$check_revamp_migrations_complete = !($migrator->has_pending_migrations());

echo(($check_revamp_versions_result &&
      $check_lab_migrations_complete &&
      $check_revamp_migrations_complete) ? "1" : "0");
