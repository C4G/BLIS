<?php

include "../includes/db_lib.php";

//$tok = $_REQUEST['tok'];
if(!isset($_REQUEST['patient_id']))
{
    echo -2;
    return;
}
$patient_id = $_REQUEST['patient_id'];
$result = API::get_patient($patient_id);

if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
