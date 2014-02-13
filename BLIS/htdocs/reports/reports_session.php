<?php
#
# Creates printable report for all single specimens in one session
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");
LangUtil::setPageId("reports");

# Helper function to fetch test record
function get_test_record($specimen_id, $test_type_id)
{
	$query_string = 
		"SELECT * FROM test ".
		"WHERE specimen_id=$specimen_id AND test_type_id=$test_type_id ";
	$record = query_associative_one($query_string);
	$test_entry = Test::getObject($record);
	return $test_entry;
}

function list_results($test_entry, $not_bold_measure_name)
{
	$measure_list = get_test_type_measure($test_entry->testTypeId);
	if($test_entry->isPending())
	{
		echo LangUtil::$generalTerms['PENDING_RESULTS']."<br>";
		return;
	}
	$print_range_label = false;
	for($i = 0; $i < count($measure_list); $i++)
	{
		$curr_measure = $measure_list[$i];
		$range = $curr_measure->range;
		if(strpos($range, ":"))
		{
			# Numeric range exists: Show range label ("Golabl Normal Ranges")
			$print_range_label = true;
			break;
		}
	}
	$result_list = explode(",", $test_entry->result);
	?>
	<table cellspacing='6px' style='text-align:center;'>
		<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>
			<?php 
			if($print_range_label)
				echo LangUtil::$pageTerms['RANGE_NORMAL'];
			?>
			</td>
			<td>
				<?php echo LangUtil::$generalTerms['RESULT_COMMENTS']; ?>
			</td>
		</tr>
		<?php
		for($i = 0; $i < count($measure_list); $i++)
		{
			# Pretty print
			$curr_measure = $measure_list[$i];
			echo "<tr>";
				echo "<td>";
				if($not_bold_measure_name)
				{
					echo $curr_measure->getName();
				}
				else
				{
					echo "<b>".$curr_measure->getName()."<b>";
				}
				echo "</td>";
				echo "<td>$result_list[$i]</td>";
				echo "<td>";
				if(trim($curr_measure->unit) != "")
					echo "[$curr_measure->unit]";
				echo "</td>";
				echo "<td>";
				if($print_range_label)
				{
					$range = $curr_measure->range;
					if(strpos($range, ":"))
					{
						$range_bounds = explode(":", $range);
						echo "($range_bounds[0] - $range_bounds[1])";
					}
					else
					{
						//Do nothing
					}
				}
				echo "</td>";
				echo "<td>";
				if(trim($test_entry->comments) == "")
					echo "-";
				else
					echo $test_entry->comments;
				echo "</td>";
			echo "</tr>";
		}
		?>
		</tbody>
	</table>
	<?php
}

$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableLatencyRecord();
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
	//javascript:window.print();
}
</script>
<?php
$lab_config_id = $_REQUEST['location'];
$saved_db = DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
?>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
	<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:export_as_word('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
</form>
<hr>
<div id='export_content'>
<style type='text/css'>
#export_content { margin-left: 30px; }
</style>
<h2><?php echo $lab_config->getSiteName(); ?></h2>
<h3>
<?php 
$from_redirect = false;
$session_num = 0;
$specimen_list = array();
$patient_list = array();
if(isset($_REQUEST['fp']))
{
	echo LangUtil::$pageTerms['MENU_PATIENT'];
	$from_redirect = true;
	$specimen_id_list = explode(",", $_REQUEST['slist']);
	foreach($specimen_id_list as $specimen_id)
	{
		if(trim($specimen_id) === "")
			continue;
		$specimen = Specimen::getById($specimen_id);
		$specimen_list[] = $specimen;
		$patient_list[] = $specimen->patientId;
	}
	$seed_pid = $patient_list[0];
	$same_patients = true;
	for($i = 1; $i < count($patient_list); $i++)
	{
		if($patient_list[$i] != $seed_pid)
		{
			$same_patients = false;
		}
	}
	if($same_patients === false)
	{
		echo "<br>".LangUtil::$generalTerms['ERROR'].": ".LangUtil::$pageTerms['TIPS_MULTPATIENTS'];
		return;
	}
}
else
{
	echo "Complete Session Report";
	$session_num = $_REQUEST['session_num'];
	$specimen_list = get_specimens_by_session($session_num);
}
?>
</h3>
<?php echo LangUtil::$generalTerms['DATE']; ?>: <?php echo date('Y-m-d H:i'); ?>
<?php 
if($from_redirect === false)
{
	echo LangUtil::$generalTerms['ACCESSION_NUM']." : ".$session_num;
}
else
{
	# Do nothing
}
?>
<br>
<?php
if($specimen_list == null || count($specimen_list) == 0)
{
	echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['SPECIMEN_ID']." $specimen_id - ".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
	return;
}
//$specimen = get_specimen_by_id($specimen_id);
$patient = get_patient_by_id($specimen_list[0]->patientId);
?>

<?php echo LangUtil::$generalTerms['PATIENT_ID']; ?>: <?php echo $patient->patientId; ?>
&nbsp;&nbsp;&nbsp;
<?php echo LangUtil::$generalTerms['NAME']; ?>: <?php echo $patient->name; ?>
<br>
<?php echo LangUtil::$generalTerms['AGE']; ?>: <?php echo $patient->getAge(); ?>
&nbsp;&nbsp;&nbsp;
<?php echo LangUtil::$generalTerms['DOB']; ?>: <?php echo $patient->getDob(); ?>
&nbsp;&nbsp;&nbsp;
<?php echo LangUtil::$generalTerms['GENDER']; ?>: <?php echo $patient->sex; ?>
<br>
<hr>
<?php
foreach($specimen_list as $specimen)
{
	if($specimen == null)
	{
		echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['SPECIMEN_ID']." $specimen_id - ".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
		return;
	}
	$specimen_id = $specimen->specimenId;
	$patient = get_patient_by_id($specimen->patientId);
	?>
	<?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?>: <?php echo $specimen_id; ?>
	&nbsp;&nbsp;&nbsp;
	<?php echo LangUtil::$generalTerms['TYPE']; ?>: <?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?>
	&nbsp;&nbsp;&nbsp;
	<?php echo LangUtil::$generalTerms['R_DATE']; ?>: <?php echo DateLib::mysqlToString($specimen->dateRecvd); ?>
	<?php
	if(trim($specimen->comments) != "")
	{
		echo "<br>";
		echo LangUtil::$generalTerms['COMMENTS']; ?>: <?php echo $specimen->comments;
	}
	?>
	<br><br>
	<?php 
	$test_list = get_tests_by_specimen_id($specimen_id);
	foreach($test_list as $test_entry)
	{
		$test_name = get_test_name_by_id($test_entry->testTypeId);
		$measure_list = get_test_type_measure($test_entry->testTypeId);
		$print_test_name = true;
		if(count($measure_list) == 1)
		{
			# Do nothing
			$print_test_name = false;
		}
		else
		{
			echo "<b>$test_name</b>";
			echo "<br>";
		}		
		if($test_entry == null)
		{
			echo "ERROR: Test type $test_name was not registered for Sample ID $specimen_id<br>";
		}
		else
		{
			list_results($test_entry, $print_test_name);
		}
	}
	?>
	<hr>
	<br>
<?php
}
DbUtil::switchRestore($saved_db);
?>
...................................

</div>