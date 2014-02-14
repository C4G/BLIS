<?php
#
# Adds a new lab configuration to DB
#
include("redirect.php");
include("includes/user_lib.php");
include("includes/db_lib.php");
include("includes/random.php");
include("lang/lang_xml2php.php");

$saved_session = SessionUtil::save();

$lab_config = new LabConfig();
$lab_config->name = $_REQUEST['name'];
$lab_config->location = $_REQUEST['location'];
$lab_config->country = $_REQUEST['country'];
$lab_admin = $_REQUEST['lab_admin'];
$country = $_REQUEST['country'];
$blocation = $_REQUEST['blocation'];


echo "<pre>";
print_r($_POST);
echo "</pre>";

if($blocation > 0)
    //setBaseConfig($blocation, 10);
?>