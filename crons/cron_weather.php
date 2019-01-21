#!/usr/bin/php
<?php

require_once __DIR__ . '/../bootstrap.php';

use Dashboard\Model\ModelWeather;
use Dashboard\Model\ModelConfig;
use Dashboard\Entity\WeatherHash;
use Dashboard\Toolbox\Messenger;

$dark_sky_url = 'https://api.darksky.net/forecast/16a96e807ef652b5dabb73a17abbdf8b/44.9422,-92.9494';

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $dark_sky_url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$darksky_json = curl_exec( $ch );
curl_close( $ch );

$save_path = '/home/pi/Data/darksky.json';
file_put_contents( $save_path, $darksky_json, LOCK_EX );

$config_model = new ModelConfig();
$notify_config = $config_model->get_config_with_key( 'notifications' )->get_values();

if ( $notify_config['webhook_url'] && $notify_config['webhook_name'] ) {
     $darksky_data = json_decode( $darksky_json, true );
     $webhook_url = $notify_config['webhook_url'];
     $messenger = new Messenger( $webhook_url, $notify_config['webhook_name'] );

     if ( $notify_config['weather_alerts'] && array_key_exists( 'alerts', $darksky_data ) ) {
          $weather_model = new ModelWeather( $entity_manager );

          foreach ( $darksky_data['alerts'] as $alert ) {
               $expires_time = date( 'g:ia \o\n Y/m/d', $alert['expires'] );
               $alert_message = '**Expires: ' . $expires_time . '**' . PHP_EOL . $alert['description'];
               $alert_message = str_replace( '. *', ".\n\n*", $alert_message );

               $hash = new WeatherHash( $alert_message, $alert['expires'] );
               if ( false === $weather_model->hash_exists( $hash->get_hash() ) ) {
                    $weather_model->save_new_hash( $hash );
                    $messenger->post_embed( $alert['title'], $alert['uri'], '14177041', $alert_message );
               }
          }
     }
}
