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
include("includes/script_elems.php");
include("includes/page_elems.php");
LangUtil::setPageId("reports");
include("../users/accesslist.php");
 if(!(isLoggedIn(get_user_by_id($_SESSION['user_id']))))
	header( 'Location: home.php' );
$date_from = "";
$date_to = "";
$hidePatientName = 0;

if(isset($_REQUEST['yf'])) {
	$date_from = $_REQUEST['yf']."-".$_REQUEST['mf']."-".$_REQUEST['df'];
	$date_to = $_REQUEST['yt']."-".$_REQUEST['mt']."-".$_REQUEST['dt'];
}
else {
	$date_from = date("Y-m-d");
	$date_to = $date_from;
}

# Helper function to fetch test history records
function get_records_to_print($lab_config, $patient_id) {
	global $date_from, $date_to;
	$retval = array();
	if(isset($_REQUEST['ip']) && $_REQUEST['ip'] == 0) {
		# Do not include pending tests
            //echo "Hi";
		$query_string =
			"SELECT t.* FROM test t, specimen sp ".
			"WHERE t.result <> '' ".
			"AND t.specimen_id=sp.specimen_id ".
			"AND sp.patient_id=$patient_id ";
		if(isset($_REQUEST['yf']))
			$query_string .= "AND (sp.date_collected BETWEEN '$date_from' AND '$date_to') ";
		$query_string .= "ORDER BY sp.date_collected DESC";
	
	}
	else {
		# Include pending tests
		$query_string =
			"SELECT t.* FROM test t, specimen sp ".
			"WHERE t.specimen_id=sp.specimen_id ".
			"AND sp.patient_id=$patient_id ";
		if(isset($_REQUEST['yf']))
			$query_string .= "AND (sp.date_collected BETWEEN '$date_from' AND '$date_to') ";
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
<script type="text/javascript" src="../js/d3.v2.js"></script>
<script type='text/javascript'>

var curr_orientation = 0;

function export_as_word(div_id) {
	document.getElementById('printhead').innerHTML=" ";
	var content = $('#'+div_id).html();
	$('#word_data').attr("value", content);
	$('#word_format_form').submit();
}

// Visualize patient test results

var chart_column_width = 360;
<?php
if(isset($_REQUEST['ip']) && $_REQUEST['ip'] == 0)
    $include_pending = 0;
else
    $include_pending = 1;?>
d3.json("reports/viz_test_result_data.php?patient_id=<?php echo $_REQUEST['patient_id'];?>&inc_p=<?php echo $include_pending;?>", function(patient_data){
	
	// get test results data
	var patient_data_by_tests = new Array();
	var patient_data_by_tests_header = new Array();
	
	/*
	<?php if($report_config->useTestName == 1) { ?>
		patient_data_by_tests_header.push("<?php echo LangUtil::$generalTerms['TEST']; ?>");
	<?php }
	if($report_config->useDateRecvd == 1) {?>
		patient_data_by_tests_header.push("<?php echo LangUtil::$generalTerms['DATE']; ?>");
	<?php }
	if($report_config->useResults == 1) {?>
		patient_data_by_tests_header.push("<?php echo LangUtil::$generalTerms['RESULTS']; ?>");
	<?php }
	if($report_config->useRemarks == 1) {?>
		patient_data_by_tests_header.push("<?php echo LangUtil::$generalTerms['RESULT_COMMENTS']; ?>");
	<?php } ?>
	*/
	
	patient_data_by_tests_header = ["<?php echo LangUtil::$generalTerms['TEST']; ?>","<?php echo LangUtil::$generalTerms['DATE']; ?>",
	"<?php echo LangUtil::$generalTerms['RESULTS']; ?>","<?php echo LangUtil::$generalTerms['RESULT_COMMENTS']; ?>"];
	
	// reformat data
	for(var i in patient_data){
		if(i=="has") break;
		var patient_id = patient_data[i].patient_id;
		var test_date = patient_data[i].test_date;
		var test_name = patient_data[i].test_name;
		var range = patient_data[i].range;
		var test_result = patient_data[i].result;
		var comment = patient_data[i].comment;
		
		if(test_result==""){
			test_result = "Pending";
		}else{
			
			if(range!=""){
				// add unit to remarks (comment)
				var split_range = range.split(" ");
				var unit = split_range[split_range.length-1];
				
				if(comment=="-"){
					comment = test_result + " " + unit;
				}else{
					comment += ", " + test_result + " " + unit;	
				}
			}
			
			test_result += "::" + range;
		}
		
		/*
		patient_data_by_tests[i] = new Array();
		<?php if($report_config->useTestName == 1) { ?>
			patient_data_by_tests[i].push(test_name);
		<?php }
		if($report_config->useDateRecvd == 1) {?>
			patient_data_by_tests[i].push(test_date);
		<?php }
		if($report_config->useResults == 1) {?>
			patient_data_by_tests[i].push(test_result);
		<?php }
		if($report_config->useRemarks == 1) {?>
			patient_data_by_tests[i].push(comment);
		<?php } ?>		
		*/
		patient_data_by_tests[i] = [test_name, test_date, test_result, comment];	
	}
	
	
	var body = d3.select("#viz_table");
	
	body.append("hr");

	body.append("table")
		.style("border-collapse", "collapse")
		.append("tr")
		.selectAll("td")
		.data(patient_data_by_tests_header)
		.enter().append("td")
		.style("width", function(d, i){
			
			switch(i){
			case 0:
				return "150px"; 
				break;
			case 1:
				return "80px";
				break;
			case 2:
				return "360px";
				break;
			case 3:
				return "170px";
				break;
			}
		})
		.style("border", "0px")
		.style("padding", "5px")
		.style("font-weight", "bold")
		.text(function(d){return d;});
	
	var vis = body.append("table")
		.style("border-collapse", "collapse")
		.selectAll("tr")
		.data(patient_data_by_tests)
	  .enter().append("tr")
		.selectAll("td")
		.data(function(d){return d;})
	  .enter().append("td")
		.style("width", function(d, i){
			switch(i){
			case 0:
				return "150px"; 
			case 1:
				return "80px";
			case 2:
				return "360px";
			case 3:
				return "170px";
			}
		})
		.style("border", "1px black solid")
		.style("border-color", "#999999")
		.style("padding", "5px")
		.style("font-size", "0.8em")
		.text(function(d,i){
				if((i==2) && (d!="Pending")){
					var result_range_array = d.split("::");
					var result = result_range_array[0];
					var range = result_range_array[1];
					var result_parsable = false;
					
					// check to see if result contains a numeric, parsable value
					if(result.match("[0-9]+")){
						result_parsable = true;
					}
					
					if(range=="" || !result_parsable){ // if the range is empty, put the results
						return result;
					}else{
						return "";
					}
				}else{
					return d;
				}
			})
		.append("svg")
			.attr("width", function(d,i){
				
				// set chart size, 0 for not required
				switch(i){
					case 0:
						return 0;
					case 1:
						return 0;
					case 2:
						var result_range_array = d.split("::");
						var result = result_range_array[0];
						var range = result_range_array[1];
						var result_parsable = false;
						
						// check to see if result contains a numeric, parsable value
						if(result.match("[0-9]+")){
							result_parsable = true;
						}
						
						if(d=="Pending" || range=="" || !result_parsable){
							return 0;
						}else{
							return 360;
						}
					case 3:
						return 0;
				}
			})
			.attr("height",10);
	
		// draw range bar: low
		vis.append("rect")
			.attr("width", function(d,i){
				if(i==2){
					if(getVisualizationType(d)==0){
						return chart_column_width/4;	
					}else if(getVisualizationType(d)==1){
						return 0;
					}
				}
			})
			.attr("height", 10)
			.attr("fill", d3.rgb(0,0,0))
			.style("opacity", 0.2);

		// draw range bar: normal
		vis.append("rect")
			.attr("x", function(d,i){
				if(i==2){
					if(getVisualizationType(d)==0){
						return chart_column_width/4;	
					}else if(getVisualizationType(d)==1){
						return 0;
					}
				}
			})
			.attr("width", function(d,i){
				if(i==2){
					if(getVisualizationType(d)==0){
						return chart_column_width/2;	
					}else if(getVisualizationType(d)==1){
						return chart_column_width/2;
					}
				}
			})
			.attr("height", 10)
			.attr("left", 10)
			.attr("fill", d3.rgb(0,0,0))
			.style("opacity", 0.3);
	
		// draw range bar: high
		vis.append("rect")
			.attr("x", function(d,i){
				if(i==2){
					if(getVisualizationType(d)==0){
						return 3*(chart_column_width/4);	
					}else if(getVisualizationType(d)==1){
						return chart_column_width/2;
					}
				}
			})
			.attr("width", function(d,i){
				if(i==2){
					if(getVisualizationType(d)==0){
						return chart_column_width/4;	
					}else if(getVisualizationType(d)==1){
						return chart_column_width/2;
					}
				}
			})
			.attr("height", 10)
			.attr("left", 10)
			.attr("fill", d3.rgb(0,0,0))
			.style("opacity", 0.15);
		
		// draw result bar on range bar
		vis.append("rect")
			.attr("x", function(d, i){
					if(i==2){
						return parseResultX(d, chart_column_width);
					}
				})
			.attr("width", function(d, i){
				if(i==2){
					if(getVisualizationType(d)==0){
						return 3;	
					}else if(getVisualizationType(d)==1){
						if(parseResultX(d, chart_column_width)==0){
							// color the whole normal range if the result is normal (< a number)
							return chart_column_width/2;
						}else{
							return 3;
						}
					}
				}
			})
			.attr("height", 10)
			.attr("left", 10)
			.attr("fill", d3.rgb(0,0,0));
});

// determine the type of visualization by the type of result
function getVisualizationType(resultRange){
	var result_range_array = resultRange.split("::");
	var result = result_range_array[0];
	var range = result_range_array[1];
	if(result.match("[-+]?[0-9]*\.?[0-9]+") && (range.indexOf("<")!=-1)){
		return 1;
	}else{
		return 0;		
	}
}

// calculate where on the range bar should the result bar be drawn
function parseResultX(resultRange, chart_column_width){
	var result_range_array = resultRange.split("::");
	var result = result_range_array[0];
	var range = result_range_array[1];
	var chart_location = 0;
	
	// time range
	if(result.match("[0-9]+min [0-9]+sec")){
		
		// result
		var min = result.split("min ")[0];
		var sec = result.split("min ")[1].split("sec")[0];
		var total_seconds = min*60+parseInt(sec);
		
		// range
		var low_range = range.split(" min")[0].split("-")[0];
		var high_range = range.split("min")[0].split("-")[1];
		var full_range = (high_range - low_range)*60;
		var seconds_offset = total_seconds - low_range*60;
		
		chart_location = 
			(chart_column_width/4) + (chart_column_width/2)*(seconds_offset/full_range);

	}else if(result.match("[-+]?[0-9]*\.?[0-9]+") && (range.indexOf("<")!=-1)){
		
		// have one-sided range, format < 6-, <6-
		var splitRange = range.split(" ");
		
		// < 6-
		if(splitRange[1].indexOf("-")!=-1){
			numeric_part = splitRange[1];
		}else{ // <6-
			numeric_part = splitRange[0].split("<")[1];
		}
		
		// 6-
		var full_range = numeric_part.split("-")[0];
		
		// check result format, could be a number, <6, or < 6
		var result_offset = 0;
		if(isNumeric(result)){
			result_offset = parseFloat(result); 
		}else{
			// format <6 or < 6
			var result_number = result.split("<")[1];
			result_offset = parseFloat(result_number); 
			
			// just place it to 0, when the result is < something, it is in the normal range
			result_offset = 0;
		}
		
		chart_location = (chart_column_width/2)*(result_offset/full_range);
		
	}else if(result.match("[-+]?[0-9]*\.?[0-9]+")){
		
		// numeric results with a specified range
		var numeric_part = range.split(" ")[0];
		var low_range = numeric_part.split("-")[0];
		var high_range = numeric_part.split("-")[1];
		var full_range = (high_range - low_range);
		var result_offset = parseFloat(result) - low_range;

		chart_location = 
			(chart_column_width/4) + (chart_column_width/2)*(result_offset/full_range);
	}

	if(chart_location<0){
		chart_location = 0;
	}else if(chart_location>chart_column_width){
		chart_location = chart_column_width-3;
	}
	
	return chart_location;
}

// test if a string value is numeric
function isNumeric(number){
	return !isNaN(parseFloat(number)) && isFinite(number);
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
	if($('#ip').is(":checked"))
		ip = 1;
	$('#fetch_progress').show();
	var url_string = "viz_test_history.php?location=<?php echo $lab_config_id; ?>&patient_id=<?php echo $patient_id; ?>&yf="+yf+"&mf="+mf+"&df="+df+"&yt="+yt+"&mt="+mt+"&dt="+dt+"&ip="+ip;
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
	
	<td>
		<input type='checkbox' name='ip' id='ip'></input> 
		<?php echo LangUtil::$pageTerms['MSG_INCLUDEPENDING']; ?>
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
$logo_path = "../logos/logo_".$lab_config_id.".jpg";
$logo_path2 = "../ajax/logo_".$lab_config_id.".jpg";
$logo_path1="../../logo_".$lab_config_id.".jpg";


if(file_exists($logo_path1) === true)
{	copy($logo_path1,$logo_path);
	?>
	<img src='<?php echo "logos/logo_".$lab_config_id.".jpg"; ?>' alt="Big Boat" height='140px'    ></src>
	<?php
}
else if(file_exists($logo_path) === true)
{
?>
	<img src='<?php echo "logos/logo_".$lab_config_id.".jpg"; ?>' alt="Big Boat" height='140px' width='140px'></src>
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
<h4 align="<?php echo $align; ?>"><?php echo $report_config->titleText; ?></h4>
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
	# Fetch test entries to print in report
	$record_list = get_records_to_print($lab_config, $patient_id); 
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
	<div id="viz_table"> </div>
	<?php
	
}

if(count($record_list) != 0)
{
	$latest_record = $record_list[0];
	$earliest_record = $record_list[count($record_list)-1];
	$latest_specimen = $latest_record[1];
	$earliest_specimen = $earliest_record[1];
	$latest_collection_parts = explode("-", $latest_specimen->dateCollected);
	$earliest_collection_parts = explode("-", $earliest_specimen->dateCollected);
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