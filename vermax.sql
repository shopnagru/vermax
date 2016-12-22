-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 30 2015 г., 14:08
-- Версия сервера: 5.5.41-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.7
CREATE DATABASE vermax;
USE vermax;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `vermax`
--

-- --------------------------------------------------------

--
-- Структура таблицы `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `conf` text NOT NULL,
  `descript` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_2` (`name`),
  UNIQUE KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Дамп данных таблицы `configs`
--

INSERT INTO `configs` (`id`, `name`, `conf`, `descript`) VALUES
(1, 'default', 'playlist=http://update.vermax.com/list.m3u\nicons=http://update.vermax.com/160/\nplaylist_update_interval=60\n\n#Минимальный интервал времени [в часах], через который будет производиться проверка обновлений. По умолчанию 1.\n#Проверка при каждом запуске 0, для отключения убрать update_url\nupdates_check_interval=0\n#Ссылка на файл с информаций об обновлениях, может быть как полной ссылкой [вида http://example.com/update.properties], так и относительной.\nupdate_url=update.properties\n\n#Пин-код родительского контроля [только цифры, не более 11 символов, по умолчанию 40885]\nchild_lock_pin_code=777777\n\n', ''),
(53, 'test', 'playlist=http://update.vermax.com/li.m3u\nicons=http://update.vermax.com/160/\nplaylist_update_interval=60\nupdates_check_interval=0\nupdate_url=update.properties?mac=test\nchild_lock_pin_code=777777', '');

-- --------------------------------------------------------

--
-- Структура таблицы `confToIp`
--

