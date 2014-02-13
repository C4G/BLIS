<?php
#
# index.php page
# Redirects to home.php or login.php (if session not started)
# Shows error message if JavaScript is disabled in the web browser
#

# If reverting back to PHP redirection, un-comment the follwing line:
# header("Location:home.php");
?>
<script language="JavaScript">
	window.location = 'home.php';
</script>
<p>
Sorry, your browser either does not support JavaScript or has disabled it. <br>
Please enable JavaSript on your browser and refresh this page in order to proceed.
</p>
<?php include("includes/footer.php"); ?>