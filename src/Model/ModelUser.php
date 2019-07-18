<?php

namespace Dashboard\Model;

use Dashboard\Entity\User;

class ModelUser extends ModelBase {
    
    public function get_user_by_id( int $id ) : ?User {
        $dql = 'SELECT u FROM \Dashboard\Entity\User u WHERE u.id = :id';

        $query = $this->entity_manager->createQuery( $dql );
        $query->setParameter( 'id', $id );
        $result = $query->getResult();

        if ( empty( $result ) ) {
            return null;
        }

        return $result[0];
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