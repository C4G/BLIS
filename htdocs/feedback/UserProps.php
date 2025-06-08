<?php
include("redirect.php");
session_start();
include('includes/db_constants.php');

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
if (!$con)
{
  die('Could not connect: ' . mysqli_error());
}
mysqli_select_db($con, $GLOBAL_DB_NAME);

$now=date('Y-m-d H:i:s',time());
$User = $_SESSION['username'];

if(!$_SESSION['PROPS_RECORDED'] || $_SESSION['PROPS_RECORDED'] === false)
{
	$sql="Insert Into User_Props (User_Id, AppCodeName, AppName, AppVersion, CookieEnabled, Platform, UserAgent, SystemLanguage, ";
	$sql.="UserLanguage, Language, ScreenAvailHeight, ScreenAvailWidth, ScreenColorDepth, ScreenHeight, ScreenWidth, Recorded_At) VALUES ";
	$sql.="('$User', '"
	.addslashes($_POST['navigator_appCodeName'])."', '".addslashes($_POST['navigator_appName'])."', '"
	.addslashes($_POST['navigator_appVersion'])."', ".addslashes($_POST['navigator_cookieEnabled']).", '"
	.addslashes($_POST['navigator_platform'])."', '".addslashes($_POST['navigator_userAgent'])."', '"
	.addslashes($_POST['navigator_systemLanguage'])."', '".addslashes($_POST['navigator_userLanguage'])."', '"
	.addslashes($_POST['navigator_language'])."', '".addslashes($_POST['screen_availHeight'])."', '"
	.addslashes($_POST['screen_availWidth'])."', '".addslashes($_POST['screen_colorDepth'])."', '"
	.addslashes($_POST['screen_height'])."', '".addslashes($_POST['screen_width'])."','$now');";
	if(mysqli_query($con, $sql))
		$_SESSION['PROPS_RECORDED']=true;
	else
		$_SESSION['PROPS_RECORDED']=false;
}

mysqli_close($con);
?>
