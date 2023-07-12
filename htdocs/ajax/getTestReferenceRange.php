<?php
include("../includes/SessionCheck.php");
include("../includes/db_lib.php");
echo json_encode(getTestReferenceRange($_REQUEST['id']));
?>