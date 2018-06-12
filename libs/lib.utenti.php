<?php

class utenti extends baseclass {

     private static $instance;

     public function __construct() {

          // chiama il costruttore del genitore
          parent::__construct();

          if(isset($_REQUEST['pagina'])) {

               if($_REQUEST['pagina']==='logout') {
                    $dati_utente = (object)array();
                    session::setvalue('dati_utente', $dati_utente);

               }

               if($_REQUEST['pagina']!=='login') {

                    $login = $this->checkLogin();

                    if($login===false) {
                         header('Location: ?pagina=login');
                    }
               }
          }
     }


     public static function getUtentiInstance() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }




     public function checkLogin() {

          if(isset(utility::dati_utente()->id_utente)) {

               $dati_utente = session::getvalue('dati_utente');
               $email = $dati_utente->email;
               $password = $dati_utente->password;

               $this->db->securize($email);
               $this->db->securize($password);

               $sql = " SELECT * FROM utenti WHERE sys_attivo='1' AND email='$email' AND password='$password' ";
               $cnt = $this->db->query($sql);

               if($cnt>0) {
                    return true;
               }
          }

          return false;
     }



     public function login($valori) {

          $email = $valori->email;
          $password = $valori->password;

          $this->db->securize($email);
          $this->db->securize($password);


          $sql = " SELECT * FROM utenti WHERE sys_attivo='1' AND email='$email' AND password='$password' ";
          $cnt = $this->db->query($sql);

          if($cnt==1) {
               $row = $this->db->getrow();

               $dati_utente = (object)array();

               foreach ($row as $key => $value) {
                    $dati_utente->{$key} = $value;
               }

               $dati_utente->cognome_nome = $dati_utente->cognome.' '.$dati_utente->nome;
               $dati_utente->nome_cognome = $dati_utente->nome.' '.$dati_utente->cognome;

               session::setvalue('dati_utente', $dati_utente);

               return true;
          }

          return false;
     }


     /*
     *
     * METODI FORM CLASSICI
     *
     */


     public function getRecords() {

          $sql = " SELECT t0.*, t1.nome AS livello, t2.nome AS location
          FROM utenti t0
          JOIN livelli t1 USING (id_livello)
          LEFT JOIN location t2 USING (id_location)
          WHERE
          t0.sys_attivo='1' AND
          t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->get_objects_array();
     }


     public function getRecord($id_utente) {

          $sql = " SELECT t0.*, t1.nome AS livello, t2.nome AS location
          FROM utenti t0
          JOIN livelli t1 USING (id_livello)
          LEFT JOIN location t2 USING (id_location)
          WHERE t0.sys_attivo='1' AND t0.id_utente = '$id_utente'
          AND t0.id_buyer='$this->id_buyer'
          ";
          $this->db->query($sql);

          return $this->db->getrow();
     }


     public function saveRecord($valori) {

          $email = $valori->email;
          $password = $valori->password;
          $this->db->securize($email);
          $this->db->securize($password);

          $sql = " INSERT INTO utenti (id_buyer,email,password,data_mod) VALUES ('$this->id_buyer','$email','$password','$this->dateNow'); ";
          if ( !$this->db->query($sql) ) { return false; }
          $id_utente = $this->db->get_last_insert_id();

          $operazione = $this->updateCampi($valori,$id_utente);
          if($operazione===false) {return false;}

          return $id_utente;
     }


     public function updateRecord($valori) {

          $id_utente = $valori->id_utente;

          $operazione = $this->updateCampi($valori,$id_utente);
          if($operazione===false) {return false;}

          return true;
     }


     public function updateCampi($valori,$id_utente) {

          foreach ($valori as $col => $value) {

               $val = $this->db->securize($value);

               if ( $this->checkColumunExists('utenti',$col)>0 ) {

                    $sql1 = " UPDATE utenti SET $col='$val' WHERE id_utente='$id_utente' AND id_buyer='$this->id_buyer' ";
                    if ( !$this->db->query($sql1) ) { return false; }
               }
          }

          $sql2 = " UPDATE utenti SET data_mod='$this->dateNow' WHERE id_utente='$id_utente' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql2) ) { return false; }

          return true;
     }


     public function deleteRecord($id_utente) {

          $sql1 = " UPDATE utenti SET sys_attivo='0' WHERE id_utente='$id_utente' AND id_buyer='$this->id_buyer' ";
          if ( !$this->db->query($sql1) ) { return false; }

          return true;
     }














}

?>
