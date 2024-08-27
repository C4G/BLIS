<?php
#
# Validates username and password
# If passed, redirects to home.php
# Else, redirects to login.php
#

include("redirect.php");
require_once("includes/db_lib.php");

//include("includes/db_lib.php");
require_once("includes/user_lib.php");

require_once("includes/composer.php");
global $log;

# Start session if not already started
if (session_id() == "") {
    session_start();
}

$LOCAL_PATH = realpath(__DIR__."/../../local/");

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$login_correct = check_user_password($username, $password);
if ($login_correct) {
    #Set session variables
    $user = get_user_by_name($username);
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $user->userId;
    $_SESSION['user_actualname'] = $user->actualName;
    $_SESSION['user_level'] = $user->level;
    $_SESSION['locale'] = $user->langId;
    $_SESSION['lab_config_id'] = $user->labConfigId;
    if ($user->level==17) {
        $combinedString = $_SESSION['doctorConfig'] = $user->rwoptions;
        $rwopts = '2,3,4,6,7';
        $rwoptsarr = explode(" ", $rwopts);
        $_SESSION['rwoptionsarray'] = $rwoptsarr;
    } else {
        $rwopts = $user->rwoptions;
        $rwoptsarr = explode(" ", $rwopts);
        $_SESSION['rwoptionsarray'] = $rwoptsarr;
    }

    //if($user->isAdmin())
    if (is_admin($user)) {
        //echo "1";
        $lab_id=get_lab_config_id_admin($user->userId);
        $_SESSION['lab_config_id'] =$lab_id;
        $_SESSION['db_name'] = "blis_".$lab_id;
        $_SESSION['dformat'] = $DEFAULT_DATE_FORMAT;
        $_SESSION['country'] = $user->country;
    } else {
        $_SESSION['lab_config_id'] = $user->labConfigId;
        $_SESSION['country'] = $user->country;
        $lab_config = get_lab_config_by_id($user->labConfigId);
        $_SESSION['db_name'] = $lab_config->dbName;
        $_SESSION['dformat'] = $lab_config->dateFormat;
        $_SESSION['dnum_reset'] = $lab_config->dailyNumReset;
        $_SESSION['pnamehide'] = $lab_config->hidePatientName;

        # Config values for registration fields
        if ($user->level!=17) {
            $_SESSION['p_addl'] = $lab_config->patientAddl;
            $_SESSION['s_addl'] = $lab_config->specimenAddl;
            $_SESSION['dnum'] = $lab_config->dailyNum;
            $_SESSION['sid'] = $lab_config->sid;
            $_SESSION['pid'] = $lab_config->pid;
            $_SESSION['comm'] = $lab_config->comm;
            $_SESSION['age'] = $lab_config->age;
            $_SESSION['dob'] = $lab_config->dob;
            $_SESSION['rdate'] = $lab_config->rdate;
            $_SESSION['refout'] = $lab_config->refout;
            $_SESSION['pname'] = $lab_config->pname;
            $_SESSION['sex'] = $lab_config->sex;
            $_SESSION['doctor'] = $lab_config->doctor;
        } else {
            $arr1 = str_split($combinedString);
            $_SESSION['p_addl'] = $arr1[0];
            $_SESSION['s_addl'] = $arr1[1];
            $_SESSION['dnum'] = $arr1[2];
            $_SESSION['sid'] = $arr1[3];
            $_SESSION['pid'] = $arr1[4];
            $_SESSION['comm'] = $arr1[5];
            $_SESSION['age'] = $arr1[6];
            $_SESSION['dob'] = $arr1[7];
            $_SESSION['rdate'] = $arr1[8];
            $_SESSION['refout'] = $arr1[9];
            $_SESSION['pname'] = $arr1[10];
            $_SESSION['sex'] = $arr1[11];
            $_SESSION['doctor'] = $arr1[12];
        }
        if ($SERVER == $ON_PORTABLE) {
            $_SESSION['langdata_path'] = $LOCAL_PATH."langdata_".$lab_config->id."/";
        } else {
            $_SESSION['langdata_path'] = $LOCAL_PATH."langdata_revamp/";
        }
    }
    
    if (User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level'])) {
        $lab_config_list = get_lab_configs($_SESSION['user_id']);
        $_SESSION['dformat'] = $lab_config_list[0]->dateFormat;
//        $_SESSION['lab_config_id'] = $lab_config_list[0]->id;
        if ($SERVER == $ON_PORTABLE) {
            $langdata_path1 = $LOCAL_PATH."langdata_".$lab_config_list[0]->id."/";
            if (is_dir($LOCAL_PATH."langdata_".$lab_config_list[0]->id."/")) {
                $_SESSION['langdata_path'] = $LOCAL_PATH."langdata_".$lab_config_list[0]->id."/";
            } else {
                $log->error("langdata_path could not be set because local/langdata_".$lab_config_list[0]->id . " does not exist.");
            }
        } else {
            $_SESSION['langdata_path'] = $LOCAL_PATH."langdata_revamp/";
        }
    } else {
        $_SESSION['langdata_path'] = $LOCAL_PATH."langdata_revamp/";
    }
    # Set session variables for recording latency/user props
    $_SESSION['PROPS_RECORDED'] = false;
    $_SESSION['DELAY_RECORDED'] = false;
    # TODO: Add other session variables here
    $_SESSION['user_role'] = "garbage";
    
    # Redirect to home page
    header("Location: /home.php");
} else {
    #Redirect to login page
    header("Location: /login.php?err");
}
