<?php

namespace Dashboard\View;

class ViewConfiguration extends ViewBase {

     private $_config_data;

     public function __construct( $config_data ) {
          $this->_page_title = 'Configuration';
          $this->_request_uri = '/configuration';

          $this->_scripts[] = 'configuration.js';
          $this->_config_data = $config_data;
     }

     protected function _build_page_content() {
          return '
               <h5>Configuration</h5>
               <div class="divider"></div>
               <div class="section">
                    <div class="row">
                         <div class="col s12">
                              <ul class="tabs">
                                   <li class="tab col s4">
                                        <a class="teal-text" href="#tab_notify">Notifications</a>
                                   </li>
                                   <li class="tab col s4"><a class="teal-text" href="#tab_weather">Weather</a></li>
                                   <li class="tab col s4"><a class="teal-text" href="#tab_system">System</a></li>
                              </ul>
                         </div>
                         <div id="tab_notify" class="col s12">' . $this->_build_notification_html() . '</div>
                         <div id="tab_weather" class="col s12">' . $this->_build_weather_html() . '</div>
                         <div id="tab_system" class="col s12">' . $this->_build_system_html() . '</div>
                    </div>
               </div>
          ';
     }

     private function _build_notification_html() {
          $config = $this->_config_data['notifications'];

          return '
               <div class="card">
                    <div class="card-content">
                         <div class="row">
                              <div class="input-field col m4">
                                   <p>Weather:</p>
                                   <p>
                                        <label>
                                             <input class="notify-input" type="checkbox" name="weather_alerts" ' . ( $config['weather_alerts'] ? 'checked' : '' ) . '/>
                                             <span>Severe Weather</span>
                                        </label>
                                   </p>
                                   <p>
                                        <label>
                                             <input class="notify-input" type="checkbox" name="weather_precip" disabled/>
                                             <span>Precipitation</span>
                                        </label>
                                   </p>
                              </div>
                              <div class="input-field col m4">
                                   <p>Inventory:</p>
                                   <p>
                                        <label>
                                             <input class="notify-input" type="checkbox" name="inventory_low_stock" disabled/>
                                             <span>Low Stock Items</span>
                                        </label>
                                   </p>
                                   <p>
                                        <label>
                                             <input class="notify-input" type="checkbox" name="inventory_reminders" disabled/>
                                             <span>Reminders</span>
                                        </label>
                                   </p>
                              </div>
                         </div>
                         <div class="divider"></div>
                         <h6>Discord - Text Notifications on Your Server Channel</h6>
                         <div class="row">
                              <div class="input-field col s12">
                                   <i class="material-icons prefix">http</i>
                                   <input id="webhook_url" class="notify-input" type="text" name="webhook_url" value="' . $config['webhook_url'] . '">
                                   <label for="webhook_url">Webhook URL</label>
                              </div>
                              <div class="input-field col s12">
                                   <i class="material-icons prefix">perm_identity</i>
                                   <input id="webhook_name" class="notify-input" type="text" name="webhook_name" value="' . $config['webhook_name'] . '">
                                   <label for="webhook_name">Display Name</label>
                              </div>
                         </div>
                         <div class="input-field s12">
                              <a class="save-config-btn waves-effect waves-light btn" data-key="notifications" data-class="notify-input"><i class="material-icons left">save</i>Save</a>
                         </div>
                    </div>
               </div>
          ';
     }

     private function _build_weather_html() {
          return '
               <div class="card">
                    <div class="card-content">
                         <p>Soon . . . </p>
                    </div>
               </div>
          ';
     }

     private function _build_system_html() {
          return '
               <div class="card">
                    <div class="card-content">
                         <p>Soon . . . </p>
                    </div>
               </div>
          ';
     }
}
