<?php
#
# Main page for modifying an existing specimen type
#
include("redirect.php");
include("includes/header.php");
include("includes/ajax_lib.php");
LangUtil::setPageId("catalog");

$script_elems->enableJQueryForm();
$script_elems->enableTokenInput();
$specimen_type = get_specimen_type_by_id($_REQUEST['sid']);
?>
<script type='text/javascript'>
$(document).ready(function(){
	<?php
	$test_list = get_compatible_tests($specimen_type->specimenTypeId);
	foreach($test_list as $test_type_id)
	{
		# Mark existing compatible tests as checked
		?>
		$('#t_type_<?php echo $test_type_id; ?>').attr("checked", "checked"); 
		<?php
	}
	?>
});

function update_stype()
{
	var old_specimen_name = "<?php echo $specimen_type->getName(); ?>";	
	old_specimen_name = old_specimen_name.toLowerCase();
	if($('#name').attr("value").trim() == "")
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_SPECIMENNAME']; ?>");
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
		<?php # Disabled to allow additions of new specimens that do not YET have compatible tests entered ?>
		//alert("<?php echo LangUtil::$pageTerms['TIPS_MISSING_SELECTEDTESTS']; ?>");
		//return;
	}
	var name_valid=true;
	var specimen_name = $('#name').attr("value").toLowerCase();	
	if( specimen_name != old_specimen_name)
	{
		var check_url = "ajax/specimen_name_check.php?specimen_name="+specimen_name;
		$.ajax({ url: check_url, async : false, success: function(response){			
				if(response == "1")		
				{	
					alert("Spacemen :"+specimen_name + " already exist");
					name_valid=false;								
				}			
		}
		});
	}	
	if(name_valid)
	{
		$('#update_stype_progress').show();
		$('#edit_stype_form').ajaxSubmit({
			success: function(msg) {
				$('#update_stype_progress').hide();
				window.location="specimen_type_updated.php?sid=<?php echo $_REQUEST['sid']; ?>";
			}
		});
	}
}
</script>
<br>
<b><?php echo LangUtil::$pageTerms['EDIT_SPECIMEN_TYPE']; ?></b>
| <a href="catalog.php?show_s=1"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<?php
if($specimen_type == null)
{
?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>
<?php
	include("includes/footer.php");
	return;
}
$page_elems->getSpecimenTypeInfo($specimen_type->name, true);
?>
<br>
<br>
<div class='pretty_box'>
<form name='edit_stype_form' id='edit_stype_form' action='ajax/specimen_type_update.php' method='post'>
<input type='hidden' name='sid' id='sid' value='<?php echo $_REQUEST['sid']; ?>'></input>
	<table cellspacing='4px'>
		<tbody>
			<tr valign='top'>
				<td style='width:150px;'><?php echo LangUtil::$generalTerms['NAME']; ?><?php $page_elems->getAsterisk(); ?></td>
				<td><input type='text' name='name' id='name' value='<?php echo $specimen_type->getName(); ?>' class='uniform_width'></input></td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['DESCRIPTION']; ?></td>
				<td><textarea type='text' name='description' id='description' class='uniform_width'><?php echo trim($specimen_type->description); ?></textarea></td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['COMPATIBLE_TESTS']; ?><?php $page_elems->getAsterisk(); ?> [<a href='#test_help' rel='facebox'>?</a>] </td>
				<td>
					<?php $page_elems->getTestTypeCheckboxes(); ?>
					<br>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:update_stype();'></input>
					&nbsp;&nbsp;&nbsp;
					<a href='catalog.php?show_s=1'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
					&nbsp;&nbsp;&nbsp;
					<span id='update_stype_progress' style='display:none;'>
						<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
				</td>
			</tr>
		</tbody>
	</table>
</form>
</div>
<div id='test_help' style='display:none'>
<small>
Use Ctrl+F to search easily through the list. Ctrl+F will prompt a box where you can enter the test name you are looking for.
</small>
</div>
<?php include("includes/footer.php"); ?>