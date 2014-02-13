<?php
#
# Main page for verifying results for a particular test type
#
include("redirect.php");
include("includes/header.php");
LangUtil::setPageId("results_entry");

# Helper functions
# TODO: Move them to another library
function get_unverified_tests($test_type_id)
{
	# Fetches all unverified test results
	$query_string = 
		"SELECT * FROM test ".
		"WHERE verified_by=0 ".
		"AND result <> '' ".
		"AND test_type_id=$test_type_id";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$test_entry = Test::getObject($record);
		$retval[] = $test_entry;
	}
	return $retval;
}

# Execution begins here
$script_elems->enableTableSorter();
$script_elems->enableJQueryForm();
$curr_user_id = $_SESSION['user_id'];
$test_type_id = $_REQUEST['t_type'];
$test_type = TestType::getById($test_type_id);
# Fetch all measures for this test type
$measure_list = $test_type->getMeasures();
$test_list = get_unverified_tests($test_type_id);
?>
<script type='text/javascript'>
function show_dialog_box()
{
	$('#confirm_dialog').show();
	$('#confirm_dialog').focus();
}

function hide_dialog_box()
{
	$('#confirm_dialog').hide();
}

function verify_results()
{
	$('#confirm_dialog').hide();
	$('#verify_progress_spinner').show();
	var html_code = "<div class='sidetip_nopos'><?php echo LangUtil::$pageTerms['TIPS_VERIFYDONE']; ?></div>";
	$('#verify_form').ajaxSubmit({
		success: function() { 
			$('#verify_content_pane').html(html_code);
			$('#verify_progress_spinner').hide();
			$('#cancel_link').html("&laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?>");
		}
	});
}

function toggle_verify()
{
}

function checkoruncheckall()
{
	if($('#check_all').attr("checked") == true)
	{
		$(".verify_flag").attr("checked", "true");
	}
	else
	{
		$(".verify_flag").removeAttr("checked");
	}
}
</script>
<br>
<b><?php echo LangUtil::$pageTerms['MENU_VERIFYRESULTS']; ?></b> |
 <a href='javascript:history.go(-1)' id='cancel_link'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
<br><br>
<?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>: <?php echo get_test_name_by_id($test_type_id); ?>
<br><br>
<?php 
if(count($test_list) == 0)
{
	echo "<div class='sidetip_nopos'>".LangUtil::$pageTerms['TIPS_VERIFYNOTFOUND']."</div>";
	include("includes/footer.php");
	return;
}
?>
<div id='verify_content_pane'>
<small><?php echo count($test_list); ?> <?php echo LangUtil::$generalTerms['SPECIMENS']; ?></small><br>
<form name='verify_form' id='verify_form' action='ajax/results_verify_do.php' method='post'>
	<input type='hidden' name='t_type' value='<?php echo $test_type_id; ?>'></input>
	<input type='hidden' name='num_measures' value='<?php echo count($measure_list); ?>'></input>
	<table class='tablesorter' id='verify_result_table'>
	<thead>
		<tr valign='top'>
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
			<?php
			foreach($measure_list as $measure)
			{
				echo "<th>".$measure->getName()." <br><small>";
				if(strpos($measure->range, ":") != false)
				{
					$range_bounds = explode(":", $measure->range);
					echo "(".LangUtil::$generalTerms['RANGE']." $range_bounds[0] - $range_bounds[1])";
				}
				if($measure->unit != "")
					echo " ($measure->unit)";
				echo "</small></th>";
			}
			?>
			<th><?php echo LangUtil::$generalTerms['RESULT_COMMENTS']; ?> (<?php echo LangUtil::$generalTerms['OPTIONAL']; ?>)</th>
			<th><?php echo LangUtil::$generalTerms['ENTERED_BY']; ?></th>
			<th>
			<?php echo LangUtil::$generalTerms['CMD_VERIFY']; ?>?
			<input type='checkbox' name='check_all' id='check_all' checked onchange='javascript:checkoruncheckall();'>
			</input>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach($test_list as $test_entry)
	{
		$result_csv = explode(",", $test_entry->result);
		$specimen = Specimen::getById($test_entry->specimenId);
		$patient = Patient::getById($specimen->patientId);
		if($patient != null){
		?>
		<tr valign='top'>
			<input type='hidden' name='specimen_id[]' value='<?php echo $test_entry->specimenId; ?>'></input>
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
				<td><?php $specimen->getAuxId(); ?></td>
				<?php
			}
			?>
			<td>
			<?php
			echo $patient->name." (".$patient->sex." ".$patient->getAgeNumber().") ";
			?>
			</td>
			<?php
			$measure_count = 1;
			foreach($measure_list as $measure)
			{
				if(strpos($measure->range, ":") != false)
				{
					# Continuous value range
					echo "<td><input type='text' name='measure_".$measure_count."[]' value='".$result_csv[$measure_count-1]."'></input>";
					$range_bounds = explode(":", $measure->range);
					$range_lower = $range_bounds[0];
					$range_upper = $range_bounds[1];
					# If out of range, show red alert indicator
					if($result_csv[$measure_count-1] < $range_lower || $result_csv[$measure_count-1] > $range_upper)
					{
						echo " <img src='img/red_alert.gif' alt='*' title='Valid range is between $range_lower and $range_upper'></img> ";
					}
					echo "</td>";
				}
				else if(strpos($measure->range, "/") != false)
				{	
					# Discrete value range
					$range_options = explode("/", $measure->range);
					?>
					<td>
					<select name='measure_<?php echo $measure_count; ?>[]'>
					<?php
					foreach($range_options as $option)
					{
					?>
						<option value='<?php echo $option; ?>'
						<?php 
						if($option == $result_csv[$measure_count-1])
							echo " selected ";
						?>
						><?php echo $option; ?></option>
					<?php
					}
					?>
					</select>
					</td>
					<?php
				}
				$measure_count++;
			}
			?>
			<td><input name='comments[]' type='text' value='<?php echo $test_entry->comments; ?>'></input></td>
			<td><?php echo get_username_by_id($test_entry->userId); ?></td>
			<td>
				<center>
					<input type='checkbox' class='verify_flag' name='verify_flag_<?php echo $i; ?>' onchange='javascript:toggle_verify(<?php echo $i; ?>);' checked></input>
				</center>
			</td>
		</tr>
		<?php
		$i++;
		}
	}
	?>
	</tbody>
	</table>
	<input type='button' name='submit_button' id='submit_button' onclick='javascript:show_dialog_box();' value='<?php echo LangUtil::$generalTerms['CMD_VERIFY']; ?>'></input>
	&nbsp;&nbsp;&nbsp;
	<small><a href='javascript:history.go(-1)'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
	&nbsp;&nbsp;&nbsp;
	<span id='verify_progress_spinner' style='display:none'>
		<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
	</span>
	<br><br>
	<span>
	<?php 
	$div_id = 'confirm_dialog';
	$msg_string = LangUtil::$pageTerms['TIPS_VERIFYCONFIRM'];
	$ok_function_call = "verify_results()";
	$cancel_function_call = "hide_dialog_box()";
	$page_elems->getConfirmDialog($div_id, $msg_string, $ok_function_call, $cancel_function_call); 
	?>
	</span>
</form>
</div>
<?php include("includes/footer.php"); ?>