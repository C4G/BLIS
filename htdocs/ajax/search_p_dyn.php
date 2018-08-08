<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Returns list of matched patients
# Called via Ajax from /search.php
#
include("../includes/db_lib.php");
include("../includes/script_elems.php");
LangUtil::setPageId("find_patient");

$script_elems = new ScriptElems();
//$script_elems->enableTableSorter();

$saved_session = SessionUtil::save();
$dynamic_fetch = 1;
$search_settings = get_lab_config_settings_search();
$rcap = $search_settings['results_per_page'];
?>
<style type="text/css">
    .prev_link{
        position: relative;
        float: left;
        cursor: pointer;
        margin-top: 1.5em;
    }
    .next_link{
        position: relative;
        float: right;
        cursor: pointer;
        margin-top: 1.5em;
    }
.customers
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
table-layout:inherit
}
.customers td, .customers th 
{
font-size:1em;
border:1px solid #98bf21;
padding:3px 7px 2px 7px;
}
.customers th 
{
font-size:1.1em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#A7C942;
color:#ffffff;
}
.customers tr.alt td 
{
color:#000000;
background-color:#EAF2D3;
}

.idtd
{
    width: 60px;
}
.nametd
{
    width: 200px;
}
.agetd
{
    width: 60px;
}
.sextd
{
    width: 50px;
}

.hor-minimalist-cy
{
	/*font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;*/
	font-size: 13px;
	background: #fff;
	/*margin: 45px;*/
	/*width: 480px;*/
	width: auto;
	border-collapse:collapse;
	text-align: left;
        table-layout: inherit;
}
.hor-minimalist-cy th
{
	font-size: 14px;
	font-weight: normal;
	/*color: #039;*/
	padding: 10px 8px;
	border-bottom: 2px solid #6678b1;
        border:1px solid #98bf21;

}
.hor-minimalist-cy td
{
	border-bottom: 1px solid #ccc;
	/*color: #669;*/
	padding: 6px 8px;
        border:1px solid #98bf21;

}
.hor-minimalist-cy tbody tr:hover td
{
	/*color: red;*/
}


.hor-minimalist-cs
{
	/*font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;*/
	font-size: 13px;
	background: #fff;
	/*margin: 45px;*/
	/*width: 480px;*/
	width: auto;
	border-collapse: collapse;
	text-align: center;
}
.hor-minimalist-cs th
{
	font-size: 13px;
	font-weight: normal;
	/*color: #039;*/
	padding: 10px 8px;
}
.hor-minimalist-cs td
{
	border-bottom: 1px solid #ccc;
	/*color: #669;*/
	padding: 6px 8px;
}
.hor-minimalist-cs tbody tr:hover td
{
	/*color: red; /*#009;*/
}

.hor-minimalist-chh
{
	/*font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;*/
	font-size: 14px;
	background: #fff;
	/*margin: 45px;*/
	/*width: 480px;*/
	width: auto;
	border-collapse: collapse;
	text-align: left;
}
.hor-minimalist-chh th
{
	font-size: 14px;
	font-weight: normal;
	/*color: #039;*/
	padding: 10px 8px;
	border-bottom: 2px solid #6678b1;
}
.hor-minimalist-chh td
{
	border-bottom: 1px solid #ccc;
	/*color: #669;*/
	padding: 6px 8px;
}
.hor-minimalist-chh tbody tr:hover td
{
	/*color: red; /*#009;*/
}

#patient_search_results table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
}

#patient_search_results thead, #patient_search_results tbody, #patient_search_results tr, #patient_search_results td, #patient_search_results th { display: block; }

#patient_search_results tr:after {
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
}

#patient_search_results thead th { 
    height: 30px;
    line-height: 30px;
}

#patient_search_results tbody {
    height: 400px;
    overflow-y: auto;
}

#patient_search_results thead {
    width: 97%;
    width: calc(100% - 17px);
}

#patient_search_results tbody { border-top: 1px solid #9a9a9a; }

#patient_search_results tbody td, #patient_search_results thead th {
    width: 10%;
    float: left;
    height: 20px;
    white-space: nowrap;
    text-align: center;
}

#patient_search_results tbody td:last-child, #patient_search_results thead th:last-child {
    border-right: none;
}


