<?php

class contatori extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();
     }


     public static function getContatoriInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }



     public function getRecords($type=false) {

          $sql = " SELECT * FROM contatori WHERE id_buyer='$this->id_buyer' ";

          if($type!==false) {
               $sql .= " AND nome LIKE '%$type%' ";
          }

          $this->db->query($sql);

          return $this->db->get_objects_array();
     }


     public function getRecord($nome,$anno) {

          $sql = " SELECT * FROM contatori WHERE nome='$nome' AND anno='$anno' AND id_buyer='$this->id_buyer' ";
          $trovato = $this->db->query($sql);

          if($trovato>0) {
               return $this->db->getrow()->valore;
          } else {
               return 0;
          }
     }


     public function plusRecord($nome=false, $anno=false, $id_contatore=false) {

          $sql = " UPDATE contatori SET valore=(valore+1) WHERE id_buyer='$this->id_buyer' ";

          if($anno!==false) { $sql .= " AND anno='$anno' "; }
          if($nome!==false) { $sql .= " AND nome='$nome' "; }
          if($id_contatore!==false) { $sql .= " AND id_contatore='$id_contatore' "; }

          if($this->db->query($sql)===false) {return false;}

          return true;
     }


     public function minusRecord($nome=false, $anno=false, $id_contatore=false) {

          $sql = " UPDATE contatori SET valore=(valore-1) WHERE id_buyer='$this->id_buyer' ";

          if($anno!==false) { $sql .= " AND anno='$anno' "; }
          if($nome!==false) { $sql .= " AND nome='$nome' "; }
          if($id_contatore!==false) { $sql .= " AND id_contatore='$id_contatore' "; }

          if($this->db->query($sql)===false) {return false;}

          return true;
     }




}

?>
