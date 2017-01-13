-- ----------------------------
-- Table structure for stat
-- ----------------------------
DROP TABLE IF EXISTS `stat`;
CREATE TABLE `stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `textplain` text,
  `stat_id` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `what` varchar(255) DEFAULT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `switch_count` varchar(255) DEFAULT NULL,
  `type` varchar(150) DEFAULT NULL,
  `mac` varchar(100) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `send_date` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12321 DEFAULT CHARSET=utf8;