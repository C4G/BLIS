<?php

include "../includes/db_lib.php";

if(!isset($_REQUEST['reagent_id']) || !isset($_REQUEST['lot']))
{
    echo -2;
    return;
}

$reagent_id = $_REQUEST['reagent_id'];
$lot = $_REQUEST['lot'];

$result = API::get_stock_usage($reagent_id, $lot);

if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
