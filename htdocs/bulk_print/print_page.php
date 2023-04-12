<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php

include("../reports/redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");
include("includes/page_elems.php");
include("barcode/barcode_lib.php");
require_once("includes/user_lib.php");

LangUtil::setPageId("reports");

include("../users/accesslist.php");
 if(!(isLoggedIn(get_user_by_id($_SESSION['user_id']))))
	header( 'Location: home.php' );

$date_from = "";
$date_to = "";
$hidePatientName = 0;
$view_viz = $viz;
$rem_specs = array();
                $rem_remarks = array();
$rem_recs = get_removed_specimens($_SESSION['lab_config_id']);
                foreach($rem_recs as $rem_rec)
                {
                    $rem_specs[] = $rem_rec['r_id'];
                    $rem_remarks[] = $rem_rec['remarks'];
                }
                
// visualization parameters
$chart_column_width = 360;
$labsection = 0;
if(isset($_REQUEST['labsection'])){
	//echo $_REQUEST['labsection'];
	$labsection = $_REQUEST['labsection'];
}
if(isset($_SESSION['userDatesDict'])) {
	foreach ($_SESSION['userDatesDict'] as $patientId => $dateRange) {
		$from = sprintf('%04d-%02d-%02d', $dateRange['yf'], $dateRange['mf'], $dateRange['df']);
		$to = sprintf('%04d-%02d-%02d', $dateRange['yt'], $dateRange['mt'], $dateRange['dt']);
		$dates[] = strtotime($from);
		$dates[] = strtotime($to);
	}
	$date_from = date('Y-m-d', min($dates));
	$date_to = date('Y-m-d', max($dates));
} else {
	$date_from = date("Y-m-d");
	$date_to = $date_from;
}
$uiinfo = "from=".$date_from."&to=".$date_to."&ip=".$_REQUEST['ip']."&viz=".$_REQUEST['viz'];
putUILog('print_page', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');
// function to draw vis
function draw_visualization($cleaned_result, $cleaned_range){

	global $chart_column_width;
	
	// start drawing the svgs
	$visual_content = "";
	$visual_content .= "<div><svg width=\"360\" height=\"20\">";
	$marker_width = 5;

	// use two or three part visualization format
	if(strpos($cleaned_range, "<")===0){
		// draw two part result range
		$visual_content .= "<rect width=\"180\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.3; \"></rect>";
		$visual_content .= "<rect x=\"180\"  width=\"180\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.15; \"></rect>";
		
		// marker for result
		$marker_location = parse_result_x($cleaned_result, $cleaned_range);
		
		if($marker_location==0){
			$marker_width = $chart_column_width/2;
		}
		
	} else if(strpos($cleaned_range, ">")===0){
		// draw two part result range
		$visual_content .= "<rect width=\"180\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.15; \"></rect>";
		$visual_content .= "<rect x=\"180\"  width=\"180\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.3; \"></rect>";
		
		// marker for result
		$marker_location = parse_result_x($cleaned_result, $cleaned_range);
		
		if($marker_location==$chart_column_width/2){
			$marker_width = $chart_column_width/2;
		}
		
	} else {
		// draw three part result range
		$visual_content .= "<rect width=\"90\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.2; \"></rect>";
		$visual_content .= "<rect x=\"90\" width=\"180\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.3; \"></rect>";
		$visual_content .= "<rect x=\"270\"  width=\"90\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.2; \"></rect>";
		
		// marker for result
		$marker_location = parse_result_x($cleaned_result, $cleaned_range);
	}
	
	$visual_content .= "<rect x=\"".$marker_location."\" width=\"".$marker_width."\" height=\"20\" fill=\"#000000\"></rect>";
	
	
	$visual_content .= "</svg></div>";

	return $visual_content;
}

function out_of_range($cleaned_result, $cleaned_range){
    $cleaned_result_split = explode(": ", $cleaned_result);
    if(count($cleaned_result_split)==1){
        $cleaned_result = $cleaned_result_split[0];
    }
    else if(count($cleaned_result_split)==2){
        $cleaned_result = $cleaned_result_split[1];
    }
    else{
        $cleaned_result = end($cleaned_result_split);
    }

    if(preg_match("/[0-9]+min [0-9]+sec/", $cleaned_result)){
        //result
        $split_min = explode("min ", $cleaned_result);
        $min = $split_min[0];
        //range
        $split_range = explode(" min", $cleaned_range);
        $split_range_2 = explode("-", $split_range);
        $low_range = $split_range_2[0];
        $high_range = $split_range_2[1];
        return  $min<$low_range || $min>$high_range;

    }else if(preg_match("/[-+]?[0-9]*\.?[0-9]+/", $cleaned_result) && (strpos($cleaned_range, "<")===0 || strpos($cleaned_range, ">")===0)){
        // have one-sided range, format < 6-, <6-
        $split_range = explode(" ", $cleaned_range);

        // < 6-
        $numeric_part = "";
        if (strpos($split_range[1], "-")!==false) {
            $numeric_part = $split_range[1];
        } else {
            $split_range_2 = explode("<", $split_range[0]);
            $numeric_part = $split_range_2[1];
        }
        // 6-
        $full_range_split = explode("-", $numeric_part);
        $full_range= $full_range_split[0];

        // check result format, could be a number, <6, or < 6
        $result_offset = 0;
        if(strpos($cleaned_result, "<")===0 || strpos($cleaned_result, ">")===0){
            // format <6 or < 6
            $result_number_split = explode("<", $cleaned_result);
            $result_number = floatval($result_number_split[1]);

            // just place it to 0, when the result is < something, it is in the normal range
            $result_offset = 0;
        }else{
            $result_offset = floatval($cleaned_result);
        }

        return $result_offset> $full_range;

    } else if(preg_match("/[-+]?[0-9]*\.?[0-9]+/", $cleaned_result)) {

        // numeric results with a specified range
        $numeric_part_split = explode(" ", $cleaned_range);
        $numeric_part = $numeric_part_split[0];

        $numeric_part_range_split = explode("-", $numeric_part);
        $low_range = $numeric_part_range_split[0];
        $high_range = $numeric_part_range_split[1];
        $cleaned_result = str_replace('_', '',$cleaned_result);
        $cleaned_result = str_replace(',', '',$cleaned_result);
        $cleaned_result = preg_replace("/[^0-9,.]/", "", $cleaned_result);
        //echo "!".$low_range."!".$high_range."!".$cleaned_result;
        return ((float)$cleaned_result<$low_range || (float)$cleaned_result > $high_range)  && ($high_range!="" && $low_range!="");
    }

}

// get visualization result marker location
function parse_result_x($cleaned_result, $cleaned_range){
	$chart_location = 0;
	global $chart_column_width;
	
	$cleaned_result_split = explode(": ", $cleaned_result);
	
	// remove labels for results
	if (count($cleaned_result_split)==1){
		$cleaned_result = $cleaned_result_split[0];
	 }else {
		$cleaned_result = $cleaned_result_split[1];
	}
	
	if(preg_match("/[0-9]+min [0-9]+sec/", $cleaned_result)){
	
		//result
		$split_min = explode("min ", $cleaned_result);
		$min = $split_min[0];
		$split_sec = explode("sec", $split_min[1]);
		$sec = $split_sec[0];
		$total_seconds = $min*60 + intval($sec);
		
		//range
		$split_range = explode(" min", $cleaned_range);
		$split_range_2 = explode("-", $split_range);
		$low_range = $split_range_2[0];
		$high_range = $split_range_2[1];
		$full_range = ($high_range - $low_range)*60;
		$seconds_offset = $total_seconds - $low_range*60;

		$chart_location = ($chart_column_width/4) + ($chart_column_width/2)*($seconds_offset/$full_range);
		
	} else if (preg_match("/[-+]?[0-9]*\.?[0-9]+/", $cleaned_result) && (strpos($cleaned_range, "<")===0 || strpos($cleaned_range, ">")===0)){
		// have one-sided range, format < 6-, <6-
		$split_range = explode(" ", $cleaned_range);
		
		// < 6-
		$numeric_part = "";
		if (strpos($split_range[1], "-")!==false){
			$numeric_part = $split_range[1];
		} else {
			$split_range_2 = explode("<", $split_range[0]);
			$numeric_part = $split_range_2[1];
		}
		
		// 6-
		$full_range_split = explode("-", $numeric_part);
		$full_range = $full_range_split[0];
		
		// check result format, could be a number, <6, or < 6
		$result_offset = 0;
		if(strpos($cleaned_result, "<")===0 || strpos($cleaned_result, ">")===0){
			// format <6 or < 6
			$result_number_split = explode("<", $cleaned_result);
			$result_number = floatval($result_number_split[1]);
			
			// just place it to 0, when the result is < something, it is in the normal range
			$result_offset = 0;
		} else {
			$result_offset = floatval($cleaned_result);
		}
		
        if ($full_range == 0) {
		    $full_range = 0.00001;
        }
		$chart_location = ($chart_column_width/2)*($result_offset/$full_range);
		
	} else if (preg_match("/[-+]?[0-9]*\.?[0-9]+/", $cleaned_result)) {

		// numeric results with a specified range
		$numeric_part_split = explode(" ", $cleaned_range);
		$numeric_part = $numeric_part_split[0];

		$numeric_part_range_split = explode("-", $numeric_part);
		$low_range = $numeric_part_range_split[0];
		$high_range = $numeric_part_range_split[1];
		$full_range = ($high_range - $low_range);
		$result_offset = floatval($cleaned_result) - $low_range;
        if ($full_range == 0) {
            $full_range = 0.00001;
        }

		$chart_location =($chart_column_width/4) + ($chart_column_width/2)*($result_offset/$full_range);
	}
	
	// to deal with double not being accurate
	$chart_location_2 = round($chart_location);
	if ($chart_location<0) {
		$chart_location = 0;
	} else if ($chart_location_2 >= $chart_column_width) {
		$chart_location = $chart_column_width-5;
	}
	
	return $chart_location;
}

// clean results
function clean_result_display($test, $report_config, $show_units){

    if (trim($test->result) == "") {
        $result = "";
	} else if ($report_config->useMeasures == 1) {
        $result = $test->decodeResultWithoutMeasures();
	} else {
        $result = $test->decodeResult(false,$show_units);
	}

    // cleaning up results
    $result = str_replace("&nbsp;", " ", $result);
    $result = str_replace("<br><br>", ", ", $result);
    $result = str_replace("<br>", ", ", $result);

    $result = str_replace(" ,", ",", $result);
    // if $result starts with ", ", remove it
    if(substr($result, 0, 2) === ", "){
        $result = substr($result, 2);
    }
    // if $result ends with ", ", remove it
    if(substr($result, -2) === ", "){
        $result = substr($result, 0, -2);
    }
        // populated each measure into an array
    $result_array = explode(", ", $result);
    return $result_array;
}
function clean_result($test, $report_config,$show_units){

	if(trim($test->result) == "")
		$result = "";
	else if($report_config->useMeasures == 1)
		$result = $test->decodeResultWithoutMeasures();
	else
		$result = $test->decodeResult(false,$show_units);
	
	// cleaning up results
	$result = str_replace("&nbsp;", " ", $result);
	$result = str_replace("<br><br>", ", ", $result);
	$result = str_replace("<br>", ", ", $result);
	$result = str_replace("<b>", "", $result);
	$result = str_replace("</b>", "", $result);
	$result = str_replace(" ,", ",", $result);
	
	// if $result starts with ", ", remove it
	if(substr($result, 0, 2) === ", "){
		$result = substr($result, 2);
	}
	
	// if $result ends with ", ", remove it
	if(substr($result, -2) === ", "){
		$result = substr($result, 0, -2);
	}	
	
	// populated each measure into an array
	$result_array = explode(", ", $result);
	return $result_array;
}

// clean range
function clean_range($test, $report_config, $patient){
	$test_type = TestType::getById($test->testTypeId);
	$measure_list = $test_type->getMeasures();
	
	$range_output = '';
	
	$loop_count = 0;
	foreach($measure_list as $measure) {
		$type=$measure->getRangeType();
		if($type==Measure::$RANGE_NUMERIC) {
			$range_list_array=$measure->getRangeString($patient);
			$lower=$range_list_array[0];
			$upper=$range_list_array[1];
			$unit=$measure->unit;
			if(stripos($unit,",")!=false) {
				$units=explode(",",$unit);
				$lower_parts=explode(".",$lower);
				$upper_parts=explode(".",$upper);
				

				if($lower_parts[0]!=0) {
					$range_output .= $lower_parts[0];
					$range_output .= $units[0];
				}
				
				if($lower_parts[1]!=0) {
					$range_output .= $lower_parts[1];
					$range_output .= $units[1];
				}
				$range_output .= "-";

				if($upper_parts[0]!=0) {
					$range_output .= $upper_parts[0];
					$range_output .= $units[0];
				}
				
				if($upper_parts[1]!=0) {
					$range_output .= $upper_parts[1];
					$range_output .= $units[1];
				}
			} else if(stripos($unit,":")!=false) {
				$units=explode(":",$unit);
				$range_output .= $lower;
				$range_output .= $units[0] . "-";
				$range_output .= $upper;
				$range_output .= $units[0];
				$range_output .= " ".$units[1];
			} else {		
				$range_output .= $lower."-". $upper; 
				$range_output .= " ".$measure->unit;
			}
		} else {
			if($measure->unit=="")
				$range_output .= "";
		}
		if($loop_count < count($measure_list)-1){
			$range_output .= ", ";
		}
		
		$loop_count++;
	}
	
	// put ranges into an array
	$range_output_array = explode(", ", $range_output);
	return $range_output_array;
}

// check if the result can be visualized
function is_result_parsable($cleaned_result){
	if(preg_match("/[0-9]+/", $cleaned_result)){
		return true;
	}
	return false;
}

# Helper function to fetch test history records
function get_records_to_print($patient_id) {
	global $date_from, $date_to;
	$retval = array();
	if(!isset($_REQUEST['ip']) or $_REQUEST['ip'] == 0) {
		# Do not include pending tests
		$labsection = 0;
		if(isset($_REQUEST['labsection'])){
			$labsection = $_REQUEST['labsection'];
		}
		
		if($labsection == 0){
			$query_string =
			"SELECT t.* FROM test t, specimen sp ".
			"WHERE t.result <> '' ".
			"AND t.specimen_id=sp.specimen_id ".
			"AND sp.patient_id=$patient_id ";
		} else {
			$query_string ="SELECT distinct t.* FROM test t, specimen sp, test_type tt, test_category tc ".
			"WHERE t.specimen_id=sp.specimen_id ".
			"AND t.result <> '' ".
			"AND sp.patient_id=$patient_id ".
			"AND t.test_type_id = tt.test_type_id ".
			"AND tt.test_type_id in (select test_type_id from test_type where test_category_id = $labsection)";
		}
		if(isset($_SESSION['userDatesDict'])) {
			$query_string .= "AND (sp.date_collected BETWEEN '$date_from' AND '$date_to') ";
		}
		$query_string .= "ORDER BY sp.date_collected DESC";
	} else {
		# Include pending tests
		$labsection = 0;
		if(isset($_REQUEST['labsection'])){
			$labsection = $_REQUEST['labsection'];
		}
		if($labsection == 0){
		$query_string =
			"SELECT t.* FROM test t, specimen sp ".
			"WHERE t.specimen_id=sp.specimen_id ".
			"AND sp.patient_id=$patient_id ";
		} else {
		$query_string ="SELECT distinct t.* FROM test t, specimen sp, test_type tt, test_category tc ".
			"WHERE t.specimen_id=sp.specimen_id ".
			"AND sp.patient_id=$patient_id ".
			"AND t.test_type_id = tt.test_type_id ".
			"AND tt.test_type_id in (select test_type_id from test_type where test_category_id = $labsection)";
		}
				
		if(isset($_SESSION['userDatesDict'])) {
			$query_string .= "AND (sp.date_collected BETWEEN '$date_from' AND '$date_to') ";
		}
			$query_string .= "ORDER BY sp.date_collected DESC";		
	
	}
	
	$resultset = query_associative_all($query_string);
	if(count($resultset) == 0 || $resultset == null)
		return $retval;
	
	foreach($resultset as $record) {
		$test = Test::getObject($record);
		$hide_patient_name = TestType::toHidePatientName($test->testTypeId);
		
		if( $hide_patient_name == 1 )
					$hidePatientName = 1;
		
		$specimen = get_specimen_by_id($test->specimenId);
		$retval[] = array($test, $specimen, $hide_patient_name);		
	}
	
	return $retval;
}

$lab_config_id = $_REQUEST['location'];
$patient_id = $_REQUEST['patient_id'];
DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
$report_id = $REPORT_ID_ARRAY['reports_testhistory.php'];
$report_config = $lab_config->getReportConfig($report_id);
$margin_list = $report_config->margins;
$userrr = get_user_by_id($_SESSION['user_id']);
if (is_country_dir($userrr) || is_super_admin($userrr)) {
    $code_type = 0;
    $bar_width = 0;
    $bar_height = 0;
    $font_size = 0;
    $printPatientBarcode = 0;
} else {
    $barcodeSettings = get_lab_config_settings_barcode();
    $code_type = $barcodeSettings['type']; //"code39";
    $bar_width = $barcodeSettings['width']; //2;
    $bar_height = $barcodeSettings['height']; //40;
    $font_size = $barcodeSettings['textsize']; //11;
    $printPatientBarcode = patientReportBarcodeCheck();
}
for ($i = 0; $i < count($margin_list); $i++) {
	$margin_list[$i] = ($SCREEN_WIDTH * $margin_list[$i] / 100);
}
?>
<html>
<head>

<style type="text/css" media="print"> 
	.btn {
		color:white; 
		background-color:#9fc748;/*#3B5998;*/ 
		border-style:none; 
		font-weight:bold; 
		font-size:14px; 
		height:25px; 
		/*width:60px;*/
		cursor:pointer;
	}
</style> 

<?php
$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableTableSorter();
$script_elems->enableDragTable();
$script_elems->enableLatencyRecord();
$script_elems->enableEditInPlace();
$page_elems = new PageElems();
?>

<script type="text/javascript" src="../js/nicEdit.js"></script>
<script type="text/javascript" src="../js/jquery-barcode-2.0.2.js"></script>  
<script type='text/javascript'>

var curr_orientation = 0;

function export_as_word(div_id) {
    myNicEditor.removeInstance('patient_table');
	document.getElementById('printhead').innerHTML=" ";
    $(".nicEdit-panel").hide();
    var content = $('#'+div_id+':visible').html();
    $(".nicEdit-panel").show();
	$('#word_data').attr("value", content);
    $('#word_format_form').attr("action","export_word.php")
	$('#word_format_form').submit();
}

function export_as_pdf(div_id) {
    document.getElementById('printhead').innerHTML=" ";
    myNicEditor.removeInstance('patient_table');
    $(".nicEdit-panel").hide();
    var content = $('#'+div_id+':visible').html();
    $(".nicEdit-panel").show();
    $('#word_data').attr("value", content);
    $('#word_format_form').attr("action","export_pdf.php");
    $('#word_format_form').submit();
}


function print_content(div_id) {
	var user_id = <?php echo $_SESSION['user_id']; ?>;
	$.ajax({
		type : 'POST',
		url : 'ajax/fetchUserLog.php',
		data: "&log_type=PRINT",
		success : function (data) {
			if ( data != "false" ) {
					
				var content = "The results for this patient have been printed already by the following users.";
				content+= "\n\n"+data+"\n\n";
				content += "\nDo you wish to print again?";
				var r = confirm(content);
				if (r == false) {
					return;
				} 
				
			}
			$("#myNicPanel").hide();
			javascript:window.print();
			var data_string = "user_id="+user_id+"&log_type=PRINT";
			$.ajax({
				type : 'POST',
				url : 'ajax/addUserLog.php',
				data: data_string
			});	
		}
	});
}

function fetch_report() {
	$yf = $('#yyyy_from').attr("value");
	$mf = $('#mm_from').attr("value");
	$df = $('#dd_from').attr("value");
	$yt = $('#yyyy_to').attr("value");
	$mt = $('#mm_to').attr("value");
	$dt = $('#dd_to').attr("value");
	$ip = 0;
	if($('#ip').is(":checked"))
		$ip = 1;
            
    if($('#viz').is(":checked"))
		$viz = 1;
	$('#fetch_progress').show();
	//instead of loading this via url we need to change the values for the current patient array
	var url_string = "print_page.php?location=<?php echo $lab_config_id; ?>";
	// window.location=url_string;
		$('#fetch_progress').hide();
	}

$(document).ready(function() {
    var code = $('#barcodeCode').val();
    $('#patientBarcode').barcode(code, '<?php echo $code_type; ?>',{barWidth:<?php echo $bar_width; ?>, barHeight:<?php echo $bar_height; ?>, fontSize:<?php echo $font_size; ?>, output:'css'});
	<?php
	if(isset($ip) && $ip == 1) {
		?>
		$('#ip').attr("checked", "true");
		<?php
	}
	?>
        <?php
	if(isset($viz) && $viz == 1) {
		?>
		$('#viz').attr("checked", "true");
		<?php
	}
	?>
	$('#report_content_table1').tablesorter();
	$('.editable').editInPlace({
		callback: function(unused, enteredText) {
			return enteredText; 
		},
		show_buttons: false,
		bg_over: "FFCC66",
		field_type: "textarea"
	});
});

$(document).ready(function(){
  // Reset Font Size
  var originalFontSize = $('#report_content').css('font-size');
   $(".resetFont").click(function(){
  $('#report_content').css('font-size', originalFontSize);
  $('#report_content table').css('font-size', originalFontSize);
  $('#report_content table th').css('font-size', originalFontSize);
  });
  // Increase Font Size
  $(".increaseFont").click(function(){
  	var currentFontSize = $('#report_content').css('font-size');
 	var currentFontSizeNum = parseFloat(currentFontSize, 10);
    var newFontSize = currentFontSizeNum*1.1;
		$('#report_content').css('font-size', newFontSize);
	$('#report_content table').css('font-size', newFontSize);
	$('#report_content table th').css('font-size', newFontSize);
	return false;
  });
  // Decrease Font Size
  $(".decreaseFont").click(function(){
  	var currentFontSize = $('#report_content').css('font-size');
 	var currentFontSizeNum = parseFloat(currentFontSize, 10);
    var newFontSize = currentFontSizeNum*0.9;
	$('#report_content').css('font-size', newFontSize);
	$('#report_content table').css('font-size', newFontSize);
	$('#report_content table th').css('font-size', newFontSize);
	return false;
  });
  
   $(".bold").click(function(){
  	 var selObj = window.getSelection();
		alert(selObj);
		selObj.style.fontWeight='bold';
	return false;
  });
});

</script>
<style type="text/css">
p.main {text-align:justify;}
</style>

</head>
<body>
    <input type="text" id="barcodeCode" name="barcodeCode" value="<?php echo encodePatientBarcode($patient_id,$lab_config_id);  ?>" style="display: none;"></input>

	<div id='options_header' style="font-family: Arial;" >
<form name='word_format_form' id='word_format_form' action='export_pdf.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
	<input type='hidden' name='lab_id' value='<?php echo $lab_config_id; ?>' id='lab_id'>
</form>
<?php
	$today = date("Y-m-d");
	$today_array = explode("-", $today);
	$monthago_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($today)) . " -1 months"));
	$monthago_array = explode("-", $monthago_date);
