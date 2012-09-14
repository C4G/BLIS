<?php 
include("redirect.php");
include("includes/header.php"); 
include("includes/random.php");
include("includes/stats_lib.php");
LangUtil::setPageId("blis_help_page");

$script_elems->enableTableSorter();
$script_elems->enableJQueryForm();

?>
<br>
<style type='text/css'>
label
{
	width: 10em;
	float: left;
	text-align: right;
	margin-right: 0.5em;
	display: block
}
</style>
<script>

function labconfig_disp()
{
if(document.getElementById('labconfig_disp').style.display =='none')
$('#labconfig_disp').show();
else
$('#labconfig_disp').hide();
//$('.right_pane').hide();
}

function testcatalog_disp()
{
if(document.getElementById('testcatalog_disp').style.display =='none')
$('#testcatalog_disp').show();
else
$('#testcatalog_disp').hide();
}

function reportlabconfig_disp()
{
if(document.getElementById('reportlabconfig_disp').style.display =='none')
$('#reportlabconfig_disp').show();
else
$('#reportlabconfig_disp').hide();
}

function report_disp()
{
if(document.getElementById('report_disp').style.display =='none')
$('#report_disp').show();
else
$('#report_disp').hide();
}

function results_disp()
{
if(document.getElementById('results_disp').style.display =='none')
$('#results_disp').show();
else
$('#results_disp').hide();
}

function configwlan()
{
if(document.getElementById('configwlan').style.display =='none')
$('#configwlan').show();
else
$('#configwlan').hide();
}

function right_load(option_num, div_id)
{
//	$('#misc_errormsg').hide();
	$('.right_pane').hide();
	$('.menu_option').removeClass('current_menu_option');
	$('#'+div_id).show();
	$('#option'+option_num).addClass('current_menu_option');
	
}
</script>

