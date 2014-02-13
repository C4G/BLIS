<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main file for updating to new version
# Calls ajax/update.php which actually performs the update operations

/*include("../users/accesslist.php");
if( !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	&& !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) &&
	!(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) )
	header( 'Location: home.php' );
*/

include("redirect.php");
include("../includes/script_elems.php");
include("lang/lang_util.php");
LangUtil::setPageId("updateCountryDbAtLocal");

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
		url : 'update/updateCountryDbAtLocal.php',
		success : function (param) {
			$('#updating').hide();
			if ( param=="true" ) {
				$('#updateSuccess').show();
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

<div id='updating' align='center'>
	<?php if( $_SESSION['locale'] != "fr" ) { ?>
		<p>Updating. Please wait..</p>
	<?php } else { ?>
		<p>Mise a jour en cours. S&#146;il vous plait attendre</p>
	<?php } ?>
	<p><img src='includes/img/ajax-loader.gif'></p>
</div>

<div id='updateSuccess' style='display:none;' align='center'>
	<p style="color:green;">Database Updated successfully.</p>
</div>

<div id='updateDatabaseFailure' style='display:none;' align='center'>
	<p style="color:red;">Database Update Failed.</p>
</div>

<script type="text/javascript">
	performDbUpdate();
</script>

</body>
</html>