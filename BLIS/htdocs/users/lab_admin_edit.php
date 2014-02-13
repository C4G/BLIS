<?php
#
# Main page for editting lad admin account
#
include("redirect.php");
include("includes/header.php"); 
LangUtil::setPageId("lab_admins");

$saved_session = SessionUtil::save();

$user_id = $_REQUEST['id'];
$user = get_user_by_id($user_id);
?>
<script type='text/javascript'>
function toggle_and_clear(div_id)
{
	$('#password_row').toggle();
	$('#admin_pwd').attr("value", "");
}

function update_lab_admin()
{
	var username = $('#username').attr('value');
	var pwd = $('#admin_pwd').attr('value');
	var email = $('#email').attr('value');
	var phone = $('#phone').attr('value');
	var fullname = $('#fullname').attr('value');
	var lang_id = $('#lang_id').attr('value');
	var url_string = 'ajax/lab_admin_update.php';
	var data_string = 'id=<?php echo $user_id; ?>&un='+username+'&p='+pwd+'&fn='+fullname+'&em='+email+'&ph='+phone+'&lang='+lang_id;
	$('#edit_admin_progress').show();
	$.ajax({
		type: "POST",
		url: url_string,
		data: data_string,
		success: function(msg) {
			$('#edit_admin_progress').hide();
			window.location = "lab_admins.php?upd="+username;
		}
	});
}

$(document).ready(function(){
	$('#lang_id').attr("value", "<?php echo $user->langId; ?>");
});
</script>
<br>
<b><?php echo LangUtil::$pageTerms['EDIT_ADMIN_ACC']; ?></b> |
 <a href='lab_admins.php'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<?php
if($user == null)
{
	?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>
	<?php
	include("includes/footer.php");
	return;
}
?>
<form name='admin_ops' action='ajax/lab_admin_update.php' method='post'>
	<table id='form_table'>
		<tr>
			<td><?php echo LangUtil::$generalTerms['USERNAME']; ?></td>
			<td>
				<?php echo $user->username; ?>
				<input type='hidden' name='username' id='username' value="<?php echo $user->username; ?>" class='uniform_width'></input>
			</td>
		</tr>
		
		<tr>
			<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
			<td><input type="text" name="fullname" id="fullname" value="<?php echo $user->actualName; ?>" class='uniform_width' /><br></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['EMAIL']; ?></td>
			<td><input type="text" name="email" id="email" value="<?php echo $user->email; ?>" class='uniform_width' /><br></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['PHONE']; ?>&nbsp;&nbsp;&nbsp;</td>
			<td><input type="text" name="phone" id="phone" value="<?php echo $user->phone; ?>" class='uniform_width' /><br></td>
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
			<td>
				<a href="javascript:toggle_and_clear();"><?php echo LangUtil::$generalTerms['PWD_RESET']; ?></a>
				<?php $page_elems->getSmallArrow(); ?>
				&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			<td><span id='password_row' style='display:none'><input name='admin_pwd' id='admin_pwd' type='text' class='uniform_width' /><span></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<br>
				<input value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' type='button' onclick="javascript:update_lab_admin();" />
				&nbsp;&nbsp;&nbsp;
				<small><a href='lab_admins.php'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
				&nbsp;&nbsp;&nbsp;
				<span id='edit_admin_progress' style='display:none'>
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
<?php 
SessionUtil::restore($saved_session);
include("includes/footer.php"); 
?>