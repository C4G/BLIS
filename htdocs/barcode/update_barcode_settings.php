<?php
include('../include/db_lib.php');

$type = $_REQUEST['brfields_type'];
$width = $_REQUEST['brfields_width'];
$height = $_REQUEST['brfields_height'];
$textsize = $_REQUEST['brfields_textsize'];
$enable = $_REQUEST['brfields_enable'];

update_lab_config_settings_barcode($type, $width, $height, $textsize, $enable);
?>
