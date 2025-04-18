<?php

require_once(__DIR__."/util.php");
require_once(__DIR__."/../includes/migrations.php");

require_admin_or_401();

$database_name = $_GET["database"];
$migration_file = $_GET["migration"];
$skip = $_GET["skip"] == "true" ? true : false;
$delete = $_GET["delete"] == "true" ? true : false;

$dbtype = $database_name == "blis_revamp" ? "revamp" : "lab";
$migrator = new LabDatabaseMigrator($database_name, $dbtype);

db_change($database_name);

if($skip) {
    $migrator->insert_migration($migration_file);
    $_SESSION['FLASH'] = "Skipped migration: $migration_file for database $database_name";
    header("Location: /debug.php?selected_database=$database_name");
    exit();
}

if($delete) {
    $migrator->delete_migration($migration_file);
    $_SESSION['FLASH'] = "Deleted migration: $migration_file for database $database_name";
    header("Location: /debug.php?selected_database=$database_name");
    exit();
}

$result = $migrator->apply_migration($migration_file);
if ($result) {
    $_SESSION['FLASH'] = "Applied $migration_file to $database_name";
} else {
    $_SESSION['FLASH'] = "Database migration $migration_file could not be applied to $database_name. Check application.log for details.";
}

header("Location: /debug.php?selected_database=$database_name");
exit();
