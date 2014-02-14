<?php
#
# Returns <option> tags for list of test types by category (section) and site
# Called via Ajax from reports.php
#

include("../includes/db_lib.php");
include("../includes/page_elems.php");
LangUtil::setPageId("general");

$page_elems = new PageElems();
$lab_config_id = $_REQUEST['l'];
$cat_code = $_REQUEST['c'];
if(!isset($_REQUEST['all_no']))
	echo "<option value='0'>All</option>";
$page_elems->getTestTypesByCategorySelect($lab_config_id, $cat_code);
?>