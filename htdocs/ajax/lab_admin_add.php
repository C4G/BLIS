<?php
#
# Adds a new lab admin account to DB
# Called via Ajax from lab_admin_new.php
#
include("../includes/SessionCheck.php");
include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
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
$lab_id = $_REQUEST['lab'];//AS 09/04/2018 Added lab ID

$user = new User();
$user->username = $username;
$user->password = $password;
$user->level = $LIS_ADMIN;
$user->actualName = $fullname;
$user->labConfigId = $lab_id;//AS 09/04/2018 Lab ID
$user->email = $email;
$user->phone = $phone;
$user->createdBy = $_SESSION['user_id'];
$user->langId = $lang_id;
$user_exists = check_user_exists($username);
if($user_exists == false) 
{
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
<?php }
else
{
	echo "This user already exists. Please edit or create a different user";
}

?>

<?php SessionUtil::restore($saved_session); ?>