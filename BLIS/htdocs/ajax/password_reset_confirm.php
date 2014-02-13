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
$user_exists = check_user_exists($username);
if($user_exists == false)
{
	$msg = "User <b>$username</b> not found. Please check the username entered.";
}
else
{
	$user_profile = get_user_by_name($username);
	$email = $user_profile->email;
	# Remove the following line once get_user_profile works
	if(trim($email) == "")
	{
		$msg = "Email address not present for <b>$username</b>. Please contact sysadmin to reset your password.";
	}
	else if(check_valid_email($email) === false)
	{
		$msg = "Email address <b>$email</b> not valid. Please contact sysadmin to reset your password.";
	}
	else
	{
		$new_password= get_random_password();
		$password_changed = change_user_password($username, $new_password);
		if($password_changed === false)
		{
			$msg = "Error while resetting password. Please try again.";
		}
		else
		{
			$subject = "[BLIS] New password for ".$username;
			$to_addr = $email;
			$body = 
				"Your password has been reset.\nPlease note that passwords are case-sensitive.\n\n".
				"Username: ".$username."\n".
				"New Password: ".$new_password."\n\n".
				"Please login to update your password.\n".
				"http://lis.cc.gatech.edu";
			if(mail($email, $subject, $body))
			{	
				$msg = "New password emailed to <u>".$email."</u>";
			}
			else
			{
				$msg = "Error sending email to <u>".$email."</u>. Please contact sysadmin to reset your password.";
			}
		}
	}
}
echo $msg;
db_close($con);
?>