<table name="page_panes" cellpadding="10px">
	<tr valign='top'>
	<td id="left_pane" class="left_menu" valign="top" width='200px'>
	    <a id='option1' class='menu_option' style='display:none;' href="javascript:right_load(1,'myFAQ');">FAQs
		</a><br><br>
		<b> Admins </b>
		<br>
		<ul>
		<li>
			<a id='labconfig' class='menu_option' href="javascript:labconfig_disp();"><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></a><br><br>
			<div id='labconfig_disp' name='labconfig_disp' style='display:none;'>
				&nbsp;&nbsp;<a id='option2' class='menu_option' href="javascript:right_load(2,'Summary_config');"><?php echo LangUtil::$pageTerms['MENU_SUMMARY']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option3' class='menu_option' href="javascript:right_load(3,'Tests_config');"><?php echo LangUtil::$pageTerms['MENU_TESTS']; ?></a><br><br>
				&nbsp;&nbsp;<a id='reportlabconfig' class='menu_option' href='javascript:reportlabconfig_disp();'><?php echo LangUtil::$pageTerms['MENU_L_REPORTS']; ?></a><br><br>
					<div id='reportlabconfig_disp' name='reportlabconfig_disp' style='display:none;'>
						&nbsp;&nbsp;&nbsp;&nbsp;<a id='option4' class='menu_option' href="javascript:right_load(4,'IR_rc');"><?php echo LangUtil::$pageTerms['MENU_R_INFECTIONREPORT']; ?></a><br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;<a id='option5' class='menu_option' href="javascript:right_load(5,'DRS_rc');"><?php echo LangUtil::$pageTerms['MENU_R_DRS']; ?></a><br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;<a id='option6' class='menu_option' href="javascript:right_load(6,'WS_rc');"><?php echo LangUtil::$pageTerms['MENU_R_WORKSHEETS']; ?></a><br><br>
					</div>
				&nbsp;&nbsp;<a id='option7' class='menu_option' href="javascript:right_load(7,'UserAccounts_config');"><?php echo LangUtil::$pageTerms['MENU_USERACCOUNTS']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option8' class='menu_option' href="javascript:right_load(8,'RegistrationFields_config');"><?php echo LangUtil::$pageTerms['MENU_REGISTRATIONFIELDS']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option9' class='menu_option' href="javascript:right_load(9,'ModLang');"><?php echo LangUtil::$pageTerms['MENU_MODIFYLANG']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option25' class='menu_option' href="javascript:right_load(9,'SetupNet');"><?php echo LangUtil::$pageTerms['MENU_SETUPNETWORK']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option10' class='menu_option' href="javascript:right_load(10,'Export');"><?php echo LangUtil::$pageTerms['MENU_EXPORTCONFIG']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option11' class='menu_option' href="javascript:right_load(11,'Backup');"><?php echo LangUtil::$pageTerms['MENU_BACKUP']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option12' class='menu_option' href="javascript:right_load(12,'Revert');"><?php echo LangUtil::$pageTerms['MENU_REVERT']; ?></a><br><br>
			</div>
		</li>	
		
		<li>
			<a id='testcatalog' class='menu_option' href='javascript:testcatalog_disp();'><?php echo LangUtil::$pageTerms['MENU_TESTCATALOG']; ?></a><br><br>
			<div id='testcatalog_disp' name ='testcatalog_disp' style='display:none;'>
				&nbsp;&nbsp;<a id='option13' class='menu_option' href="javascript:right_load(13,'TestType_tc');"><?php echo LangUtil::$pageTerms['MENU_TC_TESTTYPE']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option14' class='menu_option' href="javascript:right_load(14,'SpecimenType_tc');"><?php echo LangUtil::$pageTerms['MENU_TC_SPECIMENTYPE']; ?></a><br><br>
			</div>
		</li>
		<li>
		<a id='option15' class='menu_option' href="javascript:right_load(15,'Backup_Data');"><?php echo LangUtil::$pageTerms['MENU_BACKUPDATA']; ?></a>
		</li>
		</ul>
		
		<b> Technicians </b>
		<br>
		<ul>
		<li>
		<a id ='option16' class='menu_option' href="javascript:right_load(16,'Registration');"><?php echo LangUtil::$pageTerms['MENU_REGISTRATION']; ?></a><br><br>
		</li>
		<li>
		<a id='results' class='menu_option' href='javascript:results_disp();'><?php echo LangUtil::$pageTerms['MENU_RESULTS']; ?></a><br><br>
			<div id='results_disp' name='results_disp' style='display:none;'>
				&nbsp;&nbsp;<a id='option17' class='menu_option' href="javascript:right_load(17,'SSR_r');"><?php echo LangUtil::$pageTerms['MENU_R_SINGLESPECIMENRESULTS']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option18' class='menu_option' href="javascript:right_load(18,'BR_r');"><?php echo LangUtil::$pageTerms['MENU_R_BATCHRESULTS']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option19' class='menu_option' href="javascript:right_load(19,'VR_r');"><?php echo LangUtil::$pageTerms['MENU_R_VERIFYRESULTS']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option20' class='menu_option' href="javascript:right_load(20,'WS_r');"><?php echo LangUtil::$pageTerms['MENU_R_WORKSHEET']; ?></a><br><br>
			</div>
		</li>		
		<li>
		<a id='option21' class='menu_option' href="javascript:right_load(21,'Search');"><?php echo LangUtil::$pageTerms['MENU_SEARCH']; ?></a>
		</li><br>
		<li>
		<a id='option22' class='menu_option' href="javascript:right_load(22,'Inventory');"><?php echo LangUtil::$pageTerms['MENU_INVENTORY']; ?></a>
		</li>
		</ul>
		<b> All users </b>
		<br>
		<ul>
		<li>
		<a id='report' class='menu_option' href='javascript:report_disp()'><?php echo LangUtil::$pageTerms['MENU_REPORTS']; ?></a><br><br>
			<div id='report_disp' name='report_disp' style='display:none;'>
				&nbsp;&nbsp;<a id='option23' class='menu_option' href="javascript:right_load(23,'DailyReport');"><?php echo LangUtil::$pageTerms['MENU_DAILYREPORTS']; ?></a><br><br>
				&nbsp;&nbsp;<a id='option24' class='menu_option' href="javascript:right_load(24,'AggReport');"><?php echo LangUtil::$pageTerms['MENU_AGGREGATEREPORTS']; ?></a><br><br>
			</div>
		</li>
		</ul>	
	</td>
	
	<td>
	<div id='myFAQ' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
	<li>
	<a id='ConfigWirelessLan' href='javascript:configwlan();'>How to configure Wireless Access to BLIS?</a><br><br>
		<div id='configwlan' name='configwlan' class='right_pane' style='display:none;'>
		<ol>
			<li>Login as Admin.</li><br>
			<li>Click on the Setup Network option in the <b>Lab Configuration</b> tab</li><br>
	<!--		<li>Pass the generated BlisSetup.html file to the other computers to enable wireless access</li><br> -->
			<li>You will now be able to access BLIS by clicking on the BlisSetup.html file and entering your username and password.
		</ol><br>
			<i>In case of a computer restart or network failure repeat above steps again</i>
		</div>	
	</li>
	</ul>
	</div>
	
	<div id='Summary_config' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_SUMMARY']; ?></h3>
	<ul>
		<?php 
		if(LangUtil::$pageTerms['TIPS_SUMMARY_1']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_SUMMARY_1'];
			echo "</li>";
		}	
		if(LangUtil::$pageTerms['TIPS_SUMMARY_2']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_SUMMARY_2'];
			echo "</li>";
		}
		if(LangUtil::$pageTerms['TIPS_SUMMARY_3']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_SUMMARY_3'];
			echo "</li>"; 
		}	
		?>	
	</ul>	
	</div>
	
	<div id='Tests_config' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_TESTS']; ?></h3>
	<p>This has the following options:</p>
	<ul>
		<?php
		if(LangUtil::$pageTerms['TIPS_SPECIMENTESTTYPES']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_SPECIMENTESTTYPES'];
			echo "</li>";
		}	
		if(LangUtil::$pageTerms['TIPS_TARGETTAT']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_TARGETTAT'];
			echo "</li>";
		}
		if(LangUtil::$pageTerms['TIPS_RESULTINTERPRETATION']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_RESULTINTERPRETATION'];
			echo "</li>"; 
		}
		?>
	</ul>
	</div>
	
	<div id='IR_rc' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3>&nbsp;&nbsp;<?php echo LangUtil::$pageTerms['MENU_L_REPORTS']; ?></h3>
	<h4>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo LangUtil::$pageTerms['MENU_R_INFECTIONREPORT']; ?></h4>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_INFECTIONREPORT']; ?></li>
		</ul>
	</div>	
	
	<div id='DRS_rc' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3>&nbsp;&nbsp;<?php echo LangUtil::$pageTerms['MENU_L_REPORTS']; ?></h3>
	<h4>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo LangUtil::$pageTerms['MENU_R_DRS']; ?></h4>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_DAILYREPORTSETTINGS']; ?></li>
		</ul>
	</div>
	
	<div id='WS_rc' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3>&nbsp;&nbsp;<?php echo LangUtil::$pageTerms['MENU_L_REPORTS']; ?></h3>
	<h4>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo LangUtil::$pageTerms['MENU_R_WORKSHEETS']; ?></h4>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_WORKSHEETS']; ?></li>
		</ul>
	</div>
	
	<div id='UserAccounts_config' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_USERACCOUNTS']; ?></h3>
	<ul>	
		<?php
		if(LangUtil::$pageTerms['TIPS_USERACCOUNTS_1']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_USERACCOUNTS_1'];
			echo "</li>";
		}	
		if(LangUtil::$pageTerms['TIPS_USERACCOUNTS_2']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_USERACCOUNTS_2'];
			echo "</li>";
		}
		if(LangUtil::$pageTerms['TIPS_USERACCOUNTS_3']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_USERACCOUNTS_3'];
			echo "</li>"; 
		}
		?>
	</ul>
	</div>
	
	<div id='RegistrationFields_config' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_REGISTRATIONFIELDS']; ?></h3>
	<ul>	
		<?php
		if(LangUtil::$pageTerms['TIPS_REGISTRATIONFIELDS_1']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_REGISTRATIONFIELDS_1'];
			echo "</li>";
		}	
		if(LangUtil::$pageTerms['TIPS_REGISTRATIONFIELDS_2']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_REGISTRATIONFIELDS_2'];
			echo "</li>";
		}
		if(LangUtil::$pageTerms['TIPS_REGISTRATIONFIELDS_3']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_REGISTRATIONFIELDS_3'];
			echo "</li>"; 
		}
		?>
	</ul>
	</div>
	
	<div id='ModLang' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_MODIFYLANG']; ?></h3>
	<ul>
		<li><?php echo LangUtil::$pageTerms['TIPS_MODIFYLANG_1']; ?></li>
		<li><?php echo LangUtil::$pageTerms['TIPS_MODIFYLANG_2']; ?></li>
	</ul>
	</div>
	
	<div id='SetupNet' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_SETUPNETWORK']; ?></h3>
	<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_SETUPNETWORK_1']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_SETUPNETWORK_2']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_SETUPNETWORK_3']; ?></li>
	</ul><br>
			<i><?php echo LangUtil::$pageTerms['TIPS_SETUPNETWORK_4']; ?></i>
	</div>
	
	<div id='Export' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_EXPORTCONFIG']; ?></h3>
	<ul>
		<li><?php echo LangUtil::$pageTerms['TIPS_EXPORTCONFIG']; ?></li>
	</ul>
	</div>
	
	<div id='Backup' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_BACKUP']; ?></h3>
	<ul><li><?php echo LangUtil::$pageTerms['TIPS_BACKUP']; ?></li></ul>
	</div>
	
	<div id='Revert' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_LABCONFIG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_REVERT']; ?></h3>
	<ul>
		<li><?php echo LangUtil::$pageTerms['TIPS_REVERT']; ?></li>
	</ul>
	</div>
	
	<div id='TestType_tc' class='right_pane' style='display:none;margin-left:10px;'>
		<h2><u><?php echo LangUtil::$pageTerms['MENU_TESTCATALOG']; ?></u></h2>
		<h3><?php echo LangUtil::$pageTerms['MENU_TC_TESTTYPE']; ?></h3>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_TC_TESTTYPE_1']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_TC_TESTTYPE_2']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_TC_TESTTYPE_3']; ?></li>
		</ul>
	</div>
		
	<div id='SpecimenType_tc' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_TESTCATALOG']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_TC_SPECIMENTYPE']; ?></h3>
	<ul>
		<li><?php echo LangUtil::$pageTerms['TIPS_TC_SPECIMENTYPE_1']; ?></li>
		<li><?php echo LangUtil::$pageTerms['TIPS_TC_SPECIMENTYPE_2']; ?></li>
		<li><?php echo LangUtil::$pageTerms['TIPS_TC_SPECIMENTYPE_3']; ?></li>
	</ul>
	</div>

	<div id='Backup_Data' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_BACKUPDATA']; ?></u></h2>
	<ul>
		<li><?php echo LangUtil::$pageTerms['TIPS_BACKUPDATA']; ?></li>
	</ul>	
	</div>
	
	<div id='Registration' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_REGISTRATION']; ?></u></h2>
	<ul>
		<?php
		if(LangUtil::$pageTerms['TIPS_REGISTRATION_1']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_REGISTRATION_1'];
			echo "</li>";
		}	
		if(LangUtil::$pageTerms['TIPS_REGISTRATION_2']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_REGISTRATION_2'];
			echo "</li>";
		}
		if(LangUtil::$pageTerms['TIPS_REGISTRATION_3']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_REGISTRATION_3'];
			echo "</li>"; 
		}
		?>
	</ul>
	</div>
	
	<div id='SSR_r' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_RESULTS']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_R_SINGLESPECIMENRESULTS']; ?></h3>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_R_SINGLESPECIMENRESULTS']; ?></li>
		</ul>
	</div>
	
	<div id='BR_r' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_RESULTS']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_R_BATCHRESULTS']; ?></h3>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_R_BATCHRESULTS']; ?></li>
		</ul>
	</div>	
	
	<div id='VR_r' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_RESULTS']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_R_VERIFYRESULTS']; ?></h3>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_R_VERIFYRESULTS']; ?></li>
		</ul>
	</div>	
	
	<div id='WS_r' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_RESULTS']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_R_WORKSHEET']; ?></h3>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_R_WORKSHEET_1']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_R_WORKSHEET_2']; ?></li>
		</ul>
	</div>	

	<div id='Search' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_SEARCH']; ?></u></h2>
	<ul>
		<?php
		if(LangUtil::$pageTerms['TIPS_SEARCH_1']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_SEARCH_1'];
			echo "</li>";
		}	
		if(LangUtil::$pageTerms['TIPS_SEARCH_2']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_SEARCH_2'];
			echo "</li>";
		}
		if(LangUtil::$pageTerms['TIPS_SEARCH_3']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_SEARCH_3'];
			echo "</li>"; 
		}
		?>
	</ul>
	</div>

	<div id='Inventory' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_INVENTORY']; ?></u></h2>
	<ul>
		<?php
		if(LangUtil::$pageTerms['TIPS_INVENTORY_1']!="-") {
			echo "<li>";
			echo LangUtil::$pageTerms['TIPS_INVENTORY_1'];
			echo "</li>";
		}	
		if(LangUtil::$pageTerms['TIPS_INVENTORY_2']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_INVENTORY_2'];
			echo "</li>";
		}
		if(LangUtil::$pageTerms['TIPS_INVENTORY_3']!="-") {
			echo "<li>"; 
			echo LangUtil::$pageTerms['TIPS_INVENTORY_3'];
			echo "</li>"; 
		}
		?>
	</ul>
	</div>
	
	<div id='DailyReport' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_REPORTS']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_DAILYREPORTS']; ?></h3>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_PATIENTREPORT']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_DAILYLOG']; ?></li>
		</ul>
	</div>
	
	<div id='AggReport' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u><?php echo LangUtil::$pageTerms['MENU_REPORTS']; ?></u></h2>
	<h3><?php echo LangUtil::$pageTerms['MENU_AGGREGATEREPORTS']; ?></h3>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_PREVALENCERATE']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_COUNTS']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_TURNAROUNDTIME']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_INFECTIONREPORT']; ?></li>
			<li><?php echo LangUtil::$pageTerms['TIPS_INVENTORY']; ?></li>
		</ul>
	</div>
	</td>
</tr>
</table>
<?php include("includes/footer.php"); ?>
</body>
</html>