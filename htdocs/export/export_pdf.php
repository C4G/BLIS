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



/*
date_default_timezone_set('UTC');

require_once('../html2pdf/html2pdf.class.php');

$date = date("Ymdhi");
$file_name = "blisreport_".$date.".pdf";

$id=$_REQUEST['lab_id'];
$var=dirname(dirname(__FILE__))."\logos\logo_".$id.".jpg";
$html_content = "<img src='".$var."'"." height='140' width='140' />" . $_REQUEST['data'];


$html2pdf = new HTML2PDF('P','A4','en');
$html2pdf->setDefaultFont("times");
$html2pdf->WriteHTML($html_content);
$html2pdf->Output($file_name,"d");




include("../includes/db_lib.php");
putUILog('export_pdf', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
//getting new instance
$pdfFile = new_pdf();

PDF_open_file($pdfFile, " ");

//document info
pdf_set_info($pdfFile, "Auther", "Ahmed Elbshry");
pdf_set_info($pdfFile, "Creator", "Ahmed Elbshry");
pdf_set_info($pdfFile, "Title", "PDFlib");
pdf_set_info($pdfFile, "Subject", "Using PDFlib");

//starting our page and define the width and highet of the document
pdf_begin_page($pdfFile, 595, 842);

//check if Arial font is found, or exit
if($font = PDF_findfont($pdfFile, "Arial", "winansi", 1)) {
    PDF_setfont($pdfFile, $font, 12);
} else {
    echo ("Font Not Found!");
    PDF_end_page($pdfFile);
    PDF_close($pdfFile);
    PDF_delete($pdfFile);
    exit();
}

//start writing from the point 50,780
PDF_show_xy($pdfFile, "This Text In Arial Font", 50, 780);
PDF_end_page($pdfFile);
PDF_close($pdfFile);

//store the pdf document in $pdf
$pdf = PDF_get_buffer($pdfFile);
//get  the len to tell the browser about it
$pdflen = strlen($pdfFile);

//telling the browser about the pdf document
header("Content-type: application/pdf");
header("Content-length: $pdflen");
header("Content-Disposition: inline; filename=phpMade.pdf");
//output the document
print($pdf);
//delete the object
PDF_delete($pdfFile);

*/
?>