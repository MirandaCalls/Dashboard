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
	protected $id;

	/**
	 * @Column( type="string" )
	 * @var string
	 */
	protected $name;

	/**
	 * @Column( type="integer" )
	 * @var int
	 */
	protected $amount;

	/**
	 * @Column( type="integer" )
	 * @var int
	 */
	protected $low_stock_amount;

	/**
	 * @Column( type="text", length=500 )
	 * @var string
	 */
	protected $description;

	/**
	 * @ManyToOne( targetEntity="\Dashboard\Entity\InventoryRoom", inversedBy="items" )
	 * @var InventoryRoom
	 */
	protected $room;

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
		return $description;
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

}