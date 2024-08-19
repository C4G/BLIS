<?php

require_once(__DIR__."/../../../includes/composer.php");
require_once(__DIR__."/../../../includes/db_mysql_lib.php");
require_once(__DIR__."/../../../includes/keymgmt.php");
require_once(__DIR__."/../../../includes/platform_lib.php");
require_once(__DIR__."/backup.php");

class RestoreBackupException extends Exception { }

class BackupRestorer {

    private $backup;
    private $analyzed;

    private $target_lab_id;
    private $target_lab_database;

    private $logger;

    /**
     * Accepts a Backup object (from ./backup.php)
     */
    function __construct($backup, $target_lab_id) {
        global $log;

        $this->logger = $log;

        $this->backup = $backup;
        $this->analyzed = $backup->analyze();

        $this->target_lab_id = $target_lab_id;

        db_change('blis_revamp');

        $lab_db_name_query = "SELECT db_name FROM lab_config WHERE lab_config_id = '$target_lab_id';";
        $lab_db_name = query_associative_one($lab_db_name_query);
        if (!$lab_db_name) {
            throw new RestoreBackupException("Lab with ID $target_lab_id does not exist.");
        }

        $this->target_lab_database = $lab_db_name['db_name'];
    }

    private function decrypt($filename, $pvt_key) {
        $this->logger->info("Attempting to decrypt $filename with $pvt_key");

        if (!file_exists($filename.".key") || !file_exists($pvt_key)) {
            $this->logger->error("Both of these files must exist but at least one does not: $filename.key, $pvt_key");
            return false;
        }
    
        $private_key_id = openssl_get_privatekey(file_get_contents($pvt_key));
        $env_key=file_get_contents($filename.".key");
        $env_key=base64_decode($env_key);
    
        $sealed=file_get_contents($filename);
        $open = '';
        $res = openssl_open($sealed, $open, $env_key, $private_key_id);
        openssl_free_key($private_key_id);
    
        if (!$res) {
            $this->logger->error("Could not decrypt $filename with $filename.key: " . openssl_error_string());
            return false;
        }
    
        file_put_contents($filename.".dec", $open);
    
        // Return the filename of the decrypted file
        return $filename.".dec";
    }

    private function execute_sql_file($fname, $target_db) {
        global $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $target_conn = new mysqli("$DB_HOST:$DB_PORT", $DB_USER, $DB_PASS, $target_db);
        $this->logger->info("Connected to " . $target_db);
        $this->logger->info("Executing " . $fname);

        try {
            $structure_file = file_get_contents($fname);

            $target_conn->multi_query($structure_file);
            do {
                // Need to page through the results of the execution above so we can continue
                $result = $target_conn->store_result();
            } while ($target_conn->next_result());
        } catch (Exception $e) {
            $this->logger->error("Exception occurred: " . $e->getMessage());
            return false;
        } finally {
            $target_conn->close();
        }
    
        return true;
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
        
        $pvt=KeyMgmt::pathToKey("LAB_".$this->target_lab_id.".blis");

        $blisLabBackupFilePath = "$unzip_path/".$this->analyzed->relative_lab_backup_sql_path;

        // Attempt to decrypt file
        $decrypted_file = $this->decrypt($blisLabBackupFilePath, $pvt);
        if (!!$decrypted_file) {
            $blisLabBackupFilePath = $decrypted_file;
        }

        $return = $this->execute_sql_file($blisLabBackupFilePath, $this->target_lab_database);

        if (!!$decrypted_file) {
            unlink($decrypted_file);
        }

        $this->logger->info("Restore completed.");

        return $return;
    }
}