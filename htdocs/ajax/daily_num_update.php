<?php
#
# Main page for updating counts for daily patient numbers
# Called via Ajax from new_specimen.php
#

include("../includes/db_lib.php");
$daily_date_string = $_REQUEST['dnum'];
$dnum_val = $_REQUEST['dval'];
update_daily_number($daily_date_string, $dnum_val);
?>