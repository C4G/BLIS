<?php
#
# Adds batch results for a single test type
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("results_entry");

$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
$DEBUG = false;

$user_id = $_SESSION['user_id'];
$test_type_id = $_REQUEST['t_type'];
$test_name = get_test_name_by_id($test_type_id);
$num_measures = $_REQUEST['num_measures'];
$specimen_id_list = $_REQUEST['specimen_id'];
$measure_list = array();
$field_result = array();

$comments_list = $_REQUEST['comments'];

if($DEBUG)
{
	
	echo $measure_list[0][0];
	
	echo $test_type_id;
	echo $num_measures;
	print_r($specimen_id_list);
	print_r($measure_list[2]);
	print_r($comments_list);
}

# Collect table values in row-wise manner
$specimen_done_list = array();
$status_list = array();
$test_list = array();
for($i = 0; $i < count($specimen_id_list); $i++) {
	$empty_result_field = false;
	$specimen_id = $specimen_id_list[$i];
	$test = get_test_entry($specimen_id, $test_type_id);
	if(isset($_REQUEST['skip_'.($i+1)])) {
		# This specimen result skipped by user
		$specimen_done_list[] = $specimen_id;
		$test_list[] = $test;
		$status_list[] = LangUtil::$generalTerms['SKIPPED'];
		continue;
	}
	if($specimen_id == "") {
		# Empty or incomplete row
		continue;
	}
	if(check_specimen_id($specimen_id) == false) {
		# Error: This test type was not scheduled for current specimen ID
		$status_list[] = "<font color='red'>".LangUtil::$generalTerms['ERROR']."</font>: ".LangUtil::$generalTerms['SPECIMEN_ID']." ".LangUtil::$generalTerms['MSG_NOTFOUND'];
		$specimen_done_list[] = $specimen_id;
		$test_list[] = $test;
		continue;
	}
	$result_values = array();
	
	for($x = 0; $x < $num_measures; $x++) {
		$k = 0;
		$field_name = "measure_".$specimen_id."_".($x+1);
		foreach( $_REQUEST[$field_name] as $field )
			$measure_list[$x][$k++] = $field."_";
		# replace the final underscore with a comma
		$measure_list[$x][$k-1] = substr( $measure_list[$x][$k-1], 0, strlen($measure_list[$x][$k-1]) -1 );
		$measure_list[$x][$k-1] .= ",";
	}
	
	for($j = 0; $j < $num_measures; $j++) {
		$k = 0;
		if( (trim($measure_list[$j][$k]) == "") && ($k == 0) )
			$empty_result_field = true;
		else {
			while( ( trim($measure_list[$j][$k]) ) != "" ) 
				$result_values[] .= $measure_list[$j][$k++];
		}
	}

	unset($measure_list);
	//$result_csv = implode(",", $result_values).",";
	$result_csv = "";

	foreach( $result_values as $result_value) 
		$result_csv .= $result_value;
	unset($result_values);
	$result_csv = preg_replace("/[^a-zA-Z0-9,.;:_\s]/", "", $result_csv);
	
	$comments = $comments_list[$i];
	$comments = preg_replace("/[^a-zA-z0-9,.;:_\s]/", "", $comments);
	# Fetch entry in 'test' table
	if($test == null)
	{
		# Error: This test type was not scheduled for current specimen ID
		$status_list[] = "<font color='red'>".LangUtil::$generalTerms['ERROR']."</font>";
	}
	else if($test->isPending() == false)
	{
		# Error: Results already entered
		$status_list[] = "<font color='red'>".LangUtil::$generalTerms['ERROR']."</font>: ".LangUtil::$pageTerms['MSG_ALREADYENTERED'];		
	}
	else if($empty_result_field == true)
	{
		# Error: Result value missing
		$status_list[] = "<font color='red'>".LangUtil::$generalTerms['ERROR']."</font>: ".LangUtil::$pageTerms['MSG_RESULTMISSING'];		
	}
	else
	{
		# Add result values
		$test_id = $test->testId;
		$test->result = $result_csv;
		$specimen=Specimen::getById($specimen_id);
		$patient = Patient::getById($specimen->patientId);
		add_test_result($test_id, $result_csv, $comments, $specimen_id, $user_id,"",$patient->hashValue);
		$status_list[] = "<font color='green'>".LangUtil::$generalTerms['MSG_ADDED']."</font>";
	}
	$specimen_done_list[] = $specimen_id;
	$test_list[] = $test;
}
?>
<<script type="text/javascript">
function fetch_specimen3(specimen_id, test_id)
{
	var url = "related_tests_results_entry.php";
	window.location = url+"?specimen_id="+specimen_id+"&test_id="+test_id;
}
</script>
<br>
<b><?php echo LangUtil::$pageTerms['MENU_BATCHRESULTS']; ?></b>: <?php echo $test_name;?>
 | <a href='results_entry.php'>&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
