<?php
#
# Main file for updating to new version
# Included from header.php
# Version information stored under update.xml
#

include("../lang/lang_xml2php.php");


# Do nothing for the moment
/*
if(isset($_SESSION['no_updates']) && $_SESSION['no_updates'] == 1)
{
	# No updates to perform.
	return;
}

$LANGDATA_PATH = "../../local/langdata_128/";
if($SERVER == $ON_ARC)
{
	$LANGDATA_PATH = "../../local/langdata_128/";
}
*/

$update_txt = "../update/update.txt";
if(file_exists($update_txt) === false)
{
	# Update file not found. Update already performed
	# Set session variable to avoid checking file_exists hereafter
	$_SESSION['no_updates'] = 1;
	return;
}

# Perform update and delete update.xml file
/*
# Overwrite from /update/default.php to ../langdata/default.php
if(!rename($LANGDATA_PATH."default.xml", $LANGDATA_PATH."default_bak.xml"))
{
	# Rename failed, revert
	return;
}
$source_file = "../update/default.xml";
$destination_file = $LANGDATA_PATH."default.xml";
if(!copy($source_file, $destination_file))
{
	# Copy failed, revert
	rename($LANGDATA_PATH."default_bak.xml", $LANGDATA_PATH."default.xml");
	return;
}
lang_xml2php("default", $LANGDATA_PATH);
# Copying successful, remove backup copy
unlink($LANGDATA_PATH."default_bak.xml");

# Append new mappings from /update/en.xml to ../langdata/en.xml
if(!rename($LANGDATA_PATH."en.xml", $LANGDATA_PATH."en_bak.xml"))
{
	# Rename failed, revert
	return;
}
$old_xml_file = $LANGDATA_PATH."en_bak.xml";
$new_xml_file = "../update/en.xml";
$destn_xml_file = $LANGDATA_PATH."en.xml";
if(!append_mappings($old_xml_file, $new_xml_file, $destn_xml_file))
{
	# Mappings failed, revert
	rename($LANGDATA_PATH."en_bak.xml", $LANGDATA_PATH."en.xml");
	return;
}
lang_xml2php("en", $LANGDATA_PATH);
unlink($LANGDATA_PATH."en_bak.xml");
# Append new mappings from /update/fr.xml to ../langdata/fr.xml
if(!rename($LANGDATA_PATH."fr.xml", $LANGDATA_PATH."fr_bak.xml"))
if(false)
{
	# Rename failed, revert
	return;
}
$old_xml_file = $LANGDATA_PATH."fr_bak.xml";
$new_xml_file = "../update/fr.xml";
$destn_xml_file = $LANGDATA_PATH."fr.xml";
if(!append_mappings($old_xml_file, $new_xml_file, $destn_xml_file))
{
	# Mappings failed, revert
	rename($LANGDATA_PATH."fr_bak.xml", $LANGDATA_PATH."fr.xml");
	return;
}
lang_xml2php("fr", $LANGDATA_PATH);
unlink($LANGDATA_PATH."fr_bak.xml");
*/

//echo "update.php";
//Hiral
//Step1: Add the queries here by giving proper database number and selecting propoer database
//Step2: Make an update.txt file in the update folder. Logic: When we send the update the txt file exists so it executes these updates. But once it excutes these updates,
//the file is delinked and hence in future the update.php file is not run.

$saved_db = DbUtil::switchToLabConfigRevamp(129);
# Increase size of 'result' field in 'test' table to accomodate hash value
/*$query_string = 
	"ALTER TABLE `stock_details` ADD `NewC23` VARCHAR(50)";
query_alter($query_string);

# Add 'hash_value' field to 'patient' table
$query_string = 
	"ALTER TABLE `patient` ADD COLUMN `hash_value` VARCHAR(100)";
//query_alter($query_string);

# Populate existing patient entries with corresponding hash values
$query_string = "SELECT * FROM patient";

$resultset = query_associative_all($query_string, $row_count);
foreach($resultset as $record)
{
	$patient = Patient::getObject($record);
	$hash_value = $patient->generateHashValue();
	$patient->setHashValue($hash_value);
}

# Populate existing result entries with patient hash values
foreach($resultset as $record)
{
	$patient = Patient::getObject($record);
	$patient_hash = $patient->getHashValue();
	# Fetch all existing completed test entries for this patient
	$query_tests = 
		"SELECT t.* FROM test t, specimen s ".
		"WHERE s.specimen_id=t.specimen_id ".
		"AND s.patient_id=$patient->patientId ".
		"AND t.result <> ''";
	$test_records = query_associative_all($query_tests, $test_count);
	foreach($test_records as $test_record)
	{
		$test_entry = Test::getObject($test_record);
		$result_value = $test_entry->result.$patient_hash;
		$query_update =
			"UPDATE test SET result='$result_value' ".
			"WHERE test_id=$test_entry->testId";
		query_update($query_update);
	}
}*/
$saved_db = DbUtil::switchToLabConfigRevamp(127);

$query_string="ALTER TABLE `blis_revamp_127`.`measure` CHANGE COLUMN `range` `range` VARCHAR(1000) NOT NULL";
   mysql_query($query_string);
DbUtil::switchRestore($saved_db);
$saved_db = DbUtil::switchToLabConfigRevamp(128);

$query_string="ALTER TABLE `blis_revamp_128`.`measure` CHANGE COLUMN `range` `range` VARCHAR(1000) NOT NULL";
   mysql_query($query_string);
DbUtil::switchRestore($saved_db);
$saved_db = DbUtil::switchToLabConfigRevamp(129);

$query_string="ALTER TABLE `blis_revamp_129`.`measure` CHANGE COLUMN `range` `range` VARCHAR(1000) NOT NULL";
   mysql_query($query_string);
DbUtil::switchRestore($saved_db);
$saved_db = DbUtil::switchToLabConfigRevamp(131);

$query_string="ALTER TABLE `blis_revamp_131`.`measure` CHANGE COLUMN `range` `range` VARCHAR(1000) NOT NULL";
   mysql_query($query_string);
DbUtil::switchRestore($saved_db);
# Delete update.txt 
unlink($update_txt);
$_SESSION['no_updates'] = 1;
?>