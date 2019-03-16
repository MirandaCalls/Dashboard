<?php

require_once __DIR__ . '/../bootstrap.php';

use Dashboard\Model\ModelSpeedLog;
use Dashboard\Model\ModelInventory;
use Dashboard\Model\ModelConfig;

use Dashboard\Controller\ControllerAuthentication;
use Dashboard\Controller\ControllerInventory;
use Dashboard\Controller\ControllerConfiguration;

use Dashboard\View\ViewLogin;
use Dashboard\View\ViewHome;
use Dashboard\View\ViewInventory;
use Dashboard\View\ViewWeather;
use Dashboard\View\ViewSpeedLogs;
use Dashboard\View\ViewConfiguration;

use Klein\Klein;
use Klein\Response;

session_start();

$klein = new Klein();

$klein->respond( 'POST', '/login', function( $request, $response ) {
	ControllerAuthentication::login_user( $request );
	$response->redirect( '/' )->send();
});

$klein->respond(function( $request, $response ) {
	if ( !array_key_exists( 'authenticated', $_SESSION ) ) {
		$view = new ViewLogin();
		$response->append( $view->generate_html_for_page() );
		$response->send();
	}
});

$klein->respond( 'POST', '/logout', function( $request, $response ) {
	ControllerAuthentication::logout_user();
	$response->redirect( '/' );
});

$klein->respond( 'GET', '/', function( $request ) {
	$view = new ViewHome();
	return $view->generate_html_for_page();
});

$klein->respond( 'GET', '/inventory', function( $request ) {
	$inventory_controller = new ModelInventory();
	$items = $inventory_controller->get_items();
	$rooms = $inventory_controller->get_inventory_rooms();
	$units = $inventory_controller->get_inventory_units();
	$view = new ViewInventory( $items, $rooms, $units );
	return $view->generate_html_for_page();
});

$klein->respond( 'GET', '/weather', function( $request ) {
	$forcast_data = json_decode( file_get_contents( __DIR__ . '/../darksky.json' ), true );
	$view = new ViewWeather( $forcast_data );
	return $view->generate_html_for_page();
});

$klein->respond( 'GET', '/speedlogs', function( $request ) {
	$log_controller = new ModelSpeedLog();
	$logs = $log_controller->get_speed_logs();
	$hosts = $log_controller->get_speedtest_hosts();
	$view = new ViewSpeedLogs( $logs, $hosts );
	return $view->generate_html_for_page();
});

$klein->respond( 'GET', '/configuration', function( $request ) {
	$model = new ModelConfig();
	$config_data = array();
	$config_data['notifications'] = $model->get_config_with_key( 'notifications' )->get_values();
	$view = new ViewConfiguration( $config_data );
	return $view->generate_html_for_page();
});

$klein->respond( 'GET', '/api/inventory/items/[i:id]', function( $request, $response ) {
	$controller = new ControllerInventory();
	$result = $controller->get_inventory_item( $request );

	if ( $result['code'] != 200 ) {
		$response->code( $result['code'] );
		return json_encode( $result['errors'] );
	}

	return json_encode( $result['content'] );
});

$klein->respond( 'POST', '/api/inventory/items', function( $request, $response ) {
	$controller = new ControllerInventory();
	$result = $controller->add_inventory_item( $request );

	if ( $result['code'] != 201 ) {
		$response->code( $result['code'] );
		return json_encode( $result['errors'] );
	}

	$response->code( $result['code'] );
	return json_encode( $result['content'] );
});

$klein->respond( 'PUT', '/api/inventory/items/[i:id]', function( $request ) {
	$params = json_decode( $request->body(), true );
	$inventory_controller = new ModelInventory();
	$inventory_controller->edit_item( $request->id, $params['name'], $params['amount'], $params['low_stock_amount'], $params['description'], $params['room_id'], $params['unit_id'] );
	return $request->body();
});

$klein->respond( 'DELETE', '/api/inventory/items/[i:id]', function( $request, $response ) {
	$controller = new ControllerInventory();
	$result = $controller->delete_inventory_item( $request );

	if ( $result['code'] != 200 ) {
		$response->code( $result['code'] );
		return json_encode( $result['errors'] );
	}

	$response->code( $result['code'] );
});

$klein->respond( 'GET', '/api/inventory/rooms', function() {
	$controller = new ControllerInventory();
	$result = $controller->get_inventory_rooms();
	return json_encode( $result['content'] );
});

$klein->respond( 'GET', '/api/inventory/units', function() {
	$controller = new ControllerInventory();
	$result = $controller->get_inventory_units();
	return json_encode( $result['content'] );
});

$klein->respond( 'POST', '/api/speedlogs', function( $request ) {
	$params = json_decode( $request->body(), true );
	$server_id = $params['server_id'] != 0 ? $params['server_id'] : false;
	$log_controller = new ModelSpeedLog();
	$log_controller->run_speed_test( $server_id );
});

$klein->respond( 'PUT', '/api/configuration', function( $request, $response ) {
	$controller = new ControllerConfiguration();
	$result = $controller->save_configuration( $request );

	if ( $result['code'] != 200 ) {
		$response->code( $result['code'] );
		return json_encode( $result['errors'] );
	}

	$response->code( $result['code'] );
});

// $controllers = array(
// 	'ControllerAuth',
// 	'ControllerConfig',
// 	'ControllerInventory',
// 	'ControllerSpeedLogs'
// );

// foreach( $controllers as $controller ) {
// 	include( __DIR__ . '../src/Controller' . $controller . '.php' );
// }

$klein->dispatch();