<?php

require_once(__DIR__."/util.php");
require_once(__DIR__."/../includes/composer.php");
require_once(__DIR__."/../includes/platform_lib.php");

require_admin_or_401();

global $log;
global $LOCAL_PATH;

try {
    # This method is defined in db_lib.php.
    update_language_files();

    # This is some custom logic to create langdata folders for labs that do not have them
    # Perhaps it should be folded into update_language_files()

    $lc_ids_query = "SELECT lab_config_id FROM lab_config;";
    db_change("blis_revamp");
    $lc_ids = query_associative_all($lc_ids_query);

    $message = "";

    $source_directory = realpath(__DIR__."/../Language/");
    foreach($lc_ids as $record) {
        $lc_id = $record["lab_config_id"];
        $langdata_folder = "$LOCAL_PATH/langdata_$lc_id";

        # if the langdata folder doesn't exist for a lab, copy the stock config
        if (!is_dir($langdata_folder)) {
            PlatformLib::copyDirectory($source_directory, $langdata_folder);
            $message = $message."Created local/langdata_$lc_id<br/>\n";
        }
    }

    $_SESSION['FLASH'] = $message."Language files were reset successfully.";
} catch (Exception $e) {
    $_SESSION['FLASH'] = "Language files could not be updated: $e";
}

header("Location: /debug.php");
exit();