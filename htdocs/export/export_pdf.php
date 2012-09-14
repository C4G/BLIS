<?php
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
?>