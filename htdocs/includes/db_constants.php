<?php
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Contains DB connection parameters
# Include in db_mysql_lib.php
#

require_once(__DIR__."/platform_lib.php");

if(session_id() == "")
	session_start();
	
# Flag for toggling between local machine, portable version and arc server
$ON_DEV = 1;
$ON_ARC = 2;
$ON_PORTABLE = 3;

$SERVER = $ON_PORTABLE;

$LOCAL_PATH = "../../local/";
if($SERVER == $ON_ARC)
{
	$LOCAL_PATH = "../local/";
}

$DB_HOST = getenv("DB_HOST");
if (!$DB_HOST) {
	$DB_HOST = "127.0.0.1";
}

// If not running on Windows,
// - try to use the port from the envionment, or,
// - use the MySQL default port.
$DB_PORT = getenv("DB_PORT");
if (!$DB_PORT) {
	if (PlatformLib::runningOnWindows()) {
		// If running on Windows, assume we're running the traditional version of BLIS.
		// The default port for the Server2Go MySQL server is 7188.
		$DB_PORT = 7188;
	} else {
		$DB_PORT = 3306;
	}
}

$DB_USER = getenv("DB_USER");
if (!$DB_USER) {
	$DB_USER = "root";
}
// $d = dirname(__FILE__);
// $name= strrpos($d,"htdocs");
// //if($name === false)
// // echo "Not found";
// $new_name=substr($d,0,$name)."dbdir";
// //echo $new_name;
// $dir1 = opendir($new_name); #open directory

// $count=0;
// while (($file = readdir($dir1)) !== false) {
	// if($count==3)
// {
// $GLOBAL_DB = $file;

// }	
	// $count++;	
// }
// closedir($dir1);

$GLOBAL_DB_NAME="blis_revamp";

$DB_NAME = $GLOBAL_DB_NAME;	
$DB_PASS = "";

if(getenv("DB_PASS")) 
{
	$DB_PASS = getenv("DB_PASS");
}
else if($SERVER == $ON_DEV)
{
	$DB_PASS = "monu123";
}
else if($SERVER == $ON_ARC)
{
	$DB_PASS = "";
}
else if($SERVER == $ON_PORTABLE)
{
	$DB_PASS = "blis123";
}

if(isset($_SESSION['username']))
{
	# User has logged in
	if($_SESSION['db_name'] == "")
		# Admin level user - keep global DB instance
		$DB_NAME = $GLOBAL_DB_NAME;
	else
		# Technician user - Narrow down to local instance
		$DB_NAME = $_SESSION['db_name'];
}
?>
