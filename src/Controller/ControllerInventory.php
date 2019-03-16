<?php

use Dashboard\View\ViewInventory;
use Dashboard\Model\ModelInventory;
use Dashboard\Toolbox\JsonValidator;

$klein->respond( 'GET', '/inventory', function( $request ) {
	$inventory_controller = new ModelInventory();
	$items = $inventory_controller->get_items();
	$rooms = $inventory_controller->get_inventory_rooms();
	$units = $inventory_controller->get_inventory_units();
	$view = new ViewInventory( $items, $rooms, $units );
	return $view->generate_html_for_page();
});

$klein->respond( 'GET', '/api/inventory/items/[i:id]', function( $request, $response ) {
	$inventory_controller = new ModelInventory();
	$item = $inventory_controller->get_item( $request->id );

	if ( null === $item ) {
		$response->code( 410 );
		return json_encode( 
			array(
				'Inventory item was not found.'
			)
		);
	}

	return json_encode(
		array(
			'item_id' => $item->get_id(),
			'name' => $item->get_name(),
			'amount' => $item->get_amount(),
			'low_stock_amount' => $item->get_low_stock_amount(),
			'description' => $item->get_description(),
			'room_id' => $item->get_room()->get_id(),
			'unit_id' => $item->get_unit()->get_id()
		)
	);
});

$klein->respond( 'POST', '/api/inventory/items', function( $request, $response ) {
	$parameters = array(
		array(
			'key' => 'name',
			'type' => 'text',
			'length' => 255,
			'allow_blank' => false
		),
		array(
			'key' => 'amount',
			'type' => 'number',
			'default' => 0
		),
		array(
			'key' => 'low_stock_amount',
			'type' => 'number',
			'default' => 0
		),
		array(
			'key' => 'description',
			'type' => 'text',
			'default' => '',
			'length' => 500,
			'allow_blank' => true
		),
		array(
			'key' => 'room_id',
			'type' => 'number'
		),
		array(
			'key' => 'unit_id',
			'type' => 'number'
		)
	);
	$validator = new JsonValidator( $parameters );

	$new_item = [];
	$errors = $validator->validate_json( $request->body(), $new_item );

	if ( !empty( $errors ) ) {
		$response->code( 400 );
		return json_encode( $errors );
	}

	$inventory_controller = new ModelInventory();
	$valid_rooms = $inventory_controller->get_inventory_rooms();
	$valid_units = $inventory_controller->get_inventory_units();

	if ( !array_key_exists( $new_item['room_id'], $valid_rooms ) ) {
		$response->code( 400 );
		return json_encode( 
			array(
				'Invalid room option chosen.'
			)
		);
	}

	if ( !array_key_exists( $new_item['unit_id'], $valid_units ) ) {
		$response->code( 400 );
		return json_encode(
			array(
				'Invalid unit option chosen.'
			)
		);
	}

	$item = $inventory_controller->add_item( $new_item['name'], $new_item['amount'], $new_item['low_stock_amount'], $new_item['description'], $new_item['room_id'], $new_item['unit_id'] );

	$response->code( 201 );
	return json_encode(
		array(
			'item_id' => $item->get_id(),
			'name' => $item->get_name(),
			'amount' => $item->get_amount(),
			'low_stock_amount' => $item->get_low_stock_amount(),
			'description' => $item->get_description(),
			'room_id' => $item->get_room()->get_id(),
			'unit_id' => $item->get_unit()->get_id()
		)
	);
});

$klein->respond( 'PUT', '/api/inventory/items/[i:id]', function( $request ) {
	$params = json_decode( $request->body(), true );
	$inventory_controller = new ModelInventory();
	$inventory_controller->edit_item( $request->id, $params['name'], $params['amount'], $params['low_stock_amount'], $params['description'], $params['room_id'], $params['unit_id'] );
	return $request->body();
});

$klein->respond( 'DELETE', '/api/inventory/items/[i:id]', function( $request, $response ) {
	$inventory_controller = new ModelInventory();
	$item = $inventory_controller->get_item( $request->id );

	if ( null === $item ) {
		$response->code( 404 );
		return json_encode(
			array(
				'Inventory item was not found.'
			)
		);
	}

	$inventory_controller->delete_item( $request->id );

	$response->code( 204 );
});

$klein->respond( 'GET', '/api/inventory/rooms', function() {
	$inventory_controller = new ModelInventory();
	$rooms = $inventory_controller->get_inventory_rooms();

	$response_data = array();
	foreach ( $rooms as $room ) {
		$response_data[] = array(
			'room_id' => $room->get_id(),
			'name' => $room->get_name()
		);
	}

	return json_encode( $response_data );
});

$klein->respond( 'GET', '/api/inventory/units', function() {
	$inventory_controller = new ModelInventory();
	$units = $inventory_controller->get_inventory_units();

	$response_data = array();
	foreach ( $units as $unit ) {
		$response_data[] = array(
			'unit_id' => $unit->get_id(),
			'abbreviation' => $unit->get_abbreviation()
		);
	}

	return json_encode( $response_data );
});