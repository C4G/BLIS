<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for starting patient lookup
# 1st step of specimen registration
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("doctor_register");

putUILog('doctor_register', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');



$script_elems->enableDatePicker();
$script_elems->enableJQueryForm();

$lab_config = get_lab_config_by_id($_SESSION['lab_config_id']);
?>
<script type='text/javascript'>
$(document).ready(function() {
	$('#psearch_progress_spinner').hide();
	$('#add_anyway_link').attr("href", "new_patient.php");
	$('#pq').focus();
	$('#p_attrib').change(function() {
		$('#pq').focus();
	});
});

function restrictCharacters(e) {
	
	var alphabets = /[A-Za-z]/g;
	var numbers = /[0-9]/g;
	var specialCharacter = /[_&.]/g;
	if(!e) var e = window.event;
	if( e.keyCode ) code = e.keyCode;
	else if ( e.which) code = e.which;
	var character = String.fromCharCode(code);
	
	if( !e.ctrlKey && code!=9 && code!=8 && code!=27 && code!=36 && code!=37 && code!=38  && code!=40 &&code!=13 &&code!=32 ) {
		if ( !character.match(alphabets) && !character.match(numbers) && !character.match(specialCharacter))
			return false;
		else
			return true;
	}
	else
		return true;
}

function fetch_patients()
{
	$("#target_div_id_del").hide();
	$('#psearch_progress_spinner').show();
	var patient_id = $('#pq').attr("value").trim();
	patient_id = patient_id.replace(/[^a-z0-9 ]/gi,'');
	var search_attrib = $('#p_attrib').attr("value");
	var check_url = "ajax/patient_check_name.php?n="+patient_id;
	$.ajax({ url: check_url, success: function(response){
			if(response == "false" && search_attrib == 1)
			{
				$('#psearch_progress_spinner').hide();
				window.location="new_patient.php?n="+patient_id+"&jmp=1";
			}
			else
			{
				continue_fetch_patients();
			}
		}
	});
}

function delete_patient_profile(patientId){
	if(ConfirmDelete()){
	var params = "patient_id="+patientId+"&lab_config_id="+<?php echo $lab_config->id;?>;
	//alert("patient Id " + patient_id);
	$.ajax({
		type: "POST",
		url: "ajax/delete_patient.php",
		data: params,
		success: function(msg) {
			if(msg.indexOf("1")> -1){
				$("#target_div_id_del").html("Patient successfully deleted");
			} else {
				$("#target_div_id_del").html("Patient cannot be deleted");
			}
			$("#target_div_id_del").show();
			$("#patients_found").html('');
			$("#add_anyway_div").hide();
		}
	}); 
}
}

function ConfirmDelete()
{
  var x = confirm("Are you sure you want to delete?");
  if (x)
      return true;
  else
    return false;
}


function continue_fetch_patients()
{
	var patient_id = $('#pq').attr("value").trim();
	patient_id = patient_id.replace(/[^a-z0-9 ]/gi,'');
	var search_attrib = $('#p_attrib').attr("value");
	var condition_attrib = $('#h_attrib').attr("value");
	$('#psearch_progress_spinner').show();
	if(patient_id == "")
	{
		$('#psearch_progress_spinner').hide();
		$('#add_anyway_div').show();
		return;
	}
	var url = 'ajax/search_p.php';
	$("#patients_found").load(url, 
		{q: patient_id, a: search_attrib, c: condition_attrib}, 
		function(response)
		{
			$('#psearch_progress_spinner').hide();
			if(search_attrib == 1)
			{
				$('#add_anyway_link').html(" If not this name '<b>"+patient_id+"</b>'. Add new Patient &raquo;");
				$('#add_anyway_link').attr("href", "doctor_add_patient.php?n="+patient_id);
			}
			else
			{
				$('#add_anyway_link').html("If not this name. Add new Patient &raquo;");
				$('#add_anyway_link').attr("href", "doctor_add_patient.php");
			}
			$('#add_anyway_div').show();
		}
	);
}

function hideCondition(p_attrib)
{
	if(parseInt(p_attrib)==1)
		$('#h_attrib').show();
	else
		$('#h_attrib').hide();
}
</script>

<p style="text-align: right;"><a rel='facebox' href='#Registration'>Page Help</a></p>
<div id='Registration' class='sidetip'>
<b> Tips </b>
<br />
		<?php
		if(LangUtil::$pageTerms['TIPS_REGISTRATION_1']!="-") {
			echo "This page allows us to register new patients or lookup existing patients based on name, patient ID or number.
			To register a new specimen, enter Patient by ID/Name or add a new Patient first.";
			echo "</br>";
		}	
		
		?>
</div>
<span class='page_title'> Patient Look-up</span>
<br><br>

<form>
	<select name='p_attrib' id='p_attrib' style='font-family:Tahoma;' onchange="javascript:hideCondition(this.value);">
		<?php $page_elems->getPatientSearchAttribSelect(); ?>
	</select><select name='h_attrib' id='h_attrib' style='font-family:Tahoma;'>
		<?php $page_elems->getPatientSearchCondition(); ?>
        
	</select>
	&nbsp;&nbsp;
	<input type='text' name='pq' id='pq' style='font-family:Tahoma;' onkeypress="return restrictCharacters(event)" />
	&nbsp;&nbsp;
	<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>' id='psearch_button' onclick="javascript:fetch_patients();" />
	&nbsp;&nbsp;&nbsp;
	<span id='psearch_progress_spinner'>
	<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
	</span>
</form>
<br>

<div id='patients_found' style='position:relative;left:10px;'> </div><br/>
<div id='target_div_id_del' style='position:relative;left:10px;'></div>
<br>
<div id='add_anyway_div' style='display:none'>
<a id='add_anyway_link' href='new_patient.php'><?php echo LangUtil::$pageTerms['ADD_NEW_PATIENT']; ?> &raquo;</a>
</div>
<br>
<br>
<?php $script_elems->bindEnterToClick('#pq', '#psearch_button'); ?>
<?php include("includes/footer.php"); ?>