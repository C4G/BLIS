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


$f_pid = 0;
$f_p_addl = 0;
$f_daily_num = 0;
$f_pname = 0;
$f_sex = 0;
$f_age = 0;
$f_dob = 0;

if(isset($_REQUEST['sfields_daily_num']))
{
     if($lab_config->dailyNum >= 10)
    {
	$f_daily_num = $lab_config->dailyNum;
    }
    else
    {
         $f_daily_num = $lab_config->dailyNum + 10;
    }
}
else
{
    if($lab_config->dailyNum >= 10)
    {
        $f_daily_num = $lab_config->dailyNum - 10;
    }
    else
    {
        $f_daily_num = $lab_config->dailyNum;
    }
}
if(isset($_REQUEST['sfields_age']))
{
     if($lab_config->age >= 10)
    {
	$f_age = $lab_config->age;
    }
    else
    {
         $f_age = $lab_config->age + 10;
    }
}
else
{
    if($lab_config->age >= 10)
    {
        $f_age = $lab_config->age - 10;
    }
    else
    {
        $f_age = $lab_config->age;
    }
}
/*
if(isset($_REQUEST['sfields_pname']))
{
	$f_pname = 1;
}
if(isset($_REQUEST['sfields_sex']))
{
	$f_sex = 1;
}
if(isset($_REQUEST['sfields_age']))
{
	$f_age = 1;
}
if(isset($_REQUEST['sfields_dob']))
{
	$f_dob = 1;
}

if($lab_config->pid != $f_pid)
	$lab_config->updatePid($f_pid);
if($lab_config->patientAddl != $f_p_addl)
	$lab_config->updatePatientAddl($f_p_addl);
*/
 //if($lab_config->dailyNum != $f_daily_num)
    $lab_config->updateDailyNum($f_daily_num);
    $lab_config->updateAge($f_age);

  /*
 if($lab_config->sex != $f_sex)
	$lab_config->updateSex($f_sex);
if($lab_config->age != $f_age)
	$lab_config->updateAge($f_age);
if($lab_config->dob != $f_dob)
	$lab_config->updateDob($f_dob);
if($lab_config->pname != $f_pname)
	$lab_config->updatePname($f_pname);
*/
    
 $res = intval($_REQUEST['sfields_resultsPerPage']);
 update_lab_config_settings_search($res);
SessionUtil::restore($saved_session);

?>
 