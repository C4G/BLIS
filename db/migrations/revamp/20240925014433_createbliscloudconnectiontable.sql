-- This table stores the connections of offline labs
-- to labs on this cloud instance
CREATE TABLE IF NOT EXISTS `blis_cloud_connections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lab_config_id` int(10) unsigned NOT NULL,
  -- ID of the public key that is in the 'keymgmt' table for this lab --
  `lab_pubkey_id` int(10) unsigned DEFAULT NULL,
  `connection_code` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_backup_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lab_config_id` (`lab_config_id`)
);
