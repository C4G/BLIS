-- MySQL dump 10.11
--
-- Host: localhost    Database: blis_12
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
-- Current Database: `blis_12`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `blis_12` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;

USE `blis_12`;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE `bills` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `patient_id` int(11) unsigned NOT NULL,
  `paid_in_full` bit(1) NOT NULL default '\0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills_test_association`
--

DROP TABLE IF EXISTS `bills_test_association`;
CREATE TABLE `bills_test_association` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `bill_id` int(11) unsigned NOT NULL,
  `test_id` int(11) unsigned NOT NULL,
  `discount_type` int(4) unsigned NOT NULL default '1000',
  `discount_amount` decimal(10,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `bills_test_association`
--

LOCK TABLES `bills_test_association` WRITE;
/*!40000 ALTER TABLE `bills_test_association` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills_test_association` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL default '',
  `page` varchar(45) NOT NULL default '',
  `comment` varchar(150) NOT NULL default '',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_conversion`
--

DROP TABLE IF EXISTS `currency_conversion`;
CREATE TABLE `currency_conversion` (
  `currencya` varchar(200) NOT NULL,
  `currencyb` varchar(200) NOT NULL,
  `exchangerate` float(5,2) default NULL,
  `updatedts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `flag1` int(11) default NULL,
  `flag2` int(11) default NULL,
  `setting1` varchar(200) default NULL,
  `setting2` varchar(200) default NULL,
  PRIMARY KEY  (`currencya`,`currencyb`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency_conversion`
--

LOCK TABLES `currency_conversion` WRITE;
/*!40000 ALTER TABLE `currency_conversion` DISABLE KEYS */;
INSERT INTO `currency_conversion` VALUES ('GHâ‚µ','GHâ‚µ',1.00,'2015-03-17 08:39:32',1,NULL,NULL,NULL),('GHS','GHS',1.00,'2015-03-17 08:39:32',0,NULL,NULL,NULL),('USD','USD',1.00,'2015-03-17 08:39:32',0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `currency_conversion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_field_type`
--

DROP TABLE IF EXISTS `custom_field_type`;
CREATE TABLE `custom_field_type` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_type` varchar(45) default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `custom_field_type`
--

LOCK TABLES `custom_field_type` WRITE;
/*!40000 ALTER TABLE `custom_field_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_field_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delay_measures`
--

DROP TABLE IF EXISTS `delay_measures`;
CREATE TABLE `delay_measures` (
  `User_Id` varchar(50) NOT NULL default '',
  `IP_Address` varchar(16) NOT NULL default '',
  `Latency` int(11) NOT NULL default '0',
  `Recorded_At` datetime NOT NULL default '0000-00-00 00:00:00',
  `Page_Name` varchar(45) default NULL,
  `Request_URI` varchar(100) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delay_measures`
--

LOCK TABLES `delay_measures` WRITE;
/*!40000 ALTER TABLE `delay_measures` DISABLE KEYS */;
/*!40000 ALTER TABLE `delay_measures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dhims2_api_config`
--

DROP TABLE IF EXISTS `dhims2_api_config`;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `dhims2_api_config`
--

LOCK TABLES `dhims2_api_config` WRITE;
/*!40000 ALTER TABLE `dhims2_api_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `dhims2_api_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_order`
--

DROP TABLE IF EXISTS `field_order`;
CREATE TABLE `field_order` (
  `id` int(11) NOT NULL auto_increment,
  `lab_config_id` int(11) unsigned default NULL,
  `form_id` int(11) default NULL,
  `field_order` varchar(2000) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `field_order`
--

LOCK TABLES `field_order` WRITE;
/*!40000 ALTER TABLE `field_order` DISABLE KEYS */;
INSERT INTO `field_order` VALUES (28,12,2,'Specimen ID,Specimen Additional ID,Lab Reciept Date,Referred Out,Physician,Source'),(27,12,1,'Patient ID,Daily Number,Patient Name,Sex,Age,Date of Birth,Client Contact');
/*!40000 ALTER TABLE `field_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_reagent`
--

DROP TABLE IF EXISTS `inv_reagent`;
CREATE TABLE `inv_reagent` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) collate latin1_general_ci NOT NULL,
  `unit` varchar(45) collate latin1_general_ci NOT NULL default 'units',
  `remarks` varchar(245) collate latin1_general_ci default NULL,
  `created_by` varchar(10) collate latin1_general_ci NOT NULL default '0',
  `assocation` varchar(10) collate latin1_general_ci default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `inv_reagent`
--

LOCK TABLES `inv_reagent` WRITE;
/*!40000 ALTER TABLE `inv_reagent` DISABLE KEYS */;
/*!40000 ALTER TABLE `inv_reagent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_supply`
--

DROP TABLE IF EXISTS `inv_supply`;
CREATE TABLE `inv_supply` (
  `id` int(11) NOT NULL auto_increment,
  `reagent_id` int(11) NOT NULL,
  `lot` varchar(100) collate latin1_general_ci NOT NULL,
  `expiry_date` date default NULL,
  `manufacturer` varchar(100) collate latin1_general_ci default NULL,
  `supplier` varchar(100) collate latin1_general_ci default NULL,
  `quantity_ordered` int(11) NOT NULL default '0',
  `quantity_supplied` int(11) NOT NULL default '0',
  `cost_per_unit` decimal(10,0) default NULL,
  `user_id` int(11) NOT NULL default '0',
  `date_of_order` date default NULL,
  `date_of_supply` date default NULL,
  `date_of_reception` date default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `reagent_id` (`reagent_id`),
  CONSTRAINT `reagent_id` FOREIGN KEY (`reagent_id`) REFERENCES `inv_reagent` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `inv_supply`
--

LOCK TABLES `inv_supply` WRITE;
/*!40000 ALTER TABLE `inv_supply` DISABLE KEYS */;
/*!40000 ALTER TABLE `inv_supply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_usage`
--

DROP TABLE IF EXISTS `inv_usage`;
CREATE TABLE `inv_usage` (
  `id` int(11) NOT NULL auto_increment,
  `reagent_id` int(11) NOT NULL,
  `lot` varchar(100) collate latin1_general_ci NOT NULL,
  `quantity_used` int(11) NOT NULL default '0',
  `date_of_use` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `ts` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `reagent_id` (`reagent_id`),
  KEY `reagent_id2` (`reagent_id`),
  CONSTRAINT `reagent_id2` FOREIGN KEY (`reagent_id`) REFERENCES `inv_reagent` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `inv_usage`
--

LOCK TABLES `inv_usage` WRITE;
/*!40000 ALTER TABLE `inv_usage` DISABLE KEYS */;
/*!40000 ALTER TABLE `inv_usage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config`
--

DROP TABLE IF EXISTS `lab_config`;
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
  PRIMARY KEY  (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Dumping data for table `lab_config`
--

LOCK TABLES `lab_config` WRITE;
/*!40000 ALTER TABLE `lab_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_access`
--

DROP TABLE IF EXISTS `lab_config_access`;
CREATE TABLE `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`lab_config_id`),
  KEY `lab_config_id` (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_config_access`
--

LOCK TABLES `lab_config_access` WRITE;
/*!40000 ALTER TABLE `lab_config_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_config_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_settings`
--

DROP TABLE IF EXISTS `lab_config_settings`;
CREATE TABLE `lab_config_settings` (
  `id` int(11) NOT NULL,
  `flag1` int(11) default NULL,
  `flag2` int(11) default NULL,
  `flag3` int(11) default NULL,
  `flag4` int(11) default NULL,
  `setting1` varchar(200) collate latin1_general_ci default NULL,
  `setting2` varchar(200) collate latin1_general_ci default NULL,
  `setting3` varchar(200) collate latin1_general_ci default NULL,
  `setting4` varchar(200) collate latin1_general_ci default NULL,
  `misc` varchar(500) collate latin1_general_ci default NULL,
  `remarks` varchar(500) collate latin1_general_ci default NULL,
  `ts` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `lab_config_settings`
--

LOCK TABLES `lab_config_settings` WRITE;
/*!40000 ALTER TABLE `lab_config_settings` DISABLE KEYS */;
INSERT INTO `lab_config_settings` VALUES (1,1,2,30,11,'code39',NULL,NULL,NULL,NULL,'Barcode Settings','2015-03-16 08:34:44'),(2,20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Search Settings','2015-03-16 08:34:44'),(3,1,NULL,NULL,NULL,'GHâ‚µ','.',NULL,NULL,NULL,'Billing Settings','2015-03-16 08:34:44');
/*!40000 ALTER TABLE `lab_config_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_specimen_type`
--

DROP TABLE IF EXISTS `lab_config_specimen_type`;
CREATE TABLE `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `specimen_type_id` int(10) unsigned NOT NULL default '0',
  KEY `lab_config_id` (`lab_config_id`),
  KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_config_specimen_type`
--

LOCK TABLES `lab_config_specimen_type` WRITE;
/*!40000 ALTER TABLE `lab_config_specimen_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_config_specimen_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_test_type`
--

DROP TABLE IF EXISTS `lab_config_test_type`;
CREATE TABLE `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `test_type_id` int(10) unsigned NOT NULL default '0',
  KEY `lab_config_id` (`lab_config_id`),
  KEY `test_type_id` (`test_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_config_test_type`
--

LOCK TABLES `lab_config_test_type` WRITE;
/*!40000 ALTER TABLE `lab_config_test_type` DISABLE KEYS */;
INSERT INTO `lab_config_test_type` VALUES (12,1),(12,2),(12,3),(12,4),(12,5),(12,6),(12,7),(12,8),(12,9),(12,10),(12,11),(12,12),(12,13),(12,14),(12,15),(12,16),(12,17),(12,18),(12,19),(12,20),(12,21),(12,22),(12,23),(12,24),(12,25),(12,26),(12,27),(12,28),(12,29),(12,30),(12,31),(12,32),(12,33),(12,34),(12,35),(12,36),(12,37),(12,38),(12,39),(12,40),(12,41),(12,42),(12,43),(12,44),(12,45),(12,46),(12,47),(12,48),(12,49),(12,50),(12,51),(12,52),(12,53),(12,54),(12,55),(12,56),(12,57);
/*!40000 ALTER TABLE `lab_config_test_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labtitle_custom_field`
--

DROP TABLE IF EXISTS `labtitle_custom_field`;
CREATE TABLE `labtitle_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL,
  `field_options` text NOT NULL,
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `labtitle_custom_field`
--

LOCK TABLES `labtitle_custom_field` WRITE;
/*!40000 ALTER TABLE `labtitle_custom_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `labtitle_custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measure`
--

DROP TABLE IF EXISTS `measure`;
CREATE TABLE `measure` (
  `measure_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `unit_id` int(10) unsigned default NULL,
  `range` varchar(500) default NULL,
  `description` varchar(500) default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `unit` varchar(30) default NULL,
  PRIMARY KEY  (`measure_id`),
  KEY `unit_id` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `measure`
--

LOCK TABLES `measure` WRITE;
/*!40000 ALTER TABLE `measure` DISABLE KEYS */;
INSERT INTO `measure` VALUES (1,'BF for MPS',NULL,'No MPS Seen/Positive',NULL,'2015-03-16 09:14:16',''),(2,'PARASITE COUNT',NULL,'$freetext$$',NULL,'2015-03-17 10:24:05','parasite / ÂµL'),(3,'SPECIES',NULL,'Plasmodium falciparum/Plasmodium Ovale/Plasmodium malariae/Plasmodium vivax',NULL,'2015-03-17 10:08:31',''),(4,'DEVELOPMENTAL STAGE',NULL,'Trophozoites/Gametocytes/Schizonts',NULL,'2015-03-17 10:08:31',''),(5,'ESR',NULL,':',NULL,'2015-03-16 10:27:14','mm fall / hr'),(6,'Sickling',NULL,'Negative/Positive',NULL,'2015-03-16 10:34:23',''),(7,'G6PD',NULL,'No Defect/Partial Defect/Full Defect',NULL,'2015-03-16 10:36:05',''),(8,'Genetype',NULL,'AS/AA/AC/SC/SS/CC/AS with F/AA with F/AC with F/SC with F/SS with F/CC with F',NULL,'2015-03-16 10:38:29',''),(9,'HB',NULL,':',NULL,'2015-03-16 10:46:14','g / dL'),(10,'HCT',NULL,':',NULL,'2015-03-16 10:49:11','%'),(11,'RBC',NULL,':',NULL,'2015-03-16 10:52:41','x10Â¹Â² / L'),(12,'MCV',NULL,':',NULL,'2015-03-16 10:53:38','f'),(13,'MCH',NULL,':',NULL,'2015-03-16 10:54:47','g / L'),(14,'WBC',NULL,':',NULL,'2015-03-16 10:56:23','x10â¹L'),(15,'NEUTROPHILS',NULL,':',NULL,'2015-03-16 10:57:31','%'),(16,'LYMPHOCYTES',NULL,':',NULL,'2015-03-16 10:58:29','%'),(17,'MONOCYTES',NULL,':',NULL,'2015-03-16 10:59:25','%'),(18,'EOSINOPHIL',NULL,':',NULL,'2015-03-16 11:00:18','%'),(19,'BASOPHIL',NULL,':',NULL,'2015-03-16 11:01:01','%'),(20,'PLATELETS',NULL,':',NULL,'2015-03-16 11:02:02','x10â¹L'),(21,'RETICOLCYTES',NULL,':',NULL,'2015-03-16 11:03:17','%'),(22,'SKIN SNIP TEST',NULL,'$freetext$$',NULL,'2015-03-16 11:06:07',''),(23,'ALBUMIN',NULL,':',NULL,'2015-03-16 11:08:09','g / L'),(24,'ALP / DEA',NULL,':',NULL,'2015-03-16 11:11:47','Âµ / L'),(25,'ALT / GPT',NULL,':',NULL,'2015-03-16 11:13:34','Âµ / L'),(26,'AST / GOT',NULL,':',NULL,'2015-03-16 11:14:58','Âµ / L'),(27,'BILIRUBIN DIRECT',NULL,':',NULL,'2015-03-16 11:17:08','Âµmol / L'),(28,'BILIRUBIN TOTAL',NULL,':',NULL,'2015-03-16 11:18:45','Âµmol / L'),(29,'TOTAL PROTEIN',NULL,':',NULL,'2015-03-16 11:19:52','g / L'),(30,'GAMMA GT',NULL,':',NULL,'2015-03-16 11:20:58','Âµ / L'),(31,'CHOLESTEROL',NULL,':',NULL,'2015-03-16 11:24:40','Âµmol / L'),(32,'TRYGLYCERIDES',NULL,':',NULL,'2015-03-16 15:28:29','Âµmol / L'),(33,'HDL - CHOLESTEROL',NULL,':',NULL,'2015-03-16 15:30:41','Âµmol / L'),(34,'LDL - CHOLESTEROL',NULL,':',NULL,'2015-03-16 20:21:03','mmol / L'),(35,'CORONARY RISK',NULL,':',NULL,'2015-03-16 20:22:10','Risk'),(36,'CREATINE',NULL,':',NULL,'2015-03-16 20:26:22','Âµmol / L'),(37,'UREA',NULL,':',NULL,'2015-03-16 20:27:54','mmol / L'),(38,'POTASSIUM',NULL,':',NULL,'2015-03-16 20:30:27','mmol / L'),(39,'SODIUM',NULL,':',NULL,'2015-03-16 20:32:41','mmol / L'),(40,'CHLORIDE',NULL,':',NULL,'2015-03-16 20:35:39','mmol / L'),(41,'CK - MB',NULL,':',NULL,'2015-03-16 20:40:14','Âµ / L'),(42,'CK - NAC',NULL,':',NULL,'2015-03-16 20:41:50','Âµ / L'),(43,'LDH',NULL,':',NULL,'2015-03-16 20:42:49','Âµ / L'),(44,'Uric Acid',NULL,':',NULL,'2015-03-16 20:57:16','mmol / L'),(45,'Calcium',NULL,':',NULL,'2015-03-17 07:57:37','mmol / L'),(46,'Amylase',NULL,':',NULL,'2015-03-17 07:59:03','Âµ / L'),(47,'Glucose',NULL,':',NULL,'2015-03-17 07:59:59','mmol / L'),(48,'Pregnancy Test',NULL,'Negative/Positive',NULL,'2015-03-17 08:03:23',''),(49,'S. Typhi - Titre - O',NULL,'1 # 40/1 # 80/1 # 160/1 # 320',NULL,'2015-03-17 09:35:55',''),(50,'S. Typhi - Titre - H',NULL,'1 # 40/1 # 80/1 # 160/1 # 320',NULL,'2015-03-17 09:35:55',''),(51,'RHEUMATIOD FACTOR',NULL,'$freetext$$',NULL,'2015-03-17 08:07:24',''),(52,'Blood Group',NULL,'A Rh \"D\" Positive/A Rh \"D\" Negative/B Rh \"D\" Positive/B Rh \"D\" Negative/AB Rh \"D\" Positive/AB Rh \"D\" Negative/O Rh \"D\" Positive/O Rh \"D\" Negative',NULL,'2015-03-17 09:23:42',''),(53,'SPECIMEN TYPE',NULL,'Semi - formed/Loose/Formed/Mucoid/Bloody/Bloody - stained/Watery',NULL,'2015-03-17 08:15:08',''),(54,'WBC',NULL,'Nil/Few/Moderate/Many',NULL,'2015-03-17 08:15:09',''),(55,'RBC',NULL,'Nil/Few/Moderate/Many',NULL,'2015-03-17 08:15:09',''),(56,'CYST',NULL,'$freetext$$',NULL,'2015-03-17 08:15:09',''),(57,'LARVAE',NULL,'$freetext$$',NULL,'2015-03-17 08:15:09',''),(58,'OVA',NULL,'$freetext$$',NULL,'2015-03-17 08:15:09',''),(59,'OTHER',NULL,'$freetext$$',NULL,'2015-03-17 08:15:09',''),(60,'OCCULT BLOOD',NULL,'$freetext$$',NULL,'2015-03-17 08:15:09',''),(61,'Colour',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(62,'Apperance',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(63,'Leucocyte',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(64,'pH ',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(65,'Glucose',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(66,'Specific Gravity',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(67,'Ketones',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(68,'Nitrate',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(69,'Proteins',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(70,'Bilirubin',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(71,'Urobilinogen',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(72,'Blood ',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(73,'Pus Cells',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(74,'Epithelia Cells',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(75,'Red Blood Cells',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(76,'Yeast - like Cells',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(77,'Cast ',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(78,'Crystals',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(79,'Other ',NULL,'$freetext$$',NULL,'2015-03-17 08:21:14',''),(80,'OCCULT BLOOD',NULL,'$freetext$$',NULL,'2015-03-17 08:26:21',''),(81,'24HRS URINE PROTEIN',NULL,'$freetext$$',NULL,'2015-03-17 08:27:33','');
/*!40000 ALTER TABLE `measure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misc`
--

DROP TABLE IF EXISTS `misc`;
CREATE TABLE `misc` (
  `id` int(11) NOT NULL auto_increment,
  `r_id` int(11) NOT NULL default '0',
  `vr_id` varchar(45) collate latin1_general_ci NOT NULL default '0',
  `i1` int(11) NOT NULL default '0',
  `i2` int(11) NOT NULL default '0',
  `i3` int(11) NOT NULL default '0',
  `i4` int(11) NOT NULL default '0',
  `i5` int(11) NOT NULL default '0',
  `v1` varchar(500) collate latin1_general_ci NOT NULL default '0',
  `v2` varchar(500) collate latin1_general_ci NOT NULL default '0',
  `v3` varchar(500) collate latin1_general_ci NOT NULL default '0',
  `v4` varchar(500) collate latin1_general_ci NOT NULL default '0',
  `v5` varchar(500) collate latin1_general_ci NOT NULL default '0',
  `dt1` datetime default NULL,
  `dt2` datetime default NULL,
  `dt3` datetime default NULL,
  `d1` date default NULL,
  `d2` date default NULL,
  `d3` date default NULL,
  `ts` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `misc`
--

LOCK TABLES `misc` WRITE;
/*!40000 ALTER TABLE `misc` DISABLE KEYS */;
/*!40000 ALTER TABLE `misc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `numeric_interpretation`
--

DROP TABLE IF EXISTS `numeric_interpretation`;
CREATE TABLE `numeric_interpretation` (
  `range_u` int(10) default NULL,
  `range_l` int(10) default NULL,
  `age_u` int(10) default NULL,
  `age_l` int(10) default NULL,
  `gender` varchar(40) default NULL,
  `description` varchar(40) default NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `numeric_interpretation`
--

LOCK TABLES `numeric_interpretation` WRITE;
/*!40000 ALTER TABLE `numeric_interpretation` DISABLE KEYS */;
/*!40000 ALTER TABLE `numeric_interpretation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE `patient` (
  `patient_id` int(11) unsigned NOT NULL default '0',
  `addl_id` varchar(40) default NULL,
  `name` varchar(45) default NULL,
  `sex` char(1) NOT NULL default '',
  `age` decimal(10,0) default NULL,
  `dob` date default NULL,
  `created_by` int(11) unsigned default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `partial_dob` varchar(45) default NULL,
  `surr_id` varchar(45) default NULL,
  `hash_value` varchar(100) default NULL,
  PRIMARY KEY  (`patient_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,'undefined','Kayla Forson','F','0',NULL,506,'2015-03-16 00:00:00','1992-03-16','KF/001/16/03/15','7449f27f17079db192727d4e0ad353c522b84491');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_custom_data`
--

DROP TABLE IF EXISTS `patient_custom_data`;
CREATE TABLE `patient_custom_data` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_id` int(11) unsigned NOT NULL default '0',
  `patient_id` int(11) unsigned NOT NULL default '0',
  `field_value` varchar(45) NOT NULL default '',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_id` (`field_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_custom_data`
--

LOCK TABLES `patient_custom_data` WRITE;
/*!40000 ALTER TABLE `patient_custom_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `patient_custom_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_custom_field`
--

DROP TABLE IF EXISTS `patient_custom_field`;
CREATE TABLE `patient_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL default '',
  `field_options` text NOT NULL,
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `patient_custom_field`
--

LOCK TABLES `patient_custom_field` WRITE;
/*!40000 ALTER TABLE `patient_custom_field` DISABLE KEYS */;
INSERT INTO `patient_custom_field` VALUES (1,'Client Contact','',1,'2015-03-17 09:03:48');
/*!40000 ALTER TABLE `patient_custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_daily`
--

DROP TABLE IF EXISTS `patient_daily`;
CREATE TABLE `patient_daily` (
  `datestring` varchar(45) NOT NULL,
  `count` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_daily`
--

LOCK TABLES `patient_daily` WRITE;
/*!40000 ALTER TABLE `patient_daily` DISABLE KEYS */;
INSERT INTO `patient_daily` VALUES ('20150316',2),('20150317',2);
/*!40000 ALTER TABLE `patient_daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_report_fields_order`
--

DROP TABLE IF EXISTS `patient_report_fields_order`;
CREATE TABLE `patient_report_fields_order` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `p_fields` varchar(500) collate latin1_general_ci NOT NULL default '',
  `o_fields` varchar(500) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `patient_report_fields_order`
--

LOCK TABLES `patient_report_fields_order` WRITE;
/*!40000 ALTER TABLE `patient_report_fields_order` DISABLE KEYS */;
INSERT INTO `patient_report_fields_order` VALUES (1,'p_field_9,p_field_10,p_field_1,p_field_2,p_field_5,p_field_7,p_field_8,p_field_11,p_field_12','p_field_0,p_field_6,p_field_3,p_field_4');
/*!40000 ALTER TABLE `patient_report_fields_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL auto_increment,
  `amount` decimal(10,2) NOT NULL default '0.00',
  `bill_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference_range`
--

DROP TABLE IF EXISTS `reference_range`;
CREATE TABLE `reference_range` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `measure_id` int(10) unsigned NOT NULL,
  `age_min` varchar(45) default NULL,
  `age_max` varchar(45) default NULL,
  `sex` varchar(10) default NULL,
  `range_lower` varchar(45) NOT NULL,
  `range_upper` varchar(45) NOT NULL,
  `age_type` int(11) NOT NULL default '3',
  PRIMARY KEY  (`id`),
  KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reference_range`
--

LOCK TABLES `reference_range` WRITE;
/*!40000 ALTER TABLE `reference_range` DISABLE KEYS */;
INSERT INTO `reference_range` VALUES (1,5,'0','100','M','0 ','12',3),(2,5,'0','100','F','0','19',3),(3,9,'0','100','M','13.0','18.0',3),(4,9,'0','100','F','12.0','16.0',3),(5,10,'0','100','M','40','50',3),(6,10,'0','100','F','36','46',3),(7,11,'0','100','B','4.20','6.30',3),(8,12,'0','100','B','80.0','97.0',3),(9,13,'0','100','B','31.0','36.0',3),(10,14,'0','100','B','4.1 ','10',3),(11,15,'0','100','B','40','75',3),(12,16,'0','100','B','21 ','40',3),(13,17,'0','100','B','2','10',3),(14,18,'0','100','B','1','6',3),(15,19,'0','100','B','0','1',3),(16,20,'0','100','B','140','440',3),(17,21,'0','100','B','0.5','2.5',3),(18,23,'0','100','B','35.0','52.0',3),(19,24,'0','100','B','0.0','270.0',3),(20,25,'0','100','B','0.0','40.0',3),(21,26,'0','100','B','0.0','40.0',3),(22,27,'0','100','B','0.0','10.4',3),(23,28,'0','100','B','5.0','21.0',1),(24,29,'0','100','B','60.0','83.0',3),(25,30,'0','100','B','0.0','55.0',3),(26,31,'0','100','B','5.71','6.20',3),(27,32,'0','100','B','0.3','1.82',3),(28,33,'0','100','B','1.03','1.55',3),(29,34,'0','100','B','0.0','3.9',3),(30,35,'0','100','B','0.0','4.0',3),(31,36,'0','100','B','71.0','115.0',3),(32,37,'0','100','B','2.10','7.10',3),(33,38,'0','100','B','3.5','5.1',3),(34,39,'0','100','B','135.5','145.0',3),(35,40,'0','100','B','98.0','107.0',3),(36,41,'0','100','B','0.0','25.0',3),(37,42,'0','100','B','0.0','171.0',3),(38,43,'0','100','B','235.0','470.0',3),(39,44,'0','100','B','208.0','428.0',3),(40,45,'0','100','B','2.15','2.57',3),(41,46,'0','100','B','0.0','90.0',3),(42,47,'0','100','B','4.1','6.1',3);
/*!40000 ALTER TABLE `reference_range` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `removal_record`
--

DROP TABLE IF EXISTS `removal_record`;
CREATE TABLE `removal_record` (
  `id` int(11) NOT NULL auto_increment,
  `r_id` int(11) NOT NULL default '0',
  `vr_id` varchar(45) collate latin1_general_ci NOT NULL default '0',
  `type` int(11) default NULL,
  `user_id` int(11) default '0',
  `remarks` varchar(500) collate latin1_general_ci default NULL,
  `status` int(11) NOT NULL default '1',
  `ts` timestamp NULL default CURRENT_TIMESTAMP,
  `category` varchar(20) collate latin1_general_ci default 'test',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `removal_record`
--

LOCK TABLES `removal_record` WRITE;
/*!40000 ALTER TABLE `removal_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `removal_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_config`
--

DROP TABLE IF EXISTS `report_config`;
CREATE TABLE `report_config` (
  `report_id` int(10) unsigned NOT NULL auto_increment,
  `header` varchar(500) NOT NULL default '',
  `footer` varchar(500) NOT NULL default '-End-',
  `margins` varchar(45) NOT NULL default '2,0,10,0',
  `p_fields` varchar(45) NOT NULL default '1,1,1,1,1,1,1',
  `s_fields` varchar(45) NOT NULL default '1,1,1,1,1,1',
  `t_fields` varchar(45) NOT NULL default '1,0,1,1,1,0,1,1',
  `p_custom_fields` varchar(45) NOT NULL default '',
  `s_custom_fields` varchar(45) NOT NULL default '',
  `test_type_id` varchar(45) NOT NULL default '0',
  `title` varchar(500) NOT NULL default '',
  `landscape` int(10) unsigned NOT NULL default '0',
  `row_items` int(1) unsigned NOT NULL default '3',
  `show_border` int(1) unsigned NOT NULL default '1',
  `show_result_border` int(1) unsigned NOT NULL default '1',
  `result_border_horizontal` int(1) unsigned NOT NULL default '0',
  `result_border_vertical` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report_config`
--

LOCK TABLES `report_config` WRITE;
/*!40000 ALTER TABLE `report_config` DISABLE KEYS */;
INSERT INTO `report_config` VALUES (1,'Patient Report??center','Validated by .................................................................. Date ............................................. Time ............................#','0,0,0,0','1,0,0,1,1,0,1,0,0,0,0,0,0','1,1,0,0,0,0,0','1,1,0,0,1,0,0,1,1,0','','','0','',0,4,1,1,1,1),(2,'Specimen Report','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,0,0),(3,'Test Records','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,0,0),(4,'Daily Log - Specimens','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,0,0),(5,'Worksheet','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,0,0),(6,'Daily Log - Patients','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,0,0),(7,'Grouped Test Count Report Configuration','0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+','0','1','1','1','1','0','9999009','0',9999009,3,1,1,0,0),(8,'Grouped Specimen Count Report Configuration','0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+','0','1','1','1','1','0','9999019','0',9999019,3,1,1,0,0),(9,'Worksheet - BF for MPS','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','1','',0,3,1,1,0,0),(10,'Worksheet - ESR','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','2','',0,3,1,1,0,0),(11,'Worksheet - Sickling ','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','3','',0,3,1,1,0,0);
/*!40000 ALTER TABLE `report_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_disease`
--

DROP TABLE IF EXISTS `report_disease`;
CREATE TABLE `report_disease` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_by_age` int(10) unsigned NOT NULL,
  `group_by_gender` int(10) unsigned NOT NULL,
  `age_groups` varchar(500) default NULL,
  `measure_groups` varchar(500) default NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `lab_config_id` int(10) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`id`),
  KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report_disease`
--

LOCK TABLES `report_disease` WRITE;
/*!40000 ALTER TABLE `report_disease` DISABLE KEYS */;
INSERT INTO `report_disease` VALUES (1,0,1,'','',0,12,0),(2,0,1,'','No MPS Seen/Positive',1,12,1),(3,0,1,'','$freetext$$',2,12,1),(4,0,1,'','Plasmodium falciparum/Plasmodium Ovale/Plasmodium malariae/Plasmodium vivax',3,12,1),(5,0,1,'','Trophozoites/Gametocytes/Schizonts',4,12,1),(6,0,1,'',':',5,12,2),(7,0,1,'','Negative/Positive',6,12,3);
/*!40000 ALTER TABLE `report_disease` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen`
--

DROP TABLE IF EXISTS `specimen`;
CREATE TABLE `specimen` (
  `specimen_id` int(10) unsigned NOT NULL default '0',
  `patient_id` int(11) unsigned NOT NULL default '0',
  `specimen_type_id` int(11) unsigned NOT NULL default '0',
  `user_id` int(11) unsigned default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `status_code_id` int(11) unsigned default NULL,
  `referred_to` int(11) unsigned default NULL,
  `comments` text,
  `aux_id` varchar(45) default NULL,
  `date_collected` date NOT NULL default '0000-00-00',
  `date_recvd` date default NULL,
  `session_num` varchar(45) default NULL,
  `time_collected` varchar(45) default NULL,
  `report_to` int(10) unsigned default NULL,
  `doctor` varchar(45) default NULL,
  `date_reported` datetime default NULL,
  `referred_to_name` varchar(70) default NULL,
  `daily_num` varchar(45) NOT NULL default '',
  `referred_from_name` varchar(20) default NULL,
  PRIMARY KEY  (`specimen_id`),
  KEY `patient_id` (`patient_id`),
  KEY `specimen_type_id` (`specimen_type_id`),
  KEY `user_id` (`user_id`),
  KEY `IDX_DATE` (`date_collected`),
  KEY `aux_ind` (`aux_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specimen`
--

LOCK TABLES `specimen` WRITE;
/*!40000 ALTER TABLE `specimen` DISABLE KEYS */;
INSERT INTO `specimen` VALUES (1,1,1,506,'2015-03-16 09:33:35',1,0,'','','2015-03-16','2015-03-16','20150316-1','09:24',1,'Gabby',NULL,'','20150316-2',''),(2,1,1,506,'2015-03-17 09:40:59',1,0,'','2015031701','2015-03-17','2015-03-17','20150317-1','09:39',1,'',NULL,'','20150317-1',''),(3,1,1,506,'2015-03-17 10:14:51',1,0,'','2015031702','2015-03-17','2015-03-17','20150317-2','10:13',1,'',NULL,'','20150317-2',''),(5,1,2,506,'2015-03-17 10:14:52',1,0,'','2015031702','2015-03-17','2015-03-17','20150317-2','10:13',1,'',NULL,'','20150317-2',''),(8,1,4,506,'2015-03-17 10:14:52',1,0,'','2015031702','2015-03-17','2015-03-17','20150317-2','10:14',1,'',NULL,'','20150317-2',''),(12,1,3,506,'2015-03-17 10:14:52',1,0,'','2015031702','2015-03-17','2015-03-17','20150317-2','10:14',1,'',NULL,'','20150317-2','');
/*!40000 ALTER TABLE `specimen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_custom_data`
--

DROP TABLE IF EXISTS `specimen_custom_data`;
CREATE TABLE `specimen_custom_data` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_id` int(11) unsigned NOT NULL default '0',
  `specimen_id` int(10) unsigned NOT NULL default '0',
  `field_value` varchar(45) NOT NULL default '',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_id` (`field_id`),
  KEY `specimen_id` (`specimen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specimen_custom_data`
--

LOCK TABLES `specimen_custom_data` WRITE;
/*!40000 ALTER TABLE `specimen_custom_data` DISABLE KEYS */;
INSERT INTO `specimen_custom_data` VALUES (1,1,2,'ANC','2015-03-17 09:40:59'),(2,1,3,'OPD','2015-03-17 10:14:51'),(3,1,5,'OPD','2015-03-17 10:14:52'),(4,1,8,'OPD','2015-03-17 10:14:52'),(5,1,12,'OPD','2015-03-17 10:14:52');
/*!40000 ALTER TABLE `specimen_custom_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_custom_field`
--

DROP TABLE IF EXISTS `specimen_custom_field`;
CREATE TABLE `specimen_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL default '',
  `field_options` text NOT NULL,
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `specimen_custom_field`
--

LOCK TABLES `specimen_custom_field` WRITE;
/*!40000 ALTER TABLE `specimen_custom_field` DISABLE KEYS */;
INSERT INTO `specimen_custom_field` VALUES (1,'Source','OPD/NICU/WARD A - Female Medical/WARD B - Pedics/WARD C - Male/WARD D - Ortho/WARD 1 - Gynae/WARD 2 - Gynae/WARD 3 - Female Surgical/WARD 4 - Male Surgical/ENT/Casulty/CDU/ANC/Labour Ward/Theatre',3,'2015-03-17 09:08:27');
/*!40000 ALTER TABLE `specimen_custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_session`
--

DROP TABLE IF EXISTS `specimen_session`;
CREATE TABLE `specimen_session` (
  `session_num` varchar(45) NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specimen_session`
--

LOCK TABLES `specimen_session` WRITE;
/*!40000 ALTER TABLE `specimen_session` DISABLE KEYS */;
INSERT INTO `specimen_session` VALUES ('20150316',1),('20150317',2);
/*!40000 ALTER TABLE `specimen_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_test`
--

DROP TABLE IF EXISTS `specimen_test`;
CREATE TABLE `specimen_test` (
  `test_type_id` int(11) unsigned NOT NULL default '0',
  `specimen_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  KEY `test_type_id` (`test_type_id`),
  KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relates tests to the specimens that are compatible with thos';

--
-- Dumping data for table `specimen_test`
--

LOCK TABLES `specimen_test` WRITE;
/*!40000 ALTER TABLE `specimen_test` DISABLE KEYS */;
INSERT INTO `specimen_test` VALUES (1,1,'2015-03-16 09:14:16'),(2,1,'2015-03-16 10:27:14'),(3,1,'2015-03-16 10:34:24'),(4,1,'2015-03-16 10:36:05'),(5,1,'2015-03-16 10:38:29'),(6,1,'2015-03-16 10:46:14'),(7,1,'2015-03-16 10:49:11'),(8,1,'2015-03-16 10:52:41'),(9,1,'2015-03-16 10:53:38'),(10,1,'2015-03-16 10:54:48'),(11,1,'2015-03-16 10:56:24'),(12,1,'2015-03-16 10:57:31'),(13,1,'2015-03-16 10:58:29'),(14,1,'2015-03-16 10:59:26'),(15,1,'2015-03-16 11:00:18'),(16,1,'2015-03-16 11:01:01'),(17,1,'2015-03-16 11:02:02'),(18,1,'2015-03-16 11:03:18'),(19,1,'2015-03-16 11:04:46'),(20,5,'2015-03-16 11:06:07'),(21,2,'2015-03-16 11:08:09'),(22,2,'2015-03-16 11:11:47'),(23,2,'2015-03-16 11:13:34'),(24,2,'2015-03-16 11:14:58'),(25,2,'2015-03-16 11:17:09'),(26,2,'2015-03-16 11:18:45'),(26,5,'2015-03-16 11:18:45'),(27,2,'2015-03-16 11:19:52'),(28,2,'2015-03-16 11:20:58'),(29,2,'2015-03-16 11:22:43'),(30,2,'2015-03-16 11:24:40'),(31,2,'2015-03-16 15:28:30'),(32,2,'2015-03-16 15:30:42'),(33,2,'2015-03-16 20:21:03'),(34,2,'2015-03-16 20:22:11'),(35,2,'2015-03-16 20:24:06'),(36,2,'2015-03-16 20:26:22'),(37,2,'2015-03-16 20:27:54'),(38,2,'2015-03-16 20:30:27'),(39,2,'2015-03-16 20:32:41'),(40,2,'2015-03-16 20:35:39'),(41,2,'2015-03-16 20:38:01'),(41,1,'2015-03-16 20:38:01'),(42,2,'2015-03-16 20:40:14'),(43,2,'2015-03-16 20:41:50'),(44,2,'2015-03-16 20:42:49'),(45,2,'2015-03-16 20:45:05'),(46,2,'2015-03-16 20:57:16'),(47,2,'2015-03-17 07:57:37'),(48,2,'2015-03-17 07:59:03'),(49,2,'2015-03-17 07:59:59'),(50,1,'2015-03-17 08:03:23'),(51,1,'2015-03-17 08:06:23'),(52,1,'2015-03-17 08:07:24'),(53,1,'2015-03-17 08:08:23'),(54,4,'2015-03-17 08:15:09'),(55,3,'2015-03-17 08:21:14'),(56,4,'2015-03-17 08:26:21'),(57,3,'2015-03-17 08:27:34'),(49,6,'2015-03-17 08:28:49');
/*!40000 ALTER TABLE `specimen_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_type`
--

DROP TABLE IF EXISTS `specimen_type`;
CREATE TABLE `specimen_type` (
  `specimen_type_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `description` varchar(100) default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `disabled` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specimen_type`
--

LOCK TABLES `specimen_type` WRITE;
/*!40000 ALTER TABLE `specimen_type` DISABLE KEYS */;
INSERT INTO `specimen_type` VALUES (1,'Whole Blood','','2015-03-16 09:05:55',0),(2,'Serum','','2015-03-16 10:23:02',0),(3,'Urine','','2015-03-16 10:23:15',0),(4,'Stool','','2015-03-16 10:23:28',0),(5,'Skin Snip','','2015-03-16 10:24:02',0),(6,'Plasma','','2015-03-17 08:28:49',0);
/*!40000 ALTER TABLE `specimen_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_content`
--

DROP TABLE IF EXISTS `stock_content`;
CREATE TABLE `stock_content` (
  `name` varchar(40) default NULL,
  `current_quantity` int(11) default NULL,
  `date_of_use` date NOT NULL,
  `receiver` varchar(40) default NULL,
  `remarks` text,
  `lot_number` varchar(40) default NULL,
  `new_balance` int(11) default NULL,
  `user_name` varchar(40) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_content`
--

LOCK TABLES `stock_content` WRITE;
/*!40000 ALTER TABLE `stock_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_details`
--

DROP TABLE IF EXISTS `stock_details`;
CREATE TABLE `stock_details` (
  `name` varchar(40) default NULL,
  `lot_number` varchar(40) default NULL,
  `expiry_date` varchar(40) default NULL,
  `manufacturer` varchar(40) default NULL,
  `quantity_ordered` int(11) default NULL,
  `supplier` varchar(40) default NULL,
  `date_of_reception` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `current_quantity` int(11) default NULL,
  `date_of_supply` timestamp NOT NULL default '0000-00-00 00:00:00',
  `quantity_supplied` int(11) default NULL,
  `unit` varchar(10) default NULL,
  `entry_id` int(11) default NULL,
  `cost_per_unit` decimal(10,0) default '0',
  `quantity_used` int(10) default '0',
  UNIQUE KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_details`
--

LOCK TABLES `stock_details` WRITE;
/*!40000 ALTER TABLE `stock_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `test_id` int(10) unsigned NOT NULL auto_increment,
  `test_type_id` int(11) unsigned NOT NULL default '0',
  `result` longtext,
  `comments` varchar(200) default NULL,
  `user_id` int(11) unsigned default NULL,
  `verified_by` int(11) unsigned default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `specimen_id` int(11) unsigned default NULL,
  `date_verified` datetime default NULL,
  PRIMARY KEY  (`test_id`),
  KEY `test_type_id` (`test_type_id`),
  KEY `user_id` (`user_id`),
  KEY `specimen_id` (`specimen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` VALUES (1,1,'No MPS Seen,[$]4545[/$],Plasmodium falciparum,Trophozoites,,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-16 00:00:00',1,NULL),(2,19,'12,5,5,5,5,5,5,5,5,5,5,5,5,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',2,NULL),(3,53,'O Rh \"D\" Negative,7449f27f17079db192727d4e0ad353c522b84491','-',506,0,'2015-03-17 00:00:00',3,NULL),(4,4,'Partial Defect,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',3,NULL),(5,50,'Negative,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',3,NULL),(6,3,'Negative,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',3,NULL),(7,51,'1 / 160,1 / 40,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',3,NULL),(8,41,'22,22,22,22,22,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',5,NULL),(9,35,'77,77,7,7,7,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',5,NULL),(10,29,'30,100,30,30,7,100,100,10,7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',5,NULL),(11,54,'Semi - formed,Nil,Few,[$]YES[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',8,NULL),(12,55,'[$]RED[/$],[$]CLOUDY[/$],[$]YES[/$],[$]23[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],[$]1[/$],[$]1[/$],[$]1[/$],[$]1[/$],[$]YES[/$],[$]YES[/$],[$]YES[/$],7449f27f17079db192727d4e0ad353c522b84491','',506,0,'2015-03-17 00:00:00',12,NULL);
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_category`
--

DROP TABLE IF EXISTS `test_category`;
CREATE TABLE `test_category` (
  `test_category_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `description` varchar(100) default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_category`
--

LOCK TABLES `test_category` WRITE;
/*!40000 ALTER TABLE `test_category` DISABLE KEYS */;
INSERT INTO `test_category` VALUES (1,'HIV',NULL,'2015-03-16 08:31:36'),(2,'Haematology','','2015-03-16 09:14:16'),(3,'Parasitology','','2015-03-16 11:06:07'),(4,'Clinical Chemistry','','2015-03-16 11:08:09'),(5,'Miscellaneous','','2015-03-17 08:03:23');
/*!40000 ALTER TABLE `test_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_type`
--

DROP TABLE IF EXISTS `test_type`;
CREATE TABLE `test_type` (
  `test_type_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `description` varchar(100) default NULL,
  `test_category_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `is_panel` int(10) unsigned default NULL,
  `disabled` int(10) unsigned NOT NULL default '0',
  `clinical_data` longtext,
  `hide_patient_name` int(1) default NULL,
  `prevalence_threshold` int(3) default '70',
  `target_tat` int(3) default '24',
  PRIMARY KEY  (`test_type_id`),
  KEY `test_category_id` (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_type`
--

LOCK TABLES `test_type` WRITE;
/*!40000 ALTER TABLE `test_type` DISABLE KEYS */;
INSERT INTO `test_type` VALUES (1,'BF for MPS','',2,'2015-03-17 10:08:32',0,0,'',0,70,1),(2,'ESR','',2,'2015-03-17 08:36:04',0,0,NULL,0,70,2),(3,'Sickling ','',2,'2015-03-17 08:36:04',0,0,NULL,0,70,3),(4,'G6PD','',2,'2015-03-16 10:36:05',0,0,NULL,0,70,24),(5,'Hb Electrophoresis','',2,'2015-03-16 10:38:29',0,0,NULL,0,70,24),(6,'HB','',2,'2015-03-16 10:46:14',0,0,NULL,0,70,24),(7,'HCT','',2,'2015-03-16 10:49:11',0,0,NULL,0,70,24),(8,'RBC','',2,'2015-03-16 10:52:41',0,0,NULL,0,70,24),(9,'MCV','',2,'2015-03-16 10:53:38',0,0,NULL,0,70,24),(10,'MCH','',2,'2015-03-16 10:54:47',0,0,NULL,0,70,24),(11,'WBC','',2,'2015-03-16 10:56:24',0,0,NULL,0,70,24),(12,'Neutrophils','',2,'2015-03-16 10:57:31',0,0,NULL,0,70,24),(13,'Lymphocytes','',2,'2015-03-16 10:58:29',0,0,NULL,0,70,24),(14,'Monocytes','',2,'2015-03-16 10:59:25',0,0,NULL,0,70,24),(15,'Eosinophil','',2,'2015-03-16 11:00:18',0,0,NULL,0,70,24),(16,'Basophil','',2,'2015-03-16 11:01:01',0,0,NULL,0,70,24),(17,'Platelets','',2,'2015-03-16 11:02:02',0,0,NULL,0,70,24),(18,'Reticolcytes','',2,'2015-03-16 11:03:18',0,0,NULL,0,70,24),(19,'FBC','',2,'2015-03-16 11:04:46',1,0,NULL,0,70,24),(20,'Skin Snip Test','',3,'2015-03-16 11:06:07',0,0,NULL,0,70,24),(21,'Albumin','',4,'2015-03-16 11:08:09',0,0,NULL,0,70,24),(22,'ALP / DEA','',4,'2015-03-16 11:11:47',0,0,NULL,0,70,24),(23,'ALT / GPT','',4,'2015-03-16 11:13:34',0,0,NULL,0,70,24),(24,'AST / GOT','',4,'2015-03-16 11:14:58',0,0,NULL,0,70,24),(25,'Bilirubin Direct','',4,'2015-03-16 11:17:09',0,0,NULL,0,70,24),(26,'Bilirubin Total','',4,'2015-03-16 11:18:45',0,0,NULL,0,70,24),(27,'Total Protein','',4,'2015-03-16 11:19:52',0,0,NULL,0,70,24),(28,'Gamma GT','',4,'2015-03-16 11:20:58',0,0,NULL,0,70,24),(29,'Liver Function Tests','',4,'2015-03-16 11:22:43',1,0,NULL,0,70,24),(30,'Cholesterol','',4,'2015-03-16 11:24:40',0,0,NULL,0,70,24),(31,'Triglycerides','',4,'2015-03-16 15:28:29',0,0,NULL,0,70,24),(32,'HDL - Cholesterol','',4,'2015-03-16 15:30:42',0,0,NULL,0,70,24),(33,'LDL - Cholesterol','',4,'2015-03-16 20:21:03',0,0,NULL,0,70,24),(34,'Coronary Risk','',4,'2015-03-16 20:22:11',0,0,NULL,0,70,24),(35,'Lipid Profile','',4,'2015-03-16 20:24:06',1,0,NULL,0,70,24),(36,'Creatine ','',4,'2015-03-16 20:26:22',0,0,NULL,0,70,24),(37,'Urea','',4,'2015-03-16 20:27:54',0,0,NULL,0,70,24),(38,'Potassium','',4,'2015-03-16 20:30:27',0,0,NULL,0,70,24),(39,'Sodium','',4,'2015-03-16 20:32:41',0,0,NULL,0,70,24),(40,'Chloride','',4,'2015-03-16 20:35:39',0,0,NULL,0,70,24),(41,'Kidney Function Test','',4,'2015-03-16 20:38:01',1,0,NULL,0,70,24),(42,'CK - MB','',4,'2015-03-16 20:40:14',0,0,NULL,0,70,24),(43,'CK - NAC','',4,'2015-03-16 20:41:50',0,0,NULL,0,70,24),(44,'LDH','',4,'2015-03-16 20:42:49',0,0,NULL,0,70,24),(45,'Cardiac Profile','',4,'2015-03-16 20:45:05',1,0,NULL,0,70,24),(46,'Uric Acid','',4,'2015-03-16 20:57:16',0,0,NULL,0,70,24),(47,'Calcium','',4,'2015-03-17 07:57:37',0,0,NULL,0,70,24),(48,'Amylase','',4,'2015-03-17 07:59:03',0,0,NULL,0,70,24),(49,'Glucose','',4,'2015-03-17 07:59:59',0,0,NULL,0,70,24),(50,'Pregnancy Test','',5,'2015-03-17 08:03:23',0,0,NULL,0,70,24),(51,'Widal Test','',5,'2015-03-17 09:35:55',0,0,'',0,70,24),(52,'Rheumatiod Factor','',5,'2015-03-17 08:07:24',0,0,NULL,0,70,24),(53,'Blood Grouping','',5,'2015-03-17 09:23:42',0,0,'',0,70,24),(54,'Stool R/E','',3,'2015-03-17 08:15:09',0,0,NULL,0,70,24),(55,'Urine R/E','',3,'2015-03-17 08:21:14',0,0,NULL,0,70,24),(56,'Occult Blood','',3,'2015-03-17 08:26:21',0,0,NULL,0,70,24),(57,'24hrs Urine Protein','',4,'2015-03-17 08:27:34',0,0,NULL,0,70,24);
/*!40000 ALTER TABLE `test_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_type_costs`
--

DROP TABLE IF EXISTS `test_type_costs`;
CREATE TABLE `test_type_costs` (
  `earliest_date_valid` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `test_type_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL default '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `test_type_costs`
--

LOCK TABLES `test_type_costs` WRITE;
/*!40000 ALTER TABLE `test_type_costs` DISABLE KEYS */;
INSERT INTO `test_type_costs` VALUES ('2015-03-16 09:14:18',1,'0.00'),('2015-03-16 10:27:15',2,'0.00'),('2015-03-16 10:34:24',3,'0.00'),('2015-03-16 10:36:06',4,'0.00'),('2015-03-16 10:38:30',5,'0.00'),('2015-03-16 10:46:15',6,'0.00'),('2015-03-16 10:49:12',7,'0.00'),('2015-03-16 10:52:42',8,'0.00'),('2015-03-16 10:53:39',9,'0.00'),('2015-03-16 10:54:48',10,'0.00'),('2015-03-16 10:56:24',11,'0.00'),('2015-03-16 10:57:32',12,'0.00'),('2015-03-16 10:58:30',13,'0.00'),('2015-03-16 10:59:26',14,'0.00'),('2015-03-16 11:00:19',15,'0.00'),('2015-03-16 11:01:02',16,'0.00'),('2015-03-16 11:02:03',17,'0.00'),('2015-03-16 11:03:18',18,'0.00'),('2015-03-16 11:04:48',19,'0.00'),('2015-03-16 11:06:08',20,'0.00'),('2015-03-16 11:08:10',21,'0.00'),('2015-03-16 11:11:48',22,'0.00'),('2015-03-16 11:13:35',23,'0.00'),('2015-03-16 11:14:59',24,'0.00'),('2015-03-16 11:17:09',25,'0.00'),('2015-03-16 11:18:46',26,'0.00'),('2015-03-16 11:19:53',27,'0.00'),('2015-03-16 11:20:59',28,'0.00'),('2015-03-16 11:22:44',29,'0.00'),('2015-03-16 11:24:41',30,'0.00'),('2015-03-16 15:28:31',31,'0.00'),('2015-03-16 15:30:42',32,'0.00'),('2015-03-16 20:21:04',33,'0.00'),('2015-03-16 20:22:12',34,'0.00'),('2015-03-16 20:24:07',35,'0.00'),('2015-03-16 20:26:23',36,'0.00'),('2015-03-16 20:27:55',37,'0.00'),('2015-03-16 20:30:28',38,'0.00'),('2015-03-16 20:32:41',39,'0.00'),('2015-03-16 20:35:39',40,'0.00'),('2015-03-16 20:38:02',41,'0.00'),('2015-03-16 20:40:15',42,'0.00'),('2015-03-16 20:41:51',43,'0.00'),('2015-03-16 20:42:50',44,'0.00'),('2015-03-16 20:45:06',45,'0.00'),('2015-03-16 20:57:17',46,'0.00'),('2015-03-17 07:57:38',47,'0.00'),('2015-03-17 07:59:03',48,'0.00'),('2015-03-17 08:00:00',49,'0.00'),('2015-03-17 08:03:24',50,'0.00'),('2015-03-17 08:06:24',51,'0.00'),('2015-03-17 08:07:25',52,'0.00'),('2015-03-17 08:08:24',53,'0.00'),('2015-03-17 08:15:10',54,'0.00'),('2015-03-17 08:21:16',55,'0.00'),('2015-03-17 08:26:22',56,'0.00'),('2015-03-17 08:27:34',57,'0.00');
/*!40000 ALTER TABLE `test_type_costs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_type_measure`
--

DROP TABLE IF EXISTS `test_type_measure`;
CREATE TABLE `test_type_measure` (
  `test_type_id` int(11) unsigned NOT NULL default '0',
  `measure_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  KEY `test_type_id` (`test_type_id`),
  KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_type_measure`
--

LOCK TABLES `test_type_measure` WRITE;
/*!40000 ALTER TABLE `test_type_measure` DISABLE KEYS */;
INSERT INTO `test_type_measure` VALUES (1,1,'2015-03-16 09:14:17'),(1,2,'2015-03-16 09:14:17'),(1,3,'2015-03-16 09:14:17'),(1,4,'2015-03-16 09:14:17'),(2,5,'2015-03-16 10:27:14'),(3,6,'2015-03-16 10:34:24'),(4,7,'2015-03-16 10:36:05'),(5,8,'2015-03-16 10:38:29'),(6,9,'2015-03-16 10:46:14'),(7,10,'2015-03-16 10:49:11'),(8,11,'2015-03-16 10:52:41'),(9,12,'2015-03-16 10:53:38'),(10,13,'2015-03-16 10:54:48'),(11,14,'2015-03-16 10:56:24'),(12,15,'2015-03-16 10:57:32'),(13,16,'2015-03-16 10:58:29'),(14,17,'2015-03-16 10:59:26'),(15,18,'2015-03-16 11:00:18'),(16,19,'2015-03-16 11:01:01'),(17,20,'2015-03-16 11:02:02'),(18,21,'2015-03-16 11:03:18'),(19,9,'2015-03-16 11:04:46'),(19,10,'2015-03-16 11:04:46'),(19,11,'2015-03-16 11:04:46'),(19,12,'2015-03-16 11:04:46'),(19,13,'2015-03-16 11:04:46'),(19,14,'2015-03-16 11:04:46'),(19,15,'2015-03-16 11:04:46'),(19,16,'2015-03-16 11:04:47'),(19,17,'2015-03-16 11:04:47'),(19,18,'2015-03-16 11:04:47'),(19,19,'2015-03-16 11:04:47'),(19,20,'2015-03-16 11:04:47'),(19,21,'2015-03-16 11:04:47'),(20,22,'2015-03-16 11:06:07'),(21,23,'2015-03-16 11:08:09'),(22,24,'2015-03-16 11:11:47'),(23,25,'2015-03-16 11:13:34'),(24,26,'2015-03-16 11:14:58'),(25,27,'2015-03-16 11:17:09'),(26,28,'2015-03-16 11:18:46'),(27,29,'2015-03-16 11:19:53'),(28,30,'2015-03-16 11:20:58'),(29,23,'2015-03-16 11:22:43'),(29,24,'2015-03-16 11:22:43'),(29,25,'2015-03-16 11:22:43'),(29,26,'2015-03-16 11:22:43'),(29,27,'2015-03-16 11:22:43'),(29,28,'2015-03-16 11:22:43'),(29,29,'2015-03-16 11:22:43'),(29,30,'2015-03-16 11:22:43'),(30,31,'2015-03-16 11:24:41'),(31,32,'2015-03-16 15:28:30'),(32,33,'2015-03-16 15:30:42'),(33,34,'2015-03-16 20:21:03'),(34,35,'2015-03-16 20:22:11'),(35,31,'2015-03-16 20:24:07'),(35,32,'2015-03-16 20:24:07'),(35,33,'2015-03-16 20:24:07'),(35,34,'2015-03-16 20:24:07'),(35,35,'2015-03-16 20:24:07'),(36,36,'2015-03-16 20:26:22'),(37,37,'2015-03-16 20:27:55'),(38,38,'2015-03-16 20:30:28'),(39,39,'2015-03-16 20:32:41'),(40,40,'2015-03-16 20:35:39'),(41,36,'2015-03-16 20:38:01'),(41,37,'2015-03-16 20:38:01'),(41,38,'2015-03-16 20:38:02'),(41,39,'2015-03-16 20:38:02'),(41,40,'2015-03-16 20:38:02'),(42,41,'2015-03-16 20:40:14'),(43,42,'2015-03-16 20:41:50'),(44,43,'2015-03-16 20:42:49'),(45,41,'2015-03-16 20:45:05'),(45,42,'2015-03-16 20:45:05'),(45,43,'2015-03-16 20:45:05'),(46,44,'2015-03-16 20:57:16'),(47,45,'2015-03-17 07:57:37'),(48,46,'2015-03-17 07:59:03'),(49,47,'2015-03-17 07:59:59'),(50,48,'2015-03-17 08:03:23'),(51,49,'2015-03-17 08:06:23'),(51,50,'2015-03-17 08:06:23'),(52,51,'2015-03-17 08:07:24'),(53,52,'2015-03-17 08:08:23'),(54,53,'2015-03-17 08:15:09'),(54,54,'2015-03-17 08:15:09'),(54,55,'2015-03-17 08:15:09'),(54,56,'2015-03-17 08:15:09'),(54,57,'2015-03-17 08:15:09'),(54,58,'2015-03-17 08:15:09'),(54,59,'2015-03-17 08:15:09'),(54,60,'2015-03-17 08:15:09'),(55,61,'2015-03-17 08:21:14'),(55,62,'2015-03-17 08:21:15'),(55,63,'2015-03-17 08:21:15'),(55,64,'2015-03-17 08:21:15'),(55,65,'2015-03-17 08:21:15'),(55,66,'2015-03-17 08:21:15'),(55,67,'2015-03-17 08:21:15'),(55,68,'2015-03-17 08:21:15'),(55,69,'2015-03-17 08:21:15'),(55,70,'2015-03-17 08:21:15'),(55,71,'2015-03-17 08:21:15'),(55,72,'2015-03-17 08:21:15'),(55,73,'2015-03-17 08:21:15'),(55,74,'2015-03-17 08:21:15'),(55,75,'2015-03-17 08:21:15'),(55,76,'2015-03-17 08:21:15'),(55,77,'2015-03-17 08:21:15'),(55,78,'2015-03-17 08:21:15'),(55,79,'2015-03-17 08:21:15'),(56,80,'2015-03-17 08:26:21'),(57,81,'2015-03-17 08:27:34');
/*!40000 ALTER TABLE `test_type_measure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `unit_id` int(11) unsigned NOT NULL auto_increment,
  `unit` varchar(45) NOT NULL default '',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL default '',
  `password` varchar(45) NOT NULL default '',
  `actualname` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `created_by` int(11) unsigned default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `lab_config_id` int(10) unsigned NOT NULL,
  `level` int(10) unsigned default NULL,
  `phone` varchar(45) default NULL,
  `lang_id` varchar(45) NOT NULL default 'default',
  PRIMARY KEY  (`user_id`),
  KEY `user_id_index` USING BTREE (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Users are anybody that works in the lab.';

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_feedback`
--

DROP TABLE IF EXISTS `user_feedback`;
CREATE TABLE `user_feedback` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `rating` int(3) default NULL,
  `comments` varchar(500) collate latin1_general_ci default NULL,
  `ts` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user_feedback`
--

LOCK TABLES `user_feedback` WRITE;
/*!40000 ALTER TABLE `user_feedback` DISABLE KEYS */;
INSERT INTO `user_feedback` VALUES (1,506,6,'','2015-03-16 08:47:31'),(2,506,6,'','2015-03-16 09:46:14'),(3,506,6,'','2015-03-16 11:44:56'),(4,506,6,'','2015-03-17 08:48:00'),(5,506,6,'','2015-03-18 08:47:21'),(6,506,6,'','2015-03-18 09:19:37');
/*!40000 ALTER TABLE `user_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_props`
--

DROP TABLE IF EXISTS `user_props`;
CREATE TABLE `user_props` (
  `User_Id` varchar(50) NOT NULL default '',
  `AppCodeName` varchar(25) NOT NULL default '',
  `AppName` varchar(25) NOT NULL default '',
  `AppVersion` varchar(25) NOT NULL default '',
  `CookieEnabled` tinyint(1) NOT NULL default '0',
  `Platform` varchar(20) NOT NULL default '',
  `UserAgent` varchar(200) NOT NULL default '',
  `SystemLanguage` varchar(15) NOT NULL default '',
  `UserLanguage` varchar(15) NOT NULL default '',
  `Language` varchar(15) NOT NULL default '',
  `ScreenAvailHeight` int(11) NOT NULL default '0',
  `ScreenAvailWidth` int(11) NOT NULL default '0',
  `ScreenColorDepth` int(11) NOT NULL default '0',
  `ScreenHeight` int(11) NOT NULL default '0',
  `ScreenWidth` int(11) NOT NULL default '0',
  `Recorded_At` datetime NOT NULL default '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_props`
--

LOCK TABLES `user_props` WRITE;
/*!40000 ALTER TABLE `user_props` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_props` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_rating`
--

DROP TABLE IF EXISTS `user_rating`;
CREATE TABLE `user_rating` (
  `user_id` int(10) unsigned NOT NULL,
  `rating` int(10) unsigned NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`user_id`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_rating`
--

LOCK TABLES `user_rating` WRITE;
/*!40000 ALTER TABLE `user_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `worksheet_custom`
--

DROP TABLE IF EXISTS `worksheet_custom`;
CREATE TABLE `worksheet_custom` (
  `id` int(10) unsigned NOT NULL auto_increment,
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
  `id_fields` varchar(45) NOT NULL default '0,0,0',
  `landscape` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worksheet_custom`
--

LOCK TABLES `worksheet_custom` WRITE;
/*!40000 ALTER TABLE `worksheet_custom` DISABLE KEYS */;
/*!40000 ALTER TABLE `worksheet_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `worksheet_custom_test`
--

DROP TABLE IF EXISTS `worksheet_custom_test`;
CREATE TABLE `worksheet_custom_test` (
  `worksheet_id` int(10) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `width` varchar(45) NOT NULL,
  KEY `worksheet_id` (`worksheet_id`),
  KEY `test_type_id` (`test_type_id`),
  KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worksheet_custom_test`
--

LOCK TABLES `worksheet_custom_test` WRITE;
/*!40000 ALTER TABLE `worksheet_custom_test` DISABLE KEYS */;
/*!40000 ALTER TABLE `worksheet_custom_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `worksheet_custom_userfield`
--

DROP TABLE IF EXISTS `worksheet_custom_userfield`;
CREATE TABLE `worksheet_custom_userfield` (
  `worksheet_id` int(10) unsigned NOT NULL,
  `name` varchar(70) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '10',
  `field_id` int(10) unsigned NOT NULL auto_increment,
  KEY `Primary Key` (`field_id`),
  KEY `worksheet_id` (`worksheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worksheet_custom_userfield`
--

LOCK TABLES `worksheet_custom_userfield` WRITE;
/*!40000 ALTER TABLE `worksheet_custom_userfield` DISABLE KEYS */;
/*!40000 ALTER TABLE `worksheet_custom_userfield` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-01 16:50:55
