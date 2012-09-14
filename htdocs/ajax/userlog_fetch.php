<?php
#
# Fetches user activity log of a particular user over the given date range
# Called via Ajax from reports_userlog.php
#

include("../includes/db_lib.php");

$saved_session = SessionUtil::save();
LangUtil::setPageId("lab_config_home");

# Helper functions
# TODO: Move these to another library

function get_activity_specimen($lab_config_id, $user_id, $date_from, $date_to)
{
	$query_string = 
		"SELECT * from specimen ".
		"WHERE user_id=$user_id ".
		"AND (date_collected BETWEEN '$date_from' AND '$date_to') ".
		"ORDER BY date_collected DESC";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$specimen = Specimen::getObject($record);
		$retval[] = $specimen;
	}
	return $retval;
}

function get_activity_test($lab_config_id, $user_id, $date_from, $date_to)
{
	$query_string = 
		"SELECT * from test ".
		"WHERE user_id=$user_id ".
		"AND (ts BETWEEN '$date_from' AND '$date_to' ) ".
		"AND result <> '' ORDER BY ts DESC";
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

$lab_config_id = $_REQUEST['l'];
$lab_config = get_lab_config_by_id($lab_config_id);
$user_id = $_REQUEST['u'];
$user =  get_user_by_id($user_id);
$date_from = $_REQUEST['yf']."-".$_REQUEST['mf']."-".$_REQUEST['df'];
$date_to = $_REQUEST['yt']."-".$_REQUEST['mt']."-".$_REQUEST['dt'];
?>
<br>
<b><?php echo LangUtil::$pageTerms['RECENT_ACTIVITY']; ?></b><br>
<?php echo LangUtil::$generalTerms['FACILITY']; ?>: <?php echo $lab_config->getSiteName(); ?> |
<?php echo LangUtil::$generalTerms['USERNAME']; ?>: <?php echo $user->username; ?> 
<br>
<?php echo LangUtil::$generalTerms['FROM_DATE']; ?>: <?php echo DateLib::mysqlToString($date_from); ?> | 
<?php echo LangUtil::$generalTerms['TO_DATE']; ?>: <?php echo DateLib::mysqlToString($date_to); ?> |
<?php echo LangUtil::$generalTerms['G_DATE']; ?>: <?php echo date($_SESSION['dformat'].' H:i'); ?>
<br><br>
<?php
$saved_db = DbUtil::switchToLabConfig($lab_config_id);
# Fetch all tagged entries in specimen table by timestamp
$activity_specimen = get_activity_specimen($lab_config_id, $user_id, $date_from, $date_to);
?>
<b><?php echo LangUtil::$pageTerms['SP_REGNS']; ?></b>
<br><br>
<?php
if(count($activity_specimen) == 0)
{
	echo LangUtil::$pageTerms['TIPS_RECENTACT'];
}
else
{
	?>
	<table class='print_entry_border'>
		<thead>
			<tr valign='top'>
				<th>#</th>
				<th><?php echo LangUtil::$generalTerms['R_DATE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TESTS']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$count = 1;
		foreach($activity_specimen as $entry)
		{
			echo "<tr valign='top'>";
			echo "<td>$count</td>";
			echo "<td>".DateLib::mysqlToString($entry->dateRecvd)."</td>";
			echo "<td>";
			$entry->getAuxId();
			echo "</td>";
			echo "<td>".get_specimen_name_by_id($entry->specimenTypeId)."</td>";
			echo "<td>".$entry->getTestNames()."</td>";
			echo "</tr>";
			$count++;
		}
		?>
		</tbody>
	</table>
	<?php
}
# Fetch all tagged entrues in test table by timestamp
$activity_test = get_activity_test($lab_config_id, $user_id, $date_from, $date_to);
?>
<br><br>
<b><?php echo LangUtil::$pageTerms['RE_ENTRIES']; ?></b>
<br><br>
<?php
if(count($activity_test) == 0)
{
	echo LangUtil::$pageTerms['TIPS_RECENTACT'];
}
else
{
	?>
	<table class='print_entry_border'>
		<thead>
			<tr valign='top'>
				<th>#</th>
				<th><?php echo LangUtil::$generalTerms['E_DATE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
				<th><?php echo LangUtil::$generalTerms['TEST']; ?></th>
				<th><?php echo LangUtil::$generalTerms['RESULTS']; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$count = 1;
		foreach($activity_test as $entry)
		{
			echo "<tr valign='top'>";
			echo "<td>$count</td>";
			$timestamp_parts = explode(" ", $entry->timestamp);
			$time_parts = explode(":", $timestamp_parts[1]);
			$specimen = Specimen::getById($entry->specimenId);
			echo "<td>".DateLib::mysqlToString($timestamp_parts[0])." $time_parts[0]:$time_parts[1]</td>";
			echo "<td>";
			$specimen->getAuxId();
			echo "</td>";
			echo "<td>".get_specimen_name_by_id($specimen->specimenTypeId)."</td>";
			echo "<td>".get_test_name_by_id($entry->testTypeId)."</td>";
			echo "<td>".$entry->decodeResult()."</td>";
			echo "</tr>";
			$count++;
		}
		?>
		</tbody>
	</table>
	<?php
}
DbUtil::switchRestore($saved_db);

SessionUtil::restore($saved_session);
?>
<br><br>
..............................