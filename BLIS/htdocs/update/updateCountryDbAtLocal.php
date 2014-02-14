<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# File for updating the database. All db queries to update the database should be placed here
# Called after htdocs update succeeds
#
include("redirect.php");
include("../includes/db_lib.php");
include("../includes/user_lib.php");

global $DB_HOST, $DB_USER, $DB_PASS;

$user = get_user_by_id($_SESSION['user_id']);
$country = strtolower($user->country);

$currentDir = getcwd();
$mainBlisDir = substr($currentDir,$length,strpos($currentDir,"htdocs"));
$blisCountryDbFilePath = "\"".$mainBlisDir."\blis_".$country."_backup.sql\"";
$mysqlExePath = "\"".$mainBlisDir."server\mysql\bin\mysql.exe\"";
$dbName = "blis_".$country;
$command = $mysqlExePath." -h $DB_HOST -P 7188 -u $DB_USER -p$DB_PASS $dbname < $blisCountryDbFilePath";
$command = "C: &".$command; //the C: is a useless command to prevent the original command from failing because of having more than 2 double quotes
system($command, $return_var);
if( $return_var == 0 )
	echo "true";
else
	echo "false";
?>