<?php

namespace Dashboard\Model;

class DatabaseInterface {

     private static $_instance = null;

     public static function get_instance() {
          return self::$_instance;
     }

     public static function set_instance( $entity_manager ) {
          self::$_instance = $entity_manager;
     }
}
