<?php

class categorie extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getCategorieInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM categorie WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords($id_categoria_tipologia=false) {

          $end = "";
          if($id_categoria_tipologia!==false && $id_categoria_tipologia>0) {
               $end = " AND t0.id_categoria_tipologia='$id_categoria_tipologia'";
          }

          $select_1 = " (SELECT COUNT(*) FROM prodotti t1 WHERE t1.id_buyer=t0.id_buyer AND t1.id_categoria=t0.id_categoria AND t1.sys_attivo='1') ";
          $select_2 = " (SELECT COUNT(*) FROM servizi t2 WHERE t2.id_buyer=t0.id_buyer AND t2.id_categoria=t0.id_categoria AND t2.sys_attivo='1') ";

          $sql = " SELECT $select_1 + $select_2 AS cnt, t0.*, t1.nome AS tipologia
          FROM categorie t0
          JOIN categorie_tipologie t1 USING (id_categoria_tipologia)
          WHERE t0.sys_attivo='1'
          AND t0.id_buyer='$this->id_buyer'
          $end
          ";

          $this->db->query($sql);

          return $this->db->get_objects_array();
     }

     public function getRecord($id_categoria) {

          $select_1 = " (SELECT COUNT(*) FROM prodotti t1 WHERE t1.id_buyer=t0.id_buyer AND t1.id_categoria=t0.id_categoria AND t1.sys_attivo='1') ";
          $select_2 = " (SELECT COUNT(*) FROM servizi t2 WHERE t2.id_buyer=t0.id_buyer AND t2.id_categoria=t0.id_categoria AND t2.sys_attivo='1') ";

          $sql = " SELECT $select_1 + $select_2 AS cnt, t0.*, t00.nome AS tipologia
          FROM categorie t0
          JOIN categorie_tipologie t00 USING (id_categoria_tipologia)
          WHERE t0.sys_attivo='1' AND t0.id_categoria='$id_categoria'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }





     public function saveRecord($valori) {

          $sql = " INSERT INTO categorie (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_categoria = $this->db->get_last_insert_id();

          $operazione = $this->updateCampi($valori,$id_categoria);
          if($operazione===false) {return false;}

          return $id_categoria;
     }


     public function updateRecord($valori) {

          $id_categoria = $valori->id_categoria;

          $operazione = $this->updateCampi($valori,$id_categoria);
          if($operazione===false) {return false;}

          return true;
     }


     function updateCampi($valori,$id_categoria) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('categorie',$col)>0 ) {

                    $sql1 = " UPDATE categorie SET $col='$val' WHERE id_categoria='$id_categoria' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE categorie SET data_mod='$this->dateNow' WHERE id_categoria='$id_categoria' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }



     public function deleteRecord($id_categoria) {

          $sql1 = " UPDATE categorie SET sys_attivo='0' WHERE id_categoria='$id_categoria' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }


}

?>
