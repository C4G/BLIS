$(document).ready(function(){
    $("#inventory_div").load("view_stocks.php");;
	$("input[name='rage']").change(function() {
		toggle_agegrouplist();
	});
	$('#revert_done_msg').hide();
	$('#reorder_fields').hide();
	$('#doctor_reorder_fields').hide();
	
	/* 
	 *Instrumentation JS
	 */
	$('#instruments_menu').click(function(){
		$('#instrumentation_setup').toggle();
	});

	$('#delete-confirm-dialog').dialog({
		appendTo: 'body',
		autoOpen: false,
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Delete": function() {
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});

	$( ".driver-delete" ).click(function() {
		$( '#delete-confirm-dialog' ).dialog( "open" );
	});

	$( ".new-driver" ).click(function() {

		if ($(this).html() == "Add New Driver") {
			$(this).html( "View Driver List" );
		}else{
			$(this).html( "Add New Driver" );
		}

		$('#driver_list_table').toggle();
		$('#install-new-driver').toggle();
	});

	$('.close-new-driver').click(function(){
		$( ".new-driver" ).click();
	});

	$( ".new-device" ).click(function() {

		if ($(this).html() == "Add New Device") {
			$(this).html( "View Device List" );
		}else{
			$(this).html( "Add New Device" );
		}

		$('#device_list_table').toggle();
		$('#configure-new-device').toggle();
	});

	$('.close-new-device').click(function(){
		$( ".new-device" ).click();
	});

	$('.submit-new-driver-form').click(function(){ // New driver form
		var form = $(this).parents('form');
		var formURI = form.attr('action');
		var formData = new FormData(form[0]);

		if($('#import-driver-file').val() != ''){

			$.ajax({ url:formURI, type:"POST", data:formData, async: false, cache: false, contentType: false, processData: false })
				.done(function(data){
					alert(data);
					$( ".new-driver" ).click();
				});
		}else{
			alert("Please select a file!");
		};
	});

	$('.submit-new-device-form').click(function(){ // New device form
		var form = $(this).parents('form');
		var url = form.attr('action');
		if ($('#select-driver').val() > 0) {
			$.post( url, form.serialize() )
				.done(function(data){
					alert(data);
					$( ".new-device" ).click();
				});
		}else{

			alert($('#select-driver').siblings('label').html() + " must be selected!");
		};
	});

	/*
	 * End Instrumentation
	 */

	$('#cat_code12').change( function() { get_test_types_bycat() });

	$('.dboption').change(function() {
		toggle_dboption_help();
	});

	stype_toggle();

    $( "#field_reorder_link_patient" ).click(function() {
            $( "#dialog-form-patients" ).dialog( "open" );
        });

    $( "#field_reorder_link_specimen" ).click(function() {
        $( "#dialog-form-specimen" ).dialog( "open" );
    });

    $( "#doctor_field_reorder_link_patient" ).click(function() {
            $( "#doctor-dialog-form-patients" ).dialog( "open" );
        });

    $( "#doctor_field_reorder_link_specimen" ).click(function() {
        $( "#doctor-dialog-form-specimen" ).dialog( "open" );
    });

    $("#sortablePatients").sortable({     	});
    $("#sortableSpecimen").sortable({     	});
    $( "#sortablePatients" ).disableSelection();
    $( "#sortableSpecimen" ).disableSelection();

    $("#doctor_sortablePatients").sortable({     	});
    $("#doctor_sortableSpecimen").sortable({     	});
    $( "#doctor_sortablePatients" ).disableSelection();
    $( "#sortableSpecimen" ).disableSelection();

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

function openReorder(){
	$('#reorder_fields').show();
}

function openDoctorReorder(){
	$('#doctor_reorder_fields').show();
}

function closeReorder(){
	$('#reorder_fields').hide();
}

function closeDoctorReorder(){
	$('#doctor_reorder_fields').hide();
}

function performDbUpdate() {
	$.ajax({
		type : 'POST',
		url : 'update/updateDB.php',
		success : function (param) {
			$('#updating').hide();
			if ( param=="true" ) {
				$('#updateSuccess').show();
				setTimeout("location.href='home.php'",5000);
			} else {
				$('#updateFailure').show();
			}
		}
	});
}

function toggle_div(div_name) {
	$("#"+div_name).hide();
}

function inventory_load()
{
    right_load(15, 'inventory_div');
}

function performUpdate()
{
	$('#updating').show();
	$.ajax({
		type : 'POST',
		url : 'ajax/update.php',
		success : function(data) {
			if ( data=="true" ) {
				performDbUpdate();
			}
			else {
				$('#updating').hide();
				$('#updateFailure').show();
			}
		}
	});
}

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
}

function blis_update_t()
{
    $('#update_button').hide();
    $('#update_spinner').show();
    setTimeout( "blis_update();", 5000); 
}

function blis_update()
{
    
    $.ajax({
		type : 'POST',
		url : 'update/blis_update.php',
		success : function(data) {
			if ( data=="true" ) {
                            $('#update_failure').hide();
                            $('#update_spinner').hide();
                            $('#update_success').show();
			}
			else {
                                $('#update_success').hide();

                                $('#update_spinner').hide();
				$('#update_failure').show();
			}
		}
	});
        
    $('#update_button').show();
}

function language_div_load() {
	$('#misc_errormsg').hide();
	$('.right_pane').hide();
	$('.menu_option').removeClass('current_menu_option');
	$('#language_div').show();
	$('#option19').addClass('current_menu_option');
}

function ask_to_delete_user(user_id)
{
	var div_id = 'delete_confirm_'+user_id;
	$('#'+div_id).show();
}

function addCurrencyRatio()
{
	$("#addCurrencyRatioDiv").show();
}

function add_new_currency(action)
{
	if(action == 1){
	$('#new_currency').show();
	$('#add_new_currency_link').hide();
	} else {
	$('#new_currency').hide();
	$('#add_new_currency_link').show();
	}
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

function t_agegrouplist_append()
{
	var html_code = "&nbsp;&nbsp;<input type='text' name='age_l[]' class='range_field'></input>-<input type='text' name='age_u[]' class='range_field'></input>";
	$('#t_agegrouplist_inner').append(html_code);
}

function s_agegrouplist_append()
{
	var html_code = "&nbsp;&nbsp;<input type='text' name='sp_age_l[]' class='range_field'></input>-<input type='text' name='sp_age_u[]' class='range_field'></input>";
	$('#s_agegrouplist_inner').append(html_code);
}

function add_slot(span_id, field_name1, field_name2)
{
	var html_code = "&nbsp;&nbsp;&nbsp;<input type='text' class='range_field' name='"+field_name1+"[]' value=''></input>-<input type='text' class='range_field' name='"+field_name2+"[]' value=''></input>";
	$('#'+span_id).append(html_code);
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

function backup_data()
{
	var r=confirm("Do you want to backup?");
	if(r==true)
		$('#backup_form').submit();
	else
		{}
}

function hide_report_config()
{
	$('#report_config_content').html("");
}

function hide_worksheet_config()
{
	$('#worksheet_config_content').html("");
}

function backup_revert_submit()
{
	// Validate
	// All okay
	$('#backup_revert_progress').show();
	$('#backup_revert_form').submit();
}

function update_database_submit() {
	$('#update_database_progress').show();
	$('#update_database_form').ajaxSubmit(function success(data) {
		window.location = data;
	});

}

function add_title_line()
{
	var html_code = "<input type='text' name='title[]' value='' class='uniform_width_more'></input><br>";
	$('#title_lines').append(html_code);
}

function right_load_1(option_num, div_id)
{
//	$('#misc_errormsg').hide();
	$('.right_pane').hide();
	$('.menu_option').removeClass('current_menu_option');
	$('#'+div_id).show();
	$('#option'+option_num).addClass('current_menu_option');
	
}