<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for associating a global country test name with local laboratories test names
#

include("../users/accesslist.php");
if( !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	&& !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) )
	header( 'Location: home.php' );

include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("countrycatalog");

$script_elems->enableTableSorter();
?>

<script type="text/javascript">
$(document).ready(function(){
	<?php
	if( isset($_REQUEST['show_t'])) {
		?>
		load_right_pane('test_types_div');
		<?php
	}
	else if( isset($_REQUEST['show_s'])) {
		?>
		load_right_pane('specimen_types_div');
		<?php
	}
	else if( isset($_REQUEST['show_tc'])) { 
		?>
		load_right_pane('test_category_types_div');
		<?php
	}
	else if( isset($_REQUEST['show_m'])) {
		?>
		load_right_pane('measures_div');
		<?php
	}
        else if( isset($_REQUEST['show_mc'])) {
		?>
		load_right_pane('master_catalog_div');
		<?php
	}
        else {
		?>
		load_right_pane('test_types_div');
		<?php
	}
	?>
});

function submitTestNames() {
	var count = <?php echo count(get_lab_configs_imported()); ?>;
	if( $('#commonTestName').val() == "") {
		$('#commonTestNameError').show();
		return;
	}
	$('#progress_spinner').show();
	var dataString = "testName="+$('#commonTestName').val();
	dataString += "&labIdTestId=";
	for( var i=1; i<=count; i++) {
		value = $('#testNameSelect'+i).val();
		dataString += value+";";
	}
	/*
	$('testNameSelect > option:selected').each(function() {
		dataString += $(this).val()+";";
	});
	*/
	dataString = dataString.substring(0, dataString.length-1);
	$('#commonTestNameError').hide();
	$.ajax({
		type: "POST",
		url: "ajax/add_country_level_tests.php",
		data: dataString,
		success: function(data) {
			$('#progress_test_spinner').hide();
			window.location = "country_catalog.php?show_t";
		}
	});
}

function submitTestCategoryNames() {
var count = <?php echo count(get_lab_configs_imported()); ?>;
	if( $('#commonTestCategoryName').val() == "") {
		$('#commonTestCategoryNameError').show();
		return;
	}
	$('#progress_tc_spinner').show();
	var dataString = "testCategoryName="+$('#commonTestCategoryName').val();
	dataString += "&labIdTestCategoryId=";
	for( var i=1; i<=count; i++) {
		value = $('#testCategoryNameSelect'+i).val();
		dataString += value+";";
	}
	dataString = dataString.substring(0, dataString.length-1);
	$('#commonTestNameError').hide();
	$.ajax({
		type: "POST",
		url: "ajax/add_country_level_test_categories.php",
		data: dataString,
		success: function(data) {
			$('#progress_tc_spinner').hide();
			window.location = "country_catalog.php?show_tc";
		}
	});
}

function submitSpecimenNames() {
	var count = <?php echo count(get_site_list($_SESSION['user_id'])); ?>;
	if( $('#commonSpecimenName').val() == "") {
		$('#commonSpecimenNameError').show();
		return;
	}
	$('#progress_spinner').show();
	var dataString = "specimenName="+$('#commonSpecimenName').val();
	dataString += "&labIdSpecimenId=";
	for( var i=1; i<=count; i++) {
		value = $('#specimenNameSelect'+i).val();
		dataString += value+";";
	}
	/*
	$('specimenNameSelect > option:selected').each(function() {
		dataString += $(this).val()+";";
	});
	*/
	dataString = dataString.substring(0, dataString.length-1);
	$('#commonSpecimenNameError').hide();
	$.ajax({
		type: "POST",
		url: "ajax/add_country_level_specimens.php",
		data: dataString,
		success: function(data) {
			$('#progress_specimen_spinner').hide();
			window.location = "country_catalog.php?show_s";
		}
	});
}

function submitMeasureNames() {
	var count = <?php echo count(get_site_list($_SESSION['user_id'])); ?>;
	if( $('#commonMeasureName').val() == "") {
		$('#commonMeasureNameError').show();
		return;
	}
	$('#progress_spinner').show();
	var dataString = "measureName="+$('#commonMeasureName').val();
	dataString += "&labIdMeasureId=";
	for( var i=1; i<=count; i++) {
		value = $('#measureNameSelect'+i).val();
		dataString += value+";";
	}
	dataString = dataString.substring(0, dataString.length-1);
	$('#commonMeasureNameError').hide();
	$.ajax({
		type: "POST",
		url: "ajax/add_country_level_measures.php",
		data: dataString,
		success: function(data) {
			$('#progress_specimen_spinner').hide();
			window.location = "country_catalog.php?show_m";
		}
	});
}

function load_right_pane(div_id)
{
	$('#rm_msg').hide();
	$('div.content_div').hide();
	$('#'+div_id).show();
	$('.menu_option').removeClass('current_menu_option');
	$('#'+div_id+'_menu').addClass('current_menu_option');
}

function hide_right_pane()
{
	$('div.content_div').hide();
	$('.menu_option').removeClass('current_menu_option');
}

</script>
<table cellpadding='10px'>
<tr valign='top'>
<td id='left_pane' class='left_menu' width='150'>
    
<a href="javascript:load_right_pane('test_types_div');" class='menu_option' id='test_types_div_menu'>
	<?php echo LangUtil::$generalTerms['TEST_TYPES']; ?>
</a>
<br><br>
<a href="javascript:load_right_pane('test_category_types_div');" class='menu_option' id='test_category_types_div_menu'>
	<?php echo LangUtil::$generalTerms['LAB_SECTION']; ?>
</a>
<br><br>

</td>
<td id='right_pane'>
	<div id='test_types_div' class='content_div' style='display:none;'>
		<form id="testNamesSelector">
		<?php $page_elems->getTestNamesSelector(); ?>
		<span id='progress_test_spinner' style='display:none'><?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?></span>
		</td>
		</tr>
		</table>
		</form>
		<hr>
		<br>
		<div id='global_test_types_div'>
			<b>Currently Added Country Wide Tests</b><br><br>
			<?php $page_elems->getTestTypesCountryLevel(); ?>
		</div>
	</div>
	
	
	
	<div id='test_category_types_div' class='content_div' style='display:none;'>
		<form id="testCategoryNamesSelector">
		<?php $page_elems->getTestCategoryNamesSelector(); ?>
		<span id='progress_tc_spinner' style='display:none'><?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?></span>
		</td>
		</tr>
		</table>
		</form>
		<hr>
		<br>
		<div id='global_test_category_types_div'>
			<b>Currently Added Country Wide Specimen</b><br><br>
			<?php $page_elems->getTestCategoryTypesCountryLevel(); ?>
		</div>
	</div>
	
	
</td>
</tr>
</table>
<br>
<?php include("includes/footer.php"); ?>