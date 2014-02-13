<?php
#
# Main page for patient or specimen search
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("search");

$tips_string = LangUtil::$pageTerms['TIPS_SEARCH'];
$page_elems->getSideTip(LangUtil::$generalTerms['TIPS'], $tips_string);
?>
<script type='text/javascript'>
$(document).ready(function(){
	$('#specimen_search_results').css({"display":"none", "position":"relative", "left":"20px"});
	$('#patient_search_results').css({"display":"none", "position":"relative", "left":"20px"});
	$('#specimen_search_error').hide();
	$('#specimen_notfound_error').hide();
	$('#patient_search_error').hide();
	$('#patient_id').focus();
	$('#specimen_id').focus(function() { $('#patient_search_error').hide(); $('#specimen_notfound_error').hide(); });
	$('#patient_id').focus(function() { $('#specimen_search_error').hide() });
	$('#p_attrib').change(function() {
		$('#patient_id').focus();
	});
	$('#s_attrib').change(function() {
		$('#specimen_id').focus();
	});
});

function specimen_search()
{
	$('#specimen_search_error').hide();
	var specimen_id = $('#specimen_id').val();
	var search_attrib = $('#s_attrib').attr("value");
	if(specimen_id == "")
	{
		$('#specimen_search_error').show();
		$('#specimen_search_results').hide();
		return;
	}
	$('#specimen_search_spinner').show();
	var url = 'ajax/search_s.php';
	$("#specimen_search_results").load(url, 
		{q: specimen_id, a: search_attrib }, 
		function()
		{
			$('#specimen_search_spinner').hide();
			$('#specimen_search_results').show();
		}
	);
}



function patient_search()
{
	$('#patient_search_error').hide();
	var patient_id = $('#patient_id').val();
	var search_attrib = $('#p_attrib').attr("value");
	if(patient_id == "")
	{
		$('#patient_search_error').show();
		$('#patient_search_results').hide();
		return;
	}
	$('#patient_search_spinner').show();
	var url = 'ajax/search_p.php';
	$("#patient_search_results").load(url, 
		{q: patient_id, a: search_attrib }, 
		function()
		{
			$('#patient_search_spinner').hide();
			$('#patient_search_results').show();
		}
	);
}
</script>
<br>
<b><?php echo LangUtil::getTitle(); ?></b>
<br><br>
<table>
		
	<tr class="card_num_row" id="card_num_row">
	<td><?php echo LangUtil::$generalTerms['PATIENT']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>
		<select name='p_attrib' id='p_attrib'>
			<?php $page_elems->getPatientSearchAttribSelect(); ?>
		</select>
		&nbsp;&nbsp;
	</td>
	<td><input type="text" name="patient_id" id="patient_id" value="" size="30" />&nbsp;&nbsp;<span class='error_string' id='patient_search_error'><?php echo LangUtil::$generalTerms['MSG_REQDFIELD']; ?></span></td>
	
	<td><input type='button' id='patient_search_button' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>' onclick='javascript:patient_search();' /></td>
	<td><span id='patient_search_spinner' style='display:none'><?php echo $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']);?></span></td>
	</tr>
</table>
<div id='patient_search_results'>
</div>
<br>
<table <?php
if($_SESSION['s_addl'] == 0)
	# Specimen ID not used in lab config
	# No identifiers for specimens are used in this lab
	# Hide specimen search box
	echo " style='display:none;' ";

?>>
	<tr class="specimen_id_row" id="specimen_id_row">
		<td><?php echo LangUtil::$generalTerms['SPECIMEN']; ?>&nbsp;</td>
		<td>
			<select name='s_attrib' id='s_attrib'>
				<!--<option value='0'><?php #echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></option>-->
				<?php
				if($_SESSION['s_addl'] != 0)
				{
				?>
					<option value='1'><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></option>
				<?php
				 # Search by accession num hidden from the user
				 /*
				<option value='2'><?php echo LangUtil::$generalTerms['ACCESSION_NUM']; ?></option> 
				*/
				}
				?>
			</select>
			&nbsp;&nbsp;
		</td>
		<td>
			<input type="text" name="specimen_id" id="specimen_id" value="" size="30" />&nbsp;&nbsp;<span class='error_string' id='specimen_search_error'><?php echo LangUtil::$generalTerms['MSG_REQDFIELD']; ?></span>
		</td>
		<td>
			<input type='button' id='specimen_search_button' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>' onclick='javascript:specimen_search();' />
		</td>
		<td>
			<span id='specimen_search_spinner' style='display:none'><?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']);?></span>
			<span class='error_string' id='specimen_notfound_error'><?php echo LangUtil::$generalTerms['SPECIMEN']." ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?></span>
		</td>
	</tr>
</table>
<div id='specimen_search_results'>
</div>
<br>
<?php
$script_elems->bindEnterToClick("#specimen_id", "#specimen_search_button");
$script_elems->bindEnterToClick("#patient_id", "#patient_search_button");
?>
<?php include("includes/footer.php"); ?>