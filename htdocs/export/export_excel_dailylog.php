<?php

# TAKE NOTE!
# For this to work properly, you need to make sure that _all_ of these
# required files are not outputting anything to the browser.
# https://github.com/PHPOffice/PHPExcel/blob/1.8/Documentation/markdown/Overview/08-Recipes.md#http-headers
# Ensure that these files are _not_ encoded as "UTF-8 with BOM" (Byte Order Mark)
# since that also counts. They should be "UTF-8".

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once("../includes/composer.php");
require_once("../includes/db_lib.php");
require_once("../includes/db_util.php");
require_once("../includes/user_lib.php");

$table   = stripcslashes($_REQUEST['data']);

// save $table inside temporary file that will be deleted later
$tmpfile = tempnam(sys_get_temp_dir(), 'html');
file_put_contents($tmpfile, $table);

// insert $table into spreadsheet's Active Sheet through the HTML reader
$spreadsheet     = new Spreadsheet();
$excelHTMLReader = IOFactory::createReader('Html');
$excelHTMLReader->loadIntoExisting($tmpfile, $spreadsheet);
$spreadsheet->getActiveSheet()->setTitle('Daily Log');
$spreadsheet->getActiveSheet()->removeRow(1, 4);

unlink($tmpfile); // delete temporary file because it isn't needed anymore

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="dailylog.xlsx"');
header('Cache-Control: max-age=0');

// Creates a writer to output the spreadsheet's content
$objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
$objWriter->save("php://output");