<?php

require_once(__DIR__."/../../../includes/composer.php");

class AnalyzedBackupException extends Exception { }

class AnalyzedBackup {

    // The lab config ID associated with this backup.
    // May be different from the lab config ID that this backup is imported into.
    public $lab_config_id;

    // The filename of this backup as it was originally uploaded to the server.
    public $filename;

    // The database name present in this backup.
    public $database_name;

    // Whether or not the data is encrypted.
    public $encrypted;

    // List of files inside the backup archive
    public $files;

    // The likely version of BLIS this backup was created with.
    public $version;

    // The likely name of the lab that this backup has backed up.
    public $lab_name;

    // The path, within the zip file, to the lab backup SQL file.
    public $relative_lab_backup_sql_path;

    function __construct($filename, $location) {
        global $log;

        $this->filename = $filename;
        $this->files = array();

        $realpath = realpath($location);
        $info = pathinfo($realpath);

        $likely_encrypted = !!(substr($filename, -strlen("_enc.zip")) === "_enc.zip");

        $this->encryped = $likely_encrypted;

        $incorrect_backslashes = false;

        $zip = new ZipArchive;
        if (!$zip->open($realpath)) {
            throw new AnalyzedBackupException("Could not open file: $realpath");
        }

        $lab_id = null;

        $lab_backup = null;
        $revamp_backup = null;
        $lab_sql_log = null;
        $whole_database_log = null;
        $language_folder = null;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $path = $zip->getNameIndex($i);

            $fullpath = $path;

            array_push($this->files, $path);

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
                $revamp_backup = $fullpath;
            }

            if (preg_match("/log_([0-9]+).txt/", $path, $matches) == 1) {
                $lab_id = $matches[1];
                $lab_sql_log = $fullpath;
            }

            if (preg_match("/database.log/", $path, $matches) == 1) {
                $whole_database_log = $fullpath;
            }
        }

        if ($lab_id != null) {
            $this->database_name = "blis_$lab_id";
            $this->lab_config_id = $lab_id;
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
                    break;
                }
            }
        }

        $probable_name = null;

        global $log;

        if ($revamp_backup != null) {
            $revamp_backup_contents = $zip->getFromName($revamp_backup);
            $revamp_lines = explode("\n", $revamp_backup_contents);
            foreach($revamp_lines as $lineno => $line) {
                if (preg_match("/^INSERT INTO `lab_config` VALUES (?:\(.+\),)?\($lab_id,'(.+?)',/", $line, $matches) == 1) {
                    $probable_name = $matches[1];
                    break;
                }
            }
        }

        $zip->close();

        $this->lab_name = $probable_name;
        $this->version = $probable_version;

        if ($lab_backup != null) {
            if ($incorrect_backslashes) {
                $this->relative_lab_backup_sql_path = str_replace("\\", "/", $lab_backup);
            } else {
                $this->relative_lab_backup_sql_path = $lab_backup;
            }
        }
    }
}
