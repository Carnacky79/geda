<?php

class db {
     private $username = 'root';
     private $password = 'password';
     //private $username = 'Sql1153832';
     //private $password = '6x42q63255';
     //private $host = '89.46.111.54';
	 private $host = 'localhost';
     //public $db_login = 'Sql1153832_1';
     public $db_login = 'geda';
     private $errore;
     private $link = NULL;
     private $result = array();
     private static $instance;
     private $utility;

     private function __construct() {
          $this->link = new mysqli($this->host, $this->username, $this->password, $this->db_login);
          if ($this->link->connect_error) {
               die('Connect Error (' . $this->link->connect_errno . ') ' . $this->link->connect_error);
          }
          $this->link->set_charset('utf8');
          $this->errore = FALSE;
          $this->link->autocommit(FALSE);
     }

     public static function singleton() {
          if (!isset(self::$instance)) {
               $c = __CLASS__;
               self::$instance = new $c;
          }

          return self::$instance;
     }


     function __destruct() {
          if ($this->errore)
          $this->link->rollback();
          else
          $this->link->commit();
          $this->link->close();
     }


     public function securize(&$data, $return_value_if_empty = '') {
          if (empty($data) && $data != 0) {
               $data = $return_value_if_empty;
               return $return_value_if_empty;
          }
          if (get_magic_quotes_gpc())
          $data = stripslashes($data);
          $data = $this->link->real_escape_string($data);
          return $data;
     }


     public function query($query, $result_id = 0) {

          $this->result[$result_id] = $this->link->query($query);

          if (!$this->result[$result_id]) {
               $this->errore = TRUE;
               trigger_error('La query "' . $query . '" non ha prodotto risultati. ' . $this->link->error, E_USER_ERROR);
          }

          $operazione = $this->affected_rows();
          return $operazione;
     }


     public function get_objects_array($result_id = 0, $with_key = []) {

          if (is_array($with_key) && count($with_key)>0) {
               $array = (object)array();
               while ($obj = $this->getrow($result_id)) {

                    $p_key = key($obj);

                    if ((isset($with_key['key']) && isset($obj->{$with_key['key']}))) {
                         $id = $obj->{$with_key['key']};
                         $id_p_key = $obj->{$p_key};
                    } else {
                         $id = $obj->{$p_key};
                         $id_p_key = $id;
                    }


                    if ( isset($with_key['key']) && $with_key['key']==$p_key ) {
                         if ( $id!=null && $id!='' ) {
                              $array->{$id} = $obj;
                         }
                    } else {
                         if ( $id!=null && $id!='' && $id_p_key!=null && $id_p_key!='' ) {
                              if(!isset($array->{$id})) { $array->{$id} = (object)array(); }
                              $array->{$id}->{$id_p_key} = $obj;
                         }
                    }
               }
               return $array;
          } else {
               $array = NEW ArrayObject();
               while ($obj = $this->getrow($result_id)) {
                    $array->append($obj);
               }
               return $array;
          }
     }


     public function get_last_insert_id() {
          return $this->link->insert_id;
     }


     public function affected_rows() {
          $operazione = $this->link->affected_rows;
          if ($operazione===0) { return '0.00'; }
          else if ($operazione<0) { return false; }
          else { return $operazione; }
     }


     public function getrow($result_id = 0) {
          return $this->result[$result_id]->fetch_object();
     }


     public function get_db_login() {
          return $this->db_login;
     }



}

?>
