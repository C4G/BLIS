CREATE TABLE `patient_bills` (
	`bill_id` int(11) auto_increment NOT NULL,
	`bill_amount` decimal(10,2) NOT NULL DEFAULT '0',
	`bill_date` date NOT NULL,
	`patient_id` int(11) UNSIGNED NOT NULL,
	PRIMARY KEY(`bill_id`),
        CONSTRAINT `patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `test_type_costs` (
  `id` int(11) NOT NULL auto_increment,
  `amount` decimal(10,2) NOT NULL default '0',
  `test_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `test_type_id` FOREIGN KEY (`test_type_id`) REFERENCES `test_types` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `tests_bills_association` (
	`id` int(11) UNSIGNED auto_increment NOT NULL,
	`patient_bill_id` int(11) UNSIGNED NOT NULL,
	`test_id` int(11) UNSIGNED NOT NULL,
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;