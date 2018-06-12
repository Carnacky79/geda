<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$utenti = utenti::getUtentiInstance();

switch ($_REQUEST['action']) {


     case 'saveRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $utenti->saveRecord($valori);

     die(json_encode($operazione));
     break;

     case 'updateRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $utenti->updateRecord($valori);

     die(json_encode($operazione));
     break;

     case 'getRecord':
     if ( !isset($_REQUEST['id_utente']) ) { die(json_encode(false)); }

     $id_utente = json_decode($_REQUEST['id_utente']);

     $operazione = $utenti->getRecord($id_utente);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_utente = json_decode($_REQUEST['valori'])->id_utente;

     $operazione = $utenti->deleteRecord($id_utente);

     die(json_encode($operazione));
     break;




     case 'updateProfilo':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $utenti->updateRecord($valori);

     $dati = utility::dati_utente();
     $dati->password = $valori->password;
     session::setvalue('dati_utente',$dati);

     die(json_encode($operazione));
     break;

     case 'getProfilo':
     if ( !isset($_REQUEST['id_utente']) ) { die(json_encode(false)); }

     $id_utente = json_decode($_REQUEST['id_utente']);

     $operazione = $utenti->getRecord($id_utente);

     die(json_encode($operazione));
     break;





     default:
     die(json_encode(false));
}
