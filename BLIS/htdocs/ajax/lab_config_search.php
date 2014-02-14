<?php
#
# Searches for lab configurations by search term
# Called via Ajax from lab_configs.php
#

session_start();
include("../includes/db_lib.php");
include("../includes/user_lib.php");
include("../includes/page_elems.php");

$page_elems = new PageElems();
$search_term = trim($_REQUEST['q']);
$admin_user_id = $_SESSION['user_id'];

$lab_config_list = get_lab_configs($admin_user_id);
if($search_term == "")
{
	# Return all entries
	$page_elems->getLabConfigTable($lab_config_list);
	return;
}
# Narrow down to matched configurations
$matched_lab_config_list = array();
foreach($lab_config_list as $lab_config)
{
	if(stripos($lab_config->getSiteName(), $search_term) !== false)
	{		
		$matched_lab_config_list[] = $lab_config;
	}
	else
	{
		$username = get_username_by_id($lab_config->adminUserId);
		if(stripos($username, $search_term)  !== false)
			$matched_lab_config_list[] = $lab_config;
	}
}
$page_elems->getLabConfigTable($matched_lab_config_list);
?>