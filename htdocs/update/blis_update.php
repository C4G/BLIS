<?php
ini_set('max_execution_time', 300); 
ini_set('memory_limit','300M');
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

$def = '';
global $VERSION;
$vers = $VERSION;
if ( is_super_admin($user) || is_country_dir($user) ) 
{
	$db_name = "blis_revamp";
    $ufile = "db_update_revamp_$vers";
    blis_db_update($lab_config_id, $db_name, $ufile);
    update_language_files();
    insertVersionDataEntry();
		
	$labConfigList = get_lab_configs($user->userId);
	foreach($labConfigList as $labConfig)
	 {
		$labConfigId = $labConfig->id;
		runUpdate($labConfigId);
    }
	 update_language_files();
	//runGlobalUpdate();
    	
}
else {
	$lab_config_id = $_SESSION['lab_config_id'];
	//runUpdate($labConfigId);
        # revamp update
        $db_name = "blis_revamp";
        $ufile = "db_update_revamp_$vers";
        blis_db_update($lab_config_id, $db_name, $ufile);
        
        # lab update
        $db_name = "blis_".$lab_config_id;
        $ufile = "db_update_lab_$vers";
        blis_db_update($lab_config_id, $db_name, $ufile);
        update_language_files();
        $def = default_currency_copy($lab_config_id);
        insertVersionDataEntry();
        
	//runGlobalUpdate();
}

function runUpdate($lab_config_id)
{        
global $VERSION;
$vers = $VERSION;
        # revamp update
       // $db_name = "blis_revamp";
       // $ufile = "db_update_revamp";
       // blis_db_update($lab_config_id, $db_name, $ufile);
        

		 # lab update
	  	$db_name = "blis_".$lab_config_id;
        $ufile = "db_update_lab_$vers";
        blis_db_update($lab_config_id, $db_name, $ufile);       
        $def = default_currency_copy($lab_config_id);
        insertVersionDataEntry($lab_config_id);
}

//echo "Updated";

//echo $def;
echo "true";
?>