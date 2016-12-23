RENAME TABLE `configs` TO `configs_old`;
RENAME TABLE `requests` TO `requests_monitor`;
ALTER TABLE `requests_monitor` ENGINE = MYISAM;
RENAME TABLE `managers` TO `managers_old`;