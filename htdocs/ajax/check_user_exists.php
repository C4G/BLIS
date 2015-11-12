<?php
#
# Adds a new lab user account to DB
# Called via Ajax from lab_user_new.php
#

include("../includes/db_lib.php");

$saved_session = SessionUtil::save();

$user_list=$_REQUEST['userlist'];
$user_list_arr = explode( ',', $user_list );
$error_flag = 0;
$msg = "";
for ($i = 0; $i <= count($user_list_arr); $i++) {
    if (check_user_exists($user_list_arr[$i])){
    	$error_flag = 1;
    	$msg .= $user_list_arr[$i].",";
    }
}
if ($error_flag == 1){
	$msg = rtrim($msg, ',');
	$msg = "The following username(s) are already taken. Please try a different value - ".$msg;
}
else{
	$msg = "success";
}
echo $msg;

SessionUtil::restore($saved_session); ?>