CREATE TABLE IF NOT EXISTS `requests_monitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `mac` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `fw` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `response` varchar(255) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
