-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.16-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for xtd_archive
DROP DATABASE IF EXISTS `xtd_archive`;
CREATE DATABASE IF NOT EXISTS `xtd_archive` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtd_archive`;

-- Dumping structure for table xtd_archive.form_data_histories
DROP TABLE IF EXISTS `form_data_histories`;
CREATE TABLE IF NOT EXISTS `form_data_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `form_data_id` int(10) unsigned NOT NULL DEFAULT '1',
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_data_form` (`form_id`),
  KEY `FK_form_data_form_data_id` (`form_data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_archive.form_data_histories: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_data_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_data_histories` ENABLE KEYS */;

-- Dumping structure for table xtd_archive.form_data_value_histories
DROP TABLE IF EXISTS `form_data_value_histories`;
CREATE TABLE IF NOT EXISTS `form_data_value_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `form_item_id` int(10) unsigned NOT NULL,
  `form_data_id` int(10) unsigned NOT NULL,
  `form_data_value_id` int(10) unsigned NOT NULL,
  `item_version` int(11) NOT NULL,
  `data_version` int(11) NOT NULL DEFAULT '1',
  `text_value` text NOT NULL,
  `number_value` double NOT NULL,
  `file_value` varchar(512) NOT NULL,
  `has_changes` bit(1) NOT NULL DEFAULT b'0',
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_data_value_form_id` (`form_id`),
  KEY `FK_form_data_value_form_item_id` (`form_item_id`),
  KEY `FK_form_data_value_form_data_id` (`form_data_id`),
  KEY `FK_form_data_value_form_data_value_id` (`form_data_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_archive.form_data_value_histories: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_data_value_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_data_value_histories` ENABLE KEYS */;

-- Dumping structure for table xtd_archive.form_histories
DROP TABLE IF EXISTS `form_histories`;
CREATE TABLE IF NOT EXISTS `form_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder_id` int(10) unsigned DEFAULT '0',
  `form_id` int(10) unsigned DEFAULT '0',
  `name` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `banner` varchar(512) DEFAULT NULL,
  `background_image` varchar(512) DEFAULT NULL,
  `background_color` varchar(10) DEFAULT '#ffffff',
  `forecolor` varchar(10) DEFAULT '#000000',
  `version` int(10) unsigned DEFAULT '1',
  `is_featured` tinyint(3) unsigned DEFAULT '0',
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_folder_id` (`folder_id`),
  KEY `FK_form_form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_archive.form_histories: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_histories` ENABLE KEYS */;

