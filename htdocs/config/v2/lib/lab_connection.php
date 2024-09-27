<?php

require_once(__DIR__."/../../../includes/composer.php");

class LabConnection {

    public static function new_connection_code($formatted=true) {
        $newuuid = uniqid("", true);
        $code = strtoupper($newuuid);
        $code = str_replace(".", "", $code);
        $code = substr($code, 2);
        return $code;
    }

    public static function find_or_insert($lab_config_id) {

    }

}
