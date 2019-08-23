<?php
#
# Adds a new lab user account to DB
# Called via Ajax from lab_user_new.php
#
include("../includes/SessionCheck.php");
include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
$script_elems = new ScriptElems();
$page_elems = new PageElems();

$saved_session = SessionUtil::save();

$username=$_REQUEST['u'];
$password=$_REQUEST['p'];
$fullname = $_REQUEST['fn'];
$email = $_REQUEST['em'];
$phone = $_REQUEST['ph'];
$user_type = $_REQUEST['ut'];
$lab_config_id = $_REQUEST['lid'];
$lang_id = $_REQUEST['lang'];

$user_rwoption = $_REQUEST['opt'];
# Fetch selected user functions
# And, generate level number based on chosen functions
# Disabled for now
/*
$fn_regn = false;
$fn_results = false;
$fn_reports = false;
$level_num = 5;
if($_REQUEST['fn_regn'] == 1)
{
	$fn_regn = true;
	$level_num += 4;
}
if($_REQUEST['fn_results'] == 1)
{
	$fn_results = true;
	$level_num += 2;
}
if($_REQUEST['fn_reports'] == 1)
{
	$fn_reports = true;
	$level_num += 1;
}
*/

# Set whether technician can view patient name at results entry
if($user_type != $LIS_CLERK)
{
	//if($user_type != $LIS_ADMIN){
		if($_REQUEST['showpname'] == 1)
		{
			$user_type = $LIS_TECH_SHOWPNAME;
		}
	//}
}
$user = new User();
$user->username = $username;
$user->password = $password;
$user->level = $user_type;
$user->actualName = $fullname;
$user->labConfigId = $lab_config_id;
$user->email = $email;
$user->phone = $phone;
$user->createdBy = $_SESSION['user_id'];
$user->langId = $lang_id;
$user->rwoptions = $user_rwoption;
$success_var = add_user($user);
if ($success_var){

?>
<table cellspacing="20px">
	<tr>
		<td>
			<?php
				echo LangUtil::$generalTerms['MSG_ACC_ADDED']."<br>";
				echo LangUtil::$generalTerms['USERNAME'].": ".$user->username;
				echo "<br>";
				echo LangUtil::$generalTerms['PWD_TEMP'].": ".$user->password;
			?>
		</td>
	</tr>
</table>
<?php 
}
else
	echo "User already exists";

SessionUtil::restore($saved_session); ?>