tableml = "";
unreported_fetched = false;

$(document).ready(function(){

	$('#cat_code').change( function() { get_test_types_bycat() });
	$('#worksheet_test_type').change( function() { reset_worksheet_custom_type() });

	get_test_types_bycat();

	$("#worksheet_results").hide();
	$('.results_subdiv').hide();
	$("#import_results").hide();
	$("#batch_results").hide();
	$('#resultfetch_attrib').change(function() {
		$('#specimen_id').focus();
	});

	$("input[name='is_blank']").change( function() {
		var is_blank = $("input[name='is_blank']:checked").attr("value");
		if(is_blank == "Y")
			$('#num_rows_row').show();
		else
			$('#num_rows_row').hide();
	});
});

function reset_worksheet_custom_type()
{
	$('#worksheet_custom_type').attr("value", "");
}

function toggle(elem_id)
{
	$('#'+elem_id).toggle();
}

function right_load(destn_div)
{
	hide_worksheet_link();
	$('.results_subdiv').hide();
	$("#"+destn_div).show();
	$('#specimen_id').focus();
	$('.menu_option').removeClass('current_menu_option');
	$('#'+destn_div+'_menu').addClass('current_menu_option');
	$('#'+destn_div+'_subdiv_help').show();
	if(destn_div == 'specimen_results'){
		$('#batch_results_subdiv_help').hide();
	}
	if(destn_div == "report_results")
	{
		load_unreported_results();
	}
}

function load_unreported_results()
{
	if(unreported_fetched == false)
	{
		$('#report_results_load_progress').show();
		$('#report_results_container').load("ajax/results_getunreported.php", function() {
			$('#report_results_load_progress').hide();
		});
		unreported_fetched = true;
	}
}

function checkoruncheckall()
{
	if($('#check_all').attr("checked") == true)
	{
		$(".report_flag").attr("checked", "true");
	}
	else
	{
		$(".report_flag").removeAttr("checked");
	}
}

function hide_worksheet_link()
{
	document.getElementById("worksheet_link").innerHTML = "";
}

function hide_result_form(specimen_id)
{
	var target_div_id = "result_form_pane_"+specimen_id;
	$("#"+target_div_id).html("");
	$('#specimen_id').attr("value", "");
}

function fetch_specimen()
{
	
	var labsection = document.getElementById('cat_code_labsection_specimen').value;
	
	var specimen_id = $('#specimen_id').attr("value");
	specimen_id = specimen_id.replace(/[^a-z0-9 ]/gi,'');
	$('#fetch_progress_bar').show();

	// #Used when Ajax response did not have JavaScript code included 

	var attrib = $('#resultfetch_attrib').attr("value");
	var condition_attrib = $('#h_attrib').attr("value");
	var first_char =specimen_id.charAt(0);
	if(attrib==1 && isNaN(first_char)==false)
	{
		alert("Please enter a valid name.");
		return;
	}
	var url = 'ajax/result_entry_patient_dyn.php';

	
	$("#fetched_patient_entry").load(url, 
		{a: specimen_id, t: attrib, labsec: labsection, c: condition_attrib }, 
		function() 
		{
			$('#fetch_progress_bar').hide();
			$("#fetched_specimen").show();
			$("#fetched_specimen").html("");
		}
	);
}

// EDITING
function fetch_specimen_by_lab_section()
{
	//var specimen_id = $('#specimen_id').attr("value");
	$('#fetch_progress_bar_labsection').show();
	var lab_section_id = $('#cat_code_labsection').attr("value");
	//alert(lab_section_id);
	var url = 'ajax/result_entry_patient_lab_section.php';
	$("#labsection_results_div").load(url, 
		{labSectionId: lab_section_id}, 
		function() 
		{
			$('#fetch_progress_bar_labsection').hide();
			$("#fetched_specimen_labsetion").show();
			$("#fetched_specimen_labsetion").html("");
		}
	);
}


function fetch_specimen2(specimen_id)
{
var pg=2;
	$('#fetch_progress_bar').show();
	var url = 'ajax/specimen_form_fetch.php';
	//var target_div = "fetch_specimen";
	$('.result_form_pane').html("");
	var target_div = "result_form_pane_"+specimen_id;
	$("#"+target_div).load(url, 
		{sid: specimen_id , page_id:pg}, 
		function() 
		{
			$('#fetch_progress_bar').hide();
			$("#fetched_specimen").show();
		}
	);
}

