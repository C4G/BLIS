<?php
#
# Main page for editting user profile
#

include("redirect.php");
include("includes/header.php"); 
LangUtil::setPageId("edit_profile");

$pwd_tip = LangUtil::getPageTerm("TIPS_CASEPWD");
$page_elems = new PageElems();
$page_elems->getSideTip(LangUtil::$generalTerms["TIPS"], $pwd_tip);

$user_profile = get_user_by_id($_SESSION['user_id']);
?>
<script type='text/javascript'>
$(document).ready(function(){
	$('#curr_pwd_error').hide();
	$('#new_pwd1_error').hide();
	$('#new_pwd2_error').hide();
	$('#pwd_match_error').hide();
	$('#pwd_len_error').hide();
	$('#lang_id').attr("value", "<?php echo $user_profile->langId; ?>");
});

function right_load1()
{
	$('#change_pwd_div').hide();
	$('#edit_profile_div').show();
	$('#err_msg').hide();
	$('.menu_option').removeClass('current_menu_option');
	$('#option_1').addClass('current_menu_option');
}

function right_load2()
{
	$('#err_msg').hide();
	$('#edit_profile_div').hide();
	$('#change_pwd_div').show();
	$('.menu_option').removeClass('current_menu_option');
	$('#option_2').addClass('current_menu_option');
}

function check_entry_profile()
{
	var fullname = $('#fullname').attr("value");
	var email = $('#email').attr("value");
	var phone = $('#phone').attr("value");
	if(email == "" && phone == "" && fullname == "")
	{
		error_message = "<?php echo LangUtil::$pageTerms["MSG_NOFIELDUPDATE"]; ?>";
		document.getElementById("err_message_profile").innerHTML = "<font color=\"red\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+error_message+"</font>";
	}
	else
	{
		$("#change_profile_form").submit();
	}
}

function check_entry_pwd()
{
	$('#curr_pwd_error').hide();
	$('#new_pwd1_error').hide();
	$('#new_pwd2_error').hide();
	$('#pwd_match_error').hide();
	$('#pwd_len_error').hide();
	var old_pwd = $("#old_password").attr("value");
	var pwd = $("#new_password").attr("value");
	var pwd2= $("#new_password2").attr("value");
	var pwd_len = pwd.length;
	var pwd2_len = pwd2.length;
	var error_flag = false;
	if(old_pwd == "")
	{
		$('#curr_pwd_error').show();
		error_flag = true;
	}
	else
	{
		$('#curr_pwd_error').hide();
	}
	if(pwd_len == 0)
	{
		$('#new_pwd1_error').show();
		error_flag = true;
	}
	else
	{
		$('#new_pwd1_error').hide();
	}
	if(pwd2_len == 0)
	{
		$('#new_pwd2_error').show();
		error_flag = true;
	}
	else
	{
		$('#new_pwd2_error').hide();
	}
	if(!error_flag)
	{
		if(pwd_len != pwd2_len || pwd != pwd2)
		{
			$('#pwd_match_error').show();
			error_flag = true;
		}
		else
		{
			$('#pwd_match_error').hide();
		}
	}
	if(!error_flag)
	{
		if((pwd_len != 0 && pwd2_len != 0) && pwd_len < 3)
		{
			$('#pwd_len_error').show();
			error_flag = true;
		}
		else
		{
			$('#pwd_len_error').hide();
		}
	}
	if(!error_flag)
	{
		$("#change_pwd_form").submit();
	}
}
</script>
<br>
<table>
<tr valign='top'>
<td class='left_menu' id='left_pane' width='150px'>
<a href="javascript:right_load1();" id='option_1' class='menu_option'><?php echo $LANG_ARRAY["header"]["EDITPROFILE"]; ?></a>
<br><br>
<a href="javascript:right_load2();" id='option_2' class='menu_option'><?php echo LangUtil::getPageTerm("LINK_CHANGEPWD"); ?></a>
<br><br>
</td>
<td><br><br><br><br><br></td><td></td><td></td><td></td><td></td>
<td>
<div id='err_msg'>
<?php
if(isset($_REQUEST['upd']))
{
	?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$pageTerms["MSG_PROFILEUPDATED"]; ?>
	</div>
	<?php
}
else if(isset($_REQUEST['pupdate']))
{
	?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$pageTerms["MSG_PWDUPDATED"]; ?>
	</div>
	<?php
}
else if(isset($_REQUEST['pmatcherr']))
{
	?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$pageTerms["MSG_PWDMATCHERROR"]; ?>
	</div>
	<?php
}
else if(isset($_REQUEST['pupdateerr']))
{
	?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$pageTerms["MSG_PWDUPDATEERROR"]; ?>
	</div>
	<?php
}
?>
</div>
<div id='edit_profile_div'  style='display:none;'>
<b><?php echo $LANG_ARRAY["header"]["EDITPROFILE"] ?></b>
<br><br>
<div id="err_message_profile"></div>
<form name="input" id="change_profile_form" action="change_profile.php" method="post">
<input type='hidden' name='user_id' value='<?php echo $_SESSION['user_id']; ?>'></input>

