<?php
@session_start();
//require_once("../dompdf/dompdf_config.inc.php");
include("../MPDF57/mpdf.php");

$baseurl = $_SERVER["HTTP_HOST"];
$baseurl ='http://'.$baseurl.'/';

//$Aux_id=$_REQUEST['aux_id'];
//$lab_config_id = $_REQUEST['location'];
//$patient_id = $_REQUEST['patient_id'];

$url = $baseurl.'reports_auxid.php?aux_id='.$_REQUEST['aux_id'].'&location='.$_REQUEST['location'].'&patient_id='.$_REQUEST['patient_id'];
//echo $url;exit;
$return = file_get_contents($url);

$mpdf=new mPDF('c'); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->mirrorMargins = 1; 

$mpdf->defaultheaderfontsize = 7; 
$mpdf->defaultheaderfontstyle = B; 
$mpdf->defaultheaderline = 1; 
$mpdf->defaultfooterfontsize = 8; 
$mpdf->defaultfooterfontstyle = B; 
$mpdf->defaultfooterline = 1; 
//$mpdf->SetHeader('');
date_default_timezone_set("UTC");
$currtime = date('F j, Y, g:i a');
$mpdf->SetFooter('Printed @ '.$currtime.'|Page {PAGENO}'); /* defines footer for Odd and Even Pages - placed at Outer margin */
$mpdf->SetHeader('Results for Specimen ID: '.$_REQUEST['aux_id']);
$mpdf->WriteHTML($return);
$mpdf->Output();

//echo $return;exit;

/*$dompdf = new DOMPDF();
  $dompdf->load_html($return);
  $dompdf->set_paper("A4", "portrait");  
  $dompdf->render();
  $dompdf->stream("Result_".$_REQUEST['aux_id'], array("Attachment" => false)); */

  exit(0);