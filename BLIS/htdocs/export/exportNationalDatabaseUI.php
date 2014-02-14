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
LangUtil::setPageId("exportNationalDbUI");

$script_elems = new ScriptElems();
$script_elems->enableJQuery();
$script_elems->enableJQueryForm();

?>
<html>
<head>
<script type="text/javascript">
function exportDb() {
	$.ajax({
		type : 'POST',
		url : 'export/exportNationalDatabase.php',
		success : function (param) {
			$('#exporting').hide();
			if ( param != false ) {
				$('#exportSuccess').html(param);
				$('#exportSuccess').show();
			} else {
				alert(param);
				$('#exportDatabaseFailure').show();
			}
		}
	});
}

</script>
</head>
<body>

<br>

<div id='exporting' align='center'>
	<?php if( $_SESSION['locale'] != "fr" ) { ?>
		<p>Exporting Database.. Please wait</p>
	<?php } else { ?>
		<p>Sauvegarde des données.. Sil vous plait attendre</p>
	<?php } ?>
	<p><img src='includes/img/ajax-loader.gif'></p>
</div>

<div id='exportSuccess' style='display:none;' align='center'>
	<p style="color:green;"></p>
</div>

<div id='exportDatabaseFailure' style='display:none;' align='center'>
	<p style="color:red;">Database Export Failed.</p>
</div>

<script type="text/javascript">
	exportDb();
</script>

</body>
</html>