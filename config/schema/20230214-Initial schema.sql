
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`telegram_id` BIGINT(20) NOT NULL,
	`first_name` VARCHAR(255) NOT NULL,
	`last_name` VARCHAR(255) NULL,
	`username` CHAR(191) NULL,
	`admin` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `forwarder`;
CREATE TABLE `forwarder` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`fromChannelDiscord_id` INT(11) UNSIGNED NOT NULL,
	`toChannelTelegram_id` INT(11) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`)
);
