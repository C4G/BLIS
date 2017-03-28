<?php
/**
 * Created by PhpStorm.
 * User: SaiTeja
 * Date: 9/29/2016
 * Time: 12:24 PM
 */

include('../includes/db_lib.php');
include('../includes/page_elems.php');

$site_id_list = $_REQUEST['sites'];
$site_choice_enabled = $_REQUEST['site_choice_enabled'];

foreach ($site_id_list as $site_id)
{
    Sites::removeSite($site_id);
}

$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
$lab_config->updateSiteEntryChoice($site_choice_enabled);

?>
