<?php
include("../includes/db_lib.php");
echo json_encode(getEquipmentProps($_REQUEST['id']));
?>