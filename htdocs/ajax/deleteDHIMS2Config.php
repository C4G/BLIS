<?php
include("../includes/db_lib.php");
$dhims2 = new DHIMS2();
echo $dhims2->deleteItems($_REQUEST['l'],$_REQUEST['items']);
?>