use blis_235;

SET foreign_key_checks = 0;

ALTER TABLE lab_config_access
ADD CONSTRAINT FOREIGN KEY(lab_config_id) REFERENCES blis_revamp.lab_config(lab_config_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY(user_id) REFERENCES blis_revamp.user(user_id) ON UPDATE CASCADE;

ALTER TABLE lab_config_test_type
ADD CONSTRAINT FOREIGN KEY(lab_config_id) REFERENCES blis_revamp.lab_config(lab_config_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY(test_type_id) REFERENCES test_type(test_type_id) ON UPDATE CASCADE;

ALTER TABLE numeric_interpretation
MODIFY measure_id INT(10) UNSIGNED NOT NULL,
ADD CONSTRAINT FOREIGN KEY(measure_id) REFERENCES measure(measure_id) ON UPDATE CASCADE;

ALTER TABLE patient_custom_data
ADD CONSTRAINT FOREIGN KEY(patient_id) REFERENCES patient(patient_id) ON UPDATE CASCADE;

ALTER TABLE reference_range
ADD CONSTRAINT FOREIGN KEY(measure_id) REFERENCES measure(measure_id) ON UPDATE CASCADE;

ALTER TABLE report_disease
ADD CONSTRAINT FOREIGN KEY(measure_id) REFERENCES measure(measure_id) ON UPDATE CASCADE;

ALTER TABLE specimen
ADD CONSTRAINT FOREIGN KEY (patient_id) REFERENCES patient(patient_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY (specimen_type_id) REFERENCES specimen_type(specimen_type_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY (user_id) REFERENCES blis_revamp.user(user_id) ON UPDATE CASCADE;

ALTER TABLE specimen_custom_data
ADD CONSTRAINT FOREIGN KEY(specimen_id) REFERENCES specimen(specimen_id) ON UPDATE CASCADE;

ALTER TABLE specimen_test
ADD CONSTRAINT FOREIGN KEY(specimen_type_id) REFERENCES specimen_type(specimen_type_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY(test_type_id) REFERENCES test_type(test_type_id) ON UPDATE CASCADE;

ALTER TABLE lab_config_specimen_type
ADD CONSTRAINT FOREIGN KEY(lab_config_id) REFERENCES blis_revamp.lab_config(lab_config_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY(specimen_type_id) REFERENCES specimen(specimen_type_id) ON UPDATE CASCADE;

ALTER TABLE test
ADD CONSTRAINT FOREIGN KEY (test_type_id) REFERENCES test_type(test_type_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY (specimen_id) REFERENCES specimen(specimen_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY (user_id) REFERENCES blis_revamp.user(user_id) ON UPDATE CASCADE;

ALTER TABLE test_type
ADD CONSTRAINT FOREIGN KEY(test_category_id) REFERENCES test_category(test_category_id) ON UPDATE CASCADE;

ALTER TABLE test_type_measure
ADD CONSTRAINT FOREIGN KEY(test_type_id) REFERENCES test_type(test_type_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY(measure_id) REFERENCES measure(measure_id) ON UPDATE CASCADE;

ALTER TABLE user
/*MODIFY lab_config_id INT(10) UNSIGNED NOT NULL, */
ADD CONSTRAINT FOREIGN KEY(lab_config_id) REFERENCES blis_revamp.lab_config(lab_config_id) ON UPDATE CASCADE;

ALTER TABLE user_rating
ADD CONSTRAINT FOREIGN KEY(user_id) REFERENCES blis_revamp.user(user_id);

ALTER TABLE worksheet_custom_test
ADD CONSTRAINT FOREIGN KEY(worksheet_id) REFERENCES worksheet(worksheet_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY(test_type_id) REFERENCES test_type(test_type_id) ON UPDATE CASCADE,
ADD CONSTRAINT FOREIGN KEY(measure_id) REFERENCES measure(measure_id) ON UPDATE CASCADE;

ALTER TABLE worksheet_custom_userfield
ADD CONSTRAINT FOREIGN KEY(worksheet_id) REFERENCES worksheet(worksheet_id) ON UPDATE CASCADE;

CREATE INDEX IDX_DATE ON SPECIMEN(date_collected);

SET foreign_key_checks = 1;