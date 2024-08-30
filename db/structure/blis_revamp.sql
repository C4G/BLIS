-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: db    Database: blis_revamp
-- ------------------------------------------------------
-- Server version	5.7.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dhims2_api_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `dhims2_api_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `orgunit` varchar(200) NOT NULL,
  `dataset` varchar(200) NOT NULL,
  `dataelement` text NOT NULL,
  `categorycombo` varchar(100) DEFAULT NULL,
  `gender` varchar(5) DEFAULT NULL,
  `period` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `encryption_setting`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `encryption_setting` (
  `enc_enabled` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `equip_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `equip_config` (
  `equip_id` int(11) DEFAULT NULL,
  `prop_id` int(11) DEFAULT NULL,
  `config_prop` varchar(100) DEFAULT NULL,
  `prop_value` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `global_measures`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `global_measures` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) DEFAULT NULL,
  `range` varchar(1024) DEFAULT NULL,
  `test_id` int(10) NOT NULL DEFAULT '0',
  `measure_id` int(10) NOT NULL DEFAULT '0',
  `unit` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`test_id`,`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ii_quickcodes`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `ii_quickcodes` (
  `prop_id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_source` varchar(100) DEFAULT NULL,
  `config_prop` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`prop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `import_log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `import_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_config_id` int(10) NOT NULL,
  `successful` int(1) DEFAULT NULL,
  `flag` int(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `lab_name` varchar(100) DEFAULT NULL,
  `db_name` varchar(100) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `infection_report_settings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `infection_report_settings` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_by_age` int(10) unsigned DEFAULT NULL,
  `group_by_gender` int(10) unsigned DEFAULT NULL,
  `age_groups` varchar(512) DEFAULT NULL,
  `measure_groups` varchar(512) DEFAULT NULL,
  `measure_id` int(10) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `test_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `interfaced_equipment`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `interfaced_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_name` varchar(150) NOT NULL,
  `comm_type` enum('Bi-directional','Uni-directional') NOT NULL,
  `equipment_version` varchar(50) DEFAULT NULL,
  `lab_department` varchar(50) NOT NULL,
  `feed_source` varchar(50) DEFAULT NULL,
  `config_file` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `keymgmt`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `keymgmt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_name` varchar(200) DEFAULT NULL,
  `pub_key` varchar(8000) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lab_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `lab_config` (
  `lab_config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(45) NOT NULL,
  `location` char(45) NOT NULL,
  `admin_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `db_name` char(45) NOT NULL,
  `id_mode` int(10) unsigned NOT NULL DEFAULT '2',
  `p_addl` int(10) unsigned NOT NULL DEFAULT '0',
  `s_addl` int(10) unsigned NOT NULL DEFAULT '0',
  `daily_num` int(10) unsigned NOT NULL DEFAULT '1',
  `pid` int(10) unsigned NOT NULL DEFAULT '2',
  `pname` int(10) unsigned NOT NULL DEFAULT '1',
  `sex` int(10) unsigned NOT NULL DEFAULT '2',
  `age` int(10) unsigned NOT NULL DEFAULT '1',
  `dob` int(10) unsigned NOT NULL DEFAULT '1',
  `sid` int(10) unsigned NOT NULL DEFAULT '2',
  `refout` int(10) unsigned NOT NULL DEFAULT '1',
  `rdate` int(10) unsigned NOT NULL DEFAULT '2',
  `comm` int(10) unsigned NOT NULL DEFAULT '1',
  `dformat` varchar(45) NOT NULL DEFAULT 'd-m-Y',
  `dnum_reset` int(10) unsigned NOT NULL DEFAULT '1',
  `doctor` int(10) unsigned NOT NULL DEFAULT '1',
  `country` varchar(512) DEFAULT NULL,
  `site_choice_enabled` tinyint(1) DEFAULT '0',
  `blis_cloud_hostname` char(45) DEFAULT '',
  PRIMARY KEY (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lab_config_access`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lab_config_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lab_config_specimen_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL DEFAULT '0',
  `specimen_type_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lab_config_test_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL DEFAULT '0',
  `test_type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `print_unverified` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `map_coordinates`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `map_coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_id` int(11) NOT NULL,
  `coordinates` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `flag` int(11) DEFAULT '1',
  `country` varchar(110) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `measure_mapping`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `measure_mapping` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `measure_name` varchar(256) DEFAULT NULL,
  `lab_id_measure_id` varchar(256) DEFAULT NULL,
  `measure_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `misc`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `misc` (
  `username` varchar(20) DEFAULT NULL,
  `action` varchar(40) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reference_range_global`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `reference_range_global` (
  `measure_id` int(10) NOT NULL DEFAULT '0',
  `age_min` varchar(64) DEFAULT NULL,
  `age_max` varchar(64) DEFAULT NULL,
  `sex` varchar(64) DEFAULT NULL,
  `range_lower` varchar(64) DEFAULT NULL,
  `range_upper` varchar(64) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `report_config` (
  `report_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `header` varchar(500) NOT NULL,
  `footer` varchar(500) NOT NULL,
  `margins` varchar(45) NOT NULL,
  `p_fields` varchar(45) NOT NULL,
  `s_fields` varchar(45) NOT NULL,
  `t_fields` varchar(45) NOT NULL,
  `p_custom_fields` varchar(45) NOT NULL,
  `s_custom_fields` varchar(45) NOT NULL,
  `test_type_id` varchar(45) NOT NULL,
  `title` varchar(500) NOT NULL,
  `landscape` int(10) unsigned NOT NULL DEFAULT '0',
  `age_unit` int(11) DEFAULT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specimen_mapping`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `specimen_mapping` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `specimen_name` varchar(256) DEFAULT NULL,
  `lab_id_specimen_id` varchar(256) DEFAULT NULL,
  `specimen_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`specimen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test_category_mapping`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `test_category_mapping` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `test_category_name` varchar(256) DEFAULT NULL,
  `lab_id_test_category_id` varchar(256) DEFAULT NULL,
  `test_category_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test_mapping`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `test_mapping` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `test_name` varchar(256) DEFAULT NULL,
  `lab_id_test_id` varchar(256) DEFAULT NULL,
  `test_id` int(10) unsigned NOT NULL DEFAULT '0',
  `test_category_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `actualname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lab_config_id` int(11) unsigned DEFAULT NULL,
  `level` int(11) unsigned DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `lang_id` varchar(45) NOT NULL,
  `rwoptions` varchar(20) NOT NULL DEFAULT '2,3,4,6,7',
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user_config` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  `parameter` varchar(256) NOT NULL,
  `value` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_on` date DEFAULT NULL,
  `modified_by` varchar(256) DEFAULT NULL,
  `modified_on` date DEFAULT NULL,
  PRIMARY KEY (`user_id`,`parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user_log` (
  `patient_id` int(11) DEFAULT NULL,
  `log_type` varchar(100) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user_type` (
  `level` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `defaultdisplay` tinyint(1) DEFAULT '0',
  `created_by` varchar(256) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_type_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user_type_config` (
  `level` int(11) NOT NULL DEFAULT '0',
  `parameter` varchar(256) NOT NULL,
  `value` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_on` date DEFAULT NULL,
  `modified_by` varchar(256) DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`level`,`parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `version_data`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `version_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(45) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `i_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `u_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-20 14:25:17
