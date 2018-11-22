<?php

namespace Dashboard\Entity;

/**
 * @Entity @Table( name="net_config" )
 */
class Config {

     /**
	 * @Id @Column( type="integer" ) @GeneratedValue
	 * @var int
	 */
	protected $id;

     /**
      * @Column( type="string", unique=true )
      */
     protected $key;

     /**
      * @Column( type="text" )
      */
     protected $json;

     public function get_id() {
          return $this->id;
     }

     public function get_key() {
          return $this->key;
     }

     public function set_key( $name ) {
          $this->key = $name;
     }

     public function get_values() {
          return json_decode( $this->json, true );
     }

     public function set_json( $json ) {
          $this->json = $json;
     }
}
