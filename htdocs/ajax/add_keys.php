<?php

require_once(dirname(__FILE__)."/../includes/keymgmt.php");
require_once("../includes/SessionCheck.php");

$userId = $_SESSION['user_id'];
$lab=$_REQUEST['lab_name'];

$key_text = file_get_contents($_FILES["keys"]["tmp_name"]);
echo KeyMgmt::add_key_mgmt(KeyMgmt::create($lab, $key_text, $userId));
