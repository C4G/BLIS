-- MySQL dump 10.11
--
-- Host: localhost    Database: blis_1005
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
-- Current Database: `blis_1005`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `blis_1005` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;

USE `blis_1005`;

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
INSERT INTO `bills` VALUES (1,1,'\0');
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
INSERT INTO `bills_test_association` VALUES (1,1,1,1000,'0.00'),(2,1,2,1000,'0.00');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency_conversion`
--

LOCK TABLES `currency_conversion` WRITE;
/*!40000 ALTER TABLE `currency_conversion` DISABLE KEYS */;
INSERT INTO `currency_conversion` VALUES ('GHS','GHS',1.00,'2013-11-11 14:07:02',1,NULL,NULL,NULL);
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
-- Table structure for table `field_order`
--

DROP TABLE IF EXISTS `field_order`;
CREATE TABLE `field_order` (
  `id` int(11) NOT NULL auto_increment,
  `lab_config_id` int(11) unsigned default NULL,
  `form_id` int(11) default NULL,
  `field_order` varchar(2000) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `field_order`
--

LOCK TABLES `field_order` WRITE;
/*!40000 ALTER TABLE `field_order` DISABLE KEYS */;
INSERT INTO `field_order` VALUES (22,1005,1,'Patient ID,Daily Number,Patient Name,Sex,Date of Birth,Age,Phone Number,Email'),(20,1005,2,'Specimen ID,Comments,Lab Reciept Date,Referred Out,Physician');
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
INSERT INTO `lab_config_settings` VALUES (1,0,3,30,11,'code39',NULL,NULL,NULL,NULL,'Barcode Settings','2013-11-07 11:48:01'),(2,20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Search Settings','2013-11-07 11:48:00'),(3,1,NULL,NULL,NULL,'GHS','.',NULL,NULL,NULL,'Billing Settings','2013-11-11 13:55:22');
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
INSERT INTO `lab_config_test_type` VALUES (1005,1),(1005,2);
/*!40000 ALTER TABLE `lab_config_test_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labtitle_custom_field`
--

DROP TABLE IF EXISTS `labtitle_custom_field`;
CREATE TABLE `labtitle_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL,
  `field_options` varchar(200) NOT NULL,
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
INSERT INTO `measure` VALUES (1,'Blood 1',NULL,':',NULL,'2013-11-12 09:04:34',''),(2,'BF1',NULL,'NP1_NOP_NO1_NOO1',NULL,'2013-12-18 10:16:28',''),(3,'DG',NULL,'NN1_LKO_OPU',NULL,'2013-12-18 10:16:29','');
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
INSERT INTO `patient` VALUES (1,'','Kwamena Ahoi','M','0','1985-07-04',505,'2013-11-12 00:00:00','','P12345','e15b27b1f6755ca9f042b04df474a9b80b9a0398'),(2,'undefined','Pname Nice','M','0','2014-01-08',505,'2014-01-08 00:00:00',NULL,'P123455','0316e4f654a1514037297089a98bc209c3992e1c'),(3,'undefined','Dddffd','M','0','2014-01-08',505,'2014-01-08 00:00:00',NULL,'43343443','f9324d875dc85d2c48515f633da9d957580638c5'),(4,'undefined','Kghgh','M','0',NULL,505,'2014-01-08 00:00:00','2011-01-08','P1234555-1','aa6b6fba1e4264a9efa94570f2697d0c5d040d6c'),(5,'undefined','Emmanuel Otu','M','0','2014-01-13',559,'2014-01-13 00:00:00',NULL,'P12345-878','2bdbe9afd944d00a3afeb6a61f4ef15ab9f36dd9');
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
INSERT INTO `patient_custom_data` VALUES (1,1,5,'otu@yahoo.com','2014-01-13 10:12:42'),(2,2,5,'024791258','2014-01-13 10:12:42');
/*!40000 ALTER TABLE `patient_custom_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_custom_field`
--

DROP TABLE IF EXISTS `patient_custom_field`;
CREATE TABLE `patient_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL default '',
  `field_options` varchar(45) NOT NULL default '',
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_custom_field`
--

LOCK TABLES `patient_custom_field` WRITE;
/*!40000 ALTER TABLE `patient_custom_field` DISABLE KEYS */;
INSERT INTO `patient_custom_field` VALUES (1,'Email','',1,'2013-11-27 10:13:11'),(2,'Phone Number','',1,'2013-11-27 10:13:31');
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
INSERT INTO `patient_daily` VALUES ('20131111',1),('20131112',3),('20131115',20),('20131117',38),('20131118',4),('20131127',88),('20131129',1),('20131218',1),('20140108',137),('20140113',8);
/*!40000 ALTER TABLE `patient_daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_report_fields_order`
--

DROP TABLE IF EXISTS `patient_report_fields_order`;
CREATE TABLE `patient_report_fields_order` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `p_fields` varchar(500) collate latin1_general_ci NOT NULL,
  `o_fields` varchar(500) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `patient_report_fields_order`
--

LOCK TABLES `patient_report_fields_order` WRITE;
/*!40000 ALTER TABLE `patient_report_fields_order` DISABLE KEYS */;
INSERT INTO `patient_report_fields_order` VALUES (1,'','p_field_0,p_field_1,p_field_6,p_field_4,p_field_3,p_field_2,p_field_7,p_custom_1,p_custom_2,p_field_5,p_field_10,p_field_9,p_field_8');
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
  PRIMARY KEY  (`id`),
  KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reference_range`
--

LOCK TABLES `reference_range` WRITE;
/*!40000 ALTER TABLE `reference_range` DISABLE KEYS */;
INSERT INTO `reference_range` VALUES (1,1,'0','100','B','1','5');
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
  `row_items` int(10) unsigned NOT NULL default '3',
  `show_border` int(10) unsigned NOT NULL default '1',
  `show_result_border` int(10) unsigned NOT NULL default '1',
  `result_border_horizontal` int(10) unsigned NOT NULL default '0',
  `result_border_vertical` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report_config`
