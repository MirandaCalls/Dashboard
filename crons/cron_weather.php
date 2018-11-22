#!/usr/bin/php
<?php

require_once __DIR__ . '/../bootstrap.php';

use Dashboard\Model\ModelWeather;
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

$darksky_data = json_decode( $darksky_json, true );

$webhook_url = 'https://discordapp.com/api/webhooks/499353158011584523/fTFnpqoRUl_87DQs4F_tYAMxjouJoOFQOD14CPyvNM5fKGjvkOcB2yYahxh5U9YIUNqj';
$messenger = new Messenger( $webhook_url, 'Dashboard' );

if ( array_key_exists( 'alerts', $darksky_data ) ) {
     $model = new ModelWeather( $entity_manager );

     foreach ( $darksky_data['alerts'] as $alert ) {
          $expires_time = date( 'g:ia \o\n Y/m/d', $alert['expires'] );
          $alert_message = '**Expires: ' . $expires_time . '**' . PHP_EOL . $alert['description'];

          $hash = new WeatherHash( $alert_message, $alert['expires'] );
          if ( false === $model->hash_exists( $hash->get_hash() ) ) {
               $model->save_new_hash( $hash );
               $messenger->post_embed( $alert['title'], $alert['uri'], '14177041', $alert_message );
          }
     }
}
