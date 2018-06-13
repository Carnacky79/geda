<?php

class giacenze extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();

     }


     public static function getGiacenzeInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     public function getRecordsByLocation($id_location) {

          $sql = " SELECT t0.id_prodotto, t0.* FROM giacenze t0 WHERE id_location='$id_location' AND sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $this->db->query($sql);

          return $this->db->get_objects_array(0,array('key' => 'id_prodotto'));
     }


     public function getRecord($id_prodotto,$id_location) {

          $sql = " SELECT t0.id_prodotto, t0.* FROM giacenze t0 WHERE id_location='$id_location' AND id_prodotto='$id_prodotto' AND sys_attivo='1' AND id_buyer='$this->id_buyer' ";
          $this->db->query($sql);

          return $this->db->getrow();
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



     // public function ripristina($tabella,$id,$type) {
     //
     //      $col_id = 'id_'.$tabella;
     //
     //      $sql = " SELECT * FROM giacenze WHERE $col_id='$id' AND id_buyer='$this->id_buyer' AND sys_attivo='1' ";
     //      $this->db->query($sql);
     //
     //      $lista_prodotti = $this->db->get_objects_array();
     //
     //      foreach ($lista_prodotti as $prodotto) {
     //
     //           if($type==1) { //devo fare l'opposto visto che devo ripristina, quindi se è in uscita, aggiungo
     //                $operazione = $this->prodotti->plusRecord($prodotto->id_prodotto,$prodotto->quantita);
     //           } else {
     //                $operazione = $this->prodotti->minusRecord($prodotto->id_prodotto,$prodotto->quantita);
     //           }
     //           if($operazione===false) {return false;}
     //      }
     //
     //
     //      $sql = " UPDATE giacenze set sys_attivo='0' WHERE $col_id='$id' AND id_buyer='$this->id_buyer' AND sys_attivo='1' ";
     //      $operazione = $this->db->query($sql);
     //      if($operazione===false) {return false;}
     //
     //      return true;
     // }



     public function addRecord($id_prodotto,$quantita,$obj_valori, $ripristino=false) {

          $prodotti = prodotti::getProdottiInstance();
          $location = location::getLocationInstance();

          if((isset($obj_valori->type) && $obj_valori->type==1) || !isset($obj_valori->type)) {

               if(!isset($obj_valori->id_location)) {
                    $giornata = false;
                    $location = $location->getRecordByCliente($obj_valori->id_cliente);
               } else {
                    $giornata = true;
                    $location = $location->getRecord($obj_valori->id_location);
               }

               if(is_object($location) && $location->id_location>0) {

                    $update = " quantita = (quantita+$quantita) ";
                    if($ripristino===true) {
                         $update = " quantita = (quantita-$quantita) ";
                    }

                    $sql = " INSERT INTO giacenze (
                         id_buyer,
                         id_location,
                         id_prodotto,
                         quantita
                    ) VALUES (
                         '$this->id_buyer',
                         '$location->id_location',
                         '$id_prodotto',
                         '$quantita'
                    )
                    ON DUPLICATE KEY UPDATE $update
                    ";
                    $operazione = $this->db->query($sql);
                    if($operazione===false) {return false;}
               }
          }

          if($giornata!==true) {
               if($ripristino===true) {

                    if($obj_valori->type==1) {
                         $operazione = $prodotti->plusRecord($id_prodotto,$quantita);
                    } else {
                         $operazione = $prodotti->minusRecord($id_prodotto,$quantita);
                    }

               } else {

                    if($obj_valori->type==0) {
                         $operazione = $prodotti->plusRecord($id_prodotto,$quantita);
                    } else {
                         $operazione = $prodotti->minusRecord($id_prodotto,$quantita);
                    }

               }
               if($operazione===false) {return false;}
          }

          return true;
     }




     public function editRecord($id_prodotto,$quantita) {

          $id_location = utility::dati_utente()->id_location;


          $sql = " INSERT INTO giacenze (
               id_buyer,
               id_location,
               id_prodotto,
               quantita
          ) VALUES (
               '$this->id_buyer',
               '$id_location',
               '$id_prodotto',
               '$quantita'
          )
          ON DUPLICATE KEY UPDATE quantita = $quantita
          ";
          $operazione = $this->db->query($sql);
          if($operazione===false) {return false;}


          return true;
     }




}

?>
