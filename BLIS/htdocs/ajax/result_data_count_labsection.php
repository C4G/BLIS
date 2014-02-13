<?php
include("../includes/db_lib.php");

$attrib_value = $_REQUEST['q'];
$count = 0;

$query_string =
"SELECT COUNT(specimen_id) AS val FROM test WHERE result='' ".
"AND test_type_id IN (SELECT test_type_id FROM test_type WHERE test_category_id=$attrib_value) AND specimen_id NOT IN (select r_id from removal_record where status='1' AND category='specimen')";

$resultset = query_associative_one($query_string);
	$count = $resultset['val'];
echo $count;
?>