-- Dumping structure for table xtd_archive.form_item_element_historys
DROP TABLE IF EXISTS `form_item_element_historys`;
CREATE TABLE IF NOT EXISTS `form_item_element_historys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `form_item_id` int(10) unsigned NOT NULL,
  `form_element_id` int(10) unsigned NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `type` varchar(200) NOT NULL,
  `source` varchar(200) NOT NULL,
  `key_mapping` varchar(200) NOT NULL,
  `display_format` varchar(500) NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  `sort_columns` text,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_item_element_form_item_id` (`form_item_id`),
  KEY `FK_form_item_element_form_id` (`form_id`),
  KEY `FK_form_item_element_id` (`form_element_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_archive.form_item_element_historys: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_item_element_historys` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_item_element_historys` ENABLE KEYS */;

-- Dumping structure for table xtd_archive.form_item_histories
DROP TABLE IF EXISTS `form_item_histories`;
CREATE TABLE IF NOT EXISTS `form_item_histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `form_item_id` int(10) unsigned NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `display` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` varchar(20) NOT NULL,
  `value_type` varchar(50) NOT NULL,
  `default_value` text NOT NULL,
  `default_value_formula` text NOT NULL,
  `value_display_format` text NOT NULL,
  `value_score` int(11) NOT NULL DEFAULT '0',
  `max_width` int(10) unsigned DEFAULT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `font_size` int(10) unsigned DEFAULT NULL,
  `font_color` varchar(10) DEFAULT NULL,
  `is_required` bit(1) DEFAULT b'0',
  `is_searchable` bit(1) DEFAULT b'0',
  `is_readonly` bit(1) DEFAULT b'0',
  `is_private` bit(1) DEFAULT b'0',
  `is_show_in_list` bit(1) DEFAULT b'1',
  `sort_sequence` int(10) unsigned DEFAULT NULL,
  `sequence` int(10) unsigned NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_item_form_id` (`form_id`),
  KEY `FK_form_item_form_item_id` (`form_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_archive.form_item_histories: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_item_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_item_histories` ENABLE KEYS */;


-- Dumping database structure for xtd_core
DROP DATABASE IF EXISTS `xtd_core`;
CREATE DATABASE IF NOT EXISTS `xtd_core` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtd_core`;

-- Dumping structure for table xtd_core.applications
DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_core.applications: ~1 rows (approximately)
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` (`id`, `app_name`, `description`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 'SWNST', '', 'ACTIVE', '2016-11-01 13:42:03', 0, '2016-11-01 13:42:06', 0, '2016-11-01 13:42:08');
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;

-- Dumping structure for table xtd_core.application_secrets
DROP TABLE IF EXISTS `application_secrets`;
CREATE TABLE IF NOT EXISTS `application_secrets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int(11) unsigned NOT NULL,
  `app_id` varchar(100) NOT NULL,
  `secret` varchar(100) NOT NULL,
  `version` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_application_secret_applicatoin` (`application_id`),
  CONSTRAINT `FK_application_secret_applicatoin` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_core.application_secrets: ~1 rows (approximately)
/*!40000 ALTER TABLE `application_secrets` DISABLE KEYS */;
INSERT INTO `application_secrets` (`id`, `application_id`, `app_id`, `secret`, `version`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 1, '6d25b55d-987a-41dd-87b3-4db79b81f86c', '8861b2e14d94', '1.0', 'ACTIVE', '2016-11-01 13:43:08', 0, '2016-11-01 13:43:09', 0, '2016-11-01 13:43:10');
/*!40000 ALTER TABLE `application_secrets` ENABLE KEYS */;

-- Dumping structure for table xtd_core.modules
DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) unsigned NOT NULL,
  `type` enum('SERVER','CLIENT') DEFAULT NULL,
  `group_name` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_application_module` (`app_id`),
  CONSTRAINT `FK_application_module` FOREIGN KEY (`app_id`) REFERENCES `applications` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_core.modules: ~0 rows (approximately)
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;

-- Dumping structure for table xtd_core.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned DEFAULT NULL,
  `owner_id` int(11) unsigned DEFAULT NULL,
  `target_id` int(11) unsigned NOT NULL,
  `target_type` varchar(500) NOT NULL,
  `permission` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IDX_permission_target_id` (`target_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_core.permissions: ~1 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `group_id`, `owner_id`, `target_id`, `target_type`, `permission`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 8, NULL, 6, 'App\\Models\\Folders', 16399, 'ACTIVE', '2016-11-08 11:58:11', 3, '2016-11-08 11:58:11', 3, '2016-11-08 22:10:28');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table xtd_core.system_settings
DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_core.system_settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;


-- Dumping database structure for xtd_datapool
DROP DATABASE IF EXISTS `xtd_datapool`;
CREATE DATABASE IF NOT EXISTS `xtd_datapool` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtd_datapool`;

-- Dumping structure for table xtd_datapool.form_datas
DROP TABLE IF EXISTS `form_datas`;
CREATE TABLE IF NOT EXISTS `form_datas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_data_form` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_datapool.form_datas: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_datas` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_datas` ENABLE KEYS */;

-- Dumping structure for table xtd_datapool.form_data_values
DROP TABLE IF EXISTS `form_data_values`;
CREATE TABLE IF NOT EXISTS `form_data_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `form_item_id` int(10) unsigned NOT NULL,
  `form_data_id` int(10) unsigned NOT NULL,
  `item_version` int(11) NOT NULL,
  `data_version` int(11) NOT NULL DEFAULT '1',
  `text_value` text NOT NULL,
  `number_value` double NOT NULL,
  `file_value` varchar(512) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_data_value_form` (`form_id`),
  KEY `FK_form_data_value_form_item` (`form_item_id`),
  KEY `FK_form_data_value_form_data` (`form_data_id`),
  FULLTEXT KEY `FK_form_data_value_text_value` (`text_value`),
  CONSTRAINT `FK_form_data_value_form_data` FOREIGN KEY (`form_data_id`) REFERENCES `form_datas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_datapool.form_data_values: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_data_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_data_values` ENABLE KEYS */;


-- Dumping database structure for xtd_form_definition
DROP DATABASE IF EXISTS `xtd_form_definition`;
CREATE DATABASE IF NOT EXISTS `xtd_form_definition` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtd_form_definition`;

-- Dumping structure for table xtd_form_definition.folders
DROP TABLE IF EXISTS `folders`;
CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT '0',
  `name` varchar(500) NOT NULL,
  `color` varchar(10) DEFAULT NULL,
  `icon` varchar(512) DEFAULT NULL,
  `is_featured` tinyint(4) DEFAULT '0',
  `sequence` int(11) NOT NULL DEFAULT '1',
  `tags` varchar(500) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_form_definition.folders: ~1 rows (approximately)
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
INSERT INTO `folders` (`id`, `parent_id`, `name`, `color`, `icon`, `is_featured`, `sequence`, `tags`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(6, 0, 'Root', '', NULL, 0, 1, NULL, 'ACTIVE', '2016-11-07 15:07:56', 0, '2016-11-07 15:08:01', 0, '2016-11-07 15:08:02');
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;

-- Dumping structure for table xtd_form_definition.forms
DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder_id` int(10) unsigned DEFAULT '0',
  `related_member_id` int(10) unsigned DEFAULT '0',
  `name` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `version` int(10) unsigned DEFAULT '1',
  `is_featured` tinyint(3) unsigned DEFAULT '0',
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_folder` (`folder_id`),
  CONSTRAINT `FK_form_folder` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_form_definition.forms: ~1 rows (approximately)
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
INSERT INTO `forms` (`id`, `folder_id`, `related_member_id`, `name`, `description`, `version`, `is_featured`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 6, 0, '21項', '21項', 43, 0, 'ACTIVE', '2016-11-07 15:09:11', 3, '2016-11-09 18:02:47', 3, '2016-11-10 01:02:47');
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;

-- Dumping structure for table xtd_form_definition.form_items
DROP TABLE IF EXISTS `form_items`;
CREATE TABLE IF NOT EXISTS `form_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `display` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` varchar(20) NOT NULL,
  `value_type` varchar(50) NOT NULL,
  `value_score` int(11) NOT NULL DEFAULT '0',
  `is_searchable` bit(1) DEFAULT b'0',
  `is_show_in_list` bit(1) DEFAULT b'1',
  `is_show_in_mobile_list` bit(1) DEFAULT b'1',
  `sort_sequence` int(10) unsigned DEFAULT NULL,
  `sequence` int(10) unsigned NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_item_form` (`form_id`),
  CONSTRAINT `FK_form_item_form` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_form_definition.form_items: ~3 rows (approximately)
/*!40000 ALTER TABLE `form_items` DISABLE KEYS */;
INSERT INTO `form_items` (`id`, `form_id`, `display`, `description`, `type`, `value_type`, `value_score`, `is_searchable`, `is_show_in_list`, `is_show_in_mobile_list`, `sort_sequence`, `sequence`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 1, '涉外时间', '涉外时间', 'Singleline', 'string', 0, b'1', b'1', b'1', 1, 0, 'ACTIVE', '2016-11-07 16:18:41', 0, '2016-11-09 18:02:47', 3, '2016-11-10 01:02:47'),
	(2, 1, '引导人QY/JS', '引导人QY/JS', 'Singleline', 'string', 0, b'1', b'1', b'1', 2, 1, 'ACTIVE', '2016-11-07 12:59:14', 3, '2016-11-09 18:02:47', 3, '2016-11-10 01:02:47'),
	(3, 1, '引导人姓名', '引导人姓名', 'Singleline', 'string', 0, b'1', b'1', b'1', 0, 2, 'ACTIVE', '2016-11-07 12:59:14', 3, '2016-11-09 18:02:47', 3, '2016-11-10 01:02:47');
/*!40000 ALTER TABLE `form_items` ENABLE KEYS */;

-- Dumping structure for table xtd_form_definition.form_list_items
DROP TABLE IF EXISTS `form_list_items`;
CREATE TABLE IF NOT EXISTS `form_list_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `form_item_id` int(10) unsigned NOT NULL,
  `display_format` varchar(500) NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  `sort_columns` text,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_list_item_form` (`form_id`),
  KEY `FK_form_list_item_form_item` (`form_item_id`),
  CONSTRAINT `FK_form_list_item_form` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`),
  CONSTRAINT `FK_form_list_item_form_item` FOREIGN KEY (`form_item_id`) REFERENCES `form_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_form_definition.form_list_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_list_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_list_items` ENABLE KEYS */;

-- Dumping structure for table xtd_form_definition.item_properties
DROP TABLE IF EXISTS `item_properties`;
CREATE TABLE IF NOT EXISTS `item_properties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `target_id` int(10) unsigned NOT NULL,
  `target_type` varchar(500) NOT NULL,
  `group` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `rule` text NOT NULL,
  `value` text NOT NULL,
  `sequence` int(10) unsigned NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IDX_item_properties_target_id` (`target_id`),
  KEY `IDX_item_properties_target_type` (`target_type`(255))
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_form_definition.item_properties: ~96 rows (approximately)
/*!40000 ALTER TABLE `item_properties` DISABLE KEYS */;
INSERT INTO `item_properties` (`id`, `target_id`, `target_type`, `group`, `name`, `type`, `rule`, `value`, `sequence`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 1, 'App\\Models\\Forms', 'common', 'display', 'TextBox', '', '21項', 0, 'ACTIVE', '2016-11-08 14:52:32', 3, '2016-11-08 14:52:32', 3, '2016-11-08 21:52:32'),
	(2, 1, 'App\\Models\\Forms', 'common', 'description', 'TextBox', '', '21項', 0, 'ACTIVE', '2016-11-08 14:52:32', 3, '2016-11-08 14:52:32', 3, '2016-11-08 21:52:32'),
	(3, 1, 'App\\Models\\Forms', 'common', 'default_value', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:32', 3, '2016-11-08 14:52:32', 3, '2016-11-08 21:52:32'),
	(4, 1, 'App\\Models\\Forms', 'common', 'placeholder', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:32', 3, '2016-11-08 14:52:32', 3, '2016-11-08 21:52:32'),
	(5, 1, 'App\\Models\\Forms', 'common', 'is_featured', 'TextBox', '', '0', 0, 'ACTIVE', '2016-11-08 14:52:32', 3, '2016-11-08 14:52:32', 3, '2016-11-08 21:52:32'),
	(6, 1, 'App\\Models\\Forms', 'common', 'tooltips', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(7, 1, 'App\\Models\\Forms', 'layout', 'width', 'TextBox', '', '100px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(8, 1, 'App\\Models\\Forms', 'layout', 'height', 'TextBox', '', '23px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(9, 1, 'App\\Models\\Forms', 'layout', 'horizontalAlignment', 'TextBox', '', 'left', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(10, 1, 'App\\Models\\Forms', 'layout', 'verticalAlignment', 'TextBox', '', 'top', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(11, 1, 'App\\Models\\Forms', 'layout', 'marginTop', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(12, 1, 'App\\Models\\Forms', 'layout', 'marginRight', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(13, 1, 'App\\Models\\Forms', 'layout', 'marginBottom', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(14, 1, 'App\\Models\\Forms', 'layout', 'marginLeft', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(15, 1, 'App\\Models\\Forms', 'brush', 'backgroundColor', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(16, 1, 'App\\Models\\Forms', 'brush', 'backgroundImage', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(17, 1, 'App\\Models\\Forms', 'brush', 'foregroundColor', 'TextBox', '', '#000000', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(18, 1, 'App\\Models\\Forms', 'text', 'size', 'TextBox', '', '14px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(19, 1, 'App\\Models\\Forms', 'text', 'weight', 'TextBox', '', 'normal', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(20, 1, 'App\\Models\\Forms', 'text', 'textDecoration', 'TextBox', '', 'none', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(21, 1, 'App\\Models\\Forms', 'text', 'style', 'TextBox', '', 'normal', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(22, 1, 'App\\Models\\FormItems', 'common', 'display', 'TextBox', '', '涉外时间', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(23, 1, 'App\\Models\\FormItems', 'common', 'description', 'TextBox', '', '涉外时间', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(24, 1, 'App\\Models\\FormItems', 'common', 'default_value', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(25, 1, 'App\\Models\\FormItems', 'common', 'placeholder', 'TextBox', '', '涉外时间, 如: 2000-12-25', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(26, 1, 'App\\Models\\FormItems', 'common', 'tooltips', 'TextBox', '', '涉外时间', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(27, 1, 'App\\Models\\FormItems', 'common', 'is_searchable', 'CheckBox', '', 'true', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(28, 1, 'App\\Models\\FormItems', 'common', 'is_show_in_list', 'CheckBox', '', 'true', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(29, 1, 'App\\Models\\FormItems', 'common', 'is_show_in_mobile_list', 'CheckBox', '', 'true', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(30, 1, 'App\\Models\\FormItems', 'common', 'sort_sequence', 'TextBox', '', '1', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(31, 1, 'App\\Models\\FormItems', 'layout', 'width', 'TextBox', '', '230px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(32, 1, 'App\\Models\\FormItems', 'layout', 'height', 'TextBox', '', '23px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(33, 1, 'App\\Models\\FormItems', 'layout', 'horizontalAlignment', 'TextBox', '', 'left', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(34, 1, 'App\\Models\\FormItems', 'layout', 'verticalAlignment', 'TextBox', '', 'top', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(35, 1, 'App\\Models\\FormItems', 'layout', 'marginTop', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(36, 1, 'App\\Models\\FormItems', 'layout', 'marginRight', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(37, 1, 'App\\Models\\FormItems', 'layout', 'marginBottom', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(38, 1, 'App\\Models\\FormItems', 'layout', 'marginLeft', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(39, 1, 'App\\Models\\FormItems', 'brush', 'backgroundColor', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(40, 1, 'App\\Models\\FormItems', 'brush', 'backgroundImage', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(41, 1, 'App\\Models\\FormItems', 'brush', 'foregroundColor', 'TextBox', '', '#000000', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(42, 1, 'App\\Models\\FormItems', 'text', 'size', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(43, 1, 'App\\Models\\FormItems', 'text', 'weight', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(44, 1, 'App\\Models\\FormItems', 'text', 'textDecoration', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(45, 1, 'App\\Models\\FormItems', 'text', 'style', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(46, 1, 'App\\Models\\FormItems', 'validations', '', 'Mandatory', '', '時間不能為空', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(47, 2, 'App\\Models\\FormItems', 'common', 'display', 'TextBox', '', '引导人QY/JS', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(48, 2, 'App\\Models\\FormItems', 'common', 'description', 'TextBox', '', '引导人QY/JS', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(49, 2, 'App\\Models\\FormItems', 'common', 'default_value', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(50, 2, 'App\\Models\\FormItems', 'common', 'placeholder', 'TextBox', '', '引导人QY/JS, 如: 青年', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(51, 2, 'App\\Models\\FormItems', 'common', 'tooltips', 'TextBox', '', '引导人QY/JS', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(52, 2, 'App\\Models\\FormItems', 'common', 'is_searchable', 'CheckBox', '', 'true', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(53, 2, 'App\\Models\\FormItems', 'common', 'is_show_in_list', 'CheckBox', '', 'true', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(54, 2, 'App\\Models\\FormItems', 'common', 'is_show_in_mobile_list', 'CheckBox', '', 'true', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(55, 2, 'App\\Models\\FormItems', 'common', 'sort_sequence', 'TextBox', '', '2', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(56, 2, 'App\\Models\\FormItems', 'layout', 'width', 'TextBox', '', '140px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(57, 2, 'App\\Models\\FormItems', 'layout', 'height', 'TextBox', '', '23px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(58, 2, 'App\\Models\\FormItems', 'layout', 'horizontalAlignment', 'TextBox', '', 'left', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(59, 2, 'App\\Models\\FormItems', 'layout', 'verticalAlignment', 'TextBox', '', 'top', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(60, 2, 'App\\Models\\FormItems', 'layout', 'marginTop', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(61, 2, 'App\\Models\\FormItems', 'layout', 'marginRight', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(62, 2, 'App\\Models\\FormItems', 'layout', 'marginBottom', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(63, 2, 'App\\Models\\FormItems', 'layout', 'marginLeft', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(64, 2, 'App\\Models\\FormItems', 'brush', 'backgroundColor', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(65, 2, 'App\\Models\\FormItems', 'brush', 'backgroundImage', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(66, 2, 'App\\Models\\FormItems', 'brush', 'foregroundColor', 'TextBox', '', '#000000', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(67, 2, 'App\\Models\\FormItems', 'text', 'size', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(68, 2, 'App\\Models\\FormItems', 'text', 'weight', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(69, 2, 'App\\Models\\FormItems', 'text', 'textDecoration', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(70, 2, 'App\\Models\\FormItems', 'text', 'style', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(71, 2, 'App\\Models\\FormItems', 'validations', '', 'Mandatory', '', 'QY/JS不能為空', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(72, 3, 'App\\Models\\FormItems', 'common', 'display', 'TextBox', '', '引导人姓名', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(73, 3, 'App\\Models\\FormItems', 'common', 'description', 'TextBox', '', '引导人姓名', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(74, 3, 'App\\Models\\FormItems', 'common', 'default_value', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(75, 3, 'App\\Models\\FormItems', 'common', 'placeholder', 'TextBox', '', '姓名, 如: 金約翰', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(76, 3, 'App\\Models\\FormItems', 'common', 'tooltips', 'TextBox', '', '引导人姓名', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(77, 3, 'App\\Models\\FormItems', 'common', 'is_searchable', 'CheckBox', '', 'true', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(78, 3, 'App\\Models\\FormItems', 'common', 'is_show_in_list', 'CheckBox', '', 'false', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(79, 3, 'App\\Models\\FormItems', 'common', 'is_show_in_mobile_list', 'CheckBox', '', 'true', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(80, 3, 'App\\Models\\FormItems', 'common', 'sort_sequence', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(81, 3, 'App\\Models\\FormItems', 'layout', 'width', 'TextBox', '', '150px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(82, 3, 'App\\Models\\FormItems', 'layout', 'height', 'TextBox', '', '23px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(83, 3, 'App\\Models\\FormItems', 'layout', 'horizontalAlignment', 'TextBox', '', 'left', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(84, 3, 'App\\Models\\FormItems', 'layout', 'verticalAlignment', 'TextBox', '', 'top', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(85, 3, 'App\\Models\\FormItems', 'layout', 'marginTop', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(86, 3, 'App\\Models\\FormItems', 'layout', 'marginRight', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(87, 3, 'App\\Models\\FormItems', 'layout', 'marginBottom', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(88, 3, 'App\\Models\\FormItems', 'layout', 'marginLeft', 'TextBox', '', '0px', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(89, 3, 'App\\Models\\FormItems', 'brush', 'backgroundColor', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(90, 3, 'App\\Models\\FormItems', 'brush', 'backgroundImage', 'TextBox', '', '', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(91, 3, 'App\\Models\\FormItems', 'brush', 'foregroundColor', 'TextBox', '', '#000000', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(92, 3, 'App\\Models\\FormItems', 'text', 'size', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(93, 3, 'App\\Models\\FormItems', 'text', 'weight', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(94, 3, 'App\\Models\\FormItems', 'text', 'textDecoration', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(95, 3, 'App\\Models\\FormItems', 'text', 'style', 'TextBox', '', 'inherit', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33'),
	(96, 3, 'App\\Models\\FormItems', 'validations', '', 'Mandatory', '', '姓名不能為空', 0, 'ACTIVE', '2016-11-08 14:52:33', 3, '2016-11-08 14:52:33', 3, '2016-11-08 21:52:33');
/*!40000 ALTER TABLE `item_properties` ENABLE KEYS */;


-- Dumping database structure for xtd_membership
DROP DATABASE IF EXISTS `xtd_membership`;
CREATE DATABASE IF NOT EXISTS `xtd_membership` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtd_membership`;

-- Dumping structure for table xtd_membership.groups
DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(500) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_membership.groups: ~1 rows (approximately)
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `parent_id`, `name`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(8, 0, 'test 1', 'ACTIVE', '2016-11-02 10:02:34', 3, '2016-11-02 10:13:55', 3, '2016-11-08 13:57:48');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

-- Dumping structure for table xtd_membership.group_members
DROP TABLE IF EXISTS `group_members`;
CREATE TABLE IF NOT EXISTS `group_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_group_member_group` (`group_id`),
  KEY `FK_group_member_member` (`member_id`),
  CONSTRAINT `FK_group_member_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  CONSTRAINT `FK_group_member_member` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_membership.group_members: ~1 rows (approximately)
/*!40000 ALTER TABLE `group_members` DISABLE KEYS */;
INSERT INTO `group_members` (`id`, `group_id`, `member_id`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(2, 8, 3, 'ACTIVE', '2016-11-08 13:58:32', 3, '2016-11-08 13:58:35', 3, '2016-11-08 13:58:36');
/*!40000 ALTER TABLE `group_members` ENABLE KEYS */;

-- Dumping structure for table xtd_membership.members
DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `photo` varchar(512) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `login_ip` varchar(45) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table xtd_membership.members: ~1 rows (approximately)
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` (`id`, `username`, `password`, `code`, `display_name`, `photo`, `email`, `phone`, `status`, `login_ip`, `login_time`, `token`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'a2f8e04814b8', 'Administrator', '', 'jacky.yiu@mouxidea.com.hk', '852) 62882776', 'ACTIVE', '::1', '2016-11-07 11:19:13', 'd4ea38b439757a8f365ab13414654b2d', '2016-11-01 12:31:36', 0, '2016-11-07 11:19:13', 0, '2016-11-07 18:19:13');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
