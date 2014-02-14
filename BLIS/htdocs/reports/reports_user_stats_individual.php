<?php
#
# Main page for showing disease report and options to export
# Called via POST from reports.php
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/stats_lib.php");
include("includes/script_elems.php");
LangUtil::setPageId("reports");

$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableFlotBasic();
$script_elems->enableFlipV();
$script_elems->enableTableSorter();
$script_elems->enableLatencyRecord();
?>
<script type='text/javascript'>
function export_as_word()
{
	var html_data = $('#report_content').html();
	$('#word_data').attr("value", html_data);
	//$('#export_word_form').submit();
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
<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
	<input type='hidden' name='lab_id' value='<?php echo $lab_config_id; ?>' id='lab_id'>
	<input type='button' onclick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:export_as_word();" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
</form>
<hr>
<?php /*
<form name='export_word_form' id='export_word_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' value='' id='word_data' name='data'></input>
</form>
*/
?>
<div id='report_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<b><?php echo "User Log"; ?></b>
<br><br>
<?php
$lab_config_id = $_REQUEST['location'];
$lab_config = LabConfig::getById($lab_config_id);
if($lab_config == null)
{
	echo LangUtil::$generalTerms['MSG_NOTFOUND'];
	return;
}
$date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
$date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
$ust = new UserStats();
//echo "<pre>";
//echo "</pre>";

$log_type = $_REQUEST['log_type'];
$user_id = $_REQUEST['user_id'];
$uiinfo = "from=".$date_from."&to=".$date_to."&ud=".$user_id."&ld=".$log_type;
putUILog('reports_user_stats_individual', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
$user_obj = get_user_by_id($user_id);
?>
<script type='text/javascript'>
		$(document).ready(function(){
			$('#testsdone_table').tablesorter();
		});
		</script>
<table>
	<tbody>
		<tr>
			<td><?php echo LangUtil::$generalTerms['FACILITY']; ?>:</td>
			<td><?php echo $lab_config->getSiteName(); ?></td>
		</tr>
                <tr>
			<td><?php echo "User"; ?>:</td>
			<td><b><?php echo $user_obj->actualName; ?></b></td>
		</tr>
                <tr>
			<td><?php echo "User ID"; ?>:</td>
			<td><?php echo $user_obj->username; ?></td>
		</tr>
                <tr>
			<td><?php echo "Designation"; ?>:</td>
			<td><?php  
                        if ($user_obj->level == 0 || $user_obj->level == 1 || $user_obj->level == 13)
                            echo "Technician";
                        else if ($user_obj->level == 2)
                            echo "Administrator";
                        else if ($user_obj->level == 5)
                            echo "Clerk";
                        ?></td>
		</tr>
		<tr>
			<td><?php echo LangUtil::$pageTerms['REPORT_PERIOD']; ?>:</td>
			<td>
			<?php
			if($date_from == $date_to)
			{
				echo DateLib::mysqlToString($date_from);
			}
			else
			{	
				echo DateLib::mysqlToString($date_from)." to ".DateLib::mysqlToString($date_to);
			}
			?>
			</td>
		</tr>
                <tr>
			<td><?php echo "Log Type"; ?>:</td>
			<td>
			<?php
                            if($log_type == 1)
                                echo "Patients Registry Log";
                            else if($log_type == 2)
                                echo "Specimens Registry Log";
                            else if($log_type == 3)
                                echo "Tests Registry Log";
                            else if($log_type == 4)
                                echo "Results Entry Log";
                            else if($log_type == 5)
                                echo "Inventory Transaction Log";
			?>
			</td>
		</tr>
		
	</tbody>
</table>
<?php
$table_css = "style='padding: .3em; border: 1px black solid; font-size:14px;'";
?>
<br>
<?php if($log_type == 1) { ?> 
<table style='border-collapse: collapse;' id='testsdone_table'>
	<thead>
		<tr>
                    <th><?php 
                        $count = 0;
                        echo "S.No.";
                    ?></th>
			<th>Patient Name</th>
			<th>Patient ID</th>
                        <th>Patient Number</th>
                        <th>Patient Gender</th>
                        <th>Patient Age</th>
                        <th>Date of Registration</th>
		</tr>
	</thead>
	<tbody>
	<?php
        $all_entries = $ust->getPatientRegLog($user_id, $lab_config_id,$date_from, $date_to);
	foreach($all_entries as $entry)
	{
            ?>
            <tr>
                    <td>
                        <?php 
                            $count++;
                            echo $count; 
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            if($entry->name != '')
                                echo $entry->name; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry->surrogateId != '')
                                echo $entry->surrogateId; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                            $entr = $entry->getDailyNum();
                            if($entr != '')
                               echo $entr;
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry->sex != '')
                                echo $entry->sex; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            $entr = $entry->getAge();
                            if($entr != '')
                                echo $entr; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                           if($entry->regDate != '')
                               echo $entry->regDate;
                            else
                                echo '-';
                        ?>
                    </td>
                   
            </tr>
        <?php
        }
	?>
	</tbody>
</table>
<?php } ?>

