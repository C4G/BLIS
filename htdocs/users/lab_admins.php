<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page that lists all lab admin accounts and related options
#

include("../users/accesslist.php");
if( !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	&& !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) )
	header( 'Location: home.php' );

include("redirect.php");
?>
<?php 
include("includes/header.php");
LangUtil::setPageId("lab_admins");

$script_elems->enableFacebox();
$script_elems->enableLatencyRecord();
?>
<script type='text/javascript'>
function delete_lab_admin(user_id, username, config_flag, link_div_id, progress_div_id)
{
	var url_string = "ajax/lab_admin_delete.php";
	var data_string = "user_id="+user_id;
	$('#'+progress_div_id).show();
	$('#'+link_div_id).hide();
	$.ajax({
		type: "POST",
		url: url_string,
		data: data_string,
		success: function(msg) {
			$('#'+progress_div_id).hide();
			$('#'+link_div_id).hide();
			window.location = "lab_admins.php?del="+username;
		}
	});
}

function show_dialog_box(div_id)
{
	$('#'+div_id).hide();
}

function show_dialog_box(div_id)
{
	$('#'+div_id).show();
	$('#'+div_id).focus();
}
</script>
<br>
<b><?php echo LangUtil::getTitle(); ?></b>
| <a href='lab_admin_new.php' rel='facebox' title='Click to Add New Lab Manager Account'><?php echo LangUtil::$generalTerms['CMD_ADDNEWACCOUNT']; ?></a>
<br><br>
<?php
$tips_string = LangUtil::$pageTerms['TIPS_MANAGELAB'];
$page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);

if(isset($_REQUEST['added']))
{
	?>
	<div class='clean-orange' id='server_msg' style='top-margin:20px;width:300px;'>
	'<?php echo $_REQUEST['added']; ?>' - <?php echo LangUtil::$generalTerms['MSG_ACC_ADDED']; ?>
	&nbsp;&nbsp;
	<small><a href="javascript:toggle('server_msg');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a></small>
	</div>
	<?php
}
else if(isset($_REQUEST['del']))
{
	?>
	<div class='clean-orange' id='server_msg' style='top-margin:20px;width:300px;'>
	'<?php echo $_REQUEST['del']; ?>' - <?php echo LangUtil::$generalTerms['MSG_ACC_DELETED']; ?>
	&nbsp;&nbsp;
	<small><a href="javascript:toggle('server_msg');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a></small>
	</div>
	<?php
}
else if(isset($_REQUEST['upd']))
{
	?>
	<div class='clean-orange' id='server_msg' style='top-margin:20px;width:300px;'>
	'<?php echo $_REQUEST['upd']; ?>' - <?php echo LangUtil::$generalTerms['MSG_ACC_UPDATED']; ?>
	&nbsp;&nbsp;
	<small><a href="javascript:toggle('server_msg');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a></small>
	</div>
	<?php
}

$lab_admin_list = get_admin_users();
$page_elems->getLabAdminTable($lab_admin_list); 
?>
<br><br><br>
<?php include("includes/footer.php"); ?>