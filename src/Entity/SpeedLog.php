<?php

namespace Dashboard\Entity;

use \DateTime;

/**
 * @Entity @Table( name="net_speed_log" )
 */
class SpeedLog {
	
	const CONN_ETHERNET_TYPE = 'Ethernet';
	
	const BITS_TO_MEGABIT = 1048576;
	
	/**
	 * @Id @Column( type="integer" ) @GeneratedValue
	 * @var int
	 */
	private $id;
	
	/**
	 * @Column( type="float" )
	 * @var float
	 */
	private $upload_speed;
	
	/**
	 * @Column( type="float" )
	 * @var float
	 */
	private $download_speed;
	
	/**
	 * @Column( type="string" )
	 * @var string
	 */
	private $connection_type;
	
	/**
	 * @ManyToOne( targetEntity="\Dashboard\Entity\Host", inversedBy="speed_logs" )
	 */
	private $host;
	
	/**
	 * @Column( type="datetime" )
	 * @var DateTime
	 */
	private $time;
	
	public function get_id() : int {
		return $this->id;
	}
	
	public function get_upload_speed( $format = false ) {
		if ( $format ) {
			return $this->format_speed( $this->upload_speed );
		}
		
		return $this->upload_speed;
	}
	
	public function set_upload_speed( float $speed ) {
		$this->upload_speed = $speed;
	}
	
	public function get_download_speed( $format = false ) {
		if ( $format ) {
			return $this->format_speed( $this->download_speed );
		}
		
		return $this->download_speed;
	}
	
	public function set_download_speed( float $speed ) {
		$this->download_speed = $speed;
	}

	private function format_speed( $speed ) {
		$mega_bit = $speed / self::BITS_TO_MEGABIT;
		return round( $mega_bit, 2 ) . ' Mbits/s';
	}

	public function get_connection_type() : string {
		return $this->connection_type;
	}
	
	public function set_connection_type( string $type ) {
		$this->connection_type = $type;
	}

	public function get_host() : Host {
		return $this->host;
	}
	
	public function set_host( Host $host ) {
		$host->add_speed_log( $this );
		$this->host = $host;
	}

	public function get_time() : DateTime {
		return $this->time;
	}
	
	public function set_time( DateTime $time ) {
		$this->time = $time;
	}

}