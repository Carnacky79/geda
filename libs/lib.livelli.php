<?php

class livelli extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getLivelliInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function getRecords() {

          $sql = " SELECT t0.*
          FROM livelli t0
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }


     public function getRecord($id_livello) {

          $sql = " SELECT t0.*
          FROM livelli t0
          WHERE t0.sys_attivo='1' AND t0.id_livello = '$id_livello'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }




}

?>
