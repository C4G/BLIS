CREATE TABLE `field_order` (
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
	
ALTER TABLE blis_revamp.user ADD rwoptions varchar(20) NOT NULL default '2,3,4,6,7';