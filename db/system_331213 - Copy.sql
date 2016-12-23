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


-- Dumping database structure for xtduat_archive
CREATE DATABASE IF NOT EXISTS `xtduat_archive` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtduat_archive`;

-- Dumping structure for table xtduat_archive.form_data_histories
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

-- Dumping data for table xtduat_archive.form_data_histories: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_data_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_data_histories` ENABLE KEYS */;

-- Dumping structure for table xtduat_archive.form_data_value_histories
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
  `has_changes` tinyint(1) NOT NULL DEFAULT b'0',
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

-- Dumping data for table xtduat_archive.form_data_value_histories: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_data_value_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_data_value_histories` ENABLE KEYS */;

-- Dumping structure for table xtduat_archive.form_histories
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
  `is_featured` tinyint(1) unsigned DEFAULT '0',
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

-- Dumping data for table xtduat_archive.form_histories: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_histories` ENABLE KEYS */;

-- Dumping structure for table xtduat_archive.form_item_element_historys
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

-- Dumping data for table xtduat_archive.form_item_element_historys: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_item_element_historys` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_item_element_historys` ENABLE KEYS */;

-- Dumping structure for table xtduat_archive.form_item_histories
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
  `is_required` tinyint(1) DEFAULT b'0',
  `is_searchable` tinyint(1) DEFAULT b'0',
  `is_readonly` tinyint(1) DEFAULT b'0',
  `is_private` tinyint(1) DEFAULT b'0',
  `is_show_in_list` tinyint(1) DEFAULT b'1',
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

-- Dumping data for table xtduat_archive.form_item_histories: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_item_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_item_histories` ENABLE KEYS */;


-- Dumping database structure for xtduat_core
CREATE DATABASE IF NOT EXISTS `xtduat_core` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtduat_core`;

-- Dumping structure for table xtduat_core.applications
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

-- Dumping data for table xtduat_core.applications: ~0 rows (approximately)
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
REPLACE INTO `applications` (`id`, `app_name`, `description`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 'SWNST', '', 'ACTIVE', '2016-11-01 13:42:03', 0, '2016-11-01 13:42:06', 0, '2016-11-01 13:42:08');
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;

-- Dumping structure for table xtduat_core.application_secrets
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

-- Dumping data for table xtduat_core.application_secrets: ~0 rows (approximately)
/*!40000 ALTER TABLE `application_secrets` DISABLE KEYS */;
REPLACE INTO `application_secrets` (`id`, `application_id`, `app_id`, `secret`, `version`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 1, '6d25b55d-987a-41dd-87b3-4db79b81f86c', '8861b2e14d94', '1.0', 'ACTIVE', '2016-11-01 13:43:08', 0, '2016-11-01 13:43:09', 0, '2016-11-01 13:43:10');
/*!40000 ALTER TABLE `application_secrets` ENABLE KEYS */;

