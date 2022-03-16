
<?php
#
# Main page for registering new specimen(s) in a single session/accession
#
/*
$load_time = microtime(); 
$load_time = explode(' ',$load_time); 
$load_time = $load_time[1] + $load_time[0]; 
$page_start = $load_time; 
*/

include("redirect.php");
include("includes/header.php");
?>

<?php
include_once ("includes/db_lib.php");
include_once("includes/field_order_update.php");



LangUtil::setPageId("new_specimen");

$script_elems->enableDatePicker();
$script_elems->enableLatencyRecord();
$script_elems->enableJQueryForm();
$script_elems->enableAutocomplete();
$pid = $_REQUEST['pid'];

if(isset($_REQUEST['dnum']))
	$dnum = (string)$_REQUEST['dnum'];
else
	$dnum = get_daily_number();

if(isset($_REQUEST['session_num']))
	$session_num = $_REQUEST['session_num'];
else
	$session_num = get_session_number();
	
/* check discrepancy between dnum and session number and correct 
if ( substr($session_num,strpos($session_num, "-")+1 ) )
	$session_num = substr($session_num,0,strpos($session_num, "-"))."-".$dnum;
*/
	
$doc_array= getDoctorList();
$ref_array= getRefToList();
$php_array= addslashes(implode("%", $doc_array));

$refTo_array= addslashes(implode("%", $ref_array));
	
