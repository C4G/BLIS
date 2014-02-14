<?php
#
# Main page for verifying results for a particular test type
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("results_entry");

$script_elems->enableDatePicker();
$script_elems->enablePageloadIndicator();
# Helper functions
# TODO: Move them to another library
function get_unverified_tests($test_type_id)
{
	# Fetches all unverified test results
	$query_string = 
		"SELECT * FROM test ".
		"WHERE verified_by=0 ".
		"AND result <> '' ".
		"AND test_type_id=$test_type_id";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$test_entry = Test::getObject($record);
		$retval[] = $test_entry;
	}
	return $retval;
}

# Execution begins here
$script_elems->enableTableSorter();
$script_elems->enableJQueryForm();
/* $curr_user_id = $_SESSION['user_id'];
$test_type_id = $_REQUEST['t_type']; */

$specimen_id = $_REQUEST['specimen_id'];
$test_id = $_REQUEST['test_id'];




//$test_type = TestType::getById($test_type_id);
# Fetch all measures for this test type
//$measure_list = $test_type->getMeasures();
//$test_list = get_unverified_tests($test_type_id);
?>
<script type='text/javascript'>

function toggle_form(form_id, checkbox_obj)
{
	if(checkbox_obj.checked == true)
	{
		$('#'+form_id+' :input').attr('disabled', 'disabled');
		checkbox_obj.disabled=false;
	}
	else
	{
		$('#'+form_id+' :input').removeAttr('disabled');
		checkbox_obj.disabled=false;
	}
}


function show_dialog_box()
{
	$('#confirm_dialog').show();
	$('#confirm_dialog').focus();
}

function hide_dialog_box()
{
	$('#confirm_dialog').hide();
}

function submit_forms(specimen_id)
{
	var form_id_csv = $('#form_id_list').attr("value");
	if(form_id_csv === '' || form_id_csv === null || form_id_csv === undefined )
	{
		alert("Form Empty "+form_id_csv);
		$('.result_progress_spinner').hide();
		return;
	}
	var form_id_list = form_id_csv.split(",");
	//$('.result_cancel_link').hide();
	$('.result_progress_spinner').show();
	//var target_div_id = "fetched_specimen";
	var target_div_id = "result_form_pane_"+specimen_id;
	for(var i = 0; i < form_id_list.length; i++)
	{
		if($('#'+form_id_list[i]+'_skip').is(':checked'))
		{
			continue;
		}
		var params = $('#'+form_id_list[i]).formSerialize();
		
		 $.ajax({
			type: "POST",
			url: "ajax/result_add.php",
			data: params,
			success: function(msg) {
				$("#"+target_div_id).html(msg);
			}
		}); 
	}
	$('.result_progress_spinner').hide();
}

$(document).ready(function(){

var pg=2;
	//$('#fetch_progress_bar').show();
	var url = 'ajax/specimen_form_fetch.php';
	$('.result_form_pane').html("");
	//alert("in doc ready");
	var specimen_id = <?php echo $specimen_id;?>;
	var target_div = "result_form_pane_"+<?php echo $specimen_id;?>;
	$("#"+target_div).load(url, 
		{sid: specimen_id , page_id:pg, test_id:<?php echo $test_id;?>}, 
		function() 
		{
			//alert("Fetched specimen with id "+<?php echo $specimen_id;?>);
			//$('#fetch_progress_bar').hide();
			//$("#fetched_specimen").show();
		}
	);
});

</script>
<br>
<b><?php echo LangUtil::$pageTerms['RELATED_RESULTS']; ?></b> |
 <a href='results_entry.php' id='cancel_link'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<!-- copied from result_add.php -->
 
<div id="result_form_pane_<?php echo $specimen_id;?>" class="result_form_pane_<?php echo $specimen_id;?>"></div> 
 
<?php include("includes/footer.php"); ?>