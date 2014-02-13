<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
#top_pane {
	color: black;
	background: #B3C6E6;
	padding: 0 1em 0 0;
	height: 70px;
}

div {
	display: block;
}

body {
	font-family: Tahoma,Arial,Sans-Serif;
	font-size: 16px;
	color: #2B1B17;
}
</style>
</head>
<body>
<div id="top_pane">
		<div id="top_pane_user_info">
		
		</div>
		<table cellspacing="10px">
			<tbody><tr>
				<td>
					<span class="lis_title">Basic Laboratory Information System</span>
				</td>
				<td>
				</td>
				<td> 
				</td>
			</tr>
		</tbody></table>
	<div id="menus">
	<ul id="globalnav">
	<span id="backup_div" style="float:right;margin-right:15px;">
	</span>
	</ul>
	</div>
</div>

<?php 
include("../includes/db_lib.php");
include("../includes/user_lib.php");
$reset_before_date = "2013-08-30";
?>

<br>
<b><?php echo LangUtil::$generalTerms['PWD_RESET']; ?></b>
 | <a href='javascript:history.go(-1);'> &laquo; <?php echo LangUtil::$generalTerms['CMD_BACK']; ?></a>
<br><br>
<?php $today = date("Y-m-d"); 
if(strtotime($reset_before_date) > strtotime($today)){
password_reset_flush($reset_before_date);
echo LangUtil::$generalTerms["PASSWORDRESET_COMPLETE"];
} else {
echo LangUtil::$generalTerms["PASSWORDRESET_ERR"];
}
 ?>
<div id='confirm_msg'>
</div>
<?php include("../includes/footer.php"); ?>