<?php
#
# Show printable custom workshete
# Called via POST from results_entry.php
# Redirected from worksheet.php
#

include("redirect.php");
include("includes/db_lib.php");
LangUtil::setPageId("results_entry");

include("includes/script_elems.php");
include("includes/page_elems.php");

$page_elems = new PageElems();
$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableDragTable();

$saved_session = SessionUtil::save();

$worksheet_id = $_REQUEST['id'];
$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

if($lab_config == null)
{
	echo LangUtil::$generalTerms['MSG_NOTFOUND']; 
	SessionUtil::restore($saved_session);
	return;
}
$worksheet = CustomWorksheet::getById($worksheet_id, $lab_config);
if($worksheet == null)
{
	echo LangUtil::$generalTerms['MSG_NOTFOUND']; 
	SessionUtil::restore($saved_session);
	return;
}

$num_rows = 10;
if(!isset($_REQUEST['bn']) || is_nan($_REQUEST['bn']))
	$num_rows = 10;
else
	$num_rows = intval($_REQUEST['bn']);
	
$margin_list = $worksheet->margins;
for($i = 0; $i < count($margin_list); $i++)
{
	$margin_list[$i] = ($SCREEN_WIDTH * $margin_list[$i] / 100);
}
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
	var html_code = DocumentContainer.innerHTML;
	if($('#do_landscape').is(":checked"))
		html_code += "<style type='text/css'> #report_config_content {-moz-transform: rotate(-90deg) translate(-300px); } </style>";
	WindowObject.document.writeln(html_code);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
	//javascript:window.print();
}

$(document).ready(function(){
	$('.report_content_table').tablesorter();
});
</script>
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
</form>
<input type='checkbox' id='do_landscape' <?php
if($worksheet->landscape == true) echo " checked ";
?>><?php echo LangUtil::$generalTerms['LANDSCAPE']; ?></input>&nbsp;&nbsp;

<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:export_as_word('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
<hr>
<div id='export_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<style type='text/css'>
	<?php $page_elems->getReportConfigCss($margin_list, false); ?>
</style>
<div id='report_config_content'>
<?php

?>
<h3><?php echo $worksheet->headerText; ?> | 
	<?php echo LangUtil::$generalTerms['G_DATE']; ?>: <?php echo date($_SESSION['dformat']); ?>
</h3>
<h3><?php echo $worksheet->titleText; ?></h3>
<?php
$test_id_list = $worksheet->testTypes;
?>
<table id='worksheet_custom_<?php echo $worksheet_id; ?>' class='print_border report_content_table draggable'>
	<thead>
	<tr valign='top'>
	<?php
	if($worksheet->idFields[CustomWorksheet::$OFFSET_PID] == 1)
	{
		echo "<th>".LangUtil::$generalTerms['PATIENT_ID']."</th>";
	}
	if($worksheet->idFields[CustomWorksheet::$OFFSET_DNUM] == 1)
	{
		echo "<th>".LangUtil::$generalTerms['PATIENT_DAILYNUM']."</th>";
	}
	if($worksheet->idFields[CustomWorksheet::$OFFSET_ADDLID] == 1)
	{
		echo "<th>".LangUtil::$generalTerms['ADDL_ID']."</th>";
	}
	foreach($worksheet->userFields as $field_entry)
	{
		$field_name = $field_entry[1];
		$field_width = $field_entry[2];
		$width_val_px = intval($SCREEN_WIDTH * $field_width /100);
		echo "<th style='width:$width_val_px;'>".$field_name."</th>";
	}
	foreach($test_id_list as $test_type_id)
	{
		$test_type = TestType::getById($test_type_id);
		$measure_list = $test_type->getMeasures();
		foreach($measure_list as $measure)
		{
			$width_val_percent = $worksheet->columnWidths[$test_type_id][$measure->measureId];
			$width_val_px = intval($SCREEN_WIDTH * $width_val_percent /100);
			echo "<th style='width:$width_val_px;'>".$test_type->getName()."</th>";
		}
		
	}
	# Extra blank column
	echo "<th style='width:100px;'></th>";
	?>
	</tr>
	<tr valign='top'>
	<?php
	if($worksheet->idFields[CustomWorksheet::$OFFSET_PID] == 1)
	{
		echo "<th></th>";
	}
	if($worksheet->idFields[CustomWorksheet::$OFFSET_DNUM] == 1)
	{
		echo "<th></th>";
	}
	if($worksheet->idFields[CustomWorksheet::$OFFSET_ADDLID] == 1)
	{
		echo "<th></th>";
	}
	foreach($worksheet->userFields as $field_entry)
	{
		echo "<th></th>";
	}
	foreach($test_id_list as $test_type_id)
	{
		$test_type = TestType::getById($test_type_id);
		$measure_list = $test_type->getMeasures();
		foreach($measure_list as $measure)
		{
			echo "<th>";
			if(count($measure_list) != 1)
				echo $measure->getName()." ";
			echo $measure->getRangeString();
			echo "</th>";
		}
	}
	# Extra blank column
	echo "<th></th>";
	?>
	</tr>
	</thead>
	<tbody>
	<?php
	for($i = 0; $i <= $num_rows; $i++)
	{
		echo "<tr valign='top'>";
		if($worksheet->idFields[CustomWorksheet::$OFFSET_PID] == 1)
		{
			echo "<td><br><br></td>";
		}
		if($worksheet->idFields[CustomWorksheet::$OFFSET_DNUM] == 1)
		{
			echo "<td><br><br></td>";
		}
		if($worksheet->idFields[CustomWorksheet::$OFFSET_ADDLID] == 1)
		{
			echo "<td><br><br></td>";
		}
		foreach($worksheet->userFields as $field_entry)
		{
			echo "<td><br><br></td>";
		}
		foreach($test_id_list as $test_type_id)
		{
			$test_type = TestType::getById($test_type_id);
			$measure_list = $test_type->getMeasures();
			foreach($measure_list as $measure)
			{
				echo "<td><br><br></td>";
			}
		}
		# Extra blank column
		echo "<td><br><br></td>";
		echo "</tr>";
	}
	?>
	</tbody>
</table>
<h4><?php echo $worksheet->footerText; ?></h4>
</div>
</div>
<?php SessionUtil::restore($saved_session); ?>