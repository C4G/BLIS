<?php
#
# Main page for listing all options for a lab configuration
# Used by the Lab Admin periodically to change settings
#
include("redirect.php");
include("includes/new_image.php");
include("includes/header.php");
include("includes/random.php");
include("includes/stats_lib.php");
include_once("includes/field_order_update.php");

LangUtil::setPageId("grouped_report_config");
echo "hi";

putUILog('grouped_report_config', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$script_elems->enableTableSorter();
$script_elems->enableJQueryForm();

?>
<script src="js/jquery-ui-1.8.16.js" type="text/javascript"></script>
<link rel="stylesheet" href="css//jquery-ui-1.8.16.css" type="text/css" media="all">

 <link rel="stylesheet" href="css/jquery-ui-1.8.16.css" type="text/css" media="all"> 