use blis_235;

/*set global innodb_file_per_table = 1;*/

alter table comment engine=innodb;

alter table custom_field_type engine=innodb;

alter table delay_measures engine=innodb;

alter table lab_config engine=innodb;

alter table lab_config_access engine=innodb;

alter table lab_config_specimen_type engine=innodb;

alter table lab_config_test_type engine=innodb;

alter table labtitle_custom_field engine=innodb;

alter table measure engine=innodb;

alter table numeric_interpretation engine=innodb;

alter table patient engine=innodb;

alter table patient_custom_data engine=innodb;

alter table patient_custom_field engine=innodb;

alter table patient_daily engine=innodb;

alter table reference_range engine=innodb;

alter table report_config engine=innodb;

alter table report_disease engine=innodb;

alter table specimen engine=innodb;

alter table specimen_custom_data engine=innodb;

alter table specimen_custom_field engine=innodb;

alter table specimen_session engine=innodb;

alter table specimen_test engine=innodb;

alter table specimen_type engine=innodb;

alter table stock_content engine=innodb;

alter table stock_details engine=innodb;

alter table test engine=innodb;

alter table test_category engine=innodb;

alter table test_type engine=innodb;

alter table test_type_measure engine=innodb;

alter table unit engine=innodb;

alter table user engine=innodb;

alter table user_props engine=innodb;

alter table user_rating engine=innodb;

alter table worksheet_custom engine=innodb;

alter table worksheet_custom_test engine=innodb;

alter table worksheet_custom_userfield engine=innodb;