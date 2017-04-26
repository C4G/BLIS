create table IF NOT EXISTS `interfaced_equipment` (
  `id` int(11) NOT NULL auto_increment,
  `equipment_name` varchar(150) collate latin1_general_ci NOT NULL,
  `comm_type` enum('Bi-directional','Uni-directional') collate latin1_general_ci NOT NULL,
  `equipment_version` varchar(50) collate latin1_general_ci default NULL,
  `lab_department` varchar(50) collate latin1_general_ci NOT NULL,
  `feed_source` varchar(50) collate latin1_general_ci,
  `config_file` varchar(2000) collate latin1_general_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

create table IF NOT EXISTS user_log(patient_id int, log_type varchar(100), creation_date datetime, created_by int);

create table IF NOT EXISTS ii_quickcodes(
prop_id int(11) NOT NULL auto_increment,
feed_source varchar(100),
config_prop varchar(100),
PRIMARY KEY  (`prop_id`)
);


create table IF NOT EXISTS equip_config(
  equip_id int,
    prop_id int,
    config_prop varchar(100),
    prop_value varchar(1000)
);


insert into interfaced_equipment values(1, 'Mindray BS-200E', 'Bi-directional', '01.00.07', 'Chemistry', 'TCP/IP', '\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000pluschameleon.xml');
insert into interfaced_equipment values(2, 'ABX Pentra 60 C+', 'Bi-directional', '', 'Haematology', 'MSACCESS', '\\BLISInterfaceClient\\configs\\pentra\\pentra60cplus.xml');
insert into interfaced_equipment values(3, 'ABX MACROS 60', 'Uni-directional', '', 'Haematology', 'RS232', '\\BLISInterfaceClient\\configs\\micros60\\abxmicros60.xml');
insert into interfaced_equipment values(4, 'BT 3000 Plus', 'Uni-directional', '', 'Chemistry', 'RS232', '\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000plus.xml');
insert into interfaced_equipment values(5, 'Sysmex SX 500i', 'Uni-directional', '', 'Haematology', 'TCP/IP', '\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXS500i.xml');
insert into interfaced_equipment values(6, 'BD FACSCalibur', 'Uni-directional', '', 'Immunology', 'TEXT', ' \\BLISInterfaceClient\\configs\\BDFACSCalibur\\bdfacscalibur.xml');
insert into interfaced_equipment values(7, 'Mindray BC 3600', 'Uni-directional', '', 'Haematology', 'RS232', ' \\BLISInterfaceClient\\configs\\mindray\\mindraybc3600.xml');
insert into interfaced_equipment values(8, 'Selectra Junior', 'Uni-directional', '', 'Chemistry', 'RS232', ' \\BLISInterfaceClient\\configs\\selectrajunior\\selectrajunior.xml');
insert into interfaced_equipment values(9, 'GeneXpert', 'Bi-directional', '', 'Microbiology', 'TCP/IP', ' \\BLISInterfaceClient\\configs\\geneXpert\\genexpert.xml');
insert into interfaced_equipment values(10, 'ABX Pentra 80', 'Bi-directional', '', 'Haematology', 'RS232', ' \\BLISInterfaceClient\\configs\\pentra80\\abxpentra80.xml');
insert into interfaced_equipment values(11, 'Sysmex XT 2000i', 'Uni-directional', '', 'Haematology', 'TCP/IP', '\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXT2000i.xml');
insert into interfaced_equipment values(12, 'Vitalex Flexor', 'Uni-directional', '', 'Chemistry', 'TCP/IP', ' \\BLISInterfaceClient\\configs\\flexorE\\flexore.xml'); 

insert into ii_quickcodes(feed_source,config_prop) values('TCP/IP', 'PORT');
insert into ii_quickcodes(feed_source,config_prop) values('TCP/IP', 'MODE');
insert into ii_quickcodes(feed_source,config_prop) values('TCP/IP', 'CLIENT_RECONNECT');
insert into ii_quickcodes(feed_source,config_prop) values('TCP/IP', 'EQUIPMENT_IP');


insert into ii_quickcodes(feed_source,config_prop) values('RS232', 'COMPORT');
insert into ii_quickcodes(feed_source,config_prop) values('RS232', 'BAUD_RATE');
insert into ii_quickcodes(feed_source,config_prop) values('RS232', 'PARITY');
insert into ii_quickcodes(feed_source,config_prop) values('RS232', 'STOP_BITS');
insert into ii_quickcodes(feed_source,config_prop) values('RS232', 'APPEND_NEWLINE');
insert into ii_quickcodes(feed_source,config_prop) values('RS232', 'DATA_BITS');
insert into ii_quickcodes(feed_source,config_prop) values('RS232', 'APPEND_CARRIAGE_RETURN');

insert into ii_quickcodes(feed_source,config_prop) values('MSACCESS', 'DATASOURCE');
insert into ii_quickcodes(feed_source,config_prop) values('MSACCESS', 'DAYS');

insert into ii_quickcodes(feed_source,config_prop) values('TEXT', 'BASE_DIRECTORY');
insert into ii_quickcodes(feed_source,config_prop) values('TEXT', 'USE_SUB_DIRECTORIES');
insert into ii_quickcodes(feed_source,config_prop) values('TEXT', 'SUB_DIRECTORY_FORMAT');
insert into ii_quickcodes(feed_source,config_prop) values('TEXT', 'FILE_NAME_FORMAT');
insert into ii_quickcodes(feed_source,config_prop) values('TEXT', 'FILE_EXTENSION');
insert into ii_quickcodes(feed_source,config_prop) values('TEXT', 'FILE_SEPERATOR');

insert into equip_config values(1, 1, 'PORT', '5150');
insert into equip_config values(1, 2, 'MODE', 'client');
insert into equip_config values(1, 3, 'CLIENT_RECONNECT', 'chameleon');
insert into equip_config values(1, 4, 'EQUIPMENT_IP', 'Yes');


insert into equip_config values(2, 12, 'DATASOURCE', 'create ODBC datasource to the equipment db and put name here');
insert into equip_config values(2, 13, 'DAYS', '0');


insert into equip_config values(3, 5, 'COMPORT', '10');
insert into equip_config values(3, 6, 'BAUD_RATE', '9600');
insert into equip_config values(3, 7, 'PARITY', 'None');
insert into equip_config values(3, 8, 'STOP_BITS', '1');
insert into equip_config values(3, 9, 'APPEND_NEWLINE', 'No');
insert into equip_config values(3, 10, 'DATA_BITS', '8');
insert into equip_config values(3, 11, 'APPEND_CARRIAGE_RETURN', 'No');


insert into equip_config values(4, 5, 'COMPORT', '10');
insert into equip_config values(4, 6, 'BAUD_RATE', '9600');
insert into equip_config values(4, 7, 'PARITY', 'None');
insert into equip_config values(4, 8, 'STOP_BITS', '1');
insert into equip_config values(4, 9, 'APPEND_NEWLINE', 'No');
insert into equip_config values(4, 10, 'DATA_BITS', '8');
insert into equip_config values(4, 11, 'APPEND_CARRIAGE_RETURN', 'No');
  
insert into equip_config values(5, 1, 'PORT', '5150');
insert into equip_config values(5, 2, 'MODE', 'server');
insert into equip_config values(5, 3, 'CLIENT_RECONNECT', 'no');
insert into equip_config values(5, 4, 'EQUIPMENT_IP', 'set the Analyzer PC IP address here');


insert into equip_config values(6, 14, 'BASE_DIRECTORY', '');
insert into equip_config values(6, 15, 'USE_SUB_DIRECTORIES', '');
insert into equip_config values(6, 16, 'SUB_DIRECTORY_FORMAT', '');
insert into equip_config values(6, 17, 'FILE_NAME_FORMAT', '');
insert into equip_config values(6, 18, 'FILE_EXTENSION', '');
insert into equip_config values(6, 19, 'FILE_SEPERATOR', '');

insert into equip_config values(7, 5, 'COMPORT', '10');
insert into equip_config values(7, 6, 'BAUD_RATE', '9600');
insert into equip_config values(7, 7, 'PARITY', 'None');
insert into equip_config values(7, 8, 'STOP_BITS', '1');
insert into equip_config values(7, 9, 'APPEND_NEWLINE', 'No');
insert into equip_config values(7, 10, 'DATA_BITS', '8');
insert into equip_config values(7, 11, 'APPEND_CARRIAGE_RETURN', 'No');

insert into equip_config values(8, 5, 'COMPORT', '10');
insert into equip_config values(8, 6, 'BAUD_RATE', '9600');
insert into equip_config values(8, 7, 'PARITY', 'None');
insert into equip_config values(8, 8, 'STOP_BITS', '1');
insert into equip_config values(8, 9, 'APPEND_NEWLINE', 'No');
insert into equip_config values(8, 10, 'DATA_BITS', '8');
insert into equip_config values(8, 11, 'APPEND_CARRIAGE_RETURN', 'No');

insert into equip_config values(9, 1, 'PORT', '5150');
insert into equip_config values(9, 2, 'MODE', 'server');
insert into equip_config values(9, 3, 'CLIENT_RECONNECT', 'no');
insert into equip_config values(9, 4, 'EQUIPMENT_IP', 'set the Analyzer PC IP address here');

insert into equip_config values(10, 5, 'COMPORT', '10');
insert into equip_config values(10, 6, 'BAUD_RATE', '9600');
insert into equip_config values(10, 7, 'PARITY', 'None');
insert into equip_config values(10, 8, 'STOP_BITS', '1');
insert into equip_config values(10, 9, 'APPEND_NEWLINE', 'No');
insert into equip_config values(10, 10, 'DATA_BITS', '8');
insert into equip_config values(10, 11, 'APPEND_CARRIAGE_RETURN', 'No');

insert into equip_config values(11, 1, 'PORT', '5150');
insert into equip_config values(11, 2, 'MODE', 'server');
insert into equip_config values(11, 3, 'CLIENT_RECONNECT', 'no');
insert into equip_config values(11, 4, 'EQUIPMENT_IP', 'set the Analyzer PC IP address here');

insert into equip_config values(12, 1, 'PORT', '5150');
insert into equip_config values(12, 2, 'MODE', 'server');
insert into equip_config values(12, 3, 'CLIENT_RECONNECT', 'no');
insert into equip_config values(12, 4, 'EQUIPMENT_IP', 'set the Analyzer PC IP address here');  