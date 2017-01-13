DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
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
  KEY `update` (`update`),
  CONSTRAINT `clients_ibfk_4` FOREIGN KEY (`firmware`) REFERENCES `configs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`conf`) REFERENCES `configs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`setting`) REFERENCES `configs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `clients_ibfk_3` FOREIGN KEY (`update`) REFERENCES `configs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
