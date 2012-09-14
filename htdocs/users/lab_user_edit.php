<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for editting lad admin account
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) 
     && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	 && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) )
		header( 'Location: home.php' );
	
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("lab_config_home");

$saved_session = SessionUtil::save();

$user_id = $_REQUEST['id'];
$user = get_user_by_id($user_id);

$tips_string = LangUtil::$pageTerms['TIPS_USERACC'];
$page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
?>
<script type='text/javascript'>
function toggle_and_clear(div_id)
{
	$('#password_row').toggle();
	$('#pwd').attr("value", "");
}

function goback()
{
	window.location="<?php echo $_REQUEST['backurl']; ?>&show_u=1";
}

function update_lab_user()
{
	var username = $('#username').attr('value');
	var pwd = $('#pwd').attr('value');
	var email = $('#email').attr('value');
	var phone = $('#phone').attr('value');
	var fullname = $('#fullname').attr('value');
	var level = $('#level').attr('value');
	var lang_id = $('#lang_id').attr('value');
	var url_string = 'ajax/lab_user_update.php';
	var showpname = 0;
	if($('#showpname').is(":checked"))
	{
		showpname = 1;
	}
	var data_string = 'id=<?php echo $user_id; ?>&un='+username+'&p='+pwd+'&fn='+fullname+'&em='+email+'&ph='+phone+'&lev='+level+'&lang='+lang_id+"&showpname="+showpname;
	$('#edit_user_progress').show();
	$.ajax({
		type: "POST",
		url: url_string,
		data: data_string,
		success: function(msg) {
			$('#edit_user_progress').hide();
			window.location = "<?php echo $_REQUEST['backurl']; ?>&show_u=1&aupdate=<?php echo $user->username; ?>";
		}
	});
}

$(document).ready(function(){
	$('#lang_id').attr("value", "<?php echo $user->langId; ?>");
});
</script>
<br>
<a href='javascript:goback();'><?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a> |<b><?php echo LangUtil::$pageTerms['EDIT_LAB_USER']; ?></b>
 
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
<form name='user_ops' action='ajax/lab_user_update.php' method='post'>
	<table id='form_table'>
		<tr>
			<td><?php echo LangUtil::$generalTerms['USERNAME']; ?></td>
			<td>
				<?php echo $user->username; ?>
				<input type='hidden' name='username' id='username' value="<?php echo $user->username; ?>" class='uniform_width'></input>
			</td>
		</tr>
		
		<tr>
			<td><?php echo LangUtil::$generalTerms['NAME'] ?></td>
			<td><input type="text" name="fullname" id="fullname" value="<?php echo $user->actualName; ?>" class='uniform_width' /><br></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['EMAIL'] ?></td>
			<td><input type="text" name="email" id="email" value="<?php echo $user->email; ?>" class='uniform_width' /><br></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['PHONE'] ?>&nbsp;&nbsp;&nbsp;</td>
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
			<td><?php echo LangUtil::$generalTerms['TYPE'] ?></td>
			<td>
			<select name='level' id='level' class='uniform_width'>
			<?php
			$page_elems->getLabUserTypeOptions($user->level);
			?>
			</select>
			</td>
		</tr>
		<tr valign='top'>
			<td><?php echo LangUtil::$pageTerms['USE_PNAME_RESULTS']; ?>?</td>
			<td>
				<input type="checkbox" name="showpname" id="showpname" <?php
				if($user->level == $LIS_TECH_SHOWPNAME)
					echo "checked ";
				?>/><?php echo LangUtil::$generalTerms['YES']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<a href="javascript:toggle_and_clear();"><?php echo LangUtil::$generalTerms['PWD_RESET']; ?></a>
				<?php $page_elems->getSmallArrow(); ?>
				&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			<td><span id='password_row' style='display:none'><input name='pwd' id='pwd' type='text' class='uniform_width' /><span></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<br>
				<input value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT'] ?>' type='button' onclick="javascript:update_lab_user();" />
				&nbsp;&nbsp;&nbsp;
				<input value='<?php echo LangUtil::$generalTerms['CMD_CANCEL'] ?>' type='button' onclick="javascript:goback();" />
				&nbsp;&nbsp;&nbsp;
				<span id='edit_user_progress' style='display:none'>
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