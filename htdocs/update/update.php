<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main file for updating to new version
# Calls ajax/updateDB.php which actually performs the update operations

require_once("redirect.php");
require_once("../includes/script_elems.php");
require_once("lang/lang_util.php");

LangUtil::setPageId("update");

$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableJQueryForm();

?>
<html>
<head>
<script type="text/javascript">
function performDbUpdate() {
	$.ajax({
		type : 'POST',
		url : 'update/updateDB.php',
		success : function (param) {
			$('#updating').hide();
			if ( param=="true" ) {
				$('#updateSuccess').show();
				setTimeout(function () {
					location.href='home.php'
				}, 5000);
			} else {
				alert(param);
				$('#updateDatabaseFailure').show();
			}
		}
	});
}
</script>
</head>
<body>

<br>

<div id='updating' style='display:none;' align='center'>
	<?php if( $_SESSION['locale'] != "fr" ) { ?>
		<p>Updating. Please wait..</p>
	<?php } else { ?>
		<p>Mise a jour en cours. S&#146;il vous plait attendre</p>
	<?php } ?>
	<p><img src='includes/img/ajax-loader.gif'></p>
</div>

<div id='updateSuccess' style='display:none;' align='center'>
	<p style="color:green;">C4G BLIS updated successfully. Please wait while you are redirected to the homepage.</p>
</div>

<div id='updateDatabaseFailure' style='display:none;' align='center'>
	<p style="color:red;">Database update failed. Please check <pre>log/application.log</pre> for details.</p>
</div>

<script type="text/javascript">
	performDbUpdate();
</script>

</body>
</html>