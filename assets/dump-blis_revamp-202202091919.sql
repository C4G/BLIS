-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: blis_revamp
-- ------------------------------------------------------
-- Server version	5.0.41-community-nt

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `dhims2_api_config`
--

DROP TABLE IF EXISTS `dhims2_api_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dhims2_api_config` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) collate latin1_general_ci NOT NULL,
  `password` varchar(50) collate latin1_general_ci NOT NULL,
  `orgunit` varchar(200) collate latin1_general_ci NOT NULL,
  `dataset` varchar(200) collate latin1_general_ci NOT NULL,
  `dataelement` text collate latin1_general_ci NOT NULL,
  `categorycombo` varchar(100) collate latin1_general_ci default NULL,
  `gender` varchar(5) collate latin1_general_ci default NULL,
  `period` varchar(10) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encryption_setting` (
  `enc_enabled` int(11) default NULL
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equip_config` (
  `equip_id` int(11) default NULL,
  `prop_id` int(11) default NULL,
  `config_prop` varchar(100) collate latin1_general_ci default NULL,
  `prop_value` varchar(1000) collate latin1_general_ci default NULL
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `global_measures` (
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(128) collate latin1_general_ci default NULL,
  `range` varchar(1024) collate latin1_general_ci default NULL,
  `test_id` int(10) NOT NULL default '0',
  `measure_id` int(10) NOT NULL default '0',
  `unit` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`,`test_id`,`measure_id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ii_quickcodes` (
  `prop_id` int(11) NOT NULL auto_increment,
  `feed_source` varchar(100) collate latin1_general_ci default NULL,
  `config_prop` varchar(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`prop_id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `import_log` (
  `id` int(11) NOT NULL auto_increment,
  `lab_config_id` int(10) NOT NULL,
  `successful` int(1) default NULL,
  `flag` int(1) default NULL,
  `user_id` int(11) default NULL,
  `country` varchar(100) collate latin1_general_ci default NULL,
  `lab_name` varchar(100) collate latin1_general_ci default NULL,
  `db_name` varchar(100) collate latin1_general_ci default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `infection_report_settings` (
  `id` int(10) unsigned NOT NULL default '0',
  `group_by_age` int(10) unsigned default NULL,
  `group_by_gender` int(10) unsigned default NULL,
  `age_groups` varchar(512) collate latin1_general_ci default NULL,
  `measure_groups` varchar(512) collate latin1_general_ci default NULL,
  `measure_id` int(10) default NULL,
  `user_id` int(11) NOT NULL default '0',
  `test_id` int(10) default NULL,
  PRIMARY KEY  (`user_id`,`id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interfaced_equipment` (
  `id` int(11) NOT NULL auto_increment,
  `equipment_name` varchar(150) collate latin1_general_ci NOT NULL,
  `comm_type` enum('Bi-directional','Uni-directional') collate latin1_general_ci NOT NULL,
  `equipment_version` varchar(50) collate latin1_general_ci default NULL,
  `lab_department` varchar(50) collate latin1_general_ci NOT NULL,
  `feed_source` varchar(50) collate latin1_general_ci default NULL,
  `config_file` varchar(2000) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keymgmt` (
  `id` int(11) NOT NULL auto_increment,
  `lab_name` varchar(200) collate latin1_general_ci default NULL,
  `pub_key` varchar(8000) collate latin1_general_ci default NULL,
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `added_by` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keymgmt`
--

LOCK TABLES `keymgmt` WRITE;
/*!40000 ALTER TABLE `keymgmt` DISABLE KEYS */;
/*!40000 ALTER TABLE `keymgmt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config`
--

DROP TABLE IF EXISTS `lab_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_config` (
  `lab_config_id` int(10) unsigned NOT NULL auto_increment,
  `name` char(45) NOT NULL default '',
  `location` char(45) NOT NULL default '',
  `admin_user_id` int(10) unsigned NOT NULL default '0',
  `db_name` char(45) NOT NULL default '',
  `id_mode` int(10) unsigned NOT NULL default '2',
  `p_addl` int(10) unsigned NOT NULL default '0',
  `s_addl` int(10) unsigned NOT NULL default '0',
  `daily_num` int(10) unsigned NOT NULL default '1',
  `pid` int(10) unsigned NOT NULL default '2',
  `pname` int(10) unsigned NOT NULL default '1',
  `sex` int(10) unsigned NOT NULL default '2',
  `age` int(10) unsigned NOT NULL default '1',
  `dob` int(10) unsigned NOT NULL default '1',
  `sid` int(10) unsigned NOT NULL default '2',
  `refout` int(10) unsigned NOT NULL default '1',
  `rdate` int(10) unsigned NOT NULL default '2',
  `comm` int(10) unsigned NOT NULL default '1',
  `dformat` varchar(45) NOT NULL default 'd-m-Y',
  `dnum_reset` int(10) unsigned NOT NULL default '1',
  `doctor` int(10) unsigned NOT NULL default '1',
  `country` varchar(512) default NULL,
  `site_choice_enabled` tinyint(1) default '0',
  PRIMARY KEY  (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config`
--

LOCK TABLES `lab_config` WRITE;
/*!40000 ALTER TABLE `lab_config` DISABLE KEYS */;
INSERT INTO `lab_config` VALUES (8,'ZXCV','bamenda',415,'blis_8',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon',0),(9,'bambam','bar',416,'blis_9',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon',0),(10,'bambam2','bam',417,'blis_10',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon',0),(11,'ras','rasd',418,'blis_11',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon',0),(12,'FONDATION SOCIALE SUISSE, HD PETTE','MAROUA',504,'blis_12',1,1,0,1,4,1,2,1,1,2,1,2,0,'d-m-Y',3,1,'Cameroon',0),(126,'Testlab2','GT',63,'blis_126',1,0,0,1,2,1,2,1,1,0,0,2,0,'d-m-Y',1,1,'USA',0),(127,'Testlab1','GT',53,'blis_127',1,0,0,1,2,1,2,1,1,0,0,2,0,'d-m-Y',1,1,'USA',0),(128,'Bamenda Regional Hospital Lab','Bamenda, Cameroon',115,'blis_128',2,0,0,1,0,1,2,1,1,2,1,2,1,'m-d-Y',1,1,'Cameroon',0),(129,'Buea Regional Hospital Lab','Buea, Cameroon',116,'blis_129',2,0,0,11,1,1,2,11,1,2,1,2,1,'d-m-Y',1,1,'Cameroon',0),(130,'Hopital Centrel Laboratoire','Messa-Yaounde, Cameroon',113,'blis_130',2,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon',0),(131,'Hopital Laquintinie Laboratoire','Douala, Cameroon',114,'blis_131',2,0,1,1,1,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon',0),(151,'Tema Polyclinic Laboratory','Ghana',340,'blis_151',1,0,0,2,2,1,2,1,1,2,1,2,0,'d-m-Y',1,0,'Ghana',0),(152,'Saltpond Municipal Hospital','Ghana',339,'blis_152',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Ghana',0),(153,'Kaneshie Polyclinic','Ghana',338,'blis_153',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Ghana',0),(203,'Limbe Hospital Laboratory','Limbe, Cameroon',174,'blis_203',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon',0),(222,'Nkonsamba Regional Hospital','Nkonsamba',209,'blis_222',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',3,1,'Cameroon',0),(223,'Kisarawe District Laboratory','Coast Region',264,'blis_223',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania',0),(225,'Mafinga Laboratory','Mafinga District. Iringa Region',262,'blis_225',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania',0),(226,'Lushoto Laboratory','Lushoto District, Tanga Region',260,'blis_226',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania',0),(232,'Kiwoko Health Facility','Uganda',220,'blis_232',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda',0),(233,'JOY Medical Center-Ndeeba','Kampala, Uganda',224,'blis_233',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda',0),(234,'St. Stephens Health Centre','Kampala , Uganda',227,'blis_234',1,0,0,2,0,1,2,1,1,2,2,0,2,'d-m-Y',1,2,'Uganda',0),(235,'Alive Medical Services','Kampala, Uganda',226,'blis_235',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda',0),(236,'Kawempe Health Centre','Uganda',233,'blis_236',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda',0),(237,'Ndejje Health Centre','Uganda',234,'blis_237',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda',0),(238,'Jinja Hospital','Uganda',200,'blis_238',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda',0),(1005,'GhanaTest','Atl',404,'blis_1005',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Ghana',0);
/*!40000 ALTER TABLE `lab_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_access`
--

DROP TABLE IF EXISTS `lab_config_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`lab_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_access`
--

LOCK TABLES `lab_config_access` WRITE;
/*!40000 ALTER TABLE `lab_config_access` DISABLE KEYS */;
INSERT INTO `lab_config_access` VALUES (123,12);
/*!40000 ALTER TABLE `lab_config_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_specimen_type`
--

DROP TABLE IF EXISTS `lab_config_specimen_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `specimen_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_specimen_type`
--

LOCK TABLES `lab_config_specimen_type` WRITE;
/*!40000 ALTER TABLE `lab_config_specimen_type` DISABLE KEYS */;
INSERT INTO `lab_config_specimen_type` VALUES (106,7),(106,6),(106,9),(107,7),(107,6),(108,7),(109,6),(110,6),(111,7),(112,7),(113,7),(114,7),(115,7),(116,6),(117,6),(118,6),(119,6),(120,6),(121,6),(122,6),(123,6),(124,6),(125,6),(126,6),(126,7),(127,6),(127,7),(127,11),(128,7),(128,6),(128,8),(128,12),(129,7),(129,10),(129,8),(129,18),(129,15),(129,9),(129,12),(129,6),(130,7),(130,6),(130,8),(130,9),(130,10),(130,12),(131,7),(131,6),(131,8),(131,9),(131,10),(131,12),(132,7),(132,6),(132,9),(132,11),(132,12),(132,14),(132,15),(132,16),(132,17),(133,7),(133,6),(133,9),(133,15),(134,7),(134,6),(134,9),(134,12),(134,15),(134,17),(134,8),(136,7),(137,7),(138,7),(138,6),(138,9),(138,10),(138,12),(138,14),(139,7),(139,6),(140,7),(141,7),(141,6),(141,16),(141,9),(141,12),(142,7),(143,7),(144,7),(145,6),(145,7),(146,7),(147,7),(147,6),(147,18),(148,7),(149,8),(149,18),(149,7),(149,11),(149,6),(150,7),(151,18),(151,6),(152,8),(152,15),(152,7),(152,9),(152,12),(152,11),(152,6),(153,6),(153,7),(153,12),(153,11),(154,6),(154,18),(155,7),(156,7),(157,8),(157,7),(158,6),(158,18),(146,6),(147,9),(127,12),(159,7),(141,11),(160,6),(160,7),(161,7),(162,7),(163,7),(164,7),(165,7),(166,7),(167,7),(168,7),(169,7),(170,7),(141,18),(171,7),(178,13),(178,8),(178,18),(178,15),(178,7),(178,12),(179,10),(179,14),(179,16),(179,7),(180,10),(180,8),(180,14),(180,18),(180,16),(180,7),(181,13),(181,8),(131,16),(181,6),(182,7),(182,12),(183,7),(183,6),(184,7),(184,6),(185,7),(185,6),(186,7),(186,6),(187,7),(187,6),(188,7),(188,6),(189,7),(189,6),(190,7),(190,6),(131,18),(191,16),(191,7),(192,16),(192,7),(193,16),(193,7),(194,16),(194,7),(195,8),(195,18),(195,7),(195,12),(131,14),(195,6),(196,8),(196,18),(196,7),(196,9),(196,12),(139,11),(197,8),(197,7),(197,6),(198,8),(198,18),(198,7),(198,9),(198,12),(203,11),(199,7),(199,12),(138,11),(199,6),(199,9),(200,7),(200,9),(200,12),(131,11),(200,6),(201,7),(201,9),(201,12),(130,11),(201,6),(202,7),(202,9),(202,12),(129,11),(202,6),(202,13),(203,8),(203,7),(203,9),(203,12),(203,6),(203,15),(204,12),(205,7),(205,12),(206,12),(207,12),(128,11),(208,7),(209,7),(210,7),(211,7),(212,7),(212,12),(131,17),(131,15),(128,21),(129,21),(130,21),(131,21),(203,21),(213,13),(213,8),(213,12),(213,11),(213,6),(214,13),(214,8),(214,14),(214,16),(214,12),(214,11),(215,12),(215,11),(215,6),(219,13),(219,12),(219,11),(219,6),(220,13),(220,12),(220,11),(220,6),(221,13),(221,8),(221,18),(221,11),(222,13),(222,10),(222,8),(222,14),(222,18),(222,16),(222,11),(223,13),(223,10),(223,8),(223,14),(223,18),(223,16),(223,11),(224,11),(225,10),(225,12),(225,11),(226,10),(226,12),(226,11),(227,10),(227,12),(227,11),(228,10),(228,12),(228,11),(229,13),(229,8),(229,12),(229,11),(230,8),(230,7),(230,9),(230,12),(230,11),(231,15),(231,7),(231,11),(231,6),(232,10),(232,15),(232,7),(232,9),(232,12),(232,11),(232,6),(233,15),(233,7),(233,12),(233,11),(234,15),(234,11),(234,6),(235,13),(235,7),(235,11),(235,6),(236,7),(236,9),(236,12),(236,11),(237,7),(237,9),(237,12),(237,11),(237,6),(238,13),(238,7),(238,9),(238,12),(238,11),(238,6);
/*!40000 ALTER TABLE `lab_config_specimen_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_test_type`
--

DROP TABLE IF EXISTS `lab_config_test_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `test_type_id` int(10) unsigned NOT NULL default '0',
  `print_unverified` int(11) default '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_test_type`
--

LOCK TABLES `lab_config_test_type` WRITE;
/*!40000 ALTER TABLE `lab_config_test_type` DISABLE KEYS */;
INSERT INTO `lab_config_test_type` VALUES (106,7,1),(106,13,1),(106,10,1),(106,8,1),(107,10,1),(107,13,1),(107,7,1),(107,8,1),(108,8,1),(109,7,1),(110,7,1),(111,7,1),(112,7,1),(113,7,1),(114,7,1),(115,7,1),(116,7,1),(117,7,1),(118,7,1),(119,7,1),(120,7,1),(121,7,1),(122,7,1),(123,7,1),(124,7,1),(125,7,1),(126,7,1),(126,8,1),(127,7,1),(127,8,1),(127,56,1),(128,8,1),(128,48,1),(128,39,1),(128,49,1),(128,50,1),(128,51,1),(128,40,1),(128,52,1),(128,63,1),(128,54,1),(128,71,1),(128,18,1),(128,20,1),(128,22,1),(128,23,1),(128,24,1),(128,25,1),(128,55,1),(128,14,1),(128,43,1),(128,44,1),(128,58,1),(128,61,1),(128,72,1),(128,74,1),(128,70,1),(129,8,1),(129,48,1),(129,21,1),(129,18,1),(129,25,1),(129,27,1),(129,22,1),(129,60,1),(129,55,1),(129,9,1),(129,29,1),(129,30,1),(129,14,1),(129,24,1),(129,23,1),(129,20,1),(129,28,1),(129,70,1),(129,63,1),(129,54,1),(129,39,1),(129,51,1),(129,40,1),(129,52,1),(129,68,1),(207,71,1),(129,59,1),(129,67,1),(129,66,1),(129,58,1),(129,65,1),(129,71,1),(129,69,1),(130,8,1),(130,48,1),(130,20,1),(130,21,1),(130,22,1),(130,24,1),(130,25,1),(130,29,1),(130,30,1),(130,32,1),(130,55,1),(130,16,1),(130,39,1),(130,49,1),(130,51,1),(130,40,1),(130,52,1),(130,54,1),(130,63,1),(130,23,1),(130,43,1),(130,44,1),(130,58,1),(130,71,1),(130,72,1),(131,8,1),(131,48,1),(131,20,1),(131,21,1),(131,22,1),(131,23,1),(131,24,1),(131,25,1),(131,29,1),(131,30,1),(131,55,1),(131,16,1),(131,39,1),(131,51,1),(131,40,1),(131,52,1),(131,54,1),(131,63,1),(131,43,1),(131,44,1),(131,58,1),(131,71,1),(131,27,1),(131,32,1),(131,53,1),(131,41,1),(131,59,1),(132,8,1),(132,48,1),(132,43,1),(132,39,1),(132,40,1),(132,38,1),(132,7,1),(132,22,1),(132,23,1),(132,24,1),(132,35,1),(132,36,1),(132,51,1),(132,63,1),(132,41,1),(132,44,1),(132,47,1),(132,57,1),(132,59,1),(132,61,1),(132,64,1),(133,8,1),(133,48,1),(133,43,1),(133,39,1),(133,40,1),(133,38,1),(133,7,1),(133,22,1),(133,23,1),(133,24,1),(133,35,1),(133,36,1),(133,51,1),(133,63,1),(133,41,1),(133,44,1),(133,47,1),(133,57,1),(133,59,1),(133,61,1),(133,64,1),(134,8,1),(134,48,1),(134,7,1),(134,22,1),(134,23,1),(134,24,1),(134,36,1),(134,39,1),(134,51,1),(134,40,1),(134,63,1),(134,41,1),(134,38,1),(134,47,1),(134,58,1),(134,61,1),(134,64,1),(134,59,1),(134,35,1),(136,8,1),(136,48,1),(137,8,1),(137,48,1),(138,8,1),(138,48,1),(138,18,1),(138,19,1),(138,20,1),(138,22,1),(138,23,1),(138,24,1),(138,26,1),(138,27,1),(138,28,1),(138,29,1),(138,30,1),(138,31,1),(138,74,1),(138,32,1),(138,25,1),(138,55,1),(138,17,1),(138,16,1),(138,15,1),(138,13,1),(138,14,1),(138,49,1),(138,50,1),(138,51,1),(138,40,1),(138,52,1),(138,53,1),(138,54,1),(138,57,1),(138,58,1),(138,59,1),(138,61,1),(138,71,1),(138,62,1),(138,72,1),(138,73,1),(139,8,1),(139,48,1),(140,8,1),(140,48,1),(141,8,1),(141,48,1),(141,39,1),(141,51,1),(141,40,1),(141,53,1),(141,63,1),(141,7,1),(141,18,1),(141,19,1),(141,20,1),(141,22,1),(141,28,1),(141,29,1),(141,30,1),(141,9,1),(141,58,1),(141,54,1),(141,50,1),(141,52,1),(141,38,1),(141,71,1),(142,8,1),(142,48,1),(143,8,1),(143,48,1),(144,8,1),(144,48,1),(145,7,1),(145,38,1),(145,8,1),(146,8,1),(146,48,1),(147,8,1),(147,48,1),(147,7,1),(147,39,1),(147,40,1),(147,49,1),(147,43,1),(147,44,1),(148,8,1),(148,48,1),(149,7,1),(149,21,1),(149,8,1),(149,18,1),(149,25,1),(149,27,1),(149,26,1),(149,22,1),(149,9,1),(149,31,1),(149,29,1),(149,35,1),(149,36,1),(149,24,1),(149,23,1),(149,20,1),(149,28,1),(149,39,1),(149,40,1),(149,50,1),(149,52,1),(149,41,1),(149,42,1),(149,38,1),(149,48,1),(149,43,1),(149,44,1),(149,61,1),(149,47,1),(149,46,1),(149,56,1),(150,48,1),(151,7,1),(151,39,1),(151,40,1),(151,50,1),(151,52,1),(151,41,1),(151,48,1),(151,43,1),(151,46,1),(152,7,1),(152,25,1),(152,34,1),(152,14,1),(152,24,1),(152,23,1),(152,40,1),(152,38,1),(152,44,1),(152,47,1),(152,71,1),(152,56,1),(152,65,1),(153,7,1),(153,71,1),(153,56,1),(153,8,1),(153,39,1),(154,63,1),(154,44,1),(154,42,1),(155,8,1),(155,48,1),(156,8,1),(156,48,1),(157,8,1),(157,70,1),(158,39,1),(158,40,1),(158,38,1),(146,7,1),(146,39,1),(146,18,1),(146,63,1),(133,65,1),(133,69,1),(134,71,1),(134,65,1),(134,70,1),(130,60,1),(130,65,1),(130,70,1),(131,70,1),(131,60,1),(131,69,1),(138,60,1),(138,69,1),(141,69,1),(147,69,1),(127,71,1),(159,8,1),(141,56,1),(160,8,1),(160,7,1),(161,8,1),(162,8,1),(163,8,1),(164,8,1),(165,8,1),(166,8,1),(167,8,1),(168,8,1),(169,8,1),(170,8,1),(171,8,1),(178,19,1),(178,8,1),(178,32,1),(178,64,1),(178,18,1),(178,70,1),(178,63,1),(178,21,1),(179,64,1),(179,70,1),(179,21,1),(179,12,1),(179,25,1),(180,64,1),(180,70,1),(180,21,1),(180,12,1),(180,27,1),(180,54,1),(181,70,1),(181,21,1),(181,12,1),(181,25,1),(181,54,1),(182,8,1),(182,21,1),(182,12,1),(182,9,1),(182,40,1),(183,8,1),(183,7,1),(184,8,1),(184,7,1),(185,8,1),(185,7,1),(186,8,1),(186,7,1),(187,8,1),(187,7,1),(188,8,1),(188,7,1),(189,8,1),(189,7,1),(190,8,1),(190,7,1),(127,19,1),(127,32,1),(127,18,1),(191,19,1),(191,32,1),(191,18,1),(191,7,1),(192,19,1),(192,32,1),(192,18,1),(192,7,1),(193,19,1),(193,32,1),(193,18,1),(193,7,1),(194,19,1),(194,32,1),(194,18,1),(194,7,1),(195,8,1),(195,70,1),(195,21,1),(195,7,1),(195,27,1),(195,31,1),(195,29,1),(195,34,1),(195,30,1),(195,36,1),(195,38,1),(195,71,1),(195,56,1),(196,8,1),(196,18,1),(196,70,1),(196,21,1),(196,7,1),(196,27,1),(197,8,1),(196,31,1),(196,9,1),(196,29,1),(196,71,1),(128,56,1),(197,70,1),(197,39,1),(198,8,1),(198,18,1),(198,12,1),(198,7,1),(198,27,1),(198,29,1),(198,37,1),(198,30,1),(199,8,1),(199,32,1),(199,27,1),(199,71,1),(199,56,1),(199,38,1),(199,39,1),(141,27,1),(199,83,1),(199,44,1),(200,8,1),(200,32,1),(200,27,1),(200,39,1),(200,38,1),(200,71,1),(200,56,1),(201,8,1),(201,32,1),(201,27,1),(201,39,1),(201,31,1),(201,38,1),(201,71,1),(201,56,1),(201,44,1),(201,83,1),(201,61,1),(201,58,1),(201,84,1),(127,40,1),(202,8,1),(202,18,1),(202,7,1),(202,39,1),(202,9,1),(202,38,1),(202,71,1),(202,56,1),(202,40,1),(202,83,1),(202,47,1),(202,61,1),(202,85,1),(128,86,1),(128,7,1),(128,9,1),(203,8,1),(203,18,1),(203,70,1),(203,7,1),(203,25,1),(203,39,1),(203,9,1),(203,14,1),(203,24,1),(203,23,1),(203,71,1),(203,29,1),(203,48,1),(203,40,1),(203,43,1),(203,44,1),(203,42,1),(203,30,1),(203,65,1),(203,86,1),(203,74,1),(203,58,1),(203,52,1),(204,71,1),(205,8,1),(205,71,1),(206,71,1),(129,41,1),(131,85,1),(208,34,1),(208,30,1),(209,34,1),(209,30,1),(210,34,1),(210,30,1),(211,7,1),(212,32,1),(212,18,1),(129,56,1),(130,56,1),(131,56,1),(138,56,1),(203,56,1),(139,56,1),(131,64,1),(131,18,1),(131,68,1),(131,12,1),(131,7,1),(131,15,1),(131,73,1),(131,31,1),(131,57,1),(131,49,1),(131,37,1),(131,33,1),(131,35,1),(131,36,1),(131,14,1),(131,38,1),(131,13,1),(131,50,1),(131,61,1),(131,62,1),(131,72,1),(131,10,1),(131,84,1),(131,47,1),(131,65,1),(131,86,1),(131,83,1),(131,74,1),(131,17,1),(131,67,1),(131,66,1),(131,28,1),(131,11,1),(131,88,1),(128,89,1),(129,89,1),(130,89,1),(131,89,1),(203,89,1),(129,90,1),(129,91,1),(129,12,1),(129,35,1),(129,11,1),(129,92,1),(129,93,1),(129,94,1),(129,38,1),(129,95,1),(129,96,1),(129,97,1),(129,84,1),(129,98,1),(213,19,1),(213,8,1),(213,64,1),(213,18,1),(213,70,1),(213,7,1),(213,60,1),(214,38,1),(214,71,1),(214,86,1),(214,74,1),(214,56,1),(215,90,1),(215,8,1),(215,92,1),(215,56,1),(215,93,1),(216,8,1),(216,92,1),(216,90,1),(216,56,1),(219,8,1),(219,18,1),(219,28,1),(219,56,1),(220,8,1),(220,18,1),(220,28,1),(220,56,1),(221,22,1),(221,89,1),(221,39,1),(221,11,1),(221,56,1),(221,58,1),(222,98,1),(222,21,1),(222,84,1),(222,56,1),(223,98,1),(223,21,1),(223,84,1),(223,56,1),(224,56,1),(225,96,1),(225,71,1),(225,56,1),(226,96,1),(226,71,1),(226,56,1),(227,96,1),(227,71,1),(227,56,1),(228,96,1),(228,71,1),(228,56,1),(229,31,1),(229,57,1),(229,71,1),(230,32,1),(230,38,1),(230,56,1),(230,58,1),(230,93,1),(231,32,1),(231,7,1),(231,38,1),(231,24,1),(231,56,1),(231,58,1),(231,93,1),(232,32,1),(232,7,1),(232,38,1),(232,56,1),(232,58,1),(232,93,1),(233,90,1),(233,19,1),(233,32,1),(233,63,1),(233,95,1),(233,53,1),(233,91,1),(233,58,1),(234,63,1),(235,64,1),(235,60,1),(235,48,1),(235,44,1),(235,53,1),(235,91,1),(235,86,1),(235,58,1),(235,93,1),(236,8,1),(236,32,1),(236,44,1),(236,38,1),(236,71,1),(236,83,1),(236,27,1),(236,56,1),(237,8,1),(237,32,1),(237,39,1),(237,31,1),(237,44,1),(237,38,1),(237,61,1),(237,84,1),(237,71,1),(237,27,1),(237,56,1),(237,58,1),(238,85,1),(238,8,1),(238,18,1),(238,7,1),(238,9,1),(238,39,1),(238,40,1),(238,38,1),(238,61,1),(238,47,1),(238,71,1),(238,83,1),(238,56,1);
/*!40000 ALTER TABLE `lab_config_test_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map_coordinates`
--

DROP TABLE IF EXISTS `map_coordinates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map_coordinates` (
  `id` int(11) NOT NULL auto_increment,
  `lab_id` int(11) NOT NULL,
  `coordinates` varchar(100) collate latin1_general_ci default NULL,
  `user_id` int(11) default NULL,
  `flag` int(11) default '1',
  `country` varchar(110) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measure_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `measure_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_measure_id` varchar(256) collate latin1_general_ci default NULL,
  `measure_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `misc` (
  `username` varchar(20) collate latin1_general_ci default NULL,
  `action` varchar(40) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reference_range_global` (
  `measure_id` int(10) NOT NULL default '0',
  `age_min` varchar(64) collate latin1_general_ci default NULL,
  `age_max` varchar(64) collate latin1_general_ci default NULL,
  `sex` varchar(64) collate latin1_general_ci default NULL,
  `range_lower` varchar(64) collate latin1_general_ci default NULL,
  `range_upper` varchar(64) collate latin1_general_ci default NULL,
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_config` (
  `report_id` int(10) unsigned NOT NULL auto_increment,
  `header` varchar(500) NOT NULL default '',
  `footer` varchar(500) NOT NULL default '',
  `margins` varchar(45) NOT NULL default '',
  `p_fields` varchar(45) NOT NULL default '',
  `s_fields` varchar(45) NOT NULL default '',
  `t_fields` varchar(45) NOT NULL default '',
  `p_custom_fields` varchar(45) NOT NULL default '',
  `s_custom_fields` varchar(45) NOT NULL default '',
  `test_type_id` varchar(45) NOT NULL default '',
  `title` varchar(500) NOT NULL default '',
  `landscape` int(10) unsigned NOT NULL default '0',
  `age_unit` int(11) default NULL,
  PRIMARY KEY  (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specimen_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `specimen_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_specimen_id` varchar(256) collate latin1_general_ci default NULL,
  `specimen_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`specimen_id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_category_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_category_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_category_id` varchar(256) collate latin1_general_ci default NULL,
  `test_category_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`test_category_id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_id` varchar(256) collate latin1_general_ci default NULL,
  `test_id` int(10) unsigned NOT NULL default '0',
  `test_category_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`user_id`,`test_id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `actualname` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `created_by` int(11) unsigned default NULL,
  `ts` timestamp NOT NULL default '0000-00-00 00:00:00',
  `lab_config_id` int(11) unsigned default NULL,
  `level` int(11) unsigned default NULL,
  `phone` varchar(45) default NULL,
  `lang_id` varchar(45) NOT NULL,
  `rwoptions` varchar(20) NOT NULL default '2,3,4,6,7',
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (26,'monu','18865bfdeed2fd380316ecde609d94d7285af83f','Ruban','rubanm@gatech.edu',0,'2010-04-30 07:22:39',0,3,'','en','2,3,4,6,7'),(27,'vempala','18865bfdeed2fd380316ecde609d94d7285af83f','Santosh Vempala','vempala@cc.gatech.edu',0,'2010-01-10 15:00:55',0,3,'','default','2,3,4,6,7'),(53,'testlab1_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Testlab1 admin','',26,'2010-01-14 17:05:44',0,2,'','default','2,3,4,6,7'),(56,'testlab1_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Testlab1 Tech1','',26,'2010-04-30 03:53:06',127,0,'','en','2,3,4,6,7'),(57,'testlab1_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Testlab1 Tech2','',26,'2010-01-14 17:10:48',127,1,'','default','2,3,4,6,7'),(63,'testlab2_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Testlab2 admin','',26,'2010-01-14 17:05:44',0,2,'','default','2,3,4,6,7'),(66,'testlab2_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Testlab2 Tech1','',26,'2010-04-30 03:53:06',126,0,'','en','2,3,4,6,7'),(67,'testlab2_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Testlab2 Tech2','',26,'2010-01-14 17:10:48',126,1,'','default','2,3,4,6,7'),(123,'cameroon_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','Cameroon Country Dir.','',0,'2010-01-18 15:15:39',0,4,'677073324','fr','2,3,4,6,7'),(125,'ghana_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','Ghana Country Dir.','',0,'2010-01-18 15:16:30',0,4,'','default','2,3,4,6,7'),(501,'tanzania_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','Tanzania Country Dir.','',0,'2010-01-18 15:15:39',0,4,'','default','2,3,4,6,7'),(502,'drc_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','DRC Country Dir.','',0,'2010-01-18 15:15:39',0,4,'','default','2,3,4,6,7'),(503,'uganda_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','Uganda Country Dir.','',0,'2010-01-18 15:15:39',0,4,'','default','2,3,4,6,7'),(504,'pette_admin1','18865bfdeed2fd380316ecde609d94d7285af83f','Dr. Talaka','',123,'2021-08-08 23:00:00',12,2,'','fr','2,3,4,6,7'),(505,'sidney','c4acdecee31ca56ce9a5cae96e01d23fb83a0724','Sidney Akuro Atah','',123,'0000-00-00 00:00:00',12,0,'','default','2,3,4,6,7');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_config`
--

DROP TABLE IF EXISTS `user_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_config` (
  `user_id` int(11) NOT NULL default '0',
  `level` int(11) default NULL,
  `parameter` varchar(256) collate latin1_general_ci NOT NULL default '',
  `value` varchar(256) collate latin1_general_ci default NULL,
  `created_by` varchar(256) collate latin1_general_ci default NULL,
  `created_on` date default NULL,
  `modified_by` varchar(256) collate latin1_general_ci default NULL,
  `modified_on` date default NULL,
  PRIMARY KEY  (`user_id`,`parameter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_config`
--

LOCK TABLES `user_config` WRITE;
/*!40000 ALTER TABLE `user_config` DISABLE KEYS */;
INSERT INTO `user_config` VALUES (26,3,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(27,3,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(53,2,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(56,0,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(57,1,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(63,2,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(66,0,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(67,1,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(123,4,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(125,4,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(501,4,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(502,4,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(503,4,'rwoptions','2,3,4,6,7','Aishwarya','2015-08-26','Aishwarya','2015-08-26'),(504,2,'rwoptions','2,3,4,6,7','123','2021-08-09','123','2021-08-09'),(505,0,'rwoptions','2,3,4,6,7','123','2021-08-09','123','2021-08-09');
/*!40000 ALTER TABLE `user_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_log` (
  `patient_id` int(11) default NULL,
  `log_type` varchar(100) collate latin1_general_ci default NULL,
  `creation_date` datetime default NULL,
  `created_by` int(11) default NULL
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_type` (
  `level` int(11) NOT NULL auto_increment,
  `name` varchar(256) collate latin1_general_ci default NULL,
  `defaultdisplay` tinyint(1) default '0',
  `created_by` varchar(256) collate latin1_general_ci default NULL,
  `created_on` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`level`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_type_config` (
  `level` int(11) NOT NULL default '0',
  `parameter` varchar(256) collate latin1_general_ci NOT NULL default '',
  `value` varchar(256) collate latin1_general_ci default NULL,
  `created_by` varchar(256) collate latin1_general_ci default NULL,
  `created_on` date default NULL,
  `modified_by` varchar(256) collate latin1_general_ci default NULL,
  `modified_on` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`level`,`parameter`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `status` int(11) default NULL,
  `user_id` int(11) default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `i_ts` timestamp NULL default NULL,
  `u_ts` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `version_data`
--

LOCK TABLES `version_data` WRITE;
/*!40000 ALTER TABLE `version_data` DISABLE KEYS */;
INSERT INTO `version_data` VALUES (1,'2.4',1,116,NULL,'2013-03-09 06:01:13','2013-03-09 06:01:13'),(2,'2.6',1,53,NULL,'2013-09-19 05:16:47','2013-09-19 05:16:47'),(3,'2.6',1,53,NULL,'2013-09-19 05:16:54','2013-09-19 05:16:54'),(4,'2.7',1,53,NULL,'2014-04-07 17:23:52','2014-04-07 17:23:52'),(5,'2.91',1,53,NULL,'2015-08-26 19:29:29','2015-08-26 19:29:29'),(6,'3.0',1,53,NULL,'2015-09-26 19:29:29','2015-09-26 19:29:29'),(7,'3.3',1,53,NULL,'2017-04-27 03:03:03','2017-04-27 03:03:03'),(8,'3.4',1,53,NULL,'2018-11-08 05:09:41','2018-11-08 05:09:41'),(9,'3.5',1,53,NULL,'2019-04-17 23:19:27','2019-04-17 23:19:27'),(10,'3.52',1,53,NULL,'2019-09-30 17:59:43','2019-09-30 17:59:43'),(11,'3.6',1,123,NULL,'2021-08-09 05:21:56','2021-08-09 05:21:56'),(12,'3.61',1,53,NULL,'2021-10-22 18:57:13','2021-10-22 18:57:13'),(13,'3.7',1,53,NULL,'2021-12-06 20:03:29','2021-12-06 20:03:29'),(14,'3.71',1,53,NULL,'2022-01-14 16:00:25','2022-01-14 16:00:25'),(15,'3.72',1,123,NULL,'2022-02-09 04:07:23','2022-02-09 04:07:23');
/*!40000 ALTER TABLE `version_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'blis_revamp'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-09 19:19:09
