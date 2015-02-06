<?php
#
# Deletes a driver file
# Called via Ajax from lab_config_home.php
#

	include("../includes/db_lib.php");

	$driver_id = $_REQUEST['id'];
	$driver_file = ".php";

	# Delete DB tables entries corresponding to this driver
	$saved_db = DbUtil::switchToGlobal();
	$query = sprintf("SELECT driver_name FROM machine_drivers WHERE id = %s", mysql_real_escape_string($driver_id));
	$resultset = query_associative_one($query);

	if($resultset != null){

		foreach($resultset as $record)
		{
			$driver_file =  $record['driver_name'].$driver_file;
		}
	}


	$query = sprintf("DELETE FROM machine_drivers WHERE id = %s", mysql_real_escape_string($driver_id));
	query_delete($query);

	DbUtil::switchToLabConfig($lab_config_id);

DbUtil::switchRestore($saved_db);

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

