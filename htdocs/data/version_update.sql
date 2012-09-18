USE blis_revamp;

CREATE TABLE IF NOT EXISTS `version_data` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) collate latin1_general_ci NOT NULL,
  `flag` int(1) NOT NULL default '0',
  `remarks` varchar(500) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;



INSERT INTO `version_data`
(`version`,`flag`,`remarks`)
VALUES
('2.3',0,'-');
