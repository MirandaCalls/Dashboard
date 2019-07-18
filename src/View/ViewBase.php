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
                              $( document ).ready(function(){
                                   var elems = document.querySelectorAll( ".sidenav" );
                                   var options = {};
                                   var instances = M.Sidenav.init( elems, options );
                                   $( "#dropdown_trigger_config" ).dropdown({
                                        coverTrigger: false,
                                        constrainWidth: false
                                   });
                                   $( "#btn_logout" ).click(function(){
                                        $( "#form_logout" ).submit();
                                   });
                              });
                         </script>
                         <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                         <meta name="mobile-web-app-capable" content="yes">
                         <link rel="apple-touch-icon" href="img/icon.png">
                         <meta name="apple-mobile-web-app-title" content="Dashboard">
                         <meta name="apple-mobile-web-app-capable" content="yes">
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
          if ( !array_key_exists( 'authenticated', $_SESSION ) ) {
               return '
                    <header>
                         <div class="navbar-fixed">
                              <nav class="blue-grey darken-1">
                                   <div class="nav-wrapper container">
                                        <span class="brand-logo">Dashboard</span>
                                   </div>
                              </nav>
                         </div>
                    </header>
               ';
          }

          return '
               <header>
                    <div class="navbar-fixed">
                         <nav class="blue-grey darken-1">
                              <div class="nav-wrapper container">
                                   <span class="brand-logo">Dashboard</span>
                                   <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                   <ul class="right hide-on-med-and-down">
                                        <li class="' . ( '/' == $this->_request_uri ? 'active' : '' ) . '"><a href="/">Home</a></li>
                                        <li class="' . ( '/inventory' == $this->_request_uri ? 'active' : '' ) . '"><a href="/inventory">Inventory</a></li>
                                        <li class="' . ( '/weather' == $this->_request_uri ? 'active' : '' ) . '"><a href="/weather">Weather</a></li>
                                        <li class="' . ( '/speedlogs' == $this->_request_uri ? 'active' : '' ) . '"><a href="/speedlogs">Speed Tests</a></li>
                                        <li><a id="dropdown_trigger_config" class="dropdown-trigger" href="#" data-target="dropdown_config">' . $GLOBALS['username'] . '<i class="material-icons right">account_circle</i></a></li>
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
                    <ul id="dropdown_config" class="dropdown-content">
                         <li><a href="/configuration"><i class="material-icons">settings</i>Configuration</a></li>
                         <li class="divider"></li>
                         <li><a id="btn_logout">Logout</a></li>
                    </ul>
                    <form id="form_logout" action="/logout" method="POST"></form>
               </header>
          ';
     }

     abstract protected function _build_page_content();

     private function _build_footer() {
          return '
                              </div>
                         </main>
                         <footer class="page-footer blue-grey darken-4">
                              <div class="footer-copyright">
                                   <div class="container">
                                        © ' . date( 'o' ) . ' Maidens Computing
                                   </div>
                              </div>
                         </footer>
                    </body>
               </html>
          ';
     }
}
