-- This creates the migrations table, which is necessary to track all the migrations that come after it

CREATE TABLE IF NOT EXISTS `blis_migrations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
);
