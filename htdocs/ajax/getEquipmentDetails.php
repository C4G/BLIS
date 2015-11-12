<?php
include("../includes/db_lib.php");
echo json_encode(getEquipmentDetails($_REQUEST['id']));
?>