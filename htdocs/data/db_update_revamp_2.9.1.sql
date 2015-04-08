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
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(1, 'Mindray BS-200E', 'Bi-directional', '2.8.1 or 2.9.1 or 3.0 and above', '01.00.07', '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;TCP/IP\r\n<br/><br/>\r\n<b>[TCP/IP CONFIGURATIONS]</b><br/>	\r\n	PORT = 5150 (You can choose any appropriate port)<br/>\r\n	EQUIPMENT_IP = set it if applicable<br/>	\r\n	MODE = server	<br/>\r\n	CLIENT_RECONNECT = no<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nMindray BS-200E	<br/><br/>\r\n\r\n<b>Equipment specific tests configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\hl7\\MindrayInterface.xml', 'Chemistry');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(2, 'ABX Pentra 60 C+', 'Bi-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;MSACCESS\r\n<br/><br/>\r\n<b>[MSACCESS CONFIGURATIONS]</b><br/>	\r\n	DATASOURCE = create ODBC datasource to the equipment db and put name here<br/>\r\n	DAYS = 0<br/>	<br/>	\r\n	    \r\n<b>[EQUIPMENT] </b><br/>\r\nABX Pentra 60C+	<br/><br/>\r\n\r\n<b>Equipment specific tests configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\pentra\\pentra60cplus.xml', 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(3, 'ABX MACROS 60', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;RS232\r\n<br/><br/>\r\n<b>[RS232 CONFIGURATIONS]</b><br/>	\r\n	COMPORT = 10 (You can choose any appropriate port)<br/>\r\n	BAUD_RATE = 9600 (You can set appropriate value)<br/>	\r\n	PARITY = None	<br/>\r\n	STOP_BITS = 1<br/>\r\n    DATA_BITS = 8<br/>\r\n    APPEND_NEWLINE = No<br/>\r\n    APPEND_CARRIAGE_RETURN = No<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nABX MICROS 60	<br/><br/>\r\n\r\n<b>Equipment specific test configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\micros60\\abxmicros60.xml', 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(4, 'BT 3000 Plus', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, 'There are 2 implementations for this equipment with different feed source and software.<br/><br/>\r\n\r\n<b>BT 3000 Plus with Chameleon Middleware</b><br/>\r\n<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;TCP/IP\r\n<br/><br/>\r\n<b>[TCP/IP CONFIGURATIONS]</b><br/>	\r\n	PORT = 5150 (You can choose any appropriate port)<br/>\r\n	EQUIPMENT_IP = set the Chameleon PC IP address here <br/>	\r\n	MODE = client (Leave as it is here)	<br/>\r\n	CLIENT_RECONNECT = yes (Leave as it is here)<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nBT3000 Plus-Chameleon	<br/><br/>\r\n\r\n<b>Equipment specific tests configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000pluschameleon.xml<br/><br/>\r\n\r\n<b>BT 3000 Plus with Envoy(Without any Middleware - Connection to Analyzer directly)</b><br/>\r\n<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;RS232\r\n<br/><br/>\r\n<b>[RS232 CONFIGURATIONS]</b><br/>	\r\n	COMPORT = 10 (You can choose any appropriate port)<br/>\r\n	BAUD_RATE = 9600 (You can set appropriate value)<br/>	\r\n	PARITY = None	<br/>\r\n	STOP_BITS = 1<br/>\r\n    DATA_BITS = 8<br/>\r\n    APPEND_NEWLINE = No<br/>\r\n    APPEND_CARRIAGE_RETURN = No<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nBT3000 Plus	<br/><br/>\r\n\r\n<b>Equipment specific test configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000plus.xml', 'Chemistry');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(5, 'Sysmex SX 500i', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;TCP/IP\r\n<br/><br/>\r\n<b>[TCP/IP CONFIGURATIONS]</b><br/>	\r\n	PORT = 5150 (You can choose any appropriate port)<br/>\r\n	EQUIPMENT_IP = set the Analyzer PC IP address here <br/>	\r\n	MODE = server (Leave as it is here)	<br/>\r\n	CLIENT_RECONNECT = no (Leave as it is here)<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nSYSMEX XS-500i	<br/><br/>\r\n\r\n<b>Equipment specific tests configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXS500i.xml<br/><br/>\r\n', 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(6, 'BD FACSCalibur', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;TEXT\r\n<br/><br/>\r\n<b>[TEXT]</b><br/>	\r\n	BASE_DIRECTORY = \\BD\\BD Files\\MultiSET Files (Set correct path)<br/>\r\n	USE_SUB_DIRECTORIES = yes <br/>	\r\n	SUB_DIRECTORY_FORMAT = ddMMyy 	<br/>\r\n	FILE_NAME_FORMAT = ddMMyy <br/>\r\n    FILE_EXTENSION = exp (Leave as it is here)	<br/>\r\n    FILE_SEPERATOR = TAB (Leave as it is here)	<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nBD FACSCalibur	<br/><br/>\r\n\r\n<b>Equipment specific tests configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\BDFACSCalibur\\bdfacscalibur.xml<br/><br/>', 'Immunology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(7, 'Mindray BC 3600', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;RS232\r\n<br/><br/>\r\n<b>[RS232 CONFIGURATIONS]</b><br/>	\r\n	COMPORT = 10 (You can choose any appropriate port)<br/>\r\n	BAUD_RATE = 9600 (You can set appropriate value)<br/>	\r\n	PARITY = None	<br/>\r\n	STOP_BITS = 1<br/>\r\n    DATA_BITS = 8<br/>\r\n    APPEND_NEWLINE = No<br/>\r\n    APPEND_CARRIAGE_RETURN = No<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nMINDRAY BC 3600	<br/><br/>\r\n\r\n<b>Equipment specific test configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\mindray\\mindraybc3600.xml\r\n', 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(8, 'Selectra Junior', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;RS232\r\n<br/><br/>\r\n<b>[RS232 CONFIGURATIONS]</b><br/>	\r\n	COMPORT = 10 (You can choose any appropriate port)<br/>\r\n	BAUD_RATE = 9600 (You can set appropriate value)<br/>	\r\n	PARITY = None	<br/>\r\n	STOP_BITS = 1<br/>\r\n    DATA_BITS = 8<br/>\r\n    APPEND_NEWLINE = No<br/>\r\n    APPEND_CARRIAGE_RETURN = No<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nSelectra Junior	<br/><br/>\r\n\r\n<b>Equipment specific test configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\selectrajunior\\selectrajunior.xml<br/> \r\nPlease note that this analyzer do not send calculated test values to BLIS and so all calculated test must be configured in above file<br/>\r\n<b>selectrajunior.xml</b> Contains sample calculated tests formula configurations', 'Chemistry');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(9, 'GeneXpert', 'Bi-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;TCP/IP\r\n<br/><br/>\r\n<b>[TCP/IP CONFIGURATIONS]</b><br/>	\r\n	PORT = 5150 (You can choose any appropriate port)<br/>\r\n	EQUIPMENT_IP = set the Analyzer PC IP address here <br/>	\r\n	MODE = server (Set appropriate value)	<br/>\r\n	CLIENT_RECONNECT = no (Leave as it is here)<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nGeneXpert	<br/><br/>\r\n\r\n<b>Equipment specific tests configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\geneXpert\\genexpert.xml<br/><br/>', 'Microbiology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(10, 'ABX Pentra 80', 'Bi-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;RS232\r\n<br/><br/>\r\n<b>[RS232 CONFIGURATIONS]</b><br/>	\r\n	COMPORT = 10 (You can choose any appropriate port)<br/>\r\n	BAUD_RATE = 9600 (You can set appropriate value)<br/>	\r\n	PARITY = None	<br/>\r\n	STOP_BITS = 1<br/>\r\n    DATA_BITS = 8<br/>\r\n    APPEND_NEWLINE = No<br/>\r\n    APPEND_CARRIAGE_RETURN = No<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nABX Pentra 80	<br/><br/>\r\n\r\n<b>Equipment specific test configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\pentra80\\abxpentra80.xml<br/>', 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(11, 'Sysmex XT 2000i', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;TCP/IP\r\n<br/><br/>\r\n<b>[TCP/IP CONFIGURATIONS]</b><br/>	\r\n	PORT = 5150 (You can choose any appropriate port)<br/>\r\n	EQUIPMENT_IP = set the Analyzer PC IP address here <br/>	\r\n	MODE = server (Set appropriate value)	<br/>\r\n	CLIENT_RECONNECT = no (Leave as it is here)<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nSYSMEX XT-2000i	<br/><br/>\r\n\r\n<b>Equipment specific tests configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXT2000i.xml<br/><br/>', 'Haematology');
INSERT INTO `interfaced_equipment` (`id`, `equipment_name`, `comm_type`, `blis_version_required`, `equipment_version`, `sample_ini_configs`, `lab_department`) VALUES(12, 'Vitalex Flexor E', 'Uni-directional', '2.8.1 or 2.9.1 or 3.0 and above', NULL, '<b>[FEED SOURCE]</b><br/>\r\n&nbsp;&nbsp;RS232\r\n<br/><br/>\r\n<b>[RS232 CONFIGURATIONS]</b><br/>	\r\n	COMPORT = 10 (You can choose any appropriate port)<br/>\r\n	BAUD_RATE = 9600 (You can set appropriate value)<br/>	\r\n	PARITY = None	<br/>\r\n	STOP_BITS = 1<br/>\r\n    DATA_BITS = 8<br/>\r\n    APPEND_NEWLINE = No<br/>\r\n    APPEND_CARRIAGE_RETURN = No<br/><br/>\r\n    \r\n<b>[EQUIPMENT] </b><br/>\r\nFlexor E	<br/><br/>\r\n\r\n<b>Equipment specific test configuration file Location</b><br/>\r\n\\BLISInterfaceClient\\configs\\flexorE\\flexore.xml<br/> ', 'Chemistry');
