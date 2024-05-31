<?php

require_once(__DIR__."/util.php");

require_admin_or_401();

$migration_file = $_GET['migration'];
$migration_file = basename($migration_file);

$full_path = realpath(__DIR__."/../data/$migration_file");

if (!file_exists($full_path)) {
    $_SESSION['DEBUG_FLASH'] = "File does not exist: $full_path";
    header("Location: /debug.php");
    exit();
}

// Remove the .sql extension since the b
$migration_file = basename($migration_file, ".sql");
$lab_db = $_GET['lab'];

try {
    blis_db_update(null, $lab_db, $migration_file);
    $_SESSION['DEBUG_FLASH'] = "Applied $migration_file to $lab_db";
} catch (Exception $e) {
    $_SESSION['DEBUG_FLASH'] = "Database migration $migration_file could not be applied to $lab_db: $e";
}

header("Location: /debug.php");
exit();
