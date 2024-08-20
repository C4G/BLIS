<?php

include("../includes/db_lib.php");
putUILog('export_word', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
$fullPath = dirname(__FILE__)."\\";
array_map('unlink', glob( "$fullPath*.pdf"));
$date = date("Ymdhi");
$file_name = dirname(__FILE__).'\blisreport_'.$date.".pdf";
$_file_name = 'blisreport_'.$date.".pdf";
$cmd = " docto -f \"".dirname(__FILE__).'\file.doc"'." -O \"".$file_name."\" -T wdFormatPDF";
$id=$_REQUEST['lab_id'];
$var=dirname(dirname(__FILE__))."\logos\logo_".$id.".jpg";
$html_content = "<img src='".$var."'"." height='140' width='140' />" . stripcslashes($_REQUEST['data']);
#echo dirname(__FILE__);

$file = fopen(dirname(__FILE__).'\file.doc', 'w+');
fwrite($file, $html_content);
fclose($file);

system($cmd);

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $_file_name . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
echo file_get_contents($file_name);
