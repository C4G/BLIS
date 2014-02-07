<?php
#
# Returns list of patients matched with list of pending specimens
# Called via Ajax form result_entry.php
#

include("../includes/db_lib.php");
include("../includes/user_lib.php");
LangUtil::setPageId("results_entry");

$attrib_value = $_REQUEST['labSectionId'];

$dynamic = 1;
$search_settings = get_lab_config_settings_search();
$rcap = $search_settings['results_per_page'];
//echo "Max results per page : ".$rcap; 
$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
$uiinfo = "labSectionId=".$_REQUEST['labSectionId'];
putUILog('result_entry_patient_lab_section', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

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
        url_string = 'ajax/result_data_count_labsection.php?q='+'<?php echo $_REQUEST['labSectionId']; ?>';
        var cap = parseInt($('#rcap').html());
        $('.prev_link').hide();

        $.ajax({ 
		url: url_string, 
        async : false,
		success: function(count){
                    var icount = parseInt(count);
                     if(icount < cap)
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


    // EDITING
    # Search by Lab Section Id
    $query_string = 
				"SELECT specimen_id FROM test WHERE result='' ".
				"AND test_type_id IN (SELECT test_type_id FROM test_type WHERE test_category_id=$attrib_value) ".
    			"LIMIT 0,$rcap";
    
    //$saved_db = DbUtil::switchToLabConfig(127);
    //$retval = array();

$resultset = query_associative_all($query_string, $row_count);
//echo $query_string;
//DbUtil::switchRestore($saved_db);
//echo "Length ".count($resultset);

if(count($resultset) == 0 || $resultset == null)
{
	?>
	<div class='sidetip_nopos'>
	<?php 
	
	
	echo "In the above Lab Section - ".LangUtil::$pageTerms['MSG_PENDINGNOTFOUND'];
    ?>
	</div>
	<?php
	return;
}
$specimen_id_list_all = array();
$specimen_id_list = array();
$temp_count = 0;

foreach($resultset as $record)
{
	$specimen_id_list_all[] = $record['specimen_id'];
	//echo $record['specimen_id'];
}
# Remove duplicates that might come due to multiple pending tests
$specimen_id_list_all = array_values(array_unique($specimen_id_list_all));

//echo "Test ".count($specimen_id_list);
$category="specimen";
foreach ($specimen_id_list_all as $specimen1){
	if(check_removal_record($_SESSION['lab_config_id'], $specimen1, $category) > 0)
		continue;
	else
		$specimen_id_list[] = $specimen1;
}
?>
<div id="rcap" style="display: none;"><?php echo $rcap; ?></div>
<div id="page" style="display: none;">1</div>
<div id="mpage" style="display: none;">1</div>
<div id="rem" style="display: none;"></div>
<div id="tot" style="display: none;"></div>

<font color="grey"><small><div id="result_counts" style="float: right; padding-right: 16px"><!-- 0 results  --></div></small></font>
<font color="grey"><small><div id="page_counts" style="float: right; padding-right: 16px"><!-- 1/1 Page  --></div></small></font>

<br>

                    
<div id='data_table'>                    
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
	//print_r($specimen_id_list);
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
				<td style='width:75px;'><?php echo $patient->getSurrogateId(). " ". $temp_count++; ?></td>
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
        if(isset($_REQUEST['l']))
        { 
            $next_link = "../ajax/result_data_page_labsection.php?a=".$_REQUEST['labSectionId']."&l=".$_REQUEST['l']."&result_cap=".$result_cap."&result_counter=".($result_counter+1); 
        }
        else
        {
            $next_link = "../ajax/result_data_page_labsection.php?a=".$_REQUEST['labSectionId']."&result_cap=".$result_cap."&result_counter=".($result_counter+1);             
        }
        if(isset($_REQUEST['l']))
        { 
            $prev_link = "../ajax/result_data_page.php_labsection?a=".$_REQUEST['labSectionId']."&l=".$_REQUEST['l']."&result_cap=".$result_cap."&result_counter=".($result_counter - 1); 
        }
        else
        {
            $prev_link = "../ajax/result_data_page.php_labsection?a=".$_REQUEST['labSectionId']."&result_cap=".$result_cap."&result_counter=".($result_counter - 1);             
        }
    ?>        
<div class="prev_link">                       
     <small><a href="javascript:get_prev('<?php echo $prev_link; ?>', '<?php echo $result_counter - 1; ?>', '<?php echo $result_cap; ?>');">&lt;&nbsp;Previous&nbsp;</a></small>
</div>
<div class="next_link">                
     <small><a href="javascript:get_next('<?php echo $next_link; ?>', '<?php echo $result_counter + 1; ?>', '<?php echo $result_cap; ?>');">&nbsp;Next&nbsp&nbsp;&gt;</a></small>
</div>
</div>
