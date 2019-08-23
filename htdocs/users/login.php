<?php

include("redirect.php");
include("includes/stats_lib.php");
include("includes/password_reset_need.php");


$file = "../../BlisSetup.html";
$content =<<<content
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="Refresh"
CONTENT="1; URL=http://{$_SERVER['SERVER_ADDR']}:4001/login.php">
</head>
</html>
content;
file_put_contents($file, $content);

session_start();
# If already logged in, redirect to home page
if(isset($_SESSION['user_id']))
{
	header("Location: home.php");
}
include("includes/header.php");
LangUtil::setPageId("login");

$page_elems = new PageElems();
//$login_tip = LangUtil::getPageTerm("TIPS_NEWPWD");
$login_tip="If you have forgotten your password then please contact your BLIS administrator.";
$page_elems->getSideTip(LangUtil::getGeneralTerm("TIPS"), $login_tip);
?>
<style type="text/css"> 
	.btn {
		color:white; 
		background-color:#3B5998; 
		border-style:none; 
		font-weight:bold; 
		font-size:14px; 
		height:28px; 
		width:65px;
		cursor:pointer;
	}
</style> 

<script type='text/javascript'>
function load()
{	
	$('#username_error').hide();
	$('#password_error').hide();
}

function check_input_boxes()
{
	if($('#username').attr("value") == "")
	{
		$('#username_error').show();
		return;
	}
	else
	{
		$('#username_error').hide();
	}
	if($('#password').attr("value") == "")
	{
		$('#password_error').show();
		return;
	}
	else
	{
		$('#password_error').hide();
	}
	$('#form_login').submit();

}

function unload()
{
	document.getElementById("username_error").value == "";
	document.getElementById("password_error").value == "";
}

$(document).ready(function(){
	load();
	//alert( "You are running jQuery version: " + $.fn.jquery );
	/* var passwordNeed = false;
	$.ajax({
		url : "ajax/password_rest_need.php",
		success: function(data) {
			if(data == 'need') passwordNeed = true;
		},
		dataType: "String"
	}); */
	$('#username').focus();
});

function capLock(e)
{
	kc = e.keyCode?e.keyCode:e.which;
	if(kc == 8)
	{
		//delete key pressed, maintain same state
		return;
	}		
	sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
	if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk))
		$('#caps_lock_msg_div').show();
	else
		$('#caps_lock_msg_div').hide();
}
</script>

<table>
	<tr valign='top'>
		<td>
			<div id="login_area">
				<form name="form_login" id='form_login' action="validate.php" method="post">
				<table cellpadding="6px" cellspacing='10px'>
				<?php
					
					if(isset($_REQUEST['to']))
					{
						# Previous session timed out
						echo "<tr valign='top'>";
						echo "<td></td>";
						echo "<td>";
						echo "<span id='server_msg' class='error_string'>";
						echo LangUtil::getPageTerm("MSG_TIMED_OUT");
						echo "</span><br>";
						echo "</td>";
						echo "</tr>";
					}
					else if(isset($_REQUEST['err']))
					{
						# Incorrect username/password
						echo "<tr valign='top'>";
						echo "<td></td>";
						echo "<td>";
						echo "<span id='server_msg' class='error_string'>";
						echo LangUtil::getPageTerm("MSG_ERR_PWD");
						echo "</span><br>";
						echo "</td>";
						echo "</tr>";
					}
					else if(isset($_REQUEST['errPR']))
					{
					# Incorrect username/password
						echo "<tr valign='top'>";
						echo "<td></td>";
						echo "<td>";
						echo "<span id='server_msg' class='error_string'>";
						echo LangUtil::getPageTerm("MSG_ERR_PWDRST");
											echo "</span><br>";
						echo "</td>";
						echo "</tr>";
					}
					else if(isset($_REQUEST['prompt']))
					{
						# User not logged in
						echo "<tr valign='top'>";
						echo "<td></td>";
						echo "<td>";
						//echo "<span id='server_msg' class='error_string'>";
						//echo LangUtil::getPageTerm("MSG_PLSLOGIN");
						//echo "</span><br>";
						echo "</td>";
						echo "</tr>";
					}
				?>
					<tr valign='top'>
						<td>
							<?php echo LangUtil::getGeneralTerm("USERNAME"); ?>
						</td>
						<td>
							<input type="text" name="username" id = "username" value="" size="20" class='uniform_width' />
							<label class="error" for="username" id="username_error"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label> 
						</td>
					</tr>
					<tr valign='top'>
						<td>
							<?php echo LangUtil::getGeneralTerm("PWD"); ?>
						</td>
						<td>
							<input type="password" name="password" id = "password" value="" size="20" class='uniform_width' onkeypress="javascript:capLock(event);" onkeydown="javascript:capLock(event);" />
							<label class="error" for="password" id="password_error"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
							<br>
							<div id="caps_lock_msg_div" style="display:none"><font color='red'><small><?php echo LangUtil::getPageTerm("MSG_CAPSLOCK"); ?></small></font></div>
						</td>
					</tr>					
					<tr>
						<td></td>
						<td>
							<input type="button" class="btn" id="login_button" value="<?php echo LangUtil::$generalTerms["CMD_LOGIN"]; ?>" onclick="check_input_boxes()"/>
						
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<!-- <a href='password_reset.php'>
								<small><?php echo LangUtil::getPageTerm("MSG_NEWPWD"); ?></small>
							</a> -->
						</td>
					</tr>
					<?php 
					$password_reset_needed = password_reset_required();
					if($password_reset_needed){
					?>
					<tr>
						<td>
						</td>
						<td>
							<a href='oneTime_password_reset.php'>
								<small>Reset the Password</small>
							</a>
						</td>
					</tr>
					<?php }?>
				</table>
				</form>
			</div>
		</td>
		<td>
		</td>
		<td>
		</td>
	</tr>
</table>

<?php $script_elems->bindEnterToClick("#password", "#login_button"); ?>
<?php
include("includes/footer.php");
?>