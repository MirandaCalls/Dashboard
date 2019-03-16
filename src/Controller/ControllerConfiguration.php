<?php

namespace Dashboard\Controller;

use Dashboard\View\ViewConfiguration;
use Dashboard\Model\ModelConfig;
use Dashboard\Toolbox\JsonValidator;


$klein->respond( 'GET', '/configuration', function( $request ) {
	$model = new ModelConfig();
	$config_data = array();
	$config_data['notifications'] = $model->get_config_with_key( 'notifications' )->get_values();
	$view = new ViewConfiguration( $config_data );
	return $view->generate_html_for_page();
});

$klein->respond( 'PUT', '/api/configuration', function( $request, $response ) {
     $parameters = array(
          array(
               'key' => 'config_key',
               'type' => 'text',
               'length' => '255',
               'allow_blank' => false
          ),
          array(
               'key' => 'config_data',
               'type' => 'text',
               'allow_blank' => false
          )
     );
     $validator = new JsonValidator( $parameters );

     $valid_data = [];
     $errors = $validator->validate_json( $request->body(), $valid_data );

     if ( !empty( $errors ) ) {
          $response->code( 400 );
          return json_encode( $errors );
     }

     $model = new ModelConfig();
     $model->update_config( $valid_data['config_key'], $valid_data['config_data'] );
});