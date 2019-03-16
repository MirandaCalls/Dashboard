<?php

namespace Dashboard\Entity;

/**
 * @Entity @Table( name="net_user" )
 */
class User {

    /**
	 * @Id @Column( type="integer" ) @GeneratedValue
	 * @var int
	 */
    private $id;

    /**
     * @Column( type="string", length=255 )
     */
    private $username;

    /**
     * @Column( type="string", length=255 )
     */
    private $password_hash;

    public function get_id() : int {
        return $this->id;
    }

    public function get_username() : string {
        return $this->username;
    }

    public function set_username( string $username ) : void {
        $this->username = $username;
    }

    public function check_password( string $password ) : bool {
        return password_verify( $password, $this->password_hash );
    }

    public function set_password( string $password ) : void {
        $this->password_hash = password_hash( $password, PASSWORD_BCRYPT );
    }
}