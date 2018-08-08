<?php
#
# Returns list of patients matched with list of pending specimens
# Called via Ajax form result_entry.php
#

include("../includes/db_lib.php");
include("../includes/user_lib.php");
LangUtil::setPageId("results_entry");

$attrib_value = $_REQUEST['t'];
$attrib_type = $_REQUEST['a'];
$c = $_REQUEST['c'];

$lab_section = 0; // All lab section by default
if(isset($_REQUEST['labsec']))
	$lab_section = $_REQUEST['labsec']; // change the value based on the query


$dynamic = 1;
$search_settings = get_lab_config_settings_search();
$rcap = $search_settings['results_per_page'];
$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
$uiinfo = "op=".$_REQUEST['a']."&qr=".$_REQUEST['t'];
putUILog('result_entry_patient_dyn', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

?>
<style type="text/css">
    .prev_link{
        position: relative;
        float: left;
    }
    .next_link{
        position: relative;
        float: right;
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


</style>
<script type='text/javascript'>
    $(document).ready(function(){
        url_string = 'ajax/result_data_count.php?a='+'<?php echo $_REQUEST['a']; ?>'+'&q='+'<?php echo $_REQUEST['t']; ?>'+'&labsec='+'<?php echo $lab_section; ?>&c=<?php echo $_REQUEST['c'] ?>';
        var cap = parseInt($('#rcap').html());
        //console.log(cap);
        //alert(<?php echo $_REQUEST['t']; ?>+"-"+<?php echo $_REQUEST['a']; ?>);
                                        $('.prev_link').hide();

        $.ajax({ 
		url: url_string, 
                async : false,
		success: function(count){
                    var icount = parseInt(count);
                     if(icount < cap/*parseInt('<?php echo $_REQUEST['result_cap']; ?>')*/)
                        {
                         		
                                $('.next_link').hide();
                                if(icount == 0)
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
     rem = rem - cap;
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
if(!isset($_REQUEST['result_cap']))
    $result_cap = $rcap;
else
    $result_cap = $_REQUEST['result_cap'];

if(!isset($_REQUEST['result_counter']))
    $result_counter = 1;
else
    $result_counter = $_REQUEST['result_counter'];

$query_string = "";
if($dynamic == 0)
{
    if($attrib_type == 5)
    {
            # Search by specimen aux ID
            $query_string = 
                    "SELECT s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND s.aux_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id ".
                    "AND t.result = '' AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen')";
    }
    if($attrib_type == 0)
    {
            # Search by patient ID
            $query_string = 
                    "SELECT s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND p.surr_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id ".
                    "AND t.result = '' AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen') ";
    }
    else if($attrib_type == 1)
    {
            # Search by patient name
			if(empty($c))
				$attrib_value.='%';
			else	
				$attrib_value=str_replace('[pq]',$attrib_value,$c);
		
            $query_string = 
                    "SELECT COUNT(*) AS val FROM patient WHERE name LIKE '$attrib_value'";
            $record = query_associative_one($query_string);
            if($record['val'] == 0)
            {
                    # No patients found with matching name
                    ?>
                    <div class='sidetip_nopos'>
                    <b>'<?php echo $attrib_value; ?>'</b> - <?php echo LangUtil::$generalTerms['MSG_SIMILARNOTFOUND']; ?>
                    <?php
                    return;
            }
            $query_string = 
                    "SELECT s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE s.specimen_id=t.specimen_id ".
                    "AND t.result = '' ".
                    "AND s.patient_id=p.patient_id ".
                    "AND p.name LIKE '$attrib_value' AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen')";
    }
    else if($attrib_type == 3)
    {
            # Search by patient daily number
            $query_string = 
                    "SELECT specimen_id FROM specimen ".
                    "WHERE daily_num LIKE '%-$attrib_value' ".
                    "AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
                    "OR status_code_id=".Specimen::$STATUS_REFERRED." ) AND specimen_id NOT IN (select r_id from removal_record where category='specimen')".
                    "ORDER BY date_collected DESC";
    }
}
else
{
    if($attrib_type == 5)
    {
    	
            # Search by specimen aux ID
    	if($lab_section == 0) {
    		$query_string = 
                    "SELECT s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND s.aux_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
                    "AND t.result = '' LIMIT 0,$rcap ";
    	} else {
			$query_string =
					"SELECT s.specimen_id FROM specimen s, test t, patient p ".
					"WHERE p.patient_id=s.patient_id ".
					"AND s.aux_id='$attrib_value'".
					"AND s.specimen_id=t.specimen_id ".
					"AND t.result = '' AND test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section) AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) LIMIT 0,$rcap ";
		}
    }
    if($attrib_type == 0)
    {
            # Search by patient ID
    	if($lab_section == 0) {
    		$query_string = 
                    "SELECT s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND p.surr_id='$attrib_value'".
                    "AND s.specimen_id=t.specimen_id AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
                    "AND t.result = '' LIMIT 0,$rcap ";
    	} else {
    		$query_string =
					"SELECT s.specimen_id FROM specimen s, test t, patient p ".
					"WHERE p.patient_id=s.patient_id ".
					"AND p.surr_id='$attrib_value'".
					"AND s.specimen_id=t.specimen_id ".
					"AND t.result = '' AND test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section) AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) LIMIT 0,$rcap ";
    	}
    }
    else if($attrib_type == 1)
    {
            # Search by patient name
			if(empty($c))
				$attrib_value.='%';
			else	
				$attrib_value=str_replace('[pq]',$attrib_value,$c);
				
            $query_string = 
                    "SELECT COUNT(*) AS val FROM patient WHERE name LIKE '$attrib_value'";
            $record = query_associative_one($query_string);
            if($record['val'] == 0)
            {
                    # No patients found with matching name
                    ?>
                    <div class='sidetip_nopos'>
                    <b>'<?php echo $attrib_value; ?>'</b> - <?php echo LangUtil::$generalTerms['MSG_SIMILARNOTFOUND']; ?>
                    <?php
                    return;
            }
            
            if($lab_section == 0) {
            $query_string = 
                    "SELECT s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE s.specimen_id=t.specimen_id ".
                    "AND t.result = '' ".
                    "AND s.patient_id=p.patient_id ".
                    "AND p.name LIKE '$attrib_value' AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) LIMIT 0,$rcap"; }
            else {
			$query_string =
					"SELECT s.specimen_id FROM specimen s, test t, patient p ".
					"WHERE s.specimen_id=t.specimen_id ".
					"AND t.result = '' ".
					"AND s.patient_id=p.patient_id AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
					"AND p.name LIKE '$attrib_value' AND test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section) LIMIT 0,$rcap";
			}
    }
    else if($attrib_type == 3)
    {
            # Search by patient daily number
    	if($lab_section == 0) {
    		$query_string = 
                    "SELECT specimen_id FROM specimen ".
                    "WHERE daily_num LIKE '%-$attrib_value' ".
                    "AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
                    "OR status_code_id=".Specimen::$STATUS_REFERRED." ) AND specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
                    "ORDER BY date_collected DESC LIMIT 0,$rcap";
    	} else {
			$query_string =
					"SELECT s.specimen_id FROM specimen s, test t WHERE s.specimen_id = t.specimen_id AND ".
					"daily_num LIKE '%-$attrib_value'".
					"AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
					"OR status_code_id=".Specimen::$STATUS_REFERRED." ) AND t.test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section) AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
					"ORDER BY date_collected DESC LIMIT 0,$rcap";
    		
    	}
    } 
    else if($attrib_type == 9)
    {
            # Search by patient specimen id
                $decoded = decodeSpecimenBarcode($attrib_value);
                if($lab_section == 0) {

				$query_string = 
                    "SELECT specimen_id FROM specimen ".
                    "WHERE specimen_id = $decoded[1] ".
                    "AND ( status_code_id=".Specimen::$STATUS_PENDING." ".
                    "OR status_code_id=".Specimen::$STATUS_REFERRED." ) AND specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
                    "ORDER BY date_collected DESC LIMIT 0,$rcap";
            	} else {
					$query_string =
						"SELECT s.specimen_id FROM specimen s, test t ".
						"WHERE s.specimen_id = $decoded[1] AND s.specimen_id = t.specimen_id ".
						"AND ( s.status_code_id=".Specimen::$STATUS_PENDING." ".
						"OR s.status_code_id=".Specimen::$STATUS_REFERRED." ) ".
						" AND t.test_type_id IN
					(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section)  ".
						"AND specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) ".
						"ORDER BY date_collected DESC LIMIT 0,$rcap";
				}
    }

    else if($attrib_type == 10)
    {
    # Search by patient specimen id
    	$decoded = decodePatientBarcode($attrib_value);
    	if($lab_section == 0) {
    
		$query_string = 
                    "SELECT s.specimen_id FROM specimen s, test t, patient p ".
                    "WHERE p.patient_id=s.patient_id ".
                    "AND p.surr_id='$decoded[1]'".
                    "AND s.specimen_id=t.specimen_id ".
                    "AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen') ";
		
            	} else {
            $query_string =
				"SELECT s.specimen_id FROM specimen s, test t, patient p ".
				"WHERE p.patient_id=s.patient_id ".
				"AND p.surr_id='$attrib_value'".
				"AND s.specimen_id=t.specimen_id ".
				"AND test_type_id IN
				(SELECT test_type_id FROM test_type WHERE test_category_id=$lab_section) AND s.specimen_id NOT IN (select r_id from removal_record where category='specimen' AND status=1) LIMIT 0,$rcap ";

			}
        }
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
        if($attrib_type == 9 || $attrib_type == 10)
        {
            echo LangUtil::$pageTerms['MSG_PENDINGNOTFOUND'];
            echo '<br>'.'Try searching by patient name';
        }
        else
        {
	echo "<b>".$attrib_value."</b>";
	echo " - ".LangUtil::$pageTerms['MSG_PENDINGNOTFOUND'];
        }
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
<div id="rcap" style="display: none;"><?php echo $rcap; ?></div>
<div id="page" style="display: none;">1</div>
<div id="mpage" style="display: none;">1</div>
<div id="rem" style="display: none;"></div>
<div id="tot" style="display: none;"></div>

<font color="grey"><small><div id="result_counts" style="float: right; padding-right: 16px">0 results</div></small></font>
<font color="grey"><small><div id="page_counts" style="float: right; padding-right: 16px">1/1 Page</div></small></font>

<br>

                    
<div id='data_table'>                    
<table class="hor-minimalist-c">
	<thead>
		<tr valign='top'>
			<?php
			if($_SESSION['pid'] != 0)
			{
			?>
				<th style='min-width:75px;max-width:75px;'><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
			<?php
			}
			if($_SESSION['dnum'] != 0)
			{
			?>
				<th style='min-width:100px;max-width:100px;'><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></th>
			<?php
			}
			if($_SESSION['p_addl'] != 0)
			{
			?>
				<th style='min-width:75px;max-width:75px;'><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></th>
			<?php
			}
			//if($_SESSION['sid'] != 0)
			// "Specimen ID" now refers to aux_id
			if(false)
			{
			?>
				<th style='min-width:75px;max-width:75px;'><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
			<?php
			}
			if($_SESSION['s_addl'] != 0)
			{
			?>
				<th style='min-width:75px;max-width:75px;'><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
			<?php
			}
			//if($lab_config->hidePatientName == 0)
			if($_SESSION['user_level'] == $LIS_TECH_SHOWPNAME)
			{
			?>
				<th style='min-width:100px;max-width:100px;'><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></th>
			<?php
			}
			else
			{
			?>
			<th style='min-width:100px;max-width:100px;'><?php echo LangUtil::$generalTerms['GENDER']."/".LangUtil::$generalTerms['AGE']; ?></th>
			<?php
			}
			?>
			<th style='min-width:100px;max-width:100px;'><?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?></th>
			<th style='min-width:100px;max-width:100px;'><?php echo LangUtil::$generalTerms['TESTS']; ?></th>
			<th style='min-width:100px;max-width:100px;padding:0px'>Results</th>
			
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
				<td style='min-width:75px;max-width:75px;'><?php echo $patient->getSurrogateId(); ?></td>
			<?php
			}
			if($_SESSION['dnum'] != 0)
			{
			?>
				<td style='min-width:100px;max-width:100px'><?php echo $specimen->getDailyNumFull(); ?></td>
			<?php
			}
			if($_SESSION['p_addl'] != 0)
			{
			?>
				<td style='min-width:75px;max-width:75px'><?php echo $patient->getAddlId(); ?></td>
			<?php
			}
			//if($_SESSION['sid'] != 0)
			// "Specimen ID" now refers to aux_id
			if(false)
			{
			?>
				<td style='min-width:75px;max-width:75px'><?php echo $specimen->specimenId; ?></td>
			<?php
			}
			if($_SESSION['s_addl'] != 0)
			{
			?>
				<td style='min-width:75px;max-width:75px'><?php echo $specimen->getAuxId(); ?></td>
			<?php
			}
			//if($lab_config->hidePatientName == 0)
			if($_SESSION['user_level'] == $LIS_TECH_SHOWPNAME)
			{
			?>
				<td style='min-width:100px;max-width:100px'><a href='javascript:fetch_specimenPat(<?php echo $patient->patientId;?>,<?php echo $specimen->specimenId;?>)'><?php echo $patient->getName();?></a><?php  echo " (".$patient->sex." ".$patient->getAgeNumber().") "; ?></td>
			<?php
			}
			else
			{
			?>
				<td style='min-width:100px;max-width:100px;'><?php echo $patient->sex."/".$patient->getAgeNumber(); ?></td>
			<?php
			}
			?>
			<td style='min-width:100px;max-width:100px;'><?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?></td>
			<td style='min-width:100px;max-width:100px;'>
			<?php
			$test_list = get_tests_by_specimen_id($specimen->specimenId);
			$i = 0;
			$number_of_tests = count($test_list);
			$results_entered = 0;
			foreach($test_list as $test)
			{
				echo get_test_name_by_id($test->testTypeId);
				$i++;
				if($i != count($test_list))
				{
					echo "<br>";
				}
				if($test->result != ''){
					$results_entered++;
				}
			}
			?>
			</td>
			<td style='min-width:100px;max-width:100px;padding:0px'>
			<?php if($number_of_tests != $results_entered){?>
			<a href="javascript:fetch_specimen2(<?php echo $specimen->specimenId; ?>);" title='Click to Enter Results for this Specimen'>
				<?php echo LangUtil::$generalTerms['ENTER_RESULTS']; ?></a>
			<?php } else { ?>
				<a href="javascript:fetch_specimen2(<?php echo $specimen->specimenId; ?>);" title='Click to Enter Results for this Specimen'>
				<?php echo "View Results"; ?></a>
			<?php }?>
			</td>
			
		</tbody>
		</table>
		<div class='result_form_pane' id='result_form_pane_<?php echo $specimen->specimenId; ?>'>
		</div>
		<div class='result_form_pane' id='result_form_pane_patient_<?php echo $specimen->specimenId; ?>'>
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
        if(isset($_REQUEST['labsec']))
        { 
            $next_link = "../ajax/result_data_page.php?a=".$_REQUEST['a']."&t=".$_REQUEST['t']."&l=".$_REQUEST['labsec']."&result_cap=".$result_cap."&result_counter=".($result_counter + 1)."&c=".$_REQUEST['c']; 
        }
        else
        {
            $next_link = "../ajax/result_data_page.php?a=".$_REQUEST['a']."&t=".$_REQUEST['t']."&result_cap=".$result_cap."&result_counter=".($result_counter + 1)."&c=".$_REQUEST['c'];             
        }
        if(isset($_REQUEST['labsec']))
        { 
            $prev_link = "../ajax/result_data_page.php?a=".$_REQUEST['a']."&t=".$_REQUEST['t']."&l=".$_REQUEST['labsec']."&result_cap=".$result_cap."&result_counter=".($result_counter - 1)."&c=".$_REQUEST['c']; 
        }
        else
        {
            $prev_link = "../ajax/result_data_page.php?a=".$_REQUEST['a']."&t=".$_REQUEST['t']."&result_cap=".$result_cap."&result_counter=".($result_counter - 1)."&c=".$_REQUEST['c'];             
        }
    ?>        
<div class="prev_link">                       
     <small><a onclick="javascript:get_prev('<?php echo $prev_link; ?>', '<?php echo $result_counter - 1; ?>', '<?php echo $result_cap; ?>');">&lt;&nbsp;Previous&nbsp;</a></small>
</div>
<div class="next_link">                
     <small><a onclick="javascript:get_next('<?php echo $next_link; ?>', '<?php echo $result_counter + 1; ?>', '<?php echo $result_cap; ?>');">&nbsp;Next&nbsp&nbsp;&gt;</a></small>
</div>
</div>
