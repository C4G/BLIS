<?php
#
# Updates options to use or hide non-mandatory fields for specimens and patients
# Called via Ajax from lab_config_home.php
#

include("../users/accesslist.php");
include("../includes/field_order_update.php");
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
if(isset($_REQUEST['use_pid'])){
	
	//$use_pid = 1;
	
	//make sure we add the duplicate check also as part of pid
	/*
	0 not enabled
	1 enabled and not mandatory and allow duplicate
	2 enabled and manadatory and allow duplicate
	3 enabled and not mandatory and  no  duplicate
	4 enabled and mandfatory and  no duplicate

	*/
	
	if($_REQUEST['use_pid_radio'] == 'Y' && $_REQUEST['dup_pid_radio'] == 'Y')
		$use_pid = 2;
	elseif($_REQUEST['use_pid_radio'] == 'Y' && $_REQUEST['dup_pid_radio'] != 'Y')
		$use_pid = 4;
	elseif($_REQUEST['use_pid_radio'] != 'Y' && $_REQUEST['dup_pid_radio'] == 'Y')
		$use_pid = 1;
	elseif($_REQUEST['use_pid_radio'] !== 'Y' && $_REQUEST['dup_pid_radio'] != 'Y')
		$use_pid = 3;
		
}
if(isset($_REQUEST['use_p_addl']))
{
	$use_addl_id_patient = 1;
	if($_REQUEST['use_p_addl_radio'] == 'Y')
		$use_addl_id_patient = 2;
}
if(isset($_REQUEST['use_dnum']))
{
	if($lab_config->dailyNum >= 10)
        {
            $use_daily_num = 11;
        }
        else
        {
            $use_daily_num = 1;
        }
	if($_REQUEST['use_dnum_radio'] == 'Y')
        {
            if($lab_config->dailyNum >= 10)
            {
                $use_daily_num = 12;
            }
            else
            {
                $use_daily_num = 2;
            }
        }
}
else
{
    if($lab_config->dailyNum >= 10)
        {
            $use_daily_num = 10;
        }
        else
        {
            $use_daily_num = 0;
        }
	
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
	if($lab_config->age >= 10)
        {
            $use_age = 11;
        }
        else
        {
            $use_age = 1;
        }
	if($_REQUEST['use_age_radio'] == 'Y')
        {
            if($lab_config->age >= 10)
            {
                $use_age = 12;
            }
            else
            {
                $use_age = 2;
            }
        }
}
else
{
    if($lab_config->dailyNum >= 10)
        {
            $use_daily_num = 10;
        }
        else
        {
            $use_daily_num = 0;
        }
	
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

// 1. delete existing entry from the field order table
FieldOrdering::deleteFieldOrderEntry($lab_config->id, 1);
FieldOrdering::deleteFieldOrderEntry($lab_config->id, 2);


// 2. Enter a new row for the same lab config and form
		/* $field_ordering = new FieldOrdering();
		 // default values
		$field_ordering->form_id = 1;
		$field_ordering->id = $_SESSION['lab_config_id']; */
		/* 
		$field_ordering->field1 = -1;
		$field_ordering->field2 = -1;
		$field_ordering->field3 = -1;
		$field_ordering->field4 = -1;
		$field_ordering->field5 = -1;
		$field_ordering->field6 = -1;
		$field_ordering->field7 = -1;
		$field_ordering->field8 = -1;
		$field_ordering->field9 = -1;
		$field_ordering->field10 = -1;
		$field_ordering->field11 = -1;
		$field_ordering->field12 = -1;
		$field_ordering->field13 = -1;
		$field_ordering->field14 = -1;
		$field_ordering->field15 = -1;
		$field_ordering->field16 = -1;
		$count = 1;
		
		if(isset($lab_config->pid) && $lab_config->pid > 0){
		    $field_ordering->{field.$count} = "pid";
			$count++;
		}
		//p_addl
		if(isset($lab_config->patientAddl) && $lab_config->patientAddl> 0){
		    $field_ordering->{field.$count} = "patientaddl";
			$count++;
		}//dnum
		if(isset($lab_config->dailyNum) &&  $lab_config->dailyNum > 0){
		    $field_ordering->{field.$count} = "dnum";
			$count++;
		}//pname
		if(isset($lab_config->pname) && $lab_config->pname > 0){
		    $field_ordering->{field.$count} = "pname";
			$count++;
		}//sex
		if(isset($lab_config->sex) && $lab_config->sex> 0){
		    $field_ordering->{field.$count} = "sex";
			$count++;
		}//age
		if(isset($lab_config->age) && $lab_config->age > 0){
		    $field_ordering->{field.$count} = "age";
			$count++;
		}//dob
		if(isset($lab_config->dob) && $lab_config->dob > 0){
		    $field_ordering->{field.$count} = "dob";
			$count++;
		}
		//sid
		if(isset($lab_config->sid) && $lab_config->sid > 0){
		    $field_ordering->{field.$count} = "sid";
			$count++;
		}
		//s_addl
		if(isset($lab_config->specimenAddl) && $lab_config->specimenAddl > 0){
		    $field_ordering->{field.$count} = "specimenaddl";
			$count++;
		}
		//refout
		if(isset($lab_config->refout) && $lab_config->refout > 0){
		    $field_ordering->{field.$count} = "refout";
			$count++;
		}
		//rdate
		if(isset($lab_config->rdate) && $lab_config->rdate > 0){
		    $field_ordering->{field.$count} = "rdate";
			$count++;
		}
		//COMM
		if(isset($lab_config->comm) && $lab_config->comm > 0){
		    $field_ordering->{field.$count} = "comm";
			$count++;
		}
		//agelimit
		if(isset($lab_config->agelimit) && $lab_config->agelimit > 0){
		    $field_ordering->{field.$count} = "agelimit";
			$count++;
		}
 */		
	//FieldOrdering::add_fieldOrdering($field_ordering);
	
		//field_order_update::install_first_order($lab_config);

SessionUtil::restore($saved_session);
?>