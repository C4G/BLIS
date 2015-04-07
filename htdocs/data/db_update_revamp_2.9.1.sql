ALTER TABLE `version_data` ADD `lab_config_id` INT NULL ;

CREATE TABLE IF NOT EXISTS `interfaced_equipment` (
  `id` int(11) NOT NULL auto_increment,
  `equipment_name` varchar(150) collate latin1_general_ci NOT NULL,
  `comm_type` enum('Bi-directional','Uni-directional') collate latin1_general_ci NOT NULL,
  `blis_version_required` varchar(50) collate latin1_general_ci NOT NULL,
  `equipment_version` varchar(50) collate latin1_general_ci default NULL,
  `sample_ini_configs` text collate latin1_general_ci,
  `lab_department` varchar(50) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `interfaced_equipment`
--

INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(1, 'Mindray BS-200E', 'Bi-directional', '2.8.1 or 2.9.1 or 3.0 and above', '01.00.07', '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;TCP/IP\r\n<br/><br/>\r\n<b>[TCP/IP CONFIGURATIONS]</b><br/>	\r\n	PORT = 5150 (You can choose any appropriate port)<br/>\r\n	EQUIPMENT_IP = set it if applicable<br/>	\r\n	MODE = server	<br/>\r\n	CLIENT_RECONNECT = no<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nMindray BS-200E	<br/><br/>', 'Chemistry');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(2, 'ABX Pentra 60 C+', 'Bi-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;MSACCESS\r\n<br/><br/>\r\n<b>[MSACCESS CONFIGURATIONS]</b><br/>	\r\n	DATASOURCE = create ODBC datasource to the equipment db and put name here<br/>\r\n	DAYS = 0<br/>	<br/>	\r\n	    \r\n<b>[EQUIPMENT] </b><br/>\r\nABX Pentra 60C+	<br/><br/>', 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(3, 'ABX MACROS 60', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(4, 'BT 3000 Plus', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Chemistry');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(5, 'Sysmex SX 500i', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(6, 'BD FACSCalibur', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Immunology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(7, 'Mindray BC 3600', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(8, 'Selectra Junior', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Chemistry');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(9, 'GeneXpert', 'Bi-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Microbiology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(10, 'ABX Pentra 80', 'Bi-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(11, 'Sysmex XT 2000i', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(12, 'Vitalex Flexor E', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, NULL, 'Chemistry');
