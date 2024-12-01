<?php

require_once(__DIR__."/platform_lib.php");

/**
 * Small helper to contain logic for creating feature-flagged code.
 * Most functions should be based on environment variables or other readily-available data.
 */

class Features {

    /**
     * Enables the redesigned administrator lab config view.
     * This is always enabled for Docker/server installations.
     * Windows/client installations can force enable it with an environment variable.
     */
    public static function lab_config_v2_enabled() {
        if (!PlatformLib::runningOnWindows()) {
            return true;
        }
        return Features::ev_enabled("BLIS_LAB_BACKUPS_V2_ENABLED");
    }

    /**
     * Enables the legacy hand-written debug logger rather than using Monolog.
     * This also places database logs in the local/ folder for each lab.
     * Leaving this disabled uses monolog and creates database-specific logs in the log/ folder.
     */
    public static function legacy_database_logger() {
        return Features::ev_enabled("BLIS_LEGACY_DB_LOGGER_ENABLED");
    }

    /**
     * Enables the "BLIS Cloud" Lab Connection UI in the Lab Config page.
     * This is enabled on Windows/client installations.
     * It can be force-enabled by environment variable on Docker/server installations.
     */
    public static function lab_connection_enabled() {
        if (PlatformLib::runningOnWindows()) {
            return true;
        }
        return Features::ev_enabled("BLIS_LAB_CONNECTION_ENABLED");
    }

    private static function ev_enabled($ev) {
        return getenv($ev) == "1" || getenv($ev) == "true";
    }
}
