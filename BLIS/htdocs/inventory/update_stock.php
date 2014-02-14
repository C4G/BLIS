<?php

include("redirect.php");
include("../includes/db_lib.php");
putUILog('update_stock', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$lid = $_REQUEST['lid'];
$r_id = $_REQUEST['r_id'];
$remarks = $_REQUEST['remarks'];
$lot = $_REQUEST['lot'];
$n_lot = $_REQUEST['n_lot'];
$e_date = $_REQUEST['yyyy_e']."-".$_REQUEST['mm_e']."-".$_REQUEST['dd_e'];
$manu = $_REQUEST['manu'];
$sup = $_REQUEST['sup'];
$cost = $_REQUEST['cost'];
$r_date = $_REQUEST['yyyy_r']."-".$_REQUEST['mm_r']."-".$_REQUEST['dd_r'];

Inventory::updateStock($lid, $r_id, $lot, $n_lot, $e_date, $manu, $sup, $cost, $r_date, $remarks);
//$lid, $r_id, $lot, $n_lot, $e_date, $manu, $sup, $cost, $r_date, $remarks
$url = "Location: ../stock_lots.php?id=".$r_id;
header( $url );

?>
