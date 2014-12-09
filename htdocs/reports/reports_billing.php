<?php

#
# Lists patient test history in printable format
#

include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");

include("includes/page_elems.php");

LangUtil::setPageId("reports");

include("../users/accesslist.php");
if(!(isLoggedIn(get_user_by_id($_SESSION['user_id']))))
    header( 'Location: home.php' );

$date_from = "";
$date_to = "";

$hidePatientName = 0;

$view_viz = $_REQUEST['viz'];
$lab_config_id = $_REQUEST['location'];
// visualization parameters
$chart_column_width = 360;

$defaultCurrency = currencyConfig::getDefaultCurrency($lab_config_id);
$defCurrencyIfnotSet = get_lab_config_settings_billing();
if(is_null($defaultCurrency)){
	$secondaryCurrencies = currencyConfig::getAllSecondaryCurrencies($lab_config_id, $defCurrencyIfnotSet); 
} else {
	$secondaryCurrencies = currencyConfig::getAllSecondaryCurrencies($lab_config_id, $defaultCurrency->getCurrencyTo());
}
// Currency Type
if(isset($_REQUEST['CT'])) {
	$currencyTo = $_REQUEST['CT']; 
} else {
	if(!is_null($defaultCurrency)){
	$currencyTo = $defaultCurrency->getCurrencyTo();
	} else {
	$currencyTo = $defCurrencyIfnotSet;
	}
}
$defaultFlag = 0;
if(!is_null($defaultCurrency)){
$exchange_rate = currencyConfig::getExchangeRateValue($lab_config_id, $defaultCurrency->getCurrencyTo(), $currencyTo);
} else {
$exchange_rate = 1;
$defaultFlag = 1;
}
if(isset($_REQUEST['yf'])) {
	$date_from = $_REQUEST['yf']."-".$_REQUEST['mf']."-".$_REQUEST['df'];
	$date_to = $_REQUEST['yt']."-".$_REQUEST['mt']."-".$_REQUEST['dt'];
} else {
	$date_from = date("Y-m-d");
	$date_to = $date_from;
}

$uiinfo = "from=".$date_from."&to=".$date_to."&ip=".$_REQUEST['ip']."&viz=".$_REQUEST['viz'];

