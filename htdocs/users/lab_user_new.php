<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for adding new lab user account
# Called from lab_config_home.php
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) 
     && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	 && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) ) {
		header( 'Location: home.php' );
}

include("redirect.php");
include("includes/page_elems.php");
include("includes/script_elems.php");
LangUtil::setPageId("lab_config_home");

$script_elems = new ScriptElems();
$page_elems = new PageElems();
$reload_url = $_REQUEST['ru']."&show_u=1";
$lab_config_id = $_REQUEST['lid'];
?>
<script type="text/javascript">
function add_lab_user()
{
	var username = $('#lab_user').attr('value');
	var pwd = $('#pwd').attr('value');
	var email = $('#email').attr('value');
	var phone = $('#phone').attr('value');
	var fullname = $('#fullname').attr('value');
	var ut = $('#user_type').attr('value');
	var lang_id = $('#lang_id').attr("value");
	var showpname = 0;
	if($('#showpname').is(":checked"))
	{
		showpname = 1;
	}
	/*
	var fn_regn = 0;
	var fn_results = 0;
	var fn_reports = 0;
	if
	(
		$('#fn_regn').is(":checked") == false &&
		$('#fn_results').is(":checked") == false &&
		$('#fn_reports').is(":checked") == false
	)
	{
		$('#error_msg').html("<?php echo LangUtil::$generalTerms['ERROR'].": ".$generalTerms['USER_FUNCTIONS']; ?>");
		$('#error_msg').show();
	}
	if($('#fn_regn').is(":checked"))
	{
		fn_regn = 1;
	}
	if($('#fn_results').is(":checked"))
	{
		fn_results = 1;
	}
	if($('#fn_reports').is(":checked"))
	{
		fn_reports = 1;
	}
	*/
	if(username == "" || pwd == "")
	{
		document.getElementById('error_msg').innerHTML="<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>";
		$('#error_msg').show();
		return;
	}
	$('#error_msg').hide();
	var url_string = 'ajax/lab_user_add.php';
	//var data_string = 'u='+username+'&p='+pwd+'&fn='+fullname+'&em='+email+'&ph='+phone+'&ut='+ut+'&lid=<?php echo $lab_config_id; ?>&lang='+lang_id+"&fn_reports="+fn_reports+"&fn_results="+fn_results+"&fn_regn="+fn_regn;
	var data_string = 'u='+username+'&p='+pwd+'&fn='+fullname+'&em='+email+'&ph='+phone+'&ut='+ut+'&lid=<?php echo $lab_config_id; ?>&lang='+lang_id+"&showpname="+showpname;
	$('#add_user_progress').show();
	$.ajax({
		type: "POST",
		url: url_string,
		data: data_string,
		success: function(msg) {
			document.getElementById('server_msg').innerHTML="<small>"+msg+"</small>";
			$('#add_user_progress').hide();
			$('#form_table').hide();
			$('#server_msg').show();
			window.location="<?php echo $reload_url; ?>&aadd="+username;
		}
	});
}
</script>

<table cellspacing="20px">
<tr>
<td>

<b><?php echo LangUtil::$pageTerms['NEW_LAB_USER']; ?></b>
<br><br>
<?php $page_elems->getAsteriskMessage(); ?>
<form name='admin_ops' action='ajax/lab_user_add.php' method='post'>
	<table id='form_table'>
		<tr>
			<td><?php echo LangUtil::$generalTerms['USERNAME']; ?><?php $page_elems->getAsterisk(); ?></td>
			<td><input name='lab_user' id='lab_user' type='text' class='uniform_width' /></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['PWD_TEMP']; ?><?php $page_elems->getAsterisk(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td><input name='pwd' id='pwd' type='text' class='uniform_width' /></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$generalTerms['TYPE']; ?><?php $page_elems->getAsterisk(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
			<select name='user_type' id='user_type' class='uniform_width' >
			<?php
			$page_elems->getLabUserTypeOptions();
			?>
			</select>
			</td>
		</tr>
		<!--
		<tr valign='top'>
			<td><?php #echo LangUtil::$generalTerms['USER_FUNCTIONS']; ?><?php #$page_elems->getAsterisk(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
				<input type='checkbox' name='fn_regn' id='fn_regn' checked ><?php #echo LangUtil::getPageTitle("regn"); ?></input><br>
				<input type='checkbox' name='fn_results' id='fn_results' checked ><?php #echo LangUtil::getPageTitle("results_entry"); ?></input><br>
				<input type='checkbox' name='fn_reports' id='fn_reports' checked ><?php #echo LangUtil::getPageTitle("reports"); ?></input><br>
			</td>
		</tr>
		-->
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
		<tr valign='top'>
			<td><?php echo LangUtil::$pageTerms['USE_PNAME_RESULTS']; ?>?</td>
			<td>
				<input type="checkbox" name="showpname" id="showpname" /><?php echo LangUtil::$generalTerms['YES']; ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<br>
				<input value='<?php echo LangUtil::$generalTerms['CMD_ADD']; ?>' type='button' onclick="javascript:add_lab_user();" />
				&nbsp;&nbsp;&nbsp;
				<span id='add_user_progress' style='display:none'>
					<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
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
