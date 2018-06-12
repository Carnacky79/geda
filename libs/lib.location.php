<?php

class location extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getLocationInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function getRecords() {

          $sql = " SELECT t0.*, t1.nome AS categoria, t2.nome as cliente
          FROM location t0
          LEFT JOIN categorie t1 USING (id_categoria)
          LEFT JOIN clienti t2 USING (id_cliente)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }


     public function getRecord($id_location) {

          $sql = " SELECT t0.*, t1.nome AS categoria
          FROM location t0
          LEFT JOIN categorie t1 USING (id_categoria)
          WHERE t0.sys_attivo='1' AND t0.id_location = '$id_location'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecordByCliente($id_cliente) {

          $sql = " SELECT t0.*, t1.nome AS categoria
          FROM location t0
          LEFT JOIN categorie t1 USING (id_categoria)
          WHERE t0.sys_attivo='1' AND t0.id_cliente = '$id_cliente'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }


     public function saveRecord($valori) {

          $sql = " INSERT INTO location (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_location = $this->db->get_last_insert_id();

          $operazione = $this->updateCampi($valori,$id_location);
          if($operazione===false) {return false;}

          return $id_location;
     }


     public function updateRecord($valori) {

          $id_location = $valori->id_location;

          $operazione = $this->updateCampi($valori,$id_location);
          if($operazione===false) {return false;}

          return true;
     }


     public function updateCampi($valori,$id_location) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('location',$col)>0 ) {

                    $sql1 = " UPDATE location SET $col='$val' WHERE id_location='$id_location' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE location SET data_mod='$this->dateNow' WHERE id_location='$id_location' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_location) {

          $sql1 = " UPDATE location SET sys_attivo='0' WHERE id_location='$id_location' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }





}

?>
