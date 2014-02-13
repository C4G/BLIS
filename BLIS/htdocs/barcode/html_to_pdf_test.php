<?php
	
	require('html_to_pdf.inc.php');
	$htmltopdf = new HTML_TO_PDF();
	
	//$htmltopdf->useURL(HKC_USE_EASYW);  // default HKC_USE_ABC other HKC_USE_EASYW
	$htmltopdf->saveFile("abc.pdf");
	$htmltopdf->downloadFile("abc.pdf");
	//$result = $htmltopdf->convertHTML("<div style='padding: 0px; overflow: auto; width: 194px;' id='bar1'><div style='float: left; font-size: 0px; background-color: #FFFFFF; height: 40px; width: 60px'><div style='float: left; font-size: 0px; width:0; border-left: 2px solid #000000; height: 40px;'>");
	$result = $htmltopdf->convertURL("http://www.gmail.com");
	if($result==false)
		echo $htmltopdf->error();
?>