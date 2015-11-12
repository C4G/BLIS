<?php
include_once "../includes/db_lib.php";

function getAuxID($fromAnalyzer,$dbname)
{
	$parts = explode(".",$fromAnalyzer);
	$patient_id ="";
	$specimen_id ="";
	if(count($parts) > 1)
	{
		$patient_id = $parts[0];
		$specimen_id =  $parts[1];
		$ret= API::getSpecimenID($patient_id,$specimen_id,$dbname);
		if($ret == NULL)
			return $fromAnalyzer;
		else 
			return $ret;
			
	}
	else
	{
		return $fromAnalyzer;
	}
}
