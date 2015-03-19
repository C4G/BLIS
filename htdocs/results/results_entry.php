<?php
#
# Results entry page
# Technicians can search for a specimen to enter results for OR import results from a file and validate
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("results_entry");

$script_elems->enableDatePicker();
$script_elems->enableJQueryForm();
$script_elems->enableJQueryValidate();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
$script_elems->enableTokenInput();
?>
<script src="js/results_entry.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/results_entry.css" type="text/css" media="all"> 
<?php

$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

$user_level = $_SESSION['user_level'];
//$user = get_user_by_id($_SESSION[''])
?>
<div class='batch_results_subdiv_help' id='batch_results_subdiv_help' style='display:none;'>
	<?php
		//$tips_string = LangUtil::$pageTerms['TIPS_INFECTIONSUMMARY'];
		$tips_string = "If you cannot see any information other than Test Name, Results and the Skip Option, please tell your administrator to configure it from Worksheet Configuration";
		//$tips_string = "";
		$page_elems->getSideTipBatchResults(LangUtil::$generalTerms['TIPS'], $tips_string);
	?>
</div>
<script type='text/javascript'>

$(document).ready(function(){

	<?php 
	global $LIS_VERIFIER;

	if($user_level == $LIS_VERIFIER){
	?>
		right_load('verify_results'); 
	<?php 
	}
	else 
	{	
	?>
		right_load("specimen_results");
	<?php
	} 
	if(isset($_REQUEST['ajax_response']))
	{
		#Rendering after Ajax response (workaround for dynamically loading JS via Ajax)
	?>
		$('#specimen_id').attr("value", "<?php echo $_REQUEST['sid_redirect'] ?>");
	<?php
	}
	else
	{
	?>
		$('#fetched_specimen').hide();
	<?php
	}
	?>
	<?php
	if($SHOW_REPORT_RESULTS === true)
	{
	?>
		load_unreported_results();
	<?php
	}
	?>
	hide_worksheet_link();
});

</script>

