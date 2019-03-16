<?php

namespace Dashboard\Controller;

use Dashboard\Model\ModelUser;

class ControllerAuthentication {

    public static function login_user( $request ) : bool {
        $username = $request->param( 'username' );
        $password = $request->param( 'password' );

        $model = new ModelUser();
        $user = $model->get_user_by_username( $username );
        if ( null === $user ) {
            return false;
        }

        if ( $user->check_password( $password ) ) {
            $_SESSION['authenticated'] = true;
            return true;
        }

        return false;
    }

    public static function logout_user() {
        session_destroy();
    }
}