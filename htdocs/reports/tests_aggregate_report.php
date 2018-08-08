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
<link rel='stylesheet' type='text/css' href='../css/table.css' />
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

<form name='word_format_form' id='word_format_form' action='export_word_aggregate.php' method='post' target='_blank'>
    <input type='hidden' name='data' value='' id='word_data' />
    <input type='hidden' name='report_type' value='test_aggregate_report' id='report_type' />
    <input type='button' onclick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type='button' onclick="javascript:export_as_word();" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
</form>
<hr>

<div id='report_content'>
    <link rel='stylesheet' type='text/css' href='css/table_print.css' />
    <b><font size="5"><?php echo "Test Aggregate Report"; ?></b>
    <br><br>

    <font size="4"><?php
        //print_r($_REQUEST);
        $date_from = $_REQUEST['yyyy_from']."-".$_REQUEST['mm_from']."-".$_REQUEST['dd_from'];
        $date_to = $_REQUEST['yyyy_to']."-".$_REQUEST['mm_to']."-".$_REQUEST['dd_to'];
        $uiinfo = "from=".$date_from."&to=".$date_to;
        putUILog('tests_aggregate_report', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
        # Fetch site-wide settings
        //$site_settings = DiseaseReport::getByKeys($location[0], 0, 0);
        echo LangUtil::$pageTerms['REPORT_PERIOD'].": ";

        if($date_from == $date_to)
        {
            echo DateLib::mysqlToString($date_from);
        }
        else
        {
            echo DateLib::mysqlToString($date_from)." to ".DateLib::mysqlToString($date_to);
        }
        ?>
        <br>

        <?php


        if($_REQUEST["locationAgg"] == null)
        {
            echo "Location not found. Please choose a facility (import and choose if doesn't exist) on previous page.";
            return;
        }

        $age_unit_flag = 0;

        $location = explode(":", $value); //location array is of the format [<Facility_id>, <Facility_name>, <Facility_location>]
        $lab_id_revamp = 0; //lab id for revamp is 0.
        $configArray = getTestCountGroupedConfigCountryDir($lab_id_revamp);
        $byAge = $configArray['group_by_age'];
        $age_group_list = decodeAgeGroups($configArray['age_groups']);
        $byGender = $configArray['group_by_gender'];
        $bySection = $configArray['measure_id'];
        $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending
        #$combo = 1;
        $age_unit = $configArray['age_unit'];
        if($byAge == 1 && $age_unit_flag == 0)
        {

            if($age_unit == 1)
                echo "Age Unit: "."Years";
            else if($age_unit == 2)
                echo "Age Unit: "."Months";
            else if($age_unit == 3)
                echo "Age Unit: "."Weeks";
            else if($age_unit == 4)
                echo "Age Unit: "."Days";
            $age_unit_flag = 1;
        }


        $aggregate = array();
        $tests = array();


        foreach($_REQUEST["locationAgg"] as $value)
        {
            //echo "value: ". $value;
            $location = explode(":", $value); //location array is of the format [<Facility_id>, <Facility_name>, <Facility_location>]

            ?>
            <br>

            <table>
                <br>
                <tbody>
                <hr>
                <tr>
                    <td><b><font size="4"><?php echo LangUtil::$generalTerms['FACILITY']; ?></b></td>
                    <td><font size="4"><?php echo ":&nbsp;"?></td>
                    <td><font size="4"><?php echo $location[1]." - ".$location[2]; ?></td>
                </tr>
                </tbody>
            </table>
            <?php

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
                    $test_type_list = get_lab_config_test_types($location[0]); // to get test type ids
                    /*$cat_test_types = TestType::getByCategory($cat_codes[$cc]);
                    $cat_test_ids = array();
                    $selected_test_ids = $lab_config->getTestTypeIds();

                    foreach($cat_test_types as $test_type)
                        $cat_test_ids[] = $test_type->testTypeId;
                    $matched_test_ids = array_intersect($cat_test_ids, $selected_test_ids);
                    $selected_test_ids = array_values($matched_test_ids);
                    $test_type_list = $selected_test_ids;
                    */
                    $saved_db = DbUtil::switchToLabConfig($location[0]);
                    $tests_done_list = array();
                    $tests_list=array();
                    $summ = 0;
                    foreach($test_type_list as $test_type_id)
                    {

                        if(!isset( $tests[$test_type_id]))  $tests[$test_type_id] = 0;
                        $tests[$test_type_id] += 1;

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
                                        $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                        // echo $test_type_id. $gender. $age_from. $age_to;

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to]))$aggregate[$test_type_id. $gender. $age_from. $age_to]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to]+=$count_male_t;


                                        $gender = 'F';
                                        $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to]))$aggregate[$test_type_id. $gender. $age_from. $age_to]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to]+=$count_female_t;

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
                                        $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to."1"]))$aggregate[$test_type_id. $gender. $age_from. $age_to."1"]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to."1"]+=$count_male_c;

                                        $gender = 'F';
                                        $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to."1"]))$aggregate[$test_type_id. $gender. $age_from. $age_to."1"]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to."1"]+=$count_female_c;

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
                                        $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                        $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to]))$aggregate[$test_type_id. $gender. $age_from. $age_to]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to]+=$count_male_t;
                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to."1"]))$aggregate[$test_type_id. $gender. $age_from. $age_to."1"]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to."1"]+=$count_male_c;


                                        $gender = 'F';
                                        $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                        $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to]))$aggregate[$test_type_id. $gender. $age_from. $age_to]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to]+=$count_female_t;
                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to."1"]))$aggregate[$test_type_id. $gender. $age_from. $age_to."1"]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to."1"]+=$count_female_c;


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
                                        $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to]))$aggregate[$test_type_id. $gender. $age_from. $age_to]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to]+=$count_male_t;

                                        $gender = 'F';
                                        $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to]))$aggregate[$test_type_id. $gender. $age_from. $age_to]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to]+=$count_female_t;

                                        $count_male_t_total += $count_male_t;
                                        $count_female_t_total += $count_female_t;
                                        echo "<td>";
                                        echo $count_male_t + $count_female_t;
                                        echo "</td>";
                                    }
                                    else if ($combo == 2)
                                    {
                                        $gender = 'M';
                                        $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to."1"]))$aggregate[$test_type_id. $gender. $age_from. $age_to."1"]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to."1"]+=$count_male_c;

                                        $gender = 'F';
                                        $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to."1"]))$aggregate[$test_type_id. $gender. $age_from. $age_to."1"]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to."1"]+=$count_male_c;

                                        $count_male_c_total += $count_male_c;
                                        $count_female_c_total += $count_female_c;
                                        echo "<td>";
                                        echo $count_male_c + $count_female_c;
                                        echo "</td>";
                                    }
                                    else if ($combo == 3)
                                    {
                                        $gender = 'M';
                                        $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                        $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);

                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to]))$aggregate[$test_type_id. $gender. $age_from. $age_to]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to]+=$count_male_t;
                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to."1"]))$aggregate[$test_type_id. $gender. $age_from. $age_to."1"]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to."1"]+=$count_male_c;


                                        $gender = 'F';
                                        $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                        $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);


                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to]))$aggregate[$test_type_id. $gender. $age_from. $age_to]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to]+=$count_female_t;
                                        if(!isset($aggregate[$test_type_id. $gender. $age_from. $age_to."1"]))$aggregate[$test_type_id. $gender. $age_from. $age_to."1"]=0;
                                        $aggregate[$test_type_id. $gender. $age_from. $age_to."1"]+=$count_female_c;

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

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to]))$aggregate[$test_type_id. $gender. $date_from. $date_to]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to]+=$count_male_t;

                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to]))$aggregate[$test_type_id. $gender. $date_from. $date_to]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to]+=$count_female_t;

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

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to."1"]))$aggregate[$test_type_id. $gender. $date_from. $date_to."1"]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to."1"]+=$count_male_c;

                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);


                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to."1"]))$aggregate[$test_type_id. $gender. $date_from. $date_to."1"]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to."1"]+=$count_female_c;

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

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to]))$aggregate[$test_type_id. $gender. $date_from. $date_to]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to]+=$count_male_t;
                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to."1"]))$aggregate[$test_type_id. $gender. $date_from. $date_to."1"]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to."1"]+=$count_male_c;

                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);


                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to]))$aggregate[$test_type_id. $gender. $date_from. $date_to]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to]+=$count_female_t;
                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to."1"]))$aggregate[$test_type_id. $gender. $date_from. $date_to."1"]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to."1"]+=$count_female_c;



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

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to]))$aggregate[$test_type_id. $gender. $date_from. $date_to]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to]+=$count_male_t;

                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to]))$aggregate[$test_type_id. $gender. $date_from. $date_to]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to]+=$count_female_t;

                                    echo "<td>";
                                    echo $count_male_t + $count_female_t;
                                    echo "</td>";
                                }
                                else if ($combo == 2)
                                {
                                    $gender = 'M';
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to."1"]))$aggregate[$test_type_id. $gender. $date_from. $date_to."1"]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to."1"]+=$count_female_c;


                                    $gender = 'F';
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to."1"]))$aggregate[$test_type_id. $gender. $date_from. $date_to."1"]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to."1"]+=$count_female_c;


                                    echo "<td>";
                                    echo $count_male_c + $count_female_c;
                                    echo "</td>";
                                }
                                else if ($combo == 3)
                                {
                                    $gender = 'M';
                                    $count_male_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_male_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to]))$aggregate[$test_type_id. $gender. $date_from. $date_to]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to]+=$count_male_t;
                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to."1"]))$aggregate[$test_type_id. $gender. $date_from. $date_to."1"]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to."1"]+=$count_male_c;

                                    $gender = 'F';
                                    $count_female_t = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
                                    $count_female_c = get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender, 1);

                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to]))$aggregate[$test_type_id. $gender. $date_from. $date_to]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to]+=$count_female_t;
                                    if(!isset($aggregate[$test_type_id. $gender. $date_from. $date_to."1"]))$aggregate[$test_type_id. $gender. $date_from. $date_to."1"]=0;
                                    $aggregate[$test_type_id. $gender. $date_from. $date_to."1"]+=$count_female_c;

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


                <?php
            }
            else
            {


                $sections = array();
                $sections = get_test_categories_data($location[0]);

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
                        $test_type_list = get_test_ids_by_category($sec_code, $location[0]);
                        //$test_type_list = get_lab_config_test_types($location[0]); // to get test type ids

                        //$cat_test_types = TestType::getByCategory($cat_codes[$cc]);
                        //$cat_test_ids = array();
                        //$selected_test_ids = $lab_config->getTestTypeIds();

                        // foreach($cat_test_types as $test_type)
                        //   $cat_test_ids[] = $test_type->testTypeId;
                        /*$matched_test_ids = array_intersect($cat_test_ids, $selected_test_ids);
                        $selected_test_ids = array_values($matched_test_ids);
                        $test_type_list = $selected_test_ids;*/

                        $saved_db = DbUtil::switchToLabConfig($location[0]);
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
                                            $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $gender = 'F';
                                            $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
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
                                            $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $gender = 'F';
                                            $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
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
                                            $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $gender = 'F';
                                            $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
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
                                            $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $gender = 'F';
                                            $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_male_t_total += $count_male_t;
                                            $count_female_t_total += $count_female_t;
                                            echo "<td>";
                                            echo $count_male_t + $count_female_t;
                                            echo "</td>";
                                        }
                                        else if ($combo == 2)
                                        {
                                            $gender = 'M';
                                            $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $gender = 'F';
                                            $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $count_male_c_total += $count_male_c;
                                            $count_female_c_total += $count_female_c;
                                            echo "<td>";
                                            echo $count_male_c + $count_female_c;
                                            echo "</td>";
                                        }
                                        else if ($combo == 3)
                                        {
                                            $gender = 'M';
                                            $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $gender = 'F';
                                            $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
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

                <?php
            }
            ?>

            <?php
            //}
        }


        //////////////////////AGGREGATE TABLE CODE/////////////////////////////

        if($_REQUEST["resultAgg"]=="common"){
            foreach($tests as $i => $test){

                if($test < count($_REQUEST["locationAgg"])) {
                    unset($tests[$i]);
                }
            }
        }

        {
            //echo "value: ". $value;
            $location = explode(":", $value); //location array is of the format [<Facility_id>, <Facility_name>, <Facility_location>]

            ?>
            <br>
            <div id="aggregateResults">
            <table>
                <br>
                <tbody>
                <hr>
                <tr>
                    <td><b><font size="4"><?php echo LangUtil::$generalTerms['ALL_FACILITIES']; ?></b></td>
                    <td><font size="4"><?php echo ":&nbsp;"?></td>
                </tr>
                </tbody>
            </table>
            <?php

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
                    //$test_type_list = get_lab_config_test_types($location[0]); // to get test type ids
                    /*$cat_test_types = TestType::getByCategory($cat_codes[$cc]);
                    $cat_test_ids = array();
                    $selected_test_ids = $lab_config->getTestTypeIds();

                    foreach($cat_test_types as $test_type)
                        $cat_test_ids[] = $test_type->testTypeId;
                    $matched_test_ids = array_intersect($cat_test_ids, $selected_test_ids);
                    $selected_test_ids = array_values($matched_test_ids);
                    $test_type_list = $selected_test_ids;
                    */
                    //$saved_db = DbUtil::switchToLabConfig($location[0]);
                    $tests_done_list = array();
                    $tests_list=array();
                    $summ = 0;
                    $testList = array_keys($tests);
                    foreach($testList as $test_type_id)
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
                                        $count_male_t = $aggregate[$test_type_id. $gender. $age_from. $age_to];

                                        $gender = 'F';
                                        $count_female_t = $aggregate[$test_type_id. $gender. $age_from. $age_to];


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
                                        $count_male_c = $aggregate[$test_type_id. $gender. $age_from. $age_to."1"];

                                        $gender = 'F';
                                        $count_female_c = $aggregate[$test_type_id. $gender. $age_from. $age_to."1"];


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
                                        $count_male_t = $aggregate[$test_type_id. $gender. $age_from. $age_to];
                                        $count_male_c = $aggregate[$test_type_id. $gender. $age_from. $age_to."1"];


                                        $gender = 'F';
                                        $count_female_t = $aggregate[$test_type_id. $gender. $age_from. $age_to];
                                        $count_female_c = $aggregate[$test_type_id. $gender. $age_from. $age_to."1"];


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
                                        $count_male_t = $aggregate[$test_type_id. $gender. $age_from. $age_to];


                                        $gender = 'F';
                                        $count_female_t = $aggregate[$test_type_id. $gender. $age_from. $age_to];



                                        $count_male_t_total += $count_male_t;
                                        $count_female_t_total += $count_female_t;
                                        echo "<td>";
                                        echo $count_male_t + $count_female_t;
                                        echo "</td>";
                                    }
                                    else if ($combo == 2)
                                    {
                                        $gender = 'M';
                                        $count_male_c = $aggregate[$test_type_id. $gender. $age_from. $age_to."1"];


                                        $gender = 'F';
                                        $count_female_c = $aggregate[$test_type_id. $gender. $age_from. $age_to."1"];


                                        $count_male_c_total += $count_male_c;
                                        $count_female_c_total += $count_female_c;
                                        echo "<td>";
                                        echo $count_male_c + $count_female_c;
                                        echo "</td>";
                                    }
                                    else if ($combo == 3)
                                    {
                                        $gender = 'M';
                                        $count_male_t = $aggregate[$test_type_id. $gender. $age_from. $age_to];
                                        $count_male_c = $aggregate[$test_type_id. $gender. $age_from. $age_to."1"];


                                        $gender = 'F';
                                        $count_female_t = $aggregate[$test_type_id. $gender. $age_from. $age_to];
                                        $count_female_c = $aggregate[$test_type_id. $gender. $age_from. $age_to."1"];



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
                                    $count_male_t =  get_test_count_grouped2($test_type_id, $date_from, $date_to, $gender);
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


                <?php
            }
            else
            {


                $sections = array();
                $sections = get_test_categories_data($location[0]);

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
                        $test_type_list = get_test_ids_by_category($sec_code, $location[0]);
                        //$test_type_list = get_lab_config_test_types($location[0]); // to get test type ids

                        //$cat_test_types = TestType::getByCategory($cat_codes[$cc]);
                        //$cat_test_ids = array();
                        //$selected_test_ids = $lab_config->getTestTypeIds();

                        // foreach($cat_test_types as $test_type)
                        //   $cat_test_ids[] = $test_type->testTypeId;
                        /*$matched_test_ids = array_intersect($cat_test_ids, $selected_test_ids);
                        $selected_test_ids = array_values($matched_test_ids);
                        $test_type_list = $selected_test_ids;*/

                        $saved_db = DbUtil::switchToLabConfig($location[0]);
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
                                            $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $gender = 'F';
                                            $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
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
                                            $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $gender = 'F';
                                            $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
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
                                            $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $gender = 'F';
                                            $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
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
                                            $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $gender = 'F';
                                            $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_male_t_total += $count_male_t;
                                            $count_female_t_total += $count_female_t;
                                            echo "<td>";
                                            echo $count_male_t + $count_female_t;
                                            echo "</td>";
                                        }
                                        else if ($combo == 2)
                                        {
                                            $gender = 'M';
                                            $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $gender = 'F';
                                            $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $count_male_c_total += $count_male_c;
                                            $count_female_c_total += $count_female_c;
                                            echo "<td>";
                                            echo $count_male_c + $count_female_c;
                                            echo "</td>";
                                        }
                                        else if ($combo == 3)
                                        {
                                            $gender = 'M';
                                            $count_male_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_male_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
                                            $gender = 'F';
                                            $count_female_t = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit);
                                            $count_female_c = get_test_count_grouped_country_dir($test_type_id, $date_from, $date_to, $gender, $age_from, $age_to, $age_unit, 1);
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
                                        $count_male_t = $aggregate[$test_type_id. $gender. $date_from. $date_to];

                                        $gender = 'F';
                                        $count_female_t = $aggregate[$test_type_id. $gender. $date_from. $date_to];


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
                                        $count_male_c = $aggregate[$test_type_id. $gender. $date_from. $date_to."1"];



                                        $gender = 'F';
                                        $count_female_c = $aggregate[$test_type_id. $gender. $date_from. $date_to."1"];




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
                                        $count_male_t = $aggregate[$test_type_id. $gender. $date_from. $date_to];
                                        $count_male_c = $aggregate[$test_type_id. $gender. $date_from. $date_to."1"];



                                        $gender = 'F';
                                        $count_female_t = $aggregate[$test_type_id. $gender. $date_from. $date_to];
                                        $count_female_c = $aggregate[$test_type_id. $gender. $date_from. $date_to."1"];




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
                                        $count_male_t = $aggregate[$test_type_id. $gender. $date_from. $date_to];

                                        $gender = 'F';
                                        $count_female_t = $aggregate[$test_type_id. $gender. $date_from. $date_to];


                                        echo "<td>";
                                        echo $count_male_t + $count_female_t;
                                        echo "</td>";
                                    }
                                    else if ($combo == 2)
                                    {
                                        $gender = 'M';
                                        $count_male_c = $aggregate[$test_type_id. $gender. $date_from. $date_to."1"];


                                        $gender = 'F';
                                        $count_female_c = $aggregate[$test_type_id. $gender. $date_from. $date_to."1"];



                                        echo "<td>";
                                        echo $count_male_c + $count_female_c;
                                        echo "</td>";
                                    }
                                    else if ($combo == 3)
                                    {
                                        $gender = 'M';
                                        $count_male_t = $aggregate[$test_type_id. $gender. $date_from. $date_to];
                                        $count_male_c = $aggregate[$test_type_id. $gender. $date_from. $date_to."1"];



                                        $gender = 'F';
                                        $count_female_t = $aggregate[$test_type_id. $gender. $date_from. $date_to];
                                        $count_female_c = $aggregate[$test_type_id. $gender. $date_from. $date_to."1"];



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

                <?php
            }
            ?>
            </div>
            <?php
            //}
        }

        ?>
</div>


