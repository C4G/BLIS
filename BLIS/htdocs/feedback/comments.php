<?php
session_start();
include("../includes/page_elems.php");
$page_elems = new PageElems();
?>
<html>
<head>
</head>
<?php
if($SERVER == $ON_PORTABLE)
{
?>
<body>
<div id='message_box'>
<table class="smaller_font">
<tr>
<td>
<font class='comments_entry'><b>Comments</b>
<br><br>
<?php
if($_SESSION['locale'] != "fr")
{
?>
	Your comments and suggestions are extremely valuable to us.
<?php
}
else
{
?>
	Vos commentaires et suggestions sont extr&ecirc;mement pr&eacute;cieux pour nous.
<?php
}
?>
</td>
</tr>
<tr>
<td>
<br>
<?php
if($_SESSION['locale'] != "fr")
{
?>
	Please email any comments or suggestions to Santosh Vempala (vempala@cc.gatech.edu) or Amol Shintre (a.shintre@gatech.edu)
<?php
}
else
{
?>
	S'il vous pla&icirc;t e-mail des commentaires ou des suggestions &agrave; Santosh Vempala (vempala@cc.gatech.edu) ou Amol Shintre (a.shintre@gatech.edu)
<?php
}
?>
</td>
</tr>
</table>
</div>
</body>
<?php
}
else
{
# Non-portabla version. Show form for collecting comments.
?>
<script type='text/javascript'>
	function post_comment()
	{
		$('#comments_progress_bar').show();
		var curr_page = '<?php echo $_REQUEST['src']; ?>';
		var comment = document.forms['message'].elements['tarea'].value;
		var username = "<?php echo $_SESSION['username']; ?>";
		var url_string = "ajax/comments_backend.php?comment="+comment+"&page="+curr_page+"&user="+username;
		$.ajax({
			url: url_string,
			success: function(data) {
				document.getElementById('comments_tarea').disabled=true;
				$('#post_comment_button').hide();
				$('#comments_progress_bar').hide();
				//$('#comment_sent').append(xmlHttp.responseText);
				$('#comment_sent').append(data);
				$('#comment_sent').show();
			}
		});
	}
	</script>
	</head>
<body>
<div id='message_box'>
<form id='message' name='message'>
<table>
<tr>
<td>
<font class='comments_entry'>
<b>
<?php
if($_SESSION['locale'] == "fr")
{
	echo "Commentaires";
}
else
{
	echo "Comments";
}
?>
</b>
<br><br>
<?php
if($_SESSION['locale'] == "fr")
{
	echo "Vos commentaires et suggestions sont extr&ecirc;mement pr&eacute;cieux pour nous. S'il vous pla&icirc;t utiliser la case ci-dessous pour nous envoyer vos commentaires.";
}
else
{
	echo "Your comments and suggestions are extremely valuable to us. Please use the box below to send us feedback.";
}
?>
</font>
</td>
</tr>
<tr>
<td>
<textarea name ='tarea' id='comments_tarea' rows='5' cols='40'></textarea>
</td>
</tr>
</table>
<br>
<input id='post_comment_button' type='button' onclick='post_comment();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' />
<span id='comments_progress_bar' style='display:none'>
<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
</span>
<div id='comment_sent' class='comments_entry' style='display:none'>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</form>
</div>
</body>
<?php	
}
?>
</html>