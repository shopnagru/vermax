CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `mac` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `conf` int(11) DEFAULT NULL,
  `setting` int(11) DEFAULT NULL,
  `update` int(11) DEFAULT NULL,
  `firmware` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `conf` (`conf`),
  KEY `setting` (`setting`),
  KEY `firmware` (`firmware`),
  KEY `update` (`update`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
