<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    include("redirect.php");
    //include("includes/header.php");
include("../includes/db_lib.php");



//echo checkVersionDataTable();
//echo setVersionDataFlag(1, '2.2');
//echo exec('scc.bat');
/*
$uiLog = new UILog();
$uiLog->id = 'id';
$uiLog->info = '-';
$uiLog->file = basename($_SERVER['REQUEST_URI'], ".php");
$uiLog->tag1 = 'X';
$uiLog->tag2 = 'X';
$uiLog->tag3 = 'X';
$uiLog->writeUILog();
*/
/*
global $VERSION;
                $vers = $VERSION;
                $verss = str_replace('.','-',$vers);
                echo $verss;*/
//putUILog('$id', '$info', basename($_SERVER['REQUEST_URI'], ".php"), '$tag1', '$tag2', '$tag 3');
//import_test_between_labs(137, 128, 10);
//$name = "Serum Fluid";
//$unit = "ml";
//$remarks = "some remarks too";
//Inventory::addReagent($name, $unit, $remarks);
//$siteList = get_site_list($_SESSION['user_id']);
//echo "<pre>";
//print_r($siteList);
//echo "</pre>";

/*
$my_name = "test 1";
echo ucwords(strtolower($my_name));
echo "<br>";

$encName = "\$sub*112/\$name";
            $start_tag = "\$sub*";
            $end_tag = "/\$";
            $subm_end = strpos($encName, $end_tag);
            $parent = substr($encName, 5, $end_tag - 5);
            $parent_int = intval($parent);
echo $parent_int."<br>";

            $start_tag = "\$sub*";
            $end_tag = "/\$";
            $subm_end = strpos($encName, $end_tag);
            $decName = substr($encName, $subm_end + 2);
echo $decName."<br>";

if(strpos($encName, "\$sub") !== false)
                {
                    echo "1";
                }
                else
                {
                    echo "0";
                }
echo "<br>";
$mm = 33;
$tagID = "\$sub*".$mm."/\$";
echo $tagID;
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
$i = 0;
$y = 0;
$us = '_';
 echo "<tr valign='top' id='smrow_$i$us$y' ";
 echo "<br>";
 $adde = array();
 $adde[0] = array();
 for($r = 0; $r < 5; $r++)
 $adde[0][] = $r + 1;
 $i = 3;
 $submeasure_tag = "\$sub*".$adde[0][0]."/$";
 echo $submeasure_tag;
  echo "<br>--------------<br>";
$added_measures_list = array(3, 9);
  $added_submeasures_list = array(7, 2);
 $merged_list = array_merge($added_measures_list, $added_submeasures_list);
sort($merged_list);

print_r($merged_list);
 echo "<br>--------------<br>";
 
 
 
 $test_type = TestType::getById(130);
		$measure_list = $test_type->getMeasures();
		//$result_csv = "[$]12345[/$],1,109,9,A,,";
                $result_csv ="[$]abcdef1[/$],109,145,8,B,,";
                //echo "<br>";
                //echo $result_csv;
                //echo "<br>";
 
                if(strpos($result_csv, "[$]") === false)
                {
                    $result_list = explode(",", $result_csv);
                }
                else
                {
                    //$testt = "one,[$]two[/$],[$]twotwo[/$],three";
                    $testt = $result_csv;
                    //$test2 = strstr($testt, $);
                    $start_tag = "[$]";
                    $end_tag = "[/$]";
                    //$testtt = str_replace("[$]two[/$],", "", $testt);
                    $freetext_results = array();
                    $ft_count = substr_count($testt, $start_tag);
                    //echo $ft_count;
                    $k = 0;
                    while($k < $ft_count)
                    {
                        $ft_beg = strpos($testt, $start_tag);
                        $ft_end = strpos($testt, $end_tag);
                        $ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                        $ft_left = substr($testt, 0, $ft_beg);
                        $ft_right = substr($testt, $ft_end + 4);
                        $testt = $ft_left.$ft_right;
                        array_push($freetext_results, $ft_sub);
                        $k++;
                    }
                    print_r($freetext_results);
                    echo "<br>";
                    echo $testt;
                    //echo $freetext_results."<br>".$testt;
                    //$testtt = str_replace($subb, "", $testt, 1);
                    //echo "$testto<br>$subb<br>";
                    $result_csv = $testt;
                    if(strpos($testt, ",") == 0)
                            $result_csv = substr($testt, 1, strlen($testt)); 
                    $result_list = explode(",", $result_csv);
                    //echo "<br>";
                    //print_r($result_list);
                    //echo "<br>";
                    print_r($freetext_results);
                    echo "<br>";
                    echo $testt;
                    echo "<br>";
                    print_r($result_list);
                }
                $retval = "";
                //NC3065
                //echo print_r($measure_list);
                //echo "<br>";
                //echo $result_csv;
                //echo "<br>";
                //echo print_r($result_list,true);
                //echo "Num->".count($measure_list);
		//-NC3065
                $j = 0;
                $i = 0;
                $c = 0;
                //for($i = 0; $i < count($measure_list); $i++) {
                while($c < count($measure_list)) {
			# Pretty print
			$curr_measure = $measure_list[$c];
			if($curr_measure->getRangeType() != Measure::$RANGE_FREETEXT)
                        {
                            if(isset($result_list[$i]))
                            {    
                                //echo "Num->".$i;
                                    # If matching result value exists (e.g. after a new measure was added to this test type)
                                    if(count($measure_list) == 1)
                                    {
                                            # Only one measure: Do not print measure name
                                            if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE) {
                                                    $result_string = "";
                                                    $value_list = explode("_", $result_list[$i]);
                                                    foreach($value_list as $value) {
                                                            if(trim($value) == "")
                                                                    continue;
                                                            $result_string .= $value."<br>";
                                                    }
                                                    $result_string = substr($result_string, 0, -4);
                                                    $retval .= "<br>".$result_string."&nbsp;";
                                            }
                                            else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
                                            {
                                                    if($result_list[$i] != $curr_measure->unit)
                                                            $retval .= "<br><b>".$result_list[$i]."</b> &nbsp;";
                                                    else
                                                            $retval .= "<br>".$result_list[$i]."&nbsp;";
                                            }
                                            else
                                            {
                                                    $retval .= "<br>".$result_list[$i]."&nbsp;";
                                            }
                                    }
                                    else
                                    {
                                            # Print measure name with each result value
                                        //CHNG
                                        if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = $curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                            $retval .= "<br>".$decName.":"."&nbsp;";
                                            //chng
                                            if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE)
                                            {
                                                    $result_string = "";
                                                    $value_list = str_replace("_", ",", $result_list[$i]);
                                                    $retval .= "<br>".$value_list."<br>";
                                            }
                                            else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
                                            {
                                                    if($result_list[$i]!=$curr_measure->unit)
                                                            $retval .= "<b>".$result_list[$i]."</b> &nbsp;";
                                                    else
                                                            $retval .= $result_list[$i]."&nbsp;";
                                            }
                                            else
                                                    $retval .= $result_list[$i]."&nbsp;";
                                    }

                                    if($show_range === true)
                                    {
                                            $retval .= $curr_measure->getRangeString();
                                    }
                                    if($i != count($measure_list) - 1)
                                    {
                                            $retval .= "<br>";
                                    }
                            }
                            else
                            {
                                    # Matching result value not found: Show "-"
                                    if(count($measure_list) == 1)
                                    {
                                        //chng
                                        if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = $curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                            $retval .= $decName."&nbsp;";
                                            //chng
                                    }
                                    $retval .= " - <br>";
                            }
                            $i++;
                        }
                        else
                        {
                            $ft_result = $freetext_results[$j];

                            if(count($measure_list) == 1)
                            {
                                $retval .= "<br>".$ft_result."&nbsp;";   
                            }
                            else
                            {
                                $retval .= "<br>".$curr_measure->name.":"."&nbsp;".$ft_result."&nbsp;"; //removed <br>
                            }
                            if($show_range === true)
                                        {
                                                $retval .= $curr_measure->getRangeString();
                                        }
                                        if($i != count($measure_list) - 1)
                                        {
                                                $retval .= "<br>";
                                        }
                            $j++;
                            
                        }$c++;
                }
                echo $retval;
                
    echo "<br>----------------------------------------------<br>";  
    

       /*

         # beginning of measure deletion]
        $measures_to_be_deleted = array();
        
        $test_type_obj = get_test_type_by_id(130);
 $result_indices = array();
$update_timestamp = mktime(18, 30, 0, 6, 25, 2012);
$test_records_to_update = getTestRecordsByDate($update_timestamp, $test_type_obj->testTypeId);
$del_tag = "##";

$measure_list_objs = $test_type_obj->getMeasures();
                //print_r($measure_listt);
                $submeasure_list_objs = array();
                
                $comb_measure_list = array();
               // print_r($measure_list);
                
                foreach($measure_list_objs as $measure)
                {
                    
                    $submeasure_list_objs = $measure->getSubmeasuresAsObj();
                    //echo "<br>".count($submeasure_list);
                    //print_r($submeasure_list);
                    $submeasure_countt = count($submeasure_list_objs);
                    
                    if($measure->checkIfSubmeasure() == 1)
                    {
                        continue;
                    }
                        
                    if($submeasure_countt == 0)
                    {
                        array_push($comb_measure_list, $measure);
                    }
                    else
                    {
                        array_push($comb_measure_list, $measure);
                        foreach($submeasure_list_objs as $submeasuree)
                           array_push($comb_measure_list, $submeasuree); 
                    }
                }
                
                $comb_measure_list_ids = array();
                
                foreach($comb_measure_list as $measuree)
                {
                    array_push($comb_measure_list_ids, $measuree->measureId);
                }
                
                for($del = 0; $del < count($measures_to_be_deleted); $del++)
                {
                    if($comb_measure_list_ids[$del] == $measures_to_be_deleted[$del])
                        $result_indices[$del] = 1;
                    else
                        $result_indices[$del] = 0;
                }
                $measure_listt = $comb_measure_list;
                $result_indices[1] = 1;
                $result_indices[0] = 1;
                foreach($test_records_to_update as $tru)
                {
                    $result_csv = $tru->getResultWithoutHash();
                    $hash_in_result = $tru->getHashInResult();
                    //$result_csv = $this->getResultWithoutHash();
                    //echo "<br>";
                    //echo $result_csv;
                    //echo "<br>";
                    if(strpos($result_csv, "[$]") === false)
                    {
                        $result_list = explode(",", $result_csv);
                    }
                    else
                    {
                        //$testt = "one,[$]two[/$],[$]twotwo[/$],three";
                        $testt = $result_csv;
                        //$test2 = strstr($testt, $);
                        $start_tag = "[$]";
                        $end_tag = "[/$]";
                        //$testtt = str_replace("[$]two[/$],", "", $testt);
                        $freetext_results = array();
                        $ft_count = substr_count($testt, $start_tag);
                        //echo $ft_count;
                        $k = 0;
                        while($k < $ft_count)
                        {
                            $ft_beg = strpos($testt, $start_tag);
                            $ft_end = strpos($testt, $end_tag);
                            $ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                            $ft_left = substr($testt, 0, $ft_beg);
                            $ft_right = substr($testt, $ft_end + 5);
                            //echo "<br>".$ft_left."--".$ft_right."<br>";
                            $testt = $ft_left.$ft_right;
                            array_push($freetext_results, $ft_sub);
                            $k++;
                        }
                        //echo $freetext_results."<br>".$testt;
                        //$testtt = str_replace($subb, "", $testt, 1);
                        //echo "$testto<br>$subb<br>";
                        $result_csv = $testt;
                        if(strpos($testt, ",") == 0)
                                $result_csv = substr($testt, 1, strlen($testt)); 
                        $result_list = explode(",", $result_csv);
                        //echo "<br>";
                        //print_r($result_list);
                        //echo "<br>";
                    }
                    //NC3065
                    //echo print_r($measure_list);
                    //echo "<br>";
                    //echo $result_csv;
                    //echo "<br>";
                    //echo print_r($result_list,true);
                    //echo "Num->".count($measure_list);
                    //-NC3065
                    $vf = 0;
                    $vo = 0;
                    $c = 0;
                    $result_up = "";
                    echo "--".$result_list[0][1];
                    while($c < count($measure_listt)) 
                    {
                        $curr_measure = $measure_listt[$c];
                        
			if($curr_measure->getRangeType() != Measure::$RANGE_FREETEXT)
                        {
                           if($result_indices[$c] == 1)
                           {
                               $result_up .= "##";
                               $result_up .= $result_list[$vo];
                           }
                           else
                           {
                               $result_up .= $result_list[$vo];
                           }
                           $vo++;
                        }
                        else
                        {
                            if($result_indices[$c] == 1)
                           {
                               $result_up .= "##[$]";
                               $result_up .= $freetext_results[$vf];
                               $result_up .= "[\$]";
                           }
                           else
                           {
                               $result_up .= "[$]";
                               $result_up .= $freetext_results[$vf];
                               $result_up .= "[\$]";
                           }
                           $vf++;
                        }
                         $result_up .= ",";
                        $c++;
                    }
                    $result_up .= ",";
                    $result_up .= $hash_in_result;
                    $test_id_up = $tru->testId;
                    echo $result_up;
                    //updateTestRecordByIds($test_id_up, $result_up);

                }
    $test_type_obj = get_test_type_by_id(130);
 $result_indices = array();
//$update_timestamp = mktime(0, 0, 0, 7, 1, 2012);
 $update_timestamp = mktime(18, 30, 0, 6, 25, 2012);

$test_records_to_update = getTestRecordsByDate($update_timestamp, 130);
$del_tag = "##";

$measure_list_objs = $test_type_obj->getMeasures();
                //print_r($measure_listt);
                $submeasure_list_objs = array();
                
                $comb_measure_list = array();
               // print_r($measure_list);
                
                foreach($measure_list_objs as $measure)
                {
                    
                    $submeasure_list_objs = $measure->getSubmeasuresAsObj();
                    //echo "<br>".count($submeasure_list);
                    //print_r($submeasure_list);
                    $submeasure_countt = count($submeasure_list_objs);
                    
                    if($measure->checkIfSubmeasure() == 1)
                    {
                        continue;
                    }
                        
                    if($submeasure_countt == 0)
                    {
                        array_push($comb_measure_list, $measure);
                    }
                    else
                    {
                        array_push($comb_measure_list, $measure);
                        foreach($submeasure_list_objs as $submeasuree)
                           array_push($comb_measure_list, $submeasuree); 
                    }
                }
                
                $comb_measure_list_ids = array();
                
                foreach($comb_measure_list as $measuree)
                {
                    array_push($comb_measure_list_ids, $measuree->measureId);
                }
                
                $update_del = 0;
                for($del = 0; $del < count($comb_measure_list_ids); $del++)
                {
                    $update_del = 0;
                    $cu = 0;
                    while($cu < count($measures_to_be_deleted))
                    {
                        if($comb_measure_list_ids[$del] == $measures_to_be_deleted[$cu])
                        {
                            $update_del = 1;
                        }
                        $cu++;
                    }
                    if($update_del == 1)
                        $result_indices[$del] = 1;
                    else
                        $result_indices[$del] = 0;
                }
                $measure_listt = $comb_measure_list;
                
                
                foreach($test_records_to_update as $tru)
                {
                    $result_csv = $tru->getResultWithoutHash2();
                    $hash_in_result = $tru->getHashInResult();
                    //$result_csv = $this->getResultWithoutHash();
                    //echo "<br>";
                    //echo $result_csv;
                    //echo "<br>";
                    if(strpos($result_csv, "[$]") === false)
                    {
                        $result_list = explode(",", $result_csv);
                    }
                    else
                    {
                        //$testt = "one,[$]two[/$],[$]twotwo[/$],three";
                        $testt = $result_csv;
                        //$test2 = strstr($testt, $);
                        $start_tag = "[$]";
                        $end_tag = "[/$]";
                        //$testtt = str_replace("[$]two[/$],", "", $testt);
                        $freetext_results = array();
                        $freetext_results_remv = array();
                        $ft_count = substr_count($testt, $start_tag);
                        //echo $ft_count;
                        $k = 0;
                        $ft_indices = array();
                        while($k < $ft_count)
                        {
                            
                            $ft_beg = strpos($testt, $start_tag);
                            if($ft_beg != 0)
                            {
                                
                                if($testt[$ft_beg - 1] == "#")
                                {
                                    $ft_indices[$k] = 1;
                                    $ft_end = strpos($testt, $end_tag);
                                    $ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                                    $ft_left = substr($testt, 0, $ft_beg - 2);
                                    $ft_right = substr($testt, $ft_end + 5);
                                    $testt = $ft_left."#f#,".$ft_right;
                                    array_push($freetext_results_remv, $ft_sub);
                                }
                                else
                                {
                                    $ft_indices[$k] = 0;
                                    $ft_end = strpos($testt, $end_tag);
                                    $ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                                    $ft_left = substr($testt, 0, $ft_beg);
                                    $ft_right = substr($testt, $ft_end + 5);
                                    $testt = $ft_left.$ft_right;
                                    array_push($freetext_results, $ft_sub);
                                }
                            }
                            else
                            {
                                $ft_indices[$k] = 0;

                                $ft_end = strpos($testt, $end_tag);
                                $ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                                $ft_left = substr($testt, 0, $ft_beg);
                                $ft_right = substr($testt, $ft_end + 5);
                                //echo "<br>".$ft_left."--".$ft_right."<br>";
                                $testt = $ft_left.$ft_right;
                                array_push($freetext_results, $ft_sub);
                            }
                            //$ft_end = strpos($testt, $end_tag);
                            //$ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                            //$ft_left = substr($testt, 0, $ft_beg);
                            //$ft_right = substr($testt, $ft_end + 5);
                            //$testt = $ft_left.$ft_right;
                            //array_push($freetext_results, $ft_sub);
                            $k++;
                        }
                        echo "<br>->";
                        print_r($freetext_results);
                        //echo $freetext_results."<br>".$testt;
                        //$testtt = str_replace($subb, "", $testt, 1);
                        //echo "$testto<br>$subb<br>";
                        $result_csv = $testt;
                        if(strpos($testt, ",") == 0)
                                $result_csv = substr($testt, 1, strlen($testt)); 
                        echo "<br>->";
                        echo ($result_csv);
                        $result_list = explode(",", $result_csv);
                        //echo "<br>";
                        //print_r($result_list);
                        //echo "<br>";
                        echo "<br>->";
                        print_r($result_list);
                    }
                    //NC3065
                    //echo print_r($measure_list);
                    //echo "<br>";
                    //echo $result_csv;
                    //echo "<br>";
                    //echo print_r($result_list,true);
                    //echo "Num->".count($measure_list);
                    //-NC3065
                    $vf = 0;
                    $vo = 0;
                    $c = 0;
                    $vfr = 0;
                    $cr = 0;
                    $result_up = "";
                    while($c < count($measure_listt)) 
                    {
                        $curr_measure = $measure_listt[$c];
                       if($result_list[$vo] == "#f#")
                       {
                           $result_up .= "##[$]";
                                        $result_up .= $freetext_results_remv[$vfr];
                                        $result_up .= "[/$]";
                                        $result_up .= ",";
                                    $vfr++;
                                    $vo++;
                                    continue;
                       }
                        
                        
                            if($curr_measure->getRangeType() != Measure::$RANGE_FREETEXT)
                            {
                                if($result_list[$vo][0] == "#" && $result_list[$cr][1] == "#")
                                {
                                     $result_up .= $result_list[$vo];
                                     $result_up .= ",";
                                     $vo++;
                                    
                                }
                                else
                                {
                                    if($result_indices[$c] == 1)
                                    {
                                        $result_up .= "##";
                                        $result_up .= $result_list[$vo];
                                    }
                                    else
                                    {
                                        $result_up .= $result_list[$vo];
                                        $cr++;
                                    }
                                    $vo++;
                                    $result_up .= ",";
                                    $c++;
                                 }
                            }
                            else
                            {
                                
                                
                                    if($result_indices[$c] == 1)
                                    {
                                        $result_up .= "##[$]";
                                        $result_up .= $freetext_results[$vf];
                                        $result_up .= "[/$]";
                                        $result_up .= ",";
                                        $c++;
                                        $vf++;
                                    }
                                    else
                                    {
                                        $result_up .= "[$]";
                                        $result_up .= $freetext_results[$vf];
                                        $result_up .= "[/$]";
                                        $result_up .= ",";
                                        $c++;
                                        $vf++;
                                    }
                                
                                
                            }
                               
                    
                        
                    }
                    $result_up .= ",";
                    $result_up .= $hash_in_result;
                    $test_id_up = $tru->testId;
                    echo "<br>->".$result_up;
                    //updateTestRecordByIds($test_id_up, $result_up);

                }
                echo "<br>-------------------------###################-----------------------------------";
                $subm_ids = getSubmeasureIDs(305);
                echo "<br>Seee<br>";
                print_r($subm_ids);
                
*/
?>
