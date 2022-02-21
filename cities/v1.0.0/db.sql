CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `population` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `country_name` (`country_name`),
  KEY `population` (`population`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `core_modules` (`m_name`, `module_id`, `visible`, `lastuser`, `lastupdate`, `is_system`, `is_public`, `dependencies`, `seq`, `access_default`, `access_add`, `version`, `uninstall`, `files_hash`, `isset_home_page`) VALUES ('Cities', 'citites', 'Y', 1, '2022-02-18 00:00:00', 'Y', 'Y', null, null, 'YToxOntzOjY6ImFjY2VzcyI7czoyOiJvbiI7fQ==', null, '1.0.0', null, null, 'Y');
