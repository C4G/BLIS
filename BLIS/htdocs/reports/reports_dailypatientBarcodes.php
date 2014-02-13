<?php
#
# Main page for printing daily patient records
#
include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");
include("includes/page_elems.php");
include("barcode/barcode_lib.php");
include("includes/user_lib.php");

LangUtil::setPageId("reports");

$page_elems = new PageElems();
$script_elems = new ScriptElems();
//$script_elems->enableJquery();
$script_elems->enableTableSorter();
$script_elems->enableDragTable();


$column = $_REQUEST['col'];
$bar_width = $_REQUEST['wd']; //2;
$bar_height = $_REQUEST['ht']; //40;
$font_size = $_REQUEST['fs']; //11;
$date_from = $_REQUEST['yf']."-".$_REQUEST['mf']."-".$_REQUEST['df'];
$date_to = $_REQUEST['yt']."-".$_REQUEST['mt']."-".$_REQUEST['dt'];
$lab_config_id = $_REQUEST['l'];

$uiinfo = "from=".$date_from."&to=".$date_to;
putUILog('daily_log_patients_barcodes', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$lab_config = get_lab_config_by_id($lab_config_id);
$saved_db = DbUtil::switchToLabConfig($lab_config_id);
$patient_list = Patient::getPatientsAndSpecimenCountByRegDateRange($date_from, $date_to);
DbUtil::switchRestore($saved_db);

$report_id = $REPORT_ID_ARRAY['reports_dailypatientBarcodes.php'];
$report_config = $lab_config->getReportConfig(1);
$margin_list = $report_config->margins;

for($i = 0; $i < count($margin_list); $i++)
{
	$margin_list[$i] = ($SCREEN_WIDTH * $margin_list[$i] / 100);
}


$barcodeSettings = get_lab_config_settings_barcode();
//  print_r($barcodeSettings);
$code_type = $barcodeSettings['type']; //"code39";
if($bar_width == "")
$bar_width = $barcodeSettings['width']; //2;
if($bar_height == "")
$bar_height = $barcodeSettings['height']; //40;
if($font_size == "")
$font_size = $barcodeSettings['textsize']; //11;
if($column ==""){
	$column = 2;
}

?>
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
<script type="text/javascript" src="../js/nicEdit.js"></script>
<script type="text/javascript" src="../js/jquery-barcode-2.0.2.js"></script>
<script type='text/javascript'>
function refresh_print_form() {
	var yf = <?php echo $_REQUEST['yf'];?>;
	var mf = <?php echo $_REQUEST['mf'];?>;
	var df = <?php echo $_REQUEST['df'];?>;
	var yt = <?php echo $_REQUEST['yt'];?>;
	var mt = <?php echo $_REQUEST['mt'];?>;
	var dt = <?php echo $_REQUEST['dt'];?>;
	var wd = $("#barcodeWidth").val();
	var ht = $("#barcodeHeight").val();
	var fs = $("#barcodeFontSize").val();
	var col = $("#columnCount").val();
	$('#fetch_progress').show();
	var url_string = "reports_dailypatientBarcodes.php?l=<?php echo $lab_config_id; ?>&yf="+yf+"&mf="+mf+"&df="+df+"&yt="+yt+"&mt="+mt+"&dt="+dt+"&wd="+wd+"&ht="+ht+"&fs="+fs+"&col="+col;
	window.location=url_string;
}


function export_as_word(div_id)
{
	var content = $('#'+div_id).html();
	$('#word_data').attr("value", content);
	$('#word_format_form').submit();
}

function print_content(div_id)
{
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
	//javascript:window.print();
}
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

$("input[name='do_landscape']").click( function() {
	change_orientation();
});

$(document).ready(function(){
	$('#report_content_table5').tablesorter();
	<?php $patientCount = count($patient_list);
	for($i=0;$i<$patientCount; $i++){
	?>
	var code = $('#barcodeCode<?php echo $i;?>').val();
	$('.patientBarcode<?php echo $i;?>').barcode(code, '<?php echo $code_type; ?>',{barWidth:<?php echo $bar_width; ?>, barHeight:<?php echo $bar_height; ?>, fontSize:<?php echo $font_size; ?>, output:'css'});
	<?php } ?> 
});
</script>

<form name='word_format_form' id='word_format_form' action='export_word.php' method='post' target='_blank'>
	<input type='hidden' name='data' value='' id='word_data' />
</form>
<!-- <input type='radio' name='do_landscape' value='N' <?php
	if($report_config->landscape == false) echo " checked ";
?>>Portrait</input> -->
<input type='radio' name='do_landscape' value='N' <?php echo " checked "; ?>>Portrait</input>
&nbsp;&nbsp;
<input type='radio' name='do_landscape' value='Y'>Landscape</input>&nbsp;&nbsp;
<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:export_as_word('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_EXPORTWORD']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
&nbsp;&nbsp;&nbsp;&nbsp; <br/>
<?php echo LangUtil::$generalTerms['WIDTH']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
<input type='text' name="barcodeWidth" id="barcodeWidth" value='<?php echo $bar_width ?>' size="2" maxlength="2"></input>
&nbsp;&nbsp;
<?php echo LangUtil::$generalTerms['HEIGHT']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
<input type='text' name="barcodeHeight" id="barcodeHeight" value='<?php echo $bar_height ?>' size="2" maxlength="2"></input> 
&nbsp;&nbsp;
<?php echo LangUtil::$generalTerms['FONT_SIZE']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
<input type='text' name="barcodeFontSize" id="barcodeFontSize" value='<?php echo $font_size ?>' size="2" maxlength="2"></input> 
&nbsp;&nbsp;
<?php echo LangUtil::$generalTerms['COL_COUNT']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
<input type='text' name="columnCount" id="columnCount" value='<?php echo $column ?>' size="2" maxlength="2"></input> 
&nbsp;&nbsp;
<input type='button' onclick="javascript:refresh_print_form();" value='<?php echo LangUtil::$generalTerms['CMD_REFRESH']; ?>'></input>


<hr>
<div id='export_content'>
<link rel='stylesheet' type='text/css' href='css/table_print.css' />
<style type='text/css'>
	<?php $page_elems->getReportConfigCss(77, false); ?>
</style>
<div id='report_config_content'>
<h3><?php LangUtil::$generalTerms['PATIENT_BARCODE'] ?></h3>
<?php echo "<b>".LangUtil::$generalTerms['FACILITY']."</b>: &nbsp;&nbsp;".$lab_config->getSiteName()."&nbsp;&nbsp;"; ?>
 <?php
 if($date_from == $date_to)
 {
	echo "&nbsp;&nbsp;<b>".LangUtil::$generalTerms['DATE']."&nbsp;&nbsp;</b>: ".DateLib::mysqlToString($date_from)."&nbsp;&nbsp;";
 }
 else
 {
	echo "&nbsp;&nbsp;<b>".LangUtil::$generalTerms['FROM_DATE']."&nbsp;&nbsp;</b>: ".DateLib::mysqlToString($date_from)."&nbsp;&nbsp;";
	echo " | ";
	echo "&nbsp;&nbsp;<b>".LangUtil::$generalTerms['TO_DATE']."&nbsp;&nbsp;</b>: ".DateLib::mysqlToString($date_to)."&nbsp;&nbsp;";
 }
 ?>
  
<?php
if( (count($patient_list) == 0 || $patient_list == null) && (count($patient_list_U) == 0 || $patient_list_U == null) )
{
	echo LangUtil::$pageTerms['TIPS_NONEWPATIENTS'];
	return;
}

?>
<br><br>
<?php $patientCount = 0;  ?>
<?php foreach ($patient_list as $patient) {?>
<input type="text" id="barcodeCode<?php echo $patientCount;?>" name="barcodeCode<?php echo $patientCount;?>" value="<?php echo encodePatientBarcode($patient->getSurrogateId(),$lab_config_id); ?>" style="display: none"></input>
<?php echo "<b>".LangUtil::$generalTerms['PATIENT_ID']."</b>";?> &nbsp;&nbsp;<?php echo $patient->getSurrogateId(); ?>&nbsp;|&nbsp; <?php echo "<b>".LangUtil::$generalTerms['PATIENT_NAME']."</b>";?> &nbsp;&nbsp;<?php echo $patient->getName();?>&nbsp;|&nbsp; <?php echo "<b>".LangUtil::$generalTerms['AGE']."</b>";?> &nbsp;&nbsp;<?php echo $patient->getAge();?>&nbsp;
<br/><br/>
<table style="border='0'" border="0" >
	<?php for ($rowno = 1; $rowno <= ceil($patient->getSpecimenCount()/$column); $rowno++) {?> 
	<tr>
	<td><div id="patientBarcode<?php echo $patientCount;?>" class="patientBarcode<?php echo $patientCount;?>"></div></td>
	
	<?php for ($j = 2 ; $j<=$column ; $j++){ ?>
		<?php if($column*($rowno-1)+$j <= $patient->getSpecimenCount()) {?>
		<td><div id="patientBarcode<?php echo $patientCount;?>" class="patientBarcode<?php echo $patientCount;?>"></div></td>
		<?php } else {?>
		<td><?php echo "-"; ?></td>
		<?php } ?>
	<?php } ?>
	
	</tr>
	
	<?php }?>
</table>
<br/>

<?php for($breakTime=0; $breakTime<$column; $breakTime++) 
	{
		echo "-------------------------------------------------------";
	} echo "<br/><br/>"
?>
	
<?php $patientCount++; }?>

<br><br>

<br>
<?php # Line for Signature ?>
.............................

<h4><?php echo $report_config->footerText; ?></h4>
</div>
</div>