#!/usr/bin/php
<?php

require_once __DIR__ . '/../bootstrap.php';

use Dashboard\Model\ModelSpeedLog;

$log_model = new ModelSpeedLog( $entity_manager );
$log_model->run_speed_test();
