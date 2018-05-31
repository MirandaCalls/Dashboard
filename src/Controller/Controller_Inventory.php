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

}