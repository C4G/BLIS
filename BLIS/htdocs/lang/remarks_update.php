 <?php
#
# Updates results interpretation (remarks) to XML file
# Called via Ajax from remarks_edit.php
#

include("../includes/db_lib.php");
include("../lang/lang_xml2php.php");

$lab_config_id = $_REQUEST['lid'];
$test_type_id = $_REQUEST['ttype'];
$lab_config = LabConfig::getById($lab_config_id);
$saved_id = $_SESSION['lab_config_id'];
$test_type = TestType::getById($test_type_id);
$measure_list = $test_type->getMeasures();
$updated_remarks = array();
# The above array would contain-
# updated_remarks[measure_id] = {[range]=>[interpretation]}
foreach($measure_list as $measure)
{	
	$range_type = $measure->getRangeType();
	$range_values = $measure->getRangeValues();
	$remarks_map = array();
	$inter="";//$measure->getDescription();
	if($range_type == Measure::$RANGE_OPTIONS)
	{
		$remarks_list = $_REQUEST['remarks_'.$measure->measureId];
		$count = 0;
		//$description=$measure->getDescription();
		
		foreach($range_values as $range_value)
		{
			$inter=$inter."//".$remarks_list[$count];
			//$remarks_map[$range_value] = $remarks_list[$count];
			$count++;
			//make that statement for the desciption column with // as the appender.
			//add the string as the description column.
		}
		$measure->setInterpretation($inter);
	}
	else if($range_type==Measure::$RANGE_AUTOCOMPLETE)
	{
		
		$remarks_list = $_REQUEST['remarks_'.$measure->measureId];
		$count = 0;
		//$description=$measure->getDescription();
		
		foreach($range_values as $range_value)
		{
			$inter=$inter."//".$remarks_list[$count];
			//$remarks_map[$range_value] = $remarks_list[$count];
			$count++;
			//make that statement for the desciption column with // as the appender.
			//add the string as the description column.
		}
		$measure->setInterpretation($inter);
	}
	else if($range_type == Measure::$RANGE_NUMERIC)
	{
		$remarks_list = $_REQUEST['remarks_'.$measure->measureId];
		$id_list=$_REQUEST['id_'.$measure->measureId];
		$range_l_list=$_REQUEST['range_l_'.$measure->measureId];
		$range_u_list=$_REQUEST['range_u_'.$measure->measureId];
		$age_u_list=$_REQUEST['age_u_'.$measure->measureId];
		$age_l_list=$_REQUEST['age_l_'.$measure->measureId];
		$gender_list=$_REQUEST['gender_'.$measure->measureId];
		$measure->setNumericInterpretation($remarks_list,$id_list, $range_l_list, $range_u_list, $age_u_list, $age_l_list, $gender_list);
		// $count = 0;
		// if(count($id_list)==1)
// {	
	// foreach($range_l_list as $range_value)
		// {
			// //insert query
			// //$inter=$inter."//".$range_l_list[$count]."**".$range_u_list[$count]."**".$remarks_list[$count];
			// $count++;
			
		// }
// }
// else
// {
// foreach($id_list as $id)
// {
// if($id!=-1)
// {
// if($range_u_list[$count]!=" " && $range_l_list[$count]!=" ")
// //update
// else
// //del
// }
// //insert
// }

// }	
		
	}
	}
	# Update XML file with these changes
$langdata_path = $LOCAL_PATH."langdata_".$lab_config_id."/";
//update_remarks_xml($langdata_path, $updated_remarks);
# Generate corresponding PHP file
//remarks_xml2php($langdata_path);

# Return
$_SESSION['lab_config_id'] = $saved_id;
?>