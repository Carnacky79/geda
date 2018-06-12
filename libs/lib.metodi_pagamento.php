<?php

class metodi_pagamento extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getMetodiPagamentoInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }



     public function getRecords() {

          $sql = " SELECT t0.id_metodo_pagamento, t0.* FROM metodi_pagamento t0 WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $this->db->query($sql);

          return $this->db->get_objects_array(0,array('key' => 'id_metodo_pagamento'));
     }



     public function getRecord($id_metodo_pagamento) {

          $sql = " SELECT t0.*
          FROM metodi_pagamento t0
          WHERE t0.sys_attivo='1' AND t0.id_metodo_pagamento = '$id_metodo_pagamento'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }




}

?>
