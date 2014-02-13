<?php

include("redirect.php");
include("../includes/db_lib.php");
putUILog('update_reagent', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$lid = $_REQUEST['lid'];
$r_id = $_REQUEST['r_id'];
$reagent = $_REQUEST['reagent'];
$unit = $_REQUEST['unit'];
$remarks = $_REQUEST['remarks'];

Inventory::updateReagent($lid, $r_id, $reagent, $unit, $remarks);
header( 'Location: ../view_stock.php' );

?>
