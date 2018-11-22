<?php

namespace Dashboard\Controller;

use \Dashboard\Model\ModelConfig;
use \Dashboard\Toolbox\JsonValidator;

class ControllerConfiguration {

     public function save_configuration( $entity_manager, $request ) {
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
            return array(
              'code' => 400,
              'errors' => $errors
            );
          }

          $model = new ModelConfig( $entity_manager );
          $model->update_config( $valid_data['config_key'], $valid_data['config_data'] );

          return array(
               'code' => 200
          );
     }
}
