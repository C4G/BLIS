<?php 
include("redirect.php");
include("includes/header.php"); 
?>
<br>
<span class='page_title'>Help</span>
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

</script>

<table name="page_panes" cellpadding="10px">
	<tr valign='top'>
	<td id="left_pane" class="left_menu" valign="top" width='180px'>
		<a href="#Config Wireless LAN">How to configure wireless setup
		</a><br><br>
		<a href="#Reports">Reports
		</a><br><br>
		<a href="#Results">Results
		</a><br><br>
	</td>
	
	<td id="right_pane" class="right_pane" valign="top" >
	
	<form name="Contents" action="post">
	<table name="help_contents" cellpadding="10px">
	<tr>
		<td width="90%" valign="top">
			<div id="Config Wireless LAN">
			<textarea name="wlan_contents" rows="5" cols=40>
			First line of text
			Second line of text
			</textarea>
			<br>
			<a href = "#Config Wireless LAN"> &lt;Back to top
		</td>
		<td valign="top">	
			<input type="button" name="Edit" id="edit1" onClick="document.Contents.wlan_contents.readonly='false'">
			
			</div>
		</td>	
	</tr>
    <tr>	
		<td>
			<div id="Reports">
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<a href = "#Config Wireless LAN"> &lt;Back to top
		</td>
		<td>
			
		</td>
		</div>
	</tr>
	<tr>
		<td>
			<div id="Results" class='results_subdiv' style='display:none;'>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<a href = "#Config Wireless LAN"> &lt;Back to top
		</td>
		<td>
		</td>
		</div>
	</tr>	
	</table>	
	</form>	
	</td>
</tr>
</table>
<?php include("includes/footer.php"); ?>