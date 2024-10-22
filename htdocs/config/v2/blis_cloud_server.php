<?php

require_once(__DIR__."/../../includes/composer.php");
require_once(__DIR__."/lib/lab_connection.php");

# The controller for BLIS Cloud Server (/receiver) operations.

$action = $_GET["action"];
$lab_config_id = $_GET["lab_config_id"];

db_change("blis_revamp");
$lab_db_name_query = "SELECT lab_config_id, name, db_name FROM lab_config WHERE lab_config_id = '$lab_config_id';";
$lab = query_associative_one($lab_db_name_query);

if (!$lab) {
    // doesn't exist!
    header("HTTP/1.1 400 Bad Request", true, 400);
    exit;
}

$lab_name = $lab["name"];

if ($action === "connect") {
    $connection_code = $_POST["connection_code"];
    $pubkey = $_POST["public_key"];

    // look up connection
    $connection = LabConnection::find_by_lab_config_id($lab_config_id);

    if ($connection != null) {
        // Lab connection already exists, so this request is trying to re-connect.
        header("HTTP/1.1 400 Bad Request", true, 400);
        exit;
    }
    
    if ($connection_code != $connection->connection_code) {
        // Connection code does not match
        header("HTTP/1.1 400 Bad Request", true, 400);
        exit;
    }

    // Connection does not exist and connection code matches!

    $key = KeyMgmt::create($lab_name, $pubkey, -1);
    KeyMgmt::add_key_mgmt($key);
    $key_id = KeyMgmt::getByLabName($lab_name)['id'];

    $connection->lab_pubkey_id = $key_id;
    $connection->refresh_connection_code();
    $connection->save();

    echo("{\"connection_code\": \"".$connection->connection_code."\"}");
    exit;
}


if ($action === "backup") {

}