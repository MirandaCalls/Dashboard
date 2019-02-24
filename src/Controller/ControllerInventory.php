<?php

namespace Dashboard\Controller;

use \Dashboard\Model\ModelInventory;
use \Dashboard\Toolbox\JsonValidator;

class ControllerInventory {

	/**
	 *  GET /api/inventory/items/[i:id]
	 */
	public function get_inventory_item( $request ) : array {
		$inventory_controller = new ModelInventory();
		$item = $inventory_controller->get_item( $request->id );

		if ( null === $item ) {
			return array(
				'code' => 404,
				'errors' => array(
					'Inventory item was not found.'
				)
			);
		}

		return array(
			'code' => 200,
			'content' => array(
				'item_id' => $item->get_id(),
				'name' => $item->get_name(),
				'amount' => $item->get_amount(),
				'low_stock_amount' => $item->get_low_stock_amount(),
				'description' => $item->get_description(),
				'room_id' => $item->get_room()->get_id(),
				'unit_id' => $item->get_unit()->get_id()
			)
		);
	}

	/**
	 *  POST /api/inventory/items
	 */
	public function add_inventory_item( $request ) : array {
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
			return array(
				'code' => 400,
				'errors' => $errors
			);
		}

		$inventory_controller = new ModelInventory();
		$valid_rooms = $inventory_controller->get_inventory_rooms();
		$valid_units = $inventory_controller->get_inventory_units();

		if ( !array_key_exists( $new_item['room_id'], $valid_rooms ) ) {
			return array(
				'code' => 400,
				'errors' => array(
					'Invalid room option chosen.'
				)
			);
		}

		if ( !array_key_exists( $new_item['unit_id'], $valid_units ) ) {
			return array(
				'code' => 400,
				'errors' => array(
					'Invalid unit option chosen.'
				)
			);
		}

		$item = $inventory_controller->add_item( $new_item['name'], $new_item['amount'], $new_item['low_stock_amount'], $new_item['description'], $new_item['room_id'], $new_item['unit_id'] );

		return array(
			'code' => 201,
			'content' => array(
				'item_id' => $item->get_id(),
				'name' => $item->get_name(),
				'amount' => $item->get_amount(),
				'low_stock_amount' => $item->get_low_stock_amount(),
				'description' => $item->get_description(),
				'room_id' => $item->get_room()->get_id(),
				'unit_id' => $item->get_unit()->get_id()
			)
		);
	}

	/**
	 * DELETE /api/inventory/items/[i:id]
	 */
	public function delete_inventory_item( $request ) : array {
		$inventory_controller = new ModelInventory();
		$item = $inventory_controller->get_item( $request->id );

		if ( false === $item ) {
			return array(
				'code' => 404,
				'errors' => array(
					'Inventory item was not found.'
				)
			);
		}

		$inventory_controller->delete_item( $request->id );

		return array(
			'code' => 200
		);
	}

	/**
	 * GET /api/inventory/rooms
	 */
	public function get_inventory_rooms() {
		$inventory_controller = new ModelInventory();
		$rooms = $inventory_controller->get_inventory_rooms();

		$response_data = array();
		foreach ( $rooms as $room ) {
			$response_data[] = array(
				'room_id' => $room->get_id(),
				'name' => $room->get_name()
			);
		}
		return array(
			'code' => 200,
			'content' => $response_data
		);
	}

		/**
	 * GET /api/inventory/units
	 */
	public function get_inventory_units() {
		$inventory_controller = new ModelInventory();
		$units = $inventory_controller->get_inventory_units();

		$response_data = array();
		foreach ( $units as $room ) {
			$response_data[] = array(
				'unit_id' => $room->get_id(),
				'abbreviation' => $room->get_abbreviation()
			);
		}
		return array(
			'code' => 200,
			'content' => $response_data
		);
	}

}
