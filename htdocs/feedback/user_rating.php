<?php
#
# Saves user_ratings before proceeding to logout
#


include("../includes/db_lib.php");
include("../includes/script_elems.php");
include("../includes/page_elems.php");
$script_elems = new ScriptElems();
$page_elems = new PageElems();

$script_elems->enableJQuery();
$script_elems->enableJQueryForm();
?>
<html>
	<head>
		<title>
		</title>
		<script type='text/javascript'>
		function submit_rating()
		{
			$('#submit_progress').show();
			$('#rating_form').ajaxSubmit( { success:function() {
					$('#submit_progress').hide();
					window.location="/logout.php";
				}
			});
		}
		function skip_to_logout()
		{
		document.getElementById("skipped").setAttribute("value","-1");
			$('#submit_progress').show();
			$('#rating_form').ajaxSubmit( { success:function() {
					$('#submit_progress').hide();
					window.location="/logout.php";
				}
			});
		}
		</script>
		<?php include("../includes/styles.php"); ?>

	</head>
	<body>
	<form name='rating_form' id='rating_form' action='/user_rating_submit.php'>
	<input type='hidden' name='user_id' value='<?php echo $_SESSION['user_id']; ?>'></input>
	<input type='hidden' name='skipped' id='skipped' value='0'></input>
	<?php
	if($_SESSION['locale'] != "fr")
	{
	?>
	<table class='smaller_font'>
	<tr>
		<td>
		<b>User Rating</b>
		<br><br>
		</td>
	</tr>
	<tr>
		<td>
		How would you rate this experience with BLIS?<br>
		<input name='rating' id='rating' type='radio' value='1'>&nbsp;1. Highly satisfactory</option><br>
		<input name='rating' id='rating' type='radio' value='2'>&nbsp;2. Somewhat satisfactory</option><br>
		<input name='rating' id='rating' type='radio' value='3' checked>&nbsp;3. Neither satisfactory nor unsatisfactory</option><br>
		<input name='rating' id='rating' type='radio' value='4'>&nbsp;4. Unsatisfactory</option><br>
		<input name='rating' id='rating' type='radio' value='5'>&nbsp;5. Highly unsatisfactory</option><br><br>
		Comments:<br><textarea rows='5' columns='24' name='comments' id='comments' type='textbox' style='font-family:Tahoma;' maxlength='2048' /></br>
		</td>
	</tr>
	<tr>
		<td>
			<br>
			<input type='button' onclick='javascript:submit_rating();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
			&nbsp;&nbsp;
			<a href='javascript:skip_to_logout();'?><?php echo LangUtil::$generalTerms['CMD_SKIP']; ?></a>
			&nbsp;&nbsp;
			<span id='submit_progress' style='display:none;'>
				<?php echo $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
			</span>
		</td>
	</tr>
	</table>
	<?php
	}
	else
	{
		# Show in francais
	?>
	<table class='smaller_font'>
	<tr>
		<td>
		<b>User Rating</b>
		<br><br>
		</td>
	</tr>
	<tr>
		<td>
		Comment &eacute;valuez-vous cette exp&eacute;rience avec BLIS<br>
		<input name='rating' id='rating' type='radio' value='1'>&nbsp;1. Tr&eacute;s satisfaisant</option><br>
		<input name='rating' id='rating' type='radio' value='2'>&nbsp;2. Plut&ocirc;t satisfaisant</option><br>
		<input name='rating' id='rating' type='radio' value='3' checked>&nbsp;3. Ni satisfait, ni insatisfait</option><br>
		<input name='rating' id='rating' type='radio' value='4'>&nbsp;4. Peu satisfaisant</option><br>
		<input name='rating' id='rating' type='radio' value='5'>&nbsp;5. Tr&eacute;s insatisfaisant</option><br><br>
		Comments:<br><textarea rows='5' columns='24' name='comments' id='comments' type='textbox' style='font-family:Tahoma;' maxlength='2048' /></br>
		</td>
	</tr>
	<tr>
		<td>
			<br>
			<input type='button' onclick='javascript:submit_rating();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>'></input>
			&nbsp;&nbsp;
			<a href='javascript:skip_to_logout();'?><?php echo LangUtil::$generalTerms['CMD_SKIP']; ?></a>
			&nbsp;&nbsp;
			<span id='submit_progress' style='display:none;'>
				<?php echo $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
			</span>
		</td>
	</tr>
	</table>
	<?php
	}
	?>
	</form>
	</body>
</html>
