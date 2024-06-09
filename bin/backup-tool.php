#!/usr/bin/env php
<?php

require_once(__DIR__."/../htdocs/includes/platform_lib.php");

function endsWith($haystack, $needle)
{
    return substr($haystack, -strlen($needle)) === $needle;
}

if ($argc < 2) {
    echo("You must provide a path to a backup file to explore.\n");
    die(1);
}

$backup_file = $argv[1];
$realpath = realpath($backup_file);
$info = pathinfo($realpath);
$filename = $info['basename'];
$ext = $info['extension'];

if ($ext != "zip") {
    echo("The backup file must be a .zip file to proceed.\n");
    die(1);
}

$likely_encrypted = !!endsWith($filename, "_enc.zip");

echo("$filename\n");
echo("Encrypted: ".var_export($likely_encrypted, true)."\n");

$incorrect_backslashes = false;

$zip = new ZipArchive;
if (!$zip->open($realpath)) {
    echo("Could not open $realpath\n");
    die(1);
}

$lab_id = null;

$revamp_backup = null;
$lab_sql_log = null;
$whole_database_log = null;
$language_folder = null;

for ($i = 0; $i < $zip->numFiles; $i++) {
    $path = $zip->getNameIndex($i);

    $fullpath = $path;

    echo("$path\n");

    if (!$incorrect_backslashes && strstr($path, "\\")) {
        $incorrect_backslashes = true;
    }

    $matches = null;

    if (preg_match('/langdata_([0-9]+)/', $path) == 1) {
        $language_folder = $fullpath;
    }

    if (preg_match('/blis_([0-9]+)[\/\\]blis_[0-9]+_backup\.sql/', $path, $matches) == 1) {
        $lab_backup = $fullpath;
        $lab_id = $matches[1];
    }

    if (preg_match('/blis_revamp[\/\\]]blis_revamp_backup\.sql/', $path, $matches) == 1) {
        echo("blis_revamp backup present.\n");
        $revamp_backup = $fullpath;
    }

    if (preg_match("/log_([0-9]+).txt/", $path, $matches) == 1) {
        $lab_id = $matches[1];
        echo("log_$lab_id.txt present.\n");
        $lab_sql_log = $fullpath;
    }

    if (preg_match("/database.log/", $path, $matches) == 1) {
        echo("database.log present.\n");
        $whole_database_log = $fullpath;
    }
}

if ($lab_id != null) {
    echo("Found a lab backup. Lab ID: $lab_id\n");
}

// Ok, we're going to try and divine the version here...
//
// The basic idea is this:
// - If we have a blis_revamp_backup.sql file (not all backups will have one) then we can extract the version
//   from the version_data table. A very naive regex is used that will assume the whole INSERT INTO line from
//   the backup is on one line. We'll iterate over the SQL dump file line by line to find a match. If we find
//   a match, we'll take the last entry (row) returned by preg_match and take that as the version.
//
// - If that fails, we'll take a look at the query log file. This is a hack, but potentially useful.
//   There is a function checkVersionDataEntryExists() that will query the revamp table with the $VERSION
//   of BLIS that is currently running. We know that if this query was made, this lab was probably running
//   successfully with that version of BLIS. So we'll assume that is the last version of BLIS this backup
//   ran on. The log is traversed in reverse.

$probable_version = null;
if ($revamp_backup != null) {
    $revamp_backup_contents = $zip->getFromName($revamp_backup);
    $revamp_lines = explode("\n", $revamp_backup_contents);
    foreach($revamp_lines as $lineno => $line) {
        if (preg_match("/^INSERT INTO `version_data` VALUES (?:\([0-9]+,'([0-9\.]+)'(?:,'?[0-9a-zA-Z :-]*'?)+\),?)+/", $line, $matches) == 1) {
            $probable_version = $matches[1];
            echo("Detected version in blis_revamp_backup.sql\n");
            break;
        }
    }
}

if ($probable_version == null && $lab_sql_log != null) {
    $contents = $zip->getFromName($lab_sql_log);
    $lines = array_reverse(explode("\n", $contents));
    foreach($lines as $lineno => $line) {
        if (preg_match("/SELECT \* FROM version_data WHERE version = '([0-9\.]+)'/", $line, $matches) == 1) {
            $probable_version = $matches[1];
            echo("Guessing version from log_$lab_id.txt\n");
            break;
        }
    }
}

if ($probable_version == null && $whole_database_log != null) {
    $contents = $zip->getFromName($whole_database_log);
    $lines = array_reverse(explode("\n", $contents));
    foreach($lines as $lineno => $line) {
        if (preg_match("/SELECT \* FROM version_data WHERE version = '([0-9\.]+)'/", $line, $matches) == 1) {
            $probable_version = $matches[1];
            echo("Guessing version from database.log\n");
            break;
        }
    }
}

$zip->close();

if ($incorrect_backslashes) {
    echo("This zip uses '\\' characters as path separators. This will be corrected on import.\n");
}

if ($probable_version != null) {
    echo("Detected lab config version: $probable_version\n");
} else {
    echo("Could not detect a version!\n");
}

if ($language_folder) {
    echo("Found a language backup folder.\n");
}
