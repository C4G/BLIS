ALTER TABLE `specimen` MODIFY COLUMN `date_collected` datetime default '0000-00-00 00:00:00';
ALTER TABLE `lab_config_test_type` ADD COLUMN `print_unverified` int default 1;
ALTER TABLE `test_type` MODIFY COLUMN `target_tat` float(10) DEFAULT 24;