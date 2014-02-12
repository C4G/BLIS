<?php
include("../includes/db_lib.php");
    $id = $_REQUEST['id'];
    $lid = $_REQUEST['lid'];
    $lot = $_REQUEST['lot'];
    $unit = Inventory::getLotQuantity($lid, $id, $lot);
    if($unit == '')
        echo "0";
    else
        echo $unit;
?>
