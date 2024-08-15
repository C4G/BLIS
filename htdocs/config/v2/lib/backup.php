<?php

require_once(__DIR__."/../../../includes/db_mysql_lib.php");
require_once(__DIR__."/analyzed_backup.php");
require_once(__DIR__."/../../../includes/composer.php");

class Backup {

    // The unique ID of this backup entry.
    public $id;

    // The lab config ID associated with this backup.
    public $lab_config_id;

    // The filename of this backup as it was originally uploaded to the server.
    public $filename;

    // The full path, relative to the /files directory, of this backup file.
    public $location;

    // The timestamp that this backup file was uploaded.
    public $timestamp;

    // Analyzed backup object, lazily computed since it's expensive to do.
    private $analyzed;

    public static function insert($lab_config_id, $filename, $location) {
        $escaped_lab = db_escape($lab_config_id);
        $escaped_filename = db_escape($filename);
        $escaped_location = db_escape($location);

        $query = "INSERT INTO blis_backups (lab_config_id, filename, location)
                  VALUES('$escaped_lab','$escaped_filename','$escaped_location');";

        query_insert_one($query);

        $select = "SELECT id FROM blis_backups WHERE lab_config_id = '$escaped_lab' AND location = '$escaped_location';";
        $result = query_associative_one($select);
        return $result['id'];
    }

    public static function for_lab_config_id($lab_config_id) {
        $escaped_id = db_escape($lab_config_id);
        $query = "SELECT id, lab_config_id, filename, location, ts
                  FROM blis_backups WHERE lab_config_id = '$escaped_id'
                  ORDER BY ts DESC;";

        $results = query_associative_all($query);

        $backups = array();
        foreach($results as $result) {
            $backup = Backup::from_row($result);
            array_push($backups, $backup);
        }

        return $backups;
    }

    public static function find($backup_id) {
        $escaped_id = db_escape($backup_id);
        $query = "SELECT id, lab_config_id, filename, location, ts
                  FROM blis_backups WHERE id = '$backup_id'";

        $result = query_associative_one($query);

        return Backup::from_row($result);
    }

    private static function from_row($row) {
        $backup = new Backup();

        $backup->id = $row['id'];
        $backup->lab_config_id = $row['lab_config_id'];
        $backup->filename = $row['filename'];
        $backup->location = $row['location'];
        $backup->timestamp = strtotime($row['ts']);

        return $backup;
    }

    public function analyze() {
        if ($this->analyzed == NULL) {
            $fullpath = __DIR__."/../../../../files/" . $this->location;
            $this->analyzed = new AnalyzedBackup($this->filename, $fullpath);
        }

        return $this->analyzed;
    }
}
