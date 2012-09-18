<?php

include("redirect.php");
include("../includes/db_lib.php");
include("../includes/user_lib.php");

LangUtil::setPageId("update");
global $VERSION;
$vers = $VERSION;
$check = checkVersionDataEntry($vers);
echo $check;
?>
