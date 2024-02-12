<?php

require_once("../includes/composer.php");
require_once("../includes/db_lib.php");
require_once("../includes/user_lib.php");

$current_user_id = $_SESSION['user_id'];
$current_user = get_user_by_id($current_user_id);

$unauthorized = true;

if (is_super_admin($current_user) || is_country_dir($current_user)) {
    $unauthorized = false;
}

if ($unauthorized) {
    header('HTTP/1.1 401 Unauthorized', true, 401);
    echo "You do not have permission to view this page.";
    exit;
}

$LOG_TYPES = array('application', 'php_error', 'apache2_access', 'apache2_error', 'database');
$type = $_GET['name'];

if (!in_array($type, $LOG_TYPES, true)) {
    header('HTTP/1.1 404 Not Found', true, 404);
    echo "The content could not be found.";
    exit;
}

$filename = "$type.log";
header("Content-Type: text/plain", true, 200);
header("Content-disposition: attachment;filename=$filename");

readfile(__DIR__."/../../log/".$filename);