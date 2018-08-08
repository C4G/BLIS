<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Contains defaults for missing or incomplete DB tables and other system parameters
# Included at the beginning on includes/db_lib.php
#

# System version number displayed on page title and footer
$VERSION = "3.4";

# Debug mode
$DEBUG = false;

# Default language for the system
# Used to fetch appropriate locale file from lang/$DEFAULT_LANG.php
$DEFAULT_LANG = "default";

# Lab Id Starts for various countries
$labIdArray = array(
	"Cameroon" => 1,
	"Ghana" => 1001,
	"Uganda" => 2001,
	"Tanzania" => 3001,
	 "Drc" =>4001
);

# Default target turnaround time value (in days) for tests if not yet specified by lab admin
# Can be modified by lab admin on config/lab_config_home.php
$DEFAULT_TARGET_TAT = 1;

# Default turnaround time value (in days) for tests that are still pending
# Can be modified by lab admin on config/lab_config_home.php
$DEFAULT_PENDING_TAT = 2;

# Auto logout after user inactivity
# Session times out and redirects to login page
# Refer to js/auto_logout.js
$AUTO_LOGOUT = false;

# Turn on or off Catalog translation
# If true, name strings are fetched from local strings instead of DB
$CATALOG_TRANSLATION = false;

# Report IDs for daily reports
$REPORT_ID_ARRAY = array(
	"reports_testhistory.php" => 1,
	"reports_specimen.php" => 2,
	"reports_print.php" => 3,
	"reports_dailyspecimens.php" => 4,
	"reports_dailypatients.php" => 6,
	"worksheet.php" => 5,
	"reports_billing_specific.php" => 7,
	"reports_dailypatientBarcodes.php" => 77
);

# Default max width of the window (in pixels)
$SCREEN_WIDTH = 1000;

#List of available date formats in PHP
$DATE_FORMAT_LIST = array(
	"d-m-Y", 
	"m-d-Y", 
	"Y-m-d"
);

$DATE_FORMAT_PRETTY_LIST = array(
	"dd-mm-yyyy", 
	"mm-dd-yyyy", 
	"yyyy-mm-dd"
);

# Default date format used when no entry found in lab configuration (enter one from $DATE_FORMAT_LIST)
$DEFAULT_DATE_FORMAT = "d-m-Y";

# Flags for showing/hiding report options (reports.php)
$SHOW_SPECIMEN_REPORT = false;
$SHOW_TESTRECORD_REPORT = false;
$SHOW_PENDINGTEST_REPORT = false;

# Flags for showing/hiding results entry options (results_entry.php)
$SHOW_REPORT_RESULTS = false;

#
# Debugging related flags
#

# Log all SQL queries with timestamp and other info.
# Dumped into /log directory
$LOG_QUERIES = true;

# Length of patient ID hash (generated from name, sex, date of birth)
$PATIENT_HASH_LENGTH = 40;

# Disable updating of patient profile by users
$DISABLE_UPDATE_PATIENT_PROFILE = false;

#Default system patient fields. These fields are predefined in the system
$SYSTEM_PATIENT_FIELDS = array(
	'p_field_0' => 'PATIENT_ID',
	'p_field_9' => 'PATIENT_BARCODE',	
	'p_field_10' => 'PATIENT_SIGNATURE',
	'p_field_1' => 'PATIENT_DAILYNUM',	
	'p_field_2' => 'ADDL_ID',
	'p_field_3' => 'GENDER',
	'p_field_4' => 'AGE',
	'p_field_5' => 'DOB',
	'p_field_6' => 'NAME',
	'p_field_7' =>'TEST',
	'p_field_8' => 'REGISTRATION_DATE',
	'p_field_11' => 'useRequesterName',
	'p_field_12' => 'useReferredToHospital');


?>
