
<?php
include("../includes/db_lib.php");
include("../includes/script_elems.php");
LangUtil::setPageId("find_patient");

$script_elems = new ScriptElems();
$dynamic_fetch = 1;
if(!isset($_REQUEST['result_cap']))
    $result_cap = 10;
else
    $result_cap = $_REQUEST['result_cap'];

if(!isset($_REQUEST['result_counter']))
    $result_counter = 1;
else
    $result_counter = $_REQUEST['result_counter'];


$a = $_REQUEST['a'];
$c = $_REQUEST['c'];
$saved_db = "";
$lab_config = null;
$q = $_REQUEST['q'];
$q = strip_tags($q);
if(isset($_REQUEST['l']))
{
	# Save context
	$lab_config = LabConfig::getById($_REQUEST['l']);
	$saved_db = DbUtil::switchToLabConfig($_REQUEST['l']);
}
else
{
	$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
}
$patient_list = array();
# Fetch list from DB
if($a == 0)
{
	# Fetch by patient ID
    if($dynamic_fetch == 0)
        {
	$patient_list = search_patients_by_id($q);
        }
        else
        {
            $patient_list = search_patients_by_id_dyn($q, $result_cap, $result_counter);
        }
        
}
else if($a == 1)
{
	# Fetch by patient name
        if($dynamic_fetch == 0)
        {
            $patient_list = search_patients_by_name($q);
        }
        else
        {
            $patient_list = search_patients_by_name_dyn($q, $result_cap, $result_counter, $c);
        }
	//DB Merging - Currently Disabled 
	# See if there's a patient by the exact same name in another lab
	//$patient = searchPatientByName($q);
	/*if($patient != null) {
	# See if there's a patient by the exact same name in current lab as well as another lab and if yes automatically add enteries to current database
		autoImportPatientEntry($patient, $q);
	}*/
}
else if($a == 2)
{
	# Fetch by additional ID
     if($dynamic_fetch == 0)
        {
	$patient_list = search_patients_by_addlid($q);
        }
        else
        {
            $patient_list = search_patients_by_addlid_dyn($q, $result_cap, $result_counter);
        }
}
else if($a == 3)
{
	# Fetch by daily number
    if($dynamic_fetch == 0)
        {
	$patient_list = search_patients_by_dailynum("-".$q);
        }
        else
        {
            $patient_list = search_patients_by_dailynum_dyn("-".$q, $result_cap, $result_counter);
        }
}
//DB Merging - Currently disabled 
else if( (count($patient_list) == 0 || $patient_list[0] == null) && ($patient != null) ) {
	?>
	<br>
	<div class='sidetip_nopos'>
	<?php
		echo "A record of the patient has been found in another hospital.<br><br>"; 
	?>
            </div>
		<a rel='facebox' href='viewPatientInfo.php?pid=<?php echo $patient->patientId; ?>&type=national'>View Patient Info>></a><br>
		<a href='ajax/import_patient.php?patientId=<?php echo $patient->patientId; ?>'>Import patient record and continue?</a><br>
		<a href='new_patient.php?n=<?php echo $q; ?>'>Add New Patient</a>
	<?php
	SessionUtil::restore($saved_session);
	return;
}
# Build HTML table
?>
<table class='hor-minimalist-cs' id='patientListTable' name='patientListTable'>
        <thead>

		<tr valign='top'>
			<?php
			if($lab_config->pid != 0)
			{
				?>
				<th><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
				<?php
			}
			if($lab_config->dailyNum >= 11)
			{
				?>
				<th><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></th>
				<?php
			}
			if($lab_config->patientAddl != 0)
			{
				?>
				<th><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></th>
				<?php
			}
			?>
			<?php  #TODO: Add check if user has patient name/private data access here ?>
                        
			<th><?php echo LangUtil::$generalTerms['NAME']; ?></th>
			<th><?php echo LangUtil::$generalTerms['GENDER']; ?></th>
                        
                        <?php
			if($lab_config->age >= 11)
			{
				?>
				<th><?php echo LangUtil::$generalTerms['AGE']; ?></th>
				<?php
			}?>
			
                        <?php
			if(strpos($_SERVER["HTTP_REFERER"], "search.php") !== false)
			{
				# Show status of most recently registered specimens
				echo "<th>".LangUtil::$generalTerms['SP_STATUS']."</th>";
			}
			?>
			<th></th>
			<th></th>
		</tr>

	</thead>
		<tbody>
	<?php
        if(count($patient_list) > 0)
	foreach($patient_list as $patient)
	{
	?>
		<tr valign='top'>
			<?php
			if($lab_config->pid != 0)
			{
				?>
				<td class="idtd">
					<?php echo $patient->getSurrogateId(); ?>
				</td>
				<?php
			}
			if($lab_config->dailyNum >= 11)
			{
				//$daily_num = "-".$lab_config->dailyNum;
                                $daily_num = "-";
				//if($a == 3)
				if(true)
				{
					# Fetch specimen corresponding to this patient and daily_num
					$query_string =
						"SELECT * FROM specimen WHERE patient_id=$patient->patientId ".
						"ORDER BY date_collected DESC";
					$resultset = query_associative_all($query_string, $row_count);
					if($resultset == null || count($resultset) == 0)
						$daily_num = "-";
					else
					{
						$specimen = Specimen::getObject($resultset[0]);
						$daily_num = $specimen->getDailyNumFull();
					}
				}
				?>
				<td>
					<?php echo $daily_num; ?>
				</td>
				<?php
			}
			if($lab_config->patientAddl != 0)
			{
				?>
				<td>
					<?php echo $patient->getAddlId(); ?>
				</td>
				<?php
			}
			?>
			<td class="nametd">
				<?php echo $patient->name; ?>
			</td>
			<td class="sextd">
				<?php echo $patient->sex; ?>
			</td>
			<?php
                        if($lab_config->age >= 11)
			{
				?>
				<td class="agetd">
					<?php echo $patient->getAge(); ?>
				</td>
				<?php
			}?>
                        
			<?php
			if(strpos($_SERVER["HTTP_REFERER"], "search.php") !== false)
			{
				# Show status of most recently registered specimens
				$today = date("Y-m-d");
				$query_string = "SELECT * FROM specimen WHERE patient_id=$patient->patientId and date_collected='$today'";
				$resultset = query_associative_all($query_string, $row_count);
				$status = LangUtil::$generalTerms['DONE'];
				foreach($resultset as $record)
				{
					$specimen = Specimen::getObject($record);
					if
					(
						$specimen->statusCodeId == Specimen::$STATUS_PENDING ||
						$specimen->statusCodeId == Specimen::$STATUS_REFERRED
					)
					{
						$status = LangUtil::$generalTerms['PENDING_RESULTS'];
						break;
					}
				}
				echo "<td>$status</td>";
			}
			?>
			<td>
				<?php 
				if(strpos($_SERVER["HTTP_REFERER"], "find_patient.php") !== false || strpos($_SERVER["HTTP_REFERER"], "doctor_register.php") !== false)
				{
					# Called from find_patient.php. Show 'profile' and 'register specimen' link
					?>
					<a href='new_specimen.php?pid=<?php echo $patient->patientId; ?>' title='Click to Register New Specimen for this Patient'><?php echo LangUtil::$pageTerms['CMD_REGISTERSPECIMEN']; ?></a>
					</td><td>
					<a href='patient_profile.php?pid=<?php echo $patient->patientId; ?>' title='Click to View Patient Profile'><?php echo LangUtil::$pageTerms['CMD_VIEWPROFILE']; ?></a>
					<?php
				}
				else if(strpos($_SERVER["HTTP_REFERER"], "reports.php") !== false || strpos($_SERVER["HTTP_REFERER"], "reports2.php") !== false)
				{
					# Called from reports.php. Show 'Test History' link
					# Default to today for date range
					$today = date("Y-m-d");
					$today_parts = explode("-", $today);
					$url_string = "reports_testhistory.php?patient_id=".$patient->patientId."&location=".$_REQUEST['l']."&yf=".$today_parts[0]."&mf=".$today_parts[1]."&df=".$today_parts[2]."&yt=".$today_parts[0]."&mt=".$today_parts[1]."&dt=".$today_parts[2]."&ip=0";
					$billing_url_string = "reports_billing.php?patient_id=".$patient->patientId."&location=".$_REQUEST['l']."&yf=".$today_parts[0]."&mf=".$today_parts[1]."&df=".$today_parts[2]."&yt=".$today_parts[0]."&mt=".$today_parts[1]."&dt=".$today_parts[2]."&ip=0";

                                        ?>
					<a href='<?php echo $url_string; ?>' title='Click to View Report for this Patient' target='_blank'><?php echo LangUtil::$generalTerms['CMD_VIEW']; ?> Report</a>
					</td>
					<td>
					<a href='select_test_profile.php?pid=<?php echo $patient->patientId; ?>' title='Click to View Patient Profile'>Select Tests</a>
										</td>
                                        <td <?php //(is_billing_enabled($_SESSION['lab_config_id']) ? print("") : print("style='display:none'")) ?> >
                                       
                                            <a target="_blank" href=<?php echo $billing_url_string; ?>' title='Click to generate a bill for this patient'>Generate Bill</a>
                                        </td>
                                           
					<td>					
					<?php
				}
				else
				{
					# Called from search.php. Show only 'profile' link
					?>
					<a href='patient_profile.php?pid=<?php echo $patient->patientId; ?>' title='Click to View Patient Profile'><?php echo LangUtil::$pageTerms['CMD_VIEWPROFILE']; ?></a>
					</td><td>
					<?php
				}
				?>
			</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
   <?php 
        if(isset($_REQUEST['l']))
        { 
            $next_link = "../ajax/patient_data_page.php?q=".$_REQUEST['q']."&a=".$_REQUEST['a']."&c=".$_REQUEST['c']."&l=".$_REQUEST['l']."&result_cap=".$result_cap."&result_counter=".($result_counter+1); 
        }
        else
        {
            $next_link = "../ajax/patient_data_page.php?q=".$_REQUEST['q']."&a=".$_REQUEST['a']."&c=".$_REQUEST['c']."&result_cap=".$result_cap."&result_counter=".($result_counter+1);             
        }
        if(isset($_REQUEST['l']))
        { 
            $prev_link = "../ajax/patient_data_page.php?q=".$_REQUEST['q']."&a=".$_REQUEST['a']."&c=".$_REQUEST['c']."&l=".$_REQUEST['l']."&result_cap=".$result_cap."&result_counter=".($result_counter - 1); 
        }
        else
        {
            $prev_link = "../ajax/patient_data_page.php?q=".$_REQUEST['q']."&a=".$_REQUEST['a']."&c=".$_REQUEST['c']."&result_cap=".$result_cap."&result_counter=".($result_counter - 1);             
        }
    ?>
                   <?php if($_REQUEST['result_counter'] != 1) {?>
                
<div class="prev_link">                
    <small> <a onclick="javascript:get_prev('<?php echo $prev_link; ?>', '<?php echo $result_counter - 1; ?>', '<?php echo $result_cap; ?>');">&lt;&nbsp;Previous&nbsp;</a></small>
</div>
                                <?php } ?>
                
   <?php if($_REQUEST['rem'] > 0) {?>

<div class="next_link">                
    <small> <a onclick="javascript:get_next('<?php echo $next_link; ?>', '<?php echo $result_counter + 1; ?>', '<?php echo $result_cap; ?>');">&nbsp;Next&nbsp;&gt;</a> </small>            
</div>
                <?php } ?>
