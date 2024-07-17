<!-- (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre -->

<script type="text/javascript">
	function changeTheme(theme) {
		alert(theme);
		$.ajax({
		type : 'POST',
		url : 'users/changetheme.php?theme='+theme,
		success : function(data) {
			alert(data);
		}
	});
	}



</script>

<?php
#
# This is the footer file to display at the end of the file.
# Closes any open database connections, and-
# displays footer so the users know the page is done loading.
#

include_once(__DIR__."/../lang/lang_util.php");
include_once(__DIR__."/db_close.php");
LangUtil::setPageId("footer");
?>


</div><!-- end of center_pane-->

<div id='bottom_pane'>
	<br>
	<hr>
	<div class='footer_message'>
		<small>

		<?php
			echo '<a href="https://c4g.github.io/BLIS/faq/">FAQ</a>';
		?>
		|
		<?php
		if($_SESSION['locale'] == "en")
		{
			echo "<a href='https://c4g.github.io/BLIS/' target='_blank'>User Guide</a>";
		}
		else if($_SESSION['locale'] == "fr")
		{
			echo "<a href='https://c4g.github.io/BLIS/' target='_blank'>Guide de l'utilisateur</a>";
		}
		else
		{
			echo "<a href='https://c4g.github.io/BLIS/' target='_blank'>User Guide</a>";
		}
		?>
        | <a rel='facebox' href='feedback/comments.php?src=<?php echo $_SERVER['PHP_SELF']; ?>'><?php echo "Comments" ?>?</a>
        | C4G BLIS v<?php echo $VERSION; ?> - <?php echo LangUtil::getPageTerm("FOOTER_MSG"); ?>
		<?php
		if($_SESSION['locale'] !== "en")
		{
			?>
			 | <a href="lang_switch?to=en"><?php echo "English"; ?></a>
			<?php
		}
		else
		{
			echo " | English";
		}
		if($_SESSION['locale'] !== "fr")
		{
			?>
			 | <a href="lang_switch?to=fr"><?php echo "Francais"; ?></a>
			<?php
		}
		else
		{
			echo " | Francais";
		}
		if($_SESSION['locale'] !== "default")
		{
			?>
			 | <a href="lang_switch?to=default" class="blue"><?php echo "Default"; ?></a>
			<?php
		}
		else
		{
			echo " | Default";
		}
		/*Change Theme: <a href=javascript:changeTheme('Blue');>Blue</a> | <a href=javascript:changeTheme('Grey');>Grey*/
		if($TRACK_LOADTIME)
		{
			$endtime = microtime();
			$endarray = explode(" ", $endtime);
			$endtime = $endarray[1] + $endarray[0];
			$totaltime = $endtime - $starttime;
			$totaltime = round($totaltime,5);
			$page_name = $_SERVER['PHP_SELF'];
			$page_name_parts = explode("/", $page_name);
			$file_name = $page_name_parts[count($page_name_parts)-1].".dat";
			$file_handle = fopen("../feedback/loadtimes/".$file_name, "a");
			fwrite($file_handle, $totaltime."\n");
			fclose($file_handle);
			echo "<br>$file_name This page loaded in $totaltime seconds.";
		}
		if($TRACK_LOADTIMEJS)
		{
			echo "<script type='text/javascript'>alert(new Date().getTime() - t.getTime());</script>";
		}
		?>
		</small>
		<br><br>
	</div>
</div><!--end of bottom_pane-->
</body>
</html>
