#!/usr/bin/env php
<?php

require_once(__DIR__ . "/../../htdocs/includes/db_constants.php");

/**
 * generate_lab_migration.php
 *
 * Usage:
 *   $ db/bin/generate_lab_migration.php [TARGET_DATABASE]
 *
 * This tool will read all column information from the sample database, blis_127, and create a migration
 * for the target database to create the necessary tables and columns.
 */

if ($argc < 2) {
    echo("You must supply the target database to migrate.\n");
    die(1);
}

$target_db = $argv[1];

if ($target_db == "blis_revamp") {
    echo("This tool cannot be used to migrate the blis_revamp database.\n");
    die(1);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("$DB_HOST:$DB_PORT", $DB_USER, $DB_PASS, "blis_127");

echo("Generating migration from blis_127...\n");

$table_names = $mysqli->query("SELECT table_name FROM INFORMATION_SCHEMA.tables WHERE TABLE_SCHEMA = 'blis_127';");

$migration_lines = array();

foreach($table_names as $table) {
    $table_name = $table['table_name'];

    $result = $mysqli->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'blis_127' AND TABLE_NAME = '$table_name';");

    $primary_keys = array();
    $unique_keys = array();
    $multi_keys = array();

    foreach($result as $col) {
        $column_name = $col['COLUMN_NAME'];
        $nullable = $col['IS_NULLABLE'] != "NO";
        $type = $col['COLUMN_TYPE'];
        $default = $col['COLUMN_DEFAULT'];
        $extra = $col['EXTRA'];
        $is_string = ($col['DATA_TYPE'] == "varchar" || $col['DATA_TYPE'] == "text" || $col['DATA_TYPE'] == "datetime");
        $primary_key = $col['COLUMN_KEY'] == "PRI";
        $unique_key = $col['COLUMN_KEY'] == "UNI";
        $multi_key = $col['COLUMN_KEY'] == "MUL";

        if ($primary_key) {
            array_push($primary_keys, $column_name);
        }

        if ($unique_key) {
            array_push($unique_keys, $column_name);
        }

        if ($multi_key) {
            array_push($multi_keys, $column_name);
        }

        $stmt = "ALTER TABLE `$table_name` ADD COLUMN `$column_name` $type";
        if($nullable) {
            $stmt = $stmt . " DEFAULT NULL";
        } else {
            $stmt = $stmt . " NOT NULL";
            if ($default && $is_string) {
                $stmt = $stmt . " DEFAULT '$default'";
            } else if ($default) {
                $stmt = $stmt . " DEFAULT $default";
            }
        }

        if ($extra) {
            $stmt = $stmt . " $extra";
        }

        array_push($migration_lines, "$stmt;");
    }

    if (count($primary_keys) > 0) {
        $all_keys = implode("`, `", $primary_keys);
        array_push($migration_lines, "ALTER TABLE `$table_name` ADD PRIMARY KEY(`$all_keys`);");
    }

    // This seems to not work very well since I don't really know
    // how to generate this SQL effectively, without making lots of duplicate keys.
    // I'm leaving it here to represent what _could_ be done, if determined to be necessary...
    //
    // foreach($unique_keys as $key) {
    //     array_push($migration_lines, "ALTER TABLE `$table_name` ADD UNIQUE KEY(`$key`);");
    // }

    // foreach($multi_keys as $key) {
    //     array_push($migration_lines, "ALTER TABLE `$table_name` ADD KEY(`$key`);");
    // }
}
$mysqli->close();

$target_conn = new mysqli("$DB_HOST:$DB_PORT", $DB_USER, $DB_PASS, $target_db);
echo("Connected to $target_db!\n");

echo("Creating new tables using db/structure/blis_127.sql...\n");
$structure_file = file_get_contents(__DIR__ . "/../structure/blis_127.sql");
$target_conn->multi_query($structure_file);
do {
    // Need to page through the results of the execution above so we can continue
    $result = $target_conn->store_result();
} while ($target_conn->next_result());

echo("Executing generated migration statements...\n");
foreach($migration_lines as $line) {
    if($line == "") {
        continue;
    }

    try {
        $target_conn->query($line);
        echo($line . "\n");
    } catch (Exception $e) {
        // Silent fail - we don't care about what didn't get executed
        // This means the column already existed, etc.
    }
}

$target_conn->close();

echo("\nDone!\n");
