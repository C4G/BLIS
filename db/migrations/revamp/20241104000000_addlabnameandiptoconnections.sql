ALTER TABLE `blis_cloud_connections` ADD COLUMN `lab_name` VARCHAR(256) DEFAULT NULL;
ALTER TABLE `blis_cloud_connections` ADD COLUMN `last_backup_ip` VARCHAR(40) DEFAULT NULL;
