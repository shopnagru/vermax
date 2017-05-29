RENAME TABLE `configs` TO `configs_old`;
RENAME TABLE `requests` TO `requests_monitor`;
ALTER TABLE `requests_monitor` ENGINE = MYISAM;
ALTER TABLE `requests_monitor` CHANGE `fw` `fw` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `requests_monitor` CHANGE `version` `version` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `requests_monitor` CHANGE `response` `response` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
RENAME TABLE `managers` TO `managers_old`;