-- Dumping structure for table xtduat_core.glossaries
CREATE TABLE IF NOT EXISTS `glossaries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `target_id` int(11) NOT NULL,
  `target_type` varchar(500) NOT NULL,
  `language` varchar(6) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(11) NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_glossaries_target_id` (`target_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_core.glossaries: ~76 rows (approximately)
/*!40000 ALTER TABLE `glossaries` DISABLE KEYS */;
REPLACE INTO `glossaries` (`id`, `target_id`, `target_type`, `language`, `content`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 1, 'App\\Models\\StaticContents', 'zh-cn', '属性', 'ACTIVE', '2016-12-08 17:27:33', 3, '2016-12-08 17:27:33', 3, '2016-12-08 17:27:33'),
	(2, 2, 'App\\Models\\StaticContents', 'zh-cn', '公用', 'ACTIVE', '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07'),
	(3, 3, 'App\\Models\\StaticContents', 'zh-cn', '显示', 'ACTIVE', '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07'),
	(4, 4, 'App\\Models\\StaticContents', 'zh-cn', '默认值', 'ACTIVE', '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07'),
	(5, 5, 'App\\Models\\StaticContents', 'zh-cn', '占位符', 'ACTIVE', '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07'),
	(6, 6, 'App\\Models\\StaticContents', 'zh-cn', '提示', 'ACTIVE', '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07'),
	(7, 7, 'App\\Models\\StaticContents', 'zh-cn', '可搜索', 'ACTIVE', '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07', 3, '2016-12-08 17:47:07'),
	(8, 51, 'App\\Models\\StaticContents', 'zh-cn', '版权所有 © 由 2012 <a href="http://www.shincheonji.kr/">Shincheonji</a>.', 'ACTIVE', '2016-12-12 08:43:48', 3, '2016-12-12 08:52:43', 3, '2016-12-12 15:43:48'),
	(9, 52, 'App\\Models\\StaticContents', 'zh-cn', '翻译管理', 'ACTIVE', '2016-12-12 08:45:39', 3, '2016-12-12 11:18:19', 3, '2016-12-12 15:45:39'),
	(10, 33, 'App\\Models\\StaticContents', 'zh-cn', '電郵', 'ACTIVE', '2016-12-12 08:46:11', 3, '2016-12-12 08:46:11', 3, '2016-12-12 15:46:11'),
	(11, 44, 'App\\Models\\StaticContents', 'zh-cn', '電郵地址', 'ACTIVE', '2016-12-12 08:46:17', 3, '2016-12-12 08:46:17', 3, '2016-12-12 15:46:17'),
	(12, 39, 'App\\Models\\StaticContents', 'zh-cn', '顯示名稱', 'ACTIVE', '2016-12-12 08:46:28', 3, '2016-12-12 08:46:28', 3, '2016-12-12 15:46:28'),
	(13, 40, 'App\\Models\\StaticContents', 'zh-cn', '輸入顯示名稱', 'ACTIVE', '2016-12-12 08:46:47', 3, '2016-12-12 08:46:47', 3, '2016-12-12 15:46:47'),
	(14, 42, 'App\\Models\\StaticContents', 'zh-cn', '輸入用戶名', 'ACTIVE', '2016-12-12 08:46:55', 3, '2016-12-12 08:46:55', 3, '2016-12-12 15:46:55'),
	(15, 43, 'App\\Models\\StaticContents', 'zh-cn', '密碼', 'ACTIVE', '2016-12-12 08:47:13', 3, '2016-12-12 08:47:13', 3, '2016-12-12 15:47:13'),
	(16, 53, 'App\\Models\\StaticContents', 'zh-cn', '翻譯', 'ACTIVE', '2016-12-12 08:49:04', 3, '2016-12-12 08:49:04', 3, '2016-12-12 15:49:04'),
	(17, 13, 'App\\Models\\StaticContents', 'zh-cn', '高度', 'ACTIVE', '2016-12-12 08:51:02', 3, '2016-12-12 08:51:02', 3, '2016-12-12 15:51:02'),
	(18, 14, 'App\\Models\\StaticContents', 'zh-cn', '水平对齐', 'ACTIVE', '2016-12-12 08:51:36', 3, '2016-12-12 08:51:36', 3, '2016-12-12 15:51:36'),
	(19, 57, 'App\\Models\\StaticContents', 'zh-cn', '控件', 'ACTIVE', '2016-12-12 08:52:02', 3, '2016-12-12 08:52:02', 3, '2016-12-12 15:52:02'),
	(20, 61, 'App\\Models\\StaticContents', 'zh-cn', '删除', 'ACTIVE', '2016-12-12 08:52:53', 3, '2016-12-12 08:52:53', 3, '2016-12-12 15:52:53'),
	(21, 58, 'App\\Models\\StaticContents', 'zh-cn', '创建', 'ACTIVE', '2016-12-12 08:53:02', 3, '2016-12-12 08:53:02', 3, '2016-12-12 15:53:02'),
	(22, 34, 'App\\Models\\StaticContents', 'zh-cn', '电话', 'ACTIVE', '2016-12-12 08:53:24', 3, '2016-12-12 08:53:24', 3, '2016-12-12 15:53:24'),
	(23, 45, 'App\\Models\\StaticContents', 'zh-cn', '照片', 'ACTIVE', '2016-12-12 08:53:37', 3, '2016-12-12 08:53:37', 3, '2016-12-12 15:53:37'),
	(24, 31, 'App\\Models\\StaticContents', 'zh-cn', '登出', 'ACTIVE', '2016-12-12 08:53:48', 3, '2016-12-12 08:53:48', 3, '2016-12-12 15:53:48'),
	(25, 11, 'App\\Models\\StaticContents', 'zh-cn', '布局', 'ACTIVE', '2016-12-12 08:54:05', 3, '2016-12-12 08:54:05', 3, '2016-12-12 15:54:05'),
	(26, 32, 'App\\Models\\StaticContents', 'zh-cn', '成员管理', 'ACTIVE', '2016-12-12 08:54:25', 3, '2016-12-12 08:54:25', 3, '2016-12-12 15:54:25'),
	(27, 36, 'App\\Models\\StaticContents', 'zh-cn', '成员', 'ACTIVE', '2016-12-12 08:54:31', 3, '2016-12-12 08:54:31', 3, '2016-12-12 15:54:31'),
	(28, 30, 'App\\Models\\StaticContents', 'zh-cn', '简介', 'ACTIVE', '2016-12-12 08:54:41', 3, '2016-12-12 08:54:41', 3, '2016-12-12 15:54:41'),
	(29, 50, 'App\\Models\\StaticContents', 'zh-cn', '版本', 'ACTIVE', '2016-12-12 08:55:15', 3, '2016-12-12 08:55:15', 3, '2016-12-12 15:55:15'),
	(30, 60, 'App\\Models\\StaticContents', 'zh-cn', '查看', 'ACTIVE', '2016-12-12 08:55:49', 3, '2016-12-12 08:55:49', 3, '2016-12-12 15:55:49'),
	(31, 23, 'App\\Models\\StaticContents', 'zh-cn', '目前没有通知。', 'ACTIVE', '2016-12-12 08:56:00', 3, '2016-12-12 08:56:00', 3, '2016-12-12 15:56:00'),
	(32, 38, 'App\\Models\\StaticContents', 'zh-cn', '新成员', 'ACTIVE', '2016-12-12 08:56:20', 3, '2016-12-12 08:56:20', 3, '2016-12-12 15:56:20'),
	(33, 15, 'App\\Models\\StaticContents', 'zh-cn', '垂直对齐', 'ACTIVE', '2016-12-12 08:56:40', 3, '2016-12-12 08:56:40', 3, '2016-12-12 15:56:40'),
	(34, 35, 'App\\Models\\StaticContents', 'zh-cn', '搜索会员', 'ACTIVE', '2016-12-12 08:56:55', 3, '2016-12-12 08:57:10', 3, '2016-12-12 15:56:55'),
	(35, 54, 'App\\Models\\StaticContents', 'zh-cn', '搜索翻译', 'ACTIVE', '2016-12-12 08:57:21', 3, '2016-12-12 08:57:21', 3, '2016-12-12 15:57:21'),
	(36, 55, 'App\\Models\\StaticContents', 'zh-cn', '新翻译', 'ACTIVE', '2016-12-12 11:11:13', 3, '2016-12-12 11:11:13', 3, '2016-12-12 18:11:13'),
	(37, 10, 'App\\Models\\StaticContents', 'zh-cn', '排序序列', 'ACTIVE', '2016-12-12 11:11:27', 3, '2016-12-12 11:11:27', 3, '2016-12-12 18:11:27'),
	(38, 41, 'App\\Models\\StaticContents', 'zh-cn', '用户名', 'ACTIVE', '2016-12-12 11:11:46', 3, '2016-12-12 11:11:46', 3, '2016-12-12 18:11:46'),
	(39, 8, 'App\\Models\\StaticContents', 'zh-cn', '显示在列表中', 'ACTIVE', '2016-12-12 11:14:40', 3, '2016-12-12 11:14:40', 3, '2016-12-12 18:14:40'),
	(40, 9, 'App\\Models\\StaticContents', 'zh-cn', '显示在手机列表中', 'ACTIVE', '2016-12-12 11:15:14', 3, '2016-12-12 11:15:14', 3, '2016-12-12 18:15:14'),
	(41, 18, 'App\\Models\\StaticContents', 'zh-cn', '底边距', 'ACTIVE', '2016-12-12 11:15:56', 3, '2016-12-12 11:15:56', 3, '2016-12-12 18:15:56'),
	(42, 19, 'App\\Models\\StaticContents', 'zh-cn', '左边距', 'ACTIVE', '2016-12-12 11:16:11', 3, '2016-12-12 11:16:11', 3, '2016-12-12 18:16:11'),
	(43, 17, 'App\\Models\\StaticContents', 'zh-cn', '右边距', 'ACTIVE', '2016-12-12 11:16:21', 3, '2016-12-12 11:16:21', 3, '2016-12-12 18:16:21'),
	(44, 16, 'App\\Models\\StaticContents', 'zh-cn', '上边距', 'ACTIVE', '2016-12-12 11:16:32', 3, '2016-12-12 11:16:32', 3, '2016-12-12 18:16:32'),
	(45, 37, 'App\\Models\\StaticContents', 'zh-cn', '搜索会员', 'ACTIVE', '2016-12-12 11:16:54', 3, '2016-12-12 11:16:54', 3, '2016-12-12 18:16:54'),
	(46, 56, 'App\\Models\\StaticContents', 'zh-cn', '静态词', 'ACTIVE', '2016-12-12 11:17:11', 3, '2016-12-12 11:17:11', 3, '2016-12-12 18:17:11'),
	(47, 47, 'App\\Models\\StaticContents', 'zh-cn', '状态', 'ACTIVE', '2016-12-12 11:17:22', 3, '2016-12-12 11:17:22', 3, '2016-12-12 18:17:22'),
	(48, 26, 'App\\Models\\StaticContents', 'zh-cn', '查看全部', 'ACTIVE', '2016-12-12 11:17:43', 3, '2016-12-12 11:17:43', 3, '2016-12-12 18:17:43'),
	(49, 12, 'App\\Models\\StaticContents', 'zh-cn', '宽度', 'ACTIVE', '2016-12-12 11:18:00', 3, '2016-12-12 11:18:00', 3, '2016-12-12 18:18:00'),
	(50, 59, 'App\\Models\\StaticContents', 'zh-cn', '更新', 'ACTIVE', '2016-12-12 11:18:56', 3, '2016-12-12 11:18:56', 3, '2016-12-12 18:18:56'),
	(51, 49, 'App\\Models\\StaticContents', 'zh-cn', '暂停', 'ACTIVE', '2016-12-12 11:19:11', 3, '2016-12-12 11:19:11', 3, '2016-12-12 18:19:11'),
	(52, 48, 'App\\Models\\StaticContents', 'zh-cn', '启用', 'ACTIVE', '2016-12-12 11:19:31', 3, '2016-12-12 11:19:31', 3, '2016-12-12 18:19:31'),
	(53, 28, 'App\\Models\\StaticContents', 'zh-cn', '查看所有任务', 'ACTIVE', '2016-12-12 11:19:53', 3, '2016-12-12 11:19:53', 3, '2016-12-12 18:19:53'),
	(54, 46, 'App\\Models\\StaticContents', 'zh-cn', '用户个人资料照片', 'ACTIVE', '2016-12-12 11:23:32', 3, '2016-12-12 11:23:32', 3, '2016-12-12 18:23:32'),
	(55, 62, 'App\\Models\\StaticContents', 'zh-cn', '线上', 'ACTIVE', '2016-12-12 11:25:33', 3, '2016-12-12 11:25:33', 3, '2016-12-12 18:25:33'),
	(56, 63, 'App\\Models\\StaticContents', 'zh-cn', '搜索...', 'ACTIVE', '2016-12-12 11:26:06', 3, '2016-12-12 11:26:06', 3, '2016-12-12 18:26:06'),
	(57, 65, 'App\\Models\\StaticContents', 'zh-cn', '子群组', 'ACTIVE', '2016-12-12 11:27:33', 3, '2016-12-12 11:50:28', 3, '2016-12-12 18:27:33'),
	(58, 24, 'App\\Models\\StaticContents', 'zh-cn', '查看所有消息', 'ACTIVE', '2016-12-12 11:27:45', 3, '2016-12-12 11:27:45', 3, '2016-12-12 18:27:45'),
	(59, 64, 'App\\Models\\StaticContents', 'zh-cn', '上一层', 'ACTIVE', '2016-12-12 11:28:15', 3, '2016-12-12 11:28:15', 3, '2016-12-12 18:28:15'),
	(60, 66, 'App\\Models\\StaticContents', 'zh-cn', '主导航', 'ACTIVE', '2016-12-12 11:39:47', 3, '2016-12-12 11:39:47', 3, '2016-12-12 18:39:47'),
	(61, 68, 'App\\Models\\StaticContents', 'zh-cn', '管理', 'ACTIVE', '2016-12-12 11:40:00', 3, '2016-12-12 11:40:00', 3, '2016-12-12 18:40:00'),
	(62, 67, 'App\\Models\\StaticContents', 'zh-cn', '群组', 'ACTIVE', '2016-12-12 11:43:18', 3, '2016-12-12 11:43:18', 3, '2016-12-12 18:43:18'),
	(63, 69, 'App\\Models\\StaticContents', 'zh-cn', '添加用户', 'ACTIVE', '2016-12-12 11:45:56', 3, '2016-12-12 11:45:56', 3, '2016-12-12 18:45:56'),
	(64, 70, 'App\\Models\\StaticContents', 'zh-cn', '删除用户', 'ACTIVE', '2016-12-12 11:46:07', 3, '2016-12-12 11:46:07', 3, '2016-12-12 18:46:07'),
	(65, 72, 'App\\Models\\StaticContents', 'zh-cn', '内容', 'ACTIVE', '2016-12-12 11:48:03', 3, '2016-12-12 11:48:03', 3, '2016-12-12 18:48:03'),
	(66, 71, 'App\\Models\\StaticContents', 'zh-cn', '语言', 'ACTIVE', '2016-12-12 11:48:14', 3, '2016-12-12 11:48:14', 3, '2016-12-12 18:48:14'),
	(67, 73, 'App\\Models\\StaticContents', 'zh-cn', '新群组，按输入键提交', 'ACTIVE', '2016-12-12 11:51:25', 3, '2016-12-12 11:51:25', 3, '2016-12-12 18:51:25'),
	(68, 74, 'App\\Models\\StaticContents', 'zh-cn', '保存', 'ACTIVE', '2016-12-12 11:57:34', 3, '2016-12-12 11:57:34', 3, '2016-12-12 18:57:34'),
	(69, 79, 'App\\Models\\StaticContents', 'zh-cn', '按此创建新文件夹', 'ACTIVE', '2016-12-12 17:36:33', 3, '2016-12-12 17:36:33', 3, '2016-12-13 00:36:33'),
	(70, 77, 'App\\Models\\StaticContents', 'zh-cn', '按此创建新表单', 'ACTIVE', '2016-12-12 17:36:53', 3, '2016-12-12 17:36:53', 3, '2016-12-13 00:36:53'),
	(71, 80, 'App\\Models\\StaticContents', 'zh-cn', '新文件夹', 'ACTIVE', '2016-12-12 17:37:07', 3, '2016-12-12 17:37:07', 3, '2016-12-13 00:37:07'),
	(72, 78, 'App\\Models\\StaticContents', 'zh-cn', '新表单', 'ACTIVE', '2016-12-12 17:37:19', 3, '2016-12-12 17:37:19', 3, '2016-12-13 00:37:19'),
	(73, 76, 'App\\Models\\StaticContents', 'zh-cn', '最后提交', 'ACTIVE', '2016-12-12 17:37:43', 3, '2016-12-12 17:37:43', 3, '2016-12-13 00:37:43'),
	(74, 22, 'App\\Models\\StaticContents', 'zh-cn', '您有0条消息', 'ACTIVE', '2016-12-12 17:38:28', 3, '2016-12-12 17:38:28', 3, '2016-12-13 00:38:28'),
	(75, 25, 'App\\Models\\StaticContents', 'zh-cn', '您有0个通知', 'ACTIVE', '2016-12-12 17:38:41', 3, '2016-12-12 17:38:41', 3, '2016-12-13 00:38:41'),
	(76, 27, 'App\\Models\\StaticContents', 'zh-cn', '你有0个任务', 'ACTIVE', '2016-12-12 17:38:55', 3, '2016-12-12 17:38:55', 3, '2016-12-13 00:38:55');
/*!40000 ALTER TABLE `glossaries` ENABLE KEYS */;

-- Dumping structure for table xtduat_core.modules
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

-- Dumping data for table xtduat_core.modules: ~0 rows (approximately)
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;

-- Dumping structure for table xtduat_core.permissions
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_core.permissions: ~4 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
REPLACE INTO `permissions` (`id`, `group_id`, `owner_id`, `target_id`, `target_type`, `permission`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, NULL, NULL, 6, 'App\\Models\\Folders', 32895, 'ACTIVE', '2016-11-08 11:58:11', 3, '2016-11-08 11:58:11', 3, '2016-12-05 13:11:09'),
	(2, NULL, NULL, 7, 'App\\Models\\Folders', 32895, 'ACTIVE', '2016-12-05 14:57:21', 3, '2016-12-05 14:57:21', 3, '2016-12-05 14:57:35'),
	(3, 8, 4, 8, 'App\\Models\\Groups', 0, 'ACTIVE', '2016-12-10 11:49:35', 3, '2016-12-10 11:49:35', 3, '2016-12-10 18:52:14'),
	(4, 8, 3, 8, 'App\\Models\\Groups', 63, 'ACTIVE', '2016-12-10 11:51:36', 3, '2016-12-10 12:02:53', 3, '2016-12-10 19:02:53');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table xtduat_core.static_contents
CREATE TABLE IF NOT EXISTS `static_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grouping` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(11) NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_core.static_contents: ~80 rows (approximately)
/*!40000 ALTER TABLE `static_contents` DISABLE KEYS */;
REPLACE INTO `static_contents` (`id`, `grouping`, `content`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, '', 'Properties', '2016-12-08 17:21:51', 3, '2016-12-08 17:21:51', 3, '2016-12-08 17:21:51'),
	(2, '', 'common', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(3, '', 'display', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(4, '', 'default_value', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(5, '', 'placeholder', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(6, '', 'tooltips', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(7, '', 'is_searchable', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(8, '', 'is_show_in_list', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(9, '', 'is_show_in_mobile_list', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(10, '', 'sort_sequence', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(11, '', 'layout', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(12, '', 'width', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(13, '', 'height', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(14, '', 'horizontalAlignment', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(15, '', 'verticalAlignment', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(16, '', 'marginTop', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(17, '', 'marginRight', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(18, '', 'marginBottom', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(19, '', 'marginLeft', '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55', 3, '2016-12-08 17:24:55'),
	(20, '', '<b>S</b>CJ', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(21, '', '<b>SCJ</b>System', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:18:17'),
	(22, '', 'You have 0 message', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(23, '', 'Currently has no notification.', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(24, '', 'See All Messages', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(25, '', 'You have 0 notification', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(26, '', 'View all', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(27, '', 'You have 0 task', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(28, '', 'View all tasks', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(29, '', 'Member since Nov. 2012', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(30, '', 'Profile', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(31, '', 'Sign out', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(32, '', 'Manage Members', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(33, '', 'Email', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(34, '', 'Phone', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(35, '', 'Last Login', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(36, '', 'Members', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(37, '', 'Search member', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(38, '', 'New Member', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(39, '', 'Display Name', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(40, '', 'Enter display name', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(41, '', 'Username', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(42, '', 'Enter username', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(43, '', 'Password', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(44, '', 'Email address', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(45, '', 'Photo', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(46, '', 'User profile photo', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(47, '', 'Status', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(48, '', 'Active', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(49, '', 'Suspended', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(50, '', 'Version', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(51, '', 'Copyright © since 2012 <a href="http://www.shincheonji.kr/">Shincheonji</a>.', '2016-12-12 07:13:48', 3, '2016-12-12 07:13:48', 3, '2016-12-12 14:13:48'),
	(52, '', 'Manage Translation', '2016-12-12 07:15:48', 3, '2016-12-12 07:15:48', 3, '2016-12-12 14:15:48'),
	(53, '', 'Translation', '2016-12-12 07:15:48', 3, '2016-12-12 07:15:48', 3, '2016-12-12 14:15:48'),
	(54, '', 'Search translation', '2016-12-12 07:15:48', 3, '2016-12-12 07:15:48', 3, '2016-12-12 14:15:48'),
	(55, '', 'New Translation', '2016-12-12 07:15:48', 3, '2016-12-12 07:15:48', 3, '2016-12-12 14:15:48'),
	(56, '', 'Static Word', '2016-12-12 07:15:48', 3, '2016-12-12 07:15:48', 3, '2016-12-12 14:15:48'),
	(57, '', 'Controls', '2016-12-12 07:16:36', 3, '2016-12-12 07:16:36', 3, '2016-12-12 14:16:36'),
	(58, '', 'Create', '2016-12-12 08:48:15', 3, '2016-12-12 08:48:15', 3, '2016-12-12 15:48:15'),
	(59, '', 'Update', '2016-12-12 08:48:15', 3, '2016-12-12 08:48:15', 3, '2016-12-12 15:48:15'),
	(60, '', 'View', '2016-12-12 08:48:15', 3, '2016-12-12 08:48:15', 3, '2016-12-12 15:48:15'),
	(61, '', 'Delete', '2016-12-12 08:48:15', 3, '2016-12-12 08:48:15', 3, '2016-12-12 15:48:15'),
	(62, '', 'Online', '2016-12-12 11:24:51', 3, '2016-12-12 11:24:51', 3, '2016-12-12 18:24:51'),
	(63, '', 'Search...', '2016-12-12 11:25:55', 3, '2016-12-12 11:25:55', 3, '2016-12-12 18:25:55'),
	(64, '', 'Up a level', '2016-12-12 11:27:15', 3, '2016-12-12 11:27:15', 3, '2016-12-12 18:27:15'),
	(65, '', 'Sub-groups', '2016-12-12 11:27:15', 3, '2016-12-12 11:27:15', 3, '2016-12-12 18:27:15'),
	(66, '', 'MAIN NAVIGATION', '2016-12-12 11:39:02', 3, '2016-12-12 11:39:02', 3, '2016-12-12 18:39:02'),
	(67, '', 'GROUPS', '2016-12-12 11:39:07', 3, '2016-12-12 11:39:07', 3, '2016-12-12 18:39:07'),
	(68, '', 'Manage', '2016-12-12 11:39:27', 3, '2016-12-12 11:39:27', 3, '2016-12-12 18:39:27'),
	(69, '', 'Add User', '2016-12-12 11:45:47', 3, '2016-12-12 11:45:47', 3, '2016-12-12 18:45:47'),
	(70, '', 'Remove User', '2016-12-12 11:45:47', 3, '2016-12-12 11:45:47', 3, '2016-12-12 18:45:47'),
	(71, '', 'Language', '2016-12-12 11:47:55', 3, '2016-12-12 11:47:55', 3, '2016-12-12 18:47:55'),
	(72, '', 'Content', '2016-12-12 11:47:55', 3, '2016-12-12 11:47:55', 3, '2016-12-12 18:47:55'),
	(73, '', 'New group here, enter to submit', '2016-12-12 11:49:47', 3, '2016-12-12 11:49:47', 3, '2016-12-12 18:49:47'),
	(74, '', 'Save', '2016-12-12 11:57:22', 3, '2016-12-12 11:57:22', 3, '2016-12-12 18:57:22'),
	(75, '', 'posts', '2016-12-12 17:35:41', 3, '2016-12-12 17:35:41', 3, '2016-12-13 00:35:41'),
	(76, '', 'last submit', '2016-12-12 17:35:41', 3, '2016-12-12 17:35:41', 3, '2016-12-13 00:35:41'),
	(77, '', 'Click to create a new form', '2016-12-12 17:35:41', 3, '2016-12-12 17:35:41', 3, '2016-12-13 00:35:41'),
	(78, '', 'Create Form', '2016-12-12 17:35:41', 3, '2016-12-12 17:35:41', 3, '2016-12-13 00:35:41'),
	(79, '', 'Click to create a new folder', '2016-12-12 17:35:41', 3, '2016-12-12 17:35:41', 3, '2016-12-13 00:35:41'),
	(80, '', 'Create Folder', '2016-12-12 17:35:41', 3, '2016-12-12 17:35:41', 3, '2016-12-13 00:35:41');
/*!40000 ALTER TABLE `static_contents` ENABLE KEYS */;

-- Dumping structure for table xtduat_core.system_settings
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

-- Dumping data for table xtduat_core.system_settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;


-- Dumping database structure for xtduat_datapool
CREATE DATABASE IF NOT EXISTS `xtduat_datapool` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtduat_datapool`;

-- Dumping structure for table xtduat_datapool.form_datas
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_datapool.form_datas: ~2 rows (approximately)
/*!40000 ALTER TABLE `form_datas` DISABLE KEYS */;
REPLACE INTO `form_datas` (`id`, `form_id`, `version`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(5, 1, 1, 'ACTIVE', '2016-12-06 10:14:56', 3, '2016-12-06 10:14:56', 3, '2016-12-06 17:14:56');
/*!40000 ALTER TABLE `form_datas` ENABLE KEYS */;

-- Dumping structure for table xtduat_datapool.form_data_values
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_datapool.form_data_values: ~3 rows (approximately)
/*!40000 ALTER TABLE `form_data_values` DISABLE KEYS */;
REPLACE INTO `form_data_values` (`id`, `form_id`, `form_item_id`, `form_data_id`, `item_version`, `data_version`, `text_value`, `number_value`, `file_value`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(7, 1, 1, 5, 43, 1, 'abc', 0, '', 'ACTIVE', '2016-12-06 10:14:56', 3, '2016-12-06 10:14:56', 3, '2016-12-06 17:14:56'),
	(8, 1, 2, 5, 43, 1, 'qwer', 0, '', 'ACTIVE', '2016-12-06 10:14:56', 3, '2016-12-06 10:14:56', 3, '2016-12-06 17:14:56'),
	(9, 1, 3, 5, 43, 1, 'zxcv', 0, '', 'ACTIVE', '2016-12-06 10:14:56', 3, '2016-12-06 10:14:56', 3, '2016-12-06 17:14:56');
/*!40000 ALTER TABLE `form_data_values` ENABLE KEYS */;


-- Dumping database structure for xtduat_form_definition
CREATE DATABASE IF NOT EXISTS `xtduat_form_definition` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtduat_form_definition`;

-- Dumping structure for table xtduat_form_definition.folders
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_form_definition.folders: ~2 rows (approximately)
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
REPLACE INTO `folders` (`id`, `parent_id`, `name`, `color`, `icon`, `is_featured`, `sequence`, `tags`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(6, 0, 'Root', '', 'folder', 0, 1, NULL, 'ACTIVE', '2016-11-07 15:07:56', 3, '2016-11-07 15:08:01', 3, '2016-12-05 14:56:46'),
	(7, 6, 'Announcement', '', 'folder', 0, 1, NULL, 'ACTIVE', '2016-12-05 14:56:20', 3, '2016-12-05 14:56:20', 3, '2016-12-05 14:56:32');
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;

-- Dumping structure for table xtduat_form_definition.forms
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder_id` int(10) unsigned DEFAULT '0',
  `code` varchar(50) DEFAULT '0',
  `related_member_id` int(10) unsigned DEFAULT '0',
  `name` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `version` int(10) unsigned DEFAULT '1',
  `is_featured` tinyint(1) unsigned DEFAULT '0',
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modified_by` int(10) unsigned NOT NULL,
  `concurrent_id` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_form_folder` (`folder_id`),
  KEY `FK_form_code` (`code`),
  CONSTRAINT `FK_form_folder` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_form_definition.forms: ~1 rows (approximately)
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
REPLACE INTO `forms` (`id`, `folder_id`, `code`, `related_member_id`, `name`, `description`, `version`, `is_featured`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 6, '0', 0, '21項', '21項', 43, 0, 'ACTIVE', '2016-11-07 15:09:11', 3, '2016-11-09 18:02:47', 3, '2016-11-10 01:02:47');
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;

-- Dumping structure for table xtduat_form_definition.form_items
CREATE TABLE IF NOT EXISTS `form_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `code` varchar(50) NOT NULL,
  `display` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` varchar(20) NOT NULL,
  `value_type` varchar(50) NOT NULL,
  `value_score` int(11) NOT NULL DEFAULT '0',
  `is_searchable` tinyint(1) DEFAULT b'0',
  `is_show_in_list` tinyint(1) DEFAULT b'1',
  `is_show_in_mobile_list` tinyint(1) DEFAULT b'1',
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
  KEY `FK_form_item_code` (`code`),
  CONSTRAINT `FK_form_item_form` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_form_definition.form_items: ~3 rows (approximately)
/*!40000 ALTER TABLE `form_items` DISABLE KEYS */;
REPLACE INTO `form_items` (`id`, `form_id`, `code`, `display`, `description`, `type`, `value_type`, `value_score`, `is_searchable`, `is_show_in_list`, `is_show_in_mobile_list`, `sort_sequence`, `sequence`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(1, 1, '', '涉外时间', '涉外时间', 'Singleline', 'string', 0, b'1', b'1', b'1', 1, 0, 'ACTIVE', '2016-11-07 16:18:41', 0, '2016-11-09 18:02:47', 3, '2016-11-10 01:02:47'),
	(2, 1, '', '引导人QY/JS', '引导人QY/JS', 'Singleline', 'string', 0, b'1', b'1', b'1', 2, 1, 'ACTIVE', '2016-11-07 12:59:14', 3, '2016-11-09 18:02:47', 3, '2016-11-10 01:02:47'),
	(3, 1, '', '引导人姓名', '引导人姓名', 'Singleline', 'string', 0, b'1', b'1', b'1', 0, 2, 'ACTIVE', '2016-11-07 12:59:14', 3, '2016-11-09 18:02:47', 3, '2016-11-10 01:02:47');
/*!40000 ALTER TABLE `form_items` ENABLE KEYS */;

-- Dumping structure for table xtduat_form_definition.form_list_items
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

-- Dumping data for table xtduat_form_definition.form_list_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_list_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_list_items` ENABLE KEYS */;

-- Dumping structure for table xtduat_form_definition.item_properties
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

-- Dumping data for table xtduat_form_definition.item_properties: ~96 rows (approximately)
/*!40000 ALTER TABLE `item_properties` DISABLE KEYS */;
REPLACE INTO `item_properties` (`id`, `target_id`, `target_type`, `group`, `name`, `type`, `rule`, `value`, `sequence`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
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


-- Dumping database structure for xtduat_membership
CREATE DATABASE IF NOT EXISTS `xtduat_membership` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `xtduat_membership`;

-- Dumping structure for table xtduat_membership.groups
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_membership.groups: ~7 rows (approximately)
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
REPLACE INTO `groups` (`id`, `parent_id`, `name`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(8, 0, '__admin', 'ACTIVE', '2016-11-02 10:02:34', 3, '2016-11-02 10:13:55', 3, '2016-12-09 09:45:26'),
	(9, 8, 'Busan James', 'ACTIVE', '2016-12-09 18:36:01', 3, '2016-12-09 18:36:01', 3, '2016-12-10 01:36:01'),
	(10, 9, 'Shanghai', 'ACTIVE', '2016-12-09 18:39:40', 3, '2016-12-09 18:39:40', 3, '2016-12-10 01:39:40'),
	(11, 9, 'Beijing', 'ACTIVE', '2016-12-09 18:39:47', 3, '2016-12-09 18:39:47', 3, '2016-12-10 01:39:47'),
	(12, 10, 'Hong Kong', 'ACTIVE', '2016-12-09 18:42:18', 3, '2016-12-09 18:42:18', 3, '2016-12-10 01:42:18'),
	(13, 9, 'Qingdao', 'ACTIVE', '2016-12-09 18:52:24', 3, '2016-12-09 18:52:24', 3, '2016-12-10 01:52:24'),
	(14, 9, 'Tianjin', 'ACTIVE', '2016-12-09 18:53:45', 3, '2016-12-09 18:53:45', 3, '2016-12-10 01:53:45');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

-- Dumping structure for table xtduat_membership.group_members
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

-- Dumping data for table xtduat_membership.group_members: ~0 rows (approximately)
/*!40000 ALTER TABLE `group_members` DISABLE KEYS */;
REPLACE INTO `group_members` (`id`, `group_id`, `member_id`, `status`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(2, 8, 3, 'ACTIVE', '2016-11-08 13:58:32', 3, '2016-11-08 13:58:35', 3, '2016-11-08 13:58:36');
/*!40000 ALTER TABLE `group_members` ENABLE KEYS */;

-- Dumping structure for table xtduat_membership.members
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table xtduat_membership.members: ~3 rows (approximately)
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
REPLACE INTO `members` (`id`, `username`, `password`, `code`, `display_name`, `photo`, `email`, `phone`, `status`, `login_ip`, `login_time`, `token`, `created_date`, `created_by`, `last_modified_date`, `last_modified_by`, `concurrent_id`) VALUES
	(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'a2f8e04814b8', 'Administrator', '', 'jacky.yiu@mouxidea.com.hk', '852) 62882776', 'ACTIVE', '::1', '2016-12-09 17:48:01', '4bc861f4377fcddd29f74b99daa0b0b9', '2016-11-01 12:31:36', 0, '2016-12-09 17:48:01', 3, '2016-12-10 00:48:01'),
	(4, 'jacky', '9661fd65249b026ebea0f49927e82f0e', '', 'Jacky', '', '', '', 'ACTIVE', NULL, NULL, NULL, '2016-12-12 06:01:09', 3, '2016-12-12 06:01:09', 3, '2016-12-12 13:01:09'),
	(5, 'ivy', 'a735c3e8bc21cbe0f03e501a1529e0b4', '', 'Ivy Zhang', '', '', '', 'ACTIVE', NULL, NULL, NULL, '2016-12-12 06:03:29', 3, '2016-12-12 06:03:29', 3, '2016-12-12 13:03:29');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