--

LOCK TABLES `report_config` WRITE;
/*!40000 ALTER TABLE `report_config` DISABLE KEYS */;
INSERT INTO `report_config` VALUES (1,'Patient Report??left','#','2,0,0,0','1,1,0,1,1,0,1,0,1,0,0,0,0','1,1,1,1,1,1,0','1,1,1,1,1,0,1,1,1,0','1,2','','0','',0,4,1,0,1,1),(2,'Specimen Report','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,1,1),(3,'Test Records','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,1,1),(4,'Daily Log - Specimens??left','#','2,0,10,0','1,1,1,1,1,1,1,0,0,0,0','1,1,1,1,1,1,0','1,0,1,1,1,0,1,1,0,0','','','0','',0,2,0,1,1,1),(5,'Worksheet','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,1,1),(6,'Daily Log - Patients??left','#','2,0,10,0','1,1,1,1,1,1,1,0,0,0,0','1,1,1,1,1,1,0','1,0,1,1,1,0,1,1,0,0','','','0','',0,3,1,1,1,1),(7,'Grouped Test Count Report Configuration','0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+','0','1','1','1','1','0','9999009','0',9999009,3,1,1,1,1),(8,'Grouped Specimen Count Report Configuration','0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+','0','1','1','1','1','0','9999019','0',9999019,3,1,1,1,1);
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
  KEY `IDX_DATE` (`date_collected`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specimen`
--

LOCK TABLES `specimen` WRITE;
/*!40000 ALTER TABLE `specimen` DISABLE KEYS */;
INSERT INTO `specimen` VALUES (1,1,1,505,'2013-11-12 15:38:26',1,0,'','','2013-11-12','2013-11-12','20131112-1','15:32',1,'',NULL,'','20131112-1',NULL),(2,1,1,508,'2013-11-18 09:57:54',1,0,'','','2013-11-18','2013-11-18','20131118-4','09:56',1,'jhgs',NULL,'','20131118-4',NULL),(3,1,1,505,'2013-12-18 10:19:56',1,0,'','','2013-12-18','2013-12-18','20131218-1','10:19',1,'',NULL,'','20131218-1','');
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
/*!40000 ALTER TABLE `specimen_custom_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_custom_field`
--

DROP TABLE IF EXISTS `specimen_custom_field`;
CREATE TABLE `specimen_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL default '',
  `field_options` varchar(45) NOT NULL default '',
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specimen_custom_field`
--

LOCK TABLES `specimen_custom_field` WRITE;
/*!40000 ALTER TABLE `specimen_custom_field` DISABLE KEYS */;
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
INSERT INTO `specimen_session` VALUES ('20131111',1),('20131112',3),('20131115',20),('20131117',38),('20131118',4),('20131127',88),('20131129',1),('20131218',1),('20140108',69),('20140113',4);
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
INSERT INTO `specimen_test` VALUES (1,1,'2013-11-12 09:04:35'),(2,1,'2013-12-18 10:16:29');
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
INSERT INTO `specimen_type` VALUES (1,'Blood','','2013-11-11 12:04:30',0);
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
  `result` varchar(201) default NULL,
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
INSERT INTO `test` VALUES (1,1,'3,,e15b27b1f6755ca9f042b04df474a9b80b9a0398','',505,505,'2013-11-18 00:00:00',1,'2013-11-18 09:53:14'),(2,1,',e15b27b1f6755ca9f042b04df474a9b80b9a0398','',505,505,'2013-12-03 10:15:06',2,'2013-12-03 10:15:43'),(3,2,'NP1_NP1_NP1,NN1_NN1_NN1,##POPQ_POPQ_POPQ,,e15b27b1f6755ca9f042b04df474a9b80b9a0398','',505,0,'2013-12-18 00:00:00',3,NULL);
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
INSERT INTO `test_category` VALUES (1,'Basic Tests','','2013-11-12 09:04:34');
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
INSERT INTO `test_type` VALUES (1,'Maleria','',1,'2013-11-12 09:04:34',0,0,NULL,0,70,24),(2,'BF','',1,'2014-01-09 15:51:47',0,0,'',0,70,24);
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
INSERT INTO `test_type_costs` VALUES ('2013-11-12 09:04:35',1,'10.00'),('2013-12-18 10:16:29',2,'0.00');
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
INSERT INTO `test_type_measure` VALUES (1,1,'2013-11-12 09:04:35'),(2,2,'2013-12-18 10:16:29'),(2,3,'2013-12-18 10:16:29');
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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user_feedback`
--

LOCK TABLES `user_feedback` WRITE;
/*!40000 ALTER TABLE `user_feedback` DISABLE KEYS */;
INSERT INTO `user_feedback` VALUES (1,505,6,'','2013-11-07 11:51:07'),(2,505,6,'','2013-11-11 12:02:20'),(3,505,6,'','2013-11-11 13:30:01'),(4,505,6,'','2013-11-12 15:39:05'),(5,505,6,'','2013-11-15 13:41:49'),(6,505,6,'','2013-11-15 14:01:33'),(7,505,6,'','2013-11-15 14:10:52'),(8,505,6,'','2013-11-15 14:32:36'),(9,505,6,'','2013-11-15 15:33:27'),(10,505,6,'','2013-11-15 15:38:28'),(11,508,6,'','2013-11-15 15:40:03'),(12,505,6,'','2013-11-17 11:36:32'),(13,505,6,'','2013-11-17 12:12:39'),(14,505,6,'','2013-11-17 12:14:59'),(15,505,6,'','2013-11-17 12:20:05'),(16,505,6,'','2013-11-18 09:55:24'),(17,508,6,'','2013-11-18 10:42:37'),(18,505,6,'','2013-11-20 08:54:57'),(19,505,6,'','2013-11-20 17:33:25'),(20,505,6,'','2013-11-27 09:24:16'),(21,505,6,'','2013-11-27 09:24:46'),(22,505,6,'','2013-11-29 11:13:27'),(23,505,6,'','2013-11-29 15:32:30'),(24,505,6,'','2013-11-29 15:54:16'),(25,505,6,'','2013-11-30 16:55:35'),(26,505,6,'','2013-12-05 15:11:42'),(27,505,6,'','2013-12-17 09:42:22'),(28,505,6,'','2013-12-19 11:05:20'),(29,505,6,'','2014-01-08 16:23:41'),(30,505,6,'','2014-01-10 09:55:18'),(31,559,6,'','2014-01-10 12:16:38'),(32,559,6,'','2014-01-10 16:06:36'),(33,559,6,'','2014-01-13 09:18:35'),(34,559,6,'','2014-01-13 10:29:34'),(35,559,6,'','2014-01-13 10:53:36'),(36,559,6,'','2014-01-13 11:50:51'),(37,559,6,'','2014-01-13 13:40:00');
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

-- Dump completed on 2014-01-13 14:45:47