<br><br>
<table class='tablesorter' id='status_table'>
	<thead>
		<tr>
			<?php
			if($_SESSION['pid'] != 0)
			{
				?>
				<th><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
				<?php
			}
			if($_SESSION['dnum'] != 0)
			{
				?>
				<th><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></th>
				<?php
			}
			if($_SESSION['s_addl'] != 0)
			{
				?>
				<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
				<?php
			}
			?>
			<th><?php echo LangUtil::$generalTerms['PATIENT']; ?></th>
			<th><?php echo LangUtil::$generalTerms['SP_STATUS']; ?></th>			
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
	for($i = 0; $i < count($specimen_done_list); $i++)
	{
		$specimen_id = $specimen_done_list[$i];
		$status = $status_list[$i];
		$test_entry = $test_list[$i];
		$specimen = Specimen::getById($specimen_id);
		$patient = Patient::getById($specimen->patientId);
		?>
		<tr>
			<?php
			if($_SESSION['pid'] != 0)
			{
				?>
				<td><?php echo $patient->getSurrogateId(); ?></td>
				<?php
			}
			if($_SESSION['dnum'] != 0)
			{
				?>
				<td><?php echo $specimen->getDailyNum(); ?></td>
				<?php
			}
			if($_SESSION['s_addl'] != 0)
			{
				?>
				<td>	
					<?php $specimen->getAuxId(); ?>	
				</td>
				<?php
			}
			?>
			<td>
				<?php
				echo $patient->name." (".$patient->sex." ".$patient->getAgeNumber().") ";
				?>
			</td>
			<td>
				<?php echo $status; ?>
				&nbsp;&nbsp;
				<?php
				if($test_entry != null && $test_entry->isPending() !== true)
				{
					echo "<br>";
					echo $test_entry->decodeResult();
				}
				?>
			</td>
			<td>
				<?php
				# Link for patient report
				# Form date range from specimen collection date
				$date_parts = explode("-", $specimen->dateRecvd);
				$url1 = "reports_testhistory.php?location=".$_SESSION['lab_config_id']."&patient_id=$patient->patientId&yf=".$date_parts[0]."&mf=".$date_parts[1]."&df=".$date_parts[2]."&yt=".$date_parts[0]."&mt=".$date_parts[1]."&dt=".$date_parts[2]."&ip=1";
				$url2 = "specimen_info.php?sid=$specimen_id";
				//if(strpos($status, "Error") === false)
				if(true)
				{
				?>
					<a href='<?php echo $url1; ?>' target='_blank' title='Click to generate printable report'><?php echo LangUtil::$generalTerms['CMD_GETREPORT']; ?></a>
					&nbsp;&nbsp;&nbsp;
				<?php
				}
				?>
			</td>
			<td><a href="javascript:fetch_specimen3(<?php echo $specimen->specimenId;?>,<?php echo $test_type_id; ?>)">Related Tests for this specimen</a></td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>
<?php include("includes/footer.php"); ?>