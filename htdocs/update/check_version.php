<?php

include_once("redirect.php");
include_once("../includes/db_lib.php");
include_once("../includes/user_lib.php");
include_once("../lang/lang_util.php");

LangUtil::setPageId("update");
global $VERSION;
$vers = $VERSION;
$check = checkVersionDataEntryExists($vers);
echo $check;
?>
