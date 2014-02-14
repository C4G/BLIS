<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# File for updating the database. All db queries to update the database should be placed here
# Called after htdocs update succeeds
#
include("redirect.php");
include("../includes/db_lib.php");
include("../includes/user_lib.php");

$user = get_user_by_id($_SESSION['user_id']);

if ( is_super_admin($user) || is_country_dir($user) ) {
	$labConfigList = get_lab_configs($user->userId);
	foreach($labConfigList as $labConfig) {
		$labConfigId = $labConfig->id;
		runUpdate($labConfigId);
	}
	//runGlobalUpdate();
}
else {
	$labConfigId = $_SESSION['lab_config_id'];
	runUpdate($labConfigId);
	//runGlobalUpdate();
}

function runUpdate($lab_config_id) {

	global $con;

	/*BLIS 1.26 Update 
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);

	$query_alter = "ALTER TABLE report_disease ".
				   "DROP FOREIGN KEY report_disease_ibfk_1";
	mysql_query( $query_alter, $con ) or die(mysql_error());

	/*BLIS 1.27 Update 
	$query_alter = "ALTER TABLE stock_details ADD COLUMN used VARCHAR(1000) NULL DEFAULT '' ".
				   "AFTER quantity_used , ADD COLUMN user VARCHAR(1000) NULL DEFAULT ''  AFTER used ,".
				   " ADD COLUMN receiver VARCHAR(1000) NULL DEFAULT ''  AFTER user ,".
				   " ADD COLUMN remarks VARCHAR(1000) NULL DEFAULT ''  AFTER receiver ";

	mysql_query( $query_alter, $con ) or die(mysql_error());			   
				
	/*BLIS 1.28 Update 
	$query_alter = "ALTER TABLE custom_field_type MODIFY field_type VARCHAR(100) ";
	mysql_query( $query_alter, $con ) or die(mysql_error());	
	*/

	/*BLIS 1.29 Update 
	
	$saved_db = DbUtil::switchToGlobal();

	$query_alter = "ALTER TABLE lab_config add column ageLimit INTEGER ";
	mysql_query( $query_alter, $con ) or die(mysql_error());
				
	DbUtil::switchRestore($saved_db);
	*/

	/*BLIS 1.32 Update 

	$saved_db = DbUtil::switchToLabConfig($lab_config_id);

	$query_alter = "ALTER TABLE test_type ".
				   "ADD COLUMN prevalence_threshold int(3) default 70, ".
				   "ADD COLUMN target_tat int(3) default 24";
				   
	mysql_query( $query_alter, $con ) or die(mysql_error());
	
	*/
	
	/*BLIS 2.0 Update */
	$saved_db = DbUtil::switchToLabConfig($lab_config_id);
	
	$query_update = "ALTER TABLE user_rating ".
					"ADD COLUMN comments varchar(2048) default '' ";
	
	mysql_query( $query_update, $con) or die(mysql_error());
	
}

function runGlobalUpdate() {

	global $con;

	$saved_db = DbUtil::switchToGlobal();

	/* BLIS 1.35 Update
	$query_insert = "CREATE TABLE test_mapping (".
					"user_id int(11), ".
					"test_name varchar(256), ".
					"lab_id_test_id varchar(256), ".
					"test_id int(10) unsigned, ".
					"test_category_id int(10) unsigned, ".
					"primary key (user_id, test_id) )";
					
	mysql_query( $query_insert, $con ) or die(mysql_error());

	$query_insert = "CREATE TABLE specimen_mapping (".
					"user_id int(11), ".
					"specimen_name varchar(256), ".
					"lab_id_specimen_id varchar(256), ".
					"specimen_id int(10), ".
					"primary key (user_id, specimen_id) )";
					
	mysql_query( $query_insert, $con ) or die(mysql_error());
	
	$query_insert = "CREATE TABLE test_category_mapping (".
					"user_id int(11), ".
					"test_category_name varchar(256), ".
					"lab_id_test_category_id varchar(256), ".
					"test_category_id int(10), ".
					"primary key (user_id, test_category_id) )";
					
	mysql_query( $query_insert, $con ) or die(mysql_error());
	
	$query_insert = "CREATE TABLE measure_mapping (".
					"user_id int(11), ".
					"measure_name varchar(256), ".
					"lab_id_measure_id varchar(256), ".
					"measure_id int(10), ".
					"primary key (user_id, measure_id) )";
					
	mysql_query( $query_insert, $con ) or die(mysql_error());
	
	$query_insert = "CREATE TABLE global_measures (".
					"user_id int(11), ".
					"name varchar(128), ".
					"range varchar(1024), ".
					"test_id int(10), ".
					"measure_id int(10), ".
					"unit varchar(64), ".
					"primary key (user_id, test_id, measure_id) )";
	
	mysql_query( $query_insert, $con ) or die(mysql_error());
	
	$query_insert = "CREATE TABLE infection_report_settings (".
				    "id int(10) unsigned, ".
					"group_by_age int(10) unsigned, ".
					"group_by_gender int(10) unsigned, ".
					"age_groups varchar(512), ".
					"measure_groups varchar(512), ".
					"measure_id int(10), ".
					"user_id int(11), ".
					"test_id int(10), ".
					"primary key (user_id, id) )";
					
	mysql_query( $query_insert, $con ) or die(mysql_error());
	
	$query_insert = "CREATE TABLE reference_range_global (".
					"measure_id int(10), ".
					"age_min varchar(64), ".
					"age_max varchar(64), ".
					"sex varchar(64), ".
					"range_lower varchar(64), ".
					"range_upper varchar(64), ".
					"user_id int(11), ".
					"primary key (user_id, measure_id) )";
	
	mysql_query( $query_insert, $con ) or die(mysql_error());

	$query_insert = "INSERT INTO user (user_id, username, `password`, actualname, email, lang_id, `level`, created_by, lab_config_id, phone) ".
				    "VALUES (401, 'philip', '18865bfdeed2fd380316ecde609d94d7285af83f', 'Philip Boakye', 'boakyephilip@ymail.com', 'en', 4, 0, 0, '')";
					
	mysql_query( $query_insert, $con ) or die(mysql_error());
 
	$query_insert = "INSERT INTO user (user_id, username, `password`, actualname, email, lang_id, `level`, created_by, lab_config_id, phone) ".
				    "VALUES (402, 'mercy', '18865bfdeed2fd380316ecde609d94d7285af83f', 'Mercy Maeda', 'mirygibson@yahoo.com', 'en', 4, 0, 0, '')";
 
	mysql_query( $query_insert, $con ) or die(mysql_error());
	*/
	
	/* BLIS 1.91 Update */
	$query_alter = "ALTER table lab_config".
				   "ADD column country varchar(512)";
				   
	mysql_query( $query_alter, $con) or die(mysql_error());
	
	DbUtil::switchRestore($saved_db);
}

echo "true";
?>