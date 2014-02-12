<?php
#
# Main page for showing specimen info
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("specimen_info");

$script_elems->enableJQueryForm();
$script_elems->enableJQueryValidate();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
$script_elems->enableTokenInput();
putUILog('specimen_info', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


$sid = $_REQUEST['sid'];
$isTestDel = $_REQUEST['del'];
?>
<script type='text/javascript'>
function submit_forms(specimen_id)
{

	var form_id_csv = $('#form_id_list').attr("value");
	var form_id_list = form_id_csv.split(",");
//result_cancel_link').hide();
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


function fetch_specimen2(specimen_id)
{
	
	$('#fetch_progress_bar').show();
	var pg=1;
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
</script>
<br>
<b><?php echo LangUtil::getTitle(); ?></b>
 | <a href='javascript:history.go(-1);'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
&nbsp;&nbsp;<?php 
    			if($isTestDel){ 
    		?>
    			<span class='clean-orange' id='msg_box_test'>
					<?php echo "Test Deleted Successfully" ?> &nbsp;&nbsp;<a href="javascript:toggle('msg_box_test');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>&nbsp;&nbsp;
				</span>
			<?php } ?>
 
 <br><br>
<?php
if(isset($_REQUEST['vd']))
{
	# Directed from specimen_verify_do.php
	?>
	<span class='clean-orange' id='msg_box'>
		<?php echo LangUtil::$pageTerms['TIPS_VERIFYDONE']; ?> &nbsp;&nbsp;<a href="javascript:toggle('msg_box');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>&nbsp;&nbsp;
	</span>
	<?php
}
else if(isset($_REQUEST['re']))
{
	# Directed form specimen_result_do.php
	?>
	<span class='clean-orange' id='msg_box'>
		<?php echo LangUtil::$pageTerms['TIPS_ENTRYDONE']; ?> &nbsp;&nbsp;<a href="javascript:toggle('msg_box');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>&nbsp;&nbsp;
	</span>
	<?php	
}

?>
<table>
	<tr valign='top'>
		<td>
		<?php $page_elems->getSpecimenInfo($sid); ?>
		</td>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td>
			<?php $page_elems->getSpecimenTaskList($sid); ?>
		</td>
	</tr>
</table>
<span id='fetch_progress_bar' style='display:none;'>
					<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
				</span>	
<div class='result_form_pane' id='result_form_pane_<?php echo $sid; ?>'>
		</div>
<br>
<b><?php echo LangUtil::$pageTerms['REGDTESTS']; ?></b><br>
<?php $page_elems->getSpecimenTestsTable($sid); ?>
<?php include("includes/footer.php"); ?>