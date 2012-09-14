<?php
#
# Updates options to use or hide non-mandatory fields for specimens and patients
# Called via Ajax from lab_config_home.php
#

include("../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList))
    && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList))
    && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) ) {
	displayForbiddenMessage();
}

$saved_session = SessionUtil::save();

$lab_config = LabConfig::getById($_REQUEST['lab_config_id']);
if($lab_config == null)
{
	SessionUtil::restore($saved_session);
	return;
}

# Patient related fields
$use_pid = 0;
$use_addl_id_patient = 0;
$mand_addl_id_patient = 0;
$use_daily_num = 0;
$mand_daily_num = 0;
$use_pname = 0;
$mand_pname = 0;
$use_sex = 0;
$use_age = 0;
$mand_age = 0;
$use_dob = 0;
$mand_age = 0;
$ageLimit = 5;
//$show_pname = 1;

# Specimen related fields
$use_sid = 0;
$use_addl_id_specimen = 0;
$mand_addl_id_specimen = 0;
$use_refout = 0;
$use_doctor = 0;
$mand_refout = 0;
$use_rdate = 0;
$mand_rdate = 0;
$use_comm = 0;
$mand_comm = 0;

# Patient related fields
if(isset($_REQUEST['use_pid']))
{
	$use_pid = 1;
	if($_REQUEST['use_pid_radio'] == 'Y')
		$use_pid = 2;
}
if(isset($_REQUEST['use_p_addl']))
{
	$use_addl_id_patient = 1;
	if($_REQUEST['use_p_addl_radio'] == 'Y')
		$use_addl_id_patient = 2;
}
if(isset($_REQUEST['use_dnum']))
{
	$use_daily_num = 1;
	if($_REQUEST['use_dnum_radio'] == 'Y')
		$use_daily_num = 2;	
}
if(isset($_REQUEST['use_pname']))
{
	$use_pname = 1;
	if($_REQUEST['use_pname_radio'] == 'Y')
		$use_pname = 2;
}
if(isset($_REQUEST['use_sex']))
{
	$use_sex = 2;
	//if($_REQUEST['use_sex_radio'] == 'Y')
//		$use_sex = 2;
}
if(isset($_REQUEST['use_age']))
{
	$use_age = 1;
	if($_REQUEST['use_age_radio'] == 'Y')
		$use_age = 2;
}
if(isset($_REQUEST['use_dob']))
{
	$use_dob = 1;
	if($_REQUEST['use_dob_radio'] == 'Y')
		$use_dob = 2;
}
if(isset($_REQUEST['use_sid']))
{
	$use_sid = 2;
}
if(isset($_REQUEST['use_s_addl']))
{
	$use_addl_id_specimen = 1;
	if($_REQUEST['use_s_addl_radio'] == 'Y')
		$use_addl_id_specimen = 2;
}
if(isset($_REQUEST['use_refout']))
{
	$use_refout = 1;
	if($_REQUEST['use_refout_radio'] == 'Y')
		$use_refout = 2;
}
if(isset($_REQUEST['use_doctor']))
{
	$use_doctor = 1;
	if($_REQUEST['use_doctor_radio'] == 'Y')
		$use_doctor = 2;
}
if(isset($_REQUEST['use_rdate']))
{
	$use_rdate = 1;
	if($_REQUEST['use_rdate_radio'] == 'Y')
		$use_rdate = 2;
}
if(isset($_REQUEST['use_comm']))
{
	$use_comm = 1;
	if($_REQUEST['use_comm_radio'] == 'Y')
		$use_comm = 2;
}
if(isset($_REQUEST['ageLimit']))
{
	$ageLimit = $_REQUEST['ageLimit'];
}
if($_REQUEST['show_pname_radio'] == 'Y')
	$show_pname = 0;

if($lab_config->pid != $use_pid)
	$lab_config->updatePid($use_pid);
if($lab_config->patientAddl != $use_addl_id_patient)
	$lab_config->updatePatientAddl($use_addl_id_patient);
if($lab_config->dailyNum != $use_daily_num)
	$lab_config->updateDailyNum($use_daily_num);
if($lab_config->specimenAddl != $use_addl_id_specimen)
	$lab_config->updateSpecimenAddl($use_addl_id_specimen);
if($lab_config->sid != $use_sid)
	$lab_config->updateSid($use_sid);
if($lab_config->comm != $use_comm)
	$lab_config->updateComm($use_comm);
if($lab_config->rdate != $use_rdate)
	$lab_config->updateRdate($use_rdate);
if($lab_config->refout != $use_refout)
	$lab_config->updateRefout($use_refout);
if($lab_config->sex != $use_sex)
	$lab_config->updateSex($use_sex);
if($lab_config->age != $use_age)
	$lab_config->updateAge($use_age);
if($lab_config->dob != $use_dob)
	$lab_config->updateDob($use_dob);
if($lab_config->pname != $use_pname)
	$lab_config->updatePname($use_pname);
if($lab_config->ageLimit != $ageLimit )
	$lab_config->updateAgeLimit($ageLimit);
$lab_config->updateDateFormat($_REQUEST['dformat']);
$lab_config->updateDailyNumReset($_REQUEST['dnum_reset']);
$lab_config->updateDoctor($use_doctor);
//$lab_config->updateHidePatientName($show_pname);

SessionUtil::restore($saved_session);
?>