CREATE DATABASE  IF NOT EXISTS `blis_revamp` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;
USE `blis_revamp`;
-- MySQL dump 10.13  Distrib 5.5.9, for Win32 (x86)
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
  PRIMARY KEY  (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_config`
--

LOCK TABLES `lab_config` WRITE;
/*!40000 ALTER TABLE `lab_config` DISABLE KEYS */;
INSERT INTO `lab_config` VALUES (127,'Testlab1','GT',53,'blis_127',1,0,0,1,2,1,2,1,1,0,0,2,0,'d-m-Y',1,1,'USA'),(128,'Bamenda Regional Hospital Lab','Bamenda, Cameroon',115,'blis_128',2,0,0,1,2,1,2,1,1,2,1,2,1,'m-d-Y',1,1,'Cameroon'),(129,'Buea Regional Hospital Lab','Buea, Cameroon',116,'blis_129',2,0,0,1,1,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon'),(130,'Hopital Centrel Laboratoire','Messa-Yaounde, Cameroon',113,'blis_130',2,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon'),(131,'Hopital Laquintinie Laboratoire','Douala, Cameroon',114,'blis_131',2,0,1,1,1,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon'),(151,'Tema Polyclinic Laboratory','Ghana',340,'blis_151',1,0,0,2,2,1,2,1,1,2,1,2,0,'d-m-Y',1,0,'Ghana'),(152,'Saltpond Municipal Hospital','Ghana',339,'blis_152',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Ghana'),(153,'Kaneshie Polyclinic','Ghana',338,'blis_153',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Ghana'),(203,'Limbe Hospital Laboratory','Limbe, Cameroon',174,'blis_203',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Cameroon'),(222,'Nkonsamba Regional Hospital','Nkonsamba',209,'blis_222',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',3,1,'Cameroon'),(223,'Kisarawe District Laboratory','Coast Region',264,'blis_223',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania'),(225,'Mafinga Laboratory','Mafinga District. Iringa Region',262,'blis_225',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania'),(226,'Lushoto Laboratory','Lushoto District, Tanga Region',260,'blis_226',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Tanzania'),(232,'Kiwoko Health Facility','Uganda',220,'blis_232',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(233,'JOY Medical Center-Ndeeba','Kampala, Uganda',224,'blis_233',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(234,'St. Stephens Health Centre','Kampala , Uganda',227,'blis_234',1,0,0,2,0,1,2,1,1,2,2,0,2,'d-m-Y',1,2,'Uganda'),(235,'Alive Medical Services','Kampala, Uganda',226,'blis_235',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(236,'Kawempe Health Centre','Uganda',233,'blis_236',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(237,'Ndejje Health Centre','Uganda',234,'blis_237',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(238,'Jinja Hospital','Uganda',200,'blis_238',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Uganda'),(1005,'GhanaTest','Atl',404,'blis_1005',1,0,0,1,2,1,2,1,1,2,1,2,1,'d-m-Y',1,1,'Ghana');
/*!40000 ALTER TABLE `lab_config` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-05-20 18:07:40
