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
$doctor_use_pid = 0;
$doctor_use_addl_id_patient = 0;
$mand_addl_id_patient = 0;
$doctor_use_daily_num = 0;
$mand_daily_num = 0;
$doctor_use_pname = 0;
$mand_pname = 0;
$doctor_use_sex = 0;
$doctor_use_age = 0;
$mand_age = 0;
$doctor_use_dob = 0;
$mand_age = 0;
$ageLimit = 5;
//$show_pname = 1;

# Specimen related fields
$doctor_use_sid = 0;
$doctor_use_addl_id_specimen = 0;
$mand_addl_id_specimen = 0;
$doctor_use_refout = 0;
$doctor_use_doctor = 0;
$mand_refout = 0;
$doctor_use_rdate = 0;
$mand_rdate = 0;
$doctor_use_comm = 0;
$mand_comm = 0;


if(isset($_REQUEST['doctor_use_dnum']))
{
	if($lab_config->dailyNum >= 10)
        {
            $doctor_use_daily_num = 2;
        }
        else
        {
            $doctor_use_daily_num = 1;
        }
	if($_REQUEST['doctor_use_dnum_radio'] == 'Y')
        {
            if($lab_config->dailyNum >= 10)
            {
                $doctor_use_daily_num = 2;
            }
            else
            {
                $doctor_use_daily_num = 2;
            }
        }
}
else
{
    if($lab_config->dailyNum >= 10)
        {
            $doctor_use_daily_num = 2;
        }
        else
        {
            $doctor_use_daily_num = 2;
        }
	
}
if(isset($_REQUEST['doctor_use_pname']))
{
	$doctor_use_pname = 1;
	if($_REQUEST['doctor_use_pname_radio'] == 'Y')
		$doctor_use_pname = 2;
}
if(isset($_REQUEST['doctor_use_sex']))
{
	$doctor_use_sex = 2;
	//if($_REQUEST['doctor_use_sex_radio'] == 'Y')
//		$doctor_use_sex = 2;
}
if(isset($_REQUEST['doctor_use_age']))
{
	if($lab_config->age >= 10)
        {
            $doctor_use_age = 11;
        }
        else
        {
            $doctor_use_age = 1;
        }
	if($_REQUEST['doctor_use_age_radio'] == 'Y')
        {
            if($lab_config->age >= 10)
            {
                $doctor_use_age = 12;
            }
            else
            {
                $doctor_use_age = 2;
            }
        }
}
else
{
    if($lab_config->dailyNum >= 10)
        {
            $doctor_use_daily_num = 10;
        }
        else
        {
            $doctor_use_daily_num =2;
        }
	
}
if(isset($_REQUEST['doctor_use_dob']))
{
	$doctor_use_dob = 1;
	if($_REQUEST['doctor_use_dob_radio'] == 'Y')
		$doctor_use_dob = 2;
}
if(isset($_REQUEST['doctor_use_sid']))
{
	$doctor_use_sid = 2;
}
if(isset($_REQUEST['doctor_use_s_addl']))
{
	$doctor_use_addl_id_specimen = 1;
	if($_REQUEST['doctor_use_s_addl_radio'] == 'Y')
		$doctor_use_addl_id_specimen = 2;
}
if(isset($_REQUEST['doctor_use_refout']))
{
	$doctor_use_refout = 1;
	if($_REQUEST['doctor_use_refout_radio'] == 'Y')
		$doctor_use_refout = 2;
}
if(isset($_REQUEST['doctor_use_doctor']))
{
	$doctor_use_doctor = 1;
	if($_REQUEST['doctor_use_doctor_radio'] == 'Y')
		$doctor_use_doctor = 2;
}
if(isset($_REQUEST['doctor_use_rdate']))
{
	$doctor_use_rdate = 1;
	if($_REQUEST['doctor_use_rdate_radio'] == 'Y')
		$doctor_use_rdate = 2;
}
if(isset($_REQUEST['doctor_use_comm']))
{
	$doctor_use_comm = 1;
	if($_REQUEST['doctor_use_comm_radio'] == 'Y')
		$doctor_use_comm = 2;
}
if(isset($_REQUEST['ageLimit']))
{
	$ageLimit = $_REQUEST['ageLimit'];
}
if($_REQUEST['show_pname_radio'] == 'Y')
	$show_pname = 0;


$toUpdate= "$doctor_use_addl_id_patient". "$doctor_use_addl_id_specimen" . "$doctor_use_daily_num" . "$doctor_use_sid" . "$doctor_use_pid" . "$doctor_use_comm" . "$doctor_use_age" . "$doctor_use_dob" . "$doctor_use_rdate" ."$doctor_use_refout" . "$doctor_use_pname" . "$doctor_use_sex" . "$doctor_use_doctor";

update_lab_RWOptions($toUpdate);



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