<?php
include "../includes/db_lib.php";
$dhims2 = new DHIMS2();
echo json_encode($dhims2->getConfigs('blis_1007'));
?>