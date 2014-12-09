<?php
#
# Main page for updating test type info
# Called via Ajax from test_type_edit.php
#

include("../includes/db_lib.php");
include("../lang/lang_xml2php.php");

//NC3065
//$user = get_user_by_id($_SESSION['user_id']);
//$lab_config_id = $_REQUEST['id'];
//-NC3065

putUILog('test_type_update', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$test_type_id = $_REQUEST['tid'];
$cat_code = $_REQUEST['cat_code'];
$measures_to_delete = array();
$reference_ranges_list = array();
$measures_to_retain = array();

//$test_type = get_test_type_by_id($_REQUEST['tid']);
$added_submeasures_list = array();
$sub_reference_ranges_list = array();

$us = '_';
$r = 0;


if($_REQUEST['cat_code'] == -1)
{
	# Add new test category to catalog
	$new_cat_name = $_REQUEST['new_category'];
	$new_cat_id = add_test_category($new_cat_name);
	$cat_code = $new_cat_id;
}
$updated_entry = new TestType();
$updated_entry->testTypeId = $_REQUEST['tid'];
$updated_entry->name = addslashes($_REQUEST['name']);
$updated_entry->description = $_REQUEST['description'];
$updated_entry->clinical_data=$_REQUEST['clinical_data'];
$updated_entry->hide_patient_name=$_REQUEST['hidePatientName'];
$updated_entry->prevalenceThreshold=$_REQUEST['prevalenceThreshold'];
$updated_entry->targetTat=$_REQUEST['targetTat'];
$updated_entry->testCategoryId = $cat_code;

$cost_cents_initial = $_REQUEST['cost_to_patient_cents'];
$cost_cents = get_cents_from_whole_number($cost_cents_initial);

$newCostToPatient = $_REQUEST['cost_to_patient_dollars'] + $cost_cents;
$oldCostToPatient = $_REQUEST['costToPatient_old'];

# Update tests measures and ranges
$is_panel = false;
$added_measures_list = array();
if($_REQUEST['ispanel'] == 1)
{
	# Panel test. Collect all selected measures
	$is_panel = true;
	$measure_list = get_measures_catalog();
	foreach($measure_list as $measure_id=>$measure_name)
	{
		if(isset($_REQUEST['m_'.$measure_id]))
		{
			# Track the measure ID (key)
			$added_measures_list[] = $measure_id;
		}
	}
}
else
{
   

	# Non-panel test. Collect all modified measures
	$measure_ids = $_REQUEST['m_id'];
        $sm_ids = $_REQUEST['sm_id'];
        //print_r($sm_ids);

	$measure_names = $_REQUEST['measure'];
	$measure_types = $_REQUEST['mtype'];
	$units = $_REQUEST['unit'];
        //$subm_ids = array();
         # beginning of measure deletion]
        $measures_to_be_deleted = array();
        for($del = 0; $del < count($measure_names); $del++)
	{	
		$measure_id_each = $measure_ids[$del];
		if (isset($_REQUEST["delete_".$measure_id_each])||($measure_names[$del] == "")) 
		{
			# Mark for deletion
			array_push($measures_to_be_deleted, $measure_ids[$del]);
                        $subm_ids = getSubmeasureIDs($measure_ids[$del]);
                        for($subid = 0; $subid < count($subm_ids); $subid++)
                        {
                            #debug
                            //echo "<br>sub=$subm_ids[$subid]";
                            array_push($measures_to_be_deleted, $subm_ids[$subid]);
                        }
		}
        }
        #debug
        //print_r($measures_to_be_deleted);
        
        $test_type_obj = get_test_type_by_id($_REQUEST['tid']);
 $result_indices = array();
$update_timestamp = mktime(0, 0, 0, 7, 3, 2012);

$test_records_to_update = getTestRecordsByDate($update_timestamp, $test_type_id);
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
                    $result_csv = "";
                    $hash_in_result = "";
                    $result_csv = $tru->getResultWithoutHash2();
                    $hash_in_result = $tru->getHashInResult();
                    $check_result = $result_csv;
                    //$result_csv = $this->getResultWithoutHash();
                    //echo "<br>";
                    //echo $result_csv;
                    //echo "<br>";
                    $freetext_results = array();
                        $freetext_results_remv = array();
                    if(strpos($result_csv, "[$]") !== false)
                    {
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
                        #debug
                        //echo "<br>freetext_results=";
                        //print_r($freetext_results);
                        //echo $freetext_results."<br>".$testt;
                        //$testtt = str_replace($subb, "", $testt, 1);
                        //echo "$testto<br>$subb<br>";
                        $result_csv = $testt;
                        if(strpos($testt, ",") == 0)
                                $result_csv = substr($testt, 1, strlen($testt)); 
                        #debug
                        //echo "<br>result_csv=";
                        //echo ($result_csv);
                        $result_list = explode(",", $result_csv);
                        //echo "<br>";
                        //print_r($result_list);
                        //echo "<br>";
                        #debug
                        //echo "<br>result_list=";
                        //print_r($result_list);
                        
                    }
                    else
                    {
                        $result_list = explode(",", $result_csv);
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
                                if($result_list[$vo][0] == "#" && $result_list[$vo][1] == "#")
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
                    #debug
                    //echo "<br>===========".$result_up;
                    if($check_result != "")
                        updateTestRecordByIds($test_id_up, $result_up);

                }

	for($i = 0; $i < count($measure_names); $i++)
	{	
		$measure_id = $measure_ids[$i];
		if (isset($_REQUEST["delete_".$measure_id])||($measure_names[$i] == "")) 
		{
			# Mark for deletion
			$measures_to_delete[] = $measure_ids[$i];
                        $subm_ids = getSubmeasureIDs($measure_ids[$i]);
                        for($subid = 0; $subid < count($subm_ids); $subid++)
                        {
                            array_push($measures_to_delete, $subm_ids[$subid]);
                        }
			continue;
		}
                
                $measure_name = $measure_names[$i];
                
                if($sm_ids[$i] > 0)
                {
                    $measure_name = "\$sub*".$sm_ids[$i]."/$".$measure_name;
                }
                
		
		$range_string = "";
		
		$reference_ranges_list[$i] = array();
		if($measure_types[$i] == Measure::$RANGE_NUMERIC)
		{
			# Numeric range
			# Clear existing ref ranges			
			ReferenceRange::deleteByMeasureId($measure_id, $_SESSION['lab_config_id']);
			# Check if new reference values and age ranges have been entered properly
			$ranges_lower = $_REQUEST['range_l_'.($i+1)];
			$ranges_upper = $_REQUEST['range_u_'.($i+1)];
			$age_lower = $_REQUEST["agerange_l_".($i+1)];
			$age_upper = $_REQUEST["agerange_u_".($i+1)];
			$gender_option = $_REQUEST["gender_".($i+1)];
			for($j = 0; $j < count($ranges_lower); $j++)
			{
				$lower_range = $ranges_lower[$j];
				$upper_range = $ranges_upper[$j];
				if($lower_range!=$upper_range)
				{
				$lower_age = 0;
				$upper_age = 0;
				if(isset($_REQUEST["agerange_l_".($i+1)]))
				{
					# Age range specified for this reference range
					$lower_age = $age_lower[$j];
					$upper_age = $age_upper[$j];
					$option_gender = $gender_option[$j];									
					/*if($lower_age > $upper_age)
					{
						# Swap
						list($lower_age, $upper_age) = array($upper_age, $lower_age);
					}*/
					$reference_ranges_list[$i][] = array($lower_range, $upper_range, $lower_age, $upper_age, $option_gender);
				}
					//$gender_option = 'B';
				
			}
			}
			//	$range_string = trim($ranges_lower[$i]).":".trim($ranges_upper[$i]);
			
			//print_r($reference_ranges_list);exit;
						
			$range_string = ":";
		}
		else if($measure_types[$i] == Measure::$RANGE_OPTIONS)
		{
			# Alphanumeric values
			$option_values = $_REQUEST['alpharange_'.($i+1)];
			
			# Check if options entered properly
			$options_entered = false;
			foreach($option_values as $option_value)
			{
				if(trim($option_value) != "")
				{
					$options_entered = true;
					$option_value=str_replace('/','#',$option_value);
					$range_string .= trim($option_value);
					$range_string .= "/";
				}
			}
			if($options_entered === false)
			{
				# Error: Option values not entered properly.
				# TODO:
			}
			# Truncate trailing "/"
			$range_string = substr($range_string, 0, -1);
		}
		else if($measure_types[$i] == Measure::$RANGE_AUTOCOMPLETE)
		{
			# Autocomplete values
			$option_values = $_REQUEST['autocomplete_'.($i+1)];
			# Check if options entered properly
			$options_entered = false;
			foreach($option_values as $option_value)
			{
				if(trim($option_value) != "")
				{
					$options_entered = true;
					$range_string .= trim($option_value);
					$range_string .= "_";
				}
			}
			if($options_entered === false)
			{
				# Error: Autocomplete values not entered properly.
				# TODO:
			}
			# Truncate trailing "_"
			$range_string = substr($range_string, 0, -1);
		}
                else if($measure_types[$i] == Measure::$RANGE_FREETEXT)
		{
			# Free Text indentifier
			$range_string = "\$freetext\$\$";
		}
		$unit = $units[$i];
		# Existing measure
		# Update measure to DB
		$measure = Measure::getById($measure_ids[$i]);
		$measure->name = $measure_name;
		$measure->range = $range_string;
		$measure->unit = $unit;
		# Update measure entry DB
		$measure->updateToDb();
		$measures_to_retain[] = $measure_ids[$i];
	}

	# Non-panel test. Collect all newly added measures
	$count_ref = count($reference_ranges_list);
	$new_measures_list = array();
	$measure_names = $_REQUEST['new_measure'];
	$measure_types = $_REQUEST['new_mtype'];
	$measure_del=$_REQUEST['new_measure_del'];
	$units = $_REQUEST['new_unit'];
        
        $submeasure_names = $_REQUEST['submeasure'];
	$submeasure_types = $_REQUEST['smtype'];
        $subunits = $_REQUEST['sunit'];
	
        $do_once = 1;
        $measures_count = count($measure_names);
        $i = 0;
        
	//for($i = 0; $i < count($measure_names);$i++)
	while ($i < $measures_count)
        {
		if((trim($measure_names[$i]) == "" )||(isset($measure_del[$i])))
			{
                        $i++;
                        continue;
                    }
		$reference_ranges_list[$count_ref] = array();
		$measure_name = $measure_names[$i];
                /*
                $encName = $measure_name;
                $start_tag = "\$sub*";
                                                                $end_tag = "/\$";
                if (strpos($encName, $start_tag) !== false) 
                {
                    $subm_end = strpos($encName, $end_tag);
                    $decName = substr($encName, $subm_end + 2);
                }
                else 
                {
                     $decName = $encName;
                }
                 * 
                 */
		$ranges_lower = $_REQUEST['new_range_l_'.($i+1)];
		$ranges_upper = $_REQUEST['new_range_u_'.($i+1)];
		$range_string = "";
		if($measure_types[$i] == Measure::$RANGE_NUMERIC)
		{ $index=0;
		$age_upper = $_REQUEST['new_agerange_u_'.($i+1)];
		$age_lower = $_REQUEST['new_agerange_l_'.($i+1)];
		$gender = $_REQUEST['new_gender_'.($i+1)];
			foreach($ranges_lower as $lower)
			
			{
			$upper=$ranges_upper[$index];
			if($upper!=$lower)
			{
			$lower_age = $age_lower[$index];
			$upper_age = $age_upper[$index];
			$gender_option=$gender[$index];
			$reference_ranges_list[$count_ref][] = array($lower, $upper , $lower_age , $upper_age, $gender_option);
			}
			$index++;
			
			}
			// if($ranges_lower[1]!=$ranges_upper[1])
			// {
			// $reference_ranges_list[$count_ref][] = array($ranges_lower[0], $ranges_upper[0],0,0,'M');
			// $reference_ranges_list[$count_ref][] = array($ranges_lower[1], $ranges_upper[1],0,0,'F');
			
			// # Numeric range
			// # Check is range values entered properly
		
			// }
			// else 
			// $reference_ranges_list[$count_ref][] = array($ranges_lower[0], $ranges_upper[0],0,0,'B');
	
			$range_string = ":";
		}
		else if($measure_types[$i] == Measure::$RANGE_OPTIONS)
		{
			# Alphanumeric values
			$option_values = $_REQUEST['new_alpharange_'.($i+1)];
			# Check if options entered properly
			$options_entered = false;
			foreach($option_values as $option_value)
			{
				if(trim($option_value) != "")
				{
					$options_entered = true;
					$option_value=str_replace('/','#',$option_value);
					$range_string .= trim($option_value);
					$range_string .= "/";
				}
			}
			if($options_entered === false)
			{
				# Error: Option values not entered properly.
				# TODO:
			}
			# Truncate trailing "/"
			$range_string = substr($range_string, 0, -1);
		}
		else if($measure_types[$i] == Measure::$RANGE_AUTOCOMPLETE)
		{
			# Autocomplete values
			$option_values = $_REQUEST['new_autocomplete_'.($i+1)];
			# Check if options entered properly
			$options_entered = false;
			foreach($option_values as $option_value)
			{
				if(trim($option_value) != "")
				{
					$options_entered = true;
					$range_string .= trim($option_value);
					$range_string .= "_";
				}
			}
			if($options_entered === false)
			{
				# Error: Autocomplete values not entered properly.
				# TODO:
			}
			# Truncate trailing "_"
			$range_string = substr($range_string, 0, -1);
		}
                else if($measure_types[$i] == Measure::$RANGE_FREETEXT)
		{
			# Free Text indentifier
			$range_string = "\$freetext\$\$";
		}
		$unit = $units[$i];
		# Add measure to DB
		$new_measure_id = add_measure($measure_name, $range_string, $unit);
		$new_measures_list[] = $new_measure_id;
		$measures_to_retain[]  = $new_measure_id;
		$count_ref++;
                
                
                # sub-measures
                $submeasure_tag = "\$sub*".$new_measures_list[$i]."/$";
                $submeasures_count = count($submeasure_names[$i+1]);
                $k = 0;
                while($k < $submeasures_count)
                {

                    if($submeasure_names[$i+1][$k] == "")
                    {
                        $k++;
                        continue;
                    }
                    $ranges_lower = $_REQUEST['range_l_'.($i+1).$us.($k+1)];
                    $ranges_upper = $_REQUEST['range_u_'.($i+1).$us.($k+1)];
                    $sub_reference_ranges_list[$i] = array();
                    $measure_name = $submeasure_tag.$submeasure_names[$i+1][$k];
                    $range_string = "";
                    if($submeasure_types[$i+1][$k] == Measure::$RANGE_NUMERIC)
                    {
                    $index=0;
                    $age_upper = $_REQUEST['agerange_u_'.($i+1).$us.($k+1)];
                    $age_lower = $_REQUEST['agerange_l_'.($i+1).$us.($k+1)];
                    $gender = $_REQUEST['gender_'.($i+1).$us.($k+1)];
                            foreach($ranges_lower as $lower)

                            {
                            $upper=$ranges_upper[$index];
                            if($upper!=$lower)
                            {
                            $lower_age = $age_lower[$index];
                            $upper_age = $age_upper[$index];
                            $gender_option=$gender[$index];
                            $sub_reference_ranges_list[$r][] = array($lower, $upper , $lower_age , $upper_age, $gender_option);
                            $r++;
                            }
                            $index++;


                                    //$reference_ranges_list[$i][] = array($lower_range, $upper_range, $lower_age, $upper_age, $gender_option);
                            }
                            //	$range_string = trim($ranges_lower[$i]).":".trim($ranges_upper[$i]);
                            $range_string = ":";
                    }
                    else if($submeasure_types[$i+1][$k] == Measure::$RANGE_OPTIONS)
                    {
                            # Alphanumeric values
                            $option_values = $_REQUEST['alpharange_'.($i+1).$us.($k+1)];
                            # Check if options entered properly
                            $options_entered = false;
                            foreach($option_values as $option_value)
                            {
                                    if(trim($option_value) != "")
                                    {
                                            $options_entered = true;
                                            $range_string .= trim($option_value);
                                            $range_string .= "/";
                                    }
                            }
                            if($options_entered === false)
                            {
                                    # Error: Option values not entered properly.
                                    # TODO:
                            }
                            # Truncate trailing "/"
                            $range_string = substr($range_string, 0, -1);
                    }
                    else if($submeasure_types[$i+1][$k] == Measure::$RANGE_AUTOCOMPLETE)
                    {
                            # Autocomplete field
                            $option_values = $_REQUEST['autocomplete_'.($i+1).$us.($k+1)];
                            $options_entered = false;
                            foreach($option_values as $option_value)
                            {
                                    if(trim($option_value) != "")
                                    {
                                            $options_entered = true;
                                            $range_string .= trim($option_value);
                                            $range_string .= "_";
                                    }
                            }
                            if($options_entered === false)
                            {
                                    # Error: Autocomplete values not entered properly.
                                    # TODO:
                            }
                            # Truncate trailing "_"
                            $range_string = substr($range_string, 0, -1);
                    }
                    else if($submeasure_types[$i+1][$k] == Measure::$RANGE_FREETEXT)
                    {
                            # Free text measure type
                            $range_string = "\$freetext\$\$";
                    }
                    $unit = $subunits[$i+1][$k];
                    //# Add measure to DB and track the ID (key)

                    $added_submeasures_list[] = add_measure($measure_name, $range_string, $unit);
                    $k++;
                }
                $i++;
	}
	# Add entries for newly listed/measures to 'test_type_measure' map table
        
        $merged_list = array_merge($new_measures_list, $added_submeasures_list);
        sort($merged_list);

# Add entries for newly listed/measures to 'test_type_measure' map table
    for($i = 0; $i < count($merged_list); $i += 1)
    {
            $measure_id = $merged_list[$i];
            add_test_type_measure($test_type_id, $measure_id);
    }
        /*
	for($i = 0; $i < count($new_measures_list); $i += 1)
	{
		$measure_id = $new_measures_list[$i];
		add_test_type_measure($test_type_id, $measure_id);
	}	*/
}

# Fetch compatible specimen types
$specimen_list = array();
$reff = 1;
$catalog_specimen_list = get_specimen_types_catalog($lab_config_id, $reff);
foreach($catalog_specimen_list as $specimen_typeid=>$specimen_name)
{
	if(isset($_REQUEST['s_type_'.$specimen_typeid]))
	{
		$specimen_list[] = $specimen_typeid;
	}
}

update_test_type($updated_entry, $specimen_list ,$lab_config_id);
if ($newCostToPatient != $oldCostToPatient) {
    insert_new_cost_of_test_type($newCostToPatient, $updated_entry->testTypeId);
}

# Add entries for newly listed/measures to 'test_type_measure' map table
if($_REQUEST['ispanel'] == 1)
{
	for($i = 0; $i < count($added_measures_list); $i += 1)
	{
		$measure_id = $added_measures_list[$i];
		add_test_type_measure($test_type_id, $measure_id);
	}
}

# Add ref ranges for retained and new measures
$measure_count = 0;
foreach($reference_ranges_list as $range_list)
{
	$measure_id = $measures_to_retain[$measure_count];
	if($measure_id == "")
	{
		$measure_count++;
		continue;
	}
	if(count($range_list) == 0)
	{
		# Not a numeric field
		$measure_count++;
		continue;
	}
	foreach($range_list as $range_entry)
	{
		$range_lower = $range_entry[0];
		$range_upper = $range_entry[1];
		
		$age_min = $range_entry[2];
		$age_max = $range_entry[3];
		$gender_option = $range_entry[4];
		$ref_range = new ReferenceRange();
		$ref_range->measureId = $measure_id;
		$ref_range->ageMin = $age_min;
		$ref_range->ageMax = $age_max;
		$ref_range->sex = $gender_option;
		$ref_range->rangeLower = $range_lower;
		$ref_range->rangeUpper = $range_upper;
		$ref_range->addToDb($_SESSION['lab_config_id']);
	}
	$measure_count++;
}


$measure_count = 0;
foreach($sub_reference_ranges_list as $range_list)
{
	$measure_id = $added_submeasures_list[$measure_count];
	if(count($range_list) == 0)
	{
		# Not a numeric field
		continue;
	}
	foreach($range_list as $range_entry)
	{
		$range_lower = $range_entry[0];
		$range_upper = $range_entry[1];
		$age_min = $range_entry[2];
		$age_max = $range_entry[3];
		$gender_option = $range_entry[4];
		$ref_range = new ReferenceRange();
		$ref_range->measureId = $measure_id;
		$ref_range->ageMin = $age_min;
		$ref_range->ageMax = $age_max;
		$ref_range->sex = $gender_option;
		$ref_range->rangeLower = $range_lower;
		$ref_range->rangeUpper = $range_upper;
		$ref_range->addToDb($_SESSION['lab_config_id']);
	}
	$measure_count++;
}
$measures_to_delete_unique = array_unique($measures_to_delete);
# Remove measure entries marked for deletion
foreach($measures_to_delete_unique as $measure_id)
{
	# Disabled for version 0.8.4.
	# TODO: Check existing result values before deleting a measure
	delete_test_type_measure($test_type_id, $measure_id);
}

# Update locale XML and generate PHP list again.
if($CATALOG_TRANSLATION === true)
	update_testtype_xml($updated_entry->testTypeId, $updated_entry->name);
?>