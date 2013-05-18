<?php

include "../includes/db_lib.php";

echo API::test_api(44);
echo "<br>";
$username = "buea_admin";
$password = "admin123";
$tok = API::login($username, $password);
echo "<br>";
echo $_SESSION['token'];
echo "<br>";
echo API::stop_session($tok);

echo "<br>";
echo $_SESSION['token'];

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";


?>
