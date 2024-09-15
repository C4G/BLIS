<?php

require_once('db_lib.php');
require_once('db_mysql_lib.php');
require_once('debug_lib.php');
require_once('defaults.php');

class DbUtil
{
    public static function switchToGlobal()
    {

        # Saves currently selected DB and switches to
        # global/metadata DB instance
        global $DEBUG;
        if ($DEBUG) {
            echo "In switchToGlobal()<br>";
            echo DebugLib::getCallerFunctionName(debug_backtrace())."<br>";
        }
        global $GLOBAL_DB_NAME;
        $saved_db_name = db_get_current();
        db_change($GLOBAL_DB_NAME);
        return $saved_db_name;
    }

    public static function switchToCountry($countryName)
    {
        # Saves currently selected DB and switches to
        # country specific DB instance
        global $DEBUG;
        if ($DEBUG) {
            echo "In switchToCountry()<br>";
            echo DebugLib::getCallerFunctionName(debug_backtrace())."<br>";
        }
        $saved_db_name = db_get_current();
        $dbName = "blis_".$countryName;
        db_change($dbName);
        return $saved_db_name;
    }

    public static function switchToLabConfig($lab_config_id)
    {
        # Saves currently selected DB and switches to
        # local/lab-specific DB instance
        # Used on pages that query data from different labs
        global $DEBUG;
        if ($DEBUG) {
            echo "In switchToLabConfig($lab_config_id)<br>";
            echo DebugLib::getCallerFunctionName(debug_backtrace())."<br>";
        }
        $saved_db_name = db_get_current();
        $lab_config = get_lab_config_by_id($lab_config_id);
        if ($lab_config == null) {
            # Error: Lab configuration correspinding to $lab_config_id not found in DB
            return;
        }
        $db_name = $lab_config->dbName;
        db_change($db_name);
        return $saved_db_name;
    }

    public static function switchToLabConfigRevamp($lab_config_id=null)
    {
        global $log;

        $saved_db_name = db_get_current();
        if ($lab_config_id == null) {
            $lab_config_id = $_SESSION['lab_config_id'];
        }
        $lab_config = get_lab_config_by_id($lab_config_id);
        if ($lab_config == null) {
            # Error: Lab configuration correspinding to $lab_config_id not found in DB
            return;
        }
        $db_name = $lab_config->dbName;
        db_change($db_name);
        return $saved_db_name;
    }

    public static function switchRestore($db_name)
    {
        # Reverts back to saved DB instance
        global $DEBUG;
        if ($DEBUG) {
            echo "In switchRestore($db_name)<br>";
            echo DebugLib::getCallerFunctionName(debug_backtrace())."<br>";
        }
        db_change($db_name);
    }
}
