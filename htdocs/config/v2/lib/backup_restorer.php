<?php

require_once(__DIR__."/../../../encryption/encryption.php");
require_once(__DIR__."/../../../encryption/keys.php");
require_once(__DIR__."/../../../includes/composer.php");
require_once(__DIR__."/../../../includes/db_mysql_lib.php");
require_once(__DIR__."/../../../includes/keymgmt.php");
require_once(__DIR__."/../../../includes/platform_lib.php");
require_once(__DIR__."/backup.php");

class RestoreBackupException extends Exception { }

class BackupRestorer {

    private $backup;
    private $analyzed;
    private $decryption_key;

    private $target_lab_id;
    public $target_lab_database;

    private $logger;

    /**
     * Accepts a Backup object (from ./backup.php)
     */
    function __construct($backup, $target_lab_id, $decryption_key_id=null) {
        global $log;

        $this->logger = $log;

        $this->backup = $backup;
        $this->analyzed = $backup->analyze($decryption_key_id);
        $this->decryption_key = Key::find($decryption_key_id);

        $this->target_lab_id = $target_lab_id;

        db_change('blis_revamp');

        $lab_db_name_query = "SELECT db_name FROM lab_config WHERE lab_config_id = '$target_lab_id';";
        $lab_db_name = query_associative_one($lab_db_name_query);
        if (!$lab_db_name) {
            throw new RestoreBackupException("Lab with ID $target_lab_id does not exist.");
        }

        $this->target_lab_database = $lab_db_name['db_name'];
    }

    private function decrypt($filename) {
        $this->logger->error("decrypt $filename");

        if (!$this->decryption_key) {
            return false;
        }

        $this->logger->info("Attempting to decrypt $filename with " . $this->decryption_key->name);

        $res = Encryption::decryptFile($filename, "$filename.dec", $this->decryption_key->data);

        if (!$res) {
            $this->logger->error("Could not decrypt $filename with " . $this->decryption_key->name);
            return false;
        }

        // Return the filename of the decrypted file
        return "$filename.dec";
    }

    private function sanitize_lab_sql_file($filename) {
        global $log;

        $pathinfo = pathinfo($filename);
        $output_path = dirname($filename) . "/" . $pathinfo['filename'] . ".sanitized.sql";

        $structure_file = file_get_contents($filename);
        $file_lines = explode("\n", $structure_file);
        $output_file = fopen($output_path, 'w');
        foreach($file_lines as $line) {
            $matches = null;

            if (preg_match('/^CREATE DATABASE/', $line, $matches) == 1) {
                continue;
            }

            if (preg_match('/^USE /', $line, $matches) == 1) {
                continue;
            }

            fwrite($output_file, $line . "\n");
        }
        fclose($output_file);

        return $output_path;
    }

    private function execute_sql_file($fname, $target_db) {
        global $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS;

        $mysql = PlatformLib::mySqlClientPath();
        $command = "$mysql -B -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $target_db < \"$fname\"";

        $output = system($command, $result);

        if ($result == 0) {
            return true;
        } else {
            $sanitized_command = "$mysql -B -h $DB_HOST -P $DB_PORT -u ***** -p ***** $target_db < \"$fname\"";
            $this->logger->error("Could not execute SQL file $fname; command: $sanitized_command; err code $result; output:\n $output");
            return false;
        }
    }

    /**
     * Be careful! This is obviously a destructive function.
     */
    public function restore() {
        $this->logger->info("Starting restore of " . $this->backup->filename . " to " . $this->target_lab_database);

        $zip_path = $this->backup->full_path;
        $pathinfo = pathinfo($zip_path);
        $unzip_path = dirname($zip_path) . "/" . $pathinfo['filename'];
        mkdir($unzip_path);
        $this->logger->info("Unzipping $zip_path to $unzip_path");

        $zip = new ZipArchive;
        $res = $zip->open($zip_path);
        if ($res === TRUE) {
            $zip->extractTo($unzip_path);
            $zip->close();
            $this->logger->info("$zip_path unzipped successfully!");
        } else {
            $this->logger->error("Could not open $zip_path!");
            return false;
        }

        $blisLabBackupFilePath = "$unzip_path/".$this->analyzed->relative_lab_backup_sql_path;

        // Attempt to decrypt file
        $decrypted_file = $this->decrypt($blisLabBackupFilePath);
        if (!!$decrypted_file) {
            $blisLabBackupFilePath = $decrypted_file;
        }

        $sanitized_file = $this->sanitize_lab_sql_file($blisLabBackupFilePath);

        // Since we are reverting to a backup, we need to reset the state of the migrations table as well.
        db_change($this->target_lab_database);
        query_delete("TRUNCATE TABLE blis_migrations;");
        $this->logger->info("Truncated blis_migrations table.");

        $return = $this->execute_sql_file($sanitized_file, $this->target_lab_database);

        if (!!$decrypted_file) {
            unlink($decrypted_file);
        }

        unlink($sanitized_file);

        if ($return) {
            $this->logger->info("Restore completed.");
            PlatformLib::removeDirectory($unzip_path);
        } else {
            $this->logger->error("Restore was not successful.");
        }

        return $return;
    }
}
