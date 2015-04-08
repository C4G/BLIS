<html>
<head>
<?php
#

# Lists patient test history in printable format

#

/*

$load_time = microtime(); 

$load_time = explode(' ',$load_time); 

$load_time = $load_time[1] + $load_time[0]; 

$page_start = $load_time; 

*/
include("redirect.php");
include("includes/db_lib.php");
include("includes/page_elems.php");
include("includes/user_lib.php");
LangUtil::setPageId("reports");
include("../users/accesslist.php");
/* if(!(isLoggedIn(get_user_by_id($_SESSION['user_id']))))
 {
	header( 'Location: home.php' );
	exit;
 }*/	
	
$Aux_id=$_REQUEST['aux_id'];
$lab_config_id = $_REQUEST['location'];
$patient_id = $_REQUEST['patient_id'];

DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
$report_id = $REPORT_ID_ARRAY['reports_testhistory.php'];
$report_config = $lab_config->getReportConfig($report_id);

$rem_specs = array();
                $rem_remarks = array();
$rem_recs = get_removed_specimens($_SESSION['lab_config_id']);
                foreach($rem_recs as $rem_rec)
                {
                    $rem_specs[] = $rem_rec['r_id'];
                    $rem_remarks[] = $rem_rec['remarks'];
                }
?>
<STYLE type="text/css">
.t0{width: 700px;margin-top: 32px;font: 15px 'Times New Roman';}
.tblLine {border:#000 1px solid; width:auto}
.p3{text-align: left;padding-left: 7px; padding-right:7px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.ft4{font: 15px 'Times New Roman';line-height: 16px;}
.fttest{font: 18px 'Times New Roman';line-height: 16px;}
.ftr{font: 15px 'Times New Roman';line-height: 16px; text-align:center}
.ftLow{font: 15px 'Times New Roman';line-height: 16px; text-align:center; color:#0033FF}
.ftNormal{font: 15px 'Times New Roman';line-height: 16px; text-align:center;color:#000000}
.ftHigh{font: 15px 'Times New Roman';line-height: 16px; text-align:center;color:#FF0000}
.tr{height: 25px;}
.trlast{height: 1px;}
.trrs{height: 25px;}
.tdleft{border-left: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdright{border-left: #000000 1px solid;border-top: #000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdmid{border-left: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdleftbuttom{border-left: #000000 1px solid;border-top: #000000 1px solid;border-bottom:#000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdrightbuttom{border-top: #000000 1px solid;border-bottom:#000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdmidbuttom{border-left: #000000 1px solid;border-top: #000000 1px solid;border-bottom:#000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdleftfull{border-left: #000000 1px solid;border-top: #000000 1px solid;border-bottom:#000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}

.tdleftResult{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdstartResult{border-top: #000000 1px solid;border-right: #000000 1px solid;}
.tdRightResult{border-left: #000000 1px solid;border-top: #000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdmidResult{border-right: #000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdmidEndResult{border-left: #000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdleftButtomResult{border-left: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdRightButtomResult{border-left: #000000 1px solid;border-top: #000000 1px solid;border-right:#000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdmidButtomResult{border-left: #000000 1px solid;padding: 0px;margin: 0px;vertical-align: top;}
.tdEndResult{border-top: #000000 1px solid;}
</style>

</head>

<body>
<div id='logo' >

<?php

# If hospital logo exists, include it

$logo_path = "../logos/logo_".$lab_config_id.".jpg";

$logo_path2 = "../ajax/logo_".$lab_config_id.".jpg";

$logo_path1="../../logo_".$lab_config_id.".jpg";


if(file_exists($logo_path1) === true)

{	copy($logo_path1,$logo_path);

	?>

	<img src="<?php echo "../logos/logo_".$lab_config_id.".jpg"; ?>" alt="Big Boat" height="50px" width="700px" />

	<?php

}

else if(file_exists($logo_path) === true)

{

?>

	<img src="<?php echo "../logos/logo_".$lab_config_id.".jpg"; ?>" alt="Big Boat" height="50px" width="700px"/>

	<?php

}

?>

</div>

<?php $align=$report_config->alignment_header;?>
<h3 align="<?php echo $align; ?>"><?php echo $report_config->headerText; ?></h3>

<h4 align="<?php echo $align; ?>"><?php echo  $report_config->titleText; ?></h4>
<?php
$patient = get_patient_by_id($patient_id);
$test_verified_date = "";
$ordered_tests = "";
$lab_receipt_date="";

if($patient == null)
{

	echo LangUtil::$generalTerms['PATIENT_ID']." $patient_id ".LangUtil::$generalTerms['MSG_NOTFOUND'];
}
else
{
	# Fetch test entries to print in report
	$record_list = get_records_to_print($lab_config, $Aux_id); 
	$test_verified_date = $record_list[0][0]->dateVerified;	
	$ordered_tests = getOrderedTest($record_list);
	$lab_receipt_date = $record_list[0][1]->dateRecvd .' '.$record_list[0][1]->timeCollected;	
	
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

			//check for test_id if its in the array

			//http://www.w3schools.com/php/func_array_in_array.asp

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
	
	$Tablecolumnsize = 0;
	$output="";
	
	$resultoutput = "";		
			$resultoutput.= '<tr>';
			if($report_config->useSpecimenName == 1) 
			{
				$resultoutput.= '<td class="tr tdleftbuttom" align="center"><P class="p3 ftr"><strong>'.LangUtil::$generalTerms['TYPE'].'</strong></p></td>';
				$Tablecolumnsize++;
			}	
			if($report_config->useTestName == 1) 
			{
				$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>'.LangUtil::$generalTerms['TEST'].'</strong></p></td>';	
				$Tablecolumnsize++;			
			}				
			$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>Results</strong></p></td>';
			$Tablecolumnsize++;
			if($report_config->useRange == 1) 
			{
				$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>'.LangUtil::$generalTerms['RANGE'].'</strong></p></td>';
				$Tablecolumnsize++;
			}		
			$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>Units</strong></p></td>';
			$Tablecolumnsize++;
			if($report_config->useEntryDate == 1) {
			$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>'.LangUtil::$generalTerms['E_DATE'].'</strong></p></td>';
			$Tablecolumnsize++;
			}			
			if($report_config->useEnteredBy == 1) {
			$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>'.LangUtil::$generalTerms['ENTERED_BY'].'</strong></p></td>';
			$Tablecolumnsize++;
			}
			if($report_config->useVerifiedBy == 1) {
			$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>'.LangUtil::$generalTerms['VERIFIED_BY'].' / Position </strong></p></td>';
			$Tablecolumnsize++;
			}
			if($report_config->useStatus == 1) {
			$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>'.LangUtil::$generalTerms['SP_STATUS'].'</strong></p></td>';
			$Tablecolumnsize++;
			}
			# Specimen Custom fields headers here
	$custom_field_list = $lab_config->getSpecimenCustomFields();
	foreach($custom_field_list as $custom_field) 
	{
		$field_name = $custom_field->fieldName;
		$field_id = $custom_field->id;
		if(in_array($field_id, $report_config->specimenCustomFields)) 
		{			
			$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>'.$field_name.'</strong></p></td>';
			$Tablecolumnsize++;
		}
	}
	if($report_config->useRemarks == 1) 
			{				
				$resultoutput.= '<td class="tr tdrightbuttom" align="center"><P class="p3 ftr"><strong>'.LangUtil::$generalTerms['RESULT_COMMENTS'].'</strong></p></td>';
				$Tablecolumnsize++;
			}
			$resultoutput.= '</tr>';
			
	
	
	echo '<table width="100%">';
   
			 $combined_fields =$SYSTEM_PATIENT_FIELDS;							
				if( $lab_config ) 
				{
					$custom_field_list = $lab_config->getPatientCustomFields();					
					foreach($custom_field_list as $custom_field)
					{
						 $custom_array = array ("p_custom_$custom_field->id" => $custom_field->fieldName);
						 $combined_fields = array_merge($combined_fields,$custom_array);
					
					}
				}
				
			
			$ordered_fields=Patient::getReportfieldsOrder();			
			$column_size=$report_config->rowItems;			
			if(is_array($ordered_fields))
			{
				$ordered=explode(",",$ordered_fields['o_fields']);
				$pfields=explode(",",$report_config->patientFields);
				$values = getVisibleItems($ordered,$pfields,$combined_fields);
				$c=1;
				$endlineclass="";
				$endmark = (count($values)- $column_size)-1;
				$colspan=0;			
				for($i=0;$i<count($values);$i++)
				{
					
					if($c == 1) 
					{		
						$endlineclass = $i > $endmark ? "tdleftbuttom":"tdleft";		
						$output.= "<tr>";
						if(($i+1) == count($values))
						{
							$colspan = $column_size;
							$endlineclass = "tdleftfull";
						}
						
						$output.= '<td colspan="'.$colspan.'" class="tr '.$endlineclass.'"><P class="p3 ft4">'.$values[$i].'</P></td>';
					}
					elseif($c >=  $column_size &&  $column_size != 0)
					{
							$endlineclass = $i > $endmark ? "tdrightbuttom":"tdright";
							//$endlineclass ="tdright";
							$output.= '<td class="tr '.$endlineclass.'"><P class="p3 ft4">'.$values[$i].'</P></td>';
							$output.= "</tr>";
							$c=0;
					}
					else
					{
						$endlineclass = $i > $endmark ? "tdmidbuttom":"tdmid";
						//$endlineclass ="tdmid";
						$end_tag ="";
						if(($i+1) == count($values))
						{
							$colspan = ($column_size-$c)+1;
							$endlineclass = "tdleftfull";
							$end_tag ='</tr>';
						}
						
						$output.= '<td colspan="'.$colspan.'" class="tr '.$endlineclass.'"><P class="p3 ft4">'.$values[$i].'</P></td>';
						$output.= $end_tag;
					}
					$c++;
				}
				
            }
			else
			{
				echo LangUtil::$generalTerms['TIPS_PATIENT_DEMO_ORDER']; 
			}
			for($j=0;$j<=1;$j++)
			{
				$output.= '<tr>';
				for($i=0;$i<$Tablecolumnsize;$i++)
				{
					$output.= ' <td>&nbsp;</td>';
				}
				$output.= '</tr>';
			}	
			
				
		
		print($output);
		echo '</table><table width="100%"><thead>';
		print($resultoutput);
		echo '</thead>';
		print (getResultTable());	
		//file_put_contents('rtn', $output.'</table><table><thead>'.$resultoutput.'</thead>'.getResultTable());				
}
?>

</body>
</html>
<?php
# Helper function to fetch test history records
//var_dump(get_records_to_print($lab_config_id,$Aux_id));
function get_records_to_print($lab_config, $aux_id) 
{

	global $LIS_DOCTOR;

	$retval = array();

	
			$query_string =	"SELECT t.* FROM test t, specimen sp ".
			"WHERE t.result <> '' ".
			"AND t.specimen_id=sp.specimen_id ".
			"AND sp.aux_id=$aux_id ";
		#allow only verified results
		//$query_string .= " and t.verified_by > 0";
		#Taking care of removal tests cases
		$query_string .=" AND t.test_id not in (select distinct r_id from removal_record where `status` = 1) ";				
		$query_string .= "ORDER BY t.date_verified DESC";	
	

	$resultset = query_associative_all($query_string, $row_count);


	if(count($resultset) == 0 || $resultset == null)

		return $retval;

	

	foreach($resultset as $record) {

		$test = Test::getObject($record);
		if($test->verifiedBy == 0)
		{
				continue;
		}
		
		/*if($_SESSION['user_level'] == $LIS_DOCTOR) 
		{
			if($test->verifiedBy == 0)
			{
				continue;
			}
		}*/

		$hide_patient_name = TestType::toHidePatientName($test->testTypeId);

		

		if( $hide_patient_name == 1 )

					$hidePatientName = 1;

		

		$specimen = get_specimen_by_id($test->specimenId);

		$retval[] = array($test, $specimen, $hide_patient_name);		

	}

	return $retval;

}


function getFieldValue($field_id,$previous_daily_num="")
{
		global $patient;
		$retval="";
		
		switch ($field_id)
		{
			case 0:	
				$retval=$patient->getSurrogateId();		
			break;
			case 1:
				$retval=$previous_daily_num;
			break;
			case 2:
				$retval=$patient->getAddlId();
			break;
			case 3:
				$retval=$patient->sex;
			break;
			case 4:
				$retval=$patient->getAge();
			break;
			case 5:
				$retval=$patient->getDob();
			break;
			case 6:
				$retval=$patient->name;
			break;
			case 7:
			break;
			case 8:
				$retval=$patient->regDate;
			break;
			case 9:
				$retval='<div id="patientBarcode"></div>';
			break;
			case 10:
			break;
			
			default:
			$retval="-";
			
		}
		
		return $retval;
}


function getFlag($result,$minrange,$maxrang)
{
	//echo '['.$result.']  ('.$minrange.' - '.$maxrang.')<br/>';
	if(empty($minrange) || empty($maxrang))
	{
		return '<font color="#000000">'.$result.'<font>';	
	
	}
	
	
	$result = (float) $result;
	$minrange = (float) $minrange;
	$maxrang = (float) $maxrang;
		
	if($result < $minrange)
	{
		return '<font color="#0000FF"><strong>L '.$result.'</strong><font>';
	}
	else if( $result > $maxrang)
	{
		return '<font color="#FF0000"><strong>H '.$result.'</strong><font>';	

	}
	else
	{
		return '<font color="#000000">'.$result.'<font>';	
	}
}

function resetColor()
{
	echo '<font color="#000000"><font>';
}

function getVisibleItems($ordered,$pfields,$combined_fields)
{
	global $test_verified_date, $ordered_tests,$Aux_id,$lab_receipt_date,$report_config,$physician_same,$previous_physician;
	$values = array();
	foreach( $ordered as $field)
	{
		$value = getValue($field,$pfields,$combined_fields);
		if(NULL != $value)
			$values[] = $value ;						
	}
	
	$values[] =  '<strong>Specimen ID: </strong>'.$Aux_id;
	$values[] =  '<strong>Release Date: </strong>'.$test_verified_date;
	$values[] =  '<strong>Lab Receipt Date: </strong>'.$lab_receipt_date;
	if($report_config->useDoctor == 1 && $physician_same === true) 
	{
		$values[] =  '<strong>'.LangUtil::$generalTerms['DOCTOR'].': </strong>'.$previous_physician;
	}
	$values[] =  '<strong>Ordered Test: </strong>'.$ordered_tests;
	
	return $values;
}

function getValue($field,$pfields,$combined_fields)
{	
	global $report_config,$lab_config,$previous_daily_num;
	global $patient;	
	
	$rtnval = NULL;
	$pid=explode("_",$field);
					if(!stristr($field,"custom"))
					{
						
						if($pfields[$pid[2]]== 1)
						{
							$rtnval = '<strong>'.LangUtil::$generalTerms[$combined_fields[$field]].': </strong>';                        
                      		$rtnval.= getFieldValue($pid[2],$previous_daily_num);                        
			
						}						
					}
					else
					{
						if(in_array($pid[2], $report_config->patientCustomFields))
						{
						
                           $rtnval = '<strong>'.$combined_fields[$field].': </strong>';                   
                          
								$custom_data = get_custom_data_patient_bytype($patient->patientId, $pid[2]);
								if($custom_data == null) 
								{
									$rtnval.= "-";
								}
								else 
								{
									$field_value = $custom_data->getFieldValueString($lab_config->id, 2);
									if(trim($field_value) == "")
									$field_value = "-";
									$rtnval.= $field_value;
								}							
						}						
					}
					
					return $rtnval;
}

function getOrderedTest($record_list)
{
	$tests ="";
	foreach($record_list as $record)
	{
		$test = $record[0];
		$test_type = TestType::getById($test->testTypeId);
		
		if(empty($tests))
		{
			$tests =$test_type->name;
		}
		else
		{
			$tests.= ', '.$test_type->name;
		}
	}
	
	return $tests;
}

function getResultTable()
{
	global $record_list,$rem_specs,$Tablecolumnsize,$report_config,$patient,$lab_config;
	$rtn='<tbody>';
	foreach($record_list as $value) 
	{
		
		$test = $value[0];
		if(in_array($test->specimenId, $rem_specs))
		{
		   continue;
		}
		$specimen = $value[1];
		$id=$test->testTypeId;
		$clinical_data=get_clinical_data_by_id($test->testTypeId);
		$rtn.= '<tr>';
		if($report_config->useSpecimenName == 1)
		{
			$rtn.= '<td class="trrs tdstartResult tdleftResult"><P class="p3 ft4"><strong>'.get_specimen_name_by_id($specimen->specimenTypeId)."</strong></p></td>";
		}
		if($report_config->useTestName == 1)
		{
			$rtn.= '<td class="trrs tdstartResult" ><p class="p3 fttest"><strong>&diams;'.get_test_name_by_id($test->testTypeId)."</strong></p></td>";
		}		
		//$Tablecolumnsize-2
		for($i=0;$i<3;$i++)
		{
			$rtn.= "<td class='trrs tdstartResult'>&nbsp;</td>";
		}
		
		
		//Tie all other values to tests not measures
		
		if($report_config->useEnteredBy  == 1) 
				{
					$rtn.= '<td class="trrs tdstartResult" align="center"><P class="p3 ftr"><strong>';
					$rtn.= $test->getEnteredBy();
					$rtn.= "</strong></p></td>";
				}
				if($report_config->useVerifiedBy  == 1) 
				{
					$rtn.= '<td class="trrs tdstartResult" align="center"><P class="p3 ftr"><strong>';
					$rtn.= $test->getVerifiedBy();
					$rtn.= "</strong></p></td>";
				}
				if($report_config->useStatus  == 1) 
				{
					$rtn.= '<td class="trrs tdstartResult" align="center"><P class="p3 ftr"><strong>';
					$rtn.= $test->getStatus();
					$rtn.= "</strong></p></td>";
				}
				
				# Specimen Custom fields here
				$custom_field_list = $lab_config->getSpecimenCustomFields();
				foreach($custom_field_list as $custom_field)
				{
					if(in_array($custom_field->id, $report_config->specimenCustomFields))
					{
						$rtn.= '<td class="trrs tdstartResult" align="center"><P class="p3 ftr"><strong>';
						$custom_data = get_custom_data_specimen_bytype($specimen->specimenId, $custom_field->id);
						if($custom_data == null)
							{
								$rtn.= "-";
							}
						else
							{
								$field_value = $custom_data->getFieldValueString($lab_config->id, 1);
								if($field_value == "" or $field_value == null) 
									$field_value = "-";
								$rtn.= $field_value; 
							}
						$rtn.= "</strong></p></td>";
					}
				}
				
				if($report_config->useRemarks == 1)
				{
					$rtn.= '<td class="trrs tdstartResult" align="center"><P class="p3 ftr"><strong>';
					$rtn.= $test->getComments();
					$rtn.= "</strong></p></td>";
				}
				
		$rtn.= '</tr>';
		
		$measurelist= $test->getMeasureListArray();
		$result_array=$test->getAllResultAsArray();
		$range_list = $test->getRange_UnitsList($patient);	
		//print_r($measurelist); echo'<br/><br/><br/><br/>';
		//print_r($result_array); echo'<br/><br/><br/><br/>';
		//print_r($range_list); echo'<br/><br/><br/><br/><br/>';	
			
		for($i=0;$i<count($measurelist);$i++)
		{
			//Make sure we dont include empty results in report						
			$result_array[$i] =  str_ireplace('_undefined','',$result_array[$i]);
			if(empty($result_array[$i]))
				continue;
			$tmp = explode(':',$range_list[$i]);
			$rtn.= "<tr><td class='trrs tdleftResult'>&nbsp;</td>";
			$rtn.= '<td class="trrs tdmidResult" align="center"><P class="p3 ft4">'.$measurelist[$i]."</p></td>";			
			if(strstr($result_array[$i],"_") != FALSE)
			{
				$rtn.= '<td class="trrs tdmidResult" align="center"><P class="p3 ftr">'.str_replace("_", "<br/>", $result_array[$i])."</p></td>";
			}
			else
			{
				$parts = explode(',',$tmp[0]);				
				$rtn.= '<td class="trrs tdmidResult" align="center">'.getFlag($result_array[$i],$parts[0],$parts[1]).'</td>';
			}			
			$rtn.= '<td class="trrs tdmidResult" align="center"><P class="p3 ftr">';
			if($test->isPending() === true)
				$rtn.= "N/A";
			else
				{					
					$rtn.= str_replace(',',' - ',$tmp[0]);
				}
				$rtn.= "</p></td>";				
				$rtn.= '<td class="trrs tdmidResult" align="center"><P class="p3 ftr">'.$tmp[1]."</p></td>";
				if($report_config->useEntryDate == 1) 
				{
					$rtn.= '<td class="trrs tdmidResult" align="center"><P class="p3 ftr">';
					if(trim($test->result) == "")

						$rtn.= "-";

						

					else {

						$ts_parts = explode(" ", $test->timestamp);

						$rtn.= DateLib::mysqlToString($ts_parts[0]);

					}
					$rtn.= "</p></td>";
				}
				//$Tablecolumnsize-2				
				for($tbpart=5;$tbpart<$Tablecolumnsize;$tbpart++)
				{
					$rtn.= "<td class='trrs tdmidResult'>&nbsp;</td>";
				}
				
				
				
				
			
			$rtn.= '</tr>';		
			
		}
		
		
	}
	
	$rtn.= '<tr>';
	for($i=0;$i<($Tablecolumnsize);$i++)
		{
			$rtn.= "<td class='trlast tdEndResult'>&nbsp;</td>";
		}
		$rtn.= '</tr> </tbody></table>';
				
		$footerText=explode(";" ,$report_config->footerText);

		$designation=explode(";" ,$report_config->designation);
		
		$rtn.= '<table cellpadding=0 cellspacing=0>';		
		$rtn.= '<tr>';
		
		for($j=0;$j<count($footerText);$j++)
		 {		
			$rtn.= '<td align="center">'.$footerText[$j].'</td>';		
		 }		
		$rtn.= '</tr><tr>';		
			
		 for($j=0;$j<count($designation);$j++) 
		 {

			 $rtn.= '<td align="center">'.$designation[$j].'</td>';			
		
		 }
		 $rtn.= '</tr></table>';		
		return $rtn;
}