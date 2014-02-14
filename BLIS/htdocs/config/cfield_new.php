<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for editing a custom field
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) 
     && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	 && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) ) {
		displayForbiddenMessage();
}

include("redirect.php");
?>
<?php include("includes/header.php"); ?>
<?php
LangUtil::setPageId("lab_config_home");
$script_elems->enableJQueryForm();

$lab_config_id = $_REQUEST['lid'];
?>
<script type='text/javascript'>

$(document).ready(function(){
	$('#ftype').change(function() {
		checkandshowoptions();
	});
	checkandshowoptions();
	$("#control_7").multiSelect({ oneOrMoreSelected: '*' });
});

function checkandshowoptions()
{
	var ftype = $('#ftype').attr("value");
	if(ftype == <?php echo CustomField::$FIELD_OPTIONS; ?> || ftype == <?php echo CustomField::$FIELD_MULTISELECT; ?>)
	{
		$('#options_row').show();
	}
	else
	{
		$('#options_row').hide();
	}
	if(ftype == <?php echo CustomField::$FIELD_NUMERIC; ?>)
	{
		$('#range_row').show();
		$('#unit_row').show();
	}
	else
	{
		$('#range_row').hide();
		$('#unit_row').hide();
	}
}

function checkandsubmit()
{
	//Validate
	$('#err_msg').hide();
	var fieldname = $('#fname').attr("value");
	var fieldtype = $('#ftype').attr("value");
	if(fieldname.trim() == "")
	{
		var err_string = "<?php echo LangUtil::$generalTerms['ERROR']; ?>: <?php echo LangUtil::$generalTerms['NAME']; ?>";
		$('#err_msg').html(err_string);
		$('#err_msg').show();
		return;
	}
	else if( fieldtype == <?php echo CustomField::$FIELD_MULTISELECT; ?> )
	{
		var options = $("input[name='option[]']");
		var optionsvalid = false;
		for(var i=0; i < options.length; i++)
		{
			var val = options[i].value;
			if(val.trim() != "")
			{
				optionsvalid = true;
				break;
			}
		}
		if(optionsvalid == false)
		{
			var err_string = "<?php echo LangUtil::$generalTerms['ERROR']; ?>: <?php echo LangUtil::$generalTerms['OPTIONS']; ?>";
			$('#err_msg').html(err_string);
			$('#err_msg').show();
			return;
		}
	}
	else if( fieldtype == <?php echo CustomField::$FIELD_OPTIONS; ?> )
	{
		var options = $("input[name='option[]']");
		var optionsvalid = false;
		var optionsValueLength = 0;
		for(var i=0; i < options.length; i++)
		{
			var val = options[i].value;
			optionsValueLength += val.length;
			if(	optionsValueLength > 100 ) {
				var err_string = "<?php echo LangUtil::$generalTerms['ERROR']; ?>: Length of DropDown options exceeded ";
				$('#err_msg').html(err_string);
				$('#err_msg').show();
				return;
			}
			if(val.trim() != "")
				optionsvalid = true;
			else {
				optionsvalid = false;
				break;
			}
		}
		if(optionsvalid == false)
		{
			var err_string = "<?php echo LangUtil::$generalTerms['ERROR']; ?>: <?php echo LangUtil::$generalTerms['OPTIONS']; ?>";
			$('#err_msg').html(err_string);
			$('#err_msg').show();
			return;
		}
	}
	else if(fieldtype == <?php echo CustomField::$FIELD_NUMERIC; ?>)
	{
		var range_lower = $('#range_lower').attr("value");
		var range_upper = $('#range_upper').attr("value");
		if
		(
			(range_lower.trim() == "" || range_upper.trim() == "") ||
			(isNaN(range_lower) || isNaN(range_upper))
		)	
		{
			var err_string = "<?php echo LangUtil::$generalTerms['ERROR']; ?>: <?php echo LangUtil::$generalTerms['RANGE']; ?>";
			$('#err_msg').html(err_string);
			$('#err_msg').show();
			return;
		}
		/*
		//Uncomment the following line only if units are mandatory
		var unit = $('#unit').attr("value");
		if(unit.trim() == "")
		{
			var err_string = "<?php echo LangUtil::$generalTerms['ERROR']; ?>: <?php echo LangUtil::$generalTerms['UNIT']; ?>";
			$('#err_msg').html(err_string);
			$('#err_msg').show();
			return;
		}
		*/
	}
	$('#cfield_progress_spinner').show();
	$('#cfield_new_form').ajaxSubmit({success:function(){ 
			$('#cfield_progress_spinner').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_f=1&fadd=1";
		}
	});
}

function appendoption()
{
	var html_string = "<input name='option[]' value='' class='uniform_width'></input><br>";
	$('#options_list').append(html_string);
}
</script>
<br>
<b><?php echo LangUtil::$pageTerms['NEW_CUSTOMFIELD']; ?></b>
 | <a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_f=1'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<form name='cfield_new_form' id='cfield_new_form' action='ajax/cfield_add.php' method='post'>
<?php
$page_elems->getCustomFieldNewForm($lab_config_id);
?>
</form>
<?php include("includes/footer.php"); ?>