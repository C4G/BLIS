ALTER TABLE `test` MODIFY COLUMN `result` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

ALTER TABLE `specimen` ADD INDEX `aux_ind`(`aux_id`);
ALTER TABLE `reference_range` ADD `age_type` INT NOT NULL  DEFAULT 3;

ALTER TABLE `patient_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , ROW_FORMAT = DYNAMIC;

ALTER TABLE `specimen_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, ROW_FORMAT = DYNAMIC;

ALTER TABLE `labtitle_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , ROW_FORMAT = DYNAMIC;

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
