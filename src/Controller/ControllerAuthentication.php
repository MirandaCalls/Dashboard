<?php

use Dashboard\Model\ModelUser;

use Dashboard\View\ViewLogin;

$klein->respond( 'POST', '/login', function( $request, $response ) {
    $username = $request->param( 'username' );
    $password = $request->param( 'password' );

    $model = new ModelUser();
    $user = $model->get_user_by_username( $username );
    if ( null === $user ) {
        return;
    }

    if ( $user->check_password( $password ) ) {
        $_SESSION['authenticated'] = true;
    }

	$response->redirect( '/' )->send();
});

$klein->respond(function( $request, $response ) {
	if ( !array_key_exists( 'authenticated', $_SESSION ) ) {
		$view = new ViewLogin();
		$response->append( $view->generate_html_for_page() );
		$response->send();
	}
});

$klein->respond( 'POST', '/logout', function( $request, $response ) {
	session_destroy();
	$response->redirect( '/' );
});