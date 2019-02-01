<?php
#
# Main page for showing patient profile, test history,
# and options like updating profile, registering new specimen
#
include("redirect.php");
include("includes/header.php");
include("barcode/barcode_lib.php");
LangUtil::setPageId("patient_profile");



putUILog('patient_profile', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$pid = $_REQUEST['pid'];
$isSpecDel = $_REQUEST['del'];
$isUpdate = $_REQUEST['update'];

$script_elems->enableJQueryForm();
$script_elems->enableDatePicker();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();

$barcodeSettings = get_lab_config_settings_barcode();
//  print_r($barcodeSettings);
$code_type = $barcodeSettings['type']; //"code39";
$bar_width = $barcodeSettings['width']; //2;
$bar_height = $barcodeSettings['height']; //40;
$font_size = $barcodeSettings['textsize']; //11;
?>
<script type="text/javascript" src="facebox/facebox.js"></script>
<script type='text/javascript'>

$(document).ready(function(){
    var code = $('#patientID').val();
    $("#patientBarcodeDiv").barcode(code, '<?php echo $code_type; ?>',{barWidth:<?php echo $bar_width; ?>, barHeight:<?php echo $bar_height; ?>, fontSize:<?php echo $font_size; ?>, output:'bmp'});
	<?php 
		if($isUpdate==1){
	?>
		toggle_profile_divs();
	<?php } ?>
             

});

// Close the dialog when the user clicks anywhere outside of the modal
window.onclick = function(event) {
    if (event.target == document.getElementById('profile_update_dialog_div')) {
        document.getElementById('profile_update_dialog_div').style.display = "none";
    }
}

function showUpdateProfileDialog() {
    document.getElementById('profile_update_dialog_div').style.display = 'block';
    document.getElementById('surr_id').focus();
}

function closeUpdateProfileDialog() {
    document.getElementById('profile_update_dialog_div').style.display = 'none';
    document.getElementById('profile_update_dialog_div').blur();
}
    
    
function retrieve_deleted(sid, category){
	var params = "item_id="+sid+"&ret_cat="+category;
	 $.ajax({
		type: "POST",
		url: "ajax/retrieve_deleted.php",
		data: params,
		success: function(msg) {
			if(msg.indexOf("1")> -1){
				location.href = location.href;
			} else {
				$("#target_div_id_del").html("Specimen cannot be Retrieved");
			}
			
		}
	}); 
	
}

function toggle_profile_divs()
{
	$('#profile_div').toggle();
	$('#profile_update_form').resetForm();
}

function print_specimen_barcode(pid, sid)
{
    s_id = parseInt(sid);
    url = "ajax/getSpecimenBarcode.php?sid="+sid;
    $.ajax({
		type: "GET",
		url: url,
                async: false,
		success: function(data) {
                         code = data;

		}
	});
    $("#specimenBarcodeDiv").barcode(code, '<?php echo $code_type; ?>',{barWidth:<?php echo $bar_width; ?>, barHeight:<?php echo $bar_height; ?>, fontSize:<?php echo $font_size; ?>, output:'bmp'});         
    Popup($('#specimenBarcodeDiv').html());
}

function print_patient_barcode()
{
    Popup($('#patientBarcodeDiv').html());
}

function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Barcode</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();
        //mywindow.document.show
        return true;
    }

function update_profile()
{
	var yyyy = $("#yyyy").val();
	var mm = $("#mm").val();
	var dd = $("#dd").val();
	var age = $("#age").val();
	var error_message = "";
	var error_flag = 0;
	//Age not given
	if(age.trim().length > 0)
	{
        //Check partial DoB
		if(yyyy.trim().length > 0 && mm.trim().length > 0 && dd.trim().length == 0)
		{
			$("#dd").val("01");
            dd = "01";
			if(checkDate(yyyy, mm, dd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['DOB']." ".LangUtil::$generalTerms['INVALID']; ?>");
				return;
			}
			$("#pd_ym").val("1");
			
		}
		else if(yyyy.trim().length > 0 && mm.trim().length == 0 && dd.trim().length == 0)
		{
			$("#mm").val("01");
			$("#dd").val("01");
            mm = "01";
            dd = "01";
			if(checkDate(yyyy, mm, dd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['DOB']." ".LangUtil::$generalTerms['INVALID']; ?>");
				return;
			}
			$("#pd_y").val("1");
		}
		else if(yyyy.trim() == "" && mm.trim() == "" && dd.trim() == "")
		{
			error_message += "Please enter either Age or Date of Birth\n";//<br>";
			error_flag = 1;
			alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['TIPS_AGEORDOB']; ?>");
			return;
		}
		else
		{
			//Full DoB - check
			if(checkDate(yyyy, mm, dd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['DOB']." ".LangUtil::$generalTerms['INVALID']; ?>");
				return;
			}
		}
	}
	else if (isNaN(age))
	{
		alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['AGE']." ".LangUtil::$generalTerms['INVALID']; ?>");
		return;
	}	
	
	$('#update_profile_progress').show();
	var params = $('#profile_update_form').serialize();
	$.ajax({
		type: "POST",
		url: "ajax/patient_update.php",
		data: params,
		success: function(msg) {
			$('#update_profile_progress').hide();
            closeUpdateProfileDialog();
			alert("Successfully updated");
			window.location.reload();
		}
	});	
}
</script>
<div class="page-header">
    <h1 class="page-title"><a href="javascript:history.go(-1);" class="btn btn-secondary" role="button"><i class="fe fe-chevron-left mr-2"></i><?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>&nbsp;&nbsp;<?php echo LangUtil::getTitle(); ?></h1>
    
    <?php 
    if($isSpecDel){ 
    ?>
        <span class='clean-orange' id='msg_box_specimen'>
            <?php echo "Specimen Deleted Successfully" ?> &nbsp;&nbsp;<a href="javascript:toggle('msg_box_specimen');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>&nbsp;&nbsp;
        </span>
    <?php } ?>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div id="profile_div" class="p-lg-6">
                    <?php $page_elems->getPatientInfo($pid); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="text-wrap p-lg-6">
                    <?php $page_elems->getPatientTaskList($pid); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- Result Table Start -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo LangUtil::$generalTerms['CMD_THISTORY']; ?></h3>
            </div>
            <div class="table-responsive">
                <?php $page_elems->getPatientHistory($pid); ?>
            </div>
        </div>
    </div>
</div>

<div id="barcodeData" style="display:none;">
<input type="text" id="patientID" value='<?php echo encodePatientBarcode($_REQUEST['pid'],0); ?>' />
<br><br>
<div id="patientBarcodeDiv"></div>
<br><br>
<div id="specimenBarcodeDiv"></div>
</div>
<!-- A pop-up form to update the profile -->

<div id="profile_update_dialog_div" class="modal">

    <?php $page_elems->getPatientUpdateForm($pid); ?>
    
</div>
<script>
    require(['input-mask']);
</script>

<?php include("includes/footer.php"); ?>