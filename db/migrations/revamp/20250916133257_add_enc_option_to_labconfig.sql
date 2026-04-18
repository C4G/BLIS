ALTER TABLE `lab_config` ADD COLUMN `backup_encryption_enabled` TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE `lab_config` ADD COLUMN `backup_encryption_key_id` int(11) unsigned DEFAULT NULL;
