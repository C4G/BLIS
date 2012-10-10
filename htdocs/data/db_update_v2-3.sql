CREATE TABLE `invoices` (
  `id` int(11) NOT NULL auto_increment,
  `amount` decimal(10,2) NOT NULL default '0',
  `patient_id` int(11) NOT NULL,
  `date` date default NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE `invoice_line_items` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL default '0',
  `invoice_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

ALTER TABLE `test_type`
  ADD `costToPatient` decimal(10,2) NOT NULL default '0';