<table cellpadding="2">
<tr>
<td><?php echo LangUtil::$generalTerms['USERNAME']; ?></td>
<td><?php echo $_SESSION['username'];?></td>
</tr>

<tr>
<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
<td><input type="text" name="fullname" id="fullname" value="<?php echo $user_profile->actualName; ?>"  class='uniform_width' /></td>
</tr>

<tr>
<td><?php echo LangUtil::$generalTerms['EMAIL']; ?></td>
<td><input type="text" name="email" id="email" value="<?php echo $user_profile->email; ?>"  class='uniform_width' /></td>
</tr>

<tr>
<td><?php echo LangUtil::$generalTerms['PHONE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" name="phone" id="phone" value="<?php echo $user_profile->phone; ?>"  class='uniform_width' /></td>
</tr>

<tr>
<td><?php echo LangUtil::$generalTerms['LANGUAGE']; ?></td>
<td>
	<select name='lang_id' id='lang_id' class='uniform_width'>
		<?php $page_elems->getLangSelect(); ?>
	</select>
</td>
</tr>

<tr>
<td><br></td>
<td>
<input type="button" value="<?php echo LangUtil::$generalTerms["CMD_UPDATE"]; ?>" onclick="javascript:check_entry_profile();"/>&nbsp;&nbsp;
</td>
</tr>
</table>
</form>
</div>
<div id='change_pwd_div' style='display:none;'>
<b><?php echo LangUtil::getPageTerm("LINK_CHANGEPWD"); ?></b>
<br><br>
<div id="err_message_pwd"></div>
<form name='change_pwd_form' id='change_pwd_form' action='change_pwd.php' method='post'>
<table>
<tr>
<td><?php echo LangUtil::$generalTerms['USERNAME']; ?></td>
<td><?php echo $_SESSION['username'];?></td>
</tr>

<tr>
<td><?php echo LangUtil::$pageTerms['CURRPWD']; ?></td>
<td><input type="password" name="old_password" id="old_password" value="" size="20"  class='uniform_width' /></td>
<td><span id='curr_pwd_error' class='error_string'><?php echo LangUtil::$generalTerms['MSG_REQDFIELD']; ?></span></td>
</tr>

<tr>
<td><?php echo LangUtil::$pageTerms['NEWPWD']; ?></td>
<td><input type="password" name="new_password" id="new_password" value="" size="20"  class='uniform_width' /></td>
<td><span id='new_pwd1_error' class='error_string'><?php echo LangUtil::$generalTerms['MSG_REQDFIELD']; ?></span></td>
</tr>

<tr>
<td><?php echo LangUtil::$pageTerms['REENTERPWD']; ?> </td>
<td><input type="password" name="new_password2" id="new_password2" value="" size="20"  class='uniform_width' /></td>
<td>
<span id='new_pwd2_error' class='error_string'><?php echo LangUtil::$generalTerms['MSG_REQDFIELD']; ?></span>
<span id='pwd_match_error' class='error_string'><?php echo LangUtil::$pageTerms['MSG_PWDNOMATCH']; ?></span>
<span id='pwd_len_error' class='error_string'><?php echo LangUtil::$pageTerms['MSG_PWDMINLENGTH']; ?></span>
</td>
</tr>

<tr>
<td><br></td>
<td><input type="button" value="<?php echo LangUtil::$generalTerms["CMD_UPDATE"]; ?>" onclick="javascript:check_entry_pwd();"/>&nbsp;&nbsp;</td>
</tr>

</table>
</form>
</div>
</td>
<tr>
</table>
<?php include("includes/footer.php"); ?>