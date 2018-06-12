<?php

class iva extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getIvaInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }



     public function getRecords() {

          $sql = " SELECT t0.id_iva, t0.* FROM iva t0 WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $this->db->query($sql);

          return $this->db->get_objects_array(0,array('key' => 'id_iva'));
     }



     public function getRecord($id_iva) {

          $sql = " SELECT t0.*
          FROM iva t0
          WHERE t0.sys_attivo='1' AND t0.id_iva = '$id_iva'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }


     public function saveRecord($valori) {

          $sql = " INSERT INTO iva (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_iva = $this->db->get_last_insert_id();

          $operazione = $this->updateCampi($valori,$id_iva);
          if($operazione===false) {return false;}

          return $id_iva;
     }


     public function updateRecord($valori) {

          $id_iva = $valori->id_iva;

          $operazione = $this->updateCampi($valori,$id_iva);
          if($operazione===false) {return false;}

          return true;
     }



     function updateCampi($valori,$id_iva) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('iva',$col)>0 ) {

                    $sql1 = " UPDATE iva SET $col='$val' WHERE id_iva='$id_iva' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE iva SET data_mod='$this->dateNow' WHERE id_iva='$id_iva' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_iva) {

          $sql1 = " UPDATE iva SET sys_attivo='0' WHERE id_iva='$id_iva' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }





}

?>
