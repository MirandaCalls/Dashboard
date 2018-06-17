<?php

namespace Dashboard\Controller;

use Dashboard\Entity\InventoryItem;
use Dashboard\Entity\InventoryRoom;

class Controller_Inventory {

	private $entity_manager;

	public function __construct( $entity_manager ) {
		$this->entity_manager = $entity_manager;
	}

	public function get_items() {
		$repository = $this->entity_manager->getRepository( 'Dashboard\Entity\InventoryItem' );
		return $repository->findAll();
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

	public function add_item( $name, $amount, $low_amount, $description, $room_id ) : string {
		$room = $this->get_inventory_room( $room_id );
		if ( false === $room ) {
			return 'Invalid room selection.';
		}

		$item = new InventoryItem();
		$item->set_name( $name );
		$item->set_amount( $amount );
		$item->set_low_stock_amount( $low_amount );
		$item->set_description( $description );
		$item->set_room( $room );

		$this->entity_manager->persist( $item );
		$this->entity_manager->flush();

		return '';
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

	public function get_inventory_rooms() {
		$repository = $this->entity_manager->getRepository( 'Dashboard\Entity\InventoryRoom' );
		return $repository->findAll();
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
