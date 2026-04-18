<?php

require_once(__DIR__."/../../vendor/autoload.php");

# Logger setup

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

$_log_dir     = getenv("LOG_DIR")     ?: dirname(__DIR__, 2) . "/log";
$_data_dir    = getenv("DATA_DIR")    ?: dirname(__DIR__, 2) . "/files";
$_storage_dir = getenv("STORAGE_DIR") ?: dirname(__DIR__, 2) . "/storage";

if (!file_exists($_log_dir)) {
    mkdir($_log_dir, 0755, true);
}

$is_cli = (php_sapi_name() === 'cli');

$log = new Logger("application");
$log->pushHandler(new StreamHandler($_log_dir . "/application.log", Logger::DEBUG));
if ($is_cli) {
    $log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
}

$db_log = new Logger("database");
$db_log->pushHandler(new StreamHandler($_log_dir . "/database.log", Logger::DEBUG));

# Check for other folders needed by application
if (!file_exists($_data_dir . "/backups")) {
    mkdir($_data_dir . "/backups", 0755, true);
}

if (!file_exists($_storage_dir)) {
    mkdir($_storage_dir, 0755, true);
}

require_once(__DIR__."/platform_lib.php");

# Ensure that we create the language files in local/
# if they don't exist yet.

$lab_config_id = null;
if (isset($_SESSION["lab_config_id"])) {
    $lab_config_id = $_SESSION["lab_config_id"];
}

$lang_template_path = realpath(__DIR__."/../Language/");
$local_path = getenv("LOCAL_DIR") ?: realpath(__DIR__."/../../local");

if (!file_exists("$local_path/langdata_revamp/")) {
    $log->warning("$local_path/langdata_revamp does not exist, copying template");
    PlatformLib::copyDirectory($lang_template_path, "$local_path/langdata_revamp/");
}

if ($lab_config_id != null && !file_exists("$local_path/langdata_$lab_config_id/")) {
    $log->warning("$local_path/langdata_$lab_config_id does not exist, copying template");
    PlatformLib::copyDirectory($lang_template_path, "$local_path/langdata_$lab_config_id/");
}

$_DATABASE_LOGGERS = array();
function get_database_logger($dbname) {
    global $_DATABASE_LOGGERS, $_log_dir;
    if (!isset($_DATABASE_LOGGERS[$dbname])) {
        $log = new Logger("application");
        $formatter = new LineFormatter("%message%;\n", "");
        $stream = new StreamHandler($_log_dir . "/$dbname.sql.log", Logger::DEBUG);
        $stream->setFormatter($formatter);
        $log->pushHandler($stream);
        $_DATABASE_LOGGERS[$dbname] = $log;
    }
    return $_DATABASE_LOGGERS[$dbname];
}

?>
