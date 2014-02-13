<?php

include "../includes/db_lib.php";


$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$tok = API::login($username, $password);

echo $tok;
//print_r($_SESSION);
?>
