<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for showing lab configuration status
# Called via Ajax from lab_configs.php
#

include("../users/accesslist.php");
if( !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	&& !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) )
	header( 'Location: home.php' );

include("redirect.php");
include("includes/page_elems.php");
LangUtil::setPageId("lab_configs");

$page_elems = new PageElems();
$lab_config_id = $_REQUEST['id'];
$page_elems->getLabConfigStatus($lab_config_id);
?>