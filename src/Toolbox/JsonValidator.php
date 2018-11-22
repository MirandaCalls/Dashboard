<?php

namespace Dashboard\Toolbox;

class JsonValidator {

     private $parameters;

     public function __construct( $parameters ) {
          $this->parameters = $parameters;
     }

     public function validate_json( $json, &$validated_params ) {
          $errors = [];

          $input = json_decode( $json, true );
          if ( false === $input ) {
               return array(
                    'Invalid or malformed JSON was sent in the request body.'
               );
          }

          foreach ( $this->parameters as $parameter ) {
               $has_default = array_key_exists( 'default', $parameter );
               $has_parameter = array_key_exists( $parameter['key'], $input );
               if ( !$has_default && !$has_parameter ) {
                    $errors[] = "Missing required parameter '" . $parameter['key'] . "'.";
                    continue;
               } else if ( !$has_parameter ) {
                    $validated_params[ $key ] = $parameter['default'];
                    continue;
               }

               $message = '';
               $value = $input[ $parameter['key'] ];
               switch ( $parameter['type'] ) {
                    case 'number':
                         if ( is_numeric( $value ) ) {
                              $value = (int) $value;
                         } else {
                              $message = "'" . $parameter['key'] . "' must be a valid number.";
                         }
                         break;
                    case 'text':
                         $validate_length = array_key_exists( 'length', $parameter );
                         if ( !is_string( $value ) || ( $validate_length && strlen( $value ) > $parameter['length'] ) ) {
                              $message = "'" . $parameter['key']  . ".";
                              if ( $validate_length ) {
                                   $message .= "' must be valid text with length less than or equal to " . $parameter['length'];
                              }
                              $message .= '.';
                              break;
                         }
                         if ( !$parameter['allow_blank'] && '' === $value ) {
                              $message = "'" . $parameter['key'] . "' must not be blank.";
                         }
                         break;
               }

               if ( '' !== $message ) {
                    $errors[] = $message;
               } else {
                    $validated_params[ $parameter['key'] ] = $value;
               }
          }

          return $errors;
     }

}
