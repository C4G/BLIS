<?php

include "../includes/db_lib.php";

if(!isset($_REQUEST['yf']) || !isset($_REQUEST['mf']) || !isset($_REQUEST['df']) || !isset($_REQUEST['yt']) || !isset($_REQUEST['dt']) || !isset($_REQUEST['mt']) || !isset($_REQUEST['patient_id']) || !isset($_REQUEST['ip']))
{
    echo -2;
    return;
}
$patient_id = $_REQUEST['patient_id'];
$date_from = $_REQUEST['yf']."-".$_REQUEST['mf']."-".$_REQUEST['df'];
$date_to = $_REQUEST['yt']."-".$_REQUEST['mt']."-".$_REQUEST['dt'];
$ip = $_REQUEST['ip'];
$result = API::get_patient_results($patient_id, $date_from, $date_to, $ip);

if($result < 1)
    echo $result;
else
    echo json_encode($result); 
?>
