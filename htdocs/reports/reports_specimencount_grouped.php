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

include("../users/accesslist.php");
 if(!(isLoggedIn(get_user_by_id($_SESSION['user_id']))))
	header( 'Location: home.php' );

$script_elems = new ScriptElems();
$script_elems->enableJQuery();

$uiinfo = "from=".$date_from."%to=".$date_to;
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

<div id='report_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<b><?php echo "Specimen Count Report"; ?></b>
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
$uiinfo = "from=".$date_from."&to=".$date_to;
putUILog('reports_specimen_count_grouped', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');


$configArray = getSpecimenCountGroupedConfig($lab_config->id);
//echo "--".$configArray['group_by_age'].$configArray['group_by_gender'].$configArray['age_groups'].$configArray['measure_groups'].$configArray['measure_id']."<br>";
# Fetch report configuration
$byAge = $configArray['group_by_age'];
$age_group_list = decodeAgeGroups($configArray['age_groups']);
$byGender = $configArray['group_by_gender'];
$bySection = $configArray['measure_id'];
$combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending 
$combo = 1;
//$age_group_list = $site_settings->getAgeGroupAsList();
?>
<table>
	<tbody>
		<tr>
			<td><?php echo LangUtil::$generalTerms['FACILITY']; ?>:</td>
			<td><?php echo $lab_config->getSiteName(); ?></td>
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
		
		
	</tbody>
</table>
<?php

$table_css = "style='padding: .3em; border: 1px black solid; font-size:14px;'";
?>
<br>
<table style='border-collapse: collapse;'>
	<thead>
		<tr>
			<th><?php echo LangUtil::$generalTerms['SPECIMEN']; ?></th>
			<?php
			if($byGender == 1)
			{
				echo "<th >".LangUtil::$generalTerms['GENDER']."</th>";
			}
			if($byAge == 1)
			{
				echo "<th >".LangUtil::$pageTerms['RANGE_AGE']."</th>";
				for($i = 1; $i < count($age_group_list); $i++)
				{
					echo "<th >".LangUtil::$pageTerms['RANGE_AGE']."</th>";
				}
			}
                        else
                        {
                            echo "<th >"."Count"."</th>";
                        }
			if($byAge == 1 && $byGender == 1)
			{
				echo "<th >".LangUtil::$pageTerms['TOTAL_MF']."</th>";
			}
			?>
			
                        
                        <?php if($byAge == 1 || $byGender == 1)
                        {
                            echo "<th>".LangUtil::$pageTerms['TOTAL_TESTS']."</th>";
                        }
                        ?>
                        
		</tr>
		<tr>
			<th ></th>
			<?php
			if($byGender == 1)
			{
				echo "<th ></th>";
			}
			
			if($byAge == 1)
			{
				foreach($age_group_list as $age_slot)
				{
					echo "<th>$age_slot[0]";
					if(trim($age_slot[1]) == "+")
						echo "+";
					else
						echo " - $age_slot[1]";
					echo "</th>";
				}
			}
                        else
                        {
                            echo "<th ></th>";
                        }
			if($byAge == 1 && $byGender == 1)
			{
				echo "<th ></th>";
			}
                        
                        if($byAge == 1 || $byGender == 1)
                            echo "<th ></th>";
			?>
		<tr>
	</thead>
	<tbody>
        <?php
            # Fetching specimen IDs but keeping the variables similar to reports_testcount_grouped.php
            $test_type_list = get_lab_config_specimen_types($lab_config->id);
            //$test_type_list = get_lab_config_test_types($lab_config->id); // to get test type ids
            $saved_db = DbUtil::switchToLabConfig($lab_config->id);
            $tests_done_list = array();
            $tests_list=array();
            $summ = 0;
            foreach($test_type_list as $test_type_id)
		{
                    $test_name = get_specimen_name_by_id($test_type_id);
                    echo "<tr valign='top'>";
                        echo "<td>";
                            echo $test_name;
                        echo "</td>";
                        
                        if($byGender == 1)
                        {
                            echo "<td>";
                                echo "M";
                                echo "<br>";
                                echo "F";
                            echo "</td>";
                        }
                
                    # Group by age set to true: Fetch age slots from DB
                    if($byAge == 1)
                    {
                        $age_slot_list = decodeAgeGroups($configArray['age_groups']);
                        $count_male_t_total = 0;
                        $count_female_t_total = 0;
                        $count_male_c_total = 0;
                        $count_female_c_total = 0;
                        $count_male_p_total = 0;
                        $count_female_p_total = 0;
                        foreach($age_slot_list as $age_slot)
                        {
                            
                            $age_from = intval(trim($age_slot[0]));
                            if(trim($age_slot[1]) == "+")
                                $age_to = 100;
                            else
                                $age_to = intval(trim($age_slot[1]));
                            
                            if($byGender == 1)
                            {
                                
                                if($combo == 1)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $gender = 'F';
                                    $count_female_t = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_t_total += $count_male_t;
                                    $count_female_t_total += $count_female_t;                                    
                                    echo "<td>";
                                    echo $count_male_t;
                                    echo "<br>";
                                    echo $count_female_t;
                                    echo "</td>";
                                    
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_c = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $count_male_c_total += $count_male_c;
                                    $count_female_c_total += $count_female_c;
                                    echo "<td>";
                                    echo $count_male_c;
                                    echo "<br>";
                                    echo $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_c = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_t = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_female_c = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $count_male_p = $count_male_t - $count_male_c;
                                    $count_female_p = $count_female_t - $count_female_c;
                                    
                                    $count_male_c_total += $count_male_c;
                                    $count_female_c_total += $count_female_c;
                                    $count_male_p_total += $count_male_p;
                                    $count_female_p_total += $count_female_p;
                                    
                                    echo "<td>";
                                    echo $count_male_c." / ".$count_male_p;
                                    echo "<br>";
                                    echo $count_female_c." / ".$count_female_p;
                                    echo "</td>";
                                }
                                    
                            }
                            else
                            {
                                if($combo == 1)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $gender = 'F';
                                    $count_female_t = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_t_total += $count_male_t;
                                    $count_female_t_total += $count_female_t;
                                    echo "<td>";
                                    echo $count_male_t + $count_female_t;
                                    echo "</td>";
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_c = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $count_male_c_total += $count_male_c;
                                    $count_female_c_total += $count_female_c;
                                    echo "<td>";
                                    echo $count_male_c + $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_c = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_t = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_female_c = get_specimen_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $count_male_p = $count_male_t - $count_male_c;
                                    $count_female_p = $count_female_t - $count_female_c;
                                    $count_male_c_total += $count_male_c;
                                    $count_female_c_total += $count_female_c;
                                    $count_male_p_total += $count_male_p;
                                    $count_female_p_total += $count_female_p;
                                    echo "<td>";
                                    echo ($count_male_c + $count_female_c)." / ".($count_male_p + $count_female_p);
                                    echo "</td>";
                                }
                            }
                        }
                        if($byGender == 1)
                        {
                            if($combo == 1)
                            {
                                    echo "<td>";
                                    echo $count_male_t_total;
                                    echo "<br>";
                                    echo $count_female_t_total;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $count_male_t_total + $count_female_t_total;
                                    echo "</td>";
                            }
                            else if($combo == 2)
                            {
                                    echo "<td>";
                                    echo $count_male_c_total;
                                    echo "<br>";
                                    echo $count_female_c_total;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $count_male_c_total + $count_female_c_total;
                                    echo "</td>";
                            }
                            else if($combo == 3)
                            {
                                    echo "<td>";
                                    echo $count_male_c_total." / ".$count_male_p_total;
                                    echo "<br>";
                                    echo $count_female_c_total." / ".$count_female_p_total;
                                    echo "</td>";
                                    echo "<td>";
                                    echo ($count_male_c_total + $count_female_c_total)." / ".($count_male_p_total + $count_female_p_total);
                                    echo "</td>";
                            }
                        }
                        else
                        {
                            if($combo == 1)
                            {
                                    echo "<td>";
                                    echo $count_male_t_total + $count_female_t_total;
                                    echo "</td>";
                            }
                            else if($combo == 2)
                            {
                                    echo "<td>";
                                    echo $count_male_c_total + $count_female_c_total;
                                    echo "</td>";
                            }
                            else if($combo == 3)
                            {
                                    echo "<td>";
                                    echo ($count_male_c_total + $count_female_c_total)." / ".($count_male_p_total + $count_female_p_total);
                                    echo "</td>";
                            }
                        }
                    }
                    else
                    {
                        if($byGender == 1)
                            {
                                if($combo == 1)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $gender = 'F';
                                    $count_female_t = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    echo "<td>";
                                    echo $count_male_t;
                                    echo "<br>";
                                    echo $count_female_t;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $count_male_t + $count_female_t;
                                    echo "</td>";
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_c = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    
                                    echo "<td>";
                                    echo $count_male_c;
                                    echo "<br>";
                                    echo $count_female_c;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $count_male_c + $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_male_c = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_t = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_female_c = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $count_male_p = $count_male_t - $count_male_c;
                                    $count_female_p = $count_female_t - $count_female_c;
                                    echo "<td>";
                                    echo $count_male_c." / ".$count_male_p;
                                    echo "<br>";
                                    echo $count_female_c." / ".$count_female_p;
                                    echo "</td>";
                                    echo "<td>";
                                    echo ($count_male_c + $count_female_c)." / ".($count_male_p + $count_female_p);
                                    echo "</td>";
                                }
                                    
                            }
                            else
                            {
                                 if($combo == 1)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $gender = 'F';
                                    $count_female_t = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    echo "<td>";
                                    echo $count_male_t + $count_female_t;
                                    echo "</td>";
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_c = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    echo "<td>";
                                    echo $count_male_c + $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_male_c = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_t = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_female_c = get_specimen_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $count_male_p = $count_male_t - $count_male_c;
                                    $count_female_p = $count_female_t - $count_female_c;
                                    echo "<td>";
                                    echo ($count_male_c + $count_female_c)." / ".($count_male_p + $count_female_p);
                                    echo "</td>";
                                }
                            }
                    }
                    echo "</tr>";
                } 
        ?>
 <!-- ********************************************************************** -->
	
	</tbody>
</table>
<br><br><br>
............................................
</div>