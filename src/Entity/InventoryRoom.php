<?php

namespace Dashboard\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table( name="net_inventory_room" )
 */
class InventoryRoom {
	
	/**
	 * @Id @Column( type="integer" ) @GeneratedValue
	 * @var int
	 */
	private $id;

	/**
	 * @Column( type="string" )
	 * @var string
	 */
	private $name;

	/**
	 * @Column( type="text", length=500 )
	 * @var string
	 */
	private $description;

	/**
	 * @OneToMany( targetEntity="\Dashboard\Entity\InventoryItem", mappedBy="room" )
	 * @var InventoryItem[] An ArrayCollection of InventoryItem objects
	 */
	private $items;

	public function __construct() {
		$this->items = new ArrayCollection();
	}

	public function get_id() {
		return $this->id;
	}

	public function get_name() : string {
		return $this->name;
	}

	public function set_name( string $name ) {
		$this->name = $name;
	}

	public function get_description() : string {
		return $this->description;
	}

	public function set_description( string $text ) {
		$this->description = $text;
	}

	public function get_items() : ArrayCollection {
		return $this->items;
	}

	public function add_item( InventoryItem $item ) {
		$this->items[] = $item;
	}

}