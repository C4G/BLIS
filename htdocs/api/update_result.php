<?php

include "../includes/db_lib.php";

$username = @$_REQUEST['username'];
$password = @$_REQUEST['password'];
$dec = 2;
if(isset($_REQUEST['dec']))
$dec = intval($_REQUEST['dec']);
$dbname = API::login($username, $password);
if($dbname === -1)
{
	echo -1;exit;
}
	$specimen_id = trim(@$_REQUEST['specimen_id']);
	$measure_id = trim(@$_REQUEST['measure_id']);
	$result = trim(@$_REQUEST['result']);
	if(empty($specimen_id) || strlen($specimen_id) < 1)
		echo 0;
	else
	{
		$result = number_format($result,$dec,'.','');
		$result = API::update_result($dbname,$specimen_id,$measure_id,urldecode($result));	
		echo $result;
	}
	


?>
