<?php


class utility {

     public static function getClassiDatatable() {
          return ' withDatatable table-striped table-bordered table-hover table-condensed ';
     }

     public static function getClassiDatatable_styleOnly() {
          return ' table-striped table-bordered table-hover table-condensed ';
     }

     public static function getClassiDatatable_noStriped() {
          return ' withDatatable table-bordered table-hover table-condensed ';
     }

     public static function disconnetti() {
          header('Location: ?logout=1');
          exit(0);
     }

     public static function redirect($url = '/') {
          ob_end_clean();
          header("Location: http://" . $_SERVER['SERVER_NAME'] . $url);
          exit;
     }


     public static function toUIDate($stringa_data,$emptyIfZero=false){
          $stringa_finale='';
          $stringa_data = explode(' ',$stringa_data);
          $stringa0 = explode('-',$stringa_data[0]);
          if ( count($stringa0)>=3 ) {
               $stringa_finale .= $stringa0[2].'/'.$stringa0[1].'/'.$stringa0[0];
          } else {
               if ( $emptyIfZero!==false ) { return $emptyIfZero; } else { return false; }
          }

          if ( $stringa_finale=='00/00/0000' && $emptyIfZero!==false ) { return $emptyIfZero; }

          return $stringa_finale;
     }


     public static function mergeObjects($obj_a=array(), $obj_b=array(), $obj_c=array()) {

          $new_array = array();

          foreach ($obj_a as $key => $value) {
               $new_array[] = $value;
          }
          foreach ($obj_b as $key => $value) {
               $new_array[] = $value;
          }
          foreach ($obj_c as $key => $value) {
               $new_array[] = $value;
          }

          return $new_array;
     }

     public static function dati_utente() {
          if(session::is_set('dati_utente')) {
               return session::getvalue('dati_utente');
          }
          return (object)array();
     }


}

?>
