<?php
#
# Contains commonly used functions for performing backup or reverting to a backup
#
require_once(__DIR__."/../includes/composer.php");
require_once(__DIR__."/../includes/db_lib.php");
require_once(__DIR__."/../includes/platform_lib.php");

class BackupArchive {
    private $file_path;
    private $timestamp;
    private $lab_config_id;

    public function __construct($file_path, $lab_config_id) {
        $this->file_path = $file_path;
        $this->lab_config_id = $lab_config_id;

        $info = pathinfo($file_path);
        $filename = $info['filename'];
        $parts = explode("_", $filename);
        $probable_timestamp = $parts[2];
        $this->timestamp = date_create_from_format("Ymd-His", $probable_timestamp);
    }

    public function file_path() {
        return $this->file_path;
    }

    public function file_name() {
        return basename($this->file_path);
    }

    public function timestamp() {
        return $this->timestamp;
    }

    public function friendlyDate() {
        return $this->timestamp->format("Y-m-d H:i:s");
    }

    public function lab_config_id() {
        return $this->lab_config_id;
    }
}

class BackupLib
{
    private static function mySqlDump($databaseName, $backupFilename, $ignoreTables=array())
    {
        global $log, $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS;

        $ignoreTablesString = "";
        foreach($ignoreTables as $t) {
            $ignoreTablesString .= " --ignore-table=$t";
        }

        $mysqldumpPath = PlatformLib::mySqlDumpPath();
        $command = $mysqldumpPath." -B -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $databaseName $ignoreTablesString -r ".escapeshellarg($backupFilename);
        # this is purely cosmetic and for security... we obviously don't want to dump the database username and password in the logs
        $sanitzed_command = $mysqldumpPath." -B -h $DB_HOST -P $DB_PORT -u ***** -p ***** $databaseName $ignoreTablesString -r ".escapeshellarg($backupFilename);
        $output = system($command, $result);

        if ($result == 0) {
            $log->debug("Successfully dumped MySQL database; command: $sanitzed_command, code $result, output:\n $output");
            return $backupFilename;
        } else {
            $log->error("Could not dump MySQL database; command: $sanitzed_command, err code $result, output:\n $output");
            return false;
        }
    }

    private static function encryptFile($filename, $publicKey, $outputFilename, $decryptionKeyFilename)
    {
        global $log;

        $data = file_get_contents($filename);
        $res = openssl_seal($data, $sealed, $ekeys, array($publicKey));
        if (!$res) {
            $log->error("Failed to encrypt data: " . openssl_error_string());
            return false;
        }
        $env_key = $ekeys[0];
        file_put_contents($decryptionKeyFilename, base64_encode($env_key));
        file_put_contents($outputFilename, $sealed);
    }

    # Backup log files if they exist
    private static function dumpLog($logfile, $dest_base, $public_key)
    {
        if (file_exists($logfile)) {
            if (!!$public_key) {
                $dest = "$dest_base.enc";
                $key_dest = "$dest_base.key";
                self::encryptFile($logfile, $public_key, $dest, $key_dest);
            } else {
                copy($logfile, $dest_base);
            }
        }
    }

    private static function createZipFile($zipFile, $rootPath)
    {
        global $log;
        $log->info("Creating zip file: $zipFile from path $rootPath");

        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        // Create recursive directory iterator
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                if (PlatformLib::runningOnWindows()) {
                    // If running on Windows, replace all path separators (\) with Unix-style path separators (/)
                    // Why: https://www.php.net/manual/en/ziparchive.addfile.php
                    $relativePath = str_replace("\\", "/", $relativePath);
                }

                //echo $zipFile + "\n" + $filePath;
                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();

        $log->info("$zipFile created successfully!");
    }

    /**
     * Upload a backup file to a BLIS Cloud server
     */
    public static function send_file_to_server($file_path, $lab_config_id)
    {
        global $log;

        $lab_config = LabConfig::getById($lab_config_id);
        $server_host = $lab_config->blis_cloud_hostname;

        if (strlen($server_host === 0)) {
            $log->info("blis_cloud_hostname is not set for lab ID $lab_config_id");
            return false;
        }

        $endpoint = $server_host.'/export/import_data_director.php';
        $log->info("Attempting to upload $file_path to $endpoint...");

        if (function_exists('curl_file_create')) {
            // For PHP 5.5+, which is what we use in the BLIS docker image
            $curlfile = curl_file_create($file_path, 'application/zip');
        } else {
            // For old-school PHP, which is in-use by the Desktop BLIS
            $curlfile = '@' . realpath($file_path);
            $log->info("Resolved path to: $curlfile");
        }

        // The sqlFile name is the form name for the file
        // This should match the name used in import_data_director.php
        $post = array('sqlFile'=> $curlfile);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        // See https://www.php.net/manual/en/function.curl-exec.php
        // for why to use the === here
        if ($response === false) {
            $log->error("Failed to upload file.");
        } else {
            $log->info("File uploaded successfully!");
            echo("<p>Backup was transferred to server $server_host</p>");
        }

        return $response;
    }

