<?php

class clienti extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getClientiInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM clienti WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords() {

          $sql = " SELECT *
          FROM clienti
          WHERE sys_attivo='1'
          AND id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }

     public function getRecord($id_cliente) {

          $sql = " SELECT *
          FROM clienti
          WHERE sys_attivo='1' AND id_cliente='$id_cliente'
          AND id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }




     public function saveRecord($valori) {

          $sql = " INSERT INTO clienti (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_cliente = $this->db->get_last_insert_id();

          $operazione = $this->updateCampi($valori,$id_cliente);
          if($operazione===false) {return false;}

          return $id_cliente;
     }

     public function updateRecord($valori) {

          $id_cliente = $valori->id_cliente;

          $operazione = $this->updateCampi($valori,$id_cliente);
          if($operazione===false) {return false;}

          return true;
     }

     function updateCampi($valori,$id_cliente) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('clienti',$col)>0 ) {

                    $sql1 = " UPDATE clienti SET $col='$val' WHERE id_cliente='$id_cliente' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE clienti SET data_mod='$this->dateNow' WHERE id_cliente='$id_cliente' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_cliente) {

          $sql1 = " UPDATE clienti SET sys_attivo='0' WHERE id_cliente='$id_cliente' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }


}

?>
