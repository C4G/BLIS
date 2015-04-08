<?php

include "../includes/db_lib.php";

$username = @$_REQUEST['username'];
$password = @$_REQUEST['password'];
$dbname = API::login($username, $password);
if($dbname === -1)
{
	echo -1;exit;
}
	$specimen_id = @$_REQUEST['specimen_id'];
	$specimen_type_filter = @$_REQUEST['specimenfilter'];
	$test_filter = @$_REQUEST['testfilter'];
	$datefrom = @$_REQUEST['datefrom'];
	$dateto = @$_REQUEST['dateto'];
	$result = API::get_specimenAndTest($dbname,$specimen_id,$specimen_type_filter,$test_filter,$datefrom,$dateto);
	
	if($result < 1)
		echo $result;
	else
		echo json_encode($result); 


?>
