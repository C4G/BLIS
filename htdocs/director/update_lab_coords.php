<?php

include("redirect.php");
include("includes/db_lib.php");

$xCoord = $_REQUEST['xCoord'];
$yCoord = $_REQUEST['yCoord'];
$lab_id = $_REQUEST['labId'];
$dir_id = $_REQUEST['directorId'];

create_or_update_map_coords_entry($lab_id, $dir_id, $xCoord, $yCoord);
?>