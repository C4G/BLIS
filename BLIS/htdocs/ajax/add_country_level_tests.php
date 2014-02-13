<?php

include("../includes/db_lib.php");

$userId = $_SESSION['user_id'];
$testName = $_REQUEST['testName'];
$labIdTestId = $_REQUEST['labIdTestId'];

$saved_db = DbUtil::switchToGlobal();
$queryString = "SELECT MAX(test_id) AS test_id FROM test_mapping ".
			   "WHERE user_id=$userId";
$record = query_associative_one($queryString);
$testId = intval($record['test_id']) + 1;

$queryString = "INSERT INTO TEST_MAPPING (user_id, test_name, lab_id_test_id, test_id) ".
			   "VALUES (".$userId.",'".$testName."','".$labIdTestId."',".$testId.")";
query_insert_one($queryString) or die(mysql_error());
DbUtil::switchRestore($saved_db);

echo "true";
?>