DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('config','update','setting','firmware') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `configs` (`id`, `name`, `description`, `type`) VALUES (1, 'config_default', 'Default config', 'config');
INSERT INTO `configs` (`id`, `name`, `description`, `type`) VALUES (2, 'setting_default', 'Default setting', 'setting');
INSERT INTO `configs` (`id`, `name`, `description`, `type`) VALUES (3, 'update_default', 'Default player update', 'update');
INSERT INTO `configs` (`id`, `name`, `description`, `type`) VALUES (4, 'HD100_default', 'Default HD100 firmware', 'firmware');
INSERT INTO `configs` (`id`, `name`, `description`, `type`) VALUES (5, 'UHD200_default', 'Default UHD200 firmware', 'firmware');