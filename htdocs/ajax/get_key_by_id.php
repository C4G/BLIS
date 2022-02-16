<?php

include("../includes/db_lib.php");
include("../includes/SessionCheck.php");
$id=$_REQUEST['id'];
$ret=KeyMgmt::getById($id);
$json = json_encode($ret);
echo $json;
?>