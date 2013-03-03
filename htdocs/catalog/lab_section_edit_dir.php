<?php
#
#
# Main page for modifying an existing test type
#
include("redirect.php");
include("includes/header.php");
include("includes/ajax_lib.php");
LangUtil::setPageId("catalog");

$script_elems->enableJQueryForm();
$script_elems->enableTokenInput();

?>
<script type="text/javascript">

function toggle_div(arg)
{
    if(arg == '0')
    {
        $("#commonTestNameFixed").hide();
        $("#commonTestNameEdit").hide()
        $("#commonTestName").show();
    }
    else
    {
        var fixed_div = "labTestNameFixed"+arg;
        var normal_div = "labTestName"+arg;
        var edit_div = "labTestNameEdit"+arg;
        $("#"+fixed_div).hide();
        $("#"+edit_div).hide()
        $("#"+normal_div).show();
    }
}

function submitTestCategoryNames() {
var count = <?php echo count(get_lab_configs_imported()); ?>;
	if( $('#commonTestName').val() == "") {
		$('#commonTestNameError').show();
		return;
	}
	$('#progress_tc_spinner').show();
         var dataString = "country_test_id="+$('#country_test_id').val()+"&";
	 dataString += "testCategoryName="+$('#commonTestName').val();
	dataString += "&labIdTestCategoryId=";
	for( var i=1; i<=count; i++) {
		value = $('#testNameSelect'+i).val();
		dataString += value+";";
	}
                var reloadLoc = "lab_section_edit_dir.php?tid="+$('#country_test_id').val()+"&st=true";

	dataString = dataString.substring(0, dataString.length-1);
	$('#commonTestNameError').hide();
	$.ajax({
		type: "POST",
		url: "ajax/update_country_level_section.php",
		data: dataString,
		success: function(data) {
			//$('#progress_tc_spinner').hide();
			window.location = reloadLoc;
		}
	});
}


function submitTestNames() {
	var count = <?php echo count(get_lab_configs_imported()); ?>;
	if( $('#commonTestName').val() == "") {
		$('#commonTestNameError').show();
		return;
	}
	$('#progress_spinner').show();
        var dataString = "country_test_id="+$('#country_test_id').val()+"&";
	dataString += "testName="+$('#commonTestName').val();
	dataString += "&labIdTestId=";
	for( var i=1; i<=count; i++) {
		value = $('#testNameSelect'+i).val();
		dataString += value+";";
	}
        var reloadLoc = "test_type_edit_dir.php?tid="+$('#country_test_id').val()+"&st=true";
	/*
	$('testNameSelect > option:selected').each(function() {
		dataString += $(this).val()+";";
	});
	*/
	dataString = dataString.substring(0, dataString.length-1);
	$('#commonTestNameError').hide();
	$.ajax({
		type: "POST",
		url: "ajax/update_country_level_test.php",
		data: dataString,
		success: function(data) {
			//$('#progress_test_spinner').hide();
			window.location = reloadLoc;
                        //location.reload(true);
		}
	});
}
</script>
<?php
//$tips_string=LangUtil::$pageTerms['TIPS_MEASURES'];
//$tips_string = LangUtil::$pageTerms['TIPS_CATALOG'];
//$page_elems->getSideTip("Tips", $tips_string);
?>
<b><?php echo "Edit Lab Section"; ?></b>
| <a href="country_catalog.php?show_t=1"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br>

<?php 
$testTypeMapping = TestTypeMapping::getTestCatById($_REQUEST['tid'], $_SESSION['user_id']);
if($testTypeMapping == null)
{
?>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>

<?php
	include("includes/footer.php");
	return;

}
//$page_elems->getTestNamesSelectorForEdit($testTypeMapping);
# Fetch all measures currently on this test type
//$measure_list = $testTypeMapping->getMeasureIds();
# Display test type info table
//$page_elems->getTestTypeInfoAggregateDir($testTypeMapping);
//$testName = $_REQUEST['tname'];
$mapping_list = array();
$mapping_list = get_test_mapping_list_by_string($testTypeMapping['lab_id_test_category_id']);
//print_r($mapping_list);
?>
<div id='test_form_div' >
<form id="testNamesSelector">
<table class='hor-minimalist-a'>
    <tr>
    <td><b>Country Test Name:</b></td>
    <td><input type="text" id="commonTestName" class="variableData" size="50" style ="display: none;" value="<?php echo $testTypeMapping['test_category_name'];  ?>"></input>
        <div id="commonTestNameFixed" class="fixedData"> <?php echo $testTypeMapping['test_category_name']; ?></div><div id='commonTestNameError' style='display:none'>
            <label class="error" id="commonTestNameErrorLabel"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
    </div></td>
       <td> <div id="commonTestNameEdit" class="editLink"> <a onclick="toggle_div('0')">Edit</a></div></td>
    
    </tr>
    <tr><td></td></tr>
    <?php
    $count = 1;
    //$siteList = get_site_list($_SESSION['user_id']);
    $config_list = get_lab_configs_imported();
    foreach($config_list as $lab_config) {
        //print_r($mapping_list);
       // echo $mapping_list[(int)$lab_config->id].".";
            echo "<tr><td>".$lab_config->name."</td>";
            //$testTypeList = get_test_categories($lab_config->id);
            $testCategoriesList = get_test_categories2($lab_config->id);
            $stcheck = $mapping_list[$lab_config->id];
            $tname = "Unassigned";
            echo "<td><div id='labTestName".$lab_config->id."' class='variableData' style='display:none;'><select id='testNameSelect$count'>";
            
            //foreach($testTypeList as $testType) {
            foreach( $testCategoriesList as $testCategoryId => $testCategoryName ) {
                    if($testCategoryId == $stcheck)
                    {
                        $tname = $testCategoryName;
                    echo "<option value='$lab_config->id:$testCategoryId' selected>".$testCategoryName."</option>";
                    }
                    else
                    {
                        echo "<option value='$lab_config->id:$testCategoryId'>".$testCategoryName."</option>";
                    }
            }
            echo "</select></div>";
            ?>
            <div id="labTestNameFixed<?php echo $lab_config->id; ?>" class="fixedData"><?php echo $tname; ?></div>
            <?php
            echo "</td>";
            ?>
       <td> <div id="labTestNameEdit<?php echo $lab_config->id; ?>" class="editLink"> <a onclick="toggle_div('<?php echo $lab_config->id; ?>')">Edit</a></div></td>
            <?php
            echo "</tr>";
            $count++;
    }
    
    //echo "<tr><td></td><td></td>";
    echo "</tr>";
        ?>

    <tr>
    <td></td>		
    <?php if($_REQUEST['st'] == 'true') { ?>
    <td><input type="button" id="submit" type="submit" onclick="submitTestCategoryNames();" value="<?php echo LangUtil::$generalTerms['CMD_UPDATE']; ?>" size="20" /> <div id="success_message"><b><font color="green"> Update Successful </font></b></div></td>
    <?php }
    else
    { ?>
        <td><input type="button" id="submit" type="submit" onclick="submitTestCategoryNames();" value="<?php echo LangUtil::$generalTerms['CMD_UPDATE']; ?>" size="20" /></td>
    <?php } ?>
</table>
    <input type="hidden" id="country_test_id" name="country_test_id" value="<?php echo $_REQUEST['tid'] ?>" />
</form>    
</div>