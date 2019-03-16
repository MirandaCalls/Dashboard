<?php

namespace Dashboard\View;

class ViewHome extends ViewBase {

     public function __construct() {
          $this->_page_title = 'Home';
          $this->_request_uri = '/';

          $this->_stylesheets[] = 'weather.css';
     }

     protected function _build_page_content() {
          return '
               <div class="row">
                    <div class="col s12 m4">
                         ' . $this->_build_weather_widget() . '
                    </div>
               </div>
          ';
     }

     private function _build_weather_widget() {
          $weather_view = new ViewWeather( json_decode( file_get_contents( __DIR__ . '/../../darksky.json' ), true ) );

          return '
               <div class="card">
                    ' . $weather_view->build_current_data() . '
                    <div class="card-action">
                         <a href="/weather">Find more data -></a>
                    </div>
               </div>
          ';
     }

}
