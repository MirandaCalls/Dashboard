<?php

namespace Dashboard\Entity;

/**
 * @Entity @Table( name="net_inventory_unit" )
 */
class InventoryUnit {

    /**
	 * @Id @Column( type="integer" ) @GeneratedValue
	 * @var int
	 */
    private $id;

    /**
	 * @Column( type="string" )
	 * @var string
	 */
    private $full_name;

    /**
	 * @Column( type="string" )
	 * @var string
	 */
    private $abbreviation;

    public function get_id() {
        return $this->id;
    }

    public function set_id( $id ) {
        $this->id = $id;
    }

    public function get_full_name() {
        return $this->full_name;
    }

    public function set_full_name( $name ) {
        $this->full_name = $name;
    }

    public function get_abbreviation() {
        return $this->abbreviation;
    }

    public function set_abbreviation( $name ) {
        $this->abbreviation = $name;
    }
}