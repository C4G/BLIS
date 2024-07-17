<?php
session_start();
require_once(__DIR__."/user_lib.php");
if(basename($_SERVER['PHP_SELF'])!=="login.php")
{
if(!isset($_SESSION['user_id']))
{
header("Location: /login.php");
die();
}
if($_SESSION['user_level'] != $LIS_SUPERADMIN &&	$_SESSION['user_level'] != $LIS_COUNTRYDIR&&	$_SESSION['user_level'] != $LIS_ADMIN)
{
if($_SESSION['user_level'] ==$READONLYMODE)
{
$_SESSION['rwoptionsarray']=array(5);
}
if(!is_allowed(basename($_SERVER['PHP_SELF']),implode(",",$_SESSION['rwoptionsarray'])))
{
header("Location: /home.php");
die();
}
}
}
?>
