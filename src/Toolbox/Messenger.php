<?php

namespace Dashboard\Toolbox;

class Messenger {

     private $webhook_url;
     private $username;

     public function __construct( $webhook_url, $username ) {
          $this->webhook_url = $webhook_url;
          $this->username = $username;
     }

     public function post_message( $message_content ) {
          $ch = curl_init();
          curl_setopt( $ch, CURLOPT_POST, 1 );
          curl_setopt( $ch, CURLOPT_URL, $this->webhook_url );

          $payload = json_encode( array(
               'username' => $this->username,
               'content' => $message_content
          ));
          curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );

          curl_exec( $ch );
          curl_close( $ch );
     }

     public function post_embed( $title, $url, $color, $description ) {
          $ch = curl_init();
          curl_setopt( $ch, CURLOPT_POST, 1 );
          curl_setopt( $ch, CURLOPT_URL, $this->webhook_url );

          $payload = json_encode( array(
               'username' => $this->username,
               'embeds' => array(
                    array(
                         'title' => $title,
                         'url' => $url,
                         'color' => $color,
                         'description' => $description
                    )
               )
          ) );
          curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );

          curl_exec( $ch );
          curl_close( $ch );
     }
}
