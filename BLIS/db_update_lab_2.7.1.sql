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
	
