<?php

require_once('db_lib.php');
require_once('db_util.php');
require_once('debug_lib.php');

class LabConfig
{
    public $id;
    public $name;
    public $location;
    public $adminUserId;
    public $specimenList;
    public $testList;
    public $dbName;
    public $patientAddl;
    public $specimenAddl;
    public $dailyNum;
    public $dailyNumReset;
    public $pid;
    public $pname;
    public $sex;
    public $age;
    public $dob;
    public $sid;
    public $refout;
    public $rdate;
    public $comm;
    public $dateFormat;
    public $doctor;
    public $hidePatientName; # Flag to hide patient name at results entry
    public $ageLimit;
    public $country;
    public $site_choice_enabled;
    public $blis_cloud_hostname;
    public $backup_encryption_enabled;
    public $backup_encryption_key_id;

    public static $ID_AUTOINCR = 1;
    public static $ID_MANUAL = 2;

    public static $RESET_DAILY = 1;
    public static $RESET_MONTHLY = 2;
    public static $RESET_YEARLY = 3;
    public static $RESET_WEEKLY = 4;

    public static function getObject($record)
    {
        global $DEFAULT_DATE_FORMAT;
        # Converts a lab_config record in DB into a LabConfig object
        if ($record == null) {
            return null;
        }
        $lab_config = new LabConfig();
        if (isset($record['lab_config_id'])) {
            $lab_config->id = $record['lab_config_id'];
        } else {
            $lab_config->id = null;
        }
        $lab_config->name = $record['name'];
        $lab_config->location = $record['location'];
        $lab_config->adminUserId = $record['admin_user_id'];
        $lab_config->dbName = $record['db_name'];
        if (isset($record['id_mode'])) {
            $lab_config->idMode = $record['id_mode'];
        } else {
            $lab_config->idMode = 1;
        }
        ## TODO: Reflect the following attribs in DB backend
        $lab_config->collectionDateUsed = false;
        $lab_config->collectionTimeUsed = false;
        if (isset($record['p_addl'])) {
            $lab_config->patientAddl = $record['p_addl'];
        } else {
            $lab_config->patientAddl = 0;
        }
        if (isset($record['s_addl'])) {
            $lab_config->specimenAddl = $record['s_addl'];
        } else {
            $lab_config->specimenAddl = 0;
        }
        if (isset($record['daily_num'])) {
            $lab_config->dailyNum = $record['daily_num'];
        } else {
            $lab_config->dailyNum = 0;
        }
        if (isset($record['dnum_reset'])) {
            $lab_config->dailyNumReset = $record['dnum_reset'];
        } else {
            $lab_config->dailyNumReset = LabConfig::$RESET_DAILY;
        }
        if (isset($record['pid'])) {
            $lab_config->pid = $record['pid'];
        } else {
            $lab_config->pid = 0;
        }
        if (isset($record['pname'])) {
            $lab_config->pname = $record['pname'];
        } else {
            $lab_config->pname = 0;
        }
        if (isset($record['sex'])) {
            $lab_config->sex = $record['sex'];
        } else {
            $lab_config->sex = 0;
        }
        if (isset($record['age'])) {
            $lab_config->age = $record['age'];
        } else {
            $lab_config->age = 0;
        }
        if (isset($record['dob'])) {
            $lab_config->dob = $record['dob'];
        } else {
            $lab_config->dob = 0;
        }
        if (isset($record['sid'])) {
            $lab_config->sid = $record['sid'];
        } else {
            $lab_config->sid = 0;
        }
        if (isset($record['refout'])) {
            $lab_config->refout = $record['refout'];
        } else {
            $lab_config->refout = 0;
        }
        if (isset($record['rdate'])) {
            $lab_config->rdate = $record['rdate'];
        } else {
            $lab_config->rdate = 0;
        }
        if (isset($record['comm'])) {
            $lab_config->comm = $record['comm'];
        } else {
            $lab_config->comm = 0;
        }
        if (isset($record['dformat'])) {
            $lab_config->dateFormat = $record['dformat'];
        } else {
            $lab_config->dateFormat = $DEFAULT_DATE_FORMAT;
        }
        if (isset($record['doctor'])) {
            $lab_config->doctor = $record['doctor'];
        } else {
            $lab_config->doctor = 0;
        }
        if (isset($record['pnamehide'])) {
            $lab_config->hidePatientName = $record['pnamehide'];
        } else {
            $lab_config->hidePatientName = 1;
        }
        if (isset($record['ageLimit'])) {
            $lab_config->ageLimit = $record['ageLimit'];
        } else {
            $lab_config->ageLimit = 5;
        }
        $lab_config->site_choice_enabled = $record['site_choice_enabled'];
        $lab_config->blis_cloud_hostname = $record['blis_cloud_hostname'];
        $lab_config->backup_encryption_enabled = ($record['backup_encryption_enabled'] > 0);
        $lab_config->backup_encryption_key_id = intval($record['backup_encryption_key_id']);
        return $lab_config;
    }

