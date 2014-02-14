<?php

#
# Lists a bill in a printable format by referencing a specific bill id.
#

include("redirect.php");
include("includes/db_lib.php");
include("includes/script_elems.php");
include("includes/page_elems.php");

LangUtil::setPageId("reports");

include("../users/accesslist.php");

if(!(isLoggedIn(get_user_by_id($_SESSION['user_id']))))
    header( 'Location: home.php' );

$hidePatientName = 0;

putUILog('reports_billing_specific', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$lab_config_id = $_SESSION['lab_config_id'];
$lab_config = get_lab_config_by_id($lab_config_id);

$bill_id = $_REQUEST['bill_id'];

$bill = Bill::loadFromId($bill_id, $lab_config_id);

$associations = $bill->getAllAssociationsForBill($lab_config_id);

$patient_id = $bill->getPatientId();

DbUtil::switchToLabConfig($lab_config_id);

$report_id = $REPORT_ID_ARRAY['reports_billing_specific.php'];
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
			<table class='no_border'>
				<tr valign='top'>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='button' onclick="javascript:print_content('report_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
					</td>
					<td>
						<table class='no border'>
							<tr valign='top'>
								<td>
									<input type='radio' name='do_landscape' value='N'<?php echo " checked "; ?>>Portrait</input>
								</td>
								<td>
									<input type='radio' name='do_landscape' value='Y'>Landscape</input>
								</td>
							</tr>
						</table>
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
						Font
					</td>
					<td>
						<table class='no border'>
							<tr valign='top'>
								<td>
									<input  type='button' class="increaseFont" value='Increase' title="Increase Font-size"></input> <br>
								</td>
								<td>
									<input type='button' class="decreaseFont" value='Decrease' title="Decrease Font-size"></input> <br>
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
						<?php $align=$report_config->alignment_header;?>
						<h3 align="<?php echo $align; ?>"><?php echo $report_config->headerText; ?><?php #echo LangUtil::$pageTerms['MENU_PHISTORY']; ?></h3>
						<h4 align="<?php echo $align; ?>"><?php echo "Patient Bill #" . $bill->getId(); ?></h4>
					</div>

					<br>
					<?php
					$patient = get_patient_by_id($patient_id);
					if($patient == null)
					{
						echo LangUtil::$generalTerms['PATIENT_ID']." $patient_id ".LangUtil::$generalTerms['MSG_NOTFOUND'];
					}
					else
					{ ?>
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
					<?php } ?>
					<table>
						<tr>
							<td>Date</td>
							<td>Test Name</td>
							<td>Cost</td>
						</tr>
							<?php foreach ($associations as $association) { ?>
						<tr>
							<td><?php echo $association->getTestDate() ?></td>
							<td><?php echo $association->getTestName() ?></td>
							<td align='right'><?php echo $association->getFormattedTestCost() ?></td>
						</tr>
							<?php } ?>
						<tr>
							<td></td>
							<td align='right'>BILL TOTAL</td>
							<td align='right'><?php echo $bill->getFormattedTotal($lab_config_id) ?></td>
						</tr>
					</table>

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
					?>
					<table width=100% border="0" class="no_border" ">
						<tr>
							<?php for($j=0;$j<count($footerText);$j++) { ?>
							<td <?php if($lab_config_id==234) {?>style="font-size:14pt;"<?php }?> ><?php echo $new_footer_part; ?></td>
							<?php }?>
						</tr>
						<tr>
							<?php for($j=0;$j<count($footerText);$j++) { ?>
							<td align="center" <?php if($lab_config_id==234) {?>style="font-size:14pt;"<?php }?>><?php echo $footerText[$j]; ?></td>
							<?php }?>
						</tr>
						<tr>
							<?php for($j=0;$j<count($designation);$j++) { ?>
							<td align="center"<?php if($lab_config_id==234) {?>style="font-size:14pt;"<?php }?> ><?php echo $designation[$j]; ?></td>
							<?php }	?>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>