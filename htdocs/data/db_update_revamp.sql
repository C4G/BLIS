CREATE TABLE IF NOT EXISTS `misc` (
  `username` varchar(20) collate latin1_general_ci default NULL,
  `action` varchar(40) collate latin1_general_ci default NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

insert into misc (username, action) values ("initial","password reset completed");

CREATE TABLE IF NOT EXISTS `global_measures` (
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(128) collate latin1_general_ci default NULL,
  `range` varchar(1024) collate latin1_general_ci default NULL,
  `test_id` int(10) NOT NULL default '0',
  `measure_id` int(10) NOT NULL default '0',
  `unit` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`,`test_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


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


CREATE TABLE IF NOT EXISTS `lab_config_access` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `lab_config_specimen_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `specimen_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `lab_config_test_type` (
  `lab_config_id` int(10) unsigned NOT NULL default '0',
  `test_type_id` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `measure_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `measure_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_measure_id` varchar(256) collate latin1_general_ci default NULL,
  `measure_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


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


CREATE TABLE IF NOT EXISTS `specimen_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `specimen_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_specimen_id` varchar(256) collate latin1_general_ci default NULL,
  `specimen_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `test_category_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_category_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_category_id` varchar(256) collate latin1_general_ci default NULL,
  `test_category_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `test_mapping` (
  `user_id` int(11) NOT NULL default '0',
  `test_name` varchar(256) collate latin1_general_ci default NULL,
  `lab_id_test_id` varchar(256) collate latin1_general_ci default NULL,
  `test_id` int(10) unsigned NOT NULL default '0',
  `test_category_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`user_id`,`test_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


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


CREATE TABLE IF NOT EXISTS `map_coordinates` (
  `id` int(11) NOT NULL auto_increment,
  `lab_id` int(11) NOT NULL,
  `coordinates` varchar(100) collate latin1_general_ci default NULL,
  `user_id` int(11) default NULL,
  `flag` int(11) default '1',
  `country` varchar(110) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

