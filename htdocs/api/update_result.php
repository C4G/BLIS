<?php

include "../includes/db_lib.php";
include("misc.php");

$username = @$_REQUEST['username'];
$password = @$_REQUEST['password'];
$dec = 2;
if(isset($_REQUEST['dec']))
$dec = intval($_REQUEST['dec']);
$dbname = API::login($username, $password,true);
if($dbname === -1)
{
	echo -1;exit;
}
	$split = explode('^',$dbname);
	$dbname = $split[0];
	$specimen_id = trim(@$_REQUEST['specimen_id']);
	$specimen_id = getAuxID($specimen_id,$dbname);	
	$measure_id = trim(@$_REQUEST['measure_id']);
	$result = trim(@$_REQUEST['result']);
	if(empty($specimen_id) || strlen($specimen_id) < 1)
		echo 0;
	else
	{	
		if($dec != 0)
		{
			$result = number_format($result,$dec,'.','');
		}
		$result = API::update_result($dbname,$specimen_id,$measure_id,urldecode($result),$split[1]);	
		echo $result;
	}
	


?>
