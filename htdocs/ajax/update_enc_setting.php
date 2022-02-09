<?php
include("../includes/db_lib.php");
include("../includes/SessionCheck.php");
$val=$_REQUEST['val'];
KeyMgmt::write_enc_setting($val);
?>