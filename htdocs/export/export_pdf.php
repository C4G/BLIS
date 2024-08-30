<?php
require_once("../includes/composer.php");
require_once("../includes/db_lib.php");

putUILog('export_word', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$base_path = realpath(__DIR__."/../../files/");

$date = date("Ymdhi");

$file_base_name = $base_path.'/blisreport_'.$date;

$lab_id=$_REQUEST['lab_id'];
$logo_file=__DIR__."/../logos/logo_".$lab_id.".jpg";
$html_content = "<img src='".$logo_file."'"." height='140' width='140' />\n" . stripcslashes($_REQUEST['data']);

$file = fopen($file_base_name.'.html', 'w+');
fwrite($file, $html_content);
fclose($file);

$cmd = "pandoc -f html --pdf-engine=weasyprint -i \"$file_base_name.html\" -o \"$file_base_name.pdf\"";
$output = system($cmd);

unlink("$file_base_path.html");

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($file_base_name.".pdf") . '"');
header('Content-Length: ' . filesize("$file_base_name.pdf"));
readfile("$file_base_name.pdf");
