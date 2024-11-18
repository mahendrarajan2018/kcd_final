ALTER TABLE `kcd_2024_account_party` ADD `district` MEDIUMTEXT NOT NULL AFTER `state`; 
ALTER TABLE `kcd_2024_consignor` ADD `district` MEDIUMTEXT NOT NULL AFTER `state`; 
ALTER TABLE `kcd_2024_consignee` ADD `district` MEDIUMTEXT NOT NULL AFTER `state`; 
ALTER TABLE `kcd_2024_role` ADD `permission_check` INT(100) NOT NULL AFTER `access_page_actions`; 