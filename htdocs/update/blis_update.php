<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main file for updating to new version
# Calls ajax/update.php which actually performs the update operations

include("redirect.php");
include("../includes/db_lib.php");
include("../includes/user_lib.php");

LangUtil::setPageId("update");

$user = get_user_by_id($_SESSION['user_id']);

$def = '';

if ( is_super_admin($user) || is_country_dir($user) ) {

    $db_name = "blis_revamp";
        $ufile = "db_update_revamp";
        blis_db_update($lab_config_id, $db_name, $ufile);
        update_language_files();
        insertVersionDataEntry();
}
else {
	$lab_config_id = $_SESSION['lab_config_id'];

    # revamp update
    $db_name = "blis_revamp";
    $ufile = "db_update_revamp_2.8";
    blis_db_update($lab_config_id, $db_name, $ufile);
    
    # lab update
    $db_name = "blis_".$lab_config_id;
    #$ufile = "db_update_lab_2.7.1";
    $ufile = "db_update_lab_2.8";
    blis_db_update($lab_config_id, $db_name, $ufile);
    update_language_files();
    $def = default_currency_copy($lab_config_id);
    insertVersionDataEntry();
}

echo "true";
?>