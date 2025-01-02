CREATE TABLE IF NOT EXISTS `blis_backups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lab_config_id` int(10) unsigned NOT NULL,
  `filename` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `blis_version` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location` (`location`),
  KEY `lab_config_id` (`lab_config_id`)
);
