<div id='report_content'>
    <link rel='stylesheet' type='text/css' href='css/table_print.css' />
    <style type='text/css'>
        tbody td, thead th { 
			padding: .3em;
		} 
        div.editable {
            margin-top: 2px;
            width:900px;
            height:20px;
        }
        div.editable input {
            width:700px;
        }
        div#printhead {
			position: fixed; top: 0; left: 0; width: 100%; height: 100%;
			padding-bottom: 5em;
			margin-bottom: 100px;
			display:none;
        }
        #lab_logo {
            margin-bottom:20px;
            height: 165px;
        }
        td {
            padding:5px;
        }

        @media all {
        	.page-break { 
                display:none; 
            }
        }
        @media print {
            #options_header { 
				display:none; 
			}
			div#docbody {
				margin-top: 5em;
			}
			#report_content {
				page-break-after: always;
			}
            #report_content:last-of-type {
                page-break-after: none;
            }
        }
        .landscape_content {-moz-transform: rotate(90deg) translate(300px); }
        .portrait_content {-moz-transform: translate(1px); rotate(-90deg) }
    </style>
    <style type='text/css'>
        <?php $page_elems->getReportConfigCss($margin_list,false); ?>
    </style>
    
    <?php 
    $align=$report_config->alignment_header;?>

    <div id='report_config_content' style='display:block;'>
        <div id="docbody" name="docbody" class='report_content'>

            <div id='logo' align="<?php echo $align; ?>">
				<table>
				<tr>
				<td>
				<?php
				include 'print_functions.php';
				# If hospital logo exists, include it
				$logo_path = "../logos/logo_".$lab_config_id.".jpg";
				$logo_path2 = "../ajax/logo_".$lab_config_id.".jpg";
				$logo_path1="../../logo_".$lab_config_id.".jpg";
				$align=$report_config->alignment_header;
				
				if(file_exists($logo_path1) === true) {	
					copy($logo_path1,$logo_path);
					?>
					<img src='<?php echo "logos/logo_".$lab_config_id.".jpg"; ?>' alt="Big Boat"  id="lab_logo"   ></img>
					<?php
				} else if(file_exists($logo_path) === true) {
				?>
					<img align='<?php echo $align; ?>' src='<?php echo "logos/logo_".$lab_config_id.".jpg"; ?>' alt="Big Boat"  id="lab_logo"></img>
					<?php
				}
				?>
				</td>
				</tr>
            </table>
            </div>
            <div id="report_word_content" >

            <br/><br/>
            <?php $align=$report_config->alignment_header;?>
            <h3 align="<?php echo $align; ?>"><?php echo $report_config->headerText; ?><?php #echo LangUtil::$pageTerms['MENU_PHISTORY']; ?></h3>
            <h4 align="<?php echo $align; ?>"><?php echo $report_config->titleText; ?></h4>

            <?php
            if(isset($_SESSION['userDatesDict'][$patientId])) {
                echo "<br>";
                $userDates = $_SESSION['userDatesDict'][$patientId];
                $date_from = $userDates['yf']."-".$userDates['mf']."-".$userDates['df'];
                $date_to = $userDates['yt']."-".$userDates['mt']."-".$userDates['dt'];
                if($date_from == $date_to) {

                    echo LangUtil::$generalTerms['DATE'].": ".DateLib::mysqlToString($date_from);
                } else {	
                    echo LangUtil::$generalTerms['FROM_DATE'].": ".DateLib::mysqlToString($date_from);
                    echo " | ";
                    echo LangUtil::$generalTerms['TO_DATE'].": ".DateLib::mysqlToString($date_to);
                }
                echo "<br>";
            }
            ?>

            <br>
            <?php
			$patient = Patient::getPatientObject($patient_arr);
            $patient_id = $patient->surrogateId;

            if($patient == null) {
                echo LangUtil::$generalTerms['PATIENT_ID']." $patient_id ".LangUtil::$generalTerms['MSG_NOTFOUND'];
            } else {
                # Fetch test entries to print in report
                $record_list = get_records_to_print($patientId); 
                # If single date supplied, check if-
                # 1. Physician name is the same for all
                # 2. Patient daily number is the same for all
                # 3. All tests were completed or not
                $physician_same = false;
                $daily_number_same = false;
                $all_tests_completed = false;
                if($date_from == $date_to) {
                    $physician_same = true;
                    $daily_number_same = true;
                    $all_tests_completed = true;
                    $record_count = 0;
                    $previous_physician = "";
                    $previous_daily_num = "";
                    $count_list= count($record_list);

                    
                    foreach($record_list as $record_set) {
                        $value = $record_set;
                        $test = $value[0];
                        $specimen = $value[1];
                                    
                                    if(in_array($test->specimenId, $rem_specs))
                                    {
                                            continue;
                                    }
                        if( $hidePatientName == 0) 
                            $hidePatientName = $value[2];
                            
                        if($record_count != 0) {
                            if(strcasecmp($previous_physician, $specimen->getDoctor()) != 0) {
                                $physician_same = false;
                            }
                            if(strcasecmp($previous_daily_num, $specimen->getDailyNumFull()) != 0) {
                                $daily_number_same = false;
                            }
                            if($test->isPending() === true) {
                                $all_tests_completed = false;
                            }
                            if($physician_same === false && $daily_number_same === false && $all_tests_completed === false)
                                break;
                        }
                        $previous_physician = $specimen->getDoctor();
                        $previous_daily_num = $specimen->getDailyNumFull();
                        $record_count++;
                    }
                }
                ?>
                <div id="printhead" name="printhead">
                    <?php
                        if($report_config->usePatientName == 1) {
                            echo $patient->name; 
                            echo "\n";?><br><?php
                        }
                        if($report_config->useAge == 1) {
                            echo $patient->getAge(); 
                            echo "\n";?><br><?php
                        }
                        if($report_config->useGender == 1) {
                            echo $patient->sex; 
                            echo "\n";?><br><?php
                        }       
                        ?>
                </div>
                
            <table class='print_entry_border <?php if( $report_config->showBorder) echo "tblborder"; else echo "tblnoborder" ?>'>
                <tbody>
                    <?php
                    $combined_fields =$SYSTEM_PATIENT_FIELDS;
                    $lab_config = LabConfig::getById($_SESSION['lab_config_id']);				
                    if( $lab_config ) {
                        $custom_field_list = $lab_config->getPatientCustomFields();
                        foreach($custom_field_list as $custom_field) {
                            $custom_array = array ("p_custom_$custom_field->id" => $custom_field->fieldName);
                            $combined_fields = array_merge($combined_fields,$custom_array);
                        
                        }
                    }
                    $ordered_fields=Patient::getReportfieldsOrder();
                    $column_size=$report_config->rowItems;
                    $ordered=explode(",",$ordered_fields['o_fields']);
                    $pfields=explode(",",$report_config->patientFields);
                    if((!is_array($ordered_fields)) or (is_array($ordered_fields) and (strlen(trim($ordered_fields["o_fields"])) ==0))) {
                        $final_fields=array_keys($combined_fields);
                    } else
                        $final_fields=array_merge($ordered, array_diff(array_keys($combined_fields), $ordered));
                    $c=0;				
                    foreach($final_fields as $field) {
                        if($c == 0) 
                            echo "<tr valign='top'>";					
                        $c++;
                        $pid=explode("_",$field);
                        if(!stristr($field,"custom")) {					
                            if($pfields[$pid[2]]== 1) {
                                ?>
                                <td class="heading "><?php  echo LangUtil::$generalTerms[$combined_fields[$field]]?></td>                        
                                <td>
                                    <?php
                                        $field_value = getFieldValue($pid[2],$previous_daily_num); 
                                        if($field_value==null or trim($field_value)=="")
                                            echo "-";
                                        else
                                            echo $field_value;
                                    ?>
                                </td><td width="15px" style="border:none"></td>                      
                                <?php
                            } else 
                                $c--;
                        } else {
                            if(in_array($pid[2], $report_config->patientCustomFields)) {
                                ?>
                                <td class="heading"><?php echo $combined_fields[$field];?></td>                        
                                <td><?php 
                                $custom_data = get_custom_data_patient_bytype($patient->patientId, $pid[2]);
                                if($custom_data == null) 
                                {
                                    echo "-";
                                }
                                else 
                                {
                                    $field_value = $custom_data->getFieldValueString($lab_config->id, 2);
                                    if(trim($field_value) == "")
                                        $field_value = "-";
                                    echo $field_value;
                                }
                                ?></td><td width="15px" style="border:none"></td>  
                                <?php
                            } else 
                                $c--;
                        }
                        if($c >=  $column_size &&  $column_size != 0) {
                            echo "</tr>";
                            $c=0;
                        }
                    }		
                }
                if($report_config->useDoctor == 1 && $physician_same === true) {
                    ?>
                    <tr valign='top'>
                        <td class="heading"><?php echo LangUtil::$generalTerms['DOCTOR'];?></td>                        
                        <td><?php echo $previous_physician; ?></td>
                    </tr>
                    <?php 
                }
                ?>
                </tbody>
            </table>
            <br>
            <?php 
            if($all_tests_completed === true && count($record_list) != 0) {
                echo LangUtil::$pageTerms['MSG_ALLTESTSCOMPLETED']; 
            } else {
                ?>
                <span style="font-weight:bold"><?php echo LangUtil::$generalTerms['TESTS']; ?></span>
                <br>
                <?php
            }
            ?>
            <?php 
            if(count($record_list) == 0) {
                echo LangUtil::$generalTerms['MSG_NOTFOUND'];
            } else { 
                if(1) { 
                ?>
                <style type='text/css'>
                    tbody td, thead th { padding: .3em;  border: 1px <?php if( $report_config->showResultBorder) echo "black"; else echo "white" ?> solid;} 
                    .rstyle 
                    {
                        border-top-style: <?php if( $report_config->resultborderHorizontal == 1) echo "solid"; else echo "none"?>;
                        border-bottom-style: <?php if( $report_config->resultborderHorizontal == 1) echo "solid"; else echo "none"?>;
                        border-right-style: <?php if( $report_config->resultborderVertical == 1) echo "solid"; else echo "none"?>;		
                        border-left-style: <?php if( $report_config->resultborderVertical == 1) echo "solid"; else echo "none"?>;
                    }
                </style>
                <div id="myNicPanel"  style="width: 525px;" ></div>
                <div id="patient_table" >
                <table class='print_entry_border draggable' id='report_content_table1' >
                <thead>
                <tr valign='top'>
                <?php 
                if($report_config->useSpecimenAddlId != 0) {
                    echo "<th>".LangUtil::$generalTerms['SPECIMEN_ID']."</th>";
                }
                if($report_config->useDailyNum == 1 && $daily_number_same === false) {
                    echo "<th>".LangUtil::$generalTerms['PATIENT_DAILYNUM']."</th>";
                }
                if($report_config->useSpecimenName == 1) {
                    echo "<th>".LangUtil::$generalTerms['TYPE']."</th>";
                }
                if($report_config->useDateRecvd == 1) {
                    echo "<th>".LangUtil::$generalTerms['R_DATE']."</th>";
                }
                # Specimen Custom fields headers here
                $custom_field_list = $lab_config->getSpecimenCustomFields();
                foreach($custom_field_list as $custom_field) {
                $field_name = $custom_field->fieldName;
                $field_id = $custom_field->id;
                if(in_array($field_id, $report_config->specimenCustomFields)) {
                    echo "<th>".$field_name."</th>";
                }
                }
                if($report_config->useTestName == 1) {
                    echo "<th>".LangUtil::$generalTerms['TEST'];
                    echo "</th>";
                }
                if($report_config->useComments == 1) {
                    echo "<th>".LangUtil::$generalTerms['COMMENTS']."</th>";
                }
                if($report_config->useReferredTo == 1) {
                    echo "<th>".LangUtil::$generalTerms['REF_TO']."</th>";
                }
                if($report_config->useRequesterName == 1)
                {
                    echo "<th>"."Referring Institution"."</th>";
                }
                if($report_config->useDoctor == 1 && $physician_same === false) {
                echo "<th>".LangUtil::$generalTerms['DOCTOR']."</th>";
                }
                if($report_config->useMeasures == 1)
                    echo "<th>".LangUtil::$generalTerms['MEASURES']."</th>";
                if($report_config->useResults == 1)
                    echo "<th>".LangUtil::$generalTerms['RESULTS']."</th>";
                if($report_config->useRange == 1)
                    echo "<th>".LangUtil::$generalTerms['RANGE']."</th>";
                if($report_config->useEntryDate == 1) {
                    echo "<th>".LangUtil::$generalTerms['E_DATE']."</th>";
                }
                if($report_config->useRemarks == 1) {
                    echo "<th>".LangUtil::$generalTerms['RESULT_COMMENTS']."</th>";
                }
                if($report_config->useEnteredBy == 1) {
                    echo "<th>".LangUtil::$generalTerms['ENTERED_BY']."</th>";
                }
                if($report_config->useVerifiedBy == 1) {
                    echo "<th>".LangUtil::$generalTerms['VERIFIED_BY']." / Position </th>";
                }
                if($report_config->useStatus == 1 && $all_tests_completed === false) {
                    echo "<th>".LangUtil::$generalTerms['SP_STATUS']."</th>";
                }
                // add visualization title column
                if($view_viz == 1) {
                    echo "<th>Visualized Results</th>";
                }
                ?>
                </tr>
                </thead>
                <tbody>
                <?php
                if(isset($sid)) {
                    # Called after result entry for a single specimen
                    $value = array($sid, $tid);
                    $record_list = array();
                    $record_list[] = $value;
                    $data_list=array();
                }
                foreach($record_list as $record_set) {
                    $value = $record_set;
                    $test = $value[0];
                    if(in_array($test->specimenId, $rem_specs)) {
                    continue;
                    }
                    $testObject = get_test_entry($test->specimenId, $test->testTypeId);
                    $print_unverified = LabConfig::getPrintUnverified($_SESSION['lab_config_id']);
                    if(!($testObject->isVerified() || $print_unverified)) {
                        continue;
                    }
                    $specimen = $value[1];
                    $id=$test->testTypeId;
                    $clinical_data=get_clinical_data_by_id($test->testTypeId)
                    ?>
                    <tr valign='top'>
                    <?php
                    if($report_config->useSpecimenAddlId != 0) {
                        echo "<td class='rstyle'>";
                        $specimen->getAuxId();
                        echo "</td>";
                    }
                    if($clinical_data!='') {
                        $data_list[$id]=$clinical_data;
                    }
                    if($report_config->useDailyNum == 1 && $daily_number_same === false) {
                        echo "<td class='rstyle'>".$specimen->getDailyNum()."</td>";
                    }
                    if($report_config->useSpecimenName == 1) {
                        echo "<td class='rstyle'>".get_specimen_name_by_id($specimen->specimenTypeId)."</td>";
                    }
                    if($report_config->useDateRecvd == 1) {
                        echo "<td class='rstyle'>".DateLib::mysqlToString($specimen->dateRecvd)."</td>";
                    }
                    # Specimen Custom fields here
                    $custom_field_list = $lab_config->getSpecimenCustomFields();
                    foreach($custom_field_list as $custom_field) {
                        if(in_array($custom_field->id, $report_config->specimenCustomFields))
                        {
                            echo "<td class='rstyle'>";
                            $custom_data = get_custom_data_specimen_bytype($specimen->specimenId, $custom_field->id);
                            if($custom_data == null){
                                    echo "-";
                            } else {
                                $field_value = $custom_data->getFieldValueString($lab_config->id, 1);
                                if($field_value == "" or $field_value == null) 
                                    $field_value = "-";
                                echo $field_value; 
                            }
                            echo "</td>";
                        }
                    }

                    if($report_config->useTestName == 1)
                    {
                        echo "<td class='rstyle'>".get_test_name_by_id($test->testTypeId)."</td>";
                    }
                    if($report_config->useComments == 1)
                    {
                        echo "<td class='rstyle'>";
                        echo $specimen->getComments();
                        echo "</td>";
                    }
                    if($report_config->useReferredTo == 1)
                    {
                        echo "<td class='rstyle'>".$specimen->getReferredToName()."</td>";
                    }
                    if($report_config->useRequesterName == 1)
                    {
                        echo "<td class='rstyle'>".$lab_config->name."</td>";
                    }
                    if($report_config->useDoctor == 1 && $physician_same === false)
                    {
                        $doc=$specimen->getDoctor();
                        echo "<td class='rstyle'>".$doc."</td>";
                    }
                    if($report_config->useMeasures == 1) {
                        echo "<td class='rstyle'>";
                        echo $test->getMeasureList();
                        echo "</td>";
                    }
                    if($report_config->useResults == 1) {
                        echo "<td class='rstyle'>";

                        $cleaned_result_array = clean_result($test, $report_config,true);
                        $cleaned_range_array = clean_range($test, $report_config, $patient);

                        $result_array =  clean_result_display($test, $report_config,true);
                        foreach($cleaned_result_array as $index=>$result) {
                            echo "<br/>";
                            if(out_of_range($result, $cleaned_range_array[$index])){
                                echo "<span style='color:red; font-weight:bold'>";
                                echo $result_array[$index];
                                echo "</span>";
                            } else {
                                echo $result_array[$index];
                            }
                            echo "<br/>";
                        }
                        echo "</td>";
                    }
                            
                    if($report_config->useRange == 1) {
                        echo "<td class='rstyle'>";
                        if($test->isPending() === true) {
                            echo "N/A";
                        } else {
                            $test_type = TestType::getById($test->testTypeId);
                            $measure_list = $test_type->getMeasures();
                            
                            $submeasure_list = array();
                            $comb_measure_list = array();
                    
                            foreach($measure_list as $measure) {
                                $submeasure_list = $measure->getSubmeasuresAsObj();
                                $submeasure_count = count($submeasure_list);
                                
                                if($measure->checkIfSubmeasure() == 1) {
                                    continue;
                                }
                                    
                                if($submeasure_count == 0) {
                                    array_push($comb_measure_list, $measure);
                                } else {
                                    array_push($comb_measure_list, $measure);
                                    foreach($submeasure_list as $submeasure)
                                    array_push($comb_measure_list, $submeasure); 
                                }
                            }
                            $measure_list = $comb_measure_list;
                                                            
                            foreach($measure_list as $measure) {
                                echo "<br>";
                                $type=$measure->getRangeType();
                                if($type==Measure::$RANGE_NUMERIC) {
                                    $range_list_array=$measure->getRangeString($patient);
                                    $lower=$range_list_array[0];
                                    $upper=$range_list_array[1];
                                    $unit=$measure->unit;
                                    if(stripos($unit,",")!=false) {	
                                        echo "(";
                                        $units=explode(",",$unit);
                                        $lower_parts=explode(".",$lower);
                                        $upper_parts=explode(".",$upper);
                    
                                        if($lower_parts[0]!=0) {
                                            echo $lower_parts[0];
                                            echo $units[0];
                                        }
                                        
                                        if($lower_parts[1]!=0) {
                                            echo $lower_parts[1];
                                            echo $units[1];
                                        }
                                        echo " - ";
                    
                                        if($upper_parts[0]!=0) {
                                            echo $upper_parts[0];
                                            echo $units[0];
                                        }
                                        
                                        if($upper_parts[1]!=0) {
                                            echo $upper_parts[1];
                                            echo $units[1];
                                        }
                                        echo ")";
                                    } else if(stripos($unit,":")!=false) {
                                        $units=explode(":",$unit);
                                        echo "(";	
                                        echo $lower;
                                        ?><sup><?php echo $units[0]; ?></sup> - 
                                        <?php echo $upper;?> <sup> <?php echo $units[0]; ?> </sup>
                                        <?php
                                        echo " ".$units[1].")";
                                    } else {	
                                        echo "(";		
                                        echo $lower; ?>-<?php echo $upper.")"; 
                                        echo " ".$measure->unit;
                                    }?>
                                    &nbsp;&nbsp;	
                                    <?php
                                } else {
                                    if($measure->unit=="")
                                        $measure->unit="-";
                                    echo "&nbsp;&nbsp;&nbsp;". $measure->unit;
                                }
                                echo "<br>";
                            }
                        }

                    echo "</td>";
                    }
                                
                    if($report_config->useEntryDate == 1) {
                        echo "<td class='rstyle'>";
                        if(trim($test->result) == "") {
                            echo "-";
                        } else {
                            $ts_parts = explode(" ", $test->timestamp);
                            echo DateLib::mysqlToString($ts_parts[0]);
                        }
                        echo "</td>";
                    }
                        
                    if($report_config->useRemarks == 1) {
                        $cleaned_range_array = clean_range($test, $report_config, $patient);

                        echo "<td class='rstyle'>";
                        $test_type = TestType::getById($test->testTypeId);
                        $measure_list = $test_type->getMeasures();
                        $cleaned_result_array = clean_result($test, $report_config,false);
                        echo "<br/>";
                        foreach($measure_list as $i=>$measure) {
                            $interps = $measure->getNumericInterpretation();

                            if (out_of_range($cleaned_result_array[$i], $cleaned_range_array[$i])){
                                echo "<span style='color:red'>&lt;".LangUtil::$pageTerms['OUT_OF_RANGE']."&gt;</span><br/><br/>";
                            } else {
                                echo "<br/>";
                                echo "<br/>";
                            }
                            foreach ($interps as $interp){
                                $temp_result = $cleaned_result_array[$i];
                                $temp_result = str_replace('_', '', $temp_result);
                                $temp_result = str_replace(',', '', $temp_result);
                                $temp_result = preg_replace("/[^0-9,.]/", "", $temp_result);
                                if ((float)$temp_result<=$interp[1]&& (float)$temp_result>=$interp[0]){
                                    if ($patient->getAgeNumber()>=$interp[2]&&$patient->getAgeNumber()<=$interp[3]){
                                        if ($patient->sex==$interp[4]||$interp[4]=="B"){
                                            echo LangUtil::$pageTerms['INTERPRETATION'].": ".$interp[5];
                                        }
                                    }
                                }
                            }
                        }
                        echo "</td>";
                    }

                    if($report_config->useEnteredBy == 1) {
                        echo "<td class='rstyle'>".$test->getEnteredBy()."</td>";
                    }

                    if($report_config->useVerifiedBy == 1) {
                        echo "<td>".$test->getVerifiedBy()." / ".$test->getVerifierPosition()."</td>";
                    }
                    
                    if($report_config->useStatus == 1 && $all_tests_completed === false) {
                        echo "<td class='rstyle'>".$test->getStatus()."</td>";
                    }

                    // Add visualization column
                    if($view_viz == 1) {
                        echo "<td class='rstyle'>";
                        $cleaned_result_array = clean_result($test, $report_config,false);
                        $cleaned_range_array = clean_range($test, $report_config, $patient);

                        for($i=0; $i<count($cleaned_result_array); $i++){
                            echo "<br>";

                            $parsable_result = is_result_parsable($cleaned_result_array[$i]);
                            if($cleaned_result_array[$i]=="") {
                                // pending test
                                echo "Pending";
                                echo "<br>";
                            } else if ($cleaned_range_array[$i]=="" || !$parsable_result){
                                echo "Result cannot be visualized";
                                echo "<br>";
                            } else {
                                // draw visualization
                                $visualized_results = draw_visualization($cleaned_result_array[$i], $cleaned_range_array[$i]);
                                echo $visualized_results;
                            }
                        }
                    echo "</td>";
                    }
                ?>
                </tr>
                <?php
                }
                ?>
                </tbody>
                </table>
            </div>
            <br><br>

            <?php if($report_config->useClinicalData == 1) {		
                if(count($data_list)==1&&count($record_list)==1) {
                    ?>
                    <b>
                        Clinical Data:
                    </b>
                    <?php  
                    foreach($data_list as $key=>$value) {
                        if(stripos($value,"!#!")===0) {
                            $data=substr($value,3);
                            $dat=explode("%%%",$value);
                            $text=substr($dat[0],3);
                            $table=$dat[1];
                        } else if(stripos($value,"%%%")===0) {
                            $text="";
                            $table=substr($value,3);
                        } else {
                            $text=$value;//substr($value,3);
                            $table="";
                        }
                        
                        if($text!="")
                            echo $text;
                            
                        if($table!="") {
                            $contents=explode("###",$table);
                            $name_array=$contents[0];
                            $value_array=$contents[1];
                            $name=explode(",",$name_array);
                            $value=explode(",",$value_array);
                        }
                        ?><table>
                        <?php 
                        for($i=0;$i<count($name);$i++) {
                            if($name[$i]!=" ") {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $name[$i];?>
                                        </td>
                                        <td>
                                        <?php echo $value[$i];?>
                                        </td>
                                        </tr>
                                        <?php 
                                    }
                                }
                                ?>
                                </table>
                                <?php
                            }
                            ?>
                            <br><br>
                            <?php
                        }
                        else if( count($data_list) > 0 ) {
                            $bullet=1;
                            foreach($data_list as $key=>$value) {
                                echo $bullet++ ?>). <b>Test Name:</b>
                                <?php echo get_test_name_by_id ($key); ?>
                                <br><b>
                                Clinical Data:
                                </b>
                                <?php
                                if(stripos($value,"!#!")===0) {
                                    $data=substr($value,3);
                                    $dat=explode("%%%",$value);
                                    $text=substr($dat[0],3);
                                    $table=$dat[1];
                                }
                                else if(stripos($value,"%%%")===0) {
                                    $table=substr($value,3);
                                    $text="";
                                } else {
                                    $text=$value;//substr($value,3);
                                    $table="";
                                }
                                
                            if($text!="")
                                echo $text;
                                
                            if($table!=""&&stripos($value,"%%%")!=0) {
                                $contents=explode("###",$table);
                                $name_array=$contents[0];
                                $value_array=$contents[1];
                                $name=explode(",",$name_array);
                                $value=explode(",",$value_array);
                        
                                ?>
                                <table>
                                <?php for($i=0;$i<count($name);$i++) {
                                        if($name[$i]!="") {
                                            ?>
                                            <tr>
                                            <td>
                                            <?php echo $name[$i];?>
                                            </td>
                                            <td>
                                            <?php echo $value[$i];?>
                                            </td>
                                            </tr>
                                            <?php 
                                        }
                                    }
                                ?>
                                </table> <?php }?>
                                <br><br>
                                <?php
                            }
                        }
                    }
                } else {
                        if(isset($sid)) {
                            # Called after result entry for a single specimen
                            $value = array($sid, $tid);
                            $record_list = array();
                            $record_list[] = $value;
                            $data_list=array();
                        }
                        
                        foreach($record_list as $record_set) {
                            $value = $record_set;
                            $test = $value[0];
                                            if(in_array($test->specimenId, $rem_specs))
                                            {
                                                    continue;
                                            }
                            $specimen = $value[1];
                            $id=$test->testTypeId;
                            $clinical_data=get_clinical_data_by_id($test->testTypeId);
                            ?>	
                            <?php
                            
                            if($report_config->useSpecimenName == 1) {
                                echo "<h3>";
                                echo LangUtil::$generalTerms['TYPE']."&nbsp;&#45;&nbsp;";
                                echo get_specimen_name_by_id($specimen->specimenTypeId)."</h3>";
                            }
                            
                            if($report_config->useTestName == 1) {
                                echo "<h3>";
                                echo LangUtil::$generalTerms['TEST']."&nbsp;&#45;&nbsp;";
                                echo get_test_name_by_id($test->testTypeId)."</h3>";
                            }
                            
                            if($report_config->useSpecimenAddlId != 0) {
                                echo LangUtil::$generalTerms['SPECIMEN_ID']."&nbsp;&#45;&nbsp;";
                                echo $specimen->getAuxId();
                                echo "<br>";
                            }
                            
                            if($clinical_data!='') {
                                $data_list[$id]=$clinical_data;
                            }
                            if($report_config->useDailyNum == 1 && $daily_number_same === false) {
                                echo LangUtil::$generalTerms['PATIENT_DAILYNUM']."&nbsp;&#45;&nbsp;";
                                echo $specimen->getDailyNum()."<br>";
                            }
                            if($report_config->useDateRecvd == 1) {
                                echo LangUtil::$generalTerms['R_DATE']."&nbsp;&#45;&nbsp;";
                                echo DateLib::mysqlToString($specimen->dateRecvd)."<br>";
                            }
                            # Specimen Custom fields headers here
                            $custom_field_list = $lab_config->getSpecimenCustomFields();
                            foreach($custom_field_list as $custom_field) {
                                $field_name = $custom_field->fieldName;
                                $field_id = $custom_field->id;
                                if(in_array($field_id, $report_config->specimenCustomFields)) {
                                    echo $field_name;
                                }
                            }
                            # Specimen Custom fields here
                            $custom_field_list = $lab_config->getSpecimenCustomFields();
                            foreach($custom_field_list as $custom_field) {
                                if(in_array($custom_field->id, $report_config->specimenCustomFields))
                                {
                                    echo "<br>";
                                    $custom_data = get_custom_data_specimen_bytype($specimen->specimenId, $custom_field->id);
                                    if($custom_data == null) {
                                        echo "-";
                                    }
                                    else {
                                        $field_value = $custom_data->getFieldValueString($lab_config->id, 1);
                                        if($field_value == "" or $field_value == null) 
                                        $field_value = "-";
                                        echo $field_value; 
                                    }
                                    echo "<br>";
                                }
                            }
                            
                            if($report_config->useComments == 1) {
                                echo LangUtil::$generalTerms['COMMENTS']."&nbsp;&#45;&nbsp;";
                                echo $specimen->getComments()."<br>";
                            }
                            
                            if($report_config->useReferredTo == 1) {
                                echo LangUtil::$generalTerms['REF_TO']."&nbsp;&#45;&nbsp;";
                                echo $specimen->getReferredToName()."<br>";
                            }
                            
                            if($report_config->useDoctor == 1 && $physician_same === false) {
                                echo LangUtil::$generalTerms['DOCTOR']."&nbsp;&#45;&nbsp;";
                                $doc=$specimen->getDoctor();
                                echo $doc."<br>";
                            }
                            
                            if($report_config->useMeasures == 1)
                                echo LangUtil::$generalTerms['MEASURES']."<br>";
                            
                            if($report_config->useResults == 1) {
                                echo LangUtil::$generalTerms['RESULTS']."<br>";
                                
                                if(trim($test->result) == "") {
                                    echo LangUtil::$generalTerms['PENDING_RESULTS'];
                                } else if($report_config->useMeasures == 1) {
                                    echo $test->decodeResultWithoutMeasures();
                                } else {
                                    echo $test->decodeResult();
                                }
                                echo "<br>";
                            }
                            
                            if($report_config->useEntryDate == 1) {
                                echo LangUtil::$generalTerms['E_DATE']."&nbsp;&#45;&nbsp;";
                                
                                if(trim($test->result) == "")
                                    echo "-";
                                    
                                else {
                                    $ts_parts = explode(" ", $test->timestamp);
                                    echo DateLib::mysqlToString($ts_parts[0]);
                                }
                                echo "<br>";
                            }
                            
                            if($report_config->useRemarks == 1) {
                                echo LangUtil::$generalTerms['RESULT_COMMENTS']."&nbsp;&#45;&nbsp;";
                                echo $test->getComments()."<br>";
                            }
                            
                            if($report_config->useEnteredBy == 1) {
                                echo LangUtil::$generalTerms['ENTERED_BY']."&nbsp;&#45;&nbsp;";
                                echo $test->getEnteredBy()."<br>";
                            }
                            
                            if($report_config->useVerifiedBy == 1) {
                                echo LangUtil::$generalTerms['VERIFIED_BY']."&nbsp;&#45;&nbsp;";
                                echo $test->getVerifiedBy()."<br>";
                            }
                            
                            if($report_config->useStatus == 1 && $all_tests_completed === false) {
                                echo LangUtil::$generalTerms['SP_STATUS']."&nbsp;&#45;&nbsp;";
                                echo $test->getStatus()."<br>";
                            }
                        
                        }
                        ?>
                    
                    <br><br>
                    <?php 
                    if($report_config->useClinicalData == 1) { 		
                        if(count($data_list)==1&&count(record_list)==1) {
                            ?>
                            <b>
                                Clinical Data:
                                </b>
                                <?php  
                                foreach($data_list as $key=>$value) {
                                    if( stripos($value,"!#!")===0 ) {
                                        $data=substr($value,3);
                                        $dat=explode("%%%",$value);
                                        $text=substr($dat[0],3);
                                        $table=$dat[1];
                                    }
                                    else if(stripos($value,"%%%")===0) {
                                        $text="";
                                        $table=substr($value,3);
                                    }
                                    else {
                                        $text=$value;//substr($value,3);
                                        $table="";
                                    }
                        
                                    if($text!="")
                                        echo $text;
                                        
                                    if($table!="") {
                                        $contents=explode("###",$table);
                                        $name_array=$contents[0];
                                        $value_array=$contents[1];
                                        $name=explode(",",$name_array);
                                        $value=explode(",",$value_array);
                                    }
                                    ?><table>
                                    <?php 
                                        for($i=0;$i<count($name);$i++) {
                                            if($name[$i]!=" ") {
                                                ?>
                                                <tr>
                                                <td>
                                                <?php echo $name[$i];?>
                                                </td>
                                                <td>
                                                <?php echo $value[$i];?>
                                                </td>
                                                </tr>
                                                <?php 
                                            }
                                        }
                                    ?>
                                    </table>
                                    <?php
                        
                                }
                            ?>
                            <br><br>
                            <?php
                        } else {
                            $bullet=1;
                            foreach($data_list as $key=>$value) {
                                echo $bullet++ ?>). <b>Test Name:</b>
                                <?php echo get_test_name_by_id ($key); ?>
                                <br><b>
                                Clinical Data:
                                </b>
                                <?php
                                if(stripos($value,"!#!")===0) {
                                    $data=substr($value,3);
                                    $dat=explode("%%%",$value);
                                    $text=substr($dat[0],3);
                                    $table=$dat[1];
                                }
                                else if(stripos($value,"%%%")===0) {
                                    $table=substr($value,3);
                                    $text="";
                                } else {
                                    $text=$value;//substr($value,3);
                                    $table="";
                                }
                            
                                if($text!="")
                                    echo $text;
                        
                                if($table!=""&&stripos($value,"%%%")!=0) {
                                    $contents=explode("###",$table);
                                    $name_array=$contents[0];
                                    $value_array=$contents[1];
                                    $name=explode(",",$name_array);
                                    $value=explode(",",$value_array);
                                    
                                    ?>
                                    <table>
                                    <?php 
                                    for($i=0;$i<count($name);$i++) {
                                        if($name[$i]!="") {
                                            ?>
                                            <tr>
                                            <td>
                                            <?php echo $name[$i];?>
                                            </td>
                                            <td>
                                            <?php echo $value[$i];?>
                                            </td>
                                            </tr>
                                            <?php 
                                        }
                                    }
                                    ?>
                                    </table> <?php }?>
                                    <br><br>
                                    <?php
                                }
                            }
                        }
                    }
                }


            if(count($record_list) != 0) {
                $latest_record = $record_list[0];
                $earliest_record = $record_list[count($record_list)-1];
                $latest_specimen = $latest_record[1];
                $earliest_specimen = $earliest_record[1];
                $latest_collection_parts = explode("-", $latest_specimen->dateCollected);
                $earliest_collection_parts = explode("-", $earliest_specimen->dateCollected);
                if(!isset($yf)) {
                    ?>
                    <script type='text/javascript'>
                    $(document).ready(function(){
                        $('#dd_from').attr("value", "<?php echo $earliest_collection_parts[2]; ?>");
                        $('#mm_from').attr("value", "<?php echo $earliest_collection_parts[1]; ?>");
                        $('#yyyy_from').attr("value", "<?php echo $earliest_collection_parts[0]; ?>");
                        $('#dd_to').attr("value", "<?php echo $latest_collection_parts[2]; ?>");
                        $('#mm_to').attr("value", "<?php echo $latest_collection_parts[1]; ?>");
                        $('#yyyy_to').attr("value", "<?php echo $latest_collection_parts[0]; ?>");
                        var date_from = "<?php echo DateLib::mysqlToString($earliest_specimen->dateCollected); ?>";
                        var date_to = "<?php echo DateLib::mysqlToString($latest_specimen->dateCollected); ?>";
                        var html_string = "";
                        if(date_from == date_to)
                        {
                            html_string = "<br><?php echo LangUtil::$generalTerms['DATE'].": "; ?>"+date_from;		
                        }
                        else
                        {
                            html_string = "<br><?php echo LangUtil::$generalTerms['FROM_DATE'].": "; ?>"+date_from+" | <?php echo LangUtil::$generalTerms['TO_DATE'].": "; ?>"+date_to;
                        }
                        
                        $('#date_section').html(html_string);
                    });

                    function change_to_bold() {
                        $("#myPara").css("font-style","bold");
                    } 
                </script>
                <?php
                }
            }
            ?>
            <?php 

            $footerText=explode(";" ,$report_config->footerText);
            $designation=explode(";" ,$report_config->designation);
            $lab_config_id=$_SESSION['lab_config_id'];

            ?>

            <table width=100% border="0" class="no_border" ">
				<tr>
				<?php for($j=0;$j<count($footerText);$j++) {?>
				<td <?php if($lab_config_id==234) {?>style="font-size:14pt;"<?php }?> ><?php echo $new_footer_part; ?></td>
				<?php }?>
				</tr>
				<tr>
				<?php for($j=0;$j<count($footerText);$j++) {?>
				<td align="center" <?php if($lab_config_id==234) {?>style="font-size:14pt;"<?php }?>><?php echo $footerText[$j]; ?></td>
				<?php }?>
				</tr>
				<tr>
				<?php for($j=0;$j<count($designation);$j++) {?>
				<td align="center"<?php if($lab_config_id==234) {?>style="font-size:14pt;"<?php }?> ><?php echo $designation[$j]; ?></td>
				<?php }
				?>
				</tr>
            </table>
            </div>
        </div>
    </div>
</div>