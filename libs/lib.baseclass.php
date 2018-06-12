<?php


class baseclass {

     // LINK AL DATABASE
     protected $db = NULL;


     function __construct() {

          $this->db = db::singleton();

          $this->dati_utente = utility::dati_utente();
          if(isset($this->dati_utente->id_buyer)) {
               $this->id_buyer = $this->dati_utente->id_buyer;
          }


          $this->dateNow = date('Y-m-d H:i:s');
          $this->today = date('Y-m-d');
          $this->today_ui = date('d/m/Y');
          $this->now = date('H:i');
          $this->now_s = date('H:i:s');
     }



     public function checkColumunExists($tabella,$colonna,$database=false) {

          if ($database===false) {$database=$this->db->get_db_login();}

          $sql = " SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.COLUMNS
          WHERE TABLE_SCHEMA='".$database."' AND TABLE_NAME='$tabella' AND COLUMN_NAME='$colonna' ";

          $this->db->query($sql);

          $conteggio = $this->db->getrow()->cnt;

          return $conteggio;
     }



     public function getPropriaSocieta() {

          $oggetto = (object)array(
               'nome' => "Geda Distribuzione Sas",
               'indirizzo' => "Via Aniello Palumbo, 8",
               'cap' => "80019",
               'comune' => "Qualiano (NA)",
               'p_iva' => "05848581210"
          );

          return $oggetto;
     }


}

?>
