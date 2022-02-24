<?php

require_once __DIR__ . '/../../vendor/autoload.php';

# Logger setup

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('application');
$log->pushHandler(new StreamHandler(__DIR__.'/../../log/application.log', Logger::DEBUG));

?>