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

$def = '';
global $VERSION;

$saved_db = DbUtil::switchToGlobal();
$query = "SELECT max(version) version FROM version_data";
$record = query_associative_one($query);
DbUtil::switchRestore($saved_db);

$vers = $record['version']; 

$version_list = array("2.2","2.3","2.4","2.5","2.6","2.7","2.8","2.9","2.91","3.0","3.1","3.2","3.21","3.3", "3.4");

$version_doc_admin = array("db_update_v2-2","db_update_revamp_2.3","db_update_revamp_2.4","db_update_revamp_2.5","db_update_revamp_2.6","db_update_revamp_2.7","db_update_revamp_admin_2.8","","db_update_revamp_2.91","db_update_revamp_3.0","","db_update_revamp_3.2","db_update_revamp_3.21","", "db_update_revamp_3.4");
$version_doc_revamp = array("db_update_v2-2","db_update_revamp_2.3","db_update_revamp_2.4","db_update_revamp_2.5","db_update_revamp_2.6","db_update_revamp_2.7","db_update_revamp_2.8","","db_update_revamp_2.91", "db_update_revamp_3.0","","db_update_revamp_3.2","db_update_revamp_3.21","", "db_update_revamp_3.4");
$version_doc_lab = array("db_update_v2-2","db_update_lab_2.3","db_update_lab_2.4","db_update_lab_2.5","db_update_lab_2.6","db_update_lab_2.7","db_update_lab_2.8","","","db_update_lab_3.0","","db_update_lab_3.2","db_update_lab_3.21","db_update_lab_3.3");

$retstr1 = "";
$retstr2 = "";
$retstr3 = "";

$v_index = 0;
while($v_index<count($version_list)) {
    if($version_list[$v_index] == $vers)
    {
        $v_index++;
        while($v_index<count($version_list)){
            if ( is_super_admin($user) || is_country_dir($user) ) {
                if($version_doc_admin[$v_index] != ""){
                    $db_name = "blis_revamp";
                    $ufile = $version_doc_admin[$v_index];
                    blis_db_update($lab_config_id, $db_name, $ufile);
                    $retstr1 =  $retstr1.$version_doc_admin[$v_index]; 
                }
                
            }
            else {
                $lab_config_id = $_SESSION['lab_config_id'];

                # revamp update
                if($version_doc_revamp[$v_index] != ""){
                    $db_name = "blis_revamp";
                    $ufile =  $version_doc_revamp[$v_index];
                    blis_db_update($lab_config_id, $db_name, $ufile);
                    $retstr2 =  $retstr2.$version_doc_revamp[$v_index];
                }

                # lab update
                if($version_doc_lab[$v_index] != ""){
                    $db_name = "blis_".$lab_config_id;
                    $ufile = $version_doc_lab[$v_index];
                    blis_db_update($lab_config_id, $db_name, $ufile);
                    
                    $retstr3 =  $retstr3.$version_doc_lab[$v_index];
                }
                //runGlobalUpdate();
            }
            $v_index++;
        }
        break;
    }
    $v_index++;
}

if ( is_super_admin($user) || is_country_dir($user) ) {
    update_language_files();
    // insertVersionDataEntry();
}
else {
    $lab_config_id = $_SESSION['lab_config_id'];
    update_language_files();
    $def = default_currency_copy($lab_config_id);
    // insertVersionDataEntry();
}

$saved_db = DbUtil::switchToGlobal();
global $VERSION;
$vers = $VERSION;
$status = 1;
$uid = $_SESSION['user_id'];
$query_string = "INSERT INTO version_data (version, status, user_id, i_ts) VALUES ('$vers', $status, '$uid', NOW())";
query_insert_one($query_string);
DbUtil::switchRestore($saved_db);

// echo $retstr1.$retstr2.$retstr3;
echo "true"
?>