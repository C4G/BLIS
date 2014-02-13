<?php

include("redirect.php");
include("../includes/db_lib.php");

putUILog('add_reagent', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


$reagent = $_REQUEST['reagent'];
$unit = $_REQUEST['unit'];
$remarks = $_REQUEST['remarks'];
Inventory::addReagent($reagent, $unit, $remarks);
header( 'Location: ../view_stock.php' );

?>
