<?php
$this->startSetup();

$this->run("
ALTER TABLE {$this->getTable('cronprofiles_profile_log')} ADD `log_type` VARCHAR( 255 ) NOT NULL AFTER `action_code`;
");

$this->endSetup();
