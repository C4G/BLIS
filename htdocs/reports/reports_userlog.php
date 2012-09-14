<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Creates printable report for user activity log
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) 
     && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	 && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) ) {
		header( 'Location: home.php' );
}

include("redirect.php");
include("includes/script_elems.php");
include("includes/page_elems.php");

$saved_session = SessionUtil::save();

LangUtil::setPageId("lab_config_home");
$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$page_elems = new PageElems();

$lab_config_id = $_REQUEST['location'];
DbUtil::switchToLabConfig($lab_config_id);
$lab_config = get_lab_config_by_id($lab_config_id);
$user_id = $_REQUEST['username'];
$user =  get_user_by_id($user_id);
?>
<script type='text/javascript'>

$(document).ready(function(){
	fetch_report();
});

function fetch_report()
{
	var yf = $('#yyyy_from').attr("value");
	var mf = $('#mm_from').attr("value");
	var df = $('#dd_from').attr("value");
	var yt = $('#yyyy_to').attr("value");
	var mt = $('#mm_to').attr("value");
	var dt = $('#dd_to').attr("value");
	$('#fetch_progress').show();
	var url_string = "ajax/userlog_fetch.php?l=<?php echo $lab_config_id; ?>&u=<?php echo $user_id; ?>&yf="+yf+"&mf="+mf+"&df="+df+"&yt="+yt+"&mt="+mt+"&dt="+dt;
	$('#report_content').load(url_string, function() {
		$('#fetch_progress').hide();
	});
}

function print_content(div_id)
{
	var DocumentContainer = document.getElementById(div_id);
	var WindowObject = window.open("", "PrintWindow", "toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
	//javascript:window.print();
}
</script>
<?php
$today = date("Y-m-d");
$today_array = explode("-", $today);
$monthago_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($today)) . " -1 months"));
$monthago_array = explode("-", $monthago_date);
?>
<table>
	<tr valign='top'>
		<td>
			<?php echo LangUtil::$generalTerms['FROM_DATE']; ?>
		</td>
		<td>
			&nbsp;&nbsp;
			<?php
			$name_list = array("yyyy_from", "mm_from", "dd_from");
			$id_list = $name_list;
			$value_list = $monthago_array;
			$page_elems->getDatePickerPlain($name_list, $id_list, $value_list); 
			?>
		</td>
		<td>
			&nbsp;&nbsp;&nbsp;
			<?php echo LangUtil::$generalTerms['TO_DATE']; ?>
		</td>
		<td>
			&nbsp;&nbsp;
			<?php
			$name_list = array("yyyy_to", "mm_to", "dd_to");
			$id_list = $name_list;
			$value_list = $today_array;
			$page_elems->getDatePickerPlain($name_list, $id_list, $value_list);
			?>
		</td>
		<td>
			&nbsp;&nbsp;&nbsp;
			<input type='button' onclick="javascript:fetch_report();" value='<?php echo LangUtil::$generalTerms['CMD_VIEW']; ?>'></input>
			<span id='fetch_progress' style='display:none'>
				&nbsp;&nbsp;&nbsp;
				<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
			</span>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='hidden' name='data' value='' id='word_data' />
			<input type='button' onclick="javascript:print_content('export_content');" value='<?php echo LangUtil::$generalTerms['CMD_PRINT']; ?>'></input>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='button' onclick="javascript:window.close();" value='<?php echo LangUtil::$generalTerms['CMD_CLOSEPAGE']; ?>'></input>
		</td>
	</tr>
</table>
<hr>
<div id='export_content'>
	<style type='text/css'>
	#report_content table { border-collapse: collapse; }
	#report_content td, th { padding: .3em; border: 1px black solid; font-size:14px; } 
	#report_content { margin-left: 20px; }
	#export_content { margin-left: 20px; }
	</style>
	<div id='report_content'></div>
</div>
<?php
SessionUtil::restore($saved_session);
?>