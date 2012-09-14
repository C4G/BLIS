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
include("../includes/db_lib.php");
include("../includes/user_lib.php");

LangUtil::setPageId("update");

$user = get_user_by_id($_SESSION['user_id']);

if ( is_super_admin($user) || is_country_dir($user) ) {
	$labConfigList = get_lab_configs($user->userId);
	foreach($labConfigList as $labConfig) {
		$labConfigId = $labConfig->id;
		runUpdate($labConfigId);
	}
	//runGlobalUpdate();
}
else {
	$labConfigId = $_SESSION['lab_config_id'];
	runUpdate($labConfigId);
	//runGlobalUpdate();
}

function runUpdate($lab_config_id) {
        
        # v2.2 Update
	$db_name = "blis_".$lab_config_id;
        $ufile = "db_update_v2-2";
        blis_db_update($lab_config_id, $db_name, $ufile);
}

echo "true";
?>