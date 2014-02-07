<?php
#
# Returns list of patients matched with list of pending specimens
# Called via Ajax form result_entry.php
#

include("../includes/db_lib.php");
include("../includes/user_lib.php");
LangUtil::setPageId("results_entry");

$attrib_value = $_REQUEST['a'];
//$attrib_type = $_REQUEST['t'];
$dynamic = 1;
if(!isset($_REQUEST['result_cap']))
    $result_cap = 10;
else
    $result_cap = $_REQUEST['result_cap'];

if(!isset($_REQUEST['result_counter']))
    $result_counter = 1;
else
    $result_counter = $_REQUEST['result_counter'];

$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

 $offset = $result_cap * ($result_counter - 1);
$query_string = "";
if($dynamic == 0)
{
    $query_string = 
				"SELECT specimen_id FROM test WHERE result='' ".
				"AND test_type_id IN (SELECT test_type_id FROM test_type WHERE test_category_id=$attrib_value) ".
				"LIMIT $offset,$result_cap";
    
    
}
else
{
	$query_string =
	"SELECT specimen_id FROM test WHERE result='' ".
	"AND test_type_id IN (SELECT test_type_id FROM test_type WHERE test_category_id=$attrib_value) ".
	"LIMIT $offset,$result_cap";
		     
}

//echo $query_string;
$resultset = query_associative_all($query_string, $row_count);
if(count($resultset) == 0 || $resultset == null)
{
	?>
	<div class='sidetip_nopos'>
	<?php 
	if($attrib_type == 0)
		echo " ".LangUtil::$generalTerms['PATIENT_ID']." ";
	else if($attrib_type == 1)
		echo " ".LangUtil::$generalTerms['PATIENT_NAME']." ";
	else if($attrib_type == 3)
		echo " ".LangUtil::$generalTerms['PATIENT_DAILYNUM']." ";
	echo "<b>".$attrib_value."</b>";
	echo " - ".LangUtil::$pageTerms['MSG_PENDINGNOTFOUND'];
	?>
	</div>
	<?php
	return;
}
$specimen_id_list = array();
foreach($resultset as $record)
{
	$specimen_id_list[] = $record['specimen_id'];
}
# Remove duplicates that might come due to multiple pending tests
$specimen_id_list = array_values(array_unique($specimen_id_list));
?>

                 
<table class="hor-minimalist-c">
	<thead>
		<tr valign='top'>
			<?php
			if($_SESSION['pid'] != 0)
			{
			?>
				<th style='width:75px;'><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
			<?php
			}
			if($_SESSION['dnum'] != 0)
			{
			?>
				<th style='width:100px;'><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></th>
			<?php
			}
			if($_SESSION['p_addl'] != 0)
			{
			?>
				<th style='width:75px;'><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></th>
			<?php
			}
			//if($_SESSION['sid'] != 0)
			// "Specimen ID" now refers to aux_id
			if(false)
			{
			?>
				<th style='width:75px;'><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
			<?php
			}
			if($_SESSION['s_addl'] != 0)
			{
			?>
				<th style='width:75px;'><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
			<?php
			}
			//if($lab_config->hidePatientName == 0)
			if($_SESSION['user_level'] == $LIS_TECH_SHOWPNAME)
			{
			?>
				<th style='width:200px;'><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></th>
			<?php
			}
			else
			{
			?>
			<th style='width:100px;'><?php echo LangUtil::$generalTerms['GENDER']."/".LangUtil::$generalTerms['AGE']; ?></th>
			<?php
			}
			?>
			<th style='width:100px;'><?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?></th>
			<th style='width:100px;'><?php echo LangUtil::$generalTerms['TESTS']; ?></th>
			<th style='width:100px;'></th>
		</tr>
	</thead>
