<?php

namespace Dashboard\Entity;

/**
 * @Entity @Table( name="net_inventory_item" )
 */
class InventoryItem {

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
	 * @Column( type="integer" )
	 * @var int
	 */
	private $amount;

	/**
	 * @Column( type="integer" )
	 * @var int
	 */
	private $low_stock_amount;

	/**
	 * @Column( type="text", length=500 )
	 * @var string
	 */
	private $description;

	/**
	 * @ManyToOne( targetEntity="\Dashboard\Entity\InventoryRoom", inversedBy="items" )
	 * @var InventoryRoom
	 */
	private $room;

	/**
	 * @ManyToOne( targetEntity="\Dashboard\Entity\InventoryUnit" )
	 * @var InventoryUnit
	 */
	private $unit;

	public function get_id() : int {
		return $this->id;
	}

	public function get_name() : string {
		return $this->name;
	}

	public function set_name( string $name ) {
		$this->name = $name;
	}

	public function get_amount() : int {
		return $this->amount;
	}

	public function set_amount( int $amount ) {
		$this->amount = $amount;
	}

	public function get_low_stock_amount() : int {
		return $this->low_stock_amount;
	}

	public function set_low_stock_amount( int $amount ) {
		$this->low_stock_amount = $amount;
	}

	public function get_description() : string {
		return $this->description;
	}

	public function set_description( string $text ) {
		$this->description = $text;
	}

	public function get_room() : InventoryRoom {
		return $this->room;
	}

	public function set_room( InventoryRoom $room ) {
		$room->add_item( $this );
		$this->room = $room;
	}

	public function get_unit() : InventoryUnit {
		return $this->unit;
	}

	public function set_unit( InventoryUnit $unit ) {
		$this->unit = $unit;
	}
}
