<?php

namespace Dashboard\View;

class ViewWeather extends ViewBase {

     const DAYS_OF_WEEK = array(
          1 => 'Monday',
          2 => 'Tuesday',
          3 => 'Wednesday',
          4 => 'Thursday',
          5 => 'Friday',
          6 => 'Saturday',
          7 => 'Sunday'
     );

     private $_darksky_data;

     public function __construct( $darksky_data ) {
          $this->_page_title = 'Weather';
          $this->_request_uri = '/weather';

          $this->_scripts[] = 'weather.js';
          $this->_stylesheets[] = 'weather.css';
          $this->_darksky_data = $darksky_data;
     }

     protected function _build_page_content() {
          $last_updated_time = date( 'g:ia', $this->_darksky_data['currently']['time'] );

          return '
               <h5>Weather Forcasts</h5>
               <div class="divider"></div>
               <div class="section">
                    <div class="chip">
                         Updated ' . $last_updated_time . '
                         <i class="close material-icons">check</i>
                    </div>
               </div>
               <div class="row">
                    <div class="col s12 m4">
                         <div class="card">
                              ' . $this->build_current_data() . '
                         </div>
                         <div class="card">
                              ' . $this->_build_hourly_data() . '
                         </div>
                    </div>
                    <div class="col m8">
                         <div class="card">
                              ' . $this->_build_weekly_data() . '
                         </div>
                         <div class="card">
                              ' . $this->_build_radar() . '
                         </div>
                    </div>
               </div>
          ';
     }

     public function build_current_data() {
          $icon_file = $this->_get_icon_file( $this->_darksky_data['currently']['icon'] );
          $current_temp = round( $this->_darksky_data['currently']['temperature'] ) . '˚';
          $feels_like_temp = round( $this->_darksky_data['currently']['apparentTemperature'] );
          $descr = $this->_darksky_data['currently']['summary'];

          return '
               <div class="card-content">
                    <span class="card-title">Right Now</span>
                    <div class="now-temp-container">
                         <img class="now-icon" src="' . $icon_file . '"/>
                         <h4>' . $current_temp . '</h4>
                    </div>
                    <p>Feels like ' . $feels_like_temp . '˚</p>
                    <p>' . $descr . ' in Woodbury, MN</p>
               </div>
          ';
     }

     private function _build_hourly_data() {
          $card_content = '
               <div class="card-content">
                    <span class="card-title">Next 12 Hours</span>
               </div>
               <ul class="collection">
          ';

          foreach ( $this->_darksky_data['hourly']['data'] as $i => $hour ) {
               if ( $i > 11 ) {
                    break;
               }

               $hour_str = date( 'g:i a', $hour['time'] );
               $icon_file = $this->_get_icon_file( $hour['icon'] );
               $temp_str = round( $hour['temperature'] ) . '˚';
               $card_content .= '
                    <li class="collection-item">
                         <img class="hourly-icon" src="' . $icon_file . '"/>
                         <span>' . $hour_str . '</span>
                         <span class="secondary-content">' . $temp_str . '</span>
                    </li>
               ';
          }

          $card_content .= '
               </ul>
          ';

          return $card_content;
     }

     private function _build_weekly_data() {
          $weekly_summary = $this->_darksky_data['daily']['summary'];
          $card_content = '
               <div class="card-content">
                    <span class="card-title">Weekly</span>
                    <p>' . $weekly_summary . '</p>
               </div>
               <ul class="collapsible z-depth-0">
          ';

          $day_of_week = date( 'N', time() );
          $first = $this->_darksky_data['daily']['data'][0]['time'];
          foreach ( $this->_darksky_data['daily']['data'] as $day ) {
               if ( $day_of_week > 7 ) {
                    $day_of_week = 1;
               }
               $day_name = $first === $day['time'] ? 'Today' : self::DAYS_OF_WEEK[ $day_of_week ];
               $low_temp = round( $day['temperatureLow'] );
               $high_temp = round( $day['temperatureHigh'] );
               $summary = $day['summary'];
               $icon_file = $this->_get_icon_file( $day['icon'] );
               $sunrise_time = date( 'g:i a', $day['sunriseTime'] );
               $sunset_time = date( 'g:i a', $day['sunsetTime'] );
               $precipitation_type = array_key_exists( 'precipType', $day ) ? '(' . $day['precipType'] . ')' : '';
               $precipication = ( $day['precipProbability'] * 100 ) . '% ' . $precipitation_type;
               $humidity = ( $day['humidity'] * 100 ) . '%';
               $card_content .= '
                    <li class="collection-item">
                         <div class="collapsible-header">
                              <div class="forecast-icon-column">
                                   <img class="forecast-icon" src="' . $icon_file . '"/>
                              </div>
                              <div class="forecast-summary-column">
                                   <span class="secondary-content right-align">' . $low_temp . '˚ - ' . $high_temp . '˚</span>
                                   <span>' . $day_name . '</span>
                                   <br>
                                   <span>' . $summary . '</span>
                              </div>
                         </div>
                         <div class="collapsible-body card-content">
                              <p>Sunrise: ' . $sunrise_time . '</p>
                              <p>Sunset: ' . $sunset_time . '</p>
                              <p>Precipitation: ' . $precipication . '</p>
                              <p>Humidity: ' . $humidity . '</p>
                         </div>
                    </li>
               ';
               $day_of_week++;
          }

          $card_content .= '
               </ul>
          ';

          return $card_content;
     }

     private function _build_radar() {
          return '
               <div class="card-content">
                    <span class="card-title">Precipitation Radar</span>
               </div>
               <div id="weather_map">
                    <script src="https://darksky.net/map-embed/@radar,44.9422,-92.9494,8.js?embed=true&timeControl=true&fieldControl=false&defaultField=radar"></script>
               </div>
          ';
     }

     private function _get_icon_file( $icon_name ) {
          switch ( $icon_name ) {
               case 'cloudy':
               case 'partly-cloudy-day':
               case 'partly-cloudy-night':
                    return 'img/weather/cloudy.png';
               case 'rain':
                    return 'img/weather/rainy.png';
               case 'wind':
                    return 'img/weather/windy.png';
               case 'snow':
                    return 'img/weather/snowy.png';
               case 'sleet':
                    return 'img/weather/sleet.png';
               case 'clear-night':
                    return 'img/weather/night-clear.png';
               default:
                    return 'img/weather/sunny.png';
          }
     }
}
