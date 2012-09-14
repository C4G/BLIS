<?php
#
# Reports template page
# Save as reports_[reportname].php and modify
# Substitute "[reportname]" by the report name (single word or with underscore)
#

# Include database connection file -- keep unchanged
include("redirect.php");
include("includes/db_lib.php");

# Set page ID for language translation -- keep unchanged
LangUtil::setPageId("reports");

# Enable javascript files -- keep unchanged
include("includes/script_elems.php");
$script_elems = new ScriptElems();
$script_elems->enableJQuery();

# Javascript and PHP code for showing top pane with buttons for 'print', 'export' and 'close page' -- keep unchanged
?>
<script type='text/javascript'>
function export_as_word(div_id)
{
	var content = $('#'+div_id).html();
	$('#word_data').attr("value", content);
	$('#word_format_form').submit();
}

function print_content(div_id)
{
	var DocumentContainer = document.getElementById(div_id);
	var WindowObject = window.open("", "PrintWindow", "toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
}
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
	<input type='button' onclick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:export_as_word('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
</form>
<hr>
<?php # End of top pane and buttons section ?>

<?php 
# Next, report content which is displayed on the page 
# This can also be exported as word or printed out
?>
<div id='report_content'>

	<?php # CSS link for tables in printable reports -- keep unchanged ?>
	<link rel='stylesheet' type='text/css' href='css/table_print.css' />
	
	<?php # Report title, content and tables go here ?>
	<h3>Report Name</h3>
	<br>
	
	<?php
	## Code for read submitted HTML form data
	## Uncomment appropriate lines below
	
	## For date from single lab configuration
	$lab_config_id = $_REQUEST['location'];
	
	## For single patient/specimen report
	# $specimen_id = $_REQUEST['specimen_id'];
	# $patient_id = $_REQUEST['patient_id'];
	
	## For date range related reports
	# $date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
	# $date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
	
	## For test type related reports
	# $test_type_id = $_REQUEST['t_type'];
	
	## For specimen type related reports
	# $specimen_type_id =  $_REQUEST['s_type'];
	
	## For patient related reports
	# $patient_name = $_REQUEST['p_name'];
	?>
	
	<?php
	# Show Report date
	echo LangUtil::$generalTerms['DATE'].": ".date('Y-m-d H:i')."<br>"; 
	?>
	<?php
	# Show Facility name
	$lab_config = get_lab_config_by_id($lab_config_id);
	echo LangUtil::$generalTerms['FACILITY'].": ".$lab_config->getSiteName()."<br>"; 
	?>
	
	<?php
	## Build SQL query string from above data
	## Uncomment and modify appropriate query_string below
	
	## Blanks string
	$query_string = "";
	
	## Patient records
	# $query_string = "SELECT patient_id FROM patient WHERE [condition]";
	
	
	## Specimen records
	# $query_string = "SELECT specimen_id FROM specimen WHERE [condition]";
	
	## Test records
	# $query_string = "SELECT test_id FROM test WHERE [condition]";
	
	## Query the DB and fetch data into PHP -- keep unchanged
	$saved_db = DbUtil::switchToLabConfig($lab_Config_id);
	$resultset = query_associative_all($query_string, $row_count)
		
	## Comment out appropriate lines
	## Array storing list of matched specimens
	$specimen_list = array();
	## Array storing list of matched patients
	$patient_list = array();
	## Array storing list of matched tests
	$test_list = array();
	
	# Store fetched specimens
	foreach($resultset as $record)
	{
		$specimen_list[] = Specimen::getById($record['specimen_id']);
	}
	
	# Store fetched patients
	foreach($resultset as $record)
	{
		$patient_list[] = Specimen::getById($record['patient_id']);
	}
	
	# Store fetched tests
	foreach($resultset as $record)
	{
		$test_list[] = Specimen::getById($record['test_id']);
	}
	?>
	
	<?php
	## Populate table for report
	?>
	<table class='print_entry_border'>
		<thead>
			<tr>
			<?php
			# Table column headings section 
			# Comment out appropriate headings
			
			# Patient related--
			## Patient ID
			echo "<th>LangUtil::$generalTerms['PATIENT_ID']</th>";
			## Patient Name
			echo "<th>LangUtil::$generalTerms['NAME']</th>";
			## Addl ID
			echo "<th>LangUtil::$generalTerms['ADDL_ID']</th>";
			## Patient Age
			echo "<th>LangUtil::$generalTerms['AGE']</th>";
			## Patient Sex
			echo "<th>LangUtil::$generalTerms['GENDER']</th>";
			
			# Specimen related --
			## Specimen ID
			echo "<th>LangUtil::$generalTerms['SPECIMEN_ID']</th>";
			## Specimen Type
			echo "<th>LangUtil::$generalTerms['SPECIMEN_TYPE']</th>";
			## Addl ID
			echo "<th>LangUtil::$generalTerms['ADDL_ID_S']</th>";
			## Date collected
			echo "<th>LangUtil::$generalTerms['C_DATE']</th>";
			## Comments at registration
			echo "<th>LangUtil::$generalTerms['COMMENTS']</th>";
			## List of tests assigned to the specimen
			echo "<th>LangUtil::$generalTerms['TESTS']</th>";
			## Specimen status
			echo "<th>LangUtil::$generalTerms['SP_STATUS']</th>";
				
			# Test related --
			## Date result entered
			echo "<th>LangUtil::$generalTerms['E_DATE']</th>";
			## Result value
			echo "<th>LangUtil::$generalTerms['RESULTS']</th>";
			## Technician comments
			echo "<th>LangUtil::$generalTerms['RESULT_COMMENTS']</th>";
			## Entered by
			echo "<th>LangUtil::$generalTerms['ENTERED_BY']</th>";
			## Verified by
			echo "<th>LangUtil::$generalTerms['VERIFIED_BY']</th>";
			?>
			</tr>
		</thead>
		<tbody>
			<?php
			# Table data columns section
			# Comment out appropriate headings
			
			# Patient entries --
			foreach($patient_list as $patient)
			{
				# New row
				echo "<tr>";
				
				## Patient ID
				echo "<td>".$patient->getSurrogateId()."</td>";
				## Patient Name
				echo "<td>".$patient->getName."</td>";
				## Addl ID
				echo "<td>".$patient->getAddlId()."</td>";
				## Patient Age
				echo "<td>".$patient->getAge()."</td>";
				## Patient Sex
				echo "<td>".$patient->sex."</td>";
				
				# End of row
				echo "</tr>";
			}
			
			# Specimen entries --
			foreach($specimen_list as $specimen)
			{
				# New row
				echo "<tr>";
				
				## Specimen ID
				echo "<td>".$specimen->specimenId."</td>";
				## Specimen Type
				echo "<td>".get_specimen_name_by_id($specimen->specimenTypeId)."</td>";
				## Addl ID
				echo "<td>".$specimen->auxId."</td>";
				## Date collected
				echo "<td>".$specimen->dateCollected."</td>";
				## Comments at registration
				echo "<td>".$specimen->comments."</td>";
				## List of tests assigned to the specimen
				echo "<td>".$specimen->getTestNames()."</td>";
				## Specimen status
				echo "<td>".$specimen->getStatus()."</td>";
				
				# End of row
				echo "</tr>";
			}
			
			foreach($test_list as $test)
			{
				# New row
				echo "<tr>";
				
				## Date result entered
				echo "<td>".LangUtil::$generalTerms['E_DATE']."</td>";
				## Result value
				echo "<td>".$test->decodeResult()."</td>";
				## Technician comments
				echo "<td>".$test->getComments()."</td>";
				## Entered by
                                //NC3065
				//echo "<td>".get_username_by_id($test->verifiedBy);."</td>";
                                echo "<td>".get_username_by_id($test->verifiedBy)."</td>";
				## Verified by
				echo "<td>".$test->getVerifiedBy."</td>";
			
				# End of row
				echo "</tr>";
			}
			
			?>
		</tbody>
	</table>
	<br>
	<?php # Line for Signature ?>
	.............................
	<?php 
	# Restore database 
	DbUtil::switchRestore($saved_db);
	?>
</div>
<?php ## End of reports page ?>