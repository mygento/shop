<?php
$this->startSetup();

$this->run("
CREATE TABLE {$this->getTable('cronprofiles_profile_log')} (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `profile_id` int(10) unsigned NOT NULL default '0',
  `action_code` varchar(64) default NULL,
  `logged_data` varchar(255) NOT NULL default '',
  `logged_at` datetime default NULL,
  PRIMARY KEY  (`log_id`),
  KEY `FK_dataflow_profile_log` (`profile_id`),
  CONSTRAINT `FK_dataflow_profile_log` FOREIGN KEY (`profile_id`) REFERENCES {$this->getTable('dataflow_profile')} (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$this->endSetup();
