<?php

include "../includes/db_lib.php";

$username = @$_REQUEST['username'];
$password = @$_REQUEST['password'];
$dbname = API::login($username, $password);
if($dbname === -1)
{
	echo -1;exit;
}
	$day = @$_REQUEST['day'];
	$specimen_type_filter = @$_REQUEST['specimenfilter'];
	$test_filter = @$_REQUEST['testfilter'];	
	$aux_id = @$_REQUEST['auxid'];
	$result = API::getTestDetails($dbname,$specimen_type_filter,$test_filter,$day,$aux_id);
	
	if($result < 1)
		echo $result;
	else
		echo json_encode($result); 


?>
