<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

function carica_classi($class_name) {
     if (is_file('../../libs/lib.' . $class_name . '.php'))
     include '../../libs/lib.' . $class_name . '.php';
}
spl_autoload_register('carica_classi');

session::start();
$clienti = clienti::getClientiInstance();

switch ($_REQUEST['action']) {



     case 'saveRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $clienti->saveRecord($valori);

     die(json_encode($operazione));
     break;

     case 'updateRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $valori = json_decode($_REQUEST['valori']);

     $operazione = $clienti->updateRecord($valori);

     die(json_encode($operazione));
     break;


     case 'getRecord':
     if ( !isset($_REQUEST['id_cliente']) ) { die(json_encode(false)); }

     $id_cliente = json_decode($_REQUEST['id_cliente']);

     $operazione = $clienti->getRecord($id_cliente);

     die(json_encode($operazione));
     break;


     case 'deleteRecord':
     if ( !isset($_REQUEST['valori']) ) { die(json_encode(false)); }

     $id_cliente = json_decode($_REQUEST['valori'])->id_cliente;

     $operazione = $clienti->deleteRecord($id_cliente);

     die(json_encode($operazione));
     break;


     default:
     die(json_encode(false));
}
