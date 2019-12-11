<?php

include("../includes/db_lib.php");
include("../includes/SessionCheck.php");
$id=$_REQUEST['id'];
$ret=KeyMgmt::delete_key_mgmt($id);
echo $ret;
?>