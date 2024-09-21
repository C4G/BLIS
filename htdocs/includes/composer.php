<?php

require_once(__DIR__."/../../vendor/autoload.php");

# Logger setup

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

# Check if log/ folder does not exist
if (!file_exists(__DIR__."/../../log")) {
    # If not, create it
    mkdir(__DIR__."/../../log", 0755);
}

$log = new Logger("application");
$log->pushHandler(new StreamHandler(__DIR__."/../../log/application.log", Logger::DEBUG));

$db_log = new Logger("database");
$db_log->pushHandler(new StreamHandler(__DIR__."/../../log/database.log", Logger::DEBUG));

# Check for other folders needed by application
if (!file_exists(__DIR__."/../../files")) {
    # If not, create it
    mkdir(__DIR__."/../../files", 0755);
}

require_once(__DIR__."/platform_lib.php");

# Ensure that we create the language files in local/
# if they don't exist yet.

$lab_config_id = null;
if (isset($_SESSION["lab_config_id"])) {
    $lab_config_id = $_SESSION["lab_config_id"];
}

$lang_template_path = realpath(__DIR__."/../Language/");
$local_path = realpath(__DIR__."/../../local");

if (!file_exists("$local_path/langdata_revamp/")) {
    $log->warn("$local_path/langdata_revamp does not exist, copying template");
    PlatformLib::copyDirectory($lang_template_path, "$local_path/langdata_revamp/");
}

if ($lab_config_id != null && !file_exists("$local_path/langdata_$lab_config_id/")) {
    $log->warn("$local_path/langdata_$lab_config_id does not exist, copying template");
    PlatformLib::copyDirectory($lang_template_path, "$local_path/langdata_$lab_config_id/");
}

?>
