<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Functions for adding random data records (for evaluation phase only)
#

if(strpos($_SERVER['HTTP_REFERER'], "lab_config_home.php") !== false)
{
	require_once("../includes/db_lib.php");
}
else
{
	require_once("../includes/db_lib.php");
}



set_time_limit(1800000);

$con = mysql_connect( $DB_HOST, $DB_USER, $DB_PASS );

$MAX_NUM_PATIENTS = 5000000;
$MAX_NUM_SPECIMENS = 5000000;

$NUM_PATIENTS = 2000;
$NUM_SPECIMENS = 0;

$PATIENT_ID_START = 1;
$SPECIMEN_ID_START = 1;
$TEST_ID_START = 1;
$TESTS_ADDED = 0;

$today = date("Y-m-d");
# Specimen collection date range
$MIN_COLLECTION_DATE = "2009-01-01";
$MAX_COLLECTION_DATE = "2012-02-01";//date("Y-m-d", strtotime(date("Y-m-d", strtotime($today)) . " -2 days")); // "2009-10-30";

# Probability of scheduling a new test type to currently handled specimen
$P_NEW_TEST = 0.20;
# Fraction of specimen entries to leave as "pending"
$F_PENDING = 0.01;

function csv_append($value, &$csv_string)
{
	$csv_string .= $value.",";
}

function with_probability($probability)
{
	# Simulates guessing yes/no with probability
	$start = 1;
	$end = 1000;
	$random_value = rand($start, $end);
	$norm_value = (float) $random_value/$end;
	if($norm_value <= $probability)
		return true;
	else
		return false;
}

function get_random_gender() {
	$val = rand(1,2);
	if( $val == 1 )
		return 'F';
	return 'M';
}

function get_random_name() {
	$length = 6;
	$charset='abcdefghijklmnopqrstuvwxyz';
	$str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
	$length = 6;
	$str .= " ";
	while ($length--) {
		$str .= $charset[mt_rand(0, $count-1)];
	}
    //$str = "Bob";
    return $str;
}

function getRandomDateWithTime($ts_start, $ts_end) {
	$value = rand($ts_start, $ts_end);
	return date("Y-m-d H:i:s", $value);
}

function get_random_date($ts_start, $ts_end) {
	$value = rand($ts_start, $ts_end);
	return date("Y-m-d", $value);
}

function get_random_element($list)
{
	# Returns a random element from the list
	$min = 0;
	if(count($list) == 0)
		return null;
	$max = count($list) - 1;
	if($max == 0)
		return $list[0];
	$random = rand($min, $max);
	return $list[$random];
}

function get_random_element_index($list)
{
	# Returns a random index from the list
	$min = 0;
	if(count($list) == 0)
		return null;
	$max = count($list) - 1;
	if($max == 0)
		return 0;
	$random = rand($min, $max);
	return $random;
}

function remove_element_by_index(&$list, $index)
{
	# Removes a list element at the given index and reorganizes the list
	$retval = $list[$index];
	unset($list[$index]);
	$list = array_values($list);
	return $retval;
}

function get_random_patient_id()
{
	# Assumes patient entries have already been added
	global $PATIENT_ID_START, $NUM_PATIENTS;
	$min = $PATIENT_ID_START;
	$max = $min + $NUM_PATIENTS - 1;
	return rand($min, $max);
}

function get_random_range_value($range_string)
{
	# Returns a random test result value for the given range
	if(strpos($range_string, ":") === false)
	{
		if(strpos($range_string, "/") === false)
		{
			# Error
			# TODO: Add error handling here
			return;
		}
		# Discrete value range (e.g. P/N/I)
		$range_options = explode("/", $range_string);
		$retval = get_random_element($range_options);
		return $retval;
	}
	# Continuous value range (e.g. 1:1000)
	$range_bounds = explode(":", $range_string);
	$retval = rand((int)$range_bounds[0], (int)$range_bounds[1]);
	return $retval;
}

function get_random_ts($reference_date)
{
	# Generates a randomt timestamp string on or after the reference date
	$rand_hour = rand(1, 12);
	list($year, $month, $day) = explode('-', $reference_date);
	$offset_ts = mktime($rand_hour, 0, 0, $month, $day+1, $year);
	return date("Y-m-d H:i:s", $offset_ts);
}

function get_new_test($specimen_id, &$candidate_test_list, $testTs)
{
	# Creates a new Test from the candidate test list for the given specimen id
	global $TEST_ID_START, $TESTS_ADDED;
	$random_test_index = get_random_element_index($candidate_test_list);
	$test_type_id = remove_element_by_index($candidate_test_list, $random_test_index);
	$test = new Test();
	$test->testId = $TEST_ID_START + $TESTS_ADDED;
	$test->testTypeId = $test_type_id;
	$test->result = ""; # Denotes pending results
	$test->specimenId = $specimen_id;
	$test->comments = "";
	$test->userId = 0;
	$test->ts = $testTs;
	return $test;
}

