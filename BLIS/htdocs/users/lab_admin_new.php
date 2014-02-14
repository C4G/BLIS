<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for adding new lab admin account
# Called from lab_admins.php
#

include("../users/accesslist.php");
if( !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	&& !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) )
	header( 'Location: home.php' );

include("redirect.php");
include("includes/page_elems.php");
include("includes/script_elems.php");
LangUtil::setPageId("lab_admins");

$script_elems = new ScriptElems();
$page_elems = new PageElems();
?>
<script type="text/javascript">
function add_lab_admin()
{
	var username = $('#admin_user').attr('value');
	var pwd = $('#admin_pwd').attr('value');
	var email = $('#email').attr('value');
	var phone = $('#phone').attr('value');
	var fullname = $('#fullname').attr('value');
	var lang_id = $('#lang_id').attr("value");
	if(username == "" || pwd == "")
	{
		document.getElementById('error_msg').innerHTML="<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>";
		$('#error_msg').show();
		return;
	}
	$('#error_msg').hide();
	var url_string = 'ajax/lab_admin_add.php';
	var data_string = 'u='+username+'&p='+pwd+'&fn='+fullname+'&em='+email+'&ph='+phone+'&lang='+lang_id;
	$('#add_admin_progress').show();
	$.ajax({
		type: "POST",
		url: url_string,
		data: data_string,
		success: function(msg) {
			document.getElementById('server_msg').innerHTML="<small>"+msg+"</small>";
			$('#add_admin_progress').hide();
			$('#form_table').hide();
			$('#server_msg').show();
			window.location = "lab_admins.php?added="+username;
		}
	});
}
</script>

<table cellspacing="20px">
<tr>
<td>

<b><?php echo LangUtil::$pageTerms['ADD_NEW_ADMIN']; ?></b>
<br><br>
<?php $page_elems->getAsteriskMessage(); ?>
<form name='admin_ops' action='ajax/lab_admin_add.php' method='post'>
	<table id='form_table'>
		<tr>
			<td><?php echo LangUtil::$generalTerms['USERNAME']; ?><?php $page_elems->getAsterisk(); ?></td>
			<td><input name='admin_user' id='admin_user' type='text' class='uniform_width' /></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['PWD_TEMP']; ?><?php $page_elems->getAsterisk(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td><input name='admin_pwd' id='admin_pwd' type='text' class='uniform_width' /></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
			<td><input type="text" name="fullname" id="fullname" value="" class='uniform_width' /><br></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['EMAIL']; ?></td>
			<td><input type="text" name="email" id="email" value="" class='uniform_width' /><br></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['PHONE']; ?>&nbsp;&nbsp;&nbsp;</td>
			<td><input type="text" name="phone" id="phone" value="" class='uniform_width' /><br></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['LANGUAGE'] ?>&nbsp;&nbsp;&nbsp;</td>
			<td>
				<select name='lang_id' id='lang_id' class='uniform_width'>
					<?php echo $page_elems->getLangSelect(); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<br>
				<input value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' type='button' onclick="javascript:add_lab_admin();" />
				&nbsp;&nbsp;&nbsp;
				<span id='add_admin_progress' style='display:none'>
				<?php
					$page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']);
				?>
				</span>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<span id='error_msg' class='error_string'>
				</span>
			</td>
		</tr>
	</table>
</form>
<span id='server_msg' style='display:none;'>
</span>
</td>
</tr>
</table>