?>
<table class='no_border'>
	<tr valign='top'>
	<td>
		<?php echo LangUtil::$generalTerms['FROM_DATE']; ?>
	</td>
	<td>
		<?php
		$name_list = array("yyyy_from", "mm_from", "dd_from");
		$id_list = $name_list;
		if(!isset($_REQUEST['yf'])) {
			$value_list = $monthago_array;
		} else {
			$value_list = array($_REQUEST['yf'], $_REQUEST['mf'], $_REQUEST['df']);
		}
		$page_elems->getDatePickerPlain($name_list, $id_list, $value_list); 
		?>
	</td>
	<td>
		<input type='checkbox' name='ip' id='ip' value='1' checked></input> 
		<?php echo LangUtil::$pageTerms['MSG_INCLUDEPENDING']; ?>
			<br>
			<!-- Disabling 'viz' option until the functionality has been added -->
			<!-- <input type='checkbox' name='viz' id='viz'></input>  -->
		<!-- <?php echo "Include Range Visualization"; ?> -->
	</td>
	<td>
	</td>
	<td>
		<input type='button' onClick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
		<input type='button' onClick="javascript:window.close();" value='Close' title='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
		<!-- Disabling 'view' button until the functionality has been added -->
		<!-- <input type='button' onClick="javascript:fetch_report();" value='<?php echo LangUtil::$generalTerms['CMD_VIEW']; ?>'></input> -->
	</td>
	<td>
	<span id='fetch_progress' style='display:none'>
			&nbsp;&nbsp;&nbsp;
			<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
		</span>
	</td>