function fetch_specimen3(specimen_id, test_id)
{
	$('#fetch_progress_bar').show();
	var rows = $('table.tablesorter tr');

	rows.filter('.related_tests_tr_'+specimen_id).show();
	var url = "related_tests_results_entry.php";
	window.location = url+"?specimen_id="+specimen_id+"&test_id="+test_id;
}

function verify_control_selection() {
	$('#control_testing_error').hide();
	var test_type_id = $('#verify_test_type_control').attr("value");
	alert(test_type_id);

	var result = document.getElementById('controlTesting').value;
	alert(result);

	if(test_type_id == "")
	{	
		$('#control_testing_error').show();
		return;
	}
	
	$('#control_result_done').show();
}

function toggle_form(form_id, checkbox_obj)
{
	if(checkbox_obj.checked == false)
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

function submit_forms(specimen_id)
{
	var form_id_csv = $('#form_id_list').attr("value");
	var form_id_list = form_id_csv.split(",");
	var resultAvailable = 0;
	for(var i = 0; i < form_id_list.length; i++)
	{
		if(!$('#'+form_id_list[i]+'_skip').is(':checked'))
		{
			resultAvailable++;
		}
	}

	if(resultAvailable>1 && resultAvailable == form_id_list.length){
		alert("Enter at least one result to submit ");
		return;
	}

	$('.result_cancel_link').hide();
	$('.result_progress_spinner').show();

	var target_div_id = "result_form_pane_"+specimen_id;
	var count = 0;
	for(var i = 0; i < form_id_list.length; i++)
	{
		
			if($('#'+form_id_list[i]+'_skip').is(':checked'))
			{
				var params = $('#'+form_id_list[i]).formSerialize();
				
				 $.ajax({
					type: "POST",
					url: "ajax/result_add.php",
					data: params,
					success: function(msg) {
						$("#"+target_div_id).html(msg);
					}
				}); 
			} else {
				count++;
				if(form_id_list.length == count){
					$('.result_cancel_link').show();
					$('.result_progress_spinner').hide();
					alert("Enter the test result to save by enabling the checkbox");
					return;
				}
				continue;
			}
	}
	$('.result_progress_spinner').hide();
}

function get_batch_form()
{
	$('#batch_result_error').hide();
	tableml = "";
	var test_type_id = $('#batch_test_type').attr("value");
	var date_to_array=$('#yyyy_to').attr("value")+"-"+$('#mm_to').attr("value")+"-"+$('#dd_to').attr("value");
	var date_from_array=$('#yyyy_from').attr("value")+"-"+$('#mm_from').attr("value")+"-"+$('#dd_from').attr("value");
	var table_id = 'batch_result_table';
	if(test_type_id == "")
	{	
		$('#batch_result_error').show();
		$('#batch_form_div').html("");
		return;
	}
	$('#batch_progress_form').show();
	$('#batch_form_div').load(
		"ajax/batch_results_form_fetch.php", 
		{ 
			t_type: test_type_id,
			date_to:date_to_array,
			date_from:date_from_array
		}
		,
		function (){}
	);
	$.ajax({
		type: "GET",
		url: "ajax/batch_results_form_row.php",
		data: "t_type="+test_type_id+"date_to="+date_to_array+"date_from="+date_from_array, 
		success : function(msg) {
            tableml = msg;
			$('#batch_progress_form').hide();
		}
	});
}

function get_verification_form()
{
	$('#verify_result_error').hide();
	var test_type_id = $('#verify_test_type').attr("value");
	if(test_type_id == "")
	{	
		$('#verify_result_error').show();
		return;
	}
	$('#verify_progress_form').show();
	$('#verify_results_form').submit();
}

function get_worksheet()
{
	$('#worksheet_error').hide();
	var num_rows = $('#num_rows').attr("value");
	if(isNaN(num_rows))
	{
		$('#num_rows').attr("value", "10");
	}
	var worksheet_id = $('#worksheet_custom_type').attr("value")
	var test_type_id = $('#worksheet_test_type').attr("value");
	if(worksheet_id == "" && test_type_id == "")
	{	
		$('#worksheet_error').show();
		return;
	}
	$('#worksheet_progress_form').show();
	$('#worksheet_form').submit();
	$('#worksheet_progress_form').hide();
}

function clear_batch_table()
{
	$('#batch_form_div').html("");
}

function submit_batch_form()
{
	$('#batch_submit_progress').show();
	$('#batch_submit_button').attr("disabled", "disabled");
	$('#batch_cancel_button').hide();
	$('#batch_form').submit();
}

function add_one_batch_row()
{
	var row_count = $('#batch_result_table tr').size();
	var row_html = "<tr valign='top'><td>"+row_count+"</td>"+tableml;
	$('#batch_result_table').append(row_html);
}

function add_five_batch_rows()
{
	for(var i = 0; i < 5; i++)
		add_one_batch_row();
}

function mark_reported()
{
	$('#report_results_progress_div').show();
	$('#report_results_form').ajaxSubmit({
		success: function() {
			$('#report_results_progress_div').hide();
			$('#report_results_form_div').hide();
			$('#report_results_confirm').show();
			unreported_fetched = false;
		}
	});
}

function show_more_pnum()
{
	$(".old_pnum_records").show();
	$("#show_more_pnum_link").hide();
}

function hide_result_confirmation(specimen_id)
{
	var target_div_id = "result_form_pane_"+specimen_id;
	$("#"+target_div_id).html("");
}

function hideCondition(p_attrib)
{
	if(parseInt(p_attrib)==1)
		$('#h_attrib').show();
	else
		$('#h_attrib').hide();
}

function get_test_types_bycat()
{
	var cat_code = $('#cat_code').attr("value");
	var location_code = $('body').data('lab-config-id');
	$('#worksheet_test_type').load('ajax/tests_selectbycat.php?c='+cat_code+'&l='+location_code+'&all_no');
	reset_worksheet_custom_type();
}

function update_numeric_remarks(test_type_id, count, patient_age, patient_sex)
{
	
 	// # See ajax/specimen_form_fetch.php for field names
	 var values_csv = "";
	 var remarks_input_id = "test_"+test_type_id+"_comments";
	 for(var i = 0; i < count; i++)
	 {
	 var input_id = "measure_"+test_type_id+"_"+i;
	 values_csv += $('#'+input_id).attr("value")+"_";
	 }
	 var url_string = "ajax/fetch_remarks.php";
	values_csv = encodeURIComponent(values_csv);
	var data_string = "lid="+$('body').data('lab-config-id')+"&ttype="+test_type_id+"&values_csv="+values_csv+"&patient_age="+patient_age+"&patient_sex"+patient_sex;
	 $.ajax({
	 type: "POST",
		 url: url_string,
		 data: data_string,
		 success: function(msg) {
		$("#"+remarks_input_id).attr("value", msg)
		 }
	 });

}


function update_remarks(test_type_id, count, patient_age, patient_sex)
{
	 // # See ajax/specimen_form_fetch.php for field names
	 var values_csv = "";
	 var remarks_input_id = "test_"+test_type_id+"_comments";
	 for(var i = 0; i < count; i++)
	 {
	 var input_id = "measure_"+test_type_id+"_"+i;
	 values_csv += $('#'+input_id).attr("value")+"_";
	 }
	 var url_string = "ajax/fetch_remarks.php";
	values_csv = encodeURIComponent(values_csv);
	var data_string = "lid="+$('body').data('lab-config-id')+"&ttype="+test_type_id+"&values_csv="+values_csv+"&patient_age="+patient_age+"&patient_sex="+patient_sex;

	 $.ajax({
	 type: "POST",
		 url: url_string,
		 data: data_string,
		 success: function(msg) {
		$("#"+remarks_input_id).attr("value", msg)
		 }
	 });
}
/**
 *-----------------------------------
 * Section for AJAX loaded components
 *-----------------------------------
 */
$( document ).ajaxComplete(function() {

	/*
	 * Instrumentation
	*/
	 $('.fetch-from-instrument').click(function(){
	 	var driver = $(this).data('driver-id');
	 	var testTypeID = $(this).data('test-type-id');
	 	var url = 'ajax/instrumentation_get_test_results.php';
	 	var resultForm = $(this).closest('tr').find('form');

	 	// Fetch data from file and populate nearest form
		$.post( url, { "driver_id":driver, "test_type_id":testTypeID } )
			.done(function(data){
				var obj = jQuery.parseJSON(data);
				for (var key in obj) {
					if (obj.hasOwnProperty(key)) {
						var val = obj[key];
						var el = resultForm.find('.' + key).siblings('input');
						el.val(val);
					}
				}
			});

	 });
});