    public static function getDoctorUserOptions()
    {
        $saved_db = DbUtil::switchToGlobal();
        //global $con;
        //$lab_config_id = mysqli_real_escape_string($con, $lab_config_id);
        $query_rwoptions= "SELECT * FROM user WHERE level=17 and lab_config_id = ".$_SESSION['lab_config_id']." LIMIT 1";
        $recordOptions = query_associative_one($query_rwoptions);
        DbUtil::switchRestore($saved_db);
        //echo "from db sid ".$record['sid'];
        if ($recordOptions != null && count($recordOptions) != 0) {
            return $recordOptions['rwoptions'];
        } else {
            return '0122011111121';
        }
    }

    public static function getDoctorObject($record)
    {
        global $DEFAULT_DATE_FORMAT;
        # Converts a lab_config record in DB into a LabConfig object
        if ($record == null) {
            return null;
        }
        $lab_config = new LabConfig();
        if (isset($record['lab_config_id'])) {
            $lab_config->id = $record['lab_config_id'];
        } else {
            $lab_config->id = null;
        }
        $lab_config->name = $record['name'];
        $lab_config->location = $record['location'];
        $lab_config->adminUserId = $record['admin_user_id'];
        $lab_config->dbName = $record['db_name'];
        if (isset($record['id_mode'])) {
            $lab_config->idMode = $record['id_mode'];
        } else {
            $lab_config->idMode = 1;
        }
        ## TODO: Reflect the following attribs in DB backend
        $lab_config->collectionDateUsed = false;
        $lab_config->collectionTimeUsed = false;


        $arr1 = str_split(LabConfig::getDoctorUserOptions());

        $lab_config->patientAddl = $arr1[0];
        $lab_config->specimenAddl = $arr1[1];
        $lab_config->dailyNum = $arr1[2];
        $lab_config->sid = $arr1[3];
        $lab_config->pid = $arr1[4];
        ;
        $lab_config->comm = $arr1[5];
        $lab_config->age = $arr1[6];
        $lab_config->dob = $arr1[7];
        $lab_config->rdate = $arr1[8];
        $lab_config->refout = $arr1[9];
        $lab_config->pname = $arr1[10];
        $lab_config->sex = $arr1[11];
        $lab_config->doctor = $arr1[12];


        if (isset($record['dnum_reset'])) {
            $lab_config->dailyNumReset = $record['dnum_reset'];
        } else {
            $lab_config_id->dailyNumReset = LabConfig::$RESET_DAILY;
        }

        if (isset($record['dformat'])) {
            $lab_config->dateFormat = $record['dformat'];
        } else {
            $lab_config->dateFormat = $DEFAULT_DATE_FORMAT;
        }

        if (isset($record['pnamehide'])) {
            $lab_config->hidePatientName = $record['pnamehide'];
        } else {
            $lab_config->hidePatientName = 1;
        }

        if (isset($record['ageLimit'])) {
            $lab_config->ageLimit = $record['ageLimit'];
        } else {
            $lab_config->ageLimit = 5;
        }
        return $lab_config;
    }
    //AS 09/04/2018 fetch all labs BEGIN
    public static function getAllLabs()
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_string = 			"SELECT lab_config_id,name from lab_config";
        $retval = array();
        $resultset = query_associative_all($query_string);
        foreach ($resultset as $record) {
            $lc=new LabConfig();
            $lc->id=$record['lab_config_id'];
            $lc->name=$record['name'];
            $retval[] = $lc;
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }
    //AS 09/04/2018 END

    public static function getById($lab_config_id)
    {
        $saved_db = DbUtil::switchToGlobal();
        //global $con;
        //$lab_config_id = mysqli_real_escape_string($con, $lab_config_id);
        $query_config = "SELECT * FROM lab_config WHERE lab_config_id = $lab_config_id LIMIT 1";
        $record = query_associative_one($query_config);
        DbUtil::switchRestore($saved_db);
        //echo "from db sid ".$record['sid'];
        return LabConfig::getObject($record);
    }

