<?php

/**
 * Small helper to contain logic for creating feature-flagged code.
 * Most functions should be based on environment variables or other readily-available data.
 */

class Features {

    public static function lab_config_v2_enabled() {
        // Enabled by default now!
        return Features::ev_enabled("BLIS_LAB_BACKUPS_V2_ENABLED");
    }

    private static function ev_enabled($ev) {
        return getenv($ev) == "1" || getenv($ev) == "true";
    }
}
