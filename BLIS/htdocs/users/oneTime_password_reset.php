<?php 
include("../includes/password_reset_need.php");
$password_reset_needed = password_reset_required();
if($password_reset_needed){
?>

<?php 
include("../includes/header.php");
// if($SERVER == $ON_PORTABLE)
// {
 ?>
<!-- <br> -->
<!-- <br><br> -->
<!-- Password reset via email is not available on Portable version. Please contact sysadmin. -->
<!-- <div id='confirm_msg'> -->
<!-- </div> -->
					
<script type='text/javascript'>
$(document).ready(function(){
	//alert("page loaded");
	$('#progress_spinner').hide();
});

function ajax_reset_password()
{
	//alert("test");
	
	var username = document.reset_pwd.username.value;
	var password = document.reset_pwd.password.value;
	var confirmPassword = document.reset_pwd.confirmPassword.value;
	
	if(password == '' || confirmPassword == '' || password != confirmPassword){
	 alert("Password is empty or doesn't match");
	} else {
		$('#progress_spinner').show();
		var url = "ajax/oneTime_password_reset_confirm.php?username="+username+"&password="+password;
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
		
	} // password == confirm password else ends here 
	

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
<tr>
<td><?php echo LangUtil::$generalTerms['PWD']; ?>&nbsp;&nbsp;&nbsp;</td>
<td><input type='password' name='password' id='password' value='' /></td>
</tr>
<tr>
<td><?php echo LangUtil::$generalTerms['CNFRMPWD']; ?>&nbsp;&nbsp;&nbsp;</td>
<td><input type='password' name='confirmPassword' id='confirmPassword' value='' /></td>
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
else {
#Redirect to login page
header("Location:login.php?errPR");
}
?>