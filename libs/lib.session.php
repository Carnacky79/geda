<?php

class session {

     public static function get_HTTP_HOST() {
          return $_SERVER['HTTP_HOST'];
     }

     public static function get_REQUEST_URI() {
          return $_SERVER['REQUEST_URI'];
          //pagina php chiamata dal javascript ( es. tramite ajax )
     }

     public static function get_HTTP_REFERER() {
          return $_SERVER['HTTP_REFERER'];
          //pagina contentente il javascript che ha chimato ( es. tramite ajax ) la pagina php corrente
     }

     public static function start() {
          session_name("stocker");
          if (session_status() == PHP_SESSION_NONE) {
               return session_start();
          }
     }

     public static function getvalue($var) {
          if (isset($_SESSION[$var]))
          return $_SESSION[$var];
          else return false;
     }

     public static function setvalue($var, $valore) {
          $_SESSION[$var]=$valore;
          return $_SESSION[$var];
     }

     public static function is_set($var) {
          return isset($_SESSION[$var]);
     }


}

?>
