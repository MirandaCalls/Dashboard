<?php

namespace Dashboard\View;

abstract class ViewBase {

     protected $_page_title = '';

     protected $_request_uri = '';

     protected $_stylesheets = array(
          'shared.css'
     );

     protected $_scripts = array(
          'jquery-3.3.1.min.js',
          'materialize.js'
     );

     public function generate_html_for_page() {
          $html = $this->_build_header();
          $html .= $this->_build_page_content();
          $html .= $this->_build_footer();

          return $html;
     }

     private function _build_header() {
          $html = '
               <html>
                    <head>
                         <title>Dashboard - ' . $this->_page_title . '</title>
                         <link rel="shortcut icon" href="img/icon.png" />
                         <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection"/>
                         ' . $this->_build_stylesheets() . '
                         ' . $this->_build_js() . '
                         <script type="text/javascript">
                              document.addEventListener( "DOMContentLoaded", function() {
                                   var elems = document.querySelectorAll( ".sidenav" );
                                   var options = {};
                                   var instances = M.Sidenav.init( elems, options );
                              });
                         </script>
                         <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                         <meta name="mobile-web-app-capable" content="yes">
                    </head>
                    <body>
                         ' . $this->_build_navbar() . '
                         <main>
                              <div class="container">
          ';

          return $html;
     }

     private function _build_stylesheets() {
          $html = '';

          foreach ( $this->_stylesheets as $file ) {
               $html .= '<link type="text/css" rel="stylesheet" href="css/' . $file . '"/>';
          }

          return $html;
     }

     private function _build_js() {
          $html = '';

          foreach ( $this->_scripts as $file ) {
               $html .= '<script type="text/javascript" src="js/' . $file . '"></script>';
          }

          return $html;
     }

     private function _build_navbar() {
          $html = '
               <header>
                    <div class="navbar-fixed">
                         <nav class="blue-grey darken-1">
                              <div class="nav-wrapper container">
                                   <a href="/" class="brand-logo">Dashboard</a>
                                   <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                   <ul class="right hide-on-med-and-down">
                                        <li class="' . ( '/' == $this->_request_uri ? 'active' : '' ) . '"><a href="/">Home</a></li>
          						<li class="' . ( '/inventory' == $this->_request_uri ? 'active' : '' ) . '"><a href="/inventory">Inventory</a></li>
          						<li class="' . ( '/weather' == $this->_request_uri ? 'active' : '' ) . '"><a href="/weather">Weather</a></li>
          						<li class="' . ( '/speedlogs' == $this->_request_uri ? 'active' : '' ) . '"><a href="/speedlogs">Speed Tests</a></li>
          						<li class="' . ( '/configuration' == $this->_request_uri ? 'active' : '' ) . '"><a href="/configuration"><i class="material-icons">settings</i></a></li>
                                   </ul>
                              </div>
                         </nav>
                    </div>
                    <ul class="sidenav blue-grey darken-2" id="mobile-nav">
                         <li><a class="white-text" href="/"><i class="material-icons">home</i>Home</a></li>
                         <li><a class="white-text" href="/inventory"><i class="material-icons">storage</i>Inventory</a></li>
                         <li><a class="white-text" href="/weather"><i class="material-icons">cloud</i>Weather</a></li>
                         <li><a class="white-text" href="/speedlogs"><i class="material-icons">signal_wifi_4_bar</i>Speed Tests</a></li>
                         <li><a class="white-text" href="#"><i class="material-icons">settings</i>Settings</a></li>
                    </ul>
               </header>
          ';

          return $html;
     }

     abstract protected function _build_page_content();

     private function _build_footer() {
          $html = '
                              </div>
                         </main>
                         <footer class="page-footer blue-grey darken-4">
                              <div class="footer-copyright">
                                   <div class="container">
                                        © 2018 Maidens Computing
                                   </div>
                              </div>
                         </footer>
                    </body>
               </html>
          ';

          return $html;
     }
}