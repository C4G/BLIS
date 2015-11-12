<?php
#
# Adds a new patient record
# Called via Ajax from new_patient.php
#

include("../includes/db_lib.php");

$saved_session = SessionUtil::save();

$card_num = $_REQUEST['card_num']; # DB key
$addl_id = $_REQUEST['addl_id'];
$name = ucwords(strtolower($_REQUEST['name']));
$age = $_REQUEST['age'];
$age_param = $_REQUEST['agep'];
$receipt_yyyy = $_REQUEST['receipt_yyyy'];
$receipt_mm = $_REQUEST['receipt_mm'];
$receipt_dd = $_REQUEST['receipt_dd'];
$date_receipt=trim($_REQUEST['receipt_yyyy'])."-".trim($_REQUEST['receipt_mm'])."-".trim($_REQUEST['receipt_dd'])." 00:00:00";//mktime(0, 0, 0, $receipt_mm, $receipt_dd, $receipt_yyyy);
$pid = $_REQUEST['pid']; # Surrogate key
# Check partial DOB flags
$dob = "";
$partial_dob = "";

$uiinfo = "agep=".$age_param;
putUILog('patient_add', $uiinfo, basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

if(trim($_REQUEST['yyyy']) == "" && trim($_REQUEST['mm']) == "" && trim($_REQUEST['dd']) == "")
{
	# Only age specified
	# Set year in partial_dob field to auto-update age value in the future
	$today = date("Y-m-d");
	$today_parts = explode("-", $today);
	
	# Find year of birth based on supplied age value
	if($age_param == 2)
	{
		# Age was specified in months
		$timestamp = mktime(0, 0, 0, $today_parts[1]-($age), $today_parts[2], $today_parts[0]);
		$year = date("Y", $timestamp);
		$month = date("m", $timestamp);
		$day = date("d", $timestamp);
		$dob = "";
		$partial_dob = $year."-".$month."-".$day;
	}
	else if($age_param == 1)
	{
		# Age specified in years
		$timestamp = mktime(0, 0, 0, $today_parts[1], $today_parts[2], $today_parts[0]-$age);
		$year = date("Y", $timestamp);
		$month = date("m", $timestamp);
		$day = date("d", $timestamp);
		$dob = "";
		$partial_dob = $year."-".$month."-".$day;
	}
	else if($age_param == 3)
	{
		# Age specified in days
		$timestamp = mktime(0, 0, 0, $today_parts[1], $today_parts[2]-($age), $today_parts[0]);
		$year = date("Y", $timestamp);
		$month = date("m", $timestamp);
		$day = date("d", $timestamp);
		$dob = "";
		$partial_dob = $year."-".$month."-".$day;
	}
	else if($age_param == 4)
	{
		# Age specified in weeks
		$age=$age*7;
		$timestamp = mktime(0, 0, 0, $today_parts[1], $today_parts[2]-($age), $today_parts[0]);
		$year = date("Y", $timestamp);
		$month = date("m", $timestamp);
		$day = date("d", $timestamp);
		$dob = "";
		$partial_dob = $year."-".$month."-".$day;
	}
	else if($age_param == 5) {
		#age specified in range:
		$pos=1;
		$pos = strpos($age, ">");
		$pos1=strpos($age,"-");
	 
		if($pos1==2||$pos1==1) {
			$age_parts=explode("-",$age);
			$age=$age_parts[0]+$age_parts[1];
			$age=-1*$age/2;
		
		} 
		else if($pos==0){
			$age1 = substr($age,1); 
			$age=$age1-200;
		}
		$dob="";
		$partial_dob="";
	}

	# Reset age to 0
	if($age_param != 5)
		$age = 0;
}
else if($_REQUEST['pd_ym'] == 1)
{
	# Partial DOB with year-month only
	$dob = "";
	$partial_dob = trim($_REQUEST['yyyy'])."-".trim($_REQUEST['mm']);
}
else if($_REQUEST['pd_y'] == 1)
{
	# Partial DOB with year only
	$dob = "";
	$partial_dob = trim($_REQUEST['yyyy']);
}
else
{
	# Full DOB or age
	$dob = trim($_REQUEST['yyyy'])."-".trim($_REQUEST['mm'])."-".trim($_REQUEST['dd']);
	$partial_dob = "";
}
if($age == "")
	$age = 0;
$sex = $_REQUEST['sex'];

$patient = new Patient();
$patient->patientId = $card_num;
$patient->addlId = $addl_id;
$patient->name = $name;
$patient->dob = $dob;
$patient->partialDob = $partial_dob;
$patient->age = $age;
$patient->sex = $sex;
$patient->regDate=$date_receipt;
$patient->surrogateId = $pid;
$patient->createdBy = $_SESSION['user_id'];
update_daily_number_registration();
$patient_added = add_patient($patient);
echo json_encode($patient_data);
SessionUtil::restore($saved_session);
?>