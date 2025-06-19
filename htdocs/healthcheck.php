<?php
// This is supposed to be a very fast healthcheck page that will check if BLIS is accessible.
$status = "ok";
$response_code = 200;

require_once("includes/db_constants.php");

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, null, $DB_PORT);

if (!$con) {
    $status = "could not connect to database: $DB_HOST";
} else {
    if (!mysqli_query($con, "SELECT DATABASE()")) {
        $status = "could not query database";
    }
    mysqli_close($con);
}

if ($status != "ok") {
    $response_code = 500;
}

header("Content-Type: application/json", true, $response_code);

?>

{ "status": "<? echo($status) ?>" }