CREATE TABLE IF NOT EXISTS `confToIp` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `conf` varchar(100) NOT NULL DEFAULT 'default',
  `update` varchar(100) NOT NULL DEFAULT 'default',
  `settings` varchar(100) NOT NULL DEFAULT 'default',
  `fwupdate` varchar(100) NOT NULL DEFAULT 'default',
  `mac` varchar(300) NOT NULL,
  `descript` varchar(1000) NOT NULL,
  `prov` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `conf` (`conf`),
  KEY `conf_2` (`conf`),
  KEY `update` (`update`),
  KEY `settings` (`settings`),
  KEY `ip_2` (`ip`),
  KEY `conf_3` (`conf`),
  KEY `update_2` (`update`),
  KEY `settings_2` (`settings`),
  KEY `conf_4` (`conf`),
  KEY `fwupdate` (`fwupdate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Дамп данных таблицы `confToIp`
--

INSERT INTO `confToIp` (`id`, `ip`, `conf`, `update`, `settings`, `fwupdate`, `mac`, `descript`, `prov`) VALUES
(8, '94.230.129.26/32', 'default', 'Test', 'default', 'default', '', '', 'nag'),
(34, '172.16.16.0/24', 'default', 'default', 'default', 'default', '', '', 'nag'),
(35, '172.16.16.0/24', 'test', 'Test', 'test_stb', 'default', 'test', '', 'nag');

-- --------------------------------------------------------

--
-- Структура таблицы `fwupdates`
--

CREATE TABLE IF NOT EXISTS `fwupdates` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `fwup` text NOT NULL,
  `descript` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `id_2` (`id`),
  KEY `name_2` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `fwupdates`
--

INSERT INTO `fwupdates` (`id`, `name`, `fwup`, `descript`) VALUES
(1, 'default', '<update>\n<md5>04b5238e7846d4c851a63428d2c09aad</md5>\n<url>http://update.vermax.com/Vermax HD100/updatel.zip</url>\n<size>196863349</size>\n<release_notes>Tiny firmware v1.3.1l (2015.04.08)</release_notes>\n<backup_notice>Не отключайте питания во время обновления! Это может привести к повреждению устройства.</backup_notice>\n<status_note>-</status_note>\n<buildver>20150408</buildver>\n</update>', ''),
(2, 'tet', '<update>\r\n<md5>11002e62c0e45df4d6d874aa01b36f18</md5>\r\n<url>http://update.vermax.com/Vermax HD100/updatelast.zip</url>\r\n<size>197981315</size>\r\n<release_notes>Tiny firmware v1.3.1i (2015.03.19)</release_notes>\r\n<backup_notice>Do not power off during update</backup_notice>\r\n<status_note>-</status_note>\r\n<buildver>20150319</buildver>\r\n</update>', '');

-- --------------------------------------------------------

--
-- Структура таблицы `managers`
--

CREATE TABLE IF NOT EXISTS `managers` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `group` varchar(100) NOT NULL DEFAULT 'default',
  `provider` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `logo` varchar(300) NOT NULL,
  `link` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `providers`
--

INSERT INTO `providers` (`id`, `name`, `logo`, `link`) VALUES
(1, 'nag', '', 'http://nag.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `mac` varchar(300) NOT NULL,
  `version` varchar(100) NOT NULL,
  `type` text NOT NULL,
  `response` varchar(150) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `ip`, `mac`, `version`, `type`, `response`, `time`) VALUES
(9, '172.16.16.117', '', '', 'Запрос конфигурации', 'test', '2015-03-27 06:26:25'),
(10, '172.16.16.117', '', '', 'Запрос конфигурации', 'test', '2015-03-27 12:11:11'),
(11, '172.16.16.117', '', '', 'Запрос конфигурации', 'test', '2015-03-27 12:12:48'),
(12, '172.16.16.117', '', '', 'Запрос конфигурации', 'test', '2015-03-27 12:14:08'),
(13, '172.16.16.117', '', '', '', '', '2015-03-30 08:11:30'),
(14, '172.16.16.117', '', '', '', '', '2015-03-30 08:16:47'),
(15, '172.16.16.117', '', '', '', '', '2015-03-30 08:19:14'),
(16, '172.16.16.117', '', '', '', '', '2015-03-30 08:24:48'),
(17, '172.16.16.117', '', '', '', '', '2015-03-30 08:33:21'),
(18, '172.16.16.117', '', '', '', '', '2015-03-30 08:33:21'),
(19, '172.16.16.117', '', '', 'Запрос настроек', 'test_stb', '2015-03-30 08:44:33'),
(20, '172.16.16.117', '', '', 'Запрос настроек', 'test_stb', '2015-03-30 08:44:37'),
(21, '172.16.16.117', '', '', 'Запрос настроек', 'test_stb', '2015-03-30 09:01:08'),
(22, '172.16.16.117', '', '', 'Запрос настроек', 'test_stb', '2015-03-30 09:01:09'),
(23, '172.16.16.117', '', '', 'Запрос настроек', 'test_stb', '2015-03-30 09:01:10'),
(24, '172.16.16.117', '', '', 'Запрос конфигурации', 'default', '2015-03-30 09:01:28'),
(25, '172.16.16.117', '', '', 'Запрос настроек', 'default', '2015-03-30 09:01:32'),
(26, '172.16.16.117', '', '', 'Запрос настроек', 'default', '2015-03-30 09:07:06'),
(27, '172.16.16.117', '', '', 'Запрос конфигурации', 'default', '2015-03-30 09:07:09');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `sett` text NOT NULL,
  `descript` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `name_2` (`name`),
  KEY `name_3` (`name`),
  KEY `name_4` (`name`),
  KEY `name_5` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `name`, `sett`, `descript`) VALUES
(1, 'default', '<adb>true</adb>\n<tz>Europe/Moscow</tz>\n<ntp>ru.pool.ntp.org</ntp>', ''),
(2, 'test_stb', '<adb>true</adb>\n<tz>Asia/Yekaterinburg</tz>\n<ntp>ru.pool.ntp.org</ntp>', '');

-- --------------------------------------------------------

--
-- Структура таблицы `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `upd` text NOT NULL,
  `descript` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_2` (`name`),
  KEY `name` (`name`),
  KEY `name_3` (`name`),
  KEY `name_4` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `updates`
--

INSERT INTO `updates` (`id`, `name`, `upd`, `descript`) VALUES
(1, 'default', '#Номер новой версии, соответствующий android:versionCode из AndroidManifest.xml.\n#Обновление будет происходить в случае, если номер версии, установленной у пользователя отличается от указанного здесь номера.\n#Подробнее: http://developer.android.com/tools/publishing/versioning.html#appversioning\nversion_code=14\n\n#Ссылка на новую версию, в которой android:versionCode соответствует version_code, указанному выше.\n#Может быть как полной ссылкой [вида http://example.com/iptvplayer.apk], так и относительной.\napk_url=com.vermax.iptvplayer.0.1.4.10.apk', ''),
(4, 'Test', 'version_code=14\napk_url=com.vermax.iptvplayer.0.1.4.10.apk', '');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `confToIp`
--
ALTER TABLE `confToIp`
  ADD CONSTRAINT `confToIp_ibfk_4` FOREIGN KEY (`fwupdate`) REFERENCES `fwupdates` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `confToIp_ibfk_1` FOREIGN KEY (`conf`) REFERENCES `configs` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `confToIp_ibfk_2` FOREIGN KEY (`settings`) REFERENCES `settings` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `confToIp_ibfk_3` FOREIGN KEY (`update`) REFERENCES `updates` (`name`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
