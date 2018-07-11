<?php

class ddt extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getDdtInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM ddt WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords() {

          $sql = " SELECT t0.*, t2.nome AS fornitore, t3.nome AS cliente, t4.id_location AS id_location
          FROM ddt t0
          LEFT JOIN fornitori t2 USING (id_buyer,id_fornitore,sys_attivo)
          LEFT JOIN clienti t3 USING (id_buyer,id_cliente,sys_attivo)
          LEFT JOIN location t4 USING (id_cliente)
          WHERE t0.sys_attivo='1'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }

     public function getRecord($id_ddt) {

          $sql = " SELECT t0.*, t2.nome AS fornitore, t3.nome AS cliente
          FROM ddt t0
          LEFT JOIN fornitori t2 USING (id_buyer,id_fornitore,sys_attivo)
          LEFT JOIN clienti t3 USING (id_buyer,id_cliente,sys_attivo)
          WHERE t0.id_ddt = '$id_ddt'
          AND t0.id_buyer='$this->id_buyer'
          ";
          // t0.sys_attivo='1' AND
          $this->db->query($sql);

          return $this->db->getrow();
     }






     public function getRecords_fornitore($id_fornitore) {

          $sql = " SELECT t0.*
          FROM ddt t0
          WHERE t0.sys_attivo='1' AND t0.id_fornitore = '$id_fornitore'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }
     public function getRecords_cliente($id_cliente) {

          $sql = " SELECT t0.*
          FROM ddt t0
          WHERE t0.sys_attivo='1' AND t0.id_cliente = '$id_cliente'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }






     public function saveRecord($valori) {

          $sql = " INSERT INTO ddt (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_ddt = $this->db->get_last_insert_id();

          if($valori->type==1) {
               $contatori = contatori::getContatoriInstance();
               if($contatori->getRecord('ddt_'.$valori->type,$valori->anno)==$valori->codice) {
                    $contatori->plusRecord('ddt_'.$valori->type,$valori->anno);
               }
          }

          $operazione = $this->updateCampi($valori,$id_ddt);
          if($operazione===false) {return false;}

          return $id_ddt;
     }


     public function updateRecord($valori) {

          $id_ddt = $valori->id_ddt;

          $operazione = $this->updateCampi($valori,$id_ddt);
          if($operazione===false) {return false;}

          return true;
     }




     public function updateCampi($valori,$id_ddt) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('ddt',$col)>0 ) {
                    if($val != '') {
                        $sql1 = " UPDATE ddt SET $col='$val' WHERE id_ddt='$id_ddt' AND id_buyer='$this->id_buyer' ";
                        if (!$this->db->query($sql1)) {
                            return false;
                        }
                    }
               }
          }

          $sql2 = " UPDATE ddt SET data_mod='$this->dateNow' WHERE id_ddt='$id_ddt' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_ddt) {

          $sql1 = " UPDATE ddt SET sys_attivo='0' WHERE id_ddt='$id_ddt' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }


     public function deleteRighe($id_ddt) {

          $sql1 = " UPDATE ddt_righe SET sys_attivo='0' WHERE id_ddt='$id_ddt' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }



     public function getRighe($id_ddt) {

          $sql = " SELECT t0.*, t2.nome AS prodotto, t3.nome AS servizio
          FROM ddt_righe t0
          LEFT JOIN prodotti t2 USING (id_buyer,id_prodotto,sys_attivo)
          LEFT JOIN servizi t3 USING (id_buyer,id_servizio,sys_attivo)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer' AND
          t0.id_ddt='$id_ddt'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }



     public function getRigheOggetto($id_fornitore=0, $id_cliente=0, $id_prodotto=0, $id_servizio=0) {

          $sql = " SELECT t0.*
          FROM ddt_righe t0
          JOIN ddt t1 USING (id_ddt)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer' AND
          t0.id_prodotto='$id_prodotto' AND
          t0.id_servizio='$id_servizio' AND
          t1.id_fornitore='$id_fornitore' AND
          t1.id_cliente='$id_cliente'
          ORDER BY data_mod DESC
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }


     public function getRigheProdotto($id_prodotto,$parte) {

          if($parte=='cliente') {
               $end = " t1.id_cliente > 0 ";
          } else if($parte=='fornitore') {
               $end = " t1.id_fornitore > 0 ";
          }

          $sql = " SELECT t0.*, t1.codice, t1.data, t1.type, t2.nome AS fornitore, t3.nome AS cliente, t4.id_location AS id_location
          FROM ddt_righe t0
          JOIN ddt t1 USING (id_buyer,id_ddt,sys_attivo)
          LEFT JOIN fornitori t2 USING (id_buyer,id_fornitore,sys_attivo)
          LEFT JOIN clienti t3 USING (id_buyer,id_cliente,sys_attivo)
          LEFT JOIN location t4 USING (id_cliente)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer' AND
          t0.id_prodotto='$id_prodotto' AND
          $end
          ORDER BY data_mod DESC
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }

     public function getRigheProdottoAll($id_prodotto) {

          $obj = (object)array();
          $obj->cliente = $this->getRigheProdotto($id_prodotto,'cliente');
          $obj->fornitore = $this->getRigheProdotto($id_prodotto,'fornitore');

          return $obj;
     }


     public function saveValori($id_ddt,$obj,$obj_valori) {


          $totale_imponibile = $obj->totale_imponibile;
          $totale_iva = $obj->totale_iva;
          $totale_esente = $obj->totale_esente;
          $totale_accessorie = $obj->totale_accessorie;
          $totale_totale = $obj->totale_totale;
          $obj_righe = $obj->obj_righe;


          $sql1 = " UPDATE ddt SET
          spese_acc='$totale_accessorie',
          imponibile='$totale_imponibile',
          iva='$totale_iva',
          esente='$totale_esente',
          totale='$totale_totale'
          WHERE
          id_ddt='$id_ddt' AND
          id_buyer='$this->id_buyer'
          ";
          if ( !$this->db->query($sql1) ) { return false; }

          foreach ($obj_righe as $riga => $valori) {


               $sql = " INSERT INTO ddt_righe (
                    id_buyer,
                    id_ddt,
                    id_prodotto,
                    id_servizio,
                    quantita,
                    prezzo_unitario,
                    sconto,
                    id_iva,
                    iva,
                    totale,
                    data_mod
               ) VALUES (
                    '$this->id_buyer',
                    '$id_ddt',
                    '$valori->id_prodotto',
                    '$valori->id_servizio',
                    '$valori->quantita',
                    '$valori->prezzo_unitario',
                    '$valori->sconto',
                    '$valori->id_iva',
                    '$valori->iva',
                    '$valori->totale',
                    '$this->dateNow'
               )
               ";
               if ( !$this->db->query($sql) ) { return false; }

          }

          return true;
     }



     public function closeRecord($id_ddt) {

          $sql1 = " UPDATE ddt SET
          stato='1'
          WHERE
          id_ddt='$id_ddt' AND
          id_buyer='$this->id_buyer'
          ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }



}

?>
