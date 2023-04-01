

DROP TABLE IF EXISTS `tree`.`acos`;
DROP TABLE IF EXISTS `tree`.`albums`;
DROP TABLE IF EXISTS `tree`.`aros`;
DROP TABLE IF EXISTS `tree`.`aros_acos`;
DROP TABLE IF EXISTS `tree`.`bookmarks`;
DROP TABLE IF EXISTS `tree`.`comments`;
DROP TABLE IF EXISTS `tree`.`groups`;
DROP TABLE IF EXISTS `tree`.`items`;
DROP TABLE IF EXISTS `tree`.`people`;
DROP TABLE IF EXISTS `tree`.`photos`;
DROP TABLE IF EXISTS `tree`.`users`;


CREATE TABLE `tree`.`acos` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`foreign_key` int(10) DEFAULT NULL,
	`alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`albums` (
	`id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`start_year` text(4) DEFAULT NULL,
	`end_year` text(4) DEFAULT NULL,
	`created` datetime NOT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`aros` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`foreign_key` int(10) DEFAULT NULL,
	`alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`aros_acos` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`aro_id` int(10) NOT NULL,
	`aco_id` int(10) NOT NULL,
	`_create` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0' NOT NULL,
	`_read` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0' NOT NULL,
	`_update` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0' NOT NULL,
	`_delete` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0' NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `ARO_ACO_KEY` (`aro_id`, `aco_id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`bookmarks` (
	`id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` int(255) UNSIGNED NOT NULL,
	`item_id` int(255) UNSIGNED NOT NULL,
	`created` datetime NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `user_id__item_id__UNIQUE` (`user_id`, `item_id`),
	KEY `user_id__INDEX` (`user_id`),
	KEY `item_id__INDEX` (`item_id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`comments` (
	`id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`item_id` int(255) UNSIGNED NOT NULL,
	`user_id` int(255) UNSIGNED NOT NULL,
	`parent_id` int(255) UNSIGNED DEFAULT NULL,
	`lft` int(10) NOT NULL,
	`rght` int(10) NOT NULL,
	`body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime DEFAULT NULL,
	`block` tinyint(1) DEFAULT '0' NOT NULL,
	`block_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`blocked` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `item_id__INDEX` (`item_id`),
	KEY `user_id__INDEX` (`user_id`),
	KEY `parent_id__INDEX` (`parent_id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`groups` (
	`id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `title__UNIQUE` (`title`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`items` (
	`id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` int(255) UNSIGNED DEFAULT NULL,
	`album_id` int(255) UNSIGNED DEFAULT NULL,
	`type` int(1) NOT NULL,
	`title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`start_year` text(4) DEFAULT NULL,
	`end_year` text(4) DEFAULT NULL,
	`orientation` int(1) NOT NULL,
	`thumbs_50x50` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`thumbs_263x180` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`quantity_views` int(255) UNSIGNED DEFAULT 0 NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime DEFAULT NULL,
	`verification` tinyint(1) DEFAULT '0' NOT NULL,
	`verification_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`verified` datetime DEFAULT NULL,
	`publish` tinyint(1) DEFAULT '0' NOT NULL,
	`publicated` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `user_id__INDEX` (`user_id`),
	KEY `album_id__INDEX` (`album_id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`people` (
	`id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` int(255) UNSIGNED DEFAULT NULL,
	`father_id` int(255) UNSIGNED DEFAULT NULL,
	`mother_id` int(255) UNSIGNED DEFAULT NULL,
	`last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`second_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`biography` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`gender` int(1) NOT NULL,
	`birthday` date DEFAULT NULL,
	`thumbs_50x50` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`thumbs_120x120` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `user_id__INDEX` (`user_id`),
	KEY `father_id__INDEX` (`father_id`),
	KEY `mother_id__INDEX` (`mother_id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`photos` (
	`id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`item_id` int(255) UNSIGNED NOT NULL,
	`scale` int(2) NOT NULL,
	`path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`width` int(5) NOT NULL,
	`height` int(5) NOT NULL,
	`size` int(8) NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `item_id__type__UNIQUE` (`item_id`, `scale`),
	KEY `item_id__INDEX` (`item_id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tree`.`users` (
	`id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`group_id` int(255) UNSIGNED NOT NULL,
	`username` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`email` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`facebook_profile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`twitter_profile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`instagram_profile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`ok_profile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`vk_profile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`created` datetime NOT NULL,
	`visited` datetime DEFAULT NULL,
	`block` tinyint(1) DEFAULT '0' NOT NULL,
	`block_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`blocked` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `username__UNIQUE` (`username`),
	UNIQUE KEY `email__UNIQUE` (`email`),
	UNIQUE KEY `facebook_profile__UNIQUE` (`facebook_profile`),
	UNIQUE KEY `twitter_profile__UNIQUE` (`twitter_profile`),
	UNIQUE KEY `instagram_profile__UNIQUE` (`instagram_profile`),
	UNIQUE KEY `ok_profile__UNIQUE` (`ok_profile`),
	UNIQUE KEY `vk_profile__UNIQUE` (`vk_profile`),
	KEY `group_id__INDEX` (`group_id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

