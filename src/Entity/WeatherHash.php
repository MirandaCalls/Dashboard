<?php

namespace Dashboard\Entity;

/**
 * @Entity @Table( name="net_weather_hash" )
 */
class WeatherHash {

     /**
      * @Id @Column( type="integer" ) @GeneratedValue
      * @var int
      */
     protected $id;

     /**
      * @Column( type="text" )
      */
     protected $hash;

     /**
      * @Column( type="integer" )
      */
     protected $expires_ts;

     public function __construct( $content, $ts ) {
          $this->hash = hash( "md5", $content );
          $this->expires_ts = $ts;
     }

     public function set_hash( $content ) {
          $this->hash = hash( "md5", $content );
     }

     public function get_hash() {
          return $this->hash;
     }

     public function set_expires_ts( $ts ) {
          $this->expires_ts = (int) $ts;
     }

     public function get_expires_ts() {
          return $this->expires_ts;
     }
}
