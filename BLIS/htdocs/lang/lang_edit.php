<?php
#
# Main page for editing an existing locale's strings/terms
#

//include("redirect.php");
//include("includes/header.php");


LangUtil::setPageId("lang_modify");

//$locale = $_REQUEST['locale'];
//$lab_config_id = $_REQUEST['id'];
$user = get_user_by_id($_SESSION['user_id']);

if($locale === "default")
{
	if(is_super_admin($user) || is_country_dir($user))
	{
		//Do nothing
	}
	else
		$locale = "en";
}

$LANGDATA_PATH = $LOCAL_PATH."langdata_revamp/";
if($SERVER == $ON_PORTABLE)
{
	$LANGDATA_PATH = $LOCAL_PATH."langdata_".$lab_config_id."/";;
}


$script_elems->enableJQueryForm();
//$script_elems->enableAutogrowTextarea();
function get_locale_page_select()
{
	global $DEFAULT_LANG, $LANGDATA_PATH;
	$default_lang_pages = simplexml_load_file($LANGDATA_PATH.$DEFAULT_LANG.".xml");
	/*$utf_encoded_content = utf8_encode(file_get_contents($LANGDATA_PATH.$DEFAULT_LANG.".xml"));
	$default_lang_pages = simplexml_load_string($utf_encoded_content);*/
	foreach($default_lang_pages as $default_lang_page)
	{
		$page_id = $default_lang_page['id'];
		$page_descr = $default_lang_page['descr'];
		echo "<option value='$page_id'>$page_descr</option>";
	}
	# Catalog options
	if($CATALOG_TRANSLATION === true)
	{
		echo "<option value='_test'>Test Names</option>";
		echo "<option value='_specimen'>Specimen Names</option>";
		echo "<option value='_measure'>Measure Names</option>";
		echo "<option value='_section'>Lab Section Names</option>";
	}
}

