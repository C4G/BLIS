<?php
# Sends user comments to BLIS developers by email
# A copy is also retained in the DB
# Called via Ajax from comments.php
include("../includes/db_lib.php");

# Construct email parameters
$comment = $_REQUEST['comment'];
$username = $_REQUEST['user'];
$page = $_REQUEST['page'];
$subject = "[BLIS] New comment posted";
$email = "vempala@cc.gatech.edu; rubanm@gatech.edu;";
$body = "Username: ".$_REQUEST['user']."\n\n";
$body .= "Page: ".$_REQUEST['page']."\n\n";
$body .= "Comments: ".$_REQUEST['comment']."\n";

# Add commments to DB
add_new_comment($username, $page, $comment);

# Send comment as email
if(mail($email, $subject, $body))
{
	echo "Your comments have been posted. Thank you.";
}
else
{
	echo "Error posting comments. Please try again or email your comments to vempala@cc.gatech.edu.";
}
db_close();
?>