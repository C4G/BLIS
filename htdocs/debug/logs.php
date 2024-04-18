<?php

require_once(__DIR__."/util.php");

require_admin_or_401();

$log_files = available_log_files();
$LOG_TYPES = array_keys($log_files);
$type = $_GET['name'];

if (!in_array($type, $LOG_TYPES, true)) {
    header('HTTP/1.1 404 Not Found', true, 404);
    echo "The content could not be found.";
    exit;
}

header("Content-Type: text/plain", true, 200);
header("Content-disposition: attachment;filename=$type");

readfile($log_files[$type]);
