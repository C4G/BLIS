-- MySQL dump 10.11
--
-- Host: localhost    Database: blis_revamp
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
-- Current Database: `blis_revamp`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `blis_revamp` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;

USE `blis_revamp`;

--
-- Table structure for table `global_measures`
--

DROP TABLE IF EXISTS `global_measures`;
CREATE TABLE `global_measures` (
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(128) collate latin1_general_ci default NULL,
  `range` varchar(1024) collate latin1_general_ci default NULL,
  `test_id` int(10) NOT NULL default '0',
  `measure_id` int(10) NOT NULL default '0',
  `unit` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`,`test_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `global_measures`
--

LOCK TABLES `global_measures` WRITE;
/*!40000 ALTER TABLE `global_measures` DISABLE KEYS */;
/*!40000 ALTER TABLE `global_measures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `import_log`
--

DROP TABLE IF EXISTS `import_log`;
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

--
-- Dumping data for table `infection_report_settings`
--

LOCK TABLES `infection_report_settings` WRITE;
/*!40000 ALTER TABLE `infection_report_settings` DISABLE KEYS */;
INSERT INTO `infection_report_settings` VALUES (1,1,1,'','',0,401,0);
/*!40000 ALTER TABLE `infection_report_settings` ENABLE KEYS */;
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
  `country` varchar(512) default NULL,
  PRIMARY KEY  (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Dumping data for table `lab_config`
--

LOCK TABLES `lab_config` WRITE;
/*!40000 ALTER TABLE `lab_config` DISABLE KEYS */;
INSERT INTO `lab_config` VALUES (1,'Regional Hospital, Koforidua','Eastern Region',453,'blis_1',1,1,2,11,2,1,2,11,1,2,1,2,1,'d-m-Y',1,1,''),(2,'37 Military Hospital Laboratory','Accra, Ghana',474,'blis_2',1,1,2,11,2,1,2,11,1,2,1,2,1,'d-m-Y',1,1,''),(3,'Greater Accra Regional Hospital Laboratory, R','Greater Accra',499,'blis_3',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,''),(4,'Central Regional Hospital, Cape Coast','Cape Coast',500,'blis_4',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,''),(5,'Volta Regional Hospital, Ho','Ho',501,'blis_5',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,''),(6,'Brong-Ahafo Regional Hospital Laboratory, Sun','Sunyani',502,'blis_6',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,''),(7,'Kintampo Health Research Centre','Kintampo',503,'blis_7',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,''),(8,'Kumasi South Hospital Laboratory','Kumasi',504,'blis_8',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,''),(9,'Sekondi Public Health Laboratory','Western',505,'blis_9',1,0,2,11,2,1,2,11,1,2,1,2,1,'d-m-Y',1,1,''),(10,'Tamale Public Health Laboratory','Northern Region',518,'blis_10',1,0,1,11,2,1,2,11,1,2,0,2,1,'d-m-Y',3,1,''),(11,'Upper West Regional Hospital','WA',531,'blis_11',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,''),(12,'Effia Nkwanta Regional Hospital','Sekondi',532,'blis_12',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,''),(127,'Testlab1','GT',53,'blis_127',1,0,0,11,2,1,2,11,1,0,0,2,0,'d-m-Y',1,1,'USA'),(128,'Bamenda Regional Hospital Lab','Bamenda, Cameroon',115,'blis_128',2,0,0,1,2,1,2,1,1,2,1,2,1,'m-d-Y',1,1,'Cameroon'),(129,'Buea Regional Hospital Lab','Buea, Cameroon',116,'blis_129',2,0,0,1,1,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon'),(130,'Hopital Centrel Laboratoire','Messa-Yaounde, Cameroon',113,'blis_130',2,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon'),(131,'Hopital Laquintinie Laboratoire','Douala, Cameroon',114,'blis_131',2,0,1,1,1,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon'),(151,'Tema Polyclinic Laboratory','Ghana',340,'blis_151',1,0,0,2,2,1,2,1,1,2,1,2,0,'d-m-Y',1,0,'Ghana'),(152,'Saltpond Municipal Hospital','Ghana',339,'blis_152',1,0,0,11,2,1,2,11,1,2,1,2,1,'d-m-Y',1,1,'Ghana'),(153,'Kaneshie Polyclinic','Ghana',338,'blis_153',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Ghana'),(203,'Limbe Hospital Laboratory','Limbe, Cameroon',174,'blis_203',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon'),(222,'Nkonsamba Regional Hospital','Nkonsamba',209,'blis_222',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',3,1,'Cameroon'),(223,'Kisarawe District Laboratory','Coast Region',264,'blis_223',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania'),(225,'Mafinga Laboratory','Mafinga District. Iringa Region',262,'blis_225',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania'),(226,'Lushoto Laboratory','Lushoto District, Tanga Region',260,'blis_226',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania'),(232,'Kiwoko Health Facility','Uganda',220,'blis_232',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(233,'JOY Medical Center-Ndeeba','Kampala, Uganda',224,'blis_233',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(234,'St. Stephens Health Centre','Kampala , Uganda',227,'blis_234',1,0,0,2,0,1,2,1,1,2,2,0,2,'d-m-Y',1,2,'Uganda'),(235,'Alive Medical Services','Kampala, Uganda',226,'blis_235',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(236,'Kawempe Health Centre','Uganda',233,'blis_236',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(237,'Ndejje Health Centre','Uganda',234,'blis_237',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(238,'Jinja Hospital','Uganda',200,'blis_238',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(1005,'GhanaTest','Atl',404,'blis_1005',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Ghana'),(1006,'National Public Health & Reference Laboratory','Accra',405,'blis_1006',1,1,2,11,2,1,2,11,1,2,1,2,1,'d-m-Y',1,1,'Ghana');
/*!40000 ALTER TABLE `lab_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_access`
--

DROP TABLE IF EXISTS `lab_config_access`;
CREATE TABLE `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_config_access`
--

LOCK TABLES `lab_config_access` WRITE;
/*!40000 ALTER TABLE `lab_config_access` DISABLE KEYS */;
INSERT INTO `lab_config_access` VALUES (401,1),(401,2),(401,3),(401,4),(401,5),(401,6),(401,7),(401,8),(401,9),(401,10),(401,11),(401,12),(401,1006);
/*!40000 ALTER TABLE `lab_config_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_config_specimen_type`
--

DROP TABLE IF EXISTS `lab_config_specimen_type`;
CREATE TABLE `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `specimen_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
CREATE TABLE `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `test_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_config_test_type`
--

LOCK TABLES `lab_config_test_type` WRITE;
/*!40000 ALTER TABLE `lab_config_test_type` DISABLE KEYS */;
INSERT INTO `lab_config_test_type` VALUES (106,7),(106,13),(106,10),(106,8),(107,10),(107,13),(107,7),(107,8),(108,8),(109,7),(110,7),(111,7),(112,7),(113,7),(114,7),(115,7),(116,7),(117,7),(118,7),(119,7),(120,7),(121,7),(122,7),(123,7),(124,7),(125,7),(126,7),(126,8),(127,7),(127,8),(127,56),(128,8),(128,48),(128,39),(128,49),(128,50),(128,51),(128,40),(128,52),(128,63),(128,54),(128,71),(128,18),(128,20),(128,22),(128,23),(128,24),(128,25),(128,55),(128,14),(128,43),(128,44),(128,58),(128,61),(128,72),(128,74),(128,70),(129,8),(129,48),(129,21),(129,18),(129,25),(129,27),(129,22),(129,60),(129,55),(129,9),(129,29),(129,30),(129,14),(129,24),(129,23),(129,20),(129,28),(129,70),(129,63),(129,54),(129,39),(129,51),(129,40),(129,52),(129,68),(207,71),(129,59),(129,67),(129,66),(129,58),(129,65),(129,71),(129,69),(130,8),(130,48),(130,20),(130,21),(130,22),(130,24),(130,25),(130,29),(130,30),(130,32),(130,55),(130,16),(130,39),(130,49),(130,51),(130,40),(130,52),(130,54),(130,63),(130,23),(130,43),(130,44),(130,58),(130,71),(130,72),(131,8),(131,48),(131,20),(131,21),(131,22),(131,23),(131,24),(131,25),(131,29),(131,30),(131,55),(131,16),(131,39),(131,51),(131,40),(131,52),(131,54),(131,63),(131,43),(131,44),(131,58),(131,71),(131,27),(131,32),(131,53),(131,41),(131,59),(132,8),(132,48),(132,43),(132,39),(132,40),(132,38),(132,7),(132,22),(132,23),(132,24),(132,35),(132,36),(132,51),(132,63),(132,41),(132,44),(132,47),(132,57),(132,59),(132,61),(132,64),(133,8),(133,48),(133,43),(133,39),(133,40),(133,38),(133,7),(133,22),(133,23),(133,24),(133,35),(133,36),(133,51),(133,63),(133,41),(133,44),(133,47),(133,57),(133,59),(133,61),(133,64),(134,8),(134,48),(134,7),(134,22),(134,23),(134,24),(134,36),(134,39),(134,51),(134,40),(134,63),(134,41),(134,38),(134,47),(134,58),(134,61),(134,64),(134,59),(134,35),(136,8),(136,48),(137,8),(137,48),(138,8),(138,48),(138,18),(138,19),(138,20),(138,22),(138,23),(138,24),(138,26),(138,27),(138,28),(138,29),(138,30),(138,31),(138,74),(138,32),(138,25),(138,55),(138,17),(138,16),(138,15),(138,13),(138,14),(138,49),(138,50),(138,51),(138,40),(138,52),(138,53),(138,54),(138,57),(138,58),(138,59),(138,61),(138,71),(138,62),(138,72),(138,73),(139,8),(139,48),(140,8),(140,48),(141,8),(141,48),(141,39),(141,51),(141,40),(141,53),(141,63),(141,7),(141,18),(141,19),(141,20),(141,22),(141,28),(141,29),(141,30),(141,9),(141,58),(141,54),(141,50),(141,52),(141,38),(141,71),(142,8),(142,48),(143,8),(143,48),(144,8),(144,48),(145,7),(145,38),(145,8),(146,8),(146,48),(147,8),(147,48),(147,7),(147,39),(147,40),(147,49),(147,43),(147,44),(148,8),(148,48),(149,7),(149,21),(149,8),(149,18),(149,25),(149,27),(149,26),(149,22),(149,9),(149,31),(149,29),(149,35),(149,36),(149,24),(149,23),(149,20),(149,28),(149,39),(149,40),(149,50),(149,52),(149,41),(149,42),(149,38),(149,48),(149,43),(149,44),(149,61),(149,47),(149,46),(149,56),(150,48),(151,7),(151,39),(151,40),(151,50),(151,52),(151,41),(151,48),(151,43),(151,46),(152,7),(152,25),(152,34),(152,14),(152,24),(152,23),(152,40),(152,38),(152,44),(152,47),(152,71),(152,56),(152,65),(153,7),(153,71),(153,56),(153,8),(153,39),(154,63),(154,44),(154,42),(155,8),(155,48),(156,8),(156,48),(157,8),(157,70),(158,39),(158,40),(158,38),(146,7),(146,39),(146,18),(146,63),(133,65),(133,69),(134,71),(134,65),(134,70),(130,60),(130,65),(130,70),(131,70),(131,60),(131,69),(138,60),(138,69),(141,69),(147,69),(127,71),(159,8),(141,56),(160,8),(160,7),(161,8),(162,8),(163,8),(164,8),(165,8),(166,8),(167,8),(168,8),(169,8),(170,8),(171,8),(178,19),(178,8),(178,32),(178,64),(178,18),(178,70),(178,63),(178,21),(179,64),(179,70),(179,21),(179,12),(179,25),(180,64),(180,70),(180,21),(180,12),(180,27),(180,54),(181,70),(181,21),(181,12),(181,25),(181,54),(182,8),(182,21),(182,12),(182,9),(182,40),(183,8),(183,7),(184,8),(184,7),(185,8),(185,7),(186,8),(186,7),(187,8),(187,7),(188,8),(188,7),(189,8),(189,7),(190,8),(190,7),(127,19),(127,32),(127,18),(191,19),(191,32),(191,18),(191,7),(192,19),(192,32),(192,18),(192,7),(193,19),(193,32),(193,18),(193,7),(194,19),(194,32),(194,18),(194,7),(195,8),(195,70),(195,21),(195,7),(195,27),(195,31),(195,29),(195,34),(195,30),(195,36),(195,38),(195,71),(195,56),(196,8),(196,18),(196,70),(196,21),(196,7),(196,27),(197,8),(196,31),(196,9),(196,29),(196,71),(128,56),(197,70),(197,39),(198,8),(198,18),(198,12),(198,7),(198,27),(198,29),(198,37),(198,30),(199,8),(199,32),(199,27),(199,71),(199,56),(199,38),(199,39),(141,27),(199,83),(199,44),(200,8),(200,32),(200,27),(200,39),(200,38),(200,71),(200,56),(201,8),(201,32),(201,27),(201,39),(201,31),(201,38),(201,71),(201,56),(201,44),(201,83),(201,61),(201,58),(201,84),(127,40),(202,8),(202,18),(202,7),(202,39),(202,9),(202,38),(202,71),(202,56),(202,40),(202,83),(202,47),(202,61),(202,85),(128,86),(128,7),(128,9),(203,8),(203,18),(203,70),(203,7),(203,25),(203,39),(203,9),(203,14),(203,24),(203,23),(203,71),(203,29),(203,48),(203,40),(203,43),(203,44),(203,42),(203,30),(203,65),(203,86),(203,74),(203,58),(203,52),(204,71),(205,8),(205,71),(206,71),(129,41),(131,85),(208,34),(208,30),(209,34),(209,30),(210,34),(210,30),(211,7),(212,32),(212,18),(129,56),(130,56),(131,56),(138,56),(203,56),(139,56),(131,64),(131,18),(131,68),(131,12),(131,7),(131,15),(131,73),(131,31),(131,57),(131,49),(131,37),(131,33),(131,35),(131,36),(131,14),(131,38),(131,13),(131,50),(131,61),(131,62),(131,72),(131,10),(131,84),(131,47),(131,65),(131,86),(131,83),(131,74),(131,17),(131,67),(131,66),(131,28),(131,11),(131,88),(128,89),(129,89),(130,89),(131,89),(203,89),(129,90),(129,91),(129,12),(129,35),(129,11),(129,92),(129,93),(129,94),(129,38),(129,95),(129,96),(129,97),(129,84),(129,98),(213,19),(213,8),(213,64),(213,18),(213,70),(213,7),(213,60),(214,38),(214,71),(214,86),(214,74),(214,56),(215,90),(215,8),(215,92),(215,56),(215,93),(216,8),(216,92),(216,90),(216,56),(219,8),(219,18),(219,28),(219,56),(220,8),(220,18),(220,28),(220,56),(221,22),(221,89),(221,39),(221,11),(221,56),(221,58),(222,98),(222,21),(222,84),(222,56),(223,98),(223,21),(223,84),(223,56),(224,56),(225,96),(225,71),(225,56),(226,96),(226,71),(226,56),(227,96),(227,71),(227,56),(228,96),(228,71),(228,56),(229,31),(229,57),(229,71),(230,32),(230,38),(230,56),(230,58),(230,93),(231,32),(231,7),(231,38),(231,24),(231,56),(231,58),(231,93),(232,32),(232,7),(232,38),(232,56),(232,58),(232,93),(233,90),(233,19),(233,32),(233,63),(233,95),(233,53),(233,91),(233,58),(234,63),(235,64),(235,60),(235,48),(235,44),(235,53),(235,91),(235,86),(235,58),(235,93),(236,8),(236,32),(236,44),(236,38),(236,71),(236,83),(236,27),(236,56),(237,8),(237,32),(237,39),(237,31),(237,44),(237,38),(237,61),(237,84),(237,71),(237,27),(237,56),(237,58),(238,85),(238,8),(238,18),(238,7),(238,9),(238,39),(238,40),(238,38),(238,61),(238,47),(238,71),(238,83),(238,56);
/*!40000 ALTER TABLE `lab_config_test_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map_coordinates`
--

DROP TABLE IF EXISTS `map_coordinates`;
CREATE TABLE `map_coordinates` (
  `id` int(11) NOT NULL auto_increment,
  `lab_id` int(11) NOT NULL,
  `coordinates` varchar(100) collate latin1_general_ci default NULL,
  `user_id` int(11) default NULL,
  `flag` int(11) default '1',
  `country` varchar(110) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
CREATE TABLE `measure_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `measure_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_measure_id` varchar(256) collate latin1_general_ci default NULL,
  `measure_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
CREATE TABLE `misc` (
  `username` varchar(20) collate latin1_general_ci default NULL,
  `action` varchar(40) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `misc`
--

LOCK TABLES `misc` WRITE;
/*!40000 ALTER TABLE `misc` DISABLE KEYS */;
INSERT INTO `misc` VALUES ('initial','password reset completed','2013-10-08 12:02:17'),('initial','password reset completed','2013-10-08 12:02:28'),('initial','password reset completed','2014-01-22 14:50:55'),('initial','password reset completed','2015-03-18 10:28:59');
/*!40000 ALTER TABLE `misc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference_range_global`
--

DROP TABLE IF EXISTS `reference_range_global`;
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

--
-- Dumping data for table `reference_range_global`
--

LOCK TABLES `reference_range_global` WRITE;
/*!40000 ALTER TABLE `reference_range_global` DISABLE KEYS */;
/*!40000 ALTER TABLE `reference_range_global` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specimen_mapping`
--

DROP TABLE IF EXISTS `specimen_mapping`;
CREATE TABLE `specimen_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `specimen_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_specimen_id` varchar(256) collate latin1_general_ci default NULL,
  `specimen_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
CREATE TABLE `test_category_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_category_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_category_id` varchar(256) collate latin1_general_ci default NULL,
  `test_category_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
CREATE TABLE `test_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_id` varchar(256) collate latin1_general_ci default NULL,
  `test_id` int(10) unsigned NOT NULL default '0',
  `test_category_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`user_id`,`test_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `test_mapping`
--

LOCK TABLES `test_mapping` WRITE;
/*!40000 ALTER TABLE `test_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
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
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (26,'monu','18865bfdeed2fd380316ecde609d94d7285af83f','Ruban','rubanm@gatech.edu',0,'2010-04-30 07:22:39',0,3,'','en','2,3,4,6,7'),(27,'vempala','18865bfdeed2fd380316ecde609d94d7285af83f','Santosh Vempala','vempala@cc.gatech.edu',0,'2010-01-10 15:00:55',0,3,'','default','2,3,4,6,7'),(28,'dezalia','18865bfdeed2fd380316ecde609d94d7285af83f','Mark DeZalia','',0,'2010-01-10 15:00:55',0,3,'','default','2,3,4,6,7'),(29,'nkengasong','18865bfdeed2fd380316ecde609d94d7285af83f','John Nkengasong','',0,'2010-01-10 15:00:55',0,3,'','default','2,3,4,6,7'),(53,'testadmin','18865bfdeed2fd380316ecde609d94d7285af83f','Testadmin','',26,'2010-01-14 17:05:44',0,2,'','default','2,3,4,6,7'),(56,'testlab1_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Testlab1 Tech1','',26,'2010-04-30 03:53:06',127,0,'','en','2,3,4,6,7'),(57,'testlab1_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Testlab1 Tech2','',26,'2010-01-14 17:10:48',127,1,'','default','2,3,4,6,7'),(58,'bamenda_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Bamenda Tech 1','',26,'2010-01-17 15:48:27',128,0,'','default','2,3,4,6,7'),(59,'bamenda_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Bamenda Tech 2','',26,'2010-01-17 15:48:27',128,1,'','default','2,3,4,6,7'),(60,'buea_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Buea Technician 1','',26,'2010-01-17 16:17:34',129,13,'','default','2,3,4,6,7'),(61,'buea_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Buea Technician 2','',26,'2010-01-17 16:17:34',129,0,'','default','2,3,4,6,7'),(64,'douala_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Douala Technician 1','',26,'2011-03-12 21:59:06',131,0,'','fr','2,3,4,6,7'),(65,'douala_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Douala Technician 2','',26,'2010-01-17 16:28:56',131,1,'','default','2,3,4,6,7'),(113,'centrel_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Centrel Admin','',26,'2010-01-17 22:40:38',0,2,'','default','2,3,4,6,7'),(114,'douala_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Douala Admin','xms1@cdc.gov',26,'2010-05-01 09:27:43',0,2,'1 404 639 2036','fr','2,3,4,6,7'),(115,'bamenda_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Bamenda Admin','',26,'2010-01-28 10:08:49',0,2,'','default','2,3,4,6,7'),(116,'buea_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Beua Admin','',26,'2010-01-17 22:41:25',0,2,'','default','2,3,4,6,7'),(123,'cameroon_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','Cameroon Country Dir.','',0,'2010-01-18 15:15:39',0,4,'','default','2,3,4,6,7'),(124,'botswana_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','Botswana Country Dir.','',0,'2010-01-18 15:16:30',0,4,'','default','2,3,4,6,7'),(125,'ghana_dir','dc2d9a08e3985a34838f43659ad7fdc614ee1297','Ghana Country Dir.','',0,'2010-01-18 15:16:30',0,4,'','default','2,3,4,6,7'),(141,'bamenda_clerk','26db11a7d9416a7a586aab2e8d9d27dc7cb42ff1','Bamenda Clerk','',115,'2010-02-11 02:14:02',128,5,'','default','2,3,4,6,7'),(174,'limbe_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Limbe Lab Admin','',123,'2010-04-10 04:51:47',0,2,'','default','2,3,4,6,7'),(177,'s_akuro','18865bfdeed2fd380316ecde609d94d7285af83f','Sidney Akuro Atah','s_akuro@ghsscmr.org',0,'2010-04-10 05:08:11',0,4,'','default','2,3,4,6,7'),(178,'e_nzeko','18865bfdeed2fd380316ecde609d94d7285af83f','Fouelifack Nzeko Eric','e_nzeko@ghsscmr.org ',0,'2010-04-10 05:09:14',0,4,'','default','2,3,4,6,7'),(179,'b_mangwa','18865bfdeed2fd380316ecde609d94d7285af83f','Beatrice Mangwa','b_mangwa@ghsscmr.org ',0,'2010-04-10 06:40:12',0,4,'','default','2,3,4,6,7'),(180,'n_ngale','18865bfdeed2fd380316ecde609d94d7285af83f','Elive Ngale Esuka','n_ngale@ghsscmr.org',0,'2010-04-10 05:12:18',0,4,'','default','2,3,4,6,7'),(181,'timtahn','18865bfdeed2fd380316ecde609d94d7285af83f','Tah Timothy Njuoh','timtahn@ghsscmr.org',0,'2010-04-18 17:03:13',0,4,'','default','2,3,4,6,7'),(190,'youmbi','f5a8a870417b5e3cbe35ce8455e134006c5fe01d','youmbi sylvain','',26,'2011-02-10 11:27:46',129,0,'','default','2,3,4,6,7'),(191,'ema','f0d6963ef447641f1b7b735f1cc4a8918d1a8bff','ema-gladys','',116,'2010-04-30 08:38:05',129,0,'','default','2,3,4,6,7'),(192,'ADJIETCHEU','7948914037c0b6dd88b994115b7d074014d32b91','DJIETCHEU ALPHONSE','adjietcheu@yahoo.fr',114,'2011-04-05 11:42:27',131,0,'99845149','fr','2,3,4,6,7'),(200,'sandrine','9866f465c2a97d32ee74c81e373c00f308a3dd28','','',115,'2010-05-21 10:23:08',128,0,'','default','2,3,4,6,7'),(201,'wamba','c9e73c2f6b826eb02a4e7f94891d66170bd41814','','',115,'2010-05-21 11:37:18',128,0,'','default','2,3,4,6,7'),(202,'Siyem','781e554af0bf7ff6238e0664247fb44e8d7f6698','','',115,'0000-00-00 00:00:00',128,13,'','default','2,3,4,6,7'),(204,'agendia','3daf03f15eb4d4db177913714ac884420b4568d3','AGENDIA','',116,'0000-00-00 00:00:00',129,0,'','default','2,3,4,6,7'),(205,'Ndolo','e444fb412b4549c44e88f45bca4e638e614d0487','NDOLO FELICIA','',116,'0000-00-00 00:00:00',129,0,'','default','2,3,4,6,7'),(206,'flora','856fb0d8841130d635b523279ac4c1acb2d596f6','Bolimo Flora','florabolimo@yahoo.com',116,'0000-00-00 00:00:00',129,13,' 237 75 53 92 88','en','2,3,4,6,7'),(207,'barbara','4c322fc55317a949810c3c922c2b88e58db77719','','',115,'0000-00-00 00:00:00',128,13,'','default','2,3,4,6,7'),(208,'NDI','91ebed17dbb9197e637aa33a0bee669a50c64818','','',115,'2010-05-18 07:12:14',128,0,'','default','2,3,4,6,7'),(209,'nkongsamba_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'0000-00-00 00:00:00',0,2,'','default','2,3,4,6,7'),(210,'ashu','7b5a78278a5efa14c1bdbdb9be888b309d0feae3','ASHU CHRISTIANA','ashuchrist@yahoo.fr',116,'2010-07-12 08:56:13',129,13,'237 99448253','default','2,3,4,6,7'),(212,'seuhort','fca9fd86c6dbed955853295ddc47ca542beb939e','Seudjeu   hortense','seuhort@yahoo.fr ',114,'2010-09-07 11:37:14',131,0,'11696502','fr','2,3,4,6,7'),(213,'Nji','c3c429d13650f7e47342f6f854a2a46a02181aa5','nji','seuhort@yahoo.fr ',115,'2011-02-08 20:41:06',128,13,'','default','2,3,4,6,7'),(214,'tech 1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Lab technician','',27,'2010-09-29 23:50:35',222,0,'','default','2,3,4,6,7'),(215,'frida','2c33c40ac711f90f2dd16174ad1bb5f803024361','','',115,'2010-11-23 18:13:47',128,13,'','default','2,3,4,6,7'),(216,'bih','6be24e36a8e2e2fa8eb07341ebd6404d445e0c8b','','',115,'2010-11-24 16:55:10',128,13,'','default','2,3,4,6,7'),(217,'lisa','86c11b712462cf18a04e0187cc3f1dd35b7af78a','','',115,'2010-11-24 17:04:05',128,13,'','default','2,3,4,6,7'),(218,'ngu','d3ca7aac7621ddc54f34b1f2ba460440922f8abf','','',115,'2011-02-08 20:48:34',128,13,'','default','2,3,4,6,7'),(219,'elisabeth','86c11b712462cf18a04e0187cc3f1dd35b7af78a','','',115,'2011-02-08 20:51:28',128,13,'','default','2,3,4,6,7'),(220,'kiwoko_admin','18865bfdeed2fd380316ecde609d94d7285af83f','kabugo daniel','kabugo_daniel@yahoo.ca',26,'0000-00-00 00:00:00',0,2,'0772643234','en','2,3,4,6,7'),(221,'Iyah','e3e53ebc1d88d5ec0f733ba6f9b7c1745980638a','Iyah Rebecca','priscilla_kelly@yahoo.com',116,'2011-02-10 11:23:31',129,13,'','default','2,3,4,6,7'),(222,'Mojoko','e563a12966c7ed5b8a401a274e788813b03918dc','Mojoko Diana','',116,'2011-02-10 11:25:49',129,0,'','default','2,3,4,6,7'),(223,'kiwoko_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',26,'0000-00-00 00:00:00',232,0,'','default','2,3,4,6,7'),(224,'joy_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'0000-00-00 00:00:00',0,2,'','default','2,3,4,6,7'),(225,'joy_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',26,'0000-00-00 00:00:00',233,0,'','default','2,3,4,6,7'),(226,'alive_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Sam bakeeera','',26,'0000-00-00 00:00:00',0,2,'','default','2,3,4,6,7'),(227,'stephens_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'0000-00-00 00:00:00',0,2,'','default','2,3,4,6,7'),(228,'stephens_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',26,'0000-00-00 00:00:00',234,0,'','default','2,3,4,6,7'),(229,'stephens_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',26,'0000-00-00 00:00:00',234,1,'','default','2,3,4,6,7'),(230,'alive_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',26,'0000-00-00 00:00:00',235,0,'','default','2,3,4,6,7'),(231,'alive_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',26,'0000-00-00 00:00:00',235,0,'','default','2,3,4,6,7'),(232,'jeanne carole','48ba38c64728d5088c353376fc5f95566ad767a0','ndzengue essomba','carolinamiss55@yahoo.fr',114,'2010-12-14 08:46:54',131,0,'00237 74366771','default','2,3,4,6,7'),(233,'kawempe_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'0000-00-00 00:00:00',0,2,'','default','2,3,4,6,7'),(234,'ndejje_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'0000-00-00 00:00:00',0,2,'','default','2,3,4,6,7'),(235,'kawempe_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Technician 1','',26,'0000-00-00 00:00:00',236,0,'','default','2,3,4,6,7'),(236,'kawempe_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Technician 2','',26,'0000-00-00 00:00:00',236,1,'','default','2,3,4,6,7'),(237,'ndejje_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Technician1','',26,'0000-00-00 00:00:00',237,0,'','default','2,3,4,6,7'),(238,'ndejje_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Technician 2','',26,'0000-00-00 00:00:00',237,1,'','default','2,3,4,6,7'),(239,'jinja_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'0000-00-00 00:00:00',0,2,'','default','2,3,4,6,7'),(240,'jinja_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Jinja Technician 1','',26,'0000-00-00 00:00:00',238,0,'','default','2,3,4,6,7'),(241,'jinja_tech2','56cbdfb7197c476fdd872cf2872f38131d24c8be','Jinja Technician 2','',26,'0000-00-00 00:00:00',238,1,'','default','2,3,4,6,7'),(242,'Edward','485ae6fc79591c04f163f957b493ba918b51bd17','Edward sebuufu','',220,'0000-00-00 00:00:00',232,13,'0772643234','default','2,3,4,6,7'),(243,'susan_kabugo','2e70df24aa3acda708b1526a834c8ecdcf2c4010','','',220,'0000-00-00 00:00:00',232,13,'0782807495','default','2,3,4,6,7'),(244,'Elijah_Bongoke','9a139a7ad836578c0b91f194047b6fdaab8292e6','','',220,'0000-00-00 00:00:00',232,13,'0752239054','default','2,3,4,6,7'),(245,'Ntambi_florence','2c708ab2b68f20294a9316b7f6b3dfbbc6649202','','',220,'0000-00-00 00:00:00',232,13,'0782474741','default','2,3,4,6,7'),(246,'Lumago_Alex','e28b5d565ef53d277b834e9455364b4f7a1f139b','','',220,'0000-00-00 00:00:00',232,13,'0774029438','default','2,3,4,6,7'),(247,'Nabukalu Mary','1d34deccd430ae8a1467e1403d6a793f519a165c','','',220,'0000-00-00 00:00:00',232,13,'0775824516','en','2,3,4,6,7'),(248,'Kateregga Joseph','d5b3fa3491194be978b79ce49f2789197c568f85','','',220,'0000-00-00 00:00:00',232,13,'','en','2,3,4,6,7'),(249,'Tugume Winnie','8b1bd453fd0ce3995516f86fd21245be7e2b6d89','Tugume Winnie','w.tugume at yahoo /gmail.com',220,'0000-00-00 00:00:00',232,13,'0779294521','en','2,3,4,6,7'),(250,'Martha Anyimo','ba17d99b8355aacffe51318b64f91b16edd2e19a','Martha','',220,'0000-00-00 00:00:00',232,13,'0774402909','en','2,3,4,6,7'),(251,'alive_tech3','56cbdfb7197c476fdd872cf2872f38131d24c8be','Robert','',226,'0000-00-00 00:00:00',235,13,'','default','2,3,4,6,7'),(252,'Nuluh','39d4087e98ad3959faa4bfc064d8011a0a2149e6','Nuluh Nakintu','',227,'0000-00-00 00:00:00',234,13,'0773961463','default','2,3,4,6,7'),(253,'Ben','c63d3687930f47563519e080432a4f2db0fb7541','Naita','',227,'0000-00-00 00:00:00',234,13,'0773961463','en','2,3,4,6,7'),(254,'Kenneth','479929ad264be4de5f25ceea57707d8dca3db7c3','Naita','',227,'0000-00-00 00:00:00',234,13,'','default','2,3,4,6,7'),(255,'Robert','18865bfdeed2fd380316ecde609d94d7285af83f','Kawesa','',227,'0000-00-00 00:00:00',234,13,'','en','2,3,4,6,7'),(260,'lushoto_admin','18865bfdeed2fd380316ecde609d94d7285af83f','ALMAS YUSUPH ALMASI','amasi1967@yahoo.com',26,'2011-05-02 00:21:50',0,2,'','default','2,3,4,6,7'),(261,'lushoto_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',26,'2011-05-02 00:25:09',226,0,'','default','2,3,4,6,7'),(262,'mafinga_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Paul Mayeka','pjmayeka@fhi.org',26,'2011-05-02 00:21:04',0,2,'','default','2,3,4,6,7'),(263,'mafinga_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',26,'2011-05-02 00:23:49',225,0,'','default','2,3,4,6,7'),(264,'kisarawe_admin','18865bfdeed2fd380316ecde609d94d7285af83f','Lenga Nteminyande','ntemys@yahoo.com',26,'2011-05-01 05:19:58',0,2,'','default','2,3,4,6,7'),(265,'kisarawe_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','Amsuri Mfinanga','',26,'2011-05-01 05:31:33',223,0,'','default','2,3,4,6,7'),(300,'sama','fe2592f879a61ce7d69664fd4c190b8b8179f535','','',115,'2011-05-12 17:52:57',128,0,'','default','2,3,4,6,7'),(303,'dr freeman','f91280b302b76c70524365b3ebe19ce4fae1086c','MBANG ','',114,'2011-05-12 17:52:57',131,0,'77609481','fr','2,3,4,6,7'),(304,'elisabeth fotabong','751d38adb7e4888238cf75cb087988cde4166002','manyi','',114,'2011-05-12 17:52:57',131,0,'99767575','en','2,3,4,6,7'),(305,'awono','e3f400ffea1939f398068b3c47f6f342685d7980','awono','awonofrancois@yahoo.fr',114,'2011-05-12 17:52:57',131,13,'77616389','fr','2,3,4,6,7'),(306,'scheffler','72699c96fcd640226b0ed552cb0f32876a192d85','ACHA SCHEFFLER','schefflacha@yahoo.com',114,'2011-05-12 17:52:57',131,0,'','en','2,3,4,6,7'),(307,'fkh','256abfb4700403ee35593e8a1002490bf26cfb8d','FOTSO','fkhonore@yahoo.fr',114,'2011-05-12 17:52:57',131,0,'77666684','fr','2,3,4,6,7'),(308,'asth','5a7384b9a00f3f431b41e9c11f2b6be3aace1e54','ASSONFACK THERESE','',114,'2011-05-12 17:52:57',131,0,'99629844','fr','2,3,4,6,7'),(309,'poma','4348c5b5192404afa63923a107422c2fe31e071c','ekalle poma gisele','',114,'2011-05-12 17:52:57',131,0,'94224884','fr','2,3,4,6,7'),(310,'robson','e392cf54a5133e067c5e737ae37e05c290a61d82','bikeck mbang pierre ','',114,'2011-05-12 17:52:57',131,0,'77530048','fr','2,3,4,6,7'),(311,'biltoo','2b338943a4150a1b4b1175be17d1f5ed18889bc7','BITOLOG','biltoofr@yahoo.fr',114,'2011-05-12 17:52:57',131,0,'','default','2,3,4,6,7'),(313,'BELLE','c3dbc493a7c39a198292d58490d572fc797477b5','BELLE  GERMAINE','',114,'2011-05-12 17:52:57',131,0,'99727879','fr','2,3,4,6,7'),(314,'BOGNE','0ca6e5ae70ec7b7b7e611427ae22cfd85bfe7ea1','','',114,'2011-05-12 17:52:57',131,0,'','default','2,3,4,6,7'),(315,'mako','90f0ca15553afc5a6d1acbd2d85ab374ab57eea4','MAKOUA SEVERIN',NULL,114,'2011-05-12 17:52:57',131,13,'77973660','default','2,3,4,6,7'),(316,'foko edmond','94a9ab0a391e819552edd0a444f6d11185d4f189','FOKO Edmon','edmondfoko@yahoo.fr',114,'2011-05-12 17:52:57',131,0,' 23775080731','fr','2,3,4,6,7'),(318,'Roger ENG LINGOM','241a3929d1f461f01c264877cf1c8049c691e558','Roger ENG LINGOM','jorel8112@yahoo.fr',114,'2011-05-12 17:52:57',131,0,'96010426','fr','2,3,4,6,7'),(319,'letaliban','47b7726702903463f966f184f89099d473d41ac3','TCHOKOUASI Edgard','edgardmonkam@gmail.com',114,'2011-05-12 17:52:57',131,0,'77 27 79 93/95 08 73 17','fr','2,3,4,6,7'),(320,'tcarlos','8deb100882e6bfb099daf9be506416385f739400','TIEMENI Carlos','tiemscarlos@yahoo.fr',114,'2011-05-12 17:52:57',131,0,' 23799631314','fr','2,3,4,6,7'),(321,'yeneda','77e990fdfa00418ba0392999dd4fe798ca779887','','tiemscarlos@yahoo.fr',115,'2011-05-12 17:52:57',128,13,'','default','2,3,4,6,7'),(322,'Monique','1b2e024adb2bed711974d62af6f4563907d5c3a1','','',115,'2011-05-12 17:52:57',128,13,'','default','2,3,4,6,7'),(324,'central_tech','56cbdfb7197c476fdd872cf2872f38131d24c8be','Tech 1','',27,'2011-05-12 17:52:57',224,0,'','default','2,3,4,6,7'),(325,'Achile','69d3e1f3cae2456a45bb44dda909e4a5c7bd5eec','Achile Zambo','',53,'2011-05-12 17:52:57',127,0,'','fr','2,3,4,6,7'),(326,'nakeli','55e7aaa19c901133bfe61471c75b8d7185e39cf3','','',115,'2011-05-12 17:52:57',128,13,'','default','2,3,4,6,7'),(330,'check','e206b11080c101836e027687497e40d9081545b0','','',264,'0000-00-00 00:00:00',223,0,'','default','2,3,4,6,7'),(331,'vivian','e9cdd12c3d407c3dd443fee28f5d088074a2c88b','','',116,'0000-00-00 00:00:00',129,13,'','default','2,3,4,6,7'),(332,'nyenti','8b308a147a37213aacc43b880eae9199786f0005','','',116,'0000-00-00 00:00:00',129,13,'','default','2,3,4,6,7'),(333,'bongkem','5853ef73ea1b7a9c53ff78189ffafea6b68cf42a','','',116,'0000-00-00 00:00:00',129,13,'','default','2,3,4,6,7'),(334,'simon','81d2602f623bd95843218b2b671a89736421f1be','Simon Achankeng N.','',116,'0000-00-00 00:00:00',129,0,'','default','2,3,4,6,7'),(335,'ebob','958c2b7641c1eadeefc86a431659b305bf891a40','Mme  Anna EBOB','',116,'0000-00-00 00:00:00',129,0,'','default','2,3,4,6,7'),(336,'Richard','f1ef511c08f332b73844e83d449e85c54d6e90db','','',116,'0000-00-00 00:00:00',129,13,'','default','2,3,4,6,7'),(337,'abid','a1271a8cac2fb175ddb092286b50cd9a47e948df','','',115,'0000-00-00 00:00:00',128,0,'','default','2,3,4,6,7'),(338,'kaneshie_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'2011-10-01 04:00:00',0,2,'','en','2,3,4,6,7'),(339,'saltpond_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'2011-10-01 04:00:00',0,2,'','en','2,3,4,6,7'),(340,'tema_admin','18865bfdeed2fd380316ecde609d94d7285af83f','','',26,'2011-10-01 04:00:00',0,2,'','en','2,3,4,6,7'),(341,'saltpond_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',339,'0000-00-00 00:00:00',152,0,'','default','2,3,4,6,7'),(342,'kaneshie_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',338,'0000-00-00 00:00:00',153,0,'','default','2,3,4,6,7'),(343,'tema_tech1','56cbdfb7197c476fdd872cf2872f38131d24c8be','','',340,'0000-00-00 00:00:00',151,0,'','default','2,3,4,6,7'),(344,'domi','5060e717b2df26401d300c2e3ba97bd917cf931e','','',339,'0000-00-00 00:00:00',152,13,'','en','2,3,4,6,7'),(345,'dorcas 111','e0b16e31ab5758d2b0df3a61d38f25ca0b427858','','',339,'0000-00-00 00:00:00',152,13,'','en','2,3,4,6,7'),(346,'robaidoo','b77d77844c2c4892797568b4973542889b29d872','','',339,'0000-00-00 00:00:00',152,13,'','en','2,3,4,6,7'),(347,'Ishmelo','90c6b04b8c1600e7217cbb7cad9118798d6d5bc2','','',339,'0000-00-00 00:00:00',152,13,'','en','2,3,4,6,7'),(348,'GRACIE','ac46f503b41673d7dfad4eeacb2b37b77299c973','','',339,'0000-00-00 00:00:00',152,0,'','en','2,3,4,6,7'),(349,'NADA','98b77bd134c9fe7a1477ea19889440be600b8513','','',339,'0000-00-00 00:00:00',152,0,'','en','2,3,4,6,7'),(350,'TAYTE','d3c27c2b4d826ba8da32ac8e81534cfe67f57df1','Tayte McAwesome Willows','',339,'0000-00-00 00:00:00',152,0,'','en','2,3,4,6,7'),(351,'ELFREDA','6a9d65d38992a52e4c330d9d3cabef02b6b0dd76','','',339,'0000-00-00 00:00:00',152,0,'','en','2,3,4,6,7'),(401,'philip','18865bfdeed2fd380316ecde609d94d7285af83f','Philip Boakye','boakyephilip@ymail.com',0,'0000-00-00 00:00:00',0,4,'','en','2,3,4,6,7'),(402,'mercy','18865bfdeed2fd380316ecde609d94d7285af83f','Mercy Maeda','mirygibson@yahoo.com',0,'0000-00-00 00:00:00',0,4,'','en','2,3,4,6,7'),(403,'PRINCE','e19349852fad3d4c39060af010fb036d4e59ddda','PRINCE OTOO','kofihitman@gmail.com',339,'0000-00-00 00:00:00',152,0,'0245714443','en','2,3,4,6,7'),(404,'eunice','8bf465d28f30fc1d6df5fe1cdb98cfb5916abdd0','','',339,'0000-00-00 00:00:00',152,0,'','en','2,3,4,6,7'),(405,'nphrl_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',1006,2,NULL,'default','2,3,4,6,7'),(408,'drbasil30','3ba5274b68df30bf17d6ce0b03e648788c254436','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(409,'ebenayiku','8dda4459863b07547b7b98c1a3c078cf7b7b988b','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(410,'godfred','cfc929bf6f6f3b02106a0ccb2d80eb74ae5b0290','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(411,'kobyofosuappiah','63a29d75bda29650169702ab68b2458f1538a91e','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(412,'r.kutame','e516492e5d6bad48c18d850cbbe1c3071863fb7f','Richard Kutame','accessrich@gmail.com',405,'0000-00-00 00:00:00',1006,0,'0243321360','en','2,3,4,6,7'),(413,'rebecca','d3ba1912034165923f9010087fae287c1c25d701','','',405,'0000-00-00 00:00:00',1006,5,'','en','2,3,4,6,7'),(414,'mariama','cacef23cdbb950eb4ecf7d2c504d96b8712cf285','Doe Harry','',405,'0000-00-00 00:00:00',1006,5,'','en','2,3,4,6,7'),(415,'esther','39b815ddbce5600066ce29de22db9b5e28bc4e94','','',405,'0000-00-00 00:00:00',1006,5,'','en','2,3,4,6,7'),(416,'ruth naa','6b8a92aab6e24dd118dd5aeb8dbbe8431be074ea','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(417,'ediedade','59a95c6a9691471f9acb5db581749faa41cc0bf3','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(418,'Florence','60c1e700d910e4de7662ffdf1bfeb8b7c3c2dd33','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(419,'e.aborgah','2df41945b3d88efafa5ccd2ecfbb7eae95bb3e1a','','',405,'0000-00-00 00:00:00',1006,13,'','en','2,3,4,6,7'),(420,'rowland','47807685bddd5452c6d84710e41429df144b0acb','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(421,'amakye','7b2a165b95eb959e8d0d8e61e5cac1bef0707442','','',405,'0000-00-00 00:00:00',1006,13,'','en','2,3,4,6,7'),(422,'geegirl','c27e7508e991b6d193f27e4585fcdc7e810de4cf','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(423,'Lorreta','834a1268631b50db07e6a67babfb7284c2f3a6bd','','',405,'0000-00-00 00:00:00',1006,13,'','en','2,3,4,6,7'),(424,'williamwirekoansah','77de907fef60d67c9d4f100e19f0afd61dddb8cd','','',405,'0000-00-00 00:00:00',1006,0,'','en','2,3,4,6,7'),(425,'Ruky','58d04a7a7e495775dc27e90945967cbed50f0db0','Rukaya Laryea','rukylaryea@gmail.com',405,'0000-00-00 00:00:00',1006,13,'0543098341','en','2,3,4,6,7'),(427,'Agnes Yeboah','e7da287e0cb564797522a9c498fc886da4803c07','Agnes Yeboah','',426,'0000-00-00 00:00:00',1,5,'0246954863','en','2,3,4,6,7'),(428,'Ruth Tetteh','3ab66c1ca0479a5de9da32ea2aea6d9f5f54b641','Ruth Tetteh','',426,'0000-00-00 00:00:00',1,13,'','en','2,3,4,6,7'),(429,'Samuel Morton','ae31c0b0228a09c173cd975d48a3319e53ec0da2','Samuel Morton','samuelmorton@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0244824827','en','2,3,4,6,7'),(431,'Kingsley B. wuor','62116855eb58ab3c6b6546c4b74c426469076655','Kingsley B. wuor','wuork@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0244660009','en','2,3,4,6,7'),(432,'George Danquah Damptey','b614bbaa76fef4fd6b511d925b0dedcf159650e4','','yawdan67@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0244605634','en','2,3,4,6,7'),(433,'Stephen Ofori','d985f047dbb4973aa45079b4babdeb210b877730','','',426,'0000-00-00 00:00:00',1,0,'0209103038','en','2,3,4,6,7'),(434,'Anim Justice','4a98e3d4a9b4e57407e13f1138615f85a9e69933','Anim Justice','elicuete@yahoo.com',426,'0000-00-00 00:00:00',1,0,'0543383023','en','2,3,4,6,7'),(435,'Gina Tetteh-Ocloo','d481a04d7adcdc7c4dfda07fdda3a05ddc9ce2cf','','ginateteh@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0242814134','en','2,3,4,6,7'),(436,'Agbesi Daniel','10fcf4a7ad896de25ecf4d57c8daf44a97ef9d4b','Agbesi Daniel','agbesidan@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0543913137','en','2,3,4,6,7'),(437,'Asiamah Samuel','50b4156cf35ee349df7e115a4067f0be76aee1d5','Asiamah Samuel','asiam.samuel@gmail.com',426,'0000-00-00 00:00:00',1,13,'0243135242','en','2,3,4,6,7'),(438,'Jamila Yunusah','3b840f3b569126e4af01b98a67872585a886cd51','Jamila Yunusah','',426,'0000-00-00 00:00:00',1,5,'','en','2,3,4,6,7'),(440,'Afrakoma ','e0de668d9d1e6934b0eb319b2b2e57c4e7dde955','Afrakoma Afriyie-Asante','afrakomaasante@gmail.com',426,'0000-00-00 00:00:00',1,13,'0249943680','en','2,3,4,6,7'),(441,'Vida Tetteh','ebb8c7fc03c1388edabd6c15ddedd9b0d84c6896','Vida Angmorkie Tetteh','vydert@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0245834998','en','2,3,4,6,7'),(442,'Theresa Awuku','0d14eb3d3a6269fd09221709ceb67544f5febcb3','Theresa Awuku','awuku.theresa@yahoo.com',426,'0000-00-00 00:00:00',1,5,'0246332752','en','2,3,4,6,7'),(443,'Francisca Kwatia','f4926d3b56b7cceb9d840b995f019a6b4a8fc43c','Francisca Kwatia','Ciscaqwat@gmail.com',426,'0000-00-00 00:00:00',1,5,'0249846228','en','2,3,4,6,7'),(444,'Appiah Charles','09cf859e85d965480075214d5de24f01530f53ba','Appiah Charles','kwadwoappiahcharles@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0244444423','en','2,3,4,6,7'),(445,'Yarboye Daniel','1447b62596413f72c9a237a40c5340eb00f120d2','Yarboye Daniel','mickflip60@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0273381150','en','2,3,4,6,7'),(446,'Angel Lopez Reene','a13f2f1e43639ab4d389758b996a23a3bf8269ca','angel lopez rene','lonnet2001@yahoo.com',426,'0000-00-00 00:00:00',1,13,' 233244660690','en','2,3,4,6,7'),(447,'Daniel Osei','8df1d76163280421d54816d026fc3997160fec4c','Daniel Osei','danielosei5050@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0244085601','en','2,3,4,6,7'),(448,'Opoku-Otchere Emmanuel','765b1ce7662e58c422ec364b251257ea44a04278','Opoku-Otchere Emmanuel','opmmanuel@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0249205207','en','2,3,4,6,7'),(449,'Roger Tagoe','3ec4e6213ff138b4176e2b4d7c213a307809efd1','Roger Tagoe','lock7gh@yahoo.com',426,'0000-00-00 00:00:00',1,0,'0207127943','en','2,3,4,6,7'),(450,'Roger Tagoe','3ec4e6213ff138b4176e2b4d7c213a307809efd1','Roger Tagoe','lock7gh@yahoo.com',426,'0000-00-00 00:00:00',1,13,'0207127943','en','2,3,4,6,7'),(452,'Augustine kyere','30b13a5dbc1a4fe178de2541623d737de34257d7','Augustine kyere','kyereaugustine@gmail.com',426,'0000-00-00 00:00:00',1,0,'0246884333','en','2,3,4,6,7'),(453,'Koforidua_admin','cee56b4c77cf93f837835bd551d81c3d205916ba','','',401,'0000-00-00 00:00:00',0,2,'','default','2,3,4,6,7'),(454,'David Ansah','f092b9892c6296c817f6397641c223c5b54c61c4','David Ansah','joemanoos@hotmail.com',453,'0000-00-00 00:00:00',1,13,'02448877682','en','2,3,4,6,7'),(455,'Andrews Patrick Adjei','aeb13d26d858a814cdfa65bae3f9b1fdefd234c6','Andrews Patrick Adjei','and_andyz@yahoo.co.uk',453,'0000-00-00 00:00:00',1,13,'0265699406','en','2,3,4,6,7'),(456,'Umaima Tahir','ab6db89fb275ec4b6b810a906c55151bc09260c9','Umaima Tahir','mima_tahiru88@yahoo.com',453,'0000-00-00 00:00:00',1,13,'0246603652','en','2,3,4,6,7'),(457,'Akrasi Rejoice Myra','437a2dfa2f3c38d058aee4d4537243fc6b7fa395','Akrasi Rejoice Myra','rejoiceakrasi@yahoo.com',453,'0000-00-00 00:00:00',1,13,'0542438719','en','2,3,4,6,7'),(458,'Ansah Francis','135f4362de138275a5a8e5bfe37404503fe4b7e6','Ansah Francis','ccosongo@yahoo.com',453,'0000-00-00 00:00:00',1,5,'0246228933','en','2,3,4,6,7'),(459,'Yiadom Boakye Prince','860dd5da7fa77f11a88d3fc221608993ecdfe07d','Yiadom Boakye Prince','',453,'0000-00-00 00:00:00',1,5,'0240336717','en','2,3,4,6,7'),(460,'Lannor George Kwame','3ae6998d8a9bf4df51fe5e88762c7dfae5246b96','Lannor George Kwame','Quamegeorge@yahoo.com',453,'0000-00-00 00:00:00',1,5,'0249569561','en','2,3,4,6,7'),(461,'John Boameyeh Yanney','a169cb79ce8b4c329021e25ee6d6649bb0bcb809','John Boameyeh Yanney','jboameyehyanney@yahoo.com',453,'0000-00-00 00:00:00',1,13,'0244623491','en','2,3,4,6,7'),(462,'Abubakari Abdul-Ganiyu','8823fa35952e8584e3ffb4c13a87b24c3040961a','Abubakari Abdul-Ganiyu','abdulgany09@gmail.com',453,'0000-00-00 00:00:00',1,13,'0243967108','en','2,3,4,6,7'),(463,'Christian Ahedor Kavi','a02a5f90507b4aabded5229cb59238316ea82261','Christian Ahedor Kavi','',453,'0000-00-00 00:00:00',1,5,'0273104634','en','2,3,4,6,7'),(464,'Abdullah Halilu','308b8ec8b10411de3ca757bfe9b6db5c99e9ad23','Abdullah Halilu','abdullahhalilu@yahoo.com',453,'0000-00-00 00:00:00',1,5,'0249980709','en','2,3,4,6,7'),(465,'Kudah Catherine','b0264b54747fde3e781dccf4a889de66464f2360','Kudah Catherine','esikudah@yahoo.com',453,'0000-00-00 00:00:00',1,13,'0246838887','en','2,3,4,6,7'),(466,'Jacob Bobie Osei Tutu','6560f468389d56fc70cc0d73cb289134886991b3','Jacob Bobie Osei Tutu','bobiejacob@yahoo.com',453,'0000-00-00 00:00:00',1,0,'0245929431','en','2,3,4,6,7'),(467,'Agyekum Stephen','59113598a3bc74cf75d766c8f4986459bf683142','Agyekum Stephen','stephen.agyekum@ymail.com',453,'0000-00-00 00:00:00',1,5,'0542641999','en','2,3,4,6,7'),(468,'David Osei','c5d2977e6ed44a3ff74edd07609166e692eb44f1','David Osei','',453,'0000-00-00 00:00:00',1,5,'0207734464','en','2,3,4,6,7'),(469,'winifred xorla ','1e5c4566e920a58e15c458a32547f57485ac4a6d','winifred xorla','winibaby12@gmail.com',453,'0000-00-00 00:00:00',1,13,'0249111532','en','2,3,4,6,7'),(470,'nartey kabutey','5302900e37455affe554355287a8b166249e12fd','Nartey Kabutey','unatey@yahoo.com',453,'0000-00-00 00:00:00',1,13,'0244032831','en','2,3,4,6,7'),(471,'Joyce','679cf0cec3d64bd106af93c87a10473c6be35252','Joyce Der-Saayeng','yasob1@yahoo.com',453,'0000-00-00 00:00:00',1,13,'0244667985','en','2,3,4,6,7'),(472,'Umar Rafia','f1aa66d4d2fe5b0e2e9c618cec3534fada365b59','Umar Rafia','',453,'0000-00-00 00:00:00',1,5,'0541463967','en','2,3,4,6,7'),(473,'Newlove Owusu','687fc9722a7f8c41140d7271fae04e73eb67a4c2','Newlove Owusu','newloveowusu@yahoo.com',453,'0000-00-00 00:00:00',1,13,'0248397891','en','2,3,4,6,7'),(474,'37_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',2,2,NULL,'default','2,3,4,6,7'),(476,'rep','843bd822517dd0c377d7284d3063fcafcc71ee1b','','',53,'0000-00-00 00:00:00',127,5,'','en','2,3,4,6,7'),(477,'Biomed','c2a814d328f2c5823918470640cc9ce197a4a7a9','','',53,'0000-00-00 00:00:00',127,0,'','en','2,3,4,6,7'),(478,'Essien','ac46f503b41673d7dfad4eeacb2b37b77299c973','John Wilberforce','john.essien425@gmail.com',474,'0000-00-00 00:00:00',2,5,'0246819551','en','2,3,4,6,7'),(479,'Eleanor','ac46f503b41673d7dfad4eeacb2b37b77299c973','Eleanor Achinanya','eleanorachis@gmail.com',474,'0000-00-00 00:00:00',2,5,'0242763078','en','2,3,4,6,7'),(480,'Stephen','ba04f3516b0216b9488f1ab6182d0280ad0e2622','Stephen Nartey','stenart@yahoo.com',474,'0000-00-00 00:00:00',2,5,'0541354795','en','2,3,4,6,7'),(481,'Alexander','02e2092082e48324f640315ef7765b9c0077e753','Alexander Mensah','koomens2005@yahoo.com',474,'0000-00-00 00:00:00',2,5,'0273946620','en','2,3,4,6,7'),(482,'Patience','e3cfab6af2bb6cf21464020b8f4e9f52e3c5b879','PATIENCE N.MATEY','mamapat2005@yahoo.co.uk',474,'0000-00-00 00:00:00',2,13,'0244988398','en','2,3,4,6,7'),(483,'VICTOR AZAMETI','23747d5d04bdcfd95c9eed5135c21ccd9873c821','VICTOR AZAMETI','AZAMETI.VITOR@YAHOO.COM',474,'0000-00-00 00:00:00',2,13,'0244215301','en','2,3,4,6,7'),(484,'kotei stephen','d5f631e7ab4d4a71e59c1444a16fe56049173ca2','Kotei Stephen','enzygrenn@gmail.com',474,'0000-00-00 00:00:00',2,13,'0243921244','en','2,3,4,6,7'),(485,'Fransyeb','898f83624ad230f03cb714702f200daf03a32d53','Francis Yeboah Amoako','fransyeb@gmail.com',474,'0000-00-00 00:00:00',2,5,'0246515476','en','2,3,4,6,7'),(486,'Sani','ac46f503b41673d7dfad4eeacb2b37b77299c973','Sani Abdulai','babsisey@yahoo.com',474,'0000-00-00 00:00:00',2,5,'0540560419','en','2,3,4,6,7'),(487,'Mensah','ac46f503b41673d7dfad4eeacb2b37b77299c973','Matilda Mensah','mattmensdee@yahoo.com',474,'0000-00-00 00:00:00',2,5,'0242349962','en','2,3,4,6,7'),(488,'JOE','895076e18e3cc5225d6fffc309626018b357abc0','JOSEPH  ADDY','bigjoe11gh@yahoo.com',474,'0000-00-00 00:00:00',2,13,'0244694243','en','2,3,4,6,7'),(490,'daniel whajah nviddah','5a2f9ae80d4bf8c180f75796c039c44858d170dd','daniel whajah nviddah','dwhajah@gmail.com',474,'0000-00-00 00:00:00',2,13,'0203102727','en','2,3,4,6,7'),(491,'kackah','b4b128b461d79dbb9a664cec557cb0f7de3e4fdb','Kingsley Ackah','ackkings@yahoo.com',474,'0000-00-00 00:00:00',2,13,'0243351470','en','2,3,4,6,7'),(492,'Frank','d43b40ebb610ee0c4633efef50a5790d35a04259','Abake Frank','fakapepe@yahoo.com',474,'0000-00-00 00:00:00',2,13,'0244737478','en','2,3,4,6,7'),(493,'deladem','c62c51f671799078f52bd25d0499604ec94d3f5a','Lt ED Nkornoo','deladino@yahoo.com',474,'0000-00-00 00:00:00',2,0,'0249427135','en','2,3,4,6,7'),(494,'Grace','ac46f503b41673d7dfad4eeacb2b37b77299c973','Grace Agyemang','',474,'0000-00-00 00:00:00',2,5,'','en','2,3,4,6,7'),(495,'Priscilla','ac46f503b41673d7dfad4eeacb2b37b77299c973','Priscilla Afreh','',474,'0000-00-00 00:00:00',2,5,'','en','2,3,4,6,7'),(496,'Opoku','c32fbc64eb2d3b0ef488065c439489008f17d875','Opoku Arhin','',474,'0000-00-00 00:00:00',2,5,'','en','2,3,4,6,7'),(497,'Kwame','ac46f503b41673d7dfad4eeacb2b37b77299c973','Morphis Kwame Adjei','',474,'0000-00-00 00:00:00',2,5,'','en','2,3,4,6,7'),(498,'David Tei Abordoh','ac46f503b41673d7dfad4eeacb2b37b77299c973','David Tei Abordoh','davidabordoh@yahoo.com',474,'0000-00-00 00:00:00',2,13,'0543391358','en','2,3,4,6,7'),(499,'ridge_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',3,2,NULL,'default','2,3,4,6,7'),(500,'cape_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',4,2,NULL,'default','2,3,4,6,7'),(501,'volta_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',5,2,NULL,'default','2,3,4,6,7'),(502,'sunyani_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',6,2,NULL,'default','2,3,4,6,7'),(503,'kintampo_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',7,2,NULL,'default','2,3,4,6,7'),(504,'kumasi_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',8,2,NULL,'default','2,3,4,6,7'),(505,'sekondi_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',9,2,NULL,'default','2,3,4,6,7'),(506,'Jude Tsikata','7baa0a725fc9abfad4cf8214a74ec7cd26df7942','Jude Tsikata','jctsikata@yahoo.com',505,'0000-00-00 00:00:00',9,13,'0208178068','en','2,3,4,6,7'),(507,'Ebenezer Kofi Mensah','c330432a0fbdd8febd0dd07aef1c6c9baec3e042','Ebenezer Kofi Mensah','otuamic@yahoo.co.uk',505,'0000-00-00 00:00:00',9,13,'0244528615','en','2,3,4,6,7'),(508,'Ruth Naa Gumah','6b8a92aab6e24dd118dd5aeb8dbbe8431be074ea','Ruth Naa Gumah','ruthygh@yahoo.com',505,'0000-00-00 00:00:00',9,13,'0244587792','en','2,3,4,6,7'),(509,'Eric Ofosu Amoako','ecca715cf8cbc307424bd54e3239247232931bd5','Eric Ofosu Amoako','eofosu1984@gmail.com',505,'0000-00-00 00:00:00',9,13,'0243368530','en','2,3,4,6,7'),(510,'Clement Kobina Bonney','2fdae9cd91d35b3cba286d0b35794b9d846f704a','Clement Kobina Bonney','griffin.rocks@yahoo.com',505,'0000-00-00 00:00:00',9,13,'0279870335','en','2,3,4,6,7'),(511,'Asmah Sampson','606f14e0ebbbec4f06e130bd7e1a8f8223e1f5ef','Asmah Sampson','sampsonasmah@yahoo.com',505,'0000-00-00 00:00:00',9,13,'0202161203','en','2,3,4,6,7'),(512,'Odoka Bastu Adebisi','3da3bd493641b4bc33807a194b31b95fd55aaf71','Odoka Bastu Adebisi','odoka_bastu@hotmail.com',505,'0000-00-00 00:00:00',9,13,'0241609396','en','2,3,4,6,7'),(513,'Sylvester Chinbuah','21f6c35c875b20bb1219595f3627232838a70110','Sylvester Chinbuah','thatchinbuah@yahoo.co.uk',505,'0000-00-00 00:00:00',9,13,'0244451189','en','2,3,4,6,7'),(514,'Irene Amedzro','040399014ed1e3601a76d9474b62b3b8fc9eec7c','Irene Amedzro','irene.appiah@gmail.com',505,'0000-00-00 00:00:00',9,13,'0208418471','en','2,3,4,6,7'),(515,'Agbezuke Tetteh Jacob','ee31c60456f10544ebd845b116ce6293c0269163','Agbezuke Tetteh Jacob','agbezuke2012@hotmail.com',505,'0000-00-00 00:00:00',9,13,'0543344344','en','2,3,4,6,7'),(516,'Gabriel Addai Manu','70b2733fe7046f494205194a0d1250b0a70a15df','Gabriel Addai Manu','gadman77@gmail.com',505,'0000-00-00 00:00:00',9,13,'0242236953','en','2,3,4,6,7'),(517,'Theodora Blankson','1725167a2b2a539a115489a9c68e60ccdacdc8a6','Theodora Blankson','baabablanks@yahoo.com',505,'0000-00-00 00:00:00',9,13,'0248028756','en','2,3,4,6,7'),(518,'tamalephl_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',10,2,NULL,'default','2,3,4,6,7'),(519,'Veronica Ebkang','ffcbc8ef891e50cbc8db0c9024a25e1eb519239a','Veronica Ebkang','veronicaebkang@yahoo.com',518,'0000-00-00 00:00:00',10,5,'0244844053','en','2,3,4,6,7'),(520,'Azure Stebleson','68cff1d20e2fd3c8077c5fb6ef88155802362f5f','Azure Stebleson','stebgambilla@yahoo.com',518,'0000-00-00 00:00:00',10,13,'0247563140','en','2,3,4,6,7'),(521,'Vincent Gyande Kangah','42440383746d4532900bf2004eca4552b86ef9eb','Vincent Gyande Kangah','fabiogyande@gmail.com',518,'0000-00-00 00:00:00',10,13,'0208668426/0245930947','en','2,3,4,6,7'),(522,'Boakye Gilbert','54de3fe6586164db56249cf5dd9ab0411fb98458','Boakye Gilbert','trebligboakye@yahoo.com',518,'0000-00-00 00:00:00',10,13,'0248363283','en','2,3,4,6,7'),(523,'Daron Davies Atsu-Agbo Agboyie','16a59f777e0b14430e60cf2ef3dfdff2116d04dd',' Agboyie Daron Davies Atsu-Agbo','ddaron2020@yahoo.com',518,'0000-00-00 00:00:00',10,13,'0207818854/0267818854','en','2,3,4,6,7'),(524,'Sylvester Mensah','26fe69173c74ebcc6527a341493948357aace773','','kenpriama02@yahoo.com',518,'0000-00-00 00:00:00',10,13,'0207513068','en','2,3,4,6,7'),(525,'Stephen Puonyin Danuor','fc0a9122b4d9bdbaa995ef616c131a4b44e0ffd6','Stephen Puonyin Danuor','',518,'0000-00-00 00:00:00',10,13,'','en','2,3,4,6,7'),(526,'Comfort Tordzro','30df3b29d10ad7aac937457b858fb94cc73aa3b6','Comfort Tordzro','',518,'0000-00-00 00:00:00',10,5,'0277019622','en','2,3,4,6,7'),(527,'Ayeebo Gladys','794edd469e0697835763a8202d6a42b179de1311','Ayeebo Gladys','ladygladys2gh@yahoo.com',518,'0000-00-00 00:00:00',10,13,'0245393799','en','2,3,4,6,7'),(528,'Oyinka Georgina','a8687356a421ad7e6bcde053abd9638f4d3ac1ab','Oyinka Georgina','',518,'0000-00-00 00:00:00',10,0,'0246380143','en','2,3,4,6,7'),(529,'Abass Abdul-Karim','6a15439e18a5aeef469ca938b60aaacc665f9d8b','Abass Abdul-Karim','nanayawkomei@yahoo.com',518,'0000-00-00 00:00:00',10,13,'0244571559','en','2,3,4,6,7'),(530,'Abigail Asieduwaa','61876b0c7e629c0a912d077bf9ccbc3b9b4f9082','Abigail Asieduwaa','binexzy22@yahoo.com',518,'0000-00-00 00:00:00',10,13,'0209500751','en','2,3,4,6,7'),(531,'Wa_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',11,2,NULL,'default','2,3,4,6,7'),(532,'nkwanta_admin','18865bfdeed2fd380316ecde609d94d7285af83f',NULL,NULL,401,'0000-00-00 00:00:00',12,2,NULL,'default','2,3,4,6,7');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `version_data`
--

DROP TABLE IF EXISTS `version_data`;
CREATE TABLE `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `status` int(11) default NULL,
  `user_id` int(11) default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `i_ts` timestamp NULL default NULL,
  `u_ts` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `lab_config_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `version_data`
--

LOCK TABLES `version_data` WRITE;
/*!40000 ALTER TABLE `version_data` DISABLE KEYS */;
INSERT INTO `version_data` VALUES (1,'2.5',1,401,NULL,'2013-07-19 14:36:25','2013-07-19 14:36:25',NULL),(2,'2.6',1,518,NULL,'2013-10-08 12:02:18','2013-10-08 12:02:18',NULL),(3,'2.6',1,518,NULL,'2013-10-08 12:02:28','2013-10-08 12:02:28',NULL),(4,'2.7',1,518,NULL,'2014-01-22 14:50:57','2014-01-22 14:50:57',NULL),(5,'2.8',1,518,NULL,'2014-07-17 09:44:53','2014-07-17 09:44:53',NULL),(6,'2.8.1',1,401,NULL,'2015-03-18 10:29:03','2015-03-18 10:29:03',-1),(7,'2.8.1',1,401,NULL,'2015-03-18 10:29:30','2015-03-18 10:29:30',2),(8,'2.8.1',1,401,NULL,'2015-03-18 10:29:51','2015-03-18 10:29:51',6),(9,'2.8.1',1,401,NULL,'2015-03-18 10:30:34','2015-03-18 10:30:34',4),(10,'2.8.1',1,401,NULL,'2015-03-18 10:30:54','2015-03-18 10:30:54',12),(11,'2.8.1',1,401,NULL,'2015-03-18 10:31:12','2015-03-18 10:31:12',3),(12,'2.8.1',1,401,NULL,'2015-03-18 10:31:33','2015-03-18 10:31:33',7),(13,'2.8.1',1,401,NULL,'2015-03-18 10:31:48','2015-03-18 10:31:48',8),(14,'2.8.1',1,401,NULL,'2015-03-18 10:32:08','2015-03-18 10:32:08',1006),(15,'2.8.1',1,401,NULL,'2015-03-18 10:32:40','2015-03-18 10:32:40',1),(16,'2.8.1',1,401,NULL,'2015-03-18 10:32:59','2015-03-18 10:32:59',9),(17,'2.8.1',1,401,NULL,'2015-03-18 10:33:25','2015-03-18 10:33:25',10),(18,'2.8.1',1,401,NULL,'2015-03-18 10:33:39','2015-03-18 10:33:39',11),(19,'2.8.1',1,401,NULL,'2015-03-18 10:33:55','2015-03-18 10:33:55',5);
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

-- Dump completed on 2015-04-01 16:50:55
