<?php

include("../includes/db_lib.php");

$userId = $_SESSION['user_id'];
$testName = $_REQUEST['testName'];
$labIdTestId = $_REQUEST['labIdTestId'];
$tid = $_REQUEST['country_test_id'];

$saved_db = DbUtil::switchToGlobal();
$queryString = "DELETE FROM test_mapping WHERE test_id = $tid AND user_id = $userId";
$record = query_delete($queryString);
/*$queryString = "SELECT MAX(test_id) AS test_id FROM test_mapping ".
			   "WHERE user_id=$userId";
$record = query_associative_one($queryString);
$testId = intval($record['test_id']) + 1;
*/
$queryString = "INSERT INTO TEST_MAPPING (user_id, test_name, lab_id_test_id, test_id) ".
			   "VALUES (".$userId.",'".$testName."','".$labIdTestId."',".$tid.")";
query_insert_one($queryString) or die(mysql_error());
DbUtil::switchRestore($saved_db);

echo "true";
?>