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

	// Begin email address test
	var email_regex = new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i);

	if (!(email_regex.test($('#email').attr("value"))) && $('#email').attr("value") != '') {
		alert("Invalid email supplied.  Please enter an email in the form abcd@efgh.ijk or leave the field blank.");
		return;
	}
	// End email address test

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

	var readwriteOption = 0;
    var rwoptions = ',';
    
	$('input[name="readwriteOpt"]:checked').each(function() {
		readwriteOption++;
		rwoptions = rwoptions + this.value+','  ; 
	});

	rwoptions = rwoptions.slice(1,-1);
	
	if(readwriteOption < 1){
		alert("Select at least one read or write options");
		return;
	}

	
	var data_string = 'id=<?php echo $user_id; ?>&un='+username+'&p='+pwd+'&fn='+fullname+'&em='+email+'&ph='+phone+'&lev='+level+'&lang='+lang_id+"&showpname="+showpname+"&opt="+rwoptions;
	//alert(data_string);
	//return;
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

function add_read_mode(){
	//alert(test);
	var usermode = $('select[name="level"]').val();
	if(usermode == 16){
		$("#readOrWrite").empty();
		$("#readOrWrite").append("Read Options");

		$("#readWrite_options").empty();
		$("#readWrite_options").append("<input type='checkbox' name='readwriteOpt' id='readwriteOpt51' value='51'>Select Test - option<br><input type='checkbox' id='readwriteOpt52' name='readwriteOpt' value='52'>Generate Bill - option");
		checkAllReadWriteOptions();
	} else {
		$("#readOrWrite").empty();
		$("#readOrWrite").append("Writeable Options");

		$("#readWrite_options").empty();
		$("#readWrite_options").append("<input type='checkbox' name='readwriteOpt' id='readwriteOpt2' value='2'>Patient Registration<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt3' value='3'>Test Results<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt4' value='4'>Search<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt6' value='6'>Inventory<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt7' value='7'>Backup Data <br>");
		checkAllReadWriteOptions();
	}
	if(usermode==17){
		$("#patient-entry").hide();
		$("#patient-entry_check").hide();
}
else
{
	$("#patient-entry").show();
	$("#patient-entry_check").show();
}
}

function checkAllReadWriteOptions(){
	checkboxes = document.getElementsByName('readwriteOpt');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
	    checkboxes[i].checked = true;
	  }
}

$(document).ready(function(){
	$('#lang_id').attr("value", "<?php echo $user->langId; ?>");

	$('#phone').keypress(function(event) {
    var code = (event.keyCode ? event.keyCode : event.which);
    if (!(
            (code >= 48 && code <= 57) // "[0-9]"
            || (code == 46) // "."
			|| (code == 45) // "-"
			|| (code == 40) // ")"
			|| (code == 41) // "("
			|| (code == 32) // " "
        ))
        event.preventDefault();
	});
	var usermode = $('select[name="level"]').val();
	if(usermode==17){
		$("#patient-entry").hide();
		$("#patient-entry_check").hide();
}
else
{
	$("#patient-entry").show();
	$("#patient-entry_check").show();
}
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
			<select name='level' id='level' class='uniform_width' onchange="javascript:add_read_mode();">
			<?php
			$page_elems->getLabUserTypeOptions($user->level);
			?>
			</select>
			</td>
		</tr>
		<tr>
			<?php 
			$page_elems->getLabUserReadWriteOption($user->level, $user->rwoptions);
			?>
			
			
		</tr>
		<tr valign='top'>
		
			<td><div id="patient-entry"><?php echo LangUtil::$pageTerms['USE_PNAME_RESULTS']; ?>?</div></td>
			<td>
				<div id="patient-entry_check"><input type="checkbox" name="showpname" id="showpname" <?php
				if($user->level == $LIS_TECH_SHOWPNAME)
					echo "checked ";
				?>/><?php echo LangUtil::$generalTerms['YES']; ?>
			</div></td>
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