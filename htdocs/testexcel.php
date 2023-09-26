<?php

require_once("includes/composer.php");

$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getSheet(0);
$sheet->setCellValue("A1", "Mitchell Rysavy");

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save("05featuredemo.xlsx");

echo "Hello world\n";

?>