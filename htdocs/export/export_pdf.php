<?php
require_once("../includes/composer.php");
require_once("../includes/db_lib.php");

putUILog('export_word', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$date = date("Ymdhi");

$exports_dir = $STORAGE_DIR . "/files";
if (!is_dir($exports_dir)) {
    mkdir($exports_dir, 0755, true);
}
$html_tmp      = sys_get_temp_dir() . '/blisreport_' . $date . '.html';
$file_base_name = $exports_dir . '/blisreport_' . $date;

$lab_id=$_REQUEST['lab_id'];
$logo_file=$STORAGE_DIR."/logos/logo_".$lab_id.".jpg";
$html_content = "<img src='".$logo_file."'"." height='140' width='140' />\n" . stripcslashes($_REQUEST['data']);

$file = fopen($html_tmp, 'w+');
fwrite($file, $html_content);
fclose($file);

$cmd = "pandoc -f html --pdf-engine=weasyprint -i \"$html_tmp\" -o \"$file_base_name.pdf\"";
$output = system($cmd);

unlink($html_tmp);

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($file_base_name.".pdf") . '"');
header('Content-Length: ' . filesize("$file_base_name.pdf"));
readfile("$file_base_name.pdf");