</style>
<script type='text/javascript'>
    $(document).ready(function(){
        var lab_section = <?php echo $_REQUEST['lab_section']; ?> + '';
        url_string = 'ajax/get_result_count.php?a='+'<?php echo $_REQUEST['a']; ?>'+'&q='+'<?php echo $_REQUEST['q']; ?>'+'&labsection='+lab_section+'&c=<?php echo $_REQUEST['c']; ?>';
        var cap = parseInt($('#rcap').html());
        //console.log(cap);
         $('.prev_link').hide();	
		//alert(cap);
        $.ajax({ 
		url: url_string, 
                async : false,
		success: function(count){
					//alert(count);
                    var icount = parseInt(count);
                    //alert(icount+"-"+count);
                     if(icount < cap/*parseInt('<?php echo $_REQUEST['result_cap']; ?>')*/)
                        {
                                $('.next_link').hide();
                                if(icount == 0 || icount=="NaN")
                                    {
                                        $('#page_counts').html('0/0 Page');
                                        $('#result_counts').html('0 Results');
                                    }
                                else if(icount == 1)
                                    {
                                        $('#result_counts').html('1 Result');
                                    }
                                else
                                    {
                                        $('#result_counts').html(count + ' Results');
                                    }

                        }
                        else
                        {
                                $('#result_counts').html(count + ' Results');
                                //alert(icount+"-"+cap);
                                if(icount % cap == 0)
                                    var max_pages = parseInt(icount / cap);
                                else
                                    var max_pages = parseInt(icount / cap) + 1;
                                 $('#page_counts').html('1/' + max_pages + ' Page');
								 
                                 $('#mpage').html(max_pages);
                                $('#tot').html(count);
                                var rem = icount - cap;
                                $('#rem').html(rem);
                        }
                    

               }
	});

});

function get_next(url, sno, cap)
{
    var page = parseInt($('#page').html()); 
    page = page + 1;
    $('#page').html(page);
    var rem = parseInt($('#rem').html());
    var tot = parseInt($('#tot').html());
    var cap = parseInt($('#rcap').html());
	rem = rem -  cap; 
	$('#rem').html(rem);
    var mpage = parseInt($('#mpage').html());
    
    var displayed = tot - rem;
    
    if(displayed > tot)
        displayed = tot;
    $('#page_counts').html(page + '/' + mpage + ' Page');
    
    $('.prev_link').hide();    
    $('.next_link').hide();
    url = url + '&rem=' + rem;
    var div_name = 'resultset'+sno;
    var html_content = "<div id='"+div_name+"'</div>";
    //$('#data_table').html(html_content);
    $('#data_table').load(url);
}   

