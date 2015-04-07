ALTER TABLE `patient_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , ROW_FORMAT = DYNAMIC;

ALTER TABLE `specimen_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, ROW_FORMAT = DYNAMIC;

ALTER TABLE `labtitle_custom_field` MODIFY COLUMN `field_options` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , ROW_FORMAT = DYNAMIC;

