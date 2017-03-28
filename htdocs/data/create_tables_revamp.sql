--
-- MySQL 5.0.41
-- Wed, 26 May 2010 09:49:05 +0000
--

CREATE TABLE `comment` (
   `id` int(10) unsigned not null auto_increment,
   `username` varchar(45) not null,
   `page` varchar(45) not null,
   `comment` varchar(150) not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;


CREATE TABLE `custom_field_type` (
   `id` int(11) unsigned not null auto_increment,
   `field_type` varchar(45),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;


CREATE TABLE `delay_measures` (
   `User_Id` varchar(50) not null,
   `IP_Address` varchar(16) not null,
   `Latency` int(11) not null default '0',
   `Recorded_At` datetime not null default '0000-00-00 00:00:00',
   `Page_Name` varchar(45),
   `Request_URI` varchar(100)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `lab_config` (
   `lab_config_id` int(10) unsigned not null auto_increment,
   `name` char(45) not null,
   `location` char(45) not null,
   `admin_user_id` int(10) unsigned not null default '0',
   `db_name` char(45) not null,
   `id_mode` int(10) unsigned not null default '2',
   `p_addl` int(10) unsigned not null default '0',
   `s_addl` int(10) unsigned not null default '0',
   `daily_num` int(10) unsigned not null default '1',
   `pid` int(10) unsigned not null default '2',
   `pname` int(10) unsigned not null default '1',
   `sex` int(10) unsigned not null default '2',
   `age` int(10) unsigned not null default '1',
   `dob` int(10) unsigned not null default '1',
   `sid` int(10) unsigned not null default '2',
   `refout` int(10) unsigned not null default '1',
   `rdate` int(10) unsigned not null default '2',
   `comm` int(10) unsigned not null default '1',
   `dformat` varchar(45) not null default 'd-m-Y',
   `dnum_reset` int(10) unsigned not null default '1',
   `doctor` int(10) unsigned not null default '1',
   'site_choice_enabled' boolean default '0',
   PRIMARY KEY (`lab_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=213;

CREATE TABLE report_config (
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
  age_unit INT(11)
  PRIMARY KEY  (report_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `lab_config_access` (
   `user_id` int(10) unsigned not null default '0',
   `lab_config_id` int(10) unsigned not null default '0',
   PRIMARY KEY (`user_id`,`lab_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `lab_config_specimen_type` (
   `lab_config_id` int(10) unsigned not null default '0',
   `specimen_type_id` int(10) unsigned not null default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `lab_config_test_type` (
   `lab_config_id` int(10) unsigned not null default '0',
   `test_type_id` int(10) unsigned not null default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `measure` (
   `measure_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `unit_id` int(10) unsigned,
   `range` varchar(500) not null,
   `description` varchar(500),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `unit` varchar(30),
   PRIMARY KEY (`measure_id`),
   KEY `unit_id` (`unit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=97;


CREATE TABLE `report_disease` (
   `id` int(10) unsigned not null auto_increment,
   `group_by_age` int(10) unsigned not null,
   `group_by_gender` int(10) unsigned not null,
   `age_groups` varchar(500),
   `measure_groups` varchar(500),
   `measure_id` int(10) unsigned not null,
   `lab_config_id` int(10) unsigned not null,
   `test_type_id` int(10) unsigned not null,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1559;


CREATE TABLE `specimen_test` (
   `test_type_id` int(11) unsigned not null default '0',
   `specimen_type_id` int(11) unsigned not null default '0',
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   KEY `test_type_id` (`test_type_id`),
   KEY `specimen_type_id` (`specimen_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `specimen_type` (
   `specimen_type_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `disabled` int(10) unsigned not null default '0',
   PRIMARY KEY (`specimen_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=23;


CREATE TABLE `test_category` (
   `test_category_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=12;


CREATE TABLE `test_type` (
   `test_type_id` int(11) unsigned not null auto_increment,
   `name` varchar(45) not null,
   `description` varchar(100),
   `test_category_id` int(11) unsigned not null default '0',
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   `is_panel` int(10) unsigned,
   `disabled` int(10) unsigned not null default '0',
   PRIMARY KEY (`test_type_id`),
   KEY `test_category_id` (`test_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=93;


CREATE TABLE `test_type_measure` (
   `test_type_id` int(11) unsigned not null default '0',
   `measure_id` int(11) unsigned not null default '0',
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
   `phone` varchar(45),
   `lang_id` varchar(45) not null default 'default',
   PRIMARY KEY (`user_id`),
   KEY `user_id_index` (`lab_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=196;


CREATE TABLE `user_props` (
   `User_Id` varchar(50) not null,
   `AppCodeName` varchar(25) not null,
   `AppName` varchar(25) not null,
   `AppVersion` varchar(25) not null,
   `CookieEnabled` tinyint(1) not null default '0',
   `Platform` varchar(20) not null,
   `UserAgent` varchar(200) not null,
   `SystemLanguage` varchar(15) not null,
   `UserLanguage` varchar(15) not null,
   `Language` varchar(15) not null,
   `ScreenAvailHeight` int(11) not null default '0',
   `ScreenAvailWidth` int(11) not null default '0',
   `ScreenColorDepth` int(11) not null default '0',
   `ScreenHeight` int(11) not null default '0',
   `ScreenWidth` int(11) not null default '0',
   `Recorded_At` datetime not null default '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `user_rating` (
   `user_id` int(10) unsigned not null,
   `rating` int(10) unsigned not null,
   `ts` timestamp not null default CURRENT_TIMESTAMP,
   PRIMARY KEY (`user_id`,`ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- MySQL 5.0.41
-- Wed, 26 May 2010 09:51:08 +0000
--

INSERT INTO `measure` (`measure_id`, `name`, `unit_id`, `range`, `description`, `ts`, `unit`) VALUES 
('2', 'WBC', '', '4.0:10.0', '', '2010-04-09 13:55:32', '10*9/L'),
('3', 'HIV Rapid', '', 'N/P', '', '2010-04-05 14:25:59', ''),
('4', 'CD4', '', '0:3000', '', '2009-12-16 23:22:44', 'cell/ul'),
('5', 'CD4%', '', '0:90', '', '2009-12-16 23:22:44', '%'),
('6', 'ALT/SGPT', '', '0:1000', '', '2009-12-16 23:30:27', 'U/L'),
('7', 'FBS', '', '60:110', '', '2010-04-10 00:48:02', 'mg/dl'),
('8', 'Protein', '', '5:1000', '', '2009-12-16 23:34:26', 'g/L'),
('9', 'Acide Urique', '', '30:60', '', '2010-05-20 06:44:23', 'mg/L'),
('10', 'Ca++', '', '0:10', '', '2009-12-16 23:35:53', 'mmol/L'),
('11', 'Phosphorus', '', '1:10', '', '2009-12-16 23:36:51', 'mg/dL'),
('12', 'Mg++', '', '0:10', '', '2009-12-16 23:37:35', 'mmol/L'),
('13', 'CREAT', '', '6:13', 'Creatinine', '2010-05-20 06:20:04', 'mg/dl'),
('14', 'Globulin', '', '0:1000', '', '2009-12-16 23:39:02', 'ng/mL'),
('15', 'Albumin', '', '0:1000', '', '2009-12-16 23:39:40', 'mg/dL'),
('16', 'AST/SGOT', '0', '0:1000', '', '2009-12-16 23:39:40', 'U/L'),
('17', 'ALKP', '0', '0:1000', 'Alkaline Phosphatase', '2009-12-16 23:39:40', 'U/L'),
('18', 'TBILI', '0', '0:1000', 'Total Birilubin', '2009-12-16 23:39:40', 'umol/L'),
('19', 'BUN', '0', '0:1000', 'Blood Urea Nitrogen', '2009-12-16 23:39:40', 'mmol/L'),
('74', 'Direct Coombs Test (DCT)', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('21', 'NA', '0', '135:155', 'Sodium', '2010-05-19 12:37:38', 'Meq/ml'),
('22', 'K', '0', '3.4:5.5', 'Potassium', '2010-05-19 12:36:31', 'Meq/mll'),
('23', 'CL', '0', '98:106', 'Chloride', '2010-05-19 12:35:16', 'Meq:/ml'),
('24', 'BICAR', '0', '0:100', 'CO2 Bicarbonate', '2009-12-16 23:39:40', 'mmol/l'),
('25', 'CHOL Total', '0', '1.4:2.7', 'Cholesterol', '2010-05-20 06:24:15', 'mg/dL'),
('26', 'TRIG', '0', '0:1000', 'Trigylcerides', '2009-12-16 23:39:40', 'mmol/L'),
('27', 'HDL-CHOL', '0', '0.4:0.7', 'HDL Cholesterol', '2010-05-20 06:26:57', 'mmol/L'),
('28', 'LDL-CHOL', '0', '0:1.5', 'LDL Cholesterol', '2010-05-20 06:27:42', 'mmol/L'),
('29', 'GLUC', '0', '0:1000', 'Glucose', '2009-12-16 23:39:40', 'mmol/L'),
('30', 'AMYL', '0', '0:1000', 'Amylase', '2009-12-16 23:39:40', 'U/L'),
('31', 'LACT', '0', '0:1000', 'Lactate', '2009-12-16 23:39:40', 'mEq/L'),
('32', 'Goutte Epaisse (GE)', '0', 'Négatif/1+/2+/3+/4+', 'Malaria Smear', '2010-05-19 12:05:13', ''),
('33', 'RBC', '0', '3.5:5.5', 'Red Blood Corpuscles', '2010-04-09 13:55:32', '10*12/L'),
('34', 'HGB', '0', '11.0									0.5:15.0', 'Haemoglobin', '2010-04-09 13:55:32', 'g/dL'),
('35', 'HCT', '0', '5:75', '', '2009-12-16 23:39:40', '%'),
('36', 'MCV', '0', '80.0:99.0', '', '2010-04-09 13:55:32', 'fL'),
('37', 'MCH', '0', '26.0:32.0', '', '2010-04-09 13:55:32', 'pg'),
('38', 'MCHC', '0', '32.0:36.0', '', '2010-04-09 13:55:32', 'g/dL'),
('39', 'PLT', '0', '100:300', '', '2010-04-09 13:55:32', '10*9/L'),
('40', 'PCR (HIV DNA)', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('41', 'VL (HIV RNA)', '0', '400:1000000', 'Viral Load', '2009-12-16 23:39:40', 'copies/mL'),
('42', 'HIV EIA', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('43', 'WB (Western Blot)', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('44', 'RPR', '0', 'N/P', '', '2010-04-08 03:38:14', ''),
('45', 'HEP B', '0', 'R/NR', 'Hepatitis B', '2009-12-16 23:39:40', ''),
('46', 'HGB Electro', '', 'AA/AF/AS/SS', 'HGB Electropherosis', '2009-12-16 23:39:40', ''),
('47', 'ESR (Sed rate)', '0', '0:1000', '', '2009-12-16 23:39:40', 'mm/hr'),
('48', 'Sickling RBC', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('49', 'CT (Clotting Time)', '0', '0:100', '', '2009-12-16 23:39:40', 'min'),
('50', 'GGT', '0', '0:1000', 'Gamma Glutamyl Transferease', '2009-12-16 23:39:40', 'U/L'),
('51', 'URINE COLOUR', '0', 'Straw/Pale Yellow/Deep Yellow/Amber', '', '2009-12-16 23:39:40', ''),
('52', 'URINE TURBIDITY', '0', 'Clear/Cloudy', '', '2009-12-16 23:39:40', ''),
('53', 'URINE OCCULT BI', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('54', 'Stool Consistency', '', 'Formed(solid)/Semi-formed(not solid)/Watery', '', '2009-12-16 23:39:40', ''),
('55', 'Stool Occult BI', '', 'P/N', '', '2009-12-16 23:39:40', ''),
('56', 'HCV', '0', 'P/N', 'Hepatitis C', '2009-12-16 23:39:40', ''),
('57', 'VDRL', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('58', 'Rheumatoid Factor', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('59', 'CSF Glucose', '0', '0:100', '', '2009-12-16 23:39:40', 'mmol/L'),
('60', 'CSF Protein', '0', '0:10000', '', '2009-12-16 23:39:40', 'mg/dL'),
('61', 'CSF Chloride', '0', '0:1000', '', '2009-12-16 23:39:40', 'mmol/L'),
('62', 'Pregnancy', '0', 'N/P', '', '2010-04-08 04:19:39', ''),
('63', 'Progesterone', '0', '0:1000', '', '2009-12-16 23:39:40', 'mmol/L'),
('64', ' Groupe sanguin', '0', 'A/B/AB/O', '', '2010-05-19 12:10:14', ''),
('65', 'Rhésus', '0', 'Positif/Négatif', '', '2010-05-19 12:10:14', ''),
('66', 'ASOT', '0', 'P/N', 'Streptococcal', '2009-12-16 23:39:40', ''),
('67', 'Sperm Count', '0', '0:1000', '', '2009-12-16 23:39:40', '10^6/mL'),
('68', 'TPHA', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('69', 'Toxoplasma', '0', 'P/N', '', '2009-12-16 23:39:40', ''),
('70', 'CRP', '0', '0:0', 'C-Reactive Protein', '2010-05-20 06:21:53', 'mg/L'),
('71', 'PSA', '0', 'P/N', 'Prostate Specific Antigen', '2009-12-16 23:39:40', ''),
('72', 'Zn Stain', '0', 'AAFB seen/AAFB not seen', '', '2009-12-16 23:39:40', ''),
('73', 'Bleeding Time', '0', '0:100', '', '2009-12-16 23:39:40', ''),
('75', 'Prolactin', '0', '0:1000', '', '2009-12-16 23:39:40', 'ug/L'),
('76', 'Ferritin', '0', '0:1000', '', '2009-12-16 23:39:40', 'ug/L'),
('77', 'Testosterone', '0', '0:1000', '', '2009-12-16 23:39:40', 'nmol/L'),
('88', 'Blood Sugar', '', '3.6:12', '', '2010-04-07 02:57:00', 'mmol/L'),
('87', 'TB Smear', '', 'NR/1+/2+/3+/4+', '', '2010-04-07 01:03:35', ''),
('85', 'm2', '', 'P/N', '', '2010-03-01 13:46:40', 'u3'),
('84', 'm1', '', '12:30', '', '2010-02-28 16:22:58', 'u1'),
('89', 'AFB', '', 'N/P', '', '2010-04-08 05:09:49', ''),
('90', 'T4', '', '350:1610', '', '2010-04-09 14:19:42', 'cells/ml'),
('91', 'T8', '', '130:1118', '', '2010-04-09 14:19:42', 'cells/ml'),
('92', 'T3', '', '190:1955', '', '2010-04-09 14:19:42', 'cells/ml'),
('93', 'T4/T8', '', ':', '', '2010-04-09 14:19:42', ''),
('94', 'indicateur', '', 'positif/negatif', '', '2010-05-01 07:40:16', ''),
('95', 'Indicator', '', 'YES/NO', '', '2010-05-07 23:13:22', ''),
('96', 'Widal et Felix', '', 'Positif/Négatif', '', '2010-05-19 11:33:27', '');

INSERT INTO `specimen_test` (`test_type_id`, `specimen_type_id`, `ts`) VALUES 
('7', '6', '2009-12-16 23:22:44'),
('8', '7', '2009-12-16 23:30:27'),
('9', '6', '2009-12-16 23:33:36'),
('70', '8', '2010-01-17 11:05:47'),
('10', '6', '2009-12-16 23:34:26'),
('11', '6', '2009-12-16 23:35:12'),
('12', '6', '2009-12-16 23:35:53'),
('13', '7', '2009-12-16 23:36:51'),
('14', '7', '2009-12-16 23:37:35'),
('15', '7', '2009-12-16 23:38:09'),
('16', '7', '2009-12-16 23:39:02'),
('17', '10', '2009-12-16 23:39:40'),
('7', '13', '2010-01-15 14:52:15'),
('18', '7', '2010-01-16 17:55:07'),
('19', '7', '2010-01-16 17:56:12'),
('20', '7', '2010-01-16 17:57:12'),
('21', '7', '2010-01-16 17:58:41'),
('22', '7', '2010-01-16 17:59:40'),
('23', '7', '2010-01-16 18:00:18'),
('24', '7', '2010-01-16 18:00:41'),
('25', '7', '2010-01-16 18:01:04'),
('26', '7', '2010-01-16 18:01:36'),
('27', '7', '2010-01-16 18:02:17'),
('28', '7', '2010-01-16 18:02:38'),
('29', '7', '2010-01-16 18:03:13'),
('30', '7', '2010-01-16 18:03:35'),
('31', '7', '2010-01-16 18:04:33'),
('32', '7', '2010-01-16 18:04:51'),
('33', '7', '2010-01-16 18:05:10'),
('34', '7', '2010-01-16 18:05:58'),
('35', '7', '2010-01-16 18:06:42'),
('36', '7', '2010-01-16 18:07:51'),
('37', '7', '2010-01-16 18:09:13'),
('38', '6', '2010-01-16 18:10:17'),
('91', '7', '2010-05-19 12:26:52'),
('39', '6', '2010-01-16 18:12:18'),
('40', '6', '2010-01-16 18:12:43'),
('41', '18', '2010-01-16 18:14:08'),
('42', '18', '2010-01-16 18:15:12'),
('43', '6', '2010-01-16 18:15:49'),
('44', '6', '2010-01-16 18:17:57'),
('45', '7', '2010-01-16 18:18:22'),
('46', '6', '2010-01-16 18:19:58'),
('47', '7', '2010-01-16 18:20:39'),
('48', '7', '2010-01-16 18:21:34'),
('49', '6', '2010-01-16 18:22:32'),
('50', '6', '2010-01-16 18:23:21'),
('51', '6', '2010-01-16 18:24:00'),
('52', '6', '2010-01-16 18:25:26'),
('53', '6', '2010-01-16 18:26:01'),
('54', '6', '2010-01-16 18:26:50'),
('55', '7', '2010-01-16 18:27:50'),
('56', '11', '2010-01-16 18:29:45'),
('57', '6', '2010-01-16 18:31:09'),
('58', '7', '2010-01-16 18:32:22'),
('59', '7', '2010-01-16 18:33:23'),
('60', '10', '2010-01-16 18:34:13'),
('61', '11', '2010-01-16 18:36:14'),
('62', '7', '2010-01-16 18:37:16'),
('63', '6', '2010-01-16 18:38:21'),
('64', '7', '2010-01-16 18:38:58'),
('65', '15', '2010-01-16 18:40:08'),
('66', '7', '2010-01-16 18:41:09'),
('67', '7', '2010-01-16 18:41:36'),
('68', '7', '2010-01-16 18:42:09'),
('69', '9', '2010-01-16 18:43:01'),
('70', '6', '2010-01-16 18:44:02'),
('71', '12', '2010-01-16 18:44:58'),
('72', '7', '2010-01-16 18:51:46'),
('73', '7', '2010-01-16 18:52:13'),
('74', '7', '2010-01-16 18:52:35'),
('90', '7', '2010-05-19 11:33:27'),
('88', '16', '2010-05-20 04:45:01'),
('84', '6', '2010-04-07 02:57:00'),
('83', '9', '2010-04-05 14:22:50'),
('88', '11', '2010-05-01 07:18:02'),
('41', '8', '2010-04-29 17:43:55'),
('86', '6', '2010-04-09 14:19:42'),
('88', '14', '2010-05-01 07:18:02'),
('44', '7', '2010-04-29 17:47:55'),
('85', '13', '2010-04-08 05:09:49'),
('89', '21', '2010-05-07 23:13:22'),
('83', '17', '2010-05-20 04:49:24'),
('88', '22', '2010-05-20 05:18:12'),
('92', '7', '2010-05-20 05:19:19');

INSERT INTO `specimen_type` (`specimen_type_id`, `name`, `description`, `ts`, `disabled`) VALUES 
('6', 'Sang Total', '', '2010-05-20 04:48:37', '0'),
('7', 'Serum', '', '2009-12-08 19:41:07', '0'),
('8', 'Dried Blood Spot', '', '2009-12-08 19:41:27', '0'),
('9', 'Crachat', '', '2010-05-20 04:45:56', '0'),
('10', 'CSF', '', '2009-12-08 19:41:56', '0'),
('11', 'Urine', '', '2009-12-08 19:42:07', '0'),
('12', 'Selle', '', '2010-05-20 04:44:23', '0'),
('13', 'Aspirate', 'Aspirate Sample', '2010-01-15 14:52:15', '0'),
('14', 'Nasal Swab', '', '2009-12-08 19:42:41', '0'),
('15', 'Sperme', '', '2010-05-20 04:45:43', '0'),
('16', 'Prélèvement rectal', '', '2010-05-20 04:45:01', '0'),
('17', 'Prélèvement de la Gorge', '', '2010-05-20 04:49:24', '0'),
('18', 'Plasma EDTA', '', '2009-12-08 19:43:33', '0'),
('21', 'Frottis Vaginal', 'Vaginal Smear', '2010-05-20 04:52:18', '0'),
('22', 'LCR', 'Liquide Céphalorachidien', '2010-05-20 05:18:12', '0');

INSERT INTO `test_category` (`test_category_id`, `name`, `description`, `ts`) VALUES 
('1', 'Serology', '', '2009-12-08 19:24:33'),
('2', 'Hematology', '', '2009-12-09 12:39:21'),
('4', 'HIV', '', '2009-12-15 23:09:42'),
('5', 'CD4', '', '2009-12-16 23:22:44'),
('6', 'Chemistry', '', '2009-12-16 23:30:27'),
('7', 'Microscopy', '', '2010-01-16 18:10:17'),
('8', 'Other', '', '2010-01-16 18:29:45'),
('9', 'Hormonal', '', '2010-01-16 18:37:16'),
('10', 'Bacteriology', '', '2010-01-16 18:43:01');

INSERT INTO `test_type` (`test_type_id`, `name`, `description`, `test_category_id`, `ts`, `is_panel`, `disabled`) VALUES 
('7', 'CD4 Count', '', '5', '2009-12-16 23:29:01', '', '0'),
('8', 'ALT/SGPT', '', '6', '2009-12-16 23:30:27', '', '0'),
('9', 'FBS', 'Fasting Blood Sugar', '6', '2010-04-10 00:48:02', '', '0'),
('10', 'Protein Count', '', '6', '2009-12-16 23:34:26', '', '0'),
('11', 'Acide Urique', '', '6', '2010-05-20 06:44:23', '', '0'),
('12', 'Calcium', '', '6', '2009-12-16 23:35:53', '', '0'),
('13', 'Phosphorus', '', '6', '2009-12-16 23:36:51', '', '0'),
('14', 'Magnesium', '', '6', '2009-12-16 23:37:35', '', '0'),
('15', 'Creatine Kinase', '', '6', '2009-12-16 23:38:09', '', '0'),
('16', 'Thyroglobulin', '', '6', '2009-12-16 23:39:02', '', '0'),
('17', 'Total Albumin', '', '6', '2009-12-16 23:39:40', '', '0'),
('18', 'AST/SGOT', '', '6', '2010-01-16 17:55:07', '', '0'),
('19', 'Alkaline Phosphatase', '', '6', '2010-01-16 17:56:12', '', '0'),
('20', 'Total Bilirubin', '', '6', '2010-01-16 17:57:12', '', '0'),
('21', 'Blood Urea Nitrogen', '', '6', '2010-01-16 17:58:41', '', '0'),
('22', 'Créatinine', '', '6', '2010-05-20 06:20:04', '', '0'),
('23', 'Sodium', '', '6', '2010-01-16 18:00:18', '', '0'),
('24', 'Potassium', '', '6', '2010-01-16 18:00:41', '', '0'),
('25', 'Chlore', '', '6', '2010-05-20 06:20:43', '', '0'),
('26', 'CO2 Bicarbonate', '', '6', '2010-01-16 18:01:36', '', '0'),
('27', 'Cholestérol Total', '', '6', '2010-05-20 06:24:15', '', '0'),
('28', 'Triglycerides', '', '6', '2010-01-16 18:02:38', '', '0'),
('29', 'HDL Cholesterol', '', '6', '2010-01-16 18:03:13', '', '0'),
('30', 'LDL Cholestérol', '', '6', '2010-05-20 06:27:42', '', '0'),
('31', 'Glucose', '', '6', '2010-01-16 18:04:33', '', '0'),
('32', 'Amylase', '', '6', '2010-01-16 18:04:51', '', '0'),
('33', 'Lactate', '', '6', '2010-01-16 18:05:10', '', '0'),
('34', 'Kidney Function Panel', '', '6', '2010-01-16 18:05:58', '', '0'),
('35', 'Lipid Panel', '', '6', '2010-01-16 18:06:42', '', '0'),
('36', 'Liver Function Panel', '', '6', '2010-01-16 18:07:51', '', '0'),
('37', 'HIV Monitoring Panel', '', '6', '2010-04-09 14:44:47', '', '0'),
('38', 'Paludisme', '', '7', '2010-05-19 12:05:13', '', '0'),
('39', 'Complete Blood Count', '', '2', '2010-01-16 18:12:18', '', '0'),
('40', 'HGB', '', '2', '2010-01-16 18:12:43', '', '0'),
('41', 'HIV DNA PCR', '', '4', '2010-04-09 14:43:54', '', '0'),
('42', 'HIV RNA VL', '', '4', '2010-04-09 14:45:04', '', '0'),
('43', 'HIV EIA', '', '4', '2010-04-09 14:44:09', '', '0'),
('44', 'HIV Rapid Test', '', '4', '2010-04-09 14:43:37', '', '0'),
('46', 'Western Blot', '', '7', '2010-01-16 18:19:58', '', '0'),
('47', 'RPR', '', '1', '2010-01-16 18:20:39', '', '0'),
('48', 'Hepatitis B', '', '1', '2010-01-16 18:21:34', '', '0'),
('49', 'HGB Electropherosis', '', '2', '2010-01-16 18:22:32', '', '0'),
('50', 'Platelet Count', '', '2', '2010-01-16 18:23:21', '', '0'),
('51', 'ESR (Sed rate)', '', '2', '2010-01-16 18:24:00', '', '0'),
('52', 'Enumération Globules Blancs (GB)', '', '2', '2010-05-20 06:43:08', '', '0'),
('53', 'Sickling RBC', '', '2', '2010-01-16 18:26:01', '', '0'),
('54', 'Clotting Time (CT)', '', '2', '2010-01-16 18:26:50', '', '0'),
('55', 'Gamma Glutamyl', 'Gamma Glutamyl Transferease', '6', '2010-01-16 18:27:50', '', '0'),
('56', 'Urine Analysis', '', '8', '2010-01-16 18:29:45', '', '0'),
('57', 'Hepatitis C', '', '1', '2010-01-16 18:31:09', '', '0'),
('58', 'VDRL', '', '1', '2010-01-16 18:32:22', '', '0'),
('59', 'Rheumatoid Factor', '', '1', '2010-01-16 18:33:23', '', '0'),
('60', 'CSF', '', '6', '2010-01-16 18:34:13', '', '0'),
('61', 'Pregnancy Test (HCG)', '', '8', '2010-04-08 04:19:39', '', '0'),
('62', 'Progesterone', '', '9', '2010-01-16 18:37:16', '', '0'),
('63', 'Groupe Sanguin (ABO/Rh)', '', '2', '2010-05-20 06:22:32', '', '0'),
('64', 'ASOT (Streptococcal)', '', '1', '2010-01-16 18:38:58', '', '0'),
('65', 'Sperm Count', '', '8', '2010-01-16 18:40:08', '', '0'),
('66', 'TPHA', '', '1', '2010-01-16 18:41:09', '', '0'),
('67', 'Toxoplasma', '', '1', '2010-01-16 18:41:36', '', '0'),
('68', 'C-Reactive Protein', '', '1', '2010-01-16 18:42:09', '', '0'),
('69', 'Zn Stain', '', '10', '2010-01-16 18:43:01', '', '0'),
('70', 'Bleeding Time (BT)', '', '2', '2010-01-16 18:44:02', '', '0'),
('71', 'Stool Analysis', '', '8', '2010-01-16 18:44:58', '', '0'),
('72', 'Prolactin', '', '9', '2010-01-16 18:51:46', '', '0'),
('73', 'Ferritin', '', '9', '2010-01-16 18:52:13', '', '0'),
('74', 'Testosterone', '', '9', '2010-01-17 11:06:10', '', '0'),
('84', 'Random Blood Sugar', '', '6', '2010-04-07 02:57:00', '0', '0'),
('83', 'TB Smear', 'Tuberculosis Smear Test', '1', '2010-04-05 14:22:50', '0', '0'),
('85', 'AFB', '', '10', '2010-04-08 05:09:49', '0', '0'),
('86', 'T-Lymphocytes CD4', '', '2', '2010-04-09 14:19:42', '0', '0'),
('88', 'examen bacteriologique', '', '10', '2010-05-01 07:18:02', '0', '0'),
('89', 'Culture', 'Bacteria cultures', '10', '2010-05-07 23:13:22', '0', '0'),
('90', 'Test  de la Typhoide', '', '1', '2010-05-19 11:34:30', '0', '0'),
('91', 'IONNOGRAMME', '', '6', '2010-05-19 12:26:52', '1', '0'),
('92', 'Ionogramme', '', '1', '2010-05-20 05:19:19', '1', '0');

INSERT INTO `test_type_measure` (`test_type_id`, `measure_id`, `ts`) VALUES 
('7', '4', '2009-12-16 23:22:44'),
('7', '5', '2009-12-16 23:22:44'),
('8', '6', '2009-12-16 23:30:27'),
('9', '7', '2009-12-16 23:33:36'),
('10', '8', '2009-12-16 23:34:26'),
('11', '9', '2009-12-16 23:35:12'),
('12', '10', '2009-12-16 23:35:53'),
('13', '11', '2009-12-16 23:36:51'),
('14', '12', '2009-12-16 23:37:35'),
('15', '13', '2009-12-16 23:38:09'),
('16', '14', '2009-12-16 23:39:02'),
('17', '15', '2009-12-16 23:39:40'),
('18', '16', '2010-01-16 17:55:07'),
('19', '17', '2010-01-16 17:56:12'),
('20', '18', '2010-01-16 17:57:12'),
('21', '19', '2010-01-16 17:58:41'),
('22', '13', '2010-01-16 17:59:40'),
('23', '21', '2010-01-16 18:00:18'),
('24', '22', '2010-01-16 18:00:41'),
('25', '23', '2010-01-16 18:01:04'),
('26', '24', '2010-01-16 18:01:36'),
('27', '25', '2010-01-16 18:02:17'),
('28', '26', '2010-01-16 18:02:38'),
('29', '27', '2010-01-16 18:03:13'),
('30', '28', '2010-01-16 18:03:35'),
('31', '29', '2010-01-16 18:04:33'),
('32', '30', '2010-01-16 18:04:51'),
('33', '31', '2010-01-16 18:05:10'),
('34', '19', '2010-01-16 18:05:58'),
('34', '13', '2010-01-16 18:05:58'),
('35', '25', '2010-01-16 18:06:42'),
('35', '26', '2010-01-16 18:06:42'),
('35', '27', '2010-01-16 18:06:42'),
('35', '28', '2010-01-16 18:06:42'),
('36', '6', '2010-01-16 18:07:51'),
('36', '16', '2010-01-16 18:07:51'),
('36', '17', '2010-01-16 18:07:51'),
('36', '18', '2010-01-16 18:07:51'),
('37', '6', '2010-01-16 18:09:13'),
('37', '16', '2010-01-16 18:09:13'),
('37', '13', '2010-01-16 18:09:13'),
('37', '29', '2010-01-16 18:09:13'),
('38', '32', '2010-01-16 18:10:17'),
('39', '2', '2010-01-16 18:12:18'),
('39', '33', '2010-01-16 18:12:18'),
('39', '34', '2010-01-16 18:12:18'),
('39', '36', '2010-01-16 18:12:18'),
('39', '37', '2010-01-16 18:12:18'),
('39', '38', '2010-01-16 18:12:18'),
('39', '39', '2010-01-16 18:12:18'),
('40', '34', '2010-01-16 18:12:43'),
('41', '40', '2010-01-16 18:14:08'),
('42', '41', '2010-01-16 18:15:12'),
('43', '42', '2010-01-16 18:15:49'),
('44', '3', '2010-01-16 18:17:57'),
('46', '43', '2010-01-16 18:19:58'),
('47', '44', '2010-01-16 18:20:39'),
('48', '45', '2010-01-16 18:21:34'),
('49', '46', '2010-01-16 18:22:32'),
('50', '39', '2010-01-16 18:23:21'),
('51', '47', '2010-01-16 18:24:00'),
('52', '2', '2010-01-16 18:25:26'),
('53', '48', '2010-01-16 18:26:01'),
('54', '49', '2010-01-16 18:26:50'),
('55', '50', '2010-01-16 18:27:50'),
('56', '51', '2010-01-16 18:29:45'),
('56', '52', '2010-01-16 18:29:45'),
('56', '53', '2010-01-16 18:29:45'),
('57', '56', '2010-01-16 18:31:09'),
('58', '57', '2010-04-29 17:25:30'),
('59', '58', '2010-01-16 18:33:23'),
('60', '59', '2010-01-16 18:34:13'),
('60', '60', '2010-01-16 18:34:13'),
('60', '61', '2010-01-16 18:34:13'),
('61', '62', '2010-01-16 18:36:14'),
('62', '63', '2010-01-16 18:37:16'),
('63', '64', '2010-01-16 18:38:21'),
('63', '65', '2010-01-16 18:38:21'),
('64', '66', '2010-01-16 18:38:58'),
('65', '67', '2010-01-16 18:40:08'),
('66', '68', '2010-01-16 18:41:09'),
('67', '69', '2010-01-16 18:41:36'),
('68', '70', '2010-01-16 18:42:09'),
('69', '72', '2010-01-16 18:43:01'),
('70', '73', '2010-01-16 18:44:02'),
('71', '54', '2010-01-16 18:44:58'),
('71', '55', '2010-01-16 18:44:58'),
('72', '75', '2010-01-16 18:51:46'),
('73', '76', '2010-01-16 18:52:13'),
('74', '77', '2010-01-16 18:52:35'),
('89', '95', '2010-05-07 23:13:22'),
('91', '23', '2010-05-19 12:26:52'),
('90', '96', '2010-05-19 11:33:27'),
('88', '94', '2010-05-01 07:18:02'),
('86', '93', '2010-04-09 14:19:42'),
('86', '92', '2010-04-09 14:19:42'),
('86', '91', '2010-04-09 14:19:42'),
('86', '90', '2010-04-09 14:19:42'),
('85', '89', '2010-04-08 05:09:49'),
('84', '88', '2010-04-07 02:57:00'),
('83', '87', '2010-04-05 14:22:50'),
('91', '22', '2010-05-19 12:26:52'),
('91', '21', '2010-05-19 12:26:52'),
('92', '23', '2010-05-20 05:19:19'),
('92', '22', '2010-05-20 05:19:19'),
('92', '21', '2010-05-20 05:19:19');

INSERT INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, 
landscape, age_unit) VALUES ( 'Grouped Test Count Report Configuration', '0:4,5:9,10:14,15:19,20:24,25:29,29:34,35:39,39:44,45:49,49:54,55:59,59:64,65:+',
'0', '1', '1', '0', '1', '0', '9999009', '0', 9999009, 1);

INSERT INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, 
landscape, age_unit) VALUES ( 'Grouped Specimen Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+',
'0', '1', '1', '0', '1', '0', '9999019', '0', 9999019, 1);