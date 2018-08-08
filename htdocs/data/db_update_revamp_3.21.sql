CREATE TABLE IF NOT EXISTS report_config (
  report_id int(10) unsigned NOT NULL auto_increment,
  header varchar(500) NOT NULL default '',
  footer varchar(500) NOT NULL default '',
  margins varchar(45) NOT NULL default '',
  p_fields varchar(45) NOT NULL default '',
  s_fields varchar(45) NOT NULL default '',
  t_fields varchar(45) NOT NULL default '',
  p_custom_fields varchar(45) NOT NULL default '',
  s_custom_fields varchar(45) NOT NULL default '',
  test_type_id varchar(45) NOT NULL default '',
  title varchar(500) NOT NULL default '',
  landscape int(10) unsigned NOT NULL default 0,
  age_unit INT(11),
  PRIMARY KEY  (report_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE lab_config ADD COLUMN site_choice_enabled BOOLEAN DEFAULT 0;


INSERT IGNORE INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title,
landscape, age_unit) VALUES ( 'Grouped Test Count Report Configuration', '0:4,5:9,10:14,15:19,20:24,25:29,29:34,35:39,39:44,45:49,49:54,55:59,59:64,65:+',
'0', '1', '1', '0', '1', '0', '9999009', '0', 9999009, 1);

INSERT IGNORE INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title,
landscape, age_unit) VALUES ( 'Grouped Specimen Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+',
'0', '1', '1', '0', '1', '0', '9999019', '0', 9999019, 1);