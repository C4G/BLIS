<?php

include("../includes/db_lib.php");

$userId = $_SESSION['user_id'];
$testCategoryName = $_REQUEST['testCategoryName'];
$labIdTestCategoryId = $_REQUEST['labIdTestCategoryId'];
$tid = $_REQUEST['country_test_id'];

$saved_db = DbUtil::switchToGlobal();
$queryString = "DELETE FROM test_category_mapping WHERE test_category_id = $tid AND user_id = $userId";
$record = query_delete($queryString);
/*$queryString = "SELECT MAX(test_id) AS test_id FROM test_mapping ".
			   "WHERE user_id=$userId";
$record = query_associative_one($queryString);
$testId = intval($record['test_id']) + 1;
*/
$queryString = "INSERT INTO TEST_CATEGORY_MAPPING (user_id, test_category_name, lab_id_test_category_id, test_category_id) ".
			   "VALUES (".$userId.",'".$testCategoryName."','".$labIdTestCategoryId."',".$tid.")";
query_insert_one($queryString) or die(mysql_error());
DbUtil::switchRestore($saved_db);
echo "true";
?>