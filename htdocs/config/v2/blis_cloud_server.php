<?php

require_once(__DIR__."/../../includes/composer.php");
require_once(__DIR__."/lib/lab_connection.php");
require_once(__DIR__."/lib/analyzed_backup.php");
require_once(__DIR__."/lib/backup.php");
require_once(__DIR__."/lib/encrypted_file.php");

# The controller for BLIS Cloud Server (/receiver) operations.

if (!Features::allow_client_connections()) {
    header('HTTP/1.1 404 Not Found', true, 404);
    header("Location: /home.php");
    exit;
}

$action = $_POST["action"];
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
$lab_db_name = $lab["db_name"];

$connection_code = str_replace("-", "", $_POST["connection_code"]);

if ($action == "connect") {
    $log->warn("Connection request received for lab $lab_config_id: $lab_name");

    // look up connection
    $connection = LabConnection::find_by_lab_config_id($lab_config_id);

    if ($connection != null) {
        // Lab connection already exists, so this request is trying to re-connect.
        $log->warn("Lab $lab_config_id is already connected. Re-connecting.");
    }

    $nrml_code = str_replace("-", "", $connection->connection_code);

    if ($connection_code != $nrml_code) {
        $log->warn("Connection attempted with wrong connection code. Lab ID: $lab_config_id; Incorrect code: $connection_code");
        // Connection code does not match
        header("HTTP/1.1 400 Bad Request", true, 400);
        exit;
    }

    // Connection does not exist and connection code matches!

    $log->info("Successful connection initiated for lab '$lab_name' ($lab_config_id)");

    $server_pub = KeyMgmt::pathToKey("LAB_dir_pubkey.blis");
    $server_pvt = KeyMgmt::pathToKey("LAB_dir.blis");
    if (!$server_pub || !$server_pvt) {
        $log->info("Generating server keypair");
        $key_basedir = realpath(__DIR__."/../../../files");
        KeyMgmt::generateKeyPair("$key_basedir/LAB_dir.blis", "$key_basedir/LAB_dir_pubkey.blis");
        $server_pub = KeyMgmt::pathToKey("LAB_dir_pubkey.blis");
        $server_pvt = KeyMgmt::pathToKey("LAB_dir.blis");
    }
    $server_key = file_get_contents($server_pub);
    $server_key = base64_encode($server_key);

    $connection->lab_name = $_POST["lab_name"];
    $connection->refresh_connection_code();
    $connection->save();

    $response = array();
    $response["connection_code"] = $connection->connection_code;
    $response["public_key"] = $server_key;

    echo(json_encode($response));
    exit;

} else if ($action == "backup") {
    // look up connection
    $connection = LabConnection::find_by_lab_config_id($lab_config_id);

    if ($connection == null) {
        // Lab connection does not exist, so backups can't be uploaded.
        header("HTTP/1.1 400 Bad Request", true, 400);
        exit;
    }

    $nrml_code = str_replace("-", "", $connection->connection_code);
    if ($connection_code != $nrml_code) {
        // Connection code does not match
        header("HTTP/1.1 400 Bad Request", true, 400);
        exit;
    }

    // Connection code matches!

    $backup_date = $_POST["backup_date"];
    $backup_envelope_key = $_POST["envelope_key"];
    $backup_filename = $_FILES["backup_file"]["name"];
    $backup_tmp_path = $_FILES["backup_file"]["tmp_name"];

    $backup_location = realpath(__DIR__."/../../../files/storage/");
    // Format is: blis_backup_cloud_[lab config ID]_[date of backup]_[date of upload].zip
    $backup_filename = "blis_backup_cloud_".$lab_config_id."_" .
                       date("Ymd-His", $backup_date) . "_" . date("Ymd-His")  . ".zip";
    $decrypted_path = "$backup_location/$backup_filename";

    $enc = new EncryptedFile($backup_tmp_path);
    $result = $enc->decrypt("LAB_dir.blis", $backup_envelope_key, $decrypted_path);

    if (!$result) {
        header("HTTP/1.1 500 Internal Server Error", true, 500);
        exit;
    }

    db_change($lab_db_name);
    $backup = Backup::insert($lab_config_id, $backup_filename, "storage/$backup_filename");

    $connection->last_backup_time = strftime("%s");
    $ip = "";
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $connection->last_backup_ip = $ip;
    $connection->refresh_connection_code();
    $connection->save();

    $log->info("Backup uploaded successfully!");

    $response = array();
    $response["connection_code"] = $connection->connection_code;

    echo(json_encode($response));

    exit;
}