</tr>
<tr >
	<td>
		&nbsp;&nbsp;
		<?php echo LangUtil::$generalTerms['TO_DATE']; ?>
	</td>
	<td>
		<?php
		$name_list = array("yyyy_to", "mm_to", "dd_to");
		$id_list = $name_list;
		if(!isset($_REQUEST['yf'])) {
			$value_list = $today_array;
		} else {
			$value_list = array($_REQUEST['yt'], $_REQUEST['mt'], $_REQUEST['dt']);
		}
		$page_elems->getDatePickerPlain($name_list, $id_list, $value_list);
		?>
	</td>
	<td>
	<input type='button' onClick="javascript:export_as_word('report_word_content');" value='Export Word Document' title='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
        <input type='button' onClick="javascript:export_as_pdf('report_word_content');" value='Export PDF Document ' title='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
        <br/><small>(Export PDF requires Word 2010 or newer)</small>
	</td>
	<td>
	</td>
	<td>
		Font
		<table class='no border'>
			<tr valign='top'>
				<td>
					<input  type='button' class="increaseFont" value='Increase' title="Increase Font-size"></input>
					<input type='button' class="decreaseFont" value='Decrease' title="Decrease Font-size"></input>
				</td>
			</tr>
		</table>
	</td>
	</tr>
</table>
<hr>
</div>
<?php

$patientDictJson = $_POST['patientDict'];
$patientDict = json_decode($patientDictJson, true);
foreach($patientDict as $patientId => $patient_arr) {
    echo '<div id="report_content_' . $patientId . '">';
    include("report_content.php");
    echo '</div>';
}
?>
</body>
</html>
