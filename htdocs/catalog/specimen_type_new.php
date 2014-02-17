<?php
#
# Main page for adding new specimen type
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("catalog");
$script_elems->enableLatencyRecord();
?>
<script type='text/javascript'>
function check_input()
{
	// Validate
	var specimen_name = $('#specimen_name').attr("value");
	if(specimen_name == "")
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
		//alert("Error: No tests selected");
		//return;
	}

	var check_url = "ajax/specimen_name_check.php?specimen_name="+specimen_name;
	$.ajax({ url: check_url, async : false, success: function(response){			
			if(response == "1")		
			{	
				alert("Spacemen :"+specimen_name + " already exist");				
			}
			else
			{
					// All OK
					$('#new_specimen_form').submit();
			}
	}
	});
	
	
}

</script>
<br>
<b><?php echo LangUtil::$pageTerms['NEW_SPECIMEN_TYPE']; ?></b>
| <a href='catalog.php?show_s=1'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<div class='pretty_box'>
<form name='new_specimen_form' id='new_specimen_form' action='specimen_type_add.php' method='post'>
<table class='smaller_font'>
<tr>
<td style='width:150px;'><?php echo LangUtil::$generalTerms['NAME']; ?><?php $page_elems->getAsterisk(); ?></td>
<td><input type='text' name='specimen_name' id='specimen_name' class='uniform_width' /></td>
</tr>
<tr valign='top'>
<td><?php echo LangUtil::$generalTerms['DESCRIPTION']; ?></td>
<td><textarea name='specimen_descr' id='specimen_descr' class='uniform_width'></textarea></td>
</tr>
<tr valign='top'>
<td>
<?php echo LangUtil::$generalTerms['COMPATIBLE_TESTS']; ?> <?php $page_elems->getAsterisk(); ?>[<a href='#test_help' rel='facebox'>?</a>]
</td>
<td>
<?php $page_elems->getTestTypeCheckboxes(); ?>
<br><br>
<input type='button' onclick='check_input();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' />
&nbsp;&nbsp;&nbsp;&nbsp;
<a href='catalog.php?show_s=1'> <?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
</form>
</div>
<div id='test_help' style='display:none'>
<small>
Use Ctrl+F to search easily through the list. Ctrl+F will prompt a box where you can enter the test name you are looking for.
</small>
</div>
<?php include("includes/footer.php"); ?>