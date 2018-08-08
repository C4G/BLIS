ALTER TABLE `report_config`
ADD COLUMN `row_items` int(1) unsigned   NOT NULL DEFAULT 3;
ALTER TABLE `report_config`
ADD COLUMN `show_border` int(1) unsigned   NOT NULL DEFAULT 1;
ALTER TABLE `report_config`
ADD COLUMN `show_result_border` int(1) unsigned   NOT NULL DEFAULT 1;
ALTER TABLE `report_config`
ADD COLUMN `result_border_horizontal` int(1) UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE `report_config`
ADD COLUMN `result_border_vertical` int(1) UNSIGNED NOT NULL DEFAULT 0;

UPDATE `report_config`
SET `p_fields` = '1,1,0,1,1,0,1,0,0,0,0,0,0',
`s_fields` = '1,0,0,0,0,1,1',
`t_fields` = '1,1,1,0,0,0,0,1,0,1,1,1',
`show_border`=1,
`show_result_border`=1,
`result_border_horizontal`=1,
`result_border_vertical` = 1,
`landscape`=0,
`row_items`=1,
`test_type_id`='0',
`title`= 'Patient Report'
WHERE `report_id`=1;

ALTER TABLE specimen_custom_field
MODIFY field_options VARCHAR(65474);

ALTER TABLE patient_custom_field
MODIFY field_options VARCHAR(65474);

CREATE TABLE IF NOT EXISTS sites (
  id INT AUTO_INCREMENT NOT NULL,
  name VARCHAR(255),
  lab_id INT,
  PRIMARY KEY (id)
);

ALTER TABLE specimen ADD COLUMN site_id INT;

CREATE TABLE IF NOT EXISTS test_agg_report_config (
  id INT NOT NULL AUTO_INCREMENT,
  test_type_id INT,
  title VARCHAR(255),
  landscape BOOLEAN DEFAULT 1,
  group_by_age BOOLEAN DEFAULT 1,
  age_unit INT DEFAULT 1,
  age_groups VARCHAR(255),
  report_type INT,
  PRIMARY KEY (id)
);

ALTER TABLE test_type ADD COLUMN is_reporting_enabled BOOLEAN DEFAULT 0;

ALTER TABLE test_type ADD COLUMN prevalence_threshold INT(3) NOT NULL DEFAULT '70';

ALTER TABLE test_type ADD COLUMN target_tat INT(3) DEFAULT '24';
/*
The below statement preparation and execution is for the cases when the prevalence_threshold table
might not have the prevalence_threshold attribute in the table.

SET @stmt = (SELECT IF
	((SELECT COUNT(*)
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name='test_type'
		AND table_schema=DATABASE()
		AND column_name='prevalence_threshold'
	) > 0,
	"SELECT 1",
	"ALTER TABLE test_type ADD COLUMN prevalence_threshold INT(3) NOT NULL DEFAULT '70';"
));

PREPARE a1 FROM @stmt;
EXECUTE a1;
DEALLOCATE PREPARE a1;
*/