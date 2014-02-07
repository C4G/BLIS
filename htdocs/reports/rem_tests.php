<?php
include("redirect.php");
include("../includes/db_lib.php");

/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/
putUILog('rem_tests', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$lid = $_SESSION['lab_config_id'];
$sp = $_POST['sp'];
$remarks = $_POST['remarks'];
$count = count($sp);
for($i = 0; $i < $count; $i++)
{
	if(isset($_POST['category'])){
    	remove_specimens($lid, $sp[$i], $remarks[$i], $_POST['category']);
    	$testsList = get_tests_by_specimen_id($sp[$i]);
    	delete_tests_by_test_id($testsList);
	}
	else { 
		remove_specimens($lid, $sp[$i], $remarks[$i]);
		
	}
}

$url = "Location:../".$_POST['url'];
header( $url );

?>