<?php if($log_type == 2) { ?> 
<table style='border-collapse: collapse;' id='testsdone_table'>
	<thead>
		<tr>
                    <th><?php 
                        $count = 0;
                        echo "S.No.";
                    ?></th>
			<th>Specimen Name</th>
			<th>Specimen ID</th>
                        <th>Patient Name</th>
                        <th>Patient ID</th>
                        <th>Date of Registration</th>
		</tr>
	</thead>
	<tbody>
	<?php
        $all_entries = $ust->getSpecimenRegLog($user_id, $lab_config_id,$date_from, $date_to);
	foreach($all_entries as $entry)
	{
            ?>
            <tr>
                    <td>
                        <?php 
                            $count++;
                            echo $count; 
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            $tname = $entry->getTypeName();
                            if($tname != '')
                                echo $tname; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry->specimenId != '')
                               echo $entry->specimenId; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                            $entr2 = get_patient_by_sp_id($entry->specimenId);
                            $entr = $entr2[0]->name;
                            if($entr != '')
                               echo $entr;
                           else
                                echo '-';
                        ?>
                    </td>
                 
                    <td>
                        <?php 
                            $entr = $entry->patientId;
                            if($entr != '')
                                echo $entr; 
                            else
                                echo '-';
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            $entr = $entry->dateCollected;
                            if($entr != '')
                                echo $entr; 
                            else
                                echo '-';
                        ?>
                    </td>
                    
                   
            </tr>
        <?php
        }
	?>
	</tbody>
</table>
<?php } ?>


<?php if($log_type == 3) { ?> 
<table style='border-collapse: collapse;' id='testsdone_table'>
	<thead>
		<tr>
                    <th><?php 
                        $count = 0;
                        echo "S.No.";
                    ?></th>
			<th>Test Name</th>
			<th>Test ID</th>
                        <th>Patient Name</th>
                        <th>Patient ID</th>
                        <th>Specimen ID</th>
                        <th>Date of Registration</th>
		</tr>
	</thead>
	<tbody>
	<?php
        $all_entries = $ust->getTestRegLog($user_id, $lab_config_id,$date_from, $date_to);
	foreach($all_entries as $entry)
	{
            ?>
            <tr>
                    <td>
                        <?php 
                            $count++;
                            echo $count; 
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            $tname = get_test_name_by_id($entry->testTypeId);
                            if($tname != '')
                                echo $tname; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry->testId != '')
                               echo $entry->testId; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                            $entr2 = get_patient_by_sp_id($entry->specimenId);
                            $entr = $entr2[0]->name;
                            if($entr != '')
                               echo $entr;
                           else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            $entr = $entr2[0]->patientId;
                            if($entr != '')
                               echo $entr;
                           else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            $entr = $entry->specimenId;
                            if($entr != '')
                                echo $entr; 
                            else
                                echo '-';
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            $entr = $entry->getTestRegDate();
                            if($entr != '')
                                echo $entr; 
                            else
                                echo '-';
                        ?>
                    </td>
                    
                   
            </tr>
        <?php
        }
	?>
	</tbody>
</table>
<?php } ?>


