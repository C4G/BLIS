<?php
#
# Exports the given HTML content as word document
#
$date = date("Ymdhi");
$file_name = "blisreport_".$date.".doc";
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=$file_name");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252" />  
<title>Saves as a Word Doc</title>  
</head> 
<body>  
<?php
$id=$_REQUEST['lab_id'];
$var=dirname(dirname(__FILE__))."\logos\logo_".$id.".jpg";
$html_content = "<img src='".$var."'"." height='140' width='140' />" . $_REQUEST['data'];
print $html_content;
?>
</body>
</html>