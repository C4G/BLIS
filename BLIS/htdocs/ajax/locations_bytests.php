<?php

#
# Returns <option> tags for list of locations available for selection for a particular test
# Called via Ajax from reports.php
#

include("../includes/db_lib.php");

$selectValues = $_REQUEST['l'];
$labIdTestIdArr = explode(';',$selectValues);
$checkBoxName = $_REQUEST['checkBoxName'];

echo "<input type='checkbox' name='$checkBoxName' value='0'>".LangUtil::$generalTerms['ALL']."</input>";

for($i = 0; $i < count($labIdTestIdArr); $i++) {
	$labIdTestId = explode(':',$labIdTestIdArr[$i]);
	$labId = $labIdTestId[0];
	$testId = $labIdTestId[1];
	$lab_config = new LabConfig();
	$record = $lab_config->getById($labId);
	
	echo "<br><input type='checkbox' name='$checkBoxName' value=$labId>$record->name</input>";
}

?>