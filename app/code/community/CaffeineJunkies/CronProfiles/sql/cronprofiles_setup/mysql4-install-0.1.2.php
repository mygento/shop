<?php
$this->startSetup();

$this->run("
ALTER TABLE {$this->getTable('dataflow_profile')} ADD run_as_user_id BIGINT;
ALTER TABLE {$this->getTable('dataflow_profile')} ADD cron_expr VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE {$this->getTable('dataflow_profile')} ADD enable_cron BOOL NOT NULL DEFAULT false;
");

$this->endSetup();
