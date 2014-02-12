<?php
#
# Creates printable report for specimen log
# Showing all operations on that specimen
#
include("redirect.php");
include("includes/db_lib.php");
LangUtil::setPageId("reports");

$lab_config_id = $_REQUEST['location'];
DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
$specimen_id = $_REQUEST['specimen_id'];
$specimen = get_specimen_by_id($specimen_id);
putUILog('reports_specimenlog', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
?>
<script type='text/javascript'>
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
<input type='hidden' name='data' value='' id='word_data' />
<input type='button' onclick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
<hr>
<div id='report_content'>
<?php echo LangUtil::$generalTerms['FACILITY']; ?>: <?php echo $lab_config->getSiteName(); ?> |
<?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?>: <?php $specimen->getAuxId(); ?> |
<?php echo LangUtil::$generalTerms['G_DATE']; ?>: <?php echo date($_SESSION['dformat'].' H:i'); ?>
<br><br>
<?php
if($specimen == null)
{
	echo LangUtil::$generalTerms['ERROR']." : ".LangUtil::$generalTerms['MSG_NOTFOUND'];
	return;
}
?>
<b><?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?></b>: <?php echo $specimen->getTypeName();?>
<br>
<b><?php echo LangUtil::$generalTerms['C_DATE']; ?></b>: <?php echo DateLib::mysqlToString($specimen->dateCollected)." ".$specimen->timeCollected; ?>
<br>
<b><?php echo LangUtil::$generalTerms['R_DATE']; ?></b>: <?php echo DateLib::mysqlToString($specimen->dateRecvd); ?>
<br>
<b><?php echo LangUtil::$generalTerms['REGD_BY']; ?></b>: <?php echo get_username_by_id($specimen->userId); ?>
<br>
<b><?php echo LangUtil::$generalTerms['TESTS']; ?></b>:
<br>
<?php
$test_list = get_tests_by_specimen_id($specimen_id);
foreach($test_list as $test)
{
	echo get_test_name_by_id($test->testTypeId)." :- <br>";
	if($test->isPending())
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;".LangUtil::$generalTerms['PENDING_RESULTS'];
	}
	else
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;".LangUtil::$generalTerms['ENTERED_BY'].": ".get_username_by_id($test->userId)." on: ".$test->timestamp;
	}
	echo "<br>";
	if($test->isVerified())
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;".LangUtil::$generalTerms['VERIFIED_BY'].": ".get_username_by_id($test->verifiedBy)." on: ".$test->getDateVerified();
	}
	else
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;".LangUtil::$generalTerms['PENDING_VER'];
	}
	echo "<br>";
	if($specimen->isReported())
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;".LangUtil::$generalTerms['REPORTED'].": ".$specimen->getDateReported();
		echo "<br>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;".LangUtil::$generalTerms['REPORT_TO'].": ".$specimen->getReportTo();
	}
	else
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;".LangUtil::$generalTerms['REPORTED_NOT'];
	}
	echo "<br>";
}
?>
</div>