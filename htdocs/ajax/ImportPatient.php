<?php

include("../includes/db_lib.php");

$user = get_user_by_id($_SESSION['user_id']);
$country = strtolower($user->country);
$userId = $_SESSION['user_id'];
$labConfigId = get_lab_config_id($userId);

$globalPatientId = $_REQUEST['patientId'];
//$importLabConfigId = getLabIdFromGlobalPatientId($globalPatientId, $country);
//$importLabConfigId = substr($globalPatientId, 0, 3);
//$subValue = $importLabConfigId."00000000000";
//$importPatientIdStr = bcsub($globalPatientId, $subValue);
//$importPatientId = intval($importPatientIdStr);

$saved_db = DbUtil::switchToCountry($country);
$querySelect = 
	"SELECT * FROM patient ".
	"WHERE patient_id=$patientId";
$patientRecord = query_associative_one($querySelect);
DbUtil::switchRestore($saved_db);

$saved_db = DbUtil::switchToLabConfig($importLabConfigId); 

$querySelect = 
	"SELECT * FROM specimen ".
	"WHERE patient_id=$importPatientId";
$resultset = query_associative_all($querySelect, $rowCount);

foreach($resultset as $record)
	$specimenRecords[] = Specimen::getObject($record);

foreach($specimenRecords as $specimenRecord) {
	$querySelect = 
		"SELECT * FROM test ".
		"WHERE specimen_id=$specimenRecord->specimenId";
	$resultset = query_associative_all($querySelect, $rowCount);
	foreach($resultset as $record) {
		$testRecords[] = Test::getObject($record);
	}
}
DbUtil::switchRestore($saved_db);
	
/* Build a mapping of Specimens from the Global Table & make appropriate substitutions */
$saved_db = DbUtil::switchToGlobal();
$querySelect = 
	"SELECT * FROM specimen_mapping";
$resultset = query_associative_all($querySelect, $rowCount);
if($resultset) {
	$specimenIds = array();
	foreach($resultset as $record) {
		$labIdSpecimenIds = explode(";",$record['lab_id_specimen_id']);
		foreach( $labIdSpecimenIds as $labIdSpecimenId) {
			$labIdSpecimenIdsSeparated = explode(":",$labIdSpecimenId);
			$labId = $labIdSpecimenIdsSeparated[0];
			$specimenId = $labIdSpecimenIdsSeparated[1];
			$specimenIds[$labId] = $specimenId;
		}
		foreach($specimenRecords as $specimenRecord) {
			if ( $specimenIds[$labConfigId] == $specimenRecord->specimenTypeId )
				$specimenRecord->specimenTypeId = $specimenIds[$importLabConfigId];
		}
	}	
}

/* Build a mapping of Tests from the Global Table & make appropriate substitutions */
$querySelect = 
	"SELECT * FROM test_mapping";
$resultset = query_associative_all($querySelect, $rowCount);
if($resultset) {
	$testIds = array();
	foreach($resultset as $record) {
		$labIdTestIds = explode(";",$record['lab_id_test_id']);
		foreach($labIdTestIds as $labIdTestId) {
			$labIdTestIdsSeparated = explode(":",$labIdTestId);
			$labId = $labIdTestIdsSeparated[0];
			$testId = $labIdTestIdsSeparated[1];
			$testIds[$labId] = $testId;
		}
		foreach($testRecords as $testRecord) {
			if ( $testIds[$labConfigId] == $testRecord->testTypeId )
				$testRecord->testTypeId = $testIds[$importLabConfigId];
		}
	}
}
DbUtil::switchRestore($saved_db);

$saved_db = DbUtil::switchToLabConfig($importLabConfigId);
$querySelect = 
	"SELECT * FROM patient ".
	"WHERE patient_id=$importPatientId";
$record = query_associative_one($querySelect);
$patientName = $record['name'];

$patient = Patient::getObject($record);
$patient->createdBy = $_SESSION['user_id'];
DbUtil::switchRestore($saved_db);

add_patient($patient);

$querySelect =
	"SELECT patient_id FROM patient ".
	"WHERE name like '$patientName' ";
$record = query_associative_one($querySelect);
$newPatientId = $record['patient_id'];

/* Create New Specimen & Test Records */
$i=0;
foreach($specimenRecords as $specimenRecord) {
	$saved_db = DbUtil::switchToLabConfig($importLabConfigId); 
	$querySelect = 
		"SELECT * FROM test ".
		"WHERE specimen_id=$specimenRecord->specimenId";
	$resultset = query_associative_all($querySelect, $rowcount);
	DbUtil::switchRestore($saved_db);
	$specimenRecord->specimenId = get_max_specimen_id() + 1;
	$specimenRecord->patientId = $newPatientId;
	$specimenRecord->userId = $_SESSION['user_id'];
	$specimenRecord->doctor = '';
	add_specimen($specimenRecord);
	for($j=0;$j<count($resultset);$j++) {
		$testRecord = $testRecords[$i];
		$testRecord->specimenId = $specimenRecord->specimenId;
		$testRecord->userId = $_SESSION['user_id'];
		$i++;
		add_test($testRecord);
	}
}
DbUtil::switchRestore($saved_db);
?>
<script type="text/javascript">
window.location="../new_specimen.php?pid=<?php echo $newPatientId; ?>";
</script>