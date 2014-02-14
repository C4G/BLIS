<?php

include "../includes/db_lib.php";

if(!isset($_REQUEST['specimen_id']))
{
    echo -2;
    return;
}
$specimen_id = $_REQUEST['specimen_id'];
$result = API::get_tests($specimen_id);

if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