function get_edit_locale_form($lang_code, $lab_config_id)
{
	global $DEFAULT_LANG, $page_elems, $LANGDATA_PATH;
	$default_lang_pages = simplexml_load_file($LANGDATA_PATH."default.xml");
	$target_lang_pages = simplexml_load_file($LANGDATA_PATH.$lang_code.".xml");
	/*
	$utf_encoded_content = utf8_encode(file_get_contents($LANGDATA_PATH."default.xml"));
	$default_lang_pages = simplexml_load_string($utf_encoded_content);
	$utf_encoded_content = utf8_encode(file_get_contents($LANGDATA_PATH.$lang_code.".xml"));
	$target_lang_pages = simplexml_load_string($utf_encoded_content);
	*/
	$default_pages_list = array();
	$target_pages_list = array();
	foreach($default_lang_pages as $default_lang_page)
	{
		$default_pages_list[] = $default_lang_page;
	}
	foreach($target_lang_pages as $target_lang_page)
	{
		$target_pages_list[] = $target_lang_page;
	}
	# Test Catalog pages
	$default_catalog_pages = simplexml_load_file($LANGDATA_PATH."default_catalog.xml");
	$target_catalog_pages = simplexml_load_file($LANGDATA_PATH.$lang_code."_catalog.xml");
	$default_catalog_list = array();
	$target_catalog_list = array();
	foreach($default_catalog_pages as $default_catalog_page)
	{
		$default_catalog_list[] = $default_catalog_page;
	}
	foreach($target_catalog_pages as $target_catalog_page)
	{
		$target_catalog_list[] = $target_catalog_page;
	}
	for($i = 0; $i < count($default_pages_list);$i++)
	{
		$page_id = $default_pages_list[$i]['id'];
		$page_descr = $default_pages_list[$i]['descr'];
		echo "<div id='div_".$page_id."' class='page_form_div' style='display:none;'>";
		echo "<form id='form_".$page_id."' name='form_".$page_id."' action='lang_update' method='post'>";
		echo "<input type='hidden' name='lab_config_id' value='$lab_config_id'></input>";
		echo "<input type='hidden' name='page_id' value='$page_id'></input>";
		echo "<input type='hidden' name='lang_id' value='$lang_code'></input>";
		$default_terms = $default_pages_list[$i]->term;
		$target_terms = $target_pages_list[$i]->term;
		$default_terms_list = array();
		$target_terms_list = array();
		echo "<table class='hor-minimalist-b' style='width:800px;'>";
		echo "<thead>";
		echo "<tr valign='top'>";
		echo "<th><b>";
		echo "Default";
		echo "</b></th>";
		echo "<th><b>";
		if($lang_code === "en")
			echo "English";
		else if($lang_code === "fr")
			echo "Francais";
		echo "</b></th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach($default_terms as $default_term)
		{
			$default_terms_list[] = $default_term;
		}
		foreach($target_terms as $target_term)
		{
			$target_terms_list[] = $target_term;
		}
		for($j = 0; $j < count($default_terms_list); $j++)
		{
			$default_term = $default_terms_list[$j];
			$target_term = $target_terms_list[$j];
			if(trim($default_term->value) == "")
				continue;
			echo "<tr valign='top'>";
			echo "<td title='$default_term->key'> $default_term->value </td>";
			if(strpos($default_term->key, "TIPS_") !== false)
				echo "<td> <textarea class='no_specialchar uniform_width_more' name='$default_term->key' style='height:80px;'>$target_term->value</textarea> </td>";
			else
				echo "<td> <input class='no_specialchar uniform_width_more' type='text' name='$default_term->key' value='$target_term->value'></input></td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td></td>";
		echo "<td>";
		echo "<input type='button' onclick=\"javascript:submit_page_form('form_".$page_id."');\" value='".LangUtil::$generalTerms['CMD_SUBMIT']."'></input>";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<a href=\"javascript:hide_page_forms('form_".$page_id."');\">".LangUtil::$generalTerms['CMD_CANCEL']."</a>";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<span class='submit_page_progress' style='display:none'>";
		$page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']);
		echo "</span>";
		echo "</td>";
		echo "</tr>";
		echo "</tbody></table>";
		echo "</form></div>";
	}
	# Catalog translation forms
	for($i = 0; $i < count($default_catalog_list);$i++)
	{
		$page_id = $default_catalog_list[$i]['id'];
		$page_descr = $default_catalog_list[$i]['descr'];
		echo "<div id='div_catalog_".$page_id."' class='page_form_div' style='display:none;'>";
		echo "<form id='form_catalog_".$page_id."' name='form_catalog_".$page_id."' action='lang_catalog_update' method='post'>";
		echo "<input type='hidden' name='page_id' value='$page_id'></input>";
		echo "<input type='hidden' name='lang_id' value='$lang_code'></input>";
		$default_terms = $default_catalog_list[$i]->term;
		$target_terms = $target_catalog_list[$i]->term;
		$default_terms_list = array();
		$target_terms_list = array();
		echo "<table class='hor-minimalist-b' style='width:800px;'>";
		echo "<thead>";
		echo "<tr valign='top'>";
		echo "<th><b>";
		echo "Default";
		echo "</b></th>";
		echo "<th><b>";
		if($lang_code === "en")
			echo "English";
		else if($lang_code === "fr")
			echo "Francais";
		echo "</b></th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach($default_terms as $default_term)
		{
			$default_terms_list[] = $default_term;
		}
		foreach($target_terms as $target_term)
		{
			$target_terms_list[] = $target_term;
		}
		for($j = 0; $j < count($default_terms_list); $j++)
		{
			$default_term = $default_terms_list[$j];
			$target_term = $target_terms_list[$j];
			if(trim($default_term->value) == "")
				continue;
			echo "<tr valign='top'>";
			echo "<td title='$default_term->key'> $default_term->value </td>";
			if(strpos($default_term->key, "TIPS_") !== false)
				echo "<td> <textarea class='no_specialchar uniform_width_more' name='$default_term->key' style='height:80px;'>".htmlspecialchars_decode($target_term->value)."</textarea> </td>";
			else
				echo "<td> <input class='no_specialchar uniform_width_more' type='text' name='$default_term->key' value='".htmlspecialchars_decode($target_term->value)."'></input></td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td></td>";
		echo "<td>";
		echo "<input type='button' onclick=\"javascript:submit_page_form('form_catalog_".$page_id."');\" value='".LangUtil::$generalTerms['CMD_SUBMIT']."'></input>";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<a href=\"javascript:hide_page_forms('form_".$page_id."');\">".LangUtil::$generalTerms['CMD_CANCEL']."</a>";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<span class='submit_page_progress' style='display:none'>";
		$page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']);
		echo "</span>";
		echo "</td>";
		echo "</tr>";
		echo "</tbody></table>";
		echo "</form></div>";
	}
}
?>
<script type='text/javascript'>
$(document).ready(function() {
	$('#cat_button').click(function() {fetch_page_form();} );
	<?php
	if(isset($_REQUEST['upd']))
	{
		?>
		$('#server_msg').show();
		<?php
	}
	if(isset($_REQUEST['p']))
	{
		?>
		var page_id = $('#page_id').attr("value", "<?php echo $_REQUEST['p']; ?>");
		fetch_page_form();
		<?php
	}
	?>
	$('.no_specialchar').blur(function() { check_specialchar_alert(this); } );
});

function fetch_page_form()
{
	$('#server_msg').hide();
	$('#page_fetch_progress').show();
	var page_id = $('#page_id').attr("value");
	var locale_id = $('#lang_id').attr("value");
	var lab_config_id = <?php echo $lab_config_id ?>;
	if(page_id == "")
	{
		$('#page_fetch_progress').hide();
		return;
	}
	if(locale_id != "<?php echo $locale; ?>")
	{	
		if( locale_id == 'fr' )
			var url_string = "lab_config_home.php?id="+lab_config_id+"&set_locale&locale=fr";
		else
			var url_string = "lab_config_home.php?id="+lab_config_id+"&set_locale&locale=en";
		window.location=url_string;
	}
	$('.page_form_div').hide();
	if(page_id.startsWith('_'))
	{
		$('#div_catalog'+page_id).show();
	}
	else
	{
		$('#div_'+page_id).show();
	}
	$('#page_fetch_progress').hide();
}

function submit_page_form(form_id)
{
	var text_list = $('.no_specialchar');
	for(var i = 0; i < text_list.length; i++)
	{
		//if(check_specialchar(text_list[i]) == true)
		if(false)
		{
			alert("Special characters ' \" < > are not allowed as input for translation");
			text_list[i].focus();
			return;
		}
	}
	$('.submit_page_progress').show();
	var locale_id = $('#lang_id').attr("value");
	$('#'+form_id).ajaxSubmit({
		success: function() {
			$('.submit_page_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $_REQUEST['id']; ?>&langupd";
		}
	});
}

function hide_page_forms(source_form_id)
{
	$('#'+source_form_id).resetForm();
	$('.page_form_div').hide();
	$('#page_id').attr("value", "");
	$('#server_msg').hide();
}

function check_specialchar_alert(elem)
{
	var hasSpecialChar = check_specialchar(elem);
	if(hasSpecialChar == true)
	//if(false)
	{
		alert ("Special characters ' \" < > are not allowed as input for translation");
		elem.focus();
	}
}
function check_specialchar(elem)
{
	//var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?~_"; 
	var iChars = "'\"<>"; 
	var textval = elem.value;
	for (var i = 0; i < textval.length; i++) 
	{
		if (iChars.indexOf(textval.charAt(i)) != -1) 
		{
			return true;
		}
	}
	return false;
}
</script>
<p style="text-align: right;"><a rel='facebox' href='#ModLang'>Page Help</a></p><br/>
<?php
/*<a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>|*/
?>
<b><?php echo LangUtil::getTitle(); ?></b>
<br><br>
<table>
	<tbody>
	<tr>
		<td>
			Language
			&nbsp;&nbsp;
			<select name='lang_id' id='lang_id'>
				<option value='en' <?php if($locale == "en") echo " selected "; ?>>English</option>
				<option value='fr' <?php if($locale == "fr") echo " selected "; ?>>Francais</option>
				<?php
				//if(is_super_admin($user) || is_country_dir($user))
				if(false)
				{
					?>
					<option value='default'>Default</option>
					<?php
				}
				?>
			</select>
			&nbsp;&nbsp;&nbsp;
			<?php echo LangUtil::$pageTerms['CATEGORY']; ?>
			&nbsp;&nbsp;
			<select name='page_id' id='page_id'>
				<option value=''><?php echo LangUtil::$generalTerms['CMD_SELECT']; ?> ..</option>
				<?php get_locale_page_select(); ?>
			</select>
			&nbsp;&nbsp;&nbsp;
			<input type='button' id='cat_button' value="<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>"> </input>
			&nbsp;&nbsp;&nbsp;
			<span id='page_fetch_progress' style='display:none'>
				<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
			</span>
		</td>
	</tr>
	</tbody>
</table>
<br><br>

<div id='ModLang' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
		<li><?php echo LangUtil::$pageTerms['TIPS_MODIFYLANG_1']; ?></li>
		<li><?php echo LangUtil::$pageTerms['TIPS_MODIFYLANG_2']; ?></li>
	</ul>
	</div>
	
	

<div class='sidetip_nopos' id='server_msg' style='display:none'>
	<?php # echo LangUtil::$pageTerms['MSG_LANGUPDATED']; ?>
</div>
<?php get_edit_locale_form($locale, $lab_config_id); ?>
<?php /*include("includes/footer.php");*/ ?>