$uiinfo = "pid=".$_REQUEST['pid']."&dnum=".$_REQUEST['dnum'];
putUILog('new_specimen', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
?>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/select2.js"></script>
<script>
    var jq = $.noConflict(true); // <== Do not pass true
</script>

<script>
$(document).ready(function(){
    var refTo_string="<?php echo $refTo_array;?>";
    var refTodata=refTo_string.split("%"); 
});
</script>
<script>
// <!-- <![CDATA[
specimen_count = 1;
patient_exists = false;
$(document).ready(function(){
	$('#specimen_id').focus();
	$('a[rel*=facebox]').facebox()
	<?php
	if(isset($_REQUEST['pid']))
	{
		echo "; get_patient_info('".$pid."');";
		echo " patient_exists = true;";
	}
	?>
});

function get_patient_info()
{
	var patient_id = <?php echo $_REQUEST['pid']; ?>;//$("#card_num").attr("value");
	if(patient_id == "")
	{
		$('#specimen_patient').html("");
		return;
	}
	$('#specimen_patient').load(
		"ajax/patient_info.php", 
		{
			pid: patient_id
		}, 
		function(){
			var return_html = $('#specimen_patient').html();
			if(return_html.indexOf("<?php echo LangUtil::$generalTerms['PATIENT']." ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?>") == -1)
				patient_exists = true;
			else
				patient_exists = false;
		}
	);
}

function check_specimen_id(specimen_div_id, err_div_id)
{
	var specimen_id = $('#'+specimen_div_id).attr("value");
	if(specimen_id == "")
	{	
		$('#'+err_div_id).html("");
		return;
	}
	if(isNaN(specimen_id))
	{
		var msg_string = "<small><font color='red'>"+"Invalid ID. Only numbers allowed.</font></small>";
		$('#'+err_div_id).html(msg_string);
		return;
	}
	$('#'+err_div_id).load(
		"ajax/specimen_check_id.php", 
		{ 
			sid: specimen_id
		}
	);
}

function contains(a, obj){
  for(var i = 0; i < a.length; i++) {
    if(a[i] === obj){
      return true;
    }
  }
  return false;
}

function set_compatible_tests()
{
	var specimen_type_id = $("#s_type").attr("value");
	if(specimen_type_id == "")
	$('#test_type_box').load(
		"ajax/test_type_options.php", 
		{
			stype: specimen_type_id
		}
	);
}

function add_specimens()
{
	for(var j = 1; j <= specimen_count; j++)
	{
		// Validate each form
		var form_id = 'specimenform_'+j;
		var form_elem = $('#'+form_id);
		if(	form_elem == undefined || 
			form_elem == null )
			continue;
		if(	$("#"+form_id+" [name='stype']").attr("value") == null || 
			$("#"+form_id+" [name='stype']").attr("value") == undefined )
			continue;
		var stype = $("#"+form_id+" [name='stype']").attr("value");
		if(stype.trim() == "")
		{
			alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['MSG_STYPE_MISSING']; ?>");
			return;
		}
		var ttype_list = $("#"+form_id+" [name='t_type_list[]']");
		var ttype_notselected = true;
		for(var i = 0; i < ttype_list.length; i++)
		{
			if(ttype_list[i].checked)
			{
				ttype_notselected = false;
				break;
			}
		}
		if(ttype_notselected == true)
		{
			alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['MSG_NOTESTS_SELECTED']; ?>");
			return;
		}
		var sid = $("#"+form_id+" [name='specimen_id']").attr("value");
		if(sid.trim() == "")
		{
			alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['MSG_SID_MISSING']; ?>");
			return;
		}
		var specimen_valid = $("#specimen_msg_"+j).html();
		if(specimen_valid != "")
		{
			alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['MSG_SID_INVALID']; ?>");
			return;
		}

		var referred_out = $('#ref_out_'+j+':checked').val();
		var referred_to = $("#refTo_row_"+j+"_input").val();
		var referred_from = $("#ref_from_row_"+j+"_input").val();
		//alert(referred_out+" -- "+referred_to+" -- "+referred_from);

		if(referred_out == 'Y'){
						
			if(referred_to != referred_from){
				continue;		
			} else{
				alert("Enter either 'Referred To' or 'Referred From' ");
				return;
			}
		}
		if(specimen_valid != "")
		{
			alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['MSG_SID_INVALID']; ?>");
			return;
		}

		var ry = $("#"+form_id+" [name='receipt_yyyy']").attr("value");
		ry = ry.replace(/[^0-9]/gi,'');
		var rm = $("#"+form_id+" [name='receipt_mm']").attr("value");
		rm = rm.replace(/[^0-9]/gi,'');
		var rd = $("#"+form_id+" [name='receipt_dd']").attr("value");
		rd = rd.replace(/[^0-9]/gi,'');
		var cy = $("#"+form_id+" [name='collect_yyyy']").attr("value");
		cy = cy.replace(/[^0-9]/gi,'');
		var cm = $("#"+form_id+" [name='collect_mm']").attr("value");
		cm = cm.replace(/[^0-9]/gi,'');
		var cd = $("#"+form_id+" [name='collect_dd']").attr("value");
		cd = cd.replace(/[^0-9]/gi,'');
		var ch = $("#"+form_id+" [name='ctime_hh']").attr("value");
		ch = ch.replace(/[^0-9]/gi,'');
		var cmm = $("#"+form_id+" [name='ctime_mm']").attr("value");
		cmm = cmm.replace(/[^0-9]/gi,'');
		if(checkDate(ry, rm, rd) == false)
		{
			var answer = confirm("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['MSG_RDATE_INVALID']; ?> . Are you sure you want to continue?");
			if (answer == false)
				return;
		}
		if(cy.trim() == ""  && cm.trim() == "" && cd.trim() == "")
		{
			//Collection date not entered (optional field)
			//Do nothing
		}
		else
		{
			//Collection date entered. Check date string
			if(checkDate(cy, cm, cd) == false)
			{
				alert("<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['MSG_CDATE_INVALID']; ?>");
				return;
			}
		}
		//All okay
	}
	console.log("Reached all ok");
	$('#progress_spinner').show();
	
	for(var j = 1; j <= specimen_count; j++)
	{
		// Submit each form
		var form_id = 'specimenform_'+j;
		
		$('#'+form_id).ajaxSubmit({async: false});
		//$('#'+form_id).submit();
	}
	var dnum_val = $('#dnum').attr("value");
	<?php
	$today = date("Ymd");
	switch($_SESSION['dnum_reset'])
	{
		case LabConfig::$RESET_DAILY:
			$today = date("Ymd");
			break;
		case LabConfig::$RESET_WEEKLY:
			$today = date("Y_W");
			break;
		case LabConfig::$RESET_MONTHLY:
			$today = date("Ym");
			break;
		case LabConfig::$RESET_YEARLY:
			$today = date("Y");
			break;
	}
	?>
	/*
	var dnum_string= "<?php echo $today; ?>";
	var url_string = "ajax/daily_num_update.php?dnum="+dnum_string+"&dval="+dnum_val;
	$.ajax({ url: url_string, async: false, success: function() {}}); 
	
	var url_string = "ajax/session_num_update.php?snum=<?php echo date("Ymd"); ?>";
	$.ajax({ url: url_string, async: false, success: function() {
		$('#progress_spinner').hide();
		window.location="specimen_added.php?snum=<?php echo $session_num; ?>";
	}});
	*/
	window.location="specimen_added.php?snum=<?php echo $session_num; ?>";
}

function add_specimenbox()
{
	specimen_count++;
	var doc = $('#doc_row_1_input').attr("value");
	var refTo = $('#refTo_row_1_input').attr("value");
	var title= $('#doc_row_1_title').attr("value");
	var dnumInit = "<?php echo $dnum; ?>";
	dnum = dnumInit.toString();
	var url_string = "ajax/specimenbox_add.php?num="+specimen_count+"&pid=<?php echo $pid; ?>"+"&dnum="+dnum+"&doc="+doc+"&title="+title+"&refTo="+refTo+"&session_num=<?php echo $session_num; ?>";
	$('#sbox_progress_spinner').show();
	$.ajax({ 
		url: url_string, 
		success: function(msg){
			$('#specimenboxes').append(msg);
			$('#sbox_progress_spinner').hide();
		}
	});
}

function get_testbox(testbox_id, stype_id)
{
	//alert("Test Box ID : "+testbox_id+" specimen type : "+stype_id);
	var stype_val = $('#'+stype_id).attr("value");
	if(stype_val == "")
	{
		$('#'+testbox_id).html("-<?php echo LangUtil::$pageTerms['MSG_SELECT_STYPE']; ?>-");
		return;
	}
	$('#'+testbox_id).html("<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>");
	$('#'+testbox_id).load(
		"ajax/test_type_options.php", 
		{
			stype: stype_val
		}
	);
}

function show_dialog_box(div_id)
{
	var dialog_id = div_id+"_dialog";
	$('#'+dialog_id).show();
}

function hide_dialog_box(div_id)
{
	var dialog_id = div_id+"_dialog";
	$('#'+dialog_id).hide();
}

function remove_specimenbox(box_id)
{
	hide_dialog_box(box_id);
	specimen_count--;
	$('#'+box_id).remove();
}

function askandback()
{
	var todo = confirm("<?php echo LangUtil::$pageTerms['TIPS_SURETOABORT']; ?>");
	if(todo == true)
		history.go(-1);
}

function checkandtoggle(select_elem, div_id)
{
	var input_id = div_id+"_input";
	var report_to_val = select_elem.value;
	if(report_to_val == 1)
	{
		$('#'+div_id).hide();
	}
	else if(report_to_val == 2)
	{
		$('#'+div_id).show();
	}
	
}

function checkandtoggle_ref(ref_check_id, ref_row_id, ref_from_row_id)
{
	if($('#'+ref_check_id).attr("checked") == true)
	{
		$('#'+ref_row_id).show();
		$('#'+ref_from_row_id).show();
	}
	else
	{
		$('#'+ref_from_row_id).hide();
		$('#'+ref_row_id).hide();
	}
}
// And here is the end.

// ]]> -->
</script>

<p style="text-align: right;"><a rel='facebox' href='#NEW_SPECIMEN'>Page Help</a></p>
<span class='page_title'><?php echo LangUtil::getTitle(); ?></span>
 | <?php echo LangUtil::$generalTerms['ACCESSION_NUM']; ?> <?php echo $session_num; ?>
 | <a href='javascript:history.go(-1);'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br>
<br>
<?php
# Check if Patient ID is valid
$patient = get_patient_by_id($pid);
if($patient == null)
{
	?>
	<div class='sidetip_nopos'>
	<?php
	echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['PATIENT_ID']." ".$pid." ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?>.
	<br><br>
	<a href='find_patient.php'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
	</div>
	<?php
	include("includes/footer.php");
	return;
}

	if (isset($_SESSION['specimenFieldOrder']))
		unset($_SESSION['specimenFieldOrder']);

	if (! isset($_SESSION['specimenFieldOrder']))
	{
		$lab_config = get_lab_config_by_id($_SESSION['lab_config_id']);
		$specimenFieldOrderingObj = field_order_update::install_first_order($lab_config, 2, $_SESSION['lab_config_id']);
		$specimenOrder = $specimenFieldOrderingObj->form_field_inOrder;
		$_SESSION['specimenFieldOrder'] = explode( ',', $specimenOrder );
	}

?>
<table cellpadding='5px'>
	<tbody>
		<tr valign='top'>
			<td>
				<span id='specimenboxes'>
				<!--[Sep 3, 2018 - Jung Wook] Add a $doc_array variable to the argument of the getNewSpecimenForm function  -->
				<?php echo $page_elems->getNewSpecimenForm(1, $pid, $dnum, $session_num, $GLOBALS['doc_array']); ?>
				</span>
				<br>
				<a href='javascript:add_specimenbox();'><?php echo LangUtil::$pageTerms['ADD_ANOTHER_SPECIMEN']; ?> &raquo;</a>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<span id='sbox_progress_spinner' style='display:none;'>
					<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
				</span>
			</td>
			<td>
				<div>
					<?php echo $page_elems->getPatientInfo($pid, 400); ?>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<br>
&nbsp;&nbsp;
<input type="button" name="add_sched" id="add_button" onclick="add_specimens();" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" size="20" />
&nbsp;&nbsp;&nbsp;&nbsp;
<small><a href='javascript:askandback();'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
&nbsp;&nbsp;&nbsp;&nbsp;
<div id='NEW_SPECIMEN' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
		<?php
		if(LangUtil::$pageTerms['TIPS_REGISTRATION_SPECIMEN']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_REGISTRATION_SPECIMEN'];
			echo "</li>";
		}	
		if(LangUtil::$pageTerms['TIPS_REGISTRATION_SPECIMEN_1']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_REGISTRATION_SPECIMEN_1'];
			echo "</li>";
		}	
		?>
	</ul>
</div>
<span id='progress_spinner' style='display:none;'>
	
	<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
</span>
<br>
<?php 
/*
$load_time = microtime(); 
$load_time = explode(' ',$load_time); 
$load_time = $load_time[1] + $load_time[0]; 
$page_end = $load_time; 
$final_time = ($page_end - $page_start); 
$page_load_time = number_format($final_time, 4, '.', ''); 
echo("Page generated in " . $page_load_time . " seconds"); 
*/
include("includes/footer.php"); 
?>