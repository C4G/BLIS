<?php

include("../includes/db_lib.php");
include("../includes/SessionCheck.php");
$ret=KeyMgmt::getAllKeys();
$json = json_encode($ret);
echo $json;
?>