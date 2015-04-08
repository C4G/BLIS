CREATE TABLE IF NOT EXISTS `field_order` (
  `id` int(11) NOT NULL auto_increment,
  `lab_config_id` int(11) unsigned default NULL,
  `form_id` int(11) default NULL,
  `field_order` varchar(2000) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

alter table removal_record add category varchar(20) default "test";

ALTER TABLE specimen ADD COLUMN referred_from_name varchar(20);

CREATE TABLE IF NOT EXISTS `patient_report_fields_order`(
	`id` int(10) unsigned NOT NULL  auto_increment , 
	`p_fields` varchar(500) COLLATE latin1_general_ci NOT NULL  DEFAULT '' , 
	`o_fields` varchar(500) COLLATE latin1_general_ci NOT NULL  DEFAULT '' , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_general_ci';

ALTER TABLE `report_config` 
	ADD COLUMN `row_items` int(1) unsigned   NOT NULL DEFAULT 3 after `landscape` , 
	ADD COLUMN `show_border` int(1) unsigned   NOT NULL DEFAULT 1 after `row_items` , 
	ADD COLUMN `show_result_border` int(1) unsigned   NOT NULL DEFAULT 1 after `show_border`,	
	ADD COLUMN `result_border_horizontal` int(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `show_result_border`,
	ADD COLUMN `result_border_vertical` int(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `result_border_horizontal`;
	
	
ALTER TABLE `test` MODIFY COLUMN `result` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

ALTER TABLE `specimen` ADD INDEX `aux_ind`(`aux_id`);
ALTER TABLE `reference_range` ADD `age_type` INT NOT NULL  DEFAULT 3;

ALTER TABLE `patient_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , ROW_FORMAT = DYNAMIC;

ALTER TABLE `specimen_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, ROW_FORMAT = DYNAMIC;

ALTER TABLE `labtitle_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , ROW_FORMAT = DYNAMIC;


CREATE TABLE IF NOT EXISTS `currency_conversion` (
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

INSERT INTO `currency_conversion` (`currencya`, `currencyb`, `exchangerate`, `updatedts`, `flag1`, `flag2`, `setting1`, `setting2`) VALUES
('GHS', 'GHS', 1.00, '2013-11-11 14:07:02', 1, NULL, NULL, NULL); 

CREATE TABLE IF NOT EXISTS `dhims2_api_config` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) collate latin1_general_ci NOT NULL,
  `password` varchar(50) collate latin1_general_ci NOT NULL,
  `orgunit` varchar(200) collate latin1_general_ci NOT NULL,
  `dataset` varchar(200) collate latin1_general_ci NOT NULL,
  `dataelement` TEXT collate latin1_general_ci NOT NULL,
  `categorycombo` varchar(100) collate latin1_general_ci default NULL,
  `gender` varchar(5) collate latin1_general_ci default NULL,
  `period` varchar(10) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

ALTER TABLE `dhims2_api_config` CHANGE `dataelement` `dataelement` TEXT CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ;
