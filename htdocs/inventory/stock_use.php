<?php

include("redirect.php");
include("../includes/db_lib.php");
putUILog('stock_use', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$reagent_id = $_REQUEST['reagent'];
//$unit = $_REQUEST['unit'];
$remarks = $_REQUEST['remarks'];
$lot = $_REQUEST['lot'];
$u_date = $_REQUEST['yyyy_u']."-".$_REQUEST['mm_u']."-".$_REQUEST['dd_u'];
$quant = $_REQUEST['quant_u'];
Inventory::useStock($reagent_id, $lot, $quant, $u_date, $remarks);
header( 'Location: ../view_stock.php' );

?>
