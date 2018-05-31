<?php

namespace Dashboard\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table( name="net_host" )
 */
class Host {
	
	/**
	 * @Id @Column( type="integer" ) @GeneratedValue
	 * @var int
	 */
	protected $id;

	/**
	 * @Column( type="integer" )
	 * @var int
	 */
	protected $server_id;
	
	/**
	 * @Column( type="string" )
	 * @var string
	 */
	protected $name;
	
	/**
	 * @Column( type="string" )
	 * @var string
	 */
	protected $location;
	
	/**
	 * @OneToMany( targetEntity="\Dashboard\Entity\SpeedLog", mappedBy="host" )
	 * @var SpeedLog[] An ArrayCollection of SpeedLog objects
	 */
	protected $speed_logs;
	
	public function __construct() {
		$this->speed_logs = new ArrayCollection();
	}
	
	public function get_id() : int {
		return $this->id;
	}
	
	public function get_server_id() : int {
		return $this->server_id;
	}

	public function set_server_id( int $server_id ) {
		$this->server_id = $server_id;
	}

	public function get_name() : string {
		return $this->name;
	}
	
	public function set_name( string $name ) {
		$this->name = $name;
	}
	
	public function get_location() : string {
		return $this->location;
	}
	
	public function set_location( string $location ) {
		$this->location = $location;
	}
	
	public function get_speed_logs() : ArrayCollection {
		return $this->speed_logs;
	}
	
	public function add_speed_log( SpeedLog $log ) {
		$this->speed_logs[] = $log;
	}
	
}