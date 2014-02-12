<?php
#
# Returns HTML showing patient information
# Called via Ajax from new_specimen.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
require_once("../lib/date_lib.php");

$page_elems = new PageElems();
$pid = $_REQUEST['pid'];
$page_elems->getPatientInfo($pid, 250); 
?>