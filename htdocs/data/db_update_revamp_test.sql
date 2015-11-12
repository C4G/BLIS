
CREATE TABLE IF NOT EXISTS `tttt` (
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(128) collate latin1_general_ci default NULL,
  `range` varchar(1024) collate latin1_general_ci default NULL,
  `test_id` int(10) NOT NULL default '0',
  `measure_id` int(10) NOT NULL default '0',
  `unit` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`,`test_id`,`measure_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

