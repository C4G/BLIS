<?php

include("../includes/db_lib.php");

$userId = $_SESSION['user_id'];
$testCategoryName = $_REQUEST['testCategoryName'];
$labIdTestCategoryId = $_REQUEST['labIdTestCategoryId'];

$saved_db = DbUtil::switchToGlobal();
$queryString = "SELECT MAX(test_category_id) AS test_category_id FROM test_category_mapping ".
			   "WHERE user_id=$userId";
$record = query_associative_one($queryString);
$testCategoryId = intval($record['test_category_id']) + 1;

$queryString = "INSERT INTO TEST_CATEGORY_MAPPING (user_id, test_category_name, lab_id_test_category_id, test_category_id) ".
			   "VALUES (".$userId.",'".$testCategoryName."','".$labIdTestCategoryId."',".$testCategoryId.")";
query_insert_one($queryString) or die(mysql_error());
DbUtil::switchRestore($saved_db);

echo "true";
?>