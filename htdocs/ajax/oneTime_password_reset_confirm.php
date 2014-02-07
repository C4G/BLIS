<?php
# Resets user password
# Generates a random string as new password and emails it.
include("../includes/db_lib.php");
include("../includes/user_lib.php");

# Helper function to check email address validity
function check_valid_email($email)
{
	# TODO:
	# The following works for only >= PHP 5.2.0, hence not working on arc server.
	//return filter_var($email, FILTER_VALIDATE_EMAIL);
	return true;
}

$username = $_REQUEST['username'];
$new_password = $_REQUEST['password'];
$user_exists = check_user_exists($username);
if($user_exists == false) 
{
	$msg = "User <b>$username</b> not found. Please check the username entered.";
}
else
{
	$user_profile = get_user_by_name($username);
	if(is_admin($user_profile))
	{
		$password_changed = change_user_password_oneTime($username, $new_password);
		if($password_changed === false)
		{
			$msg = "Error while resetting password. Please try again.";
		}
		else
		{	
				$msg = "Password reset complete </u>";
		}
	}
	
	else {
		$msg = "You don't have enough previleges to reset your password. Contact your administrator </u>";
	}
}
echo $msg;
db_close($con);
?>