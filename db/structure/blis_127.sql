-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: db    Database: blis_127
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
-- Table structure for table `bills`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `bills` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) unsigned NOT NULL,
  `paid_in_full` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bills_test_association`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `bills_test_association` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) unsigned NOT NULL,
  `test_id` int(11) unsigned NOT NULL,
  `discount_type` int(4) unsigned NOT NULL DEFAULT '1000',
  `discount_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blis_backups`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `blis_backups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lab_config_id` int(10) unsigned NOT NULL,
  `filename` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `blis_version` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location` (`location`),
  KEY `lab_config_id` (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blis_migrations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `blis_migrations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comment`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL DEFAULT '',
  `page` varchar(45) NOT NULL DEFAULT '',
  `comment` varchar(150) NOT NULL DEFAULT '',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `currency_conversion`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `currency_conversion` (
  `currencya` varchar(200) NOT NULL,
  `currencyb` varchar(200) NOT NULL,
  `exchangerate` float(5,2) DEFAULT NULL,
  `updatedts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag1` int(11) DEFAULT NULL,
  `flag2` int(11) DEFAULT NULL,
  `setting1` varchar(200) DEFAULT NULL,
  `setting2` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`currencya`,`currencyb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_field_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `custom_field_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_type` varchar(100) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `delay_measures`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `delay_measures` (
  `User_Id` varchar(50) NOT NULL DEFAULT '',
  `IP_Address` varchar(16) NOT NULL DEFAULT '',
  `Latency` int(11) NOT NULL DEFAULT '0',
  `Recorded_At` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Page_Name` varchar(45) DEFAULT NULL,
  `Request_URI` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `field_order`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `field_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_config_id` int(11) unsigned DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `field_order` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inv_reagent`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `inv_reagent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `unit` varchar(45) NOT NULL DEFAULT 'units',
  `remarks` varchar(245) DEFAULT NULL,
  `created_by` varchar(10) NOT NULL DEFAULT '0',
  `assocation` varchar(10) DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inv_supply`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `inv_supply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reagent_id` int(11) NOT NULL,
  `lot` varchar(100) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `quantity_ordered` int(11) NOT NULL DEFAULT '0',
  `quantity_supplied` int(11) NOT NULL DEFAULT '0',
  `cost_per_unit` decimal(10,0) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_of_order` date DEFAULT NULL,
  `date_of_supply` date DEFAULT NULL,
  `date_of_reception` date DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `reagent_id` (`reagent_id`),
  CONSTRAINT `reagent_id` FOREIGN KEY (`reagent_id`) REFERENCES `inv_reagent` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inv_usage`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `inv_usage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reagent_id` int(11) NOT NULL,
  `lot` varchar(100) NOT NULL,
  `quantity_used` int(11) NOT NULL DEFAULT '0',
  `date_of_use` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `reagent_id` (`reagent_id`),
  KEY `reagent_id2` (`reagent_id`),
  CONSTRAINT `reagent_id2` FOREIGN KEY (`reagent_id`) REFERENCES `inv_reagent` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lab_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `lab_config` (
  `lab_config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(45) NOT NULL DEFAULT '',
  `location` char(45) NOT NULL DEFAULT '',
  `admin_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `db_name` char(45) NOT NULL DEFAULT '',
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
  `ageLimit` int(11) DEFAULT NULL,
  PRIMARY KEY (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
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
-- Table structure for table `lab_config_settings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `lab_config_settings` (
  `id` int(11) NOT NULL,
  `flag1` int(11) DEFAULT NULL,
  `flag2` int(11) DEFAULT NULL,
  `flag3` int(11) DEFAULT NULL,
  `flag4` int(11) DEFAULT NULL,
  `setting1` varchar(200) DEFAULT NULL,
  `setting2` varchar(200) DEFAULT NULL,
  `setting3` varchar(200) DEFAULT NULL,
  `setting4` varchar(200) DEFAULT NULL,
  `misc` varchar(500) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
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
  `test_type_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `labtitle_custom_field`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `labtitle_custom_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(45) NOT NULL,
  `field_options` varchar(200) NOT NULL,
  `field_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `measure`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `measure` (
  `measure_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `unit_id` int(10) unsigned DEFAULT NULL,
  `range` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `unit` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`measure_id`),
  KEY `unit_id` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `misc`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `misc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `r_id` int(11) NOT NULL DEFAULT '0',
  `vr_id` varchar(45) NOT NULL DEFAULT '0',
  `i1` int(11) NOT NULL DEFAULT '0',
  `i2` int(11) NOT NULL DEFAULT '0',
  `i3` int(11) NOT NULL DEFAULT '0',
  `i4` int(11) NOT NULL DEFAULT '0',
  `i5` int(11) NOT NULL DEFAULT '0',
  `v1` varchar(500) NOT NULL DEFAULT '0',
  `v2` varchar(500) NOT NULL DEFAULT '0',
  `v3` varchar(500) NOT NULL DEFAULT '0',
  `v4` varchar(500) NOT NULL DEFAULT '0',
  `v5` varchar(500) NOT NULL DEFAULT '0',
  `dt1` datetime DEFAULT NULL,
  `dt2` datetime DEFAULT NULL,
  `dt3` datetime DEFAULT NULL,
  `d1` date DEFAULT NULL,
  `d2` date DEFAULT NULL,
  `d3` date DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `numeric_interpretation`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `numeric_interpretation` (
  `range_u` int(10) DEFAULT NULL,
  `range_l` int(10) DEFAULT NULL,
  `age_u` int(10) DEFAULT NULL,
  `age_l` int(10) DEFAULT NULL,
  `gender` varchar(40) DEFAULT NULL,
  `description` varchar(40) DEFAULT NULL,
  `measure_id` int(10) DEFAULT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patient`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `patient` (
  `patient_id` int(11) unsigned NOT NULL DEFAULT '0',
  `addl_id` varchar(40) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `sex` char(1) NOT NULL DEFAULT '',
  `age` decimal(10,0) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `partial_dob` varchar(45) DEFAULT NULL,
  `surr_id` varchar(45) DEFAULT NULL,
  `hash_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`patient_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patient_custom_data`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `patient_custom_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL DEFAULT '0',
  `patient_id` int(11) unsigned NOT NULL DEFAULT '0',
  `field_value` varchar(45) NOT NULL DEFAULT '',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patient_custom_field`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `patient_custom_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(45) NOT NULL DEFAULT '',
  `field_options` varchar(16000) DEFAULT NULL,
  `field_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patient_daily`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `patient_daily` (
  `datestring` varchar(45) NOT NULL,
  `count` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patient_report_fields_order`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `patient_report_fields_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `p_fields` varchar(500) NOT NULL DEFAULT '',
  `o_fields` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payments`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bill_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reference_range`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `reference_range` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `measure_id` int(10) unsigned NOT NULL,
  `age_min` varchar(45) DEFAULT NULL,
  `age_max` varchar(45) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `range_lower` varchar(45) NOT NULL,
  `range_upper` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `removal_record`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `removal_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `r_id` int(11) NOT NULL DEFAULT '0',
  `vr_id` varchar(45) NOT NULL DEFAULT '0',
  `type` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `remarks` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(20) DEFAULT 'test',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `report_config` (
  `report_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `header` varchar(500) NOT NULL DEFAULT '',
  `footer` varchar(500) NOT NULL DEFAULT '-End-',
  `margins` varchar(45) NOT NULL DEFAULT '2,0,10,0',
  `p_fields` varchar(45) NOT NULL DEFAULT '1,1,1,1,1,1,1',
  `s_fields` varchar(45) NOT NULL DEFAULT '1,1,1,1,1,1',
  `t_fields` varchar(45) NOT NULL DEFAULT '1,0,1,1,1,0,1,1',
  `p_custom_fields` varchar(45) NOT NULL DEFAULT '',
  `s_custom_fields` varchar(45) NOT NULL DEFAULT '',
  `test_type_id` varchar(45) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `landscape` int(10) unsigned NOT NULL DEFAULT '0',
  `row_items` int(1) unsigned NOT NULL DEFAULT '3',
  `show_border` int(1) unsigned NOT NULL DEFAULT '1',
  `show_result_border` int(1) unsigned NOT NULL DEFAULT '1',
  `result_border_horizontal` int(1) unsigned NOT NULL DEFAULT '0',
  `result_border_vertical` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_disease`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `report_disease` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_by_age` int(10) unsigned NOT NULL,
  `group_by_gender` int(10) unsigned NOT NULL,
  `age_groups` varchar(500) DEFAULT NULL,
  `measure_groups` varchar(500) DEFAULT NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `lab_config_id` int(10) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `Region` varchar(40) DEFAULT NULL,
  `District` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specimen`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `specimen` (
  `specimen_id` int(10) unsigned NOT NULL DEFAULT '0',
  `patient_id` int(11) unsigned NOT NULL DEFAULT '0',
  `specimen_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_code_id` int(11) unsigned DEFAULT NULL,
  `referred_to` int(11) unsigned DEFAULT NULL,
  `comments` text,
  `aux_id` varchar(45) DEFAULT NULL,
  `date_collected` date NOT NULL DEFAULT '0000-00-00',
  `date_recvd` date DEFAULT NULL,
  `session_num` varchar(45) DEFAULT NULL,
  `time_collected` varchar(45) DEFAULT NULL,
  `report_to` int(10) unsigned DEFAULT NULL,
  `doctor` varchar(45) DEFAULT NULL,
  `date_reported` datetime DEFAULT NULL,
  `referred_to_name` varchar(70) DEFAULT NULL,
  `daily_num` varchar(45) NOT NULL DEFAULT '',
  `referred_from_name` varchar(20) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`specimen_id`),
  KEY `patient_id` (`patient_id`),
  KEY `specimen_type_id` (`specimen_type_id`),
  KEY `user_id` (`user_id`),
  KEY `status_code_id` (`status_code_id`),
  KEY `referred_to` (`referred_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specimen_custom_data`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `specimen_custom_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL DEFAULT '0',
  `specimen_id` int(10) unsigned NOT NULL DEFAULT '0',
  `field_value` varchar(45) NOT NULL DEFAULT '',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`),
  KEY `specimen_id` (`specimen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specimen_custom_field`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `specimen_custom_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(45) NOT NULL DEFAULT '',
  `field_options` varchar(16000) DEFAULT NULL,
  `field_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specimen_session`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `specimen_session` (
  `session_num` varchar(45) NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specimen_test`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `specimen_test` (
  `test_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `specimen_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `test_type_id` (`test_type_id`),
  KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Relates tests to the specimens that are compatible with thos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specimen_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `specimen_type` (
  `specimen_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `description` varchar(100) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `disabled` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stock_content`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `stock_content` (
  `name` varchar(40) DEFAULT NULL,
  `current_quantity` int(11) DEFAULT NULL,
  `date_of_use` date NOT NULL,
  `receiver` varchar(40) DEFAULT NULL,
  `remarks` text,
  `lot_number` varchar(40) DEFAULT NULL,
  `new_balance` int(11) DEFAULT NULL,
  `user_name` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stock_details`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `stock_details` (
  `name` varchar(40) DEFAULT NULL,
  `lot_number` varchar(40) DEFAULT NULL,
  `expiry_date` varchar(40) DEFAULT NULL,
  `manufacturer` varchar(40) DEFAULT NULL,
  `quantity_ordered` int(11) DEFAULT NULL,
  `supplier` varchar(40) DEFAULT NULL,
  `date_of_reception` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `current_quantity` int(11) DEFAULT NULL,
  `date_of_supply` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `quantity_supplied` int(11) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `entry_id` int(11) DEFAULT NULL,
  `cost_per_unit` decimal(10,0) DEFAULT '0',
  `quantity_used` int(10) DEFAULT '0',
  `used` varchar(1000) DEFAULT '',
  `user` varchar(1000) DEFAULT '',
  `receiver` varchar(1000) DEFAULT '',
  `remarks` varchar(1000) DEFAULT '',
  UNIQUE KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `test` (
  `test_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `result` varchar(5000) DEFAULT NULL,
  `comments` varchar(200) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `verified_by` int(11) unsigned DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `specimen_id` int(11) unsigned DEFAULT NULL,
  `date_verified` datetime DEFAULT NULL,
  PRIMARY KEY (`test_id`),
  KEY `test_type_id` (`test_type_id`),
  KEY `user_id` (`user_id`),
  KEY `specimen_id` (`specimen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test_agg_report_config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `test_agg_report_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_type_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `landscape` tinyint(1) DEFAULT '1',
  `group_by_age` tinyint(1) DEFAULT '1',
  `age_unit` int(11) DEFAULT '1',
  `age_groups` varchar(255) DEFAULT NULL,
  `report_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test_category`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `test_category` (
  `test_category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `description` varchar(100) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `test_type` (
  `test_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `description` varchar(100) DEFAULT NULL,
  `test_category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_panel` int(10) unsigned DEFAULT NULL,
  `disabled` int(10) unsigned NOT NULL DEFAULT '0',
  `clinical_data` longtext,
  `hide_patient_name` int(1) DEFAULT NULL,
  `prevalence_threshold` int(3) DEFAULT '70',
  `target_tat` int(3) DEFAULT '24',
  `is_reporting_enabled` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`test_type_id`),
  KEY `test_category_id` (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test_type_costs`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `test_type_costs` (
  `earliest_date_valid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `test_type_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test_type_measure`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `test_type_measure` (
  `test_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `measure_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `test_type_id` (`test_type_id`),
  KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unit`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `unit` (
  `unit_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `unit` varchar(45) NOT NULL DEFAULT '',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL DEFAULT '',
  `password` varchar(45) NOT NULL DEFAULT '',
  `actualname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lab_config_id` int(10) unsigned DEFAULT NULL,
  `level` int(10) unsigned DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `lang_id` varchar(45) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`user_id`),
  KEY `user_id_index` (`lab_config_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Users are anybody that works in the lab.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_feedback`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(3) DEFAULT NULL,
  `comments` varchar(500) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_props`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user_props` (
  `User_Id` varchar(50) NOT NULL DEFAULT '',
  `AppCodeName` varchar(25) NOT NULL DEFAULT '',
  `AppName` varchar(25) NOT NULL DEFAULT '',
  `AppVersion` varchar(25) NOT NULL DEFAULT '',
  `CookieEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `Platform` varchar(20) NOT NULL DEFAULT '',
  `UserAgent` varchar(200) NOT NULL DEFAULT '',
  `SystemLanguage` varchar(15) NOT NULL DEFAULT '',
  `UserLanguage` varchar(15) NOT NULL DEFAULT '',
  `Language` varchar(15) NOT NULL DEFAULT '',
  `ScreenAvailHeight` int(11) NOT NULL DEFAULT '0',
  `ScreenAvailWidth` int(11) NOT NULL DEFAULT '0',
  `ScreenColorDepth` int(11) NOT NULL DEFAULT '0',
  `ScreenHeight` int(11) NOT NULL DEFAULT '0',
  `ScreenWidth` int(11) NOT NULL DEFAULT '0',
  `Recorded_At` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_rating`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `user_rating` (
  `user_id` int(10) unsigned NOT NULL,
  `rating` int(10) unsigned NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `worksheet_custom`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `worksheet_custom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `header` varchar(500) NOT NULL,
  `footer` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `p_fields` varchar(100) NOT NULL,
  `s_fields` varchar(100) NOT NULL,
  `t_fields` varchar(100) NOT NULL,
  `p_custom` varchar(100) NOT NULL,
  `s_custom` varchar(100) NOT NULL,
  `margins` varchar(50) NOT NULL,
  `id_fields` varchar(45) NOT NULL DEFAULT '0,0,0',
  `landscape` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `worksheet_custom_test`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `worksheet_custom_test` (
  `worksheet_id` int(10) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `width` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `worksheet_custom_userfield`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `worksheet_custom_userfield` (
  `worksheet_id` int(10) unsigned NOT NULL,
  `name` varchar(70) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '10',
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  KEY `Primary Key` (`field_id`)
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

-- Dump completed on 2024-08-20 14:25:18