function empty_patient_table()
{
	$query_string = "TRUNCATE TABLE patient";
	query_blind($query_string);
}

function empty_specimen_table()
{
	$query_string = "TRUNCATE TABLE specimen";
	query_blind($query_string);
}

function empty_test_table()
{
	$query_string = "TRUNCATE TABLE test";
	query_blind($query_string);
}

function add_patients_random($num_patients)
{
	# Adds random patient entries
	global $MAX_NUM_PATIENTS, $NUM_PATIENTS;
	if($num_patients > $MAX_NUM_PATIENTS)
	{
		$num_patients = $MAX_NUM_PATIENTS;
	}
	//$patient_sql_filename = "../data/patients.sql";	
	/*
	if(strpos($_SERVER['HTTP_REFERER'], "lab_config_home.php") !== false)
	{
		$patient_sql_filename = "../data/patients.sql";	
	}
	else
	{
		$patient_sql_filename = "../data/patients.sql";	
	}
	*/	
	/*$patient_sql_file = fopen($patient_sql_filename, 'r');
	$count = 0;
	while($count < $num_patients)
	{
		$sql = fgets($patient_sql_file);
		query_insert_one($sql);
		$count++;
	}
	*/
	$count = 1;
	$minDate = "1930-01-01";
	$maxDate = "2011-01-01";
	while($count <= $num_patients) {
		$patientId = $count;
		$addl_id = $count + 5000;
		$surr_id = $count + 8500;
		$name = get_random_name();
		$sex = get_random_gender();
		$dob = get_random_date($minDate, $maxDate);
		$sql = "INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)".
				"VALUES ($patientId, '$name' , '$dob' , '$sex', $addl_id, $surr_id)";
                        query_insert_one($sql);
		
		$count++;
	}
	$NUM_PATIENTS = $num_patients;
}

function add_specimens_random($num_specimens, $user_list=array())
{
	# Adds random specimen entries with some tests scheduled
	global $MAX_NUM_SPECIMENS, $SPECIMEN_ID_START, $TESTS_ADDED, $NUM_SPECIMENS;
	global $MIN_COLLECTION_DATE, $MAX_COLLECTION_DATE, $P_NEW_TEST;
	$doctorNames = array('Buck','Harrel','Knight','Myers','Guzman','Jones','Fox','Hood','Sweeney','Dillards');
	$lab_config_id = $_SESSION['lab_config_id'];
	$min_date = $MIN_COLLECTION_DATE;
	$max_date = $MAX_COLLECTION_DATE;
	list($y_start, $m_start, $d_start) = explode("-", $min_date);
	list($y_end, $m_end, $d_end) = explode("-", $max_date);
	$ts_start = mktime(0, 0, 0, $m_start, $d_start, $y_start);
	$ts_end = mktime(0, 0, 0, $m_end, $d_end, $y_end);
	if($num_specimens > $MAX_NUM_SPECIMENS)
	{
		$num_specimens = $MAX_NUM_SPECIMENS;
	}
	
	$specimen_type_list = get_lab_config_specimen_types($lab_config_id);
	$test_type_list = get_lab_config_test_types($lab_config_id);
	$count = 0;
	$specimen_id_count = $SPECIMEN_ID_START;
	while($count < $num_specimens)
	{
		$user_id = 0;
		if(count($user_list) != 0)
		{
			$random_user_index = rand(1, count($user_list));
			$random_user = $user_list[$random_user_index-1];
			$user_id = $random_user->userId;
		}
		$specimen_type_id = get_random_element($specimen_type_list);
		$patient_id = get_random_patient_id();

		# Create a new specimen entry
		$specimen = new Specimen();
		$specimen->specimenId = $specimen_id_count;
		$specimen->specimenTypeId = $specimen_type_id;
		$specimen->patientId = $patient_id;
		$specimen->userId = $user_id; 
		# Alternatively, above userId can be linked to $_SESSION['user_id']
		$randomDate = get_random_date($ts_start, $ts_end);
		$specimen->dateCollected = $randomDate;
		$specimen->dateRecvd = $specimen->dateCollected;
		$specimen->statusCodeId = Specimen::$STATUS_PENDING;
		$specimen->reportTo = 1;
		$specimen->doctor = $doctorNames[rand(0,9)];
		$specimen->referredTo = 0;
		$specimen->comments = "";
		$specimen->auxId = "";
			
		# Schedule tests for this specimen
		$compatible_test_list = get_compatible_tests($specimen_type_id);
		if(count($compatible_test_list) == 0)
		{
			# No compatible tests found in the lab configuration
			# Undo specimen entry addition
			//rollback_transaction();
			# TODO: Add error handling here (or do checking on front-end)
			# Update counters
			$TESTS_ADDED++;
			$specimen_id_count++;
			$count++;
			continue;
		}
		$candidate_test_list = array_values(array_intersect($compatible_test_list, $test_type_list));
		if(count($candidate_test_list) == 0)
		{
			# No compatible tests found in the lab configuration
			# Undo specimen entry addition
			//rollback_transaction();
			# Update counters
			$TESTS_ADDED++;
			$specimen_id_count++;
			$count++;
			continue;
		}
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		add_specimen($specimen);
		list($y_end, $m_end, $d_end) = explode("-", $randomDate);
		$rstartTime = mktime(0, 0, 0, $m_end, $d_end, $y_end);
		$rendTime = mktime(23, 59, 59, $m_end, $d_end, $y_end);
		do
		{
			$testTs = getRandomDateWithTime($rstartTime, $rendTime);
			$test_entry = get_new_test($specimen_id_count, $candidate_test_list, $testTs);
			add_test_random($test_entry);
		} while(with_probability($P_NEW_TEST) && (count($candidate_test_list) > 0));
		DbUtil::switchRestore($saved_db);
		//commit_transaction();
		
		# Update counters
		$TESTS_ADDED++;
		$specimen_id_count++;
		$count++;
	}
	# Update global count fo book-keeping
	$NUM_SPECIMENS = $num_specimens;
}

