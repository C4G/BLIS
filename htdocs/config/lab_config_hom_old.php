<?php
#
# Main page for listing all options for a lab configuration
# Used by the Lab Admin periodically to change settings
#

include("redirect.php");
include("includes/new_image.php");
include("includes/header.php");
include("includes/random.php");
include("includes/stats_lib.php");
LangUtil::setPageId("lab_config_home");

$script_elems->enableTableSorter();
$script_elems->enableJQueryForm();

$lab_config_id = $_REQUEST['id'];
$lab_config = LabConfig::getById($lab_config_id);
if($lab_config == null)
{
	?>
	<br><br>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>
	<?php
	include("includes/footer.php");
	return;
}
?>
<style type='text/css'>

.range_field {
	width:30px;
}
</style>
<script type='text/javascript'>

<?php $page_elems->getCompatibilityJsArray("st_map"); ?>

$(document).ready(function(){
	$("input[name='rage']").change(function() {
		toggle_agegrouplist();
	});
	$('#revert_done_msg').hide();
	$('#cat_code12').change( function() { get_test_types_bycat() });
	get_test_types_bycat
	<?php
	if(isset($_REQUEST['show_u']))
	{
		# Preload user accounts pane
		?>
		right_load(3, 'users_div');
		<?php		
	}
	else if(isset($_REQUEST['show_f']))
	{
		# Preload custom fields pane
		?>
		right_load(4, 'fields_div');
		<?php
	}
	else
	{
		?>
		right_load(1, 'site_info_div');
		<?php
	}
	if(isset($_REQUEST['aupdate']))
	{
		# Show user account updated message
		?>
		$('#user_acc_msg').html("'<?php echo $_REQUEST['aupdate']; ?>' - <?php echo LangUtil::$generalTerms['MSG_ACC_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('user_acc_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#user_acc_msg').show();
		<?php
	}
	else if(isset($_REQUEST['adel']))
	{
		# Show user account deleted message
		?>
		$('#user_acc_msg').html("<?php echo LangUtil::$generalTerms['MSG_ACC_DELETED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('user_acc_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#user_acc_msg').show();
		<?php
	}
	else if(isset($_REQUEST['aadd']))
	{
		# Show user account added message
		?>
		$('#user_acc_msg').html("'<?php echo $_REQUEST['aadd']; ?>' - <?php echo LangUtil::$generalTerms['MSG_ACC_ADDED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('user_acc_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#user_acc_msg').show();
		<?php
	}
	else if(isset($_REQUEST['tupdate']))
	{
		# Show TAT values updated message
		?>
		$('#tat_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('tat_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#tat_msg').show();
		right_load(5, 'target_tat_div');
		<?php
	}
	else if(isset($_REQUEST['fupdate']))
	{
		# Show custom field updated message
		?>
		$('#cfield_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('cfield_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#cfield_msg').show();
		right_load(4, 'fields_div');
		<?php
	}
	else if(isset($_REQUEST['fadd']))
	{
		# Show custom field added message
		?>
		$('#cfield_msg').html("<?php echo LangUtil::$generalTerms['MSG_ADDED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('cfield_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#cfield_msg').show();
		right_load(4, 'fields_div');
		<?php
	}
	else if(isset($_REQUEST['stupdate']))
	{
		# Show custom field updated message
		?>
		$('#sttypes_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('sttypes_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#sttypes_msg').show();
		right_load(2, 'st_types_div');
		<?php
	}
	else if(isset($_REQUEST['adupdate']))
	{
		# Show custom field updated message
		?>
		$('#admin_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('admin_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#admin_msg').show();
		right_load(7, 'change_admin_div');
		<?php
	}
	else if(isset($_REQUEST['aggupdate']))
	{
		# Show custom field updated message
		?>
		$('#agg_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('agg_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#agg_msg').show();
		right_load(8, 'agg_report_div');
		<?php
	}
	else if(isset($_REQUEST['miscupdate']))
	{
		# Show general settings updated message
		?>
		$('#misc_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('misc_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#misc_msg').show();
		right_load(9, 'misc_div');
		<?php
	}
	else if(isset($_REQUEST['langupd']))
	{
		# Show locale updated message
		?>
		$('#main_msg').html("<?php echo LangUtil::$pageTerms['MSG_LANGUPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('main_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#main_msg').show();
		<?php
	}
	else if(isset($_REQUEST['ofupdate']))
	{
		# Show other fields updated message
		?>
		$('#cfield_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('cfield_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#cfield_msg').show();
		right_load(4, 'fields_div');
		<?php
	}
	else if(isset($_REQUEST['rcfgupdate']))
	{
		# Show report config updated message
		?>
		$('#report_config_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('report_config_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#report_config_msg').show();
		var report_type=<?php echo $_REQUEST['rcfgupdate']; ?>;
		right_load(11, 'report_config_div');
		$('#report_type11').attr("value", report_type);
		//fetch_report_config();
		fetch_report_summary();
		<?php
	}
	else if(isset($_REQUEST['wcfgupdate']))
	{
		# Show report config updated message
		?>
		$('#worksheet_config_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('worksheet_config_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#worksheet_config_msg').show();
		<?php 
		$post_parts = explode(",", $_REQUEST['wcfgupdate']); 
		?>
		right_load(12, 'worksheet_config_div');
		$('#cat_code12').attr("value", "<?php echo $post_parts[0]; ?>");
		$('#test_type12').attr("value", "<?php echo $post_parts[1]; ?>");
		fetch_worksheet_summary();
		<?php
	}
	else if(isset($_REQUEST['revert']))
	{
		?>
		right_load(13, 'backup_revert_div');
		<?php
		if($_REQUEST['revert'] == 1)
		{
			?>
			//$('#backup_revert_msg').html("<?php #echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('backup_revert_msg');\"><?php #echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
			$('#revert_done_msg').show();
			<?php
		}
		else
		{
			?>
			$('#backup_revert_msg').html("<?php echo LangUtil::$generalTerms['ERROR']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('backup_revert_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
			$('#backup_revert_msg').show();
			<?php
		}
	}
	?>
	$('#lab_admin').attr("value", "<?php echo $lab_config->adminUserId; ?>");
	$('.stype_entry').change(function() {
		check_compatible();
	});
	$('.dboption').change(function() {
		toggle_dboption_help();
	});
	stype_toggle();
	check_compatible();	
});

function test_setup()
{
if(document.getElementById('test_setup').style.display =='none')
$('#test_setup').show();
else
$('#test_setup').hide();
}

function report_setup()
{
if(document.getElementById('report_setup').style.display =='none')
$('#report_setup').show();
else
$('#report_setup').hide();

}
	
function check_compatible()
{
	// TODO:
	/*
	$('.ttype_entry').attr("disabled", "disabled");
	//$('.ttype_entry').removeAttr("checked");
	for(var i in st_map)
	{
		var stype_elem_id = "s_type_"+i;
		var stype_elem = $('#'+stype_elem_id);
		if(stype_elem == undefined || stype_elem == null)
			continue;
		if(stype_elem.attr("checked"))
		{
			var test_csv = st_map[i];
			if(test_csv == "" || test_csv == null || test_csv == undefined || typeof test_csv != 'string')
				continue;
			if(test_csv.contains(","))
			{
				var test_list = test_csv.split(",");
				for(var j in test_list)
				{
					var checkbox_elem_id = "t_type_"+j;
					var checkbox_elem = $('#'+checkbox_elem_id);
					checkbox_elem.removeAttr("disabled");
				}
			}
			else
			{
				var checkbox_elem_id = "t_type_"+test_csv;
				var checkbox_elem = $('#'+checkbox_elem_id);
				checkbox_elem.removeAttr("disabled");
			}
		}
	}
	*/
}

function right_load(option_num, div_id)
{
	$('#name9').attr("value", "<?php echo $lab_config->name; ?>");
	$('#loc9').attr("value", "<?php echo $lab_config->location; ?>");
	$('#misc_errormsg').hide();
	$('.right_pane').hide();
	$('.menu_option').removeClass('current_menu_option');
	$('#'+div_id).show();
	$('#option'+option_num).addClass('current_menu_option');
	
}



function export_html()
{
<?php
$myFile = "../../BlisSetup.html";
$fh = fopen($myFile, 'w') or die("can't open file");
$content =('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<META HTTP-EQUIV="Refresh"
CONTENT="1; URL=');
$content1=('">
</head> 
</html>');
$content=$content.StatsLib::get_ip().$content1;
fwrite($fh, $content);
fclose($fh);
?>
right_load(14, 'network_setup_div');
}
function ask_to_delete_user(user_id)
{
	var div_id = 'delete_confirm_'+user_id;
	$('#'+div_id).show();
}

function delete_user(user_id)
{
	var url_string = "ajax/lab_user_delete.php?uid="+user_id;
	var reload_url = "lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_u=1&adel=1";
	$.ajax({ url: url_string, async: false, success: function() {
		window.location=reload_url;
	}});
}

function submit_goal_tat()
{
	$('#tat_progress_spinner').show();
	$('#goal_tat_form').ajaxSubmit({
		success: function() {
			$('#tat_progress_spinner').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&tupdate=1";
		}
	});
}

function toggletatdivs()
{
	$('#goal_tat_list').toggle();
	$('#goal_tat_form').toggle();
	var curr_link_text = $('#toggletat_link').html();
	if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
		$('#toggletat_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
	else
		$('#toggletat_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
}

function toggle_disease_report()
{
	$('#agg_report_summary').toggle();
	$('#agg_report_form_div').toggle();
	var curr_link_text = $('#agg_edit_link').html();
	if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
		$('#agg_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
	else
		$('#agg_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
}

function toggle_ofield_div()
{
	$('#ofield_summary').toggle();
	$('#ofield_form_div').toggle();
	var curr_link_text = $('#ofield_toggle_link').html();
	if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
		$('#ofield_toggle_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
	else
		$('#ofield_toggle_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
}

function stype_toggle()
{
	$('#stype_box').toggle();
	if($('#stype_link').html() == "Show")
	{
		$('#stype_link').html("Hide");		
	}
	else
	{
		$('#stype_link').html("Show");
	}
}

function ttype_toggle()
{
	$('#ttype_box').toggle();
	if($('#ttype_link').html() == "Show")
	{
		$('#ttype_link').html("Hide");		
	}
	else
	{
		$('#ttype_link').html("Show");
	}
}

function checkandsubmit_st_types()
{
	//Validate
	var stype_entries = $('.stype_entry');
	var stype_selected = false;
	for(var i = 0; i < stype_entries.length; i++)
	{
		if(stype_entries[i].checked)
		{
			stype_selected = true;
			break;
		}
	}
	if(stype_selected == false)
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_SPECIMENSNOTSELECTED']; ?>");
		return;
	}
	var ttype_entries = $('.ttype_entry');
	var ttype_selected = false;
	for(var i = 0; i < ttype_entries.length; i++)
	{
		if(ttype_entries[i].checked)
		{
			ttype_selected = true;
			break;
		}
	}
	if(ttype_selected == false)
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_TESTSNOTSELECTED']; ?>");
		return;
	}
	//All okay
	$('#st_types_progress').show();
	$('#st_types_form').ajaxSubmit({success:function(){
			$('#st_types_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&stupdate=1";
		}
	});
}

function delete_config()
{
	var url_string ='ajax/lab_config_delete.php?id=<?php echo $lab_config->id; ?>';
	$.ajax({ url: url_string, async: false, success: function(){
			window.location="lab_configs.php?msg=<?php echo base64_encode($lab_config->getSiteName()." deleted"); ?>";
		}
	});
}

function change_admin()
{
	var admin_user_id = $('#lab_admin').attr('value');
	var url_string = 'ajax/lab_admin_change.php?lid=<?php echo $lab_config->id; ?>&uid='+admin_user_id;
	$.ajax({ url: url_string, async: false, success: function(){
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&adupdate=1";
		}
	});
}

function agg_checkandsubmit()
{
	//Validate
	//TODO
	//All okay
	$('#agg_progress_spinner').show();
	$('#agg_report_form').ajaxSubmit({
		success: function() {
			$('#agg_progress_spinner').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&aggupdate=1";
		}
	});
}

function agg_preview()
{
	// Shows preview of infection report in a separate window
	// Clone fields from disease report form to preview form
	$('#agg_preview_form').html($('#agg_report_form').clone(true).html());
	$('#agg_preview_form').submit();
}

function toggle_agegrouplist()
{
	$('#agegrouprow').toggle();
}

function agegrouplist_append()
{
	var html_code = "&nbsp;&nbsp;<input type='text' name='age_l[]' class='range_field'></input>-<input type='text' name='age_u[]' class='range_field'></input>";
	$('#agegrouplist_inner').append(html_code);
}

function add_slot(span_id, field_name1, field_name2)
{
	var html_code = "&nbsp;&nbsp;&nbsp;<input type='text' class='range_field' name='"+field_name1+"[]' value=''></input>-<input type='text' class='range_field' name='"+field_name2+"[]' value=''></input>";
	$('#'+span_id).append(html_code);
}

function misc_checkandsubmit()
{
	//Validate
	$('#misc_errormsg').html("");
	$('#misc_errormsg').hide();
	var name = $('#name9').attr("value");
	var location = $('#loc9').attr("value");
	var err_msg = "";
	if(name.trim() == "")
		err_msg = "<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>";
	else if(location.trim() == "")
		err_msg = "<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>";
	if(err_msg != "")
	{
		$('#misc_errormsg').html(err_msg);
		$('#misc_errormsg').show();
		return;
	}	
	//All okay
	$('#misc_progress').show();
	$('#misc_form').ajaxSubmit({
		success: function() {
			$('#misc_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&miscupdate=1";
		}
	});
}

function toggle_dboption_help()
{
	var dboption_val = $("input[name='dboption']:checked").attr("value");
	$('.dboption_help').hide();
	$('.random_params').hide();
	if(dboption_val != 0)
	{
		$('#dboption_help_'+dboption_val).show();
	}
	if(dboption_val == 1)
	{
		$('.random_params').show();
	}
}

function submit_otherfields()
{
	$('#otherfields_progress').show();
	$('#otherfields_form').ajaxSubmit({
		success: function() {
			$('#otherfields_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&ofupdate=1";
		}
	});
}

function backup_data()
{
	$('#backup_form').submit();
}

function fetch_report_config()
{
	var report_type = $("#report_type11").attr("value");
	var url_string = "ajax/report_config_fetch.php?l=<?php echo $lab_config->id; ?>&rt="+report_type;
	$('#report_config_fetch_progress').show();
	$('#report_config_content').load(url_string, function() {
		$('#report_config_fetch_progress').hide();
	});
}

function hide_report_config()
{
	$('#report_config_content').html("");
}


function fetch_report_summary()
{
	var report_type = $("#report_type11").attr("value");
	var url_string = "ajax/report_config_summary.php?l=<?php echo $lab_config->id; ?>&rt="+report_type;
	$('#report_config_fetch_progress').show();
	$('#report_config_content').load(url_string, function() {
		$('#report_config_fetch_progress').hide();
	});
}

function update_file()
{ 
var report_id = $('#report_type11').attr("value");
	$('#submit_report_config_progress').show();
	$('#report_config_submit_form').ajaxSubmit({
		success: function() {
			$('#submit_report_config_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&rcfgupdate="+report_id;
		}
	});
}
 function update_report_config()
{ 
var report_id = $('#report_type11').attr("value");

	$('#submit_report_config_progress').show();
		$('#report_config_submit_form').ajaxSubmit({
		success: function() {
		$('#submit_report_config_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&rcfgupdate="+report_id;
		}
	});
}

function get_test_types_bycat()
{
	var cat_code = $('#cat_code12').attr("value");
	var location_code = <?php echo $lab_config->id; ?>;
	$('#test_type12').load('ajax/tests_selectbycat.php?c='+cat_code+'&l='+location_code+'&all_no');
}

function fetch_worksheet_config()
{
	var cat_code = $('#cat_code12').attr("value");
	var t_type = $('#test_type12').attr("value");
	var url_string = "ajax/worksheet_config_fetch.php?l=<?php echo $lab_config->id; ?>&c="+cat_code+"&t="+t_type;
	$('#worksheet_fetch_progress').show();
	$('#worksheet_config_content').load(url_string, function() {
		$('#worksheet_fetch_progress').hide();
	});
}

function hide_worksheet_config()
{
	$('#worksheet_config_content').html("");
}

function fetch_worksheet_summary()
{
	var cat_code = $('#cat_code12').attr("value");
	var t_type = $('#test_type12').attr("value");
	var url_string = "ajax/worksheet_config_summary.php?l=<?php echo $lab_config->id; ?>&c="+cat_code+"&t="+t_type;
	$('#worksheet_fetch_progress').show();
	$('#worksheet_config_content').load(url_string, function() {
		$('#worksheet_fetch_progress').hide();
	});
}

function update_worksheet_config()
{
	var cat_code = $('#cat_code12').attr("value");
	var t_type = $('#test_type12').attr("value");
	$('#submit_worksheet_config_progress').show();
	$('#worksheet_config_submit_form').ajaxSubmit({
		success: function() {
			$('#submit_worksheet_config_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&wcfgupdate="+cat_code+","+t_type;
		}
	});
}

function backup_revert_submit()
{
	// Validate
	// All okay
	$('#backup_revert_progress').show();
	$('#backup_revert_form').submit();
}

function add_title_line()
{
	var html_code = "<input type='text' name='title[]' value='' class='uniform_width_more'></input><br>";
	$('#title_lines').append(html_code);
}
</script>

<br>
<table>
	<tbody>
		<tr valign='top'>
			<td class='left_menu' id='left_pane' width='150px'><ul>
				<li><a id='option1' class='menu_option' href="javascript:right_load(1, 'site_info_div');"><?php echo LangUtil::$pageTerms['MENU_SUMMARY']; ?></a>
				</li>
			<?php
				# If super-admin or country-dir, show option to Delete this configuration
				# If super-admin or country-dir, show option to Change lab manager/admin
				# If super-admin or country-dir, show option to Back up Data
				# For lab admin, the option appears as a separate tab
				$user = get_user_by_id($_SESSION['user_id']);
				if(is_super_admin($user) || is_country_dir($user))
				{			
					?>
				
				<li>	<a id='option9' class='menu_option' href="javascript:right_load(9, 'misc_div');"><?php echo LangUtil::$pageTerms['MENU_GENERAL']; ?></a>
					<br><br></li><li>
					<a id='option7' class='menu_option' href="javascript:right_load(7, 'change_admin_div');"><?php echo LangUtil::$pageTerms['MENU_MGR']; ?></a>
					<br><br></li><li>
					<a id='option6' class='menu_option' href="javascript:right_load(6, 'del_config_div');"><?php echo LangUtil::$pageTerms['MENU_DEL']; ?></a></li>
					<?php					
				}
				?>
				<br>
				</li><li>
				<a id='test' class='menu_option' href="javascript:test_setup();"><?php echo LangUtil::$pageTerms['Tests']; ?> </a>
<br><br></li>
				<div id='test_setup' name='test_setup' style='display:none;'>
				<a id='option2' class='menu_option' href="javascript:right_load(2, 'st_types_div');"><?php echo LangUtil::$pageTerms['MENU_ST_TYPES']; ?></a>
				<br><br>
				<a id='option5' class='menu_option' href="javascript:right_load(5, 'target_tat_div');"><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></a>
				<br><br>
				<a href='remarks_edit.php?id=<?php echo $_REQUEST['id']; ?>'><?php echo "Results Interpretation"; ?></a>
				<br><br>
				</div>
				<li>
				<a id='report' class='menu_option' href="javascript:report_setup();"><?php echo LangUtil::$pageTerms['Reports']; ?> </a>
<br><br></li>
				<div id='report_setup' name='report_setup' style='display:none;'>
							
				<a id='option8' class='menu_option' href="javascript:right_load(8, 'agg_report_div');"><?php echo LangUtil::$pageTerms['MENU_INFECTION']; ?></a>
				<br><br>
				<a id='option11' class='menu_option' href="javascript:right_load(11, 'report_config_div');"><?php echo LangUtil::$pageTerms['MENU_REPORTCONFIG']; ?></a>
				<br><br>
				<a id='option12' class='menu_option' href="javascript:right_load(12, 'worksheet_config_div');"><?php echo LangUtil::$pageTerms['MENU_WORKSHEETCONFIG']; ?></a>
				<br><br>
				</div>
				<li>
				<a id='option12' class='menu_option' href="javascript:right_load(12, 'worksheet_config_div');"><?php echo LangUtil::$pageTerms['MENU_WORKSHEETCONFIG']; ?></a>
				<br><br></li>
				<li>				
				<a id='option3' class='menu_option' href="javascript:right_load(3, 'users_div');"><?php echo LangUtil::$pageTerms['MENU_USERS']; ?></a>
				<br><br></li><li>
				<a id='option4' class='menu_option' href="javascript:right_load(4, 'fields_div');"><?php echo LangUtil::$pageTerms['MENU_CUSTOM']; ?></a>
				<br><br></li><li>
				<a href='lang_edit?locale=<?php echo $_SESSION['locale']; ?>&id=<?php echo $_REQUEST['id']; ?>'><?php echo LangUtil::getPageTerm("MODIFYLANG"); ?> </a>
				<br><br></li>
				<li>
				<a id='option14' class='menu_option' href="javascript:export_html();"><?php echo "Setup Network" ?></a>
				<br><br></li>
				<li>
				<a href='export_config?id=<?php echo $_REQUEST['id']; ?>' target='_blank'><?php echo LangUtil::$pageTerms['MENU_EXPORTCONFIG']; ?></a><br><br></li>
				<?php
				if($SERVER != $ON_ARC)
					{
					?>
						
					<li>	<a id='option10' class='menu_option' href="javascript:backup_data();"><?php echo $LANG_ARRAY['header']['MENU_BACKUP']; ?></a><br><br></li>
					<?php
					}
					
	
				if($SERVER != $ON_ARC)
				{
					?>
					
					<li><a id='option13' class='menu_option' href="javascript:right_load(13, 'backup_revert_div');"><?php echo LangUtil::$pageTerms['MENU_BACKUP_REVERT']; ?></a><br><br></li>
					<?php
				}
				?>
					<!--<li>
				<a href='stock_management?locale=<?php echo $_SESSION['locale']; ?>&id=<?php echo $_REQUEST['id']; ?>'><?php echo LangUtil::$pageTerms['New Stock']; ?></a>
				<br><br></li>--><li>
				<a id='option12' class='menu_option' href="javascript:right_load(15, 'inventory_div');"><?php echo LangUtil::$pageTerms['Inventory']; ?></a>
				<br><br></li><!--<li><a href='stock_edit.php'><?php echo LangUtil::$pageTerms['Edit Stock']; ?></a>	</li>-->
				</ul>
			</td>
			<td>
				<br><br><br><br><br>
			</td>
			<td>
			
				<div class='right_pane' id='site_info_div' style='display:none;margin-left:10px;'>
				<b><?php echo LangUtil::$pageTerms['MENU_SUMMARY']; ?></b>
					<br><br>
					<div id='main_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<?php
					$page_elems->getLabConfigInfo($lab_config->id);
					?>
					<form id='backup_form' name='backup_form' action='data_backup' method='post' target='_blank'>
						<input type='hidden' name='id' value='<?php echo $_REQUEST['id']; ?>'></input>
					</form>
				</div>
			
				<div class='right_pane' id='st_types_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_ST_TYPES']; ?></b>
					<br><br>
					<div id='sttypes_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<form id='st_types_form' name='st_types_form' action='ajax/st_types_update.php' method='post'>
					<input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>					
					<?php echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?>
					<small><a id='stype_link' href='javascript:stype_toggle();'><?php echo LangUtil::$generalTerms['CMD_SHOW']; ?></a></small>
					<div class='pretty_box' id='stype_box' style='display:none'>
					<b><u><?php echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></u></b>
						<?php $page_elems->getSpecimenTypeCheckboxes($lab_config->id); ?>
					</div>
					<br>
					<br>
					<?php echo LangUtil::$generalTerms['TEST_TYPES']; ?>
					<small><a id='ttype_link' href='javascript:ttype_toggle();'><?php echo LangUtil::$generalTerms['CMD_SHOW']; ?></a></small>
					<div class='pretty_box' id='ttype_box' style='display:none'>
					<b><u><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></u></b>
						<?php $page_elems->getTestTypeCheckboxes($lab_config->id); ?>
					</div>
					<br><br>
					<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='checkandsubmit_st_types()'>
					</input>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<span id='st_types_progress' style='display:none;'>
						<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
					</form>
				</div>
				
				<div class='right_pane' id='users_div' style='display:none;margin-left:10px;'>
					<?php
					$reload_url = "lab_config_home.php?id=$lab_config_id";
					?>
					<b><?php echo LangUtil::$pageTerms['MENU_USERS']; ?></b>
					 | <a rel='facebox' href='lab_user_new.php?ru=<?php echo $reload_url; ?>&lid=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['CMD_ADDNEWACCOUNT']; ?></a>
					<br><br>
					<div id='user_acc_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<div id='user_list_table'>
					<?php
					$user_list = $lab_config->getUsers();
					$page_elems->getLabUsersTable($user_list, $lab_config_id);
					?>
					</div>
				</div>
				<div class='right_pane' id='inventory_div' style='display:none;margin-left:10px;'>
					<?php
					$reload_url = "lab_config_home.php?id=$lab_config_id";
					?>
					<b>Inventory</b>
					 <ul>
					<li>
				<a href='stock_management?locale=<?php echo $_SESSION['locale']; ?>&id=<?php echo $_REQUEST['id']; ?>'><?php echo LangUtil::$pageTerms['New Stock']; ?></a>
				<br><br></li>
					<li><a href='stock_edit.php'><?php echo LangUtil::$pageTerms['Edit Stock']; ?></a>	</li></ul>
				</div>
				
				<div class='right_pane' id='fields_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_CUSTOM']; ?></b>
					 | <a href='javascript:toggle_ofield_div();' id='ofield_toggle_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
					<br><br>
					<div id='cfield_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<div id='ofield_summary' class='pretty_box'>
					<?php $page_elems->getRegistrationFieldsSummary($lab_config); ?>
					</div>
					<div id='ofield_form_div' style='display:none;'>
					<form id='otherfields_form' name='otherfields_form' action='ajax/ofield_update.php' method='post'>
					<input type='hidden' value='<?php echo $_REQUEST['id']; ?>' name='lab_config_id'></input>
					<table class='hor-minimalist-b' style='width:auto;'>
						<thead>
							<tr>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr valign='top'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></td>
								<td>
									<input type='checkbox' name='use_pid' id='use_pid' <?php
									if($lab_config->pid != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_pid_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_pid_radio' value='Y' <?php
										if($lab_config->pid == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_pid_radio' value='N' <?php
										if($lab_config->pid != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr valign='top'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['ADDL_ID']; ?></td>
								<td>
									<input type='checkbox' name='use_p_addl' id='use_p_addl' <?php
									if($lab_config->patientAddl != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_p_addl_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_p_addl_radio' value='Y' <?php
										if($lab_config->patientAddl == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_p_addl_radio' value='N' <?php
										if($lab_config->patientAddl != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></td>
								<td>
									<input type='checkbox' name='use_dnum' id='use_dnum'<?php
									if($lab_config->dailyNum != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_dnum_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_dnum_radio' value='Y'<?php
										if($lab_config->dailyNum == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_dnum_radio' value='N' <?php
										if($lab_config->dailyNum != 2)
											echo " checked ";
										?> ><?php echo LangUtil::$generalTerms['NO']; ?></input>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_RESET']; ?>
										<select name='dnum_reset' id='dnum_reset'>
											<option value='<?php echo LabConfig::$RESET_DAILY; ?>'><?php echo LangUtil::$pageTerms['DAILY']; ?></option>
											<option value='<?php echo LabConfig::$RESET_WEEKLY; ?>'><?php echo LangUtil::$pageTerms['WEEKLY']; ?></option>
											<option value='<?php echo LabConfig::$RESET_MONTHLY; ?>'><?php echo LangUtil::$pageTerms['MONTHLY']; ?></option>
											<option value='<?php echo LabConfig::$RESET_YEARLY; ?>'><?php echo LangUtil::$pageTerms['YEARLY']; ?></option>
										</select>
										<script type='text/javascript'>
										$(document).ready(function(){
											$('#dnum_reset').attr("value", "<?php echo $lab_config->dailyNumReset; ?>");
										});										
										</script>
									</span>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['NAME']; ?></td>
								<td>
									<input type='checkbox' name='use_pname' id='use_pname'<?php
									if($lab_config->pname != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_pname_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_pname_radio' value='Y'<?php
										if($lab_config->pname == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_pname_radio' value='N' <?php
										if($lab_config->pname != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['GENDER']; ?></td>
								<td>
									<input type='checkbox' name='use_sex' id='use_sex' <?php
									if($lab_config->sex != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_sex_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['DOB']; ?></td>
								<td>
									<input type='checkbox' name='use_dob' id='use_dob'<?php
									if($lab_config->dob != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_dob_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_dob_radio' value='Y'<?php
										if($lab_config->dob == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_dob_radio' value='N' <?php
										if($lab_config->dob != 2)
											echo " checked ";
										?> ><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['AGE']; ?></td>
								<td>
									<input type='checkbox' name='use_age' id='use_age'<?php
									if($lab_config->age != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_age_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_age_radio' value='Y'<?php
										if($lab_config->age == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_age_radio' value='N' <?php
										if($lab_config->age != 2)
											echo " checked ";
										?> ><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<?php
							# Option moved to technician account profile from v0.8.2
							/*
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$pageTerms['USE_PNAME_RESULTS']; ?>?</td>
								<td>
									<input type='radio' name='show_pname_radio' value='Y' <?php
									if($lab_config->hidePatientName == 0)
										echo " checked ";
									?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
									<input type='radio' name='show_pname_radio' value='N' <?php
									if($lab_config->hidePatientName == 1)
										echo " checked ";
									?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
								</td>
							</tr>
							*/
							?>
							<tr valign='top' style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
								<td>
									<input type='checkbox' name='use_sid' id='use_sid'<?php
									//if($lab_config->sid != 0)
									if(true)
										echo " checked ";
									?>>
									</input>
									<span id='use_sid_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
								<td>
									<input type='checkbox' name='use_s_addl' id='use_s_addl'<?php
									if($lab_config->specimenAddl != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_s_addl_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_s_addl_radio' value='Y'<?php
										if($lab_config->specimenAddl == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_s_addl_radio' value='N' <?php
										if($lab_config->specimenAddl != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['COMMENTS']; ?></td>
								<td>
									<input type='checkbox' name='use_comm' id='use_comm'<?php
									if($lab_config->comm != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_comm_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_comm_radio' value='Y'<?php
										if($lab_config->comm == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_comm_radio' value='N' <?php
										if($lab_config->comm != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['R_DATE']; ?></td>
								<td>
									<input type='checkbox' name='use_rdate' id='use_rdate'<?php
									if($lab_config->rdate != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_rdate_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_rdate_radio' value='Y'<?php
										if($lab_config->rdate == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_rdate_radio' value='N' <?php
										if($lab_config->rdate != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['REF_OUT']; ?></td>
								<td>
									<input type='checkbox' name='use_refout' id='use_refout'<?php
									if($lab_config->refout != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_refout_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_refout_radio' value='Y'<?php
										if($lab_config->refout == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_refout_radio' value='N' <?php
										if($lab_config->refout != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['DOCTOR']; ?></td>
								<td>
									<input type='checkbox' name='use_doctor' id='use_doctor'<?php
									if($lab_config->refout != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_doctor_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_doctor_radio' value='Y'<?php
										if($lab_config->refout == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_doctor_radio' value='N' <?php
										if($lab_config->refout != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['DATE_FORMAT']; ?></td>
								<td>
									<select name='dformat' id='dformat'>
										<?php $page_elems->getDateFormatSelect($lab_config); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_UPDATE']; ?>' onclick='javascript:submit_otherfields();'>
									</input>
									&nbsp;&nbsp;&nbsp;
									<span id='otherfields_progress' style='display:none;'>
										<?php echo $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
					</form>
					</div>
					<script type='text/javascript'>
					$(document).ready(function(){
						if($('#use_pid').is(':checked'))
						{
							$('#use_pid_mand').show();
						}
						if($('#use_p_addl').is(':checked'))
						{
							$('#use_p_addl_mand').show();
						}
						if($('#use_s_addl').is(':checked'))
						{
							$('#use_s_addl_mand').show();
						}
						if($('#use_dnum').is(':checked'))
						{
							$('#use_dnum_mand').show();
						}
						if($('#use_sex').is(':checked'))
						{
							$('#use_sex_mand').show();
						}
						if($('#use_age').is(':checked'))
						{
							$('#use_age_mand').show();
						}
						if($('#use_dob').is(':checked'))
						{
							$('#use_dob_mand').show();
						}
						if($('#use_pid').is(':checked'))
						{
							$('#use_pid_mand').show();
						}
						if($('#use_sid').is(':checked'))
						{
							$('#use_sid_mand').show();
						}
						if($('#use_rdate').is(':checked'))
						{
							$('#use_rdate_mand').show();
						}
						if($('#use_refout').is(':checked'))
						{
							$('#use_refout_mand').show();
						}
						if($('#use_doctor').is(':checked'))
						{
							$('#use_doctor_mand').show();
						}
						if($('#use_pname').is(':checked'))
						{
							$('#use_pname_mand').show();
						}
						if($('#use_comm').is(':checked'))
						{
							$('#use_comm_mand').show();
						}
						$('#use_pid').click(function() {
							if($('#use_pid').is(':checked'))
							{
								$('#use_pid_mand').show();
							}
							else
							{
								$('#use_pid_mand').hide();
							}
						});
						$('#use_p_addl').click(function() {
							if($('#use_p_addl').is(':checked'))
							{
								$('#use_p_addl_mand').show();
							}
							else
							{
								$('#use_p_addl_mand').hide();
							}
						});
						$('#use_dnum').click(function() {
							if($('#use_dnum').is(':checked'))
							{
								$('#use_dnum_mand').show();
							}
							else
							{
								$('#use_dnum_mand').hide();
							}
						});
						$('#use_s_addl').click(function() {
							if($('#use_s_addl').is(':checked'))
							{
								$('#use_s_addl_mand').show();
							}
							else
							{
								$('#use_s_addl_mand').hide();
							}
						});
						$('#use_dnum').click(function() {
							if($('#use_dnum').is(':checked'))
							{
								$('#use_dnum_mand').show();
							}
							else
							{
								$('#use_dnum_mand').hide();
							}
						});
						$('#use_dob').click(function() {
							if($('#use_dob').is(':checked'))
							{
								$('#use_dob_mand').show();
							}
							else
							{
								$('#use_dob_mand').hide();
							}
						});
						$('#use_sid').click(function() {
							if($('#use_sid').is(':checked'))
							{
								$('#use_sid_mand').show();
							}
							else
							{
								$('#use_sid_mand').hide();
							}
						});
						$('#use_sex').click(function() {
							if($('#use_sex').is(':checked'))
							{
								$('#use_sex_mand').show();
							}
							else
							{
								$('#use_sex_mand').hide();
							}
						});
						$('#use_age').click(function() {
							if($('#use_age').is(':checked'))
							{
								$('#use_age_mand').show();
							}
							else
							{
								$('#use_age_mand').hide();
							}
						});
						$('#use_refout').click(function() {
							if($('#use_refout').is(':checked'))
							{
								$('#use_refout_mand').show();
							}
							else
							{
								$('#use_refout_mand').hide();
							}
						});
						$('#use_doctor').click(function() {
							if($('#use_doctor').is(':checked'))
							{
								$('#use_doctor_mand').show();
							}
							else
							{
								$('#use_doctor_mand').hide();
							}
						});
						$('#use_rdate').click(function() {
							if($('#use_rdate').is(':checked'))
							{
								$('#use_rdate_mand').show();
							}
							else
							{
								$('#use_rdate_mand').hide();
							}
						});
						$('#use_comm').click(function() {
							if($('#use_comm').is(':checked'))
							{
								$('#use_comm_mand').show();
							}
							else
							{
								$('#use_comm_mand').hide();
							}
						});
						$('#use_pname').click(function() {
							if($('#use_pname').is(':checked'))
							{
								$('#use_pname_mand').show();
							}
							else
							{
								$('#use_pname_mand').hide();
							}
						});
					});
					</script>
					<br>
					<?php echo LangUtil::$pageTerms['CUSTOMFIELDS']." - ".LangUtil::$generalTerms['SPECIMENS']; ?>
					 | <a href='cfield_new.php?lid=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['ADDNEW']; ?></a>[<a href='#new_help' rel='facebox'>?</a>]
					<div id='specimen_custom_field_list'>
					<?php 
					$custom_field_list = get_lab_config_specimen_custom_fields($lab_config->id);
					$page_elems->getCustomFieldTable($lab_config->id, $custom_field_list, 1); 
					?>
					</div>
					
					<br>
					<?php echo LangUtil::$pageTerms['CUSTOMFIELDS']." - ".LangUtil::$generalTerms['PATIENTS']; ?>
					 | <a href='cfield_new.php?lid=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['ADDNEW']; ?></a> [<a href='#new_help' rel='facebox'>?</a>]
					<div id='patient_custom_field_list'>
					<?php 
					$custom_field_list = get_lab_config_patient_custom_fields($lab_config->id);
					$page_elems->getCustomFieldTable($lab_config->id, $custom_field_list, 2); 
					?>
					</div>
				</div>
				<div class='right_pane' id='network_setup_div' style='display:none;margin-left:10px;'>
				Setup can be accessed from BlisSetup.html in the main folder.
				</div>
				<div class='right_pane' id='target_tat_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></b>
					 | <a href="javascript:toggletatdivs();" id='toggletat_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
					<br><br>
					<div id='tat_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<div id='goal_tat_list'>
					<?php $page_elems->getGetGoalTatTable($lab_config->id); ?>
					</div>
					<form id='goal_tat_form' style='display:none' name='goal_tat_form' action='ajax/lab_config_tat_update.php' method='post'>
						<?php $page_elems->getGoalTatForm($lab_config_id); ?>
						<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:submit_goal_tat();'></input>
						&nbsp;&nbsp;&nbsp;
						<small><a href='javascript:toggletatdivs();'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
						&nbsp;&nbsp;&nbsp;
						<span id='tat_progress_spinner' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
						</span>
					</form>
				</div>
				
				<div class='right_pane' id='del_config_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_DEL']; ?></b>
					<br><br>
					<div class='clean-orange' style='width:350px;'>
					'<?php echo $lab_config->getSiteName(); ?>' - <?php echo LangUtil::$pageTerms['TIPS_LABDELETE']; ?>
					<br><br>
					<input type='button' onclick='javascript:delete_config();' value='<?php echo LangUtil::$generalTerms['CMD_OK']; ?>'>
					&nbsp;&nbsp;&nbsp;
					<input type='button' onclick="javascript:right_load(1, 'site_info_div');" value='<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>'>
					</div>
				</div>
				
				<div class='right_pane' id='change_admin_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_MGR']; ?></b>
					<br><br>
					<div id='admin_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<select name='lab_admin' id='lab_admin' class='uniform_width'>
					<?php 
						# Fetch list of existing lab admins 
						$page_elems->getAdminUserOptions();
					?>
					</select>
					<br><br>
					<input type='button' onclick='javascript:change_admin();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'>
					&nbsp;&nbsp;&nbsp;
					<small><a href="javascript:right_load(1, 'site_info_div');"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
				</div>
				
				<div class='right_pane' id='agg_report_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_INFECTION']; ?></b>
					 | <a href='javascript:toggle_disease_report();' id='agg_edit_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
					<br><br>
					<div id='agg_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<div id='agg_report_summary'>
						<?php echo $page_elems->getAggregateReportSummary($lab_config); ?>
					</div>
					<div id='agg_report_form_div' style='display:none;'>
						<form id='agg_report_form' name='agg_report_form' action='ajax/report_agg_update.php' method='post'>
							<?php $page_elems->getAggregateReportConfigureForm($lab_config); ?>
						</form>	
						<form id='agg_preview_form' style='display:none;' name='agg_preview_form' action='report_disease_preview.php' method='post' target='_blank'>					
							<?php # This form is cloned from agg_report_form in javascript:agg_preview() function ?>
						</form>
					</div>
				</div>
				
				<div class='right_pane' id='misc_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_GENERAL']; ?></b>
					<br><br>
					<div id='misc_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<form id='misc_form' name='misc_form' action='ajax/lab_config_miscupdate.php' method='post'>
						<table cellspacing='10px'>
							<tbody>
								<tr>
									<td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td>
										<input type='text' name='name' id='name9' class='uniform_width' value='<?php echo $lab_config->name; ?>'>
										</input>
										<input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['LOCATION']; ?></td>
									<td>
										<input type='text' name='loc' id='loc9' class='uniform_width' value='<?php echo $lab_config->location; ?>'>
										</input>
									</td>
								</tr>
								<tr valign='top'>
									<td>Database</td>
									<td>
										<input type='radio' class='dboption' name='dboption' value='1'>Populate Random Data</input><br>
										<input type='radio' class='dboption' name='dboption' value='2'>Clear Random Data</input><br>
										<input type='radio' class='dboption' name='dboption' value='0' checked>Keep Unchanged</input>
										<br><br>
										<div class='clean-orange dboption_help uniform_width' id='dboption_help_1' style='display:none'>
										Populate Random Data - Creates new random records for patients and specimens
										</div>
										<div class='clean-orange dboption_help uniform_width' id='dboption_help_2' style='display:none'>
										Clear Random Data - Clears all random data about patients and specimens
										</div>
									</td>
								</tr>
								<tr valign='top' class='random_params' style='display:none;'>
									<td>Total Patients</td>
									<td>
										<input type='text' class='uniform_width' name='num_p' value='<?php echo $MAX_NUM_PATIENTS/2; ?>'></input>
									</td>
								</tr>
								<tr valign='top' class='random_params' style='display:none;'>
									<td>Total Specimens</td>
									<td>
										<input type='text' class='uniform_width' name='num_s' value='<?php echo "2000"; #$MAX_NUM_SPECIMENS/2; ?>'></input>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type='button' name='misc_form_button' id='misc_form_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:misc_checkandsubmit();'>
										</input>
										&nbsp;&nbsp;&nbsp;
										<small><a href="javascript:right_load(1, 'site_info_div');"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
										&nbsp;&nbsp;&nbsp;
										<span id='misc_progress' style='display:none'>
											<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
										</span>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<span id='misc_errormsg' class='clean-error' style='display:none' >
										</span>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										
									</td>
								</tr>
							</tbody>
						</table>
					</form>			
				</div>
				
				<div class='right_pane' id='report_config_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_REPORTCONFIG']; ?></b>
					<br><br>
					<div id='report_config_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<form id='report_config_form' name='report_config_form' action='' method='post'>
						<?php echo LangUtil::$generalTerms['REPORT_TYPE']; ?>
						&nbsp;&nbsp;
						<select name='report_type' id='report_type11'>
							<option value='1'><?php echo $LANG_ARRAY['reports']['MENU_PATIENT']; ?></option>
							<?php
							if($SHOW_SPECIMEN_REPORT === true)
							{
								?>
								<option value='2'><?php echo $LANG_ARRAY['reports']['MENU_SPECIMEN']; ?></option>
								<?php
							}
							if($SHOW_TESTRECORD_REPORT === true)
							{
								?>
								<option value='3'><?php echo $LANG_ARRAY['reports']['MENU_TESTRECORDS']; ?></option>
								<?php
							}
							?>
							<option value='4'><?php echo $LANG_ARRAY['reports']['MENU_DAILYLOGS']."-".LangUtil::$generalTerms['SPECIMENS']; ?></option>
							<option value='6'><?php echo $LANG_ARRAY['reports']['MENU_DAILYLOGS']."-".LangUtil::$generalTerms['PATIENTS']; ?></option>
						</select>
						&nbsp;&nbsp;
						<input type='button' id='report_config_button' value="<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>" onclick="javascript:fetch_report_config();"></input>
						&nbsp;&nbsp;
						<span id='report_config_fetch_progress' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
						</span>
						<br><br>
						<div id='report_config_content'>
						</div>
					</form>	
				</div>
				
				<div class='right_pane' id='worksheet_config_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_WORKSHEETCONFIG']; ?></b>
					<br><br>
					<div id='worksheet_config_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<form id='worksheet_config_form' name='worksheet_config_form' action='ajax/report_config_update.php' method='post'>
						<table>
							<tbody>
								<tr valign='top'>
									<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></td>
									<td>
										<select name='cat_code' id='cat_code12' class='uniform_width'>
											<option value="0"><?php echo LangUtil::$generalTerms['ALL']; ?></option>
											<?php $page_elems->getTestCategorySelect(); ?>
										</select>
									</td>
								</tr>
								<tr valign='top'>
									<td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
									<td>
										<select id='test_type12' name='t_type' class='uniform_width'>
											<?php $page_elems->getTestTypesSelect($lab_config->id); ?>
										</select>
									</td>
							</tr>
							<tr valign='top'>
								<td></td>
								<td>
									<input type='button' onclick='javascript:fetch_worksheet_config();' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>'></input>
									&nbsp;&nbsp;&nbsp;
									<span id='worksheet_fetch_progress' style='display:none'>
										<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
									</span>
								</td>
							</tr>
						</table>
					</form>
					<br>
					<div id='worksheet_config_content'>
					</div>
					<br>
					<?php echo LangUtil::$pageTerms['CUSTOM_WORKSHEETS']; ?>
					<?php $page_elems->getCustomWorksheetTable($lab_config); ?>
					<br>
					<small><a href='worksheet_custom_new.php?id=<?php echo $lab_config->id; ?>'><?php echo LangUtil::$pageTerms['NEW_CUSTOMWORKSHEET']; ?> &raquo;</a></small>
				</div>
				
				<div class='right_pane' id='backup_revert_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_BACKUP_REVERT']; ?></b>
					<br><br>
					<div id='backup_revert_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<form id='backup_revert_form' name='backup_revert_form' action='data_backup_revert.php' method='post'>
						<input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
						<table>
							<tbody>
								<tr valign='top'>
									<td><?php echo LangUtil::$pageTerms['BACKUP_LOCATION']; ?></td>
									<td>
										<?php $page_elems->getBackupRevertRadio("backup_path", $lab_config->id); ?>
									</td>
								</tr>
								<tr valign='top'>
									<td><?php echo LangUtil::$pageTerms['INCLUDE_LANGUAGE_SETTINGS']; ?>?</td>
									<td>
										<input type='radio' name='do_lang' id='do_lang' value='Y'><?php echo LangUtil::$generalTerms['YES']; ?></input>
										<input type='radio' name='do_lang' value='N' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</td>
								</tr>
								<tr valign='top'>
									<td><?php echo LangUtil::$pageTerms['BACKUP_CURRENT_VERSION']; ?></td>
									<td>
										<input type='radio' name='do_currbackup' id='do_currbackup' value='Y' checked><?php echo LangUtil::$generalTerms['YES']; ?></input>
										<input type='radio' name='do_currbackup' value='N'><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</td>
								</tr>
								<tr valign='top'>
									<td></td>
									<td>
										<input type='button' onclick='javascript:backup_revert_submit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
										&nbsp;&nbsp;&nbsp;
										<span id='backup_revert_progress' style='display:none'>
											<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
										</span>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
					<br><br>
					<div class='clean-orange' id='revert_done_msg' style='width:300px' style='display:none;'>
						<?php echo LangUtil::$pageTerms['TIPS_REVERTDONE']; ?>
					</div>
				</div>
			</td>
		</tr>
	</tbody>
</table>


<div id='new_help' style='display:none'>
<small>
<u>Add New</u> lets you add new registration fileds as required for the lab.
</small>
</div>

<?php include("includes/footer.php"); ?>