<?php
include("redirect.php");
session_start();
include('includes/db_constants.php');

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, null, $DB_PORT);
if (!$con)
{
  die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, $GLOBAL_DB_NAME);

$Latency="";
$Page_Name="";
$Request_URI="";
if(array_key_exists('latency', $_POST))
{
	$Latency = $_POST['latency'];
}
if(array_key_exists('page', $_POST))
{
	$Page_Name = $_POST['page'];
}
if(array_key_exists('uri', $_POST))
{
	$Request_URI = $_POST['uri'];
}

$now=date('Y-m-d H:i:s',time());
$User = $_SESSION['username'];
if(!$_SESSION['DELAY_RECORDED'])
{
	$sql=
		"Insert Into Delay_Measures (User_Id, IP_Address, Latency, Recorded_At, Page_Name, Request_URI) ".
		"VALUES ('$User', '".$_SERVER['REMOTE_ADDR']."', '$Latency', '$now', '$Page_Name', '$Request_URI');";
	if(mysqli_query($con, $sql))
		$_SESSION['DELAY_RECORDED']=true;
	else
		$_SESSION['DELAY_RECORDED']=false;
}
mysqli_close($con);
?>
