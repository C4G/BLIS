--
-- MySQL 5.0.67
-- Thu, 14 Jan 2010 17:39:27 +0000
--

CREATE TABLE `custom_field_type` (
   `id` int(11) unsigned not null auto_increment,
   `field_type` varchar(45),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `custom_field_type` is empty]

CREATE TABLE `lab_config` (
   `lab_config_id` int(10) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `location` varchar(45) not null,
   `admin_user_id` int(10) unsigned not null,
   `db_name` varchar(45),
   PRIMARY KEY (`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `lab_config` is empty]

CREATE TABLE `lab_config_access` (
   `user_id` int(10) unsigned not null,
   `lab_config_id` int(10) unsigned not null,
   PRIMARY KEY (`user_id`,`lab_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `lab_config_access` is empty]

CREATE TABLE `lab_config_specimen_type` (
   `lab_config_id` int(10) unsigned not null,
   `specimen_type_id` int(10) unsigned not null
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `lab_config_specimen_type` is empty]

CREATE TABLE `lab_config_test_type` (
   `lab_config_id` int(10) unsigned not null,
   `test_type_id` int(10) unsigned not null
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `lab_config_test_type` is empty]

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

-- [Table `measure` is empty]

CREATE TABLE `patient` (
   `patient_id` int(11) unsigned not null,
   `addl_id` varchar(40),
   `name` varchar(45),
   `sex` char(1) not null,
   `age` decimal(10,0),
   `dob` date,
   `created_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`patient_id`),
   KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `patient` (`patient_id`, `addl_id`, `name`, `sex`, `age`, `dob`, `created_by`, `ts`) VALUES 
('1', '1', 'John John', 'M', '0', '1986-01-15', '', '2010-01-13 14:19:39'),
('2', '2', 'David Davi', 'M', '0', '1987-12-21', '', '2010-01-13 14:22:02'),
('3', '3', 'Mark Mark', 'M', '0', '1996-01-10', '', '2010-01-13 14:28:45'),
('4', '4', 'Luke Skywalker', 'M', '0', '2001-01-07', '', '2010-01-13 14:30:33');

CREATE TABLE `patient_custom_data` (
   `id` int(11) unsigned not null auto_increment,
   `field_id` int(11) unsigned not null,
   `patient_id` int(11) unsigned not null,
   `field_value` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_id` (`field_id`),
   KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7;

INSERT INTO `patient_custom_data` (`id`, `field_id`, `patient_id`, `field_value`, `ts`) VALUES 
('1', '1', '4', '2010-01-13', '2010-01-13 14:30:33'),
('2', '2', '4', 'Single', '2010-01-13 14:30:33'),
('3', '3', '4', 'County4', '2010-01-13 14:30:33'),
('4', '1', '1', '2009-12-12', '2010-01-14 07:44:04'),
('5', '2', '1', 'Divorced', '2010-01-14 07:44:04'),
('6', '3', '1', 'County1', '2010-01-14 07:44:04');

CREATE TABLE `patient_custom_field` (
   `id` int(11) unsigned not null auto_increment,
   `field_name` varchar(45) not null,
   `field_options` varchar(45) not null,
   `field_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;

INSERT INTO `patient_custom_field` (`id`, `field_name`, `field_options`, `field_type_id`, `ts`) VALUES 
('1', 'Join Date', '', '2', '2010-01-13 14:00:14'),
('2', 'Marital Status', 'Single/Married/Divorced', '3', '2010-01-13 14:00:14'),
('3', 'County', '', '1', '2010-01-13 14:00:14');

CREATE TABLE `privilege` (
   `privilege_id` int(11) unsigned not null auto_increment,
   `privilege` varchar(45) not null,
   `description` varchar(200),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `privilege` is empty]

CREATE TABLE `range` (
   `range_id` int(10) unsigned not null auto_increment,
   `range` varchar(45) not null,
   `comments` varchar(200),
   `measure_id` int(11) unsigned not null,
   `range_type` int(11),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`range_id`),
   KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `range` is empty]

CREATE TABLE `referrer` (
   `referrer_id` int(11) unsigned not null,
   `referrer` varchar(45),
   `email` varchar(45),
   `phone` varchar(45),
   `contact` varchar(45),
   `comments` varchar(45),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`referrer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `referrer` is empty]

CREATE TABLE `role` (
   `role_id` int(11) unsigned not null auto_increment,
   `role` varchar(45) not null,
   `description` varchar(200),
   `created_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`role_id`),
   KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `role` is empty]

CREATE TABLE `role_privilege` (
   `role_id` int(11) unsigned not null,
   `privilege_id` int(11) unsigned not null,
   `assigned_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `privilege_id` (`privilege_id`),
   KEY `role_id` (`role_id`),
   KEY `assigned_by` (`assigned_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `role_privilege` is empty]

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
   PRIMARY KEY (`specimen_id`),
   KEY `patient_id` (`patient_id`),
   KEY `specimen_type_id` (`specimen_type_id`),
   KEY `user_id` (`user_id`),
   KEY `status_code_id` (`status_code_id`),
   KEY `referred_to` (`referred_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `specimen` (`specimen_id`, `patient_id`, `specimen_type_id`, `user_id`, `ts`, `status_code_id`, `referred_to`, `comments`, `aux_id`, `date_collected`, `date_recvd`) VALUES 
('1', '2', '6', '44', '2010-01-14 07:56:07', '1', '0', 'Urgent', 'a1', '2010-01-14', '2010-01-14'),
('2', '1', '6', '44', '2010-01-14 08:03:39', '1', '0', '				', 'a2', '2010-01-14', '2010-01-14'),
('3', '4', '6', '44', '2010-01-14 08:48:22', '0', '0', '				', 'a3', '2010-01-14', '2010-01-14'),
('4', '1', '6', '44', '2010-01-14 11:50:42', '0', '0', '				', 'a4', '2010-01-14', '2010-01-14');

CREATE TABLE `specimen_custom_data` (
   `id` int(11) unsigned not null auto_increment,
   `field_id` int(11) unsigned not null,
   `specimen_id` int(10) unsigned not null,
   `field_value` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_id` (`field_id`),
   KEY `specimen_id` (`specimen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

INSERT INTO `specimen_custom_data` (`id`, `field_id`, `specimen_id`, `field_value`, `ts`) VALUES 
('1', '1', '1', '2010-01-14', '2010-01-14 07:56:07'),
('2', '1', '2', '2010-01-14', '2010-01-14 08:03:39'),
('3', '1', '3', '2010-01-14', '2010-01-14 08:48:22'),
('4', '1', '4', '2010-01-14', '2010-01-14 11:50:42');

CREATE TABLE `specimen_custom_field` (
   `id` int(11) unsigned not null auto_increment,
   `field_name` varchar(45) not null,
   `field_options` varchar(45) not null,
   `field_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;

INSERT INTO `specimen_custom_field` (`id`, `field_name`, `field_options`, `field_type_id`, `ts`) VALUES 
('1', 'Referred Date', '', '2', '2010-01-13 14:00:14');

CREATE TABLE `specimen_test` (
   `test_type_id` int(11) unsigned not null,
   `specimen_type_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `test_type_id` (`test_type_id`),
   KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `specimen_test` is empty]

CREATE TABLE `specimen_type` (
   `specimen_type_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`specimen_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `specimen_type` is empty]

CREATE TABLE `status_code` (
   `status_code_id` int(11) unsigned not null,
   `status` varchar(45),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`status_code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `status_code` is empty]

CREATE TABLE `test` (
   `test_id` int(10) unsigned not null auto_increment,
   `test_type_id` int(11) unsigned not null,
   `result` varchar(45) not null,
   `comments` varchar(200),
   `user_id` int(11) unsigned,
   `verified_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `specimen_id` int(11) unsigned,
   PRIMARY KEY (`test_id`),
   KEY `test_type_id` (`test_type_id`),
   KEY `user_id` (`user_id`),
   KEY `specimen_id` (`specimen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

INSERT INTO `test` (`test_id`, `test_type_id`, `result`, `comments`, `user_id`, `verified_by`, `ts`, `specimen_id`) VALUES 
('1', '7', '990,80,', 'High value range', '44', '44', '2010-01-14 07:56:07', '1'),
('2', '7', '100,10,', 'Low value range', '44', '44', '2010-01-14 08:03:39', '2'),
('3', '7', '', '', '44', '0', '2010-01-14 08:48:22', '3'),
('4', '7', '', '', '44', '0', '2010-01-14 11:50:42', '4');

CREATE TABLE `test_category` (
   `test_category_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `test_category` is empty]

CREATE TABLE `test_type` (
   `test_type_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `test_category_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`test_type_id`),
   KEY `test_category_id` (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `test_type` is empty]

CREATE TABLE `test_type_measure` (
   `test_type_id` int(11) unsigned not null,
   `measure_id` int(11) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `test_type_id` (`test_type_id`),
   KEY `measure_id` (`measure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `test_type_measure` is empty]

CREATE TABLE `unit` (
   `unit_id` int(11) unsigned not null auto_increment,
   `unit` varchar(45) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `unit` is empty]

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- [Table `user` is empty]

CREATE TABLE `user_role` (
   `user_id` int(11) unsigned not null,
   `role_id` int(11) unsigned not null,
   `assigned_by` int(11) unsigned,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `role_id` (`role_id`),
   KEY `assigned_by` (`assigned_by`),
   KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- [Table `user_role` is empty]