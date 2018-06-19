<?php

require_once __DIR__ . '/../bootstrap.php';

use Dashboard\Model\ModelSpeedLog;
use Dashboard\Model\ModelInventory;

use Dashboard\Controller\ControllerInventory;

$klein = new \Klein\Klein();

$klein->respond( 'GET', '/', function() {
	$page_title = 'Home';
	include_once 'views/header.php';
	include_once 'views/home.php';
	include_once 'views/footer.php';
});

$klein->respond( 'GET', '/inventory', function() use ( $entity_manager) {
	$inventory_controller = new ModelInventory( $entity_manager );
	$items = $inventory_controller->get_items();
	$rooms = $inventory_controller->get_inventory_rooms();
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
	$log_controller = new ModelSpeedLog( $entity_manager );
	$logs = $log_controller->get_speed_logs();
	$hosts = $log_controller->get_speedtest_hosts();
	$page_title = 'Speed Logs';
	include_once 'views/header.php';
	include_once 'views/speedlogs.php';
	include_once 'views/footer.php';
});

$klein->respond( 'GET', '/api/inventory/items/[i:id]', function( $request, $response ) use ( $entity_manager ) {
	$controller = new ControllerInventory();
	$result = $controller->get_inventory_item( $entity_manager, $request );

	if ( $result['code'] != 200 ) {
		$response->code( $result['code'] );
		return json_encode( $result['errors'] );
	}

	return json_encode( $result['content'] );
});

$klein->respond( 'POST', '/api/inventory/items', function( $request, $response ) use ( $entity_manager ) {
	$controller = new ControllerInventory();
	$result = $controller->add_inventory_item( $entity_manager, $request );

	if ( $result['code'] != 201 ) {
		$response->code( $result['code'] );
		return json_encode( $result['errors'] );
	}

	$response->code( $result['code'] );
});

$klein->respond( 'PUT', '/api/inventory/items/[i:id]', function( $request ) use ( $entity_manager ) {
	$params = json_decode( $request->body(), true );
	$inventory_controller = new ModelInventory( $entity_manager );
	$inventory_controller->edit_item( $request->id, $params['name'], $params['amount'], $params['low_stock_amount'], $params['description'], $params['room_id'] );
});

$klein->respond( 'POST', '/api/speedlogs', function( $request ) use ( $entity_manager ) {
	$params = json_decode( $request->body(), true );
	$server_id = $params['server_id'] != 0 ? $params['server_id'] : false;
	$log_controller = new ModelSpeedLog( $entity_manager );
	$log_controller->run_speed_test( $server_id );
});

$klein->dispatch();
