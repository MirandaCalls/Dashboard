<?php

namespace Dashboard\Model;

use Dashboard\Entity\InventoryItem;
use Dashboard\Entity\InventoryRoom;

class ModelInventory {

	private $entity_manager;

	public function __construct() {
		$this->entity_manager = DatabaseInterface::get_instance();
	}

	public function get_items() {
		$dql = 'SELECT i FROM \Dashboard\Entity\InventoryItem i ORDER BY i.name ASC';

		$query = $this->entity_manager->createQuery( $dql );

		return $query->getResult();
	}

	public function get_item( $item_id ) {
		$dql = 'SELECT i FROM \Dashboard\Entity\InventoryItem i WHERE i.id = ?1';

		$query = $this->entity_manager->createQuery( $dql );
		$query->setParameter( 1, $item_id );
		$result = $query->getResult();

		if ( 0 == count( $result ) ) {
			return false;
		}

		return $result[0];
	}

	public function add_item( $name, $amount, $low_amount, $description, $room_id ) {
		$room = $this->get_inventory_room( $room_id );

		$item = new InventoryItem();
		$item->set_name( $name );
		$item->set_amount( $amount );
		$item->set_low_stock_amount( $low_amount );
		$item->set_description( $description );
		$item->set_room( $room );

		$this->entity_manager->persist( $item );
		$this->entity_manager->flush();
	}

	public function edit_item( $item_id, $name, $amount, $low_amount, $description, $room_id ) : string {
		$item = $this->get_item( $item_id );
		if ( false === $item ) {
			return 'Invalid item selection.';
		}

		$room = $this->get_inventory_room( $room_id );
		if ( false === $room ) {
			return 'Invalid room selection.';
		}

		$item->set_name( $name );
		$item->set_amount( $amount );
		$item->set_low_stock_amount( $low_amount );
		$item->set_description( $description );
		$item->set_room( $room );

		$this->entity_manager->flush();

		return '';
	}

	public function delete_item( $item_id ) {
		$item = $this->get_item( $item_id );
		$this->entity_manager->remove( $item );
		$this->entity_manager->flush();
	}

	public function get_inventory_rooms() {
		$repository = $this->entity_manager->getRepository( 'Dashboard\Entity\InventoryRoom' );
		$result = $repository->findAll();

		$rooms = [];
		foreach ( $result as $row ) {
			$rooms[ $row->get_id() ] = $row;
		}
		return $rooms;
	}

	public function get_inventory_room( $room_id ) {
		$dql = 'SELECT r FROM \Dashboard\Entity\InventoryRoom r WHERE r.id = ?1';

		$query = $this->entity_manager->createQuery( $dql );
		$query->setParameter( 1, $room_id );
		$result = $query->getResult();

		if ( 0 == count( $result ) ) {
			return false;
		}

		return $result[0];
	}

}
