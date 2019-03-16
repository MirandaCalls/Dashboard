<?php

use Dashboard\View\ViewHome;

$klein->respond( 'GET', '/', function( $request ) {
	$view = new ViewHome();
	return $view->generate_html_for_page();
});