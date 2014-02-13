<?php
include("redirect.php");
include("../includes/db_lib.php");

/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/

putUILog('ret_tests', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$lid = $_SESSION['lab_config_id'];
$sp = $_POST['specs'];
$count = count($sp);
for($i = 0; $i < $count; $i++)
{
	if(isset($_POST['category'])){
		retrieve_specimens($lid, $sp[$i], $remarks[$i], $_POST['category']);
		retrieve_deleted_items($lid, $sp[$i],$_POST['category']);
	}
	else{
		retrieve_specimens($lid, $sp[$i]);
		retrieve_deleted_items($lid, $sp[$i]);
	}
}

/* if(isset($_POST['category'])){
	echo $_POST['category'];
} */
$url = "Location:../".$_POST['url'];
header( $url );

?>
