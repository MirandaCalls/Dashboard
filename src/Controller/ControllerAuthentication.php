<?php

use Dashboard\Model\ModelUser;

use Dashboard\View\ViewLogin;

$klein->respond(function( $request, $response ) {
    if ( in_array( $request->uri(), array( '/login' ) ) ) {
        return;
    }

	if ( !array_key_exists( 'authenticated', $_SESSION ) ) {
		$response->redirect( '/login' )->send();
    }
    
    $model = new ModelUser();
    $GLOBALS['username'] = $model->get_user_by_id( $_SESSION['user_id'] )->get_username();
});

$klein->respond( 'GET', '/login', function() {
    $view = new ViewLogin();
    return $view->generate_html_for_page();
});

$klein->respond( 'POST', '/login', function( $request, $response ) {
    $username = $request->param( 'username' );
    $password = $request->param( 'password' );

    $model = new ModelUser();
    $user = $model->get_user_by_username( $username );
    if ( null === $user || false == $user->check_password( $password ) ) {
        $view = new ViewLogin( true );
        return $view->generate_html_for_page();
    }

    $_SESSION['authenticated'] = true;
    $_SESSION['user_id'] = $user->get_id();
	$response->redirect( '/' )->send();
});

$klein->respond( 'POST', '/logout', function( $request, $response ) {
	session_destroy();
	$response->redirect( '/' );
});