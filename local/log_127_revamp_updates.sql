USE blis_revamp;

UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1', location='GT', admin_user_id=53, id_mode=1 WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
UPDATE lab_config SET name='Testlab1' WHERE lab_config_id=127;
UPDATE lab_config SET location='GT' WHERE lab_config_id=127;
2012-05-24 17:24:58	DELETE FROM lab_config_access WHERE lab_config_id=127
2012-05-24 17:24:58	DELETE FROM user WHERE lab_config_id=127
2012-05-24 17:24:58	DELETE FROM report_disease WHERE lab_config_id=127
2012-05-24 17:24:58	DELETE FROM lab_config WHERE lab_config_id=127
2012-05-24 17:30:32	DELETE FROM lab_config_access WHERE lab_config_id=127
2012-05-24 17:30:32	DELETE FROM user WHERE lab_config_id=127
2012-05-24 17:30:32	DELETE FROM report_disease WHERE lab_config_id=127
2012-05-24 17:30:32	DELETE FROM lab_config WHERE lab_config_id=127
2013-09-19 01:16:47	CREATE TABLE IF NOT EXISTS `misc` (
  `username` varchar(20) collate latin1_general_ci default NULL,
  `action` varchar(40) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	

insert into misc (username, action) values ("initial","password reset completed");
2013-09-19 01:16:47	

CREATE TABLE IF NOT EXISTS `global_measures` (
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(128) collate latin1_general_ci default NULL,
  `range` varchar(1024) collate latin1_general_ci default NULL,
  `test_id` int(10) NOT NULL default '0',
  `measure_id` int(10) NOT NULL default '0',
  `unit` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`,`test_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `infection_report_settings` (
  `id` int(10) unsigned NOT NULL default '0',
  `group_by_age` int(10) unsigned default NULL,
  `group_by_gender` int(10) unsigned default NULL,
  `age_groups` varchar(512) collate latin1_general_ci default NULL,
  `measure_groups` varchar(512) collate latin1_general_ci default NULL,
  `measure_id` int(10) default NULL,
  `user_id` int(11) NOT NULL default '0',
  `test_id` int(10) default NULL,
  PRIMARY KEY  (`user_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `lab_config` (
  `lab_config_id` int(10) unsigned NOT NULL auto_increment,
  `name` char(45) NOT NULL default '',
  `location` char(45) NOT NULL default '',
  `admin_user_id` int(10) unsigned NOT NULL default '0',
  `db_name` char(45) NOT NULL default '',
  `id_mode` int(10) unsigned NOT NULL default '2',
  `p_addl` int(10) unsigned NOT NULL default '0',
  `s_addl` int(10) unsigned NOT NULL default '0',
  `daily_num` int(10) unsigned NOT NULL default '1',
  `pid` int(10) unsigned NOT NULL default '2',
  `pname` int(10) unsigned NOT NULL default '1',
  `sex` int(10) unsigned NOT NULL default '2',
  `age` int(10) unsigned NOT NULL default '1',
  `dob` int(10) unsigned NOT NULL default '1',
  `sid` int(10) unsigned NOT NULL default '2',
  `refout` int(10) unsigned NOT NULL default '1',
  `rdate` int(10) unsigned NOT NULL default '2',
  `comm` int(10) unsigned NOT NULL default '1',
  `dformat` varchar(45) NOT NULL default 'd-m-Y',
  `dnum_reset` int(10) unsigned NOT NULL default '1',
  `doctor` int(10) unsigned NOT NULL default '1',
  `country` varchar(512) default NULL,
  PRIMARY KEY  (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `specimen_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `test_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `measure_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `measure_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_measure_id` varchar(256) collate latin1_general_ci default NULL,
  `measure_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `reference_range_global` (
  `measure_id` int(10) NOT NULL default '0',
  `age_min` varchar(64) collate latin1_general_ci default NULL,
  `age_max` varchar(64) collate latin1_general_ci default NULL,
  `sex` varchar(64) collate latin1_general_ci default NULL,
  `range_lower` varchar(64) collate latin1_general_ci default NULL,
  `range_upper` varchar(64) collate latin1_general_ci default NULL,
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `specimen_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `specimen_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_specimen_id` varchar(256) collate latin1_general_ci default NULL,
  `specimen_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `test_category_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_category_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_category_id` varchar(256) collate latin1_general_ci default NULL,
  `test_category_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `test_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_id` varchar(256) collate latin1_general_ci default NULL,
  `test_id` int(10) unsigned NOT NULL default '0',
  `test_category_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`user_id`,`test_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `actualname` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `created_by` int(11) unsigned default NULL,
  `ts` timestamp NOT NULL default '0000-00-00 00:00:00',
  `lab_config_id` int(11) unsigned default NULL,
  `level` int(11) unsigned default NULL,
  `phone` varchar(45) default NULL,
  `lang_id` varchar(45) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2013-09-19 01:16:47	

CREATE TABLE IF NOT EXISTS `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `status` int(11) default NULL,
  `user_id` int(11) default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `i_ts` timestamp NULL default NULL,
  `u_ts` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	

CREATE TABLE IF NOT EXISTS `import_log` (
  `id` int(11) NOT NULL auto_increment,
  `lab_config_id` int(10) NOT NULL,
  `successful` int(1) default NULL,
  `flag` int(1) default NULL,
  `user_id` int(11) default NULL,
  `country` varchar(100) collate latin1_general_ci default NULL,
  `lab_name` varchar(100) collate latin1_general_ci default NULL,
  `db_name` varchar(100) collate latin1_general_ci default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `status` int(11) default NULL,
  `user_id` int(11) default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `i_ts` timestamp NULL default NULL,
  `u_ts` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	


CREATE TABLE IF NOT EXISTS `map_coordinates` (
  `id` int(11) NOT NULL auto_increment,
  `lab_id` int(11) NOT NULL,
  `coordinates` varchar(100) collate latin1_general_ci default NULL,
  `user_id` int(11) default NULL,
  `flag` int(11) default '1',
  `country` varchar(110) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:47	

;
2013-09-19 01:16:54	CREATE TABLE IF NOT EXISTS `misc` (
  `username` varchar(20) collate latin1_general_ci default NULL,
  `action` varchar(40) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	

insert into misc (username, action) values ("initial","password reset completed");
2013-09-19 01:16:54	

CREATE TABLE IF NOT EXISTS `global_measures` (
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(128) collate latin1_general_ci default NULL,
  `range` varchar(1024) collate latin1_general_ci default NULL,
  `test_id` int(10) NOT NULL default '0',
  `measure_id` int(10) NOT NULL default '0',
  `unit` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`,`test_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `infection_report_settings` (
  `id` int(10) unsigned NOT NULL default '0',
  `group_by_age` int(10) unsigned default NULL,
  `group_by_gender` int(10) unsigned default NULL,
  `age_groups` varchar(512) collate latin1_general_ci default NULL,
  `measure_groups` varchar(512) collate latin1_general_ci default NULL,
  `measure_id` int(10) default NULL,
  `user_id` int(11) NOT NULL default '0',
  `test_id` int(10) default NULL,
  PRIMARY KEY  (`user_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `lab_config` (
  `lab_config_id` int(10) unsigned NOT NULL auto_increment,
  `name` char(45) NOT NULL default '',
  `location` char(45) NOT NULL default '',
  `admin_user_id` int(10) unsigned NOT NULL default '0',
  `db_name` char(45) NOT NULL default '',
  `id_mode` int(10) unsigned NOT NULL default '2',
  `p_addl` int(10) unsigned NOT NULL default '0',
  `s_addl` int(10) unsigned NOT NULL default '0',
  `daily_num` int(10) unsigned NOT NULL default '1',
  `pid` int(10) unsigned NOT NULL default '2',
  `pname` int(10) unsigned NOT NULL default '1',
  `sex` int(10) unsigned NOT NULL default '2',
  `age` int(10) unsigned NOT NULL default '1',
  `dob` int(10) unsigned NOT NULL default '1',
  `sid` int(10) unsigned NOT NULL default '2',
  `refout` int(10) unsigned NOT NULL default '1',
  `rdate` int(10) unsigned NOT NULL default '2',
  `comm` int(10) unsigned NOT NULL default '1',
  `dformat` varchar(45) NOT NULL default 'd-m-Y',
  `dnum_reset` int(10) unsigned NOT NULL default '1',
  `doctor` int(10) unsigned NOT NULL default '1',
  `country` varchar(512) default NULL,
  PRIMARY KEY  (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `specimen_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `test_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `measure_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `measure_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_measure_id` varchar(256) collate latin1_general_ci default NULL,
  `measure_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `reference_range_global` (
  `measure_id` int(10) NOT NULL default '0',
  `age_min` varchar(64) collate latin1_general_ci default NULL,
  `age_max` varchar(64) collate latin1_general_ci default NULL,
  `sex` varchar(64) collate latin1_general_ci default NULL,
  `range_lower` varchar(64) collate latin1_general_ci default NULL,
  `range_upper` varchar(64) collate latin1_general_ci default NULL,
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `specimen_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `specimen_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_specimen_id` varchar(256) collate latin1_general_ci default NULL,
  `specimen_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `test_category_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_category_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_category_id` varchar(256) collate latin1_general_ci default NULL,
  `test_category_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `test_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_id` varchar(256) collate latin1_general_ci default NULL,
  `test_id` int(10) unsigned NOT NULL default '0',
  `test_category_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`user_id`,`test_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `actualname` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `created_by` int(11) unsigned default NULL,
  `ts` timestamp NOT NULL default '0000-00-00 00:00:00',
  `lab_config_id` int(11) unsigned default NULL,
  `level` int(11) unsigned default NULL,
  `phone` varchar(45) default NULL,
  `lang_id` varchar(45) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2013-09-19 01:16:54	

CREATE TABLE IF NOT EXISTS `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `status` int(11) default NULL,
  `user_id` int(11) default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `i_ts` timestamp NULL default NULL,
  `u_ts` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	

CREATE TABLE IF NOT EXISTS `import_log` (
  `id` int(11) NOT NULL auto_increment,
  `lab_config_id` int(10) NOT NULL,
  `successful` int(1) default NULL,
  `flag` int(1) default NULL,
  `user_id` int(11) default NULL,
  `country` varchar(100) collate latin1_general_ci default NULL,
  `lab_name` varchar(100) collate latin1_general_ci default NULL,
  `db_name` varchar(100) collate latin1_general_ci default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `status` int(11) default NULL,
  `user_id` int(11) default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `i_ts` timestamp NULL default NULL,
  `u_ts` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	


CREATE TABLE IF NOT EXISTS `map_coordinates` (
  `id` int(11) NOT NULL auto_increment,
  `lab_id` int(11) NOT NULL,
  `coordinates` varchar(100) collate latin1_general_ci default NULL,
  `user_id` int(11) default NULL,
  `flag` int(11) default '1',
  `country` varchar(110) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2013-09-19 01:16:54	

;
2014-04-07 13:23:51	CREATE TABLE IF NOT EXISTS `misc` (
  `username` varchar(20) collate latin1_general_ci default NULL,
  `action` varchar(40) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	

insert into misc (username, action) values ("initial","password reset completed");
2014-04-07 13:23:51	

CREATE TABLE IF NOT EXISTS `global_measures` (
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(128) collate latin1_general_ci default NULL,
  `range` varchar(1024) collate latin1_general_ci default NULL,
  `test_id` int(10) NOT NULL default '0',
  `measure_id` int(10) NOT NULL default '0',
  `unit` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`,`test_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `infection_report_settings` (
  `id` int(10) unsigned NOT NULL default '0',
  `group_by_age` int(10) unsigned default NULL,
  `group_by_gender` int(10) unsigned default NULL,
  `age_groups` varchar(512) collate latin1_general_ci default NULL,
  `measure_groups` varchar(512) collate latin1_general_ci default NULL,
  `measure_id` int(10) default NULL,
  `user_id` int(11) NOT NULL default '0',
  `test_id` int(10) default NULL,
  PRIMARY KEY  (`user_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `lab_config` (
  `lab_config_id` int(10) unsigned NOT NULL auto_increment,
  `name` char(45) NOT NULL default '',
  `location` char(45) NOT NULL default '',
  `admin_user_id` int(10) unsigned NOT NULL default '0',
  `db_name` char(45) NOT NULL default '',
  `id_mode` int(10) unsigned NOT NULL default '2',
  `p_addl` int(10) unsigned NOT NULL default '0',
  `s_addl` int(10) unsigned NOT NULL default '0',
  `daily_num` int(10) unsigned NOT NULL default '1',
  `pid` int(10) unsigned NOT NULL default '2',
  `pname` int(10) unsigned NOT NULL default '1',
  `sex` int(10) unsigned NOT NULL default '2',
  `age` int(10) unsigned NOT NULL default '1',
  `dob` int(10) unsigned NOT NULL default '1',
  `sid` int(10) unsigned NOT NULL default '2',
  `refout` int(10) unsigned NOT NULL default '1',
  `rdate` int(10) unsigned NOT NULL default '2',
  `comm` int(10) unsigned NOT NULL default '1',
  `dformat` varchar(45) NOT NULL default 'd-m-Y',
  `dnum_reset` int(10) unsigned NOT NULL default '1',
  `doctor` int(10) unsigned NOT NULL default '1',
  `country` varchar(512) default NULL,
  PRIMARY KEY  (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `specimen_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `test_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `measure_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `measure_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_measure_id` varchar(256) collate latin1_general_ci default NULL,
  `measure_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `reference_range_global` (
  `measure_id` int(10) NOT NULL default '0',
  `age_min` varchar(64) collate latin1_general_ci default NULL,
  `age_max` varchar(64) collate latin1_general_ci default NULL,
  `sex` varchar(64) collate latin1_general_ci default NULL,
  `range_lower` varchar(64) collate latin1_general_ci default NULL,
  `range_upper` varchar(64) collate latin1_general_ci default NULL,
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `specimen_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `specimen_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_specimen_id` varchar(256) collate latin1_general_ci default NULL,
  `specimen_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `test_category_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_category_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_category_id` varchar(256) collate latin1_general_ci default NULL,
  `test_category_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `test_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_id` varchar(256) collate latin1_general_ci default NULL,
  `test_id` int(10) unsigned NOT NULL default '0',
  `test_category_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`user_id`,`test_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `actualname` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `created_by` int(11) unsigned default NULL,
  `ts` timestamp NOT NULL default '0000-00-00 00:00:00',
  `lab_config_id` int(11) unsigned default NULL,
  `level` int(11) unsigned default NULL,
  `phone` varchar(45) default NULL,
  `lang_id` varchar(45) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2014-04-07 13:23:51	

CREATE TABLE IF NOT EXISTS `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `status` int(11) default NULL,
  `user_id` int(11) default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `i_ts` timestamp NULL default NULL,
  `u_ts` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	

CREATE TABLE IF NOT EXISTS `import_log` (
  `id` int(11) NOT NULL auto_increment,
  `lab_config_id` int(10) NOT NULL,
  `successful` int(1) default NULL,
  `flag` int(1) default NULL,
  `user_id` int(11) default NULL,
  `country` varchar(100) collate latin1_general_ci default NULL,
  `lab_name` varchar(100) collate latin1_general_ci default NULL,
  `db_name` varchar(100) collate latin1_general_ci default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `status` int(11) default NULL,
  `user_id` int(11) default NULL,
  `remarks` varchar(250) collate latin1_general_ci default NULL,
  `i_ts` timestamp NULL default NULL,
  `u_ts` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	


CREATE TABLE IF NOT EXISTS `map_coordinates` (
  `id` int(11) NOT NULL auto_increment,
  `lab_id` int(11) NOT NULL,
  `coordinates` varchar(100) collate latin1_general_ci default NULL,
  `user_id` int(11) default NULL,
  `flag` int(11) default '1',
  `country` varchar(110) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
2014-04-07 13:23:51	

;
2015-08-26 15:29:27	ALTER TABLE user ADD rwoptions varchar(20) NOT NULL default '2,3,4,6,7';
2015-08-26 15:29:27	;
2015-08-26 15:29:28	create table IF NOT EXISTS `user_config`(
user_id int,
    level int, 
    parameter varchar(256), 
    value varchar(256), 
    created_by varchar(256), 
    created_on date, 
    modified_by varchar(256), 
    modified_on date,
    primary key(user_id, parameter)
);
2015-08-26 15:29:28	

create table IF NOT EXISTS `user_type`(
level int primary key AUTO_INCREMENT, 
    name varchar(256), 
    defaultdisplay boolean default 0,
    created_by varchar(256),     
    created_on timestamp DEFAULT CURRENT_TIMESTAMP
);
2015-08-26 15:29:28	


insert into user_type(name, defaultdisplay, created_by) values('LIS_TECH_RO',1,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_ADMIN',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_SUPERADMIN',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_COUNTRYDIR',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_CLERK',1,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_001',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_010',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_011',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_100',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_101',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_110',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_111',0,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_TECH_SHOWPNAME',1,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_TECH_RW',1,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_VERIFIER',1,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('READONLYMODE',1,'Aishwarya');
2015-08-26 15:29:28	
insert into user_type(name, defaultdisplay, created_by)  values('LIS_PHYSICIAN',1,'Aishwarya');
2015-08-26 15:29:28	

create table IF NOT EXISTS `user_type_config`(
    level int,
    parameter varchar(256), 
    value varchar(256), 
    created_by varchar(256), 
    created_on date, 
    modified_by varchar(256), 
    modified_on timestamp DEFAULT CURRENT_TIMESTAMP,
    primary key(level, parameter)
);
2015-08-26 15:29:28	


insert into user_type_config(level, parameter, value, created_by, modified_by) values (1,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (2,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (3,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (4,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (5,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (6,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (7,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (8,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (9,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (10,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (11,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (12,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (13,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (14,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (15,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (16,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	
insert into user_type_config(level, parameter, value, created_by, modified_by) values (17,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
2015-08-26 15:29:28	

;
2015-08-28 13:17:40	UPDATE lab_config SET daily_num=1 WHERE lab_config_id=127
2015-08-28 13:17:40	UPDATE lab_config SET age=1 WHERE lab_config_id=127
2017-04-18 03:38:38	CREATE TABLE IF NOT EXISTS report_config (
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
2017-04-18 03:38:38	

ALTER TABLE lab_config ADD COLUMN site_choice_enabled BOOLEAN DEFAULT 0;
2017-04-18 03:38:38	


INSERT IGNORE INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, 
landscape, age_unit) VALUES ( 'Grouped Test Count Report Configuration', '0:4,5:9,10:14,15:19,20:24,25:29,29:34,35:39,39:44,45:49,49:54,55:59,59:64,65:+',
'0', '1', '1', '0', '1', '0', '9999009', '0', 9999009, 1);
2017-04-18 03:38:38	

INSERT IGNORE INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, 
landscape, age_unit) VALUES ( 'Grouped Specimen Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+',
'0', '1', '1', '0', '1', '0', '9999019', '0', 9999019, 1);
2017-04-18 03:38:38	
;
2017-04-18 03:38:39	CREATE TABLE IF NOT EXISTS report_config (
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
2017-04-18 03:38:39	

ALTER TABLE lab_config ADD COLUMN site_choice_enabled BOOLEAN DEFAULT 0;
2017-04-18 03:38:39	


INSERT IGNORE INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title,
landscape, age_unit) VALUES ( 'Grouped Test Count Report Configuration', '0:4,5:9,10:14,15:19,20:24,25:29,29:34,35:39,39:44,45:49,49:54,55:59,59:64,65:+',
'0', '1', '1', '0', '1', '0', '9999009', '0', 9999009, 1);
2017-04-18 03:38:39	

INSERT IGNORE INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title,
landscape, age_unit) VALUES ( 'Grouped Specimen Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+',
'0', '1', '1', '0', '1', '0', '9999019', '0', 9999019, 1);
2017-04-18 03:38:39	;
2017-04-24 17:48:17	UPDATE lab_config SET name='Testlab1', location='GT', admin_user_id=53, id_mode=1 WHERE lab_config_id=127
2017-04-24 17:48:35	UPDATE lab_config SET name='Testlab1', location='GT', admin_user_id=53, id_mode=1 WHERE lab_config_id=127