    // public static function getById($lab_config_id) {
    // 	$saved_db = DbUtil::switchToGlobal();
    // 	//global $con;
    // 	//$lab_config_id = mysqli_real_escape_string($con, $lab_config_id);
    // 	$query_config = "SELECT * FROM lab_config WHERE lab_config_id = $lab_config_id LIMIT 1";
    // 	$record = query_associative_one($query_config);
    // 	DbUtil::switchRestore($saved_db);
    // 	//echo "from db sid ".$record['sid'];
    // 	return LabConfig::getObject($record);
    // }

    public static function getDoctorConfig($lab_config_id)
    {
        $saved_db = DbUtil::switchToGlobal();
        //global $con;
        //$lab_config_id = mysqli_real_escape_string($con, $lab_config_id);
        $query_config = "SELECT * FROM lab_config WHERE lab_config_id = $lab_config_id LIMIT 1";
        $record = query_associative_one($query_config);
        DbUtil::switchRestore($saved_db);
        //echo "from db sid ".$record['sid'];
        return LabConfig::getDoctorObject($record);
    }



    public function getUserCountry($lab_config_id)
    {
        global $con;
        $lab_config_id = mysqli_real_escape_string($con, $lab_config_id);
        $saved_db = DbUtil::switchToGlobal();
        $userId = $_SESSION['user_id'];
        if ($lab_config_id == 0) {
            $query = "SELECT lab_config_id FROM lab_config_access where user_id = $userId LIMIT 1";
            $record = query_associative_one($query);
            $lab_config_id = $record['lab_config_id'];
        }
        $query = "SELECT country FROM lab_config where lab_config_id = $lab_config_id LIMIT 1";
        $record = query_associative_one($query);
        DbUtil::switchRestore($saved_db);
        return $record['country'];
    }