function add_results_random($user_list=array())
{
	# Adds random result entries for scheduled specimen
	global $NUM_SPECIMENS, $F_PENDING, $SPECIMEN_ID_START;
	$lab_config_id = $_SESSION['lab_config_id'];
	//$specimens_to_handle = floor($NUM_SPECIMENS * (1-$F_PENDING));
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$num_specimens2 = query_num_rows("specimen");
	DbUtil::switchRestore($saved_db);
	$specimens_to_handle = floor($num_specimens2 * (1-$F_PENDING));
	//echo $specimens_to_handle." / ".$num_specimens2."<br>";
	$count = 0;
	$specimen_id_count = $SPECIMEN_ID_START;
	while($count < $specimens_to_handle)
	{
		# Fetch random specimen
		//$specimen_id = rand($SPECIMEN_ID_START, $SPECIMEN_ID_START + $NUM_SPECIMENS);
		$specimen_id =  $specimen_id_count;
		//echo $specimen_id."<br>";
		$specimen = get_specimen_by_id($specimen_id);
		if($specimen == null)
		{
			# TODO:
		}
		$result_entry_ts = get_random_ts($specimen->dateCollected);
		if($specimen == null)
		{
			#  Specimen does not exist
			//echo "Specimen does not exist<br>";
			//$count++;
			$specimen_id_count++;
			continue;
		}
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);
		$status_code = get_specimen_status($specimen_id);
		DbUtil::switchRestore($saved_db);
		if($status_code == Specimen::$STATUS_DONE)
		{
			# Results already entered
			//echo "Results already entered<br>";
			$count++;
			$specimen_id_count++;
			continue;
		}
		# Fetch tests scheduled for this specimen
		$test_list = get_tests_by_specimen_id($specimen_id);
		# For each test, fetch test measures and range from catalog
		foreach($test_list as $test)
		{
			$measure_list = get_test_type_measures($test->testTypeId);
			$result_entry = "";
			foreach($measure_list as $measure)
			{
				$range = get_measure_range($measure);
				# Select random result value
				$result_val = get_random_range_value($range);
				csv_append($result_val, $result_entry);
			}
			$test_id = $test->testId;
			# Update result field in test entry
			$saved_db = DbUtil::switchToLabConfig($lab_config_id);
			# Select random technician as the one of entered this result
			$user_id = 0;
			if(count($user_list) != 0)
			{
				$random_user_index = rand(1, count($user_list));
				$random_user = $user_list[$random_user_index-1];
				$user_id = $random_user->userId;
			}
			add_test_result($test_id, $result_entry, "", "", $user_id, $result_entry_ts);
			# Randomly this test result mark as verified or keep as unverified
			# null or 0 => not verified, non-zero => verified.
			if(with_probability(0.90))
			{
				$is_verified = 2;
				$test->setVerifiedBy($is_verified);
			}			
			DbUtil::switchRestore($saved_db);
		}
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		# Mark specimen as 'all tests done'
		update_specimen_status($specimen_id);
		# Randomly mark this specimen as reported or keep as unreported
		if(with_probability(0.90))
		{
			$date_reported = date("Y-m-d H:i:s");
			$specimen->setDateReported($date_reported);
		}
		DbUtil::switchRestore($saved_db);
		# Update counters
		$count++;
		$specimen_id_count++;
	}
}

