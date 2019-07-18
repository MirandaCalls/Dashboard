<?php

namespace Dashboard\Model;

use Dashboard\Entity\Config;

class ModelConfig extends ModelBase {

     public function get_config_with_key( $config_key ) {
          $dql = 'SELECT c FROM \Dashboard\Entity\Config c WHERE c.key = :key';

          $query = $this->entity_manager->createQuery( $dql );
		$query->setParameter( 'key', $config_key );
		$result = $query->getResult();

          if ( 0 == count( $result ) ) {
               return false;
          }

          return $result[0];
     }

     public function update_config( $key, $json ) {
          $config = $this->get_config_with_key( $key );
          $config->set_json( $json );

          $this->entity_manager->flush();
     }
}
