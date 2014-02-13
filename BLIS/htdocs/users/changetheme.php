<?php

$theme = $_REQUEST['theme'];
if ( $theme == "Blue" )
	$_SESSION['theme'] = "Blue";
else
	$_SESSION['theme'] = "Grey";
	
echo $_SESSION['theme'];
?>