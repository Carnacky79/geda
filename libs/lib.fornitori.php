<?php

class fornitori extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getFornitoriInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM fornitori WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords() {

          $sql = " SELECT *
          FROM fornitori
          WHERE sys_attivo='1'
          AND id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }

     public function getRecord($id_fornitore) {

          $sql = " SELECT *
          FROM fornitori
          WHERE sys_attivo='1' AND id_fornitore='$id_fornitore'
          AND id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }




     public function saveRecord($valori) {

          $sql = " INSERT INTO fornitori (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_fornitore = $this->db->get_last_insert_id();

          $operazione = $this->updateCampi($valori,$id_fornitore);
          if($operazione===false) {return false;}

          return $id_fornitore;
     }

     public function updateRecord($valori) {

          $id_fornitore = $valori->id_fornitore;

          $operazione = $this->updateCampi($valori,$id_fornitore);
          if($operazione===false) {return false;}

          return true;
     }

     function updateCampi($valori,$id_fornitore) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('fornitori',$col)>0 ) {

                    $sql1 = " UPDATE fornitori SET $col='$val' WHERE id_fornitore='$id_fornitore' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE fornitori SET data_mod='$this->dateNow' WHERE id_fornitore='$id_fornitore' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_fornitore) {

          $sql1 = " UPDATE fornitori SET sys_attivo='0' WHERE id_fornitore='$id_fornitore' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }


}

?>
