<?php
#
# Main page for deleting a lab configuration
# Called via Ajax from lab_config_home.php
#

include("../includes/db_lib.php");
$lab_config_id = $_REQUEST['id'];
# Delete DB tables corresponding to this lab configuration
delete_lab_config($lab_config_id);
# Delete corresponding langdata folder
if($SERVER != $ON_ARC)
{
	$langdata_dir = $LOCAL_PATH."langdata_".$lab_config_id;
	$file_list = array();
	if ($handle = opendir($langdata_dir))
	{
		while (false !== ($file = readdir($handle)))
		{
			if($file === "." || $file == "..")
				continue;
			$file_list[] = $langdata_dir."/$file";
		}
	}
	foreach($file_list as $file)
	{
		unlink($file);
	}
	rmdir($langdata_dir);
}
?>

