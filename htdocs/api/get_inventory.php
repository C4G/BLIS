<?php

include "../includes/db_lib.php";


//$specimen_id = $_REQUEST['specimen_id'];
//$tok = $_REQUEST['tok'];

$result = API::get_inventory();

if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
