<?php
include("../includes/db_lib.php");
putUILog('export_html', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$myFile = "../../htdocs/BLISSetup.html";
$fh = fopen($myFile, 'w') or die("can't open file");
$content =('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<META HTTP-EQUIV="Refresh"
CONTENT="1; URL=');
$content1=('">
</head> 
</html>');
$content=$content.$_REQUEST['data'].$content1;
fwrite($fh, $content);
fclose($fh);
?>