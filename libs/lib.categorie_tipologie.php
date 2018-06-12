<?php

class categorie_tipologie extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getCategorieTipologieInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }



     public function getRecords() {

          $sql = " SELECT * FROM categorie_tipologie WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }




}

?>
