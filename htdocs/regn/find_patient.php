<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for starting patient lookup
# 1st step of specimen registration
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("find_patient");

putUILog('find_patient', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');



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
	var patient_id = $('#pq').val().trim();
	patient_id = patient_id.replace(/[^a-z0-9 ]/gi,'');
	var search_attrib = $('#p_attrib').val();
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
                $("#patients_search_results").html('');
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
	var patient_id = $('#pq').val().trim();
	patient_id = patient_id.replace(/[^a-z0-9 ]/gi,'');
	var search_attrib = $('#p_attrib').val();
	var condition_attrib = $('#h_attrib').val();
	$('#psearch_progress_spinner').show();
	if(patient_id == "")
	{
		$('#psearch_progress_spinner').hide();
		$('#add_anyway_div').show();
		return;
	}
	var url = 'ajax/search_p.php';
	$("#patients_search_results").load(url, 
		{q: patient_id, a: search_attrib, c: condition_attrib}, 
		function(response)
		{
			$('#psearch_progress_spinner').hide();
			if(search_attrib == 1)
			{
				$('#add_anyway_link').html(" If not this name '<b>"+patient_id+"</b>' <?php echo LangUtil::$pageTerms['ADD_NEW_PATIENT']; ?>&raquo;");
				$('#add_anyway_link').attr("href", "new_patient.php?n="+patient_id);
			}
			else
			{
				$('#add_anyway_link').html("If not this name. <?php echo LangUtil::$pageTerms['ADD_NEW_PATIENT']; ?> &raquo;");
				$('#add_anyway_link').attr("href", "new_patient.php");
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
<div class="page-header">
    <h1 class="page-title"><?php echo LangUtil::getTitle(); ?></h1>
</div>
<div class="row">
    <div class="col-lg-4 order-lg-1 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="text-wrap p-lg-6">
                    <h3 class="mt-0 mb-4"><?php echo LangUtil::getGeneralTerm("TIPS"); ?></h3>
                    <small>
                    
                        <?php
                        if(LangUtil::$pageTerms['TIPS_REGISTRATION_1']!="-") {
                            echo "<p>";
                            echo LangUtil::$pageTerms['TIPS_REGISTRATION_1'];
                            echo "</p>";
                        }	
                        if(LangUtil::$pageTerms['TIPS_REGISTRATION_2']!="-") {
                            echo "<p>"; 
                            echo LangUtil::$pageTerms['TIPS_REGISTRATION_2'];
                            echo "</p>";
                        }
                        if(LangUtil::$pageTerms['TIPS_PATIENT_LOOKUP']!="-")	{
                            echo "<p>"; 
                            echo LangUtil::$pageTerms['TIPS_PATIENT_LOOKUP'];
                            echo "</p>"; 
                        }
                        ?>
                    
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="text-wrap p-lg-6">
                    <p>
                        <?php
                        if(LangUtil::$pageTerms['TIPS_REGISTRATION_1']!="-") {
                            echo "This page allows us to register new patients or lookup existing patients based on name, patient ID or number.";
                            echo "</br>";
                        }	
                        ?>
                    </p>
                    <!-- start of search -->
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <select name="p_attrib" id="p_attrib" class="form-control custom-select" onchange="javascript:hideCondition(this.value);">
                                    <?php $page_elems->getPatientSearchAttribSelect(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <select name="h_attrib" id="h_attrib" class="form-control custom-select">
                                <?php $page_elems->getPatientSearchCondition(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pq" id="pq" onkeypress="return restrictCharacters(event)" />
                                    <span class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="psearch_button" onclick="fetch_patients()"><?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?></button></span>
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <center>
                                <span id='psearch_progress_spinner'>
                                <?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
                                </span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- end of search -->
        <!-- start of results -->
        <div class="card">
            <div class="table-responsive" id="patients_search_results">
                
            </div>
        </div>
        <!-- end of results -->
        <!-- start of new patient -->
        <div id="target_div_id_del" ></div>
        <div id="add_anyway_div" style="display:none">
        <a class="btn btn-primary btn-block" id="add_anyway_link" href="new_patient.php" style="color:white"><?php echo LangUtil::$pageTerms['ADD_NEW_PATIENT']; ?> &raquo;</a>
        </div>
        <br>
        <br>
        <?php $script_elems->bindEnterToClick('#pq', '#psearch_button'); ?>
        <!-- end of new patient -->
    </div>
</div>

<?php include("includes/footer.php"); ?>