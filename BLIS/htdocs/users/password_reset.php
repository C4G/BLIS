<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include("../includes/header.php");
if($SERVER == $ON_PORTABLE)
{
?>
<br>
<b><?php echo LangUtil::$generalTerms['PWD_RESET']; ?></b>
 | <a href='javascript:history.go(-1);'> &laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
<br><br>
Password reset via email is not available on Portable version. Please contact sysadmin.
<div id='confirm_msg'>
</div>
<?php include("includes/footer.php"); ?>
<?php
}
else
{
# Online version. Show form for resetting password.
?>
<script type='text/javascript'>
$(document).ready(function(){
	$('#progress_spinner').hide();
});

function ajax_reset_password()
{
	$('#progress_spinner').show();
	var username = document.reset_pwd.username.value;
	var url = "ajax/password_reset_confirm.php?username="+username;
	var xmlHttp;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	xmlHttp.onreadystatechange=function()
    {
		if(xmlHttp.readyState==4)
		{
			var message = xmlHttp.responseText;
			$('#confirm_msg').html(message);
			//$('#submit_row').hide();
			$('#progress_spinner').hide();
			$('#confirm_msg').show();
		}
	}
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);
}
</script>
<?php $script_elems->bindEnterToClick("#username", "#submit_button"); ?>
<br>
<b><?php echo LangUtil::$generalTerms['PWD_RESET']; ?></b>
 | <a href='login.php'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
<br><br>
<form name='reset_pwd'>
<table cellspacing='20px'>
<tr>
<td><?php echo LangUtil::$generalTerms['USERNAME']; ?>&nbsp;&nbsp;&nbsp;</td>
<td><input type='text' name='username' id='username' value='' /></td>
</tr>
<tr id='submit_row'>
<td></td>
<td>
<input type='button' id='submit_button' value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" onclick='javascript:ajax_reset_password();'/>
&nbsp;&nbsp;
<span id='progress_spinner'>
<?php 
$page_elems->getProgressSpinner("Resetting password");
?>
</span>
</td>
</tr>
</table>
</form>
<div id='confirm_msg'>
</div>
<?php include("includes/footer.php");
}
?>