<?php

include("../includes/db_lib.php");
include("../includes/user_lib.php");

$patientId = $_REQUEST['p_id'];
$logType = $_REQUEST['log_type'];

$saved_db = DbUtil::switchToGlobal();
$query_configs = "SELECT created_by, creation_date from user_log where patient_id =  ".$patientId." and log_type = '".$logType."'";
$resultset = query_associative_all($query_configs,0);
DbUtil::switchRestore($saved_db);


$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);
$queryString = "SELECT t_fields from report_config where report_id =1 ";
$record2 = query_associative_one($queryString);
$test_field_list = explode(",", $record2['t_fields']);
DbUtil::switchRestore($saved_db);

if ($resultset != null && (($logType == 'PRINT' && $test_field_list[10]) || ($logType == 'RESULT' && $test_field_list[11]) ) == '1' ){
	$ret_str = "User id\t\t\t\t Print date";
	foreach( $resultset as $aish ) {
		$ret_str .= "\n  ".$aish['created_by']."\t\t\t\t".$aish['creation_date'];
	}
	echo $ret_str;	
}
else{
	echo "false";
}

?>