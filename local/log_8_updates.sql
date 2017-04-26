USE blis_8;

2012-05-24 17:16:33	CREATE TABLE `comment` (
   `id` int(10) unsigned not null auto_increment,
   `username` varchar(45) not null,
   `page` varchar(45) not null,
   `comment` varchar(150) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;
2012-05-24 17:16:33	

CREATE TABLE `custom_field_type` (
   `id` int(11) unsigned not null auto_increment,
   `field_type` varchar(45),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:33	

CREATE TABLE `delay_measures` (
   `User_Id` varchar(50) not null,
   `IP_Address` varchar(16) not null,
   `Latency` int(11) not null default '0',
   `Recorded_At` datetime not null default '0000-00-00 00:00:00',
   `Page_Name` varchar(45),
   `Request_URI` varchar(100)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:34	

CREATE TABLE `lab_config` (
   `lab_config_id` int(10) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `location` varchar(45) not null,
   `admin_user_id` int(10) unsigned not null, 
   `id_mode` INTEGER UNSIGNED NOT NULL DEFAULT 2, 
   `db_name` varchar(45),
   PRIMARY KEY (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:34	

CREATE TABLE `lab_config_access` (
  `user_id` INTEGER UNSIGNED NOT NULL,
  `lab_config_id` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `lab_config_id`)
) ENGINE = InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:34	

CREATE TABLE `lab_config_specimen_type` (
   `lab_config_id` int(10) unsigned not null,
   `specimen_type_id` int(10) unsigned not null
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:35	

CREATE TABLE `lab_config_test_type` (
   `lab_config_id` int(10) unsigned not null,
   `test_type_id` int(10) unsigned not null
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:35	

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:35	

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:36	

CREATE TABLE `patient_custom_data` (
   `id` int(11) unsigned not null auto_increment,
   `field_id` int(11) unsigned not null,
   `patient_id` int(11) unsigned not null,
   `field_value` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_id` (`field_id`),
   KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:37	


CREATE TABLE `patient_custom_field` (
   `id` int(11) unsigned not null auto_increment,
   `field_name` varchar(45) not null,
   `field_options` varchar(45) not null,
   `field_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:37	

CREATE TABLE `patient_daily` (
   `datestring` varchar(45) not null,
   `count` int(10) unsigned not null
) ENGINE=InnoDB;
2012-05-24 17:16:38	

CREATE TABLE `reference_range` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `measure_id` INTEGER UNSIGNED NOT NULL,
  `age_min` VARCHAR(45),
  `age_max` VARCHAR(45),
  `sex` VARCHAR(10),
  `range_lower` VARCHAR(45) NOT NULL,
  `range_upper` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
2012-05-24 17:16:38	

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
   `landscape` int(10) unsigned not null default 0,
   PRIMARY KEY (`report_id`)
) ENGINE=InnoDB;
2012-05-24 17:16:39	

INSERT INTO `report_config` (`report_id`, `header`, `footer`, `margins`, `p_fields`, `s_fields`, `t_fields`, `p_custom_fields`, `s_custom_fields`) VALUES 
('1', 'Patient Report', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('2', 'Specimen Report', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('3', 'Test Records', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('4', 'Daily Log - Specimens', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('5', 'Worksheet', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', ''),
('6', 'Daily Log - Patients', '', '2,0,10,0', '1,1,1,1,1,1,1', '1,1,1,1,1,1', '1,0,1,1,1,0,1,1', '', '');
2012-05-24 17:16:39	

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
) ENGINE=InnoDB;
2012-05-24 17:16:39	

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:40	

CREATE TABLE `specimen_custom_data` (
   `id` int(11) unsigned not null auto_increment,
   `field_id` int(11) unsigned not null,
   `specimen_id` int(10) unsigned not null,
   `field_value` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_id` (`field_id`),
   KEY `specimen_id` (`specimen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:40	

CREATE TABLE `specimen_custom_field` (
   `id` int(11) unsigned not null auto_increment,
   `field_name` varchar(45) not null,
   `field_options` varchar(45) not null,
   `field_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:41	

CREATE TABLE `specimen_test` (
   `test_type_id` int(11) unsigned not null,
   `specimen_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `test_type_id` (`test_type_id`),
   KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:41	

CREATE TABLE `specimen_type` (
   `specimen_type_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `disabled` int(10) unsigned default 0,
   PRIMARY KEY (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:41	

CREATE TABLE `specimen_session` (
  `session_num` VARCHAR(45) NOT NULL,
  `count` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`session_num`)
) ENGINE=InnoDB;
2012-05-24 17:16:42	

CREATE TABLE `stock_content` (
   `name` VARCHAR(64),
   `current_quantity` INT(11),
   `date_of_use` date NOT NULL,
   `receiver` VARCHAR(64),
   `remarks` TEXT,
   `lot_number` VARCHAR(64),
   `new_balance` INT(11),
   `user_name` VARCHAR(64)
) ENGINE=InnoDB;
2012-05-24 17:16:42	

CREATE TABLE `stock_details` (
	`name` VARCHAR(64),
	`lot_number` VARCHAR(64),
	`expiry_date` VARCHAR(64),
	`manufacturer` VARCHAR(64),
	`quantity_ordered` INT(11),
	`supplier` VARCHAR(64),
	`date_of_reception` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`current_quantity` INT(11),
	`date_of_supply` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`quantity_supplied` INT(11),
	`unit` VARCHAR(10), 
	`entry_id` INT(11), 
	`cost_per_unit` DECIMAL(10,0),
	`quantity_used` INT(10)
) ENGINE=InnoDB;
2012-05-24 17:16:42	

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:43	

CREATE TABLE `test_category` (
   `test_category_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:43	

INSERT INTO `test_category` (`test_category_id`, `name`) VALUES(1, 'HIV');
2012-05-24 17:16:44	

CREATE TABLE `test_type` (
   `test_type_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `test_category_id` int(11) unsigned not null,
   `is_panel` INTEGER UNSIGNED, 
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `disabled` INT(10) unsigned not null,
   `clinical_data` longtext,
   `hide_patient_name` int(1),
   `prevalence_threshold` int(3) default 70,
   `target_tat` int(3) default 24,
   PRIMARY KEY (`test_type_id`),
   KEY `test_category_id` (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:45	

CREATE TABLE `test_type_measure` (
   `test_type_id` int(11) unsigned not null,
   `measure_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `test_type_id` (`test_type_id`),
   KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:46	

CREATE TABLE `unit` (
   `unit_id` int(11) unsigned not null auto_increment,
   `unit` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:46	

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
   `phone` varchar(45),
   `lang_id` varchar(45),
   PRIMARY KEY (`user_id`),
   KEY `user_id_index` (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
2012-05-24 17:16:46	

CREATE TABLE `user_props` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
2012-05-24 17:16:47	

CREATE TABLE `user_rating` (
  `user_id` INTEGER UNSIGNED NOT NULL,
  `rating` INTEGER UNSIGNED NOT NULL,
  `ts` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `ts`)
) ENGINE = InnoDB;
2012-05-24 17:16:47	

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
) ENGINE=InnoDB;
2012-05-24 17:16:48	

CREATE TABLE `worksheet_custom_test` (
  `worksheet_id` INTEGER UNSIGNED NOT NULL,
  `test_type_id` INTEGER UNSIGNED NOT NULL,
  `measure_id` INTEGER UNSIGNED NOT NULL,
  `width` VARCHAR(45) NOT NULL
) ENGINE=InnoDB;
2012-05-24 17:16:48	

CREATE TABLE `worksheet_custom_userfield` (
	`worksheet_id` INT(10) UNSIGNED NOT NULL,
	`name` VARCHAR(64) NOT NULL,
	`width` INT(10) UNSIGNED NOT NULL,
	`field_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT
) ENGINE=InnoDB;
2012-05-24 17:16:48	;