function get_prev(url, sno, cap)
{
    var page = parseInt($('#page').html()); 
    page = page - 1;
    $('#page').html(page);
    var rem = parseInt($('#rem').html()); 
    var tot = parseInt($('#tot').html());
    var cap = parseInt($('#rcap').html());
    var mpage = parseInt($('#mpage').html());

     rem = rem + cap;
    $('#rem').html(rem);
    var displayed = tot - rem;
    if(displayed > tot)
        displayed = tot;
        $('#page_counts').html(page + '/' + mpage + ' Page');

    //$('#result_counts').html(displayed + '/' + tot + ' Results');
    $('.prev_link').hide();
    $('.next_link').hide();
    url = url + '&rem=' + rem;
    var div_name = 'resultset'+sno;
    var html_content = "<div id='"+div_name+"'</div>";
    //$('#data_table').html(html_content);
    $('#data_table').load(url);
}
</script>
<?php
/*
$q = addslashes($name);
$q = mysql_escape_string($name);
$q = str_ireplace("<script>", "&lt;script&gt;", $name);
$q = strip_tags($q);
*/
$uiinfo = "op=".$_REQUEST['a']."&qr=".$_REQUEST['q'];
putUILog('search_p_dyn', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?>
<div id="rcap" style="display: none;"><?php echo $rcap; ?></div>
<div id="page" style="display: none;">1</div>
<div id="mpage" style="display: none;">1</div>
<div id="rem" style="display: none;"></div>
<div id="tot" style="display: none;"></div>

<font color="grey"><small><div id="result_counts" style="float: right; padding-right: 16px">0 results</div></small></font>
<font color="grey"><small><div id="page_counts" style="float: right; padding-right: 16px">1/1 Page</div></small></font>

<br>

<div id="data_table">
    <div id ="resultset1">
<?php

if(!isset($_REQUEST['result_cap']))
    $result_cap = $rcap;
else
    $result_cap = $_REQUEST['result_cap'];

if(!isset($_REQUEST['result_counter']))
    $result_counter = 1;
else
    $result_counter = $_REQUEST['result_counter'];



$a = $_REQUEST['a'];
$saved_db = "";
$lab_config = null;
$q = $_REQUEST['q'];
$q = strip_tags($q);
$c = $_REQUEST['c'];
// lab section fetch
$lab_section = $_REQUEST['lab_section'];
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
	$patient_list = search_patients_by_id($q, $lab_section);
        }
        else
        {
            $patient_list = search_patients_by_id_dyn($q, $result_cap, $result_counter, $lab_section);
        }
        
}
else if($a == 1)
{
	//echo "Fetch By Name";
	# Fetch by patient name
        if($dynamic_fetch == 0)
        {
            $patient_list = search_patients_by_name($q, $lab_section,$c);
        }
        else
        {
        	//echo "Fetch By Name section is ".$lab_section;
            $patient_list = search_patients_by_name_dyn($q, $result_cap, $result_counter, $c, $lab_section);
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
	$patient_list = search_patients_by_addlid($q, $lab_section);
        }
        else
        {
            $patient_list = search_patients_by_addlid_dyn($q, $result_cap, $result_counter, $lab_section);
        }
}
else if($a == 3)
{
	# Fetch by daily number
    if($dynamic_fetch == 0)
        {
	$patient_list = search_patients_by_dailynum("-".$q, $lab_section);
        }
        else
        {
            $patient_list = search_patients_by_dailynum_dyn("-".$q, $result_cap, $result_counter, $lab_section);
        }
}
else if($a == 9)
{
	# Fetch by db id
    if($dynamic_fetch == 0)
        {
	$patient_l = getPatientFromBarcode($q);
        }
        else
        {
	$patient_l = getPatientFromBarcode($q);
        }
        $patient_list[0] = $patient_l;
}
if( (count($patient_list) == 0 || $patient_list[0] == null) && ($patient == null) )
{
	?>
	<br>
	<div class='sidetip_nopos'>
	<?php
	echo LangUtil::$pageTerms['MSG_NOMATCH']." -";
	if($a == 0)
		echo " ".LangUtil::$generalTerms['PATIENT_ID']." ";
	else if($a == 1)
		echo " ".LangUtil::$generalTerms['NAME']." ";
	else if($a == 2)
		echo " ".LangUtil::$generalTerms['ADDL_ID']." ";
	
                if($a == 9)
                {
                    echo 'Try searching by Patient Name';
                }
                else
                {
                    echo '<b>'.$q.'</b>';
                }
        ?>
	<?php
	//if(strpos($_SERVER['HTTP_REFERER'], "find_patient.php") !== false)
	if(false)
	{
		?>
		&nbsp;&nbsp;<a href='new_patient.php'><?php echo LangUtil::$pageTerms['ADD_NEW_PATIENT']; ?> &raquo;</a>
		<?php
	}
	?>
	</div>
	<?php
	SessionUtil::restore($saved_session);
	return;
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
	<script type="text/javascript">
		function retrieve_deleted(sid, category){
			var params = "item_id="+sid+"&ret_cat="+category;
			 $.ajax({
				type: "POST",
				url: "ajax/retrieve_deleted.php",
				data: params,
				success: function(msg) {
					if(msg.indexOf("1")> -1){
						location.href = location.href;
					} else {
						$("#target_div_id_del").html("Patient cannot be Retrieved");
					}
					
				}
			}); 
			
		}

		</script>

<table class='hor-minimalist-cs' id='patientListTable' name='patientListTable'>
	<thead >
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
			<?php 
			$user = get_user_by_id($_SESSION['user_id']);
			$rwopts = explode(",", $user->rwoptions);
			if (in_array("51", $rwopts) || in_array("2", $rwopts) || in_array("3", $rwopts) || in_array("4", $rwopts) || in_array("6", $rwopts) || in_array("7", $rwopts)) {
				echo "<th></th>";
			} 
			if (in_array("52", $rwopts) || in_array("2", $rwopts) || in_array("3", $rwopts) || in_array("4", $rwopts) || in_array("6", $rwopts) || in_array("7", $rwopts)) {
				echo "<th></th>";
			}
			?>
<!-- 			<th></th> -->
			<?php
				if(is_admin_check($user)){
			?>
<!-- 				<th></th> -->
			<?php }?>
		</tr>
	</thead>
	<tbody>
	<?php
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
					$url_string = "reports_testhistory.php?patient_id=".$patient->patientId."&location=".$_REQUEST['l']."&yf=".$today_parts[0]."&mf=".$today_parts[1]."&df=".$today_parts[2]."&yt=".$today_parts[0]."&mt=".$today_parts[1]."&dt=".$today_parts[2]."&ip=0"."&labsection=".$lab_section;
					$billing_url_string = "reports_billing.php?patient_id=".$patient->patientId."&location=".$_REQUEST['l']."&yf=".$today_parts[0]."&mf=".$today_parts[1]."&df=".$today_parts[2]."&yt=".$today_parts[0]."&mt=".$today_parts[1]."&dt=".$today_parts[2]."&ip=0"."&labsection=".$lab_section;

                                        ?>
					<a href='<?php echo $url_string; ?>' title='Click to View Report for this Patient' target='_blank'><?php echo LangUtil::$generalTerms['CMD_VIEW']; ?> Report</a>
					</td>
					<td>
					
					<?php $user = get_user_by_id($_SESSION['user_id']);
					$rw_option = array();
					$rw_option = explode(",",$user->rwoptions);
					if($user->level == 16){
						 if (in_array("51", $rw_option) || in_array("2", $rw_option) || in_array("3", $rw_option) || in_array("4", $rw_option) || in_array("6", $rw_option) || in_array("7", $rw_option)) {
					?>
					<a href='select_test_profile.php?pid=<?php echo $patient->patientId; ?>&labsection=<?php echo $lab_section?>' title='Click to View Patient Profile'>Select Tests</a>
					<?php } 
					} else {?>
						<a href='select_test_profile.php?pid=<?php echo $patient->patientId; ?>&labsection=<?php echo $lab_section?>' title='Click to View Patient Profile'>Select Tests</a>
					<?php }?>
										</td>
                                        <td <?php (is_billing_enabled($_SESSION['lab_config_id']) ? print("") : print("style='display:none'")) ?> >
                    <?php          
                    if($user->level == 16){
						 if (in_array("52", $rw_option) || in_array("2", $rw_option) || in_array("3", $rw_option) || in_array("4", $rw_option) || in_array("6", $rw_option) || in_array("7", $rw_option)) {
					?>
			               <a  target='_blank' href=<?php echo $billing_url_string; ?> title='Click to generate a bill for this patient'>Generate Bill</a>
					<?php } 
					} else {?>
			               <a  target='_blank' href=<?php echo $billing_url_string; ?> title='Click to generate a bill for this patient'>Generate Bill</a>
					<?php }?>          
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
			
			<?php if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
				
			?>
				<?php 
				if(check_removal_record($_SESSION['lab_config_id'], $patient->patientId, "patient")){ ?>
						<td><a href='javascript:retrieve_deleted(<?php echo $patient->patientId;?>, "patient")' title="Click to Retrieve the deleted patient" >Retrieve</a></td>
			<?php } else {?>
						<td></td>
			<?php }
			}?>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
    <?php 
        if(isset($_REQUEST['l']))
        { 
            $next_link = "../ajax/patient_data_page.php?q=".$_REQUEST['q']."&a=".$_REQUEST['a']."&c=".$_REQUEST['c']."&l=".$_REQUEST['l']."&result_cap=".$result_cap."&result_counter=".($result_counter + 1); 
        }
        else
        {
            $next_link = "../ajax/patient_data_page.php?q=".$_REQUEST['q']."&a=".$_REQUEST['a']."&c=".$_REQUEST['c']."&result_cap=".$result_cap."&result_counter=".($result_counter + 1);             
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
<div class="prev_link">                       
     <small><a onclick="javascript:get_prev('<?php echo $prev_link; ?>', '<?php echo $result_counter - 1; ?>', '<?php echo $result_cap; ?>');">&lt;&nbsp;Previous&nbsp;</a></small>
</div>
<div class="next_link">                
     <small><a onclick="javascript:get_next('<?php echo $next_link; ?>', '<?php echo $result_counter + 1; ?>', '<?php echo $result_cap; ?>');">&nbsp;Next&nbsp&nbsp;&gt;</a></small>
</div>
</div>                
</div>
<?php
# Switch back context
if(isset($_REQUEST['l']))
{
	# Save context
	DbUtil::switchRestore($saved_db);
}
SessionUtil::restore($saved_session);
?>