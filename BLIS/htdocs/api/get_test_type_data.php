<?php

include "../includes/db_lib.php";
if(!isset($_REQUEST['test_type_id']))
{
    echo -2;
    return;
}

$tid = $_REQUEST['test_type_id'];
$result = API::get_test_type($tid);

if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
