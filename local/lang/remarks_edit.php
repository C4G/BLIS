<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for editting result interpretation (remarks) values
# Done by lab admins on existing test measures (indicators) in lab configuration
#

include("../users/accesslist.php");

if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) &&
	!(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList) ) ) {
	displayForbiddenMessage();
}


include("redirect.php");
include("includes/header.php"); 
LangUtil::setPageId("blis_help_page");
$script_elems->enableJQueryForm();

$saved_session = SessionUtil::save();

$lab_config_id = $_REQUEST['id'];
$lab_config = LabConfig::getById($lab_config_id);
?>
<p style="text-align: right;"><a rel='facebox' href='#Tests_config'>Page Help</a></p><br/>
<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>|<b>Results Interpretation</b> 
 <br><br>
 
<div id='Tests_config' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
		<?php
		if(LangUtil::$pageTerms['TIPS_RESULTINTERPRETATION']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_RESULTINTERPRETATION'];
			echo "</li>"; 
		}
		?>
	</ul>
</div> 
<?php
if($lab_config === null)
{
	# Lab not found
	?>
	<div class='sidetip_nopos'>
		<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>
	<?php
	SessionUtil::restore($saved_session);
	include("includes/footer.php");
	return;
}
?>
<script type='text/javascript'>
function fetch_remarks_form()
{
	$('#updated_msg').hide();
	var ttype = $("#ttype").attr("value");
	$('#remarks_fetch_progress').show();
	var url_string = "ajax/remarks_form_fetch.php?lid=<?php echo $lab_config->id; ?>&ttype="+ttype;
	$('#remarks_form_pane').load( url_string, {}, function() {
		$('#remarks_fetch_progress').hide();
	});
}

function add_remarks_row(measure_id, range_type)
{
	var html_code = "";
	if(range_type == <?php echo Measure::$RANGE_NUMERIC; ?>)
	{
		html_code = "<tr><td><input type='hidden' name='id_"+measure_id+"[]' value=-2 class='uniform_width_less'></input>";
		html_code += "<input type='text' name='range_l_"+measure_id+"[]' value='' class='uniform_width_less'></input>";
		html_code += "-<input type='text' name='range_u_"+measure_id+"[]' value='' class='uniform_width_less'></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		html_code += "<input type='text' name='age_l_"+measure_id+"[]' value='' class='uniform_width_less'></input>";
		html_code += "-<input type='text' name='age_u_"+measure_id+"[]' value='' class='uniform_width_less'></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		html_code += "<input type='text' name='gender_"+measure_id+"[]' value='' size='1px'></input>";
		html_code += "<td><input type='text' name='remarks_"+measure_id+"[]' value='' class='uniform_width'></input></td></tr>";
	}
	var target_table_id = "remarks_table_"+measure_id;
	$('#'+target_table_id).append(html_code);
}

function submit_remarks_form()
{
	//Validate
	var numeric_fields = $(".numeric_range");
	for(var i = 0; i < numeric_fields.length; i++)
	{
		var elem = numeric_fields[i];
		var val = elem.value;
		if(val.trim() != "")
		{
			if(val.trim() != "+" && val.trim() != "-" && isNaN(val))
			{
				//alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['RANGE']; ?>");
				//return;
			}
		}
	}
	//All okay
	$('#remarks_submit_progress').show();
	$('#remarks_form').ajaxSubmit({ success: function() {
			$('#remarks_submit_progress').hide();
			hide_remarks_form();
			$('#updated_msg').show();
		}
	});
}

function hide_remarks_form()
{
	$('#remarks_form_pane').html("");
}
</script>
<?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>
&nbsp;&nbsp;&nbsp;
<select name='ttype' id='ttype'>
	<?php $page_elems->getTestTypesSelect($lab_config->id); ?>
</select>
&nbsp;&nbsp;&nbsp;
<input type='button' onclick='javascript:fetch_remarks_form();' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>'></input>
&nbsp;&nbsp;
<span id='remarks_fetch_progress' style='display:none;'>
	<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
</span>
&nbsp;
<span id='updated_msg' class='clean-orange' style='display:none;width:140px;'>
	<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>
</span>

<br><br>
<div id='remarks_form_pane'>
</div>
<?php
SessionUtil::restore($saved_session);
include("includes/footer.php"); 
?>