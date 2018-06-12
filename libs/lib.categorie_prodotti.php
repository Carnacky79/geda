<?php

class categorie_prodotti extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getCategorieProdottiInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM categorie_prodotti WHERE sys_attivo='1' ";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords() {

          $select_1 = " (SELECT COUNT(*) as cnt FROM prodotti t1 WHERE t1.id_categoria_prodotto='t0.id_categoria_prodotto' AND sys_attivo='1') ";

          $sql = " SELECT t0.*, $select_1 AS cnt
          FROM categorie_prodotti t0
          WHERE t0.sys_attivo='1'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }

     public function getRecord($id_categoria_prodotto) {

          $select_1 = " (SELECT COUNT(*) as cnt FROM prodotti t1 WHERE t1.id_categoria_prodotto='t0.id_categoria_prodotto') AND sys_attivo='1' ";

          $sql = " SELECT t0.*, $select_1 AS cnt
          FROM categorie_prodotti t0
          WHERE t0.sys_attivo='1' AND t0.id_categoria_prodotto='$id_categoria_prodotto'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }





     public function saveRecord($valori) {

          $sql = " INSERT INTO categorie_prodotti (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_categoria_prodotto = $this->db->get_last_insert_id();

          $this->updateCampi($valori,$id_categoria_prodotto);

          return $id_categoria_prodotto;
     }


     public function updateRecord($valori) {

          $id_categoria_prodotto = $valori->id_categoria_prodotto;

          $this->updateCampi($valori,$id_categoria_prodotto);

          return $id_categoria_prodotto;
     }


     function updateCampi($valori,$id_categoria_prodotto) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('categorie_prodotti',$col)>0 ) {

                    $sql1 = " UPDATE categorie_prodotti SET $col='$val' WHERE id_categoria_prodotto='$id_categoria_prodotto' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE categorie_prodotti SET data_mod='$this->dateNow' WHERE id_categoria_prodotto='$id_categoria_prodotto' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }



     public function deleteRecord($id_categoria_prodotto) {

          $sql1 = " UPDATE categorie_prodotti SET sys_attivo='0' WHERE id_categoria_prodotto='$id_categoria_prodotto' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }


}

?>