    /**
     * Perform a backup of site data.
     * @param lab_config_id laboratory configuration ID, according to the database
     * @param include_langdata include localization files in backup as well. default: yes
     * @param encryption_key key to encrypt the backup with. default: no encryption
     */
    public static function performBackup($lab_config_id, $include_langdata=true, $encryption_key=false)
    {
        global $log, $con, $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS;
        $encryption_enabled = !!$encryption_key;

        $lab_db = "blis_$lab_config_id";

        // Create backup directory structure
        $backup_dir = "../../files/backups/blis_backup_" . $lab_db . "_" . date("Ymd-His");
        mkdir($backup_dir, 0700, true);
        mkdir("$backup_dir/$lab_db/", 0700, false);
        mkdir("$backup_dir/blis_revamp/", 0700, false);
        mkdir("$backup_dir/langdata_$lab_config_id/", 0700, false);

        $plaintext_backup = "$backup_dir/$lab_db/$lab_db"."_backup.sql";

        // Ignore the "backups" table
        $ignoredTables = array();
        array_push($ignoredTables, "$lab_db.blis_backups");

        // Dump the database
        self::mySqlDump($lab_db, $plaintext_backup, $ignoredTables);

        $backupType = $_POST['backupTypeSelect'];

        // If backup type is anonymous, then re-import the database and hash the patient names
        if ($backupType == "anonymized") {
            // Create the database we will reimport to
            $anonymized_db = $lab_db."_anonymized";
            $query = "CREATE DATABASE $anonymized_db";
            query_blind($query, $con);

            // Copy the plaintext database backup and replace the old database name with the anonymized one.
            $fileHandle = fopen($plaintext_backup, "r");
            $backupLabDbTempFileName = "$backup_dir/$lab_db/blis_".$lab_config_id."_reimport.sql";
            $fileWriteHandle = fopen($backupLabDbTempFileName, "w");
            while (!feof($fileHandle)) {
                $line = fgets($fileHandle);
                if (strstr($line, "CREATE DATABASE ") || strstr($line, "USE ")) {
                    $line = str_replace($lab_db, $anonymized_db, $line);
                }
                fwrite($fileWriteHandle, $line);
            }
            fclose($fileWriteHandle);
            fclose($fileHandle);

            // Delete the original database dump
            unlink($plaintext_backup);

            // Reimport the new database data
            $mysqlExePath = PlatformLib::mySqlClientPath();
            $command = "$mysqlExePath -h $DB_HOST -P $DB_PORT -u $DB_USER -p$DB_PASS $anonymized_db < \"$backupLabDbTempFileName\"";
            $last_line = system($command, $result);
            if ($result != 0) {
                $log->error("Could not import MySQL database to anonymize data; command: $command, last line: $last_line");
                return;
            }

            // Delete the temporary dump used to import data
            unlink($backupLabDbTempFileName);

            // Replace each patient name with a SHA-256 hash of the name
            $saved_db= db_get_current();
            db_change($anonymized_db);
            $queryUpdate = "UPDATE patient SET name = SHA2(name, 256);";
            query_blind($queryUpdate);
            DbUtil::switchRestore($saved_db);

            // Re-dump the anonymized database to a temp file
            self::mySqlDump($anonymized_db, $backupLabDbTempFileName);

            // Drop anonymized database
            query_blind("DROP DATABASE $anonymized_db;");

            // Replace instances of the anonymized db name with the real db name
            $fileHandle = fopen($backupLabDbTempFileName, "r");
            $fileWriteHandle = fopen($plaintext_backup, "w");
            while (!feof($fileHandle)) {
                $line = fgets($fileHandle);
                if (strstr($line, "CREATE DATABASE ") || strstr($line, "USE ")) {
                    $line = str_replace($anonymized_db, $lab_db, $line);
                }
                fwrite($fileWriteHandle, $line);
            }
            fclose($fileWriteHandle);
            fclose($fileHandle);

            unlink($backupLabDbTempFileName);

            // Now the file located at $plaintext_backup is anonymized!
        }

        $server_public_key = false;

        if ($encryption_enabled) {
            $server_public_key = openssl_pkey_get_public($encryption_key);
            if (!$server_public_key) {
                $log->error(openssl_error_string());
                return;
            }
            $encrypted_backup = "$backup_dir/$lab_db/$lab_db"."_backup.sql.enc";
            $encrypted_backup_key = "$backup_dir/$lab_db/$lab_db"."_backup.sql.key";
            self::encryptFile($plaintext_backup, $server_public_key, $encrypted_backup, $encrypted_backup_key);

            // Delete plaintext backup
            unlink($plaintext_backup);

            // Move encrypted backup file to expected file name
            rename($encrypted_backup, $plaintext_backup);
        }


        $dbname = "blis_revamp";
        $backupDbFileName = "$backup_dir/$dbname/$dbname"."_backup.sql";
        self::mySqlDump($dbname, $backupDbFileName);

        if ($encryption_enabled) {
            $encrypted_backup = "$backup_dir/$dbname/$dbname"."_backup.sql.enc";
            $encrypted_backup_key = "$backup_dir/$dbname/$dbname"."_backup.sql.key";
            self::encryptFile($backupDbFileName, $server_public_key, $encrypted_backup, $encrypted_backup_key);

            unlink($backupDbFileName);

            // Move encrypted backup to expected file name
            rename($encrypted_backup, $backupDbFileName);
        }

        // Add language data files to backup folder
        $lab_langdata = "../../local/langdata_$lab_config_id";
        if ($handle = opendir($lab_langdata)) {
            while (false !== ($file = readdir($handle))) {
                if ($file === "." || $file == "..") {
                    continue;
                }
                copy("$lab_langdata/$file", "$backup_dir/langdata_$lab_config_id/$file");
            }
        }


        self::dumpLog("../../local/log_$lab_config_id.txt", "$backup_dir/log_$lab_config_id.txt", $server_public_key);
        self::dumpLog("../../local/log_$lab_config_id"."_updates.txt", "$backup_dir/log_$lab_config_id"."_updates.txt", $server_public_key);
        self::dumpLog("../../local/log_$lab_config_id"."_revamp_updates.txt", "$backup_dir/log_$lab_config_id"."_revamp_updates.txt", $server_public_key);
        self::dumpLog("../../local/UILog_2-2.csv", "$backup_dir/UILog_2-2.csv", $server_public_key);
        self::dumpLog("../../local/UILog_2-3.csv", "$backup_dir/UILog_2-3.csv", $server_public_key);
        self::dumpLog("../../log/application.log", "$backup_dir/application.log", $server_public_key);
        self::dumpLog("../../log/database.log", "$backup_dir/database.log", $server_public_key);
        self::dumpLog("../../log/apache2_error.log", "$backup_dir/apache2_error.log", $server_public_key);
        self::dumpLog("../../log/php_error.log", "$backup_dir/apache2_error.log", $server_public_key);

        $zipFile=$backup_dir;
        if ($encryption_enabled) {
            $zipFile=$zipFile."_enc.zip";
        } else {
            $zipFile = $zipFile.".zip";
        }

        self::createZipFile($zipFile, realpath($backup_dir));

        $new_path = dirname(__FILE__)."/../../files/backups/".basename($zipFile);
        rename($zipFile, $new_path);

        // Removes the backup directory in files/
        // Comment this out if you want to figure out what went wrong somewhere!
        PlatformLib::removeDirectory($backup_dir);

        return $new_path;
    }

