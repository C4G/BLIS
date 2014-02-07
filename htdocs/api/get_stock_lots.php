<?php

include "../includes/db_lib.php";

if(!isset($_REQUEST['reagent_id']))
{
    echo -2;
    return;
}

$reagent_id = $_REQUEST['reagent_id'];
$result = API::get_stock_lots($reagent_id);

if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
