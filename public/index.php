<?php

require_once __DIR__ . '/../bootstrap.php';

use Dashboard\Controller\Controller_SpeedLog;
use Dashboard\Controller\Controller_Inventory;

$klein = new \Klein\Klein();

$klein->respond( 'GET', '/', function() {
	$page_title = 'Home';
	include_once 'views/header.php';
	include_once 'views/home.php';
	include_once 'views/footer.php';
});

$klein->respond( 'GET', '/inventory', function() use ( $entity_manager) {
	$inventory_controller = new Controller_Inventory( $entity_manager );
	$items = $inventory_controller->get_items();
	$page_title = 'Inventory';
	include_once 'views/header.php';
	include_once 'views/inventory.php';
	include_once 'views/footer.php';
});

$klein->respond( 'GET', '/weather', function() use ( $entity_manager ) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, 'https://api.darksky.net/forecast/16a96e807ef652b5dabb73a17abbdf8b/44.9422,-92.9494' );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$forcast_data = json_decode( curl_exec( $ch ), true );
	curl_close( $ch );
	$page_title = 'Weather';
	include_once 'views/header.php';
	include_once 'views/weather.php';
	include_once 'views/footer.php';
});

$klein->respond( 'GET', '/speedlogs', function() use ( $entity_manager ) {
	$log_controller = new Controller_SpeedLog( $entity_manager );
	$logs = $log_controller->get_speed_logs();
	$hosts = $log_controller->get_speedtest_hosts();
	$page_title = 'Speed Logs';
	include_once 'views/header.php';
	include_once 'views/speedlogs.php';
	include_once 'views/footer.php';
});

$klein->respond( 'POST', '/api/speedlogs', function( $request ) use ( $entity_manager ) {
	$params = json_decode( $request->body(), true );
	$server_id = $params['server_id'] != 0 ? $params['server_id'] : false;
	$log_controller = new Controller_SpeedLog( $entity_manager );
	$log_controller->run_speed_test( $server_id );
});

$klein->dispatch();