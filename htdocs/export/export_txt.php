<?php
#
# Exports the given HTML content as txt document
#
include("../includes/db_lib.php");
putUILog('export_text', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
$date = date("Ymdhi");
$file_name = "blisreport_".$date.".txt";
require_once('class.html2text.inc'); 
$html_content = $_REQUEST['data'];
//print $html_content;
// The "source" HTML you want to convert. 
//$html = 'Sample string with HTML code in it'; 
$html = $html_content;

// Instantiate a new instance of the class. Passing the string 
// variable automatically loads the HTML for you. 
$h2t =& new html2text($html); 

// Simply call the get_text() method for the class to convert 
// the HTML to the plain text. Store it into the variable. 
$text = $h2t->get_text(); 

// Or, alternatively, you can print it out directly: 
//return;
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=$file_name");
$h2t->print_text();
?>