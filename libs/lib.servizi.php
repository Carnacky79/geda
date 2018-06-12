<?php

class servizi extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getServiziInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM servizi WHERE sys_attivo='1' AND id_buyer='$this->id_buyer'";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords() {

          $sql = " SELECT t0.*, t1.nome AS categoria, t2.nome AS fornitore, '2' AS id_categoria_tipologia, t0.id_servizio AS id_oggetto
          FROM servizi t0
          LEFT JOIN categorie t1 USING (id_buyer,id_categoria,sys_attivo)
          LEFT JOIN fornitori t2 USING (id_buyer,id_fornitore,sys_attivo)
          WHERE t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }

     public function getRecordsPropri() {

          $sql = " SELECT t0.id_servizio, t0.*, t1.nome AS categoria, '2' AS id_categoria_tipologia, t0.id_servizio AS id_oggetto
          FROM servizi t0
          LEFT JOIN categorie t1 USING (id_buyer,id_categoria,sys_attivo)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_fornitore=0 AND
          t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array(0, array('key'=>'id_fornitore'));
     }


     public function getRecord($id_servizio) {

          $sql = " SELECT t0.*, t1.nome AS categoria, t2.nome AS fornitore
          FROM servizi t0
          LEFT JOIN categorie t1 USING (id_buyer,id_categoria,sys_attivo)
          LEFT JOIN fornitori t2 USING (id_buyer,id_fornitore,sys_attivo)
          WHERE t0.sys_attivo='1' AND t0.id_servizio = '$id_servizio'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }


     public function saveRecord($valori) {

          $sql = " INSERT INTO servizi (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_servizio = $this->db->get_last_insert_id();

          $operazione = $this->updateCampi($valori,$id_servizio);
          if($operazione===false) {return false;}

          return $id_servizio;
     }


     public function updateRecord($valori) {

          $id_servizio = $valori->id_servizio;

          $operazione = $this->updateCampi($valori,$id_servizio);
          if($operazione===false) {return false;}

          return true;
     }




     function updateCampi($valori,$id_servizio) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('servizi',$col)>0 ) {

                    $sql1 = " UPDATE servizi SET $col='$val' WHERE id_servizio='$id_servizio' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE servizi SET data_mod='$this->dateNow' WHERE id_servizio='$id_servizio' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_servizio) {

          $sql1 = " UPDATE servizi SET sys_attivo='0' WHERE id_servizio='$id_servizio' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }





}

?>
