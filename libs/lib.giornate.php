<?php

class giornate extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getGiornateInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM giornate WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords() {

          $sql = " SELECT
          t0.*,
          IFNULL ((
               SELECT SUM(totale) FROM giornate_righe t1 where t1.id_giornata=t0.id_giornata AND sys_attivo='1'
          ),0) as incassi,
          IFNULL ((
               SELECT SUM(quantita) FROM giornate_righe t2 where t2.id_giornata=t0.id_giornata AND sys_attivo='1'
          ),0) as quantita,
          (
               SELECT COUNT(*) FROM giornate_righe t3 where t3.id_giornata=t0.id_giornata AND sys_attivo='1'
          ) as numero,
          t4.nome as location
          FROM giornate t0
          LEFT JOIN location t4 USING (id_location)

          WHERE t0.sys_attivo='1'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);


          return $this->db->get_objects_array();
     }

     public function getRecord($id_giornata) {

          $sql = " SELECT t0.*
          FROM giornate t0
          WHERE t0.id_giornata = '$id_giornata'
          AND t0.id_buyer='$this->id_buyer'
          ";
          // t0.sys_attivo='1' AND
          $this->db->query($sql);

          return $this->db->getrow();
     }

     public function getC_U($id_prodotto){

          $sql = " SELECT t0.c_u
          FROM prodotti t0
          WHERE t0.id_prodotto = '$id_prodotto'
          ";

         $this->db->query($sql);

         return $this->db->getrow();

     }



     public function getDateRecords($giorno,$id_location=false) {

          if($id_location===false) {
               $id_location = $this->dati_utente->id_location;
          }

          $sql = " SELECT t0.*
          FROM giornate t0
          WHERE t0.sys_attivo='1' AND id_location='$id_location' AND t0.giorno = '$giorno'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $conteggio = $this->db->query($sql);

          if($conteggio===1) {
               $trovata = $this->db->getrow();
               return $trovata;
          }

          return false;
     }



     public function getRecords_location($id_location) {

          $sql = " SELECT t0.*
          FROM giornate t0
          WHERE t0.sys_attivo='1' AND t0.id_location = '$id_location'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }



     public function aggiungiOdierna($propria=true) {

          $valori = (object)array(
               'giorno' => date('Y-m-d')
          );

          if($propria) {
               $valori->id_location = $this->dati_utente->id_location;
          }

          $operazione = $this->saveRecord($valori);

          if($operazione===false) {return false;}

          return $operazione;
     }



     public function saveRecord($valori) {
          // ON DUPLICATE KEY UPDATE data_mod='$this->dateNow';

          $sql = " INSERT INTO giornate (id_buyer,giorno,id_location,data_mod) VALUES ('$this->id_buyer','$valori->giorno','$valori->id_location','$this->dateNow')
          ON DUPLICATE KEY UPDATE data_mod='$this->dateNow' ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_giornata = $this->db->get_last_insert_id();

          return $id_giornata;
     }


     public function updateRecord($valori) {

          $id_giornata = $valori->id_giornata;

          $operazione = $this->updateCampi($valori,$id_giornata);
          if($operazione===false) {return false;}

          return true;
     }




     public function updateCampi($valori,$id_giornata) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('giornate',$col)>0 ) {

                    $sql1 = " UPDATE giornate SET $col='$val' WHERE id_giornata='$id_giornata' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE giornate SET data_mod='$this->dateNow' WHERE id_giornata='$id_giornata' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_giornata) {

          // $sql1 = " UPDATE giornate SET sys_attivo='0' WHERE id_giornata='$id_giornata' AND id_buyer='$this->id_buyer' ";

          $sql1 = " DELETE FROM giornate WHERE id_giornata='$id_giornata' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }


     public function deleteRighe($id_giornata) {

          $sql1 = " UPDATE giornate_righe SET sys_attivo='0' WHERE id_giornata='$id_giornata' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }



     public function getRighe($id_giornata) {

          $sql = " SELECT t0.*, t2.nome AS prodotto, t3.nome AS metodo
          FROM giornate_righe t0
          LEFT JOIN prodotti t2 USING (id_buyer,id_prodotto,sys_attivo)
          LEFT JOIN metodi_pagamento t3 USING (id_buyer,id_metodo_pagamento,sys_attivo)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer' AND
          t0.id_giornata='$id_giornata'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }



     public function saveValori($id_giornata,$obj,$type) {

          $obj_righe = $obj->obj_righe;


          $sql1 = " UPDATE giornate SET
          data_mod='$this->dateNow'
          WHERE
          id_giornata='$id_giornata' AND
          id_buyer='$this->id_buyer'
          ";
          if ( !$this->db->query($sql1) ) { return false; }

          foreach ($obj_righe as $riga => $valori) {


               $sql = " INSERT INTO giornate_righe (
                    id_buyer,
                    id_giornata,
                    id_prodotto,
                    id_metodo_pagamento,
                    quantita,
                    totale,
                    data_mod
               ) VALUES (
                    '$this->id_buyer',
                    '$id_giornata',
                    '$valori->id_prodotto',
                    '$valori->id_metodo_pagamento',
                    '$valori->quantita',
                    '$valori->totale',
                    '$this->dateNow'
               )
               ";
               if ( !$this->db->query($sql) ) { return false; }
          }

          return true;
     }




}

?>
