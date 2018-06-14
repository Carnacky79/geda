<?php

class prodotti extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getProdottiInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function plusRecord($id_prodotto,$quantita) {

          $sql = " UPDATE prodotti SET qta_residua=qta_residua+$quantita WHERE id_prodotto='$id_prodotto' AND id_buyer='$this->id_buyer' ";
          $operazione = $this->db->query($sql);

          if($operazione===false) {return false;}

          return true;
     }

     public function minusRecord($id_prodotto,$quantita) {

          $sql = " UPDATE prodotti SET qta_residua=qta_residua-$quantita WHERE id_prodotto='$id_prodotto' AND id_buyer='$this->id_buyer' ";
          $operazione = $this->db->query($sql);

          if($operazione===false) {return false;}

          return true;
     }




     public function count_records() {

          $sql = " SELECT COUNT(*) AS cnt FROM prodotti WHERE sys_attivo='1' AND id_buyer='$this->id_buyer'";
          $cnt = $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getRecords() {

          $sql = " SELECT t0.*, t1.nome AS categoria, '1' AS id_categoria_tipologia, t0.id_prodotto AS id_oggetto
          FROM prodotti t0
          LEFT JOIN categorie t1 USING (id_buyer,id_categoria,sys_attivo)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }



     public function getRecordsByCategoria($id_categoria) {

          $sql = " SELECT t0.*, t1.nome AS categoria, '1' AS id_categoria_tipologia, t0.id_prodotto AS id_oggetto
          FROM prodotti t0
          LEFT JOIN categorie t1 USING (id_buyer,id_categoria,sys_attivo)
          WHERE
          t0.id_categoria='$id_categoria' AND
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }




     public function getFornitoriAssociati($id_prodotto) {

          $sql = " SELECT t0.*, t1.nome
          FROM prodotti_fornitori t0
          LEFT JOIN fornitori t1 USING (id_fornitore)
          WHERE
          t1.sys_attivo='1'
          AND t0.id_prodotto='$id_prodotto'
          ";

          $this->db->query($sql);

          return $this->db->get_objects_array();
     }


     public function getFornitoriAssociatiAll() {

          $sql = " SELECT t0.id_prodotto, t0.*, t1.nome
          FROM prodotti_fornitori t0
          LEFT JOIN fornitori t1 USING (id_fornitore)
          WHERE
          t1.sys_attivo='1'
          ";

          $this->db->query($sql);

          return $this->db->get_objects_array(0,array('key' => 'id_fornitore'));
     }



     public function getRecord($id_prodotto) {

          $sql = " SELECT t0.*, t1.nome AS categoria
          FROM prodotti t0
          LEFT JOIN categorie t1 USING (id_buyer,id_categoria,sys_attivo)
          WHERE t0.sys_attivo='1' AND t0.id_prodotto = '$id_prodotto'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }


     public function getFile($id_prodotto) {

          $target_dir = "../../uploads/prodotti/".$this->id_buyer."/".$id_prodotto."/";
          mkdir( $target_dir, 0777, true );

          $obj = array();

          $da_get = glob($target_dir.'*');
          foreach($da_get as $get){
               if(is_file($get)) {
                    $obj[] = (object)array('name' => basename($get), 'file' => $get, "size" => 0,"type" => "");
               }
          }

          return (object)array('cnt' => count((array)$obj), 'files' => $obj);
     }


     public function deleteFile($file) {

          if(is_file($file)) {
               unlink($file);
          }
          return true;
     }



     public function saveFile($id_prodotto,$file) {

          $target_dir = "../../uploads/prodotti/".$this->id_buyer."/".$id_prodotto."/";
          mkdir( $target_dir, 0777, true );

          $da_canc = glob($target_dir.'*');
          foreach($da_canc as $canc){
               if(is_file($canc)) {
                    unlink($canc);
               }
          }

          $target_file = $target_dir . basename($file["image"]["name"]);

          $spostamento = move_uploaded_file($file["image"]["tmp_name"], $target_file);

          //die(var_dump($target_file));

          if ($spostamento) {
               return true;
          } else {
               return false;
          }

          return false;
     }


     public function checkEsistente($valori,$id_prodotto=false) {

          $codice = $valori->codice;
          $this->db->securize($codice);

          $sql = " SELECT COUNT(*) AS cnt FROM prodotti WHERE sys_attivo='1' AND id_buyer='$this->id_buyer' AND codice='$codice' ";

          if($id_prodotto!==false) {
               $sql .= " AND id_prodotto!='$id_prodotto' ";
          }

          $this->db->query($sql);

          $cnt = $this->db->getrow()->cnt;

          if($cnt>0) {
               return false;
          }

          return true;
     }



     public function saveRecord($valori) {

          if($this->checkEsistente($valori)) {

               $sql = " INSERT INTO prodotti (id_buyer,data_mod) VALUES ('$this->id_buyer','$this->dateNow'); ";
               if ( !$this->db->query($sql) ) { return false; }
               $id_prodotto = $this->db->get_last_insert_id();

               $operazione = $this->updateCampi($valori,$id_prodotto);
               if($operazione===false) {return false;}

               return $id_prodotto;
          }

          return 'doppio';
     }


     public function updateRecord($valori) {

          $id_prodotto = $valori->id_prodotto;

          if($this->checkEsistente($valori,$id_prodotto)) {

               $operazione = $this->updateCampi($valori,$id_prodotto);
               if($operazione===false) {return false;}

               return true;

          }

          return 'doppio';
     }




     public function updateCampi($valori,$id_prodotto) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('prodotti',$col)>0 ) {

                    $sql1 = " UPDATE prodotti SET $col='$val' WHERE id_prodotto='$id_prodotto' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE prodotti SET data_mod='$this->dateNow' WHERE id_prodotto='$id_prodotto' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_prodotto) {

          $sql1 = " UPDATE prodotti SET sys_attivo='0' WHERE id_prodotto='$id_prodotto' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }




     public function updateFornitoriAssociati($id_prodotto,$fornitori_associati) {

          $sql1 = " DELETE FROM prodotti_fornitori WHERE id_prodotto='$id_prodotto' ";
          if ( !$this->db->query($sql1) ) { return false; }

          foreach ($fornitori_associati as $id_fornitore => $c_u) {

               $sql2 = " INSERT INTO prodotti_fornitori SET
               id_prodotto = '$id_prodotto',
               id_fornitore = '$id_fornitore',
               c_u = '$c_u'
               ";
               if ( !$this->db->query($sql2) ) { return false; }
          }


          return true;
     }


    public function getRecordByLocation($id_prodotto,$id_location){
        $sql = " SELECT t0.*, t1.nome AS categoria, t2.quantita
          FROM prodotti t0
          LEFT JOIN categorie t1 USING (id_buyer,id_categoria,sys_attivo)
          JOIN giacenze t2 USING (id_prodotto)
          WHERE t0.sys_attivo='1' AND t0.id_prodotto = '$id_prodotto' AND t2.id_location = '$id_location'
          AND t0.id_buyer='$this->id_buyer'
          ";
        $this->db->query($sql);

        return $this->db->getrow();
    }


}

?>
