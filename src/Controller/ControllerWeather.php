<?php

use Dashboard\View\ViewWeather;

$klein->respond( 'GET', '/weather', function( $request ) {
	$forcast_data = json_decode( file_get_contents( __DIR__ . '/../../darksky.json' ), true );
	$view = new ViewWeather( $forcast_data );
	return $view->generate_html_for_page();
});