<?php

class fatture extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getFattureInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM fatture WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords() {

          $sql = " SELECT t0.*, t2.nome AS fornitore, t3.nome AS cliente, t4.id_location AS id_location
          FROM fatture t0
          LEFT JOIN fornitori t2 USING (id_buyer,id_fornitore,sys_attivo)
          LEFT JOIN clienti t3 USING (id_buyer,id_cliente,sys_attivo)
          LEFT JOIN location t4 USING (id_cliente)
          WHERE t0.sys_attivo='1'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }

     public function getRecord($id_fattura) {

          $sql = " SELECT t0.*, t2.nome AS fornitore, t3.nome AS cliente
          FROM fatture t0
          LEFT JOIN fornitori t2 USING (id_buyer,id_fornitore,sys_attivo)
          LEFT JOIN clienti t3 USING (id_buyer,id_cliente,sys_attivo)
          WHERE t0.id_fattura = '$id_fattura'
          AND t0.id_buyer='$this->id_buyer'
          ";
          // t0.sys_attivo='1' AND
          $this->db->query($sql);

          return $this->db->getrow();
     }






     public function getRecords_fornitore($id_fornitore) {

          $sql = " SELECT t0.*
          FROM fatture t0
          WHERE t0.sys_attivo='1' AND t0.id_fornitore = '$id_fornitore'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }
     public function getRecords_cliente($id_cliente) {

          $sql = " SELECT t0.*
          FROM fatture t0
          WHERE t0.sys_attivo='1' AND t0.id_cliente = '$id_cliente'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }






     public function saveRecord($valori) {

          $sql = " INSERT INTO fatture (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_fattura = $this->db->get_last_insert_id();

          if($valori->type==1) {
               $contatori = contatori::getContatoriInstance();
               if($contatori->getRecord('fattura_'.$valori->type,$valori->anno)==$valori->codice) {
                    $contatori->plusRecord('fattura_'.$valori->type,$valori->anno);
               }
          }

          $operazione = $this->updateCampi($valori,$id_fattura);
          if($operazione===false) {
              return false;
          }

          return $id_fattura;
     }


     public function updateRecord($valori) {

          $id_fattura = $valori->id_fattura;

          $operazione = $this->updateCampi($valori,$id_fattura);
          if($operazione===false) {return false;}

          return true;
     }




     public function updateCampi($valori,$id_fattura) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('fatture',$col)>0 ) {
                    if($val != '') {
                        $sql1 = " UPDATE fatture SET $col='$val' WHERE id_fattura='$id_fattura' AND id_buyer='$this->id_buyer' ";
                        if (!$this->db->query($sql1)) {
                            return false;
                        }
                    }
               }
          }

          $sql2 = " UPDATE fatture SET data_mod='$this->dateNow' WHERE id_fattura='$id_fattura' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_fattura) {

          $sql1 = " UPDATE fatture SET sys_attivo='0' WHERE id_fattura='$id_fattura' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }


     public function deleteRighe($id_fattura) {

          $sql1 = " UPDATE fatture_righe SET sys_attivo='0' WHERE id_fattura='$id_fattura' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }



     public function getRighe($id_fattura) {

          $sql = " SELECT t0.*, t2.nome AS prodotto, t3.nome AS servizio
          FROM fatture_righe t0
          LEFT JOIN prodotti t2 USING (id_buyer,id_prodotto,sys_attivo)
          LEFT JOIN servizi t3 USING (id_buyer,id_servizio,sys_attivo)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer' AND
          t0.id_fattura='$id_fattura'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }



     public function getRigheOggetto($id_fornitore=0, $id_cliente=0, $id_prodotto=0, $id_servizio=0) {

          $sql = " SELECT t0.*
          FROM fatture_righe t0
          JOIN fatture t1 USING (id_fattura)
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
          FROM fatture_righe t0
          JOIN fatture t1 USING (id_buyer,id_fattura,sys_attivo)
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


     public function saveValori($id_fattura,$obj,$obj_valori) {


          $totale_imponibile = $obj->totale_imponibile;
          $totale_iva = $obj->totale_iva;
          $totale_esente = $obj->totale_esente;
          $totale_accessorie = $obj->totale_accessorie;
          $totale_totale = $obj->totale_totale;
          $obj_righe = $obj->obj_righe;


          $sql1 = " UPDATE fatture SET
          spese_acc='$totale_accessorie',
          imponibile='$totale_imponibile',
          iva='$totale_iva',
          esente='$totale_esente',
          totale='$totale_totale'
          WHERE
          id_fattura='$id_fattura' AND
          id_buyer='$this->id_buyer'
          ";
          if ( !$this->db->query($sql1) ) { return false; }

          foreach ($obj_righe as $riga => $valori) {


               $sql = " INSERT INTO fatture_righe (
                    id_buyer,
                    id_fattura,
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
                    '$id_fattura',
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




     public function closeRecord($id_fattura) {

          $sql1 = " UPDATE fatture SET
          stato='1'
          WHERE
          id_fattura='$id_fattura' AND
          id_buyer='$this->id_buyer'
          ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }




}

?>
