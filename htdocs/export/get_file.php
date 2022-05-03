<?php

######
# Securely retrieve a file from the files/ folder.
# Should ideally perform authentication/authorization before sending the file.

$files_dir = dirname(__FILE__) . "/../../files";
$file = $_REQUEST['f'];
// Prevent malicious users from grabbing any old system file
$file = str_replace("..", "", $file);

header("Content-disposition: attachment;filename=" . basename($file));
readfile("$files_dir/$file");
