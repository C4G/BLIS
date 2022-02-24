-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: blis_12
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

CREATE DATABASE IF NOT EXISTS blis_12;
USE blis_12;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `patient_id` int(11) unsigned NOT NULL,
  `paid_in_full` bit(1) NOT NULL default '\0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills_test_association` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `bill_id` int(11) unsigned NOT NULL,
  `test_id` int(11) unsigned NOT NULL,
  `discount_type` int(4) unsigned NOT NULL default '1000',
  `discount_amount` decimal(10,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL default '',
  `page` varchar(45) NOT NULL default '',
  `comment` varchar(150) NOT NULL default '',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_conversion`
--

LOCK TABLES `currency_conversion` WRITE;
/*!40000 ALTER TABLE `currency_conversion` DISABLE KEYS */;
INSERT INTO `currency_conversion` VALUES ('F.CFA','F.CFA',1.00,'2021-08-09 09:53:41',1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `currency_conversion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_field_type`
--

DROP TABLE IF EXISTS `custom_field_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_field_type` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_type` varchar(45) default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delay_measures` (
  `User_Id` varchar(50) NOT NULL default '',
  `IP_Address` varchar(16) NOT NULL default '',
  `Latency` int(11) NOT NULL default '0',
  `Recorded_At` datetime NOT NULL default '0000-00-00 00:00:00',
  `Page_Name` varchar(45) default NULL,
  `Request_URI` varchar(100) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field_order` (
  `id` int(11) NOT NULL auto_increment,
  `lab_config_id` int(11) unsigned default NULL,
  `form_id` int(11) default NULL,
  `field_order` varchar(2000) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_order`
--

LOCK TABLES `field_order` WRITE;
/*!40000 ALTER TABLE `field_order` DISABLE KEYS */;
INSERT INTO `field_order` VALUES (61,12,1,'Patient ID,Patient Addl ID,Daily Number,Patient Name,Sex,Age,Date of Birth,Enceinte,Si oui, numbre de semaines d amenorrhee,Allaitante,Si oui, depuis combien de semaines,Date diagnostic VIH,Date initiation TARV,Ligne de traitement,Region'),(62,12,2,'Specimen ID,Lab Reciept Date,Referred Out,Physician,Date d envoi a Pette,Conformite de l echantillon,Nom et contact du preleveur,Echantillon,Date prelevement,Protocol ARV,Motif Examen');
/*!40000 ALTER TABLE `field_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_reagent`
--

DROP TABLE IF EXISTS `inv_reagent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY  (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`lab_config_id`),
  KEY `lab_config_id` (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_settings`
--

LOCK TABLES `lab_config_settings` WRITE;
/*!40000 ALTER TABLE `lab_config_settings` DISABLE KEYS */;
INSERT INTO `lab_config_settings` VALUES (1,1,2,30,11,'code39',NULL,NULL,NULL,NULL,'Barcode Settings','2021-08-09 05:27:22'),(2,20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Search Settings','2021-08-09 05:27:22'),(3,1,NULL,NULL,NULL,'F.CFA','.',NULL,NULL,NULL,'Billing Settings','2021-08-09 05:27:22');
/*!40000 ALTER TABLE `lab_config_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_specimen_type`
--

DROP TABLE IF EXISTS `lab_config_specimen_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `specimen_type_id` int(10) unsigned NOT NULL default '0',
  KEY `lab_config_id` (`lab_config_id`),
  KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_specimen_type`
--

LOCK TABLES `lab_config_specimen_type` WRITE;
/*!40000 ALTER TABLE `lab_config_specimen_type` DISABLE KEYS */;
INSERT INTO `lab_config_specimen_type` VALUES (12,1),(12,3),(12,2),(12,4),(12,7),(12,8),(12,10),(12,9),(12,6),(12,11),(12,5),(12,13);
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
  KEY `lab_config_id` (`lab_config_id`),
  KEY `test_type_id` (`test_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config_test_type`
--

LOCK TABLES `lab_config_test_type` WRITE;
/*!40000 ALTER TABLE `lab_config_test_type` DISABLE KEYS */;
INSERT INTO `lab_config_test_type` VALUES (12,1),(12,2),(12,3),(12,4),(12,5),(12,6),(12,7),(12,8),(12,9),(12,10),(12,11),(12,12),(12,13),(12,14),(12,15),(12,16),(12,17),(12,18),(12,19),(12,20),(12,21),(12,22),(12,23),(12,24),(12,25),(12,26),(12,27),(12,28),(12,29),(12,30),(12,31),(12,32),(12,33),(12,34),(12,35),(12,36),(12,37),(12,38),(12,39),(12,40),(12,41),(12,42),(12,43),(12,44),(12,45),(12,46);
/*!40000 ALTER TABLE `lab_config_test_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labtitle_custom_field`
--

DROP TABLE IF EXISTS `labtitle_custom_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `labtitle_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL,
  `field_options` varchar(200) NOT NULL,
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure`
--

LOCK TABLES `measure` WRITE;
/*!40000 ALTER TABLE `measure` DISABLE KEYS */;
INSERT INTO `measure` VALUES (1,'Charge Virale',NULL,':',NULL,'2021-08-09 08:26:21','copies/ml'),(2,'Ac. urique',NULL,':',NULL,'2021-08-09 09:50:41','mg/dl'),(3,'AgHBs',NULL,'Negatif/Positif',NULL,'2021-08-09 09:56:18','Negatif'),(4,'Amylase',NULL,':',NULL,'2021-08-09 09:57:46','mg/dl'),(5,'bK Controle',NULL,'Negatif/Rares/1+/2+/3+/4+',NULL,'2021-08-09 10:05:23',''),(6,'bK Nouveau',NULL,'Negatif/Rares/1+/2+/3+/4+',NULL,'2021-08-09 10:06:55',''),(7,'CD4',NULL,':',NULL,'2021-08-09 10:08:57','Cellules/mm3'),(8,'Chlamydia',NULL,'Negatif/Positif',NULL,'2021-08-09 10:11:34',''),(9,'Creatinine',NULL,':',NULL,'2021-08-09 10:13:12','mg/dl'),(10,'Cross Match',NULL,'Negatif/Positif',NULL,'2021-08-09 10:16:12',''),(11,'HCG',NULL,'Negatif/Positif',NULL,'2021-08-09 10:19:15',''),(12,'ECG',NULL,'$freetext$$',NULL,'2021-08-09 10:21:22',''),(13,'Fluoresceine',NULL,'$freetext$$',NULL,'2021-08-09 10:24:29',''),(14,'Fond de l oeil',NULL,'$freetext$$',NULL,'2021-08-09 10:26:04',''),(15,'Gamma GT',NULL,'$freetext$$',NULL,'2021-08-09 10:27:16','mg/dl'),(16,'Glycemie',NULL,':',NULL,'2021-08-09 10:30:06','mg/dl'),(17,'GPT',NULL,':',NULL,'2021-08-09 10:31:36','UI/L'),(18,'GS/Rh',NULL,'A/AB/B/O',NULL,'2021-08-09 10:36:08',''),(19,'$sub*18/$Rhesus',NULL,'Negatif/Poditif',NULL,'2021-08-09 10:36:08',''),(20,'HCV',NULL,'Negatif/Positif',NULL,'2021-08-09 10:37:28',''),(21,'Image Echo abdomino pelvienne',NULL,'$freetext$$',NULL,'2021-08-09 10:40:24',''),(22,'Echo CPN',NULL,'$freetext$$',NULL,'2021-08-09 10:42:21',''),(23,'Echo generale',NULL,'$freetext$$',NULL,'2021-08-09 10:43:48',''),(24,'Imagerie Medicale: Rx',NULL,'$freetext$$',NULL,'2021-08-09 10:45:03',''),(25,'Rx (face-profil)',NULL,'$freetext$$',NULL,'2021-08-09 10:46:39',''),(26,'Lame Luttes',NULL,'$freetext$$',NULL,'2021-08-09 10:48:21',''),(27,'LCR',NULL,'$freetext$$',NULL,'2021-08-09 10:49:23',''),(28,'Leucos manuel',NULL,'$freetext$$',NULL,'2021-08-09 10:51:17',''),(29,'NFS',NULL,'$freetext$$',NULL,'2021-08-09 10:53:36',''),(30,'NFS (FEC)',NULL,'$freetext$$',NULL,'2021-08-09 10:55:41',''),(31,'Oraquick/Bispot',NULL,'Negatif/Positif',NULL,'2021-08-09 10:58:03',''),(32,'TDR Palu',NULL,'Negatif/Positif',NULL,'2021-08-09 11:01:13',''),(33,'PIO',NULL,'$freetext$$',NULL,'2021-08-09 11:03:27',''),(34,'Poche de sang',NULL,'$freetext$$',NULL,'2021-08-09 11:04:46',''),(35,'Poche de sang',NULL,'$freetext$$',NULL,'2021-08-09 11:06:15',''),(36,'PSA',NULL,'Negatif/Positif',NULL,'2021-08-09 11:08:22',''),(37,'log 10',NULL,'$freetext$$',NULL,'2021-08-09 11:14:15','log 10 copies/ml'),(38,'Refractometre',NULL,'$freetext$$',NULL,'2021-08-09 11:17:01',''),(39,'Facteur Rhumatoid',NULL,'Non reactif/Reactif',NULL,'2021-08-09 11:18:26',''),(40,'RPR',NULL,'$freetext$$',NULL,'2021-08-09 11:20:00',''),(41,'CORPROLOGIE',NULL,'-/-',NULL,'2021-08-09 11:22:09',''),(42,'$sub*41/$Couleur',NULL,'$freetext$$',NULL,'2021-08-09 11:22:09',''),(43,'$sub*41/$Aspect',NULL,'$freetext$$',NULL,'2021-08-09 11:22:09',''),(44,'$sub*41/$Microscopie',NULL,'$freetext$$',NULL,'2021-08-09 11:22:09',''),(45,'H pylori',NULL,'$freetext$$',NULL,'2021-08-09 11:24:14',''),(46,'VIH',NULL,'Non reactif/Reactif/Non realiser',NULL,'2021-08-09 11:25:46',''),(47,'VIH',NULL,'Non reactif/Reactif/Non realiser',NULL,'2021-08-09 11:27:03',''),(48,'VIH',NULL,'Non reactif/Non reactif/Non realiser',NULL,'2021-08-09 11:28:07',''),(49,'VIH',NULL,'Non reactif/Reactif/Non realiser',NULL,'2021-08-09 11:29:16',''),(50,'Urine',NULL,'-/-',NULL,'2021-08-09 12:34:57',''),(51,'$sub*50/$Leucocytes',NULL,'$freetext$$',NULL,'2021-08-09 12:34:57','Leu/ÂµL'),(52,'$sub*50/$Nitrite',NULL,'$freetext$$',NULL,'2021-08-09 12:34:57',''),(53,'$sub*50/$Albumine/Proteines',NULL,'$freetext$$',NULL,'2021-08-09 12:34:57','mg/gL'),(54,'$sub*50/$PH',NULL,':',NULL,'2021-08-09 12:34:57',''),(55,'$sub*50/$Sang',NULL,'$freetext$$',NULL,'2021-08-09 12:34:57','Ery/ÂµL'),(56,'$sub*50/$Densite',NULL,':',NULL,'2021-08-09 12:34:57',''),(57,'$sub*50/$Corps cetoniques',NULL,'$freetext$$',NULL,'2021-08-09 12:34:57','mg/mL'),(58,'$sub*50/$Bilirubin',NULL,'$freetext$$',NULL,'2021-08-09 12:34:57','mg/mL'),(59,'$sub*50/$Glucose',NULL,'$freetext$$',NULL,'2021-08-09 12:34:57','mg/mL'),(60,'TO',NULL,'Negatif/Positif',NULL,'2021-08-09 12:40:45',''),(61,'TH',NULL,'Negatif/Positif',NULL,'2021-08-09 12:40:45',''),(62,'AO',NULL,'Negatif/Positif',NULL,'2021-08-09 12:40:45',''),(63,'AH',NULL,'Nagatif/Positif',NULL,'2021-08-09 12:40:45',''),(64,'BO',NULL,'Negatif/Positif',NULL,'2021-08-09 12:40:45',''),(65,'BH',NULL,'Negatif/Positif',NULL,'2021-08-09 12:40:45',''),(66,'CO',NULL,'Negatif/Positif',NULL,'2021-08-09 12:40:45',''),(67,'CH',NULL,'Negatif/Positif',NULL,'2021-08-09 12:40:45',''),(68,'CONCLUSION',NULL,'Serologie WIDAL NEGATIVE_Serologie WIDAL POSITIVE',NULL,'2021-08-09 12:40:45','');
/*!40000 ALTER TABLE `measure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misc`
--

DROP TABLE IF EXISTS `misc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `numeric_interpretation`
--

LOCK TABLES `numeric_interpretation` WRITE;
/*!40000 ALTER TABLE `numeric_interpretation` DISABLE KEYS */;
INSERT INTO `numeric_interpretation` VALUES (0,0,100,0,'B','TARGET NON DETECTABLE',1,1),(39,1,100,0,'B','SUPPRIMER, RETESTER APRES 6 OU 12M',1,2),(999,41,100,0,'B','SUPPRIMER, RETESTER APRES 6M',1,3),(10000000,1000,100,0,'B','NON SUPPRIMER:(DO EAC) RETESTER APRES 3M',1,4);
/*!40000 ALTER TABLE `numeric_interpretation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,'Pette','Philippe Ryi','M',0,NULL,504,'2021-08-08 23:00:00','1965-08-09','HGOI765','602b3e834789d1b531ae2fe2527a05b2066a5322');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_custom_data`
--

DROP TABLE IF EXISTS `patient_custom_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_custom_data`
--

LOCK TABLES `patient_custom_data` WRITE;
/*!40000 ALTER TABLE `patient_custom_data` DISABLE KEYS */;
INSERT INTO `patient_custom_data` VALUES (1,1,1,'NA','2021-08-09 15:03:04'),(2,2,1,'','2021-08-09 15:03:04'),(3,3,1,'NA','2021-08-09 15:03:04'),(4,4,1,'','2021-08-09 15:03:04'),(5,5,1,'--','2021-08-09 15:03:04'),(6,6,1,'--','2021-08-09 15:03:04'),(7,7,1,'1 ere','2021-08-09 15:03:04'),(8,8,1,'TELE','2021-08-09 15:03:04'),(9,9,1,'Test de routine','2021-08-09 15:03:04');
/*!40000 ALTER TABLE `patient_custom_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_custom_field`
--

DROP TABLE IF EXISTS `patient_custom_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL default '',
  `field_options` varchar(65474) NOT NULL default '',
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_custom_field`
--

LOCK TABLES `patient_custom_field` WRITE;
/*!40000 ALTER TABLE `patient_custom_field` DISABLE KEYS */;
INSERT INTO `patient_custom_field` VALUES (1,'Enceinte','Non/Oui/NA',3,'2021-08-09 07:43:23'),(2,'Si oui, numbre de semaines d amenorrhee','',1,'2021-08-09 07:46:04'),(3,'Allaitante','Non/Oui/NA',3,'2021-08-09 07:48:06'),(4,'Si oui, depuis combien de semaines','',1,'2021-08-09 07:48:44'),(5,'Date diagnostic VIH','',2,'2021-08-09 07:51:34'),(6,'Date initiation TARV','',2,'2021-08-09 07:52:50'),(7,'Ligne de traitement','1 ere/2 eme/3 eme/Ne sait pas /NA',3,'2021-08-09 07:55:40'),(10,'Region','Nord/Adamaoua/Extreame Nord/Nord Ouest/Littoral/Centre/Ouest/Est/Sud/Sud Ouest',3,'2021-08-10 08:25:10');
/*!40000 ALTER TABLE `patient_custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_daily`
--

DROP TABLE IF EXISTS `patient_daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_daily` (
  `datestring` varchar(45) NOT NULL,
  `count` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_daily`
--

LOCK TABLES `patient_daily` WRITE;
/*!40000 ALTER TABLE `patient_daily` DISABLE KEYS */;
INSERT INTO `patient_daily` VALUES ('20210809',1);
/*!40000 ALTER TABLE `patient_daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL auto_increment,
  `amount` decimal(10,2) NOT NULL default '0.00',
  `bill_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reference_range`
--

LOCK TABLES `reference_range` WRITE;
/*!40000 ALTER TABLE `reference_range` DISABLE KEYS */;
INSERT INTO `reference_range` VALUES (2,2,'0','100','B','3.0','7.0'),(3,4,'0','100','B','28','100'),(4,7,'0','100','B','500','1200'),(5,9,'0','100','B','0.6','1.4'),(6,16,'0','100','B','70','110'),(7,17,'0','100','B','0','50'),(10,54,'0','100','B','6','7.5'),(11,56,'0','100','B','1.010','1.025'),(12,1,'0','100','B','0','999');
/*!40000 ALTER TABLE `reference_range` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `removal_record`
--

DROP TABLE IF EXISTS `removal_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_config`
--

LOCK TABLES `report_config` WRITE;
/*!40000 ALTER TABLE `report_config` DISABLE KEYS */;
INSERT INTO `report_config` VALUES (1,'LABORATOIRE DE BIOLOGIE MOLECULAIRE??center','E-Mail : hopitalpette1@yahoo.fr	_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _                                    Tel (mobile) : +237 679 52 93 49 #_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _','2,0,10,0','1,0,1,1,1,0,1,0,1,1,0,0,0','1,0,1,0,0,0,0','1,0,0,1,0,1,0,1,0,1,1,1','6,7,10','1,5,6,7','0','',0,0,0,1,1,1),(2,'Specimen Report','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,0,0),(3,'Test Records','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,0,0),(4,'FONDATION SOCIALE SUISSE - HÃ”PITAL DE PETTÃ‰ ??left','#','2,0,10,0','1,1,0,1,1,0,1,0,1,0,0,0,0','1,1,1,1,1,1,0','1,0,0,1,0,0,1,0,0,0,0,0','1,5,6,7,8,10','','0','Rapport Journalier - Echantillons',0,0,0,1,0,0),(5,'Worksheet','','2,0,10,0','1,1,1,1,1,1,1','1,1,1,1,1,1','1,0,1,1,1,0,1,1','','','0','',0,3,1,1,0,0),(6,'FONDATION SOCIALE SUISSE - HÃ”PITAL DE PETTÃ‰ ??left','LABORATOIRE DE BIOLOGIE MOLÃ‰CULAIRE (+237) 679 52 93 49 (Direction),                  (+237) 699 98 06 45 (Laboratoire)  (+237) 696 61 68 12 (Biologiste Resp.)           (+237) 699 69 67 52 (Biologiste Adj.)  B.P. 65 Maroua â€“ Cameroun                         E-mail : hopitalpette1@yahoo.fr#Major Labo _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _              Medecin Biologist','2,0,10,0','1,1,1,1,1,1,1,0,0,0,0,0,0','1,1,1,1,1,1,0','1,0,1,1,1,0,1,1,0,0,0,0','10','','0','Rapport Jounalier - Patients',0,0,0,1,0,0),(7,'Grouped Test Count Report Configuration','0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+','0','1','1','1','1','0','9999009','0',9999009,3,1,1,0,0),(8,'Grouped Specimen Count Report Configuration','0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+','0','1','1','1','1','0','9999019','0',9999019,3,1,1,0,0),(9,'Worksheet - CHARGE VIRALE (CV) VIH','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','1','',0,3,1,1,0,0),(10,'Worksheet - Acide urique','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','2','',0,3,1,1,0,0),(11,'Worksheet - AgHBs','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','3','',0,3,1,1,0,0),(12,'Worksheet - Amylase','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','4','',0,3,1,1,0,0),(13,'Worksheet - bK Controle','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','5','',0,3,1,1,0,0),(14,'Worksheet - bK Nouveau','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','6','',0,3,1,1,0,0),(15,'Worksheet - CD4 - Externes','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','7','',0,3,1,1,0,0),(16,'Worksheet - Chlamydia','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','8','',0,3,1,1,0,0),(17,'Worksheet - Creatininemie','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','9','',0,3,1,1,0,0),(18,'Worksheet - Cross Match','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','10','',0,3,1,1,0,0),(19,'Worksheet - HCG (Test de Grosesse)','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','11','',0,3,1,1,0,0),(20,'Worksheet - ECG','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','12','',0,3,1,1,0,0),(21,'Worksheet - Fluoresceine','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','13','',0,3,1,1,0,0),(22,'Worksheet - Fond de l oeil','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','14','',0,3,1,1,0,0),(23,'Worksheet - Gamma GT','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','15','',0,3,1,1,0,0),(24,'Worksheet - Glycemie','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','16','',0,3,1,1,0,0),(25,'Worksheet - GPT','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','17','',0,3,1,1,0,0),(26,'Worksheet - Groupe Sanguin/Rhesus','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','18','',0,3,1,1,0,0),(27,'Worksheet - HCV','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','19','',0,3,1,1,0,0),(28,'Worksheet - Imagerie Medicale: Echo-abdomino-pelvienne','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','20','',0,3,1,1,0,0),(29,'Worksheet - Imagerie Medicale: Echo-CPN','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','21','',0,3,1,1,0,0),(30,'Worksheet - Imagerie Medicale: Echo generale','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','22','',0,3,1,1,0,0),(31,'Worksheet - Imagerie Medicale: Rx','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','23','',0,3,1,1,0,0),(32,'Worksheet - Imagerie Medicale: Rx (face-profil)','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','24','',0,3,1,1,0,0),(33,'Worksheet - Lame Luttes','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','25','',0,3,1,1,0,0),(34,'Worksheet - LCR','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','26','',0,3,1,1,0,0),(35,'Worksheet - Leucos manuel','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','27','',0,3,1,1,0,0),(36,'Worksheet - NFS','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','28','',0,3,1,1,0,0),(37,'Worksheet - NFS (FEC)','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','29','',0,3,1,1,0,0),(38,'Worksheet - Oraquick/Bispot','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','30','',0,3,1,1,0,0),(39,'Worksheet - Paracheck Palud','','5,0,5,0','0,1,0,1,1,0,0','0,0,1,1,0,0','1,0,1,0,0,0,0,1','','','31','',0,3,1,1,0,0);
/*!40000 ALTER TABLE `report_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_disease`
--

DROP TABLE IF EXISTS `report_disease`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_disease`
--

LOCK TABLES `report_disease` WRITE;
/*!40000 ALTER TABLE `report_disease` DISABLE KEYS */;
INSERT INTO `report_disease` VALUES (1,0,1,'','',0,12,0),(2,0,1,'',':',1,12,1),(3,0,1,'',':',2,12,2),(4,0,1,'','Negatif/Positif',3,12,3),(5,0,1,'',':',4,12,4),(6,0,1,'','Negatif/Rares/1+/2+/3+/4+',5,12,5),(7,0,1,'','Negatif/Rares/1+/2+/3+/4+',6,12,6),(8,0,1,'',':',7,12,7),(9,0,1,'','Negatif/Positif',8,12,8),(10,0,1,'',':',9,12,9),(11,0,1,'','Negatif/Positif',10,12,10),(12,0,1,'','Negatif/Positif',11,12,11),(13,0,1,'','$freetext$$',12,12,12),(14,0,1,'','$freetext$$',13,12,13),(15,0,1,'','$freetext$$',14,12,14),(16,0,1,'','$freetext$$',15,12,15),(17,0,1,'',':',16,12,16),(18,0,1,'',':',17,12,17),(19,0,1,'','A/AB/B/O',18,12,18),(20,0,1,'','Negatif/Poditif',19,12,18),(21,0,1,'','Negatif/Positif',20,12,19),(22,0,1,'','$freetext$$',21,12,20),(23,0,1,'','$freetext$$',22,12,21),(24,0,1,'','$freetext$$',23,12,22),(25,0,1,'','$freetext$$',24,12,23),(26,0,1,'','$freetext$$',25,12,24),(27,0,1,'','$freetext$$',26,12,25),(28,0,1,'','$freetext$$',27,12,26),(29,0,1,'','$freetext$$',28,12,27),(30,0,1,'','$freetext$$',29,12,28),(31,0,1,'','$freetext$$',30,12,29),(32,0,1,'','Negatif/Positif',31,12,30),(33,0,1,'','Negatif/Positif',32,12,31);
/*!40000 ALTER TABLE `report_disease` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate latin1_general_ci default NULL,
  `lab_id` int(11) default NULL,
  `District` varchar(40) collate latin1_general_ci default NULL,
  `Region` varchar(40) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sites`
--

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;
INSERT INTO `sites` VALUES (1,'FONDATION SOCIALE SUISSE, HD PETTE',12,NULL,NULL);
/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen`
--

DROP TABLE IF EXISTS `specimen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `site_id` int(11) default NULL,
  PRIMARY KEY  (`specimen_id`),
  KEY `patient_id` (`patient_id`),
  KEY `specimen_type_id` (`specimen_type_id`),
  KEY `user_id` (`user_id`),
  KEY `IDX_DATE` (`date_collected`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen`
--

LOCK TABLES `specimen` WRITE;
/*!40000 ALTER TABLE `specimen` DISABLE KEYS */;
/*!40000 ALTER TABLE `specimen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_custom_data`
--

DROP TABLE IF EXISTS `specimen_custom_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_custom_data`
--

LOCK TABLES `specimen_custom_data` WRITE;
/*!40000 ALTER TABLE `specimen_custom_data` DISABLE KEYS */;
INSERT INTO `specimen_custom_data` VALUES (1,1,1,'2021-08-09','2021-08-09 15:05:42'),(2,2,1,'Oui','2021-08-09 15:05:42'),(3,3,1,'Denis','2021-08-09 15:05:42'),(4,4,1,'APPROUVE','2021-08-09 15:05:42'),(5,1,3,'2021-08-09','2021-08-09 15:05:42'),(6,2,3,'Oui','2021-08-09 15:05:42'),(7,3,3,'','2021-08-09 15:05:42'),(8,4,3,'APPROUVE','2021-08-09 15:05:42');
/*!40000 ALTER TABLE `specimen_custom_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_custom_field`
--

DROP TABLE IF EXISTS `specimen_custom_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specimen_custom_field` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `field_name` varchar(45) NOT NULL default '',
  `field_options` varchar(65474) NOT NULL default '',
  `field_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_custom_field`
--

LOCK TABLES `specimen_custom_field` WRITE;
/*!40000 ALTER TABLE `specimen_custom_field` DISABLE KEYS */;
INSERT INTO `specimen_custom_field` VALUES (1,'Date d envoi a Pette','',2,'2021-08-09 08:10:04'),(2,'Conformite de l echantillon','Oui/Non',3,'2021-08-09 08:12:25'),(3,'Nom et contact du preleveur','',1,'2021-08-09 08:14:23'),(4,'Echantillon','APPROUVE/REJETTE/NA',3,'2021-08-09 08:15:49'),(5,'Date prelevement','',2,'2021-08-12 11:12:02'),(6,'Protocol ARV','',1,'2021-08-12 11:27:27'),(7,'Motif Examen','',1,'2021-08-12 11:32:10');
/*!40000 ALTER TABLE `specimen_custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_session`
--

DROP TABLE IF EXISTS `specimen_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specimen_session` (
  `session_num` varchar(45) NOT NULL default '',
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_session`
--

LOCK TABLES `specimen_session` WRITE;
/*!40000 ALTER TABLE `specimen_session` DISABLE KEYS */;
INSERT INTO `specimen_session` VALUES ('20210809',5),('20210810',1);
/*!40000 ALTER TABLE `specimen_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_test`
--

DROP TABLE IF EXISTS `specimen_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specimen_test` (
  `test_type_id` int(11) unsigned NOT NULL default '0',
  `specimen_type_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  KEY `test_type_id` (`test_type_id`),
  KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relates tests to the specimens that are compatible with thos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_test`
--

LOCK TABLES `specimen_test` WRITE;
/*!40000 ALTER TABLE `specimen_test` DISABLE KEYS */;
INSERT INTO `specimen_test` VALUES (1,1,'2021-08-09 08:26:21'),(2,2,'2021-08-09 09:50:42'),(3,2,'2021-08-09 09:56:18'),(4,2,'2021-08-09 09:57:46'),(5,4,'2021-08-09 10:05:24'),(6,4,'2021-08-09 10:06:55'),(7,3,'2021-08-09 10:08:57'),(8,2,'2021-08-09 10:11:34'),(9,2,'2021-08-09 10:13:12'),(10,3,'2021-08-09 10:16:12'),(11,2,'2021-08-09 10:19:15'),(11,5,'2021-08-09 10:19:15'),(12,12,'2021-08-09 10:22:09'),(13,1,'2021-08-09 10:24:30'),(13,2,'2021-08-09 10:24:30'),(14,12,'2021-08-09 10:26:04'),(15,1,'2021-08-09 10:27:16'),(15,2,'2021-08-09 10:27:16'),(16,2,'2021-08-09 10:30:06'),(17,2,'2021-08-09 10:31:36'),(18,3,'2021-08-09 10:36:08'),(19,2,'2021-08-09 10:37:28'),(20,12,'2021-08-09 10:40:24'),(21,12,'2021-08-09 10:42:22'),(22,12,'2021-08-09 10:43:48'),(23,12,'2021-08-09 10:45:03'),(24,12,'2021-08-09 10:46:39'),(25,12,'2021-08-09 10:48:21'),(26,7,'2021-08-09 10:49:23'),(27,3,'2021-08-09 10:51:17'),(28,3,'2021-08-09 10:53:36'),(29,3,'2021-08-09 10:55:42'),(30,2,'2021-08-09 10:58:04'),(30,13,'2021-08-09 10:58:32'),(31,3,'2021-08-09 11:01:13'),(32,12,'2021-08-09 11:03:27'),(33,3,'2021-08-09 11:04:47'),(34,3,'2021-08-09 11:06:15'),(35,2,'2021-08-09 11:08:22'),(36,12,'2021-08-09 11:17:01'),(37,2,'2021-08-09 11:18:26'),(38,2,'2021-08-09 11:20:00'),(39,6,'2021-08-09 11:22:09'),(40,2,'2021-08-09 11:24:14'),(41,12,'2021-08-09 11:25:46'),(41,2,'2021-08-09 11:25:46'),(42,1,'2021-08-09 11:27:03'),(42,2,'2021-08-09 11:27:03'),(43,1,'2021-08-09 11:28:07'),(43,2,'2021-08-09 11:28:07'),(44,1,'2021-08-09 11:29:17'),(44,2,'2021-08-09 11:29:17'),(45,5,'2021-08-09 12:34:57'),(46,2,'2021-08-09 12:40:45');
/*!40000 ALTER TABLE `specimen_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_type`
--

DROP TABLE IF EXISTS `specimen_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specimen_type` (
  `specimen_type_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `description` varchar(100) default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `disabled` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specimen_type`
--

LOCK TABLES `specimen_type` WRITE;
/*!40000 ALTER TABLE `specimen_type` DISABLE KEYS */;
INSERT INTO `specimen_type` VALUES (1,'PLASMA','','2021-08-09 08:17:32',0),(2,'SERUM','','2021-08-09 08:17:45',0),(3,'SANG TOTAL','','2021-08-09 08:18:02',0),(4,'CRACHAT','','2021-08-09 09:42:16',0),(5,'URINE','','2021-08-09 09:45:30',0),(6,'SELLES','','2021-08-09 09:46:26',0),(7,'LCR','','2021-08-09 09:46:52',0),(8,'PUS','','2021-08-09 09:47:03',0),(9,'SECRETIONS VAGINALES','','2021-08-09 09:47:35',0),(10,'SECRETIONS URETHRALES','','2021-08-09 09:47:55',0),(11,'SKIN SNIP','','2021-08-09 09:48:12',0),(12,'AUTRES','','2021-08-09 10:21:37',0),(13,'SALIVRE','','2021-08-09 10:58:32',0);
/*!40000 ALTER TABLE `specimen_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_content`
--

DROP TABLE IF EXISTS `stock_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `test_id` int(10) unsigned NOT NULL auto_increment,
  `test_type_id` int(11) unsigned NOT NULL default '0',
  `result` varchar(5000) default NULL,
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_agg_report_config`
--

DROP TABLE IF EXISTS `test_agg_report_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_agg_report_config` (
  `id` int(11) NOT NULL auto_increment,
  `test_type_id` int(11) default NULL,
  `title` varchar(255) collate latin1_general_ci default NULL,
  `landscape` tinyint(1) default '1',
  `group_by_age` tinyint(1) default '1',
  `age_unit` int(11) default '1',
  `age_groups` varchar(255) collate latin1_general_ci default NULL,
  `report_type` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_agg_report_config`
--

LOCK TABLES `test_agg_report_config` WRITE;
/*!40000 ALTER TABLE `test_agg_report_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_agg_report_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_category`
--

DROP TABLE IF EXISTS `test_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_category` (
  `test_category_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `description` varchar(100) default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_category`
--

LOCK TABLES `test_category` WRITE;
/*!40000 ALTER TABLE `test_category` DISABLE KEYS */;
INSERT INTO `test_category` VALUES (1,'HIV',NULL,'2021-08-09 05:24:24'),(2,'BIOCHIMIE','','2021-08-09 09:50:41'),(3,'BACTERIOLOGIE','','2021-08-09 10:05:23'),(4,'HEMATOLOGIE','','2021-08-09 10:08:57'),(5,'SEROLOGIE','','2021-08-09 10:11:34'),(6,'AUTRES','','2021-08-09 10:21:22'),(7,'IMAGERIE','','2021-08-09 10:40:24'),(8,'PARASITOLOGIE','','2021-08-09 11:01:13');
/*!40000 ALTER TABLE `test_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_type`
--

DROP TABLE IF EXISTS `test_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `is_reporting_enabled` tinyint(1) default '0',
  PRIMARY KEY  (`test_type_id`),
  KEY `test_category_id` (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_type`
--

LOCK TABLES `test_type` WRITE;
/*!40000 ALTER TABLE `test_type` DISABLE KEYS */;
INSERT INTO `test_type` VALUES (1,'CHARGE VIRALE VIH','',1,'2021-08-12 11:34:49',0,0,'NB : Pour quâ€™une variation de la charge virale soit significative, il faut que la diffÃ©rence entre deux mesures soit dâ€™au moins 0,5 Log10 soit une rÃ©duction ou une augmentation dâ€™un facteur 3 du nombre de copies/ml\n(*) Limite de dÃ©tection (LDD): <40 copies/mL (1,60 Log 10 copies/mL). Limites de quantifcation (LDQ) Comprise entre 40 et 10 000 000 copies/mL (1,60 et 7,0 Log 10 copies/mL)\n',0,50,250,0),(2,'Acide urique','',2,'2021-08-09 09:50:42',0,0,NULL,0,70,24,0),(3,'AgHBs','',2,'2021-08-09 09:56:18',0,0,NULL,0,70,24,0),(4,'Amylase','',2,'2021-08-09 09:57:46',0,0,NULL,0,70,24,0),(5,'bK Controle','',3,'2021-08-09 10:05:24',0,0,NULL,0,70,24,0),(6,'bK Nouveau','',3,'2021-08-09 10:06:55',0,0,NULL,0,70,24,0),(7,'CD4 - Externes','',4,'2021-08-09 10:08:57',0,0,NULL,0,70,24,0),(8,'Chlamydia','',5,'2021-08-09 10:11:34',0,0,NULL,0,70,24,0),(9,'Creatininemie','',2,'2021-08-09 10:13:12',0,0,NULL,0,70,24,0),(10,'Cross Match','',4,'2021-08-09 10:16:12',0,0,NULL,0,70,24,0),(11,'HCG (Test de Grosesse)','',5,'2021-08-09 10:19:15',0,0,NULL,0,70,24,0),(12,'ECG','',6,'2021-08-09 10:22:09',0,0,'',0,70,24,0),(13,'Fluoresceine','',2,'2021-08-09 10:24:30',0,0,NULL,0,70,24,0),(14,'Fond de l oeil','',6,'2021-08-09 10:26:04',0,0,NULL,0,70,24,0),(15,'Gamma GT','',2,'2021-08-09 10:27:16',0,0,NULL,0,70,24,0),(16,'Glycemie','',2,'2021-08-09 10:30:06',0,0,NULL,0,70,24,0),(17,'GPT','',2,'2021-08-09 10:31:36',0,0,NULL,0,70,24,0),(18,'Groupe Sanguin/Rhesus','',4,'2021-08-09 10:36:08',0,0,NULL,0,70,24,0),(19,'HCV','',2,'2021-08-09 10:37:28',0,0,NULL,0,70,24,0),(20,'Imagerie Medicale: Echo-abdomino-pelvienne','',7,'2021-08-09 10:40:24',0,0,NULL,0,70,24,0),(21,'Imagerie Medicale: Echo-CPN','',7,'2021-08-09 10:42:22',0,0,NULL,0,70,24,0),(22,'Imagerie Medicale: Echo generale','',7,'2021-08-09 10:43:48',0,0,NULL,0,70,24,0),(23,'Imagerie Medicale: Rx','',7,'2021-08-09 10:45:03',0,0,NULL,0,70,24,0),(24,'Imagerie Medicale: Rx (face-profil)','',7,'2021-08-09 10:46:39',0,0,NULL,0,70,24,0),(25,'Lame Luttes','',6,'2021-08-09 10:48:21',0,0,NULL,0,70,24,0),(26,'LCR','',3,'2021-08-09 10:49:23',0,0,NULL,0,70,24,0),(27,'Leucos manuel','',4,'2021-08-09 10:51:17',0,0,NULL,0,70,24,0),(28,'NFS','',4,'2021-08-09 10:53:36',0,0,NULL,0,70,24,0),(29,'NFS (FEC)','',4,'2021-08-09 10:55:42',0,0,NULL,0,70,24,0),(30,'Oraquick/Bispot','',5,'2021-08-09 10:58:04',0,0,NULL,0,70,24,0),(31,'Paracheck Palud','',8,'2021-08-09 11:01:13',0,0,NULL,0,70,24,0),(32,'PIO','',6,'2021-08-09 11:03:27',0,0,NULL,0,70,24,0),(33,'Poche de sang avec donner','',4,'2021-08-09 11:04:47',0,0,NULL,0,70,24,0),(34,'Poche de sang sans donner','',4,'2021-08-09 11:06:15',0,0,NULL,0,70,24,0),(35,'PSA (test rapide)','',2,'2021-08-09 11:08:22',0,0,NULL,0,70,24,0),(36,'Refractometre','',6,'2021-08-09 11:17:01',0,0,NULL,0,70,24,0),(37,'Rhumatisme','',5,'2021-08-09 11:18:26',0,0,NULL,0,70,24,0),(38,'RPR','',5,'2021-08-09 11:20:00',0,0,NULL,0,70,24,0),(39,'SELLES','',8,'2021-08-09 11:22:09',0,0,NULL,0,70,24,0),(40,'H. Pylori','',5,'2021-08-09 11:24:14',0,0,NULL,0,70,24,0),(41,'Determine HIV','',1,'2021-08-09 11:25:46',0,0,NULL,0,70,24,0),(42,'Determine HIV <15ans','',1,'2021-08-09 11:27:03',0,0,NULL,0,70,24,0),(43,'Determine HIV CPN','',1,'2021-08-09 11:28:07',0,0,NULL,0,70,24,0),(44,'Determine HIV Tbc','',1,'2021-08-09 11:29:17',0,0,NULL,0,70,24,0),(45,'Analyse des Urine','',3,'2021-08-09 12:34:57',0,0,NULL,0,70,24,0),(46,'WIDAL','',5,'2021-08-09 12:40:45',0,0,NULL,0,70,24,0);
/*!40000 ALTER TABLE `test_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_type_costs`
--

DROP TABLE IF EXISTS `test_type_costs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_type_costs` (
  `earliest_date_valid` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `test_type_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL default '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_type_costs`
--

LOCK TABLES `test_type_costs` WRITE;
/*!40000 ALTER TABLE `test_type_costs` DISABLE KEYS */;
INSERT INTO `test_type_costs` VALUES ('2021-08-09 08:26:22',1,0.00),('2021-08-09 09:50:42',2,3000.00),('2021-08-09 09:56:18',3,1000.00),('2021-08-09 09:57:46',4,3000.00),('2021-08-09 10:05:24',5,0.00),('2021-08-09 10:06:56',6,0.00),('2021-08-09 10:08:57',7,8000.00),('2021-08-09 10:11:34',8,1000.00),('2021-08-09 10:13:12',9,3000.00),('2021-08-09 10:16:12',10,0.00),('2021-08-09 10:19:15',11,1000.00),('2021-08-09 10:21:22',12,5000.00),('2021-08-09 10:24:30',13,1000.00),('2021-08-09 10:26:04',14,1500.00),('2021-08-09 10:27:16',15,3000.00),('2021-08-09 10:30:06',16,2000.00),('2021-08-09 10:31:36',17,3000.00),('2021-08-09 10:36:08',18,1500.00),('2021-08-09 10:37:28',19,1500.00),('2021-08-09 10:40:24',20,5000.00),('2021-08-09 10:42:22',21,2000.00),('2021-08-09 10:43:48',22,3000.00),('2021-08-09 10:45:03',23,5000.00),('2021-08-09 10:46:39',24,7000.00),('2021-08-09 10:48:21',25,1000.00),('2021-08-09 10:49:23',26,3000.00),('2021-08-09 10:51:17',27,1000.00),('2021-08-09 10:53:36',28,3000.00),('2021-08-09 10:55:42',29,3000.00),('2021-08-09 10:58:04',30,1000.00),('2021-08-09 11:01:13',31,2500.00),('2021-08-09 11:03:27',32,1500.00),('2021-08-09 11:04:47',33,10000.00),('2021-08-09 11:06:15',34,40000.00),('2021-08-09 11:08:22',35,5000.00),('2021-08-09 11:17:02',36,2000.00),('2021-08-09 11:18:26',37,1500.00),('2021-08-09 11:20:00',38,2000.00),('2021-08-09 11:22:09',39,500.00),('2021-08-09 11:24:14',40,3000.00),('2021-08-09 11:25:46',41,0.00),('2021-08-09 11:27:03',42,0.00),('2021-08-09 11:28:08',43,0.00),('2021-08-09 11:29:17',44,0.00),('2021-08-09 12:34:57',45,1000.00),('2021-08-09 12:40:45',46,1500.00);
/*!40000 ALTER TABLE `test_type_costs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_type_measure`
--

DROP TABLE IF EXISTS `test_type_measure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_type_measure` (
  `test_type_id` int(11) unsigned NOT NULL default '0',
  `measure_id` int(11) unsigned NOT NULL default '0',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  KEY `test_type_id` (`test_type_id`),
  KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_type_measure`
--

LOCK TABLES `test_type_measure` WRITE;
/*!40000 ALTER TABLE `test_type_measure` DISABLE KEYS */;
INSERT INTO `test_type_measure` VALUES (1,1,'2021-08-09 08:26:21'),(2,2,'2021-08-09 09:50:42'),(3,3,'2021-08-09 09:56:18'),(4,4,'2021-08-09 09:57:46'),(5,5,'2021-08-09 10:05:24'),(6,6,'2021-08-09 10:06:56'),(7,7,'2021-08-09 10:08:57'),(8,8,'2021-08-09 10:11:34'),(9,9,'2021-08-09 10:13:12'),(10,10,'2021-08-09 10:16:12'),(11,11,'2021-08-09 10:19:15'),(12,12,'2021-08-09 10:21:22'),(13,13,'2021-08-09 10:24:30'),(14,14,'2021-08-09 10:26:04'),(15,15,'2021-08-09 10:27:16'),(16,16,'2021-08-09 10:30:06'),(17,17,'2021-08-09 10:31:36'),(18,18,'2021-08-09 10:36:08'),(18,19,'2021-08-09 10:36:08'),(19,20,'2021-08-09 10:37:28'),(20,21,'2021-08-09 10:40:25'),(21,22,'2021-08-09 10:42:22'),(22,23,'2021-08-09 10:43:48'),(23,24,'2021-08-09 10:45:03'),(24,25,'2021-08-09 10:46:39'),(25,26,'2021-08-09 10:48:21'),(26,27,'2021-08-09 10:49:23'),(27,28,'2021-08-09 10:51:17'),(28,29,'2021-08-09 10:53:36'),(29,30,'2021-08-09 10:55:42'),(30,31,'2021-08-09 10:58:04'),(31,32,'2021-08-09 11:01:13'),(32,33,'2021-08-09 11:03:27'),(33,34,'2021-08-09 11:04:47'),(34,35,'2021-08-09 11:06:15'),(35,36,'2021-08-09 11:08:22'),(1,37,'2021-08-09 11:13:19'),(36,38,'2021-08-09 11:17:02'),(37,39,'2021-08-09 11:18:26'),(38,40,'2021-08-09 11:20:00'),(39,41,'2021-08-09 11:22:09'),(39,42,'2021-08-09 11:22:09'),(39,43,'2021-08-09 11:22:09'),(39,44,'2021-08-09 11:22:09'),(40,45,'2021-08-09 11:24:14'),(41,46,'2021-08-09 11:25:46'),(42,47,'2021-08-09 11:27:03'),(43,48,'2021-08-09 11:28:07'),(44,49,'2021-08-09 11:29:17'),(45,50,'2021-08-09 12:34:57'),(45,51,'2021-08-09 12:34:57'),(45,52,'2021-08-09 12:34:57'),(45,53,'2021-08-09 12:34:57'),(45,54,'2021-08-09 12:34:57'),(45,55,'2021-08-09 12:34:57'),(45,56,'2021-08-09 12:34:57'),(45,57,'2021-08-09 12:34:57'),(45,58,'2021-08-09 12:34:57'),(45,59,'2021-08-09 12:34:57'),(46,60,'2021-08-09 12:40:45'),(46,61,'2021-08-09 12:40:45'),(46,62,'2021-08-09 12:40:45'),(46,63,'2021-08-09 12:40:45'),(46,64,'2021-08-09 12:40:45'),(46,65,'2021-08-09 12:40:45'),(46,66,'2021-08-09 12:40:45'),(46,67,'2021-08-09 12:40:45'),(46,68,'2021-08-09 12:40:45');
/*!40000 ALTER TABLE `test_type_measure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `unit_id` int(11) unsigned NOT NULL auto_increment,
  `unit` varchar(45) NOT NULL default '',
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_feedback` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `rating` int(3) default NULL,
  `comments` varchar(500) collate latin1_general_ci default NULL,
  `ts` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_feedback`
--

LOCK TABLES `user_feedback` WRITE;
/*!40000 ALTER TABLE `user_feedback` DISABLE KEYS */;
INSERT INTO `user_feedback` VALUES (1,504,6,'','2021-08-09 08:38:33'),(2,504,6,'','2021-08-09 13:42:54'),(3,504,6,'','2021-08-10 08:29:37'),(4,504,6,'','2021-08-12 11:38:48'),(5,504,6,'','2021-08-12 11:42:46');
/*!40000 ALTER TABLE `user_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_props`
--

DROP TABLE IF EXISTS `user_props`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_rating` (
  `user_id` int(10) unsigned NOT NULL,
  `rating` int(10) unsigned NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`user_id`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `worksheet_custom_test` (
  `worksheet_id` int(10) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `width` varchar(45) NOT NULL,
  KEY `worksheet_id` (`worksheet_id`),
  KEY `test_type_id` (`test_type_id`),
  KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `worksheet_custom_userfield` (
  `worksheet_id` int(10) unsigned NOT NULL,
  `name` varchar(70) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '10',
  `field_id` int(10) unsigned NOT NULL auto_increment,
  KEY `Primary Key` (`field_id`),
  KEY `worksheet_id` (`worksheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `worksheet_custom_userfield`
--

LOCK TABLES `worksheet_custom_userfield` WRITE;
/*!40000 ALTER TABLE `worksheet_custom_userfield` DISABLE KEYS */;
/*!40000 ALTER TABLE `worksheet_custom_userfield` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'blis_12'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-09 19:19:04
