<?php

require_once __DIR__ . '/../bootstrap.php';

use Klein\Klein;
use Klein\Response;

session_start();

$klein = new Klein();

$controllers = array(
	'ControllerAuthentication',
	'ControllerHome',
	'ControllerWeather',
	'ControllerInventory',
	'ControllerSpeedLogs',
	'ControllerConfiguration'
);

foreach( $controllers as $controller ) {
	include( __DIR__ . '/../src/Controller/' . $controller . '.php' );
}

$klein->dispatch();