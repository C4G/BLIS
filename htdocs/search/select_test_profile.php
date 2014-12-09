<?php
#
# Main page for showing patient profile, test history,
# and options like updating profile, registering new specimen
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("patient_profile");

$pid = $_REQUEST['pid'];
$script_elems->enableJQueryForm();
$script_elems->enableDatePicker();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
$admin = 0;
if(is_admin_check(get_user_by_id($_SESSION['user_id']))) {
     $admin = 1;}
$rem_recs = get_removed_specimens($_SESSION['lab_config_id'], "test");
foreach($rem_recs as $rem_rec)
{
    $rem_specs[] = $rem_rec['r_id'];
    $rem_remarks[] = $rem_rec['remarks'];
}

		$labsection = 0;
		if(isset($_REQUEST['labsection'])){
			$labsection = $_REQUEST['labsection'];
		}

//print_r($rem_specs);
?>
<script type='text/javascript'>
function toggle_profile_divs()
{
	$('#profile_div').toggle();
	$('#profile_update_div').toggle();
	$('#profile_update_form').resetForm();
}

function update_profile()
{
	$('#pd_ym').attr("value", "0");
	$('#pd_y').attr("value", "0");
	var yyyy = $('#yyyy').attr("value");
	var mm = $('#mm').attr("value");
	var dd = $('#dd').attr("value");
	var age = $('#age').attr("value");
	var error_message = "";
	var error_flag = 0;
	//Age not given
	if(age.trim() == "")
	{
		//Check partial DoB
		if(yyyy.trim() != "" && mm.trim() != "" && dd.trim() == "")
		{
			dd = "01";
			if(checkDate(yyyy, mm, dd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['DOB']." ".LangUtil::$generalTerms['INVALID']; ?>");
				return;
			}
			$('#pd_ym').attr("value", "1");
			
		}
		else if(yyyy.trim() != "" && mm.trim() == "" && dd.trim() == "")
		{
			mm = "01";
			dd = "01";
			if(checkDate(yyyy, mm, dd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['DOB']." ".LangUtil::$generalTerms['INVALID']; ?>");
				return;
			}
			$('#pd_y').attr("value", "1");
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
	var params = $('#profile_update_form').formSerialize();
	$.ajax({
		type: "POST",
		url: "ajax/patient_update.php",
		data: params,
		success: function(msg) {
			$('#update_profile_progress').hide();
			window.location.reload();
		}
	});	
}

function get_select_tests(pid)
{
var _chkBoxes = document.getElementsByName("liked");
var _chkBoxesLen = _chkBoxes.length;
var i=0;
var txt=new Array();
var k=0;
for(i=0; i<_chkBoxesLen; i++)
if (_chkBoxes[i].checked == true)
{
txt[k]=_chkBoxes[i].value;
k++;
}
var url_string = "report_selected_tests.php?specimen_array="+txt+"&pid="+pid;
	window.open(url_string);

}


function get_select_tests_del(pid)
{
var _chkBoxes = document.getElementsByName("liked");
var _chkBoxesLen = _chkBoxes.length;
var i=0;
var txt=new Array();
var k=0;
for(i=0; i<_chkBoxesLen; i++)
if (_chkBoxes[i].checked == true)
{
txt[k]=_chkBoxes[i].value;
k++;
}
var url_string = "remove_selected_tests.php?specimen_array="+txt+"&pid="+pid;
	window.open(url_string, "_self");

}

function get_select_tests_undel(pid)
{
var _chkBoxes = document.getElementsByName("liked");
var _chkBoxesLen = _chkBoxes.length;
var i=0;
var txt=new Array();
var k=0;
for(i=0; i<_chkBoxesLen; i++)
if (_chkBoxes[i].checked == true)
{
txt[k]=_chkBoxes[i].value;
k++;
}
var url_string = "retrieve_specimens.php?specimen_array="+txt+"&pid="+pid;
	window.open(url_string, "_self");

}
</script>
<br>
<b>Patient Report</b>
 | <a href='javascript:history.go(-1);'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>

<br>
<p align="center">
<b><?php echo LangUtil::$generalTerms['CMD_THISTORY']; ?></b></p>

<?php $page_elems->getSelectPatientHistory($pid, $labsection); ?>
<br>

<p align="right">
<?php $page_elems->getPatientSelectReport($pid); ?>
</p>
<?php if($admin == 1){ ?>
<p align="right">
<?php $page_elems->getDeleteOptions($pid); ?>
</p>
<p align="right">
<?php $page_elems->getUnDeleteOptions($pid); ?>
</p>
<?php } ?>
<?php include("includes/footer.php"); ?>