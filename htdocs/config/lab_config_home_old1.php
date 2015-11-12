<?php
#
# Main page for listing all options for a lab configuration
# Used by the Lab Admin periodically to change settings
#

include("redirect.php");
include("includes/new_image.php");
include("includes/header.php");
include("includes/random.php");
include("includes/stats_lib.php");
include("includes/field_order_update.php");

LangUtil::setPageId("lab_config_home");

putUILog('lab_config_home', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$script_elems->enableTableSorter();
$script_elems->enableJQueryForm();


?>


  
  
<script src="js/jquery-ui-1.8.16.js" type="text/javascript"></script>
<link rel="stylesheet" href="css//jquery-ui-1.8.16.css" type="text/css" media="all">

<!-- <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all"> -->
<!-- <link rel="stylesheet" href="/resources/demos/style.css" /> -->
<!-- <script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript" src="js/dialog/jquery.ui.core.js"></script>
	<script type="text/javascript" src="js/dialog/jquery.ui.dialog.js"></script> -->

<div id='Summary_config' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
	<?php 
	if(LangUtil::$pageTerms['TIPS_SUMMARY_1'] != '-') {
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

<div id='Billing_config' class='right_pane' style='display:none;margin-left:10px;'>
    <u>This has the following options</u>
    <ul>
        <li>Enable Billing: Toggles whether or not your lab uses the billing engine.</li>
        <li>Currency Name: Denotes what name will be used when printing monetary amounts in the billing engine.</li>
        <li>Currency Delimiter: Denotes what is used to separate 'dollars' from 
            'cents' when printing monetary amounts in the billing engine.  For example, the '.' in 10.50</li>
    </ul>
</div>

<div id='IR_rc' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_INFECTIONREPORT']; ?></li>
		</ul>
	</div>	
	
	<div id='DRS_rc' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_DAILYREPORTSETTINGS']; ?></li>
		</ul>
	</div>
	
	<div id='WS_rc' class='right_pane' style='display:none;margin-left:10px;'>
		<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_WORKSHEETS']; ?></li>
		</ul>
	</div>
	
	<div id='UserAccounts_config' class='right_pane' style='display:none;margin-left:10px;'>
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

        <!--NC3065-->
        
        <div id='search_config' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>	
		<?php
		
			echo "<li>";
			echo " Toggle Patient Number or Patient's Age to be displayed as part of Search Results";
			echo "</li>";
                        echo "<li>";
			echo " Choosing to display Patient Number and/or Patient's Age as part of Search results slows down the time taken to search ";
			echo "</li>";
                        
                        
		
		?>
	</ul>
	</div>
        
        <div id='barcode_config' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>	
		<?php
		
			echo "<li>";
			echo " Configure your settings for barcode formats";
			echo "</li>";
                        echo "<li>";
			echo " Width and Height are the dimensions of the bars ";
			echo "</li>";
                        echo "<li>";
			echo " Text size os the for the code printed underneath the barcodes";
			echo "</li>";
                       
                        
                        
		
		?>
	</ul>
	</div>
        
        <!---NC3065-->
	
	<div id='SetupNet' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
			<li><?php echo LangUtil::$pageTerms['TIPS_SETUPNETWORK_3']; ?></li>
	</ul><br>
			<i><?php echo LangUtil::$pageTerms['TIPS_SETUPNETWORK_4']; ?></i>
	</div>
	
	<div id='Revert' class='right_pane' style='display:none;margin-left:10px;'>
	<ul>
		<li><?php echo LangUtil::$pageTerms['TIPS_REVERT']; ?></li>
	</ul>
	</div>

<div id='new_help' style='display:none'>
<small>
<u>Add New</u> lets you add new registration fields as required for the lab.
</small>
</div>

<?php

$lab_config_id = $_REQUEST['id'];
$user = get_user_by_id($_SESSION['user_id']);
if ( !((is_country_dir($user)) || (is_super_admin($user)) ) ) {
	$saved_db = DbUtil::switchToGlobal();
	$query = "SELECT lab_config_id FROM lab_config WHERE admin_user_id = ".$_SESSION['user_id'];
	$record = query_associative_one($query);
	$labId = $record['lab_config_id'];
	if($labId != $lab_config_id) {
		echo "You are not authorized to access the configuration";
		include("includes/footer.php");
		die();
	}
	DbUtil::switchRestore($saved_db);
}
//echo "Lab Config Id ".$lab_config_id;
$lab_config = LabConfig::getById($lab_config_id);
//echo "specimen Id ".$lab_config->sid;

if($lab_config == null)
{
	?>
	<br><br>
	<div class='sidetip_nopos'>
	<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
	</div>
	<?php
	include("includes/footer.php");
	return;
}

$field_odering = field_order_update::install_first_order($lab_config);
?>
<style type='text/css'>

	/* body { font-size: 62.5%; } */
  
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  
    /* label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; } */

.range_field {
	width:30px;
}
</style>
<script type='text/javascript'>

<?php $page_elems->getCompatibilityJsArray("st_map", $lab_config_id); ?>

$(document).ready(function(){
        $("#inventory_div").load("view_stocks.php");;
	$("input[name='rage']").change(function() {
		toggle_agegrouplist();
	});
	$('#revert_done_msg').hide();
	$('#cat_code12').change( function() { get_test_types_bycat() });
	get_test_types_bycat
	<?php
	if(isset($_REQUEST['show_u']))
	{
		# Preload user accounts pane
		?>
		right_load(3, 'users_div');
		<?php		
	}
	else if(isset($_REQUEST['show_f']))
	{
		# Preload custom fields pane
		?>
		right_load(4, 'fields_div');
		<?php
	}
	else if(isset($_REQUEST['show_i']))
	{
		# Preload the inventory pane
		?>
		right_load(15, 'inventory_div');
		<?
	}
	else if(isset($_REQUEST['set_locale']))
	{
		$locale = $_REQUEST['locale'];
		?>
		language_div_load();
		<?php
	}
	else
	{
		$locale = $_SESSION['locale'];
		?>
		right_load(1, 'site_info_div');
		<?php
	}
	
	if(isset($_REQUEST['aupdate']))
	{
		# Show user account updated message
		?>
		$('#user_acc_msg').html("'<?php echo $_REQUEST['aupdate']; ?>' - <?php echo LangUtil::$generalTerms['MSG_ACC_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('user_acc_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#user_acc_msg').show();
		<?php
	}
	else if(isset($_REQUEST['adel']))
	{
		# Show user account deleted message
		?>
		$('#user_acc_msg').html("<?php echo LangUtil::$generalTerms['MSG_ACC_DELETED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('user_acc_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#user_acc_msg').show();
		<?php
	}
	else if(isset($_REQUEST['aadd']))
	{
		# Show user account added message
		?>
		$('#user_acc_msg').html("'<?php echo $_REQUEST['aadd']; ?>' - <?php echo LangUtil::$generalTerms['MSG_ACC_ADDED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('user_acc_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#user_acc_msg').show();
		<?php
	}
	else if(isset($_REQUEST['tupdate']))
	{
		# Show TAT values updated message
		?>
		$('#tat_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('tat_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#tat_msg').show();
		right_load(5, 'target_tat_div');
		<?php
	}
	else if(isset($_REQUEST['fupdate']))
	{
		# Show custom field updated message
		?>
		$('#cfield_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('cfield_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#cfield_msg').show();
		right_load(4, 'fields_div');
		<?php
	}
	else if(isset($_REQUEST['fadd']))
	{
		# Show custom field added message
		?>
		$('#cfield_msg').html("<?php echo LangUtil::$generalTerms['MSG_ADDED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('cfield_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#cfield_msg').show();
		right_load(4, 'fields_div');
		<?php
	}
	else if(isset($_REQUEST['stupdate']))
	{
		# Show custom field updated message
		?>
		$('#sttypes_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('sttypes_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#sttypes_msg').show();
		right_load(2, 'st_types_div');
		<?php
	}
        else if(isset($_REQUEST['billingupdate']))
        {
                ?>
                $('#billing_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('billing_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#billing_msg').show();
                right_load(22, 'billing_div');
                <?php
        }
        
        else if(isset($_REQUEST['addedCurrency']))
        {
        	?>
                $('#billing_msg').html("New Currecy added. &nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('billing_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
        		$('#billing_msg').show();
                right_load(22, 'billing_div');
            <?php
         }
	else if(isset($_REQUEST['adupdate']))
	{
		# Show custom field updated message
		?>
		$('#admin_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('admin_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#admin_msg').show();
		right_load(7, 'change_admin_div');
		<?php
	}
	else if(isset($_REQUEST['aggupdate']))
	{
		# Show custom field updated message
		?>
		$('#agg_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('agg_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#agg_msg').show();
		right_load(8, 'agg_report_div');
		<?php
	}
        else if(isset($_REQUEST['grouped_count_update']))
	{
		# Show custom field updated message
		?>
		$('#grouped_count_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('grouped_count_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#grouped_count_msg').show();
		right_load(36, 'grouped_count_div');
		<?php
	}
	else if(isset($_REQUEST['miscupdate']))
	{
		# Show general settings updated message
		?>
		$('#misc_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('misc_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#misc_msg').show();
		right_load(9, 'misc_div');
		<?php
	}
	else if(isset($_REQUEST['langupd']))
	{
		# Show locale updated message
		?>
		$('#main_msg').html("<?php echo LangUtil::$pageTerms['MSG_LANGUPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('main_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#main_msg').show();
		<?php
	}
	else if(isset($_REQUEST['ofupdate']))
	{
		# Show other fields updated message
		?>
		$('#cfield_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('cfield_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#cfield_msg').show();
		right_load(4, 'fields_div');
		<?php
	}
        //NC3065
        else if(isset($_REQUEST['sfcupdate']))
	{
		# Show other fields updated message
		?>
		$('#searchfield_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('searchfield_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#searchfield_msg').show();
		right_load(21, 'search_div');
		<?php
	}
        else if(isset($_REQUEST['brcupdate']))
	{
		# Show other fields updated message
		?>
		$('#barcodefield_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('barcodefield_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#barcodefield_msg').show();
		right_load(28, 'barcode_div');
		<?php
	}
        //-NC3065
	else if(isset($_REQUEST['rcfgupdate']))
	{
		# Show report config updated message
		?>
		$('#report_config_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('report_config_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#report_config_msg').show();
		var report_type=<?php echo $_REQUEST['rcfgupdate']; ?>;
		right_load(11, 'report_config_div');
		$('#report_type11').attr("value", report_type);
		//fetch_report_config();
		fetch_report_summary();
		<?php
	}
	else if(isset($_REQUEST['wcfgupdate']))
	{
		# Show report config updated message
		?>
		$('#worksheet_config_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('worksheet_config_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#worksheet_config_msg').show();
		<?php 
		$post_parts = explode(",", $_REQUEST['wcfgupdate']); 
		?>
		right_load(12, 'worksheet_config_div');
		$('#cat_code12').attr("value", "<?php echo $post_parts[0]; ?>");
		$('#test_type12').attr("value", "<?php echo $post_parts[1]; ?>");
		fetch_worksheet_summary();
		<?php
	}
        else if(isset($_REQUEST['importupdate']))
	{
		# Show report config updated message
		?>
		$('#worksheet_config_msg').html("<?php echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('worksheet_config_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
		$('#worksheet_config_msg').show();
		<?php 
		$post_parts = explode(",", $_REQUEST['wcfgupdate']); 
		?>
		right_load(12, 'worksheet_config_div');
		$('#cat_code12').attr("value", "<?php echo $post_parts[0]; ?>");
		$('#test_type12').attr("value", "<?php echo $post_parts[1]; ?>");
		fetch_worksheet_summary();
		<?php
	}
	else if( isset($_REQUEST['revert']) ) {
		if( isset($_REQUEST['updateChange'])) { ?>
			right_load(18, 'update_database_div');
			<?php 
				if($_REQUEST['revert'] == 1) { ?>
					$('#update_success').show();
				<?php } else { ?>
					$('#update_failure').show();
			<?php }
		} else { ?>
			right_load(13, 'backup_revert_div');
			<?php if($_REQUEST['revert'] == 1) { ?>
				//$('#backup_revert_msg').html("<?php #echo LangUtil::$generalTerms['MSG_UPDATED']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('backup_revert_msg');\"><?php #echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
				$('#revert_done_msg').show();
				<?php
				} else { ?>
					$('#backup_revert_msg').html("<?php echo LangUtil::$generalTerms['ERROR']; ?>&nbsp;&nbsp;&nbsp;<a href=\"javascript:toggle('backup_revert_msg');\"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>");
					$('#backup_revert_msg').show();
				<?php
				}
		}
	}
	?>
	$('#lab_admin').attr("value", "<?php echo $lab_config->adminUserId; ?>");
	/*$('.stype_entry').change(function() {
		check_compatible();
	});
	*/
	$('.dboption').change(function() {
		toggle_dboption_help();
	});
	stype_toggle();
});

function performDbUpdate() {
	$.ajax({
		type : 'POST',
		url : 'update/updateDB.php',
		success : function (param) {
			$('#updating').hide();
			if ( param=="true" ) {
				$('#updateSuccess').show();
				setTimeout("location.href='home.php'",5000);
			} else {
				$('#updateFailure').show();
			}
		}
	});
}

function add_new_currency_ratio(action){
	if(action == 1){
		var defaultCurrency = $("#default_currency").val();
		var addedCurrency=$("#added_currency").val();
		var exchangeRate = $("#added_currency_rate").val();
		var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
		if(exchangeRate == '' || !numberRegex.test(exchangeRate)){
			alert("Enter a valid exchange rate");
			return;
		}
		var url_string = "ajax/add_currency_rate.php?lid=<?php echo $lab_config->id; ?>&defaultCurrency="+
		defaultCurrency+"&secondaryCurrency="+addedCurrency+"&exchangeRate="+exchangeRate;
		var reload_url = "lab_config_home.php?id=<?php echo $lab_config_id; ?>&billingupdate=1";
		$.ajax({ url: url_string, async: false, success: function() {
			window.location=reload_url;
		}});
	} else {
		$("#addCurrencyRatioDiv").hide();
	}
}

function get_testbox2(stype_id)
{
	//var stype_val = $('#'+stype_id).attr("value");
        var stype_val = stype_id;
        $('#test_list_by_site').show();
	if(stype_val == "")
	{
		$('#test_list_by_site').html("-<?php echo 'Select Facility to display its Test Catalog here'; ?>-");
		return;
	}
	$('#test_list_by_site').html("<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>");
	$('#test_list_by_site').load(
		"ajax/test_list_by_site.php", 
		{
			site_id: stype_val
		}
	);
}

function toggle_div(div_name) {
	$("#"+div_name).hide();
}

function inventory_load()
{
    //$("#inventory_div").load("view_stock.php");
    right_load(15, 'inventory_div');
}

function performUpdate()
{
	$('#updating').show();
	$.ajax({
		type : 'POST',
		url : 'ajax/update.php',
		success : function(data) {
			if ( data=="true" ) {
				performDbUpdate();
			}
			else {
				$('#updating').hide();
				$('#updateFailure').show();
			}
		}
	});
}

function test_setup()
{
if(document.getElementById('test_setup').style.display =='none')
$('#test_setup').show();
else
$('#test_setup').hide();
}

function report_setup()
{
if(document.getElementById('report_setup').style.display =='none')
$('#report_setup').show();
else
$('#report_setup').hide();

}

function check_compatible()
{
}

function blis_update_t()
{
    $('#update_button').hide();
    $('#update_spinner').show();
    setTimeout( "blis_update();", 5000); 
}

function blis_update()
{
    
    $.ajax({
		type : 'POST',
		url : 'update/blis_update.php',
		success : function(data) {
			if ( data=="true" ) {
                            $('#update_failure').hide();
                            $('#update_spinner').hide();
                            $('#update_success').show();
			}
			else {
                                $('#update_success').hide();

                                $('#update_spinner').hide();
				$('#update_failure').show();
			}
		}
	});
        
    $('#update_button').show();
}

function right_load(option_num, div_id)
{
	$('#name9').attr("value", "<?php echo $lab_config->name; ?>");
	$('#loc9').attr("value", "<?php echo $lab_config->location; ?>");
	$('#misc_errormsg').hide();
	$('.right_pane').hide();
	$('.menu_option').removeClass('current_menu_option');
	$('#'+div_id).show();
	$('#option'+option_num).addClass('current_menu_option');
	if ( option_num == 16 ) {
		//performUpdate();
	}
}

function language_div_load() {
	$('#misc_errormsg').hide();
	$('.right_pane').hide();
	$('.menu_option').removeClass('current_menu_option');
	$('#language_div').show();
	$('#option19').addClass('current_menu_option');
}

function export_html()
{
<?php
$myFile = "../../BlisSetup.html";
$fh = fopen($myFile, 'w') or die("can't open file");
$content =('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<META HTTP-EQUIV="Refresh"
CONTENT="1; URL=');
$content1=('">
</head> 
</html>');
$content=$content.StatsLib::get_ip().$content1;
fwrite($fh, $content);
fclose($fh);
?>
right_load(14, 'network_setup_div');
}
function ask_to_delete_user(user_id)
{
	var div_id = 'delete_confirm_'+user_id;
	$('#'+div_id).show();
}

function delete_user(user_id)
{
	var url_string = "ajax/lab_user_delete.php?uid="+user_id;
	var reload_url = "lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_u=1&adel=1";
	$.ajax({ url: url_string, async: false, success: function() {
		window.location=reload_url;
	}});
}

function submit_goal_tat()
{
	$('#tat_progress_spinner').show();
	$('#goal_tat_form').ajaxSubmit({
		success: function() {
			$('#tat_progress_spinner').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&tupdate=1";
		}
	});
}

function toggletatdivs()
{
	$('#goal_tat_list').toggle();
	$('#goal_tat_form').toggle();
	var curr_link_text = $('#toggletat_link').html();
	if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
		$('#toggletat_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
	else
		$('#toggletat_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
}

function updateCurrencyRatio(row_id)
{
	var defaultCurrency = $("#default_currency").val();
	var secondaryCurrency= $("#currency"+row_id).text();
	var exchangeRate = $("#exchangeRate"+row_id).val();

	var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
	if(exchangeRate == '' || !numberRegex.test(exchangeRate)){
		alert("Enter a valid exchange rate");
		return;
	}
	
	var url_string = "ajax/add_currency_rate.php?lid=<?php echo $lab_config->id; ?>&defaultCurrency="+
	defaultCurrency+"&secondaryCurrency="+secondaryCurrency+"&exchangeRate="+exchangeRate;
	var reload_url = "lab_config_home.php?id=<?php echo $lab_config_id; ?>&billingupdate=1";
	$.ajax({ url: url_string, async: false, success: function() {
		window.location=reload_url;
	}});
}

function deleteCurrencyRatio(row_id)
{
	var defaultCurrency = $("#default_currency").val();
	var secondaryCurrency= $("#currency"+row_id).text();
	
	var url_string = "ajax/delete_currency_rate.php?lid=<?php echo $lab_config->id; ?>&defaultCurrency="+
	defaultCurrency+"&secondaryCurrency="+secondaryCurrency;
	var reload_url = "lab_config_home.php?id=<?php echo $lab_config_id; ?>&billingupdate=1";
	$.ajax({ url: url_string, async: false, success: function() {
		window.location=reload_url;
	}});
}

function addCurrencyRatio()
{
	$("#addCurrencyRatioDiv").show();
}

function toggle_disease_report()
{
	$('#agg_report_summary').toggle();
	$('#agg_report_form_div').toggle();
	var curr_link_text = $('#agg_edit_link').html();
	if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
		$('#agg_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
	else
		$('#agg_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
}


function toggle_grouped_count_report()
{
	$('#grouped_count_report_summary').toggle();
	$('#grouped_count_report_form_div').toggle();
	var curr_link_text = $('#grouped_count_edit_link').html();
	if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
		$('#grouped_count_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
	else
		$('#grouped_count_edit_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
}


function toggle_ofield_div()
{
	$('#ofield_summary').toggle();
	$('#ofield_form_div').toggle();
	var curr_link_text = $('#ofield_toggle_link').html();
	if(curr_link_text == "<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>")
		{
		 $('#ofield_toggle_link').html("<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>");
		 $('#field_reorder_link').show();
		}
	else{
		$('#ofield_toggle_link').html("<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>");
		$('#field_reorder_link').show();
	 }
}


$(function() {
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    var name = $( "#name" ),
        email = $( "#email" ),
        password = $( "#password" ),
        allFields = $( [] ).add( name ).add( email ).add( password ),
        tips = $( ".validateTips" );

    $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 500,
        width: 500,
        modal: true,
        buttons: {
            "Update Field Order": function() {
                var index = 0;
				var orders = "";
				$('#sortable li').each(function(){
					var $this = $(this);
					index++;
					var field_name = $this.text();
					orders = orders+field_name.replace(/\s+/g,"")+"="+index+"&";
				});
				orders = orders.match(/(.*).$/)[1];
   		  	 
				$.ajax({
					url : "ajax/process-field-ordering.php?"+orders,
					async: false,
					success : function(data) {
						alert("Field Order Updated");
						window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>";
					}	
				});
   		     
				},
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });

    $( "#field_reorder_link" ).click(function() {
            $( "#dialog-form" ).dialog( "open" );
        });

    
    $("#sortable").sortable({
        update : function () {
        	 
        	}
      	});
    $( "#sortable" ).disableSelection();
    
});

function add_new_currency(action)
{
	if(action == 1){
	$('#new_currency').show();
	$('#add_new_currency_link').hide();
	} else {
	$('#new_currency').hide();
	$('#add_new_currency_link').show();
	}
}

function stype_toggle()
{
	$('#stype_box').toggle();
	if($('#stype_link').html() == "Show")
	{
		$('#stype_link').html("Hide");		
	}
	else
	{
		$('#stype_link').html("Show");
	}
}

function ttype_toggle()
{
	$('#ttype_box').toggle();
	if($('#ttype_link').html() == "Show")
	{
		$('#ttype_link').html("Hide");		
	}
	else
	{
		$('#ttype_link').html("Show");
	}
}

function checkandsubmit_st_types()
{
	//Validate
	var stype_entries = $('.stype_entry');
	var stype_selected = false;
	for(var i = 0; i < stype_entries.length; i++)
	{
		if(stype_entries[i].checked)
		{
			stype_selected = true;
			break;
		}
	}
	if(stype_selected == false)
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_SPECIMENSNOTSELECTED']; ?>");
		return;
	}
	var ttype_entries = $('.ttype_entry');
	var ttype_selected = false;
	for(var i = 0; i < ttype_entries.length; i++)
	{
		if(ttype_entries[i].checked)
		{
			ttype_selected = true;
			break;
		}
	}
	if(ttype_selected == false)
	{
		alert("<?php echo LangUtil::$pageTerms['TIPS_TESTSNOTSELECTED']; ?>");
		return;
	}
	//All okay
	$('#st_types_progress').show();
	$('#st_types_form').ajaxSubmit({success:function(){
			$('#st_types_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&stupdate=1";
		}
	});
}

function submit_billing_update()
{
        //Submit stuff to the db here.
        $('#billing_progress').show();
	$('#billing_form').ajaxSubmit({success:function(){
			$('#billing_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&billingupdate=1";
		}
	});
}


function submit_new_currency()
        //Submit stuff to the db here.
{
        $('#billing_progress').show();
        var newCurrency = $('#new_currency_name').val();
        if(newCurrency == '' || newCurrency == undefined || newCurrency.length == 0){
			alert("Enter a currency name to be added");
			return;
        }

        var url_string ='ajax/lab_config_addCurrency.php?id=<?php echo $lab_config->id; ?>&currencyName='+newCurrency;
        $.ajax({
    		url : url_string,
    		async: false,
    		success : function(data) {
    			if ( data.indexOf("true") >= 0 ) {
    				$('#billing_progress').hide();
    				window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&addedCurrency=1";
    			}
    			else {
    				$('#billing_progress').hide();
    				alert("Currency already exists. Enter a different currency name");	
    			}
    		}
    	});
}

function cancel_new_currency(){
	
}

function delete_config()
{
	var url_string ='ajax/lab_config_delete.php?id=<?php echo $lab_config->id; ?>';
	$.ajax({ url: url_string, async: false, success: function(){
			window.location="lab_configs.php?msg=<?php echo base64_encode($lab_config->getSiteName()." deleted"); ?>";
		}
	});
}

function change_admin()
{
	var admin_user_id = $('#lab_admin').attr('value');
	var url_string = 'ajax/lab_admin_change.php?lid=<?php echo $lab_config->id; ?>&uid='+admin_user_id;
	$.ajax({ url: url_string, async: false, success: function(){
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&adupdate=1";
		}
	});
}

function agg_checkandsubmit()
{
	//Validate
	//TODO
	//All okay
	$('#agg_progress_spinner').show();
	$('#agg_report_form').ajaxSubmit({
		success: function() {
			$('#agg_progress_spinner').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&aggupdate=1";
		}
	});
}

function grouped_checkandsubmit()
{
	//Validate
	//TODO
	//All okay
	$('#grouped_count_progress_spinner').show();
	$('#grouped_count_report_form').ajaxSubmit({
		success: function() {
			$('#grouped_count_progress_spinner').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&grouped_count_update=1";
		}
	});
}

function agg_preview()
{
	// Shows preview of infection report in a separate window
	// Clone fields from disease report form to preview form
	$('#agg_preview_form').html($('#agg_report_form').clone(true).html());
	$('#agg_preview_form').submit();
}

function toggle_agegrouplist()
{
	$('#agegrouprow').toggle();
}

function agegrouplist_append()
{
	var html_code = "&nbsp;&nbsp;<input type='text' name='age_l[]' class='range_field'></input>-<input type='text' name='age_u[]' class='range_field'></input>";
	$('#agegrouplist_inner').append(html_code);
}

function t_agegrouplist_append()
{
	var html_code = "&nbsp;&nbsp;<input type='text' name='age_l[]' class='range_field'></input>-<input type='text' name='age_u[]' class='range_field'></input>";
	$('#t_agegrouplist_inner').append(html_code);
}

function s_agegrouplist_append()
{
	var html_code = "&nbsp;&nbsp;<input type='text' name='sp_age_l[]' class='range_field'></input>-<input type='text' name='sp_age_u[]' class='range_field'></input>";
	$('#s_agegrouplist_inner').append(html_code);
}

function add_slot(span_id, field_name1, field_name2)
{
	var html_code = "&nbsp;&nbsp;&nbsp;<input type='text' class='range_field' name='"+field_name1+"[]' value=''></input>-<input type='text' class='range_field' name='"+field_name2+"[]' value=''></input>";
	$('#'+span_id).append(html_code);
}

function misc_checkandsubmit()
{
	//Validate
	$('#misc_errormsg').html("");
	$('#misc_errormsg').hide();
	var name = $('#name9').attr("value");
	var location = $('#loc9').attr("value");
	var err_msg = "";
	if(name.trim() == "")
		err_msg = "<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>";
	else if(location.trim() == "")
		err_msg = "<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>";
	if(err_msg != "")
	{
		$('#misc_errormsg').html(err_msg);
		$('#misc_errormsg').show();
		return;
	}	
	//All okay
	$('#misc_progress').show();
	$('#misc_form').submit();
	/*
	$('#misc_form').ajaxSubmit({
		success: function() {
			$('#misc_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&miscupdate=1";
		}
	});
	*/
}

function toggle_dboption_help()
{
	var dboption_val = $("input[name='dboption']:checked").attr("value");
	$('.dboption_help').hide();
	$('.random_params').hide();
	if(dboption_val != 0)
	{
		$('#dboption_help_'+dboption_val).show();
	}
	if(dboption_val == 1)
	{
		$('.random_params').show();
	}
}

function submit_otherfields()
{
	$('#otherfields_progress').show();
	$('#otherfields_form').ajaxSubmit({
		success: function() {
			$('#otherfields_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&ofupdate=1";
		}
	});
}

//NC3065
function submit_searchconfig()
{
	$('#searchfields_progress').show();
	$('#searchfields_form').ajaxSubmit({
		success: function() {
			$('#searchfields_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&sfcupdate=1";
		}
	});
}
function submit_barcodeconfig()
{
	$('#barcodefields_progress').show();
	$('#barcodefields_form').ajaxSubmit({
		success: function() {
			$('#barcodefields_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&brcupdate=1";
		}
	});
}
//-NC3065

function backup_data()
{
	var r=confirm("Do you want to backup?");
	if(r==true)
		$('#backup_form').submit();
	else
		{}
}

function fetch_report_config()
{
	var report_type = $("#report_type11").attr("value");
	var url_string = "ajax/report_config_fetch.php?l=<?php echo $lab_config->id; ?>&rt="+report_type;
	$('#report_config_fetch_progress').show();
	$('#report_config_content').load(url_string, function() {
		$('#report_config_fetch_progress').hide();
	});
}

function hide_report_config()
{
	$('#report_config_content').html("");
}


function fetch_report_summary()
{
	var report_type = $("#report_type11").attr("value");
	var url_string = "ajax/report_config_summary.php?l=<?php echo $lab_config->id; ?>&rt="+report_type;
	$('#report_config_fetch_progress').show();
	$('#report_config_content').load(url_string, function() {
		$('#report_config_fetch_progress').hide();
	});
}

function update_file()
{ 
var report_id = $('#report_type11').attr("value");
	$('#submit_report_config_progress').show();
	$('#report_config_submit_form').ajaxSubmit({
		success: function() {
			$('#submit_report_config_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&rcfgupdate="+report_id;
		}
	});
}
 function update_report_config()
{ 
	var report_id = $('#report_type11').attr("value");
	$('#submit_report_config_progress').show();
	$('#report_config_submit_form').ajaxSubmit({
		success: function() {
		$('#submit_report_config_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&rcfgupdate="+report_id;
		}
	});
}

function get_test_types_bycat()
{
	var cat_code = $('#cat_code12').attr("value");
	var location_code = <?php echo $lab_config->id; ?>;
	$('#test_type12').load('ajax/tests_selectbycat.php?c='+cat_code+'&l='+location_code+'&all_no');
}

function fetch_worksheet_config()
{
	var cat_code = $('#cat_code12').attr("value");
	var t_type = $('#test_type12').attr("value");
	var url_string = "ajax/worksheet_config_fetch.php?l=<?php echo $lab_config->id; ?>&c="+cat_code+"&t="+t_type;
	$('#worksheet_fetch_progress').show();
	$('#worksheet_config_content').load(url_string, function() {
		$('#worksheet_fetch_progress').hide();
	});
}

function hide_worksheet_config()
{
	$('#worksheet_config_content').html("");
}

function fetch_worksheet_summary()
{
	var cat_code = $('#cat_code12').attr("value");
	var t_type = $('#test_type12').attr("value");
	var url_string = "ajax/worksheet_config_summary.php?l=<?php echo $lab_config->id; ?>&c="+cat_code+"&t="+t_type;
	$('#worksheet_fetch_progress').show();
	$('#worksheet_config_content').load(url_string, function() {
		$('#worksheet_fetch_progress').hide();
	});
}

function update_worksheet_config()
{
	var cat_code = $('#cat_code12').attr("value");
	var t_type = $('#test_type12').attr("value");
	$('#submit_worksheet_config_progress').show();
	$('#worksheet_config_submit_form').ajaxSubmit({
		success: function() {
			$('#submit_worksheet_config_progress').hide();
			window.location="lab_config_home.php?id=<?php echo $lab_config->id; ?>&wcfgupdate="+cat_code+","+t_type;
		}
	});
}

function backup_revert_submit()
{
	// Validate
	// All okay
	$('#backup_revert_progress').show();
	$('#backup_revert_form').submit();
}

function update_database_submit() {
	$('#update_database_progress').show();
	$('#update_database_form').ajaxSubmit(function success(data) {
		window.location = data;
	});

}

function add_title_line()
{
	var html_code = "<input type='text' name='title[]' value='' class='uniform_width_more'></input><br>";
	$('#title_lines').append(html_code);
}

function right_load_1(option_num, div_id)
{
//	$('#misc_errormsg').hide();
	$('.right_pane').hide();
	$('.menu_option').removeClass('current_menu_option');
	$('#'+div_id).show();
	$('#option'+option_num).addClass('current_menu_option');
	
}
</script>

<br>

<table>
	<tbody>
		<tr valign='top'>
			<td class='left_menu' id='left_pane' width='160px'><ul>
				<a id='option1' class='menu_option' href="javascript:right_load(1, 'site_info_div');"><?php echo LangUtil::$pageTerms['MENU_SUMMARY']; ?></a>
				<br>
				
				<?php
				# If super-admin or country-dir, show option to Delete this configuration
				# If super-admin or country-dir, show option to Change lab manager/admin
				# If super-admin or country-dir, show option to Back up Data
				# For lab admin, the option appears as a separate tab
				$user = get_user_by_id($_SESSION['user_id']);
				if(is_super_admin($user) || is_country_dir($user)) {			
					?>
					<br>
					<a id='option9' class='menu_option' href="javascript:right_load(9, 'misc_div');"><?php echo LangUtil::$pageTerms['MENU_GENERAL']; ?></a>
					<br><br>
					<a id='option7' class='menu_option' href="javascript:right_load(7, 'change_admin_div');"><?php echo LangUtil::$pageTerms['MENU_MGR']; ?></a>
					<br><br>
					<a id='option6' class='menu_option' href="javascript:right_load(6, 'del_config_div');"><?php echo LangUtil::$pageTerms['MENU_DEL']; ?></a></li>
					<br>
					<?php					
				}
				?>
				<br>
				
				<a id='test' class='menu_option' href="javascript:test_setup();"><?php echo LangUtil::$pageTerms['Tests']; ?> </a>
				<br><br>
				<div id='test_setup' name='test_setup' style='display:none;'>
					-<a id='option2' class='menu_option' href="javascript:right_load(2, 'st_types_div');"><?php echo LangUtil::$pageTerms['MENU_ST_TYPES']; ?></a>
					</li><br><br>
					-<a id='option5' class='menu_option' href="javascript:right_load(5, 'target_tat_div');"><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></a>
					</li><br><br>
					-<a href='remarks_edit.php?id=<?php echo $_REQUEST['id']; ?>'><?php echo "Results Interpretation"; ?></a>
					<br><br>
				</div>
                                
                                <a id='option21' class='menu_option' href="javascript:right_load(21, 'search_div');"><?php echo "Search" ?></a>
                                <br><br>
                                
				<a id='report' class='menu_option' href="javascript:report_setup();"><?php echo LangUtil::$pageTerms['Reports']; ?> </a>
				<br><br></li>
				<div id='report_setup' name='report_setup' style='display:none;'>
					-<a id='option8' class='menu_option' href="javascript:right_load(8, 'agg_report_div');"><?php echo LangUtil::$pageTerms['MENU_INFECTION']; ?></a>
					<br><br>
                    -<a id='option36' class='menu_option' href="javascript:right_load(36, 'grouped_count_div');"><?php echo "Test/Specimen Grouped Reports"; ?></a>
					<br><br>
					-<a id='option11' class='menu_option' href="javascript:right_load(11, 'report_config_div');"><?php echo LangUtil::$pageTerms['MENU_REPORTCONFIG']; ?></a>
					<br><br>
					-<a id='option12' class='menu_option' href="javascript:right_load(12, 'worksheet_config_div');"><?php echo LangUtil::$pageTerms['MENU_WORKSHEETCONFIG']; ?></a>
					<br><br>
				</div>

				<a id='option15' class='menu_option' href="javascript:right_load(15, 'inventory_div');"><?php echo LangUtil::$pageTerms['Inventory']; ?></a>
				<br><br>
				<a id='option28' class='menu_option' href="javascript:right_load(28, 'barcode_div');"><?php echo "Barcode Settings"; ?></a>
				<br><br>
                                <a id='option22' class='menu_option' href="javascript:right_load(22, 'billing_div');"><?php echo "Billing"; ?></a>
				<br><br>
				<a id='option3' class='menu_option' href="javascript:right_load(3, 'users_div');"><?php echo LangUtil::$pageTerms['MENU_USERS']; ?></a>
				<br><br>
				<a id='option4' class='menu_option' href="javascript:right_load(4, 'fields_div');"><?php echo LangUtil::$pageTerms['MENU_CUSTOM']; ?></a>
				<br><br>
							
				<a id='option19' class='menu_option' href="javascript:language_div_load();"><?php echo LangUtil::getPageTerm("MODIFYLANG"); ?></a>
				<br><br>
				<a id='option14' class='menu_option' href="javascript:export_html();"><?php echo "Setup Network" ?></a>
				<br><br>
				
				<?php
					if($SERVER != $ON_ARC) {
						?>
						<a id='option13' class='menu_option' href="javascript:right_load(13, 'backup_revert_div');"><?php echo LangUtil::$pageTerms['MENU_BACKUP_REVERT']; ?></a><br><br></li>
						<?php if(is_super_admin($user) || is_country_dir($user)) { ?>
								<a id='option18' class='menu_option' href="javascript:right_load(18, 'update_database_div');"><?php echo 'Update Data'; ?></a><br><br></li>
                                                                <a id='option34' class='menu_option' href="javascript:right_load(34, 'import_config_div');"><?php echo 'Import Configuration' ?></a><br><br></li>

						<?php }
					}
				?>
				
				<a href='export_config?id=<?php echo $_REQUEST['id']; ?>' target='_blank'><?php echo LangUtil::$pageTerms['MENU_EXPORTCONFIG']; ?></a><br><br></li>
                                <div id="old_update_div" style="display:none;">
				<a id='option39' class='menu_option' href="javascript:right_load(39, 'blis_update_div');">Update to New Version</a>
				<br><br>
				</div>
				<?php /* Enable for Data Merging
				<a rel='facebox' id='option18' class='menu_option' href="updateCountryDbAtLocalUI.php">Update National Database</a>
				</ul>
				*/ ?>
			</td>
			<td>
				<br><br><br><br><br>
			</td>
			<td>
				<div class='right_pane' id='site_info_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#Summary_config'>Page Help</a></p>
				<b><?php echo LangUtil::$pageTerms['MENU_SUMMARY']; ?></b>
					<br><br>
					<div id='main_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<?php
					$page_elems->getLabConfigInfo($lab_config->id);
					?>
					<form id='backup_form' name='backup_form' action='data_backup' method='post' target='_blank'>
						<input type='hidden' name='id' value='<?php echo $_REQUEST['id']; ?>'></input>
					</form>
				</div>
                            
                                <div class='right_pane' id='blis_update_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#Summary_config'>Page Help</a></p>
				<b><?php echo "BLIS Update"; ?></b>
					<br><br>
                                        <input type="Button" id="update_button" name="update_button" value="Start Update" onclick="javascript:blis_update_t()"/>
                                        <br>
                                        <div id='update_spinner' style='display:none;'>
                                        <?php
					$spinner_message = "Updating to C4G BLIS v2.2"."<br>";
                                        $page_elems->getProgressSpinnerBig($spinner_message);
                                        ?>
                                        </div>
                                        <br>
                                        <div id='update_success' class='clean-orange' style='display:none;width:350px;'>
                                            Update to v2.2 Successful!
                                        </div>
                                        <div id='update_failure' class='clean-error' style='display:none;width:350px;'>
                                            Update to v2.2 Failed! Try Again.
                                        </div>
				</div>
				
				<div class='right_pane' id='st_types_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#Tests_config'>Page Help</a></p>
					<b><?php echo LangUtil::$pageTerms['MENU_ST_TYPES']; ?></b>
					<br><br>
					<div id='sttypes_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<form id='st_types_form' name='st_types_form' action='ajax/st_types_update.php' method='post'>
					<input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>					
					<?php echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?>
					<small><a id='stype_link' href='javascript:stype_toggle();'><?php echo LangUtil::$generalTerms['CMD_SHOW']; ?></a></small>
					<div class='pretty_box' id='stype_box' style='display:none'>
					<b><u><?php echo LangUtil::$generalTerms['SPECIMEN_TYPES']; ?></u></b>
						<?php $page_elems->getSpecimenTypeCheckboxes($lab_config->id); ?>
					</div>
					<br>
					<br>
					<?php echo LangUtil::$generalTerms['TEST_TYPES']; ?>
					<small><a id='ttype_link' href='javascript:ttype_toggle();'><?php echo LangUtil::$generalTerms['CMD_SHOW']; ?></a></small>
					<div class='pretty_box' id='ttype_box' style='display:none'>
					<b><u><?php echo LangUtil::$generalTerms['TEST_TYPES']; ?></u></b>
                                        
                                        <?php
                                        //NC3065
                                        
                                        $user = get_user_by_id($_SESSION['user_id']);
                                        if(is_super_admin($user) || is_country_dir($user))
                                        {
                                            $page_elems->getTestTypeCheckboxes_dir($lab_config->id);
                                        }
                                        else
                                        {
                                            $page_elems->getTestTypeCheckboxes($lab_config->id); 
                                        }
                                        //NC3065
					?>
                                        
                                         <?php //$page_elems->getTestTypeCheckboxes($lab_config->id); ?>
                                        
					</div>
					<br><br>
					<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='checkandsubmit_st_types()'>
					</input>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<span id='st_types_progress' style='display:none;'>
                                  
						<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
					</form>
				</div>
			
                                <!--NC3065-->
                                
                                <div class='right_pane' id='search_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#search_config'>Page Help</a></p>
					<b><?php echo "Configure Fields for search results"; ?></b>
					<br><br>
                                        <div id='searchfield_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<form id='searchfields_form' name='searchfields_form' action='ajax/search_config_update.php' method='post'>
					<input type='hidden' name='lab_config_id' value='<?php echo $lab_config->id; ?>'></input>					
						<?php $page_elems->getSearchFieldsCheckboxes($lab_config->id); ?>
					<br><br>
					<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='submit_searchconfig()'>
					</input>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<!--span id='st_types_progress' style='display:none;'-->
                                        <span id='searchfields_progress' style='display:none;'>

						<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
					</form>
				</div>
                                
                                <div class='right_pane' id='barcode_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#barcode_config'>Page Help</a></p>
					<b><?php echo "Configure Barcode Format Settings"; ?></b>
					<br><br>
                                        <div id='barcodefield_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<form id='barcodefields_form' name='barcodefields_form' action='ajax/update_barcode_settings.php' method='post'>
					<input type='hidden' name='lab_config_id' value='<?php echo $lab_config->id; ?>'></input>					
						<?php $page_elems->getBarcodeFields($lab_config->id);
                                                //$page_elems->getSearchFieldsCheckboxes($lab_config->id); ?>
					<br><br>
					<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='submit_barcodeconfig()'>
					</input>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<!--span id='st_types_progress' style='display:none;'-->
                                        <span id='barcodefields_progress' style='display:none;'>

						<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
					</form>
				</div>
                                
                                <!--NC3065-->

                            
				<div class='right_pane' id='users_div' style='display:none;margin-left:10px;'>
					<?php
					$reload_url = "lab_config_home.php?id=$lab_config_id";
					?>
					<p style="text-align: right;"><a rel='facebox' href='#UserAccounts_config'>Page Help</a></p>
					<b><?php echo LangUtil::$pageTerms['MENU_USERS']; ?></b>
					 | <a rel='facebox' href='lab_user_new.php?ru=<?php echo $reload_url; ?>&lid=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['CMD_ADDNEWACCOUNT']; ?></a>
					<br><br>
					<div id='user_acc_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<div id='user_list_table'>
					<?php
					$user_list = $lab_config->getUsers();
					$page_elems->getLabUsersTable($user_list, $lab_config_id);
					?>
					</div>
				</div>
					
				<div class='right_pane' id='inventory_div' style='display:none;margin-left:10px;'>
				</div>
                                
                                <div class='right_pane' id='billing_div' style='display:none;margin-left:10px;'>
                                         
                                    <p style="text-align: right;"><a rel='facebox' href='#Billing_config'>Page Help</a></p>
                                    <div id='billing_msg' class='clean-orange' style='display:none;width:350px;'>
                                    </div>
                           
									<form id='billing_form' name='billing_form' action='ajax/billing_update.php' method='post'>
                                        <input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
                                        <div class="pretty_box">
                                        <?php
                                            if (is_billing_enabled($_SESSION['lab_config_id'])) {
                                                $checkbox = "checked";
                                            } else {
                                                $checkbox = "";
                                            }
                                            $old_currency = get_currency_type_from_lab_config_settings();
                                        ?>
                                        <input type="checkbox" value="enable_billing" name="enable_billing" <?php echo $checkbox ?>/><?php echo "Enable Billing"; ?>
                                        <br><br>
                                        <?php echo "Default Currency Name:"; ?>
                                        <!-- <input type="text" name="currency_name" value="<?php echo get_currency_type_from_lab_config_settings() ?>" />  -->
                                        <select name='default_currency' id='default_currency'>
                                        <?php $allCurrencies = currencyConfig::getAllDifferenctCurrencies($lab_config_id);
                                        $defaultCurrency = "";
                                        foreach ($allCurrencies as $currency){ 
										//echo $currency->getFlag1(). " " . $currency->getCurrencyFrom();
                                        if($currency->getFlag1()){
										$defaultCurrency = $currency; 
                                        ?>
											<option value='<?php echo $currency->getCurrencyFrom(); ?>' selected><?php echo $currency->getCurrencyFrom(); ?></option>
										<?php } 
										else {
                                        ?>
                                        	<option value='<?php echo $currency->getCurrencyFrom(); ?>'><?php echo $currency->getCurrencyFrom(); ?></option>
                                        <?php } 
										}?>
											
										</select>
                                        <br><br>
                                        <?php echo "Currency Delimiter:"; ?>
                                        <input type="text" name="currency_delimiter" value="<?php echo get_currency_delimiter_from_lab_config_settings() ?>" size="1" maxlength="1" />
                                        <br><br>
                                        Currency will display as: 00<?php echo get_currency_delimiter_from_lab_config_settings(); ?>00 <?php echo get_currency_type_from_lab_config_settings() ?>
                                        <br/><br/>
                                        <?php if($defaultCurrency==""){?>
                                        <div id="exchange_rate" style='display:none;' ></div><?php } else {?>
                                        <?php 
                                        $alreadyExistingExchangeRates = array();
                                        if($defaultCurrency!=""){
                                        $exchangeRates = currencyConfig::getExchangeRateSnap($lab_config_id, $defaultCurrency->getCurrencyFrom());
                                        $totalCurrencies = count($allCurrencies);
                                        $totalExchangeRates = count($exchangeRates);
                                        }?>
										<?php if($totalExchangeRates <1){?>
                                        <div id="exchange_rate" style='display:none;'></div>
										<?php } else {?>
                                        <div id="exchange_rate" >
                                        <table border="1">
                                        <tr>
                                        <th>&nbsp;&nbsp; <?php echo LangUtil::$generalTerms['CURRENCY']; ?>&nbsp;&nbsp; </th>
                                        <th>&nbsp;&nbsp; <?php echo LangUtil::$generalTerms['EXCHANGE_RATE']; ?>&nbsp;&nbsp; </th>
                                        <th>&nbsp;&nbsp; <?php echo LangUtil::$generalTerms['UPDATED_DATE']; ?>&nbsp;&nbsp; </th>
                                        <th>&nbsp;&nbsp; <?php echo LangUtil::$generalTerms['ACTIONS']; ?>&nbsp;&nbsp; </th>
                                        </tr>
                                        <?php 
                                        $row=0;
                                        foreach($exchangeRates as $currencyExchageRow){?>
                                        <tr> 
                                        <td>&nbsp;&nbsp; <div id="currency<?php echo $row;?>"><?php echo $currencyExchageRow->getCurrencyTo();
                                                         array_push($alreadyExistingExchangeRates, $currencyExchageRow->getCurrencyTo()); ?> </div>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp; <input type="text" id="exchangeRate<?php echo $row;?>" value="<?php echo $currencyExchageRow->getExchangeRate();?>" size="4" />&nbsp;&nbsp; </td>
                                        <td>&nbsp;&nbsp; <?php echo DateLib::mysqlToString($currencyExchageRow->getLastUpdatedDate());?>&nbsp;&nbsp; </td>
                                        <td>&nbsp;&nbsp; <a href="javascript:updateCurrencyRatio(<?php echo $row;?>);">Update</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="javascript:deleteCurrencyRatio(<?php echo $row;?>);">Delete</a> &nbsp;&nbsp; </td>
                                        </tr>
                                        <?php $row++; }?>
                                        </table>
                                        </div>
                                        <?php } ?>
                                        <a href="javascript:addCurrencyRatio();"><?php echo LangUtil::$generalTerms['ADD_CURRENCY_RATE']; ?></a><br/>
										<?php }?>
                                        
                                        <div id="addCurrencyRatioDiv">
                                        <?php
                                        $validAddableCurrency = array();
                                        foreach ($allCurrencies as $currency){ 
										if($currency->getCurrencyTo() != $defaultCurrency->getCurrencyFrom() && !(in_array($currency->getCurrencyTo(), $alreadyExistingExchangeRates))){
										array_push($validAddableCurrency, $currency);
										} 
										}
										if(count($validAddableCurrency)>0){?>
                                        Secondary Currency&nbsp;&nbsp;&nbsp; 
                                        <select name='added_currency' id='added_currency'>
                                        <?php
                                        foreach ($validAddableCurrency as $currency){ 
										?>
											<option value='<?php echo $currency->getCurrencyFrom(); ?>'><?php echo $currency->getCurrencyFrom(); ?></option>
										<?php } 
										?>
                                        </select> 
                                        &nbsp;&nbsp;&nbsp; <input type="text" id="added_currency_rate" size="12" placeholder="Exchange Rate">
                                        &nbsp;&nbsp;&nbsp; <input type="button" value="Add" onclick="add_new_currency_ratio(1)" />
                                        &nbsp;&nbsp;&nbsp; <input type="button" value="Cancel" onclick="add_new_currency_ratio(0)" />
                                        <?php }  else {
											echo "<br/>"."Add secondary currencies to enter the exchange rates";
										}?>
                                        </div>
                                        <br/>                                       
                                        <div>
                                    	<a href='javascript:add_new_currency(1);' id='add_new_currency_link'><?php echo LangUtil::$generalTerms['ADD_CURRENCY']; ?></a>
                                    	                                    
                                   	 	<div id="new_currency" style='display:none;'>
                                   	 	<?php echo LangUtil::$generalTerms['NEW_CURRENCY']; ?>
                                    	&nbsp;&nbsp;&nbsp;<input type="text" name="new_currency_name" id="new_currency_name" /> 
                                    	&nbsp;&nbsp;&nbsp;<input type="button" value="Add Currency Type" onclick="submit_new_currency()" />
                                    	&nbsp;&nbsp;&nbsp; <input type="button" value="Cancel" onclick="add_new_currency(0)" />
                                    	</div>
                                    	</div>
                                       
                                        <br/>
                                        <input type="button" value="Update" onclick="submit_billing_update()" />

                                        <span id='billing_progress' style='display:none;'>
                                            <?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
										</span>
                                    </form>
                                    </div>
								
                                </div>
				
				<div class='right_pane' id='fields_div' style='display:none;margin-left:10px;'>
				
<div id="dialog-form" title="Create new user">
  <p class="validateTips">All form fields are required.</p>
 
   <ul id="sortable">
   <?php  
		if($field_odering->field1 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field1."</li>";
		}
		if($field_odering->field2 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field2."</li>";
		}
		if($field_odering->field3 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field3."</li>";
		}
		if($field_odering->field4 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field4."</li>";
		}
		if($field_odering->field5 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field5."</li>";
		}
		if($field_odering->field6 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field6."</li>";
		}
		if($field_odering->field7 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field7."</li>";
		}
		if($field_odering->field8 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field8."</li>";
		}
		if($field_odering->field9 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field9."</li>";
		}
		if($field_odering->field10 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field10."</li>";
		}
		if($field_odering->field11 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field11."</li>";
		}
		if($field_odering->field12 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field12."</li>";
		}
		if($field_odering->field13 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field13."</li>";
		}
		if($field_odering->field14 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field14."</li>";
		}
		if($field_odering->field15 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field15."</li>";
		}
		if($field_odering->field16 != "-1"){
			echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>".$field_odering->field16."</li>";
		}
		
   ?>
  
</ul>
</div>
 
 
		
					<p style="text-align: right;"><a rel='facebox' href='#RegistrationFields_config'>Page Help</a></p>
					<b><?php echo LangUtil::$pageTerms['MENU_CUSTOM']; ?></b>
					 | <a href='javascript:toggle_ofield_div();' id='ofield_toggle_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
					<br><br>
					<div id='cfield_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<div id='ofield_summary' class='pretty_box'>
					<?php $page_elems->getRegistrationFieldsSummary($lab_config); ?>
					</div>
					<div id='ofield_form_div' style='display:none;'>
					<form id='otherfields_form' name='otherfields_form' action='ajax/ofield_update.php' method='post'>
					<input type='hidden' value='<?php echo $_REQUEST['id']; ?>' name='lab_config_id'></input>
					<table class='hor-minimalist-b' style='width:auto;'>
						<thead>
							<tr>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr valign='top'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></td>
								<td>
									<input type='checkbox' name='use_pid' id='use_pid' <?php
									if($lab_config->pid != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_pid_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_pid_radio' value='Y' <?php
										if($lab_config->pid == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_pid_radio' value='N' <?php
										if($lab_config->pid != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr valign='top'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['ADDL_ID']; ?></td>
								<td>
									<input type='checkbox' name='use_p_addl' id='use_p_addl' <?php
									if($lab_config->patientAddl != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_p_addl_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_p_addl_radio' value='Y' <?php
										if($lab_config->patientAddl == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_p_addl_radio' value='N' <?php
										if($lab_config->patientAddl != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></td>
								<td>
									<input type='checkbox' name='use_dnum' id='use_dnum'<?php
									
                                                                        if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 12)
										echo " checked ";
									?>>
									</input>
									<span id='use_dnum_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_dnum_radio' value='Y'<?php
										if($lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_dnum_radio' value='N' <?php
										if($lab_config->dailyNum != 2 && $lab_config->dailyNum != 12)
											echo " checked ";
										?> ><?php echo LangUtil::$generalTerms['NO']; ?></input>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_RESET']; ?>
										<select name='dnum_reset' id='dnum_reset'>
											<option value='<?php echo LabConfig::$RESET_DAILY; ?>'><?php echo LangUtil::$pageTerms['DAILY']; ?></option>
											<option value='<?php echo LabConfig::$RESET_WEEKLY; ?>'><?php echo LangUtil::$pageTerms['WEEKLY']; ?></option>
											<option value='<?php echo LabConfig::$RESET_MONTHLY; ?>'><?php echo LangUtil::$pageTerms['MONTHLY']; ?></option>
											<option value='<?php echo LabConfig::$RESET_YEARLY; ?>'><?php echo LangUtil::$pageTerms['YEARLY']; ?></option>
										</select>
										<script type='text/javascript'>
										$(document).ready(function(){
											$('#dnum_reset').attr("value", "<?php echo $lab_config->dailyNumReset; ?>");
											$("#addCurrencyRatioDiv").hide();
											$("#updateCurrencyRatioDialog").hide();
										});										
										</script>
									</span>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['NAME']; ?></td>
								<td>
									<input type='checkbox' name='use_pname' id='use_pname'<?php
									if($lab_config->pname != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_pname_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_pname_radio' value='Y'<?php
										if($lab_config->pname == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_pname_radio' value='N' <?php
										if($lab_config->pname != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['GENDER']; ?></td>
								<td>
									<input type='checkbox' name='use_sex' id='use_sex' <?php
									if($lab_config->sex != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_sex_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['DOB']; ?></td>
								<td>
									<input type='checkbox' name='use_dob' id='use_dob'<?php
									if($lab_config->dob != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_dob_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_dob_radio' value='Y'<?php
										if($lab_config->dob == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_dob_radio' value='N' <?php
										if($lab_config->dob != 2)
											echo " checked ";
										?> ><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['AGE']; ?></td>
								<td>
									<input type='checkbox' name='use_age' id='use_age'<?php
                                                                        if($lab_config->age == 1 || $lab_config->age == 2 || $lab_config->age == 11 || $lab_config->age == 12)
									
										echo " checked ";
									?>>
									</input>
									<span id='use_age_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_age_radio' value='Y'<?php
										if($lab_config->age == 2 || $lab_config->age == 12)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_age_radio' value='N' <?php
										if($lab_config->age != 2 && $lab_config->age != 12)
											echo " checked ";
										?> ><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo 'Complete Age Display Limit'; ?></td>
								<td>
									<input type='text' name='ageLimit' id='ageLimit' size='3' maxlength='3' value='<?php echo $lab_config->ageLimit; ?>'>
									</input>
									<?php echo LangUtil::$generalTerms['YEARS'] ?>
								</td>
							</tr>
							<tr valign='top' style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
								<td>
									<input type='checkbox' name='use_sid' id='use_sid'<?php
									//if($lab_config->sid != 0)
									if(true)
										echo " checked ";
									?>>
									</input>
									<span id='use_sid_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
								<td>
									<input type='checkbox' name='use_s_addl' id='use_s_addl'<?php
									if($lab_config->specimenAddl != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_s_addl_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_s_addl_radio' value='Y'<?php
										if($lab_config->specimenAddl == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_s_addl_radio' value='N' <?php
										if($lab_config->specimenAddl != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['COMMENTS']; ?></td>
								<td>
									<input type='checkbox' name='use_comm' id='use_comm'<?php
									if($lab_config->comm != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_comm_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_comm_radio' value='Y'<?php
										if($lab_config->comm == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_comm_radio' value='N' <?php
										if($lab_config->comm != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['R_DATE']; ?></td>
								<td>
									<input type='checkbox' name='use_rdate' id='use_rdate'<?php
									if($lab_config->rdate != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_rdate_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_rdate_radio' value='Y'<?php
										if($lab_config->rdate == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_rdate_radio' value='N' <?php
										if($lab_config->rdate != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['REF_OUT']; ?></td>
								<td>
									<input type='checkbox' name='use_refout' id='use_refout'<?php
									if($lab_config->refout != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_refout_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_refout_radio' value='Y'<?php
										if($lab_config->refout == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_refout_radio' value='N' <?php
										if($lab_config->refout != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['DOCTOR']; ?></td>
								<td>
									<input type='checkbox' name='use_doctor' id='use_doctor'<?php
									if($lab_config->refout != 0)
										echo " checked ";
									?>>
									</input>
									<span id='use_doctor_mand' style='display:none;'>
										&nbsp;&nbsp;
										<?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>?
										&nbsp;&nbsp;
										<input type='radio' name='use_doctor_radio' value='Y'<?php
										if($lab_config->refout == 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
										&nbsp;&nbsp;
										<input type='radio' name='use_doctor_radio' value='N' <?php
										if($lab_config->refout != 2)
											echo " checked ";
										?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</span>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['DATE_FORMAT']; ?></td>
								<td>
									<select name='dformat' id='dformat'>
										<?php $page_elems->getDateFormatSelect($lab_config); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_UPDATE']; ?>' onclick='javascript:submit_otherfields();'>
									</input>
									&nbsp;&nbsp;&nbsp;
									<span id='otherfields_progress' style='display:none;'>
										<?php echo $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
					</form>
					</div> <br/>
					<a href="#" id='field_reorder_link'>Reorder Fields in Patient Registration</a> 
					<!-- <button id="create-user">Create new user</button> -->
					<br/>
					<script type='text/javascript'>
					$(document).ready(function(){
						if($('#use_pid').is(':checked'))
						{
							$('#use_pid_mand').show();
						}
						if($('#use_p_addl').is(':checked'))
						{
							$('#use_p_addl_mand').show();
						}
						if($('#use_s_addl').is(':checked'))
						{
							$('#use_s_addl_mand').show();
						}
						if($('#use_dnum').is(':checked'))
						{
							$('#use_dnum_mand').show();
						}
						if($('#use_sex').is(':checked'))
						{
							$('#use_sex_mand').show();
						}
						if($('#use_age').is(':checked'))
						{
							$('#use_age_mand').show();
						}
						if($('#use_dob').is(':checked'))
						{
							$('#use_dob_mand').show();
						}
						if($('#use_pid').is(':checked'))
						{
							$('#use_pid_mand').show();
						}
						if($('#use_sid').is(':checked'))
						{
							$('#use_sid_mand').show();
						}
						if($('#use_rdate').is(':checked'))
						{
							$('#use_rdate_mand').show();
						}
						if($('#use_refout').is(':checked'))
						{
							$('#use_refout_mand').show();
						}
						if($('#use_doctor').is(':checked'))
						{
							$('#use_doctor_mand').show();
						}
						if($('#use_pname').is(':checked'))
						{
							$('#use_pname_mand').show();
						}
						if($('#use_comm').is(':checked'))
						{
							$('#use_comm_mand').show();
						}
						$('#use_pid').click(function() {
							if($('#use_pid').is(':checked'))
							{
								$('#use_pid_mand').show();
							}
							else
							{
								$('#use_pid_mand').hide();
							}
						});
						$('#use_p_addl').click(function() {
							if($('#use_p_addl').is(':checked'))
							{
								$('#use_p_addl_mand').show();
							}
							else
							{
								$('#use_p_addl_mand').hide();
							}
						});
						$('#use_dnum').click(function() {
							if($('#use_dnum').is(':checked'))
							{
								$('#use_dnum_mand').show();
							}
							else
							{
								$('#use_dnum_mand').hide();
							}
						});
						$('#use_s_addl').click(function() {
							if($('#use_s_addl').is(':checked'))
							{
								$('#use_s_addl_mand').show();
							}
							else
							{
								$('#use_s_addl_mand').hide();
							}
						});
						$('#use_dnum').click(function() {
							if($('#use_dnum').is(':checked'))
							{
								$('#use_dnum_mand').show();
							}
							else
							{
								$('#use_dnum_mand').hide();
							}
						});
						$('#use_dob').click(function() {
							if($('#use_dob').is(':checked'))
							{
								$('#use_dob_mand').show();
							}
							else
							{
								$('#use_dob_mand').hide();
							}
						});
						$('#use_sid').click(function() {
							if($('#use_sid').is(':checked'))
							{
								$('#use_sid_mand').show();
							}
							else
							{
								$('#use_sid_mand').hide();
							}
						});
						$('#use_sex').click(function() {
							if($('#use_sex').is(':checked'))
							{
								$('#use_sex_mand').show();
							}
							else
							{
								$('#use_sex_mand').hide();
							}
						});
						$('#use_age').click(function() {
							if($('#use_age').is(':checked'))
							{
								$('#use_age_mand').show();
							}
							else
							{
								$('#use_age_mand').hide();
							}
						});
						$('#use_refout').click(function() {
							if($('#use_refout').is(':checked'))
							{
								$('#use_refout_mand').show();
							}
							else
							{
								$('#use_refout_mand').hide();
							}
						});
						$('#use_doctor').click(function() {
							if($('#use_doctor').is(':checked'))
							{
								$('#use_doctor_mand').show();
							}
							else
							{
								$('#use_doctor_mand').hide();
							}
						});
						$('#use_rdate').click(function() {
							if($('#use_rdate').is(':checked'))
							{
								$('#use_rdate_mand').show();
							}
							else
							{
								$('#use_rdate_mand').hide();
							}
						});
						$('#use_comm').click(function() {
							if($('#use_comm').is(':checked'))
							{
								$('#use_comm_mand').show();
							}
							else
							{
								$('#use_comm_mand').hide();
							}
						});
						$('#use_pname').click(function() {
							if($('#use_pname').is(':checked'))
							{
								$('#use_pname_mand').show();
							}
							else
							{
								$('#use_pname_mand').hide();
							}
						});
					});
					</script>
					<br>
					<?php echo LangUtil::$pageTerms['CUSTOMFIELDS']." - ".LangUtil::$generalTerms['SPECIMENS']; ?>
					 | <a href='cfield_new.php?lid=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['ADDNEW']; ?></a>[<a href='#new_help' rel='facebox'>?</a>]
					<div id='specimen_custom_field_list'>
					<?php 
					$custom_field_list = get_lab_config_specimen_custom_fields($lab_config->id);
					$page_elems->getCustomFieldTable($lab_config->id, $custom_field_list, 1); 
					?>
					</div>
					
					<br>
					<?php echo LangUtil::$pageTerms['CUSTOMFIELDS']." - ".LangUtil::$generalTerms['PATIENTS']; ?>
					 | <a href='cfield_new.php?lid=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['ADDNEW']; ?></a> [<a href='#new_help' rel='facebox'>?</a>]
					<div id='patient_custom_field_list'>
					<?php 
					$custom_field_list = get_lab_config_patient_custom_fields($lab_config->id);
					$page_elems->getCustomFieldTable($lab_config->id, $custom_field_list, 2); 
					?>
					</div>
					
					<br>
					<?php echo LangUtil::$pageTerms['CUSTOMFIELDS']." - Lab Titles"; ?>
					 | <a href='cfield_new.php?lid=<?php echo $lab_config_id; ?>'><?php echo LangUtil::$generalTerms['ADDNEW']; ?></a> [<a href='#new_help' rel='facebox'>?</a>]
					<div id='labtitle_custom_field_list'>
					<?php 
					$custom_field_list = get_lab_config_labtitle_custom_fields($lab_config->id);
					$page_elems->getCustomFieldTable($lab_config->id, $custom_field_list, 3); 
					?>
					</div>
				</div>
				<div class='right_pane' id='network_setup_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#SetupNet'>Page Help</a></p>
				Setup can be accessed from BlisSetup.html in the main folder.
				</div>
				<div class='right_pane' id='target_tat_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#Tests_config'>Page Help</a></p>
					<b><?php echo LangUtil::$pageTerms['MENU_TAT']; ?></b>
					 | <a href="javascript:toggletatdivs();" id='toggletat_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
					<br><br>
					<div id='tat_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<div id='goal_tat_list'>
					<?php $page_elems->getGetGoalTatTable($lab_config->id); ?>
					</div>
					<form id='goal_tat_form' style='display:none' name='goal_tat_form' action='ajax/lab_config_tat_update.php' method='post'>
						<?php $page_elems->getGoalTatForm($lab_config->id); ?>
						<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:submit_goal_tat();'></input>
						&nbsp;&nbsp;&nbsp;
						<small><a href='javascript:toggletatdivs();'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
						&nbsp;&nbsp;&nbsp;
						<span id='tat_progress_spinner' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
						</span>
					</form>
				</div>
				

                            <div id='view_stocks_help' class='right_pane' style='display:none;margin-left:10px;'>
                                    <ul>	
                                            <?php

                                                    echo "<li>";
                                                    echo " Toggle Patient Number or Patient's Age to be displayed as part of Search Results";
                                                    echo "</li>";
                                                    echo "<li>";
                                                    echo " Choosing to display Patient Number and/or Patient's Age as part of Search results slows down the time taken to search ";
                                                    echo "</li>";



                                            ?>
                                    </ul>
                                    </div>

                                
                                
				<div class='right_pane' id='del_config_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_DEL']; ?></b>
					<br><br>
					<div class='clean-orange' style='width:350px;'>
					'<?php echo $lab_config->getSiteName(); ?>' - <?php echo LangUtil::$pageTerms['TIPS_LABDELETE']; ?>
					<br><br>
					<input type='button' onclick='javascript:delete_config();' value='<?php echo LangUtil::$generalTerms['CMD_OK']; ?>'>
					&nbsp;&nbsp;&nbsp;
					<input type='button' onclick="javascript:right_load(1, 'site_info_div');" value='<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>'>
					</div>
				</div>
				
				<div class='right_pane' id='change_admin_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_MGR']; ?></b>
					<br><br>
					<div id='admin_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<select name='lab_admin' id='lab_admin' class='uniform_width'>
					<?php 
						# Fetch list of existing lab admins 
						$page_elems->getAdminUserOptions();
					?>
					</select>
					<br><br>
					<input type='button' onclick='javascript:change_admin();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'>
					&nbsp;&nbsp;&nbsp;
					<small><a href="javascript:right_load(1, 'site_info_div');"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
				</div>
				
				<div class='right_pane' id='agg_report_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#IR_rc'>Page Help</a></p>
					<b><?php echo LangUtil::$pageTerms['MENU_INFECTION']; ?></b>
					 | <a href='javascript:toggle_disease_report();' id='agg_edit_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
					<br><br>
					<div id='agg_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<div id='agg_report_summary'>
						<?php echo $page_elems->getAggregateReportSummary($lab_config); ?>
					</div>
					<div id='agg_report_form_div' style='display:none;'>
						<form id='agg_report_form' name='agg_report_form' action='ajax/report_agg_update.php' method='post'>
							<?php $page_elems->getAggregateReportConfigureForm($lab_config); ?>
						</form>	
						<form id='agg_preview_form' style='display:none;' name='agg_preview_form' action='report_disease_preview.php' method='post' target='_blank'>					
							<?php # This form is cloned from agg_report_form in javascript:agg_preview() function ?>
						</form>
					</div>
				</div>
				
                                <div class='right_pane' id='grouped_count_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#IR_rc'>Page Help</a></p>
					<b><?php echo "Test/Specimen Count Grouped Reports"; ?></b>
					 | <a href='javascript:toggle_grouped_count_report();' id='grouped_count_edit_link'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
					<br><br>
					<div id='grouped_count_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<div id='grouped_count_report_summary'>
						<?php echo $page_elems->getGroupedCountReportSummary($lab_config); ?>
					</div>
					<div id='grouped_count_report_form_div' style='display:none;'>
						<form id='grouped_count_report_form' name='grouped_count_report_form' action='ajax/grouped_count_reports_update.php' method='post'>
							<?php $page_elems->getGroupedCountReportConfigureForm($lab_config); ?>
						</form>	
						
					</div>
				</div>
                                
				<div class='right_pane' id='misc_div' style='display:none;margin-left:10px;'>
					<b><?php echo LangUtil::$pageTerms['MENU_GENERAL']; ?></b>
					<br><br>
					<div id='misc_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<form id='misc_form' name='misc_form' action='ajax/lab_config_miscupdate.php' method='get'>
						<table cellspacing='10px'>
							<tbody>
								<tr>
									<td><?php echo LangUtil::$generalTerms['FACILITY']; ?> &nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td>
										<input type='text' name='name' id='name9' class='uniform_width' value='<?php echo $lab_config->name; ?>'>
										</input>
										<input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['LOCATION']; ?></td>
									<td>
										<input type='text' name='loc' id='loc9' class='uniform_width' value='<?php echo $lab_config->location; ?>'>
										</input>
									</td>
								</tr>
								<tr valign='top'>
									<td>Database</td>
									<td>
										<input type='radio' class='dboption' name='dboption' value='1'>Populate Random Data</input><br>
										<input type='radio' class='dboption' name='dboption' value='2'>Clear Random Data</input><br>
										<input type='radio' class='dboption' name='dboption' value='0' checked>Keep Unchanged</input>
										<br><br>
										<div class='clean-orange dboption_help uniform_width' id='dboption_help_1' style='display:none'>
										Populate Random Data - Creates new random records for patients and specimens
										</div>
										<div class='clean-orange dboption_help uniform_width' id='dboption_help_2' style='display:none'>
										Clear Random Data - Clears all random data about patients and specimens
										</div>
									</td>
								</tr>
								<tr valign='top' class='random_params' style='display:none;'>
									<td>Total Patients</td>
									<td>
										<input type='text' class='uniform_width' name='num_p' value='<?php echo $MAX_NUM_PATIENTS/2; ?>'></input>
									</td>
								</tr>
								<tr valign='top' class='random_params' style='display:none;'>
									<td>Total Specimens</td>
									<td>
										<input type='text' class='uniform_width' name='num_s' value='<?php echo "2000"; #$MAX_NUM_SPECIMENS/2; ?>'></input>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type='button' name='misc_form_button' id='misc_form_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:misc_checkandsubmit();'>
										</input>
										&nbsp;&nbsp;&nbsp;
										<small><a href="javascript:right_load(1, 'site_info_div');"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
										&nbsp;&nbsp;&nbsp;
										<span id='misc_progress' style='display:none'>
											<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
										</span>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<span id='misc_errormsg' class='clean-error' style='display:none' >
										</span>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										
									</td>
								</tr>
							</tbody>
						</table>
					</form>			
				</div>
				
				<!--  Daily Report Settings Pane -->
				<div class='right_pane' id='report_config_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#DRS_rc'>Page Help</a></p>
					<b><?php echo LangUtil::$pageTerms['MENU_REPORTCONFIG']; ?></b>
					<br><br>
					<div id='report_config_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<form id='report_config_form' name='report_config_form' action='' method='post'>
						<?php echo LangUtil::$generalTerms['REPORT_TYPE']; ?>
						&nbsp;&nbsp;
						<select name='report_type' id='report_type11'>
							<option value='1'><?php echo $LANG_ARRAY['reports']['MENU_PATIENT']; ?></option>
							<?php
							if($SHOW_SPECIMEN_REPORT === true)
							{
								?>
								<option value='2'><?php echo $LANG_ARRAY['reports']['MENU_SPECIMEN']; ?></option>
								<?php
							}
							if($SHOW_TESTRECORD_REPORT === true)
							{
								?>
								<option value='3'><?php echo $LANG_ARRAY['reports']['MENU_TESTRECORDS']; ?></option>
								<?php
							}
							?>
							<option value='4'><?php echo $LANG_ARRAY['reports']['MENU_DAILYLOGS']."-".LangUtil::$generalTerms['SPECIMENS']; ?></option>
							<option value='6'><?php echo $LANG_ARRAY['reports']['MENU_DAILYLOGS']."-".LangUtil::$generalTerms['PATIENTS']; ?></option>
							<!--<option value='77'><?php echo $LANG_ARRAY['reports']['MENU_DAILYLOGS']."-".LangUtil::$generalTerms['PATIENT_BARCODE']; ?></option>-->
						</select>
						&nbsp;&nbsp;
						<input type='button' id='report_config_button' value="<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>" onclick="javascript:fetch_report_config();"></input>
						&nbsp;&nbsp;
						<span id='report_config_fetch_progress' style='display:none;'>
							<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
						</span>
						<br><br>
						<div id='report_config_content'>
						</div>
					</form>	
				</div>
				
				<div class='right_pane' id='backup_revert_div' style='display:none;margin-left:10px;'>
					<p style="text-align: right;"><a rel='facebox' href='#Revert'>Page Help</a></p>
					<b><?php echo LangUtil::$pageTerms['MENU_REVERT']; ?></b>
					<br><br>
					<div id='backup_revert_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<form id='backup_revert_form' name='backup_revert_form' action='data_backup_revert.php' method='post'>
						<input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
						<table>
							<tbody>
								<tr valign='top'>
									<td><?php echo LangUtil::$pageTerms['BACKUP_LOCATION']; ?></td>
									<td>
										<?php $page_elems->getBackupRevertRadio("backup_path", $lab_config->id); ?>
									</td>
								</tr>
								<tr valign='top'>
									<td><?php echo LangUtil::$pageTerms['INCLUDE_LANGUAGE_SETTINGS']; ?>?</td>
									<td>
										<input type='radio' name='do_lang' id='do_lang' value='Y'><?php echo LangUtil::$generalTerms['YES']; ?></input>
										<input type='radio' name='do_lang' value='N' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</td>
								</tr>
								<tr valign='top'>
									<td><?php echo LangUtil::$pageTerms['BACKUP_CURRENT_VERSION']; ?></td>
									<td>
										<input type='radio' name='do_currbackup' id='do_currbackup' value='Y' checked><?php echo LangUtil::$generalTerms['YES']; ?></input>
										<input type='radio' name='do_currbackup' value='N'><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</td>
								</tr>
								<tr valign='top'>
									<td></td>
									<td>
										<input type='button' onclick='javascript:backup_revert_submit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
										&nbsp;&nbsp;&nbsp;
										<span id='backup_revert_progress' style='display:none'>
											<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
										</span>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
	
					<br><br>
					<div class='clean-orange' id='revert_done_msg' style='width:300px' style='display:none;'>
						<?php echo LangUtil::$pageTerms['TIPS_REVERTDONE']; ?>
					</div>
				</div>
				
				<div class='right_pane' id='update_database_div' style='display:none;margin-left:10px;'>
					<p style="text-align: right;"><a rel='facebox' href='#Revert'>Page Help</a></p>
					<b><?php echo "Update Data"; ?></b>
					<br><br>
					<form id='update_database_form' name='update_database_form' action='export/update_database.php' method='get'>
						<input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
						<table>
							<tbody>
								<tr valign='top'>
									<td><?php echo 'BACKUP_LOCATION'; ?></td>
									<td>
										<?php $page_elems->getBackupRevertRadio("backup_path", $lab_config->id); ?>
									</td>
								</tr>
								<tr valign='top'>
									<td><?php echo 'BACKUP_CURRENT_VERSION'; ?></td>
									<td>
										<input type='radio' name='do_currbackup' id='do_currbackup' value='Y' checked><?php echo LangUtil::$generalTerms['YES']; ?></input>
										<input type='radio' name='do_currbackup' value='N'><?php echo LangUtil::$generalTerms['NO']; ?></input>
									</td>
								</tr>
								<tr valign='top'>
									<td></td>
									<td>
										<input type='button' onclick='javascript:update_database_submit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
										&nbsp;&nbsp;&nbsp;
										<span id='update_database_progress' style='display:none'>
											<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
										</span>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
					<br><br>
					<div id='update_success' class='clean-orange' style='display:none;width:350px;'>
						Updated Successfully&nbsp;&nbsp;&nbsp;<a href="javascript:toggle_div('update_success');"--><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>
					</div>
					<div id='update_failure' class='clean-orange' style='display:none;width:350px;'>
						Update Failed&nbsp;&nbsp;&nbsp;<a href="javascript:toggle_div('update_failure');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>
					</div>
				</div>
                                
                                <div class='right_pane' id='import_config_div' style='display:none;margin-left:10px;'>
					<p style="text-align: right;"><a rel='facebox' href='#importconfig'>Page Help</a></p>
					<b><?php echo "Import Configuration"; ?></b>
					<br><br>
					<form id='import_config_form' name='import_config_form' action='ajax/import_config.php' method='get'>
						<input type='hidden' name='lid' value='<?php echo $lab_config->id; ?>'></input>
						<table>
							<tbody>
                                                            <tr valign='top'>
                                                                <td><?php echo '- Select the facility from which you want to import data:'; ?></td>
									<td>
										<?php echo ""; ?>
									</td>
								</tr>
                                                                <tr valign='top'>
                                                                <td><?php
                                                                    //$site_list = get_site_list($_SESSION['user_id']);
                                                                    //print_r($site_list);
                                                                    //echo "<input type='checkbox' name='".$elem_name."[]' id='$elem_id' value='$key'>$value</input>";
                                                                    ?>
                                                                    <select name='location' id='location2' class='uniform_width' onchange="javascript:get_testbox2(this.value);">
                                                                    <option value='0'><?php echo 'Select Facility'; ?></option>
                                                                    <?php
                                                                        $page_elems->getSiteOptions();
                                                                    ?>
                                                                    </select>
                                                                    
                                                                        
                                                                </td>
									<td>
										<?php //echo $lab_config->id; ?>
									</td>
								</tr>
                                                                <tr valign='top'>
                                                                <td>
                                                                    <div id='test_list_by_site'>
                                                                        <?php //echo 'Select Facility to dispay its test catalog '?>
                                                                        </div>
                                                                </td>
									<td>
										<?php echo ""; ?>
									</td>
								</tr>
                                                                <tr valign='top'>
                                                                <td><?php echo '- Select the configuration data you want to import:'; ?></td>
									<td>
										<?php echo ""; ?>
									</td>
								</tr>
								
								<tr valign='top'>
									<td><?php echo 'Import test catalog'; ?></td>
									<td>
										<input type='checkbox' id="import_tc" name='import_tc' >
                                                                                </input>
									</td>
								</tr>
								<tr valign='top'>
									<td><?php echo 'Import specimen catalog'; ?></td>
									<td>
										<input type='checkbox' id="import_sc" name='import_sc' >
                                                                                </input>
									</td>
								</tr>
                                                                <tr valign='top'>
									<td><?php echo 'Import Statistic Report settings'; ?></td>
									<td>
										<input type='checkbox' id="import_sr" name='import_sr' >
                                                                                </input>
									</td>
								</tr>
                                                                <tr valign='top'>
									<td><?php echo 'Import Patient Report configurations and Worksheets'; ?></td>
									<td>
										<input type='checkbox' id="import_pw" name='import_pw' >
                                                                                </input>
									</td>
								</tr>
                                                                <tr valign='top'>
									<td></td>
									<td>
										<input type='button' onclick='javascript:update_database_submit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
										&nbsp;&nbsp;&nbsp;
										<span id='update_database_progress' style='display:none'>
											<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
										</span>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
					<br><br>
					<div id='update_success' class='clean-orange' style='display:none;width:350px;'>
						Updated Successfully&nbsp;&nbsp;&nbsp;<a href="javascript:toggle_div('update_success');"--><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>
					</div>
					<div id='update_failure' class='clean-orange' style='display:none;width:350px;'>
						Update Failed&nbsp;&nbsp;&nbsp;<a href="javascript:toggle_div('update_failure');"><?php echo LangUtil::$generalTerms['CMD_HIDE']; ?></a>
					</div>
				</div>
				
				<div class='right_pane' id='worksheet_config_div' style='display:none;margin-left:10px;'>
				<p style="text-align: right;"><a rel='facebox' href='#WS_rc'>Page Help</a></p>
					<b><?php echo LangUtil::$pageTerms['MENU_WORKSHEETCONFIG']; ?></b>
					<br><br>
					<div id='worksheet_config_msg' class='clean-orange' style='display:none;width:350px;'>
					</div>
					<br>
					<form id='worksheet_config_form' name='worksheet_config_form' action='ajax/report_config_update.php' method='post'>
						<table>
							<tbody>
								<tr valign='top'>
									<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></td>
									<td>
										<select name='cat_code' id='cat_code12' class='uniform_width'>
											<option value="0"><?php echo LangUtil::$generalTerms['ALL']; ?></option>
											<?php $page_elems->getTestCategorySelect(); ?>
										</select>
									</td>
								</tr>
								<tr valign='top'>
									<td><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></td>
									<td>
										<select id='test_type12' name='t_type' class='uniform_width'>
											<?php $page_elems->getTestTypesSelect($lab_config->id); ?>
										</select>
									</td>
							</tr>
							<tr valign='top'>
								<td></td>
								<td>
									<input type='button' onclick='javascript:fetch_worksheet_config();' value='<?php echo LangUtil::$generalTerms['CMD_SEARCH']; ?>'></input>
									&nbsp;&nbsp;&nbsp;
									<span id='worksheet_fetch_progress' style='display:none'>
										<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SEARCHING']); ?>
									</span>
								</td>
							</tr>
						</table>
					</form>
					<br>
					<div id='worksheet_config_content'>
					</div>
					<br>
					<?php echo LangUtil::$pageTerms['CUSTOM_WORKSHEETS']; ?>
					<?php $page_elems->getCustomWorksheetTable($lab_config); ?>
					<br>
					<small><a href='worksheet_custom_new.php?id=<?php echo $lab_config->id; ?>'><?php echo LangUtil::$pageTerms['NEW_CUSTOMWORKSHEET']; ?> &raquo;</a></small>
				</div>
				
				<div class='right_pane' id='language_div' style='display:none;margin-left:10px;'>
					<div id='language_contents'></div>
					<?php
						include('lang/lang_edit.php'); 
					?>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<?php include("includes/footer.php"); ?>
