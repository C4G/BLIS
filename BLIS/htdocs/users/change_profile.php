<?php
#
# Changes user profile information
# Called from edit_profile.php
#
include("redirect.php");
session_start(); 
include("includes/db_lib.php");
$updated_entry = new User();
$updated_entry->userId = $_REQUEST['user_id'];
$updated_entry->actualName = $_REQUEST['fullname'];
$updated_entry->phone = $_REQUEST['phone'];
$updated_entry->email = $_REQUEST['email'];
$updated_entry->langId = $_REQUEST['lang_id'];
# Update changes in DB
update_user_profile($updated_entry);
$err_message = "Profile updated";
db_close();
$_SESSION['locale'] = $_REQUEST['lang_id'];
header("location:edit_profile.php?upd");
?>