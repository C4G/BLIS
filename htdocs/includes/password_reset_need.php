<?php
include("../includes/db_lib.php");
include("../includes/user_lib.php");

function password_reset_required(){
	$password_reset_need = password_reset_need_confirm();
	return $password_reset_need;
}

?>