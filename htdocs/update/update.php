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
				setTimeout("location.href='home.php'",5000);
			} else {
				alert(param);
				$('#updateDatabaseFailure').show();
			}
		}
	});
}

function performUpdate()
{
	$('#updating').show();
	$.ajax({
		type : 'POST',
		url : 'ajax/update_blis.php',
		success : function(data) {
			if ( data=="true" ) {
				performDbUpdate();
			}
			else {
				$('#updating').hide();
				$('#updateCodeFailure').show();
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

<div id='updateCodeFailure' style='display:none;' align='center'>
	<p style="color:red;">Code Update Failed. Please Revert 
	<!--<br> 
	Perform manual update as follows, <br>
	1. Rename folder htdocs in BLIS folder to htdocs_backup <br>
	2. Unzip htdocs.zip to BLIS folder <br>
	3. Check to see that htdocs folder now contains a list of folders with the first file named C4G BLIS v2.0<br>
	4. Now close your browser and then restart BLIS.exe <br>
	5. Done-->
	</p>
</div>

<div id='updateDatabaseFailure' style='display:none;' align='center'>
	<p style="color:red;">Database Update Failed.</p>
</div>

<script type="text/javascript">
	performUpdate();
</script>

</body>
</html>