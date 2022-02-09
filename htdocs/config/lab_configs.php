<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Lists currently accessible lab configurations with options to modify/add 
# Check whether to redirect to lab configuration page
# Called when the lab admin has only one lab under him/her
#

include("../users/accesslist.php");
include("redirect.php");
include("includes/user_lib.php");


if( !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList))
	&& !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList))
    && !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)))
	header( 'Location: home.php' );

get_user_by_id($_SESSION['user_id']);
$_SESSION['user_level'];



if(User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level']))
{
    
	$lab_config_list = get_lab_configs($_SESSION['user_id']);
    $_SESSION['lab_config_id']=$lab_config_list[0]->id;
	header("location:lab_config_home.php?id=".$lab_config_list[0]->id);
}


include("includes/header.php");
LangUtil::setPageId("lab_configs");
?>
<script type='text/javascript'>
$(document).ready(function(){
	<?php
	if(isset($_REQUEST['revert'])) {
		if($_REQUEST['revert']==0) { ?>
			$('#update_failure').show();
		<?php
		}
		else { ?>
			$('#update_success').show();
		<?php
		}
	}
	?>
});	

function toggle_div(div_name) {
	$("#"+div_name).hide();
}

function update_database_submit() {
	$('#update_database_progress').show();
	$('#update_database_form').ajax({
		url: 'update_database.php?lid=0&do_currbackup=N&backup_path=0',
		success: function(data) {
			window.location = data;
		}
	});

}

function delete_lab_config(site_name, id)
{
	var confirm_code = confirm(
		"Are you sure you want to delete configuration for '"+site_name+"' ?\n"+
		"All data and technician accounts will be deleted permanently. "
	);
	if(confirm_code == false)
	{
		return;
	}
	var url_string = "ajax/lab_config_delete.php";
	var data_string = "id="+id;
	$.ajax({
		type: "POST",
		url: url_string,
		data: data_string,
		success: function(msg) {
			window.location = "lab_configs.php";
		}
	});
}

function search_labs(view_all)
{
	$('#lab_search_progress_bar').show();
	var url;
	if(view_all == 1)
	{
		//View all lab configs
		url = "ajax/lab_config_search.php?q=";
		var search_term = $('#lab_search_term').attr("value", "");
		$('#viewall_link').hide();
	}
	else
	{
		//View by seacrch term
		var search_term = $('#lab_search_term').val();
		url = "ajax/lab_config_search.php?q="+search_term;
		if(search_term.trim() == "")
			$('#viewall_link').hide();
		else
			$('#viewall_link').show();
	}
	$("#lab_config_list").load(
		url, 
		{}, 
		function(){
			$('#lab_search_progress_bar').hide();
		}
	);	
}
</script>
<?php $script_elems->bindEnterToClick("#lab_search_term", "#lab_search_button"); ?>
<br>
<b><?php echo LangUtil::getTitle(); ?></b>
 | <a href='lab_config_new.php'><?php echo LangUtil::$pageTerms['CMD_ADDNEWLAB']; ?></a>
  | <a href='lab_backups.php'><?php echo 'Import Lab Data'; ?></a>
|<a href="../ajax/download_key.php?role=dir">Download Public Key</a>

     <?php /* Enable when data merging is implemented
 | <a href='updateNationalDatabaseUI.php'><?php echo "Update National Database"; ?></a>
 | <a rel='facebox' href='exportNationalDatabaseUI.php'><?php echo "Export National Database"; ?></a>
 */ ?>
<br><br>
<?php
if(isset($_REQUEST['msg']))
{
	?>
	<div class='clean-orange' id='server_msg' style='top-margin:20px;width:300px;'>
	<?php echo base64_decode($_REQUEST['msg']); ?>
	&nbsp;&nbsp;
	<small><a href="javascript:toggle('server_msg');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a></small>
	</div>
	<?php
}
?>
<p>
	<input type='text' name="lab_search_term" id="lab_search_term" />
	&nbsp;&nbsp;
	<input type='button' onclick='javascript:search_labs(0);' name='lab_search_button' id='lab_search_button' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>' title='Enter full or partial name of the lab to search' />
	&nbsp;&nbsp;
	<a href='javascript:search_labs(1)' id='viewall_link' style='display:none;' title='Click to View All Lab Configurations'><small><?php echo LangUtil::$pageTerms['CMD_VIEWALL']; ?></small></a>
	&nbsp;&nbsp;
	<span id='lab_search_progress_bar' style='display:none;'>
		<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
	</span>
</p>
<?php 
$admin_user_id = $_SESSION['user_id'];

$lab_config_list = get_lab_configs($admin_user_id);

$lab_config_list_imported = get_lab_configs_imported();
//print_r($lab_config_list);
//echo "<br>";
//print_r($lab_config_list_imported);
?>
<div id='lab_config_list_imported'>
       <br>
    <b>Lab Backups</b>
	<?php $page_elems->getLabConfigTableImported($lab_config_list_imported);  ?>
</div>
    <br>
<div id='lab_config_list'>
    <b>Lab Config Templates</b>
	<?php $page_elems->getLabConfigTable($lab_config_list);  ?>
</div>
<br>
 <div id='update_success' class='clean-orange' style='display:none;width:350px;'>
	Updated Successfully&nbsp;&nbsp;&nbsp;<a href="javascript:toggle_div('update_success');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>
</div>
 <div id='update_failure' class='clean-orange' style='display:none;width:350px;'>
	Update Failed&nbsp;&nbsp;&nbsp;<a href="javascript:toggle_div('update_failure');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?>
</div>
<br>
<small><a href='lab_config_new.php'><?php echo LangUtil::$pageTerms['CMD_ADDNEWLAB']; ?> &raquo;</a> | </small> 
<?php
/* Need to fix bug
<small><a href='javascript:update_database_submit();'><?php echo 'Update All Labs Data from Backups'; ?></a> | </small>
*/
?>
<small><a rel='facebox' href='update/blis_update.php'><?php echo 'Update To New Version'; ?></a></small>
<span id='update_database_progress' style='display:none'>
	<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
</span>
<?php include("includes/footer.php"); ?>