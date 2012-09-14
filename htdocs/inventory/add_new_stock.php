<?php

include("redirect.php");
include("../includes/db_lib.php");

putUILog('add_new_stock', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


$reagent_id = $_REQUEST['reagent'];
//$unit = $_REQUEST['unit'];
$remarks = $_REQUEST['remarks'];
$lot = $_REQUEST['lot'];
$e_date = $_REQUEST['yyyy_e']."-".$_REQUEST['mm_e']."-".$_REQUEST['dd_e'];
$manu = $_REQUEST['manu'];
$sup = $_REQUEST['sup'];
$quant = $_REQUEST['quant'];
$cost = $_REQUEST['cost'];
$r_date = $_REQUEST['yyyy_r']."-".$_REQUEST['mm_r']."-".$_REQUEST['dd_r'];

Inventory::addStock($reagent_id, $lot, $e_date, $manu, $sup, $quant, $cost, $r_date, $remarks);
header( 'Location: ../view_stock.php' );

?>
