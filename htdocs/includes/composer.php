<?php

require_once(dirname(__FILE__) . '/../../vendor/autoload.php');

# Logger setup

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('application');
$log->pushHandler(new StreamHandler(dirname(__FILE__).'/../../log/application.log', Logger::DEBUG));

?>
