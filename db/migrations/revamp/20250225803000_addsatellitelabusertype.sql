-- Using INSERT IGNORE - it's important to have this user type,
-- but it might conflict with what's already in the table and we
-- don't have a sophisticated way to deal with that yet.
INSERT IGNORE INTO `user_type` (`level`, `name`, `defaultdisplay`, `created_by`, `created_on`) VALUES ('20', 'SATELLITE_LAB', '1', 'Princesca', CURRENT_TIMESTAMP);
