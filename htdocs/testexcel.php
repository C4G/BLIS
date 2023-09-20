<?php

require_once("includes/composer.php");

// $objPHPExcel = new PHPExcel();
// $sheet = $objPHPExcel->getSheet(0);
// $sheet->setCellValue("A1", "Mitchell Rysavy");

// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
// $objWriter->save("05featuredemo.xlsx");

echo "Hello world\n";

$arr = scandir("Z:\home\mitchell\github\BLIS\htdocs\\export/uploads/blis_backup_Saltpond-Municipal-Hospital---Ghana_20120610-1106/");
if (count($arr) > 0 && $arr[0] == ".") {
    $arr = array_splice($arr, 0, 1);
}
if (count($arr) > 0 && $arr[0] == "..") {
    $arr = array_splice($arr, 0, 1);
}


echo count($arr)

?>