    /**
     * Lists server backup zip files compatible with the given $lab_config_id
     */
    public static function listServerBackups($lab_config_id)
    {
        // TODO: Can't determine if the backups are compatible from an encryption POV
        # Returns a list of all backup folders available on main dir
        global $log;
        $backups = array();
        $searchPath = dirname(__FILE__)."/../../files/backups";
        if (!file_exists($searchPath)) {
            mkdir($searchPath, 0600);
        }

        if ($handle = opendir($searchPath)) {
            while (false !== ($file = readdir($handle))) {
                $file_parts = pathinfo($file);
                if (!(is_file("$searchPath/$file") && $file_parts['extension'] === "zip")) {
                    // we only want .zip files
                    continue;
                }

                $zip = new ZipArchive;
                if ($zip->open("$searchPath/$file") !== false) {
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $path = $zip->getNameIndex($i);
                        if (dirname($path) === "blis_$lab_config_id") {
                            $backup = new BackupArchive("$searchPath/$file", $lab_config_id);
                            array_push($backups, $backup);
                            break;
                        }
                    }
                    $zip->close();
                } else {
                    $log->error("Could not open zip to examine: $file");
                    continue;
                }
            }
        }

        closedir($handle);

        usort($backups,function($first,$second){
            return $first->timestamp() < $second->timestamp();
        });

        return $backups;
    }
}