    public function changeAdmin($new_admin_id)
    {
        global $con;
        $new_admin_id = mysqli_real_escape_string($con, $new_admin_id);
        $query_string =
            "UPDATE lab_config ".
            "SET admin_user_id=$new_admin_id ".
            "WHERE lab_config_id=$this->id ";
        $saved_db = DbUtil::switchToGlobal();
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function getUsers()
    {
        $saved_db = DbUtil::switchToGlobal();
        $lab_config_id = $this->id;
        $retval = array();
        $query_string =
            "SELECT u.* FROM user u ".
            "WHERE lab_config_id=$lab_config_id ORDER BY u.username";

        $resultset = query_associative_all($query_string);
        if ($resultset != null) {
            foreach ($resultset as $record) {
                $retval[] = User::getObject($record);
            }
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }

    public function getUserTypes()
    {
        $saved_db = DbUtil::switchToGlobal();
        $lab_config_id = $this->id;
        $retval = array();
        $query_string =
            "SELECT * FROM user_type";

        $resultset = query_associative_all($query_string);
        if ($resultset != null) {
            foreach ($resultset as $record) {
                $retval[] = UserType::getObject($record);
            }
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }

    public function getSiteName()
    {
        # Returns site-name string
        return $this->name." - ".$this->location;
    }

    public function getGoalTatValues()
    {
        # Returns a list of latest goal TAT values for all tests in the lab
        global $DEFAULT_TARGET_TAT;
        $test_type_list = get_test_types_by_site($this->id);
        $saved_db = DbUtil::switchToLabConfig($this->id);
        $retval = array();
        foreach ($test_type_list as $test_type) {
            /*
            $query_string =
                "SELECT tat FROM test_type_tat ".
                "WHERE test_type_id=$test_type->testTypeId ORDER BY ts DESC LIMIT 1";
            */
            $query_string =
                "SELECT target_tat FROM test_type ".
                "WHERE test_type_id=$test_type->testTypeId";
            $record = query_associative_one($query_string);
            if ($record == null) {
                # Entry not yet added by lab admin: Show default
                $retval[$test_type->testTypeId] = $DEFAULT_TARGET_TAT*24;
            } else {
                $retval[$test_type->testTypeId] = $record['target_tat'];
            }
        }
        # Append TAT value for pending tests
        //$query_string = "SELECT tat FROM test_type_tat WHERE test_type_id=0 LIMIT 1";
        /*$query_string = "SELECT target_tat FROM test_type_tat WHERE test_type_id=0 LIMIT 1";
        $record = query_associative_one($query_string);
        if($record == null)
        {
            $retval[0] = null;
        }
        else if($record['tat'] == null)
        {
            $retval[0] = null;
        }
        else
        {
            # Default value present in table
            $retval[0] = $record['tat'];
        }*/
        DbUtil::switchRestore($saved_db);
        return $retval;
    }

    public function getPendingTatValue()
    {
        # Returns default TAT value (in hours) to be assigned for samples that are pending
        # Used while generating TAT report
        # Stored in DB table 'test_type_tat' against test_type_id=0
        global $DEFAULT_PENDING_TAT;
        $saved_db = DbUtil::switchToLabConfig($this->id);
        $query_string = "SELECT tat FROM test_type_tat WHERE test_type_id=0 LIMIT 1";
        $record = query_associative_one($query_string);
        $retval = 0;
        if ($record == null) {
            $retval = $DEFAULT_PENDING_TAT*24;
        } elseif ($record['tat'] == null) {
            $retval = $DEFAULT_PENDING_TAT*24;
        } else {
            # Entry present in DB
            $retval = $record['tat'];
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }


    public function getGoalTatValue($test_type_id, $timestamp="")
    {
        global $DEFAULT_TARGET_TAT, $con;
        $saved_db = DbUtil::switchToLabConfig($this->id);
        $query_string = "";
        $test_type_id = mysqli_real_escape_string($con, $test_type_id);
        $query_string = "SELECT target_tat FROM test_type ".
                        "WHERE test_type_id=$test_type_id ORDER BY ts DESC LIMIT 1";
        $record = query_associative_one($query_string);
        return $record['target_tat'];
    }


    /*
    public function getGoalTatValue($test_type_id, $timestamp="")
    {
        # Returns the goal TAT value for the test on a given timestamp
        global $DEFAULT_TARGET_TAT;
        $saved_db = DbUtil::switchToLabConfig($this->id);
        $query_string = "";
        if($timestamp == "")
        {
            # Fetch latest entry
            $query_string =
                "SELECT target_tat FROM test_type ".
                "WHERE test_type_id=$test_type_id ORDER BY ts DESC LIMIT 1";
        }
        else
        {
            # Fetch entry closest before or at the timestamp value
            $query_string =
                "SELECT target_tat FROM test_type ttt ".
                "WHERE ttt.test_type_id=$test_type_id ".
                "AND ( ".
                    "((UNIX_TIMESTAMP('$timestamp')-UNIX_TIMESTAMP(ttt.ts)) < (".
                    "SELECT (UNIX_TIMESTAMP('$timestamp')-UNIX_TIMESTAMP(ttt2.ts)) ".
                    "FROM test_type_tat ttt2 ".
                    "WHERE ttt2.test_type_id=$test_type_id ".
                    "AND ttt2.ts <> ttt.ts ".
                    ")) ".
                    "OR ( ".
                    "(SELECT COUNT(*) ".
                    "FROM test_type_tat ttt3 ".
                    "WHERE ttt3.test_type_id=$test_type_id ".
                    "AND ttt3.ts <> ttt.ts) = 0 )".
                ")";
        }
        $record = query_associative_one($query_string);
        $retval = 0;
        if($record == null)
            $retval = $DEFAULT_TARGET_TAT;
        else
            $retval = round($record['tat']/24, 2);
        DbUtil::switchRestore($saved_db);
        return $retval;
    }
    */

    public function updateGoalTatValue($test_type_id, $tat_value)
    {
        # Updates goal TAT value for a single test type
        ## Adds a new entry for every update to have time-versioned goal TAT values
        $saved_db = DbUtil::switchToLabConfig($this->id);
        global $con;
        $test_type_id = mysqli_real_escape_string($con, $test_type_id);
        $tat_value = mysqli_real_escape_string($con, $tat_value);
        # Create new entry
        /*
        $query_string =
            "SELECT tat FROM test_type_tat ".
            "WHERE test_type_id=$test_type_id ORDER BY ts DESC LIMIT 1";
        */
        $query_string =
            "SELECT target_tat FROM test_type "."WHERE test_type_id=$test_type_id";
        //"WHERE test_type_id=$test_type_id ORDER BY ts DESC LIMIT 1";
        $existing_record = query_associative_one($query_string);
        if ($existing_record) {
            if ($existing_record['target_tat'] != $tat_value) {
                # Update TAT value
                $query_string =
                    "UPDATE test_type SET target_tat=$tat_value WHERE test_type_id=$test_type_id";
                query_update($query_string);
            }
            /*
            else
            {
                # New record to append for TAT (keeping timestamp wise progression of entries)
                $query_string =
                    "INSERT INTO test_type_tat (test_type_id, tat) ".
                    "VALUES ($test_type_id, $tat_value)";
                ;
                query_insert_one($query_string);
            }
            */
        }
        /*
        else
        {
            # New record to add (first entry for this test type)
            $query_string =
                "INSERT INTO test_type_tat (test_type_id, tat) ".
                "VALUES ($test_type_id, $tat_value)";
            ;
            query_insert_one($query_string);
        }
        DbUtil::switchRestore($saved_db);
        */
    }

    public function getPrintUnverified($lab_config)
    {
        $saved_db = DbUtil::switchToLabConfigRevamp($lab_config);
        # Returns a list of all test type IDs added to the lab configuration
        $query_string =
            "SELECT distinct print_unverified FROM lab_config_test_type ".
            "WHERE lab_config_id=".$lab_config;
        $resultset = query_associative_one($query_string);
        DbUtil::switchRestore($saved_db);
        return $resultset['print_unverified'];
    }

    public function setPrintUnverified($lab_config, $print_unverified)
    {
        $saved_db = DbUtil::switchToLabConfigRevamp($lab_config);
        $query_string =
            "UPDATE lab_config_test_type ".
            "SET print_unverified=".$print_unverified.
            " WHERE lab_config_id=$lab_config";
        query_update($query_string);
        DbUtil::switchRestore($saved_db);
    }


    public function getTestTypeIds()
    {
        $saved_db = DbUtil::switchToLabConfigRevamp($this->id);
        # Returns a list of all test type IDs added to the lab configuration
        $query_string =
            "SELECT test_type_id FROM lab_config_test_type ".
            "WHERE lab_config_id=$this->id";
        $resultset = query_associative_all($query_string);
        $retval = array();
        foreach ($resultset as $record) {
            $retval[] = $record['test_type_id'];
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }

    public function getTestTypes()
    {
        $saved_db = DbUtil::switchToLabConfigRevamp($this->id);
        # Returns a list of all test type objects added to the lab configuration
        $query_string =
            "SELECT tt.* FROM test_type tt, lab_config_test_type lctt ".
            "WHERE lctt.lab_config_id=$this->id ".
            "AND lctt.test_type_id=tt.test_type_id";
        $resultset = query_associative_all($query_string);
        $retval = array();
        foreach ($resultset as $record) {
            $retval[] = TestType::getObject($record);
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }

    public function changeName($new_name)
    {
        # Changes facility name for this lab configuration
        global $con;
        $new_name = mysqli_real_escape_string($con, $new_name);
        $saved_db = DbUtil::switchToGlobal();
        $query_string =
            "UPDATE lab_config SET name='$new_name' WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function changeLocation($new_location)
    {
        # Changes location value for this lab configuration
        global $con;
        $new_location = mysqli_real_escape_string($con, $new_location);
        $saved_db = DbUtil::switchToGlobal();
        $query_string =
            "UPDATE lab_config SET location='$new_location' WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updatePatientAddl($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET p_addl=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateSpecimenAddl($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET s_addl=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateDailyNum($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET daily_num=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updatePid($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET pid=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateSid($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET sid=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateComm($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET comm=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateRdate($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET rdate=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateRefout($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET refout=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateDoctor($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET doctor=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateHidePatientName($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET pnamehide=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateAge($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET age=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateSex($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET sex=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateDob($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET dob=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updatePname($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET pname=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateDateFormat($new_format)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_format = mysqli_real_escape_string($con, $new_format);
        $query_string =
            "UPDATE lab_config SET dformat='$new_format' WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function updateAgeLimit($ageLimit)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $ageLimit = mysqli_real_escape_string($con, $ageLimit);
        $query_string =
            "UPDATE lab_config SET ageLimit=$ageLimit WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
        return $ageLimit;
    }

    public function getAllReportConfigs()
    {
        # Returns report config parameters of all reportIds for this lab
        return ReportConfig::getAllRows($this->id);
    }

    public function getAnyWorksheetConfig()
    {
        # if there is any row with non zero test_type_id returns it
        # otherwise return any row present
        return ReportConfig::getOneWorksheetRow($this->id);
    }

    public function getReportConfig($report_id)
    {
        # Returns report config parameters getByIdfor this lab
        return ReportConfig::getById($this->id, $report_id);
    }

    public function getWorksheetConfig($test_type_id)
    {
        return ReportConfig::getByTestTypeId($this->id, $test_type_id);
    }

    public function getCustomFields($target_entity)
    {
        # Returns list of custom fields being used at this lab
        # $target_entity = 1 for specimen. 2 for patients
        $saved_db = DbUtil::switchToLabConfig($this->id);
        global $con;
        $target_entity = mysqli_real_escape_string($con, $target_entity);
        $target_table = "patient_custom_field";
        if ($target_entity == 1) {
            $target_table = "specimen_custom_field";
        }
        if ($target_entity == 3) {
            $target_table = "labtitle_custom_field";
        }
        $query_string =
            "SELECT * FROM $target_table ORDER BY id";
        $resultset = query_associative_all($query_string);
        $retval = array();
        foreach ($resultset as $record) {
            $retval[] = CustomField::getObject($record);
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }


    public function getPatientCustomFields()
    {
        # Returns list of patient custom fields being used at this lab
        return $this->getCustomFields(2);
    }

    public function getSpecimenCustomFields()
    {
        # Returns list of specimen custom fields being used at this lab
        return $this->getCustomFields(1);
    }

    public function getLabTitleCustomFields()
    {
        # Returns list of specimen custom fields being used at this lab
        return $this->getCustomFields(3);
    }

    public function updateDailyNumReset($new_value)
    {
        $saved_db = DbUtil::switchToGlobal();
        global $con;
        $new_value = mysqli_real_escape_string($con, $new_value);
        $query_string =
            "UPDATE lab_config SET dnum_reset=$new_value WHERE lab_config_id=$this->id";
        query_blind($query_string);
        DbUtil::switchRestore($saved_db);
    }

    public function worksheetConfigGenerate()
    {
        $test_ids = $this->getTestTypeIds();
        $saved_db = DbUtil::switchToLabConfig($this->id);
        echo $saved_db;
        foreach ($test_ids as $test_id) {
            $test_entry = TestType::getById($test_id);
            $query_string =
                "SELECT report_id FROM report_config WHERE test_type_id='$test_id' LIMIT 1";
            $record = query_associative_one($query_string);
            if ($record == null) {
                # Add new entry
                $query_string_add =
                    "INSERT INTO report_config (".
                        "test_type_id, header, footer, margins, ".
                        "p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields ".
                    ") VALUES (".
                        "'$test_id', 'Worksheet - ".$test_entry->name."', '', '5,0,5,0', ".
                        "'0,1,0,1,1,0,0', '0,0,1,1,0,0', '1,0,1,0,0,0,0,1', '', '' ".
                    ")";
                query_insert_one($query_string_add);
            }
        }
        DbUtil::switchRestore($saved_db);
    }

    public function getCustomWorksheets()
    {
        $saved_db = DbUtil::switchToLabConfig($this->id);
        $query_string =
            "SELECT * FROM worksheet_custom";
        $resultset = query_associative_all($query_string);
        $retval = array();
        if ($resultset != null && count($resultset) != 0) {
            foreach ($resultset as $record) {
                $retval[] = CustomWorksheet::getObject($record);
            }
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }

    public function updateSiteEntryChoice($choice)
    {
        $saved_db = DbUtil::switchToGlobal();

        $query = "UPDATE lab_config SET site_choice_enabled='$choice' WHERE ".
            "lab_config_id='$this->id'";
        query_update($query);
        DbUtil::switchRestore($saved_db);
    }

    public function updateBlisCloudHostname($hostname)
    {
        global $con;
        $saved_db = DbUtil::switchToGlobal();
        $escaped = mysqli_real_escape_string($con, $hostname);
        $query = "UPDATE lab_config SET blis_cloud_hostname='$escaped' WHERE lab_config_id='$this->id'";
        query_update($query);
        DbUtil::switchRestore($saved_db);
    }

    public function setBackupEncryptionEnabled($encryption_enabled)
    {
        global $con;
        $encryption_enabled_val = !!$encryption_enabled ? 1 : 0;
        $saved_db = DbUtil::switchToGlobal();
        $query = "UPDATE lab_config SET backup_encryption_enabled='$encryption_enabled_val' WHERE lab_config_id='$this->id'";
        query_update($query);
        DbUtil::switchRestore($saved_db);
    }

    public function updateBackupEncryptionKeyId($key_id)
    {
        global $con;
        $saved_db = DbUtil::switchToGlobal();
        $escaped = db_escape($key_id);
        $query = "UPDATE lab_config SET backup_encryption_key_id='$escaped' WHERE lab_config_id='$this->id'";
        query_update($query);
        DbUtil::switchRestore($saved_db);
    }
}