</table>
<?php
	$count = 1;
	foreach($specimen_id_list as $specimen_id)
	{
		$specimen = get_specimen_by_id($specimen_id);
		$patient = get_patient_by_id($specimen->patientId);
		?>
		<table class="hor-minimalist-c">
		<tbody>
		<tr valign='top' <?php
		if($attrib_type == 3 && $count != 1)
		{
			# Fetching by patient daily number. Hide all records except the latest one
			echo " class='old_pnum_records' style='display:none' ";
		}
		?>>
			<?php
			if($_SESSION['pid'] != 0)
			{
			?>
				<td style='width:75px;'><?php echo $patient->getSurrogateId(); ?></td>
			<?php
			}
			if($_SESSION['dnum'] != 0)
			{
			?>
				<td style='width:100px;'><?php echo $specimen->getDailyNumFull(); ?></td>
			<?php
			}
			if($_SESSION['p_addl'] != 0)
			{
			?>
				<td style='width:75px;'><?php echo $patient->getAddlId(); ?></td>
			<?php
			}
			//if($_SESSION['sid'] != 0)
			// "Specimen ID" now refers to aux_id
			if(false)
			{
			?>
				<td style='width:75px;'><?php echo $specimen->specimenId; ?></td>
			<?php
			}
			if($_SESSION['s_addl'] != 0)
			{
			?>
				<td style='width:75px;'><?php echo $specimen->getAuxId(); ?></td>
			<?php
			}
			//if($lab_config->hidePatientName == 0)
			if($_SESSION['user_level'] == $LIS_TECH_SHOWPNAME)
			{
			?>
				<td style='width:200px;'><?php echo $patient->getName()." (".$patient->sex." ".$patient->getAgeNumber().") "; ?></td>
			<?php
			}
			else
			{
			?>
				<td style='width:100px;'><?php echo $patient->sex."/".$patient->getAgeNumber(); ?></td>
			<?php
			}
			?>
			<td style='width:100px;'><?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?></td>
			<td style='width:100px;'>
			<?php
			$test_list = get_tests_by_specimen_id($specimen->specimenId);
			$i = 0;
			foreach($test_list as $test)
			{
				echo get_test_name_by_id($test->testTypeId);
				$i++;
				if($i != count($test_list))
				{
					echo "<br>";
				}
			}
			?>
			</td>
			<td style='width:100px;'><a href="javascript:fetch_specimen2(<?php echo $specimen->specimenId; ?>);" title='Click to Enter Results for this Specimen'>
				<?php echo LangUtil::$generalTerms['ENTER_RESULTS']; ?></a>
			</td>
		</tr>
		</tbody>
		</table>
		<div class='result_form_pane' id='result_form_pane_<?php echo $specimen->specimenId; ?>'>
		</div>
		<?php
		$count++;
	}
	?>

<?php
if($attrib_type == 3 && $count > 2)
{
	# Show "view more" link for revealing earlier patient records
	?>
	<a href='javascript:show_more_pnum();' id='show_more_pnum_link'><small>View older entries &raquo;</small></a>
	<br><br>
	<?php
}

?>
<?php 
        if(isset($_REQUEST['l']))
        { 
            $next_link = "../ajax/result_data_page_labsection.php?a=".$_REQUEST['a']."&l=".$_REQUEST['l']."&result_cap=".$result_cap."&result_counter=".($result_counter+1); 
        }
        else
        {
            $next_link = "../ajax/result_data_page_labsection.php?a=".$_REQUEST['a']."&result_cap=".$result_cap."&result_counter=".($result_counter+1);             
        }
        if(isset($_REQUEST['l']))
        { 
            $prev_link = "../ajax/result_data_page_labsection.php?a=".$_REQUEST['a']."&l=".$_REQUEST['l']."&result_cap=".$result_cap."&result_counter=".($result_counter - 1); 
        }
        else
        {
            $prev_link = "../ajax/result_data_page_labsection.php?a=".$_REQUEST['a']."&result_cap=".$result_cap."&result_counter=".($result_counter - 1);             
        }
    ?>        
<div class="prev_link">                       
     <small><a href="javascript:get_prev('<?php echo $prev_link; ?>', '<?php echo $result_counter - 1; ?>', '<?php echo $result_cap; ?>');">&lt;&nbsp;Previous&nbsp;</a></small>
</div>
<div class="next_link">                
     <small><a href="javascript:get_next('<?php echo $next_link; ?>', '<?php echo $result_counter + 1; ?>', '<?php echo $result_cap; ?>');">&nbsp;Next&nbsp&nbsp;&gt;</a></small>
</div>
