<?php
#
# Main page for deleting a lab configuration
# Called via Ajax from lab_config_home.php
#

include("../includes/db_lib.php");
$lab_config_id = $_REQUEST['id'];
$new_currency_value = $_REQUEST['currencyName'];
# Delete DB tables corresponding to this lab configuration
$dbStatus = add_currency_lab_config($lab_config_id, $new_currency_value);
if($dbStatus){
	echo "true";
}
?>