function add_results_sequential($user_list=array())
{
	# Adds random result entries for scheduled specimen
	global $NUM_SPECIMENS, $F_PENDING, $SPECIMEN_ID_START;
	$lab_config_id = $_SESSION['lab_config_id'];
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	$num_specimens2 = query_num_rows("specimen");
	$specimens_to_handle = floor($num_specimens2 * (1-$F_PENDING));
	$specimen_target_list = array();
	$query_string = "SELECT * FROM specimen ORDER BY date_collected LIMIT ".$specimens_to_handle;
	$resultset = query_associative_all($query_string, $row_count);
	foreach($resultset as $record)
	{
		$specimen_entry = Specimen::getObject($record);
		$specimen_target_list[] = $specimen_entry;
	}
	DbUtil::switchRestore($saved_db);
	$count = 0;
	$specimen_id_count = $SPECIMEN_ID_START;
	foreach($specimen_target_list as $specimen)
	{
		if($specimen == null)
		{
			# TODO:
		}
		$result_entry_ts = get_random_ts($specimen->dateCollected);
		if($specimen == null)
		{
			#  Specimen does not exist
			//echo "Specimen does not exist<br>";
			//$count++;
			$specimen_id_count++;
			continue;
		}
		$saved_db = DbUtil::switchToLabConfig($_SESSION['lab_config_id']);
		$specimen_id = $specimen->specimenId;
		$status_code = get_specimen_status($specimen_id);
		DbUtil::switchRestore($saved_db);
		if($status_code == Specimen::$STATUS_DONE)
		{
			# Results already entered
			//echo "Results already entered<br>";
			$count++;
			$specimen_id_count++;
			continue;
		}
		$patientId = $specimen->patientId;
		$currentPatient = Patient::getById($patientId);
		$hashValue = $currentPatient->generateHashValue();
		# Fetch tests scheduled for this specimen
		$test_list = get_tests_by_specimen_id($specimen_id);
		# For each test, fetch test measures and range from catalog
		foreach($test_list as $test)
		{
			$measure_list = get_test_type_measures($test->testTypeId);
			$result_entry = "";
			foreach($measure_list as $measure)
			{
				$range = get_measure_range($measure);
				# Select random result value
				$result_val = get_random_range_value($range);
				csv_append($result_val, $result_entry);
			}
			$test_id = $test->testId;
			# Update result field in test entry
			$saved_db = DbUtil::switchToLabConfig($lab_config_id);
			# Select random technician as the one of entered this result
			$user_id = 0;
			if(count($user_list) != 0)
			{
				$random_user_index = rand(1, count($user_list));
				$random_user = $user_list[$random_user_index-1];
				$user_id = $random_user->userId;
			}
			add_test_result($test_id, $result_entry, "", "", $user_id, $result_entry_ts, $hashValue);
			# Randomly this test result mark as verified or keep as unverified
			# null or 0 => not verified, non-zero => verified.
			if(with_probability(0.90))
			{
				$is_verified = 2;
				$test->setVerifiedBy($is_verified);
			}			
			DbUtil::switchRestore($saved_db);
		}
		$saved_db = DbUtil::switchToLabConfig($lab_config_id);
		# Mark specimen as 'all tests done'
		update_specimen_status($specimen_id);
		# Randomly mark this specimen as reported or keep as unreported
		if(with_probability(0.90))
		{
			$date_reported = date("Y-m-d H:i:s");
			$specimen->setDateReported($date_reported);
		}
		DbUtil::switchRestore($saved_db);
		# Update counters
		$count++;
		$specimen_id_count++;
	}
}

#
# Functions for managing random data on an existing configuration
#

function clear_random_data($lab_config)
{
	# TODO:
	if($lab_config == null)
		return;
	# Remove entries from 'test' table and 'specimen' table
	global $MAX_NUM_PATIENTS, $MAX_NUM_SPECIMENS, $PATIENT_ID_START, $SPECIMEN_ID_START;
	$saved_db = DbUtil::switchToLabConfig($lab_config->id);
	for($i = $SPECIMEN_ID_START; $i <= $SPECIMEN_ID_START + $MAX_NUM_SPECIMENS; $i++)
	{
		$query_string = "DELETE FROM test WHERE specimen_id=$i";
		query_blind($query_string);
		$query_string = "DELETE FROM specimen WHERE specimen_id=$i";
		query_blind($query_string);
	}
	# Remove entries from 'patient' table
	for($i = $PATIENT_ID_START; $i <= $PATIENT_ID_START + $MAX_NUM_PATIENTS; $i++)
	{
		$query_string = "DELETE FROM patient WHERE patient_id=$i";
		query_blind($query_string);
	}
	DbUtil::switchRestore($saved_db);
}
?>