<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("db_lib.php");
$sid = $_REQUEST['sid'];
echo encodeSpecimenBarcode($sid, 0);
?>