<br>
<table name="page_panes" cellpadding="10px">
	<tr valign='top'>
	<td id="left_pane" class="left_menu" valign="top" width='180px'>

	<?php  
	global $LIS_VERIFIER;
	if($user_level != $LIS_VERIFIER){
	?>
		<a href="javascript:right_load('specimen_results');" title='Enter Test Results for a Single Specimen' 
			class='menu_option' id='specimen_results_menu'
		>
			<?php echo LangUtil::$pageTerms['MENU_SINGLESPECIMEN']; ?>
		</a><br><br>
		<a href="javascript:right_load('batch_results');"  title='Enter Test Results for a Batch of Specimens'
			class='menu_option' id='batch_results_menu'
		>
			<?php echo LangUtil::$pageTerms['MENU_BATCHRESULTS']; ?>
		</a><br><br>
		<!--
		<a href="javascript:right_load('import_results');"  title='Import Test Results from Equipment'
			class='menu_option' id='import_results_menu'
		>
			Import Results
		</a><br><br>
		--><?php }?>
		<a href="javascript:right_load('verify_results');"  title='Verify Test Results'
			class='menu_option' id='verify_results_menu'
		>
			<?php echo LangUtil::$pageTerms['MENU_VERIFYRESULTS']; ?>
		</a><br><br>
		
		<?php /* Uncomment when Control Testing is finalized
		<a href="javascript:right_load('control_testing');" title='Enter Control Testing Results'
			class='menu_option' id='control_testing_menu'
		>
			<?php echo LangUtil::$pageTerms['CONTROL_TESTING_RESULTS']; ?>
		</a><br><br>
		*/ ?>
		
		<?php
		if($SHOW_REPORT_RESULTS === true)
		{
		?>
		<a href="javascript:right_load('report_results');"  title='Mark Test Results as Reported to Patient/Doctor'
			class='menu_option' id='report_results_menu'
		>
			<?php echo LangUtil::$pageTerms['MENU_REPORTRESULTS']; ?>
		</a><br><br>
		<?php
		}
		?>
		<a href="javascript:right_load('worksheet_div');"  title='Generate worksheet with a list of pending specimens'
			class='menu_option' id='worksheet_div_menu'
		>
			<?php echo LangUtil::$pageTerms['MENU_WORKSHEET']; ?>
		</a><br><br>
		
		
		<a href="javascript:right_load('labsection_div');"  title='Enter Results by Lab Sections'
			class='menu_option' id='labsection_div_menu'
		> <?php echo LangUtil::$pageTerms['MENU_LABSECTION']; ?></a>
		
		
			
		<p>&nbsp;</p>
		<p><div id="worksheet_link"></div></p><br><br>
		
		
	</td>
	
	<td id="right_pane" class="right_pane" valign="top" >
	
		<div id="worksheet_results" class='results_subdiv' style='display:none;'>
			<form name="fetch_worksheet" id="fetch_worksheet">
				<b>Worksheet Results</b>
				<br>
				<br>
				Worksheet# <input type="text" name="worksheet_num" id="worksheet_num" class='uniform_width' />
				<input type="button" onclick="fetch_worksheets();" value="Fetch"/>
			</form>
			<div id="worksheet">
			</div>
		</div>
		
		<div id="specimen_results" class='results_subdiv' style='display:none;'>
			<form name="fetch_specimen_form" id="fetch_specimen_form">
				<b><?php echo LangUtil::$pageTerms['MENU_SINGLESPECIMEN']; ?></b>
				<br>
				<br>
				<select name='resultfetch_attrib' id='resultfetch_attrib' onchange="javascript:hideCondition(this.value);">
					<?php
					$hide_patient_name = true;

					if($_SESSION['user_level'] == $LIS_TECH_SHOWPNAME)
					{
						$hide_patient_name = false;
					}
					$page_elems->getPatientSearchAttribSelect($hide_patient_name);
					if($_SESSION['s_addl'] != 0)
					{
					?>
						<option value='5'><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></option>
					<?php
					}
					?>
				</select>
				<select name='h_attrib' id='h_attrib' style='font-family:Tahoma;'>
					<?php $page_elems->getPatientSearchCondition(); ?>
				</select>

				&nbsp;&nbsp;
				<input type="text" name="specimen_id" id="specimen_id" class='uniform_width' />
				<br/> <br/>
				
				<table cellspacing='4px'>
					<tbody>
					<tr valign='top'>
						<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?> &nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>
							<select name='cat_code_labsection_specimen' id='cat_code_labsection_specimen' class='uniform_width'>
								<option value="0">ALL</option>
								<?php $page_elems->getTestCategorySelect(); ?>
							</select>
						</td>
					</tr>
					
				</table>
				<br/>
				<input type="button" id='fetch_specimen_button' onclick="fetch_specimen();" value="<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>" />
				&nbsp;&nbsp; <br/>
				<span id='fetch_progress_bar' style='display:none;'>
					<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
				</span>	
			</form>
			<br>
			<div id='fetched_patient_entry'>
			</div>
			<div id="fetched_specimen">
			<?php
				if(isset($_REQUEST['ajax_response']))
					echo $_REQUEST['ajax_response'];
			?>
			</div>
		</div>

		<div id="import_results" class='results_subdiv' style='display:none;'>
			<b>Import Results</b>
			<br>
			<br>
			<form name='form_import' id='form_import' action='' method='POST' enctype='multipart/form-data'>
				<table>
					<tr>
						<td>Machine Type</td>
						<td><input type='text' name='mc_type'></td>
					</tr>
					<tr>
						<td>File</td>
						<td><input type='file' name='file_path'></td>
					</tr>
					<tr>
						<td></td>
						<td><br><input type='button' name='submit_import' value='Import Results'/></td>
					</tr>
				</table>
			</form>
		</div>
		
		<div id='batch_results' class='results_subdiv' style='display:none;'>
			<b><?php echo LangUtil::$pageTerms['MENU_BATCHRESULTS']; ?></b>
			<br>
			<br>
			<?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>
			&nbsp;&nbsp;&nbsp;
			<select id='batch_test_type' class='uniform_width'>
				<option value=""><?php echo LangUtil::$generalTerms['SELECT_ONE']; ?>..</option>
				<?php $page_elems->getTestTypesSelect($_SESSION['lab_config_id']); ?>
			</select>
			&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;
			<br><br>
			<table>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
					<?php
					$today = date("Y-m-d");
					$today_array = explode("-", $today);
					$monthago_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($today)) . " -270 days"));
					$monthago_array = explode("-", $monthago_date);
					$name_list = array("yyyy_from", "mm_from", "dd_from");
					$id_list = array("yyyy_from", "mm_from", "dd_from");
					$value_list = $monthago_array;
					$page_elems->getDatePicker($name_list, $id_list, $value_list);
					?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['TO_DATE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
					<td>
					<?php
						$name_list = array("yyyy_to", "mm_to", "dd_to");
						$id_list = array("yyyy_to", "mm_to", "dd_to");
						$value_list = $today_array;
						$page_elems->getDatePicker($name_list, $id_list, $value_list);
					?>
					</td>
				</tr>
				<tr valign='top'>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td>
						&nbsp;&nbsp;&nbsp;
						<input type='button' onclick='javascript:get_batch_form();' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>'></input>
					</td>
				</tr>
			</table>
			<span id='batch_progress_form' style='display:none'>
				<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
			</span>
			<span id='batch_result_error' class='error_string' style='display:none;'>
				<?php echo LangUtil::$generalTerms['MSG_SELECT_TTYPE']; ?>
			</span>
			<br><br>
			<div id='batch_form_div'>
			</div>
		</div>
		
		<div id='verify_results' class='results_subdiv' style='display:none;'>
			<b><?php echo LangUtil::$pageTerms['MENU_VERIFYRESULTS']; ?></b>
			<br>
			<br>
			<form name='verify_results_form' id='verify_results_form' action='results_verify.php' method='post'>
				<?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>
				&nbsp;&nbsp;&nbsp;
				
				<select id='verify_test_type' name='t_type' class='uniform_width'>
					<option value=""><?php echo LangUtil::$generalTerms['SELECT_ONE']; ?>..</option>
					<?php $page_elems->getTestTypesSelect($_SESSION['lab_config_id']); ?>
				</select>
				&nbsp;&nbsp;&nbsp;
				<input type='button' onclick='javascript:get_verification_form();' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>'></input>
				&nbsp;&nbsp;&nbsp;
				<span id='verify_progress_form' style='display:none'>
					<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
				</span>
				<span id='verify_result_error' class='error_string' style='display:none;'>
					<?php echo LangUtil::$generalTerms['MSG_SELECT_TTYPE']; ?>
				</span>
			</form>
			<br><br>
			<div id='verify_form_div'>
			</div>
		</div>
		
		<div id='control_testing' class='results_subdiv' style='display:none;'>
			<b><?php echo LangUtil::$generalTerms['CONTROL_TESTING_RESULTS']; ?></b>
			<br>
			<br>
			<form name='control_testing_form' id='control_testing_form' action='control_testing_entry.php' method='post'>
				<table cellspacing='4px'>
					<tbody>
					<tr valign='top'>
						<td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?> &nbsp;&nbsp;&nbsp;</td>
						<td>
							<select id='verify_test_type_control' name='t_type' class='uniform_width'>
								<option value=""><?php echo LangUtil::$generalTerms['SELECT_ONE']; ?>..</option>
								<?php $page_elems->getTestTypesSelect($_SESSION['lab_config_id']); ?>
							</select>
							<span id='control_testing_error' class='error_string' style='display:none;'>
								<?php echo LangUtil::$generalTerms['MSG_SELECT_TTYPE']; ?>
							</span>
							<br>
						</td>
					</tr>
					<tr valign='top'>
						<td>Result</td>
						<td>
							<input type="radio" name="controlTesting" id="controlTesting" value="Pass" checked> Pass 
							<input type="radio" name="controlTesting" id="controlTesting" value="Fail"> Fail
							<br>
						</td>
					<tr valign='top'>
						<td></td>
						<td>
							<input type='button' onclick='javascript:verify_control_selection();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
						</td>
					</tr>
					</tbody>
				</table>
			</form>
			<br><br>
			<div id='control_testing_div'>
			</div>
			<div class='clean-orange' id='control_result_done' style='width:300px' style='display:none;'>
						
			</div>
		</div>
		
		<div id='worksheet_div' class='results_subdiv' style='display:none;'>
			<b><?php echo LangUtil::$pageTerms['MENU_WORKSHEET']; ?></b>
			<br>
			<br>
			<form name='worksheet_form' id='worksheet_form' action='worksheet.php' method='post' target='_blank'>
				<table cellspacing='4px'>
					<tbody>
					<tr valign='top'>
						<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></td>
						<td>
							<select name='cat_code' id='cat_code' class='uniform_width'>
								<?php $page_elems->getTestCategorySelect(); ?>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?><br>OR</td>
						<td>
							<select id='worksheet_test_type' name='t_type' class='uniform_width'>
								<?php $page_elems->getTestTypesSelect($_SESSION['lab_config_id']); ?>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td>
							<?php echo LangUtil::$pageTerms['CUSTOM_WORKSHEET']; ?></td>
						<td>
							<select id='worksheet_custom_type' name='w_type' class='uniform_width'>
								<option value=""><?php echo LangUtil::$generalTerms['SELECT_ONE']; ?></option>
								<?php 
								$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
								$page_elems->getCustomWorksheetSelect($lab_config); 
								?>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td><?php echo LangUtil::$pageTerms['BLANK_WORKSHEET']; ?>?</td>
						<td>
							<input type='radio' name='is_blank' value='Y'><?php echo LangUtil::$generalTerms['YES']; ?></input>
							<input type='radio' name='is_blank' value='N' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
						</td>
					</tr>
					<tr valign='top' id='num_rows_row' style='display:none;'>
						<td><?php echo LangUtil::$pageTerms['NUM_ROWS']; ?></td>
						<td>
							<input type='text' name='num_rows' id='num_rows' value='10' class='uniform_width'></input>
						</td>
					</tr>
					<tr valign='top'>
						<td></td>
						<td>
							<input type='button' onclick='javascript:get_worksheet();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
							&nbsp;&nbsp;&nbsp;
							<span id='worksheet_progress_form' style='display:none'>
								<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
							</span>
							<span id='worksheet_error' class='error_string' style='display:none;'>
								<?php echo LangUtil::$generalTerms['MSG_SELECT_TTYPE']; ?>
							</span>
						</td>
					</tr>
				</table>
			</form>
		</div>
		
		
		
		<div id='labsection_div' class='results_subdiv' style='display:none;'>
			<b><?php echo LangUtil::$pageTerms['MENU_LABSECTION']; ?></b>
			<br>
			<br>
			<form name='labsection_form' id='labsection_form' action=''>
				<table cellspacing='4px'>
					<tbody>
					<tr valign='top'>
						<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></td>
						<td>
							<select name='cat_code_labsection' id='cat_code_labsection' class='uniform_width'>
								<?php $page_elems->getTestCategorySelect(); ?>
							</select>
						</td>
						<td>
						  	<input type="button" value="submit" onclick="fetch_specimen_by_lab_section()" />
						</td>
					</tr>
					
				</table>
				<span id='fetch_progress_bar_labsection' style='display:none;'>
					<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
				</span>	
			</form>
			<br><br>
			<div id='labsection_results_div'>
			</div> <br/>
			<div id="fetched_specimen_labsetion">
			<?php
				if(isset($_REQUEST['ajax_response']))
					echo $_REQUEST['ajax_response'];
			?>
			</div>
		</div>
		
		
		
			
		<?php
		if($SHOW_REPORT_RESULTS === true)
		{
		?>
		<div id='report_results' class='results_subdiv' style='display:none;'>
			<b><?php echo LangUtil::$pageTerms['MENU_REPORTRESULTS']; ?></b>
			<span id='report_results_load_progress'>
			&nbsp;&nbsp;&nbsp;
			<?php
			$page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']);
			?>
			</span>
			<br>
			<br>
			<div id='report_results_container'>
			
			<?php 
			/*
			
			*/
			?>
			</div>
		</div>
		<?php
		}
		?>
	</td>
</tr>
</table>
<form id='ajax_redirect' method='post' action='results_entry.php'>
	<input type='hidden' name='sid_redirect' id='sid_redirect' value=''></input>
	<input type='hidden' name='ajax_response' id='ajax_response' value=''></input>
</form>

</form>
<?php
$script_elems->bindEntertoClick("#specimen_id", "#fetch_specimen_button");
?>
<?php include("includes/footer.php"); ?>