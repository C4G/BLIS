<?php
#
# Toggles between English and French mode
#

if(session_id() == "")
	session_start();

$target_lang = $_REQUEST['to'];
$_SESSION['locale'] = $target_lang;
header("Location: ".$_SERVER['HTTP_REFERER']);
?>
	