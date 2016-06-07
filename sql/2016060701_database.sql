--
-- Add column `password` into table `merchants` to store merchant's password
--

ALTER TABLE `merchants` ADD `password` VARCHAR( 60 ) NOT NULL AFTER `email` ;