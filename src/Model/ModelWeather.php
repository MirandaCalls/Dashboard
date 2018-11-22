<?php

namespace Dashboard\Model;

use Dashboard\Entity\WeatherHash;

class ModelWeather {

     private $entity_manager;

	public function __construct( $entity_manager ) {
		$this->entity_manager = $entity_manager;
	}

     public function save_new_hash( $new_hash ) {
          $this->entity_manager->persist( $new_hash );
          $this->entity_manager->flush();
     }

     public function hash_exists( $hash ) {
          $dql = 'SELECT h FROM \Dashboard\Entity\WeatherHash h WHERE h.hash = :hash_value';

          $query = $this->entity_manager->createQuery( $dql );
          $query->setParameter( 'hash_value', $hash );
          $result = $query->getResult();

          if ( empty( $result ) ) {
               return false;
          }

          return true;
     }
}
