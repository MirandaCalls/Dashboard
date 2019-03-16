<?php

namespace Dashboard\Model;

use Dashboard\Entity\User;

class ModelUser {

    private $entity_manager;

	public function __construct() {
		$this->entity_manager = DatabaseInterface::get_instance();
    }
    
    public function get_user_by_username( string $username ) : ?User {
        $dql = 'SELECT u FROM \Dashboard\Entity\User u WHERE u.username = :username';

        $query = $this->entity_manager->createQuery( $dql );
        $query->setParameter( 'username', $username );
        $result = $query->getResult();

        if ( empty( $result ) ) {
            return null;
        }

        return $result[0];
    }
}