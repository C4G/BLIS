<?php

require_once(__DIR__."/../includes/composer.php");
require_once(__DIR__."/../includes/db_lib.php");

/**
 * This class exists to answer one question: What lab_config_id should I use right now?
 * This is an annoying problem that is solved in many ways around the codebase...
 * Now we can cram all of the logic we need in one place, and hopefully introduce some caching too.
 */
class LabConfigResolver {

    private static $resolved_lab_config_id = null;

    public static function resolveId() {
        global $log;

        if (LabConfigResolver::$resolved_lab_config_id != null) {
            $log->debug("lab_config_id was cached");
            return LabConfigResolver::$resolved_lab_config_id;
        }

        if(isset($_SESSION["lab_config_id"]) && $_SESSION["lab_config_id"] != null) {
            LabConfigResolver::$resolved_lab_config_id = $_SESSION["lab_config_id"];
            $log->debug("Resolved lab_config_id: ". LabConfigResolver::$resolved_lab_config_id ." from session.");
            return LabConfigResolver::$resolved_lab_config_id;
        }

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != null) {
            LabConfigResolver::$resolved_lab_config_id = get_user_lab_id($_SESSION["user_id"]);

            if (LabConfigResolver::$resolved_lab_config_id > 0) {
                $log->debug("Resolved lab_config_id: ". LabConfigResolver::$resolved_lab_config_id ." from logged in user_id: " . $_SESSION["user_id"]);
                return LabConfigResolver::$resolved_lab_config_id;
            }

            if(User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level'])) {
                $lab_config_list = get_lab_configs($_SESSION['user_id']);
                LabConfigResolver::$resolved_lab_config_id = $lab_config_list[0]->id;
                $log->debug("Resolved lab_config_id: ". LabConfigResolver::$resolved_lab_config_id ." by looking up labs that user ID : " . $_SESSION["user_id"] . " has access to.");
                return LabConfigResolver::$resolved_lab_config_id;
            }

            $lab_config_with_admin_uid = get_first_lab_config_with_admin_user_id($_SESSION['user_id']);
            if ($lab_config_with_admin_uid) {
                LabConfigResolver::$resolved_lab_config_id = $lab_config_with_admin_uid;
                $log->debug("Resolved lab_config_id: ". LabConfigResolver::$resolved_lab_config_id ." by looking up labs with admin user ID : " . $_SESSION["user_id"]);
                return LabConfigResolver::$resolved_lab_config_id;
            }
        }

        $log->warning("Could not resolve lab_config_id. Logged in user ID: " . $_SESSION["user_id"]);
    }
}
