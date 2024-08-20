ALTER TABLE `bills` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `bills` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `bills_test_association` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `bills_test_association` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `blis_backups` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `blis_backups` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `blis_migrations` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `blis_migrations` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `comment` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `comment` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `currency_conversion` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `currency_conversion` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `custom_field_type` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `custom_field_type` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `delay_measures` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `delay_measures` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `dhims2_api_config` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `dhims2_api_config` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `field_order` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `field_order` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `inv_reagent` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `inv_reagent` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `inv_supply` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `inv_supply` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `inv_usage` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `inv_usage` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `lab_config` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `lab_config` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `lab_config_access` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `lab_config_access` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `lab_config_settings` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `lab_config_settings` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `lab_config_specimen_type` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `lab_config_specimen_type` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `lab_config_test_type` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `lab_config_test_type` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `labtitle_custom_field` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `labtitle_custom_field` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `measure` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `measure` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `misc` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `misc` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `numeric_interpretation` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `numeric_interpretation` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `patient` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `patient` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `patient_custom_data` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `patient_custom_data` CONVERT TO CHARACTER SET utf8mb4;

-- Using utf8mb4 means we need to shrink this column a bit
ALTER TABLE `patient_custom_field` MODIFY COLUMN `field_options` VARCHAR (16000) NULL;
ALTER TABLE `patient_custom_field` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `patient_custom_field` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `patient_daily` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `patient_daily` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `patient_report_fields_order` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `patient_report_fields_order` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `payments` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `payments` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `reference_range` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `reference_range` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `removal_record` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `removal_record` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `report_config` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `report_config` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `report_disease` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `report_disease` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `sites` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `sites` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `specimen` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `specimen` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `specimen_custom_data` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `specimen_custom_data` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `specimen_custom_field` MODIFY COLUMN `field_options` VARCHAR (16000) NULL;
ALTER TABLE `specimen_custom_field` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `specimen_custom_field` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `specimen_session` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `specimen_session` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `specimen_test` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `specimen_test` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `specimen_type` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `specimen_type` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `stock_content` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `stock_content` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `stock_details` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `stock_details` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `test` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `test` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `test_agg_report_config` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `test_agg_report_config` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `test_category` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `test_category` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `test_type` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `test_type` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `test_type_costs` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `test_type_costs` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `test_type_measure` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `test_type_measure` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `unit` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `unit` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `user` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `user` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `user_feedback` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `user_feedback` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `user_props` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `user_props` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `user_rating` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `user_rating` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `worksheet_custom` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `worksheet_custom` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `worksheet_custom_test` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `worksheet_custom_test` CONVERT TO CHARACTER SET utf8mb4;

ALTER TABLE `worksheet_custom_userfield` ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `worksheet_custom_userfield` CONVERT TO CHARACTER SET utf8mb4;
