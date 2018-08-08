<?php
# 
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# This file contains entity classes and functions for DB queries
#

# Start session if not already started
if(session_id() == "")
	session_start();


include("defaults.php");
require_once("db_mysql_lib.php");

if(!isset($_SESSION['langdata_path']))
{
	$_SESSION['langdata_path'] = $LOCAL_PATH."langdata_revamp/";
}
# Select appropriate locale file
if(!isset($_SESSION['locale']))
	$_SESSION['locale'] = $DEFAULT_LANG;
$locale_catalog_file = $_SESSION['langdata_path'].$_SESSION['locale']."_catalog.php";
$locale_file = $_SESSION['langdata_path'].$_SESSION['locale'].".php";

include($locale_catalog_file);
include($locale_file);

require_once("debug_lib.php");
require_once("date_lib.php");
//require_once("user_lib.php");

// PDF Modules
require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');


#
# Entity classes for database backend
#
class UserType{
	public $level;
	public $name;
	public $defaultdisplay;
	public $rwoption;
	public static function getObject($record)
	{
		global $DEFAULT_LANG;
		# Converts a user record in DB into a User object
		if($record == null)
			return null;
		$usertype = new UserType();
		$usertype->defaultdisplay = $record['defaultdisplay'];
		$usertype->level = $record['level'];
		$usertype->name = $record['name'];
		$usertype->createdBy = $record['created_by'];		
		$usertype->rwoption = $record['rwoption'];	
		return $usertype;
	}
}
class User
{
	public $userId;
	public $username;
	public $password;
	public $actualName;
	public $email;
	public $phone;
	public $level;
	public $createdBy;
	public $labConfigId;
	public $langId;
	public $country;
	
	public $rwoption;
	
	public static function getObject($record)
	{
		global $DEFAULT_LANG;
		# Converts a user record in DB into a User object
		if($record == null)
			return null;
		$user = new User();
		$user->userId = $record['user_id'];
		$user->username = $record['username'];
		$user->password = $record['password'];
		$user->actualName = $record['actualname'];
		$user->level = $record['level'];
		$user->email = $record['email'];
		$user->phone = $record['phone'];
		$user->createdBy = $record['created_by'];
		$user->labConfigId = $record['lab_config_id'];
		if(isset($record['lang_id']))
			$user->langId = $record['lang_id'];
		else
			$user->langId = $DEFAULT_LANG;
			
		/*if( $user->labConfigId == 128 || $user->labConfigId == 129 || $user->labConfig == 131 ) */
			$user->country = LabConfig::getUserCountry($user->labConfigId);
		
		$user->rwoptions = $record['rwoptions'];;
		
		return $user;
	}

	public static function getByUserId($id)
    {
        $saved_db = DbUtil::switchToGlobal();

        $query = "SELECT * FROM user ".
            "WHERE user_id='$id'";
        $user = query_associative_one($query);

        return self::getObject($user);
    }
	
	public static function onlyOneLabConfig($user_id, $user_level)
	{
		# Checks if only one lab config exists for this admin level user
		global $LIS_ADMIN;
		$lab_config_list = get_lab_configs($user_id, $user_level);
		
		if(count($lab_config_list) == 1 && $user_level == $LIS_ADMIN)
			return true;
		else
			return false;
	}
}


class currencyConfig{
	public $currencyFrom;
	public $currencyTo; 
	public $exchangeRate;
	public $lastUpdatedOn;
	public $flag1;
	public $flag2;
	public $setting1;
	public $setting2;
	
	public static function getObject($record)
	{
		global $DEFAULT_DATE_FORMAT;
		# Converts a lab_config record in DB into a LabConfig object
		if($record == null)
			return null;
		$currency_config = new currencyConfig();
		$currency_config->currencyFrom = $record['currencya'];
		$currency_config->currencyTo = $record['currencyb'];
		$currency_config->exchangeRate = $record['exchangerate'];
		$currency_config->lastUpdatedOn = $record['updatedts'];
		
		if(isset($record['flag1']))
			$currency_config->flag1 = $record['flag1'];
		else
			$currency_config->flag1 = 0;
		
		if(isset($record['flag2']))
			$currency_config->flag2 = $record['flag2'];
		else
			$currency_config->flag2 = 0;
		
		if(isset($record['setting1']))
			$currency_config->setting1 = $record['setting1'];
		else
			$currency_config->setting1 = 0;
		
		if(isset($record['setting2']))
			$currency_config->setting2 = $record['setting2'];
		else
			$currency_config->setting2 = 0;
		
		return $currency_config;
		
	}
	
	
	public function getCurrencyFrom()
	{
		if($this->currencyFrom == null || trim($this->currencyFrom) == "")
			return "-";
		else
			return $this->currencyFrom;
	}
	
	public function getCurrencyTo()
	{
		if($this->currencyTo == null || trim($this->currencyTo) == "")
			return "-";
		else
			return $this->currencyTo;
	}
	public function getExchangeRate()
	{
		if($this->exchangeRate == null || trim($this->exchangeRate) == "")
			return 0;
		else
			return $this->exchangeRate;
	}
	public function getLastUpdatedDate()
	{
		if($this->lastUpdatedOn == null || trim($this->lastUpdatedOn) == "")
			return "-";
		else
			return $this->lastUpdatedOn;
	}
	public function getFlag1()
	{
		if($this->flag1 == null || trim($this->flag1) == "")
			return 0;
		else
			return $this->flag1;
	}
	
	public function getFlag2()
	{
		if($this->flag2 == null || trim($this->flag2) == "")
			return "-";
		else
			return $this->flag2;
	}
	
	public function getSetting1()
	{
		if($this->setting1 == null || trim($this->setting1) == "")
			return "-";
		else
			return $this->setting1;
	}
	
	public function getSetting2()
	{
		if($this->setting2 == null || trim($this->setting2) == "")
			return "-";
		else
			return $this->setting2;
	}
	
	public static function getExchangeRateSnap($lab_config_id, $currencyFrom) {
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$retval = array();
		$query_string = "SELECT * FROM currency_conversion where currencya='$currencyFrom' && currencyb!='$currencyFrom'";
		$resultset = query_associative_all($query_string, $row_count);
		foreach($resultset as $record)
		{
			$retval[] = currencyConfig::getObject($record);
		}
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public static function getExchangeRateValue($lab_config_id, $currencyFrom, $currencyTo) {
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		global $con;
		$query_config = "SELECT * FROM currency_conversion where currencya='$currencyFrom' && currencyb='$currencyTo' limit 1";
		$record = query_associative_one($query_config);
		DbUtil::switchRestore($saved_db);
		return currencyConfig::getObject($record);
	}
	
	public static function getDefaultCurrency($lab_config_id) {
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		global $con;
		$query_config = "SELECT * FROM currency_conversion where currencya=currencyb && flag1='1' limit 1";
		$record = query_associative_one($query_config);
		DbUtil::switchRestore($saved_db);
		return currencyConfig::getObject($record);
	}
	
	public static function setDefaultCurrency($lab_config_id, $default_currency_name) {
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string = "update currency_conversion set flag1='0' where flag1='1'";
		query_update($query_string);
		$query_string = "update currency_conversion set flag1='1' where currencya='$default_currency_name' && currencya=currencyb";
		query_update($query_string);
		DbUtil::switchRestore($saved_db);
		return 1;
	}
	
	public static function getAllDifferenctCurrencies($lab_config_id) {
		//echo "TEST";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		global $con;
		$query_string = "SELECT distinct currencyb FROM currency_conversion";
		$resultset = query_associative_all($query_string, $row_count);
		$record_c=array();
		foreach($resultset as $record)
		{
			foreach($record as $key=>$value){
			$query_string = "SELECT * FROM currency_conversion WHERE currencya='$value' && currencya=currencyb";
			$record_each= query_associative_one($query_string);
			echo $record_each['currencya'].'||';
			$record_c[]=currencyConfig::getObject($record_each);
			}
		}
		DbUtil::switchRestore($saved_db);
		return $record_c;
	}
	
	
	public static function getAllSecondaryCurrencies($lab_config_id, $default_currency) {
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string = "SELECT distinct currencyb FROM currency_conversion where currencya='$default_currency'";
		
		$resultset = query_associative_all($query_string, $row_count);
		$record_c=array();
		foreach($resultset as $record)
		{
			foreach($record as $key=>$value){
				$query_string = "SELECT * FROM currency_conversion WHERE currencya='$value' && currencya=currencyb";
				$record_each= query_associative_one($query_string);
				$record_c[]=currencyConfig::getObject($record_each);
			}
		}
		DbUtil::switchRestore($saved_db);
		return $record_c;
	}
	
	
}


class FieldOrdering
{
	public $id; // 0 for patient registration, 1 for specimen registration
	/* public $field1;
	public $field2;
	public $field3;
	public $field4;
	public $field5;
	public $field6;
	public $field7;
	public $field8;
	public $field9;
	public $field10;
	public $field11;
	public $field12;
	public $field13;
	public $field14;
	public $field15;
	public $field16; */
	public $form_field_inOrder;
	
	public $form_id;
	
	
	public static function getObject($record)
	{
		# Converts a lab_config record in DB into a LabConfig object
		if($record == null)
			return null;
		
		$field_ordering = new FieldOrdering();
		
		if(isset($record['lab_config_id']))
			$field_ordering->id = $record['lab_config_id'];
		else
			$field_ordering->id = null;
		
		if(isset($record['form_id']))
			$field_ordering->form_id = $record['form_id'];
		else
			$field_ordering->form_id = -1;
		
		if(isset($record['field_order']))
			$field_ordering->form_field_inOrder = $record['field_order'];
		else
			$field_ordering->form_field_inOrder = -1;
		
		return $field_ordering;
	}

	public static function getByFormId($lab_config_id, $form_id) {
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		//$query_config = "SELECT * FROM field_ordering WHERE lab_config_id = $lab_config_id AND form_id=$form_id LIMIT 1";
		$query_config = "SELECT * FROM field_order WHERE lab_config_id = $lab_config_id AND form_id=$form_id LIMIT 1";
		//echo $query_config;
		$record = query_associative_one($query_config);
		DbUtil::switchRestore($saved_db);
		return FieldOrdering::getObject($record);
	}
	
	public static function deleteFieldOrderEntry($lab_config_id, $form_id){
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		//$query_delete = "DELETE FROM field_ordering WHERE lab_config_id=$lab_config_id AND form_id=$form_id";
		$query_delete = "DELETE FROM field_order WHERE lab_config_id=$lab_config_id AND form_id=$form_id";
		query_blind($query_delete);
		DbUtil::switchRestore($saved_db);
	}
	
	public static function add_fieldOrdering($fieldOrder, $importOn = false)
	{
		# Adds a new patient/ specimen field order to DB 
		
		$field_order = db_escape($fieldOrder->form_field_inOrder);
		$lab_config_id = db_escape($fieldOrder->id);
		$form_id = db_escape($fieldOrder->form_id);
			
		
		/* $query_string =
			"INSERT INTO `field_ordering`(`lab_config_id`, `field1`, `field2`, `field3`, `field4`, `field5`, `field6`, `field7`,`field8`,`field9`,`field10`,`field11`,`field12`,`field13`,`field14`,`field15`,`field16`,`form_id`) ".
			"VALUES ($lab_config_id, '$field1', '$field2', '$field3', '$field4', '$field5', '$field6', '$field7', '$field8', '$field9', '$field10', '$field11', '$field12', '$field13', '$field14', '$field15', '$field16', $form_id)";
		 */
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);
		
		$query_string =
		"INSERT INTO `field_order`(`lab_config_id`, `field_order`,`form_id`) ".
		"VALUES ($lab_config_id, '$field_order', $form_id)";
		//echo $query_string;
		//print $query_string;
		query_insert_one($query_string);
		
		DbUtil::switchRestore($saved_db);
		return true;
	}
}





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
		if($record == null)
			return null;
		$lab_config = new LabConfig();
		if(isset($record['lab_config_id']))
			$lab_config->id = $record['lab_config_id'];
		else
			$lab_config->id = null;
		$lab_config->name = $record['name'];
		$lab_config->location = $record['location'];
		$lab_config->adminUserId = $record['admin_user_id'];
		$lab_config->dbName = $record['db_name'];
		if(isset($record['id_mode']))
			$lab_config->idMode = $record['id_mode'];
		else
			$lab_config->idMode = 1;
		## TODO: Reflect the following attribs in DB backend
		$lab_config->collectionDateUsed = false;
		$lab_config->collectionTimeUsed = false;
		if(isset($record['p_addl']))
			$lab_config->patientAddl = $record['p_addl'];
		else
			$lab_config->patientAddl = 0;
		if(isset($record['s_addl']))
			$lab_config->specimenAddl = $record['s_addl'];
		else
			$lab_config->specimenAddl = 0;
		if(isset($record['daily_num']))
			$lab_config->dailyNum = $record['daily_num'];
		else
			$lab_config->dailyNum = 0;
		if(isset($record['dnum_reset']))
			$lab_config->dailyNumReset = $record['dnum_reset'];
		else
			$lab_config->dailyNumReset = LabConfig::$RESET_DAILY;
		if(isset($record['pid']))
			$lab_config->pid = $record['pid'];
		else
			$lab_config->pid = 0;
		if(isset($record['pname']))
			$lab_config->pname = $record['pname'];
		else
			$lab_config->pname = 0;
		if(isset($record['sex']))
			$lab_config->sex = $record['sex'];
		else
			$lab_config->sex = 0;
		if(isset($record['age']))
			$lab_config->age = $record['age'];
		else
			$lab_config->age = 0;
		if(isset($record['dob']))
			$lab_config->dob = $record['dob'];
		else
			$lab_config->dob = 0;
		if(isset($record['sid']))
			$lab_config->sid = $record['sid'];
		else
			$lab_config->sid = 0;
		if(isset($record['refout']))
			$lab_config->refout = $record['refout'];
		else
			$lab_config->refout = 0;
		if(isset($record['rdate']))
			$lab_config->rdate = $record['rdate'];
		else
			$lab_config->rdate = 0;
		if(isset($record['comm']))
			$lab_config->comm = $record['comm'];
		else
			$lab_config->comm = 0;
		if(isset($record['dformat']))
			$lab_config->dateFormat = $record['dformat'];
		else
			$lab_config->dateFormat = $DEFAULT_DATE_FORMAT;
		if(isset($record['doctor']))
			$lab_config->doctor = $record['doctor'];
		else
			$lab_config->doctor = 0;
		if(isset($record['pnamehide']))
			$lab_config->hidePatientName = $record['pnamehide'];
		else
			$lab_config->hidePatientName = 1;
		if(isset($record['ageLimit']))
			$lab_config->ageLimit = $record['ageLimit'];
		else
			$lab_config->ageLimit = 5;
        $lab_config->site_choice_enabled = $record['site_choice_enabled'];
		return $lab_config;
	}
	
	public static function getDoctorUserOptions() {
		$saved_db = DbUtil::switchToGlobal();
		//global $con;
		//$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$query_rwoptions= "SELECT * FROM user WHERE level=17 and lab_config_id = ".$_SESSION['lab_config_id']." LIMIT 1";
		$recordOptions = query_associative_one($query_rwoptions);
		DbUtil::switchRestore($saved_db);
		//echo "from db sid ".$record['sid'];
		if($recordOptions != null && count($recordOptions) != 0) {
			return $recordOptions['rwoptions'];
		}
		else {
			return '0122011111121';
		}
	}
	
	public static function getDoctorObject($record)
	{
		global $DEFAULT_DATE_FORMAT;
		# Converts a lab_config record in DB into a LabConfig object
		if($record == null)
			return null;
			$lab_config = new LabConfig();
			if(isset($record['lab_config_id']))
				$lab_config->id = $record['lab_config_id'];
			else
				$lab_config->id = null;
			$lab_config->name = $record['name'];
			$lab_config->location = $record['location'];
			$lab_config->adminUserId = $record['admin_user_id'];
			$lab_config->dbName = $record['db_name'];
			if(isset($record['id_mode']))
				$lab_config->idMode = $record['id_mode'];
			else
				$lab_config->idMode = 1;
			## TODO: Reflect the following attribs in DB backend
			$lab_config->collectionDateUsed = false;
			$lab_config->collectionTimeUsed = false;
			
			
			$arr1 = str_split(LabConfig::getDoctorUserOptions());
		
			$lab_config->patientAddl = $arr1[0];
			$lab_config->specimenAddl = $arr1[1];
			$lab_config->dailyNum = $arr1[2];
			$lab_config->sid = $arr1[3];
			$lab_config->pid = $arr1[4];;
			$lab_config->comm = $arr1[5];
			$lab_config->age = $arr1[6];
			$lab_config->dob = $arr1[7];
			$lab_config->rdate = $arr1[8];
			$lab_config->refout = $arr1[9];
			$lab_config->pname = $arr1[10];
			$lab_config->sex = $arr1[11];
			$lab_config->doctor = $arr1[12];

			
			if(isset($record['dnum_reset']))
				$lab_config->dailyNumReset = $record['dnum_reset'];
			else
				$lab_config_id->dailyNumReset = LabConfig::$RESET_DAILY;
			
			if(isset($record['dformat']))
				$lab_config->dateFormat = $record['dformat'];
			else
				$lab_config->dateFormat = $DEFAULT_DATE_FORMAT;
			
			if(isset($record['pnamehide']))
				$lab_config->hidePatientName = $record['pnamehide'];
			else
				$lab_config->hidePatientName = 1;
			
			if(isset($record['ageLimit']))
				$lab_config->ageLimit = $record['ageLimit'];
			else
				$lab_config->ageLimit = 5;
			return $lab_config;
	}

	
	public static function getById($lab_config_id) {
		$saved_db = DbUtil::switchToGlobal();
		//global $con;
		//$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$query_config = "SELECT * FROM lab_config WHERE lab_config_id = $lab_config_id LIMIT 1";
		$record = query_associative_one($query_config);
		DbUtil::switchRestore($saved_db);
		//echo "from db sid ".$record['sid'];
		return LabConfig::getObject($record);
	}

	// public static function getById($lab_config_id) {
	// 	$saved_db = DbUtil::switchToGlobal();
	// 	//global $con;
	// 	//$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	// 	$query_config = "SELECT * FROM lab_config WHERE lab_config_id = $lab_config_id LIMIT 1";
	// 	$record = query_associative_one($query_config);
	// 	DbUtil::switchRestore($saved_db);
	// 	//echo "from db sid ".$record['sid'];
	// 	return LabConfig::getObject($record);
	// }
	
	public static function getDoctorConfig($lab_config_id) {
		$saved_db = DbUtil::switchToGlobal();
		//global $con;
		//$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$query_config = "SELECT * FROM lab_config WHERE lab_config_id = $lab_config_id LIMIT 1";
		$record = query_associative_one($query_config);
		DbUtil::switchRestore($saved_db);
		//echo "from db sid ".$record['sid'];
		return LabConfig::getDoctorObject($record);
	}
	
	
	
	public function getUserCountry($lab_config_id) {
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$saved_db = DbUtil::switchToGlobal();
		$userId = $_SESSION['user_id'];
		if( $lab_config_id == 0 ) {
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
		$new_admin_id = mysql_real_escape_string($new_admin_id, $con);
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
			
		$resultset = query_associative_all($query_string, $row_count);
		if($resultset != null)
		{
			foreach($resultset as $record)
			{
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
			
		$resultset = query_associative_all($query_string, $row_count);
		if($resultset != null)
		{
			foreach($resultset as $record)
			{
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
		foreach($test_type_list as $test_type)
		{
			/*
			$query_string = 
				"SELECT tat FROM test_type_tat ".
				"WHERE test_type_id=$test_type->testTypeId ORDER BY ts DESC LIMIT 1";
			*/
			$query_string = 
				"SELECT target_tat FROM test_type ".
				"WHERE test_type_id=$test_type->testTypeId";
			$record = query_associative_one($query_string);
			if($record == null)
			{
				# Entry not yet added by lab admin: Show default
				$retval[$test_type->testTypeId] = $DEFAULT_TARGET_TAT*24;
			}
			else
			{
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
		if($record == null)
		{
			$retval = $DEFAULT_PENDING_TAT*24;
		}
		else if($record['tat'] == null)
		{
			$retval = $DEFAULT_PENDING_TAT*24;
		}
		else
		{
			# Entry present in DB
			$retval = $record['tat'];
		}
		DbUtil::switchRestore($saved_db);
		return $retval;		
	}


	public function getGoalTatValue($test_type_id, $timestamp="") {
		global $DEFAULT_TARGET_TAT, $con;
		$saved_db = DbUtil::switchToLabConfig($this->id);
		$query_string = "";
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
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
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		$tat_value = mysql_real_escape_string($tat_value, $con);
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
		if($existing_record) {
			if($existing_record['target_tat'] != $tat_value) {
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
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
		{
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
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
		{
			$retval[] = TestType::getObject($record);
		}
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public function changeName($new_name)
	{
		# Changes facility name for this lab configuration
		global $con;
		$new_name = mysql_real_escape_string($new_name, $con);
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
		$new_location = mysql_real_escape_string($new_location, $con);
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
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET p_addl=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateSpecimenAddl($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET s_addl=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateDailyNum($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET daily_num=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updatePid($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET pid=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateSid($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET sid=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateComm($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET comm=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateRdate($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET rdate=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateRefout($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET refout=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateDoctor($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET doctor=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateHidePatientName($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET pnamehide=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateAge($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET age=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateSex($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET sex=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateDob($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET dob=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updatePname($new_value)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_value = mysql_real_escape_string($new_value, $con);
		$query_string = 
			"UPDATE lab_config SET pname=$new_value WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateDateFormat($new_format)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$new_format = mysql_real_escape_string($new_format, $con);
		$query_string = 
			"UPDATE lab_config SET dformat='$new_format' WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function updateAgeLimit($ageLimit)
	{
		$saved_db = DbUtil::switchToGlobal();
		global $con;
		$ageLimit = mysql_real_escape_string($ageLimit, $con);
		$query_string = 
			"UPDATE lab_config SET ageLimit=$ageLimit WHERE lab_config_id=$this->id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
		return $ageLimit;
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
		$target_entity = mysql_real_escape_string($target_entity, $con);
		$target_table = "patient_custom_field";
		if($target_entity == 1)
			$target_table = "specimen_custom_field";
		if($target_entity == 3)	
			$target_table = "labtitle_custom_field";
		$query_string = 
			"SELECT * FROM $target_table ORDER BY id";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
		{
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
		$new_value = mysql_real_escape_string($new_value, $con);
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
		foreach($test_ids as $test_id)
		{	
			$test_entry = TestType::getById($test_id);
			$query_string = 
				"SELECT report_id FROM report_config WHERE test_type_id='$test_id' LIMIT 1";
			$record = query_associative_one($query_string);
			if($record == null)
			{	
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
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if($resultset != null && count($resultset) != 0)
		{
			foreach($resultset as $record)
			{
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
}

class Sites
{
    public $id;
    public $name;
    public $lab_id;

    public static function getObject($record)
    {
        # Process a record and return the Sites object
        if ($record == null)
            return null;

        $obj = new Sites();
        $obj->id = $record['id'];
        $obj->name = $record['name'];
        $obj->lab_id = $record['lab_id'];
        $obj->district = $record['District'];
        $obj->region = $record['Region'];
        return $obj;
    }

    public static function getDefaultSite($lab_config)
    {
        $query = "SELECT * FROM sites ".
            "WHERE name='$lab_config->name'";

        $result = query_associative_one($query);

        return self::getObject($result);

    }

    public static function getById($id)
    {
        $query = "SELECT * FROM sites ".
            "WHERE id='$id'";
        $result = query_associative_one($query);

        return self::getObject($result);
    }

    public static function getByLabConfigId($id)
    {
        $saved_db = DbUtil::switchToLabConfig($id);
        global $con;
        $val = mysql_query('select 1 from `sites` LIMIT 1');

        if($val !== FALSE)
        {
            $query = "SELECT * FROM sites ".
                "WHERE lab_id=". $id;
            $result = query_associative_all($query, null);

            if ($result == NULL)
            {
                $lab_config = LabConfig::getById($id);
                $lab_name = mysql_real_escape_string($lab_config->name, $con);
                $query = "INSERT INTO sites ".
                    "(name, lab_id) VALUES ".
                    "('$lab_name', '$id')";
                query_insert_one($query);
            }

            $query = "SELECT * FROM sites ".
                "WHERE lab_id=". $id;
            $result = query_associative_all($query, null);

            $resultset = array();
            foreach ($result as $record)
                $resultset[] = self::getObject($record);

            DbUtil::switchRestore($saved_db);

            return $resultset;
        }
        else
        {
            return null;
        }



    }

    public static function addSite($lab_config_id, $site_name)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        global $con;

        $name = mysql_real_escape_string($site_name, $con);

        $query = "INSERT INTO sites ".
            "(name, lab_id) VALUES ".
            "('$name', '$lab_config_id')";
        query_insert_one($query);

        DbUtil::switchRestore($saved_db);
    }

    public static function updateSite($lab_config_id, $site_id, $site_region, $site_district)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        global $con;

        //$id = mysql_real_escape_string($site_id, $con);
        $region = mysql_real_escape_string($site_region, $con);
        $district = mysql_real_escape_string($site_district, $con);
        echo $site_region;
        echo $site_district;
       
        $query = "UPDATE sites SET Region = '".$region."' , District = '".$district."' where id = '$site_id' ";
        echo $query;
        query_insert_one($query);

        DbUtil::switchRestore($saved_db);
    }

    public static function removeSite($id)
    {
        $query = "DELETE FROM sites ".
            "WHERE id='$id'";
        query_delete($query);
    }
}

class TestAggReportConfig
{
    public $id;
    public $test_type_id;

    public $title;
    public $landscape;
    public $report_type;

    public $group_by_age;
    public $age_unit;
    public $age_groups;

    public static function getObject($record)
    {
        global $DEFAULT_DATE_FORMAT;

        if ($record == null)
            return null;

        $report_config = new TestAggReportConfig();

        $report_config->id = $record['id'];
        $report_config->test_type_id = $record['test_type_id'];
        $report_config->title = $record['title'];
        $report_config->landscape = $record['landscape'];
        $report_config->group_by_age = $record['group_by_age'];
        $report_config->age_unit = $record['age_unit'];
        $report_config->age_groups = explode(',', $record['age_groups']);
        $report_config->report_type = $record['report_type'];

        return $report_config;
    }

    public static function getByTestTypeId(
        $lab_config_id,
        $test_type_id,
        $report_type)
    {
        global $con;
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);

        $test_type = TestType::getById($test_type_id);
        $test_name = mysql_real_escape_string($test_type->name, $con);

        $query = "SELECT * FROM test_agg_report_config ".
            "WHERE test_type_id=".$test_type_id.
            " AND report_type=".$report_type;
        $result = query_associative_one($query);

        if ($result == null)
        {
            $query = "INSERT INTO test_agg_report_config ".
                "(test_type_id, title, report_type) VALUES ".
                "('$test_type_id', '$test_name', '$report_type')";
            query_insert_one($query);

            $query = "SELECT * FROM test_agg_report_config ".
                "WHERE test_type_id=".$test_type_id.
                " AND report_type=".$report_type;
            $result = query_associative_one($query);
        }
        DbUtil::switchRestore($saved_db);

        return self::getObject($result);
    }

    public static function updateRecord($lab_config_id, $record)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);

        $query = "UPDATE test_agg_report_config ".
            "SET group_by_age='$record->group_by_age', ".
            "age_unit='$record->age_unit', ".
            "age_groups='$record->age_groups' ".
            "WHERE test_type_id='$record->test_type_id' ".
            "AND report_type='$record->report_type'";
        query_update($query);
        DbUtil::switchRestore($saved_db);
    }
}

class ReportConfig
{
	public $labConfigId;
	public $reportId;
	public $testTypeId;
	public $title;
		
	public $headerText;
	public $titleText;
	public $footerText;
	public $designation;
	public $aglignment_header;
	//alignmen
	//size
	//align?size?text
	public $patientCustomFields;
	public $specimenCustomFields;
	public $margins;
	public static $TOP=0, $BOTTOM=1, $LEFT=2, $RIGHT=3;
	
	public $usePatientId;
	public $usePatientBarcode;
	public $usePatientSignature;
	public $useDailyNum;
	public $usePatientAddlId;
	public $useGender;
	public $useAge;
	public $useDob;
	public $usePatientName;
	public $useTest;
	public $usePatientRegistrationDate;
	
	public $useSpecimenId;
	public $useSpecimenAddlId;
	public $useDateRecvd;
	public $useComments;
	public $useReferredTo;
	public $useDoctor;
	public $useSpecimenName;
	
	public $useMeasures;
	public $useResults;
	public $useRange;
	public $useRemarks;
	public $useEntryDate;
	public $useEnteredBy;
	public $useVerifiedBy;
	public $useStatus;
	public $useTestName;
	public $useClinicalData;
	public $usePrintConfirm;
	public $useResultConfirm;
	
	public $useRequesterName;
	public $useReferredToHospital;
	
	public $landscape;
	public $logoUrl;
	
	//Appearance
	public $rowItems;
	public $showBorder;
	public $patientFields;
	public $showResultBorder;
	public $resultborderVertical;
	public $resultborderHorizontal;
	
		
		
	public static function getObject($record, $lab_config_id)
	{
		global $LANG_ARRAY, $LOCAL_PATH;
		
		if($record == null)
			return null;
		
		$report_config = new ReportConfig();
		
		$report_config->labConfigId = $lab_config_id;
		$report_config->reportId = $record['report_id'];
		$report_config->testTypeId = $record['test_type_id'];
		
		$report_config->rowItems = (int)$record['row_items'];
		$report_config->showBorder = $record['show_border'];
		$report_config->patientFields = $record['p_fields'];
		$report_config->showResultBorder = $record['show_result_border'];		
		$report_config->resultborderHorizontal = $record['result_border_horizontal'];
		$report_config->resultborderVertical = $record['result_border_vertical'];		
		
		
		
		switch($report_config->reportId)
		{
			case 1:
				$report_config->name = $LANG_ARRAY["reports"]["MENU_PATIENT"];
				break;
			case 2:
				$report_config->name = $LANG_ARRAY["reports"]["MENU_SPECIMEN"];
				break;
			case 3:
				$report_config->name = $LANG_ARRAY["reports"]["MENU_TESTRECORDS"];
				break;
			case 4:
				$report_config->name = $LANG_ARRAY["reports"]["MENU_DAILYLOGS"];
				break;
		}
		
		$alignment_header=$record['header'];
		
		if(strpos($alignment_header, "??")!=-1)
		{	
			$split_alignment_header=explode("??",$alignment_header);
			$report_config->headerText =$split_alignment_header[0];
			$report_config->alignment_header=$split_alignment_header[1];	
		}
		else
			$report_config->headerText=$alignment_header;
		
		$footer_designation=$record['footer'];
		
		if(strpos($footer_designation, "#")!=-1)
		{
			$split= explode("#", $footer_designation);
			$report_config->footerText = $split[0];
			$report_config->designation =$split[1];
		}
		else
		$report_config->footerText = $record['footer'];
		$report_config->titleText = $record['title'];
		
		$report_config->logoUrl = $LOCAL_PATH."logos/logo_".$lab_config_id;
		$report_config->landscape = false;
		if($record['landscape'] == 1)
			$report_config->landscape = true;
		
		$margins_csv = $record['margins'];
		$report_config->margins = explode(",", $margins_csv);
		
		$patient_custom_csv = $record['p_custom_fields'];
		$report_config->patientCustomFields = explode(",", $patient_custom_csv);
		
		$specimen_custom_csv = $record['s_custom_fields'];
		$report_config->specimenCustomFields = explode(",", $specimen_custom_csv);
		
		# Patient main fields
		$patient_field_list = explode(",", $record['p_fields']);
		if(!isset($patient_field_list[0]))
			$report_config->usePatientId = 0;
		else
			$report_config->usePatientId = $patient_field_list[0];
		if(!isset($patient_field_list[1]))
			$report_config->useDailyNum = 0;
		else
			$report_config->useDailyNum = $patient_field_list[1];
		if(!isset($patient_field_list[2]))
			$report_config->usePatientAddlId = 0;
		else
			$report_config->usePatientAddlId = $patient_field_list[2];
		if(!isset($patient_field_list[3]))
			$report_config->useGender = 0;
		else
			$report_config->useGender = $patient_field_list[3];
		if(!isset($patient_field_list[4]))
			$report_config->useAge = 0;
		else
			$report_config->useAge = $patient_field_list[4];
		if(!isset($patient_field_list[5]))
			$report_config->useDob = 0;
		else
			$report_config->useDob = $patient_field_list[5];
		if(!isset($patient_field_list[6]))
			$report_config->usePatientName = 0;
		else
			$report_config->usePatientName = $patient_field_list[6];
		if(!isset($patient_field_list[7]))
			$report_config->useTest = 0;
		else
			$report_config->useTest = $patient_field_list[7];
		if(!isset($patient_field_list[8]))
			$report_config->usePatientRegistrationDate = 0;
		else
			$report_config->usePatientRegistrationDate = $patient_field_list[8];
		if(!isset($patient_field_list[9]))
			$report_config->usePatientBarcode = 0;
		else
			$report_config->usePatientBarcode = $patient_field_list[9];
		if(!isset($patient_field_list[10]))
			$report_config->usePatientSignature = 0;
		else
			$report_config->usePatientSignature = $patient_field_list[10];

		if(!isset($patient_field_list[11]))
			$report_config->useRequesterName = 0;
		else
			$report_config->useRequesterName = $patient_field_list[11];
		
		if(!isset($patient_field_list[12]))
		{	
			$report_config->useReferredToHospital = 0;
		}else
			$report_config->useReferredToHospital = $patient_field_list[12];
		
		
		# Specimen main fields
		$specimen_field_list = explode(",", $record['s_fields']);
		if(!isset($specimen_field_list[0]))
			$report_config->useSpecimenId = 0;
		else
			$report_config->useSpecimenId = $specimen_field_list[0];
		if(!isset($specimen_field_list[1]))
			$report_config->useSpecimenAddlId = 0;
		else
			$report_config->useSpecimenAddlId = $specimen_field_list[1];
		if(!isset($specimen_field_list[2]))
			$report_config->useDateRecvd = 0;
		else
			$report_config->useDateRecvd = $specimen_field_list[2];
		if(!isset($specimen_field_list[3]))
			$report_config->useComments = 0;
		else
			$report_config->useComments = $specimen_field_list[3];
		if(!isset($specimen_field_list[4]))
			$report_config->useReferredTo = 0;
		else
			$report_config->useReferredTo = $specimen_field_list[4];
		if(!isset($specimen_field_list[5]))
			$report_config->useSpecimenName = 0;
		else
			$report_config->useSpecimenName = $specimen_field_list[5];
		if(!isset($specimen_field_list[6]))
			$report_config->useDoctor = 0;
		else
			$report_config->useDoctor = $specimen_field_list[6];
		
		# Test main fields
		$test_field_list = explode(",", $record['t_fields']);
		if(!isset($test_field_list[0]))
			$report_config->useResults = 0;
		else
			$report_config->useResults = $test_field_list[0];
		if(!isset($test_field_list[1]))
			$report_config->useRange = 0;
		else
			$report_config->useRange = $test_field_list[1];
		if(!isset($test_field_list[2]))
			$report_config->useRemarks = 0;
		else
			$report_config->useRemarks = $test_field_list[2];
		if(!isset($test_field_list[3]))
			$report_config->useEntryDate = 0;
		else
			$report_config->useEntryDate = $test_field_list[3];
		if(!isset($test_field_list[4]))
			$report_config->useEnteredBy = 0;
		else
			$report_config->useEnteredBy = $test_field_list[4];	
		if(!isset($test_field_list[5]))
			$report_config->useVerifiedBy = 0;
		else
			$report_config->useVerifiedBy = $test_field_list[5];
		if(!isset($test_field_list[6]))
			$report_config->useStatus = 0;
		else
			$report_config->useStatus = $test_field_list[6];
		if(!isset($test_field_list[7]))
			$report_config->useTestName = 0;
		else
			$report_config->useTestName = $test_field_list[7];
		if(!isset($test_field_list[8]))
			$report_config->useMeasures = 0;
		else
			$report_config->useMeasures = $test_field_list[8];
		if(!isset($test_field_list[9]))
			$report_config->useClinicalData = 0;
		else
			$report_config->useClinicalData =$test_field_list[9];
		if(!isset($test_field_list[10]))
			$report_config->usePrintConfirm = 0;
		else
			$report_config->usePrintConfirm =$test_field_list[10];
		if(!isset($test_field_list[11]))
			$report_config->useResultConfirm = 0;
		else
			$report_config->useResultConfirm =$test_field_list[11];
		
		# Return data object
		return $report_config;		
	}
	
	public static function getById($lab_config_id, $report_id)
	{
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id);
		$report_id = mysql_real_escape_string($report_id);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string = "SELECT * FROM report_config WHERE report_id=$report_id LIMIT 1";
		$record = query_associative_one($query_string);
		$retval = ReportConfig::getObject($record, $lab_config_id);
		DbUtil::switchRestore($saved_db);
		return $retval;		
	}
	
	public static function getByTestTypeId($lab_config_id, $test_type_id)
	{
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id);
		$test_type_id = mysql_real_escape_string($test_type_id);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string = "SELECT * FROM report_config WHERE test_type_id=$test_type_id LIMIT 1";
		$record = query_associative_one($query_string);
		$retval = ReportConfig::getObject($record, $lab_config_id);
		DbUtil::switchRestore($saved_db);
		return $retval;		
	}
	
	public static function updateToDb(
		$report_config, 
		$margin_csv, 
		$patient_main_field_map, 
		$specimen_main_field_map, 
		$test_main_field_map, 
		$patient_custom_field_map, 
		$specimen_custom_field_map
		//$labtitle_custom_field_map
	)
	{
		$pfield_csv = implode(",", $patient_main_field_map);
		$sfield_csv = implode(",", $specimen_main_field_map);
		$tfield_csv = implode(",", $test_main_field_map);
		$pcustom_csv = implode(",", $patient_custom_field_map);
		$scustom_csv = implode(",", $specimen_custom_field_map);
		$saved_db = DbUtil::switchToLabConfig($report_config->labConfigId);
		$landscape_flag = 0;
		if($report_config->landscape === true)
			$landscape_flag = 1;
		$query_string = 
			"SELECT report_id FROM report_config WHERE report_id=$report_config->reportId LIMIT 1";
		$record = query_associative_one($query_string);
		$footer_designation=implode("#", array($report_config->footerText, $report_config->designation));
		if($record == null || $record['report_id'] == null)
		{
			# New entry to be added
			$query_string = "SELECT max(report_id) AS reportId from report_config";
			$record = query_associative_one($query_string);
			$reportId = $record['reportId'];
			$reportId += 1;
			$query_string = 
				"INSERT INTO report_config (".
					"report_id, test_type_id, header, footer, title, landscape, margins, ".
					"p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields , row_items,show_border,show_result_border ".
				",result_border_horizontal,result_border_vertical) VALUES (".
					"$reportId, $report_config->testTypeId, '$report_config->headerText', '$footer_designation', '$report_config->titleText', $landscape_flag, '$margin_csv', ".
					"'$pfield_csv', '$sfield_csv', '$tfield_csv', '$pcustom_csv', '$scustom_csv','$report_config->rowItems','$report_config->showBorder','$report_config->showResultBorder','$report_config->resultborderHorizontal','$report_config->resultborderVertical'".
				")";
			query_insert_one($query_string);
		}
		else
		{
			# Update existing entry
			$query_string = 
				"UPDATE report_config SET ".
				"header='$report_config->headerText', ".
				"footer='$footer_designation', ".
				"title='$report_config->titleText', ".
				"margins='$margin_csv', ".
				"landscape=$landscape_flag, ".
				"p_fields='$pfield_csv', ".
				"s_fields='$sfield_csv', ".
				"t_fields='$tfield_csv', ".
				"p_custom_fields='$pcustom_csv', ".
				"s_custom_fields='$scustom_csv', ".
				"row_items='$report_config->rowItems', ".
				"show_border='$report_config->showBorder', ".
				"show_result_border='$report_config->showResultBorder', ".
				"result_border_horizontal='$report_config->resultborderHorizontal', ".
				"result_border_vertical='$report_config->resultborderVertical' ".
				"WHERE report_id=$report_config->reportId";
			query_update($query_string);
		}
		
		DbUtil::switchRestore($saved_db);
	}
}

class TestType
{
	public $testTypeId;
	public $name;
	public $description;
	public $clinical_data;
	public $testCategoryId;
	public $isPanel;
	public $hidePatientName;
	public $prevalenceThreshold;
	public $targetTat;
    public $is_report_enabled;
	
	public static function getObject($record)
	{
		# Converts a test_type record in DB into a TestType object
		if($record == null)
			return null;
		$test_type = new TestType();
		$test_type->testTypeId = $record['test_type_id'];
		$test_type->name = $record['name'];
		$test_type->description = $record['description'];
		$test_type->clinical_data=  $record['clinical_data'];
		$test_type->testCategoryId = $record['test_category_id'];
		$test_type->hidePatientName = $record['hide_patient_name'];
		$test_type->prevalenceThreshold = $record['prevalence_threshold'];
		$test_type->targetTat = $record['target_tat'];
        $test_type->is_report_enabled = $record['is_report_enabled'];
		if($record['is_panel'] != null && $record['is_panel'] == 1)
		{
			$test_type->isPanel = true;
		}
		else
		{
			$test_type->isPanel = false;
		}
		return $test_type;
	}
	
	public function getName()
	{
		global $CATALOG_TRANSLATION;
		if($CATALOG_TRANSLATION === true)
		{
			return LangUtil::getTestName($this->testTypeId);
		}
		else
		{
			return $this->name;
		}
	}
	
	public function getDescription()
	{
		if(trim($this->description) == "" || $this->description == null)
			return "-";
		else
			return trim($this->description);
	}
	
	public function getClinicalData()
	{
		if(trim($this->clinical_data) == "" || $this->clinical_data == null)
			return "-";
		else
			return trim($this->clinical_data);
	}
	
	public static function getByCategory($cat_code)
	{
		# Returns all test types belonging to a partciular category (aka section)
		if($cat_code == null || $cat_code == "")
			return null;
		$retval = array();
		$query_string = 
			"SELECT * FROM test_type ".
			"WHERE test_category_id=$cat_code AND disabled=0";
		//$saved_db = DbUtil::switchToLabConfigRevamp();
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
		$resultset = query_associative_all($query_string, $row_count);
		foreach($resultset as $record)
		{
			$retval[] = TestType::getObject($record);
		}
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public static function getById($test_type_id)
	{
		# Returns test type record in DB
		global $con;
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		//$saved_db = DbUtil::switchToLabConfigRevamp();
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
		$query_string =
			"SELECT * FROM test_type WHERE test_type_id=$test_type_id LIMIT 1";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		return TestType::getObject($record);
	}

	public static function getByReportingStatus($status)
    {
        # Return all test types that have reporting enabled/disabled
        $retval = array();
        $query_string = "SELECT * FROM test_type ".
            "WHERE is_reporting_enabled='$status'".
            "ORDER BY name";
        $saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);
        $resultset = query_associative_all($query_string, $row_count);
        foreach ($resultset as $record)
        {
            $retval[] = TestType::getObject($record);
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }

    public static function updateReportingStatus($unadded, $added)
    {
        $query_string = "SELECT test_type_id FROM test_type ".
            "WHERE is_reporting_enabled=1";
        $test_id_list = query_associative_all($query_string, $row_count);
        foreach ($test_id_list as $k=>$v)
            $temp[$k] = $v['test_type_id'];
        $test_id_list = $temp;

        if (is_array($test_id_list))
            $added = array_merge($added, $test_id_list);

        $query_string = "UPDATE test_type SET is_reporting_enabled=0";
        query_update($query_string);

        foreach($added as $id)
        {
            $query_string = "UPDATE test_type SET is_reporting_enabled=1 ".
                "WHERE test_type_id=".$id;
            query_update($query_string);
        }
    }
	
	public function getMeasures()
	{
		# Returns list of measures included in a test type
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"SELECT measure_id FROM test_type_measure ".
			"WHERE test_type_id=$this->testTypeId ";
                        //"ORDER BY ts";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if($resultset) {
			foreach($resultset as $record)
			{
				$measure_obj = Measure::getById($record['measure_id']);
				$retval[] = $measure_obj;
			}
		}
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public function getMeasureIds()
	{
		# Returns list of measure IDs included in a test type
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"SELECT measure_id FROM test_type_measure ".
			"WHERE test_type_id=$this->testTypeId ";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
		{
			$retval[] = $record['measure_id'];
		}
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public static function deleteById($test_type_id)
	{
		# Deletes test type from database
		# 1. Delete entries in lab_config_test_type
		global $con;
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"DELETE FROM lab_config_test_type WHERE test_type_id=$test_type_id";
		query_blind($query_string);
		# 2. Delete entries from specimen_test
		$query_string =
			"DELETE FROM specimen_test WHERE test_type_id=$test_type_id";
		query_blind($query_string);
		# 3. Set disabled flag in test_type entry
		$query_string =
			"UPDATE test_type SET disabled=1 WHERE test_type_id=$test_type_id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function toHidePatientName($test_type_id) {
		global $con;
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		$query_string = 
			"SELECT hide_patient_name FROM test_type WHERE test_type_id=$test_type_id";
		$record = query_associative_one($query_string);
		$retval = $record['hide_patient_name'];
		return $retval;
	}
	
	public static function getNameById($id)
	{
		$query_string = "SELECT name FROM `test_type` WHERE `test_type_id` = $id";
		
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

		$retVal = query_associative_one($query_string);

		DbUtil::switchRestore($saved_db);
		
		return $retVal['name'];
	}
}

class SpecimenType
{
	public $specimenTypeId;
	public $name;
	public $description;
	
	public static function getObject($record)
	{
		if($record == null)
			return null;
			
		$specimen_type = new SpecimenType();
		
		if(isset($record['specimen_type_id']))
			$specimen_type->specimenTypeId = $record['specimen_type_id'];
		else
			$specimen_type->specimenTypeId = null;
		
		if(isset($record['name']))
			$specimen_type->name = $record['name'];
		else
			$specimen_type->name = null;
			
		if(isset($record['description']))
			$specimen_type->description = $record['description'];
		else
			$specimen_type->description = null;
			
		return $specimen_type;
	}
	
	public function getName()
	{
		global $CATALOG_TRANSLATION;
		if($CATALOG_TRANSLATION === true)
		{
			return LangUtil::getSpecimenName($this->specimenTypeId);
		}
		else
		{
			return $this->name;
		}
	}
	
	public function getDescription()
	{
		if(trim($this->description) == "" || $this->description == null)
			return "-";
		else 
			return trim($this->description);
	}
	
	public static function getById($specimen_type_id)
	{
		# Returns a specimen type entry fetch by ID
		global $con;
		$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"SELECT * FROM specimen_type ".
			"WHERE specimen_type_id=$specimen_type_id";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		return SpecimenType::getObject($record);
	}
	
	public static function deleteById($specimen_type_id)
	{
		# Deletes specimen type from database
		# 1. Delete entries in lab_config_specimen_type
		global $con;
		$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"DELETE FROM lab_config_specimen_type WHERE specimen_type_id=$specimen_type_id";
		query_blind($query_string);
		# 2. Delete entries from specimen_test
		$query_string =
			"DELETE FROM specimen_test WHERE specimen_type_id=$specimen_type_id";
		query_blind($query_string);
		# 3. Set disabled flag in specimen_type entry
		$query_string =
			"UPDATE specimen_type SET disabled=1 WHERE specimen_type_id=$specimen_type_id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
}

class Measure
{
	# For each test indicator in 'measure' table
	
	public $measureId;
	public $name;
	public $unit;
	public $description;
	public $range;
	
	public static $RANGE_ERROR = 0;
	public static $RANGE_OPTIONS = 1;
	public static $RANGE_NUMERIC = 2;
	public static $RANGE_MULTI = 3;
	public static $RANGE_AUTOCOMPLETE = 4;
	//nc40
        public static $RANGE_FREETEXT = 5;
        //-nc40
        
        # nc50
        public static $RANGE_SUBTYPE = 6;
        
	public static function getObject($record)
	{
		# Converts a measure record in DB into a Measure object
		if($record == null)
			return null;
		$measure = new Measure();
		$measure->measureId = $record['measure_id'];
		$measure->name = $record['name'];
		$measure->unit = $record['unit'];
		$measure->description = $record['description'];
		$measure->range = $record['range'];
		return $measure;
	}
	
	public function getName()
	{
		global $CATALOG_TRANSLATION;
		if($CATALOG_TRANSLATION === true)
		{
			return LangUtil::getMeasureName($this->measureId);
		}
		else
		{
                    /*
                    if(strpos($this->name, "\$sub") !== false)
                    {
                        $encName = $this->name;
                        $start_tag = "\$sub*";
                        $end_tag = "/\$";
                        $subm_end = strpos($encName, $end_tag);
                        $decName = substr($encName, $subm_end + 2);
                        return $decName;
                    }
                    else
                    */
			return $this->name;
                    
		}
	}
	
	public function getRangeType()
	{
		if(strpos($this->range, "_") !== false)
		{
			return Measure::$RANGE_AUTOCOMPLETE;
		}
		else if(strpos($this->range, ":") !== false)
		{
			return Measure::$RANGE_NUMERIC;
		}
		else if(strpos($this->range, "*") !== false)
		{
			return Measure::$RANGE_MULTI;
		}	
		else if(strpos($this->range, "/") !== false)
		{
			return Measure::$RANGE_OPTIONS;
		}
                //nc40
		else if(strpos($this->range, "\$freetext\$") !== false)
                {
                    return Measure::$RANGE_FREETEXT;
                }
		//-nc40
                
		else 
		{
			return Measure::$RANGE_ERROR;
		}
	}
	
        #nc50
        public function checkIfSubmeasure()
        {
                if(strpos($this->name, "\$sub") !== false)
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
        }
        
        #nc50
        public function truncateSubmeasureTag()
        {
            $encName = $this->name;
            $start_tag = "\$sub*";
            $end_tag = "/\$";
            $subm_end = strpos($encName, $end_tag);
            $decName = substr($encName, $subm_end + 2);
            return $decName;
        }
        
        # nc50
        public function getSubmeasureParent()
        {
            $encName = $this->name;
            $start_tag = "\$sub*";
            $end_tag = "/\$";
            $subm_end = strpos($encName, $end_tag);
            $parent = substr($encName, 5, $end_tag - 5);
            $parent_int = intval($parent);
            return $parent_int;
        }
        
        #nc50
        public function getSubmeasuresAsObj()
        {
            $id = $this->measureId;
            $tagID = "\$sub*".$id."/\$";
            $submeasureList = array();
             $query_string =
			"SELECT * FROM measure ";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$recordset = query_associative_all($query_string, $row_count);
                DbUtil::switchRestore($saved_db);
                foreach( $recordset as $record ) 
                {
				$measureName = $record['name'];
                                $smID = intval($record['measure_id']);
                                if(strpos($measureName, $tagID) !== false)
                                {
                                    //echo "<br>---".strpos($measureName, $tagID);
                                    $smObj = Measure::getById($record['measure_id']);
                                    array_push($submeasureList, $smObj);
                                }
		}
                return $submeasureList;
        }
        
        public function getSubmeasures()
        {
            $id = $this->measureId;
            $tagID = "\$sub*".$id."/\$";
            $submeasureList = array();
             $query_string =
			"SELECT * FROM measure ";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$recordset = query_associative_one($query_string);
                DbUtil::switchRestore($saved_db);
                foreach( $recordset as $record ) 
                {
				$measureName = $record['name'];
                                $smID = intval($record['measure_id']);
                                if(strpos($measureName, $tagID) !== false)
                                {
                                    array_push($submeasureList, $smID);
                                }
		}
                return $submeasureList;
        }
        
	public function getRangeValues($patient=null)
	{
		# Returns range values in a list
		
		$range_type = $this->getRangeType();
		$retval = array();
		switch($range_type)
		{
			case Measure::$RANGE_NUMERIC:
				# check if ref range is already configured
				$ref_range = null;
				if($patient != null)
				{	$ref_range = ReferenceRange::getByAgeAndSex($patient->getAgeNumber(), $patient->sex, $this->measureId, $_SESSION['lab_config_id']);
				
				}
				if($ref_range == null)
					# Fetch from default entry in 'measure' table
					$retval = explode(":", $this->range);
				else
					$retval = array($ref_range->rangeLower, $ref_range->rangeUpper);
				break;
			case Measure::$RANGE_OPTIONS:
			
			{
			$retval = explode("/", $this->range);
				
				foreach($retval as $key=>$value)
				{
				
				$retval[$key]=str_replace("#","/",$value);
				}
			break;
			}
			case Measure::$RANGE_AUTOCOMPLETE:
				$retval = explode("_", $this->range);
				foreach($retval as $key=>$value)
				{
				$retval[$key]=str_replace("#","_",$value);
				}
				break;
                                
                        case Measure::$RANGE_FREETEXT:
				$retval = "Free Text Measure Type";
				break;
		}
		return $retval;
	}
	
	public function getRangeString($patient=null)
	{
		# Returns range in string for printing or displaying
		$retval = "";
		if
		(
			$this->getRangeType() == Measure::$RANGE_OPTIONS ||
			$this->getRangeType() == Measure::$RANGE_MULTI ||
			$this->getRangeType() == Measure::$RANGE_AUTOCOMPLETE ||
                        $this->getRangeType() == Measure::$RANGE_FREETEXT
		)
		{
			$range_parts = explode("/", $this->range);
			# TODO: Display possible options for result indicator??
			$retval .= "-";
		}
		else if($this->getRangeType() == Measure::$RANGE_NUMERIC)
		{
			$ref_range = null;
			if($patient != null)
				$ref_range = ReferenceRange::getByAgeAndSex($patient->getAgeNumber(), $patient->sex, $this->measureId, $_SESSION['lab_config_id']);
			if($ref_range == null)
				# Fetch from default entry in 'measure' table
				$range_parts = explode(":", $this->range);
			else
				$range_parts = array($ref_range->rangeLower, $ref_range->rangeUpper);
			$retval .= "(".$range_parts[0]."-".$range_parts[1];
			if($this->range != null && trim($this->range) != "")
				$retval .= "  ".$this->unit;
			$retval .= ")";
		}
		
		return $range_parts;
                
	}
	
	public function getUnits()
	{
		return $this->unit;
	}
	
	public static function getById($measure_id)
	{
		# Returns a test measure by ID
		global $con;
		$measure_id = mysql_real_escape_string($measure_id, $con);
		if($measure_id == null || $measure_id < 0)
			return null;
		$query_string = "SELECT * FROM measure WHERE measure_id=$measure_id LIMIT 1";
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		return Measure::getObject($record);		
	}
	
	public function updateToDb()
	{
		# Updates an existing measure entry in DB
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"UPDATE measure SET name='$this->name', range='$this->range', unit='$this->unit' ".
			"WHERE measure_id=$this->measureId";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function setInterpretation($inter)
	{
		# Updates an existing measure entry in DB
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"UPDATE measure SET description='$inter'".
			"WHERE measure_id=$this->measureId";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	public function setNumericInterpretation($remarks_list,$id_list, $range_l_list, $range_u_list, $age_u_list, $age_l_list, $gender_list)
	{
		# Updates an existing measure entry in DB
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$count = 0;
		if($id_list[0]==-1)
		{
		foreach($range_l_list as $range_value)
				{
			//insert query
			$query_string="INSERT INTO NUMERIC_INTERPRETATION (range_u, range_l, age_u, age_l, gender, description, measure_id) ".
			"VALUES($range_u_list[$count],$range_l_list[$count],$age_u_list[$count],$age_l_list[$count],'$gender_list[$count]','$remarks_list[$count]',$this->measureId)";
			query_insert_one($query_string);
			$count++;
				}
		}
		else
		{
		foreach($range_l_list as $range_value)
			{
				if($id_list[$count]!=-2)
					{
						if($remarks_list[$count]=="")
							{
						//delete
						$query_string="DELETE FROM NUMERIC_INTERPRETATION WHERE id=$id_list[$count]";
						query_delete($query_string);
						}else
							{
							//update
						$query_string = 
						"UPDATE numeric_interpretation SET range_u=$range_u_list[$count], range_l=$range_l_list[$count], age_u=$age_u_list[$count], age_l=$age_l_list[$count], gender='$gender_list[$count]' , description='$remarks_list[$count]' ".
						"WHERE id=$id_list[$count]";
						query_update($query_string);
						
						}
				}else
					{
					$query_string="INSERT INTO numeric_interpretation (range_u, range_l, age_u, age_l, gender, description, measure_id) ".
			"VALUES($range_u_list[$count],$range_l_list[$count],$age_u_list[$count],$age_l_list[$count],'$gender_list[$count]','$remarks_list[$count]',$this->measureId)";
			query_insert_one($query_string);
				}
		
		$count++;
		}
	}
	DbUtil::switchRestore($saved_db);
	}
	
	public function getNumericInterpretation()
	{
	$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = "SELECT * FROM numeric_interpretation WHERE measure_id=$this->measureId";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if($resultset!=NULL)
			{
			foreach($resultset as $record)
			{
				$range_u=$record['range_u'];
				$range_l=$record['range_l'];
				$age_u=$record['age_u'];
				$age_l=$record['age_l'];
				$gender=$record['gender'];
				$id=$record['id'];
				$description=$record['description'];
				$measure_id=$record['measure_id'];
				$retval[] =array($range_l,$range_u,$age_l,$age_u,$gender,$description,$id,$measure_id);
			}
			
		}else
			{
		//get interpretation ka loop
			}
	DbUtil::switchRestore($saved_db);
	return $retval;
	}
	
	public function addToDb()
	{
		# Updates an existing measure entry in DB
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"INSERT INTO measure (name, range, unit) ".
			"VALUES ('$this->name', '$this->range', '$this->unit')".
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function getReferenceRanges($lab_config_id)
	{
		# Fetches reference ranges from database for this measure
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string = "SELECT * FROM reference_range WHERE measure_id=$this->measureId ORDER BY sex DESC";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if ($resultset!=NULL)
		{
			foreach($resultset as $record)
			{
				$retval[] = ReferenceRange::getObject($record);
			}
		}	
			DbUtil::switchRestore($saved_db);
			return $retval;
	}
	
	public function getInterpretation()
	{	
		$retval= array();
		$numeric_description=array();
		if(trim($this->description) == "" || $this->description == null)
			return $retval;
		else 
		{
		$description=substr(($this->description),2);
		if(strpos($description,"##")===false)
		$retval=explode("//" , $description);
		else
		$retval=explode("##",$description);
		}
		
		return $retval;
	}
	
	public function getDescription()
	{
		if(trim($this->description) == "" || $this->description == null)
			return "-";
		else
			return trim($this->description);
	}

}

class Patient
{
	public $patientId; # db primary key
	public $addlId;
	public $name;
	public $dob;
	public $partialDob;
	public $age;
	public $sex;
	public $surrogateId; # surrogate key (user facing)
	public $createdBy; # user ID who registered this patient
	public $hashValue; # hash value for this patient (based on name, dob, sex)
	public $regDate;
	
	public $specimenCount;
	public static function getObject($record)
	{
		# Converts a patient record in DB into a Patient object
		if($record == null)
			return null;
		$patient = new Patient();
		$patient->patientId = $record['patient_id'];
		$patient->addlId = $record['addl_id'];
		$patient->name = $record['name'];
		$patient->dob = $record['dob'];
		$patient->age = $record['age'];
		$patient->sex = $record['sex'];
		$date_parts = explode(" ", date($record['ts']));
		$date_parts_1=explode("-",$date_parts[0]);
		$patient->regDate=$date_parts_1[2]."-".$date_parts_1[1]."-".$date_parts_1[0];
		
		$patient->specimenCount = 0;
		$args = func_get_args();
		if(func_num_args() ==1){
			$patient->specimenCount = 0;
		} else {
			$patient->specimenCount = $args[1];
		}
		
		if(isset($record['partial_dob']))
			$patient->partialDob = $record['partial_dob'];
		else
			$patient->partialDob = null;
		if(isset($record['surr_id']))
			$patient->surrogateId = $record['surr_id'];
		else
			$patient->surrogateId = null;
		if(isset($record['created_by']))
			$patient->createdBy = $record['created_by'];
		else
			$patient->createdBy = null;
		if(isset($record['hash_value']))
			$patient->hashValue = $record['hash_value'];
		else
			$patient->hashValue = null;
		return $patient;
	}
	
	public static function checkNameExists($name)
	{
		# Checks if the given patient name (or similar match) already exists
		global $con;
		$name = mysql_real_escape_string($name, $con);
		$query_string = 
			"SELECT COUNT(patient_id) AS val FROM patient WHERE name LIKE '%$name%'";
		$resultset = query_associative_one($query_string);
		if($resultset == null || $resultset['val'] == 0)
			return false;
		else
			return true;
	}
	
	public function getName()
	{
		if(trim($this->name) == "")
			return " - ";
		else
			return $this->name;
	}
	
	public function getAddlId()
	{
		if($this->addlId == "")
			return " - ";
		else
			return $this->addlId;
	}
	
	public function getAssociatedTests() {
		if( $this->patientId == "" )
			return " - ";
		else {
			$query_string = "SELECT t.test_type_id FROM test t, specimen sp ".
							"WHERE t.result <> '' ".
							"AND t.specimen_id=sp.specimen_id ".
							"AND sp.patient_id=$this->patientId";
			$recordset = query_associative_all($query_string, $row_count);
			foreach( $recordset as $record ) {
				$testName = get_test_name_by_id($record['test_type_id']);
				$result .= $testName."<br>";
			}
			return $result;
		}
	}
	
	public function getAge()
	{
		# Returns patient age value
		if($this->partialDob == "" || $this->partialDob == null)
		{
			if($this->dob != null && $this->dob != "")
			{
				# DoB present in patient record
				return DateLib::dobToAge($this->dob);
			}
			else 
			{	$age_value=-1*$this->age;
				if($age_value>100){
					$age_value=200-$age_value;
					$age_value=">".$age_value;
					}
				else
					{
					$diff=$age_value%10;
					$age_range1=$age_value-$diff;
					$age_range2=$age_range1+10;
					$age_value=$age_range1."-".$age_range2;
					}
					if($this->age < 0)
				$this->age=$age_value;
				return $this->age." ".LangUtil::$generalTerms['YEARS'];
			}
		}
		else
		{
			# Calculate age from partial DoB
			$aprrox_dob = "";
			if(strpos($this->partialDob, "-") === false)
			{
				# Year-only specified
				$approx_dob = trim($this->partialDob)."-01-01";
			}
			else
			{
				# Year and month specified
				$approx_dob = trim($this->partialDob)."-01";
			}
			return DateLib::dobToAge($approx_dob);
		}
	}
	
	public function getAgeNumber()
	{
		# Returns patient age value (numeric part alone)
		if($this->partialDob == "" || $this->partialDob == null)
		{
			if($this->dob != null && $this->dob != "")
			{
				# DoB present in patient record
				return DateLib::dobToAgeNumber($this->dob);
			}
			else
			{	if($this->age<100)
					$this->age=200+$this->age;
				else if($this->age<0)
					$this->age=-1*$this->age;
			
				return $this->age;
			}
		}
		else
		{
			# Calculate age from partial DoB
			$aprrox_dob = "";
			if(strpos($this->partialDob, "-") === false)
			{
				# Year-only specified
				$approx_dob = trim($this->partialDob)."-01-01";
			}
			else
			{
				# Year and month specified
				$approx_dob = trim($this->partialDob)."-01";
			}
			return DateLib::dobToAgeNumber($approx_dob);
		}
	}
	
	public function getDob()
	{
		# Returns patient dob value
		if($this->partialDob != null && $this->partialDob != "")
		{
			return $this->partialDob." (".LangUtil::$generalTerms['APPROX'].")";
		}
		else if($this->dob == null || trim($this->dob) == "")
		{
			return " - ";
		}
		else
		{
			return DateLib::mysqlToString($this->dob);
		}
	}
	
	public static function getByAddDate($date)
	{
		# Returns all patient records added on that date
		global $con;
		$date = mysql_real_escape_string($date, $con);
		$query_string = 
			"SELECT * FROM patient ".
			"WHERE ts LIKE '%$date%' ORDER BY patient_id";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
			$retval[] = Patient::getObject($record);
		return $retval;
	}
	
	public static function getByAddDateRange($date_from, $date_to)
	{
		# Returns all patient records added on that date range
		$query_string = 
			"SELECT * FROM patient ".
			"WHERE UNIX_TIMESTAMP(ts) >= UNIX_TIMESTAMP('$date_from 00:00:00') ".
			"AND UNIX_TIMESTAMP(ts) <= UNIX_TIMESTAMP('$date_to 23:59:59') ".
			"ORDER BY patient_id";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
			$retval[] = Patient::getObject($record);
		return $retval;
	}
	
	public static function getByRegDateRange($date_from , $date_to)
	{
	$query_string =
			"SELECT DISTINCT patient_id FROM specimen ".
			"WHERE date_collected BETWEEN '$date_from' AND '$date_to'";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		$record_p=array();
			foreach($resultset as $record)
			{
				foreach($record as $key=>$value){
				$query_string = "SELECT * FROM patient WHERE patient_id=$value";
				$record_each= query_associative_one($query_string);
				$record_p[]=Patient::getObject($record_each);
				}
			}
		return $record_p;	
	
	}

	public static function getReportedByRegDateRange($date_from , $date_to, $lab_section)
	{
		$emp="";
		$query_string = "";
		if($lab_section == 0){
		$query_string =
				"SELECT DISTINCT patient_id FROM specimen , test ".
				"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
				"AND result!='$emp' ".
				"AND specimen.specimen_id=test.specimen_id AND patient_id
						 NOT IN
			(SELECT DISTINCT patient_id FROM specimen , test ".
			"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
			"AND result='$emp' ".
			"AND specimen.specimen_id=test.specimen_id)";
		} else {
			$query_string_for_test_type_id = "select test_type_id from test_type where test_category_id=$lab_section";
			$resultsetTestIDs = query_associative_all($query_string_for_test_type_id, $row_count);
			$testidsarr = array();
			$counter = 0;
			foreach($resultsetTestIDs as $key => $values){
				array_push($testidsarr,$values['test_type_id']);
				$counter++;
			}
			$testids = join(',',$testidsarr);
			$labsecwise_addon = "";
			if($counter > 0){
				$labsecwise_addon = "AND test.test_type_id IN ($testids)";
			} else {
				$record_p=array();
				return $record_p;
			}
			$query_string =
			"SELECT DISTINCT patient_id FROM specimen , test ".
			"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
			"AND result!='$emp' ".
			"AND specimen.specimen_id=test.specimen_id ".$labsecwise_addon." AND patient_id 
						 NOT IN
			(SELECT DISTINCT patient_id FROM specimen , test ".
						"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
						"AND result='$emp' ".
						"AND specimen.specimen_id=test.specimen_id)".$labsecwise_addon;
			
		}
		//;
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		$record_p=array();
		$count = 0;
		foreach($resultset as $record)
		{
			foreach($record as $key=>$value) {
				$query_string = "SELECT * FROM patient WHERE patient_id=$value";
				$record_each= query_associative_one($query_string);
				$record_p[]=Patient::getObject($record_each);
			}
		}
		//$unreportedList = self::getUnReportedByRegDateRange($date_from, $date_to);
		return $record_p;	
	
	}
	
	
	public static function getPatientsAndSpecimenCountByRegDateRange($date_from , $date_to)
	{
		$query_string =
		"SELECT patient_id as patientId, count(*) as specimenCount FROM specimen ". 
		"WHERE date_collected BETWEEN '$date_from' AND '$date_to'".
 		"group by patientId order by SpecimenCount desc";
		
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		$record_p=array();
		$count = 0;
		foreach($resultset as $record)
		{
			$record_each="";
			$select = true;
			foreach($record as $key=>$value) {
				//$patientId = $obj['patientId'];
				//$specimenCount = $obj['specimenCount'];
				if($select)
				{
					$query_string = "SELECT * FROM patient WHERE patient_id=$value";
					$record_each= query_associative_one($query_string);
					$select = false;
				} else {
					$record_p[]=Patient::getObject($record_each, $value);
					$select = true;
				}
			}
		}
		//$unreportedList = self::getUnReportedByRegDateRange($date_from, $date_to);
		return $record_p;
	
	}
	

	public static function getUnReportedByRegDateRange($date_from , $date_to, $lab_section)
	{
		$emp="";
		$query_string = "";
		if($lab_section == 0){
		$query_string =
			"SELECT DISTINCT patient_id FROM specimen , test ".
			"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
			"AND result='$emp' ".
			"AND specimen.specimen_id=test.specimen_id";
		} else {
			$query_string_for_test_type_id = "select test_type_id from test_type where test_category_id=$lab_section";
			//_for_test_type_id;
			$resultsetTestIDs = query_associative_all($query_string_for_test_type_id, $row_count);
			$testidsarr = array();
			$counter = 0;
			foreach($resultsetTestIDs as $key => $values){
				array_push($testidsarr,$values['test_type_id']);
				$counter++;
			}
			$testids = join(',',$testidsarr);
			$labsecwise_addon = "";
			if($counter > 0){
				$labsecwise_addon = "AND test.test_type_id IN ($testids)";
			}else {
				return;
			}
			$query_string =
			"SELECT DISTINCT patient_id FROM specimen , test ".
			"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
			"AND result='$emp' ".
			"AND specimen.specimen_id=test.specimen_id ".$labsecwise_addon;
		}
		//;
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		$record_p=array();
		foreach($resultset as $record) {
			foreach($record as $key=>$value)
				$query_string = "SELECT * FROM patient WHERE patient_id=$value";
			$record_each= query_associative_one($query_string);
			$record_p[]=Patient::getObject($record_each);
		}
		return $record_p;
	}

	
	public static function getById($patient_id)
	{
		# Returns patient record by ID
		global $con;
		$patient_id = mysql_real_escape_string($patient_id, $con);
		$query_string = "SELECT * FROM patient WHERE patient_id=$patient_id";
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		return Patient::getObject($record);
	}
	
	public function getSurrogateId()
	{
		if($this->surrogateId == null || trim($this->surrogateId) == "")
			return "-";
		else
			return $this->surrogateId;
	}
	
	public function getSpecimenCount()
	{
		if($this->specimenCount == null || trim($this->specimenCount) == "")
			return 0;
		else
			return $this->specimenCount;
	}
	
	public function getDailyNum()
	{
		# Returns daily number ("patient number")
		# Fetches value from the latest specimen which was assigned to this patient
		$query_string =
			"SELECT s.daily_num FROM specimen s, patient p ".
			"WHERE s.patient_id=p.patient_id ".
			"AND p.patient_id=$this->patientId ".
			"ORDER BY s.date_collected DESC";
		$record = query_associative_one($query_string);		
		$retval = "";
		if($record == null || trim($record['daily_num']) == "")
			$retval = "-";
		else
			$retval = $record['daily_num'];
		return $retval;
	}

	public function generateHashValue()
	{
		# Generates hash value for this patient (based on name, age and date of birth)
		$name_part = strtolower(str_replace(" ", "", $this->name));
		$sex_part = strtolower($this->sex);
		$dob_part = "";
		if($this->partialDob != null && trim($this->partialDob) != "")
		{	
			# Determine unix timestamp based on partial (approximate) date of birth
			$approx_dob = "";
			if(strpos($this->partialDob, "-") === false)
			{
				# Year-only specified
				$approx_dob = trim($this->partialDob)."-01-01";
			}
			else
			{
				# Year and month specified
				$approx_dob = trim($this->partialDob)."-01";
			}
			list($year, $month, $day) = explode('-', $approx_dob);
			$dob_part = mktime(0, 0, 0, $month, $day, $year);
		}
		else
		{
			# Determine unix timestamp based on complete data of birth
			$dob = $this->dob;
			list($year, $month, $day) = explode('-', $dob);
			$dob_part = mktime(0, 0, 0, $month, $day, $year);
		}
		$hash_input = $name_part.$dob_part.$sex_part;
		# TODO: Provide choice of hashing schemes
		$retval = sha1($hash_input);
		return $retval;
	}
	
	public function getHashValue()
	{
		$retval = $this->hashValue;
		return $retval;
	}
	
	public function getSex()
	{
	$sex=$this->sex;
	
	return $sex;
	}
	
	public function setHashValue($hash_value)
	{
		if($hash_value == null || trim($hash_value) == "")
			return;
		$query_string = 
			"UPDATE patient SET hash_value='$hash_value' ".
			"WHERE patient_id=$this->patientId";
		query_update($query_string);
	}
	
	#updates patients ordered fields on reports
	public static function updateReportOrder($p_fields, $o_fields)
	{
		$query_string ="select count(id) as val from patient_report_fields_order";
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

		$resultset = query_associative_one($query_string);
		if($resultset == null || $resultset['val'] == 0)
		{
			$query_string="insert into patient_report_fields_order(p_fields,o_fields)
			values('$p_fields','$o_fields') ";
		}
		else
		{
			$query_string="update patient_report_fields_order set p_fields='$p_fields',o_fields='$o_fields'";
			
		}
		
		query_update($query_string);
		
		DbUtil::switchRestore($saved_db);
	}
	
	public static function getReportfieldsOrder()
	{
		$query_string ="select * from patient_report_fields_order limit 1";
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);
		$record = query_associative_one($query_string);
		return $record;
	}
}

class Specimen
{
	public $specimenId;
	public $specimenTypeId;
	public $patientId;
	public $statusCodeId;
	public $referredTo;
	public $comments;
	public $dateRecvd;
	public $dateCollected;
	public $timeCollected;
	public $sessionNum;
	public $auxId;
	public $userId;
	public $reportTo;
	public $doctor;
	public $dateReported;
	public $referredToName;
	public $dailyNum;
    public $site_id;
	
	public $referredFromName;
	
	public static $STATUS_PENDING = 0;
	public static $STATUS_DONE = 1;
	public static $STATUS_REFERRED = 2;
	public static $STATUS_TOVERIFY = 3;
	public static $STATUS_REPORTED = 4;
	public static $STATUS_RETURNED = 5;
	
	public static function getObject($record)
	{
		# Converts a specimen record in DB into a Specimen object
		if($record == null)
			return null;
		$specimen = new Specimen();
		$specimen->specimenId = $record['specimen_id'];
		$specimen->specimenTypeId = $record['specimen_type_id'];
		$specimen->patientId = $record['patient_id'];
		$specimen->userId = $record['user_id'];
		$specimen->dateCollected = $record['date_collected'];
		if(isset($record['date_recvd']))
			$specimen->dateRecvd = $record['date_recvd'];
		else
			$specimen->dateRecvd = null;
		if(isset($record['time_collected']))
			$specimen->timeCollected = $record['time_collected'];
		else
			$specimen->timeCollected = null;
		if(isset($record['session_num']))
			$specimen->sessionNum = $record['session_num'];
		else
			$specimen->sessionNum = null;
		if(isset($record['status_code_id']))
			$specimen->statusCodeId = $record['status_code_id'];
		else
			$specimen->statusCodeId = null;
		if(isset($record['referred_to']))
			$specimen->referredTo = $record['referred_to'];
		else
			$specimen->referredTo = null;
		if(isset($record['comments']))
			$specimen->comments = $record['comments'];
		else
			$specimen->comments = null;
		if(isset($record['aux_id']))
			$specimen->auxId = $record['aux_id'];
		else
			$specimen->auxId = null;
		if(isset($record['report_to']))
			$specimen->reportTo = $record['report_to'];
		else
			$specimen->reportTo = null;
		if(isset($record['doctor']))
			{
			$specimen->doctor = $record['doctor'];
			}
			
		else
			$specimen->doctor = null;
		if(isset($record['date_reported']))
			$specimen->dateReported = $record['date_reported'];
		else
			$specimen->dateReported = null;
		if(isset($record['referred_to_name']))
			$specimen->referredToName = $record['referred_to_name'];
		else
			$specimen->referredToName = null;
		
		if(isset($record['referred_from_name']))
			$specimen->referredFromName = $record['referred_from_name'];
		else
			$specimen->referredFromName = null;
		
		if(isset($record['daily_num']))
			$specimen->dailyNum = $record['daily_num'];
		else
			$specimen->dailyNum = null;

        if(isset($record['site_id']))
            $specimen->site_id = $record['site_id'];
        else {
            $lab_config = LabConfig::getById($_SESSION['lab_config_id']);
            $specimen->site_id = Sites::getDefaultSite($lab_config)->id;
        }
		return $specimen;
	}
	
	public static function getById($specimen_id)
	{
		global $con;
		$specimen_id = mysql_real_escape_string($specimen_id, $con);
		$query_string = "SELECT * FROM specimen WHERE specimen_id=$specimen_id LIMIT 1";
		$record = query_associative_one($query_string);
		return Specimen::getObject($record);
	}
	
	public function getComments()
	{
		if(trim($this->comments) == "" || $this->comments == null)
			echo "-";
		else
			echo $this->comments;
	}
	
	public function getAuxId()
	{
		if($this->auxId == "" || $this->auxId == null)
			echo "-";
		else
			echo $this->auxId;
	}
	
	public function getStatus()
	{
		switch($this->statusCodeId)
		{
			case Specimen::$STATUS_PENDING:
				return LangUtil::$generalTerms['PENDING_RESULTS'];
				break;
			case Specimen::$STATUS_DONE:
				return LangUtil::$generalTerms['DONE'];
				break;
			case Specimen::$STATUS_REFERRED:
				return LangUtil::$generalTerms['REF_OUT'];
				break;
			case Specimen::$STATUS_TOVERIFY:
				return LangUtil::$generalTerms['PENDING_VER'];
				break;
			case Specimen::$STATUS_RETURNED:
				return LangUtil::$generalTerms['REF_RETURNED'];
				break;
		}
	}
	
	public function getReportTo()
	{
		if($this->reportTo == null)
			return "-";
		if($this->reportTo == 1)
			return LangUtil::$generalTerms['PATIENT'];
		if(trim($this->doctor) == "")
			return LangUtil::$generalTerms['DOCTOR'];
		return trim($this->doctor);
	}
	
	public function isReported()
	{
		if(($this->dateReported != null || trim($this->dateReported) != ""))
			return true;
		else
			return false;
	}
	
	public function getDateReported()
	{
		if($this->dateReported == null || $this->dateReported == "")
			return null;
		else
		{
			$date_parts = explode(" ", $this->dateReported);
			return DateLib::mysqlToString($date_parts[0])." ".$date_parts[1];
		}
	}
	
	public function setDateReported($date_reported)
	{
		# Sets value for date_reported
		if($date_reported == null)
			return;
		$query_string = 
			"UPDATE specimen SET date_reported='$date_reported' WHERE specimen_id=".$this->specimenId;
		query_blind($query_string);
	}
	
	public static function getUnreported()
	{
		# Returns all test results that have been entered but not reported
		$query_string = 
			"SELECT sp.* FROM specimen sp ".
			"WHERE sp.report_to <> '' ".
			"AND sp.date_reported IS NULL ".
			"AND ( ".
				"SELECT DISTINCT t.specimen_id FROM test t ".
				"WHERE t.specimen_id=sp.specimen_id ".
				"AND t.result = '' ".
				") IS NULL";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if($resultset == null)
			return $retval;
		foreach($resultset as $record)
		{
			$retval[] = Specimen::getObject($record);
		}
		return $retval;
	}
	
	public static function markAsReported($specimen_id, $timestamp)
	{
		# Marks a given specimen as reported as sets 'date_reported'
		global $con;
		$specimen_id = mysql_real_escape_string($specimen_id, $con);
		$query_string = 
			"UPDATE specimen ".
			"SET date_reported='$timestamp' ".
			"WHERE specimen_id=$specimen_id";
		query_blind($query_string);
	}
	
	public function getTypeName()
	{
		$specimen_type = SpecimenType::getById($this->specimenTypeId);
		if($specimen_type == null)
			return LangUtil::$generalTerms['NOTKNOWN'];
		return $specimen_type->getName();
	}
	
	public function getSessionNum()
	{
		if(trim($this->sessionNum) == "" || $this->sessionNum == null)
			return " -  ";
		else 
			return trim($this->sessionNum);
	}
	
	public function getTestNames()
	{
		$query_string = "SELECT test_type_id FROM test WHERE specimen_id=$this->specimenId";
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
		$resultset = query_associative_all($query_string, $row_count);
		DbUtil::switchRestore($saved_db);
		$retval = "";
		$count = 0;
		foreach($resultset as $record)
		{
			$count++;
			$test_type_id = $record['test_type_id'];
			$test_name = get_test_name_by_id($test_type_id);
			$retval .= $test_name;
			if($count < count($resultset))
			{
				$retval .= "<br>";
			}
		}
		return $retval;
	}
	
	public function getDailyNum()
	{
		if(trim($this->dailyNum) == "" || $this->dailyNum == 0)
			return "-";
		$dnum_parts = explode("-", $this->dailyNum);
		return $dnum_parts[1];
	}
	
	public function getDailyNumFull()
	{
		if(trim($this->dailyNum) == "" || $this->dailyNum == 0)
			return "-";
		return $this->dailyNum;
	}
	
	public function getDailyNumExpand()
	{
		if(trim($this->dailyNum) == "" || $this->dailyNum == 0)
			return "-";
		$today_string = date("Ymd");
		$dnum_parts = explode("-", $this->dailyNum);
		return $dnum_parts[1];
		if(strpos($this->dailyNum, $today_string."-") === false)
			return $this->dailyNum;
		else
			return $dnum_parts[1];
			
	}
	
	public function getReferredToName()
	{
		if($this->referredToName == null || trim($this->referredToName) == "")
			return "-";
		return trim($this->referredToName);
	}
	
	public function getReferredFromName()
	{
		if($this->referredFromName == null || trim($this->referredFromName) == "")
			return "-";
		return trim($this->referredFromName);
	}
	
	public function getDoctor()
	{
		if($this->doctor == "" || $this->doctor == null)
			return "-";
		else
			return $this->doctor;
			
			
	}

	public static function getSpecimensByDateRange($specimen_type_id, $from, $to)
    {
        $query = "SELECT * FROM specimen WHERE ".
            "specimen_type_id='$specimen_type_id' AND ".
            "date_collected BETWEEN '$from' AND '$to' ";
        $result = query_associative_all($query, null);

        if ($result == null)
            return null;

        $ret = array();
        foreach ($result as $record) {
            $ret[] = self::getObject($record);
        }

        return $ret;
    }
}

class Test
{
	public $testId;
	public $testTypeId;
	public $specimenId;
	public $result;
	public $comments;
	public $userId;
	public $verifiedBy;
	public $dateVerified;
	public $timestamp;
	public $ts;
	
	public static function getObject($record)
	{
		# Converts a test record in DB into a Test object
		if($record == null)
			return null;
		$test = new Test();
		
		if(isset($record['test_id']))
			$test->testId = $record['test_id'];
		else
			$test->testId = null;
			
		if(isset($record['test_type_id']))
			$test->testTypeId = $record['test_type_id'];
		else
			$test->testTypeId = null;
			
		if(isset($record['specimen_id']))
			$test->specimenId = $record['specimen_id'];
		else
			$test->specimenId = null;
		
		if(isset($record['result']))
			$test->result = $record['result'];
		else
			$test->result = null;
		
		if(isset($record['comments']))
			$test->comments = $record['comments'];
		else
			$test->comments = null;
			
		if(isset($record['user_id']))
			$test->userId = $record['user_id'];
		else
			$test->userId = null;
			
		if(isset($record['verified_by']))
			$test->verifiedBy = $record['verified_by'];
		else
			$test->verifiedBy = null;
			
		if(isset($record['date_verified']))
			$test->dateVerified = $record['date_verified'];
		else
			$test->dateVerified = null;
		
		if(isset($record['ts']))
			$test->timestamp = $record['ts'];
		else
			$test->timestamp = null;
		
		return $test;
	}
	
	public static function getTestBySpecimenID($sid)
	{
		# Returns a test result entry by test_id field
		if($sid == null || trim($sid) == "")
		{
			return null;
		}
		$query_string =
		"SELECT * FROM test WHERE specimen_id = $sid";
		//"AND result<>''";
		$record = query_associative_one($query_string);
		return Test::getObject($record);
	}
	
	public static function getAllTestsBySpecimenId($id)
    {
        $query = "SELECT * FROM test WHERE specimen_id='$id'";
        $results = query_associative_all($query, null);
        if ($results == null)
            return null;
        $ret = array();
        foreach ($results as $record) {
            $ret[] = Test::getObject($record);
        }
        return $ret;
    }
	
	public static function getById($test_id)
	{
		# Returns a test result entry by test_id field
		if($test_id == null || trim($test_id) == "")
		{
			return null;
		}
		global $con;
		$test_id = mysql_real_escape_string($test_id, $con);
		$query_string = "SELECT * FROM test WHERE `test_id` = $test_id";
		$record = query_associative_one($query_string);
		return Test::getObject($record);
	}
	
	public function isPending()
	{
		# Checks if test results are pending or not
		if($this->result == "")
			return true;
		return false;
	}
	
	public function isVerified()
	{
		# Checks if test results have been verified by a second technician
		if($this->verifiedBy == null || $this->verifiedBy == 0)
			return false;
		return true;
	}
	
	public function isReported()
	{
		# TODO:
		return false;
	}
	
	public function getEnteredBy()
	{
		# Returns username of the technician who entered results
		# Or, "Pending" if results are pending verification
		if($this->isPending())
			return LangUtil::$generalTerms['PENDING_RESULTS'];
		else
		{
			return get_username_by_id($this->userId);
		}
	}
	
	public function getVerifiedBy()
	{
		# Returns username of the technician who verified results
		# Or, "Not verified" if results are pending verification
		if($this->isVerified())
			return get_username_by_id($this->verifiedBy);
		return LangUtil::$generalTerms['PENDING_VER'];
	}
	
	public function getVerifierPosition()
	{
	# Returns username of the technician who verified results
	# Or, "Not verified" if results are pending verification
	if($this->isVerified())
		return get_user_position_by_id($this->verifiedBy);
	return "";
	}
	
	public function setVerifiedBy($verified_by)
	{
		# Sets verified by flag for given test
		global $con;
		$verified_by = mysql_real_escape_string($verified_by, $con);
		$query_string =
			"UPDATE test SET verified_by=$verified_by WHERE test_id=".$this->testId;
		query_blind($query_string);
	}
	
	public function addResult($hash_value)
	{
		# Enters results for this test
		# Adds results for a test entry
		$curent_ts = "";
		$current_ts = date("Y-m-d H:i:s");
		$result_field = $this->result.$hash_value;
		$query_string = 
			"UPDATE `test` SET result='$result_field', ".
			"comments='$this->comments', ".
			"user_id=$this->userId, ".
			"ts='$current_ts' ".
			"WHERE test_id=$this->testId ";
		query_blind($query_string);
		# If specimen ID was passed, update its status
		$specimen_id = $this->specimenId;
		if($specimen_id != "")
			update_specimen_status($specimen_id);
	}
	
	public function getResultWithoutHash()
	{
	    global $PATIENT_HASH_LENGTH;
		if(trim($this->result) == "")
			# Results not yet entered
			return "";
		$retval = substr($this->result, 0, -1*$PATIENT_HASH_LENGTH);
        if ($retval == '')
            $retval = substr($this->result, 0, -1);
        # nc44
        $testt = $retval;
        //$test2 = strstr($testt, $);
        $del_tag = "##";
        $start_tag = "[$]";
        $end_tag = "[/$]";
        $comma = ',';
        //$testtt = str_replace("[$]two[/$],", "", $testt);
        $del_count = substr_count($testt, $del_tag);
        //echo $ft_count;
        $k = 0;
        //echo "-".$del_count."-";
        while($k < $del_count)
        {
           $del_beg = strpos($testt, $del_tag);
            if($testt[$del_beg] == "[" && $testt[$del_beg + 1] == "$")
            {
                $del_end = strpos($testt, $end_tag, $del_beg);
                //$ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                $res_left = substr($testt, 0, $del_beg);
                $res_right = substr($testt, $del_end + 5);

            }
            else
            {
                $del_end = strpos($testt, $comma, $del_beg);
                //$ft_sub = substr($testt, $ft_beg + 2, $ft_end - $ft_beg - 3);
                $res_left = substr($testt, 0, $del_beg);
                $res_right = substr($testt, $del_end + 1);
            }
            //echo "<br>".$ft_left."--".$ft_right."<br>";
            $testt = $res_left.$res_right;
            //array_push($freetext_results, $ft_sub);
            $k++;
        }
        //echo $testt;
        $retval = $testt;
		return $retval;
	}
	
        public function getResultWithoutHash2()
	{
		global $PATIENT_HASH_LENGTH;
		if(trim($this->result) == "")
			# Results not yet entered
			return "";
		$retval = substr($this->result, 0, -1*$PATIENT_HASH_LENGTH);
		return $retval;
	}
        
        public function getHashInResult()
	{
		global $PATIENT_HASH_LENGTH;
		if(trim($this->result) == "")
			# Results not yet entered
			return "";
		$retval = substr($this->result, -1*$PATIENT_HASH_LENGTH);
                return $retval;
        }
	public function getMeasureList() {
		$testType = TestType::getById($this->testTypeId);
		$measure_list = $testType->getMeasures();
                $submeasure_list = array();
                $comb_measure_list = array();
               // print_r($measure_list);
                
                foreach($measure_list as $measure)
                {
                    
                    $submeasure_list = $measure->getSubmeasuresAsObj();
                    //echo "<br>".count($submeasure_list);
                    //print_r($submeasure_list);
                    $submeasure_count = count($submeasure_list);
                    
                    if($measure->checkIfSubmeasure() == 1)
                    {
                        continue;
                    }
                        
                    if($submeasure_count == 0)
                    {
                        array_push($comb_measure_list, $measure);
                    }
                    else
                    {
                        array_push($comb_measure_list, $measure);
                        foreach($submeasure_list as $submeasure)
                           array_push($comb_measure_list, $submeasure); 
                    }
                }
                $measure_list = $comb_measure_list;
		for($i = 0; $i < count($measure_list); $i++) {
			$curr_measure = $measure_list[$i];
                        if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                            
                        
			$retval .= "<br>".$decName."<br>";
		}
		return $retval;
	}	
	
	public function decodeResult($show_range=false,$add_units=true) {

		# Converts stored result value(s) for showing on front-end
		# Get measure, unit pairs for this test
		$test_type = TestType::getById($this->testTypeId);
		$measure_list = $test_type->getMeasures();
        # print_r($measure_list);
        $submeasure_list = array();
        $comb_measure_list = array();
        // print_r($measure_list);
        foreach($measure_list as $measure)
        {
            $submeasure_list = $measure->getSubmeasuresAsObj();
            //echo "<br>".count($submeasure_list);
            # print_r($submeasure_list);
            $submeasure_count = count($submeasure_list);

            if($measure->checkIfSubmeasure() == 1)
            {
                continue;
            }
                        
            if($submeasure_count == 0)
            {
                array_push($comb_measure_list, $measure);
            }
            else
            {
                array_push($comb_measure_list, $measure);
                foreach($submeasure_list as $submeasure)
                   array_push($comb_measure_list, $submeasure);
            }
        }
        $measure_list = $comb_measure_list;
		$result_csv = $this->getResultWithoutHash();
                //$result_csv = $this->getResultWithoutHash();
                //echo "<br>";
                //echo $result_csv;
                //echo "<br>";
                if(strpos($result_csv, "[$]") === false)
                {
                    $result_list = explode(",", $result_csv);
                }
                else
                {
                    //$testt = "one,[$]two[/$],[$]twotwo[/$],three";
                    $testt = $result_csv;
                    //$test2 = strstr($testt, $);
                    $start_tag = "[$]";
                    $end_tag = "[/$]";
                    //$testtt = str_replace("[$]two[/$],", "", $testt);
                    $freetext_results = array();
                    $ft_count = substr_count($testt, $start_tag);
                    //echo $ft_count;
                    $k = 0;
                    while($k < $ft_count)
                    {
                        $ft_beg = strpos($testt, $start_tag);
                        $ft_end = strpos($testt, $end_tag);
                        $ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                        $ft_left = substr($testt, 0, $ft_beg);
                        $ft_right = substr($testt, $ft_end + 5);
                        //echo "<br>".$ft_left."--".$ft_right."<br>";
                        $testt = $ft_left.$ft_right;
                        array_push($freetext_results, $ft_sub);
                        $k++;
                    }
                    //echo $freetext_results."<br>".$testt;
                    //$testtt = str_replace($subb, "", $testt, 1);
                    //echo "$testto<br>$subb<br>";
                    $result_csv = $testt;
                    if(strpos($testt, ",") == 0)
                            $result_csv = substr($testt, 1, strlen($testt)); 
                    $result_list = explode(",", $result_csv);
                    //echo "<br>";
                    //print_r($result_list);
                    //echo "<br>";
                }
                $retval = "";
                //NC3065
                //echo print_r($measure_list);
                //echo "<br>";
                //echo $result_csv;
                //echo "<br>";
                //echo print_r($result_list,true);
                //echo "Num->".count($measure_list);
		//-NC3065
                $j = 0;
                $i = 0;
                $c = 0;
                //for($i = 0; $i < count($measure_list); $i++) {
                while($c < count($measure_list)) {
			# Pretty print
			$curr_measure = $measure_list[$c];
			if($curr_measure->getRangeType() != Measure::$RANGE_FREETEXT)
                        {
                            if(isset($result_list[$i]))
                            {    
                                //echo "Num->".$i;
                                    # If matching result value exists (e.g. after a new measure was added to this test type)
                                    if(count($measure_list) == 1)
                                    {
                                            # Only one measure: Do not print measure name
                                            if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE) {
                                                    $result_string = "";
                                                    $value_list = explode("_", $result_list[$i]);
                                                    foreach($value_list as $value) {
                                                            if(trim($value) == "")
                                                                    continue;
                                                            $result_string .= $value."<br>";
                                                    }
                                                    $result_string = substr($result_string, 0, -4);
                                                    $retval .= "<br>".$result_string."&nbsp;";
                                            }
                                            else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
                                            {
                                                    if($result_list[$i] != $curr_measure->unit)
                                                            $retval .= "<br><b>".$result_list[$i]."</b> &nbsp;";
                                                    else
                                                            $retval .= "<br>".$result_list[$i]."&nbsp;";
                                            }
                                            else
                                            {
                                                    $retval .= "<br>".$result_list[$i]."&nbsp;";
                                            }
                                            if($add_units == true)
                                                $retval.=$curr_measure->unit."&nbsp";
                                    }
                                    else
                                    {
                                            # Print measure name with each result value
                                         if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                            $retval .= "<br>".$decName.":"."&nbsp;";
                                        
                                            if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE)
                                            {
                                                    $result_string = "";
                                                    $value_list = str_replace("_", ",", $result_list[$i]);
                                                    $retval .= "<b>".$value_list."</b>";
                                            }
                                            else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
                                            {
                                                    if($result_list[$i]!=$curr_measure->unit)
                                                            $retval .= "<b>".$result_list[$i]."</b>"."&nbsp;";
                                                    else
                                                            $retval .= $result_list[$i]."&nbsp;";
                                            }
                                            else
                                                    $retval .= "<b>".$result_list[$i]."</b>"."&nbsp;";
                                        if($add_units == true)
                                            $retval.=$curr_measure->unit."&nbsp";
                                    }


                                    if($show_range === true)
                                    {
                                            $retval .= $curr_measure->getRangeString();
                                    }
                                    if($i != count($measure_list) - 1)
                                    {
                                            $retval .= "<br>";
                                    }
                            }
                            else
                            {
                                    # Matching result value not found: Show "-"
                                    if(count($measure_list) == 1)
                                    {
                                            if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                            $retval .= $decName."&nbsp;";
                                    }
                                    $retval .= " - <br>";
                            }
                            $i++;
                        }
                        else
                        {
                            $ft_result = $freetext_results[$j];

                            if(count($measure_list) == 1)
                            {
                                $retval .= "<br>".$ft_result."&nbsp;";   
                            }
                            else
                            {
                                if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                $retval .= "<br>".$decName.":"."&nbsp;"."<b>".$ft_result."</b>"."&nbsp;";
                            }
                            if($show_range === true)
                                        {
                                                $retval .= $curr_measure->getRangeString();
                                        }
                                        if($i != count($measure_list) - 1)
                                        {
                                                $retval .= "<br>";
                                        }
                            $j++;
                            
                        }$c++;
		}//end
		//$retval = str_replace("_",",",$retval); # Replace all underscores with a comma
		return $retval;
	}
	
        public function decodeResultWithoutMeasures($show_range=false) {
            # Converts stored result value(s) for showing on front-end
		# Get measure, unit pairs for this test
		$test_type = TestType::getById($this->testTypeId);
		$measure_list = $test_type->getMeasures();
                //print_r($measure_list);
                $submeasure_list = array();
                $comb_measure_list = array();
               // print_r($measure_list);
                
                foreach($measure_list as $measure)
                {
                    
                    $submeasure_list = $measure->getSubmeasuresAsObj();
                    //echo "<br>".count($submeasure_list);
                    //print_r($submeasure_list);
                    $submeasure_count = count($submeasure_list);
                    
                    if($measure->checkIfSubmeasure() == 1)
                    {
                        continue;
                    }
                        
                    if($submeasure_count == 0)
                    {
                        array_push($comb_measure_list, $measure);
                    }
                    else
                    {
                        array_push($comb_measure_list, $measure);
                        foreach($submeasure_list as $submeasure)
                           array_push($comb_measure_list, $submeasure); 
                    }
                }
                $measure_list = $comb_measure_list;
		$result_csv = $this->getResultWithoutHash();
                //$result_csv = $this->getResultWithoutHash();
                //echo "<br>";
                //echo $result_csv;
                //echo "<br>";
                if(strpos($result_csv, "[$]") === false)
                {
                    $result_list = explode(",", $result_csv);
                }
                else
                {
                    //$testt = "one,[$]two[/$],[$]twotwo[/$],three";
                    $testt = $result_csv;
                    //$test2 = strstr($testt, $);
                    $start_tag = "[$]";
                    $end_tag = "[/$]";
                    //$testtt = str_replace("[$]two[/$],", "", $testt);
                    $freetext_results = array();
                    $ft_count = substr_count($testt, $start_tag);
                    //echo $ft_count;
                    $k = 0;
                    while($k < $ft_count)
                    {
                        $ft_beg = strpos($testt, $start_tag);
                        $ft_end = strpos($testt, $end_tag);
                        $ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                        $ft_left = substr($testt, 0, $ft_beg);
                        $ft_right = substr($testt, $ft_end + 5);
                        //echo "<br>".$ft_left."--".$ft_right."<br>";
                        $testt = $ft_left.$ft_right;
                        array_push($freetext_results, $ft_sub);
                        $k++;
                    }
                    //echo $freetext_results."<br>".$testt;
                    //$testtt = str_replace($subb, "", $testt, 1);
                    //echo "$testto<br>$subb<br>";
                    $result_csv = $testt;
                    if(strpos($testt, ",") == 0)
                            $result_csv = substr($testt, 1, strlen($testt)); 
                    $result_list = explode(",", $result_csv);
                    //echo "<br>";
                    //print_r($result_list);
                    //echo "<br>";
                }
                $retval = "";
                //NC3065
                //echo print_r($measure_list);
                //echo "<br>";
                //echo $result_csv;
                //echo "<br>";
                //echo print_r($result_list,true);
                //echo "Num->".count($measure_list);
		//-NC3065
                $j = 0;
                $i = 0;
                $c = 0;
                //for($i = 0; $i < count($measure_list); $i++) {
                while($c < count($measure_list)) {
			# Pretty print
			$curr_measure = $measure_list[$c];
			if($curr_measure->getRangeType() != Measure::$RANGE_FREETEXT)
                        {
                            if(isset($result_list[$i]))
                            {    
                                //echo "Num->".$i;
                                    # If matching result value exists (e.g. after a new measure was added to this test type)
                                    if(count($measure_list) == 1)
                                    {
                                            # Only one measure: Do not print measure name
                                            if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE) {
                                                    $result_string = "";
                                                    $value_list = explode("_", $result_list[$i]);
                                                    foreach($value_list as $value) {
                                                            if(trim($value) == "")
                                                                    continue;
                                                            $result_string .= $value."<br>";
                                                    }
                                                    $result_string = substr($result_string, 0, -4);
                                                    $retval .= "<br>".$result_string."&nbsp;";
                                            }
                                            else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
                                            {
                                                    if($result_list[$i] != $curr_measure->unit)
                                                            $retval .= "<br><b>".$result_list[$i]."</b> &nbsp;";
                                                    else
                                                            $retval .= "<br>".$result_list[$i]."&nbsp;";
                                            }
                                            else
                                            {
                                                    $retval .= "<br>".$result_list[$i]."&nbsp;";
                                            }
                                    }
                                    else
                                    {
                                            # Print measure name with each result value
                                         
                                        
                                            if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE)
                                            {
                                                    $result_string = "";
                                                    $value_list = str_replace("_", ",", $result_list[$i]);
                                                    $retval .= "<br><b>".$value_list."</b>";
                                            }
                                            else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
                                            {
                                                    if($result_list[$i]!=$curr_measure->unit)
                                                            $retval .= "<br><b>".$result_list[$i]."</b>"."&nbsp;";
                                                    else
                                                            $retval .= $result_list[$i]."&nbsp;";
                                            }
                                            else
                                                    $retval .= "<br><b>".$result_list[$i]."</b>"."&nbsp;";
                                    }

                                    if($show_range === true)
                                    {
                                            $retval .= $curr_measure->getRangeString();
                                    }
                                    if($i != count($measure_list) - 1)
                                    {
                                            $retval .= "<br>";
                                    }
                            }
                            else
                            {
                                    # Matching result value not found: Show "-"
                                    if(count($measure_list) == 1)
                                    {
                                            
                                    }
                                    $retval .= " - <br>";
                            }
                            $i++;
                        }
                        else
                        {
                            $ft_result = $freetext_results[$j];

                            if(count($measure_list) == 1)
                            {
                                $retval .= "<br>".$ft_result."&nbsp;";   
                            }
                            else
                            {
                                 $retval .= "<br>".$ft_result."&nbsp;"; 
                            }
                            if($show_range === true)
                                        {
                                                $retval .= $curr_measure->getRangeString();
                                        }
                                        if($i != count($measure_list) - 1)
                                        {
                                                $retval .= "<br>";
                                        }
                            $j++;
                            
                        }$c++;
		}//end
		//$retval = str_replace("_",",",$retval); # Replace all underscores with a comma
		return $retval;
        }
        
        /*
	public function decodeResultWithoutMeasures($show_range=false) {
		# Converts stored result value(s) for showing on front-end
		$test_type = TestType::getById($this->testTypeId);
		$measure_list = $test_type->getMeasures();
		$result_csv = $this->getResultWithoutHash();
		$result_list = explode(",", $result_csv);
		$retval = "";
		for($i = 0; $i < count($measure_list); $i++) {
			# Pretty print
			$curr_measure = $measure_list[$i];
			if(isset($result_list[$i]))
			{    
				# If matching result value exists (e.g. after a new measure was added to this test type)
				if(count($measure_list) == 1)
				{
					# Only one measure: Do not print measure name
					//$retval .= $curr_measure->name."&nbsp;";
					if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE) {
						$result_string = "";
						$value_list = explode("_", $result_list[$i]);
						foreach($value_list as $value) {
							if(trim($value) == "")
								continue;
							$result_string .= $value."<br>";
						}
						$result_string = substr($result_string, 0, -4);
						$retval .= "<br>".$result_string."&nbsp;";
					}
					else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
					{
						if($result_list[$i] != $curr_measure->unit)
							$retval .= "<br><b>".$result_list[$i]."</b> &nbsp;";
						else
							$retval .= "<br>".$result_list[$i]."&nbsp;";
					}
					else
					{
						$retval .= "<br>".$result_list[$i]."&nbsp;";
					}
				}
				else
				{
					# Print measure name with each result value
					// $retval .= $curr_measure->name."&nbsp;";
					if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE)
					{
						$result_string = "";
						$value_list = str_replace("_", ",", $result_list[$i]);
						//$retval .= ":<br>".$value_list."<br>";
						$retval .= "<br>".$value_list."<br>";
					}
					else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
					{
						if($result_list[$i]!=$curr_measure->unit) {
							//$retval .= "<b>".$result_list[$i]."</b> &nbsp;";
							$retval .= "<br><b>".$result_list[$i]."</b> &nbsp;<br>";
						}
						else {
							//$retval .= $result_list[$i]."&nbsp;";
							$retval .= "<br>".$result_list[$i]."&nbsp;<br>";
						}
					}
					else
					{
						//$retval .= $result_list[$i]."&nbsp;";
						$retval .= "<br>".$result_list[$i]."&nbsp;<br>";
					}
				}
				if($show_range === true)
				{
					$retval .= $curr_measure->getRangeString();
				}
				if($i != count($measure_list) - 1)
				{
					//$retval .= "<br>";
				}
			}
			else
			{
				# Matching result value not found: Show "-"
				if(count($measure_list) == 1)
				{
					$retval .= $curr_measure->name."&nbsp;";
				}
				$retval .= " - <br>";
			}
		}
		$retval = str_replace("_",",",$retval); # Replace all underscores with a comma
		return $retval;
	}
	*/
        
	public function getComments()
	{
		if(trim($this->comments) == "" || $this->comments == null)
			return "-";
		else
			return $this->comments;
	}
	
	public static function getByAddDate($date, $test_type_id)
	{
		# Returns all test records added on that day
		global $con;
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		$date = mysql_real_escape_string($date, $con);
		$query_string =
			"SELECT * FROM test ".
			"WHERE test_type_id=$test_type_id ".
			"AND ts LIKE '%$date%' ";
			//"AND result<>''";
		$retval = array();
		$resultset = query_associative_all($query_string, $row_count);
		foreach($resultset as $record)
			$retval[] = Test::getObject($record);
		return $retval;
	}
        
	
	public function verifyAndUpdate($hash_value)
	{
		# Updates changes to DB after verified/corrected result values are submitted
		$specimen_id = $this->specimenId;
		$test_type_id = $this->testTypeId;
		$query_string =
			"SELECT * FROM test ".
			"WHERE specimen_id=$specimen_id ".
			"AND test_type_id=$test_type_id LIMIT 1";
		$record = query_associative_one($query_string);
		$existing_entry = Test::getObject($record);
		$test_id = $existing_entry->testId;
		$new_result_value = $this->result.$hash_value;
		$query_verify = "";
		if	(
				$existing_entry->result == $new_result_value && 
				$existing_entry->comments == $this->comments
			)
		{
			# No changes or corrections after verification
			$query_verify = 
				"UPDATE test ".
				"SET verified_by=$this->verifiedBy, ".
				"date_verified='$this->dateVerified' ".
				"WHERE test_id=$test_id";
		}
		else
		{	
			# Update with corrections and mark as verified
			$query_verify =
				"UPDATE test ".
				"SET result='$new_result_value', ".
				"comments='$this->comments', ".
				"verified_by=$this->verifiedBy, ".
				"date_verified='$this->dateVerified' ".
				"WHERE test_id=$test_id";
		}
		query_blind($query_verify);
	}
	
	public function getDateVerified()
	{
		if($this->dateVerified == null || $this->dateVerified == "")
			return "-";
		else
		{
			$date_parts = explode(" ", $this->dateVerified);
			return DateLib::mysqlToString($date_parts[0])." ".$date_parts[1];
		}
	}
	
	public function getStatus()
	{
		if($this->isPending())
			return LangUtil::$generalTerms['PENDING_RESULTS'];
		else
			return LangUtil::$generalTerms['DONE'];
	}

	public function getTestRegDate()
	{
		$query_string =
		"SELECT date_collected FROM specimen ".
		"WHERE specimen_id = ( ".
		"SELECT specimen_id FROM test WHERE test_id = $this->testId".
					")";
		//"AND result<>''";
		$resultset = query_associative_one($query_string, $row_count);
		$retval = $resultset['date_collected'];
		return $retval;
	}
	
	/* public function getTestBySpecimenIdAndLabSection()
	{
		$query_string =
		"SELECT * FROM test WHERE specimen_id = $this->testId".
		")";
		//"AND result<>''";
		$resultset = query_associative_one($query_string, $row_count);
		$retval = $resultset['date_collected'];
		return $retval;
	} */
	
	public static function convertArrayOfIdsToObjects($testIds)
	{
		$test_objs = array();
		foreach ($testIds as $testId)
		{
			$test_objs[] = Test::getById($testId);
		}
		return $test_objs;
	}
	
	// Returns the name associated with the test type this is an instance of.
	public function getTestName()
	{
		$id = $this->testTypeId;
		
		return TestType::getNameById($id);
	}
}

class CustomField
{
	public $id;
	public $fieldName;
	public $fieldOptions;
	public $fieldTypeId;
	public $flag;
	public static $FIELD_FREETEXT = 1;
	public static $FIELD_DATE = 2;
	public static $FIELD_OPTIONS = 3;
	public static $FIELD_NUMERIC = 4;
	public static $FIELD_MULTISELECT = 5;
	
	public static function getObject($record)
	{
		# Converts a custom field record in DB into a CustomField object
		if($record == null)
			return null;
		$custom_field = new CustomField();
		
		if(isset($record['id']))
			$custom_field->id = $record['id'];
		else
			$custom_field->id = null;
			
		if(isset($record['field_name']))
		{
			$name=$record['field_name'];
			$name_string=explode("^^" , $name);
			$custom_field->fieldName=$name_string[0];
			if($name_string[1]!=NULL|| $name_string!="")
			$custom_field->flag=$name_string[1];
			else
			$custom_field->flag=0;
		}
			else
			$custom_field->fieldName = null;
			
		if(isset($record['field_options']))
			$custom_field->fieldOptions = $record['field_options'];
		else
			$custom_field->fieldOptions = null;
			
		if(isset($record['field_type_id']))
			$custom_field->fieldTypeId = $record['field_type_id'];
		else
			$custom_field->fieldTypeId = null;
			
		return $custom_field;
	}
	
	public static function addNew($new_entry, $lab_config_id, $tabletype)
	{
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		# Adds a new custom field entry
		# $tabletype = 1 for specimen custom field
		# $tabletype = 2 for patient custom field
		# $tabletype = 3 for labtitle custom field
		$table_name = "";
		if($tabletype == 1)
			$table_name = "specimen_custom_field";
		else if($tabletype == 2)
			$table_name = "patient_custom_field";
		else if($tabletype == 3)
			$table_name = "labtitle_custom_field";
		else
			return;
		$query_string = 
			"INSERT INTO $table_name (field_name, field_options, field_type_id) ".
			"VALUES ('$new_entry->fieldName', '$new_entry->fieldOptions', $new_entry->fieldTypeId)";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function setId($field_id, $lab_config_id, $tabletype)
	{
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$field_id = mysql_real_escape_string($field_id, $con);
		if($field_id<100)
		$new_id=$field_id+100;
		else
		$new_id=$field_id-100;
		$table_name = "";
		if($tabletype == 1)
			$table_name = "specimen_custom_field";
		else if($tabletype == 2)
			$table_name = "patient_custom_field";
		else if($tabletype == 3)
			$table_name = "labtitle_custom_field";
		else
			return null;
		$query_string =
			" UPDATE $table_name ".
			" SET id=$new_id".
			" WHERE id=$field_id";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
	
	}
	public static function getById($field_id, $lab_config_id, $tabletype)
	{
		# Returns a custom field entry
		# $tabletype = 1 for specimen custom field
		# $tabletype = 2 for patient custom field
		# $tabletype = 3 for labtitle custom field
		$table_name = "";
		if($tabletype == 1)
			$table_name = "specimen_custom_field";
		else if($tabletype == 2)
			$table_name = "patient_custom_field";
		else if($tabletype == 3)
			$table_name = "labtitle_custom_field";
		else
			return null;
		$query_string =
			"SELECT * FROM $table_name ".
			"WHERE id=$field_id";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		return CustomField::getObject($record);
	}
	
	public static function deleteById($updated_entry, $lab_config_id, $tabletype)
	{
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		if($updated_entry == null)
			return;
		$table_name = "";
		if($tabletype == 1)
			$table_name = "specimen_custom_field";
		else if($tabletype == 2)
			$table_name = "patient_custom_field";
		else if($tabletype == 3)
			$table_name = "labtitle_custom_field";
		else 
			return;
			
		$query_string = 
			"DELETE FROM $table_name ".
			"WHERE id=$updated_entry->id ";
		
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
			
	
	}
	public static function updateById($updated_entry, $lab_config_id, $tabletype ,$offset=0)
	{
		# Updates a custom field entry
		# $tabletype = 1 for specimen custom field
		# $tabletype = 2 for patient custom field
		# $tabletype = 3 for labtitle custom field
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		if($updated_entry == null)
			return;
		$table_name = "";
		if($tabletype == 1)
			$table_name = "specimen_custom_field";
		else if($tabletype == 2)
			$table_name = "patient_custom_field";
		else if($tabletype == 3)
			$table_name = "labtitle_custom_field";
		else 
			return;
			if($offset==$updated_entry->id)
			$new_id=intval($updated_entry->id)*13;
			else if($offset==-1)
			{
			$new_id=$updated_entry->id;
			}
			else if($offset==-3)
			$new_id=intval($updated_entry->id)/13;
			else
			$new_id=$updated_entry->id;
			
		$query_string = 
			"UPDATE $table_name ".
			"SET field_name='$updated_entry->fieldName', ".
			"id='$new_id', ".
			"field_options='$updated_entry->fieldOptions', ".
			"field_type_id=$updated_entry->fieldTypeId ".
			"WHERE id=$updated_entry->id";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public function getFieldTypeName()
	{
		# Returns a string describing field type of this custom field
		switch($this->fieldTypeId)
		{
			case CustomField::$FIELD_FREETEXT:
				return LangUtil::$generalTerms['FREETEXT'];
			case CustomField::$FIELD_DATE:
				return LangUtil::$generalTerms['DATE'];
			case CustomField::$FIELD_OPTIONS:
				return LangUtil::$generalTerms['DROPDOWN'];
			case CustomField::$FIELD_NUMERIC:
				return LangUtil::$generalTerms['NUMERIC_FIELD'];
			case CustomField::$FIELD_MULTISELECT:
				return LangUtil::$generalTerms['MULTISELECT'];
		}
	}
	
	public function getFieldOptions()
	{
		# Returns list of option values for this custom field
		$retval = array();
		if($this->fieldTypeId != CustomField::$FIELD_OPTIONS && $this->fieldTypeId != CustomField::$FIELD_MULTISELECT)
			return $retval;
		else
		{
			$options_csv = $this->fieldOptions;
			$retval = explode("/", $options_csv);
			return $retval;
		}
	}
	
	public function getFieldRange()
	{
		# Returns range bound values for this custom field
		$retval = array();
		if($this->fieldTypeId != CustomField::$FIELD_NUMERIC)
			return $retval;
		else
		{
			$options_csv = $this->fieldOptions;
			$retval = explode(":", $options_csv);
			return $retval;
		}
	}
	
	
}

class SpecimenCustomData
{
	public $fieldId;
	public $specimenId;
	public $fieldValue;
	
	public static function getObject($record)
	{
		# Converts a specimen_custom_data record in DB into a SpecimenCustomData object
		if($record == null)
			return null;
		$custom_data = new SpecimenCustomData();
		
		if(isset($record['field_id']))
			$custom_data->fieldId = $record['field_id'];
		else
			$custom_data->fieldId = null;
			
		if(isset($record['specimen_id']))
			$custom_data->specimenId = $record['specimen_id'];
		else
			$custom_data->specimenId = null;
			
		if(isset($record['field_value']))
			$custom_data->fieldValue = $record['field_value'];
		else
			$custom_data->fieldValue = null;
		
		return $custom_data;
	}
	
	
	public function getFieldValueString($lab_config_id, $tabletype)
	{
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$field_type = CustomField::getById($this->fieldId, $lab_config_id, $tabletype);
		$field_value = $this->fieldValue;
		if(trim($field_value) == "" || $field_value == null)
		{
			$field_value = "-";
			return $field_value;
		}
		if($field_type->fieldTypeId == CustomField::$FIELD_NUMERIC)
		{
			$range = $field_type->getFieldRange();
			return $field_value." $range[2]";
		}
		else if($field_type->fieldTypeId == CustomField::$FIELD_DATE)
		{
			return DateLib::mysqlToString($field_value);
		}
		else
		{
			return $field_value;
		}
	}
}

class SpecimenTest
{
    public $test_type_id;
    public $specimen_type_id;

    public static function getObject($record)
    {
        # Converts a record from the table specimen_test in DB into a SpecimenTest object
        if ($record == null)
            return null;

        $obj = new SpecimenTest();
        $obj->test_type_id = $record['test_type_id'];
        $obj->specimen_type_id = $record['specimen_type_id'];

        return $obj;
    }

    public static function getSpecimenIdsByTestTypeId($id)
    {
        $query = "SELECT specimen_type_id FROM specimen_test ".
            "WHERE test_type_id=". $id;
        $result = query_associative_all($query, null);

        if ($result == null)
            return null;

        $ret = array();
        foreach ($result as $key=>$value)
            $ret[] = $value;

        return $ret;
    }
}

class PatientCustomData
{
	public $fieldId;
	public $patientId;
	public $fieldValue;
	
	public static function getObject($record)
	{
		# Converts a patient_custom_data record in DB into a PatientCustomData object
		if($record == null)
			return null;
		$custom_data = new PatientCustomData();
		
		if(isset($record['field_id']))
			$custom_data->fieldId = $record['field_id'];
		else
			$custom_data->fieldId = null;
			
		if(isset($record['patient_id']))
			$custom_data->patientId = $record['patient_id'];
		else
			$custom_data->patientId = null;
			
		if(isset($record['field_value']))
			$custom_data->fieldValue = $record['field_value'];
		else
			$custom_data->fieldValue = null;
		
		return $custom_data;
	}
	
	public function getFieldValueString($lab_config_id, $tabletype)
	{
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$field_type = CustomField::getById($this->fieldId, $lab_config_id, $tabletype);
		$field_value = $this->fieldValue;
		if(trim($field_value) == "" || $field_value == null)
		{
			$field_value = "-";
			return $field_value;
		}
		if($field_type->fieldTypeId == CustomField::$FIELD_NUMERIC)
		{
			$range = $field_type->getFieldRange();
			return $field_value." $range[2]";
		}
		else if($field_type->fieldTypeId == CustomField::$FIELD_DATE)
		{
			return DateLib::mysqlToString($field_value);
		}
		else
		{
			return $field_value;
		}
	}
}

class Report
{
	public $id;
	public $name;
	public $groupByGender;
	public $groupByAge;
	public $ageSlots;
	
	public static function getObject($record)
	{
		# Converts a `report` table record to Report object
		if($record == null)
			return null;
		$report = new Report();
		if(isset($record['report_id']))
			$report->id = $record['report_id'];
		else
			$report->id = null;
		if(isset($record['name']))
			$report->name = $record['name'];
		else
			$report->name = null;
		if(isset($record['group_by_gender']))
			$report->groupByGender = $record['group_by_gender'];
		else
			$report->groupByGender = null;
		if(isset($record['group_by_age']))
			$report->groupByAge = $record['group_by_age'];
		else
			$report->groupByAge = null;
		if(isset($record['age_slots']))
		{
			# Build age slots array
			# Store in DB in the following format: 'lower1:upper1,lower2:upper2,lowern:uppern'
			$report->ageSlots = array();
			$age_slot_list = explode(",", $record['age_slots']);
			foreach($age_slot_list as $age_slot)
			{
				$age_slot_range = explode(":", $age_slot);
				$report->ageSlots[] = $age_slot_range;
			}
		}
		else
			$report->ageSlots = null;
		return $report;
	}
	
	public function addToDb()
	{
		# Adds a new report configuration to DB
		$saved_db = DbUtil::switchToGlobal();
		$query_string = 
			"INSERT INTO report (name, group_by_gender, group_by_age, age_slots) ".
			"VALUES ('$this->name', $this->groupByGender, $this->groupByAge, '$this->ageSlots')";
		query_insert_one($query_string);
		$new_report_id = get_last_insert_id();
		DbUtil::switchRestore($saved_db);
		return $new_report_id;
	}
	
	public static function getById($report_id)
	{
		global $con;
		$report_id = mysql_real_escape_string($report_id, $con);
		# Fetches a report record from table
		$saved_db = DbUtil::switchToGlobal();
		$query_string = "SELECT * FROM report WHERE report_id=$report_id LIMIT 1";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		return Report::getObject($record);
	}
	
	public static function getAllFromDb()
	{
		# Returns all report types stored in DB
		$saved_db = DbUtil::switchToGlobal();
		$query_string = "SELECT * FROM report";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
		{
			$retval[] = Report::getObject($record);
		}
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
}

class DiseaseReport
{
	public $labConfigId;
	public $testTypeId;
	public $measureId;
	public $groupByGender;
	public $groupByAge;
	public $ageGroups;
	public $measureGroups;
	
	public static function getObject($record)
	{
		if($record == null)
			return null;
		$retval = new DiseaseReport();
		$retval->labConfigId = $record['lab_config_id'];
		$retval->testTypeId = $record['test_type_id'];
		$retval->measureId = $record['measure_id'];
		$retval->groupByGender = $record['group_by_gender'];
		$retval->groupByAge = $record['group_by_age'];
		if(isset($record['age_groups']))
			$retval->ageGroups = $record['age_groups'];
		if(isset($record['measure_groups']))
			$retval->measureGroups = $record['measure_groups'];
		return $retval;
	}
	
	public function addToDb()
	{
		$disease_report = $this;
		//$saved_db = DbUtil::switchToGlobal();
		# Remove existing entry
		$query_string =
			"DELETE FROM report_disease ".
			"WHERE lab_config_id=$this->labConfigId ".
			"AND test_type_id=$this->testTypeId ".
			"AND measure_id=$this->measureId";
		query_blind($query_string);
		# Add updated entry
		$query_string = 
			"INSERT INTO report_disease( ".
				"lab_config_id, ".
				"test_type_id, ".
				"measure_id, ".
				"group_by_gender, ".
				"group_by_age, ".
				"age_groups, ".
				"measure_groups ".
			") ".
			"VALUES ( ".
				"$disease_report->labConfigId, ".
				"$disease_report->testTypeId, ".
				"$disease_report->measureId, ".
				"$disease_report->groupByGender, ".
				"$disease_report->groupByAge, ".
				"'$disease_report->ageGroups', ".
				"'$disease_report->measureGroups' ".
			")";
		query_insert_one($query_string);
		//DbUtil::switchRestore($saved_db);
	}
	
	public static function getByKeys($lab_config_id, $test_type_id, $measure_id)
	{
		global $con;
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		$measure_id = mysql_real_escape_string($measure_id, $con);
		# Fetches a record by compound key
		$query_string =
			"SELECT * FROM report_disease ".
			"WHERE lab_config_id=$lab_config_id ".
			"AND test_type_id=$test_type_id ".
			"AND measure_id=$measure_id LIMIT 1";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$record = query_associative_one($query_string);
		$retval = DiseaseReport::getObject($record);
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public function getAgeGroupAsList()
	{
		# Returns the age_group field as a PHP list
		$age_parts = explode(",", $this->ageGroups);
		$retval = array();
		foreach($age_parts as $age_part)
		{
			if(trim($age_part) == "")
				continue;
			$age_bounds = explode(":", $age_part);
			$retval[] = $age_bounds;
		}
		return $retval;
	}
	
	public function getMeasureGroupAsList()
	{
		# Returns the measure_group field as a PHP list
		$measure_parts = explode(",", $this->measureGroups);
		$retval = array();
		foreach($measure_parts as $measure_part)
		{
			if(trim($measure_part) == "")
				continue;
			$measure_bounds = explode(":", $measure_part);
			$retval[] = $measure_bounds;
		}
		return $retval;
	}
}

class CustomWorksheet
{
	public $id;
	public $name;
	
	public $headerText;
	public $footerText;
	public $titleText;
	public $margins;
	
	public $idFields;
	public static $OFFSET_PID = 0;
	public static $OFFSET_DNUM = 1;
	public static $OFFSET_ADDLID = 2;
	
	public $patientFields;
	public $specimenFields;
	public $testFields;
	public $patientCustomFields;
	public $specimenCustomFields;
	public $userFields;
	
	public $testTypes;
	public $columnWidths;
	public $landscape;
	
	public static $DEFAULT_WIDTH = 10; # in %age
	public static $DEFAULT_MARGINS = array(2, 2, 2, 2);
	
	public static function getObject($record)
	{
		if($record == null)
			return null;
		
		$worksheet = new CustomWorksheet();
		
		if(isset($record['id']))
			$worksheet->id = $record['id'];
		else
			$worksheet->id = null;
		if(isset($record['name']))
			$worksheet->name = $record['name'];
		else
			$worksheet->name = "";
		if(isset($record['header']))
			$worksheet->headerText = $record['header'];
		else
			$worksheet->headerText = "";
		if(isset($record['footer']))
			$worksheet->footerText = $record['footer'];
		else
			$worksheet->footerText = "";
		if(isset($record['title']))
			$worksheet->titleText = $record['title'];
		else
			$worksheet->titleText = "";
			
		$worksheet->landscape = false;
		if(isset($record['landscape']) && $record['landscape'] == 1)
			$worksheet->landscape = true;
		
		$margins_csv = $record['margins'];
		$worksheet->margins = explode(",", $margins_csv);
		
		$id_fields_csv = $record['id_fields'];
		if($id_fields_csv == null || trim($id_fields_csv) == "")
		{
			$id_fields_csv = "0,0,0";
		}
		$worksheet->idFields = explode(",", $id_fields_csv);
		
		$patient_custom_csv = $record['p_custom'];
		$worksheet->patientCustomFields = explode(",", $patient_custom_csv);
		
		$specimen_custom_csv = $record['s_custom'];
		$worksheet->specimenCustomFields = explode(",", $specimen_custom_csv);
	
		$query_string =
			"SELECT test_type_id, measure_id, width FROM worksheet_custom_test WHERE worksheet_id=$worksheet->id ORDER BY test_type_id";
		$resultset = query_associative_all($query_string, $row_count);
		# Populate testTypes list
		$worksheet->testTypes = array();
		foreach($resultset as $record)
		{
			if(in_array($record['test_type_id'], $worksheet->testTypes) === false)
			{
				$worksheet->testTypes[] = $record['test_type_id'];
			}
		}
		# Populate columnWidths list
		$worksheet->columnWidths = array();
		foreach($resultset as $record)
		{
			$test_type_id = intval($record['test_type_id']);
			$measure_id = intval($record['measure_id']);
			$width = intval($record['width']);
			if(array_key_exists($test_type_id, $worksheet->columnWidths) === false)
				$worksheet->columnWidths[$test_type_id] = array();
			$worksheet->columnWidths[$test_type_id][$measure_id] = $width;
		}
		
		# Populate list of user-defined fields
		$query_string = 
			"SELECT name,width,field_id FROM worksheet_custom_userfield WHERE worksheet_id=$worksheet->id ORDER BY name";
		$resultset = query_associative_all($query_string, $row_count);
		$worksheet->userFields = array();
		foreach($resultset as $record)
		{
			$field_id = $record['field_id'];
			$field_name = trim($record['name']);
			$field_width = $record['width'];
			$field_entry = array($field_id, $field_name, $field_width);
			$worksheet->userFields[] = $field_entry;
		}
		
		# TODO:
		# Populate patient main field maps
		# Populate specimen main field maps
		# Populate test main field maps
		
		return $worksheet;
	}
	
	public static function getById($worksheet_id, $lab_config)
	{
		global $con;
		$worksheet_id = mysql_real_escape_string($worksheet_id, $con);
		if($worksheet_id == null || $lab_config == null)
			return null;
		$saved_db = DbUtil::switchToLabConfig($lab_config->id);
		$query_string = 
			"SELECT * FROM worksheet_custom WHERE id=$worksheet_id";
		$record = query_associative_one($query_string);
		$retval = CustomWorksheet::getObject($record);
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public static function addToDb($worksheet, $lab_config)
	{
		if($worksheet == null || $lab_config == null)
		{
			return;
		}
		$saved_db = DbUtil::switchToLabConfig($lab_config->id);
		$margins_csv = implode(",", $worksheet->margins);
		$id_fields_csv = implode(",", $worksheet->idFields);
		$query_string = 
			"INSERT INTO worksheet_custom (name, header, footer, title, margins, id_fields, p_fields, s_fields, t_fields, p_custom, s_custom) ".
			"VALUES ('$worksheet->name', '$worksheet->headerText', '$worksheet->footerText', '$worksheet->titleText', '$margins_csv', '$id_fields_csv', '', '', '', '', '')";
		query_insert_one($query_string);
		$worksheet_id = get_last_insert_id();
		foreach($worksheet->columnWidths as $key=>$value)
		{
			$test_type_id = $key;
			$width_list = $value;
			foreach($width_list as $key2=>$value2)
			{
				$measure_id = $key2;
				$width = $value2;
				$query_string = 
					"INSERT INTO worksheet_custom_test (worksheet_id, test_type_id, measure_id, width) ".
					"VALUES ($worksheet_id, $test_type_id, $measure_id, '$width')";
				query_insert_one($query_string);				
			}
		}
		foreach($worksheet->userFields as $field_entry)
		{
			$field_name = $field_entry[1];
			$field_width = $field_entry[2];
			$query_string = 
				"INSERT INTO worksheet_custom_userfield (worksheet_id, name, width) ".
				"VALUES ($worksheet_id, '$field_name', $field_width) ";
			query_insert_one($query_string);
		}
		$retval = $worksheet_id;
		DbUtil::switchRestore($saved_db);
		return $worksheet_id;
	}
	
	public static function updateToDb($worksheet, $lab_config)
	{
		if($worksheet == null || $lab_config == null)
		{
			return;
		}
		$saved_db = DbUtil::switchToLabConfig($lab_config->id);
		$margins_csv = implode(",", $worksheet->margins);
		$id_fields_csv = implode(",", $worksheet->idFields);
		$query_string = 
			"UPDATE worksheet_custom SET ".
			"name='$worksheet->name', ".
			"header='$worksheet->headerText', ".
			"footer='$worksheet->footerText', ".
			"title='$worksheet->titleText', ".
			"margins='$margins_csv', ".
			"id_fields='$id_fields_csv' ".
			"WHERE id=$worksheet->id";
		query_insert_one($query_string);
		# Clear all existing width entries
		$query_clear = "DELETE FROM worksheet_custom_test WHERE worksheet_id=$worksheet->id";
		query_blind($query_clear);
		# Add updated set of entries
		foreach($worksheet->columnWidths as $key=>$value)
		{
			$test_type_id = $key;
			$width_list = $value;
			foreach($width_list as $key2=>$value2)
			{
				$measure_id = $key2;
				$width = $value2;
				$query_string = 
					"INSERT INTO worksheet_custom_test (worksheet_id, test_type_id, measure_id, width) ".
					"VALUES ($worksheet->id, $test_type_id, $measure_id, '$width')";
				query_insert_one($query_string);
			}
		}
		foreach($worksheet->userFields as $field_entry)
		{
			$field_id = $field_entry[0];
			$field_name = $field_entry[1];
			$field_width = $field_entry[2];
			if($field_id == 0)
			{
				# New user field
				$query_string = 
					"INSERT INTO worksheet_custom_userfield (worksheet_id, name, width) ".
					"VALUES ($worksheet->id, '$field_name', $field_width) ";
				query_insert_one($query_string);
			}
			else
			{
				# Existing user field to update
				$query_string = 
					"UPDATE worksheet_custom_userfield ".
					"SET name='$field_name', width=$field_width ".
					"WHERE field_id=$field_id";
				query_update($query_string);
			}
		}
		DbUtil::switchRestore($saved_db);
	}
}

class ReferenceRange
{
	public $id;
	public $measureId;
	public $ageMin;
	public $ageMax;
	public $sex;
	public $rangeLower;
	public $rangeUpper;
	
	public static function getObject($record)
	{
		if($record == null)
			return null;
		$reference_range = new ReferenceRange();
		if(isset($record['id']))
			$reference_range->id = $record['id'];
		else
			$reference_range->id = null;
		if(isset($record['measure_id']))
			$reference_range->measureId = $record['measure_id'];
		else
			$reference_range->measureId = null;
		if(isset($record['age_min']))
			$reference_range->ageMin = intval($record['age_min']);
		else
			$reference_range->ageMin = null;
		if(isset($record['age_max']))
			$reference_range->ageMax = intval($record['age_max']);
		else
			$reference_range->ageMax = null;
		if(isset($record['sex']))
			$reference_range->sex = $record['sex'];
		else
			$reference_range->sex = null;
		if(isset($record['range_lower']))
			//$reference_range->rangeLower = intval($record['range_lower']);
		$reference_range->rangeLower = $record['range_lower'];
		else
			$reference_range->rangeLower = null;
		if(isset($record['range_upper']))
			$reference_range->rangeUpper = $record['range_upper'];
			//$reference_range->rangeUpper = intval($record['range_upper']);
		else
			$reference_range->rangeUpper = null;
		return $reference_range;
	}
	
	public function addToDb($lab_config_id)
	{
		# Adds this entry to database
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string = 
			"INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) ".
			"VALUES ($this->measureId, '$this->ageMin', '$this->ageMax', '$this->sex', '$this->rangeLower', '$this->rangeUpper')";
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public static function deleteByMeasureId($measure_id, $lab_config_id)
	{
		# Deletes all entries for the given measure
		# Used when deleting the measure from catalof
		# Or when resetting ranges (from test_type_edit.php)
		global $con;
		$measure_id = mysql_real_escape_string($measure_id, $con);
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string = "DELETE FROM reference_range WHERE measure_id=$measure_id";
		query_delete($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public static function getByAgeAndSex($age, $sex, $measure_id, $lab_config_id)
	{
		# Fetches the reference range based on supplied age and sex values
		global $con;
		$measure_id = mysql_real_escape_string($measure_id, $con);
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$age = mysql_real_escape_string($age, $con);
		$sex = mysql_real_escape_string($sex, $con);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string = "SELECT * FROM reference_range WHERE measure_id=$measure_id";
		$retval = null;
		$resultset = query_associative_all($query_string, $row_count);
		if($resultset == null || count($resultset) == 0)
			return $retval;
		foreach($resultset as $record)
		{
			$ref_range = ReferenceRange::getObject($record);
			if($ref_range->ageMin == 0 && $ref_range->ageMax == 0)
			{
				# No agewise split
				if($ref_range->sex == "B" || strtolower($ref_range->sex) == strtolower($sex))
				{
					return $ref_range;
				}
			}
			else if($ref_range->ageMin <= $age && $ref_range->ageMax >= $age)
			{
				# Age wise split exists
				if($ref_range->sex == "B" || strtolower($ref_range->sex) == strtolower($sex))
				{
					return $ref_range;
				}
			}
		}
		DbUtil::switchRestore($saved_db);
	}
}

class DbUtil
{
	public static function switchToGlobal()
	{
		
		# Saves currently selected DB and switches to 
		# global/metadata DB instance
		global $DEBUG;
		if($DEBUG)
		{
			echo "In switchToGlobal()<br>";
			echo DebugLib::getCallerFunctionName(debug_backtrace())."<br>";
		}
		global $GLOBAL_DB_NAME;
		$saved_db_name = db_get_current();
		db_change($GLOBAL_DB_NAME);
		return $saved_db_name;
	}

	public static function switchToCountry($countryName) {
		# Saves currently selected DB and switches to 
		# country specific DB instance
		global $DEBUG;
		if($DEBUG) {
			echo "In switchToCountry()<br>";
			echo DebugLib::getCallerFunctionName(debug_backtrace())."<br>";
		}
		$saved_db_name = db_get_current();
		$dbName = "blis_".$countryName;
		db_change($dbName);
		return $saved_db_name;
	}
	
	public static function switchToLabConfig($lab_config_id)
	{
		# Saves currently selected DB and switches to
		# local/lab-specific DB instance
		# Used on pages that query data from different labs
		global $DEBUG;
		if($DEBUG)
		{
			echo "In switchToLabConfig($lab_config_id)<br>";
			echo DebugLib::getCallerFunctionName(debug_backtrace())."<br>";
		}
		$saved_db_name = db_get_current();
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null)
		{
			# Error: Lab configuration correspinding to $lab_config_id not found in DB
			return;
		}
		$db_name = $lab_config->dbName;
		db_change($db_name);
		return $saved_db_name;
	}
	
	public static function switchToLabConfigRevamp($lab_config_id=null)
	{
		$saved_db_name = db_get_current();
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null)
		{
			# Error: Lab configuration correspinding to $lab_config_id not found in DB
			return;
		}
		$db_name = $lab_config->dbName;
		db_change($db_name);
		return $saved_db_name;
	}
	
	public static function switchRestore($db_name)
	{
		# Reverts back to saved DB instance
		global $DEBUG;
		if($DEBUG)
		{
			echo "In switchRestore($db_name)<br>";
			echo DebugLib::getCallerFunctionName(debug_backtrace())."<br>";
		}
		db_change($db_name);
	}
}

class SessionUtil
{
	# Class for switching context between sessions
	public static function save()
	{
		$saved_session = array();
		foreach($_SESSION as $key=>$value)
		{
			$saved_session[$key] = $value;
		}
		return $saved_session;
	}
	
	public static function restore($saved_session)
	{
		foreach($saved_session as $key=>$value)
		{
			$_SESSION[$key] = $value;
		}
	}
	
	public static function includeIfMissing($include_path, $test_string)
	{
		# Includes a php file if found to be not included already
		$file_included = false;
		$included_list = get_included_files();
		foreach($included_list as $included_file)
		{
			if(strpos($included_file, $test_string) === true)
			{
				$file_included = true;
				break;
			}
		}
		if($file_included === false)
		{
			include($include_path);
		}
	}
}

class UILog
{
    // Name of the file where the message logs will be appended.
	private $LOGFILENAME;
	
    // Define the separator for the fields. Default is comma (,).
	private $SEPARATOR;
        
   // hHeaders
	private $HEADERS;
        
        public $datetime;
        public $id;
        public $info;
        public $file;
        public $user;
        public $lab;
        public $version;
        public $tag1;
        public $tag2;
        public $tag3;
        
    function UILog($logfilename = '../../local/UILog.csv', $separator = ',') {
                global $VERSION;
                $vers = $VERSION;
                $verss = str_replace('.','-',$vers);
                $logfilename = "../../local/UILog_".$verss.".csv";
		$this->LOGFILENAME = $logfilename;
		$this->SEPARATOR = $separator;
		$this->HEADERS =
			'DATETIME' . $this->SEPARATOR . 
                        'IDENTIFIER' . $this->SEPARATOR . 
			'INFO' . $this->SEPARATOR .
                        'FILE' . $this->SEPARATOR .
                        'USER' . $this->SEPARATOR .
                        'LAB' . $this->SEPARATOR .
                        'VERSION' . $this->SEPARATOR .
                        'TAG1' . $this->SEPARATOR .
                        'TAG2' . $this->SEPARATOR .
			'TAG3';
	}
        
    public function writeUILog()
    {
        global $VERSION;
        $this->datetime = date("Y-m-d H:i:s");
        $this->user = $_SESSION['user_id'];
        $this->lab = $_SESSION['lab_config_id'];
        $this->version = $VERSION;

        
                
        if (!file_exists($this->LOGFILENAME)) 
        {
		$headers = $this->HEADERS .  "\n";
	}
        
        $fd = fopen($this->LOGFILENAME, "a");
        
        if (@$headers) 
        {
		fwrite($fd, $headers);
	}
        
        //$entry = array($datetime,$errorlevel,$tag,$value,$line,$file);
        $entry = array($this->datetime, $this->id, $this->info, $this->file, $this->user, $this->lab, $this->version, $this->tag1, $this->tag2, $this->tag3);
        fputcsv($fd, $entry, $this->SEPARATOR);

        fclose($fd);
    }
    
    public function readUILog($vers, $mode = 0, $filename = "")
    {
        $row = -1;
        $csvdata = array();
        if($mode == 0)
        {
            $verss = str_replace('.','-',$vers);
            $logfilename = "../../local/UILog_".$verss.".csv";
        }
        else
        {
            $logfilename = "../../local/".$filename;
        }
        if (($handle = fopen($logfilename, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle, ",")) !== FALSE) 
            {
                $row++;
                if($row == 0)
                        continue;
                $csvdata[$row] = array();
                $csvdata[$row] = $data;
            }
            fclose($handle);
        }
        return $csvdata;
    }
    
    public function getLogsByID($id, $datefrom = NULL, $dateto = NULL)
    {
        $csvdata = apc_fetch('csvdata');
        $log = array();
        foreach($csvdata as $data)
        {
            if($data[1] == $id)
            {
                $level = get_level_by_id($data[4]);
                $uname = get_username_by_id($data[4]);
                $data[4] = $uname."(".$level.")";
                $labconfig_obj = get_lab_config_by_id($data[5]);
                $data[5] = $labconfig_obj->name;
                array_push ($log, $data);
            }
        }
        return $log;
    }
}

class UserStats
{
    #Specimen table ts reflect date of specimen/test registration and test table ts reflects date of resut entry
    #Specimen table user_id reflects user who registered the specime/test and test table user_id reflects the user who enetered results
    
    public function getAdminUser($lab_config_id)
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_string = 
                            "SELECT admin_user_id FROM lab_config ".
                            "WHERE lab_config_id = $lab_config_id";
                        
	$resultset = query_associative_one($query_string);
        //print_r($resultset);
        $retval = $resultset['admin_user_id'];	
	DbUtil::switchRestore($saved_db);
	return $retval;
    }
    
    public function getAllUsers($lab_config_id)
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_string = 
			"SELECT user_id FROM user ".
			"WHERE lab_config_id = $lab_config_id ".
                        "AND user_id <> ".
			"( ".
                            "SELECT admin_user_id FROM lab_config ".
                            "WHERE lab_config_id = $lab_config_id".
                        " ) ";
	
	$retval = array();
	$resultset = query_associative_all($query_string, $row_count);
        //print_r($resultset);
	foreach($resultset as $record)
	{
             //$i = $resultset['user_id'];
             $retval[] = $record['user_id'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
    }
    
    public function getTestStats($user_id, $lab_config_id, $date_from, $date_to)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $date_from_parts = explode("-", $date_from);		
        $date_to_parts = explode("-", $date_to);
        $date_from_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
        $date_from_ts = date( 'Y-m-d H:i:s', $date_from_ts );
        $date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
        $date_to_ts = date( 'Y-m-d H:i:s', $date_to_ts );

        $query_string = 
				"SELECT COUNT(*) as count_val FROM test ".
				"WHERE specimen_id IN ( ".
                                "SELECT specimen_id from specimen ".
                                "WHERE ts BETWEEN '$date_from_ts' AND '$date_to_ts' ".
				"AND user_id = $user_id)";
	
	$resultset = query_associative_one($query_string);
	$retval = $resultset['count_val'];
        DbUtil::switchRestore($saved_db);
        return $retval;
    }
    
    public function getPatientsStats($user_id, $lab_config_id, $date_from, $date_to)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $date_from_parts = explode("-", $date_from);		
        $date_to_parts = explode("-", $date_to);
        $date_from_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
        $date_from_ts = date( 'Y-m-d H:i:s', $date_from_ts );
        $date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
        $date_to_ts = date( 'Y-m-d H:i:s', $date_to_ts );

        $query_string = 
				"SELECT COUNT(*) as count_val FROM patient ".
				"WHERE ts BETWEEN '$date_from_ts' AND '$date_to_ts' ".
				"AND created_by = $user_id";
	
	$resultset = query_associative_one($query_string);
	$retval = $resultset['count_val'];
        DbUtil::switchRestore($saved_db);
        return $retval;
    }
    
    public function getSpecimenStats($user_id, $lab_config_id, $date_from, $date_to)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $date_from_parts = explode("-", $date_from);		
        $date_to_parts = explode("-", $date_to);
        $date_from_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
        $date_from_ts = date( 'Y-m-d H:i:s', $date_from_ts );
        $date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
        $date_to_ts = date( 'Y-m-d H:i:s', $date_to_ts );

        $query_string = 
				"SELECT COUNT(*) as count_val FROM specimen ".
				"WHERE ts BETWEEN '$date_from_ts' AND '$date_to_ts' ".
				"AND user_id = $user_id";
	
	$resultset = query_associative_one($query_string);
	$retval = $resultset['count_val'];
        DbUtil::switchRestore($saved_db);
        return $retval;
    }
    
    public function getResultStats($user_id, $lab_config_id, $date_from, $date_to)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $date_from_parts = explode("-", $date_from);		
        $date_to_parts = explode("-", $date_to);
        $date_from_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
        $date_from_ts = date( 'Y-m-d H:i:s', $date_from_ts );
        $date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
        $date_to_ts = date( 'Y-m-d H:i:s', $date_to_ts );

        $query_string = 
				"SELECT COUNT(*) as count_val FROM test ".
				"WHERE ts BETWEEN '$date_from_ts' AND '$date_to_ts' ".
				"AND user_id = $user_id ".
                                "AND result <> ''";
	
	$resultset = query_associative_one($query_string);
	$retval = $resultset['count_val'];
        DbUtil::switchRestore($saved_db);
        return $retval;      
    }
    
    public function getPatientRegLog($user_id, $lab_config_id, $date_from, $date_to)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $date_from_parts = explode("-", $date_from);		
        $date_to_parts = explode("-", $date_to);
        $date_from_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
        $date_from_ts = date( 'Y-m-d H:i:s', $date_from_ts );
        $date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
        $date_to_ts = date( 'Y-m-d H:i:s', $date_to_ts );

        $query_string = 
				"SELECT * FROM patient ".
				"WHERE ts BETWEEN '$date_from_ts' AND '$date_to_ts' ".
				"AND created_by = $user_id";
	
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getObject($record);
		}
	}
        DbUtil::switchRestore($saved_db);
        return $patient_list;
    }
    
    public function getSpecimenRegLog($user_id, $lab_config_id, $date_from, $date_to)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $date_from_parts = explode("-", $date_from);		
        $date_to_parts = explode("-", $date_to);
        $date_from_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
        $date_from_ts = date( 'Y-m-d H:i:s', $date_from_ts );
        $date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
        $date_to_ts = date( 'Y-m-d H:i:s', $date_to_ts );

        $query_string = 
				"SELECT * FROM specimen ".
				"WHERE ts BETWEEN '$date_from_ts' AND '$date_to_ts' ".
				"AND user_id = $user_id";
	
	$resultset = query_associative_all($query_string, $row_count);
	$test_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$test_list[] = Specimen::getObject($record);
		}
	}
        DbUtil::switchRestore($saved_db);
        return $test_list;
    }
    
    public function getTestRegLog($user_id, $lab_config_id, $date_from, $date_to)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $date_from_parts = explode("-", $date_from);		
        $date_to_parts = explode("-", $date_to);
        $date_from_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
        $date_from_ts = date( 'Y-m-d H:i:s', $date_from_ts );
        $date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
        $date_to_ts = date( 'Y-m-d H:i:s', $date_to_ts );

        $query_string = 
				"SELECT * FROM test ".
				"WHERE ts BETWEEN '$date_from_ts' AND '$date_to_ts' ".
				"AND user_id = $user_id";
	
	$resultset = query_associative_all($query_string, $row_count);
	$test_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$test_list[] = Test::getObject($record);
		}
	}
        DbUtil::switchRestore($saved_db);
        return $test_list;
    }
    
    public function getResultEntryLog($user_id, $lab_config_id, $date_from, $date_to)
    {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $date_from_parts = explode("-", $date_from);		
        $date_to_parts = explode("-", $date_to);
        $date_from_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
        $date_from_ts = date( 'Y-m-d H:i:s', $date_from_ts );
        $date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
        $date_to_ts = date( 'Y-m-d H:i:s', $date_to_ts );

        $query_string = 
				"SELECT * FROM test ".
				"WHERE ts BETWEEN '$date_from_ts' AND '$date_to_ts' ".
				"AND user_id = $user_id";
	
	$resultset = query_associative_all($query_string, $row_count);
	$test_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$test_list[] = Test::getObject($record);
		}
	}
        DbUtil::switchRestore($saved_db);
        return $test_list;
    }
}

class Bill
{
	#Used to combine payments into a logical grouping, and provide a quick method for users to see if a patient has
	#been billed for a particular test or set of tests.
	
	private $id;
	private $patientId;
	private $paidInFull;
	
	function Bill($patientId)
	{
		$this->paidInFull = FALSE;
		$this->patientId = $patientId;
	}
	
	public function create($lab_config_id)
	{
		$patientId = $this->patientId;

		if ($this->paidInFull)
		{
			$paidInFull = 1;
		} else
		{
			$paidInFull = 0;
		}

		$query_string = "INSERT INTO `bills` (`patient_id`, `paid_in_full`)	VALUES ($patientId, $paidInFull)";
							
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		query_insert_one($query_string);
		
		$this->id = get_last_insert_id();
		
		DbUtil::switchRestore($saved_db);
		
		return 1;
	}
	
	public function save($lab_config_id)
	{
		$id = $this->id;
		$patientId = $this->patientId;
		$paidInFull = $this->paidInFull;

		$query_string = "UPDATE `bills` SET `patient_id` = $patientId,
											`paid_in_full` = $paidInfull
						WHERE `id` = $id";
							
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		query_update($query_string);
		
		DbUtil::switchRestore($saved_db);
		
		return 1;
	}
	
	public static function loadFromId($billId, $lab_config_id)
	{
		$id = $billId;
		
		$query_string = "SELECT * FROM `bills` WHERE `id` = $id";
		
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		$retVal = query_associative_one($query_string);
		
		DbUtil::switchRestore($saved_db);
		
		$bill = new Bill($retVal['patient_id']);
		
		$bill->id = $id;
		$bill->paidInFull = $retVal['paidInFull'];
		
		return $bill;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getPatientId()
	{
		return $this->patientId;
	}
	
	public static function createBillForTests($tests, $lab_config_id)
	{
		# Create a new bill and associate all of the desired tests with it.
		// The way we call the bill constructor here is awkward and assumes that the tests are all for the same patient.
		// While that's true for now, it's not necessarily going to stay that way, so this may need to be revisited. -Robert.

		$bill = new Bill(Specimen::getById($tests[0]->specimenId)->patientId);
		$bill->create($lab_config_id);

		foreach($tests as $test)
		{
			$association = new BillsTestsAssociationObject($bill->id, $test->testId);
			$association->create($lab_config_id);
		}
		
		return $bill;
	}
	
	public static function hasTestBeenBilled($testId, $lab_config_id)
	{
		$query_string = "SELECT COUNT(*) FROM `bills_test_association` WHERE `test_id` = $testId";
		
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		$retVal = query_associative_one($query_string);
		
		DbUtil::switchRestore($saved_db);

		if ($retVal["COUNT(*)"] > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	public function hasBillBeenFullyPaid($lab_config_id)
	{
		if ($this->paidInFull) # If this flag has been toggled, there's no reason to make another DB query.
		{
			return TRUE;
		}
		# Return true if there are enough payments associated with this bill to fully cover its cost.
		$bill_amount = $this->amount;
		
		$payments_total = 0.0;
		
		$payments = Payment::loadAllPaymentsForBill($this->id, $lab_config_id);
		
		foreach($payments as $payment)
		{
			$payments_total += $payment->amount;
		}
		
		if ($payments_total == $bill_amount)
		{
			$bill->paidInFull = TRUE;
			$bill->save($lab_config_id);
			return TRUE;
		} else if ($payments_total < $bill_amount)
		{
			return FALSE;
		} else
		{
			// I'm really not sure how we want to handle if the bill was OVER-paid.  TODO: Ask Naomi/Santosh at some point.
			// For now, I'm just calling it fully paid.
			$bill->paidInFull = TRUE;
			$bill->save($lab_config_id);
			return TRUE;
		}
	}
	
	public function getAllAssociationsForBill($lab_config_id)
	{
		$id = $this->id;
		
		$query_string = "SELECT id FROM `bills_test_association` WHERE `bill_id` = $id";
		
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		$retVal = query_associative_all($query_string, $_COUNT);
		
		DbUtil::switchRestore($saved_db);
		
		$associations = array();
		foreach($retVal as $entry)
		{
			$associations[] = BillsTestsAssociationObject::loadFromId($entry['id'], $lab_config_id);
		}
		return $associations;
	}

	public function getBillTotal($lab_config_id)
	{
		$associations = $this->getAllAssociationsForBill($lab_config_id);

		$runningTotal = 0.00;
		foreach($associations as $assoc)
		{
			$runningTotal += $assoc->getDiscountedTotal();
		}
		return $runningTotal;
	}
	
	public function getFormattedTotal($lab_config_id)
	{
		$cost = $this->getBillTotal($lab_config_id);
		
		return format_number_to_money($cost);
	}
}

class BillsTestsAssociationObject
{
	# Used to associate tests with a bill.  Also provides a place to apply discounts to a test,
	#  since we don't want to modify the existing test table structure.
	
	// Constants for discount assignments.
	const NONE = 1000;
	const PERCENT = 1001;
	const FLAT = 1002;
	
	private $id;
	private $billId;
	private $testId;
	private $discountType;
	private $discount;
	
	function BillsTestsAssociationObject($billId, $testId)
	{
		$this->billId = $billId;
		$this->testId = $testId;
		$this->discountType = self::NONE;
		$this->discount = 0.00;
	}
	
	function create($lab_config_id)
	{
		$billId = $this->billId;
		$testId = $this->testId;
		$discountType = $this->discountType;
		$discountAmount = $this->discount;
		
		$query_string = "INSERT INTO `bills_test_association` (bill_id, test_id, discount_type, discount_amount)
							VALUES ($billId, $testId, $discountType, $discountAmount)";
							
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		query_insert_one($query_string);
		
		$this->id = get_last_insert_id();
		
		DbUtil::switchRestore($saved_db);
		
		return 1;
	}
	
	function save($lab_config_id)
	{
		$id = $this->id;
		$billId = $this->billId;
		$testId = $this->testId;
		$discountType = $this->discountType;
		$discountAmount = $this->discount;
		
		$query_string = "UPDATE `bills_test_association` SET `bill_id` = $billId,
															 `test_id` = $testId,
															 `discount_type` = $discountType,
															 `discount_amount` = $discountAmount
						WHERE `id` = $id";

		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		query_update($query_string);
		
		DbUtil::switchRestore($saved_db);
		
		return 1;
	}
	
	function loadFromId($id, $lab_config_id)
	{
		
		$query_string = "SELECT * FROM `bills_test_association` WHERE `id` = $id";
		
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);

		$retVal = query_associative_one($query_string);

		DbUtil::switchRestore($saved_db);
		
		$association = new BillsTestsAssociationObject($retVal['bill_id'], $retVal['test_id']);

		$association->id = $id;
		$association->discountType = $retVal['discount_type'];
		$association->discount = $retVal['discount_amount'];
		
		return $association;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getDiscountedTotal()
	{
		switch($this->discountType)
		{
		case self::NONE:
			$unformatted_cost = $this->getCostOfTest();
			break;
		case self::FLAT:
			$unformatted_cost = $this->getCostOfTest() - $this->discount;
			break;
		case self::PERCENT:
			$unformatted_cost = $this->getCostOfTest() * (1 - ($this->discount / 100));
			break;
		default:
			// Shouldn't get here.
			break;
		}
		$cost = (floor($unformatted_cost * 100)) / 100;
		return $unformatted_cost;
	}
	
	public function getCostOfTest()
	{
		$test = Test::getById($this->testId);
		$cost = get_cost_of_test($test);
		$cost = $cost['amount'];
		return floatVal($cost);
	}
	
	public function getTestId()
	{
		return $this->testId;
	}
	
	public function getTest()
	{
		$id = $this->testId;
		
		$test = Test::loadById($id);
		
		return $test;
	}
	
	public function getBillId()
	{
		return $this->billId;
	}
	
	public function getDiscountAmount()
	{
		return $this->discount;
	}
	
	public function isFlatDiscount()
	{
		if ($this->discountType == self::FLAT)
		{
			return TRUE;
		} else
		{
			return FALSE;
		}
	}

	public function isPercentDiscount()
	{
		if ($this->discountType == self::PERCENT)
		{
			return TRUE;
		} else
		{
			return FALSE;
		}
	}

	public function isDiscountDisabled()
	{
		if ($this->discountType == self::NONE)
		{
			return TRUE;
		} else
		{
			return FALSE;
		}
	}
	
	public function setDiscountType($discount_type)
	{
		if ($discount_type < 100 or $discount_type > 1002)
		{
			return 0;
		}
		$this->discountType = $discount_type;

		return 1;
	}
	
	public function setDiscountAmount($amount)
	{
		if (!is_numeric($amount))
		{
			# Passed in something that was not a number.
			return 0;
		}
		
		#Ensure that whatever we got is in numeric form.
		$amount = floatval($amount);
		
		if ($amount < 0)
		{
			# Passed in a negative value, which we aren't going to allow.
			return 0;
		}

		switch ($this->discountType)
		{
		case self::NONE:
			break; // Shouldn't happen.
		case self::PERCENT:
			if ($amount > 100)
			{
				# Passed in a value greater than 100 for a percentage discount, which we aren't going to allow.
				return 0;
			}
			break;
		case self::FLAT:
			if ($amount > $this->getCostOfTest())
			{
				# Passed in a value greater than the cost of the test, which we aren't going to allow.
				return 0;
			}
			break;
		default:
			break; // shouldn't happen.
		}

		# If it gets this far, we have a good numeric value to add.
		$this->discount = $amount;
		return 1;
	}
	
	public function loadByTestId($testId, $lab_config_id)
	{
		$query_string = "SELECT id FROM `bills_test_association` WHERE `test_id` = $testId";
		
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);

		$retVal = query_associative_one($query_string);

		DbUtil::switchRestore($saved_db);
		
		$association = self::loadFromId($retVal['id'], $lab_config_id);
		
		return $association;
	}
	
	// Return the name for the test this object references.
	public function getTestName()
	{
		$id = $this->testId;

		$query_string = "SELECT name FROM test_type WHERE test_type_id = (SELECT test_type_id FROM test WHERE test_id = $id)";
		
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

		$retVal = query_associative_one($query_string);

		DbUtil::switchRestore($saved_db);

		return $retVal['name'];
	}
	
	// Return the date for the test this object references.
	public function getTestDate()
	{
		$id = $this->testId;

		$query_string = "SELECT ts FROM test WHERE test_id = $id";
		
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);

		$retVal = query_associative_one($query_string);

		DbUtil::switchRestore($saved_db);

		$date = $retVal['ts'];
		
		return date("Y-m-d", strtotime($date));
	}
	
	// Return the cost for the test this object references, formatted accordingly.
	public function getFormattedTestCost()
	{
		$cost = $this->getDiscountedTotal();
		
		return format_number_to_money($cost);
	}
}

class Payment
{
	#Records the payment of a bill
	
	public $id;
	public $amount;
	public $billId;
	
	function Payment($amount, $billId)
	{
		$this->amount = $amount;
		$this->billId = $billId;
	}
	
	public function create($lab_config_id)
	{
		$amount = $this->amount;
		$billId = $this->billId;

		$query_string = "INSERT INTO `payments` (`amount`, `bill_id`)
							VALUES ($amount, $billId)";
							
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		query_insert_one($query_string);
		
		$this->id = get_last_insert_id();
		
		DbUtil::switchRestore($saved_db);
		
		return 1;
	}
	
	public function save($lab_config_id)
	{
		$id = $this->id;
		$amount = $this->amount;
		$billId = $this->billId;

		$query_string = "UPDATE `payments` SET `amount` = $amount,
											   `bill_id` = $billId
						WHERE `id` = $id";
							
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		query_update($query_string);
		
		DbUtil::switchRestore($saved_db);
		
		return 1;
	}
	
	public static function loadFromId($id, $lab_config_id)
	{
		$query_string = "SELECT * FROM `payments` WHERE `id` = $id";
		
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		$retVal = query_associative_one($query_string);
		
		DbUtil::switchRestore($saved_db);
		
		$payment = new Payment($retVal['patient_id']);
		
		$payment->id = $id;
		$payment->amount = $retVal['amount'];
		$payment->billId = $retVal['bill_id'];
		
		return $payment;
	}
	
	public static function loadAllPaymentsForBill($bill, $lab_config_id)
	{
		$billId = $bill->id;
		
		$query_string = "SELECT id FROM `payments` WHERE `bill_id` = $billId";
		
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		
		$retVal = query_associative_all($query_string);
		
		DbUtil::switchRestore($saved_db);
		
		$payments = array();
		
		if (count($retVal != 0))
		{
			foreach ($retVal as $val)
			{
				$payments.append(Payment::loadFromId($val, $lab_config_id));
			}
			return $payments;
		} else
		{
			return 0;
		}
	}
	
	public static function createNewPaymentForBill($bill, $amount, $lab_config_id)
	{
		$payment = new Payment($amount, $bill->id);
		
		$payment->create($lab_config_id);
		
		return $payment;
	}
}
#
# Functions for managing user profiles and login
#

function encrypt_password($password)
{
	# Encrypts cleartext password before adding to DB or matching passwords
	$salt = "This comment should suffice as salt.";
	return sha1($password.$salt);

}

function check_user_password($username, $password)
{
	# Verifies username and password
	global $con;
	$username = mysql_real_escape_string($username, $con);
	$saved_db = DbUtil::switchToGlobal();
	$password = encrypt_password($password);
	$query_string = 
		"SELECT * FROM user ".
		"WHERE username='$username' ".
		"AND password='$password' LIMIT 1";
	$record = query_associative_one($query_string);
	# Return user profile (null if incorrect username/password)
	DbUtil::switchRestore($saved_db);
	return User::getObject($record);
}

function change_user_password($username, $password)
{
	# Changes user password
	global $con;
	$username = mysql_real_escape_string($username, $con);
	$saved_db = DbUtil::switchToGlobal();
	$password = encrypt_password($password);
	$query_string =
		"UPDATE user ".
		"SET password='$password' ".
		"WHERE username='$username'";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
}

function change_user_password_oneTime($username, $password)
{
	# Changes user password
	global $con;
	$username = mysql_real_escape_string($username, $con);
	$saved_db = DbUtil::switchToGlobal();
	$password = encrypt_password($password);
	$query_string =
	"UPDATE user ".
	"SET password='$password' ".
	"WHERE username='$username'";
	query_blind($query_string);
	
	//insert into blis_129.misc (vr_id, v1, v2) values ("username", "admin", "Password Reset Complete");
	$query_string_misc = 
	"INSERT INTO MISC ".
	"(username, action) values ('$username', 'password reset completed')";
	query_blind($query_string_misc);
	
	DbUtil::switchRestore($saved_db);
}

function password_reset_need_confirm()
{
	# Changes user password
	global $con;
	$saved_db = DbUtil::switchToGlobal();
	$query_string = "select count(*) as resetCount from misc where action='password reset completed'";
	$record = query_associative_one($query_string);
	//$num_rows = mysql_num_rows($record);
	DbUtil::switchRestore($saved_db);
	if($record['resetCount'] == 0)
		return true;
	return false; 
	//return $record;
}

function password_reset_flush($reset_before_date){
	global $con; 
	$saved_db = DbUtil::switchToGlobal();
	$query_string = "delete from misc where ts<'$reset_before_date' && action='password reset completed'";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
}

function check_user_exists($username)
{
	# Checks if the username exists in DB
	global $con;
	$username = mysql_real_escape_string($username, $con);
	$saved_db = DbUtil::switchToGlobal();
	$query_string = "SELECT username FROM user WHERE username='$username' LIMIT 1";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	if($record == null)
		return false;
	return true;
}

function add_user($user)
{
	# Adds a new user account
	if (!check_user_exists($user->username)){
		$saved_db = DbUtil::switchToGlobal();
		$password = encrypt_password($user->password);
		$rwoptions = $user->rwoptions;
		if($user->level == 17) {
			$user->rwoptions = LabConfig::getDoctorUserOptions();
		}
		$query_string = 
			"INSERT INTO user(username, password, actualname, level, created_by, lab_config_id, email, phone, lang_id, rwoptions) ".
			"VALUES ('$user->username', '$password', '$user->actualName', $user->level, $user->createdBy, '$user->labConfigId', '$user->email', '$user->phone', '$user->langId','$user->rwoptions')";
		
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);

		$saved_db = DbUtil::switchToGlobal();
		$query_string = "SELECT user_id FROM user WHERE username='$user->username' LIMIT 1";
		$record = query_associative_one($query_string);
		$query_string = 
			"INSERT INTO user_config(user_id, level, parameter, value, created_by, created_on, modified_by, modified_on) ".
			"VALUES ('".$record['user_id']."',$user->level, 'rwoptions', '$rwoptions', $user->createdBy, curdate(), $user->createdBy, curdate())";
		query_insert_one($query_string);

		DbUtil::switchRestore($saved_db);
		return true;
	}	
	return false;
}
function fetch_user_log($patientId,$logType){
	$saved_db = DbUtil::switchToGlobal();
	$queryString = "SELECT created_by, creation_date from user_log where patient_id =  ".$patientId." and log_type = '".$logType."'";
	$resultset = query_associative_all($query_string, 0);
	DbUtil::switchRestore($saved_db);
	return $resultset;
}

function add_user_type($user_type, $defaultdisplay, $rwoption)
{
	# Adds a new user account
	$saved_db = DbUtil::switchToGlobal();
	$password = encrypt_password($user->password);
	$query_string = "SELECT count(1) as count from user_type where lower(name) = lower('$user_type')";
	
	$retVal = query_associative_one($query_string);

	if($retVal['count'] == 0){
		$query_string = 
		"INSERT INTO user_type(name, defaultdisplay, created_by) ".
		"VALUES ('$user_type',$defaultdisplay,'".$_SESSION['user_id']."')";
	
		query_insert_one($query_string);

		$query_string = "SELECT level from user_type where name = '$user_type'";	
		$retVal = query_associative_one($query_string);

		$query_string = "insert into user_type_config(level, parameter, value, created_by, modified_by) values ('".$retVal['level']."','rwoptions', '$rwoption', '".$_SESSION['user_id']."', '".$_SESSION['user_id']."')";
		query_insert_one($query_string);
	}

	DbUtil::switchRestore($saved_db);

	return $retVal['count'];

}

function get_user_type_options($user_type)
{
	# Adds a new user account
	$saved_db = DbUtil::switchToGlobal();
	$password = encrypt_password($user->password);
	$query_string = "SELECT value from user_type_config where level = $user_type and parameter ='rwoptions'";	
	$retVal = query_associative_one($query_string);
	
	DbUtil::switchRestore($saved_db);

	return $retVal['value'];

}

function get_level_name_db($user_level)
{
	$saved_db = DbUtil::switchToGlobal();
	$password = encrypt_password($user->password);
	$query_string = "SELECT name FROM user_type where level = $user_level";	
	$retVal = query_associative_one($query_string);
	
	DbUtil::switchRestore($saved_db);

	return $retVal['name'];
}
// Delete Tests related to specimen
function delete_tests_by_test_id($tests_list){
	if(sizeof($tests_list)>0){
		foreach($tests_list as $test){
			/* $query_string = "DELETE FROM test WHERE test_id=$test->testId";
			query_blind($query_string); */
			$remarks = "Typo";
			$category = "test";
			remove_specimens($lab_config_id, $test->testId, $remarks, $category);
		}
	}
}

// Delete Specimen related to patient
function delete_specimen_by_specimen_id($specimen_list){
	if(sizeof($specimen_list)>0){
		foreach($specimen_list as $specimen){
			$testsList = get_tests_by_specimen_id($specimen->specimenId);
			delete_tests_by_test_id($testsList);
			/* $query_string = "DELETE FROM specimen WHERE specimen_id=$specimen->specimenId";
			query_blind($query_string); */
			$remarks = "Typo";
			$category = "specimen";
			remove_specimens($lab_config_id, $specimen->specimenId, $remarks, $category);
		}
	}
	
}

 function delete_specimen_by_specimen_id_api($specimen_list, $lab_config_id, $remarks = "Typo"){
	global $con;
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	
 	if(sizeof($specimen_list)>0){
		foreach($specimen_list as $specimen){
			//echo "in delete_specimen_by_specimen_id_api : ".$specimen->specimenId;
			$testsList = get_tests_by_specimen_id($specimen->specimenId);
			delete_tests_by_test_id($testsList);
			/* $query_string = "DELETE FROM specimen WHERE specimen_id=$specimen->specimenId";
			query_blind($query_string); */
			
			$category = "specimen";
			remove_specimens($lab_config_id, $specimen->specimenId, $remarks, $category);
		}
	}
	DbUtil::switchRestore($saved_db);
	return 1;
}

function delete_test_by_test_id_api($test_list, $lab_config_id){
	global $con;
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);

	if(sizeof($test_list)>0){
		
		foreach($test_list as $test){
/* 			$query_string = "DELETE FROM test WHERE test_id=$test->testId";
			query_blind($query_string);
 */		
			$remarks = "Typo";
			$category = "test";
			remove_specimens($lab_config_id, $test->testId, $remarks, $category);
		}
	}
	DbUtil::switchRestore($saved_db);
	return 1;
}

function delete_patient($patient_id, $lab_config_id)
{
	$retval = get_specimens_by_patient_id($patient_id);
	# Deletes a patient from DB
	$isSuccess = 1;
	global $con;
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	
	if(sizeof($retval)>0){
		// Collect Specimen Related to patients 
		// Delete the above collected specimen from the above specimen table
		// Collect the tests related to the above specimen
		// Delete the above collected tests from the appropriate table
		//$isSuccess = 0;
		delete_specimen_by_specimen_id($retval);
	}  
		# Remove patient record
	//$query_string = "DELETE FROM patient WHERE patient_id=$patient_id";
	//query_blind($query_string);
	$remarks = "Typo";
	$category = "patient";
	remove_specimens($lab_config_id, $patient_id, $remarks, $category);
	DbUtil::switchRestore($saved_db);
	return $isSuccess;
}

function update_user_profile($updated_entry)
{
	# Updates user profile information
	$saved_db = DbUtil::switchToGlobal();
	$user_id = $updated_entry->userId;
	$query_string = 
		"UPDATE user ".
		"SET email='$updated_entry->email', ".
		"phone='$updated_entry->phone', ".
		"actualname='$updated_entry->actualName', ".
		"lang_id='$updated_entry->langId' ".
		"WHERE user_id=$user_id";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
}

function update_user_level($updated_entry)
{
	# Changes user access level
	$saved_db = DbUtil::switchToGlobal();
	$user_id = $updated_entry->userId;
	$query_string = 
		"UPDATE user ".
		"SET level=$updated_entry->level ".
		"WHERE user_id=$updated_entry->userId";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"UPDATE user_config ".
		"SET level=$updated_entry->level ".
		"WHERE user_id=$user_id";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
}

function update_admin_user($updated_entry)
{
	# Updates lab admin account
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"UPDATE user ".
		"SET actualname='$updated_entry->actualName', ".
		"phone='$updated_entry->phone', ".
		"email='$updated_entry->email', ".
		"lang_id='$updated_entry->langId' ".
		"WHERE user_id=$updated_entry->userId";
	query_blind($query_string);
	if($updated_entry->password != "")
	{
		change_user_password($updated_entry->username, $updated_entry->password);
	}
	DbUtil::switchRestore($saved_db);
}

function update_lab_user($updated_entry)
{
	# Updates lab user (non-admin) account
	$saved_db = DbUtil::switchToGlobal();
	// if($updated_entry->level == 17) {
	// 	$updated_entry->rwoption = LabConfig::getDoctorUserOptions();
	// }
	$query_string = 
		"UPDATE user ".
		"SET actualname='$updated_entry->actualName', ".
		"phone='$updated_entry->phone', ".
		"email='$updated_entry->email', ".
		"level=$updated_entry->level, ".
		"lang_id='$updated_entry->langId', ".
		"rwoptions='$updated_entry->rwoption' ".
		"WHERE user_id=$updated_entry->userId";
	query_blind($query_string);

	if($updated_entry->password != "")
	{
		change_user_password($updated_entry->username, $updated_entry->password);
	}
	DbUtil::switchRestore($saved_db);
	# Updates user_config
	$saved_db = DbUtil::switchToGlobal();
	$query_string =
		"UPDATE user_config 
		SET level=".$updated_entry->level.", ".
		"value='".$updated_entry->rwoption."' ".
		" WHERE user_id=".$updated_entry->userId." and parameter = 'rwoptions'";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);


}

function update_lab_user_type($updated_entry, $rwoption)
{
	# Updates lab user (non-admin) account
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"UPDATE user_type ".
		"SET defaultdisplay=$updated_entry->defaultdisplay ".
		"WHERE level=$updated_entry->level";
	query_blind($query_string);

	$query_string = 
		"UPDATE user_type_config ".
		"SET value='$rwoption' ".
		"WHERE level=$updated_entry->level and parameter='rwoptions'";
	query_blind($query_string);
	
	DbUtil::switchRestore($saved_db);
}

function update_lab_RWOptions($config)
{
	# Updates lab user (non-admin) account
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
	"UPDATE user ".
	"SET rwoptions='$config'".
	"WHERE level=17 and lab_config_id = ".$_SESSION['lab_config_id']."";
	query_blind($query_string);	
	DbUtil::switchRestore($saved_db);

	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
	"UPDATE user_config ".
	"SET value='$config'".
	"WHERE level=17 and lab_config_id = ".$_SESSION['lab_config_id']." and parameter = 'rwoptions'";
	query_blind($query_string);	
	DbUtil::switchRestore($saved_db);

}

function delete_user_by_id($user_id)
{
	# Deletes a user from DB
	global $con;
	$user_id = mysql_real_escape_string($user_id, $con);
	$saved_db = DbUtil::switchToGlobal();
	# Remove entries from lab_config_access
	$query_string = 
		"DELETE FROM lab_config_access ".
		"WHERE user_id=$user_id";
	query_blind($query_string);
	# Remove user record
	$query_string =
		"DELETE FROM user WHERE user_id=$user_id";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
	# Remove user_config record
	$saved_db = DbUtil::switchToGlobal();
	$query_string =
		"DELETE FROM user_config WHERE user_id=$user_id";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);

}
function delete_user_type($user_type)
{
	# Deletes a user from DB
	global $con;
	//$user_id = mysql_real_escape_string($user_id, $con);
	$saved_db = DbUtil::switchToGlobal();
	# Remove entries from lab_config_access
	$query_string = 
		"DELETE FROM user_type ".
		"WHERE level=$user_type";
	query_blind($query_string);

	$query_string = 
	"DELETE FROM user_type_config ".
	"WHERE level=$user_type";
	query_blind($query_string);
	# Remove user record
	$query_string =
		"DELETE FROM user WHERE level=$user_type";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
}
function get_user_by_id($user_id)
{
	global $con;
	$user_id = mysql_real_escape_string($user_id, $con);
	# Fetches user record by primary key
	$saved_db = DbUtil::switchToGlobal();
	$query_string = "SELECT  a.user_id, a.username, a.password,a.actualname, a.email, a.created_by, a.ts, a.lab_config_id, a.level, a.phone, a.lang_id, b.value as rwoptions 
	FROM user a, user_config b  WHERE a.user_id = b.user_id and b.parameter = 'rwoptions' and a.user_id=$user_id LIMIT 1";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return User::getObject($record);
}

function get_user_by_level($user_level)
{
	global $con;
	//$user_id = mysql_real_escape_string($user_id, $con);
	# Fetches user record by primary key
	$saved_db = DbUtil::switchToGlobal();
	$query_string = "SELECT  a.*,b.value as rwoption from user_type a, user_type_config b WHERE a.level = $user_level and a.level = b.level and b.parameter = 'rwoptions' LIMIT 1";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return UserType::getObject($record);
}

function get_username_by_id($user_id)
{
	# Returns username as string
	global $con;
	$user_id = mysql_real_escape_string($user_id, $con);
	$saved_db = DbUtil::switchToGlobal();
	$query_string = "SELECT username FROM user WHERE user_id=$user_id";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	if($record == null)
		return LangUtil::$generalTerms['NOTKNOWN'];
	else
		return $record['username'];
}

function get_user_position_by_id($user_id)
{
	# Returns username as string
	global $con;
	$user_id = mysql_real_escape_string($user_id, $con);
	$saved_db = DbUtil::switchToGlobal();
	$query_string = "SELECT level FROM user WHERE user_id=$user_id";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	if($record == null)
		return LangUtil::$generalTerms['NOTKNOWN'];
	
	$user_level = $record['level'];
	
	
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_VERIFIER, $LIS_COUNTRYDIR, $LIS_CLERK,$LIS_PHYSICIAN;
	global $LIS_001, $LIS_010, $LIS_011, $LIS_100, $LIS_101, $LIS_110, $LIS_111, $LIS_TECH_SHOWPNAME;
	
	switch($user_level){
		case $LIS_VERIFIER:
			return "Verifier";
			break;
		case $LIS_ADMIN:
			return "Lab Admin";
			break;
		case $LIS_SUPERADMIN:
			return "Admin";
			break;
		case $LIS_COUNTRYDIR:
			return "Country Director";
			break;
		case $LIS_CLERK:
			return "Clerk";
			break;
			case $LIS_PHYSICIAN:
				return "Doctor";
				break;
		default :
			return "";
			break;
	}
	
	
	
	
	
	return $record['level'];
	
	
}

function get_user_by_name($username)
{
	global $con;
	$username = mysql_real_escape_string($username, $con);
	# Fetches user record by username
	$saved_db = DbUtil::switchToGlobal();
	#$query_string = "SELECT * FROM user WHERE username='$username' LIMIT 1";
	$query_string = "SELECT  a.user_id, a.username, a.password,a.actualname, a.email, a.created_by, a.ts, a.lab_config_id, a.level, a.phone, a.lang_id, b.value as rwoptions 
	FROM user a, user_config b  WHERE a.user_id = b.user_id and b.parameter = 'rwoptions' and a.username='$username' LIMIT 1";
	$record = query_associative_one($query_string);
	if ($record == null){
		$query_string = "SELECT user_id, username, password, actualname, email, created_by, ts, lab_config_id, level, phone, lang_id, rwoptions FROM user WHERE username='$username' LIMIT 1";
		$record = query_associative_one($query_string);
	}
	if ($record == null){
		$query_string = "SELECT user_id, username, password, actualname, email, created_by, ts, lab_config_id, level, phone, lang_id FROM user WHERE username='$username' LIMIT 1";
		$record = query_associative_one($query_string);
	}
	DbUtil::switchRestore($saved_db);
	return User::getObject($record);
}

function get_admin_users()
{
	# Fetches list (assoc array) of admin users
	# Called from lab_admins.php
	global $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_COUNTRYDIR;
	$saved_db = DbUtil::switchToGlobal();
	$query_string = "";
	if($_SESSION['user_level'] == $LIS_SUPERADMIN)
	{
		# Return all admin accounts
		#$query_string = 
		#	"SELECT * FROM user ".
		#	"WHERE level=$LIS_ADMIN ORDER BY username";
		$query_string = "SELECT  a.user_id, a.username, a.password,a.actualname, a.email, a.created_by, a.ts, a.lab_config_id, a.level, a.phone, a.lang_id, b.value as rwoptions 
		FROM user a, user_config b  WHERE a.user_id = b.user_id and b.parameter = 'rwoptions' and a.username='$LIS_ADMIN' ORDER BY username";
	}
	else if($_SESSION['user_level'] == $LIS_COUNTRYDIR)
	{
		# Return all admin accounts from that country alone
		$query_string = 
			"SELECT u.* FROM user u ".
			"WHERE u.level=$LIS_ADMIN ".
			"AND (u.user_id IN ( ".
			"SELECT lc.admin_user_id FROM lab_config lc, lab_config_access lca ".
			"WHERE lc.lab_config_id=lca.lab_config_id ".
			"AND lca.user_id=".$_SESSION['user_id']." )) ".
			"OR u.created_by=".$_SESSION['user_id']." ".
			"ORDER BY u.username";
	}
	$retval = array();
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$retval[] = User::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_level_by_id($user_id)
{
	global $con;
	$username = mysql_real_escape_string($username, $con);
	$user = get_user_by_id($user_id);
	return $user->level;
}

function get_admin_user_list($user_id)
{
	# Fetches list (assoc array) of admin users
	# Called from lab_config_new.php
	global $con;
	$user_id = mysql_real_escape_string($user_id, $con);
	global $LIS_ADMIN;
	$saved_db = DbUtil::switchToGlobal();
	$user = get_user_by_id($user_id);
	$retval = array();
	if(true)//is_super_admin($user))
	{
		# Super-admin level user: Return all admin accounts
		#$query_string = 
		#	"SELECT * FROM user ".
		#	"WHERE level=$LIS_ADMIN";
		$query_string = "SELECT  a.user_id, a.username, a.password,a.actualname, a.email, a.created_by, a.ts, a.lab_config_id, a.level, a.phone, a.lang_id, b.value as rwoptions 
		FROM user a, user_config b  WHERE a.user_id = b.user_id and b.parameter = 'rwoptions' and a.username='$LIS_ADMIN'";
	}
	else if(is_country_dir($user))
	{
		# Country dir: Return all admin accounts in that country alone
		$query_string = 
			"SELECT u.* FROM user u ".
			"WHERE u.level=$LIS_ADMIN ".
			"AND u.user_id IN ( ".
			"SELECT lc.admin_user_id FROM lab_config lc, lab_config_access lca ".
			"WHERE lc.lab_config_id=lca.lab_config_id ".
			"AND lca.user_id=".$_SESSION['user_id']." ) ".
			"ORDER BY u.username";
	}
	else
	{
		# Only admin level user: Return single option
		#$query_string = "SELECT * FROM user WHERE user_id=$user_id";
		$query_string = "SELECT  a.user_id, a.username, a.password,a.actualname, a.email, a.created_by, a.ts, a.lab_config_id, a.level, a.phone, a.lang_id, b.value as rwoptions 
		FROM user a, user_config b  WHERE a.user_id = b.user_id and b.parameter = 'rwoptions' and a.user_id='$user_id' ";
	}
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$retval[$record['user_id']] = $record['username'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}


#
# Functions for adding patient-related information
#

function add_patient($patient, $importOn = false)
{
	# Adds a new patient to DB (called from ajax/patient_add.php)
	$pid = $patient->patientId;
	$addl_id = db_escape($patient->addlId);
	$name = db_escape($patient->name);
	$dob = db_escape($patient->dob);
	$partial_dob = db_escape($patient->partialDob);
	$age = db_escape($patient->age);
	$sex = $patient->sex;
	$receipt_date=db_escape($patient->regDate);
	$surr_id = db_escape($patient->surrogateId);
	$created_by = db_escape($patient->createdBy);
	$hash_value = $patient->generateHashValue();
	$query_string = "";
	
	/* Ensure that no other entry has been added prior to this function being called. If yes, update patientId */
	if($importOn == false) { // Do not check during importing of patient since no conflicts are going to arise
		$maxPid = bcadd(get_max_patient_id(), 1);
		if( $maxPid != $pid )
			$pid = $maxPid;
	}
	
	if($dob == "" && $partial_dob == "")
	{
		$query_string = 
			"INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `surr_id`, `created_by`, `hash_value` ,`ts`) ".
			"VALUES ($pid, '$addl_id', '$name', $age, '$sex', '$surr_id', $created_by, '$hash_value', '$receipt_date')";
	}
	else if($partial_dob != "")
	{
		$query_string = 
			"INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) ".
			"VALUES ($pid, '$addl_id', '$name', $age, '$sex', '$partial_dob', '$surr_id', $created_by, '$hash_value', '$receipt_date')";
	}
	else
	{
		$query_string =
			"INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `dob`, `age`, `sex`, `surr_id`, `created_by`, `hash_value`, `ts`) ".
			"VALUES ($pid, '$addl_id', '$name', '$dob', $age, '$sex', '$surr_id', $created_by, '$hash_value', '$receipt_date')";
	}
	
	print $query_string;
	query_insert_one($query_string);
	return true;
}

function check_patient_id($pid)
{
	# Checks if patient ID already exists in DB, and returns true/false accordingly
	# Called from ajax/patient_check_id.php
	global $con;
	$pid = mysql_real_escape_string($pid, $con);
	$query_string = "SELECT patient_id FROM patient WHERE patient_id=$pid LIMIT 1";
	$retval = query_associative_one($query_string);
	if($retval == null)
		return false;
	else
		return true;
}

function check_spacemen_byname($specimen_name)
{
	# Checks if Specimen already exists in DB, and returns true/false accordingly
	global $con;
	$specimen_name = mysql_real_escape_string($specimen_name, $con);
	$query_string = "SELECT specimen_type_id FROM specimen_type WHERE name='$specimen_name' LIMIT 1";	
	$retval = query_associative_one($query_string);
	if($retval == null)
		return false;
	else
		return true;
	
}

function check_testType_byname($test_type)
{
	# Checks if Specimen already exists in DB, and returns true/false accordingly
	global $con;
	$test_type = mysql_real_escape_string($test_type, $con);
	$query_string = "SELECT test_type_id FROM test_type WHERE name='$test_type' LIMIT 1";	
	$retval = query_associative_one($query_string);
	if($retval == null)
		return false;
	else
		return true;
	
}
function check_patient_surr_id($surr_id)
{
	# Checks if patient ID already exists in DB, and returns true/false accordingly
	# Called from ajax/patient_check_surr_id.php
	global $con;
	$surr_id = mysql_real_escape_string($surr_id, $con);
	$query_string = "SELECT surr_id FROM patient WHERE surr_id='$surr_id' LIMIT 1";	
	$retval = query_associative_one($query_string);
	if($retval == null)
		return false;
	else
		return true;
}

function get_patient_by_sp_id($sid)
{
	global $con;
	$sid = mysql_real_escape_string($sid, $con);
$query_string="SELECT patient_id FROM specimen WHERE specimen_id=$sid ";
//;
$resultset = query_associative_one($query_string);
$patient_list = array();
	if(count($resultset) > 0)
	{
		
		$id= $resultset['patient_id'];
		
			$patient_list[] = Patient::getById($id);
			//print_r($patient_list);
		}

return $patient_list;


}


function get_patient_by_id($pid)
{
	global $con;
	$pid = mysql_real_escape_string($pid, $con);
	# Fetches a patient record by patient id
	return Patient::getById($pid);
}

function search_patients_by_id($q, $labsection = 0)
{
	global $con;
	$q = mysql_real_escape_string($q, $con);
	# Searches for patients with similar PID
	if(! is_admin_check(get_user_by_id($_SESSION['user_id']))){
		if($labsection == 0){
			$query_string =
			"SELECT * FROM patient ".
			"WHERE surr_id='$q' ".
			"ORDER BY ts DESC";
		} else {
			$query_string =
			"select distinct p.* from patient p, specimen s where ".
			"p.surr_id ='$q' and p.patient_id = s.patient_id and s.specimen_id in ".
			"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
			"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.ts DESC";
		
		}	
	} else {
	if($labsection == 0){
		$query_string = 
		"SELECT * FROM patient ".
		"WHERE surr_id='$q' AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1)".
		"ORDER BY ts DESC";
	} else {
		$query_string =
		"select distinct p.* from patient p, specimen s where ".
		"p.surr_id ='$q' AND p.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) and p.patient_id = s.patient_id and s.specimen_id in ".
		"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
		"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.ts DESC";
		
	}
	}
	//;
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getObject($record);
			
		}
	}
	return $patient_list;
}

function search_patients_by_id_dyn($q, $cap, $counter, $labsection = 0)
{
	# Searches for patients with similar name
	global $con;
        $offset = $cap * ($counter - 1);
	$q = mysql_real_escape_string($q, $con);
	
	
	if($labsection == 0){
		$query_string = 
		"SELECT * FROM patient ".
		"WHERE surr_id='$q' ORDER BY ts DESC LIMIT $offset,$cap";
	} else {
		$query_string =
		"select distinct p.* from patient p, specimen s where ".
		"p.surr_id ='$q' and p.patient_id = s.patient_id and s.specimen_id in ".
		"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
		"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.ts DESC LIMIT $offset,$cap";
	
	}
	
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getObject($record);
			
		}
	}
	return $patient_list;
}

function search_patients_by_id_count($q, $labsection = 0)
{
	# Searches for patients with similar name
	global $con;
	$q = mysql_real_escape_string($q, $con);
	
	if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
		if($labsection == 0){
			$query_string =
			"SELECT count(*) as val FROM patient ".
			"WHERE surr_id LIKE '$q'";
		} else {
			$query_string = "select count(distinct patient.patient_id) as val from patient, specimen ".
					"where patient.surr_id like '$q' and patient.patient_id = specimen.patient_id ".
					"and specimen.specimen_id in ".
					"(select specimen_id from specimen where specimen_type_id in ".
					"(select specimen_type_id from specimen_test where test_type_id in ".
					"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))";
		}	
	} else {
		
		if($labsection == 0){
			$query_string =
			"SELECT count(*) as val FROM patient ".
			"WHERE surr_id LIKE '$q' AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1)";
		} else {
			$query_string = "select count(distinct patient.patient_id) as val from patient, specimen ".
					"where patient.surr_id like '$q' and patient.patient_id = specimen.patient_id ".
					" AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1)".
					" and specimen.specimen_id in ".
					"(select specimen_id from specimen where specimen_type_id in ".
					"(select specimen_type_id from specimen_test where test_type_id in ".
					"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))";
		}
		
		
	}
	
	
	
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $resultset['val'];
}

function search_patients_by_name($q, $labsection = 0,$c="")
{
	# Searches for patients with similar name
	global $con;
	$q = mysql_real_escape_string($q, $con);
	if(empty($c))
		$q.='%';
    else	
		$q=str_replace('[pq]',$q,$c);

	if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
	
	if($labsection == 0){
		$query_string = 
		"SELECT * FROM patient ".
		"WHERE name LIKE '$q' ORDER BY name ASC";
	} else {
		$query_string =
		"select distinct p.* from patient p, specimen s where ".
		"p.name LIKE '$q' and p.patient_id = s.patient_id and s.specimen_id in ".
		"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
		"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.name ASC";
	
	}
	} else {
		if($labsection == 0){
			$query_string =
			"SELECT * FROM patient ".
			"WHERE name LIKE '$q'  AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) ORDER BY name ASC";
		} else {
			$query_string =
			"select distinct p.* from patient p, specimen s where ".
			"p.name LIKE '$q'  AND p.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) and p.patient_id = s.patient_id and s.specimen_id in ".
			"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
			"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.name ASC";
		
		}
	}			
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getObject($record);
			
		}
	}
	
	return $patient_list;
}

function search_patients_by_name_dyn($q, $cap, $counter, $c="", $labsection = 0)
{
	# Searches for patients with similar name
	global $con;
        $offset = $cap * ($counter - 1);
	$q = mysql_real_escape_string($q, $con);
	if(empty($c))
		$q.='%';
    else	
		$q=str_replace('[pq]',$q,$c);
	//echo "[]".$labsection;
	$user = get_user_by_id($_SESSION['user_id']);
	
	if(! is_admin_check($user)){
	if($labsection == 0){
		$query_string = 
		"SELECT * FROM patient  ".
		"WHERE name LIKE '$q' AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) ORDER BY name ASC LIMIT $offset,$cap";
	} else {
		$query_string =
		"select distinct p.* from patient p, specimen s where ".
		"p.name LIKE '$q' AND p.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) and p.patient_id = s.patient_id and s.specimen_id in ".
		"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
		"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.name ASC LIMIT $offset,$cap";
	//;
	}
	} else {
		if($labsection == 0){
			$query_string =
			"SELECT * FROM patient ".
			"WHERE name LIKE '$q' ORDER BY name ASC LIMIT $offset,$cap";
		} else {
			$query_string =
			"select distinct p.* from patient p, specimen s where ".
			"p.name LIKE '$q' and p.patient_id = s.patient_id and s.specimen_id in ".
			"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
			"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.name ASC LIMIT $offset,$cap";
			//;
		}
	}
	//;	
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getObject($record);
			
		}
	}
	return $patient_list;
}

function search_patients_by_name_count($q, $labsection = 0,$c="")
{
	# Searches for patients with similar name
	global $con;
	$q = mysql_real_escape_string($q, $con);
	if(empty($c))
		$q.='%';
    else	
		$q=str_replace('[pq]',$q,$c);
		
	if(! is_admin_check(get_user_by_id($_SESSION['user_id']))){
		if($labsection == 0){
			$query_string =
			"SELECT count(*) as val FROM patient  ".
			"WHERE name LIKE '$q' AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1)";
		} else {
			$query_string =
			"select count(distinct p.patient_id) as val from patient p, specimen s where ".
			"p.name LIKE '$q' AND p.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) and p.patient_id = s.patient_id and s.specimen_id in ".
			"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
			"(select test_type_id as lab_section from test_type where test_category_id = '$labsection')))";

		}
	} else {
		if($labsection == 0){
			$query_string =
			"SELECT count(*) as val FROM patient ".
			"WHERE name LIKE '$q'";
		} else {
			$query_string =
			"select count(distinct p.patient_id) as val from patient p, specimen s where ".
			"p.name LIKE '$q' and p.patient_id = s.patient_id and s.specimen_id in ".
			"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
			"(select test_type_id as lab_section from test_type where test_category_id = '$labsection')))";
			
		}
	}
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	//$res = implode(",",$resultset);
	return $resultset['val'];
	//return $res;
}

function search_patients_by_addlid($q, $labsection = 0)
{
	global $con;
	$q = mysql_real_escape_string($q, $con);
	# Searches for patients with similar addl ID
	
	if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
		
	if($labsection == 0){
		$query_string = 
		"SELECT * FROM patient ".
		"WHERE addl_id LIKE '%$q%'";
	} else {
		$query_string =
		"select distinct p.* from patient p, specimen s where ".
		"p.addl_id LIKE '%$q%' and p.patient_id = s.patient_id and s.specimen_id in ".
		"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
		"(select test_type_id as lab_section from test_type where test_category_id = '$labsection')))";
	
	}
	} else {
		if($labsection == 0){
			$query_string =
			"SELECT * FROM patient ".
			"WHERE addl_id LIKE '%$q%'  AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1)";
		} else {
			$query_string =
			"select distinct p.* from patient p, specimen s where ".
			"p.addl_id LIKE '%$q%'  AND p.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) and p.patient_id = s.patient_id and s.specimen_id in ".
			"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
			"(select test_type_id as lab_section from test_type where test_category_id = '$labsection')))";
		
		}	
	}
	//;
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getObject($record);
			
		}
	}
	return $patient_list;
}

function search_patients_by_addlid_dyn($q, $cap, $counter, $labsection = 0)
{
	# Searches for patients with similar name
	global $con;
        $offset = $cap * ($counter - 1);
	$q = mysql_real_escape_string($q, $con);
	
	if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
	
	if($labsection == 0){
		$query_string = 
		"SELECT * FROM patient ".
		"WHERE addl_id LIKE '%$q%' ORDER BY addl_id ASC LIMIT $offset,$cap";
	} else {
		$query_string =
		"select distinct p.* from patient p, specimen s where ".
		"p.addl_id LIKE '%$q%' and p.patient_id = s.patient_id and s.specimen_id in ".
		"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
		"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.addl_id ASC LIMIT $offset,$cap";
	
	}
	} else{
		if($labsection == 0){
			$query_string =
			"SELECT * FROM patient ".
			"WHERE addl_id LIKE '%$q%' AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) ORDER BY addl_id ASC LIMIT $offset,$cap";
		} else {
			$query_string =
			"select distinct p.* from patient p, specimen s where ".
			"p.addl_id LIKE '%$q%' AND p.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) and p.patient_id = s.patient_id and s.specimen_id in ".
			"(select specimen_id from specimen where specimen_type_id in (select specimen_type_id from specimen_test where test_type_id in ".
			"(select test_type_id as lab_section from test_type where test_category_id = '$labsection'))) ORDER BY p.addl_id ASC LIMIT $offset,$cap";
		
		}
	}
	//;
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getObject($record);
				
		}
	}
	return $patient_list;
}

function search_patients_by_addlid_count($q, $labsection = 0)
{
	# Searches for patients with similar name
	global $con;
	$q = mysql_real_escape_string($q, $con);
	
	if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
	
	if($labsection == 0){
		$query_string = 
		"SELECT count(*) as val FROM patient ".
		"WHERE addl_id LIKE '%$q%'";
	}
	else {
		$query_string = "select count(distinct patient.patient_id) as val from patient, specimen ".
				"where patient.addl_id LIKE '%$q%' and patient.patient_id = specimen.patient_id ".
				"and specimen.specimen_id in ".
				"(select specimen_id from specimen where specimen_type_id in ".
				"(select specimen_type_id from specimen_test where test_type_id in ".
				"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))";
	}
	} else {
		if($labsection == 0){
			$query_string =
			"SELECT count(*) as val FROM patient ".
			"WHERE addl_id LIKE '%$q%' AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1)";
		}
		else {
			$query_string = "select count(distinct patient.patient_id) as val from patient, specimen ".
					"where patient.addl_id LIKE '%$q%' AND patient.patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) and patient.patient_id = specimen.patient_id ".
					"and specimen.specimen_id in ".
					"(select specimen_id from specimen where specimen_type_id in ".
					"(select specimen_type_id from specimen_test where test_type_id in ".
					"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))";
		}	
	}
	//;
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $resultset['val'];
}

function search_patients_by_dailynum($q, $labsection = 0)
{
	global $con;
	$q = mysql_real_escape_string($q, $con);
	# Searches for patients with similar daily number

	if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
	if($labsection == 0){
		$query_string = "SELECT DISTINCT patient_id FROM specimen WHERE daily_num LIKE '%".$q."' ORDER BY date_collected DESC LIMIT 20";
	} else {
	$query_string = "select distinct patient_id from specimen ".
			"where specimen.daily_num like '%$q' ".
			"and specimen.specimen_id in ".
				"(select specimen_id from specimen where specimen_type_id in ".
				"(select specimen_type_id from specimen_test where test_type_id in ".
				"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))".
				"  ORDER BY date_collected DESC LIMIT 20";
	}
	} else {
		if($labsection == 0){
			$query_string = "SELECT DISTINCT patient_id FROM specimen WHERE daily_num LIKE '%".$q."' AND patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) ORDER BY date_collected DESC LIMIT 20";
		} else {
			$query_string = "select distinct patient_id from specimen ".
					"where specimen.daily_num like '%$q'  AND patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) ".
					"and specimen.specimen_id in ".
					"(select specimen_id from specimen where specimen_type_id in ".
					"(select specimen_type_id from specimen_test where test_type_id in ".
					"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))".
					"  ORDER BY date_collected DESC LIMIT 20";
		}	
	}
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getById($record['patient_id']);
			
		}
	}
	return $patient_list;
}

function search_patients_by_dailynum_dyn($q, $cap, $counter, $labsection = 0)
{
	# Searches for patients with similar name
	global $con;
        $offset = $cap * ($counter - 1);
	$q = mysql_real_escape_string($q, $con);
	
	if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
	if($labsection == 0){
		$query_string = 
		"SELECT DISTINCT patient_id FROM specimen WHERE daily_num LIKE '%".$q."' ORDER BY date_collected DESC LIMIT $offset,$cap";
	} else {
		$query_string = "select distinct patient_id from specimen ".
			"where specimen.daily_num like '%$q' ".
			"and specimen.specimen_id in ".
				"(select specimen_id from specimen where specimen_type_id in ".
				"(select specimen_type_id from specimen_test where test_type_id in ".
				"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))".
				"  ORDER BY date_collected DESC LIMIT $offset,$cap";
	
	}
	} else {
		if($labsection == 0){
			$query_string =
			"SELECT DISTINCT patient_id FROM specimen WHERE daily_num LIKE '%".$q."' AND patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1)  ORDER BY date_collected DESC LIMIT $offset,$cap";
		} else {
			$query_string = "select distinct patient_id from specimen ".
					"where specimen.daily_num like '%$q'  AND patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) ".
					"and specimen.specimen_id in ".
					"(select specimen_id from specimen where specimen_type_id in ".
					"(select specimen_type_id from specimen_test where test_type_id in ".
					"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))".
					"  ORDER BY date_collected DESC LIMIT $offset,$cap";
		
		}
	}
	$resultset = query_associative_all($query_string, $row_count);
        $patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getById($record['patient_id']);
			
		}
	}
	return $patient_list;
}

function search_patients_by_dailynum_count($q, $labsection = 0)
{
	# Searches for patients with similar name
	global $con;
	$q = mysql_real_escape_string($q, $con);
	
	if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
	if($labsection == 0){
		$query_string = 
		"SELECT count(DISTINCT patient_id) as val FROM specimen WHERE daily_num LIKE '%$q'";
	} else {
		$query_string = "select count(distinct specimen.patient_id) as val from specimen ".
				"where specimen.daily_num like '%$q' ".
				"and specimen.specimen_id in ".
				"(select specimen_id from specimen where specimen_type_id in ".
				"(select specimen_type_id from specimen_test where test_type_id in ".
				"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))";
	} } else {
		if($labsection == 0){
			$query_string =
			"SELECT count(DISTINCT patient_id) as val FROM specimen WHERE daily_num LIKE '%$q'  AND patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1)";
		} else {
		$query_string = "select count(distinct specimen.patient_id) as val from specimen ".
				"where specimen.daily_num like '%$q'  AND patient_id NOT IN (select r_id from removal_record where category='patient' AND removal_record.status=1) ".
				"and specimen.specimen_id in ".
				"(select specimen_id from specimen where specimen_type_id in ".
				"(select specimen_type_id from specimen_test where test_type_id in ".
				"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))";
		}	
	}
	
	
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $resultset['val'];
}

function search_specimens_by_id($q)
{
	global $con;
	$q = mysql_real_escape_string($q, $con);
	# Searches for specimens with similar ID
	$query_string = 
		"SELECT * FROM specimen ".
		"WHERE specimen_id LIKE '%$q%'";
	$resultset = query_associative_all($query_string, $row_count);
	$specimen_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$specimen_list[] = Specimen::getObject($record);
		}
	}
	return $specimen_list;
}

function search_specimens_by_addlid($q)
{
	global $con;
	$q = mysql_real_escape_string($q, $con);
	# Searches for specimens with similar addl ID
	$query_string = 
		"SELECT * FROM specimen ".
		"WHERE aux_id LIKE '%$q%'";
	$resultset = query_associative_all($query_string, $row_count);
	$specimen_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$specimen_list[] = Specimen::getObject($record);
		}
	}
	return $specimen_list;
}

function search_specimens_by_patient_id($patient_id)
{
	global $con;
	$patient_id = mysql_real_escape_string($patient_id, $con);
	# Searches for specimens by patient ID
	$query_string = 
		"SELECT sp.* FROM specimen sp, patient p ".
		"WHERE sp.patient_id=p.patient_id ".
		"AND p.patient_id = '".$patient_id."'";// OR p.patient_id LIKE '%".$patient_id."%'";
	$resultset = query_associative_all($query_string, $row_count);
	$specimen_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$specimen_list[] = Specimen::getObject($record);
		}
	}
	return $specimen_list;
}

function search_specimens_by_patient_name($patient_name)
{
	# Searches for specimens by patient name
	global $con;
	$patient_name = mysql_real_escape_string($patient_name, $con);
	$query_string = 
		"SELECT sp.* FROM specimen sp, patient p ".
		"WHERE sp.patient_id=p.patient_id ".
		"AND p.name LIKE '%$patient_name%' ";
	$resultset = query_associative_all($query_string, $row_count);
	$specimen_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$specimen_list[] = Specimen::getObject($record);
		}
	}
	return $specimen_list;
}

function search_specimens_by_session($q)
{
	global $con;
	$q = mysql_real_escape_string($q, $con);
	# Searched for specimens in a single session
	$query_string =
		"SELECT * FROM specimen ".
		"WHERE session_num LIKE '%$q%'";
	$resultset = query_associative_all($query_string, $row_count);
	$specimen_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$specimen_list[] = Specimen::getObject($record);
		}
	}
	return $specimen_list;
}

function search_specimens_by_session_exact($q)
{
	global $con;
	$q = mysql_real_escape_string($q, $con);
	# Searched for specimens in a single session
	$query_string =
		"SELECT * FROM specimen ".
		"WHERE session_num='$q'";
	$resultset = query_associative_all($query_string, $row_count);
	$specimen_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$specimen_list[] = Specimen::getObject($record);
		}
	}
	return $specimen_list;
}

function search_specimens_by_dailynum($q)
{
	global $con;
	$q = mysql_real_escape_string($q, $con);
	# Searched for specimens in a single session
	$query_string =
		"SELECT * FROM specimen ".
		"WHERE daily_num LIKE '%-$q' ORDER BY daily_num DESC LIMIT 5";
	$resultset = query_associative_all($query_string, $row_count);
	$specimen_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$specimen_list[] = Specimen::getObject($record);
		}
	}
	return $specimen_list;
}

function get_patients_by_name_or_id($search_term)
{
	global $con;
	$search_term = mysql_real_escape_string($search_term, $con);
	# Searches for patients with similar PID or Name
	# Called from patient_fetch.php
	$query_string = 
		"SELECT * FROM patient ".
		"WHERE patient_id LIKE '%$search_term%' ".
		"OR name LIKE '%$search_term%'";
	$resultset = query_associative_all($query_string, $row_count);
	$patient_list = array();
	if(count($resultset) > 0)
	{
		foreach($resultset as $record)
		{
			$patient_list[] = Patient::getObject($record);
		}
	}
	return $patient_list;
}

function update_patient($modified_record)
{
	# Updates an existing patient record
	# Called from ajax/patient_update.php
	$myFile = "../../local/myFile.txt";
$fh = fopen($myFile, 'a') or die("can't open file");
$pid = $modified_record->patientId;
	$current_record = get_patient_by_id($pid);
	if($modified_record->name == "")
		$modified_record->name = $current_record->name;
	if(trim($modified_record->age) == "" || is_nan($modified_record->age))
		$modified_record->age=0;
	$query_string = 
		"UPDATE patient SET ".
		"name='$modified_record->name', ".
		"surr_id='$modified_record->surrogateId', ".
		"addl_id='$modified_record->addlId', ".
		"sex='$modified_record->sex', ";
	if($modified_record->age != 0)
	{
		$today = date("Y-m-d");
		$today_parts = explode("-", $today);
		# Find year of birth based on supplied age value
		if($modified_record->age < 0)
		{
			# Age was specified in months
			$timestamp = mktime(0, 0, 0, $today_parts[1]-(-1*$modified_record->age), $today_parts[2], $today_parts[0]);
			$year = date("Y", $timestamp);
			$month = date("m", $timestamp);
			$dob = "";
			$modified_record->partialDob = $year."-".$month;
		}
		else
		{
			# Age specified in years
			$timestamp = mktime(0, 0, 0, $today_parts[1], $today_parts[2], $today_parts[0]-$modified_record->age);
			$year = date("Y", $timestamp);
			$dob = "";
			$modified_record->partialDob = $year;
		}
	}
	$modified_record->age = 0;
	if($modified_record->partialDob != "")
		$query_string .= "age=$modified_record->age, partial_dob='$modified_record->partialDob' ";
	else if($modified_record->dob != "")
		$query_string .= "age=$modified_record->age, partial_dob='', dob='$modified_record->dob' ";
	$query_string .= "WHERE patient_id=$pid";
	fwrite($fh, $query_string);
fclose($fh);
	query_blind($query_string);
	# Addition of custom fields: done from calling function/page	
	return true;
}

#
# Functions for handling specimen/test-related data
#

function get_pending_tests_by_type($test_type_id)
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	# Returns a list of pending tests for a given test type
	$query_string =
		"SELECT * FROM test WHERE test_type_id=$test_type_id ".
		"AND result=''";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = Test::getObject($record);
	}
	return $retval;
}

function get_pending_tests_by_type_date($test_type_id, $date_from,$date_to)
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$date_from_array=explode("-",$date_from);
	$date_to_array=explode("-",$date_to);
	# Returns a list of pending tests for a given test type
	$query_string =
		"SELECT * FROM test WHERE test_type_id=$test_type_id ".
		"AND ts >= '$date_from_array[0]-$date_from_array[1]-$date_from_array[2] 00:00:00' ".
		"AND ts <='$date_to_array[0]-$date_to_array[1]-$date_to_array[2] 23:59:59'".
		"AND result=''";
		
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = Test::getObject($record);
	}
	return $retval;
}

function get_tests_by_specimen_id($specimen_id)
{
	global $con;
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	# Returns list of tests scheduled for this given specimen
	$query_string = "SELECT * FROM test WHERE specimen_id=$specimen_id";
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
	$resultset = query_associative_all($query_string, $row_count);
	DbUtil::switchRestore($saved_db);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = Test::getObject($record);
	}
	return $retval;
}

function get_completed_tests_by_type($test_type_id, $date_from="", $date_to="")
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	# Returns list of tests of a particular type,
	# that were registered between date_from and date_to and completed
	$query_string = "";
	if($date_from == "" || $date_to == "")
	{
		if($test_type_id == 0)
		{
			$query_string = 
				"SELECT UNIX_TIMESTAMP(t.ts) as ts, t.specimen_id, UNIX_TIMESTAMP(s.date_collected) as date_collected ".
				"FROM test t, specimen s ".
				"WHERE t.result <> '' ".
				"AND s.specimen_id=t.specimen_id ORDER BY s.date_collected";
		}
		else
		{
			$query_string = 
				"SELECT UNIX_TIMESTAMP(t.ts) as ts, t.specimen_id, UNIX_TIMESTAMP(s.date_collected) as date_collected ".
				"FROM test t, specimen s ".
				"WHERE s.test_type_id=$test_type_id ".
				"AND t.result <> '' ".
				"AND s.specimen_id=t.specimen_id ORDER BY s.date_collected";
		}
	}
	else
	{
		if($test_type_id == 0)
		{
			$query_string = 
				"SELECT UNIX_TIMESTAMP(t.ts) as ts, t.specimen_id, UNIX_TIMESTAMP(s.date_collected) as date_collected ".
				"FROM test t, specimen s ".
				"WHERE t.result <> '' ".
				"AND s.specimen_id=t.specimen_id ".
				"AND s.date_collected between '$date_from' AND '$date_to' ORDER BY s.date_collected";
		}
		else
		{
			$query_string = 
				"SELECT UNIX_TIMESTAMP(t.ts) as ts, t.specimen_id, UNIX_TIMESTAMP(s.date_collected) as date_collected ".
				"FROM test t, specimen s ".
				"WHERE t.test_type_id=$test_type_id ".
				"AND t.result <> '' ".
				"AND s.specimen_id=t.specimen_id ".
				"AND s.date_collected between '$date_from' AND '$date_to' ORDER BY s.date_collected";
		}
	}
	$resultset = query_associative_all($query_string, $row_count);
	# Entries for {ts, specimen_id, date_collected} are returned
	return $resultset;
}

function get_pendingtat_tests_by_type($test_type_id, $date_from="", $date_to="")
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	# Returns list of pending tests of a particular type,
	# that were registered between date_from and date_to and not completed
	$query_string = "";
	if($date_from == "" || $date_to == "")
	{
		if($test_type_id == 0)
		{
			$query_string = 
				"SELECT UNIX_TIMESTAMP(t.ts) as ts, t.specimen_id, UNIX_TIMESTAMP(s.date_collected) as date_collected ".
				"FROM test t, specimen s ".
				"WHERE t.result = '' ".
				"AND s.specimen_id=t.specimen_id ORDER BY s.date_collected";
		}
		else
		{
			$query_string = 
				"SELECT UNIX_TIMESTAMP(t.ts) as ts, t.specimen_id, UNIX_TIMESTAMP(s.date_collected) as date_collected ".
				"FROM test t, specimen s ".
				"WHERE s.test_type_id=$test_type_id ".
				"AND t.result = '' ".
				"AND s.specimen_id=t.specimen_id ORDER BY s.date_collected";
		}
	}
	else
	{
		if($test_type_id == 0)
		{
			$query_string = 
				"SELECT UNIX_TIMESTAMP(t.ts) as ts, t.specimen_id, UNIX_TIMESTAMP(s.date_collected) as date_collected ".
				"FROM test t, specimen s ".
				"WHERE t.result = '' ".
				"AND s.specimen_id=t.specimen_id ".
				"AND s.date_collected between '$date_from' AND '$date_to' ORDER BY s.date_collected";
		}
		else
		{
			$query_string = 
				"SELECT UNIX_TIMESTAMP(t.ts) as ts, t.specimen_id, UNIX_TIMESTAMP(s.date_collected) as date_collected ".
				"FROM test t, specimen s ".
				"WHERE t.test_type_id=$test_type_id ".
				"AND t.result = '' ".
				"AND s.specimen_id=t.specimen_id ".
				"AND s.date_collected between '$date_from' AND '$date_to' ORDER BY s.date_collected";
		}
	}
	$resultset = query_associative_all($query_string, $row_count);
	# Entries for {ts, specimen_id, date_collected} are returned
	return $resultset;
}

function get_specimens_by_patient_id($patient_id, $labsection =0)
{
	global $con;
	$patient_id = mysql_real_escape_string($patient_id, $con);
	# Returns list of specimens registered for the given patient
	if($labsection == 0){
		$query_string = 
		"SELECT * FROM specimen WHERE patient_id=$patient_id ORDER BY date_collected DESC";
	} else {
		$query_string = 
		"SELECT DISTINCT s.* from specimen s, test t, test_type tt ".
		"WHERE patient_id=$patient_id ".
		"AND s.specimen_id=t.specimen_id AND t.test_type_id=tt.test_type_id AND tt.test_category_id=$labsection ".
		"ORDER BY s.date_collected DESC";
	}
		//;
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
	$resultset = query_associative_all($query_string, $row_count);
	DbUtil::switchRestore($saved_db);
	$retval = array();
	foreach($resultset as $record)
	{
		
		$retval[] = Specimen::getObject($record);
	}
	//echo $retval[0]->specimenId;
	return $retval;
}

function add_specimen($specimen)
{
	# Adds a new specimen record in DB
	$query_string = 
		"INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, ".
		"session_num, time_collected, report_to, doctor, referred_to_name, referred_from_name, daily_num, site_id) VALUES ( $specimen->specimenId, $specimen->patientId, $specimen->specimenTypeId, ".
		"'$specimen->dateCollected', '$specimen->dateRecvd', $specimen->userId, $specimen->statusCodeId, $specimen->referredTo, '$specimen->comments', ".
		"'$specimen->auxId', '$specimen->sessionNum', '$specimen->timeCollected', $specimen->reportTo, '$specimen->doctor', '$specimen->referredToName', '$specimen->referredFromName',  '$specimen->dailyNum', '$specimen->site_id' )";
	//;
	query_insert_one($query_string);
	return $specimen->specimenId;
}

function check_specimen_id($sid)
{
	global $con;
	$sid = mysql_real_escape_string($sid, $con);
	# Checks if specimen ID already exists in DB, and returns true/false accordingly
	# Called from ajax/specimen_check_id.php
	$query_string = "SELECT specimen_id FROM specimen WHERE specimen_id=$sid LIMIT 1";
	$retval = query_associative_one($query_string);
	if($retval == null)
		return false;
	else
		return true;
}

function add_test($test, $testId=null)
{
	# Adds a new test record in DB
	if( $testId == null)
		$testId = bcadd(get_max_test_id(),1);
	$query_string = 
		"INSERT INTO `test` ( test_id, specimen_id, test_type_id, result, comments, verified_by, user_id ) ".
		"VALUES ( $testId, $test->specimenId, $test->testTypeId, '$test->result', '$test->comments', 0, $test->userId )";
	query_insert_one($query_string);
	return get_last_insert_id();
}

function add_test_random($test)
{
	# Adds a new test record in DB
	$query_string = 
		"INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			$test->testTypeId,  
			$test->specimenId, 
			'$test->result', 
			'$test->comments', 
			0, 
			$test->userId,
			'$test->ts' )";
	query_insert_one($query_string);
	return get_last_insert_id();
}

function get_test_entry($specimen_id, $test_type_id)
{
	global $con;
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	# Returns the test_id primary key
	$query_string = 
		"SELECT * FROM test ".
		"WHERE specimen_id=$specimen_id ".
		"AND test_type_id=$test_type_id LIMIT 1";
	$record = query_associative_one($query_string);
	$retval = Test::getObject($record);
	return $retval;
}

function add_test_result($test_id, $result_entry, $comments="", $specimen_id="", $user_id=0, $ts="", $hash_value)
{
	# Adds results for a test entry
	$curent_ts = "";
	if($ts == "")
		$current_ts = date("Y-m-d H:i:s");
	else
		$current_ts = $ts;
		//$current_ts = date("Y-m-d H:i:s" , $ts);
	
	# Append patient hash value to result field
	$result_field = $result_entry.$hash_value;
	# Add entry to DB
	$query_string = 
		"UPDATE `test` SET result='$result_field', ".
		"comments='$comments', ".
		"user_id=$user_id, ".
		"ts='$current_ts' ".
		"WHERE test_id=$test_id ";
	
	query_blind($query_string);
	# If specimen ID was passed, update its status
	if($specimen_id != "")
		update_specimen_status($specimen_id);
}

function update_specimen_status($specimen_id)
{
	global $con;
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	# Checks if all test results for the specimen have been entered,
	# and updates specimen status accordingly
	$test_list = get_tests_by_specimen_id($specimen_id);
	foreach($test_list as $test)
	{
		if($test->isPending() === true)
		{
			# This test result is pending
			return;
		}
	}
	# Update specimen status to complete
	$status_code = Specimen::$STATUS_DONE;
	set_specimen_status($specimen_id, $status_code);
}

function set_specimen_status($specimen_id, $status_code)
{
	global $con;
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	# Sets specimen status to specified status code
	# TODO: Link this to customized status codes in 'status_code' table
	$query_string = 
		"UPDATE `specimen` SET status_code_id=$status_code ".
		"WHERE specimen_id=$specimen_id";
	query_blind($query_string);
}

function get_specimen_status($specimen_id)
{
	global $con;
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	# Returns status of the given specimen
	# TODO: Link this to customized status codes in 'status_code' table
	$query_string = 
		"SELECT status_code_id FROM specimen ".
		"WHERE specimen_id=$specimen_id LIMIT 1";
	$record = query_associative_one($query_string);
	return $record['status_code_id'];
}

function get_specimen_by_id($specimen_id)
{
	global $con;
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	# Fetches a specimen record by specimen id
	$query_string = 
		"SELECT * FROM specimen WHERE specimen_id=$specimen_id LIMIT 1";
	//;
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return Specimen::getObject($record);
}

function get_specimen_by_id_api($specimen_id, $lab_config_id)
{
	global $con;
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	# Fetches a specimen record by specimen id
	$query_string =
	"SELECT * FROM specimen WHERE specimen_id=$specimen_id LIMIT 1";
	//;
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return Specimen::getObject($record);
}

function get_test_by_test_id_api($test_id, $lab_config_id)
{
	global $con;
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$test_id = mysql_real_escape_string($test_id, $con);
	$query_string =
	"SELECT * FROM test WHERE test_id=$test_id LIMIT 1";
	//." ";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return Test::getObject($record);
}

function get_specimens_by_session($session_num)
{
	global $con;
	$session_num = mysql_real_escape_string($session_num, $con);
	# Returns all specimens registered in this session
	$query_string = 
		"SELECT * FROM specimen ".
		"WHERE session_num='$session_num'";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
		$retval[] = Specimen::getObject($record);
	return $retval;
}

#
# Functions for adding lab configuration (site) related data
#

/*
* Checks if an administrator is present. If not, adds administrator to users table and returns id
*/
function checkAndAddAdmin($adminName, $labConfigId, $dev=0) {
	global $con;
	$labConfigId = mysql_real_escape_string($labConfigId, $con);
	$saved_db = DbUtil::switchToGlobal();
	if($dev == 0)
		$query_check = "SELECT  a.user_id, a.username, a.password,a.actualname, a.email, a.created_by, a.ts, a.lab_config_id, a.level, a.phone, a.lang_id, b.value as rwoptions 
					FROM user a, user_config b  WHERE a.user_id = b.user_id and b.parameter = 'rwoptions' and a.username like '$adminName'";
	else if($dev == 1)
		$query_check = "SELECT  a.user_id, a.username, a.password,a.actualname, a.email, a.created_by, a.ts, a.lab_config_id, a.level, a.phone, a.lang_id
					FROM user a WHERE a.lab_config_id = $labConfigId";

	$record = query_associative_one($query_check);
	
	if($record) {
		DbUtil::switchRestore($saved_db);
		return $record['user_id'];
	}
	else {
		$userId = $_SESSION['user_id'];
		$query_select = "SELECT max(user_id) AS maxUserId FROM user";
		$record = query_associative_one($query_select);
		$newAdminUserId = intval($record['maxUserId']) + 1;
		$query_insert = "INSERT INTO user (user_id, username, password, created_by, ts, lab_config_id, level, lang_id) ".
						"VALUES ($newAdminUserId, '$adminName', '18865bfdeed2fd380316ecde609d94d7285af83f', $userId, CURDATE(), '$labConfigId', 2, 'default') ";
		query_insert_one($query_insert);
		DbUtil::switchRestore($saved_db);
		return $newAdminUserId;
	}	
}

/* Checks if the lab admin user is added to user_config table or not and then adds it if it doesn't exist*/
function checkAndAddUserConfig($lab_admin_id){
	global $con;
	$saved_db = DbUtil::switchToGlobal();
	$userId = $_SESSION['user_id'];

	$query_check = "SELECT user_id from user_config where user_id=$lab_admin_id";
	$record = query_associative_one($query_check);
	
	if(!$record) {
		#this branch is taken when developers import a backup into their application from a country director's interface
		#query to insert into user_config
		$query_insert = "INSERT INTO user_config (user_id, level, parameter, value, created_by, created_on, modified_by, modified_on) ".
						"VALUES ($lab_admin_id, 2, 'rwoptions', '2,3,4,6,7', $userId, CURDATE(), $userId, CURDATE()) ";
		query_insert_one($query_insert);
	}
	
	DbUtil::switchRestore($saved_db);
	return;
}

function add_lab_config($lab_config, $dev=0)
{
	# Adds a new lab configuration to DB
	$saved_db = DbUtil::switchToGlobal();
	$query_check = "SELECT admin_user_id FROM lab_config WHERE lab_config_id = $lab_config->id";
	$record = query_associative_one($query_check);

	if($dev == 0){
		#This branch is taken when a new lab is created by a country director 
		# Adds a new lab configuration to DB
		$query_add_lab_config = 
			"INSERT INTO lab_config(name, location, admin_user_id, id_mode, lab_config_id, country) ".
			"VALUES ('$lab_config->name', '$lab_config->location', $lab_config->adminUserId, $lab_config->idMode, '$lab_config->id', '$lab_config->country')";
		query_insert_one($query_add_lab_config);
	}
	else if($dev == 1  && is_null($record)){
		# This branch is taken when an entry for lab in the config param doesn't exist in revamp db 
		# (for devs importing lab backups using country director's interface)
		$query_add_lab_config = 
			"INSERT INTO lab_config(admin_user_id, lab_config_id) ".
			"VALUES ($lab_config->adminUserId, $lab_config->id)";
		query_insert_one($query_add_lab_config);
	}
	else if($dev == 1 && (intval($record['admin_user_id']) != intval($lab_config->adminUserId))){
		# This branch is taken when a lab backup is imported by developers in country director's interface, 
		# and when an entry exists with an admin userid which is not the same as the one in lab config object param 
		#Update the admin user id for the lab config in the object param passed
		$query_update_lab_config = 
			"UPDATE lab_config ".
			"SET admin_user_id = $lab_config->adminUserId WHERE lab_config_id = $lab_config->id";
		query_update($query_update_lab_config);	
	}

	DbUtil::switchRestore($saved_db);
	return;
}

function add_lab_config_with_id($lab_config)
{
	# Adds a new lab configuration to DB, when ID already known
	$lab_config_id = $lab_config->id;
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$query_add_lab_config = 
		"INSERT INTO lab_config(lab_config_id, name, location, admin_user_id, id_mode) ".
		"VALUES ($lab_config->id, '$lab_config->name', '$lab_config->location', $lab_config->adminUserId, $lab_config->idMode)";
	query_insert_one($query_add_lab_config);
	foreach($lab_config->testList as $test_type_id)
	{
		# Add entry to 'lab_config_test_type' map table
		add_lab_config_test_type($lab_config_id, $test_type_id);
	}
	foreach($lab_config->specimenList as $specimen_type_id)
	{
		# Add entry to 'lab_config_specimen_type' map table
		add_lab_config_specimen_type($lab_config_id, $specimen_type_id);
	}
	DbUtil::switchRestore($saved_db);
	return $lab_config_id;
}

function enable_new_test($lab_config_id, $test_type_id)
{
    $saved_db = DbUtil::switchToLabConfigRevamp();
    $query_ins= 
					"INSERT INTO lab_config_test_type(lab_config_id, test_type_id) ".
					"VALUES ($lab_config_id, $test_type_id)";
    query_blind($query_ins);
    DbUtil::switchRestore($saved_db);
}

function update_lab_config($updated_entry, $updated_specimen_list=null, $updated_test_list=null)
{
	# Updates a lab configuration record
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"UPDATE lab_config ".
		"SET name='$updated_entry->name', ".
		"location='$updated_entry->location', ".
		"admin_user_id=$updated_entry->adminUserId, ".
		"id_mode=$updated_entry->idMode ".
		"WHERE lab_config_id=$updated_entry->id";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	if($updated_specimen_list != null)
	{
		# Update specimen types
		$existing_specimen_list = get_lab_config_specimen_types($updated_entry->id);
		## Add new specimen types
		foreach($updated_specimen_list as $specimen_type_id)
		{
			if(in_array($specimen_type_id, $existing_specimen_list))
			{
				# Entry already present
				# Continue
			}
			else
			{
				# Add specimen type entry in mapping table
				$query_ins= 
					"INSERT INTO lab_config_specimen_type(lab_config_id, specimen_type_id) ".
					"VALUES ($updated_entry->id, $specimen_type_id)";
				query_blind($query_ins);
			}
		}
		## Remove specimen types marked as deleted
		foreach($existing_specimen_list as $specimen_type_id)
		{
			if(in_array($specimen_type_id, $updated_specimen_list))
			{
				# Not marked for removal
				# Continue
			}
			else
			{
				# Remove specimen type entry from mapping table
				$query_del = 
					"DELETE FROM lab_config_specimen_type ".
					"WHERE lab_config_id=$updated_entry->id ".
					"AND specimen_type_id=$specimen_type_id";
				query_blind($query_del);	
			}
		}
	}
	if($updated_test_list != null)
	{
		# Update test types
		$existing_test_list = get_lab_config_test_types($updated_entry->id);
		## Add new test types
		foreach($updated_test_list as $test_type_id)
		{
			if(in_array($test_type_id, $existing_test_list))
			{
				# Entry already present
				# Continue
			}
			else
			{
				# Add test type entry in mapping table
				$query_ins= 
					"INSERT INTO lab_config_test_type(lab_config_id, test_type_id) ".
					"VALUES ($updated_entry->id, $test_type_id)";
				query_blind($query_ins);
			}
		}
		## Remove test types marked as deleted
		foreach($existing_test_list as $test_type_id)
		{
			if(in_array($test_type_id, $updated_test_list))
			{
				# Not marked for removal
				# Continue
			}
			else
			{
				# Remove test type entry from mapping table
				$query_del = 
					"DELETE FROM lab_config_test_type ".
					"WHERE lab_config_id=$updated_entry->id ".
					"AND test_type_id=$test_type_id";
				query_blind($query_del);
				# Remove worksheet config for this test type
				if($test_type_id != 0)
				{
					$saved_db2 = DbUtil::switchToLabConfig($updated_entry->id);
					$query_del2 = 
						"DELETE FROM report_config WHERE test_type_id=$test_type_id";
					query_delete($query_del2);
					DbUtil::switchRestore($saved_db2);
				}				
			}
		}
	}
	DbUtil::switchRestore($saved_db);
}
///////////////////////////////
//This is where the stock module all starts//
///////////////////////////////
function update_stocks_details($name,$lot_number,$expiry_date,$manu,$quant,$supplier,$entry_id, $cost)
{
$saved_db = DbUtil::switchToLabConfigRevamp();
$query_string = 
				"UPDATE stock_details SET name='$name',lot_number='$lot_number',expiry_date='$expiry_date',manufacturer='$manu',supplier='$supplier',current_quantity='$quant' , cost_per_unit='$cost' WHERE entry_id=$entry_id";
				query_update($query_string);
				DbUtil::switchRestore($saved_db);
}

function get_reagent_name()
{
$retval= array();
$saved_db = DbUtil::switchToLabConfigRevamp();
$query_string = "SELECT distinct(name) FROM stock_details ";
$resultset = query_associative_all($query_string, $row_count);
		//print $resultset[0];
		if($resultset!=null)
		{
		foreach($resultset as $record)
		{
		//echo $record['name'];
		$retval[]=$record['name'];
		}		
	}
				DbUtil::switchRestore($saved_db);
return $retval;
}

function get_stock_details($entry_id)
{
	$saved_db = DbUtil::switchToLabConfigRevamp();
	global $con;
	$entry_id = mysql_real_escape_string($entry_id, $con);
	$query_string = "SELECT name,lot_number,expiry_date,manufacturer,supplier,current_quantity,unit ,cost_per_unit FROM stock_details WHERE entry_id='$entry_id' ";
	$resultset = query_associative_one($query_string);
	if($resultset!=null)
	{
		$name=$resultset['name'];
		$lot_number=$resultset['lot_number'];
		$date=$resultset['expiry_date'];
		$manu=$resultset['manufacturer'];
		$supplier=$resultset['supplier'];
		$quant=$resultset['current_quantity'];
		$unit=$resultset['unit'];
		$cost=$resultset['cost_per_unit'];
		$retval=array($name,$lot_number,$manu,$quant,$date,$supplier,$unit,$cost);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function add_new_stock($name,$lot_number,$expiry_date,$manufacture,$supplier,$quantity_supplied,$unit , $cost_per_unit,$ts) {
	# Adds a new stock or update the quantity of the stock
	
	$saved_db = DbUtil::switchToLabConfigRevamp();
        # Find the entry_id (primary key)
	/*$query_string = "SELECT MAX(entry_id) as'entry_id'FROM stock_details";
	$record = query_associative_one($query_string);
	if($record == null || $record['entry_id'] == null)
	$entry_id=0;
	else
	$entry_id=$record['entry_id'];
        
        $current_ts = date("Y-m-d H:i:s" , $ts[$i]);
        
        $query_string = 
                "INSERT INTO stock_details(name,lot_number,expiry_date, manufacturer, quantity_ordered,quantity_supplied,current_quantity,supplier,unit,entry_id,cost_per_unit,date_of_reception, date_of_supply) ".
                "VALUES ('$name[$i]','$lot_number[$i]','$expiry_date[$i]', '$manufacture[$i]', '$quantity_supplied[$i]' ,'$quantity_supplied[$i]','$current_quantity','$supplier[$i]','$unit[$i]','$current_entry_id','$cost_per_unit[$i]', '$current_ts','$current_ts')";
        query_insert_one($query_string);**/
        
	$length= count($name);
	
	# Find the entry_id (primary key)
	$query_string = "SELECT MAX(entry_id) as'entry_id'FROM stock_details";
	$record = query_associative_one($query_string);
	if($record == null || $record['entry_id'] == null)
	$entry_id=0;
	else
	$entry_id=$record['entry_id'];
	
	for($i=0;$i<$length;$i++) {
		$current_entry_id=$entry_id+1+$i;
		if($name[$i]!="")
		{
			$query_string="SELECT current_quantity FROM stock_details WHERE name='$name[$i]'";
			$resultset = query_associative_all($query_string, $row_count);
			$current_quantity=$quantity_supplied[$i];
			if($resultset!=null) {
				foreach($resultset as $record )
					$current_quantity=$current_quantity+$record['current_quantity'];
				if($record['current_quantity']!=0) {
					$query_string = "UPDATE stock_details SET current_quantity=$current_quantity WHERE name= '$name[$i]'";
					query_update($query_string);
				}
		
			}
			
			# If same lot number then no need to add another entry into stock_details table
			$query_string="SELECT quantity_ordered, quantity_supplied, unit FROM stock_details WHERE name='$name[$i]' AND lot_number='$lot_number[$i]' AND manufacturer='$manufacture[$i]' AND supplier='$supplier[$i]' AND cost_per_unit=$cost_per_unit[$i] LIMIT 1";
			$resultset = query_associative_all($query_string,$row_count);
			$current_ts = date("Y-m-d H:i:s" , $ts[$i]);
			if($resultset==null) {
				$query_string = 
					"INSERT INTO stock_details(name,lot_number,expiry_date, manufacturer, quantity_ordered,quantity_supplied,current_quantity,supplier,unit,entry_id,cost_per_unit,date_of_reception, date_of_supply) ".
					"VALUES ('$name[$i]','$lot_number[$i]','$expiry_date[$i]', '$manufacture[$i]', '$quantity_supplied[$i]' ,'$quantity_supplied[$i]','$current_quantity','$supplier[$i]','$unit[$i]','$current_entry_id','$cost_per_unit[$i]', '$current_ts','$current_ts')";
				query_insert_one($query_string);
				$query_string=
					"INSERT INTO stock_content(name,current_quantity,date_of_use,lot_number,new_balance)".
					"VALUES('$name[$i]',0,'$current_ts','$lot_number[$i]','$current_quantity')";
				query_insert_one($query_string);
			}
			else {
				foreach($resultset as $record) {
					$quantity_ordered = $record['quantity_ordered'] + $current_quantity;
					$quantity_supplied = $record['quantity_supplied'] + $current_quantity;
					$unit= $record['unit'] + $unit[$i];
				}
				$query_string = "UPDATE stock_details SET quantity_ordered =$quantity_ordered, quantity_supplied=$quantity_supplied, unit=$unit, date_of_reception='$current_ts', ".
								"date_of_supply='$current_ts' WHERE name='$name[$i]' AND lot_number='$lot_number[$i]' AND manufacturer='$manufacture[$i]' AND supplier='$supplier[$i]' ".
								"AND cost_per_unit=$cost_per_unit[$i]";
				query_update($query_string);
			}
		}
		DbUtil::switchRestore($saved_db);
	}
}

function get_stock_count()
{
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = "SELECT name,current_quantity ,unit FROM stock_details GROUP BY name ";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset!=null){
		foreach($resultset as $record){
			$name=$record['name'];
			$quant=$record['current_quantity'];
			$unit=$record['unit'];
			$retval[]=array($name,$quant,$unit);
		}
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_stock_out_details()
{
$saved_db = DbUtil::switchToLabConfigRevamp();
$query_string = 
		"SELECT name,current_quantity,new_balance,date_of_use,lot_number,user_name FROM stock_content";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if($resultset!=null){
		foreach($resultset as $record)
		{
		$name=$record['name'];
		$lot_number=$record['lot_number'];
		$current_quantity=(int)$record['current_quantity'];
		$new_balance=(int)$record['new_balance'];
		$quantity=$new_balance-$current_quantity;
		$date_of_entry=$record['date_of_use'];
		$user=$record['user_name'];
		if($current_quantity==0)
		{
		$current_quantity=$quantity;
		$quantity=$quantity."(new stock)";
		
		}
		$retval[]= array($name,$lot_number,$quantity,$date_of_entry,$user,$current_quantity);	
		}
		}
		
		return $retval;
DbUtil::switchRestore($saved_db);
}

function get_current_inventory_byName($date_to,$date_from, $name)
{
	$saved_db = DbUtil::switchToLabConfigRevamp();
	global $con;
	$name = mysql_real_escape_string($name, $con);
	$query_string = 
		"SELECT name,new_balance,date_of_use, lot_number FROM stock_content WHERE date_of_use<='$date_to' AND date_of_use >= '$date_from' AND name='$name' ";
		$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset!=null){
		foreach($resultset as $record) {
			$name=$record['name'];
			$quantity=$record['new_balance'];
			$date_of_entry=$record['date_of_use'];
			$lot_number=$record['lot_number'];
		$retval[]= array( $name,$quantity,$date_of_entry, $lot_number);	
		}
	}
	return $retval;
	DbUtil::switchRestore($saved_db);

}

function get_current_inventory($date_to,$date_from) {
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"SELECT name,new_balance,date_of_use, lot_number FROM stock_content WHERE date_of_use<='$date_to' AND date_of_use >= '$date_from' ";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if($resultset!=null){
		foreach($resultset as $record)
		{
		$name=$record['name'];
		$quantity=$record['new_balance'];
		$date_of_entry=$record['date_of_use'];
		$lot_number=$record['lot_number'];
		$retval[]= array( $name,$quantity,$date_of_entry, $lot_number);	
		}
		}
		
		return $retval;
DbUtil::switchRestore($saved_db);

}

#Called from stock_edit to get data from stock_details
function get_stocks()
{
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"SELECT name,lot_number, manufacturer,current_quantity,expiry_date,supplier,unit,entry_id ,cost_per_unit, date_of_reception FROM stock_details ORDER BY name ASC, manufacturer ASC, lot_number ASC, date_of_reception DESC";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset!=null){
		foreach($resultset as $record) {
			$name=$record['name'];
			$manufacture=$record['manufacturer'];
			$lot_number=$record['lot_number'];
			$quantity=$record['current_quantity'];
			$expiry_date=$record['expiry_date'];
			$supplier=$record['supplier'];
			$unit=$record['unit'];
			$entry_id=$record['entry_id'];
			$cost=$record['cost_per_unit'];
			$date_of_reception = $record['date_of_reception'];
			$retval[]= array($name, $lot_number,$manufacture,$quantity,$expiry_date,$supplier,$unit,$entry_id ,$cost, $receive_date);	
		}
	}
	DbUtil::switchRestore($saved_db);		
	return $retval;
}

function get_entry_ids()
{
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"SELECT entry_id  FROM stock_details ORDER BY entry_id ";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset!=null){
		foreach($resultset as $record) {
			$retval[]=$record['entry_id'];
		}
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function update_stocks($name, $lot_number, $quant, $receiver, $remarks, $ts)
{
	global $con;
	$name = mysql_real_escape_string($name, $con);
	$lot_number = mysql_real_escape_string($lot_number, $con);
	$quant = mysql_real_escape_string($quant, $con);
	$receiver = mysql_real_escape_string($receiver, $con);
	$remarks = mysql_real_escape_string($remarks, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$current_ts = date("Y-m-d H:i:s" , $ts);
	$query_string = 
		"SELECT current_quantity, quantity_supplied, quantity_used, used, user_name, receiver, remarks FROM stock_details WHERE name='$name' and lot_number='$lot_number'";
	$record = query_associative_one($query_string);
	
	if($record!=null) {
		$current_quantity=(int)$record['current_quantity'];
		$quantity_supplied=$record['quantity_supplied'];
		$quantity_used=$record['quantity_used'];
		$use=$record['used'];
		$username=$record['user_name'];
		$receiver_old=$record['receiver'];
		$remarks_old=$record['remarks'];
				
		$quantity_supplied_integer=(int)$quantity_supplied;
		$quantity_used_integer=(int)$quantity_used;
		$quant_integer=(int)$quant;
		
		$quant_finally_used=$quant_integer+$quantity_used_integer;
		$new_current_quant=$current_quantity-$quant_integer;
		$user_name=get_username_by_id($_SESSION['user_id']);
		
		#Checking to see if first entry or not and then appending or creating
		if($use=="") 
			$use_new=$current_ts.":".$quantity_integer;	
		else
			$use_new=$use.",".$current_ts.":".$quantity_integer;
			
		if($receiver=="")
			$receiver_new=$receiver;
		else
			$receiver_new=$receiver_old.",".$receiver;
			
		if($remarks=="")
			$remarks_new=$remarks;
		else
			$remarks_new=$remarks_old.",".$remarks;
			
		#Checking to see that the quantity is present in DB	
		if($quant_finally_used<=$quantity_supplied_integer) { 
			$quant_final=$current_quantity-$quant_integer;
			//$query_string = 
				// "INSERT INTO stock_content(name, current_quantity,lot_number, receiver ,remarks ,new_balance ,date_of_use,user_name) ".
				// "VALUES ('$name', '$quant_final' ,'$lot_number','$receiver', '$remarks','$new_current_quant','$current_ts' , '$user_name')";
			//query_insert_one($query_string);
			
			$query_string = 
				"UPDATE stock_details SET current_quantity=$quant_final WHERE name= '$name'";
			query_update($query_string);
			$query_string = 
				"UPDATE stock_details SET quantity_used=$quant_finally_used, used='$use_new', receiver='$receiver_new', remarks='$remarks_new' ".
				"WHERE name= '$name' and lot_number='$lot_number'";
			query_update($query_string);
	
			DbUtil::switchRestore($saved_db);
			return 1;
		}
		else{
			DbUtil::switchRestore($saved_db);
			return -1;
		}
		
	}
}

/////////////////////////////////
// This is add currency module //
///////////////////////////////// 
function add_currency_lab_config($lab_config_id, $new_currency)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_string = 
			"select count(*) as currencyCount from currency_conversion where currencyb='$new_currency' limit 1";
	$record = query_associative_one($query_string);
	$retval = $record['currencyCount'];
	if($retval > 0){
		DbUtil::switchRestore($saved_db);
		return 0;
	} else {
		$date_updated = date("Y-m-d");
		$query_string = "select count(*) as currencyCount from currency_conversion";
		$record = query_associative_one($query_string);
		$retval = $record['currencyCount'];
		if($retval > 0){
		$query_string = "insert into currency_conversion (currencya, currencyb, exchangerate, updatedts) 
		values ('$new_currency','$new_currency', 1, '$date_updated')";
		query_insert_one($query_string);
		} else {
			$query_string = "insert into currency_conversion (currencya, currencyb, exchangerate, updatedts, flag1)
			values ('$new_currency','$new_currency', 1, '$date_updated', 1)";
			query_insert_one($query_string);
		}
		DbUtil::switchRestore($saved_db);
		return 1;
	}
}

/////////////////////////////////
// This is add currency rate module //
///////////////////////////////// 

function add_currency_rate_lab_config($lab_config_id, $default_currency, $new_currency, $exchange_rate)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_string =
	"select count(*) as currencyCount from currency_conversion where currencya='$default_currency' && currencyb='$new_currency' limit 1";
	$record = query_associative_one($query_string);
	$retval = $record['currencyCount'];
	$date_updated = date("Y-m-d");
	if($retval > 0){
	$query_string = "update currency_conversion set exchangerate='$exchange_rate', updatedts='$date_updated' where currencya='$default_currency' && currencyb='$new_currency';
	";
	query_update($query_string);
	DbUtil::switchRestore($saved_db);
	return 0;
	} else {
	$query_string = "insert into currency_conversion (currencya, currencyb, exchangerate, updatedts)
	values ('$default_currency','$new_currency', '$exchange_rate', '$date_updated')";
	query_insert_one($query_string);
	DbUtil::switchRestore($saved_db);
	return 1;
	}
}

function delete_currency_rate_lab_config($lab_config_id, $default_currency, $delete_currency)
{
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	global $con;
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_string =
	"delete from currency_conversion where currencya='$default_currency' && currencyb='$delete_currency'";
	query_blind($query_string);
	return 1;
}
/////////////////////////////////
// This is end of stock module //
/////////////////////////////////
function delete_lab_config($lab_config_id)
{
	# Deletes a lab configuration and all related data
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$saved_db = DbUtil::switchToGlobal();
	$lab_config = get_lab_config_by_id($lab_config_id);
	if($lab_config == null)
	{
		# Not found or error
		return;
	}
	# Delete DB instance
	db_delete($lab_config->dbName);
	# Delete DB revamp instance
	$revamp_db_name = "blis_revamp_".$lab_config->id;
	db_delete($revamp_db_name);
	# Delete entries from lab_config_access
	$query_string =
		"DELETE FROM lab_config_access ".
		"WHERE lab_config_id=$lab_config->id";
	query_blind($query_string);
	# Delete technician accounts
	$query_string = 
		"DELETE FROM user ".
		"WHERE lab_config_id=$lab_config->id";
	query_blind($query_string);
	# Delete disease report settings
	$query_string =
		"DELETE FROM report_disease WHERE lab_config_id=$lab_config->id";
	query_blind($query_string);
	# Delete entry from lab_config
	$query_string = 
		"DELETE FROM lab_config ".
		"WHERE lab_config_id=$lab_config->id";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
}

function create_lab_config_tables($lab_config_id, $db_name)
{
	# Creates empty tables for a new lab configuration
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	db_change($db_name);
	$file_name = '../data/create_tables.sql';
	$sql_file = fopen($file_name, 'r');
	$sql_string = fread($sql_file, filesize($file_name));
	$sql_command_list = explode(";", $sql_string);
	foreach($sql_command_list as $sql_command)
	{
		query_blind($sql_command.";");
	}
}

function blis_db_update($lab_config_id, $db_name, $ufile)
{
	# Creates empty tables for a new lab configuration
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	db_change($db_name);
	$file_name = "../data/".$ufile.".sql";
	$sql_file = fopen($file_name, 'r');
	$sql_string = fread($sql_file, filesize($file_name));
	$sql_command_list = explode(";", $sql_string);
	foreach($sql_command_list as $sql_command)
	{
		query_blind($sql_command.";");
	}
	
	
}


function default_currency_copy($lab_config_id){
	global $con;
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$id=3;
	$queryString  = "SELECT setting1 as defaultCurrency FROM lab_config_settings where id=$id";
	$record = query_associative_one($queryString);
	$defaultCurrency = $record['defaultCurrency'];
	//echo $defaultCurrency;
	$query_configs = "INSERT INTO `currency_conversion` (`currencya`, `currencyb`, `exchangerate`, `flag1`) VALUES ('$defaultCurrency', '$defaultCurrency', '1.0', '1')";
	$resultset = query_associative_one($query_configs);
	DbUtil::switchRestore($saved_db);
	return 1;
}

function create_lab_config_revamp_tables($lab_config_id, $revamp_db_name)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Creates empty tables for a new lab configuration (revamp)
	db_change($revamp_db_name);
	$file_name = '../data/create_tables_revamp.sql';
	$sql_file = fopen($file_name, 'r');
	$sql_string = fread($sql_file, filesize($file_name));
	$sql_command_list = explode(";", $sql_string);
	foreach($sql_command_list as $sql_command)
	{
		query_blind($sql_command.";");
	}
}

function set_lab_config_db_name($lab_config_id, $db_name)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Sets database instance name for lab configuration
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"UPDATE lab_config ".
		"SET db_name='$db_name' ".
		"WHERE lab_config_id='$lab_config_id' ";
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
}

#
# Functions for fetching lab configuration (site) related data
#
function get_lab_config_by_id($lab_config_id)
{
	global $con;
	//print_r($lab_config_id);
	//$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a lab configuration record by id
	return LabConfig::getById($lab_config_id);
}

function get_lab_config_id_admin($user_id)
{

$query_string = "SELECT lab_config_id FROM lab_config WHERE admin_user_id='$user_id'";
$record = query_associative_one($query_string);
		$id = $record['lab_config_id'];
		
return $id;
}

function get_lab_config_id($user_id)
{
	$saved_db = DbUtil::switchToGlobal();

	$query_string = "SELECT lab_config_id FROM user WHERE user_id='$user_id'";
	$record = query_associative_one($query_string);
	$id = $record['lab_config_id'];
	DbUtil::switchRestore($saved_db);	
	return $id;
}

/* Import Configuration function */
function  insert_import_entry($id)
{
    $saved_db = DbUtil::switchToGlobal();
    $query_configs = "INSERT INTO import_log (lab_config_id) values ($id)";
    $resultset = query_associative_one($query_configs);
    return 1;
}

function get_lab_configs_imported()
{
    $saved_db = DbUtil::switchToGlobal();
    $query_configs = "SELECT distinct lab_config_id from import_log";
    $retval = array();
	$resultset = query_associative_all($query_configs, $row_count);
	if($resultset == null)
	{
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
        
	foreach($resultset as $record)
	{
		$retval[] = LabConfig::getById($record['lab_config_id']);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_last_import_date($id)
{
    $saved_db = DbUtil::switchToGlobal();
    $query_configs = "SELECT * from import_log where lab_config_id = $id ORDER BY ts DESC";
    $resultset = query_associative_one($query_configs);
    return $resultset['ts'];
}

function get_test_mapping_list_by_string($string)
{
    //echo "<pre>";
    $m1 = array();
    $m2 = array();
    $m1 = explode(";",$string);
    //print_r($m1);
    for($i = 0; $i < count($m1); $i++)
    {
        if($m1[$i] != 'null' && $m1[$i] != 'undefined')
        {
            //$m2[] = array();
            $temp = explode(":", $m1[$i]);
            $m2[$temp[0]] = $temp[1];
        }
    }
       // print_r($m2);
    //echo "</pre>";
    return $m2;

}

function get_lab_configs($admin_user_id = "")
{
	# Returns all lab configs present in DB and accessible by admin-level user
	# If admin_user_id not supplied, all stored lab configs are returned
	$saved_db = DbUtil::switchToGlobal();
	$user = null;
	if($admin_user_id != "")
		$user = get_user_by_id($admin_user_id);
	if($admin_user_id == "" || is_super_admin($user))
	{
		# Super admin user: Fetch lab configs stored in DB
		$query_configs = "SELECT * FROM lab_config ORDER BY name";
	}
	else if(is_country_dir($user))
	{
		# Country director: Fetch lab configs from lab_config_access table
		$query_configs = 
			"SELECT * from lab_config lc ".
			"WHERE lc.lab_config_id IN ( ".
			"SELECT lca.lab_config_id from lab_config_access lca ".
			"WHERE lca.user_id=$admin_user_id ) ".
			"ORDER BY lc.name";
	}
	else
	{
		# Fetch all lab configs

		$query_configs = 
			"SELECT * FROM lab_config ".
			"WHERE admin_user_id=$admin_user_id ".
			"OR lab_config_id IN ( ".
			"	SELECT lab_config_id FROM user ".
			"	WHERE user_id=$admin_user_id ".
			") ORDER BY name";
	}
	$retval = array();
	$resultset = query_associative_all($query_configs, $row_count);
	if($resultset == null)
	{
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	foreach($resultset as $record)
	{
		$retval[] = LabConfig::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_lab_config_num_patients($lab_config_id)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns total number of patients present in lab configuration
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$retval = query_num_rows("patient");
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_lab_config_num_specimens($lab_config_id)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns total number of specimens present in lab configuration
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$retval = query_num_rows("specimen");
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_lab_config_num_specimens_pending($lab_config_id, $specimen_type_id="")
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
	# Returns total number of pending specimens present in lab configuration
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	if($specimen_type_id != "")
	{
		# Narrow down to specimen type
		$query_string = 
			"SELECT COUNT(DISTINCT t.specimen_id) AS val ".
			"FROM test t, specimen sp ".
			"WHERE t.result='' ".
			"AND sp.specimen_id=t.specimen_id ".
			"AND sp.specimen_type_id=$specimen_type_id";
	}
	else
	{
		# Count for all specimen types
		$query_string = 
			"SELECT COUNT(DISTINCT specimen_id) AS val FROM test ".
			"WHERE result=''";
	}
	$record = query_associative_one($query_string);
	$retval = $record['val'];
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_lab_config_num_tests_pending($lab_config_id, $test_type_id="")
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	# Returns total number of pending tests in lab configuration
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	if($test_type_id != "")
	{
		# Narrow down to test type
		$query_string = 
			"SELECT COUNT(*) AS val FROM test ".
			"WHERE result='' ".
			"AND test_type_id=$test_type_id";
	}
	else
	{
		# Count for all test types
		$query_string = 
			"SELECT COUNT(*) AS val FROM test ".
			"WHERE result=''";
	}
	$record = query_associative_one($query_string);
	$retval = $record['val'];
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_tests_done_this_month($lab_config)
{
	# Returns count of tests performed in the current month
	$retval = array();
	$saved_db = DbUtil::switchToLabConfig($lab_config->id);
	$date_to = date("Y-m-d");
	$date_from = $date_to;
	$date_from_parts = explode("-", $date_from);
	$date_from_parts[2] = "01";
	$date_from = implode("-", $date_from_parts);
	DbUtil::switchRestore($saved_db);
	return $retval;
}



function get_site_lab($site_id)
{
    # Returns lab id of site

    $query_string = "SELECT * FROM sites WHERE id='$site_id'";
    $record = query_associative_one($query_string);
    $retval = 0;
    if($record == null)
    {
        return null;
    }
    else
    {
        $retval = $record['lab_id'];
    }
    return $retval;
}


function get_site_info($site_id)
{
    # Returns lab id of site

    $query_string = "SELECT * FROM sites WHERE id='$site_id'";
    $record = query_associative_one($query_string);
    $retval = 0;
    if($record == null)
    {
        return null;
    }
    else
    {
        $retval = $record;
    }
    return $retval;
}

function get_site_list($user_id)
{
	# Returns a list of accessible site names and ids for a given user (admin or technician)
	global $con;
	$user_id = mysql_real_escape_string($user_id, $con);
	$saved_db = DbUtil::switchToGlobal();
	$user = get_user_by_id($user_id);
	$retval = array();
	if(is_admin_check($user))
	{
		# Admin level user
		# Return all owned/accessible lab configurations
		# If superadmin, return all lab configurations
		if(is_super_admin($user))
			$lab_config_list = get_lab_configs();
		else
			$lab_config_list = get_lab_configs($user_id);
		foreach($lab_config_list as $lab_config)
		{
			$retval[$lab_config->id] = $lab_config->getSiteName();
		}
	}
	else
	{
		# Technician user -> Return local lab configuration
		$lab_config = get_lab_config_by_id($user->labConfigId);
		$retval[$user->labConfigId] = $lab_config->getSiteName();
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}





function get_test_types_by_site($lab_config_id="")
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a list of test types configured for a particular site
	$saved_db = "";
	if($lab_config_id == "")
		$saved_db = DbUtil::switchToLabConfigRevamp();
	else
		$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$retval = array();
	if($lab_config_id === "")
		$query_string = "SELECT * FROM test_type ORDER BY name";
	else
		$query_string = "SELECT * FROM test_type ORDER BY name";
		/*
		$query_string = 
			"SELECT tt.* FROM test_type tt, lab_config_test_type lctt ".
			"WHERE tt.test_type_id=lctt.test_type_id ".
			"AND lctt.lab_config_id=$lab_config_id ORDER BY tt.name";
		*/
	$resultset = query_associative_all($query_string, $row_count);
	if($resultset) {
		foreach($resultset as $record)
			$retval[] = TestType::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_test_types_by_site_category($lab_config_id, $cat_code)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$cat_code = mysql_real_escape_string($cat_code, $con);
	# Returns a list of test types of a particular section (category),
	# configured for a particular site
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$retval = array();
	$query_string = 
		"SELECT tt.* FROM test_type tt, lab_config_test_type lctt ".
		"WHERE tt.test_type_id=lctt.test_type_id ".
		"AND lctt.lab_config_id=$lab_config_id ORDER BY tt.name";
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$test_type_entry = TestType::getObject($record);
		if($test_type_entry->testCategoryId == $cat_code)
		{
			# Category code matched: Append to result list.
			$retval[] = TestType::getObject($record);
		}
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_test_types_by_site_map($lab_config_id)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a list of test types configured for a particular site
	global $CATALOG_TRANSLATION;
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$retval = array();
	$query_string = 
		"SELECT tt.* FROM test_type tt, lab_config_test_type lctt ".
		"WHERE tt.test_type_id=lctt.test_type_id ".
		"AND lctt.lab_config_id=$lab_config_id ".
		"ORDER BY tt.name";
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		if($CATALOG_TRANSLATION === true)
			$retval[$record['test_type_id']] = LangUtil::getTestName($record['test_type_id']);
		else
			$retval[$record['test_type_id']] = $record['name'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_users_by_site_map($lab_config_id)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a list of usernames configured for a particular site
	$saved_db = DbUtil::switchToGlobal();
	$retval = array();
	$query_string = 
		"SELECT u.* FROM user u ".
		"WHERE lab_config_id=$lab_config_id ORDER BY u.username";
	$resultset = query_associative_all($query_string, $row_count);
	if($resultset != null)
	{
		foreach($resultset as $record)
		{
			$retval[$record['user_id']] = $record['username'];
		}
	}
	# Append lab admin account
	$lab_config = get_lab_config_by_id($lab_config_id);
	$admin_name = get_username_by_id($lab_config->adminUserId);
	$retval[$lab_config->adminUserId] = $admin_name;
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_tech_users_by_site_map($lab_config_id)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a list of technician usernames configured for a particular site
	$saved_db = DbUtil::switchToGlobal();
	$retval = array();
	$query_string = 
		"SELECT u.* FROM user u ".
		"WHERE lab_config_id = $lab_config_id ORDER BY u.username";
	$resultset = query_associative_all($query_string, $row_count);
	if($resultset != null)
	{
		foreach($resultset as $record)
		{
			$retval[$record['user_id']] = $record['username'];
		}
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_specimen_types_by_site($lab_config_id="")
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a list of specimen types configured for a particular site
	$saved_db = "";
	if($lab_config_id == "")
		$saved_db = DbUtil::switchToLabConfigRevamp();
	else
		$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$retval = array();
	if($lab_config_id === "")
		$query_string = "SELECT * FROM specimen_type WHERE disabled=0 ORDER BY NAME";
	else
		/*
		$query_string = 
			"SELECT st.* FROM specimen_type st, lab_config_specimen_type lcst ".
			"WHERE st.disabled=0  AND st.specimen_type_id=lcst.specimen_type_id ".
			"AND lcst.lab_config_id=$lab_config_id ORDER BY st.name";
		*/
		$query_string = "SELECT * FROM specimen_type WHERE disabled=0 ORDER BY NAME";
	$resultset = query_associative_all($query_string, $row_count);
	if($resultset) {
		foreach($resultset as $record)
			$retval[] = SpecimenType::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

#
# Functions for adding data to catalog
#
function add_specimen_type($specimen_name, $specimen_descr, $test_list=array())
{
	global $con;
	$specimen_name = mysql_real_escape_string($specimen_name, $con);
	$specimen_descr = mysql_real_escape_string($specimen_descr, $con);
	# Adds a new specimen type in DB with compatible tests in $test_list
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"INSERT INTO specimen_type(name, description) ".
		"VALUES ('$specimen_name', '$specimen_descr')";
	query_insert_one($query_string);
	$specimen_type_id = get_max_specimen_type_id();
	if(count($test_list) != 0)
	{
		# For each compatible test type, add a new entry in 'specimen_test' map table
		foreach($test_list as $test_type_id)
		{
			$query_string = 
				"INSERT INTO specimen_test(test_type_id, specimen_type_id) ".
				"VALUES ($test_type_id, $specimen_type_id)";
			query_insert_one($query_string);
		}
	}
	# Return primary key of the record just inserted
	DbUtil::switchRestore($saved_db);
	//return get_max_specimen_type_id();
	return get_last_insert_id();
}

function update_specimen_type($updated_entry, $new_test_list)
{
	# Updates specimen type info in DB catalog
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$existing_entry = get_specimen_type_by_id($updated_entry->specimenTypeId);
	if($existing_entry == null)
	{
		# No record found
		DbUtil::switchRestore($saved_db);
		return;
	}
	$query_string =
		"UPDATE specimen_type ".
		"SET name='$updated_entry->name', ".
		"description='$updated_entry->description' ".
		"WHERE specimen_type_id=$updated_entry->specimenTypeId";
	query_blind($query_string);
	# Delete entries for removed compatible tests
	$existing_list = get_compatible_tests($updated_entry->specimenTypeId);
	foreach($existing_list as $test_type_id)
	{
		if(in_array($test_type_id, $new_test_list))
		{
			# Compatible test not removed
			# Do nothing
		}
		else
		{
			# Remove entry from mapping table
			$query_del = 
				"DELETE from specimen_test ".
				"WHERE test_type_id=$test_type_id ".
				"AND specimen_type_id=$updated_entry->specimenTypeId";
			query_blind($query_del);
		}
	}
	# Add entries for new compatible tests
	foreach($new_test_list as $test_type_id)
	{
		if(in_array($test_type_id, $existing_list))
		{
			# Entry already exists
			# Do nothing
		}
		else
		{
			# Add entry in mapping table
			$query_ins = 
				"INSERT INTO specimen_test (specimen_type_id, test_type_id) ".
				"VALUES ($updated_entry->specimenTypeId, $test_type_id)";
			query_blind($query_ins);
		}
	}
	DbUtil::switchRestore($saved_db);
}

function add_test_type($test_name, $test_descr, $clinical_data, $cat_code, $is_panel, $lab_config_id, $hide_patient_name, $prevalenceThreshold, $targetTat, $specimen_list = array())
{
	global $con;
	$test_name = mysql_real_escape_string($test_name, $con);
	$test_descr = mysql_real_escape_string($test_descr, $con);
	$cat = mysql_real_escape_string($cat_code, $con);
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$hide_patient_name = mysql_real_escape_string($hide_patient_name, $con);
    $cost_to_patient = mysql_real_escape_string($cost, $con);
	# Adds a new test type in DB with compatible specimens in 'specimen_list'
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$is_panel_num = 1;
        
	if($is_panel == false)
	{
		$is_panel_num = 0;
	}       
        if($prevalenceThreshold == "")
            $prevalenceThreshold = 70;
        
        if($targetTat == "")
            $targetTat = 24;
        
	if($clinical_data=="")
	{
	$query_string = 
		"INSERT INTO test_type(name, description,test_category_id, is_panel, hide_patient_name, prevalence_threshold, target_tat) ".
		"VALUES ('$test_name', '$test_descr','$cat_code', '$is_panel_num', '$hide_patient_name', $prevalenceThreshold, $targetTat)";
	}
	else
	{
	$query_string = 
		"INSERT INTO test_type(name, description,clinical_data, test_category_id, is_panel, hide_patient_name, prevalence_threshold, target_tat) ".
		"VALUES ('$test_name', '$test_descr','$clinical_data', '$cat_code', '$is_panel_num', '$hide_patient_name', $prevalenceThreshold, $targetTat)";
	}
	query_insert_one($query_string);
	$test_type_id = get_max_test_type_id();
	if(count($specimen_list) != 0)
	{
		# For each compatible test type, add a new entry in 'specimen_test' map table
		foreach($specimen_list as $specimen_type_id)
		{
			add_specimen_test($specimen_type_id, $test_type_id);
		}
	}
	# Return primary key of the record just inserted
	DbUtil::switchRestore($saved_db);
	return get_max_test_type_id();
}

function update_test_type($updated_entry, $new_specimen_list,$lab_config_id)
{
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Updates test type info in DB catalog
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$existing_entry = get_test_type_by_id($updated_entry->testTypeId);
	if($existing_entry == null)
	{
		# No record found
		DbUtil::switchRestore($saved_db);
		return;
	}
	if(0) {
	$query_string =
		"UPDATE test_type ".
		"SET name='$updated_entry->name', ".
		"description='$updated_entry->description', ".
		//"clinical_data='$updated_entry->clinical_data', ".
		"test_category_id='$updated_entry->testCategoryId', ".
		"hide_patient_name='$updated_entry->hide_patient_name', ".
		"prevalence_threshold=$updated_entry->prevalenceThreshold, ".
		"target_tat=$updated_entry->targetTat ".
		"WHERE test_type_id=$updated_entry->testTypeId";
	}
	else {
	$query_string =
		"UPDATE test_type ".
		"SET name='$updated_entry->name', ".
		"description='$updated_entry->description', ".
		"clinical_data='$updated_entry->clinical_data', ".
		"test_category_id='$updated_entry->testCategoryId', ".
		"hide_patient_name='$updated_entry->hide_patient_name', ".
		"prevalence_threshold=$updated_entry->prevalenceThreshold, ".
		"target_tat=$updated_entry->targetTat ".
		"WHERE test_type_id=$updated_entry->testTypeId";
	}
	query_blind($query_string);
	# Delete entries for removed compatible specimens
	$existing_list = get_compatible_specimens($updated_entry->testTypeId);
	foreach($existing_list as $specimen_type_id)
	{
		if(in_array($specimen_type_id, $new_specimen_list))
		{
			# Compatible specimen not removed
			# Do nothing
		}
		else
		{
			# Remove entry from mapping table
			$query_del = 
				"DELETE from specimen_test ".
				"WHERE test_type_id=$updated_entry->testTypeId ".
				"AND specimen_type_id=$specimen_type_id";
			query_blind($query_del);
		}
	}
	# Add entries for new compatible specimens
	foreach($new_specimen_list as $specimen_type_id)
	{
		if(in_array($specimen_type_id, $existing_list))
		{
			# Entry already exists
			# Do nothing
		}
		else
		{
			# Add entry in mapping table
			$query_ins = 
				"INSERT INTO specimen_test (specimen_type_id, test_type_id) ".
				"VALUES ($specimen_type_id, $updated_entry->testTypeId)";
			query_blind($query_ins);
		}
	}
	DbUtil::switchRestore($saved_db);
}

function add_test_category($cat_name, $cat_descr="")
{
	global $con;
	$cat_name = mysql_real_escape_string($cat_name, $con);
	$cat_descr = mysql_real_escape_string($cat_descr, $con);
	# Adds a new test category to catalog
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"INSERT INTO test_category(name, description) ".
		"VALUES ('$cat_name', '$cat_descr')";
	query_insert_one($query_string);
	# Return primary key of the record just inserted
	DbUtil::switchRestore($saved_db);
	return get_max_test_cat_id();
}

function add_measure($measure, $range, $unit)
{
	# Adds a new measure to catalog
	global $con;
	$measure = mysql_real_escape_string($measure, $con);
	$range = mysql_real_escape_string($range, $con);
	$unit = mysql_real_escape_string($unit, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"INSERT INTO measure(name, range, unit) ".
		"VALUES ('$measure', '$range', '$unit')";
	query_insert_one($query_string);
	# Return primary key of the record just inserted
	DbUtil::switchRestore($saved_db);
	return get_max_measure_id();
}

#
# Functions for fetching data from catalog
#
function get_specimen_types_catalog($lab_config_id=null, $reff=null)
{
	# Returns a list of all specimen types available in catalog
	global $CATALOG_TRANSLATION;
        //NC3065
        //global $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_COUNTRYDIR;
        if($reff == 1)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }
        //-NC3065

	if($lab_config_id == null)
		return;
	else
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_stypes =
		"SELECT specimen_type_id, name FROM specimen_type WHERE disabled=0 ORDER BY name";
	$resultset = query_associative_all($query_stypes, $row_count);
	$retval = array();
	if($resultset) {
		foreach($resultset as $record)
		{
			if($CATALOG_TRANSLATION === true)
				$retval[$record['specimen_type_id']] = LangUtil::getSpecimenName($record['specimen_type_id']);
			else
				$retval[$record['specimen_type_id']] = $record['name'];
		}
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_test_types_catalog($lab_config_id=null, $reff=null)
{
	# Returns a list of all test types available in catalog
	global $CATALOG_TRANSLATION;
        //NC3065
               // global $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_COUNTRYDIR;
        if($reff == 1 && $reff != 2)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }
        //-NC3065
	if($lab_config_id == null)
		return;
	//else
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_ttypes =
		"SELECT test_type_id, name FROM test_type WHERE disabled=0 ORDER BY name";
	$resultset = query_associative_all($query_ttypes, $row_count);
	$retval = array();
	if($resultset) {
		foreach($resultset as $record)
		{
			if($CATALOG_TRANSLATION === true)
				$retval[$record['test_type_id']] = LangUtil::getTestName($record['test_type_id']);
			else
				$retval[$record['test_type_id']] = $record['name'];
		}
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

//NC3065
function get_search_fields($lab_config_id=null)
{
	# Returns a list of all specimen types available in catalog
	global $CATALOG_TRANSLATION;
	if($lab_config_id == null)
		return;
	else
		$saved_db = DbUtil::switchToGlobal();
	$query_sfields ="SELECT pid, p_addl, daily_num, pname, sex, age, dob FROM lab_config WHERE lab_config_id=$lab_config_id";
        $resultset = query_associative_one($query_sfields);
	//$retval = array();
	
	DbUtil::switchRestore($saved_db);
	return $resultset;
}

//NC3065
function getDoctorNames()
{
	$query_string = "SELECT doctor FROM specimen WHERE date_collected >'2010-08-11'";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$doc_name=$record['doctor'];
		$pos=strpos($doc_name,".");
		if($pos!=-1 && $pos < 5)
			$doc_name=substr($doc_name,$pos+2);
		$retval[]=$doc_name;
	}
	return $retval;
}

function get_test_categories_data($lab_config_id) {
	
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);		
        $query_string = "SELECT test_category_id, name FROM test_category";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
        $i = 0;
        
	foreach($resultset as $record)
	{
            $retval[$i] = array(2);
            $retval[$i][0] = $record['test_category_id'];
            $retval[$i][1] = $record['name'];
            $i++;
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_test_ids_by_category($cat, $lab_config_id) {
	
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);		
        $query_string = "SELECT test_type_id FROM test_type WHERE test_category_id = $cat";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
            array_push($retval, $record['test_type_id']);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_test_categories($lab_config_id=null) {
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a list of all test categories available in catalog
	global $CATALOG_TRANSLATION;
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$query_string = "SELECT test_category_id, name FROM test_category";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		if($CATALOG_TRANSLATION === true)
			$retval[$record['test_category_id']] = LangUtil::getLabSectionName($record['test_category_id']);
		else
			$retval[$record['test_category_id']] = $record['name'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_test_categories2($lab_config_id=null) {
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a list of all test categories available in catalog
	global $CATALOG_TRANSLATION;
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$query_string = "SELECT test_category_id, name FROM test_category";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
        if($row_count == 0)
            return;
	foreach($resultset as $record)
	{
		if($CATALOG_TRANSLATION === true)
			$retval[$record['test_category_id']] = LangUtil::getLabSectionName($record['test_category_id']);
		else
			$retval[$record['test_category_id']] = $record['name'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}


function get_test_category_name_by_id($cat_id)
{
	global $con;
	$cat_id = mysql_real_escape_string($cat_id, $con);
	# Returns test category name as string
	global $CATALOG_TRANSLATION;
	if($CATALOG_TRANSLATION === true)
	{
		$saved_db = DbUtil::switchToLabConfig();
		$query_string = 
			"SELECT * FROM test_category ".
			"WHERE test_category_id=$cat_id LIMIT 1";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		return LangUtil::getLabSectionName($record['test_category_id']);
	}
	else
	{
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"SELECT name FROM test_category ".
			"WHERE test_category_id=$cat_id LIMIT 1";
		$record = query_associative_one($query_string);
		$retval = LangUtil::$generalTerms['NOTKNOWN'];
		if($record != null)
			$retval = $record['name'];
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
}

function get_test_types_wcat_catalog()
{
	# Returns a list of all test types available in catalog, with category name appended
	global $CATALOG_TRANSLATION;
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_ttypes =
		"SELECT test_type_id, name FROM test_type";
	$resultset = query_associative_all($query_ttypes, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		if($CATALOG_TRANSLATION === true)
			$retval[$record['test_type_id']] = LangUtil::getTestName($record['test_type_id']);
		else
			$retval[$record['test_type_id']] = $record['name'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;	
}

function getMeasuresByLab($labConfigId) {
	global $con;
	$labConfigId = mysql_real_escape_string($labConfigId, $con);
	$saved_db = DbUtil::switchToLabConfig($labConfigId);
	$query_string = "SELECT * FROM measure ORDER BY name";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
		$retval[] = Measure::getObject($record);
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_measures_catalog()
{
	# Returns a list of all measures available in catalog
	global $CATALOG_TRANSLATION;
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_measures =
		"SELECT measure_id, name FROM measure ORDER BY name";
	$resultset = query_associative_all($query_measures, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		if($CATALOG_TRANSLATION === true)
			$retval[$record['measure_id']] = LangUtil::getMeasureName($record['measure_id']);
		else
			$retval[$record['measure_id']] = $record['name'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_measure_by_id($measure_id)
{
	global $con;
	$measure_id = mysql_real_escape_string($measure_id, $con);
	# Returns Measure object from DB
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_measure = 
		"SELECT * FROM measure WHERE measure_id=$measure_id LIMIT 1";
	$record = query_associative_one($query_measure);
	$retval = Measure::getObject($record);
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_test_type_measure($test_type_id)
{
	# Returns list of measures for a given test type
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	# Moved to TestType::getMeasures()
	$test_type = TestType::getById($test_type_id);
	if($test_type != null)
	{
		return $test_type->getMeasures();
	}
	else
	{
		$dummy_list = array();
		return $dummy_list;
	}	
}

function get_specimen_type_by_name($specimen_name)
{
	global $con;
	$specimen_name = mysql_real_escape_string($specimen_name, $con);
	# Returns specimen type record in DB
	$user = get_user_by_id($_SESSION['user_id']);
	$lab_config_id = $user->labConfigId;
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$query_string = 
		"SELECT * FROM specimen_type WHERE name='$specimen_name' AND disabled=0 LIMIT 1";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return SpecimenType::getObject($record);
}

function get_test_type_by_name($test_name)
{
	global $con;
	$test_name = mysql_real_escape_string($test_name, $con);
	# Returns test type record in DB
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$test_name = addslashes($test_name);
	$query_string =
		"SELECT * FROM test_type WHERE name='$test_name' AND disabled=0 LIMIT 1";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return TestType::getObject($record);
}

function get_specimen_name_by_id($specimen_type_id)
{
	# Returns specimen type name string
	global $con;
	$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
	global $CATALOG_TRANSLATION;
	if($CATALOG_TRANSLATION === true)
		return LangUtil::getSpecimenName($specimen_type_id);
	else
	{
		//$saved_db = DbUtil::switchToLabConfigRevamp();
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
		$query_string = 
			"SELECT name FROM specimen_type ".
			"WHERE specimen_type_id=$specimen_type_id LIMIT 1";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		if($record == null)
			return LangUtil::$generalTerms['NOTKNOWN'];
		else
			return $record['name'];
	}
}

function get_test_name_by_id($test_type_id, $lab_config_id=null)
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns test type name string
	global $CATALOG_TRANSLATION;
	if($CATALOG_TRANSLATION === true)
	return LangUtil::getTestName($test_type_id);
	else
	{
		//$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
		$query_string = 
			"SELECT name FROM test_type ".
			"WHERE test_type_id=$test_type_id LIMIT 1";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		if($record == null)
			return LangUtil::$generalTerms['NOTKNOWN'];
		else
			return $record['name'];
	}
}

function get_clinical_data_by_id($test_type_id)
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	# Returns test type name string
	global $CATALOG_TRANSLATION;
	if($CATALOG_TRANSLATION === true)
	return LangUtil::getTestName($test_type_id);
	else
	{
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"SELECT clinical_data FROM test_type ".
			"WHERE test_type_id=$test_type_id LIMIT 1";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		if($record == null)
			return LangUtil::$generalTerms['NOTKNOWN'];
		else
			return $record['clinical_data'];
	}
}

function get_test_type_by_id($test_type_id)
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	# Returns test type record in DB
	return TestType::getById($test_type_id);
}

function get_specimen_type_by_id($specimen_type_id)
{
	global $con;
	$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
	# Returns specimen type record in DB
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string =
		"SELECT * FROM specimen_type WHERE specimen_type_id=$specimen_type_id LIMIT 1";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return SpecimenType::getObject($record);
}



#
# Functions for jquery.token-input plugin
# Called from pages in ajax/token_*.php
#

function search_measures_catalog($measure_name)
{
	# Returns a list of matching measures available in catalog
	# Called from ajax/token_tmeas.php
	global $con;
	$measure_name = mysql_real_escape_string($measure_name, $con);
	global $CATALOG_TRANSLATION;
	$saved_db = DbUtil::switchToGlobal();
	$query_string =
		"SELECT measure_id, name FROM measure WHERE name LIKE '$measure_name%'";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		if($CATALOG_TRANSLATION === true)
			$retval[$record['measure_id']] = LangUtil::getMeasureName($record['measure_id']);
		else
			$retval[$record['measure_id']] = $record['name'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function search_test_types_catalog($test_name)
{
	# Returns matching test types available in catalog
	# Called from ajax/token_ttypes.php
	global $con;
	$test_name = mysql_real_escape_string($test_name, $con);
	global $CATALOG_TRANSLATION;
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"SELECT * FROM test_type WHERE name LIKE '$test_name%' AND disabled=0";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		if($CATALOG_TRANSLATION === true)
			$retval[$record['test_type_id']] = LangUtil::getTestName($record['test_type_id']);
		else
			$retval[$record['test_type_id']] = $record['name'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function search_specimen_types_catalog($specimen_name)
{
	# Returns matching test types available in catalog
	# Called from ajax/token_stypes.php
	global $con;
	$specimen_name = mysql_real_escape_string($specimen_name, $con);
	global $CATALOG_TRANSLATION;
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"SELECT * FROM specimen_type WHERE disabled=0 AND name LIKE '$specimen_name%'";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		if($CATALOG_TRANSLATION === true)
			$retval[$record['specimen_type_id']] = LangUtil::getSpecimenName($record['specimen_type_id']);
		else
			$retval[$record['specimen_type_id']] = $record['name'];		
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}


#
# Functions to fetch the largest primary key value,
# or primary key of the latest inserted record
#

function get_max_specimen_type_id()
{
	# Returns the largest specimen type ID
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string =
		"SELECT MAX(specimen_type_id) as maxval FROM specimen_type";
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $resultset['maxval'];
}

function get_max_test_type_id()
{
	# Returns the largest test type ID
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string =
		"SELECT MAX(test_type_id) as maxval FROM test_type";
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $resultset['maxval'];
}
function getDoctorList()
{
	$query_string =
		"SELECT DISTINCT doctor FROM specimen WHERE doctor!=' ' AND ts >'2010-11-11' ORDER BY ts desc  ";
		$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset == null)
		return $retval;
	foreach($resultset as $record)
	{
		
		$retval[] = $record['doctor'];
	}
		return $retval;
}

function getRefToList()
{
	$query_string =
	"SELECT DISTINCT referred_to_name FROM specimen WHERE referred_to_name!=' ' AND ts >'2010-11-11' ORDER BY ts desc  ";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset == null)
		return $retval;
	foreach($resultset as $record)
	{

		$retval[] = $record['referred_to_name'];
	}
	return $retval;
}



function get_max_test_cat_id()
{
	# Returns the largest test category type ID
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string =
		"SELECT MAX(test_category_id) as maxval FROM test_category";
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $resultset['maxval'];
}

function get_max_measure_id()
{
	# Returns the largest measure ID
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string =
		"SELECT MAX(measure_id) as maxval FROM measure";
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $resultset['maxval'];
}

function get_max_lab_config_id()
{
	# Returns the largest lab_config ID
	$saved_db = DbUtil::switchToGlobal();
	$query_string =
		"SELECT MAX(lab_config_id) as maxval FROM lab_config";
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $resultset['maxval'];
}

function get_max_patient_id()
{
	# Returns the largest patient ID
	$query_string =
		"SELECT MAX(patient_id) as maxval FROM patient";
	$resultset = query_associative_one($query_string);
	return $resultset['maxval'];
}

function get_max_specimen_id()
{
	# Returns the largest specimen ID
	$query_string =
		"SELECT MAX(specimen_id) as maxval FROM specimen";
	$resultset = query_associative_one($query_string);
	return $resultset['maxval'];
}

function get_max_test_id() {
	$query_string =
		"SELECT MAX(test_id) as maxval FROM test";
	$resultset = query_associative_one($query_string);
	return $resultset['maxval'];
}

function getStartDate()
{

$today = date("Ymd");
	$query_string =
		"SELECT ts FROM specimen".
		"WHERE session_id=1";
	//	;

	$record = query_associative_one($query_string);
	//echo "fhi";
	///echo $record['ts'];
//echo "dsd";

}

function get_session_number()
{
	# Generate the next session number for specimen registration
	$today = date("Ymd");
	$query_string =
		"SELECT * FROM specimen_session ".
		"WHERE session_num='$today'";
	$record = query_associative_one($query_string);
	if($record == null) {
		$returnValue = $today."-1";
		update_session_number(date("Ymd"));
	}
	else {
		$returnValue = $today."-".($record['count']+1);
		update_session_number(date("Ymd"));
	}
	return $returnValue;
}

function get_session_current_number()
{

$today = date("Ymd");
	$query_string =
		"SELECT * FROM specimen_session ".
		"WHERE session_num='$today'";
	$record = query_associative_one($query_string);
	if($record == null)
		return $today."-1";
	else
		return $today."-".($record['count']);
}

function update_session_number($session_date_string)
{
	# Updates count values for session numbers
	# Called from ajax/session_num_update.php
	$query_string = 
		"SELECT * FROM specimen_session ".
		"WHERE session_num='$session_date_string'";
	$record = query_associative_one($query_string);
	if($record == null)
	{
		# No entry exists. Add one.
		$query_string = 
			"INSERT INTO specimen_session(session_num, count) ".
			"VALUES ('$session_date_string', 1)";
		query_insert_one($query_string);
	}
	else
	{
		# Update count value
		$new_count = $record['count'] + 1;
		$query_string =
			"UPDATE specimen_session ".
			"SET count=$new_count ".
			"WHERE session_num='$session_date_string'";
		query_blind($query_string);
	}
}

function get_daily_number()
{
	# Generate the next daily number for specimen registration
	$today = date("Ymd");
	switch($_SESSION['dnum_reset'])
	{
		case LabConfig::$RESET_DAILY:
			$today = date("Ymd");
			break;
		case LabConfig::$RESET_WEEKLY:
			$today = date("Y_W");
			break;
		case LabConfig::$RESET_MONTHLY:
			$today = date("Ym");
			break;
		case LabConfig::$RESET_YEARLY:
			$today = date("Y");
			break;
	}
	$query_string =
		"SELECT * FROM patient_daily ".
		"WHERE datestring='$today'";
	$record = query_associative_one($query_string);

	if($record == null) {
		$returnValue = 1;
		$query_string = "INSERT INTO patient_daily (datestring, count) ".
						"VALUES ('$today', $returnValue)";
		query_insert_one($query_string);
		//update_session_number(date("Ymd"));
	}
	else {
		$returnValue = $record['count']+1;
		$query_string = "update patient_daily set count=$returnValue where datestring='$today' ";
		query_blind($query_string);
		//update_session_number(date("Ymd"));
	}
	return $returnValue;
}

function update_daily_number_registration()
{
	# Generate the next daily number for specimen registration
	$today = date("Ymd");
	switch($_SESSION['dnum_reset'])
	{
		case LabConfig::$RESET_DAILY:
			$today = date("Ymd");
			break;
		case LabConfig::$RESET_WEEKLY:
			$today = date("Y_W");
			break;
		case LabConfig::$RESET_MONTHLY:
			$today = date("Ym");
			break;
		case LabConfig::$RESET_YEARLY:
			$today = date("Y");
			break;
	}
	$query_string =
	"SELECT * FROM patient_daily ".
	"WHERE datestring='$today'";
	$record = query_associative_one($query_string);

	if($record == null) {
		$returnValue = 1;
		$query_string = "INSERT INTO patient_daily (datestring, count) ".
				"VALUES ('$today', $returnValue)";
		query_insert_one($query_string);
		//update_session_number(date("Ymd"));
	}
	else {
		$returnValue = $record['count']+1;
		$query_string = "update patient_daily set count=$returnValue where datestring='$today' ";
		query_blind($query_string);
		//update_session_number(date("Ymd"));
	}
	return $returnValue;
}

function get_daily_number_registration()
{
	# Generate the next daily number for specimen registration
	$today = date("Ymd");
	switch($_SESSION['dnum_reset'])
	{
		case LabConfig::$RESET_DAILY:
			$today = date("Ymd");
			break;
		case LabConfig::$RESET_WEEKLY:
			$today = date("Y_W");
			break;
		case LabConfig::$RESET_MONTHLY:
			$today = date("Ym");
			break;
		case LabConfig::$RESET_YEARLY:
			$today = date("Y");
			break;
	}
	$query_string =
	"SELECT * FROM patient_daily ".
	"WHERE datestring='$today'";
	$record = query_associative_one($query_string);

	if($record == null) {
		$returnValue = 1;
		//update_session_number(date("Ymd"));
	}
	else {
		$returnValue = $record['count']+1;
		//update_session_number(date("Ymd"));
	}
	return $returnValue;
}




function update_daily_number($daily_date_string, $curr_count)
{
	# Updates count values for daily numbers
	# Called from ajax/daily_num_update.php
	# Find current count value
	$count_val = $curr_count;
	$query_string = "SELECT * FROM patient_daily WHERE datestring='$daily_date_string'";
	$record = query_associative_one($query_string);
	if($record == null)
	{
		# No entry exists. Add one.
		$query_string = 
			"INSERT INTO patient_daily(datestring, count) ".
			"VALUES ('$daily_date_string', $count_val)";
		query_insert_one($query_string);
	}
	else
	{
		# Update count value
		$old_count = $record['count'];
		$new_count = $old_count+1;
		$query_string = "UPDATE patient_daily ".
						"SET count=$new_count ".
						"WHERE datestring='$daily_date_string'";
		query_blind($query_string);
	}
}

#
# Functions for adding data to mapping tables in catalog
#

function add_test_type_measure($test_type_id, $measure_id)
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$measure_id = mysql_real_escape_string($measure_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	# Adds a new entry to test_type->measure map table
	$query_check = 
		"SELECT * FROM test_type_measure ".
		"WHERE test_type_id=$test_type_id AND measure_id=$measure_id";
	$flag_exists = query_associative_one($query_check);
	if($flag_exists != null)
	{
		# Mapping already exists
		# TODO: Add error handling?
		DbUtil::switchRestore($saved_db);
		return;
	}
	$query_add =
		"INSERT INTO test_type_measure(test_type_id, measure_id) ".
		"VALUES ($test_type_id, $measure_id)";
	query_insert_one($query_add);
	DbUtil::switchRestore($saved_db);
}

function delete_test_type_measure($test_type_id, $measure_id)
{
	# Deletes the mapping entry between test_type and measure
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$measure_id = mysql_real_escape_string($measure_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"DELETE FROM test_type_measure ".
		"WHERE test_type_id=$test_type_id AND measure_id=$measure_id";
	query_delete($query_string);
	# Check if any other test type uses this measure.
	# If not, delete entry from 'measure' table
	$query_string =
		"SELECT * FROM test_type_measure ".
		"measure_id=$measure_id";
	$resultset = query_associative_all($query_string, $row_count);
	if($resultset == null || count($resultset) == 0)
	{
		$query_delete = "DELETE FROM measure WHERE measure_id=$measure_id";
		query_delete($query_delete);
	}
	DbUtil::switchRestore($saved_db);
}

function add_specimen_test($specimen_type_id, $test_type_id)
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	# Adds a new entry to specimen_type->test_type map table
	$query_check = 
		"SELECT * FROM specimen_test ".
		"WHERE test_type_id=$test_type_id AND specimen_type_id=$specimen_type_id";
	$flag_exists = query_associative_one($query_check);
	if($flag_exists != null)
	{
		# Mapping already exists
		# TODO: Add error handling?
		DbUtil::switchRestore($saved_db);
		return;
	}
	$query_add =
		"INSERT INTO specimen_test(specimen_type_id, test_type_id) ".
		"VALUES ($specimen_type_id, $test_type_id)";
	query_insert_one($query_add);
	DbUtil::switchRestore($saved_db);
}

function add_lab_config_test_type($lab_config_id, $test_type_id)
{
	# Adds a new entry to lab_config->test_type map table
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$query_check = 
		"SELECT * FROM lab_config_test_type ".
		"WHERE test_type_id=$test_type_id AND lab_config_id=$lab_config_id";
	$flag_exists = query_associative_one($query_check);
	if($flag_exists != null)
	{
		# Mapping already exists
		# TODO: Add error handling?
		return;
	}
	$query_add =
		"INSERT INTO lab_config_test_type(lab_config_id, test_type_id) ".
		"VALUES ($lab_config_id, $test_type_id)";
	query_insert_one($query_add);
	DbUtil::switchRestore($saved_db);
}

function add_lab_config_specimen_type($lab_config_id, $specimen_type_id)
{
	# Adds a new entry to lab_config->specimen_type map table
	global $con;
	$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$query_check = 
		"SELECT * FROM lab_config_specimen_type ".
		"WHERE specimen_type_id=$specimen_type_id AND lab_config_id=$lab_config_id";
	$flag_exists = query_associative_one($query_check);
	if($flag_exists != null)
	{
		# Mapping already exists
		# TODO: Add error handling?
		return;
	}
	$query_add =
		"INSERT INTO lab_config_specimen_type(lab_config_id, specimen_type_id) ".
		"VALUES ($lab_config_id, $specimen_type_id)";
	query_insert_one($query_add);
	DbUtil::switchRestore($saved_db);
}

function add_lab_config_access($user_id, $lab_config_id)
{
	# Adds access to a new lab config for a country dir user
	global $con;
	$user_id = mysql_real_escape_string($user_id, $con);
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$saved_db = DbUtil::switchToGlobal();
	$query_check = 
		"SELECT * FROM lab_config_access ".
		"WHERE user_id=$user_id AND lab_config_id like '$lab_config_id'";
	$flag_exists = query_associative_one($query_check);
	if($flag_exists != null)
	{
		# Mapping already exists
		# TODO: Add error handling?
		return;
	}
	$query_add =
		"INSERT INTO lab_config_access(user_id, lab_config_id) ".
		"VALUES ($user_id, '$lab_config_id')";
	query_insert_one($query_add);
	DbUtil::switchRestore($saved_db);
}

#
# Functions for fetching data from mapping tables
#

function get_compatible_tests($specimen_type_id)
{
	# Returns a list of compatible tests for a given specimen type in catalog
	global $con;
	$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"SELECT test_type_id FROM specimen_test WHERE specimen_type_id=$specimen_type_id";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset == null)
		return $retval;
	foreach($resultset as $record)
	{
		$retval[] = $record['test_type_id'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_compatible_specimens($test_type_id)
{
	# Returns a list of compatible specimens for a given test type in catalog
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$query_string = 
		"SELECT specimen_type_id FROM specimen_test WHERE test_type_id=$test_type_id";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset == null)
		return $retval;
	foreach($resultset as $record)
	{
		$retval[] = $record['specimen_type_id'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_compatible_test_types($lab_config_id, $specimen_type_id)
{
	# Returns a list of compatible tests for a given specimen type in lab configuration
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$specimen_type_id = mysql_real_escape_string($specimen_type_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$query_string = 
		"SELECT tt.* FROM test_type tt, lab_config_test_type lctt, specimen_test st ".
		"WHERE tt.test_type_id=lctt.test_type_id ".
		"AND lctt.lab_config_id=$lab_config_id ".
		"AND st.specimen_type_id=$specimen_type_id ".
		"AND st.test_type_id=tt.test_type_id ".
		"AND tt.disabled=0 ".
		"ORDER BY tt.name";

	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = TestType::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_lab_config_test_types($lab_config_id, $to_global=false)
{
	## Moved to LabConfig::getTestTypeIds();
	global $con;
	//$lab_config_id = 127;
	
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	//echo "test ".$lab_config_id;
	//$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$lab_config = LabConfig::getById($lab_config_id);
	//DbUtil::switchRestore($saved_db);
	
	return $lab_config->getTestTypeIds();
}

function get_lab_config_specimen_types($lab_config_id, $to_global=false, $lab_config_id_filter=0)
{
	global $con;

	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns a list of all specimen types added to the lab configuration
	if($to_global == false){
		$saved_db = DbUtil::switchToLabConfigRevamp();
	}
	else
		$saved_db = DbUtil::switchToGlobal();

	if($lab_config_id_filter == 1){
		#this branch is entered when the call is made from specimen_aggregate_report.php
		#because the db context has to remain either blis_revamp or  blis_lab_config_id
		#for the $query_string to work
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	}

	$query_string = 
		"SELECT specimen_type_id FROM lab_config_specimen_type ".
		"WHERE lab_config_id=$lab_config_id";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = $record['specimen_type_id'];
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_test_type_measures($test_type_id)
{
	# Returns list of measure IDs included in a test type
	# Moved to Measure::getMeasureIds()
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$test_type = TestType::getById($test_type_id);
	if($test_type != null)
	{
		return $test_type->getMeasureIds();
	}
	else
	{
		$dummy_list = array();
		return $dummy_list;
	}	
}

function get_measure_range($measure_id)
{
	global $con;
	$measure_id = mysql_real_escape_string($measure_id, $con);
	$saved_db = DbUtil::switchToLabConfigRevamp();
	# Returns range specified for the measure
	$query_string =
		"SELECT range FROM measure WHERE measure_id=$measure_id LIMIT 1";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return $record['range'];
}


#
# Functions for handling custom fields
#

function add_custom_field_specimen($custom_field, $lab_config_id=null)
{
	# Adds a new specimen custom field to lab configuration
	global $con;
	if($lab_config_id != null) {
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	}
	$query_string = 
		"INSERT INTO specimen_custom_field (field_name, field_options, field_type_id) ".
		"VALUES ('$custom_field->fieldName', '$custom_field->fieldOptions', $custom_field->fieldTypeId)";
	query_blind($query_string);
	if($lab_config_id != null)
		DbUtil::switchRestore($saved_db);
}

function add_custom_field_patient($custom_field, $lab_config_id=null)
{
	# Adds a new patient custom field to lab configuration
	global $con;
	if($lab_config_id != null) {
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	}
	$query_string = 
		"INSERT INTO patient_custom_field (field_name, field_options, field_type_id) ".
		"VALUES ('$custom_field->fieldName', '$custom_field->fieldOptions', $custom_field->fieldTypeId)";
	query_blind($query_string);
	if($lab_config_id != null)
		DbUtil::switchRestore($saved_db);
}

function add_custom_field_labtitle($custom_field, $lab_config_id=null)
{
	# Adds a new lab title custom field to lab configuration
	global $con;
	if($lab_config_id != null) {
		$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	}
	$query_string = 
		"INSERT INTO labtitle_custom_field (field_name, field_options, field_type_id) ".
		"VALUES ('$custom_field->fieldName', '$custom_field->fieldOptions', $custom_field->fieldTypeId)";
	query_blind($query_string);
	if($lab_config_id != null)
		DbUtil::switchRestore($saved_db);
}

function get_custom_fields()
{
	# Returns a list of all patient custom fields
	$query_string =
		"SELECT DISTINCT doctor FROM specimen WHERE doctor!=''";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		
		$retval[] = $record;
	}
	
	return $retval;
}
function get_custom_fields_specimen()
{
	# Returns a list of all specimen custom fields
	$query_string =
		"SELECT * FROM specimen_custom_field";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$custom_field = CustomField::getObject($record);
		$retval[] = $custom_field;
	}
	return $retval;
}

function get_custom_fields_patient()
{
	# Returns a list of all patient custom fields
	$query_string =
		"SELECT * FROM patient_custom_field";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$custom_field = CustomField::getObject($record);
		$retval[] = $custom_field;
	}
	return $retval;
}

function get_custom_fields_patient_by_name($field_name)
{
	# Returns a list of all patient custom fields
	$query_string =
	"SELECT * FROM patient_custom_field where field_name = '$field_name' LIMIT 1";
	$record = query_associative_one($query_string);
	/* . " - ";
	print_r($record);
	echo "<br/>"; */
	$retval = array();
	//foreach($resultset as $record)
	//{	
		$custom_field = CustomField::getObject($record);
	//	$retval[] = $custom_field;
	//}
		//echo "Final Field Name : ".$custom_field->fieldName."<br/>";
	return $custom_field;
}

function get_custom_fields_labtitle($field_id)
{
	# Returns a list of all patient custom fields
	global $con;
	$field_id = mysql_real_escape_string($field_id, $con);
	$query_string =
		"SELECT field_options FROM labtitle_custom_field where id = $field_id LIMIT 1";
	$record = query_associative_one($query_string);
	return $record['field_options'];
}

function get_custom_field_name_specimen($field_id)
{
	# Returns name of the specimen custom field
	global $con;
	$field_id = mysql_real_escape_string($field_id, $con);
	$query_string = 
		"SELECT field_name FROM specimen_custom_field ".
		"WHERE id=$field_id LIMIT 1";
	$record = query_associative_one($query_string);
	return $record['field_name'];
}

function get_custom_field_name_patient($field_id)
{
	# Returns name of the patient custom field
	global $con;
	$field_id = mysql_real_escape_string($field_id, $con);
	$query_string = 
		"SELECT field_name FROM patient_custom_field ".
		"WHERE id=$field_id LIMIT 1";
	$record = query_associative_one($query_string);
	return $record['field_name'];
}

function get_custom_field_name_labtitle($field_id)
{
	# Returns name of the specimen custom field
	global $con;
	$field_id = mysql_real_escape_string($field_id, $con);
	$query_string = 
		"SELECT field_name FROM labtitle_custom_field ".
		"WHERE id=$field_id LIMIT 1";
	$record = query_associative_one($query_string);
	return $record['field_name'];
}

function add_custom_data_specimen($custom_data)
{
	# Adds the custom field value to specimen_custom_data table
	$query_string = 
		"INSERT INTO specimen_custom_data (field_id, specimen_id, field_value) ".
		"VALUES ($custom_data->fieldId, $custom_data->specimenId, '$custom_data->fieldValue')";
	query_blind($query_string);
}

function add_custom_data_patient($custom_data)
{
	# Adds the custom field value to patient_custom_data table
	$query_string = 
		"INSERT INTO patient_custom_data (field_id, patient_id, field_value) ".
		"VALUES ($custom_data->fieldId, $custom_data->patientId, '$custom_data->fieldValue')";
	query_blind($query_string);
}


function update_custom_data_patient($custom_data)
{
	# Updates custom field value in patient_custom_data table
	## Check if entry already exists
	$query_string = 
		"SELECT * FROM patient_custom_data ".
		"WHERE field_id=$custom_data->fieldId ".
		"AND patient_id=$custom_data->patientId LIMIT 1";
	$record = query_associative_one($query_string);
	if($record == null)
	{
		## Add a new entry in patient_custom_data table
		$query_string_new = 
			"INSERT INTO patient_custom_data (field_id, patient_id, field_value) ".
			"VALUES ($custom_data->fieldId, $custom_data->patientId, '$custom_data->fieldValue')";
		query_blind($query_string_new);
	}
	else
	{
		## Record already exists, hence update field_value alone
		$query_string_update = 
			"UPDATE patient_custom_data ".
			"SET field_value='$custom_data->fieldValue' ".
			"WHERE patient_id=$custom_data->patientId ".
			"AND field_id=$custom_data->fieldId";
		query_blind($query_string_update);
	}
}

function get_custom_data_specimen($specimen_id)
{
	# Fetches custom data stored for a given specimen ID
	global $con;
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	$query_string = 
		"SELECT * FROM specimen_custom_data ".
		"WHERE specimen_id=$specimen_id";
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);		
	$resultset = query_associative_all($query_string, $row_count);
	DbUtil::switchRestore($saved_db);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = SpecimenCustomData::getObject($record);
	}
	return $retval;
}

function get_custom_data_specimen_bytype($specimen_id, $field_id)
{
	global $con;
	$specimen_id = mysql_real_escape_string($specimen_id, $con);
	$field_id = mysql_real_escape_string($field_id, $con);
	$query_string = 
		"SELECT * FROM specimen_custom_data ".
		"WHERE specimen_id=$specimen_id AND field_id=$field_id LIMIT 1";
	$record = query_associative_one($query_string);
	$retval = null;
	if($record != null)
		$retval = SpecimenCustomData::getObject($record);
	return $retval;
}

function get_custom_data_patient($patient_id)
{
	# Fetches custom data stored for a given patient ID
	global $con;
	$patient_id = mysql_real_escape_string($patient_id, $con);
	$query_string = 
		"SELECT * FROM patient_custom_data ".
		"WHERE patient_id=$patient_id";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = PatientCustomData::getObject($record);
	}
	return $retval;
}

function get_custom_data_patient_bytype($patient_id, $field_id)
{
	global $con;
	$patient_id = mysql_real_escape_string($patient_id, $con);
	$field_id = mysql_real_escape_string($field_id, $con);
	$query_string = 
		"SELECT * FROM patient_custom_data ".
		"WHERE patient_id=$patient_id AND field_id=$field_id LIMIT 1";
	$record = query_associative_one($query_string);
	$retval = null;
	if($record != null)
		$retval = PatientCustomData::getObject($record);
	return $retval;
}

function get_lab_config_specimen_custom_fields($lab_config_id)
{
	# Returns list of specimen custom fields for a lab configuration
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_string = 
		"SELECT * FROM specimen_custom_field";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = CustomField::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_lab_config_patient_custom_fields($lab_config_id)
{
	# Returns list of patient custom fields for a lab configuration
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id);
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_string = 
		"SELECT * FROM patient_custom_field";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	foreach($resultset as $record)
	{
		$retval[] = CustomField::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function get_lab_config_labtitle_custom_fields($lab_config_id)
{
	# Returns list of patient custom fields for a lab configuration
	global $con;
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_string = 
		"SELECT * FROM labtitle_custom_field";
	$resultset = query_associative_all($query_string, $row_count);
	$retval = array();
	if($resultset) {
		foreach($resultset as $record)
			$retval[] = CustomField::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}


#
# Functions for transaction support
# (Works in InnoDB engine and not in MyISAM)
#

function begin_transaction()
{
	query_blind("BEGIN");
}

function commit_transaction()
{
	query_blind("COMMIT");
}

function rollback_transaction()
{
	query_blind("ROLLBACK");
}


#
# Functions for miscellaneous tasks
#

function add_new_comment($username, $page, $comment)
{
	# Adds a copy of user comment to DB
	global $con;
	$username = mysql_real_escape_string($username, $con);
	$page = mysql_real_escape_string($page, $con);
	$comment = mysql_real_escape_string($comment, $con);
	$query_string =
		"INSERT INTO comment (username, page, comment) ".
		"VALUES ('$username', '$page', '$comment')";
	$saved_db = DbUtil::switchToGlobal();
	query_blind($query_string);
	DbUtil::switchRestore($saved_db);
}

function getBackupFolders($user_id) {
	$labConfigList = get_lab_configs($user_id);
	foreach($labConfigList as $labConfig) {
		$labConfigId = $labConfig->id;
		$folderName = getLatestBackupFolder($labConfigId);
		if( $folderName != "notFound" )
			$retval[$labConfigId] = $folderName;
	}
	return $retval;
}

function getLatestBackupFolder($labConfigId) {
	$folderList = get_backup_folders($labConfigId);
	if( count($folderList) > 0 ) {
		end($folderList);
		$key = key($folderList);
		return $key;
	}
	else
		return "notFound";
}
function get_backup_folders($lab_config_id)
{
	# Returns a list of all backup folders available on main dir
	$retval = array();
	$start_dir = "../../";
	if($handle = opendir($start_dir)) 
	{
		while (false !== ($file = readdir($handle))) 
		{
			if(strpos($file, "blis_backup_") !== false)
			{
				if(is_file($file))
				{
					# Not a folder
					continue;
				}
				# This is a data backup folder
				$lab_config_match = false;
				if($handle2 = opendir($start_dir.$file))
				{
					# Check if this folder has backup for the given lab_config_id
					while (false !== ($file2 = readdir($handle2)))
					{
						if($file2 == "blis_".$lab_config_id)
						{
							$lab_config_match = true;
							break;
						}
					}					
				}
				if($lab_config_match === false)
					continue;
				# $lab_config_id matched. Add this folder option
				$name_parts = explode("_", $file);
				$timestamp_index = 3;
				$timestamp_parts = explode("-", $name_parts[$timestamp_index]);
				$year = substr($timestamp_parts[0], 0, 4);
				$month = substr($timestamp_parts[0], 4, 2);
				$day = substr($timestamp_parts[0], 6, 2);
				$hour = substr($timestamp_parts[1], 0, 2);
				$min = substr($timestamp_parts[1], 2, 2);
				$date = $year."-".$month."-".$day;
				$option_name = DateLib::mysqlToString($date)." ".$hour.":".$min;
				$option_value = $file;
				$retval[$option_value] = $option_name;
			}
		}
	}
	closedir($handle);
	return $retval;
}

class TestTypeMapping {

	public $testId;
	public $name;
	public $userId;
	public $labIdTestId;
	public $testCategoryId;
	
	public static function getObject($record)
	{
		# Converts a test type mapping record in DB into a TestTypeMapping object
		if($record == null)
			return null;
		$testTypeMapping = new TestTypeMapping();
		$testTypeMapping->testId = $record['test_id'];
		$testTypeMapping->name = $record['test_name'];
		$testTypeMapping->userId = $record['user_id'];
		$testTypeMapping->labIdTestId = $record['lab_id_test_id'];
		$testTypeMapping->testCategoryId = $record['test_category_id'];
		return $testTypeMapping;
	}
	
	public function getName()
	{
		global $CATALOG_TRANSLATION;
		if($CATALOG_TRANSLATION === true)
		{
			return LangUtil::getTestName($this->testId);
		}
		else
		{
			return $this->name;
		}
	}
	
	public function getDescription()
	{
		if(trim($this->description) == "" || $this->description == null)
			return "-";
		else
			return trim($this->description);
	}
	
	public function getClinicalData()
	{
		if(trim($this->clinical_data) == "" || $this->clinical_data == null)
			return "-";
		else
			return trim($this->clinical_data);
	}
	
	public static function getByCategory($catCode)
	{
		# Returns all test types belonging to a particular category (aka section)
		if($catCode == null || $catCode == "")
			return null;
		$retval = array();
		$query_string = 
			"SELECT * FROM test_mapping ".
			"WHERE test_category_id=$catCode";
		$saved_db = DbUtil::switchToGlobal();
		$resultset = query_associative_all($query_string, $row_count);
		foreach($resultset as $record)
			$retval[] = TestTypeMapping::getObject($record);
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public static function getById($testTypeId) {
		# Returns global test type record in DB
		$saved_db = DbUtil::switchToGlobal();
		$query_string =
			"SELECT * FROM test_mapping WHERE test_id=$testTypeId LIMIT 1";
		$record = query_associative_one($query_string);
		return TestTypeMapping::getObject($record);
	}
        
        public static function getTestTypeById($testTypeId, $user_id) {
		# Returns global test type record in DB
		$saved_db = DbUtil::switchToGlobal();
		$query_string =
			"SELECT * FROM test_mapping WHERE test_id=$testTypeId AND user_id=$user_id LIMIT 1";
		$record = query_associative_one($query_string);
		return TestTypeMapping::getObject($record);
	}
        
        public static function getTestCatById($testTypeId, $user_id) {
		# Returns global test type record in DB
		$saved_db = DbUtil::switchToGlobal();
		$query_string =
			"SELECT * FROM test_category_mapping WHERE test_category_id=$testTypeId AND user_id=$user_id LIMIT 1";
		$record = query_associative_one($query_string);
		return $record;
	}
	
	public function getMeasures()
	{
		# Returns list of measures included in a test type
		$saved_db = DbUtil::switchToGlobal();
		$query_string = 
			"SELECT measure_id FROM global_measures ".
			"WHERE test_id=$this->testId";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
		{
			$measure_obj = GlobalMeasure::getById($record['measure_id']);
			$retval[] = $measure_obj;
		}
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public function getMeasureIds()
	{
		# Returns list of measure IDs included in a test type
		$saved_db = DbUtil::switchToGlobal();
		$query_string = 
			"SELECT measure_id FROM global_measures ".
			"WHERE test_id=$this->testId";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record) {
			$retval[] = $record['measure_id'];
		}
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	/*
	public static function deleteById($test_type_id)
	{
		# Deletes test type from database
		# 1. Delete entries in lab_config_test_type
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"DELETE FROM lab_config_test_type WHERE test_type_id=$test_type_id";
		query_blind($query_string);
		# 2. Delete entries from specimen_test
		$query_string =
			"DELETE FROM specimen_test WHERE test_type_id=$test_type_id";
		query_blind($query_string);
		# 3. Set disabled flag in test_type entry
		$query_string =
			"UPDATE test_type SET disabled=1 WHERE test_type_id=$test_type_id";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	*/
}

class GlobalMeasure
{
	# For each test indicator in 'measure' table
	
	public $measureId;
	public $name;
	public $unit;
	public $description;
	public $range;
	public $testId;
	
	public static $RANGE_ERROR = 0;
	public static $RANGE_OPTIONS = 1;
	public static $RANGE_NUMERIC = 2;
	public static $RANGE_MULTI = 3;
	public static $RANGE_AUTOCOMPLETE = 4;

	
	public static function getObject($record) {
		# Converts a measure record in DB into a Measure object
		if($record == null)
			return null;
		$measure = new GlobalMeasure();
		$measure->measureId = $record['measure_id'];
		$measure->name = $record['name'];
		$measure->unit = $record['unit'];
		//$measure->description = $record['description'];
		$measure->userId = $record['user_id'];
		$measure->testId = $record['test_id'];
		$measure->range = $record['range'];
		return $measure;
	}
	
	public function getName() {
		global $CATALOG_TRANSLATION;
		if($CATALOG_TRANSLATION === true) {
			return LangUtil::getMeasureName($this->measureId);
		}
		else {
			return $this->name;
		}
	}
	
	public function getRangeType()
	{
		if(strpos($this->range, "_") !== false)
		{
			return GlobalMeasure::$RANGE_AUTOCOMPLETE;
		}
		else if(strpos($this->range, ":") !== false)
		{
			return GlobalMeasure::$RANGE_NUMERIC;
		}
		else if(strpos($this->range, "*") !== false)
		{
			return GlobalMeasure::$RANGE_MULTI;
		}	
		else if(strpos($this->range, "/") !== false)
		{
			return GlobalMeasure::$RANGE_OPTIONS;
		}	
		else 
		{
			return GlobalMeasure::$RANGE_ERROR;
		}
	}
	
	/*
	public function getRangeValues($patient=null)
	{
		# Returns range values in a list
		
		$range_type = $this->getRangeType();
		$retval = array();
		switch($range_type)
		{
			case Measure::$RANGE_NUMERIC:
				# check if ref range is already configured
				$ref_range = null;
				if($patient != null)
				{	$ref_range = ReferenceRange::getByAgeAndSex($patient->getAgeNumber(), $patient->sex, $this->measureId, $_SESSION['lab_config_id']);
				
				}
				if($ref_range == null)
					# Fetch from default entry in 'measure' table
					$retval = explode(":", $this->range);
				else
					$retval = array($ref_range->rangeLower, $ref_range->rangeUpper);
				break;
			case Measure::$RANGE_OPTIONS:
			
			{
			$retval = explode("/", $this->range);
				
				foreach($retval as $key=>$value)
				{
				
				$retval[$key]=str_replace("#","/",$value);
				}
			break;
			}
			case Measure::$RANGE_AUTOCOMPLETE:
				$retval = explode("_", $this->range);
				foreach($retval as $key=>$value)
				{
				$retval[$key]=str_replace("#","_",$value);
				}
				break;
		}
		return $retval;
	}
	
	public function getRangeString($patient=null)
	{
		# Returns range in string for printing or displaying
		$retval = "";
		if
		(
			$this->getRangeType() == Measure::$RANGE_OPTIONS ||
			$this->getRangeType() == Measure::$RANGE_MULTI ||
			$this->getRangeType() == Measure::$RANGE_AUTOCOMPLETE
		)
		{
			$range_parts = explode("/", $this->range);
			# TODO: Display possible options for result indicator??
			$retval .= "-";
		}
		else if($this->getRangeType() == Measure::$RANGE_NUMERIC)
		{
			$ref_range = null;
			if($patient != null)
				$ref_range = ReferenceRange::getByAgeAndSex($patient->getAgeNumber(), $patient->sex, $this->measureId, $_SESSION['lab_config_id']);
			if($ref_range == null)
				# Fetch from default entry in 'measure' table
				$range_parts = explode(":", $this->range);
			else
				$range_parts = array($ref_range->rangeLower, $ref_range->rangeUpper);
			$retval .= "(".$range_parts[0]."-".$range_parts[1];
			if($this->range != null && trim($this->range) != "")
				$retval .= "  ".$this->unit;
			$retval .= ")";
		}
		
		return $range_parts;
	}
	
	public function getUnits()
	{
		return $this->unit;
	}
	*/
	
	public static function getById($measure_id)
	{
		# Returns a test measure by ID
		$saved_db = DbUtil::switchToLabConfigRevamp();
		if($measure_id == null || $measure_id < 0)
			return null;
		$query_string = "SELECT * FROM global_measures WHERE measure_id=$measure_id LIMIT 1";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		return GlobalMeasure::getObject($record);		
	}
	
	public function updateToDb()
	{
		# Updates an existing global measure entry in DB
		$saved_db = DbUtil::switchToGlobal();
		$query_string = 
			"UPDATE global_measures SET name='$this->name', range='$this->range', unit='$this->unit' ".
			"WHERE measure_id=$this->measureId";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	/*
	public function setInterpretation($inter)
	{
		# Updates an existing measure entry in DB
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"UPDATE measure SET description='$inter'".
			"WHERE measure_id=$this->measureId";
		query_blind($query_string);
		DbUtil::switchRestore($saved_db);
	}
	public function setNumericInterpretation($remarks_list,$id_list, $range_l_list, $range_u_list, $age_u_list, $age_l_list, $gender_list)
	{
		# Updates an existing measure entry in DB
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$count = 0;
		if($id_list[0]==-1)
		{
		foreach($range_l_list as $range_value)
				{
			//insert query
			$query_string="INSERT INTO NUMERIC_INTERPRETATION (range_u, range_l, age_u, age_l, gender, description, measure_id) ".
			"VALUES($range_u_list[$count],$range_l_list[$count],$age_u_list[$count],$age_l_list[$count],'$gender_list[$count]','$remarks_list[$count]',$this->measureId)";
			query_insert_one($query_string);
			$count++;
				}
		}
		else
		{
		foreach($range_l_list as $range_value)
			{
				if($id_list[$count]!=-2)
					{
						if($remarks_list[$count]=="")
							{
						//delete
						$query_string="DELETE FROM NUMERIC_INTERPRETATION WHERE id=$id_list[$count]";
						query_delete($query_string);
						}else
							{
							//update
						$query_string = 
						"UPDATE numeric_interpretation SET range_u=$range_u_list[$count], range_l=$range_l_list[$count], age_u=$age_u_list[$count], age_l=$age_l_list[$count], gender='$gender_list[$count]' , description='$remarks_list[$count]' ".
						"WHERE id=$id_list[$count]";
						query_update($query_string);
						
						}
				}else
					{
					$query_string="INSERT INTO numeric_interpretation (range_u, range_l, age_u, age_l, gender, description, measure_id) ".
			"VALUES($range_u_list[$count],$range_l_list[$count],$age_u_list[$count],$age_l_list[$count],'$gender_list[$count]','$remarks_list[$count]',$this->measureId)";
			query_insert_one($query_string);
				}
		
		$count++;
		}
	}
	DbUtil::switchRestore($saved_db);
	}
	
	public function getNumericInterpretation()
	{
	$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = "SELECT * FROM numeric_interpretation WHERE measure_id=$this->measureId";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if($resultset!=NULL)
			{
			foreach($resultset as $record)
			{
				$range_u=$record['range_u'];
				$range_l=$record['range_l'];
				$age_u=$record['age_u'];
				$age_l=$record['age_l'];
				$gender=$record['gender'];
				$id=$record['id'];
				$description=$record['description'];
				$measure_id=$record['measure_id'];
				$retval[] =array($range_l,$range_u,$age_l,$age_u,$gender,$description,$id,$measure_id);
			}
			
		}else
			{
		//get interpretation ka loop
			}
	DbUtil::switchRestore($saved_db);
	return $retval;
	}
	
	public function addToDb()
	{
		# Updates an existing measure entry in DB
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$query_string = 
			"INSERT INTO measure (name, range, unit) ".
			"VALUES ('$this->name', '$this->range', '$this->unit')".
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}
	*/
	
	public function getReferenceRanges($user_id)
	{
		# Fetches reference ranges from database for this measure
		$saved_db = DbUtil::switchToGlobal();
		$query_string = "SELECT * FROM reference_range_global WHERE measure_id=$this->measureId AND user_id=$user_id ORDER BY sex DESC";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		if ($resultset!=NULL)
		{
			foreach($resultset as $record)
			{
				$retval[] = ReferenceRangeGlobal::getObject($record);
			}
		}	
			DbUtil::switchRestore($saved_db);
			return $retval;
	}
	
	/*
	public function getInterpretation()
	{	
		$retval= array();
		$numeric_description=array();
		if(trim($this->description) == "" || $this->description == null)
			return $retval;
		else 
		{
		$description=substr(($this->description),2);
		if(strpos($description,"##")===false)
		$retval=explode("//" , $description);
		else
		$retval=explode("##",$description);
		}
		
		return $retval;
	}
	
	public function getDescription()
	{
		if(trim($this->description) == "" || $this->description == null)
			return "-";
		else
			return trim($this->description);
	} */
}

class ReferenceRangeGlobal
{
	public $id;
	public $measureId;
	public $ageMin;
	public $ageMax;
	public $sex;
	public $rangeLower;
	public $rangeUpper;
	public $userId;
	
	public static function getObject($record)
	{
		if($record == null)
			return null;
		$reference_range = new ReferenceRangeGlobal();
		if(isset($record['id']))
			$reference_range->id = $record['id'];
		else
			$reference_range->id = null;
		if(isset($record['measure_id']))
			$reference_range->measureId = $record['measure_id'];
		else
			$reference_range->measureId = null;
		if(isset($record['age_min']))
			$reference_range->ageMin = intval($record['age_min']);
		else
			$reference_range->ageMin = null;
		if(isset($record['age_max']))
			$reference_range->ageMax = intval($record['age_max']);
		else
			$reference_range->ageMax = null;
		if(isset($record['sex']))
			$reference_range->sex = $record['sex'];
		else
			$reference_range->sex = null;
		if(isset($record['range_lower']))
			$reference_range->rangeLower = $record['range_lower'];
		else
			$reference_range->rangeLower = null;
		if(isset($record['range_upper']))
			$reference_range->rangeUpper = $record['range_upper'];
		else
			$reference_range->rangeUpper = null;
		return $reference_range;
	}
	
	public function addToDb($user_id)
	{
		# Adds this entry to database
		$saved_db = DbUtil::switchToGlobal();
		$query_string = 
			"INSERT INTO reference_range_global (measure_id, age_min, age_max, sex, range_lower, range_upper, user_id) ".
			"VALUES ($this->measureId, '$this->ageMin', '$this->ageMax', '$this->sex', '$this->rangeLower', '$this->rangeUpper', $user_id)";
		//;
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public static function deleteByMeasureId($measure_id)
	{
		# Deletes all entries for the given measure
		# Used when deleting the measure from catalof
		# Or when resetting ranges (from test_type_edit.php)
		$saved_db = DbUtil::switchToGlobal();
		$query_string = "DELETE FROM reference_range_global WHERE measure_id=$measure_id";
		query_delete($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public static function getByAgeAndSex($age, $sex, $measure_id, $user_id)
	{
		# Fetches the reference range based on supplied age and sex values
		$saved_db = DbUtil::switchToGlobal();
		$query_string = "SELECT * FROM reference_range_global WHERE measure_id=$measure_id AND user_id=$user_id";
		$retval = null;
		$resultset = query_associative_all($query_string, $row_count);
		if($resultset == null || count($resultset) == 0)
			return $retval;
		foreach($resultset as $record)
		{
			$ref_range = ReferenceRangeGlobal::getObject($record);
			if($ref_range->ageMin == 0 && $ref_range->ageMax == 0)
			{
				# No agewise split
				if($ref_range->sex == "B" || strtolower($ref_range->sex) == strtolower($sex))
				{
					return $ref_range;
				}
			}
			else if($ref_range->ageMin <= $age && $ref_range->ageMax >= $age)
			{
				# Age wise split exists
				if($ref_range->sex == "B" || strtolower($ref_range->sex) == strtolower($sex))
				{
					return $ref_range;
				}
			}
		}
		DbUtil::switchRestore($saved_db);
	}
}

class GlobalInfectionReport
{
	public $id;
	public $testId;
	public $measureId;
	public $groupByGender;
	public $groupByAge;
	public $ageGroups;
	public $measureGroups;
	public $userId;
	
	public static function getObject($record)
	{
		if($record == null)
			return null;
		$retval = new GlobalInfectionReport();
		$retval->userId = $record['user_id'];
		$retval->testId = $record['test_id'];
		$retval->measureId = $record['measure_id'];
		$retval->groupByGender = $record['group_by_gender'];
		$retval->groupByAge = $record['group_by_age'];
		if(isset($record['age_groups']))
			$retval->ageGroups = $record['age_groups'];
		if(isset($record['measure_groups']))
			$retval->measureGroups = $record['measure_groups'];
		return $retval;
	}
	
	public function addToDb()
	{
		$infectionReportSettings = $this;
		$saved_db = DbUtil::switchToGlobal();
		# Remove existing entry
		$query_string =
			"DELETE FROM infection_report_settings ".
			"WHERE user_id=$this->userId ".
			"AND test_id=$this->testId ".
			"AND measure_id=$this->measureId";
		query_blind($query_string);
		# Add updated entry
		$query_string = 
			"INSERT INTO infection_report_settings( ".
				"id, ".
				"user_id, ".
				"test_id, ".
				"measure_id, ".
				"group_by_gender, ".
				"group_by_age, ".
				"age_groups, ".
				"measure_groups ".
			") ".
			"VALUES ( ".
				"$infectionReportSettings->id, ".
				"$infectionReportSettings->userId, ".
				"$infectionReportSettings->testId, ".
				"$infectionReportSettings->measureId, ".
				"$infectionReportSettings->groupByGender, ".
				"$infectionReportSettings->groupByAge, ".
				"'$infectionReportSettings->ageGroups', ".
				"'$infectionReportSettings->measureGroups' ".
			")";
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}
	
	public static function getByKeys($user_id, $test_type_id, $measure_id)
	{
		# Fetches a record by compound key
		$saved_db = DbUtil::switchToGlobal();
		$query_string =
			"SELECT * FROM infection_report_settings ".
			"WHERE user_id=$user_id ".
			"AND test_id=$test_type_id ".
			"AND measure_id=$measure_id LIMIT 1";
		$record = query_associative_one($query_string);
		$retval = GlobalInfectionReport::getObject($record);
		DbUtil::switchRestore($saved_db);
		return $retval;
	}
	
	public function getAgeGroupAsList()
	{
		# Returns the age_group field as a PHP list
		$age_parts = explode(",", $this->ageGroups);
		$retval = array();
		foreach($age_parts as $age_part)
		{
			if(trim($age_part) == "")
				continue;
			$age_bounds = explode(":", $age_part);
			$retval[] = $age_bounds;
		}
		return $retval;
	}
	
	public function getMeasureGroupAsList()
	{
		# Returns the measure_group field as a PHP list
		$measure_parts = explode(",", $this->measureGroups);
		$retval = array();
		foreach($measure_parts as $measure_part)
		{
			if(trim($measure_part) == "")
				continue;
			$measure_bounds = explode(":", $measure_part);
			$retval[] = $measure_bounds;
		}
		return $retval;
	}
}

class GlobalPatient
{
	public $patientId; 
	public $addlId;
	public $name;
	public $dob;
	public $partialDob;
	public $age;
	public $sex;
	public $surrogateId; # surrogate key (user facing)
	public $createdBy; # user ID who registered this patient
	public $hashValue; # hash value for this patient (based on name, dob, sex)
	public $regDate;
	public static function getObject($record)
	{
		# Converts a patient record in DB into a Patient object
		if($record == null)
			return null;
		$patient = new Patient();
		$patient->patientId = $record['patient_id'];
		$patient->addlId = $record['addl_id'];
		$patient->name = $record['name'];
		$patient->dob = $record['dob'];
		$patient->age = $record['age'];
		$patient->sex = $record['sex'];
		$date_parts = explode(" ", date($record['ts']));
		$date_parts_1=explode("-",$date_parts[0]);
		$patient->regDate=$date_parts_1[2]."-".$date_parts_1[1]."-".$date_parts_1[0];
		
		if(isset($record['partial_dob']))
			$patient->partialDob = $record['partial_dob'];
		else
			$patient->partialDob = null;
		if(isset($record['surr_id']))
			$patient->surrogateId = $record['surr_id'];
		else
			$patient->surrogateId = null;
		if(isset($record['created_by']))
			$patient->createdBy = $record['created_by'];
		else
			$patient->createdBy = null;
		if(isset($record['hash_value']))
			$patient->hashValue = $record['hash_value'];
		else
			$patient->hashValue = null;
		return $patient;
	}
	
	public static function checkNameExists($name, $country)
	{
		# Checks if the given patient name (or similar match) already exists
		$saved_db = DbUtil::switchToCountry($country);
		$query_string = 
			"SELECT COUNT(patient_id) AS val FROM patient WHERE name LIKE '%$name%'";
		$resultset = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		if($resultset == null || $resultset['val'] == 0)
			return false;
		else
			return true;
	}
	
	public function getName()
	{
		if(trim($this->name) == "")
			return " - ";
		else
			return $this->name;
	}
	
	public function getAddlId()
	{
		if($this->addlId == "")
			return " - ";
		else
			return $this->addlId;
	}
	
	public function getAssociatedTests() {
		if( $this->patientId == "" )
			return " - ";
		else {
			$query_string = "SELECT t.test_type_id FROM test t, specimen sp ".
							"WHERE t.result <> '' ".
							"AND t.specimen_id=sp.specimen_id ".
							"AND sp.patient_id=$this->patientId";
			$recordset = query_associative_all($query_string, $row_count);
			foreach( $recordset as $record ) {
				$testName = get_test_name_by_id($record['test_type_id']);
				$result .= $testName."<br>";
			}
			return $result;
		}
	}
	
	public function getAge()
	{
		# Returns patient age value
		if($this->partialDob == "" || $this->partialDob == null)
		{
			if($this->dob != null && $this->dob != "")
			{
				# DoB present in patient record
				return DateLib::dobToAge($this->dob);
			}
			else 
			{	$age_value=-1*$this->age;
				if($age_value>100){
					$age_value=200-$age_value;
					$age_value=">".$age_value;
					}
				else
					{
					$diff=$age_value%10;
					$age_range1=$age_value-$diff;
					$age_range2=$age_range1+10;
					$age_value=$age_range1."-".$age_range2;
					}
					if($this->age < 0)
				$this->age=$age_value;
				return $this->age." ".LangUtil::$generalTerms['YEARS'];
			}
		}
		else
		{
			# Calculate age from partial DoB
			$aprrox_dob = "";
			if(strpos($this->partialDob, "-") === false)
			{
				# Year-only specified
				$approx_dob = trim($this->partialDob)."-01-01";
			}
			else
			{
				# Year and month specified
				$approx_dob = trim($this->partialDob)."-01";
			}
			return DateLib::dobToAge($approx_dob);
		}
	}
	
	public function getAgeNumber()
	{
		# Returns patient age value (numeric part alone)
		if($this->partialDob == "" || $this->partialDob == null)
		{
			if($this->dob != null && $this->dob != "")
			{
				# DoB present in patient record
				return DateLib::dobToAgeNumber($this->dob);
			}
			else
			{	if($this->age<100)
					$this->age=200+$this->age;
				else if($this->age<0)
					$this->age=-1*$this->age;
			
				return $this->age;
			}
		}
		else
		{
			# Calculate age from partial DoB
			$aprrox_dob = "";
			if(strpos($this->partialDob, "-") === false)
			{
				# Year-only specified
				$approx_dob = trim($this->partialDob)."-01-01";
			}
			else
			{
				# Year and month specified
				$approx_dob = trim($this->partialDob)."-01";
			}
			return DateLib::dobToAgeNumber($approx_dob);
		}
	}
	
	public function getDob()
	{
		# Returns patient dob value
		if($this->partialDob != null && $this->partialDob != "")
		{
			return $this->partialDob." (".LangUtil::$generalTerms['APPROX'].")";
		}
		else if($this->dob == null || trim($this->dob) == "")
		{
			return " - ";
		}
		else
		{
			return DateLib::mysqlToString($this->dob);
		}
	}
	
	public static function getByAddDate($date)
	{
		# Returns all patient records added on that date
		$query_string = 
			"SELECT * FROM patient ".
			"WHERE ts LIKE '%$date%' ORDER BY patient_id";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
			$retval[] = Patient::getObject($record);
		return $retval;
	}
	
	public static function getByAddDateRange($date_from, $date_to)
	{
		# Returns all patient records added on that date range
		$query_string = 
			"SELECT * FROM patient ".
			"WHERE UNIX_TIMESTAMP(ts) >= UNIX_TIMESTAMP('$date_from 00:00:00') ".
			"AND UNIX_TIMESTAMP(ts) <= UNIX_TIMESTAMP('$date_to 23:59:59') ".
			"ORDER BY patient_id";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		foreach($resultset as $record)
			$retval[] = Patient::getObject($record);
		return $retval;
	}
	
	public static function getByRegDateRange($date_from , $date_to)
	{
	$query_string =
			"SELECT DISTINCT patient_id FROM specimen ".
			"WHERE date_collected BETWEEN '$date_from' AND '$date_to'";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		$record_p=array();
			foreach($resultset as $record)
			{
				foreach($record as $key=>$value)
				$query_string = "SELECT * FROM patient WHERE patient_id=$value";
				$record_each= query_associative_one($query_string);
				$record_p[]=Patient::getObject($record_each);
			}
		return $record_p;	
	
	}

	public static function getReportedByRegDateRange($date_from , $date_to)
	{
		$emp="";
		$query_string =
				"SELECT DISTINCT patient_id FROM specimen , test ".
				"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
				"AND result!='$emp' ".
				"AND specimen.specimen_id=test.specimen_id";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		$record_p=array();
		$count = 0;
		foreach($resultset as $record)
		{
			foreach($record as $key=>$value) {
				$query_string = "SELECT * FROM patient WHERE patient_id=$value";
				$record_each= query_associative_one($query_string);
				$record_p[]=Patient::getObject($record_each);
			}
		}
		return $record_p;	
	
	}
	

	public static function getUnReportedByRegDateRange($date_from , $date_to)
	{
		$emp="";
		$query_string =
			"SELECT DISTINCT patient_id FROM specimen , test ".
			"WHERE date_collected BETWEEN '$date_from' AND '$date_to' ".
			"AND result='$emp' ".
			"AND specimen.specimen_id=test.specimen_id";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = array();
		$record_p=array();
		foreach($resultset as $record) {
			foreach($record as $key=>$value)
				$query_string = "SELECT * FROM patient WHERE patient_id=$value";
			$record_each= query_associative_one($query_string);
			$record_p[]=Patient::getObject($record_each);
		}
		return $record_p;
	}

	
	public static function getById($patient_id)
	{
		# Returns patient record by ID
		$query_string = "SELECT * FROM patient WHERE patient_id=$patient_id";
		$record = query_associative_one($query_string);
		//return 1;
		return Patient::getObject($record);
	}
	
	public function getSurrogateId()
	{
		if($this->surrogateId == null || trim($this->surrogateId) == "")
			return "-";
		else
			return $this->surrogateId;
	}
	
	public function getDailyNum()
	{
		# Returns daily number ("patient number")
		# Fetches value from the latest specimen which was assigned to this patient
		$query_string =
			"SELECT s.daily_num FROM specimen s, patient p ".
			"WHERE s.patient_id=p.patient_id ".
			"AND p.patient_id=$this->patientId ".
			"ORDER BY s.date_collected DESC";
		$record = query_associative_one($query_string);		
		$retval = "";
		if($record == null || trim($record['daily_num']) == "")
			$retval = "-";
		else
			$retval = $record['daily_num'];
		return $retval;
	}

	public function generateHashValue()
	{
		# Generates hash value for this patient (based on name, age and date of birth)
		$name_part = strtolower(str_replace(" ", "", $this->name));
		$sex_part = strtolower($this->sex);
		$dob_part = "";
		if($this->partialDob != null && trim($this->partialDob) != "")
		{	
			# Determine unix timestamp based on partial (approximate) date of birth
			$approx_dob = "";
			if(strpos($this->partialDob, "-") === false)
			{
				# Year-only specified
				$approx_dob = trim($this->partialDob)."-01-01";
			}
			else
			{
				# Year and month specified
				$approx_dob = trim($this->partialDob)."-01";
			}
			list($year, $month, $day) = explode('-', $approx_dob);
			$dob_part = mktime(0, 0, 0, $month, $day, $year);
		}
		else
		{
			# Determine unix timestamp based on complete data of birth
			$dob = $this->dob;
			list($year, $month, $day) = explode('-', $dob);
			$dob_part = mktime(0, 0, 0, $month, $day, $year);
		}
		$hash_input = $name_part.$dob_part.$sex_part;
		# TODO: Provide choice of hashing schemes
		$retval = sha1($hash_input);
		return $retval;
	}
	
	public function getHashValue()
	{
		$retval = $this->hashValue;
		return $retval;
	}
	
	public function getSex()
	{
	$sex=$this->sex;
	
	return $sex;
	}
	
	public function setHashValue($hash_value)
	{
		if($hash_value == null || trim($hash_value) == "")
			return;
		$query_string = 
			"UPDATE patient SET hash_value='$hash_value' ".
			"WHERE patient_id=$this->patientId";
		query_update($query_string);
	}
}

/** 
	Aggregation Helper Functions 
*/
function getTestCatName_by_cat_id($lab_config_id, $cat_id){
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_string =
	"select name from test_category where test_category_id=$cat_id";
	$record = query_associative_one($query_string);
	$catName = $record['name'];
	DbUtil::switchRestore($saved_db);
	# Return category name of the record just inserted
	return $catName;
}


function addAggregateMeasure($measure, $range, $testId, $userId, $unit)
{
	# Adds a new measure to catalog
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"SELECT MAX(measure_id) AS measure_id FROM global_measures ".
		"WHERE user_id=$userId";
	$record = query_associative_one($query_string);
	$measureId = intval($record['measure_id']) + 1;
	$query_string = 
		"INSERT INTO global_measures (name, range, test_id, user_id, unit, measure_id ) ".
		"VALUES ('$measure', '$range', $testId, $userId, '$unit', $measureId)";
	query_insert_one($query_string);
	DbUtil::switchRestore($saved_db);
	# Return measure id of the record just inserted
	return $measureId;
}

function getAggregateTestTypeById($testTypeId) {
	return TestTypeMapping::getById($testTypeId);
}

function updateAggregateTestType($updated_entry, $userId) {
	# Updates test type mapping info in DB catalog
	$saved_db = DbUtil::switchToGlobal();
	$existing_entry = getAggregateTestTypeById($updated_entry->testTypeId);
	if($existing_entry == null) {
		# No record found
		DbUtil::switchRestore($saved_db);
		return;
	}
	$query_string =
		"UPDATE test_mapping ".
		"SET name='$updated_entry->name' ".
		"WHERE user_id=$userId ";
	query_blind($query_string);
	/*
	# Delete entries for removed compatible specimens
	$existing_list = get_compatible_specimens($updated_entry->testTypeId);
	foreach($existing_list as $specimen_type_id)
	{
		if(in_array($specimen_type_id, $new_specimen_list))
		{
			# Compatible specimen not removed
			# Do nothing
		}
		else
		{
			# Remove entry from mapping table
			$query_del = 
				"DELETE from specimen_test ".
				"WHERE test_type_id=$updated_entry->testTypeId ".
				"AND specimen_type_id=$specimen_type_id";
			query_blind($query_del);
		}
	}
	# Add entries for new compatible specimens
	foreach($new_specimen_list as $specimen_type_id)
	{
		if(in_array($specimen_type_id, $existing_list))
		{
			# Entry already exists
			# Do nothing
		}
		else
		{
			# Add entry in mapping table
			$query_ins = 
				"INSERT INTO specimen_test (specimen_type_id, test_type_id) ".
				"VALUES ($specimen_type_id, $updated_entry->testTypeId)";
			query_blind($query_ins);
		}
	}
	*/
	DbUtil::switchRestore($saved_db);
}

function getAggregateTestTypeByName($testName)
{
	# Returns test type record in DB
	$saved_db = DbUtil::switchToGlobal();
	$test_name = addslashes($test_name);
	$query_string =
		"SELECT * FROM test_mapping WHERE test_name='$testName' LIMIT 1";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	return TestTypeMapping::getObject($record);
}

function getAggregateMeasureById($measureId)
{
	# Returns Measure object from DB
	$saved_db = DbUtil::switchToGlobal();
	$query_measure = 
		"SELECT * FROM global_measures WHERE measure_id=$measureId LIMIT 1";
	$record = query_associative_one($query_measure);
	$retval = GlobalMeasure::getObject($record);
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function getTestTypesCountryLevel() {
	$saved_db = DbUtil::switchToLabConfigRevamp();
	$user_id = $_SESSION['user_id'];
	$retval = array();
	$query = "SELECT * FROM test_mapping where user_id =".$user_id;
	$resultset = query_associative_all($query, $count);
	foreach($resultset as $record) {
		$retval[] = TestTypeMapping::getObject($record);
	}
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function addTestCategoryAgg($cat_name, $cat_descr="")
{
	# Adds a new test category to catalog
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"INSERT INTO test_category(name, description) ".
		"VALUES ('$cat_name', '$cat_descr')";
	query_insert_one($query_string);
	# Return primary key of the record just inserted
	DbUtil::switchRestore($saved_db);
	return get_max_test_cat_id();
}

function updateTestMappingWithCategory($testId, $catCode) {
	$saved_db = DbUtil::switchToGlobal();
	/*
	$query_string = 
		"SELECT test_category_id ".
		"FROM test_category_mapping ".
		"WHERE lab_id_test_category_id='$catCode' ";
	$record = query_associative_one($query_string);
	if($record != null)
		$testCategoryId = $record['test_category_id'];
	*/
	$query_string = 
		"UPDATE test_mapping ".
		"SET test_category_id=$catCode ".
		"WHERE test_id=$testId ";
	query_update($query_string);
	DbUtil::switchRestore($saved_db);
}

function getTestCategoryAggNameById($cat_id)
{
	# Returns test category name as string
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"SELECT test_category_name FROM test_category_mapping ".
		"WHERE test_category_id=$cat_id LIMIT 1";
	$record = query_associative_one($query_string);
	$retval = LangUtil::$generalTerms['NOTKNOWN'];
	if($record != null)
		$retval = $record['test_category_name'];
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function getLabMeasureIdFromGlobalMeasureId($labConfigId, $globalTestType, $currentMeasureCount) {
	$saved_db = DbUtil::switchToGlobal();
	$query_string = 
		"SELECT lab_id_test_id FROM test_mapping ".
		"WHERE test_id=$globalTestType->testId ";
	$record = query_associative_one($query_string);
	$labIdTestIds = explode(";",$record['lab_id_test_id']);
	foreach( $labIdTestIds as $labIdTestId ) {
		$labIdTestIdsSeparated = explode(":",$labIdTestId);
		$labId = $labIdTestIdsSeparated[0];
		$testId = $labIdTestIdsSeparated[1];
		$testIds[$labId] = $testId;
	}
	$testTypeId = $testIds[$labConfigId];
	$svdb = DbUtil::switchToLabConfig($labConfigId);
	$query_string =
		"SELECT * from test_type_measure ".
		"WHERE test_type_id=$testTypeId";
	$resultset = query_associative_all($query_string, $count);
	$measureCount = 0;
	foreach($resultset as $record) {
		if($measureCount == $currentMeasureCount) {
			$measureId = $record['measure_id'];
			DbUtil::switchRestore($saved_db);
			return $measureId;
		}
		++$measureCount;
	}
	DbUtil::switchRestore($saved_db);
}

function getLabMeasureIdFromGlobalName($measureName, $labConfigId) {
	$saved_db = DbUtil::switchToGlobal();
	$userId= $_SESSION['user_id'];
	$query_string = 
		"SELECT lab_id_measure_id FROM measure_mapping ".
		"WHERE measure_name='$measureName' ".
		"AND user_id=$userId LIMIT 1";
	$record = query_associative_one($query_string);
	$measureIds = array();
	$labIdMeasureIds = explode(";",$record['lab_id_measure_id']);
	foreach( $labIdMeasureIds as $labIdMeasureId ) {
		$labIdMeasureIdsSeparated = explode(":",$labIdMeasureId);
		$labId = $labIdMeasureIdsSeparated[0];
		$measureId = $labIdMeasureIdsSeparated[1];
		$measureIds[$labId] = $measureId;
	}
	DbUtil::switchRestore($saved_db);
	return $measureIds[$labConfigId];
}

/** 
	DB Merging Helper Functions Begin Here
*/
function searchPatientByName($q) {
	$user = get_user_by_id($_SESSION['user_id']);
	$country = strtolower($user->country);
	$saved_db = DbUtil::switchToCountry($country);
	# Searches for patients with exact name in the global database
	$query_string = 
		"SELECT * FROM patient ".
		"WHERE name LIKE '$q'";
	$record = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	if( $record )
		$patient = Patient::getObject($record);
	else 
		$patient = null;
	return $patient;
}

function autoImportPatientEntry($importPatient, $patientName) {
	$query_string = 
		"SELECT * FROM patient ".
		"WHERE name LIKE '$patientName'";
	$record = query_associative_one($query_string);	
	
	if( $record ) {
		$saved_db = DbUtil::switchToGlobal();
		$userId = $_SESSION['user_id'];
		$query = "SELECT * FROM lab_config_access where user_id = $userId";
		$record = query_associative_one($query);
		$labConfigId = $record['lab_config_id'];
	
		$currentLabPatient = Patient::getObject($record);
		$globalPatientId = $importPatient->patientId;
		$importLabConfigId = substr($globalPatientId, 0, 3);
		
		if( $importLabConfigId == $labConfigId )
			return;
		
		$subValue = $importLabConfigId."00000000000";
		$importPatientIdStr = bcsub($globalPatientId, $subValue);
		$importPatientId = intval($importPatientIdStr);
		
		$saved_db = DbUtil::switchToLabConfig($importLabConfigId); 

		$querySelect = 
			"SELECT * FROM specimen ".
			"WHERE patient_id=$importPatientId";
		$resultset = query_associative_all($querySelect, $rowCount);
	
		if($resultset) {
			foreach($resultset as $record)
				$specimenRecords[] = Specimen::getObject($record);
			

			foreach($specimenRecords as $specimenRecord) {
				$querySelect = 
					"SELECT * FROM test ".
					"WHERE specimen_id=$specimenRecord->specimenId";
				$resultset = query_associative_all($querySelect, $rowCount);
				foreach($resultset as $record)
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
	
		$i=0;
		if($specimenRecords) {
			foreach($specimenRecords as $specimenRecord) {
				$saved_db = DbUtil::switchToLabConfig($importLabConfigId); 
				$querySelect = 
					"SELECT * FROM test ".
					"WHERE specimen_id=$specimenRecord->specimenId";
				$resultset = query_associative_all($querySelect, $rowcount);
				DbUtil::switchRestore($saved_db);
				$specimenRecord->specimenId = get_max_specimen_id() + 1;
				$specimenRecord->patientId = $currentLabPatient->patientId;
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
		}
		DbUtil::switchRestore($saved_db);
	}
}

function getLabIdFromGlobalPatientId($patientId, $country) {
	if( $country == 'cameroon') {
		if( strstr($patientId, "128"))
			return 128;
		else if ( strstr($patientId, "129") )
			return 129;
		else
			return 131;
	}
}

# nc40
function getTestCountGroupedConfig($lab_config_id)
{
		/*$query_string =
			"SELECT * FROM report_disease ".
			"WHERE lab_config_id = 9999009";
                 * 
                 */
                $nineID = 9999009;
                $query_string = "SELECT * FROM report_config WHERE landscape = $nineID";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$record = query_associative_one($query_string);
                if($record == '')
                {
                    /*
                    $query_string_add = "INSERT INTO report_disease (group_by_age, group_by_gender, age_groups, measure_groups, measure_id, lab_config_id, test_type_id) VALUES (1, 1, '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', 1, 9999009, 1)";
                    query_insert_one($query_string_add);
                    $record = query_associative_one($query_string);
                     
                     */
                    $query_string_add = "INSERT INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, landscape ) VALUES ('Grouped Test Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', '1', '1', '1', '1', '0', '$nineID' , '0', $nineID)";
                    query_insert_one($query_string_add);
                    $record = query_insert_one($query_string);
                    $query_string = "SELECT * FROM report_config WHERE landscape = $nineID";
                        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
                        $record = query_associative_one($query_string);
                }
                
                
		DbUtil::switchRestore($saved_db);
                $retval = array();
                /*$byAge = $configArray['group_by_age'];
                $age_group_list = decodeAgeGroups($configArray['age_groups']);
                $byGender = $configArray['group_by_gender'];
                $bySection = $configArray['measure_id'];
                $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending */
                
                $retval['group_by_age'] = intval($record['p_fields']); //group_by_age
                $retval['age_groups'] = $record['footer']; //age_groups
                $retval['group_by_gender'] = intval($record['s_fields']); //group_by_gender
                $retval['measure_id'] = intval($record['t_fields']); //group_by_section
                $retval['test_type_id'] = intval($record['p_custom_fields']); //combo
                
		return $retval;
                
}

function getTestCountGroupedConfigCountryDir($lab_config_id)
{
	/*$query_string =
	"SELECT * FROM report_disease ".
	"WHERE lab_config_id = 9999009";
     * 
     */
    $nineID = 9999009;
    $query_string = "SELECT * FROM report_config WHERE landscape = $nineID";
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$record = query_associative_one($query_string);
    if($record == '')
    {
        /*
        $query_string_add = "INSERT INTO report_disease (group_by_age, group_by_gender, age_groups, measure_groups, measure_id, lab_config_id, test_type_id) VALUES (1, 1, '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', 1, 9999009, 1)";
        query_insert_one($query_string_add);
        $record = query_associative_one($query_string);
         
         */
        $query_string_add = "INSERT INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, landscape, age_unit ) VALUES ('Grouped Test Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', '1', '1', '1', '1', '0', '$nineID' , '0', $nineID, 4)";
        query_insert_one($query_string_add);
        $record = query_insert_one($query_string);
        $query_string = "SELECT * FROM report_config WHERE landscape = $nineID";
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
        $record = query_associative_one($query_string);
    }
                
                
	DbUtil::switchRestore($saved_db);
    $retval = array();
    /*$byAge = $configArray['group_by_age'];
    $age_group_list = decodeAgeGroups($configArray['age_groups']);
    $byGender = $configArray['group_by_gender'];
    $bySection = $configArray['measure_id'];
    $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending */
    
    $retval['group_by_age'] = intval($record['p_fields']); //group_by_age
    $retval['age_groups'] = $record['footer']; //age_groups
    $retval['group_by_gender'] = intval($record['s_fields']); //group_by_gender
    $retval['measure_id'] = intval($record['t_fields']); //group_by_section
    $retval['test_type_id'] = intval($record['p_custom_fields']); //combo
    $retval['age_unit'] = intval($record['age_unit']); //the unit of age represented by integer [1: Years, 2: Months, 3: Weeks, 4: Days]           
	return $retval;
                
}

# nc40
function decodeAgeGroups($ageGroups)
	{
		# Returns the age_group field as a PHP list
		$age_parts = explode(",", $ageGroups);
		$retval = array();
		foreach($age_parts as $age_part)
		{
			if(trim($age_part) == "")
				continue;
			$age_bounds = explode(":", $age_part);
			$retval[] = $age_bounds;
		}
		return $retval;
	}

 # nc40       
function getSpecimenCountGroupedConfig($lab_config_id)
{
                $nineID = 9999019;
                $query_string = "SELECT * FROM report_config WHERE landscape = $nineID";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$record = query_associative_one($query_string);
                if($record == '')
                {
                    /*
                    $query_string_add = "INSERT INTO report_disease (group_by_age, group_by_gender, age_groups, measure_groups, measure_id, lab_config_id, test_type_id) VALUES (1, 1, '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', 1, 9999009, 1)";
                    query_insert_one($query_string_add);
                    $record = query_associative_one($query_string);
                     
                     */
                    $query_string_add = "INSERT INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, landscape ) VALUES ('Grouped Specimen Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', '1', '1', '1', '1', '0', '$nineID' , '0', $nineID)";
                    query_insert_one($query_string_add);
                    $record = query_insert_one($query_string);
                    $query_string = "SELECT * FROM report_config WHERE landscape = $nineID";
                        $saved_db = DbUtil::switchToLabConfig($lab_config_id);
                        $record = query_associative_one($query_string);
                }
                
                
		DbUtil::switchRestore($saved_db);
                $retval = array();
                /*$byAge = $configArray['group_by_age'];
                $age_group_list = decodeAgeGroups($configArray['age_groups']);
                $byGender = $configArray['group_by_gender'];
                $bySection = $configArray['measure_id'];
                $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending */
                
                $retval['group_by_age'] = intval($record['p_fields']); //group_by_age
                $retval['age_groups'] = $record['footer']; //age_groups
                $retval['group_by_gender'] = intval($record['s_fields']); //group_by_gender
                $retval['measure_id'] = intval($record['t_fields']); //group_by_section
                $retval['test_type_id'] = intval($record['p_custom_fields']); //combo
                
		return $retval;
}

function getSpecimenCountGroupedConfigCountryDir($lab_config_id)
{
    $nineID = 9999019;
    $query_string = "SELECT * FROM report_config WHERE landscape = $nineID";
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$record = query_associative_one($query_string);
    if($record == '')
    {
        /*
        $query_string_add = "INSERT INTO report_disease (group_by_age, group_by_gender, age_groups, measure_groups, measure_id, lab_config_id, test_type_id) VALUES (1, 1, '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', 1, 9999009, 1)";
        query_insert_one($query_string_add);
        $record = query_associative_one($query_string);
         
         */
        $query_string_add = "INSERT INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, landscape, age_unit ) VALUES ('Grouped Specimen Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', '1', '1', '1', '1', '0', '$nineID' , '0', $nineID, 4)";
        query_insert_one($query_string_add);
        $record = query_insert_one($query_string);
        $query_string = "SELECT * FROM report_config WHERE landscape = $nineID";
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);
            $record = query_associative_one($query_string);
    }
            
            
	DbUtil::switchRestore($saved_db);
    $retval = array();
    /*$byAge = $configArray['group_by_age'];
    $age_group_list = decodeAgeGroups($configArray['age_groups']);
    $byGender = $configArray['group_by_gender'];
    $bySection = $configArray['measure_id'];
    $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending */
    
    $retval['group_by_age'] = intval($record['p_fields']); //group_by_age
    $retval['age_groups'] = $record['footer']; //age_groups
    $retval['group_by_gender'] = intval($record['s_fields']); //group_by_gender
    $retval['measure_id'] = intval($record['t_fields']); //group_by_section
    $retval['test_type_id'] = intval($record['p_custom_fields']); //combo
    $retval['age_unit'] = intval($record['age_unit']); //the unit of age represented by integer [1: Years, 2: Months, 3: Weeks, 4: Days]

	return $retval;
}

# nc40
function updateGroupedReportsConfig($byAge, $byGender, $ageGroups, $bySection, $combo, $entryID, $lab_config_id)
	{
                $saved_db = DbUtil::switchToLabConfig($lab_config_id);		
                
                if($entryID == 9999019)
                    $header = "Grouped Specimen Count Report Configuration";
                else
                    $header = "Grouped Test Count Report Configuration";
                
                # Remove existing entry
		$query_string =
			"DELETE FROM report_config ".
			"WHERE landscape = $entryID ";
			
		query_blind($query_string);
		
                # Add updated entry
		$query_string = 
			"INSERT INTO report_config( ".
				"header, ".
				"footer, ".
				"margins, ".
				"p_fields, ".
				"s_fields, ".
				"t_fields, ".
				"p_custom_fields, ".
                                "s_custom_fields, ".
                                "test_type_id, ".
                                "title, ".
                                "landscape ".
			") ".
			"VALUES ( ".
				"'$header', ".
				"'$ageGroups', ".
				"'0', ".
				"'$byAge', ".
				"'$byGender', ".
				"'$bySection', ".
				"'$combo', ".
                                "'0', ".
                                "'$entryID', ".
                                "'0', ".
                                "$entryID ".
			")";
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}
     
     function updateGroupedReportsConfigCountryDir($byAge, $byGender, $ageGroups, $bySection, $combo, $entryID, $lab_config_id, $age_unit)
	{
                $saved_db = DbUtil::switchToLabConfig($lab_config_id);		
                
                if($entryID == 9999019)
                    $header = "Grouped Specimen Count Report Configuration";
                else
                    $header = "Grouped Test Count Report Configuration";
                
                # Remove existing entry
		$query_string =
			"DELETE FROM report_config ".
			"WHERE landscape = $entryID ";
			
		query_blind($query_string);
		
                # Add updated entry
		$query_string = 
			"INSERT INTO report_config( ".
				"header, ".
				"footer, ".
				"margins, ".
				"p_fields, ".
				"s_fields, ".
				"t_fields, ".
				"p_custom_fields, ".
                                "s_custom_fields, ".
                                "test_type_id, ".
                                "title, ".
                                "landscape, ".
                                "age_unit ".
			") ".
			"VALUES ( ".
				"'$header', ".
				"'$ageGroups', ".
				"'0', ".
				"'$byAge', ".
				"'$byGender', ".
				"'$bySection', ".
				"'$combo', ".
                                "'0', ".
                                "'$entryID', ".
                                "'0', ".
                                "$entryID, ".
                                "$age_unit ".
			")";
		query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}   
        #nc44
        function getTestRecordsByDate($date, $test_type_id)
	{
		global $con;
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		$date = mysql_real_escape_string($date, $con);
		$query_string =
			"SELECT * FROM test ".
			"WHERE test_type_id=$test_type_id ".
			"AND ts > FROM_UNIXTIME($date) ";
		$retval = array();
		$resultset = query_associative_all($query_string, $row_count);
		foreach($resultset as $record)
			$retval[] = Test::getObject($record);
		return $retval;
	}
        
        function updateTestRecordByIds($test_id, $result)
	{
            //$count_tests = count($test_ids);
            //for($i = 0; $i < $count_tests; $i++)
            //{
		$query_string =
			"UPDATE test SET result='$result' ".
			"WHERE test_id=$test_id ";
                query_update($query_string);
            //}
	}

        function getTestRecordsByDatee($date)
	{
		# Returns all test records added on that day
		global $con;
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		$date = mysql_real_escape_string($date, $con);
		$query_string =
			"SELECT * FROM test ".
			"Where ts > From_UNIXTIME($date) ";
			//"AND result<>''";
		$retval = array();
		$resultset = query_associative_all($query_string, $row_count);
                
		foreach($resultset as $record)
			$retval[] = $record['test_id'];
		return $retval;
	}
        
        function get_test_date_by_id($test_type_id, $lab_config_id=null)
{
	global $con;
	$test_type_id = mysql_real_escape_string($test_type_id, $con);
	$lab_config_id = mysql_real_escape_string($lab_config_id, $con);
	# Returns test type name string
	global $CATALOG_TRANSLATION;
	if($CATALOG_TRANSLATION === true)
	return LangUtil::getTestName($test_type_id);
	else
	{
		$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
		$query_string = 
			"SELECT date(ts) FROM test_type ".
			"WHERE test_type_id=$test_type_id LIMIT 1";
		$record = query_associative_one($query_string);
		DbUtil::switchRestore($saved_db);
		if($record == null)
			return LangUtil::$generalTerms['NOTKNOWN'];
		else
			return $record['date(ts)'];
	}
}

function getSubmeasureIDs($id)
        {
            //$id = $this->measureId;
            $tagID = "\$sub*".$id."/\$";
            $submeasureList = array();
             $query_string =
			"SELECT * FROM measure ";
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$recordset = query_associative_all($query_string);
                DbUtil::switchRestore($saved_db);
                foreach( $recordset as $record ) 
                {
				$measureName = $record['name'];
                                $smID = intval($record['measure_id']);
                                if(strpos($measureName, $tagID) !== false)
                                {
                                    array_push($submeasureList, $smID);
                                }
		}
                return $submeasureList;
        }
        
        
function setBaseConfig($from_id, $to_id)
{
    $saved_db = DbUtil::switchToLabConfig($to_id);
    
    $query_string = "DELETE FROM test_category WHERE test_category_id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".test_category";
    $dbnn = "blis_".$to_id.".test_category";
    $query_string = "INSERT INTO ".$dbnn." (test_category_id, name, description) SELECT test_category_id, name, description FROM ".$dbn;
    query_insert_one($query_string);
    
    $query_string = "DELETE FROM measure WHERE measure_id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".measure";
    $dbnn = "blis_".$to_id.".measure";
    $query_string = "INSERT INTO ".$dbnn." (measure_id, name, unit_id, range, description, unit) SELECT measure_id, name, unit_id, range, description, unit FROM ".$dbn;
    query_insert_one($query_string);
    
    $query_string = "DELETE FROM specimen_type WHERE specimen_type_id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".specimen_type";
    $dbnn = "blis_".$to_id.".specimen_type";
    $query_string = "INSERT INTO ".$dbnn." (specimen_type_id, name, description) SELECT specimen_type_id, name, description FROM ".$dbn;
    query_insert_one($query_string);
    
    $query_string = "DELETE FROM reference_range WHERE id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".reference_range";
    $dbnn = "blis_".$to_id.".reference_range";
    $query_string = "INSERT INTO ".$dbnn." (id, measure_id, age_min, age_max, sex, range_lower, range_upper) SELECT id, measure_id, age_min, age_max, sex, range_lower, range_upper FROM ".$dbn;
    query_insert_one($query_string);
    
    $query_string = "DELETE FROM test_type WHERE test_type_id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".test_type";
    $dbnn = "blis_".$to_id.".test_type";
    $query_string = "INSERT INTO ".$dbnn." (test_type_id, name, description, test_category_id, is_panel, disabled, clinical_data, hide_patient_name, prevalence_threshold, target_tat) SELECT test_type_id, name, description, test_category_id, is_panel, disabled, clinical_data, hide_patient_name, prevalence_threshold, target_tat FROM ".$dbn;
    query_insert_one($query_string);
  
    $query_string = "DELETE FROM test_type_measure WHERE test_type_id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".test_type_measure";
    $dbnn = "blis_".$to_id.".test_type_measure";
    $query_string = "INSERT INTO ".$dbnn." (test_type_id, measure_id) SELECT test_type_id, measure_id FROM ".$dbn;
    query_insert_one($query_string);
    
    $query_string = "DELETE FROM unit WHERE unit_id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".unit";
    $dbnn = "blis_".$to_id.".unit";
    $query_string = "INSERT INTO ".$dbnn." (unit_id, unit) SELECT unit_id, unit FROM ".$dbn;
    query_insert_one($query_string);
    
    $query_string = "DELETE FROM custom_field_type WHERE id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".custom_field_type";
    $dbnn = "blis_".$to_id.".custom_field_type";
    $query_string = "INSERT INTO ".$dbnn." (id, field_type) SELECT id, field_type FROM ".$dbn;
    query_insert_one($query_string);
    
    /*
    $query_string = "DELETE FROM labtitle_custom_field WHERE id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".labtitle_custom_field";
    $dbnn = "blis_".$to_id.".labtitle_custom_field";
    $query_string = "INSERT INTO ".$dbnn." (id, field_name, field_options, field_type_id) SELECT id, field_name, field_options, field_type_id FROM ".$dbn;
    query_insert_one($query_string);
    */
    
    $query_string = "DELETE FROM patient_custom_field WHERE id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".patient_custom_field";
    $dbnn = "blis_".$to_id.".patient_custom_field";
    $query_string = "INSERT INTO ".$dbnn." (id, field_name, field_options, field_type_id) SELECT id, field_name, field_options, field_type_id FROM ".$dbn;
    query_insert_one($query_string);
    
    $query_string = "DELETE FROM specimen_custom_field WHERE id > 0";
    query_blind($query_string);
    $dbn = "blis_".$from_id.".specimen_custom_field";
    $dbnn = "blis_".$to_id.".specimen_custom_field";
    $query_string = "INSERT INTO ".$dbnn." (id, field_name, field_options, field_type_id) SELECT id, field_name, field_options, field_type_id FROM ".$dbn;
    query_insert_one($query_string);
    
    DbUtil::switchRestore($saved_db);
    
}   

function setBaseConfigSpecimens($from_id, $to_id)
{
    # test_category table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM test_category ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
    $query_string = "DELETE FROM test_category WHERE test_category_id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['test_category_id'];
        $val2 = $rec['name'];
        $val3 = $rec['description'];
        $query_string = "INSERT INTO test_category (test_category_id, name, description) VALUES ($val1, '$val2', '$val3') ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
    
    # measure table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM measure ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
     $query_string = "DELETE FROM measure WHERE measure_id > 0";
    query_blind($query_string);
    /*foreach($recordset as $rec)
    {
        // $intLat = !empty($intLat) ? "'$intLat'" : "NULL";
        $val1 = $rec['measure_id'];
        $val2 = $rec['name'];
        $val3 = db_prep_int($rec['unit_id'], 1);
        $val4 = $rec['range'];
        $val5 = db_prep_string($rec['description']);
        $val6 = db_prep_string($rec['unit']);
        $val1 = !empty($val1) ? $val1 : NULL;
        $val2 = !empty($val2) ? $val2 : "";
        $val3 = !empty($val3) ? $val3 : NULL;
        $val4 = !empty($val4) ? $val4 : NULL;
        $val5 = !empty($val5) ? "$val5" : NULL;
        $val6 = !empty($val6) ? "$val6" : NULL;

        echo "---->".$val1."@".$val2."@".$val3."@".$val4."@".$val5."@".$val6."@"."<br><br>";
        $query_string = "INSERT INTO measure (measure_id, name, unit_id, range, description, unit) VALUES ($val1, '$val2', $val3, '$val4', '$val5', '$val6')";
        ."<br>";
        query_insert_one($query_string);
    }*/
    $dbn = "blis_".$from_id.".measure";
    $dbnn = "blis_".$to_id.".measure";
     $query_string = "INSERT INTO ".$dbnn." (measure_id, name, unit_id, range, description, unit) SELECT measure_id, name, unit_id, range, description, unit FROM ".$dbn;
     query_insert_one($query_string);
    DbUtil::switchRestore($saved_db);
    return;
    
    
    # specimen_type table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM specimen_type ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
     $query_string = "DELETE FROM specimen_type WHERE specimen_type_id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['specimen_type_id'];
        $val2 = $rec['name'];
        $val3 = $rec['description'];
        $query_string = "INSERT INTO specimen_type (specimen_type_id, name, description) VALUES ($val1, '$val2', '$val3') ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
    
    # reference_range table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM reference_range ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
     $query_string = "DELETE FROM reference_range WHERE id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['id'];
        $val2 = $rec['measure_id'];
        $val3 = $rec['age_min'];
        $val4 = $rec['age_max'];
        $val5 = $rec['sex'];
        $val6 = $rec['range_lower'];
        $val7 = $rec['range_upper'];
        $query_string = "INSERT INTO reference_range (id, measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES ($val1, $val2, '$val3', '$val4', '$val5', '$val6', '$val7') ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
    
    # test_type table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM test_type ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
     $query_string = "DELETE FROM test_type WHERE test_type_id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['test_type_id'];
        $val2 = $rec['name'];
        $val3 = $rec['description'];
        $val4 = $rec['test_category_id'];
        $val5 = $rec['is_panel'];
        $val6 = $rec['disabled'];
        $val7 = $rec['clinical_data'];
        $val8 = $rec['hide_patient_name'];
        $val9 = $rec['prevalence_threshold'];
        $val10 = $rec['target_tat'];
        $query_string = "INSERT INTO test_type (test_type_id, name, description, test_category_id, is_panel, disabled, clinical_data, hide_patient_name, prevalence_threshold, target_tat) VALUES ($val1, '$val2', '$val3', $val4, $val5, $val6, '$val7', $val8, $val9, $val10) ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
    
     # test_type_measure table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM test_type_measure ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
     $query_string = "DELETE FROM test_type_measure WHERE test_type_id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['test_type_id'];
        $val2 = $rec['measure_id'];
        $query_string = "INSERT INTO test_type_measure (test_type_id, measure_id) VALUES ($val1, $val2) ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
    
    # unit table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM unit ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
     $query_string = "DELETE FROM unit WHERE unit_id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['unit_id'];
        $val2 = $rec['unit'];
        $query_string = "INSERT INTO unit (unit_id, unit) VALUES ($val1, '$val2') ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
    
    # custom_field_type table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM custom_field_type ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
     $query_string = "DELETE FROM custom_field_type WHERE id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['id'];
        $val2 = $rec['field_type'];
        $query_string = "INSERT INTO custom_field_type (id, field_type) VALUES ($val1, '$val2') ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
 
    # labtitle_custom_field table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM labtitle_custom_field ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
     $query_string = "DELETE FROM labtitle_custom_field WHERE id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['id'];
        $val2 = $rec['field_name'];
        $val3 = $rec['field_options'];
        $val4 = $rec['field_type_id'];
        $query_string = "INSERT INTO labtitle_custom_field (id, field_name, field_options, field_type_id) VALUES ($val1, '$val2', '$val3', $val4) ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
    
    # patient_custom_field table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM patient_custom_field; ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
    $query_string = "DELETE FROM patient_custom_field WHERE id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['id'];
        $val2 = $rec['field_name'];
        $val3 = $rec['field_options'];
        $val4 = $rec['field_type_id'];
        $query_string = "INSERT INTO patient_custom_field; (id, field_name, field_options, field_type_id) VALUES ($val1, '$val2', '$val3', $val4) ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
    
    # specimen_custom_field table
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $query_string =
			"SELECT * FROM specimen_custom_field; ";
    $recordset = query_associative_all($query_string, $row_count);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
    $query_string = "DELETE FROM specimen_custom_field WHERE id > 0";
    query_blind($query_string);
    foreach($recordset as $rec)
    {
        $val1 = $rec['id'];
        $val2 = $rec['field_name'];
        $val3 = $rec['field_options'];
        $val4 = $rec['field_type_id'];
        $query_string = "INSERT INTO specimen_custom_field; (id, field_name, field_options, field_type_id) VALUES ($val1, '$val2', '$val3', $val4) ";
        query_insert_one($query_string);
    }
    DbUtil::switchRestore($saved_db);
}

function import_test_between_labs($test_id, $from_id, $to_id)
{
    //echo "<pre>";
    $tt = new TestType();
    $test_type = new TestType();
    $saved_db = DbUtil::switchToLabConfig($from_id);
    $test_type = $tt->getById($test_id);
    //print_r($test_obj);
    if(is_null($test_type)){
        echo "Could not load test ID: ".$test_id;
        return;
    }

    $measure_objs = $test_type->getMeasures();
    //print_r($measure_objs);
    DbUtil::switchRestore($saved_db);
    
    $saved_db = DbUtil::switchToLabConfig($to_id);
    //$test_type->testTypeId;
    $test_name = $test_type->name;
    $test_descr = $test_type->description;
    $clinical_data = $test_type->clinical_data;
    $cat_code = $test_type->testCategoryId;
    $hide_patient_name = $test_type->hidePatientName;
    $prevalenceThreshold = $test_type->prevalenceThreshold;
    $targetTat = $test_type->targetTat;
    $is_panel = $test_type->isPanel;
    $lab_config_id = $to_id;
    $new_test_id = add_test_type($test_name, $test_descr, $clinical_data, $cat_code, $is_panel, $lab_config_id, $hide_patient_name, $prevalenceThreshold, $targetTat);
    $subm_flags = array();
    $id_list = array();
    foreach($measure_objs as $mo)
    {
        if($mo->checkIfSubmeasure() == 0)
        {
            if($mo->getRangeType() == Measure::$RANGE_NUMERIC)
            {
                $m_id = add_measure($mo->name, $mo->range, $mo->unit);
                array_push($id_list, $m_id);
                if($mo->range == ':')
                {
                    //$ref = new ReferenceRange();
                    $refs = $mo->getReferenceRanges($from_id);
                    foreach($refs as $ref)
                    {
                        $ref->measureId = $m_id;
                        $ref->addToDb($to_id);
                    }
                }
            }
            else
            {
                $m_id = add_measure($mo->name, $mo->range, $mo->unit);
                array_push($id_list, $m_id);
            }
        }
        else
        {
            $dec_name = $mo->truncateSubmeasureTag();
            $enc_name = "\$sub*".$m_id."/$".$dec_name;
            $sm_id = add_measure($enc_name, $mo->range, $mo->unit);
            array_push($id_list, $sm_id);
        }
            
    }
    
    foreach($id_list as $measure_id)
    {
        add_test_type_measure($new_test_id, $measure_id);
    }
    DbUtil::switchRestore($saved_db);
    //echo "<pre>";
}

/***************************************************
 * Test Removal Module STARTS
***************************************************/
function remove_specimens($lid, $sp, $remarks, $category="test")
{
            $created_by = $_SESSION["user_id"];
            
            $saved_db = DbUtil::switchToLabConfig($lid);            
            
            $query_string = "INSERT INTO removal_record (r_id, type, remarks, user_id, status, category) ".
                            "VALUES ($sp, 1, '$remarks', $created_by, 1, '$category')";
            //;
            query_insert_one($query_string);
            
            DbUtil::switchRestore($saved_db);
}
  
function get_removed_specimens($lid, $category="test")
{
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT * from removal_record WHERE type = 1 AND category='$category' AND status = 1";
            
            $recordset = query_associative_all($query_string, $row_count);
            
            DbUtil::switchRestore($saved_db);
            
            return $recordset;
}

function retrieve_deleted_items($lid, $sp, $category="test"){
	$lab_config_id = $lid;
	
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	if($category == "patient"){
		$specimen_list = get_specimens_by_patient_id($sp);
		if(sizeof($specimen_list)>0){
			foreach($specimen_list as $specimen){
				retrieve_deleted_items($lid,$specimen->specimenId, "specimen");
			}
			
		}
	} else if($category == "specimen"){
		$testsList = get_tests_by_specimen_id($sp);
		if(sizeof($testsList)>0){
			foreach($testsList as $test){
				retrieve_deleted_items($lid, $test->testId );
			}
		}
	}
	    $query_string = "UPDATE removal_record SET status = 0 WHERE r_id = $sp AND category='$category' AND status = 1 AND type = 1";
		//."<br/>";
	    query_update($query_string);
    
	DbUtil::switchRestore($saved_db);
	return 1;
}

function retrieve_specimens($lid, $sp, $category="test")
{
        $lab_config_id = $lid;
            
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);  
    
        $query_string = "UPDATE removal_record SET status = 0 WHERE r_id = $sp AND category='$category' AND status = 1 AND type = 1";
            query_update($query_string);
            
        DbUtil::switchRestore($saved_db);
}

function check_removal_record($lid, $sp, $category="test")
{
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT count(*) as val from removal_record WHERE type = 1 AND category='$category' AND status = 1 AND r_id = $sp";
            
            //;
            $recordset = query_associative_one($query_string);
            //."<br/>";
            DbUtil::switchRestore($saved_db);
            return $recordset['val'];
}

function get_date_of_latest_test_type_cost_update($test_type_id)
{
    $lab_config_id = $_SESSION['lab_config_id'];
    
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);
    
    $query_string = "SELECT earliest_date_valid FROM test_type_costs WHERE test_type_id=$test_type_id ORDER BY earliest_date_valid DESC LIMIT 1";
    
    $result = query_associative_one($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    return $result['earliest_date_valid'];
}

function instantiate_new_cost_of_test_type($cost, $test_type_id)
{
    $lab_config_id = $_SESSION['lab_config_id'];
        
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);
    
    $query_string = "SELECT count(*) AS val FROM test_type_costs WHERE test_type_id=$test_type_id";
    
    $count = query_associative_one($query_string);
    
    DbUtil::switchRestore($saved_db);
    
    if ($count['val'] != 0) {
        return 0;
    }
    
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);

    $query_string = "INSERT INTO test_type_costs (amount, test_type_id) VALUES ($cost, $test_type_id)";

    query_insert_one($query_string);

    DbUtil::switchRestore($saved_db);
    
    return 1;
}

function insert_new_cost_of_test_type($cost, $test_type_id)
{
    $lab_config_id = $_SESSION['lab_config_id'];

    $date = get_date_of_latest_test_type_cost_update($test_type_id);
    $formatted_date = strtotime(date("Y-m-d", strtotime($date)));
    $today = strtotime(date("Y-m-d"));
    if ($formatted_date == $today) {
        $now = date("Y-m-d");

        $saved_db = DbUtil::switchToLabConfig($lab_config_id);

        $query_string = "UPDATE test_type_costs SET amount=$cost WHERE test_type_id=$test_type_id AND earliest_date_valid >= $now";

        query_update($query_string);

        DbUtil::switchRestore($saved_db);
    } else {
        $saved_db = DbUtil::switchToLabConfig($lab_config_id);

        $query_string = "INSERT INTO test_type_costs (amount, test_type_id) VALUES ($cost, $test_type_id)";
        query_insert_one($query_string);

        DbUtil::switchRestore($saved_db);
    }
    
    return 1;
}

function get_latest_cost_of_test_type($test_type_id)
{
    instantiate_new_cost_of_test_type(0.00, $test_type_id);

    $lab_config_id = $_SESSION['lab_config_id'];
    
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);
    
    $query_string = "SELECT amount FROM test_type_costs WHERE ".
                    "test_type_id=$test_type_id ORDER BY earliest_date_valid DESC LIMIT 1";
    $result = query_associative_one($query_string);
   
    DbUtil::switchRestore($saved_db);
    return $result['amount'];
}

function get_cost_of_test_type_for_closest_date($date, $test_type_id)
{
    instantiate_new_cost_of_test_type(0.00, $test_type_id);
    
    $date = date("Y-m-d H:i:s", strtotime($date));
	
    $lab_config_id = $_SESSION['lab_config_id'];
    
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);

    $query_string = "SELECT amount, earliest_date_valid FROM test_type_costs WHERE test_type_id=$test_type_id AND earliest_date_valid<='$date' ORDER BY earliest_date_valid DESC LIMIT 1";
    
    $result = query_associative_one($query_string);
    
    DbUtil::switchRestore($saved_db);

    return $result;
}

function get_all_tests_for_patient_and_date_range($patient_id, $small_date, $large_date, $labsection=0)
{
    $lab_config_id = $_SESSION['lab_config_id'];
    
    $large_date = date("Y-m-d H:i:s", strtotime($large_date) + 86400); // Gives us a range from the day we want to the next day.
    $small_date = date("Y-m-d H:i:s", strtotime($small_date));
    
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);
    
	if($labsection == 0){
		$query_string = "SELECT DISTINCT test_id, ts FROM test WHERE specimen_id IN (SELECT specimen_id FROM specimen WHERE patient_id=$patient_id) AND ts<='$large_date' AND ts>='$small_date'";
    } else {
		$query_string = "SELECT DISTINCT t.test_id, t.ts FROM test t, test_type tt ". 
						 "WHERE t.specimen_id IN (SELECT specimen_id FROM specimen WHERE patient_id=$patient_id) ".
						 "AND t.test_type_id IN (SELECT test_type_id from test_type where test_category_id=$labsection) AND t.ts<='$large_date' AND t.ts>='$small_date'";
	}
	
    $result = query_associative_all($query_string, $_count);
    
    DbUtil::switchRestore($saved_db);
    
    return $result;
}

function get_test_names_and_costs_from_ids($id_array)
{
    $name_array = array();
    $cost_array = array();
    $ids = array();
    if (!empty($id_array)) {
        foreach ($id_array as $id) {
            $test_type_id = get_test_type_id_from_test_id($id);
            $ids[] = $test_type_id;
            $name_array[] = get_test_name_by_id($test_type_id);
            $date = get_test_date_by_id($test_type_id);
            $cost = get_latest_cost_of_test_type($test_type_id);
            $cost_array[] = $cost;
        }
    }
    $ret_array = array();
    $ret_array['costs'] = $cost_array;
    $ret_array['names'] = $name_array;
    
    return $ret_array;
}

function get_cost_of_test($test)
{
	$cost = get_cost_of_test_type_for_closest_date($test->timestamp, $test->testTypeId);
	
	return $cost;
}

function generate_bill_data_for_patient_and_date_range($patient_id, $first_date, $second_date, $labsection=0)
{
	//echo "Lab Section ".$labsection;
	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
    $test_info = get_all_tests_for_patient_and_date_range($patient_id, $first_date, $second_date, $labsection);
	DbUtil::switchRestore($saved_db);
	
    $test_ids = array();
    $test_dates = array();
    foreach ($test_info as $test) {
        $test_ids[] = $test['test_id'];
        $test_dates[] = date("Y-m-d", strtotime($test['ts']));
    }
    $saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
    $names_and_costs = get_test_names_and_costs_from_ids($test_ids);
    DbUtil::switchRestore($saved_db);
	$bill_total = array_sum($names_and_costs['costs']);
    $bill_fields = array();
    $bill_fields['total'] = $bill_total;
    $bill_fields['names'] = $names_and_costs['names'];
    $bill_fields['costs'] = $names_and_costs['costs'];
    $bill_fields['dates'] = $test_dates;
    
    return $bill_fields;
}

function get_test_type_id_from_test_id($test_id)
{
    $lab_config_id = $_SESSION['lab_config_id'];
    
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);
    
    $query_string = "SELECT test_type_id FROM test WHERE test_id=$test_id";
    
    $result = query_associative_one($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    return $result['test_type_id'];
}

/***************************
 * Billing Functions
 ***************************/
 
function functional_number_to_editable_money($number)
{
	$string = get_currency_delimiter_from_lab_config_settings(); // i.e. get DDD(.)CC
	
	$dollars = floor($number); // i.e. get (DDD).CC
	$cents = $number - $dollars; // i.e. get DDD.(CC)
	
	$cents_as_whole_number = get_cents_as_whole_number($cents); // turn 0.(CC) into (CC).0
	
	$string = $dollars . $string . $cents; // i.e. (DDD)(.)(CC) = DDD.CC
	
	return $string;
}

function editable_money_to_functional_number($string)
{
	$delimiter = get_currency_delimiter_from_lab_config_settings();
	
	$values = explode($delimiter, $string);
	$dollars = $values[0];
	$cents = $values[1];
	
	$numeric_cents = get_cents_from_whole_number($cents); // turn (CC).0 into 0.(CC)
	$numeric_dollars = intval($dollars); // force dealing with an int to ensure no type problems arise.
	
	return $numeric_dollars + $nuermic_cents;
}

function format_number_to_money($number)
{
    $dollars = floor($number);
    $cents = $number - $dollars;
    
    $cents_as_whole_number = get_cents_as_whole_number($cents);
    
    if ($cents_as_whole_number < 10)
        $cents_as_whole_number = "0" . strval($cents_as_whole_number);
    
    return $dollars . get_currency_delimiter_from_lab_config_settings() . $cents_as_whole_number . " " . get_currency_type_from_lab_config_settings();
}

function format_number_to_money_currencyName($number, $currencyName)
{
    $dollars = floor($number);
    $cents = $number - $dollars;
    
    $cents_as_whole_number = get_cents_as_whole_number($cents);
    
    if ($cents_as_whole_number < 10)
        $cents_as_whole_number = "0" . strval($cents_as_whole_number);
    
    return $dollars . get_currency_delimiter_from_lab_config_settings() . $cents_as_whole_number . " " . $currencyName;
}


function get_cents_as_whole_number($cents)
{
    return floor($cents * 100);
}

function get_cents_from_whole_number($cents)
{
	$cost_cents = floor(ltrim($cents, "0")); // Remove any leading zeroes in case the user typed 01 or similar.
	
	return $cost_cents / 100;
}


function insert_lab_config_settings_billing($enabled, $currency_name, $currency_delimiter)
{
    $id = 3; // ID for billing settings
    
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
    
    $query_string = "SELECT count(*) as val from lab_config_settings WHERE id = $id";
    $recordset = query_associative_one($query_string);
    
    if($recordset[val] != 0)
        return 0;
    
    $remarks = "Billing Settings";
    
    $query_string = "INSERT INTO lab_config_settings (id, flag1, setting1, setting2, remarks) ".
                            "VALUES ($id, $enabled, '$currency_name', '$currency_delimiter', '$remarks')";
    query_insert_one($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    return 1;
}

function get_lab_config_settings_billing()
{
    insert_lab_config_settings_billing(1, "USD", ".");
    $id = 3; // ID for billing settings
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
    $query_string = "SELECT * from lab_config_settings WHERE id = $id";
    $recordset = query_associative_one($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    $retval = array();
    
    // barcode settings = type, width, height, font_size
    
    $retval['enabled'] = $recordset['flag1'];
    $retval['currency_name'] = $recordset['setting1'];
    $retval['currency_delimiter'] = $recordset['setting2'];
    
    return $retval;
}

function update_lab_config_settings_billing($new_settings)
{
    $enable = $new_settings['enabled'];
    $currency_name = $new_settings['currency_name'];
    $currency_delimiter = $new_settings['currency_delimiter'];
    
    insert_lab_config_settings_billing(1, "USD", ".");
    $id = 3; // ID for billing settings
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
    
    if($enable != 0)
        $enable = 1;
        
    $query_string = "UPDATE lab_config_settings SET flag1=$enable, setting1='$currency_name', setting2='$currency_delimiter' WHERE id=$id";
    query_update($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    return 1;
}

function get_currency_type_from_lab_config_settings()
{
    $settings = get_lab_config_settings_billing();
    
    return $settings['currency_name'];
}

function get_currency_delimiter_from_lab_config_settings()
{
    $settings = get_lab_config_settings_billing();
    
    return $settings['currency_delimiter'];
}

function update_currency_name_in_lab_config_settings($new_currency)
{
    $settings = get_lab_config_settings_billing();
    
    $settings['currency_name'] = $new_currency;
   
    update_lab_config_settings_billing($settings);
    $lab_config_id = $_SESSION['lab_config_id'];
    currencyConfig::setDefaultCurrency($lab_config_id, $new_currency);
    return 1;
}

function update_currency_delimiter_in_lab_config_settings($new_delimiter)
{
    $settings = get_lab_config_settings_billing();
    
    $settings['currency_delimiter'] = $new_delimiter;
    
    update_lab_config_settings_billing($settings);
    
    return 1;
}

function get_selected_if_currency_is_used($currency)
{
    $currency_set = get_currency_type_from_lab_config_settings();
    
    if ($currency_set == $currency) {
        return "checked";
    } else {
        return "";
    }
}

function enable_billing()
{
    $current_state = get_lab_config_settings_billing();
    $current_state['enabled'] = 1;
    
    update_lab_config_settings_billing($current_state);
    
    return 1;
}

function disable_billing()
{
    $current_state = get_lab_config_settings_billing();
    $current_state['enabled'] = 0;
    
    update_lab_config_settings_billing($current_state);
    
    return 1;
}

function is_billing_enabled($lid)
{
    $current_state = get_lab_config_settings_billing();

    if ($current_state['enabled'] == "1") {
        return true;
    }
    return false;
}

/***************************************************
 * PDF Rendering Functions
 **************************************************/
function render_pdf_from_html($html, $page_title, $page_author)
{
    // This currently only renders a one-page document.  Any longer will break it.  TODO: Look into this.

    // Instantiate the pdf
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('BLIS');
    $pdf->SetTitle($page_title);
    $pdf->SetSubject($page_title);
    $pdf->SetKeywords("TCPDF, PDF, example, test, guide, $page_title, BLIS, html");
}


/***************************************************
 * Test Removal Module ENDS
***************************************************/

## Barcode Module Settings ##

function getBarcodeTypes()
{
    $types = "ean8,ean13,code11,code39,code128,codabar,std25,int25,code93";
    $codeList = explode(",", $types);
    return($codeList);
}

function insert_lab_config_settings_barcode($type, $width, $height, $textsize, $enable)
{
    $id = 1; // ID for barcode settings
    
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
    
    $query_string = "SELECT count(*) as val from lab_config_settings WHERE id = $id";
    $recordset = query_associative_one($query_string);        
    
    if($recordset[val] != 0)
        return 0;
    
    $remarks = "Barcode Settings";
    $query_string = "INSERT INTO lab_config_settings (id, flag1, flag2, flag3, flag4, setting1, remarks) ".
                            "VALUES ($id, $enable, $width, $height, $textsize, '$type', '$remarks')";
            query_insert_one($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    return 1;
}

function get_lab_config_settings_barcode()
{
    insert_lab_config_settings_barcode('code39', 2, 30, 11, 1);
    $id = 1; // ID for barcode settings
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
    $query_string = "SELECT * from lab_config_settings WHERE id = $id";
    $recordset = query_associative_one($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    $retval = array();
    
    // barcode settings = type, width, height, font_size
    
    $retval['enabled'] = $recordset['flag1'];
    $retval['width'] = $recordset['flag2'];
    $retval['height'] = $recordset['flag3'];
    $retval['textsize'] = $recordset['flag4'];
    $retval['type'] = $recordset['setting1'];
    
    return $retval;
}

function update_lab_config_settings_barcode($type, $width, $height, $textsize, $enable)
{
    insert_lab_config_settings_barcode('code39', 2, 30, 11, 1);
    $id = 1; // ID for barcode settings
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
    
    if($enable != 0)
        $enable = 1;    
        
    $query_string = "UPDATE lab_config_settings SET flag1 = $enable, flag2 = $width, flag3 = $height, flag4 = $textsize, setting1 = '$type' WHERE id = $id";
            query_update($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    return 1;
}


##  Barcode Module Setings Ends  ##

## Search Settings ##


function insert_lab_config_settings_search($num)
{
    $id = 2; // ID for search settings
    
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
    
    $query_string = "SELECT count(*) as val from lab_config_settings WHERE id = $id";
    $recordset = query_associative_one($query_string);        
    
    if($recordset[val] != 0)
        return 0;
    $remarks = "Search Settings";
    $query_string = "INSERT INTO lab_config_settings (id, flag1, remarks) ".
                            "VALUES ($id, $num, '$remarks')";
            query_insert_one($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    return 1;
}

function get_lab_config_settings_search()
{
    insert_lab_config_settings_search(20);
    $id = 2; // ID for search settings
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
    $query_string = "SELECT * from lab_config_settings WHERE id = $id";
    $recordset = query_associative_one($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    $retval = array();
    
    // search settings = results_per_page
    
    $retval['results_per_page'] = $recordset['flag1'];
    
    
    return $retval;
}

function update_lab_config_settings_search($num)
{
    insert_lab_config_settings_search(20);
    $id = 2; // ID for search settings
    $lab_config_id = $_SESSION['lab_config_id'];
            
    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
        
    $query_string = "UPDATE lab_config_settings SET flag1 = $num WHERE id = $id";
            query_update($query_string);
            
    DbUtil::switchRestore($saved_db);
    
    return 1;
}


## Search Settings End ##

function putUILog($id, $info, $file, $tag1, $tag2, $tag3)
{
    $uiLog = new UILog();
    $uiLog->id = $id;
    $uiLog->info = $info;
    $uiLog->file = $file;
    $uiLog->tag1 = $tag1;
    $uiLog->tag2 = $tag2;
    $uiLog->tag3 = $tag3;
    $uiLog->writeUILog();
}

class Inventory
{
        public $id;
	public $name;
	public $unit;
	public $remarks;
	public $quantity;
	        
        public function addReagent($name, $unit, $remarks)
        {
            $created_by = $_SESSION["user_id"];
            $lab_config_id = $_SESSION["lab_config_id"];
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);            
            
            $query_string = "INSERT INTO inv_reagent (name, unit, remarks, created_by) ".
                            "VALUES ('$name', '$unit', '$remarks', $created_by)";
            query_insert_one($query_string);
            
            DbUtil::switchRestore($saved_db);
        }
        
        public function editReagent()
        {
            
        }
        
        public function addStock($reagent_id, $lot, $e_date, $manu, $sup, $quant, $cost, $r_date, $remarks)
        {
            $created_by = $_SESSION["user_id"];
            $lab_config_id = $_SESSION["lab_config_id"];
            if($cost == '')
                $cost = 0;
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "INSERT INTO inv_supply (reagent_id, lot, expiry_date, manufacturer, supplier, quantity_ordered, quantity_supplied, cost_per_unit, user_id, date_of_order, date_of_supply, date_of_reception, remarks) ".
                            "VALUES ($reagent_id, '$lot', '$e_date', '$manu', '$sup', 0, $quant, $cost, $created_by, '$r_date', '$r_date', '$r_date', '$remarks')";
            query_insert_one($query_string);
            
            DbUtil::switchRestore($saved_db);
        }
        
        public function useStock($reagent_id, $lot, $quant, $u_date, $remarks)
        {
            $created_by = $_SESSION["user_id"];
            $lab_config_id = $_SESSION["lab_config_id"];
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "INSERT INTO inv_usage (reagent_id, lot, quantity_used, date_of_use, user_id, remarks) ".
                            "VALUES ($reagent_id, '$lot', $quant, '$u_date', $created_by, '$remarks')";
            query_insert_one($query_string);
            
            DbUtil::switchRestore($saved_db);
        }
        
        public function editStock()
        {
            
        }
        
        public function getQuantity($lid, $r_id)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT sum(quantity_supplied) as val from inv_supply where reagent_id = $r_id";
            $recordset = query_associative_one($query_string);
            $supply = $recordset['val'];
            
            $query_string = "SELECT sum(quantity_used) as val from inv_usage where reagent_id = $r_id";
            $recordset2 = query_associative_one($query_string);
            $usage = $recordset2['val'];
                        
            $quantity = $supply - $usage;
            
            DbUtil::switchRestore($saved_db);
            
            return $quantity;
        }
        
        public function checkReagent($lid, $name)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT count(*) as val from inv_reagent WHERE name = '$name'";
            $recordset = query_associative_one($query_string);
            $count = $recordset['val'];
            
            $check = 0;
            
            if($count > 0)
                $check = 1;
            
            DbUtil::switchRestore($saved_db);
           
            return $check;
        }
        
        public function checkLot($lid, $r_id, $lot)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT count(*) as val from inv_supply WHERE lot = '$lot' AND reagent_id = $r_id";
            $recordset = query_associative_one($query_string);
            $count = $recordset['val'];
            
            $check = 0;
            
            if($count > 0)
                $check = 1;
            
            DbUtil::switchRestore($saved_db);
            
            return $check;
        }
        
        public function getLotQuantity($lid, $r_id, $lot)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT * from inv_supply where reagent_id = $r_id AND lot = '$lot'";
            $recordset2 = query_associative_one($query_string);
            $quantity = $recordset2['quantity_supplied'];
            
            $query_string = "SELECT * from inv_usage where reagent_id = $r_id AND lot = '$lot'";
            $recordset = query_associative_all($query_string, $row_count);
            if(isset($recordset))
            foreach($recordset as $rec)
                $quantity = $quantity - $rec['quantity_used']; 
            
            DbUtil::switchRestore($saved_db);
            
            return $quantity;
        }
        
        public function getStockDetails($lid, $r_id)
        {
           
        }
        
        public function getReagentById($lid, $r_id)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT * from inv_reagent WHERE id = $r_id";
            $recordset = query_associative_one($query_string);
            
            DbUtil::switchRestore($saved_db);
            
            return $recordset;
        }
        
        public function getLot($lid, $r_id, $lot)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT * from inv_supply WHERE reagent_id = $r_id AND lot = '$lot'";
            $recordset = query_associative_one($query_string);
            
            DbUtil::switchRestore($saved_db);
            
            return $recordset;
        }
        
        public function getLot2($lid, $r_id, $lot)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT count(*) as val from inv_supply WHERE reagent_id = $r_id AND lot = '$lot'";
            $rc = query_associative_one($query_string);            
            
            $query_string = "SELECT * from inv_supply WHERE reagent_id = $r_id AND lot = '$lot'";
            $recordset = query_associative_one($query_string);
            
            DbUtil::switchRestore($saved_db);
            if($rc['val'] > 0)
                return $recordset;
            else
                return -1;
        }
        
        public function getAllReagents($lid)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT * from inv_reagent";
            $recordset = query_associative_all($query_string, $row_count);
            
            DbUtil::switchRestore($saved_db);
            
            return $recordset;
        }
        
        public function getStocksList($lid, $r_id)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT * from inv_supply WHERE reagent_id = $r_id";
            $recordset = query_associative_all($query_string, $row_count);
            
            DbUtil::switchRestore($saved_db);
            
            return $recordset;
        }
        
        public function getReagentUnit($lid, $id)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);     
            
            $query_string = "SELECT unit from inv_reagent WHERE id=$id";
            $recordset = query_associative_one($query_string);
            
            DbUtil::switchRestore($saved_db);
            
            return $recordset['unit'];
        }
        
        public function updateReagent($lid, $r_id, $name, $unit, $remarks)
        {
            $lab_config_id = $lid;
            
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);    
            
            $query_string = "UPDATE inv_reagent SET name = '$name', unit = '$unit' , remarks = '$remarks' WHERE id = $r_id";
            query_update($query_string);
                                
            DbUtil::switchRestore($saved_db);            
        }
        
        public function updateStock($lid, $r_id, $lot, $n_lot, $e_date, $manu, $sup, $cost, $r_date, $remarks)
        {
            $lab_config_id = $lid;
            if($cost == '')
                $cost = 0;
            $saved_db = DbUtil::switchToLabConfig($lab_config_id);    
            
            $query_string = "UPDATE inv_supply SET lot='$n_lot', expiry_date='$e_date', manufacturer='$manu', supplier='$sup', cost_per_unit='$cost', date_of_reception='$r_date', remarks='$remarks' WHERE reagent_id = $r_id AND lot='$lot'";
            query_update($query_string);
                                
            $query_string = "UPDATE inv_usage SET lot='$n_lot' WHERE reagent_id = $r_id AND lot='$lot'";
            query_update($query_string);
            
            DbUtil::switchRestore($saved_db);
            
        }
        
        public function get_inv_supply_by_user($lid, $user)
        {
                    $lab_config_id = $lid;

                    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     

                    $query_string = "SELECT * from inv_supply WHERE user_id = $user";
                    $recordset = query_associative_all($query_string, $row_count);

                    DbUtil::switchRestore($saved_db);

                    return $recordset;
        }

        public function get_inv_usage_by_user($lid, $user)
        {
                    $lab_config_id = $lid;

                    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     

                    $query_string = "SELECT * from inv_usage WHERE user_id = $user";
                    $recordset = query_associative_all($query_string, $row_count);

                    DbUtil::switchRestore($saved_db);

                    return $recordset;
        }
        
}

/*****************************************
********** New Update Process ****************
*****************************************/
function checkVersionDataTable()
{
   $saved_db = DbUtil::switchToGlobal();
		
   /*$query = "SELECT * FROM version_data WHERE version = 'start_entry' LIMIT 1";
   $record = query_associative_one($query);
   if(!$record)
   {
       $code = 0;   #version entry doesnt exist
       DbUtil::switchRestore($saved_db);
       return $code;
   }
   */
   $code = 0;
   $query = "select 1 from version_data";
   $record = query_blind($query);
   if($record !== FALSE)
   {
       $code = 1;   #version_data table exists
   }
   DbUtil::switchRestore($saved_db);
   return $code; 
}
function checkUsernameAvailability($user_name){

}
function checkVersionDataEntry($vers)
{
   $saved_db = DbUtil::switchToGlobal();
		
   $query = "SELECT * FROM version_data WHERE version = '$vers' LIMIT 1";
   $record = query_associative_one($query);
   if(!$record)
   {
       $code = 0;   #version entry doesnt exist
   }
   else if($record['flag'] == 0)
   {
       $code = 1;  #version entry exists but update procedure incomplete
   }
   else if($record['flag'] > 0)
   {
       $code = 2;  #version entry exists and update procedure complete
   }
   DbUtil::switchRestore($saved_db);
   return $code; 
}

function checkVersionDataEntryExists($vers)
{
   $saved_db = DbUtil::switchToGlobal();
		
   $query = "SELECT * FROM version_data WHERE version = '$vers' LIMIT 1";
   $record = query_associative_one($query);
   if(!$record)
   {
       $code = 0;   #version entry doesnt exist
   }
   else
   {
       $code = 1;  #version entry exists implying db update has been completed and update procedure incomplete
   }
   
   DbUtil::switchRestore($saved_db);
   return $code; 
}


function setVersionDataFlag($fl, $vers)
{
   $code = 0;
   
   $saved_db = DbUtil::switchToGlobal();
   
   $query = "SELECT * FROM version_Data WHERE version = '$vers' LIMIT 1";
   $record = query_associative_one($query);
   
   if(!$record)
   {
       $code = 1;   #version entry doesnt exist
       DbUtil::switchRestore($saved_db);
       return $code;
   }
   else
   {
       $code = 2; #version entry exists
   }
   
   $query = "UPDATE version_data SET flag = $fl WHERE version = '$vers'";
   $ret = query_blind($query);
   if(!$ret)
   {
       $code = 3; #Error during updation of flag
   }
   else
   {
       $code = 4;
   }
   DbUtil::switchRestore($saved_db);
   return $code; 
}

function update_language_files(){
	$directories = scandir('../../local');
	foreach($directories as $directory){
		if($directory=='.' or $directory=='..' ){
			continue;
		}else{
			if (strpos($directory,'langdata_') !== false && is_dir("../../local/".$directory)) {
				copy("../Language/en.php","../../local/".$directory."/en.php");
				copy("../Language/en.xml","../../local/".$directory."/en.xml");
				
				copy("../Language/default.php","../../local/".$directory."/default.php");
				copy("../Language/default.xml","../../local/".$directory."/default.xml");
				
				copy("../Language/fr.php","../../local/".$directory."/fr.php");
				copy("../Language/fr.xml","../../local/".$directory."/fr.xml");
			}
	
		}
	}
	
}
function insertVersionDataEntry()
{
   
   $saved_db = DbUtil::switchToGlobal();
   global $VERSION;
   $vers = $VERSION;
   $status = 1;
   $uid = $_SESSION['user_id'];
   $query_string = "INSERT INTO version_data (version, status, user_id, i_ts) ".
                            "VALUES ('$vers', $status, $uid, NOW())";
   query_insert_one($query_string);
   
   
   DbUtil::switchRestore($saved_db);
}

#### BARCODE FUNCTIONS ####


function getPatientBarcodeDelim()
{
    $delim = 'X';
    return $delim;
}

function getSpecimenBarcodeDelim()
{
    $delim = 'X';
    return $delim;
}

function getInventoryBarcodeDelim()
{
    $delim = 'X';
    return $delim;
}

function patientReportBarcodeCheck()
{
    return 1;
}

function patientBarcodeCheck()
{
    return 1;
}

function specimenBarcodeCheck()
{
    return 1;
}

function patientSearchBarcodeCheck()
{
    return 1;
}

function specimenSearchBarcodeCheck()
{
    return 1;
}

function getPatientFromBarcode($patient_code)
{
    $pieces = decodePatientBarcode($patient_code);
    $patient_id = $pieces[1];
    $patientClass = new Patient();
    $patient = $patientClass->getById($patient_id);
    return $patient;
}

function search_patients_by_db_id_count($patient_code, $labsection)
{
    $patient = getPatientFromBarcode($patient_code);
    $count = 0;
    if($labsection == 0){
    if($patient != NULL)
        $count = 1;
    } else {
    	$query_string = "select count(distinct patient.patient_id) as val from patient, specimen ".
    			"where patient.patient_id like '$patient->patientId' and patient.patient_id = specimen.patient_id ".
    			"and specimen.specimen_id in ".
    			"(select specimen_id from specimen where specimen_type_id in ".
    			"(select specimen_type_id from specimen_test where test_type_id in ".
    			"(select test_type_id as lab_section from test_type where test_category_id = $labsection)))";
    	
    	$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);	
	$resultset = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
    	return $resultset['val'];
    }
    return $count;
}

function getSpecimenFromBarcode($specimen_code)
{
    $pieces = decodeSpecimenBarcode($specimen_code);
    $specimen_id = $pieces[1];
    $patientClass = new Patient();
    $patient = $patientClass->getById($patient_id);
    return $patient;
}

function decodeSpecimenBarcode($specimen_code)
{
    $specimen_code = strtoupper($specimen_code);
     $sdelim = getSpecimenBarcodeDelim();
     $pieces = explode($sdelim, $specimen_code);
     return $pieces;
}

function decodePatientBarcode($patient_code)
{
    $patient_code = strtoupper($patient_code);
     $pdelim = getPatientBarcodeDelim();
     $pieces = explode($pdelim, $patient_code);
     return $pieces;
}

function encodePatientBarcode($patient_id, $labconfig_id) //getPatientBarcodeCode($patient_id, $labconfig_id)
{
    $pdelim = getPatientBarcodeDelim();
    if($labconfig_id == 0)
        $labconfig_id = $_SESSION['lab_config_id'];
    $pcode = $labconfig_id.$pdelim.$patient_id;
    return $pcode;
}

function encodeSpecimenBarcode($specimen_id, $labconfig_id)
{
    $sdelim = getSpecimenBarcodeDelim();
     if($labconfig_id == 0)
        $labconfig_id = $_SESSION['lab_config_id'];
    $scode = $labconfig_id.$sdelim.$specimen_id;
    return $scode;
}

function encodeInventoryBarcode($inventory_id, $labconfig_id)
{
    $idelim = getInventoryBarcodeDelim();
    $icode = $labconfig_id.$idelim.$inventory_id;
    return $icode;
}

###########################

/////  Functions for country director reports ////

function get_tat_data_per_test_per_lab_dir_new($test_type_id, $lab_config_id, $date_from, $date_to, $include_pending)
 {
    global $DEFAULT_PENDING_TAT; # Default TAT value for pending tests (in days)
    $i = 7;
                    $lab_config = LabConfig::getById($lab_config_id);
               // date_default_timezone_set('UTC');
		$saved_db = DbUtil::switchToLabConfig($lab_config->id);
		/////////////////////////$resultset = get_completed_tests_by_type($test_type_id, $date_from, $date_to);
		# {resultentry_ts, specimen_id, date_collected_ts}
		$progression_val = array();
		$progression_count = array();
                $cc = 1;
		$date_from_parts = explode("-", $date_from);		
		$date_to_parts = explode("-", $date_to);
		$date_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
		$date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
		
		while($date_ts<=$date_to_ts) {     
			$second_day_ts= mktime(0, 0, 0, $date_from_parts[1],$date_from_parts[2]+$i,$date_from_parts[0]);
			$date_fromp=date("Y-m-d", $date_ts);
			$date_top=date("Y-m-d", $second_day_ts);
                        $resultset = get_completed_tests_by_type($test_type_id, $date_fromp, $date_top);
                        $progression_val[$date_ts]= 0;
				//$percentile_count[$week_ts] = array();
				//$percentile_count[$week_ts][] = $date_diff;
				$progression_count[$date_ts] = 0;
                        foreach($resultset as $record) {
			$date_collected = $record['date_collected'];
			//$week_collected = date("W", $date_collected);
			//$year_collected = date("Y", $date_collected);
			//$week_ts = week_to_date2($week_collected, $year_collected);
			//$week_ts_datetime = date("Y-m-d H:i:s", $week_ts);
			$date_r_ts = $record['ts'];
			$date_diff = ($date_r_ts - $date_collected);
                        if($date_diff < 0)
                            $date_diff = 0;
			if(!isset($progression_val[$date_ts])) {
                        //if($progression_val[$week_ts] == 0) {
				//$progression_val[$week_ts] = array();
				$progression_val[$date_ts]= $date_diff;
				//$percentile_count[$week_ts] = array();
				//$percentile_count[$week_ts][] = $date_diff;
				$progression_count[$date_ts] = 1;
				//$goal_tat[$week_ts] = $lab_config->getGoalTatValue($test_type_id, $week_ts_datetime);
				//$progression_val[$week_ts][3] = array();
				//$progression_val[$week_ts][4] = array();
			}
			else {
                            
				$progression_val[$date_ts] += $date_diff;
				//$percentile_count[$week_ts][] = $date_diff;
				$progression_count[$date_ts] += 1;
                                //$formattedValue = round($value[0],2);
                                //$formattedDate = bcmul($key,1000);
                                //ksort($stat_list); 
			}
			
                    }
                        
                        $date_ts = $second_day_ts;
                        $i=$i+7;
                }
                                
                $cc = 1;
		$rstat = array();
		foreach($progression_val as $key=>$value) {
			# Find average value
                        if($progression_count[$key] == 0)
                        {
                            $rstat[$cc][1] = 0;
                        }
                        else
                        {
			$progression_val[$key] = $value/$progression_count[$key];
			# Convert from sec timestamp to days
			$progression_val[$key] = ($progression_val[$key]/(60*60*24));
                        $rstat[$cc][1] = round($progression_val[$key],2);
                        }
                        $rstat[$cc][0] =  date('d M Y', $key);
                                //ksort($stat_list); 
                        $cc++;
			# Determine percentile value
			//$progression_val[$key][1] = getPercentile2($percentile_count[$key], $percentile_tofind);
			# Convert from sec timestamp to days
			//$progression_val[$key][1] = $progression_val[$key][1]/(60*60*24);
			//$progression_val[$key][2] = $goal_tat[$key];
		}
		DbUtil::switchRestore($saved_db);
		# Return {week=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids]]}
                //foreach($progression_val as )
		return $rstat;
}

function get_prevalence_data_per_test_per_lab_dir($test_type_id, $lab_config_id, $date_from, $date_to, $gender=null)

{
   $i=7;		
		# Fetch all test types with one measure having discrete P/N range
		$retval = array();
                					$lab_config = LabConfig::getById($lab_config_id);

		$saved_db = DbUtil::switchToLabConfig($lab_config->id);
		$date_from_parts = explode("-", $date_from);		
		$date_to_parts = explode("-", $date_to);
		$date_ts = mktime(0, 0, 0, $date_from_parts[1], $date_from_parts[2], $date_from_parts[0]);
		$date_to_ts=mktime(0, 0, 0, $date_to_parts[1], $date_to_parts[2], $date_to_parts[0]);
		
		while($date_ts<=$date_to_ts) {     
			$second_day_ts= mktime(0, 0, 0, $date_from_parts[1],$date_from_parts[2]+$i,$date_from_parts[0]);
			$date_fromp=date("Y-m-d", $date_ts);
			$date_top=date("Y-m-d", $second_day_ts);
		
			if($gender=='M'||$gender=='F') { 
				$query_string = 
						"SELECT COUNT(*) AS count_val  FROM test t, patient p, specimen s ".
						"WHERE t.test_type_id=$test_type_id ".
						"AND p.patient_id=s.patient_id ".
						"AND p.sex LIKE '$gender' ".
						"AND t.specimen_id=s.specimen_id ".
						"AND (s.date_collected BETWEEN '$date_fromp' AND '$date_top') ".
						"AND  (t.result LIKE 'N,%' OR t.result LIKE 'nÃƒÂ¯Ã‚Â¿Ã‚Â½gatif,%' OR t.result LIKE 'negatif,%' OR t.result LIKE 'n,%' OR t.result LIKE 'negative,%')";
			}
			else {
				$query_string = 
				"SELECT COUNT(*) AS count_val  FROM test t, specimen s ".
				"WHERE t.test_type_id=$test_type_id ".
				"AND t.specimen_id=s.specimen_id ".
				"AND ( s.date_collected BETWEEN '$date_fromp' AND '$date_top' )".
				"AND  (result LIKE 'N,%' OR result LIKE 'nÃƒÂ¯Ã‚Â¿Ã‚Â½gatif,%' OR result LIKE 'negatif,%' OR result LIKE 'n,%' OR result LIKE 'negative,%')";

				}
			$record = query_associative_one($query_string);
			$count_negative = $record['count_val'];
			
			$query_string = 
				"SELECT COUNT(*) AS count_val  FROM test t, specimen s ".
				"WHERE t.test_type_id=$test_type_id ".
				"AND t.specimen_id=s.specimen_id ".
				"AND result!=''".
				"AND ( s.date_collected BETWEEN '$date_fromp' AND '$date_top' )";
			$record = query_associative_one($query_string);
			$count_all = $record['count_val'];
			/*if($count_all != 0)*/
				$retval[$date_ts] = array($count_all, $count_negative);
			
		$date_ts = $second_day_ts;
		$i=$i+7;
			
					

	}
        $rstat = array();
        $cc=1;
		foreach($retval as $key=>$value) {
			# Find average value
			# Convert from sec timestamp to days
                        $rstat[$cc][1] = $value[0];
                                                $rstat[$cc][2] = $value[1];

                        $rstat[$cc][0] =  date('d M Y', $key);
                                //ksort($stat_list); 
                        $cc++;
			# Determine percentile value
			//$progression_val[$key][1] = getPercentile2($percentile_count[$key], $percentile_tofind);
			# Convert from sec timestamp to days
			//$progression_val[$key][1] = $progression_val[$key][1]/(60*60*24);
			//$progression_val[$key][2] = $goal_tat[$key];
		}
		DbUtil::switchRestore($saved_db);
		
		return $rstat;
	
}

function get_prevalence_data_per_test_per_lab_dir22($test_type_id, $lab_config_id, $date_from, $date_to)
{
        $retval = array();
    //$testTypeMapping = TestTypeMapping::getTestTypeById($test_type_id, $_SESSION['user_id']);
    //$mapping_list = array();
    //$mapping_list = get_test_mapping_list_by_string($testTypeMapping->labIdTestId);
    //print_r($mapping_list);

                          //  foreach( $lab_config_id as $key) {
					$lab_config = LabConfig::getById($lab_config_id);
                                        //print_r($lab_config);
					//$test_type_id = $mapping_list[$lab_config->id];
					$saved_db = DbUtil::switchToLabConfig($lab_config->id);	
					
					# For particular test type, fetch negative records
			
						$query_string = 
							"SELECT COUNT(*) AS count_val FROM test t, specimen s ".
							"WHERE t.test_type_id=$test_type_id ".
							"AND t.specimen_id=s.specimen_id ".
							"AND ( s.date_collected BETWEEN '$date_from' AND '$date_to' ) ".
							"AND (result LIKE 'N,%' OR result LIKE 'nÃƒÂ¯Ã‚Â¿Ã‚Â½gatif,%' OR result LIKE 'negatif,%' OR result LIKE 'n,%' OR result LIKE 'negative,%')";
						$record = query_associative_one($query_string);
						$count_negative = intval($record['count_val']);
						$query_string = 
							"SELECT COUNT(*) AS count_val FROM test t, specimen s ".
							"WHERE t.test_type_id=$test_type_id ".
							"AND t.specimen_id=s.specimen_id ".
							"AND result!=''".
							"AND ( s.date_collected BETWEEN '$date_from' AND '$date_to' )";
							//echo($query_string);
						$record = query_associative_one($query_string);
						$count_all = intval($record['count_val']);
						# If total tests is 0, ignore
						if($count_all == 0)
							continue;
						$testName = get_test_name_by_id($test_type_id);
						$labName = $lab_config->name;
						$query_string = 
							"SELECT prevalence_threshold FROM test_type ".
							"WHERE test_type_id=$test_type_id ";
						$record = query_associative_one($query_string);
						$threshold = intval($record['prevalence_threshold']);
						
						$retval[$labName] = array( $count_all, $count_negative, $threshold );
                               // }
                                DbUtil::switchRestore($saved_db);		
				return $retval;
}

function getPercentile2($list, $ile_value)
	{
		# Returns the percentile value from the given list
		$num_values = count($list);
		sort($list);
		$mark = ceil(round($ile_value/100, 2) * $num_values);
		return $list[$mark-1];
	}

function get_tat_data_per_test_per_lab_dir2($test_type_id, $lab_config_id, $date_from, $date_to, $include_pending)
{
    # Calculates monthly progression of TAT values for a given test type and time period
		global $DEFAULT_PENDING_TAT; # Default TAT value for pending tests (in days)
                $lab_config = LabConfig::getById($lab_config_id);
		$saved_db = DbUtil::switchToLabConfig($lab_config->id);
		$resultset = get_completed_tests_by_type($test_type_id, $date_from, $date_to);
		# {resultentry_ts, specimen_id, date_collected_ts}
		//print_r($resultset);
                $progression_val = array();
		$progression_count = array();
		$percentile_tofind = 90;
		$percentile_count = array();
		$goal_val = array();
		# Build list as {month=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids]]}
		# For completed tests
		foreach($resultset as $record)
		{
			$date_collected = $record['date_collected'];
			$date_collected_parsed = date("Y-m-d", $date_collected);
			$date_collected_parts = explode("-", $date_collected_parsed);
			$month_ts = mktime(0, 0, 0, $date_collected_parts[1], 0, $date_collected_parts[0]);
			$month_ts_datetime = date("Y-m-d H:i:s", $month_ts);
			$date_ts = $record['ts'];
			$date_diff = ($date_ts - $date_collected);
			if(!isset($progression_val[$month_ts]))
			{
				$goal_tat[$month_ts] = $lab_config->getGoalTatValue($test_type_id, $month_ts_datetime);
				$progression_val[$month_ts] = array();
				$progression_val[$month_ts][0] = $date_diff;
				$percentile_count[$month_ts] = array();
				$percentile_count[$month_ts][] = $date_diff;
				$progression_count[$month_ts] = 1;
				$progression_val[$month_ts][3] = array();
				$progression_val[$month_ts][4] = array();
			}
			else
			{
				$progression_val[$month_ts][0] += $date_diff;
				$percentile_count[$month_ts][] = $date_diff;
				$progression_count[$month_ts] += 1;
			}
			
		}
		if($include_pending === true)
		{
			$pending_tat_value = $lab_config->getPendingTatValue(); # in hours
			# Update the above list {month=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids]]}
			# For pending tests in this time duration
			$resultset_pending = get_pendingtat_tests_by_type($test_type_id, $date_from, $date_to);
			$num_pending = count($resultset_pending);
			foreach($resultset_pending as $record)
			{
				$date_collected = $record['date_collected'];
				$date_collected_parsed = date("Y-m-d", $date_collected);
				$date_collected_parts = explode("-", $date_collected_parsed);
				$month_ts = mktime(0, 0, 0, $date_collected_parts[1], 0, $date_collected_parts[0]);
				$month_ts_datetime = date("Y-m-d H:i:s", $month_ts);
				$date_diff = $pending_tat_value*60*60;
				if(!isset($progression_val[$month_ts]))
				{
					$goal_tat[$month_ts] = $lab_config->getGoalTatValue($test_type_id, $month_ts_datetime);
					$progression_val[$month_ts] = array();
					$progression_val[$month_ts][0] = $date_diff;
					$percentile_count[$month_ts] = array();
					$percentile_count[$month_ts][] = $date_diff;
					$progression_count[$month_ts] = 1;
					$progression_val[$month_ts][3] = array();
					$progression_val[$month_ts][4] = array();
				}
				else
				{
					$progression_val[$month_ts][0] += $date_diff;
					$percentile_count[$month_ts][] = $date_diff;
					$progression_count[$month_ts] += 1;
				}
				# Add to list of TAT pending specimens
				$progression_val[$month_ts][4][] = $record['specimen_id'];
			}
		}
		foreach($progression_val as $key=>$value)
		{
			# Find average value
			$progression_val[$key][0] = $value[0]/$progression_count[$key];
			# Convert from sec timestamp to days
			$progression_val[$key][0] = ($progression_val[$key][0]/(60*60*24));
			# Determine percentile value
			$progression_val[$key][1] = getPercentile2($percentile_count[$key], $percentile_tofind);
			# Convert from sec timestamp to days
			$progression_val[$key][1] = $progression_val[$key][1]/(60*60*24);
			$progression_val[$key][2] = $goal_tat[$key];
		}		
		DbUtil::switchRestore($saved_db);
		return $progression_val;
}


function week_to_date2($week_num, $year)
{
	# Returns timestamp for the first day of the week
	# TODO: Move this to /includes/date_lib.php
	$week = $week_num;
	$Jan1 = mktime (1, 1, 1, 1, 1, $year);
	$iYearFirstWeekNum = (int) strftime("%W",mktime (1, 1, 1, 1, 1, $year));
	if ($iYearFirstWeekNum == 1)
	{
		$week = $week - 1;
	}
	$weekdayJan1 = date ('w', $Jan1);
	$FirstMonday = strtotime(((4-$weekdayJan1)%7-3) . ' days', $Jan1);
	$CurrentMondayTS = strtotime(($week) . ' weeks', $FirstMonday);
	return ($CurrentMondayTS);
}

function get_tat_data_per_test_per_lab_dir($test_type_id, $lab_config_id, $date_from, $date_to, $include_pending)
 {
    global $DEFAULT_PENDING_TAT; # Default TAT value for pending tests (in days)
                    $lab_config = LabConfig::getById($lab_config_id);
                //
		$saved_db = DbUtil::switchToLabConfig($lab_config->id);
		$resultset = get_completed_tests_by_type($test_type_id, $date_from, $date_to);
		# {resultentry_ts, specimen_id, date_collected_ts}
		$progression_val = array();
		$progression_count = array();
                $cc = 1;
		//$percentile_tofind = 90;
		//$percentile_count = array();
		//$goal_val = array();
		# Return {week=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids]]}
                echo "!".$date_to."!";
                $from_e = explode('-',$date_from);
                $to_e = explode('-',$date_to);
                $start_ts = mktime(1, 1, 1, $from_e[1], $from_e[2], $from_e[0]);
                $end_ts = mktime(1, 1, 1, $to_e[1], $to_e[2], $to_e[0]);
                $week_start_ts = date("W", $start_ts);
		$year_start_ts = date("Y", $start_ts);
                $startingWeek = week_to_date2($week_start_ts, $year_start_ts);
                $week_end_ts = date("W", $end_ts);
		$year_end_ts = date("Y", $end_ts);
                $endingWeek = week_to_date2($week_end_ts, $year_end_ts);
                
                $weekDiff = mktime(1, 1, 1, 1, 1, 2000) - mktime(1, 1, 1, 1, 10, 2000);
                
                $wc = 0;
                $currentWeek = $startingWeek;
                $currentTS = $startingWeek;
                echo "sTS=".$startingWeek;
                echo "cTS=".$endingWeek;
                while($currentWeek != $endingWeek)
                {
                    $wc++;
                    $currentTS = $currentTS + $weekDiff;
                    $week_currentTS = date("W", $currentTS);
                    $year_currentTS = date("Y", $currentTS);
                    $currentWeek = week_to_date2($week_currentTS, $year_currentTS);
                    $progression_count[$currentWeek] = 0;
                    $progression_val[$currentWeek]= 0;
                    $wc++;
                }
                echo "WC=".$wc;
		foreach($resultset as $record) {
			$date_collected = $record['date_collected'];
			$week_collected = date("W", $date_collected);
			$year_collected = date("Y", $date_collected);
			$week_ts = week_to_date2($week_collected, $year_collected);
			$week_ts_datetime = date("Y-m-d H:i:s", $week_ts);
			$date_ts = $record['ts'];
			$date_diff = ($date_ts - $date_collected);
                        if($date_diff < 0)
                            $date_diff = 0;
			//if(!isset($progression_val[$week_ts])) {
                        if($progression_val[$week_ts] == 0) {
				//$progression_val[$week_ts] = array();
				$progression_val[$week_ts]= $date_diff;
				//$percentile_count[$week_ts] = array();
				//$percentile_count[$week_ts][] = $date_diff;
				$progression_count[$week_ts] = 1;
				//$goal_tat[$week_ts] = $lab_config->getGoalTatValue($test_type_id, $week_ts_datetime);
				//$progression_val[$week_ts][3] = array();
				//$progression_val[$week_ts][4] = array();
			}
			else {
                            
				$progression_val[$week_ts] += $date_diff;
				//$percentile_count[$week_ts][] = $date_diff;
				$progression_count[$week_ts] += 1;
                                //$formattedValue = round($value[0],2);
                                //$formattedDate = bcmul($key,1000);
                                //ksort($stat_list); 
			}
			
		}
		if($include_pending === true) {
			$pending_tat_value = $lab_config->getPendingTatValue(); # in hours
			# Update the above list {week=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids]]}
			# For pending tests in this time duration
			$resultset_pending = get_pendingtat_tests_by_type($test_type_id, $date_from, $date_to);
			$num_pending = count($resultset_pending);
			foreach($resultset_pending as $record) {
			
				$date_collected = $record['date_collected'];
				$week_collected = date("W", $date_collected);
				$year_collected = date("Y", $date_collected);
				$week_ts = week_to_date2($week_collected, $year_collected);
				$week_ts_datetime = date("Y-m-d H:i:s", $week_ts);
				$date_ts = $record['ts'];
				$date_diff = $pending_tat_value*60*60;;
				if(!isset($progression_val[$week_ts]))
				{
					//$progression_val[$week_ts] = array();
					$progression_val[$week_ts] = $date_diff;
					//$percentile_count[$week_ts] = array();
					//$percentile_count[$week_ts][] = $date_diff;
					$progression_count[$week_ts] = 1;
					//$goal_tat[$week_ts] = $lab_config->getGoalTatValue($test_type_id, $week_ts_datetime);
					//$progression_val[$week_ts][3] = array();
					//$progression_val[$week_ts][4] = array();
				}
				else
				{
                                    if($date_diff > 0)
					$progression_val[$week_ts] += $date_diff;
					//$percentile_count[$week_ts][] = $date_diff;
					$progression_count[$week_ts] += 1;
				}
				# Add to list of TAT pending specimens
			}
		}
                $rstat = array();
                $wa = 7;
                $wc = 0;
		foreach($progression_val as $key=>$value) {
			# Find average value
			$progression_val[$key] = $value/$progression_count[$key];
			# Convert from sec timestamp to days
			$progression_val[$key] = ($progression_val[$key]/(60*60*24));
                        $rstat[$cc][1] = round($progression_val[$key],2);
                        $rstat[$cc][0] =  date('d M Y', $key);
                                //ksort($stat_list); 
                        $cc++;
			# Determine percentile value
			//$progression_val[$key][1] = getPercentile2($percentile_count[$key], $percentile_tofind);
			# Convert from sec timestamp to days
			//$progression_val[$key][1] = $progression_val[$key][1]/(60*60*24);
			//$progression_val[$key][2] = $goal_tat[$key];
		}
		DbUtil::switchRestore($saved_db);
		# Return {week=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids]]}
                //foreach($progression_val as )
		return $rstat;
}

function get_country_from_user_id()
{
    $usr_c = get_username_by_id($_SESSION['user_id']);
    $usr_c = strtolower($usr_c);
    //$usr_c = ucfirst($usr_c);
    $usr_cs = substr($usr_c, 0, strpos($usr_c, "_"));
    return $usr_cs; 
}

function get_coordinates($lab_id)
{
    $saved_db = DbUtil::switchToGlobal();
    $query_configs = "SELECT * from map_coordinates WHERE lab_id = $lab_id";
    $retval = array();
	$resultset = query_associative_one($query_configs);
	if($resultset == null)
	{
		DbUtil::switchRestore($saved_db);
                $retval[0] = -1;
                $retval[1] = -1;
		return $retval;
	}
        
	$retval = explode(',', $resultset['coordinates']);
       
	DbUtil::switchRestore($saved_db);
	return $retval;
}

function getGlobalTestName($tid)
{
    $saved_db = DbUtil::switchToGlobal();
    $query_configs = "SELECT * from test_mapping WHERE test_id = $tid";
    
	$resultset = query_associative_one($query_configs);
	if($resultset == null)
	{
		DbUtil::switchRestore($saved_db);
                $retval = 'Unknown';
		return $retval;
	}
        
	$retval = $resultset['test_name'];
       
	DbUtil::switchRestore($saved_db);
	return $retval;
}

//////////////////////////////////////////////////

/*
* Returns a list of all labs under a certain director
*/
function get_labs_for_director($director)
{
	$lab_config_id = $_SESSION['lab_config_id'];
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	
	$query_string = "SELECT lab_config_id FROM lab_config_access WHERE user_id = $director";
	
	$retVal = query_associative_all($query_string, $_COUNT);
	DbUtil::switchRestore($saved_db);

	return $retVal;
}

/*
* Returns the name of a lab, based on its id
*/
function get_lab_name_by_id_revamp($lab_id)
{
	$lab_config_id = $_SESSION['lab_config_id'];
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	
	$query_string = "SELECT name FROM lab_config WHERE lab_config_id = $lab_id";
	
	$retVal = query_associative_all($query_string, $_COUNT);
	DbUtil::switchRestore($saved_db);

	return $retVal;
}

/*
* Returns whether or not a lab has been placed on the director map.
*/
function is_lab_placed($lab, $user)
{	
	$lab_config_id = $_SESSION['lab_config_id'];
	
	$query_string = "SELECT coordinates FROM map_coordinates WHERE lab_id = $lab AND user_id = $user";
	
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$retVal = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);

	if (!is_null($retVal['coordinates']))
	{
		return $retVal['coordinates'];
	}
	return NULL;
}

/*
* Updates (or if there is no entry to update, creates) an entry with the x and y coordinates of a laboratory.
*/
function create_or_update_map_coords_entry($lab_id, $dir_id, $x, $y)
{
	$lab_config_id = $_SESSION['lab_config_id'];
	$coordinate_string = $x . "," . $y;
	
	// Check and see if an entry exists.
	$query_string = "SELECT COUNT(*) FROM map_coordinates WHERE lab_id = $lab_id AND user_id = $dir_id";
	
	$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
	$retVal = query_associative_one($query_string);
	DbUtil::switchRestore($saved_db);
	
	if ($retVal["COUNT(*)"] > 0)
	{
		$query_string = "UPDATE map_coordinates SET coordinates = '$coordinate_string' WHERE lab_id = $lab_id AND user_id = $dir_id";

		$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
		$retVal = query_update($query_string);
		DbUtil::switchRestore($saved_db);

	} else
	{
		$query_string = "INSERT INTO map_coordinates (coordinates, lab_id, user_id) VALUES ('$coordinate_string', $lab_id, $dir_id)";
		
		$saved_db = DbUtil::switchToLabConfigRevamp($lab_config_id);
		$retVal = query_insert_one($query_string);
		DbUtil::switchRestore($saved_db);
	}
}

function db_analysis_ratings($lb)
{
	if($lb == 128)
	{
		// entries from 2010-05-17 to 2012-05-21
		$labdb = "blis_128";
		$lastdate = mktime( 0, 0, 0, 05, 21, 2012 );
		$day = 26;
		$yr = 2010;
		$mth = 04;
	}
	else if($lb == 129)
	{
		// entries from 2010-05-11 to 2013-04-25
		$labdb = "blis_129";
		$lastdate = mktime( 0, 0, 0, 04, 25, 2012 );
		$day = 26;
		$yr = 2010;
		$mth = 04;
	}
	else if($lb == 153)
	{
		// entries from 2011-12-20 to 2013-4-24
		$labdb = "blis_153";
		$lastdate = mktime( 0, 0, 0, 08, 30, 2013 );
		$day = 1;
		$yr = 2011;
		$mth = 10;
	}
	else if($lb == 1006)
	{
		// NO data
		// entries from 2012-06-16 to 2013-04-28
		$labdb = "blis_1006";
		$lastdate = mktime( 0, 0, 0, 04, 28, 2013);
		$day = 11;
		$yr = 2012;
		$mth = 6;
	}
	else if($lb == 131)
	{
		// entries from 2010-05-11 to 2013-04-29
		$labdb = "blis_131";
		$lastdate = mktime( 0, 0, 0, 07, 09, 2012);
		$day = 26;
		$yr = 2010;
		$mth = 4;
	}
	$ic = 1;
	while(1)
	{
		$c1 = 0;
		$c2 = 0;
		$c3 = 0;
		$c4 = 0;
		$c5 = 0;
		$c6 = 0;
		$startdate = mktime( 0, 0, 0, $mth, $day, $yr );
		$enddate = mktime( 0, 0, 0, $mth, $day + 7, $yr );
		$query_string = "SELECT * FROM $labdb.user_rating where ts >= FROM_UNIXTIME($startdate) AND ts < FROM_UNIXTIME($enddate)";
		$retVal = query_associative_all($query_string, $count);
		foreach($retVal as $row)
		{
			if($row['rating'] == 1)
				$c1++;
			else if($row['rating'] == 2)
				$c2++;
			else if($row['rating'] == 3)
				$c3++;
			else if($row['rating'] == 4)
				$c4++;
			else if($row['rating'] == 5)
				$c5++;
			else if($row['rating'] == 6)
				$c6++;
		}
		echo $ic.",".date( 'Y-m-d', $startdate ).",".date( 'Y-m-d', $enddate ).",";
		echo $c1.",".$c2.",".$c3.",".$c4.",".$c5.",".$c6;
		//echo $retVal["COUNT(*)"];
		echo "<br>";
		if($lastdate <= $enddate)
			break;
		$day = $day + 7;
		$ic++;
	}
}

function db_analysis_patients($lb)
{
	if($lb == 128)
	{
		// entries from 2010-05-17 to 2013-04-26
		$labdb = "blis_128";
		$lastdate = mktime( 0, 0, 0, 04, 26, 2013 );
		$day = 17;
		$yr = 2010;
		$mth = 05;
	}
	else if($lb == 129)
	{
		// entries from 2010-05-11 to 2013-04-25
		$labdb = "blis_129";
		$lastdate = mktime( 0, 0, 0, 04, 25, 2013 );
		$day = 10;
		$yr = 2010;
		$mth = 05;
	}
	else if($lb == 153)
	{
		// entries from 2011-12-20 to 2013-4-24
		$labdb = "blis_153";
		$lastdate = mktime( 0, 0, 0, 04, 24, 2013 );
		$day = 19;
		$yr = 2011;
		$mth = 12;
	}
	else if($lb == 1006)
	{
		// entries from 2012-06-16 to 2013-04-28
		$labdb = "blis_1006";
		$lastdate = mktime( 0, 0, 0, 04, 28, 2013);
		$day = 11;
		$yr = 2012;
		$mth = 06;
	}
	else if($lb == 131)
	{
		// entries from 2010-05-11 to 2013-04-29
		$labdb = "blis_131";
		$lastdate = mktime( 0, 0, 0, 04, 28, 2013);
		$day = 10;
		$yr = 2010;
		$mth = 05;
	}
	$ic = 1;
	while(1)
	{
		
		$startdate = mktime( 0, 0, 0, $mth, $day, $yr );
		$enddate = mktime( 0, 0, 0, $mth, $day + 7, $yr );
		$query_string = "SELECT COUNT(*) FROM $labdb.patient where ts >= FROM_UNIXTIME($startdate) AND ts < FROM_UNIXTIME($enddate)";
		$retVal = query_associative_one($query_string);
		echo $ic.",".date( 'Y-m-d', $startdate ).",".date( 'Y-m-d', $enddate ).",";
		echo $retVal["COUNT(*)"];
		echo "<br>";
		if($lastdate <= $enddate)
			break;
		$day = $day + 7;
		$ic++;
	}
}

function db_analysis_tests($lb)
{
	if($lb == 128)
	{
		// entries from 2010-05-18 to 2013-04-27
		$labdb = "blis_128";
		$lastdate = mktime( 0, 0, 0, 04, 27, 2013 );
		$day = 17;
		$yr = 2010;
		$mth = 05;
	}
	else if($lb == 129)
	{
		// entries from 2010-05-11 to 2013-04-26
		$labdb = "blis_129";
		$lastdate = mktime( 0, 0, 0, 04, 26, 2013 );
		$day = 10;
		$yr = 2010;
		$mth = 05;
	}
	else if($lb == 153)
	{
		// entries from 2011-12-20 to 2013-4-24
		$labdb = "blis_153";
		$lastdate = mktime( 0, 0, 0, 04, 24, 2013 );
		$day = 19;
		$yr = 2011;
		$mth = 12;
	}
	else if($lb == 1006)
	{
		// entries from 2012-06-16 to 2013-04-28
		$labdb = "blis_1006";
		$lastdate = mktime( 0, 0, 0, 04, 28, 2013);
		$day = 11;
		$yr = 2012;
		$mth = 06;
	}
	else if($lb == 131)
	{
		// entries from 2010-05-11 to 2013-04-29
		$labdb = "blis_131";
		$lastdate = mktime( 0, 0, 0, 04, 28, 2013);
		$day = 10;
		$yr = 2010;
		$mth = 05;
	}
	$ic = 1;
	while(1)
	{
		
		$startdate = mktime( 0, 0, 0, $mth, $day, $yr );
		$enddate = mktime( 0, 0, 0, $mth, $day+7, $yr );
		$query_string = "SELECT COUNT(*) FROM $labdb.test where ts >= FROM_UNIXTIME($startdate) AND ts < FROM_UNIXTIME($enddate)";
		$retVal = query_associative_one($query_string);
		echo $ic.",".date( 'Y-m-d', $startdate ).",".date( 'Y-m-d', $enddate ).",";
		echo $retVal["COUNT(*)"];
		echo "<br>";
		if($lastdate <= $enddate)
			break;
		$day = $day + 7;
		//$mth++;
		$ic++;
	}
}

/* Functions used by API class member function */
function api_get_patient_records($lab_config, $patient_id, $date_from, $date_to, $ip) {

	$retval = array();

	if($_REQUEST['ip'] == 0) {

		# Do not include pending tests

		$query_string =

			"SELECT t.* FROM test t, specimen sp ".

			"WHERE t.result <> '' ".

			"AND t.specimen_id=sp.specimen_id ".

			"AND sp.patient_id=$patient_id ";


			$query_string .= "AND (sp.date_collected BETWEEN '$date_from' AND '$date_to') ";

		$query_string .= "ORDER BY sp.date_collected DESC";

	

	}

	else {

		# Include pending tests

		$query_string =

			"SELECT t.* FROM test t, specimen sp ".

			"WHERE t.specimen_id=sp.specimen_id ".

			"AND sp.patient_id=$patient_id ";


			$query_string .= "AND (sp.date_collected BETWEEN '$date_from' AND '$date_to') ";

		$query_string .= "ORDER BY sp.date_collected DESC";		

	

	}

	

	$resultset = query_associative_all($query_string, $row_count);

	

	if(count($resultset) == 0 || $resultset == null)

		return $retval;

	

	foreach($resultset as $record) {

		$test = Test::getObject($record);

		$hide_patient_name = TestType::toHidePatientName($test->testTypeId);

		

		if( $hide_patient_name == 1 )

					$hidePatientName = 1;

		

		$specimen = get_specimen_by_id($test->specimenId);

		$retval[] = array($test, $specimen, $hide_patient_name);		

	}

	

	return $retval;

}

function api_decode_results($testObj)
{
    $rts = array();
    $show_range = false;
    //print_r($testObj);
    //echo "-----------".$testObj->testTypeId."--------";
    $test_type = TestType::getById($testObj->testTypeId);
		$measure_list = $test_type->getMeasures();
                //print_r($measure_list);
                $submeasure_list = array();
                $comb_measure_list = array();
               // print_r($measure_list);
                foreach($measure_list as $measure)
                {
                    
                    $submeasure_list = $measure->getSubmeasuresAsObj();
                    //echo "<br>".count($submeasure_list);
                    //print_r($submeasure_list);
                    $submeasure_count = count($submeasure_list);
                    
                    if($measure->checkIfSubmeasure() == 1)
                    {
                        continue;
                    }
                        
                    if($submeasure_count == 0)
                    {
                        array_push($comb_measure_list, $measure);
                    }
                    else
                    {
                        array_push($comb_measure_list, $measure);
                        foreach($submeasure_list as $submeasure)
                           array_push($comb_measure_list, $submeasure); 
                    }
                }
                $measure_list = $comb_measure_list;
		$result_csv = $testObj->getResultWithoutHash();
                //$result_csv = $this->getResultWithoutHash();
                //echo "<br>";
                //echo $result_csv;
                //echo "<br>";
                if(strpos($result_csv, "[$]") === false)
                {
                    $result_list = explode(",", $result_csv);
                }
                else
                {
                    //$testt = "one,[$]two[/$],[$]twotwo[/$],three";
                    $testt = $result_csv;
                    //$test2 = strstr($testt, $);
                    $start_tag = "[$]";
                    $end_tag = "[/$]";
                    //$testtt = str_replace("[$]two[/$],", "", $testt);
                    $freetext_results = array();
                    $ft_count = substr_count($testt, $start_tag);
                    //echo $ft_count;
                    $k = 0;
                    while($k < $ft_count)
                    {
                        $ft_beg = strpos($testt, $start_tag);
                        $ft_end = strpos($testt, $end_tag);
                        $ft_sub = substr($testt, $ft_beg + 3, $ft_end - $ft_beg - 3);
                        $ft_left = substr($testt, 0, $ft_beg);
                        $ft_right = substr($testt, $ft_end + 5);
                        //echo "<br>".$ft_left."--".$ft_right."<br>";
                        $testt = $ft_left.$ft_right;
                        array_push($freetext_results, $ft_sub);
                        $k++;
                    }
                    //echo $freetext_results."<br>".$testt;
                    //$testtt = str_replace($subb, "", $testt, 1);
                    //echo "$testto<br>$subb<br>";
                    $result_csv = $testt;
                    if(strpos($testt, ",") == 0)
                            $result_csv = substr($testt, 1, strlen($testt)); 
                    $result_list = explode(",", $result_csv);
                    //echo "<br>";
                    //print_r($result_list);
                    //echo "<br>";
                }
                $retval = "";
                //NC3065
                //echo print_r($measure_list);
                //echo "<br>";
                //echo $result_csv;
                //echo "<br>";
                //echo print_r($result_list,true);
                //echo "Num->".count($measure_list);
		//-NC3065
                $j = 0;
                $i = 0;
                $c = 0;
                //for($i = 0; $i < count($measure_list); $i++) {
                while($c < count($measure_list)) {
			# Pretty print
			$curr_measure = $measure_list[$c];
			if($curr_measure->getRangeType() != Measure::$RANGE_FREETEXT)
                        {
                            if(isset($result_list[$i]))
                            {    
                                //echo "Num->".$i;
                                    # If matching result value exists (e.g. after a new measure was added to this test type)
                                    if(count($measure_list) == 1)
                                    {
                                            # Only one measure: Do not print measure name
                                            if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE) {
                                                    $result_string = "";
                                                    $value_list = explode("_", $result_list[$i]);
                                                    foreach($value_list as $value) {
                                                            if(trim($value) == "")
                                                                    continue;
                                                            $result_string .= $value.",";
                                                    }
                                                    $result_string = substr($result_string, 0, -4);
                                                    $retval .= "<br>".$result_string."&nbsp;";
                                                    $rts[$curr_measure->name] = $result_string;
                                            }
                                            else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
                                            {
                                                    if($result_list[$i] != $curr_measure->unit)
                                                            $retval .= "<br><b>".$result_list[$i]."</b> &nbsp;";
                                                    else
                                                            $retval .= "<br>".$result_list[$i]."&nbsp;";
                                                    $rts[$curr_measure->name] = $result_list[$i];
                                            }
                                            else
                                            {
                                                    $retval .= "<br>".$result_list[$i]."&nbsp;";
                                                    $rts[$curr_measure->name] = $result_list[$i];
                                            }
                                    }
                                    else
                                    {
                                            # Print measure name with each result value
                                         if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                            $retval .= "<br>".$decName.":"."&nbsp;";
                                        
                                            if($curr_measure->getRangeType() == Measure::$RANGE_AUTOCOMPLETE)
                                            {
                                                    $result_string = "";
                                                    $value_list = str_replace("_", ",", $result_list[$i]);
                                                    $retval .= "<b>".$value_list."</b>";
                                                    $rts[$decName] = $value_list;
                                            }
                                            else if($curr_measure->getRangeType() == Measure::$RANGE_OPTIONS)
                                            {
                                                    if($result_list[$i]!=$curr_measure->unit)
                                                            $retval .= "<b>".$result_list[$i]."</b>"."&nbsp;";
                                                    else
                                                            $retval .= $result_list[$i]."&nbsp;";
                                                    $rts[$decName] = $result_list[$i];
                                            }
                                            else
                                            {
                                                    $retval .= "<b>".$result_list[$i]."</b>"."&nbsp;";
                                                     $rts[$decName] = $result_list[$i];
                                            }
                                            
                                    }

                                    if($show_range === true)
                                    {
                                            $retval .= $curr_measure->getRangeString();
                                    }
                                    if($i != count($measure_list) - 1)
                                    {
                                            $retval .= "<br>";
                                    }
                            }
                            else
                            {
                                    # Matching result value not found: Show "-"
                                    if(count($measure_list) == 1)
                                    {
                                            if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                            $retval .= $decName."&nbsp;";
                                    }
                                    $retval .= " - <br>";
                                     $rts[$decName] = "-";
                            }
                            $i++;
                        }
                        else
                        {
                            $ft_result = $freetext_results[$j];

                            if(count($measure_list) == 1)
                            {
                                $retval .= "<br>".$ft_result."&nbsp;";   
                            }
                            else
                            {
                                if(strpos($curr_measure->name, "\$sub") !== false)
                                                            {
                                                                $decName = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$curr_measure->truncateSubmeasureTag();
                                                                
                                                            }
                                                            else
                                                            {
                                                                $decName = $curr_measure->name;
                                                            }
                                $retval .= "<br>".$decName.":"."&nbsp;"."<b>".$ft_result."</b>"."&nbsp;";
                            }
                            if($show_range === true)
                                        {
                                                $retval .= $curr_measure->getRangeString();
                                        }
                                        if($i != count($measure_list) - 1)
                                        {
                                                $retval .= "<br>";
                                        }
                            $j++;
                            
                             $rts[$decName] = $ft_result;
                            
                        }$c++;
		}//end
		//$retval = str_replace("_",",",$retval); # Replace all underscores with a comma
		return $rts;
	
}

 function check_api_token($tok)
    {
        print_r($_SESSION);
        echo "<br>";
        echo "<br>".$_SESSION['tok']." - ".$tok."<br>";
        if(!isset($_SESSION['tok']))
            return -2;
        if($_SESSION['tok'] == $tok)
        {
            // valid token
            return 1;
        }
        if($_SESSION['tok'] == -1)
        {
            // invalid session
            return -2;
        }
        if($_SESSION['tok'] != $tok)
        {
            // invalid token
            return -2;
        }
        
       
        
            return -2;
    }

function is_admin_check($user)
{
	# Returns true for admin and superadmin level users
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_SUPERADMIN, $LIS_CLERK, $LIS_TECH_SHOWPNAME, $LIS_COUNTRYDIR, $READONLYMODE, $LIS_PHYSICIAN;
	if
	(
		$user->level == $LIS_TECH_RO || 
		$user->level == $LIS_TECH_RW || 
		$user->level == $LIS_CLERK || 
		$user->level == $LIS_TECH_SHOWPNAME ||
		$user->level == $READONLYMODE ||
		$user->level == $LIS_PHYSICIAN ||
		$user->level == $LIS_PHYSICIAN 
	)
		return false;
	return true;
}    

function is_super_admin_check($user)
{
	# Returns true for superadmin level users only
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_VERIFIER, $LIS_SUPERADMIN;
	if($user->level == $LIS_SUPERADMIN)
		return true;
	return false;
}

function is_country_dir_check($user)
{
	# Returns true for superadmin level users only
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_ADMIN, $LIS_VERIFIER, $LIS_SUPERADMIN, $LIS_COUNTRYDIR, $LIS_PHYSICIAN;
	if($user->level == $LIS_COUNTRYDIR)
		return true;
	return false;
}

function is_verifier_check($user)
{
	# Returns true for superadmin level users only
	global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_ADMIN, $LIS_ADMIN, $LIS_VERIFIER, $LIS_SUPERADMIN, $LIS_COUNTRYDIR, $LIS_PHYSICIAN;
	if($user->level == $LIS_VERIFIER)
		return true;
	return false;
}


function getDoctorNamesForPatients($patient, $lab_config_id, $lab_section, $reported){
	//$query =
	$specimen_list = get_specimens_by_patient_id($patient->patientId, $lab_section);
	$doctors = array();
	if($reported == 1){
		// reported
		foreach($specimen_list as $specimen){
			$test = Test::getTestBySpecimenID($specimen->specimenId);
			if($test != null && $test->result != ""){
				array_push($doctors,$specimen->doctor);
			}
		}
	} else {
		// unreported 
		foreach($specimen_list as $specimen){
			$test = Test::getTestBySpecimenID($specimen->specimenId);
			//echo "Test ".$test->specimenId;
			if($test != null && $test->result == ""){
				array_push($doctors,$specimen->doctor);
			}
		}
	}
	
	return array_unique($doctors);
}


/* API starts here*/

class API
{
    public static function test_api($data)
    {
        return "# API test String".$data." #";
    }
    
   public function login($username, $password)
    {
       print_r($_SESSION);
        global $con;
	$username = mysql_real_escape_string($username, $con);
	$saved_db = DbUtil::switchToGlobal();
	$password = encrypt_password($password);
	$query_string = 
		"SELECT * FROM user ".
		"WHERE username='$username' ".
		"AND password='$password' AND lab_config_id != 0 LIMIT 1";
	$record = query_associative_one($query_string);
	# Return user profile (null if incorrect username/password)
	DbUtil::switchRestore($saved_db);
	//return User::getObject($record);
        if($record == NULL)
        {
            return -1;
        }
        else
        {
            $tok = API::start_session($username, $password);
            return $tok;
        }
    }
    
    
    
    public function start_session($username, $password)
    {
         session_start();
        
         $sid = session_id();
         //$_SESSION['tok'] = $sid;
        
         $user = get_user_by_name($username);
	$_SESSION['username'] = $username;
	$_SESSION['user_id'] = $user->userId;
	$_SESSION['user_actualname'] = $user->actualName;
	$_SESSION['user_level'] = $user->level;
        $_SESSION['level'] = $user->level;
	$_SESSION['locale'] = $user->langId;
	if($user->level==17) {
		$combinedString = $user->rwoptions;

		$_SESSION['doctorConfig'] = $combinedString;
	}
        
	if(is_admin_check($user))
	{
		
		$lab_id=get_lab_config_id_admin($user->userId);
		$_SESSION['lab_config_id'] = $lab_id;
		$_SESSION['db_name'] = "blis_".$lab_id;
		$_SESSION['dformat'] = $DEFAULT_DATE_FORMAT;
		$_SESSION['country'] = $user->country;
	}
	else
	{
		$_SESSION['lab_config_id'] = $user->labConfigId;
		echo $user->labConfigId;
		$_SESSION['country'] = $user->country;
		$lab_config = get_lab_config_by_id($user->labConfigId);
		$_SESSION['db_name'] = $lab_config->dbName;
		$_SESSION['dformat'] = $lab_config->dateFormat;
		$_SESSION['dnum_reset'] = $lab_config->dailyNumReset;
		$_SESSION['pnamehide'] = $lab_config->hidePatientName;
		# Config values for registration fields
		if($user->level!=17) {
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
		}
		else {
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
		if($SERVER == $ON_PORTABLE)
			$_SESSION['langdata_path'] = $LOCAL_PATH."langdata_".$lab_config->id."/";
		else
			$_SESSION['langdata_path'] = $LOCAL_PATH."langdata_revamp/";
	}
	
	
	# Set session variables for recording latency/user props
	$_SESSION['PROPS_RECORDED'] = false;
	$_SESSION['DELAY_RECORDED'] = false;
	#TODO: Add other session variables here
	$_SESSION['user_role'] = "garbage";
         return 1; 
    }
    
    public function stop_session()
    {
         //$_SESSION['tok'] = -1;
         //session_destroy();
         return 1;
    }
    
    public function search_patients($by, $str)
    {
        //by 1 = name, 2 = id, 3 = number
        global $con;
	$q = mysql_real_escape_string($str, $con);
        
        if($by == 2)
         {
             //$count = search_patients_by_id_count($q);
             $patient_list = search_patients_by_id($q);
             if(count($patient_list) > 0)
                $ret = $patient_list;
             else
                $ret = 0;
         }
         else if($by == 1)
         {
             //$count = search_patients_by_name_count($q);
             $patient_list = search_patients_by_name($q);
             if(count($patient_list) > 0)
                $ret = $patient_list;
             else
                $ret = 0;
         }
         else if($by == 3)
         {
             //$count = search_patients_by_dailynum_count($q);
             $patient_list = search_patients_by_dailynum($q);
             if(count($patient_list) > 0)
                $ret = $patient_list;
             else
                $ret = 0;
         }
         else
         {
            return -1;
         }
         return $ret;
         
    }
    
    public function search_specimens($by, $str)
    {
        //by 3 = patient name, 2 = patient id, 1 = specimen_id
        global $con;
	$q = mysql_real_escape_string($str, $con);
        
        if($by == 1)
         {
             $patient_list = search_specimens_by_id($q);
            if(count($patient_list) > 0)
                $ret = $patient_list;
            else
                $ret = 0;
         }
         else if($by == 3)
         {
             $patient_list = search_specimens_by_patient_name($q);
             if(count($patient_list) > 0)
                $ret = $patient_list;
             else
                $ret = 0;
         }
         else if($by == 2)
         {
             $patient_list = search_specimens_by_patient_id($q);
             if(count($patient_list) > 0)
                $ret = $patient_list;
             else
                $ret = 0;
         }
         else
         {
            return -1;
         }
         return $ret;
         
    }
    
    public function get_tests($specimen_id)
    {
        $test_list = get_tests_by_specimen_id($specimen_id);
        if(count($test_list) > 0)
                $ret = $test_list;
             else
                $ret = 0;
             
        return $ret;
    }
    
    public function get_patient($patient_id)
    {
         /*$chk = check_api_token($tok);
        if($chk != 1)
        return $chk;*/
        
        $pat = get_patient_by_id($patient_id);
        if($pat != 3)
                $ret = $pat;
             else
                $ret = 0;
             
        return $ret;
    }
    
    public function get_specimen($specimen_id)
    {
        $spec = get_specimen_by_id($specimen_id);
        if(count($spec) > 0)
                $ret = $spec;
             else
                $ret = 0;
             
        return $ret;
    }
     
    public function get_specimen_catalog()
    {
        global $CATALOG_TRANSLATION;
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }

            if($lab_config_id == null)
            {
                $lab_config_id = get_lab_config_id_admin($_SESSION['user_id']);
            }
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_stypes =
		"SELECT specimen_type_id, name FROM specimen_type WHERE disabled=0 ORDER BY name";
	$resultset = query_associative_all($query_stypes, $row_count);
	$retval = array();
	if($resultset) {
		foreach($resultset as $record)
		{
			if($CATALOG_TRANSLATION === true)
				$retval[$record['specimen_type_id']] = LangUtil::getSpecimenName($record['specimen_type_id']);
			else
				$retval[$record['specimen_type_id']] = $record['name'];
		}
	}
	DbUtil::switchRestore($saved_db);
        $catalog = $retval;
        if(count($catalog) > 0)
                $ret = $catalog;
             else
                $ret = 0;
             
        return $ret;
    }
    
    
    public function get_test_catalog()
    {
        global $CATALOG_TRANSLATION;
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }

            if($lab_config_id == null)
            {
                $lab_config_id = get_lab_config_id_admin($_SESSION['user_id']);
            }
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_ttypes =
		"SELECT test_type_id, name FROM test_type WHERE disabled=0 ORDER BY name";
	$resultset = query_associative_all($query_ttypes, $row_count);
	$retval = array();
	if($resultset) {
		foreach($resultset as $record)
		{
			if($CATALOG_TRANSLATION === true)
				$retval[$record['test_type_id']] = LangUtil::getTestName($record['test_type_id']);
			else
				$retval[$record['test_type_id']] = $record['name'];
		}
	}
	DbUtil::switchRestore($saved_db);
        $catalog = $retval;
        if(count($catalog) > 0)
                $ret = $catalog;
             else
                $ret = 0;
             
        return $ret;
    }
    
    
    public function get_lab_sections()
    {
        /*$chk = check_api_token($tok);
        if($chk != 1)
        return $chk;*/
        
        global $CATALOG_TRANSLATION;
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }

            if($lab_config_id == null)
            {
                $lab_config_id = get_lab_config_id_admin($_SESSION['user_id']);
            }
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$query_stypes =
		"SELECT test_category_id, name, description FROM test_category";
	$resultset = query_associative_all($query_stypes, $row_count);
	$retval = array();
        DbUtil::switchRestore($saved_db);
	if($resultset) {
            $ret = $resultset;
	}
        else
             $ret = 0;
	             
        return $ret;
    }
    
    public function get_test_type($test_type_id)
    {
        global $con;
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }

            if($lab_config_id == null)
            {
                $lab_config_id = get_lab_config_id_admin($_SESSION['user_id']);
            }
		$test_type_id = mysql_real_escape_string($test_type_id, $con);
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		$query_string =
			"SELECT * FROM test_type WHERE test_type_id=$test_type_id LIMIT 1";
		$record = query_associative_one($query_string);
		
		$test_type = TestType::getObject($record);
         
        //print_r($test_type);
                $ret = array();
        if($test_type != null)
                $ret['info'] = $test_type;
             else
                return 0;
        $measure_list = array();

         $measure_list_objs = $test_type->getMeasures();
                //print_r($measure_list);
                $submeasure_list_objs = array();
                
                $comb_measure_list = array();
               // print_r($measure_list);
                
                foreach($measure_list_objs as $measure)
                {
                    
                    $submeasure_list_objs = $measure->getSubmeasuresAsObj();
                    //echo "<br>".count($submeasure_list);
                    //print_r($submeasure_list);
                    $submeasure_count = count($submeasure_list_objs);
                    
                    if($measure->checkIfSubmeasure() == 1)
                    {
                        continue;
                    }
                        
                    if($submeasure_count == 0)
                    {
                        array_push($comb_measure_list, $measure);
                    }
                    else
                    {
                        array_push($comb_measure_list, $measure);
                        foreach($submeasure_list_objs as $submeasure)
                           array_push($comb_measure_list, $submeasure); 
                    }
                }
                
                $measure_list_ids = array();
                //echo "<pre>";
                //print_r($comb_measure_list);
                //echo "</pre>";
                foreach($comb_measure_list as $measure)
                {
                    array_push($measure_list_ids, $measure->measureId);
                }
                /*
                echo "<pre>";
                print_r($measure_list);
                
                print_r($measure_list_ids);
                echo "</pre>";
                */
                $measure_list = $measure_list_ids;
                //print_r($measure_list_objs);
                $ret['measures'] = $measure_list_objs;
             DbUtil::switchRestore($saved_db);
        return $ret;
    } 
    
    public function get_patient_results($patient_id, $date_from, $date_to, $ip)
    {
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lab_config_id = $user->labConfigId;
        }

            if($lab_config_id == null)
            {
                $lab_config_id = get_lab_config_id_admin($_SESSION['user_id']);
            }
        $recs = api_get_patient_records($lab_config, $patient_id, $date_from, $date_to, $ip);
        //echo "<pre>";
        //print_r($recs);
        $rtt = array();
        foreach($recs as $tobj)
            $rtt[$tobj[0]->testId] = api_decode_results ($tobj[0]);
        
        return $rtt;
            
    }
    
    public function get_inventory()
    {
        //print_r($_SESSION);
        /*
        $chk = check_api_token($tok);
        if($chk != 1)
        return $chk;
        */
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lid = $user->labConfigId;
        }

            if($lid == null)
            {
                $lid = get_lab_config_id_admin($_SESSION['user_id']);
            }
         $reagents_list = Inventory::getAllReagents($lid);
         $cc = 1;
        foreach($reagents_list as $reagent) 
        {
            $quant = Inventory::getQuantity($lid, $reagent['id']);
            // $uni = $reagent['unit'];
             $spec[$cc]['id'] =  $reagent['id'];
              $spec[$cc]['name'] =  $reagent['name'];
               $spec[$cc]['unit'] =  $reagent['unit'];
               $spec[$cc]['remarks'] =  $reagent['remarks'];
               $spec[$cc]['quantity'] =  $quant;
               $cc++;
        }
        //$spec = get_specimen_by_id($specimen_id);
        if(count($spec) > 0)
                $ret = $spec;
             else
                $ret = 0;
             
        return $ret;
    }
   
    public function get_stock_lots($r_id)
    {
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lid = $user->labConfigId;
        }

            if($lid == null)
            {
                $lid = get_lab_config_id_admin($_SESSION['user_id']);
            }
        $stocks_list = Inventory::getStocksList($lid, $r_id);
    
         $cc = 1;
        foreach($stocks_list as $stock) 
        {
            $quant = Inventory::getQuantity($lid, $reagent['id']);
            // $uni = $reagent['unit'];
             $spec[$cc]['id'] = $stock['id'];
              $spec[$cc]['lot'] =  $stock['lot'];
               $spec[$cc]['manufacturer'] =  $stock['manufacturer'];
                $spec[$cc]['supplier'] =  $stock['supplier'];
                $spec[$cc]['date_of_reception'] =  $stock['date_of_reception'];
               $spec[$cc]['remarks'] =  $stock['remarks'];
               $dp = explode("-", $stock['expiry_date']);
                            $e_date = $dp[2]."/".$dp[1]."/".$dp[0];
               $spec[$cc]['expiry_date'] =  $e_date;             
               $spec[$cc]['current_quantity'] =  Inventory::getLotQuantity($lid, $r_id, $stock['lot']);
               $spec[$cc]['quantity_supplied'] =  $stock['quantity_suppied'];
               $cc++;
        }
        
        //$spec = get_specimen_by_id($specimen_id);
        if(count($spec) > 0)
                $ret = $spec;
             else
                $ret = 0;
             
        return $ret;
    }
    
    public function get_stock_usage($r_id, $lot)
    {
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lid = $user->labConfigId;
        }

            if($lid == null)
            {
                $lid = get_lab_config_id_admin($_SESSION['user_id']);
            }
        //$stocks_list = Inventory::getStocksList($lid, $r_id);
        $lab_config_id = $lid;

                    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     

                    $query_string = "SELECT * from inv_usage WHERE reagent_id = $r_id AND lot = '$lot'";
                    $recordset = query_associative_all($query_string, $row_count);

                    DbUtil::switchRestore($saved_db);
         $cc = 1;
         //echo "-".$recordset."-";
         //print_r($recordset);
         $spec = array();
        foreach($recordset as $stock) 
        {
            $quant = Inventory::getQuantity($lid, $reagent['id']);
            // $uni = $reagent['unit'];
             $spec[$cc]['id'] = $stock['id'];
              $spec[$cc]['quantity_used'] =  $stock['quantity_used'];;
               $spec[$cc]['user_id'] =  $stock['user_id'];
               $spec[$cc]['remarks'] =  $reagent['remarks'];
               $dp = explode("-", $stock['date_of_use']);
                            $e_date = $dp[2]."/".$dp[1]."/".$dp[0];
               $spec[$cc]['date_of_use'] =  $e_date;             
               $cc++;
        }
        
        //$spec = get_specimen_by_id($specimen_id);
        if(count($spec) > 0)
                $ret = $spec;
             else
                $ret = 0;
             
        return $ret;
    }
    
    public function get_test_cost($tid)
    {
        if($_SESSION['level'] < 2 || $_SESSION['level'] > 4)
        {
            $user = get_user_by_id($_SESSION['user_id']);
            $lid = $user->labConfigId;
        }

            if($lid == null)
            {
                $lid = get_lab_config_id_admin($_SESSION['user_id']);
            }
        //$stocks_list = Inventory::getStocksList($lid, $r_id);
        $lab_config_id = $lid;

                    $saved_db = DbUtil::switchToLabConfig($lab_config_id);     

                    $query_string = "SELECT * from test_type_costs WHERE test_type_id = $tid ORDER BY earliest_date_valid DESC LIMIT 1";
                    $record = query_associative_one($query_string);

                    DbUtil::switchRestore($saved_db);
        
        if($record != null)
                $ret = $record['amount'];
             else
                $ret = -1;
             
        return $ret;
    }
    
}
	
   
/* API ends here */
class DHIMS2
{
	public $ID;
	public $username;
	public $password;
	public $orgUnit;
	public $dataSet;
	public $dataElement;
	public $entryPeriod;
	public $categoryCombo;
	public $blisTestID;
	public $blisAgegroup;
	public $blisGender;
	
	public function Save($lab_config_id)
	{
		$sql="INSERT INTO `dhims2_api_config` (
`id` ,`username` ,`password` ,`orgunit` ,`dataset` ,
`dataelement` ,`categorycombo` ,`gender` ,`period`)
VALUES (NULL , '$this->username', '$this->password', '$this->orgUnit', '$this->dataSet',
 '$this->dataElement".'|'."$this->blisTestID', '$this->categoryCombo".'|'."$this->blisAgegroup', '$this->blisGender', '$this->entryPeriod');";
		query_blind($sql,$db);	
		return 1;
	}
	
	public function deleteItems($lab_config_id,$items)
	{
		$sql ="delete from dhims2_api_config where id in ($items)";
		query_blind($sql,$db);	
		return 1;
	}
	
	public function getSendingConfigs($lab_config_id)
	{
		
		$sql="select * from dhims2_api_config";
		$resultset = query_associative_all($sql, $row_count,$lab_config_id);		
		$results = array();
		$larr = array();		
		$icount= count($resultset);	
		
		for($i=0;$i<$icount;$i++)
		{
			$orgunit = explode('^',$resultset[$i]['orgunit']);						
			$larr['orgUnit'] = $orgunit[0];					
			$dataset = explode('^',$resultset[$i]['dataset']);
			$larr['dataSet'] = $dataset[0];			
			$dataelement = explode('|',$resultset[$i]['dataelement']);
			$dsetparts = explode('^',$dataelement[0]);
			$larr['dataElement'] = $dsetparts[0];
			
			$elementname = "";			
			for($dcount=1;$dcount<count($dataelement);$dcount++)
			{
				$tmp = explode('^',$dataelement[$dcount]);
				if(empty($elementname))
					$elementname .= $tmp[0];
				else
					$elementname .= '+'.$tmp[0];
			}			
			
			$larr['blistestID']=$elementname;			
			$categorycombo = explode('^',$resultset[$i]['categorycombo']);
			$larr['categoryOptionCombo'] = $categorycombo[0];
			$comboname = explode('|',$categorycombo[1]);			
			$larr['blisageGroup'] = $comboname[1];			
			$larr['gender'] = $resultset[$i]['gender'];
			$larr['period'] = $resultset[$i]['period'];			
			$results[] = $larr;
			$larr = array();					
		
		}
		//file_put_contents("dhims2.txt",print_r($results));
				
		return $results;
		
		//print_r($results);
	}	
	
	public function getConfigs($lab_config_id)
	{		
		$sql="select * from dhims2_api_config";
		$resultset = query_associative_all($sql, $row_count,$lab_config_id);		
		$results = array();
		$larr = array();	
		$orgunitTrimList = array();	
		$datasetTrimList = array();	
		$dataelementTrimList = array();
		$genderTrimList = array();
		$icount= count($resultset);	
		for($i=0;$i<$icount;$i++)
		{
			$orgunit = explode('^',$resultset[$i]['orgunit']);
			if(!in_array($orgunit[0],$orgunitTrimList))
			{				
				$larr['id'] = $orgunit[0];
				$larr['pId'] = 0;
				$larr['name'] = $orgunit[1];
				$larr['open'] = true;
				$larr['ename'] = $resultset[$i]['id'];
				$results[] = $larr;
				$larr = array();
				$orgunitTrimList[] = $orgunit[0];
			}
			
			$dataset = explode('^',$resultset[$i]['dataset']);
			if(!in_array($dataset[0],$datasetTrimList))
			{
				$larr['id'] = $dataset[0];
				$larr['pId'] = $orgunit[0];
				$larr['name'] = $dataset[1];
				$larr['isParent'] = true;
				$larr['open'] = true;
				$larr['ename'] = $resultset[$i]['id'];
				$results[] = $larr;
				$larr = array();
				$datasetTrimList[] = $dataset[0];
			}			
			
			$dataelement = explode('|',$resultset[$i]['dataelement']);
			//$elementname = explode('|',$dataelement[1]);
			$elementname = "";
			$dsetparts = explode('^',$dataelement[0]);  //.$elementname[1];
			for($dcount=1;$dcount<count($dataelement);$dcount++)
			{
				$tmp = explode('^',$dataelement[$dcount]);
				if(empty($elementname))
					$elementname .= $tmp[1];
				else
					$elementname .= '+'.$tmp[1];
			}
			
			$dsetElem = $dsetparts[0];
			if(!in_array($dsetElem,$dataelementTrimList))
			{
				$larr['id'] = $dsetElem;
				$larr['pId'] = $dataset[0];				
				$larr['name'] = $dsetparts[1].'-->'.$elementname;
				$larr['open'] = true;
				$larr['isParent'] = true;
				$larr['ename'] = $resultset[$i]['id'];
				$results[] = $larr;
				$larr = array();
				$dataelementTrimList[] = $dsetElem;
			}
			
					
			if(	$resultset[$i]['gender'] =="M")
			{
				if(!in_array( $dsetElem.'_M',$genderTrimList))
				{
					$larr['id'] = $dsetElem.'_M';
					$larr['pId'] = $dsetElem;
					$comboname = explode('|',$categorycombo[1]);			
					$larr['name'] ="Male";
					$larr['open'] = true;
					$larr['isParent'] = true;
					$larr['ename'] = $resultset[$i]['id'];
					$results[] = $larr;
					$larr = array();
					$genderTrimList[] = $dsetElem.'_M';
				}
			
				$categorycombo = explode('^',$resultset[$i]['categorycombo']);
				$larr['id'] = $categorycombo[0];
				$larr['pId'] =  $dsetElem.'_M';
				$comboname = explode('|',$categorycombo[1]);			
				$larr['name'] = $comboname[0].'-->'.$comboname[1];
				$larr['open'] = true;
				$larr['ename'] = $resultset[$i]['id'];
				$results[] = $larr;
				$larr = array();
			}
			elseif(	$resultset[$i]['gender'] =="F")
			{
				if(!in_array( $dsetElem.'_F',$genderTrimList))
				{
					$larr['id'] = $dsetElem.'_F';
					$larr['pId'] = $dsetElem;
					$comboname = explode('|',$categorycombo[1]);			
					$larr['name'] ="Female";
					$larr['open'] = true;
					$larr['isParent'] = true;
					$larr['ename'] = $resultset[$i]['id'];
					$results[] = $larr;
					$larr = array();
					$genderTrimList[] = $dsetElem.'_F';
				}
				
				$categorycombo = explode('^',$resultset[$i]['categorycombo']);
				$larr['id'] = $categorycombo[0];
				$larr['pId'] =  $dsetElem.'_F';
				$comboname = explode('|',$categorycombo[1]);			
				$larr['name'] = $comboname[0].'-->'.$comboname[1];
				$larr['open'] = true;
				$larr['ename'] = $resultset[$i]['id'];
				$results[] = $larr;
				$larr = array();
			}
			else
			{
				if(!in_array( $dsetElem.'_B',$genderTrimList))
				{
					$larr['id'] = $dsetElem.'_B';
					$larr['pId'] = $dsetElem;
					$comboname = explode('|',$categorycombo[1]);			
					$larr['name'] ="Male & Female";
					$larr['open'] = true;
					$larr['isParent'] = true;
					$larr['ename'] = $resultset[$i]['id'];
					$results[] = $larr;
					$larr = array();
					$genderTrimList[] = $dsetElem.'_B';
				}
				
				$categorycombo = explode('^',$resultset[$i]['categorycombo']);
				$larr['id'] = $categorycombo[0];
				$larr['pId'] =  $dsetElem.'_B';
				$comboname = explode('|',$categorycombo[1]);			
				$larr['name'] = $comboname[0].'-->'.$comboname[1];
				$larr['open'] = true;
				$larr['ename'] = $resultset[$i]['id'];
				$results[] = $larr;
				$larr = array();
			}
			
			//if($i==2)
			//break;
		}
		//file_put_contents("dhims2.txt",print_r($results));
				
		return $results;
		
		//print_r($results);
	}	

}

	
	function getEquipmentList()
	{
		$saved_db = DbUtil::switchToGlobal();
		$query_configs = "SELECT id,equipment_name from interfaced_equipment";
		
		$resultset = query_associative_all($query_configs,0);
		
		   
		DbUtil::switchRestore($saved_db);
		return $resultset;
	}
	
	function getEquipmentDetails($id)
	{
		$saved_db = DbUtil::switchToGlobal();
		$query_configs = "SELECT * from interfaced_equipment where id={$id}";
		
		$resultset = query_associative_all($query_configs,0);
		
		   
		DbUtil::switchRestore($saved_db);
		return $resultset;
	}
	function getEquipmentProps($id)
	{
		$saved_db = DbUtil::switchToGlobal();
		$query_configs = "SELECT * from equip_config where equip_id={$id}";
		
		$resultset = query_associative_all($query_configs,0);
		
		   
		DbUtil::switchRestore($saved_db);
		return $resultset;
	}
?>
