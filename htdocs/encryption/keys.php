<?php

require_once(__DIR__.'/../includes/composer.php');
require_once(__DIR__.'/../includes/db_lib.php');
require_once(__DIR__.'/../includes/platform_lib.php');

class Key {
    public static $PUBLIC = "SODIUM_PUBLIC";
    public static $KEYPAIR = "SODIUM_KEYPAIR";

    // The unique database ID of this key
    public $id;

    // The name of the key (eg. the lab name)
    public $name;

    // The type of this key: PUBLIC or KEYPAIR
    public $type;

    // The Base64-encoded key data
    public $data;

    // The timestamp when this row was created
    public $created_at;

    public static function insert($name, $type, $data) {
        $escaped_name = db_escape($name);
        $escaped_type = db_escape($type);
        $escaped_data = db_escape($data);

        $query = "INSERT INTO `keys` (`name`, `type`, `data`)
                  VALUES('$escaped_name','$escaped_type','$escaped_data');";

        query_insert_one($query);

        $select = "SELECT id FROM `keys` WHERE lab_config_id = '$escaped_lab' AND location = '$escaped_location';";
        $result = query_associative_one($select);
        return $result['id'];
    }

    public static function find($key_id) {
        $escaped_id = db_escape($key_id);
        $query = "SELECT *
                  FROM `keys` WHERE id = '$escaped_id'";

        $result = query_associative_one($query);
        if ($result == null) {
            return false;
        }

        return Key::from_row($result);
    }

    public static function where_type($key_type) {
        $escaped_type = db_escape($key_type);
        $query = "SELECT * FROM `keys` WHERE `type` = '$key_type';";
        $results = query_associative_all($query);

        $keys = array();
        foreach($results as $result) {
            $key = Key::from_row($result);
            array_push($keys, $key);
        }

        return $keys;
    }

    private static function from_row($row) {
        $key = new Key();

        $key->id = $row['id'];
        $key->name = $row['name'];
        $key->type = $row['type'];
        $key->data = $row['data'];
        $key->created_at = $row['created_at'];

        return $key;
    }

    public function destroy() {
        global $log;

        $id = $this->id;
        $query = "DELETE FROM keys WHERE id = '$id' LIMIT 1;";
        $result = query_associative_one($query);

        $log->info("Deleted key with ID: $id");
    }
}
