<?php
ini_set('max_execution_time', 300); 
ini_set('memory_limit','300M');
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
$script_elems->enableJQueryForm();
$script_elems->enableFacebox();



?>

<style type='text/css'>
.warning {
    
    border: 1px solid;
    width: 350px;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url(../includes/img/knob_attention.png);
}
.update_error {
    
    border: 1px solid;
    width: 400px;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('../includes/img/knob_cancel.png');
}
.update_success {
    
    border: 1px solid;
    width: 350px;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    color: #000000;
    background-color: #99FF99;
    background-image: url('../includes/img/knob_valid_green.png');
}
</style>

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
<b><?php echo "Test Count Report"; ?></b>
<br><br>

<?php
//print_r($_REQUEST);
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
putUILog('reports_test_count_grouped', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
# Fetch site-wide settings
//$site_settings = DiseaseReport::getByKeys($lab_config->id, 0, 0);

$configArray = getTestCountGroupedConfig($lab_config->id);
//echo "--".$configArray['group_by_age'].$configArray['group_by_gender'].$configArray['age_groups'].$configArray['measure_groups'].$configArray['measure_id']."<br>";
# Fetch report configuration
$byAge = $configArray['group_by_age'];
$age_group_list = decodeAgeGroups($configArray['age_groups']);
$byGender = $configArray['group_by_gender'];
$bySection = $configArray['measure_id'];
$combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending 

/*
$byAge = 1;
$bySection = 1;
$byGender = 0;
*/
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

$dhims2_test_config = array();
$dhims2_test_item = array();
			
if($bySection == 0)
{
$table_css = "style='padding: .3em; border: 1px black solid; font-size:14px;'";
?>
<br>
<table style='border-collapse: collapse;'>
	<thead>
		<tr>
			<th><?php echo LangUtil::$generalTerms['TEST']; ?></th>
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
		</tr>
	</thead>
	<tbody>
        <?php
            $test_type_list = get_lab_config_test_types($lab_config->id); // to get test type ids            
            /*$cat_test_types = TestType::getByCategory($cat_codes[$cc]);
            $cat_test_ids = array();
            $selected_test_ids = $lab_config->getTestTypeIds();

            foreach($cat_test_types as $test_type)
                $cat_test_ids[] = $test_type->testTypeId;
            $matched_test_ids = array_intersect($cat_test_ids, $selected_test_ids);
            $selected_test_ids = array_values($matched_test_ids);
            $test_type_list = $selected_test_ids;
            */ 
            $saved_db = DbUtil::switchToLabConfig($lab_config->id);
            $tests_done_list = array();
            $tests_list=array();
            $summ = 0;			
            foreach($test_type_list as $test_type_id)
		{
				
                    $test_name = get_test_name_by_id($test_type_id);
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
                        //$age_slot_list = $site_settings->getAgeGroupAsList();
                        $age_slot_list = decodeAgeGroups($configArray['age_groups']);						
                        $count_male_t_total = 0;
                        $count_female_t_total = 0;
                        $count_male_c_total = 0;
                        $count_female_c_total = 0;
                        $count_male_p_total = 0;
                        $count_female_p_total = 0;
                        foreach($age_slot_list as $age_slot)
                        {                        
							//I have to cate for days and months as well    
                            $age_from = trim($age_slot[0]); 
                            if(trim($age_slot[1]) == "+")
                                $age_to = 200;
                            else
                                $age_to = trim($age_slot[1]);
                            
                            if($byGender == 1)
                            {
                                
                                if($combo == 1)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_t_total += $count_male_t;
                                    $count_female_t_total += $count_female_t;                                    
                                    echo "<td>";
                                    echo $count_male_t;
                                    echo "<br>";
                                    echo $count_female_t;
                                    echo "</td>";
									$dhims2_test_item['test_type_id']=$test_type_id;
									$dhims2_test_item['gender']='M';
									$dhims2_test_item['value']=$count_male_t;									
									$dhims2_test_item['age_group']=$age_slot[0].'-'.$age_slot[1];									
									$dhims2_test_config[] = $dhims2_test_item;
									$dhims2_test_item = array();
									
									$dhims2_test_item['test_type_id']=$test_type_id;
									$dhims2_test_item['gender']='F';
									$dhims2_test_item['value']=$count_female_t;								
									$dhims2_test_item['age_group']=$age_slot[0].'-'.$age_slot[1];									
									$dhims2_test_config[] = $dhims2_test_item;
									$dhims2_test_item = array();
									
                                    
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $count_male_c_total += $count_male_c;
                                    $count_female_c_total += $count_female_c;
                                    echo "<td>";
                                    echo $count_male_c;
                                    echo "<br>";
                                    echo $count_female_c;
                                    echo "</td>";
									
									$dhims2_test_item['test_type_id']=$test_type_id;
									$dhims2_test_item['gender']='M';
									$dhims2_test_item['value']=$count_male_c;									
									$dhims2_test_item['age_group']=$age_slot[0].'-'.$age_slot[1];									
									$dhims2_test_config[] = $dhims2_test_item;
									$dhims2_test_item = array();
									
									$dhims2_test_item['test_type_id']=$test_type_id;
									$dhims2_test_item['gender']='F';									
									$dhims2_test_item['value']=$count_female_c;
									$dhims2_test_item['age_group']=$age_slot[0].'-'.$age_slot[1];									
									$dhims2_test_config[] = $dhims2_test_item;
									$dhims2_test_item = array();
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_female_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
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
                                    $count_male_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_t_total += $count_male_t;
                                    $count_female_t_total += $count_female_t;
                                    echo "<td>";
                                    echo $count_male_t + $count_female_t;
                                    echo "</td>";
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $count_male_c_total += $count_male_c;
                                    $count_female_c_total += $count_female_c;
                                    echo "<td>";
                                    echo $count_male_c + $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_female_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
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
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
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
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    
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
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
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
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    echo "<td>";
                                    echo $count_male_t + $count_female_t;
                                    echo "</td>";
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    echo "<td>";
                                    echo $count_male_c + $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
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

</div>
<?php
}
else
{
    
    
$sections = array();
$sections = get_test_categories_data($lab_config_id->id);

$sec_count = count($sections);


for($sc = 0; $sc < $sec_count; $sc++)
{
$sec_code = $sections[$sc][0];
$sec_name = $sections[$sc][1];

echo "<br><br><table><tr><td>";
echo "Section: </td><td>".$sec_name."</td></tr></table>";
                               

?>

<br>
<table style='border-collapse: collapse;'>
	<thead>
		<tr>
			<th><?php echo LangUtil::$generalTerms['TEST']; ?></th>
			<?php
			if($byGender == 1)
			{
				echo "<th >".LangUtil::$generalTerms['GENDER']."</th>";
			}
			if($byAge == 1)
			{
                            $age_group_list = decodeAgeGroups($configArray['age_groups']);

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
                            $age_group_list = decodeAgeGroups($configArray['age_groups']);

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
		</tr>
	</thead>
	<tbody>
        <?php
            $test_type_list = get_test_ids_by_category($sec_code, $lab_config_id->id);
                //$test_type_list = get_lab_config_test_types($lab_config->id); // to get test type ids
            
            //$cat_test_types = TestType::getByCategory($cat_codes[$cc]);
            //$cat_test_ids = array();
            //$selected_test_ids = $lab_config->getTestTypeIds();

           // foreach($cat_test_types as $test_type)
             //   $cat_test_ids[] = $test_type->testTypeId;
            /*$matched_test_ids = array_intersect($cat_test_ids, $selected_test_ids);
            $selected_test_ids = array_values($matched_test_ids);
            $test_type_list = $selected_test_ids;*/
            
            $saved_db = DbUtil::switchToLabConfig($lab_config->id);
            $tests_done_list = array();
            $tests_list=array();
            $summ = 0;
            foreach($test_type_list as $test_type_id)
		{
                    $test_name = get_test_name_by_id($test_type_id);
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
                        //$age_slot_list = $site_settings->getAgeGroupAsList();
                        $age_slot_list = decodeAgeGroups($configArray['age_groups']);
                        $count_male_t_total = 0;
                        $count_female_t_total = 0;
                        $count_male_c_total = 0;
                        $count_female_c_total = 0;
                        $count_male_p_total = 0;
                        $count_female_p_total = 0;
                        foreach($age_slot_list as $age_slot)
                        {
                            //I have to cate for days and months as well  
                            $age_from = trim($age_slot[0]);
                            if(trim($age_slot[1]) == "+")
                                $age_to = 200;
                            else
                                $age_to = trim($age_slot[1]);
                            
                            if($byGender == 1)
                            {
                                
                                if($combo == 1)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_t_total += $count_male_t;
                                    $count_female_t_total += $count_female_t;                                    
                                    echo "<td>";
                                    echo $count_male_t;
                                    echo "<br>";
                                    echo $count_female_t;
                                    echo "</td>";
									
									$dhims2_test_item['test_type_id']=$test_type_id;
									$dhims2_test_item['gender']='M';
									$dhims2_test_item['value']=$count_male_t;									
									$dhims2_test_item['age_group']=$age_slot[0].'-'.$age_slot[1];									
									$dhims2_test_config[] = $dhims2_test_item;
									$dhims2_test_item = array();
									
									$dhims2_test_item['test_type_id']=$test_type_id;	
									$dhims2_test_item['gender']='F';								
									$dhims2_test_item['value']=$count_female_t;
									$dhims2_test_item['age_group']=$age_slot[0].'-'.$age_slot[1];									
									$dhims2_test_config[] = $dhims2_test_item;
									$dhims2_test_item = array();
                                    
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $count_male_c_total += $count_male_c;
                                    $count_female_c_total += $count_female_c;
                                    echo "<td>";
                                    echo $count_male_c;
                                    echo "<br>";
                                    echo $count_female_c;
                                    echo "</td>";
									
									$dhims2_test_item['test_type_id']=$test_type_id;
									$dhims2_test_item['gender']='M';
									$dhims2_test_item['value']=$count_male_c;									
									$dhims2_test_item['age_group']=$age_slot[0].'-'.$age_slot[1];									
									$dhims2_test_config[] = $dhims2_test_item;
									$dhims2_test_item = array();
									
									$dhims2_test_item['test_type_id']=$test_type_id;
									$dhims2_test_item['gender']='F';									
									$dhims2_test_item['value']=$count_female_c;
									$dhims2_test_item['age_group']=$age_slot[0].'-'.$age_slot[1];									
									$dhims2_test_config[] = $dhims2_test_item;
									$dhims2_test_item = array();
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_female_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
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
                                    $count_male_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_t_total += $count_male_t;
                                    $count_female_t_total += $count_female_t;
                                    echo "<td>";
                                    echo $count_male_t + $count_female_t;
                                    echo "</td>";
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $count_male_c_total += $count_male_c;
                                    $count_female_c_total += $count_female_c;
                                    echo "<td>";
                                    echo $count_male_c + $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_male_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to);
                                    $count_female_c = get_test_count_grouped($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, 1);
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
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
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
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    
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
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
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
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    echo "<td>";
                                    echo $count_male_t + $count_female_t;
                                    echo "</td>";
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    echo "<td>";
                                    echo $count_male_c + $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);
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
<?php
}
?>
<br><br><br>
</div>
<?php
}
?>
<table width="100%"><tr><td style="border:dotted thin #000"></td></tr></table>
<?php
if($byAge == 1 && $byGender == 1 && $combo !=3 )
{
	include_once("includes/page_elems.php");	
	$user = get_user_by_id($_SESSION['user_id']);
	//Enable the click to DHIMS2 button for all users
	//if(isAdmin($user))
	//{
		?>
        <table width="100%">
        <tr>
        <td align="center">
        <span id='dhims2_send_progress' style='display:none'><?php
        
        $page_elems = new PageElems();
        $page_elems->getProgressSpinnerBig("Connecting to DHIMS2, Please wait...");?> </span>        
        </td>
        </tr>
        <tr>
        <td align="center"> 
        <div id="dhims2_send_link" style="display:block;" class="warning"><b>DHIMS2 INTERFACE</b>
            	<form name="dhims2_frm" id="dhims2_frm" action="../api/dhims2_send.php" method="post">
                <input type="hidden" value='<?php echo json_encode($dhims2_test_config);?>' name="dhims2_test_counts" id="dhims2_test_counts"  />
                <input type="hidden" name="lab_config_id" id="lab_config_id" value="<?php  echo $lab_config_id?>" />
                Username:<input type="text" name="dhims2_username" id="dhims2_username" /><br />
                Password:<input type="password" name="dhims2_password" id="dhims2_username" /> <br />
                 <a id='update_link' href='javascript:send_to_dhims();'>SEND TO DHIMS</a>              
                </form>               
            </div>
            <div id="dhims2_send_failure" style="display:none;" class="update_error">
   <b>Sending Error!</b><form name="dhims2_frm_retry" id="dhims2_frm_retry" action="../api/dhims2_send.php" method="post">
                <input type="hidden" value='<?php echo json_encode($dhims2_test_config);?>' name="dhims2_test_counts" id="dhims2_test_counts"  />
                <input type="hidden" name="lab_config_id" id="lab_config_id" value="<?php  echo $lab_config_id?>" />
                Username:<input type="text" name="dhims2_username" id="dhims2_username" /><br />
                Password:<input type="password" name="dhims2_password" id="dhims2_username" /> <br />                            
                </form> Please try again by clicking <a id='update_link' href='javascript:send_to_dhims_retry();'>here</a><br>
    If still unsuccessful report error to BLIS Team
    </div>

 <div id="dhims2_send_success"  style="display:none;" class="update_success">
    <b>Sending Successful!</b><br /> Configured test counts have been sent to DHIMS2 successfully
    <br />
    <a rel='facebox' href='#response_success'>DHIMS2 response</a>
   
    </div>
            </td>
        </tr>
        </table>  
        
         <div id='response_success' class='update_success' style='display:none;margin-left:10px; width:auto; height:auto'> 
         </div>
 <?php
	//}
 }
?>

<script type="text/javascript">
	function send_to_dhims()
	{
		var period = Date('Ym');
		var msg = "This will send only DHIMS2 configured tests with values on this page.\nAlso note that system will set reporting period as LAST MONTH. \n\nPlease confirm!";
				
		if (confirm(msg)==false){
			return;
		}
	
		$('#dhims2_send_link').hide();
		$('#dhims2_send_failure').hide();
		$('#dhims2_send_progress').show();	
		try
		{	
		$('#dhims2_frm').ajaxSubmit({
		success: function(status) {
			handleDHIMS2Response(status);
		}
	});
		}catch(err){alert(err.message);}
	
	}
	
	function send_to_dhims_retry()
	{		
		$('#dhims2_send_link').hide();
		$('#dhims2_send_failure').hide();
		$('#dhims2_send_progress').show();	
		try
		{	
		$('#dhims2_frm_retry').ajaxSubmit({
		success: function(status) {
			handleDHIMS2Response(status);
		}
	});
		}catch(err){alert(err.message);}
	
		
	}
	
	function handleDHIMS2Response(status)
	{
		$('#dhims2_send_progress').hide();
			if ( status == "false" ) {
				$('#dhims2_send_link').show();				
				alert("Authentication Error: Invalid Login credentials");				
			}
			else if ( status =="404" ) {				
				$('#dhims2_send_link').show();			
				alert("The DHIMS2 server cannot be found! Please check your internet connection");				
			}
			else if ( status =="no" ) {				
				$('#dhims2_send_link').show();			
				alert("Error! DHIMS2 Interface has not been configured. or No DHIMS2 test values found.\nPlease contact your administrator");				
			}
			else if ( status=="0" ) {					
				
				$('#dhims2_send_failure').show();				
			}
			else
			{				
				$('#response_success').html(status);
				$('#dhims2_send_success').show();
			}	
	}

</script>