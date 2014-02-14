<?php

require_once('html2pdf/html2pdf.class.php');

$filename = "hi.pdf";
$content2 = "<div style='padding: 0px; overflow: auto; width: 194px;' id='bar1'><div style='float: left; font-size: 0px; background-color: #FFFFFF; height: 40px; width: 60px'><div style='float: left; font-size: 0px; width:0; border-left: 2px solid #000000; height: 40px;'></div></div></div>";
//$content = $_REQUEST['content_for_pdf'];   
//$content3 = str_replace("'", "\"", $content);
//print_r($_REQUEST);
$content =  stripslashes($_REQUEST['content_for_pdf']);
echo $content;
    try
    {
        //$html2pdf = new HTML2PDF('P', 'A4', 'fr');
//      $html2pdf->setModeDebug();
        //$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->Output($filename);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
