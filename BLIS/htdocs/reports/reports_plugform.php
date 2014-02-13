<?php
#
# PHP code for a new report plug in 
# In the file reports/reports.php: 
# copy this code after the line saying PLUG_FORM_DIV
# Substitute "[reportname]" by the report name (single word or with underscore)
?>

<?php # Report form ?>
<div id='[reportname]_div' style='display:none;' class='reports_subdiv'>
<?php # Set id attribute above by replacing [reportname] part ?>
	<b>Report Name</b>
	<br><br>
	<form name="[reportname]_form" id="[reportname]_form" action="reports/reports_[reportname].php" method='post' target='_blank'>
		<table cellpadding="4px">
			<?php 
			# Form entry table: Each row <tr> is for a single field
			# Remove unneeded rows <tr> to </tr>
			?>
		
			<?php # Select lab faciity ?>
			<tr>
				<td><?php echo LangUtil::$generalTerms['FACILITY']; ?> </td>
				<td>
					<select name='location' id='location20' class='uniform_width'>
					<?php
						$page_elems->getSiteOptions();
					?>
					</select>
				</td>
			</tr>
			
			<?php # Select from_date ?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['FROM_DATE']; ?> </td>
				<td>
				<?php
					$name_list = array("yyyy_from", "mm_from", "dd_from");
					$id_list = array("yyyy_from20", "mm_from20", "dd_from20");
					$value_list = $monthago_array;
					$page_elems->getDatePicker($name_list, $id_list, $value_list);
				?>
				</td>
			</tr>
			
			<?php # Select to_date ?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['TO_DATE']; ?> </td>
				<td>
				<?php
					$name_list = array("yyyy_to", "mm_to", "dd_to");
					$id_list = array("yyyy_to20", "mm_to20", "dd_to20");
					$value_list = $today_array;
					$page_elems->getDatePicker($name_list, $id_list, $value_list);
				?>
				</td>
			</tr>
			
			<?php # Enter specimen_id ?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?> </td>
				<td>
					<input type='text' name='specimen_id' value=''></input>
				</td>
			</tr>
			
			<?php # Enter patient_id ?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?> </td>
				<td>
					<input type='text' name='patient_id' value=''></input>
				</td>
			</tr>
			
			<?php # Enter patient_name ?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?> </td>
				<td>
					<input type='text' name='p_name' value=''></input>
				</td>
			</tr>
			
			<?php # Enter specimen_id ?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?> </td>
				<td>
					<input type='text' name='specimen_id' value=''></input>
				</td>
			</tr>
			
			<?php # Select test_type ?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?> </td>
				<td>
					<select name='t_type'>
						<?php $page_elems->getTestTypesSelect(""); ?>
					</select>
				</td>
			</tr>
			
			<?php # Select specimen_type ?>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?> </td>
				<td>
					<select name='t_type'>
						<?php $page_elems->getSpecimenTypesSelect(""); ?>
					</select>
				</td>
			</tr>
			
			<?php # Submit button ?>
			<tr>
				<td></td>
				<td>
					<br>
					<input type='submit' id='[report_name]_submit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
				</td>
			</tr>
		</table>
	</form>
	
</div>