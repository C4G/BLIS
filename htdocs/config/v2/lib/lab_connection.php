<?php

require_once(__DIR__."/../../../includes/composer.php");
require_once(__DIR__."/../../../includes/db_mysql_lib.php");

class LabConnection {

    public $id;
    public $lab_config_id;
    public $public_key_id;
    public $connection_code;
    public $last_backup_time;
    public $created_at;
    public $lab_name;
    public $last_backup_ip;

    public static function find_by_lab_config_id($lab_config_id) {
        db_change("blis_revamp");

        $escaped_id = db_escape($lab_config_id);
        $query = "SELECT *
                  FROM blis_cloud_connections WHERE lab_config_id = '$escaped_id'";

        $result = query_associative_one($query);

        if ($result == null) {
            return null;
        }

        return LabConnection::from_row($result);
    }

    public static function find_or_create($lab_config_id) {
        $existing = LabConnection::find_by_lab_config_id($lab_config_id);
        if ($existing != null ) {
            return $existing;
        }

        $connection_code = LabConnection::new_connection_code();
        $escaped_cfg_id = db_escape($lab_config_id);

        $query = "INSERT INTO blis_cloud_connections (lab_config_id, connection_code)
                  VALUES('$escaped_cfg_id','$connection_code');";

        query_insert_one($query);

        return LabConnection::find_by_lab_config_id($lab_config_id);
    }

    public function save() {
        db_change("blis_revamp");

        $query = "UPDATE blis_cloud_connections
            SET lab_pubkey_id = '".db_escape($this->public_key_id)."',
            lab_name = '".db_escape($this->lab_name)."',
            connection_code = '".db_escape($this->connection_code)."',
            last_backup_time = '".db_escape(date("Y-m-d H:i:s", $this->last_backup_time))."',
            last_backup_ip = '".db_escape($this->last_backup_ip)."'
            WHERE id = '".$this->id."';";

        query_update($query);
    }

    public function refresh_connection_code() {
        $this->connection_code = LabConnection::new_connection_code();
    }

    private static function from_row($row) {
        $lab_connection = new LabConnection();

        $lab_connection->id = $row['id'];
        $lab_connection->lab_config_id = $row['lab_config_id'];
        $lab_connection->public_key_id = $row['lab_pubkey_id'];
        $lab_connection->connection_code = $row['connection_code'];
        if ($row['last_backup_time'] != 0) {
            $lab_connection->last_backup_time = strtotime($row['last_backup_time']);
        }
        $lab_connection->created_at = strtotime($row['created_at']);
        $lab_connection->lab_name = $row['lab_name'];
        $lab_connection->last_backup_ip = $row['last_backup_ip'];

        return $lab_connection;
    }

    private static function new_connection_code() {
        $newuuid = uniqid("", true);
        $code = strtoupper($newuuid);
        $code = str_replace(".", "", $code);
        $code = substr($code, 2);
        return $code;
    }
}
