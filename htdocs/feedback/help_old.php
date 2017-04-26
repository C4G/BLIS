<?php 
include("redirect.php");
include("includes/header.php"); 
include("includes/random.php");
include("includes/stats_lib.php");
LangUtil::setPageId("help");

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
	    <a id='option1' class='menu_option' href="javascript:right_load(1,'myFAQ');">FAQs
		</a><br><br>
		<b> Admins </b>
		<br>
		<ul>
		<li>
			<a id='labconfig' class='menu_option' href="javascript:labconfig_disp();">Lab Configuration</a><br><br>
			<div id='labconfig_disp' name='labconfig_disp' style='display:none;'>
				&nbsp;&nbsp;<a id='option2' class='menu_option' href="javascript:right_load(2,'Summary_config');">Summary</a><br><br>
				&nbsp;&nbsp;<a id='option3' class='menu_option' href="javascript:right_load(3,'Tests_config');">Tests</a><br><br>
				&nbsp;&nbsp;<a id='reportlabconfig' class='menu_option' href='javascript:reportlabconfig_disp();'>Reports</a><br><br>
					<div id='reportlabconfig_disp' name='reportlabconfig_disp' style='display:none;'>
						&nbsp;&nbsp;&nbsp;&nbsp;<a id='option4' class='menu_option' href="javascript:right_load(4,'IR_rc');">Infection Report</a><br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;<a id='option5' class='menu_option' href="javascript:right_load(5,'DRS_rc');">Daily Report Settings</a><br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;<a id='option6' class='menu_option' href="javascript:right_load(6,'WS_rc');">Worksheets</a><br><br>
					</div>
				&nbsp;&nbsp;<a id='option7' class='menu_option' href="javascript:right_load(7,'UserAccounts_config');">User Accounts</a><br><br>
				&nbsp;&nbsp;<a id='option8' class='menu_option' href="javascript:right_load(8,'RegistrationFields_config');">Registration Fields</a><br><br>
				&nbsp;&nbsp;<a id='option9' class='menu_option' href="javascript:right_load(9,'ModLang');">Modify Language</a><br><br>
				&nbsp;&nbsp;<a id='option25' class='menu_option' href="javascript:right_load(9,'SetupNet');">Setup Network</a><br><br>
				&nbsp;&nbsp;<a id='option10' class='menu_option' href="javascript:right_load(10,'Export');">Export Configuration</a><br><br>
				&nbsp;&nbsp;<a id='option11' class='menu_option' href="javascript:right_load(11,'Backup');">Backup Data</a><br><br>
				&nbsp;&nbsp;<a id='option12' class='menu_option' href="javascript:right_load(12,'Revert');">Revert to Backup</a><br><br>
			</div>
		</li>	
		
		<li>
			<a id='testcatalog' class='menu_option' href='javascript:testcatalog_disp();'>Test Catalog</a><br><br>
			<div id='testcatalog_disp' name ='testcatalog_disp' style='display:none;'>
				&nbsp;&nbsp;<a id='option13' class='menu_option' href="javascript:right_load(13,'TestType_tc');">Test Type</a><br><br>
				&nbsp;&nbsp;<a id='option14' class='menu_option' href="javascript:right_load(14,'SpecimenType_tc');">Specimen Type</a><br><br>
			</div>
		</li>
		<li>
		<a id='option15' class='menu_option' href="javascript:right_load(15,'Backup_Data');">Backup Data
		</a>
		</li>
		</ul>
		
		<b> Technicians </b>
		<br>
		<ul>
		<li>
		<a id ='option16' class='menu_option' href="javascript:right_load(16,'Registration');">Registration</a><br><br>
		</li>
		<li>
		<a id='results' class='menu_option' href='javascript:results_disp();'>Results</a><br><br>
			<div id='results_disp' name='results_disp' style='display:none;'>
				&nbsp;&nbsp;<a id='option17' class='menu_option' href="javascript:right_load(17,'SSR_r');">Single Specimen Results</a><br><br>
				&nbsp;&nbsp;<a id='option18' class='menu_option' href="javascript:right_load(18,'BR_r');">Batch Results</a><br><br>
				&nbsp;&nbsp;<a id='option19' class='menu_option' href="javascript:right_load(19,'VR_r');">Verify Results</a><br><br>
				&nbsp;&nbsp;<a id='option20' class='menu_option' href="javascript:right_load(20,'WS_r');">Worksheet</a><br><br>
			</div>
		</li>		
		<li>
		<a id='option21' class='menu_option' href="javascript:right_load(21,'Search');">Search</a>
		</li><br>
		<li>
		<a id='option22' class='menu_option' href="javascript:right_load(22,'Inventory');">Inventory</a>
		</li>
		</ul>
		<b> All users </b>
		<br>
		<ul>
		<li>
		<a id='report' class='menu_option' href='javascript:report_disp()'>Reports</a><br><br>
			<div id='report_disp' name='report_disp' style='display:none;'>
				&nbsp;&nbsp;<a id='option23' class='menu_option' href="javascript:right_load(23,'DailyReport');">Daily Reports</a><br><br>
				&nbsp;&nbsp;<a id='option24' class='menu_option' href="javascript:right_load(24,'AggReport');">Aggregate Reports</a><br><br>
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
	<h2><u>Lab Configuration</u></h2>
	<h3>Summary</h3>
	<ul>
		<li>Gives a summary of lab setup including the lab personnel accounts, test and specimen types.</li>
	</ul>
	</div>
	
	<div id='Tests_config' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>Tests</h3>
	<p>This has the following options:</p>
	<ul>
		<li>Specimen / Test Types &ndash; This option allows us to configure the Specimens can be collected and Tests that are performed at the particular lab.</li>
		<li>Target TAT &ndash; This option list the turnaround time for each test type. We can modify the TAT using the Edit option and changing the value.</li>
		<li>Results Interpretation &ndash; This option allows us to specify the interpretation for multiple ranges of values for each test type.</li>
	</ul>
	</div>
	
	<div id='IR_rc' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>&nbsp;&nbsp;Reports</h3>
	<h4>&nbsp;&nbsp;&nbsp;&nbsp;Infection Report</h4>
		<ul>
			<li>This is an editable page for setting the infection report parameters.</li>
		</ul>
	</div>	
	
	<div id='DRS_rc' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>&nbsp;&nbsp;Reports</h3>
	<h4>&nbsp;&nbsp;&nbsp;&nbsp;Daily Report Settings</h4>
		<ul>
			<li>This is an editable page for setting the layout of the Patient Report, Daily log of Specimens and Daily log of Patients.</li>
		</ul>
	</div>
	
	<div id='WS_rc' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>&nbsp;&nbsp;Reports</h3>
	<h4>&nbsp;&nbsp;&nbsp;&nbsp;Worksheets</h4>
		<ul>
			<li>This is an editable page for creating custom worksheets.</li>
		</ul>
	</div>
	
	<div id='UserAccounts_config' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>User Accounts</h3>
	<ul>	
		<li>This page gives a summary of the various users given access to the system.</li>
		<li>It also allows for creation of new user accounts.</li>
		<li>It allows to edit account settings, delete accounts and monitor account activity.</li>
	</ul>
	</div>
	
	<div id='RegistrationFields_config' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>Registration Fields</h3>
	<ul>	
		<li>This page allows for the configuration of the patient registration page. It allows for creating mandatory fields and hides certain fields if they are not desired to be filled.</li>
		<li>It also allows for creation of certain custom fields for Patient registration and new Specimen addition which may be needed by certain labs only.</li>
	</ul>
	</div>
	
	<div id='ModLang' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>Modify Language</h3>
	<ul>
		<li>This page allows to toggle between languages (default language is English).</li>
		<li>You can also choose to change the language for a few pages using this option. The pages are listed as a drop-down menu.</li>
	</ul>
	</div>
	
	<div id='SetupNet' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>Setup Network</h3>
	<ul>
			<li>Login as Admin.</li>
			<li>Click on the Setup Network option in the <b>Lab Configuration</b> tab.</li>
	<!--		<li>Pass the generated BlisSetup.html file to the other computers to enable wireless access.</li> -->
			<li>You will now be able to access BLIS by clicking on BlisSetup.html and entering your username and password.</li>
	</ul><br>
			<i>In case of a computer restart or network failure repeat above steps again</i>
	</div>
	
	<div id='Export' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>Export Configuration</h3>
	<ul>
		<li>This option gives the configuration summary for the entire system as a Microsoft Word document.</li>
	</ul>
	</div>
	
	<div id='Backup' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>Backup Data</h3>
	<ul><li>This option allows to take the backup of the system.</li></ul>
	</div>
	
	<div id='Revert' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Lab Configuration</u></h2>
	<h3>Revert to Backup</h3>
	<ul>
		<li>In case of system failure, if we want to revert to a previously backed&ndash;up copy of the data we can use this option.</li>
		<li>A backup of the current system can be taken at this instant (optional)</li>
	</ul>
	</div>
	
	<div id='TestType_tc' class='right_pane' style='display:none;margin-left:10px;'>
		<h2><u>Test Catalog</u></h2>
		<h3>Test Types</h3>
		<ul>
			<li>Gives a complete listing of the available test types.</li>
			<li>We can use this page to edit existing present test types.</li>
			<li>New test types can also be added using the &ldquo;Add New&rdquo; option located near the top of the Page.</li>
		</ul>
	</div>
		
	<div id='SpecimenType_tc' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Test Catalog</u></h2>
	<h3>Specimen Types</h3>
	<ul>
		<li>Gives a complete listing of the available specimen types.</li>
		<li>We can use this page to edit existing specimen types. Tests compatible with a particular specimen type can added/deleted by checking the appropriate boxes located here.</li>
		<li>New specimen types can also be added using the &ldquo;Add New&rdquo; option located near the top of the Page.</li>
	</ul>
	</div>

	<div id='Backup_Data' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Backup</u></h2>
	<ul>
		<li>This option takes a backup of the system and stores it on the local drive. This option is only available to the Admin.</li>
	</ul>	
	</div>
	
	<div id='Registration' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Registration</u></h2>
	<ul>
		<li>This page allows us to register new patients or lookup existing patients based on name, patient ID or number.</li>
		<li>Once a patient has been registered, we can use this page to view,edit the patients profile.</li>
		<li>We can also register a specimen the patient has provided for a particular test.</li>
	</ul>
	</div>
	
	<div id='SSR_r' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Results</u></h2>
	<h3>Single Specimen Results</h3>
		<ul>
			<li>This option allows us to add results for a particular patient based on the specimens he had provided.</li>
		</ul>
	</div>
	
	<div id='BR_r' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Results</u></h2>
	<h3>Batch Results</h3>
		<ul>
			<li>This option allows us to add results for a particular Test Type.</li>
		</ul>
	</div>	
	
	<div id='VR_r' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Results</u></h2>
	<h3>Verify Results</h3>
		<ul>
			<li>This option allows us to verify the result based on the test-type. It shows the list of results for all patients whose results have not been verified. You can modify the results and enter remarks before verifying the results.</li>
		</ul>
	</div>	
	
	<div id='WS_r' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Results</u></h2>
	<h3>Worksheet</h3>
		<ul>
			<li>This option generates a worksheet based on the Lab Section and Test Type. You can also use a custom worksheet which can be created by Admins using Lab Configuration &ndash;&gt; Tests &ndash;&gt; Reports &ndash;&gt; Worksheet.</li>
			<li>You can create a blank worksheet by choosing the Keep Blank option and specifying the number of rows you need.</li>
		</ul>
	</div>	

	<div id='Search' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Search</u></h2>
	<ul>
		<li>This page allows us to search for a particular patient. You can enter a partial name here and it generates a list of patients with matching names.</li>
		<li>You can view the profile of the particular patient you want, check the tests and the results of tests for the patient.</li>
	</ul>
	</div>

	<div id='Inventory' class='right_pane' style='display:none;margin-left:10px;'>
	<h2><u>Inventory</u></h2>
	<ul>
		<li>This page displays the current reagent quantities in stock.</li>
		<li>You can update stock as you acquire new reagents by adding the reagent name,quantity received, receiver name and remarks.</li>
	</ul>
	</div>
	
	<div id='DailyReport' class='right_pane' style='display:none;margin-left:10px;'>
	<h2>Reports</h2>
	<h3>Daily Reports</h3>
		<ul>
			<li>Patient Report &ndash; This option allows us to generate the report for a particular patient based on either, the patient name, patient number or patient id.
			<li>Daily Log &ndash; This option generates a daily of either patient or test records from a particular start date to end date. You can customize the kind of report you want by choosing one option from the Section (e.g. Serology, Hematology) and/or Test type (e.g. ALT/SGPT, HGB) dropdown menus.
		</ul>
	</div>
	
	<div id='AggReport' class='right_pane' style='display:none;margin-left:10px;'>
	<h2>Reports</h2>
	<h3>Aggregate Reports</h3>
		<ul>
			<li>Prevalence Rate &ndash; This report gives the prevalence of a particular infection type based on the number of tests done and the results. You can enter the specified period for which you want to check the prevalence rate of a particular infection. You can also views the Trends of the infection for the defined period, as a graph, by clicking the Trends option when the report is displayed.</li>
			<li>Counts &ndash; This option generates a report for a particular period of time based on the count of tests, specimen or doctor statistics.</li>
			<li>Turnaround Time &ndash;  This option generates the turnaround time for all or chosen test for a particular period of time. It also generates a graph of the statistics. You can choose to include both pending and completed tests or just the completed tests.</li>
			<li>Infection Report &ndash; This option generates an aggregate infection report for a particular period for one or all Lab sections. It also provides an option to create a Word document of the generated report. </li>
			<li>Inventory &ndash; This option generates a listing of the current inventory.</li>
		</ul>
	</div>
	</td>
</tr>
</table>
<?php include("includes/footer.php"); ?>
</body>
</html>