<?php if($log_type == 4) { ?> 
<table style='border-collapse: collapse;' id='testsdone_table'>
	<thead>
		<tr>
                    <th><?php 
                        $count = 0;
                        echo "S.No.";
                    ?></th>
			<th>Test Name</th>
			<th>Test ID</th>
                        <th>Patient Name</th>
                        <th>Patient ID</th>
                        <th>Specimen ID</th>
                        <th>Date of Result Entry</th>
		</tr>
	</thead>
	<tbody>
	<?php
        $all_entries = $ust->getResultEntryLog($user_id, $lab_config_id,$date_from, $date_to);
	foreach($all_entries as $entry)
	{
            ?>
            <tr>
                    <td>
                        <?php 
                            $count++;
                            echo $count; 
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            $tname = get_test_name_by_id($entry->testTypeId);
                            if($tname != '')
                                echo $tname; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry->testId != '')
                               echo $entry->testId; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                            $entr2 = get_patient_by_sp_id($entry->specimenId);
                            $entr = $entr2[0]->name;
                            if($entr != '')
                               echo $entr;
                           else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            $entr = $entr2[0]->patientId;
                            if($entr != '')
                               echo $entr;
                           else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            $entr = $entry->specimenId;
                            if($entr != '')
                                echo $entr; 
                            else
                                echo '-';
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            $entr = $entry->timestamp;
                            if($entr != '')
                                echo $entr; 
                            else
                                echo '-';
                        ?>
                    </td>
                    
                   
            </tr>
        <?php
        }
	?>
	</tbody>
</table>
<?php } ?>

<?php if($log_type == 5) { ?> 
<b>Inventory In-Flow</b>
<table style='border-collapse: collapse;' id='testsdone_table'>
	<thead>
		<tr>
                    <th><?php 
                        $count = 0;
                        echo "S.No.";
                    ?></th>
			<th>Reagent</th>
			<th>Lot</th>
                        <th>Expiry Date</th>
                        <th>Manufacturer</th>
                        <th>Supplier</th>
                        <th>Quantity Supplied</th>
                        <th>Cost Per Unit</th>
                        <th>Date of Supply</th>
                        <th>Remarks</th>
                        <th>Date of Transaction</th>
		</tr>
	</thead>
	<tbody>
	<?php
        $all_entries = Inventory::get_inv_supply_by_user($lab_config_id, $user_id);
	foreach($all_entries as $entry)
	{
            ?>
            <tr>
                    <td>
                        <?php 
                            $count++;
                            echo $count; 
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            $dat = Inventory::getReagentById($lab_config_id, $entry['reagent_id']);
                            if($dat[name] != '')
                                echo $dat[name]; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry[lot] != '')
                                echo $entry[lot]; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                            
                            if($entry[expiry_date] != '')
                               echo $entry[expiry_date];
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry[manufacturer] != '')
                                echo $entry[manufacturer]; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry[supplier] != '')
                                echo $entry[supplier]; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            
                            if($entry[quantity_supplied] != '')
                                echo $entry[quantity_supplied]; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                           if($entry[cost_per_unit] != '')
                               echo $entry[cost_per_unit];
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                           if($entry[date_of_reception] != '')
                               echo $entry[date_of_reception];
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                           if($entry[remarks] != '')
                               echo $entry[remarks];
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                           if($entry[ts] != '')
                               echo $entry[ts];
                            else
                                echo '-';
                        ?>
                    </td>
                   
            </tr>
        <?php
        }
	?>
	</tbody>
</table>
<br><br>
<b>Inventory Out-Flow</b>
<table style='border-collapse: collapse;' id='testsdone_table'>
	<thead>
		<tr>
                    <th><?php 
                        $count = 0;
                        echo "S.No.";
                    ?></th>
			<th>Reagent</th>
			<th>Lot</th>
                        <th>Quantity Used</th>
                        <th>Date of Use</th>
                        <th>Remarks</th>
                        <th>Date of Transaction</th>
		</tr>
	</thead>
	<tbody>
	<?php
        $all_entries = Inventory::get_inv_usage_by_user($lab_config_id, $user_id);
	foreach($all_entries as $entry)
	{
            ?>
            <tr>
                    <td>
                        <?php 
                            $count++;
                            echo $count; 
                        ?>
                    </td>
                    
                    <td>
                        <?php 
                            $dat = Inventory::getReagentById($lab_config_id, $entry['reagent_id']);
                            if($dat[name] != '')
                                echo $dat[name]; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($entry[lot] != '')
                                echo $entry[lot]; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                            
                            if($entry[quantity_used] != '')
                                echo $entry[quantity_used]; 
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                           if($entry[date_of_use] != '' && $entry[date_of_use] != '0000-00-00')
                               echo $entry[date_of_use];
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                           if($entry[remarks] != '')
                               echo $entry[remarks];
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php 
                           if($entry[ts] != '')
                               echo $entry[ts];
                            else
                                echo '-';
                        ?>
                    </td>
                   
            </tr>
        <?php
        }
	?>
	</tbody>
</table>

<?php } ?>


<br><br><br>
............................................
</div>