putUILog('reports_testhistory', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

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
	}else if(strpos($cleaned_range, ">")===0){

                // draw two part result range
		$visual_content .= "<rect width=\"180\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.15; \"></rect>";
		$visual_content .= "<rect x=\"180\"  width=\"180\" height=\"20\" fill=\"#000000\" style=\"opacity: 0.3; \"></rect>";

                // marker for result
		$marker_location = parse_result_x($cleaned_result, $cleaned_range);

                if($marker_location==$chart_column_width/2){
			$marker_width = $chart_column_width/2;
		}
	}else{

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

// get visualization result marker location
function parse_result_x($cleaned_result, $cleaned_range){
	$chart_location = 0;
	global $chart_column_width;
	$cleaned_result_split = explode(": ", $cleaned_result);

        // remove labels for results
	if(count($cleaned_result_split)==1){
		$cleaned_result = $cleaned_result_split[0];
	}else{
		$cleaned_result = $cleaned_result_split[1];
	}

        if(preg_match("/[0-9]+min [0-9]+sec/", $cleaned_result)){

                //result
		$split_min = explode("min ", $cleaned_result);
		$min = $split_time[0];
		$split_sec = explode("sec", $split_time[1]);
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
	}else if(preg_match("/[-+]?[0-9]*\.?[0-9]+/", $cleaned_result) && (strpos($cleaned_range, "<")===0 || strpos($cleaned_range, ">")===0)){

                // have one-sided range, format < 6-, <6-
		$split_range = explode(" ", $cleaned_range);

                // < 6-
		$numeric_part = "";

                if(strpos($split_range[1], "-")!==false){
			$numeric_part = $split_range[1];
		}else{
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
		}else{
			$result_offset = floatval($cleaned_result);
		}
		$chart_location = ($chart_column_width/2)*($result_offset/$full_range);
	}else if(preg_match("/[-+]?[0-9]*\.?[0-9]+/", $cleaned_result)){

                // numeric results with a specified range
		$numeric_part_split = explode(" ", $cleaned_range);
		$numeric_part = $numeric_part_split[0];
		$numeric_part_range_split = explode("-", $numeric_part);

                $low_range = $numeric_part_range_split[0];
		$high_range = $numeric_part_range_split[1];
		$full_range = ($high_range - $low_range);

                $result_offset = floatval($cleaned_result) - $low_range;
		$chart_location =($chart_column_width/4) + ($chart_column_width/2)*($result_offset/$full_range);
	}
	// to deal with double not being accurate
	$chart_location_2 = round($chart_location);
	if($chart_location<0){
		$chart_location = 0;
	}else if($chart_location_2 >= $chart_column_width){
		$chart_location = $chart_column_width-5;
	}
	return $chart_location;
}

// clean results
function clean_result($test, $report_config){
	if(trim($test->result) == "")
		$result = "";
	else if($report_config->useMeasures == 1)
		$result = $test->decodeResultWithoutMeasures();
	else
		$result = $test->decodeResult();
	
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


$patient_id = $_REQUEST['patient_id'];

DbUtil::switchToLabConfig($lab_config_id);

$lab_config = get_lab_config_by_id($lab_config_id);
$report_id = $REPORT_ID_ARRAY['reports_testhistory.php'];
$report_config = $lab_config->getReportConfig($report_id);
$margin_list = $report_config->margins;

for($i = 0; $i < count($margin_list); $i++) {
	$margin_list[$i] = ($SCREEN_WIDTH * $margin_list[$i] / 100);
}

?>

<html>
<head>

<style type="text/css">
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
<script type='text/javascript'>

var curr_orientation = 0;
function export_as_word(div_id) {
	document.getElementById('printhead').innerHTML=" ";
	var content = $('#'+div_id).html();
	$('#word_data').attr("value", content);
	$('#word_format_form').submit();
}

function print_content(div_id) {
	/*
	var DocumentContainer = document.getElementById(div_id);
	var WindowObject = window.open("", "PrintWindow", "toolbars=no,scrollbars=yes,status=no,resizable=yes");
	var html_code = DocumentContainer.innerHTML;
	var do_landscape = $("input[name='do_landscape']:checked").attr("value");
	if(do_landscape == "Y")
		html_code += "<style type='text/css'> #report_config_content {-moz-transform: rotate(-90deg) translate(-300px); } </style>";
	WindowObject.document.writeln(html_code);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
	*/
	$("#myNicPanel").hide();
	javascript:window.print();
}

function fetch_report() {
	var yf = $('#yyyy_from').attr("value");
	var mf = $('#mm_from').attr("value");
	var df = $('#dd_from').attr("value");
	var yt = $('#yyyy_to').attr("value");
	var mt = $('#mm_to').attr("value");
	var dt = $('#dd_to').attr("value");
	var ip = 0;
	var currencyType = $("#default_currency").val();
	$('#fetch_progress').show();
	var url_string = "reports_billing.php?location=<?php echo $lab_config_id; ?>&patient_id=<?php echo $patient_id; ?>&yf="+yf+"&mf="+mf+"&df="+df+"&yt="+yt+"&mt="+mt+"&dt="+dt+"&CT="+currencyType;
	window.location=url_string;
}

$(document).ready(function() {
	<?php
	if(isset($_REQUEST['ip']) && $_REQUEST['ip'] == 1) {
	?>
	$('#ip').attr("checked", "true");
        <?php
	}
	?>
        <?php
	if(isset($_REQUEST['viz']) && $_REQUEST['viz'] == 1) {
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
	$("input[name='do_landscape']").click( function() {
		change_orientation();
	});
	var myNicEditor = new nicEditor();
    myNicEditor.setPanel('myNicPanel');
    myNicEditor.addInstance('patient_table');
});

function change_orientation() {
	var do_landscape = $("input[name='do_landscape']:checked").attr("value");
	if(do_landscape == "Y" && curr_orientation == 0) {
		$('#report_config_content').removeClass("portrait_content");
		$('#report_config_content').addClass("landscape_content");
		curr_orientation = 1;
	}
	if(do_landscape == "N" && curr_orientation == 1) {
		$('#report_config_content').removeClass("landscape_content");
		$('#report_config_content').addClass("portrait_content");
		curr_orientation = 0;
	}
}

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
<div id='options_header' style="font-family: Arial;" >

<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
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
			}
			else {
				$value_list = array($_REQUEST['yf'], $_REQUEST['mf'], $_REQUEST['df']);
			}
			$page_elems->getDatePickerPlain($name_list, $id_list, $value_list);
			?>
	</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='button' onclick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
	</td>
	<td>
		<table class='no border'>
	<tr valign='top'>
	<td>
	<input type='radio' name='do_landscape' value='N'<?php
			//if($report_config->landscape == false) echo " checked ";
			echo " checked ";
			?>>Portrait</input>
	</td>
	<td>
		<input type='radio' name='do_landscape' value='Y' <?php
			//if($report_config->landscape == true) echo " checked ";
			?>>Landscape</input>
	</td>
	</tr>
	</table>
	</td>
	<td>&nbsp;&nbsp;
	Currency Type &nbsp;
	<select name='default_currency' id='default_currency'>
    <?php 
    foreach ($secondaryCurrencies as $currency){ 
	if($currency->getCurrencyTo() == $currencyTo){
	?>
	<option value='<?php echo $currency->getCurrencyFrom(); ?>' selected><?php echo $currency->getCurrencyFrom(); ?></option>
	<?php } 
	else {
    ?>
      	<option value='<?php echo $currency->getCurrencyFrom(); ?>'><?php echo $currency->getCurrencyFrom(); ?></option>
    <?php } 
	}?>
	</td>
	<td>
		<input type='button' onclick="javascript:fetch_report();" value='<?php echo LangUtil::$generalTerms['CMD_VIEW']; ?>'></input>
		</td><td><span id='fetch_progress' style='display:none'>
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
			}
			else {
				$value_list = array($_REQUEST['yt'], $_REQUEST['mt'], $_REQUEST['dt']);
			}
			$page_elems->getDatePickerPlain($name_list, $id_list, $value_list);
			?>
	</td>
	<td>
	&nbsp;&nbsp;
	Font
	</td>
	<td>
	<table class='no border'>
	<tr valign='top'><td>
	<input  type='button' class="increaseFont" value='Increase' title="Increase Font-size"></input> <br>
	</td>
	<td>
	<input type='button' class="decreaseFont" value='Decrease' title="Decrease Font-size"></input> <br>
	<!--<input type='button' class="bold" value='Bold' title="Bold"></input> <br>-->
	</td>
	</tr>
	</table>
	</td>
	<td>
	&nbsp;&nbsp;
	<input type='button' onclick="javascript:export_as_word('report_word_content');" value='Export Word Document' title='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
	</td>
	<td>
	&nbsp;&nbsp;
	<input type='button' onclick="javascript:window.close();" value='Close' title='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
	</td>
	</tr>
</table>

<hr>
</div>
<div id='report_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<style type='text/css'>
div.editable {
	/*padding: 2px 2px 2px 2px;*/
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
@media all
{
  .page-break { display:none; }
}
@media print
{
	#options_header { display:none; }
	/* div#printhead {	display: block;
  } */
  div#docbody {
  margin-top: 5em;
  }
}
.landscape_content {-moz-transform: rotate(90deg) translate(300px); }
.portrait_content {-moz-transform: translate(1px); rotate(-90deg) }
</style>
<style type='text/css'>
	<?php $page_elems->getReportConfigCss($margin_list); ?>
</style>
<?php $align=$report_config->alignment_header;?>
<div id='report_config_content' style='display:block;'>
<div id="docbody" name="docbody">
<div id='logo' >
<?php
# If hospital logo exists, include it
$logo_path = "../logos/logo_billing_".$lab_config_id.".jpg";
$logo_path2 = "../ajax/logo_billing_".$lab_config_id.".jpg";
$logo_path1="../../logo_billing_".$lab_config_id.".jpg";
if(file_exists($logo_path1) === true)
{	copy($logo_path1,$logo_path);
	?>
	<img src='<?php echo "logos/logo_billing_".$lab_config_id.".jpg"; ?>' alt="Big Boat" height='140px'    ></src>
	<?php
}
else if(file_exists($logo_path) === true)
{
?>
	<img src='<?php echo "logos/logo_billing_".$lab_config_id.".jpg"; ?>' alt="Big Boat" height='140px' width='140px'></src>
	<?php
}
?>
</div>
<!--//If condition for the font size
<STYLE>H3 {FONT-SIZE: <?php echo $size; ?>}</STYLE>-->
<div id="report_word_content">
<div id="date_section" >
<?php $align=$report_config->alignment_header;?>
<h3 align="<?php echo $align; ?>"><?php echo $report_config->headerText; ?><?php #echo LangUtil::$pageTerms['MENU_PHISTORY']; ?></h3>
<h4 align="<?php echo $align; ?>"><?php echo "Patient Bill"; ?></h4>
</div>
<?php
if(isset($_REQUEST['yf']))
{
	echo "<br>";
	if($date_from == $date_to) {
		echo LangUtil::$generalTerms['DATE'].": ".DateLib::mysqlToString($date_from);
	}
	else {
		echo LangUtil::$generalTerms['FROM_DATE'].": ".DateLib::mysqlToString($date_from);
		echo " | ";
		echo LangUtil::$generalTerms['TO_DATE'].": ".DateLib::mysqlToString($date_to);
	}
}
?>
<br>
<?php
$patient = get_patient_by_id($patient_id);
if($patient == null)
{
	echo LangUtil::$generalTerms['PATIENT_ID']." $patient_id ".LangUtil::$generalTerms['MSG_NOTFOUND'];
}
else
{
	# Fetch billing entries to print in report
	$labsection = 0;
	if(isset($_REQUEST['labsection'])){
		$labsection = $_REQUEST['labsection'];
	}

	$billing_info = generate_bill_data_for_patient_and_date_range($patient_id, $date_from, $date_to, $labsection);
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
	<table class='print_entry_border'>
		<tbody>
			<?php
			if($report_config->usePatientId == 1) {
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></td>
					<td><?php echo $patient->getSurrogateId(); ?></td>
				</tr>
				<?php
			}
			if($report_config->useDailyNum == 1 && $daily_number_same === true) {
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></td>
					<td><?php echo $previous_daily_num; ?></td>
				</tr>
				<?php
			}
			if($report_config->usePatientRegistrationDate == 1) {
				?>
				<tr valign='top'>
					<td><?php echo "Registration Date"; ?></td>
					<td><?php echo $patient->regDate ?></td>
				</tr>
				<?php
			}
			if($report_config->usePatientAddlId == 1) {
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></td>
					<td><?php echo $patient->getAddlId(); ?></td>
				</tr>
				<?php
			}
			if( ($report_config->usePatientName == 1) && ($hidePatientName != 1) ) {
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
					<td><?php echo $patient->name; ?></td>
				</tr>
				<?php
			}
			if($report_config->useAge == 1) {
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['AGE']; ?></td>
					<td><?php echo $patient->getAge(); ?></td>
				</tr>
				<?php
			}
			if($report_config->useGender == 1) {
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['GENDER']; ?></td>
					<td><?php echo $patient->sex; ?></td>
				</tr>
				<?php
			}
			if($report_config->useDob == 1) {
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['DOB']; ?></td>
					<td><?php echo $patient->getDob(); ?></td>
				</tr>
				<?php
			}
			# Patient Custom fields here
			$custom_field_list = $lab_config->getPatientCustomFields();
			foreach($custom_field_list as $custom_field) {
				if(in_array($custom_field->id, $report_config->patientCustomFields)) {
					$field_name = $custom_field->fieldName;
					?>
					<tr valign='top'>
					<?php
					echo "<td>";
					echo $field_name;
					echo "</td>";
					$custom_data = get_custom_data_patient_bytype($patient->patientId, $custom_field->id);
					echo "<td>";
					if($custom_data == null) {
						echo "-";
					}
					else {
						$field_value = $custom_data->getFieldValueString($lab_config->id, 2);
						if(trim($field_value) == "")
							$field_value = "-";
						echo $field_value;
					}
					echo "</td>";
					?>
					</tr>
					<?php
				}
			}
			if($report_config->useDoctor == 1 && $physician_same === true) {
				?>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['DOCTOR']; ?></td>
					<td><?php echo $previous_physician; ?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<br>
	<?php
}

//echo "Bill count - ".count($billing_info['names']);
if(count($billing_info['names']) != 0)
{?>
<table>
    <tr>
        <td>Date</td>
        <td>Test Name</td>
        <td>Cost</td>
    </tr>
        <?php for ($i = 0; $i < count($billing_info['names']); $i++) { ?>
    <tr>
        <td><?php echo $billing_info['dates'][$i]; ?></td>
        <td><?php echo $billing_info['names'][$i]; ?></td>
		
		<?php 
		if($defaultFlag != 1) { ?>
        <td><?php 
		//echo $exchange_rate->getExchangeRate(). " ";
		echo format_number_to_money_currencyName(($billing_info['costs'][$i])*$exchange_rate->getExchangeRate(), $currencyTo); ?></td>
		<?php } else {?>
		<td><?php echo format_number_to_money(($billing_info['costs'][$i])); ?></td>
		<?php } ?>
    </tr>
        <?php } ?>
    <tr>
        <td></td>
        <td>BILL TOTAL</td>
        <?php if($defaultFlag != 1) { ?>
        <td><?php echo format_number_to_money_currencyName(($billing_info['total'])*$exchange_rate->getExchangeRate(), $currencyTo); ?>
        </td>
		<?php } else {?>
		<td><?php echo format_number_to_money(($billing_info['costs'][$i])); ?></td>
		<?php } ?>
    </tr>
</table>
    <?php
	if(!isset($_REQUEST['yf'])) {
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
<div class='editable' title='Click to Edit'>
</div>
<div class='editable' title='Click to Edit'>
</div>
<div class='editable' title='Click to Edit'>
</div>
<!--p class="main">
............................................-->
<?php
$new_footer_part="............................................";
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
/*
$load_time = microtime();
$load_time = explode(' ',$load_time);
$load_time = $load_time[1] + $load_time[0];
$page_end = $load_time;
$final_time = ($page_end - $page_start);
$page_load_time = number_format($final_time, 4, '.', '');
echo("Page generated in " . $page_load_time . " seconds");
*/
?>
</tr>
</table>
</div>
</div>
</div>
</div>
</body>
</html>