#!/usr/bin/php
<?php

require_once __DIR__ . '/../bootstrap.php';

use Dashboard\Controller\Controller_SpeedLog;

$log_controller = new Controller_SpeedLog( $entity_manager );
$log_controller->run_speed_test();