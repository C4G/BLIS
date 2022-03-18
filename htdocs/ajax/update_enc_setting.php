<?php
require_once("../includes/keymgmt.php");
require_once("../includes/SessionCheck.php");
$val=$_REQUEST['val'];
KeyMgmt::write_enc_setting($val);
