<?php
#
# Adds user rating to DB.
#

include("../includes/db_lib.php");
global $con;

$user_id = $_REQUEST['user_id'];
$rating = $_REQUEST['rating'];
$skipped = $_REQUEST['skipped'];
$comments = $_REQUEST['comments'];
//$comments= mysql_real_escape_string($_REQUEST['comments'],$con);
if($skipped==-1)
	$rating=6;

$query_string = 
	"INSERT INTO user_feedback (user_id, rating, comments) ".
	"VALUES ($user_id, $rating, '$comments')";
echo $query_string;
query_blind($query_string);

?>