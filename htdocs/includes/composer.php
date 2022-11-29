<?php

require_once(dirname(__FILE__) . '/../../vendor/autoload.php');

# Logger setup

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

# Check if log/ folder does not exist
if (!file_exists(__DIR__."/../../log")) {
    # If not, create it
    mkdir(__DIR__."/../../log", 0755);
}

$log = new Logger('application');
$log->pushHandler(new StreamHandler(dirname(__FILE__).'/../../log/application.log', Logger::DEBUG));

$db_log = new Logger('database');
$db_log->pushHandler(new StreamHandler(dirname(__FILE__).'/../../log/database.log', Logger::DEBUG));

# Check for other folders needed by application
if (!file_exists(__DIR__."/../../files")) {
    # If not, create it
    mkdir(__DIR__."/../../files", 0755);
}

?>
