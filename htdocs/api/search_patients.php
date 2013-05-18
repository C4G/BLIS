<?php

include "../includes/db_lib.php";


if(!isset($_REQUEST['option']) || !isset($_REQUEST['query']))
{
    echo -2;
    return;
}

$by = $_REQUEST['option'];
$str = $_REQUEST['query'];
$result = API::search_patients($by, $str);

if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
