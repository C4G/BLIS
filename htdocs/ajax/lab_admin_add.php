<?php
#
# Adds a new lab admin account to DB
# Called via Ajax from lab_admin_new.php
#

include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
include("../includes/user_lib.php");
LangUtil::setPageId("lab_admins");

$script_elems = new ScriptElems();
$page_elems = new PageElems();

$saved_session = SessionUtil::save();

$username=$_REQUEST['u'];
$password=$_REQUEST['p'];
$fullname = $_REQUEST['fn'];
$email = $_REQUEST['em'];
$phone = $_REQUEST['ph'];
$lang_id = $_REQUEST['lang'];

$user = new User();
$user->username = $username;
$user->password = $password;
$user->level = $LIS_ADMIN;
$user->actualName = $fullname;
$user->labConfigId = 0;
$user->email = $email;
$user->phone = $phone;
$user->createdBy = $_SESSION['user_id'];
$user->langId = $lang_id;
add_user($user);
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
<?php SessionUtil::restore($saved_session); ?>