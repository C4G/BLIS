-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: db    Database: blis_revamp
-- ------------------------------------------------------
-- Server version	5.7.37

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

DROP TABLE IF EXISTS `dhims2_api_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dhims2_api_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `orgunit` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `dataset` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `dataelement` text COLLATE latin1_general_ci NOT NULL,
  `categorycombo` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `gender` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `period` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dhims2_api_config`
--

LOCK TABLES `dhims2_api_config` WRITE;
/*!40000 ALTER TABLE `dhims2_api_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `dhims2_api_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encryption_setting`
--

DROP TABLE IF EXISTS `encryption_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `encryption_setting` (
  `enc_enabled` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encryption_setting`
--

LOCK TABLES `encryption_setting` WRITE;
/*!40000 ALTER TABLE `encryption_setting` DISABLE KEYS */;
INSERT INTO `encryption_setting` VALUES (1),(1);
/*!40000 ALTER TABLE `encryption_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equip_config`
--

DROP TABLE IF EXISTS `equip_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equip_config` (
  `equip_id` int(11) DEFAULT NULL,
  `prop_id` int(11) DEFAULT NULL,
  `config_prop` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `prop_value` varchar(1000) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equip_config`
--

LOCK TABLES `equip_config` WRITE;
/*!40000 ALTER TABLE `equip_config` DISABLE KEYS */;
INSERT INTO `equip_config` VALUES (1,1,'PORT','5150'),(1,2,'MODE','client'),(1,3,'CLIENT_RECONNECT','chameleon'),(1,4,'EQUIPMENT_IP','Yes'),(3,5,'COMPORT','10'),(3,6,'BAUD_RATE','9600'),(3,7,'PARITY','None'),(3,8,'STOP_BITS','1'),(3,9,'APPEND_NEWLINE','No'),(3,10,'DATA_BITS','8'),(3,11,'APPEND_CARRIAGE_RETURN','No'),(2,12,'DATASOURCE','create ODBC datasource to the equipment db and put name here'),(2,12,'DAYS','0'),(4,5,'COMPORT','10'),(4,6,'BAUD_RATE','9600'),(4,7,'PARITY','None'),(4,8,'STOP_BITS','1'),(4,9,'APPEND_NEWLINE','No'),(4,10,'DATA_BITS','8'),(4,11,'APPEND_CARRIAGE_RETURN','No'),(5,1,'PORT','5150'),(5,2,'MODE','server'),(5,3,'CLIENT_RECONNECT','no'),(5,4,'EQUIPMENT_IP','set the Analyzer PC IP address here'),(6,14,'BASE_DIRECTORY',''),(6,15,'USE_SUB_DIRECTORIES',''),(6,16,'SUB_DIRECTORY_FORMAT',''),(6,17,'FILE_NAME_FORMAT',''),(6,18,'FILE_EXTENSION',''),(6,19,'FILE_SEPERATOR',''),(7,5,'COMPORT','10'),(7,6,'BAUD_RATE','9600'),(7,7,'PARITY','None'),(7,8,'STOP_BITS','1'),(7,9,'APPEND_NEWLINE','No'),(7,10,'DATA_BITS','8'),(7,11,'APPEND_CARRIAGE_RETURN','No'),(8,5,'COMPORT','10'),(8,6,'BAUD_RATE','9600'),(8,7,'PARITY','None'),(8,8,'STOP_BITS','1'),(8,9,'APPEND_NEWLINE','No'),(8,10,'DATA_BITS','8'),(8,11,'APPEND_CARRIAGE_RETURN','No'),(9,1,'PORT','5150'),(9,2,'MODE','server'),(9,3,'CLIENT_RECONNECT','no'),(9,4,'EQUIPMENT_IP','set the Analyzer PC IP address here'),(10,5,'COMPORT','10'),(10,6,'BAUD_RATE','9600'),(10,7,'PARITY','None'),(10,8,'STOP_BITS','1'),(10,9,'APPEND_NEWLINE','No'),(10,10,'DATA_BITS','8'),(10,11,'APPEND_CARRIAGE_RETURN','No'),(11,1,'PORT','5150'),(11,2,'MODE','server'),(11,3,'CLIENT_RECONNECT','no'),(11,4,'EQUIPMENT_IP','set the Analyzer PC IP address here'),(12,1,'PORT','5150'),(12,2,'MODE','server'),(12,3,'CLIENT_RECONNECT','no'),(12,4,'EQUIPMENT_IP','set the Analyzer PC IP address here');
/*!40000 ALTER TABLE `equip_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `global_measures`
--

DROP TABLE IF EXISTS `global_measures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `global_measures` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) COLLATE latin1_general_ci DEFAULT NULL,
  `range` varchar(1024) COLLATE latin1_general_ci DEFAULT NULL,
  `test_id` int(10) NOT NULL DEFAULT '0',
  `measure_id` int(10) NOT NULL DEFAULT '0',
  `unit` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`,`test_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `global_measures`
--

LOCK TABLES `global_measures` WRITE;
/*!40000 ALTER TABLE `global_measures` DISABLE KEYS */;
/*!40000 ALTER TABLE `global_measures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ii_quickcodes`
--

DROP TABLE IF EXISTS `ii_quickcodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ii_quickcodes` (
  `prop_id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_source` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `config_prop` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`prop_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ii_quickcodes`
--

LOCK TABLES `ii_quickcodes` WRITE;
/*!40000 ALTER TABLE `ii_quickcodes` DISABLE KEYS */;
INSERT INTO `ii_quickcodes` VALUES (1,'TCP/IP','PORT'),(2,'TCP/IP','MODE'),(3,'TCP/IP','CLIENT_RECONNECT'),(4,'TCP/IP','EQUIPMENT_IP'),(5,'RS232','COMPORT'),(6,'RS232','BAUD_RATE'),(7,'RS232','PARITY'),(8,'RS232','STOP_BITS'),(9,'RS232','APPEND_NEWLINE'),(10,'RS232','DATA_BITS'),(11,'RS232','APPEND_CARRIAGE_RETURN'),(12,'MSACCESS','DATASOURCE'),(13,'MSACCESS','DAYS'),(14,'TEXT','BASE_DIRECTORY'),(15,'TEXT','USE_SUB_DIRECTORIES'),(16,'TEXT','SUB_DIRECTORY_FORMAT'),(17,'TEXT','FILE_NAME_FORMAT'),(18,'TEXT','FILE_EXTENSION'),(19,'TEXT','FILE_SEPERATOR');
/*!40000 ALTER TABLE `ii_quickcodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `import_log`
--

DROP TABLE IF EXISTS `import_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `import_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_config_id` int(10) NOT NULL,
  `successful` int(1) DEFAULT NULL,
  `flag` int(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `country` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `lab_name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `db_name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `remarks` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `import_log`
--

LOCK TABLES `import_log` WRITE;
/*!40000 ALTER TABLE `import_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `import_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `infection_report_settings`
--

DROP TABLE IF EXISTS `infection_report_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `infection_report_settings` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_by_age` int(10) unsigned DEFAULT NULL,
  `group_by_gender` int(10) unsigned DEFAULT NULL,
  `age_groups` varchar(512) COLLATE latin1_general_ci DEFAULT NULL,
  `measure_groups` varchar(512) COLLATE latin1_general_ci DEFAULT NULL,
  `measure_id` int(10) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `test_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `infection_report_settings`
--

LOCK TABLES `infection_report_settings` WRITE;
/*!40000 ALTER TABLE `infection_report_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `infection_report_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interfaced_equipment`
--

DROP TABLE IF EXISTS `interfaced_equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interfaced_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_name` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `comm_type` enum('Bi-directional','Uni-directional') COLLATE latin1_general_ci NOT NULL,
  `equipment_version` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `lab_department` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `feed_source` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `config_file` varchar(2000) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interfaced_equipment`
--

LOCK TABLES `interfaced_equipment` WRITE;
/*!40000 ALTER TABLE `interfaced_equipment` DISABLE KEYS */;
INSERT INTO `interfaced_equipment` VALUES (1,'Mindray BS-200E','Bi-directional','01.00.07','Chemistry','TCP/IP','\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000pluschameleon.xml'),(2,'ABX Pentra 60 C+','Bi-directional','','Haematology','MSACCESS','\\BLISInterfaceClient\\configs\\pentra\\pentra60cplus.xml'),(3,'ABX MACROS 60','Uni-directional','','Haematology','RS232','\\BLISInterfaceClient\\configs\\micros60\\abxmicros60.xml'),(4,'BT 3000 Plus','Uni-directional','','Chemistry','RS232','\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000plus.xml'),(5,'Sysmex SX 500i','Uni-directional','','Haematology','TCP/IP','\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXS500i.xml'),(6,'BD FACSCalibur','Uni-directional','','Immunology','TEXT',' \\BLISInterfaceClient\\configs\\BDFACSCalibur\\bdfacscalibur.xml'),(7,'Mindray BC 3600','Uni-directional','','Haematology','RS232',' \\BLISInterfaceClient\\configs\\mindray\\mindraybc3600.xml'),(8,'Selectra Junior','Uni-directional','','Chemistry','RS232',' \\BLISInterfaceClient\\configs\\selectrajunior\\selectrajunior.xml'),(9,'GeneXpert','Bi-directional','','Microbiology','TCP/IP',' \\BLISInterfaceClient\\configs\\geneXpert\\genexpert.xml'),(10,'ABX Pentra 80','Bi-directional','','Haematology','RS232',' \\BLISInterfaceClient\\configs\\pentra80\\abxpentra80.xml'),(11,'Sysmex XT 2000i','Uni-directional','','Haematology','TCP/IP','\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXT2000i.xml'),(12,'Vitalex Flexor','Uni-directional','','Chemistry','TCP/IP',' \\BLISInterfaceClient\\configs\\flexorE\\flexore.xml');
/*!40000 ALTER TABLE `interfaced_equipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keymgmt`
--

DROP TABLE IF EXISTS `keymgmt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keymgmt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_name` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `pub_key` varchar(8000) COLLATE latin1_general_ci DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `added_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keymgmt`
--

LOCK TABLES `keymgmt` WRITE;
/*!40000 ALTER TABLE `keymgmt` DISABLE KEYS */;
INSERT INTO `keymgmt` VALUES (1,'DO Cloud Key','-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDMMFWkJRz9BmZRF2ovmpXuOdVf\nkJ8Y6AVWI2twV4IDQFgZ67pL84FyLUWa0RFXtVueRbNUjeHWgR0uz1XRWL35ll+L\n11TDJv7jqO5MDu5f5DcpV8yW49ghiyCVgRLfz2ueVaIoo6Rq/lHiQWKCdWJU8Wq6\nwna29cmFCWoLSARKtwIDAQAB\n-----END PUBLIC KEY-----\n','2022-04-10 13:56:09',506);
/*!40000 ALTER TABLE `keymgmt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config`
--

DROP TABLE IF EXISTS `lab_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_config` (
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
  `country` varchar(512) DEFAULT NULL,
  `site_choice_enabled` tinyint(1) DEFAULT '0',
  `blis_cloud_hostname` char(45) DEFAULT '',
  PRIMARY KEY (`lab_config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1006 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config`
--

LOCK TABLES `lab_config` WRITE;
/*!40000 ALTER TABLE `lab_config` DISABLE KEYS */;
INSERT INTO `lab_config` VALUES (127,'Testlab1','GT',53,'blis_127',1,0,0,1,2,1,2,1,1,0,0,2,0,'d-m-Y',1,1,'USA',0,'');
/*!40000 ALTER TABLE `lab_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_access`
--

DROP TABLE IF EXISTS `lab_config_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lab_config_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`lab_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_access`
--

LOCK TABLES `lab_config_access` WRITE;
/*!40000 ALTER TABLE `lab_config_access` DISABLE KEYS */;
INSERT INTO `lab_config_access` VALUES (123,127);
/*!40000 ALTER TABLE `lab_config_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_specimen_type`
--

DROP TABLE IF EXISTS `lab_config_specimen_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL DEFAULT '0',
  `specimen_type_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_specimen_type`
--

LOCK TABLES `lab_config_specimen_type` WRITE;
/*!40000 ALTER TABLE `lab_config_specimen_type` DISABLE KEYS */;
INSERT INTO `lab_config_specimen_type` VALUES (127,6),(127,7),(127,11),(127,12);
/*!40000 ALTER TABLE `lab_config_specimen_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_test_type`
--

DROP TABLE IF EXISTS `lab_config_test_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL DEFAULT '0',
  `test_type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `print_unverified` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_test_type`
--

LOCK TABLES `lab_config_test_type` WRITE;
/*!40000 ALTER TABLE `lab_config_test_type` DISABLE KEYS */;
INSERT INTO `lab_config_test_type` VALUES (127,7,1),(127,8,1),(127,56,1),(127,71,1),(127,19,1),(127,32,1),(127,18,1),(127,40,1);
/*!40000 ALTER TABLE `lab_config_test_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map_coordinates`
--

DROP TABLE IF EXISTS `map_coordinates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `map_coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_id` int(11) NOT NULL,
  `coordinates` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `flag` int(11) DEFAULT '1',
  `country` varchar(110) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map_coordinates`
--

LOCK TABLES `map_coordinates` WRITE;
/*!40000 ALTER TABLE `map_coordinates` DISABLE KEYS */;
/*!40000 ALTER TABLE `map_coordinates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measure_mapping`
--

DROP TABLE IF EXISTS `measure_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `measure_mapping` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `measure_name` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `lab_id_measure_id` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `measure_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure_mapping`
--

LOCK TABLES `measure_mapping` WRITE;
/*!40000 ALTER TABLE `measure_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `measure_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misc`
--

DROP TABLE IF EXISTS `misc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `misc` (
  `username` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `action` varchar(40) COLLATE latin1_general_ci DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `misc`
--

LOCK TABLES `misc` WRITE;
/*!40000 ALTER TABLE `misc` DISABLE KEYS */;
INSERT INTO `misc` VALUES ('initial','password reset completed','2013-09-19 05:16:47'),('initial','password reset completed','2013-09-19 05:16:54'),('initial','password reset completed','2014-04-07 17:23:51');
/*!40000 ALTER TABLE `misc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference_range_global`
--

DROP TABLE IF EXISTS `reference_range_global`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reference_range_global` (
  `measure_id` int(10) NOT NULL DEFAULT '0',
  `age_min` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `age_max` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `sex` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `range_lower` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `range_upper` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reference_range_global`
--

LOCK TABLES `reference_range_global` WRITE;
/*!40000 ALTER TABLE `reference_range_global` DISABLE KEYS */;
/*!40000 ALTER TABLE `reference_range_global` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_config`
--

DROP TABLE IF EXISTS `report_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_config` (
  `report_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `header` varchar(500) NOT NULL DEFAULT '',
  `footer` varchar(500) NOT NULL DEFAULT '',
  `margins` varchar(45) NOT NULL DEFAULT '',
  `p_fields` varchar(45) NOT NULL DEFAULT '',
  `s_fields` varchar(45) NOT NULL DEFAULT '',
  `t_fields` varchar(45) NOT NULL DEFAULT '',
  `p_custom_fields` varchar(45) NOT NULL DEFAULT '',
  `s_custom_fields` varchar(45) NOT NULL DEFAULT '',
  `test_type_id` varchar(45) NOT NULL DEFAULT '',
  `title` varchar(500) NOT NULL DEFAULT '',
  `landscape` int(10) unsigned NOT NULL DEFAULT '0',
  `age_unit` int(11) DEFAULT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_config`
--

LOCK TABLES `report_config` WRITE;
/*!40000 ALTER TABLE `report_config` DISABLE KEYS */;
INSERT INTO `report_config` VALUES (1,'Grouped Test Count Report Configuration','0:4,5:9,10:14,15:19,20:24,25:29,29:34,35:39,39:44,45:49,49:54,55:59,59:64,65:+','0','1','1','0','1','0','9999009','0',9999009,1),(2,'Grouped Specimen Count Report Configuration','0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+','0','1','1','0','1','0','9999019','0',9999019,1),(3,'Grouped Test Count Report Configuration','0:4,5:9,10:14,15:19,20:24,25:29,29:34,35:39,39:44,45:49,49:54,55:59,59:64,65:+','0','1','1','0','1','0','9999009','0',9999009,1),(4,'Grouped Specimen Count Report Configuration','0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+','0','1','1','0','1','0','9999019','0',9999019,1);
/*!40000 ALTER TABLE `report_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_mapping`
--

DROP TABLE IF EXISTS `specimen_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specimen_mapping` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `specimen_name` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `lab_id_specimen_id` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `specimen_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_mapping`
--

LOCK TABLES `specimen_mapping` WRITE;
/*!40000 ALTER TABLE `specimen_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `specimen_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_category_mapping`
--

DROP TABLE IF EXISTS `test_category_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_category_mapping` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `test_category_name` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `lab_id_test_category_id` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `test_category_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_category_mapping`
--

LOCK TABLES `test_category_mapping` WRITE;
/*!40000 ALTER TABLE `test_category_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_category_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_mapping`
--

DROP TABLE IF EXISTS `test_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_mapping` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `test_name` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `lab_id_test_id` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `test_id` int(10) unsigned NOT NULL DEFAULT '0',
  `test_category_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`test_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_mapping`
--

LOCK TABLES `test_mapping` WRITE;
/*!40000 ALTER TABLE `test_mapping` DISABLE KEYS */;
INSERT INTO `test_mapping` VALUES (27,'Cameroon','',1,NULL);
/*!40000 ALTER TABLE `test_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=507 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (26,'superadmin','18865bfdeed2fd380316ecde609d94d7285af83f','Super Admin','superadmin@example.com',NULL,'2010-04-30 07:22:39',NULL,3,NULL,'en','2,3,4,6,7'),(53,'testlab1_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Testlab1 admin','',26,'2010-01-14 17:05:44',0,2,'','default','2,3,4,6,7'),(56,'testlab1_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Testlab1 Tech1','',26,'2010-04-30 03:53:06',127,0,'','en','2,3,4,6,7'),(57,'testlab1_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Testlab1 Tech2','',26,'2010-01-14 17:10:48',127,1,'','default','2,3,4,6,7'),(123,'cameroon_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','Cameroon Country Dir.','',0,'2010-01-18 15:15:39',0,4,'677073324','fr','2,3,4,6,7'),(506,'MitchellR','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,123,'2022-04-10 00:00:00',127,2,NULL,'default','2,3,4,6,7');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_config`
--

DROP TABLE IF EXISTS `user_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_config` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  `parameter` varchar(256) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `value` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `created_by` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `created_on` date DEFAULT NULL,
  `modified_by` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `modified_on` date DEFAULT NULL,
  PRIMARY KEY (`user_id`,`parameter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_config`
--

LOCK TABLES `user_config` WRITE;
/*!40000 ALTER TABLE `user_config` DISABLE KEYS */;
INSERT INTO `user_config` VALUES (26,3,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(53,2,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(56,0,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(57,1,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(123,4,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(506,2,'rwoptions','2,3,4,6,7','123','2022-04-10','123','2022-04-10');
/*!40000 ALTER TABLE `user_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_log` (
  `patient_id` int(11) DEFAULT NULL,
  `log_type` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_log`
--

LOCK TABLES `user_log` WRITE;
/*!40000 ALTER TABLE `user_log` DISABLE KEYS */;
INSERT INTO `user_log` VALUES (76,'PRINT','2021-10-26 15:06:07',53);
/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_type` (
  `level` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `defaultdisplay` tinyint(1) DEFAULT '0',
  `created_by` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`level`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_type`
--

LOCK TABLES `user_type` WRITE;
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` VALUES (1,'LIS_TECH_RO',1,'Aishwarya','2015-08-26 19:29:28'),(2,'LIS_ADMIN',0,'Aishwarya','2015-08-26 19:29:28'),(3,'LIS_SUPERADMIN',0,'Aishwarya','2015-08-26 19:29:28'),(4,'LIS_COUNTRYDIR',0,'Aishwarya','2015-08-26 19:29:28'),(5,'LIS_CLERK',1,'Aishwarya','2015-08-26 19:29:28'),(6,'LIS_001',0,'Aishwarya','2015-08-26 19:29:28'),(7,'LIS_010',0,'Aishwarya','2015-08-26 19:29:28'),(8,'LIS_011',0,'Aishwarya','2015-08-26 19:29:28'),(9,'LIS_100',0,'Aishwarya','2015-08-26 19:29:28'),(10,'LIS_101',0,'Aishwarya','2015-08-26 19:29:28'),(11,'LIS_110',0,'Aishwarya','2015-08-26 19:29:28'),(12,'LIS_111',0,'Aishwarya','2015-08-26 19:29:28'),(13,'LIS_TECH_SHOWPNAME',1,'Aishwarya','2015-08-26 19:29:28'),(14,'LIS_TECH_RW',1,'Aishwarya','2015-08-26 19:29:28'),(15,'LIS_VERIFIER',1,'Aishwarya','2015-08-26 19:29:28'),(16,'READONLYMODE',1,'Aishwarya','2015-08-26 19:29:28'),(17,'LIS_PHYSICIAN',1,'Aishwarya','2015-08-26 19:29:28');
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_type_config`
--

DROP TABLE IF EXISTS `user_type_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_type_config` (
  `level` int(11) NOT NULL DEFAULT '0',
  `parameter` varchar(256) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `value` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `created_by` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `created_on` date DEFAULT NULL,
  `modified_by` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`level`,`parameter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_type_config`
--

LOCK TABLES `user_type_config` WRITE;
/*!40000 ALTER TABLE `user_type_config` DISABLE KEYS */;
INSERT INTO `user_type_config` VALUES (1,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(2,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(3,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(4,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(5,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(6,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(7,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(8,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(9,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(10,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(11,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(12,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(13,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(14,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(15,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(16,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28'),(17,'rwoptions','2,3,4,6,7','Aishwarya',NULL,'Aishwarya','2015-08-26 19:29:28');
/*!40000 ALTER TABLE `user_type_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `version_data`
--

DROP TABLE IF EXISTS `version_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `version_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `remarks` varchar(250) COLLATE latin1_general_ci DEFAULT NULL,
  `i_ts` timestamp NULL DEFAULT NULL,
  `u_ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `version_data`
--

LOCK TABLES `version_data` WRITE;
/*!40000 ALTER TABLE `version_data` DISABLE KEYS */;
INSERT INTO `version_data` VALUES (1,'2.4',1,116,NULL,'2013-03-09 06:01:13','2013-03-09 06:01:13'),(2,'2.6',1,53,NULL,'2013-09-19 05:16:47','2013-09-19 05:16:47'),(3,'2.6',1,53,NULL,'2013-09-19 05:16:54','2013-09-19 05:16:54'),(4,'2.7',1,53,NULL,'2014-04-07 17:23:52','2014-04-07 17:23:52'),(5,'2.91',1,53,NULL,'2015-08-26 19:29:29','2015-08-26 19:29:29'),(6,'3.0',1,53,NULL,'2015-09-26 19:29:29','2015-09-26 19:29:29'),(7,'3.3',1,53,NULL,'2017-04-27 03:03:03','2017-04-27 03:03:03'),(8,'3.4',1,53,NULL,'2018-11-08 05:09:41','2018-11-08 05:09:41'),(9,'3.5',1,53,NULL,'2019-04-17 23:19:27','2019-04-17 23:19:27'),(10,'3.52',1,53,NULL,'2019-09-30 17:59:43','2019-09-30 17:59:43'),(11,'3.6',1,123,NULL,'2021-08-09 05:21:56','2021-08-09 05:21:56'),(12,'3.61',1,53,NULL,'2021-10-22 18:57:13','2021-10-22 18:57:13'),(13,'3.7',1,53,NULL,'2021-12-06 20:03:29','2021-12-06 20:03:29'),(14,'3.71',1,53,NULL,'2022-01-14 16:00:25','2022-01-14 16:00:25'),(15,'3.72',1,123,NULL,'2022-02-09 04:07:23','2022-02-09 04:07:23'),(16,'3.8',1,506,NULL,'2022-04-10 13:55:23','2022-04-10 13:55:23');
/*!40000 ALTER TABLE `version_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-17 20:00:43
