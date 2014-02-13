<?php
#
# Code for adding new report entry on the left menu
# In the file reports/reports.php: 
# copy this code after the line saying PLUG_DAILY_REPORT_ENTRY for daily report
# or after PLUG_AGGREGATE_REPORT_ENTRY for aggregate report
# Substitute "[reportname]" by the report name (single word or with underscore)
?>
<li class='menu_option' id='[reportname]_menu'>
	<a href='javascript:show_[reportname]_form();'> Report Name</a>
</li>
<script type='text/javascript'>
function show_[reportname]_form()
{
	$('.reports_subdiv').hide();
	$('.reports_subdiv_help').hide();
	$('#[reportname]_div').show();
	$('.menu_option').removeClass('current_menu_option');
	$('#specimen_report_menu').addClass('current_menu_option');
}
</script>