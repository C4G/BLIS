CREATE TABLE `custom_field_type` (
   `id` int(11) unsigned not null auto_increment,
   `field_type` varchar(45),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `lab_config` (
   `lab_config_id` int(10) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `location` varchar(45) not null,
   `admin_user_id` int(10) unsigned not null, 
   `id_mode` INTEGER UNSIGNED NOT NULL DEFAULT 2, 
   `db_name` varchar(45),
   PRIMARY KEY (`lab_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `lab_config_specimen_type` (
   `lab_config_id` int(10) unsigned not null,
   `specimen_type_id` int(10) unsigned not null
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `lab_config_test_type` (
   `lab_config_id` int(10) unsigned not null,
   `test_type_id` int(10) unsigned not null
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `measure` (
   `measure_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `unit_id` int(10) unsigned,
   `range` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `unit` varchar(30),
   PRIMARY KEY (`measure_id`),
   KEY `unit_id` (`unit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `patient` (
   `patient_id` int(11) unsigned not null,
   `addl_id` varchar(40),
   `name` varchar(45),
   `sex` char(1) not null,
   `age` decimal(10,0),
   `dob` date, 
   `partial_dob` VARCHAR(45), 
   `created_by` int(11) unsigned,
   `surr_id` VARCHAR(45),
   `hash_value` VARCHAR(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`patient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `patient_custom_data` (
   `id` int(11) unsigned not null auto_increment,
   `field_id` int(11) unsigned not null,
   `patient_id` int(11) unsigned not null,
   `field_value` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_id` (`field_id`),
   KEY `patient_id` (`patient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `patient_custom_field` (
   `id` int(11) unsigned not null auto_increment,
   `field_name` varchar(45) not null,
   `field_options` varchar(45) not null,
   `field_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_type_id` (`field_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `privilege` (
   `privilege_id` int(11) unsigned not null auto_increment,
   `privilege` varchar(45) not null,
   `description` varchar(200),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`privilege_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `range` (
   `range_id` int(10) unsigned not null auto_increment,
   `range` varchar(45) not null,
   `comments` varchar(200),
   `measure_id` int(11) unsigned not null,
   `range_type` int(11),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`range_id`),
   KEY `measure_id` (`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `referrer` (
   `referrer_id` int(11) unsigned not null,
   `referrer` varchar(45),
   `email` varchar(45),
   `phone` varchar(45),
   `contact` varchar(45),
   `comments` varchar(45),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`referrer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `role` (
   `role_id` int(11) unsigned not null auto_increment,
   `role` varchar(45) not null,
   `description` varchar(200),
   `created_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`role_id`),
   KEY `created_by` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `role_privilege` (
   `role_id` int(11) unsigned not null,
   `privilege_id` int(11) unsigned not null,
   `assigned_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `privilege_id` (`privilege_id`),
   KEY `role_id` (`role_id`),
   KEY `assigned_by` (`assigned_by`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `specimen` (
   `specimen_id` int(10) unsigned not null,
   `patient_id` int(11) unsigned not null,
   `specimen_type_id` int(11) unsigned not null,
   `user_id` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `status_code_id` int(11) unsigned,
   `referred_to` int(11) unsigned,
   `comments` varchar(450),
   `aux_id` varchar(45),
   `date_collected` date not null,
   `date_recvd` date,
   `session_num` VARCHAR(45),
   `time_collected` VARCHAR(45),
   `report_to` INTEGER UNSIGNED, 
   `doctor` VARCHAR(45), 
   `date_reported` DATETIME, 
   `referred_to_name` VARCHAR(70), 
   `daily_num` varchar(45) not null DEFAULT '',
   PRIMARY KEY (`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `specimen_custom_data` (
   `id` int(11) unsigned not null auto_increment,
   `field_id` int(11) unsigned not null,
   `specimen_id` int(10) unsigned not null,
   `field_value` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_id` (`field_id`),
   KEY `specimen_id` (`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `specimen_custom_field` (
   `id` int(11) unsigned not null auto_increment,
   `field_name` varchar(45) not null,
   `field_options` varchar(45) not null,
   `field_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_type_id` (`field_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `specimen_test` (
   `test_type_id` int(11) unsigned not null,
   `specimen_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `test_type_id` (`test_type_id`),
   KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `specimen_type` (
   `specimen_type_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`specimen_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `status_code` (
   `status_code_id` int(11) unsigned not null,
   `status` varchar(45),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`status_code_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `test` (
   `test_id` int(10) unsigned not null auto_increment,
   `test_type_id` int(11) unsigned not null,
   `result` varchar(201) not null,
   `comments` varchar(200),
   `user_id` int(11) unsigned,
   `verified_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `specimen_id` int(11) unsigned,
   `date_verified` DATETIME,
   PRIMARY KEY (`test_id`),
   KEY `test_type_id` (`test_type_id`),
   KEY `user_id` (`user_id`),
   KEY `specimen_id` (`specimen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `test_category` (
   `test_category_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `test_type` (
   `test_type_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `test_category_id` int(11) unsigned not null,
   `is_panel` INTEGER UNSIGNED, 
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`test_type_id`),
   KEY `test_category_id` (`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `test_type_measure` (
   `test_type_id` int(11) unsigned not null,
   `measure_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `test_type_id` (`test_type_id`),
   KEY `measure_id` (`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `unit` (
   `unit_id` int(11) unsigned not null auto_increment,
   `unit` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`unit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `user` (
   `user_id` int(11) unsigned not null auto_increment,
   `username` varchar(45) not null,
   `password` varchar(45) not null,
   `actualname` varchar(45),
   `email` varchar(45),
   `created_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `lab_config_id` int(10) unsigned,
   `level` int(10) unsigned,
   PRIMARY KEY (`user_id`),
   KEY `user_id_index` (`lab_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `user_role` (
   `user_id` int(11) unsigned not null,
   `role_id` int(11) unsigned not null,
   `assigned_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `role_id` (`role_id`),
   KEY `assigned_by` (`assigned_by`),
   KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `lab_config_access` (
  `user_id` INTEGER UNSIGNED NOT NULL,
  `lab_config_id` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `lab_config_id`)
) ENGINE = MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `comment` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `page` VARCHAR(45) NOT NULL,
  `comment` VARCHAR(150) NOT NULL,
  `ts` timestamp not null default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `Delay_Measures` (
  `User_Id` varchar(50) NOT NULL default '',
  `IP_Address` varchar(16) NOT NULL default '',
  `Latency` int(11) NOT NULL default '0',
  `Recorded_At` datetime NOT NULL default '0000-00-00 00:00:00',
  `Page_Name` varchar(45) default NULL,
  `Request_URI` varchar(100) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `User_Props` (
  `User_Id` varchar(50) NOT NULL default '',
  `AppCodeName` varchar(25) NOT NULL default '',
  `AppName` varchar(25) NOT NULL default '',
  `AppVersion` varchar(25) NOT NULL default '',
  `CookieEnabled` tinyint(1) NOT NULL default '0',
  `Platform` varchar(20) NOT NULL default '',
  `UserAgent` varchar(200) NOT NULL default '',
  `SystemLanguage` varchar(15) NOT NULL default '',
  `UserLanguage` varchar(15) NOT NULL default '',
  `Language` varchar(15) NOT NULL default '',
  `ScreenAvailHeight` int(11) NOT NULL default '0',
  `ScreenAvailWidth` int(11) NOT NULL default '0',
  `ScreenColorDepth` int(11) NOT NULL default '0',
  `ScreenHeight` int(11) NOT NULL default '0',
  `ScreenWidth` int(11) NOT NULL default '0',
  `Recorded_At` datetime NOT NULL default '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `specimen_session` (
  `session_num` VARCHAR(45) NOT NULL,
  `count` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`session_num`)
)
ENGINE = MyISAM;

CREATE TABLE `test_type_tat` (
  `test_type_id` INTEGER UNSIGNED NOT NULL,
  `tat` FLOAT NOT NULL, 
  `ts` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
ENGINE = MyISAM;

CREATE TABLE `report` (
  `report_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `group_by_gender` BOOLEAN NOT NULL,
  `group_by_age` BOOLEAN NOT NULL,
  `age_slots` VARCHAR(45),
  PRIMARY KEY (`report_id`)
)
ENGINE = MyISAM;

CREATE TABLE  `report_disease` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_by_age` int(10) unsigned NOT NULL,
  `group_by_gender` int(10) unsigned NOT NULL,
  `age_groups` varchar(500) default NULL,
  `measure_groups` varchar(500) default NULL,
  `measure_id` int(10) unsigned NOT NULL,
  `lab_config_id` int(10) unsigned NOT NULL,
  `test_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`id`)
)
ENGINE=MyISAM;

CREATE TABLE `patient_daily` (
   `datestring` varchar(45) not null,
   `count` int(10) unsigned not null
) 
ENGINE=MyISAM;

CREATE TABLE `user_rating` (
  `user_id` INTEGER UNSIGNED NOT NULL,
  `rating` INTEGER UNSIGNED NOT NULL,
  `ts` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `ts`)
)
ENGINE = MyISAM;

CREATE TABLE `report_config` (
   `report_id` int(10) unsigned not null AUTO_INCREMENT,
   `header` varchar(500) not null,
   `footer` varchar(250) not null default '',
   `margins` varchar(45) not null default '2,0,10,0',
   `p_fields` varchar(45) not null default '1,1,1,1,1,1,1',
   `s_fields` varchar(45) not null default '1,1,1,1,1,1',
   `t_fields` varchar(45) not null default '1,0,1,1,1,0,1,1',
   `p_custom_fields` varchar(45) not null,
   `s_custom_fields` varchar(45) not null,
   `test_type_id` VARCHAR(45) not null default '0',
   `title` VARCHAR(250) NOT NULL DEFAULT '',
   PRIMARY KEY (`report_id`)
) 
ENGINE=MyISAM;

INSERT INTO `report_config` (`report_id`, `header`, `footer`, `margins`, `p_fields`, `s_fields`, `t_fields`, `p_custom_fields`, `s_custom_fields`) VALUES 
('1', 'Patient Report', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('2', 'Specimen Report', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('3', 'Test Records', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('4', 'Daily Log - Specimens', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('5', 'Worksheet', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('6', 'Daily Log - Patients', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', '');

CREATE TABLE `worksheet_custom` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `header` VARCHAR(500) NOT NULL,
  `footer` VARCHAR(250) NOT NULL,
  `title` VARCHAR(250) NOT NULL,
  `p_fields` VARCHAR(100) NOT NULL,
  `s_fields` VARCHAR(100) NOT NULL,
  `t_fields` VARCHAR(100) NOT NULL,
  `p_custom` VARCHAR(100) NOT NULL,
  `s_custom` VARCHAR(100) NOT NULL,
  `margins` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=MyISAM;

CREATE TABLE `worksheet_custom_test` (
  `worksheet_id` INTEGER UNSIGNED NOT NULL,
  `test_type_id` INTEGER UNSIGNED NOT NULL,
  `measure_id` INTEGER UNSIGNED NOT NULL,
  `width` VARCHAR(45) NOT NULL
)
ENGINE=MyISAM;

CREATE TABLE `reference_range` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `measure_id` INTEGER UNSIGNED NOT NULL,
  `age_min` VARCHAR(45),
  `age_max` VARCHAR(45),
  `sex` VARCHAR(10),
  `range_lower` VARCHAR(45) NOT NULL,
  `range_upper` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE = MyISAM;