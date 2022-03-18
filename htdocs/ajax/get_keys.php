<?php
require_once("../includes/keymgmt.php");
require_once("../includes/SessionCheck.php");

echo json_encode(KeyMgmt::getAllKeys());
